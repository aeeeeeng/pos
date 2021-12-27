<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
