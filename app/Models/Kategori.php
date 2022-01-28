<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    protected $guarded = [];

    public static $storeRule = [
        'nama_kategori' => 'required|string|max:100|unique:kategori,nama_kategori'
    ];

    public static function storeKategori($payloads)
    {
        try {
            $payloads['id_outlet'] = session()->get('outlet');
            $payloads['nama_kategori'] = strtoupper($payloads['nama_kategori']);
            $payloads['created_at'] = date('Y-m-d H:i:s');
            DB::table('kategori')->insert($payloads);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function updateKategori($id, $payloads)
    {
        try {
            $payloads['nama_kategori'] = strtoupper($payloads['nama_kategori']);
            $payloads['updated_at'] = date('Y-m-d H:i:s');
            DB::table('kategori')->where('id_kategori', $id)->update($payloads);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function getDataKategori($payloads, $type)
    {
        try {
            $kategori = DB::table('kategori as k')
                        ->leftJoin('produk as p', function($join) {
                            $join->on('k.id_kategori', '=', 'p.id_kategori');
                            $join->where('p.status', '1');
                        })
                        ->selectRaw("
                            k.id_kategori,
                            k.nama_kategori,
                            k.created_at,
                            count(p.id_kategori) as totalProduk
                        ")
                        ->groupBy('k.id_kategori', 'k.nama_kategori');

            if(isset($payloads['search'])) {
                $kategori->where('k.nama_kategori', 'like', '%' . $payloads['search'] . '%');
            }

            if(isset($payloads['id_outlet'])) {
                $kategori->where('k.id_outlet', $payloads['id_outlet']);
            }

            // $kategori->orde

            if($type == 'datatable') {
                return $kategori;
            }

            return $kategori->get();

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
