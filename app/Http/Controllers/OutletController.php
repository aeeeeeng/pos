<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OutletController extends Controller
{
    public function pilihDefault()
    {
        $outlet = DB::table('outlet')->selectRaw('id_outlet, nama_outlet, alamat, telepon, path_logo')->get();
        return view('outlet/pilih-default', compact('outlet'));
    }

    public function setOutlet(Request $request)
    {
        $id_outlet = $request->post('id_outlet');
        Session::put('outlet', $id_outlet);
    }
}
