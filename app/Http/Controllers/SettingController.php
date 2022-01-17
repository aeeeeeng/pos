<?php

namespace App\Http\Controllers;

use App\Library\Response;
use App\Models\Gudang;
use Illuminate\Http\Request;
use App\Models\Setting;
use Exception;
use Illuminate\Http\Client\ResponseSequence;

class SettingController extends Controller
{
    public function index()
    {
        $gudang = Gudang::getAllGudangActive('row');
        return view('setting.index', compact('gudang'));
    }

    public function show()
    {
        return Setting::first();
    }

    public function setMode(Request $request)
    {
        $status = 200;
        $responseJson = [];

        $oldMode = Setting::first()->dark_mode;
        $nowMode = $oldMode == '0' ? '1' : '0';
        try {
            $update = Setting::first()->update(['dark_mode' => $nowMode]);
            $responseJson = Response::success('berhasil', Setting::first());
        } catch (Exception $e) {
            $responseJson = Response::error($e->getMessage());
        }
        return response()->json($responseJson, $status);
    }

    public function update(Request $request)
    {
        $setting = Setting::first();
        $setting->nama_perusahaan = $request->nama_perusahaan;
        $setting->telepon = $request->telepon;
        $setting->alamat = $request->alamat;
        $setting->diskon = $request->diskon;
        $setting->tipe_nota = $request->tipe_nota;
        $setting->min_stok = $request->min_stok;
        $setting->gudang_prioritas = $request->gudang_prioritas;

        if ($request->hasFile('path_logo')) {
            $file = $request->file('path_logo');
            $nama = 'logo-' . date('YmdHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/img'), $nama);

            $setting->path_logo = "/img/$nama";
        }

        if ($request->hasFile('path_kartu_member')) {
            $file = $request->file('path_kartu_member');
            $nama = 'logo-' . date('Y-m-dHis') . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('/img'), $nama);

            $setting->path_kartu_member = "/img/$nama";
        }

        $setting->update();

        return response()->json('Data berhasil disimpan', 200);
    }
}
