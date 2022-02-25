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
                    // ->where('p.id_outlet', session()->get('outlet'))
                    ->where('p.dijual', '1')
                    ->where('p.status', '1');
            if($id_kategori != '') {
                $produk->where('p.id_kategori', $id_kategori);
            }
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

    public function searchMember(Request $request)
    {
        $q = $request->get('q');
        $sql = DB::table('member')->selectRaw('id_member as id, kode_member, nama as nama_member')
               ->where('kode_member', 'like', '%'.strtoupper($q).'%')
               ->orWhere('nama', 'like', '%'.$q.'%');
        $result['incomplete_results'] = true;
        $result['total_count'] = $sql->count();
        $result['items'] = $sql->get();
        return response()->json($result);
    }

    public function getPromoAuto(Request $request)
    {
        $status = 200;
        $responseJson = [];
        try {
            DB::unprepared('DROP TABLE IF EXISTS payloads;
                            CREATE TEMPORARY TABLE payloads (
                                `key` INT PRIMARY KEY,
                                `id_produk` VARCHAR(100),
                                `qty_order` INT
                            )');
            $payloads = [];
            foreach ($request->all()['detail'] as $item) {
                $payload['key'] = $item['key'];
                $payload['id_produk'] = $item['id_produk'];
                $payload['qty_order'] = $item['qty_order'];
                $payloads[] = $payload;
            }

            DB::table('payloads')->insert($payloads);

            $timeNow = date('H:i:s');
            $dateNow = date('Y-m-d');
            $nowDayNumber = date('N', strtotime(date('l')));

            $promoBogo = self::getPromoBogo($timeNow, $dateNow, $nowDayNumber);
            $promoGrandTotal = self::getPromoGrandTotal($timeNow, $dateNow, $nowDayNumber, $request->post('grandTotal'));
            $promoQtyProduk = self::getPromoQtyProduk($timeNow, $dateNow, $nowDayNumber, $request->post('grandTotal'));

            $promo = [];

            foreach ($promoBogo as $item) { array_push($promo, $item); };
            foreach ($promoGrandTotal as $item) { array_push($promo, $item); };
            foreach ($promoQtyProduk as $item) { array_push($promo, $item); };

            $responseJson = Response::success('OK', $promo);

        } catch (Exception $e) {
            $status = 500;
            $responseJson = $e->getMessage();
        }
        return response()->json($responseJson, $status);
    }

    public static function getPromoManual(Request $request)
    {
        $status = 200;
        $responseJson = '';

        $timeNow = date('H:i:s');
        $dateNow = date('Y-m-d');
        $nowDayNumber = date('N', strtotime(date('l')));

        try {
            $promoManual = DB::table('promo_diskon as pd')
                            ->join('promo_diskon_outlet as pdo', 'pd.id_promo_diskon', '=', 'pdo.id_promo_diskon')
                            ->selectRaw("
                                    pd.id_promo_diskon as id,
                                    pd.kode_promo,
                                    pd.nama_promo,
                                    pd.diskon_val,
                                    pd.diskon_unit,
                                    'promoManual' as tipe_diskon
                            ")
                            ->where(function($query) use($dateNow){
                                    $query->where('pd.tanggal_mulai', '<=', $dateNow);
                                    $query->where('pd.tanggal_akhir', '>=', $dateNow);
                                })
                                ->where(function($query) use($timeNow){
                                    $query->where('pd.jam_mulai', '<=', $timeNow);
                                    $query->where('pd.jam_akhir', '>=', $timeNow);
                                })
                                ->where(function($query) use ($nowDayNumber){
                                    $query->where('pd.hari', $nowDayNumber);
                                    $query->orWhere('pd.hari', '0');
                                })
                                ->where('pdo.id_outlet_promo', session()->get('outlet'))
                                ->orderBy('pd.created_at', 'ASC');
                if($request->get('id') != '' || $request->get('id') != null) {
                    $promoManual->where('pd.id_promo_diskon', $request->get('id'));
                }
            $responseJson = Response::success('OK', $promoManual->get());
        } catch (Exception $e) {
            $status = 500;
            $responseJson = $e->getMessage();
        }
        return response()->json($responseJson, $status);

    }

    private static function getPromoBogo($timeNow, $dateNow, $nowDayNumber)
    {

        $payloads = DB::table('payloads as p')->selectRaw('p.id_produk, sum(p.qty_order) as qty_order')->groupBy('p.id_produk');
        $promoBogo = DB::table('promo_auto_bogo as pab')
        ->selectRaw("
            pab.kode_promo,
            pab.nama_promo,
            pab.qty_produk_bonus,
            pab.id_produk_bonus,
            prd.nama_produk,
            prd.harga_jual as diskon_val,
            'rp' as diskon_unit,
            'promoBogo' as tipe_diskon
        ")
        ->join('promo_auto_bogo_outlet as pabo', 'pab.id_promo_auto_bogo', '=', 'pabo.id_promo_auto_bogo')
        ->join(DB::raw('('.$payloads->toSql().') as p'), function($join){
            $join->on('p.id_produk', '=', 'pab.id_produk_beli');
            $join->on('p.qty_order', '>=', 'pab.min_qty_produk');
        })
        ->join('produk as prd', 'prd.id_produk', '=', 'pab.id_produk_bonus')
        ->where(function($query) use($dateNow){
            $query->where('pab.tanggal_mulai', '<=', $dateNow);
            $query->where('pab.tanggal_akhir', '>=', $dateNow);
        })
        ->where(function($query) use($timeNow){
            $query->where('pab.jam_mulai', '<=', $timeNow);
            $query->where('pab.jam_akhir', '>=', $timeNow);
        })
        ->where(function($query) use ($nowDayNumber){
            $query->where('pab.hari', $nowDayNumber);
            $query->orWhere('pab.hari', '0');
        })
        ->where('pabo.id_outlet_promo', session()->get('outlet'))
        ->orderBy('pab.created_at', 'ASC');
        return $promoBogo->get();
    }

    private static function getPromoGrandTotal($timeNow, $dateNow, $nowDayNumber, $grandTotal)
    {
        $promoGrandTotal = DB::table('promo_auto_grandtotal as pag')
        ->selectRaw("
            pag.kode_promo,
            pag.nama_promo,
            pag.diskon_val,
            pag.diskon_unit,
            'promoGrandTotal' as tipe_diskon
        ")
        ->join('promo_auto_grandtotal_outlet as pago', 'pag.id_promo_auto_grandtotal', '=', 'pago.id_promo_auto_grandtotal')
        ->where(function($query) use($dateNow){
            $query->where('pag.tanggal_mulai', '<=', $dateNow);
            $query->where('pag.tanggal_akhir', '>=', $dateNow);
        })
        ->where(function($query) use($timeNow){
            $query->where('pag.jam_mulai', '<=', $timeNow);
            $query->where('pag.jam_akhir', '>=', $timeNow);
        })
        ->where(function($query) use ($nowDayNumber){
            $query->where('pag.hari', $nowDayNumber);
            $query->orWhere('pag.hari', '0');
        })
        ->where('pag.min_grandtotal', '<=', $grandTotal)
        ->where('pago.id_outlet_promo', session()->get('outlet'))
        ->orderBy('pag.created_at', 'ASC');
        return $promoGrandTotal->get();
    }

    private static function getPromoQtyProduk($timeNow, $dateNow, $nowDayNumber, $grandTotal)
    {

        $promoQtyProduk = DB::table('promo_auto_qty_produk as paqp')
        ->selectRaw("
            paqp.kode_promo,
            paqp.nama_promo,
            paqp.diskon_val,
            paqp.diskon_unit,
            'promoQtyProduk' as tipe_diskon,
            id_produk_beli
        ")
        ->join('promo_auto_qty_produk_outlet as paqpo', 'paqp.id_promo_auto_qty_produk', '=', 'paqpo.id_promo_auto_qty_produk')
        ->join('payloads as p', function($join){
            $join->on('p.id_produk', '=', 'paqp.id_produk_beli');
            $join->on('p.qty_order', '>=', 'paqp.min_qty_produk');
        })
        ->where(function($query) use($dateNow){
            $query->where('paqp.tanggal_mulai', '<=', $dateNow);
            $query->where('paqp.tanggal_akhir', '>=', $dateNow);
        })
        ->where(function($query) use($timeNow){
            $query->where('paqp.jam_mulai', '<=', $timeNow);
            $query->where('paqp.jam_akhir', '>=', $timeNow);
        })
        ->where(function($query) use ($nowDayNumber){
            $query->where('paqp.hari', $nowDayNumber);
            $query->orWhere('paqp.hari', '0');
        })
        ->where('paqpo.id_outlet_promo', session()->get('outlet'))
        ->orderBy('paqp.created_at', 'ASC');

        return $promoQtyProduk->get();
    }

    public function store(Request $request)
    {
        dd($request->all());
    }
}
