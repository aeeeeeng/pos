<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

    protected $table = 'pengeluaran';
    protected $primaryKey = 'id_pengeluaran';
    protected $fillable = ['kode_pengeluaran'];
    protected $guarded = [];

    public static $storeRule = [
        'id_outlet' => 'required',
        'tanggal_pengeluaran' => 'required',
        'deskripsi' => 'required',
        'nominal' => 'required'
    ];
}
