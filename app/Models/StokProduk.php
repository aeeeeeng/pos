<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StokProduk extends Model
{
    use HasFactory;

    protected $primaryKey = "id_stok_produk";

    protected $table = 'stok_produk';

    protected $fillable = [
        'id_stok_produk',
        'id_gudang',
        'kode',
        'catatan',
        'tanggal',
        'jenis',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by'
    ];

    public static function getStokMasuk($payloads, $type)
    {
        try {
            $stokMasuk = DB::table('stok_produk as sp')
                         ->join('gudang as g', function($join) {
                             $join->on('sp.id_gudang', '=', 'g.id_gudang');
                             $join->where('g.status', '1');
                         })
                         ->selectRaw("sp.*, g.nama_gudang, g.kode_gudang")
                         ->where('sp.jenis', 'MASUK');
            if(isset($payloads['gudang'])) {
                $stokMasuk->where('sp.id_gudang', $payloads['gudang']);
            }

            if(isset($payloads['status'])) {
                $stokMasuk->where('sp.status', $payloads['status']);
            }

            if(isset($payloads['dateStart']) && isset($payloads['dateEnd'])) {
                $stokMasuk->whereBetween('tanggal', [$payloads['dateStart'], $payloads['dateEnd']]);
            }

            if($type == 'datatable') {
                return $stokMasuk;
            }
            return $stokMasuk->get();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function cancelAllJenis($id)
    {
        DB::beginTransaction();
        try {
            DB::table('stok_produk')->where('id_stok_produk', $id)->update(['status' => '0']);
            DB::table('stok_produk_detail')->where('id_reference', $id)
                                           ->where('sumber', 'stok_produk')
                                           ->update(['nilai' => 0]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public static function showDetailAllJenis($id)
    {
        try {
            $header = DB::table('stok_produk as sp')->join('gudang as g', 'sp.id_gudang', '=', 'g.id_gudang')
                      ->where('id_stok_produk', $id)
                      ->selectRaw('sp.*, g.nama_gudang, g.kode_gudang')->first();
            $details = DB::table('stok_produk_detail as spd')->join('produk as p', 'spd.id_produk', '=', 'p.id_produk')
                       ->where('spd.id_reference', $id)->where('spd.sumber', 'stok_produk')->get();
            return compact('header', 'details');
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    
}
