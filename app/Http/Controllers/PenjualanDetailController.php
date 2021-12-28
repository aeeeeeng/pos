<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\Produk;
use App\Models\Member;
use App\Models\Setting;

class PenjualanDetailController extends Controller
{
    public function index()
    {
        $produk = Produk::orderBy('nama_produk')->get();
        $member = Member::orderBy('nama')->get();
        $diskon = Setting::first()->diskon ?? 0;

        return view('penjualan_detail.index', compact('produk', 'member', 'diskon'));
    }

    public function getDataProduct(Request $request)
    {
        $q = $request->get('q');
        $sql = DB::table('produk')->selectRaw('produk.id_produk as id, produk.*')
        ->where('kode_produk', 'like', '%'.strtoupper($q).'%')
        ->orWhere('nama_produk', 'like', '%'.$q.'%');
        $result['incomplete_results'] = true;
        $result['total_count'] = $sql->count();
        $result['items'] = $sql->get();
        return response()->json($result);
    }
}
