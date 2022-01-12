<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'setting';
    protected $primaryKey = 'id_setting';
    protected $guarded = [];

    public static function getNamaGudang()
    {
        $gudang = self::join('gudang', 'gudang_prioritas', '=', 'id_gudang')->first();
        if($gudang->nama_gudang) {
            return $gudang->nama_gudang;
        }
        return '';
    }

}
