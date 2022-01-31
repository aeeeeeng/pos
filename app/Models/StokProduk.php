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
        'id_outlet',
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
                         ->leftJoin('outlet as o', 'sp.id_outlet', '=', 'o.id_outlet')
                         ->selectRaw("sp.*, o.nama_outlet")
                         ->where('sp.jenis', 'MASUK');

            if(isset($payloads['id_outlet'])) {
                $stokMasuk->where('sp.id_outlet', $payloads['id_outlet']);
            }

            if(isset($payloads['status'])) {
                $stokMasuk->where('sp.status', $payloads['status']);
            }

            if(isset($payloads['search'])) {
                $search = $payloads['search'];
                $stokMasuk->where(function($query) use($search){
                    $query->where('sp.kode', 'like', '%' . $search . '%');
                    $query->orWhere('sp.catatan', 'like', '%' . $search . '%');
                });
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

    public static function getStokKeluar($payloads, $type)
    {
        try {
            $stokMasuk = DB::table('stok_produk as sp')
                        ->leftJoin('outlet as o', 'sp.id_outlet', '=', 'o.id_outlet')
                        ->selectRaw("sp.*, o.nama_outlet")
                        ->where('sp.jenis', 'KELUAR');

            if(isset($payloads['id_outlet'])) {
                $stokMasuk->where('sp.id_outlet', $payloads['id_outlet']);
            }

            if(isset($payloads['status'])) {
                $stokMasuk->where('sp.status', $payloads['status']);
            }

            if(isset($payloads['search'])) {
                $search = $payloads['search'];
                $stokMasuk->where(function($query) use($search){
                    $query->where('sp.kode', 'like', '%' . $search . '%');
                    $query->orWhere('sp.catatan', 'like', '%' . $search . '%');
                });
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

    public static function getStokOpname($payloads, $type)
    {
        try {
            $stokOpname = DB::table('stok_produk as sp')
                         ->join('outlet as o', 'sp.id_outlet', '=', 'o.id_outlet')
                         ->selectRaw("sp.*, o.nama_outlet")
                         ->where('sp.jenis', 'OPNAME');
            if(isset($payloads['id_outlet'])) {
                $stokOpname->where('o.id_outlet', $payloads['id_outlet']);
            }

            if(isset($payloads['status'])) {
                $stokOpname->where('sp.status', $payloads['status']);
            }

            if(isset($payloads['dateStart']) && isset($payloads['dateEnd'])) {
                $stokOpname->whereBetween('tanggal', [$payloads['dateStart'], $payloads['dateEnd']]);
            }

            if(isset($payloads['search'])) {
                $search = $payloads['search'];
                $stokOpname->where(function($query) use($search){
                    $query->where('sp.kode', 'like', '%' . $search . '%');
                    $query->orWhere('sp.catatan', 'like', '%' . $search . '%');
                });
            }

            if($type == 'datatable') {
                return $stokOpname;
            }
            return $stokOpname->get();
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
                                           ->update(['nilai' => 0, 'sub_total' => 0]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public static function showDetailAllJenis($id)
    {
        try {
            $header = DB::table('stok_produk as sp')->join('outlet as o', 'o.id_outlet', '=', 'sp.id_outlet')
                      ->where('id_stok_produk', $id)
                      ->selectRaw('sp.*, o.nama_outlet')->first();
            $details = DB::table('stok_produk_detail as spd')
                       ->join('produk as p', 'spd.id_produk', '=', 'p.id_produk')
                       ->leftJoin('uom as u', 'u.id_uom', '=', 'p.id_uom')
                       ->where('spd.id_reference', $id)->where('spd.sumber', 'stok_produk')->get();
            $grandTotal = $details->reduce(function($prev, $next){
                return $prev + $next->sub_total;
            });
            return compact('header', 'details', 'grandTotal');
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function showDetailOpname($id)
    {
        try {
            $header = DB::table('stok_produk as sp')->leftJoin('outlet as o', 'o.id_outlet', '=', 'sp.id_outlet')
                      ->where('id_stok_produk', $id)
                      ->selectRaw('sp.*, o.nama_outlet')->first();

            $subSpd = DB::table('stok_produk_detail')->selectRaw("id_produk, id_reference, sum(nilai) as jumlah_barang_sistem ")
                      ->groupBy('id_produk', 'id_reference');

            $details = DB::table('stok_produk_detail as spd')
                       ->selectRaw("
                            p.kode_produk,
                            p.nama_produk,
                            IFNULL(ROUND(sum(subSpd.jumlah_barang_sistem), 2), 0) as jumlah_barang_sistem,
                            IFNULL(ROUND(sum(subSpd.jumlah_barang_sistem), 2), 0) + spd.nilai  as jumlah_barang_aktual,
                            spd.nilai as selisih,
                            spd.harga
                       ")
                       ->join('produk as p', 'spd.id_produk', '=', 'p.id_produk')
                       ->leftJoinSub($subSpd, 'subSpd', function($joinSub) use ($id) {
                            $joinSub->on('spd.id_produk', '=', 'subSpd.id_produk');
                            $joinSub->where('subSpd.id_reference', '<', $id);
                       })
                       ->where('spd.id_reference', $id)->where('sumber', 'stok_produk')
                       ->groupBy('p.kode_produk', 'p.nama_produk', 'spd.nilai', 'spd.harga')
                       ->get();
            return compact('header', 'details');
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function getLastStockProduct($id)
    {
        try {
            $data = DB::table('stok_produk_detail')->selectRaw("ifnull(sum(nilai),0) as last_stock")->where('id_produk', $id)->first();
            return $data->last_stock;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

}
