<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\Produk;
use App\Models\Member;
use App\Models\Setting;
use App\Library\Response;
use Exception;

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
        $sql = DB::table('produk')->selectRaw('produk.id_produk as id, produk.*')
        ->where('kode_produk', 'like', '%'.strtoupper($q).'%')
        ->orWhere('nama_produk', 'like', '%'.$q.'%');
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
                $detail['jumlah'] = $item['qty_order'];
                $detail['diskon'] = $item['diskon'];
                $detail['subtotal'] = $item['subtotal'];
                $detail['created_at'] = date("Y-m-d H:i:s");
                $detail['updated_at'] = date("Y-m-d H:i:s");
                $details[] = $detail;
                self::updateStock($item['id_produk'], $item['qty_order']);
            }
            DB::table('penjualan_detail')->insert($details);
            $responseJson = Response::success('Berhasil menyimpan transaksi');
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $status = 500;
            $responseJson = Response::error($e->getMessage());
        }
        return response()->json($responseJson, $status);
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
