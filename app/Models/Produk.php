<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    protected $guarded = [];

    public static function getPriceFifo($idProduct)
    {
        $in = DB::table('stok_produk_detail spd')
              ->join('produk as p', 'spd.id_produk', '=', 'p.id_produk')
              ->join('stok_produk sp', 'spd.id_reference', '=', 'sp.id_stok_produk')
              ->where('spd.id_produk', $idProduct)
              ->where('spd.nilai', '>', 0)
              ->selectRaw("
                    sp.tanggal,
                    p.nama_produk, 
                    spd.nilai as qty_in, 
                    0 as qty_out, 
                    spd.harga, 
                    spd.sub_total 
              ");

        $out = DB::table('stok_produk_detail spd')
              ->join('produk as p', 'spd.id_produk', '=', 'p.id_produk')
              ->join('stok_produk sp', 'spd.id_reference', '=', 'sp.id_stok_produk')
              ->where('spd.id_produk', $idProduct)
              ->where('spd.nilai', '<', 0)
              ->selectRaw("
                    sp.tanggal,
                    p.nama_produk, 
                    0 as qty_in,
                    spd.nilai as qty_out, 
                    spd.harga, 
                    spd.sub_total 
              ")
              ->union($in);

        $result = DB::table(DB::raw( "({$out->toSql()}) as sub" ))
                  ->whereRaw("sub.qty_in + sub.qty_out <> 0")
                  ->orderBy("sub.tanggal", 'asc');
                  
        return $result->first();

    }
}
