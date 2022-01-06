<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LaporanLabaProduct extends Model
{
    use HasFactory;

    public static function queryGetData($tglAwal, $tglAkhir)
    {
        $query = DB::table(DB::raw("
        (select adddate('1970-01-01',t4.i*10000 + t3.i*1000 + t2.i*100 + t1.i*10 + t0.i) selected_date from
        (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t0,
        (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t1,
        (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t2,
        (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t3,
        (select 0 i union select 1 union select 2 union select 3 union select 4 union select 5 union select 6 union select 7 union select 8 union select 9) t4) as v
        "))
        ->leftJoin('penjualan_detail as pd', DB::raw('date(pd.created_at)'), '=', 'v.selected_date')
        ->leftJoin('produk as p', 'p.id_produk', '=', 'pd.id_produk')
        ->whereBetween('v.selected_date', [$tglAwal, $tglAkhir])
        ->groupBy('v.selected_date', 'p.nama_produk', 'pd.harga_jual', 'pd.diskon', 'pd.harga_beli', DB::raw("DATE_FORMAT(pd.created_at, '%H:%i')"))
        ->selectRaw("
            v.selected_date as tanggalJual,
            DATE_FORMAT(pd.created_at, '%H:%i') as jam_penjualan,
            IFNULL(p.nama_produk, '-') AS nama_produk,
            IFNULL(pd.harga_jual, 0) as harga_jual, 
            IFNULL(pd.diskon, 0) as diskon, 
            IFNULL(sum(pd.jumlah), 0)  as jumlahPenjualan,
            IFNULL(sum(pd.subtotal), 0) as totalSubtotalJual,
            IFNULL(pd.harga_beli, 0) as harga_beli,
            IFNULL(sum(pd.jumlah * (pd.harga_beli - (pd.harga_beli/100*pd.diskon))), 0) as totalSubtotalBeli,
            IFNULL(sum(pd.subtotal - (pd.jumlah * (pd.harga_beli - (pd.harga_beli/100*pd.diskon)))), 0) as labaBersih
        ");

        return $query->get();
    }
}
