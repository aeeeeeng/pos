<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Outlet extends Model
{
    use HasFactory;
    protected $table = 'outlet';
    protected $primaryKey = 'id_outlet';
    protected $guarded = [];

    public static function defaultOutlet()
    {

        if(session()->get('outlet') != null) {
            return self::where('id_outlet', session()->get('outlet'))->first();
        } else {
            $columns = [];
            foreach (self::getTableColumns() as $item) {
                $column[$item] = null;
                $columns = $column;
            }
            return (object) $columns;
        }
    }

    private static function getTableColumns()
    {
        return Schema::getColumnListing('outlet');
    }

}
