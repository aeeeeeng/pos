<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Gudang extends Model
{
    use HasFactory;

    protected $primaryKey = "id_gudang";

    protected $table = 'gudang';

    public static $validationForm = [
        'nama_gudang' => 'required|string|max:100|unique:gudang,nama_gudang',
        'alamat_gudang' => 'required|string|max:100'
    ];

    protected $fillable = [
        'id_gudang',
        'kode_gudang',
        'nama_gudang',
        'alamat_gudang',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by'
    ];

    public static function getAllGudangActive($type)
    {
        try {
            $gudang =  DB::table('gudang')->where('status', '1');
            if($type == 'datatable') {
                return $gudang;
            }
            return $gudang->get();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function inActiveGudang($id)
    {
        try {
            DB::table('gudang')->where('id_gudang', $id)->update(['status' => '0']);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function storeGudang(array $payloads) 
    {
        try {
            $payloads['created_at'] = date("Y-m-d H:i:s");
            $payloads['created_by'] = auth()->user()->name;
            DB::table('gudang')->insert($payloads);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function updateGudang(int $id, array $payloads) 
    {
        try {
            $payloads['updated_at'] = date("Y-m-d H:i:s");
            $payloads['updated_by'] = auth()->user()->name;
            DB::table('gudang')->where('id_gudang', $id)->update($payloads);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function showGudangBy($id)
    {
        try {
            return DB::table('gudang')->where('id_gudang', $id)->first();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
