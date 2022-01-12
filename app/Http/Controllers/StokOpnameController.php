<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Gudang;
use Exception;
use App\Models\StokProduk;
use Yajra\DataTables\DataTables;
use App\Library\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;
use App\Library\UniqueCode;

class StokOpnameController extends Controller
{
    public function index()
    {
        $gudang = Gudang::getAllGudangActive('row');
        return view('stok-opname.index', compact('gudang'));
    }

    public function create()
    {
        $gudang = Gudang::getAllGudangActive('row');
        return view('stok-opname.create', compact('gudang'));
    }

    public function getProduct(Request $request)
    {

        $q = $request->get('q');

        $product = DB::table('produk as p')
        ->leftJoin('stok_produk_detail as spd', 'spd.id_produk', '=', 'p.id_produk')
        ->selectRaw("
            p.id_produk as id,
            IFNULL(sum(spd.nilai),0) as stok,
            IFNULL(sum(sub_total) / sum(nilai),0) as nilai_stok, 
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

    public function getData(Request $request)
    {
        $status = 200;
        $responseJson = [];

        try {
            $stokKeluar = StokProduk::getStokOpname($request->all(), 'datatable');
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
            $stokProduk['catatan'] = $payloads['catatan'];
            $stokProduk['kode'] = (new UniqueCode(StokProduk::class, 'kode', 'ST-O-', 4, true))->get();
            $stokProduk['tanggal'] = date("Y-m-d");
            $stokProduk['jenis'] = 'OPNAME';
            $stokProduk['reference'] = 'STOKOPNAME';
            $stokProduk['created_at'] = date("Y-m-d H:i:s");
            $stokProduk['created_by'] = auth()->user()->name;
            $id_reference = DB::table('stok_produk')->insertGetId($stokProduk);
            $stokProdukDetail = [];
            foreach ($payloads['dataDetail'] as $item) {
                $detail = [];
                $detail['id_produk'] = $item['id'];
                $detail['nilai'] = $item['stok_selisih'];
                $detail['jenis'] = floatval($item['stok_selisih']) < 0 ? 'KELUAR' : 'MASUK';
                $detail['sumber'] = 'stok_produk';
                $detail['id_reference'] = $id_reference;
                $detail['kode_reference'] = $stokProduk['kode'];
                $detail['harga'] = $item['nilai_stok'];
                $detail['sub_total'] = $item['nilai_stok'] * $item['stok_selisih'];
                $stokProdukDetail[] = $detail;
                
            }
            DB::table('stok_produk_detail')->insert($stokProdukDetail);
            $responseJson = Response::success('Berhasil membuat stok opname');
            
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $status = 500;
            $responseJson = Response::error($e->getMessage());
        }
        return response()->json($responseJson, $status);
    }

    private static function getSelisihSubTotal($idProduct, $newHpp)
    {
        $sql = DB::table('stok_produk_detail as spd')->where('spd.id_produk', $idProduct)
                ->selectRaw("
                    sum(spd.nilai) as nilaiAkhir, 
                    sum(spd.sub_total) as subTotalAkhir,
                    sum(spd.nilai * 15000) as subTotalBaru,
                    ABS(sum(spd.sub_total) - sum(spd.nilai * ".intval($newHpp).")) as selisihSubTotal
                ");
        return $sql->first();
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
        $data = StokProduk::showDetailOpname($id);
        return view('stok-opname.detail', $data);
    }

}
