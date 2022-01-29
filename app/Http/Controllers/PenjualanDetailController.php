<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\Produk;
use App\Models\Member;
use App\Models\Setting;
use App\Library\Response;
use Exception;
use App\Library\UniqueCode;
use App\Models\StokProduk;

class PenjualanDetailController extends Controller
{
    public function index()
    {
        $produk = Produk::orderBy('nama_produk')->get();
        $member = Member::orderBy('nama')->get();
        $diskon = Setting::first()->diskon ?? 0;

        return view('penjualan_detail.index', compact('produk', 'member', 'diskon'));
    }

    public function getDataProduct(Request $request)
    {
        $q = $request->get('q');
        $sql = DB::table('produk as p')->selectRaw('
                                                p.id_produk as id,
                                                p.id_produk,
                                                p.id_kategori,
                                                p.kode_produk, p.nama_produk,
                                                p.merk,
                                                p.harga_jual, p.diskon,
                                                p.created_at, p.updated_at,
                                                IFNULL(sum(nilai),0) as stok,
                                                IFNULL(sum(sub_total) / sum(nilai),0) as hpp')
        ->leftJoin('stok_produk_detail as spd', 'p.id_produk', '=', 'spd.id_produk')
        ->where('p.kode_produk', 'like', '%'.strtoupper($q).'%')
        ->orWhere('p.nama_produk', 'like', '%'.$q.'%')
        ->groupBy('p.id_produk', 'p.id_kategori',
                'p.kode_produk', 'p.nama_produk',
                'p.merk',
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
            $header = [];
            $details = [];

            $header['id_member'] = $payloads['member'];
            $header['total_item'] = count($payloads['dataDetail']);
            $header['total_harga'] = $payloads['grandTotal'];
            $header['diskon'] = $payloads['diskon'];
            $header['bayar'] = $payloads['totalBayar'];
            $header['diterima'] = $payloads['diterima'];
            $header['id_user'] = auth()->user()->id;
            $header['created_at'] = date("Y-m-d H:i:s");
            $header['updated_at'] = date("Y-m-d H:i:s");
            $id_penjualan = DB::table('penjualan')->insertGetId($header);
            foreach ($payloads['dataDetail'] as $item) {
                $detail = [];
                $detail['id_penjualan'] = $id_penjualan;
                $detail['id_produk'] = $item['id_produk'];
                $detail['harga_jual'] = $item['harga_jual'];
                $detail['harga_beli'] = $item['hpp'];
                $detail['jumlah'] = $item['qty_order'];
                $detail['diskon'] = $item['diskon'];
                $detail['subtotal'] = $item['subtotal'];
                $detail['created_at'] = date("Y-m-d H:i:s");
                $detail['updated_at'] = date("Y-m-d H:i:s");
                $details[] = $detail;
                self::updateStock($item['id_produk'], $item['qty_order']);
            }
            DB::table('penjualan_detail')->insert($details);
            self::storeStock($details);
            $responseJson = Response::success('Berhasil menyimpan transaksi', ['id_penjualan' => $id_penjualan]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $status = 500;
            $responseJson = Response::error($e->getMessage());
        }
        return response()->json($responseJson, $status);
    }

    private static function storeStock($detail)
    {
        try {
            $stokProduk = [];
            $stokProduk['id_gudang'] = Setting::first()->gudang_prioritas;
            $stokProduk['tanggal'] = date("Y-m-d");
            $stokProduk['jenis'] = 'PENJUALAN';
            $stokProduk['reference'] = 'STOKPENJUALAN';
            $stokProduk['kode'] = (new UniqueCode(StokProduk::class, 'kode', 'ST-P-', 4))->get();;
            $stokProduk['created_at'] = date("Y-m-d H:i:s");
            $stokProduk['created_by'] = auth()->user()->name;
            $id_reference = DB::table('stok_produk')->insertGetId($stokProduk);
            $stokProdukDetail = [];
            foreach ($detail as $item) {
                $detail = [];
                $detail['id_produk'] = $item['id_produk'];
                $detail['nilai'] = -1 * floatval($item['jumlah']);
                $detail['harga'] = $item['harga_beli'];
                $detail['sub_total'] = $detail['nilai'] * $item['harga_beli'];
                $detail['jenis'] = 'KELUAR';
                $detail['sumber'] = 'stok_produk';
                $detail['id_reference'] = $id_reference;
                $detail['kode_reference'] = $stokProduk['kode'];
                $stokProdukDetail[] = $detail;
            }
            DB::table('stok_produk_detail')->insert($stokProdukDetail);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }


    private static function updateStock($idProduct, $qty)
    {
        try {
            DB::table('produk')->where('id_produk', $idProduct)
            ->update([
                'stok' => DB::raw('produk.stok - ' . $qty)
            ]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

}
