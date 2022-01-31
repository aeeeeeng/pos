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
        $outlet = DB::table('outlet')->get();
        return view('stok-opname.index', compact('outlet'));
    }

    public function create()
    {
        $outlet = DB::table('outlet')->get();
        return view('stok-opname.create', compact('outlet'));
    }

    public function getProduct(Request $request)
    {

        $status = 200;
        $responseJson = [];

        $id_outlet = $request->get('id_outlet');

        try {
            $product = DB::table('produk as p')
            ->leftJoin('stok_produk_detail as spd', 'spd.id_produk', '=', 'p.id_produk')
            ->leftJoin('uom as u', 'p.id_uom', '=', 'u.id_uom')
            ->selectRaw("
                p.id_produk as id,
                IFNULL(round(sum(spd.nilai), 2),0) as stok,
                IFNULL(round(sum(sub_total) / sum(nilai), 2),0) as nilai_stok,
                0 as new_nilai_stok,
                IFNULL(round(sum(spd.nilai), 2),0) as qty_stok,
                0 as stok_selisih,
                p.kode_produk,
                p.sku_produk,
                p.nama_produk,
                p.harga_jual,
                u.nama_uom
            ")
            ->where('p.id_outlet', $id_outlet)
            ->where('p.kelola_stok', '1')
            ->orderBy('p.created_at', 'desc')
            ->groupBy('spd.id_produk', 'p.id_produk', 'p.kode_produk', 'p.sku_produk', 'p.nama_produk', 'p.harga_jual', 'u.nama_uom');
            $responseJson = Response::success('OK', $product->get());
        } catch (Exception $e) {
            $status = 500;
            $responseJson = Response::error($e->getMessage());
        }
        return response()->json($responseJson, $status);
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
            $stokProduk['id_outlet'] = $payloads['id_outlet'];
            $stokProduk['catatan'] = $payloads['catatan'];
            $stokProduk['kode'] = (new UniqueCode(StokProduk::class, 'kode', 'ST-OP-', 9, true))->get();
            $stokProduk['tanggal'] = date("Y-m-d");
            $stokProduk['jenis'] = 'OPNAME';
            $stokProduk['reference'] = 'STOKOPNAME';
            $stokProduk['created_at'] = date("Y-m-d H:i:s");
            $stokProduk['created_by'] = auth()->user()->name;
            $id_reference = DB::table('stok_produk')->insertGetId($stokProduk);
            $stokProdukDetail = [];
            foreach ($payloads['dataDetail'] as $item) {
                $harga = $item['nilai_stok'];
                $subtotalHpp =  $harga * $item['stok_selisih'];

                $detail = [];
                $detail['id_produk'] = $item['id'];
                $detail['nilai'] = $item['stok_selisih'];
                $detail['jenis'] = floatval($item['stok_selisih']) < 0 ? 'KELUAR' : 'MASUK';
                $detail['sumber'] = 'stok_produk';
                $detail['id_reference'] = $id_reference;
                $detail['kode_reference'] = $stokProduk['kode'];
                $detail['harga'] = $harga;
                $detail['sub_total'] = $subtotalHpp;
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

    private static function setNewHpp($item)
    {
        $totalHargaBefore = $item['stok'] * $item['nilai_stok'];
        $totalQtyBaru = $item['stok'] + $item['stok_selisih'];
        $subtotalHpp = $totalHargaBefore - ($totalQtyBaru * $item['new_nilai_stok']);
        if($item['stok_selisih'] == 0) {
            return abs($subtotalHpp);
        }
        return abs($subtotalHpp / $item['stok_selisih']);

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
