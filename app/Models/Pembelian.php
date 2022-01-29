<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Pembelian extends Model
{
    use HasFactory;

    protected $table = 'pembelian';
    protected $primaryKey = 'id_pembelian';
    protected $fillable = ['kode_pembelian', 'no_pembelian'];
    protected $guarded = [];

    public static function getData($payloads, $type)
    {
        try {
            $pembelian = DB::table('pembelian as p')
                         ->leftJoin('supplier as s', 'p.id_supplier', '=', 's.id_supplier')
                         ->selectRaw("p.id_pembelian, p.kode_pembelian, s.nama as nama_supplier,
                                      p.no_pembelian, DATE_FORMAT(p.tanggal_pembelian,'%d/%m/%Y') as tanggal_pembelian, p.status, p.created_at");

            if(isset($payloads['id_outlet'])) {
                $pembelian->where('p.id_outlet', $payloads['id_outlet']);
            }
            if(isset($payloads['id_supplier'])) {
                $pembelian->where('p.id_supplier', $payloads['id_supplier']);
            }
            if(isset($payloads['dateStart'])) {
                $dateStart = $payloads['dateStart'];
                $dateEnd = $payloads['dateEnd'];
                $pembelian->whereBetween('p.tanggal_pembelian', [$dateStart, $dateEnd]);
            }
            if(isset($payloads['status'])) {
                $pembelian->where('p.status', $payloads['status']);
            }
            if(isset($payloads['cari'])) {
                $pembelian->where('p.no_pembelian', 'like', '%' . $payloads['cari'] . '%');
                $pembelian->orWhere('p.kode_pembelian', 'like', '%' . $payloads['cari'] . '%');
            }

            if($type == 'datatable') {
                return $pembelian;
            }

            $pembelian->orderBy('p.created_at', 'desc');
            return $pembelian->get();

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'id_supplier', 'id_supplier');
    }
}
