<?php

namespace App\Http\Controllers;

use App\Models\AddOpt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Kategori;
use Yajra\DataTables\Facades\DataTables;
use Exception;
use App\Library\Response;

class AddOptController extends Controller
{
    public function index()
    {
        $dataKategori = Kategori::selectRaw("id_kategori as id, nama_kategori as text");
        $dataAddOpt = DB::table('add_opt');
        $dataProduk = DB::table('produk')->where('status', '1');

        $dataOutlet = DB::table('outlet')->selectRaw("id_outlet as id, nama_outlet as text");
        $outlet = $dataOutlet->get();

        $totalKategori = $dataKategori->where('id_outlet', session()->get('outlet'))->count();
        $totalAddOpt = $dataAddOpt->where('id_outlet', session()->get('outlet'))->count();
        $totalProduk = $dataProduk->where('id_outlet', session()->get('outlet'))->count();

        return view('add-opt.index', compact('totalKategori', 'totalAddOpt', 'totalProduk', 'outlet'));
    }

    public function data(Request $request)
    {
        $status = 200;
        $responseJson = [];
        try {
            $addOpt = AddOpt::getData($request->all(), 'datatable');
            $datatables = DataTables::of($addOpt);
            $responseJson = $datatables->make(true)->original;
        } catch (Exception $e) {
            $status = 500;
            $responseJson = Response::error($e->getMessage());
        }
        return response()->json($responseJson, $status);
    }

    public function create()
    {
        return view('add-opt.create');
    }

    public function edit($id)
    {
        $header = json_encode(DB::table('add_opt')->where('id_add_opt', $id)->first());
        $details = json_encode(DB::table('add_opt_detail')
                               ->selectRaw('nama_add_opt_detail as nama, harga_add_opt_detail as harga')
                               ->where('id_add_opt', $id)->get());
        return view('add-opt.edit', compact('header', 'details'));
        // return view('')
    }

    public function update($id, Request $request)
    {
        $status = 200;
        $responseJson = [];
        DB::beginTransaction();
        try {
            AddOpt::updateAddOpt($id, $request->all());
            $responseJson = Response::success('Berhasil menyimpan opsi tambahan');
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            $status = 500;
            $responseJson = Response::error($e->getMessage());
        }
        return response()->json($responseJson, $status);
    }

    public function kelolaBahanBaku($id)
    {
        $addOpt = DB::table('add_opt_detail as aod')->where('aod.id_add_opt', $id)
                  ->join('add_opt as ao', 'ao.id_add_opt', '=', 'aod.id_add_opt')
                  ->selectRaw('ao.id_outlet, aod.*')->get();

        foreach ($addOpt as $item) {
            $detail = DB::table('add_opt_komposit as aok')->where('aok.id_add_opt', $item->id_add_opt_detail)
                    ->join('produk as p', 'p.id_produk', '=', 'aok.id_produk_detail')
                    ->join('uom as u', 'u.id_uom', '=', 'p.id_uom')
                    ->selectRaw("p.nama_produk, u.nama_uom, aok.*");
            $item->detail = $detail->count() > 0 ? $detail->get() : [['id_produk_detail' => '', 'nama_produk' => '', 'nama_uom' => '', 'jumlah_komposit' => '' ]];
        }

        return view('add-opt.form-kelola-bahan-baku', compact('addOpt', 'id'));
    }

    public function storeKelolaBahanBaku($id, Request $request)
    {
        $status = 200;
        $responseJson = [];

        DB::beginTransaction();
        try {
            AddOpt::storeKelolaBahanBaku($id, $request->all());
            $responseJson = Response::success('Berhasil menyimpan bahan baku');
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $status = 500;
            $responseJson = Response::error($e->getMessage());
        }
        return response()->json($responseJson, $status);
    }
}
