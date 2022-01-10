<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gudang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Library\UniqueCode;
use App\Models\StokProduk;
use Yajra\DataTables\Facades\DataTables;
use App\Library\Response;
use Exception;

class StokKeluarController extends Controller
{
    public function index()
    {
        $gudang = Gudang::getAllGudangActive('row');
        return view('stok-keluar.index', compact('gudang'));
    }

    public function create()
    {
        $gudang = Gudang::getAllGudangActive('row');
        return view('stok-keluar.create', compact('gudang'));
    }

    public function getData(Request $request)
    {
        $status = 200;
        $responseJson = [];

        try {
            $stokKeluar = StokProduk::getStokKeluar($request->all(), 'datatable');
            $datatables = DataTables::of($stokKeluar);
            $responseJson = $datatables->make(true)->original;
        } catch (Exception $e) {
            $status = 500;
            $responseJson = Response::error($e->getMessage());
        }
        return response()->json($responseJson, $status);
    }

    public function store(Request $request)
    {
        $status = 200;
        $responseJson = [];
        DB::beginTransaction();
        try {
            $payloads = $request->all();
            $stokProduk = [];
            $stokProduk['id_gudang'] = $payloads['id_gudang'];
            $stokProduk['tanggal'] = Carbon::createFromFormat('d/m/Y', $payloads['tanggal'])->format('Y-m-d');
            $stokProduk['catatan'] = $payloads['catatan'];
            $stokProduk['jenis'] = 'KELUAR';
            $stokProduk['kode'] = (new UniqueCode(StokProduk::class, 'kode', 'ST-K-', 4, true))->get();
            $stokProduk['created_at'] = date("Y-m-d H:i:s");
            $stokProduk['created_by'] = auth()->user()->name;
            $id_reference = DB::table('stok_produk')->insertGetId($stokProduk);
            $stokProdukDetail = [];
            foreach ($payloads['dataDetail'] as $item) {
                $detail = [];
                $detail['id_produk'] = $item['id_produk'];
                $detail['nilai'] = -1 * abs($item['qty_stok']);
                $detail['jenis'] = 'KELUAR';
                $detail['harga'] = $item['subtotal'] / $item['qty_stok'];
                $detail['sub_total'] = $item['subtotal'];
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

    public function getProduct(Request $request)
    {

        $q = $request->get('q');

      

        $product = DB::table('stok_produk_detail as spd')
        ->join('produk as p', 'spd.id_produk', '=', 'p.id_produk')
        ->selectRaw("
            spd.id_produk as id,
            sum(spd.nilai) as stok,
            sum(sub_total) / sum(nilai) as nilai_stok, 
            p.id_produk,
            p.kode_produk,
            p.nama_produk,
            p.harga_jual
        ")
        ->where('p.kode_produk', 'like', '%'.strtoupper($q).'%')
        ->orWhere('p.nama_produk', 'like', '%'.$q.'%')
        ->groupBy('spd.id_produk', 'p.id_produk', 'p.kode_produk', 'p.nama_produk', 'p.harga_jual');

        $final['incomplete_results'] = true;
        $final['total_count'] = $product->count();
        $final['items'] = $product->get();
        return response()->json($final);
    }

    public function showDetail($id)
    {
        $data = StokProduk::showDetailAllJenis($id);
        return view('stok-keluar.detail', $data);
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
}
