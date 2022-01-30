<?php

namespace App\Http\Controllers;

use App\Library\Response;
use App\Models\Gudang;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Library\UniqueCode;
use App\Models\StokProduk;
use Yajra\DataTables\Facades\DataTables;

class StokMasukController extends Controller
{
    public function index()
    {
        $outlet = DB::table('outlet')->get();
        return view('stok-masuk.index', compact('outlet'));
    }

    public function create()
    {
        $outlet = DB::table('outlet')->get();
        return view('stok-masuk.create', compact('outlet'));
    }

    public function getData(Request $request)
    {
        $status = 200;
        $responseJson = [];

        try {
            $stokMasuk = StokProduk::getStokMasuk($request->all(), 'datatable');
            $datatables = DataTables::of($stokMasuk);
            $responseJson = $datatables->make(true)->original;
        } catch (Exception $e) {
            $status = 500;
            $responseJson = Response::error($e->getMessage());
        }
        return response()->json($responseJson, $status);
    }

    public function getDataProduct(Request $request)
    {
        $q = $request->get('q');
        $id_outlet = $request->get('id_outlet');
        $sql = DB::table('produk as p')->selectRaw('
                                                p.id_produk as id,
                                                p.id_produk,
                                                p.id_kategori,
                                                p.kode_produk, p.nama_produk,
                                                p.merk,
                                                p.harga_jual, p.diskon,
                                                p.created_at, p.updated_at,
                                                u.nama_uom,
                                                IFNULL(round(sum(nilai), 2),0) as stok,
                                                IFNULL(round(sum(sub_total) / sum(nilai),2),0) as hpp')
        ->leftJoin('uom as u', 'u.id_uom', '=', 'p.id_uom')
        ->leftJoin('stok_produk_detail as spd', 'p.id_produk', '=', 'spd.id_produk')
        ->where('p.id_outlet', $id_outlet)
        ->where('p.kelola_stok', '1')
        ->where('p.status', '1')
        ->where(function($query) use($q) {
            $query->where('p.kode_produk', 'like', '%'.strtoupper($q).'%');
            $query->orWhere('p.nama_produk', 'like', '%'.$q.'%');
        })
        ->groupBy('p.id_produk', 'p.id_kategori',
                'p.kode_produk', 'p.nama_produk',
                'p.merk', 'u.nama_uom',
                'p.harga_jual', 'p.diskon', 'p.created_at', 'p.updated_at');

        $result['incomplete_results'] = true;
        $result['total_count'] = $sql->count();
        $result['items'] = $sql->get();
        return response()->json($result);
    }

    public function store(Request $request)
    {
        $status = 200;
        $responseJson = [];
        DB::beginTransaction();
        try {
            $payloads = $request->all();
            $stokProduk = [];
            $stokProduk['id_outlet'] = $payloads['id_outlet'];
            $stokProduk['tanggal'] = Carbon::createFromFormat('d/m/Y', $payloads['tanggal'])->format('Y-m-d');
            $stokProduk['catatan'] = $payloads['catatan'];
            $stokProduk['jenis'] = 'MASUK';
            $stokProduk['reference'] = 'STOKMASUK';
            $stokProduk['kode'] = (new UniqueCode(StokProduk::class, 'kode', 'ST-M-', 9))->get();
            $stokProduk['created_at'] = date("Y-m-d H:i:s");
            $stokProduk['created_by'] = auth()->user()->name;
            $id_reference = DB::table('stok_produk')->insertGetId($stokProduk);
            $stokProdukDetail = [];
            foreach ($payloads['dataDetail'] as $item) {
                $detail = [];
                $detail['id_produk'] = $item['id_produk'];
                $detail['nilai'] = $item['qty_stok'];
                $detail['harga'] = $item['harga_beli'];
                $detail['sub_total'] = $item['subtotal'];
                $detail['jenis'] = 'MASUK';
                $detail['sumber'] = 'stok_produk';
                $detail['id_reference'] = $id_reference;
                $detail['kode_reference'] = $stokProduk['kode'];
                $stokProdukDetail[] = $detail;
            }
            DB::table('stok_produk_detail')->insert($stokProdukDetail);
            $responseJson = Response::success('Berhasil membuat stok masuk');
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $status = 500;
            $responseJson = Response::error($e->getMessage());
        }
        return response()->json($responseJson, $status);
    }

    public function cancel($id)
    {
        $status = 200;
        $responseJson = [];
        try {
            StokProduk::cancelAllJenis($id);
            $responseJson = Response::success('Berhasil membatalkan');
        } catch (Exception $e) {
            $status = 500;
            $responseJson = Response::error($e->getMessage());
        }
        return response()->json($responseJson, $status);
    }

    public function showDetail($id)
    {
        $data = StokProduk::showDetailAllJenis($id);
        return view('stok-masuk.detail', $data);
    }
}
