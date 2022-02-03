<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\Controller;
use App\Library\Response;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiJualController extends Controller
{
    public function index()
    {
        $kategori = DB::table('produk as p')->join('kategori as k', 'p.id_kategori', '=', 'k.id_kategori')
                    ->where('p.dijual', '1')
                    ->where(function($query){
                        // $query->where('k.id_outlet', session()->get('outlet'));
                        // $query->where('p.id_outlet', session()->get('outlet'));
                    })
                    ->where('p.status', '1')
                    ->selectRaw("DISTINCT k.id_kategori, k.nama_kategori")->get();
        return view('app.transaksi-jual.index', compact('kategori'));
    }

    public function getDataProduk(Request $request)
    {
        $status = 200;
        $responseJson = [];

        try {
            $id_kategori = $request->get('id_kategori');
            $produk = DB::table('produk as p')
                    ->leftJoin('kategori as k', 'p.id_kategori', '=', 'k.id_kategori')
                    ->selectRaw('p.*, k.nama_kategori')
                    ->where('p.id_kategori', $id_kategori)
                    // ->where('p.id_outlet', session()->get('outlet'))
                    ->where('p.dijual', '1')
                    ->where('p.status', '1');
            if($request->get('cari') != '' || $request->get('cari') != null) {
                $produk->where('p.nama_produk', 'like', '%' . $request->get('cari') . '%');
                $produk->orWhere('p.sku_produk', 'like', '%' . $request->get('cari') . '%');
                $produk->orWhere('p.barcode_produk', 'like', '%' . $request->get('cari') . '%');
            }
            $produk->orderBy('p.nama_produk', 'asc');
            $resultProduk = $produk->get()->each(function($model){
                $arrProdukName = explode(" ", $model->nama_produk);
                if(count($arrProdukName) > 1) {
                    $model->imageText = substr($arrProdukName[0], 0, 1) . '' . substr($arrProdukName[1], 0, 1);
                } else {
                    $model->imageText = substr($arrProdukName[0], 0, 1);
                }
                return $model;
            });
            $responseJson = Response::success('OK', $resultProduk);
        } catch (Exception $e) {
            $status = 500;
            $responseJson = Response::error($e->getMessage());
        }
        return response()->json($responseJson, $status);
    }

    public function getAddOpt($id_produk)
    {
        $status = 200;
        $responseJson = [];
        try {
            $headerAddOpt = DB::table('produk_additional as pa')->where('pa.id_produk', $id_produk)
            ->join('add_opt as ao', 'ao.id_add_opt', '=', 'pa.id_add_opt');
            $totalHeader = $headerAddOpt->count();
            $dataHeader = $headerAddOpt->get();
            if($totalHeader > 0) {
                $dataHeader->each(function($item){
                    $detailAddOpt = DB::table('add_opt_detail as aod')->where('aod.id_add_opt', $item->id_add_opt)->get();
                    $item->details = $detailAddOpt;
                    return $item;
                });
            }
            $responseJson = Response::success('ok', $dataHeader);
        } catch (Exception $e) {
            $status = 500;
            $responseJson = Response::error($e->getMessage());
        }
        return response()->json($responseJson, $status);
    }
}
