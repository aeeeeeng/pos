<?php

namespace App\Http\Controllers;

use App\Library\Response;
use Illuminate\Http\Request;
use App\Models\Kategori;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataKategori = Kategori::selectRaw("id_kategori as id, nama_kategori as text");
        $dataAddOpt = DB::table('add_opt');
        $dataProduk = DB::table('produk')->where('status', '1');

        $dataOutlet = DB::table('outlet')->selectRaw("id_outlet as id, nama_outlet as text");
        $outlet = $dataOutlet->get();

        $totalKategori = $dataKategori->count();
        $totalAddOpt = $dataAddOpt->count();
        $totalProduk = $dataProduk->count();

        return view('kategori.index', compact('totalKategori', 'totalAddOpt', 'totalProduk', 'outlet'));
    }

    public function data(Request $request)
    {
        $status = 200;
        $responseJson = [];
        try {
            $kategori = Kategori::getDataKategori($request->all(), 'datatable');
            $datatables = DataTables::of($kategori);
            $responseJson = $datatables->make(true)->original;
        } catch (Exception $e) {
            $status = 500;
            $responseJson = Response::error($e->getMessage());
        }
        return response()->json($responseJson, $status);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kategori.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $status = 200;
        $responseJson = [];

        $validate = Validator::make($request->all(), Kategori::$storeRule);
        if($validate->fails()) {
            $responseJson = Response::error($validate->errors());
            return response()->json($responseJson, 400);
        }

        try {
            Kategori::storeKategori($request->all());
            $responseJson = Response::success('Berhasil menambahkan kategori');
        } catch (Exception $e) {
            $status = 500;
            $responseJson = Response::error($e->getMessage());
        }
        return response()->json($responseJson, $status);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kategori = Kategori::find($id);

        return response()->json($kategori);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kategori = DB::table('kategori')->where('id_kategori', $id)->first();
        return view('kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $status = 200;
        $responseJson = [];

        $newRules = Kategori::$storeRule;
        $newRules['nama_kategori'] = 'required|string|max:100|unique:kategori,nama_kategori,' . $id . ',id_kategori';
        $validate = Validator::make($request->all(), $newRules);
        if($validate->fails()) {
            $responseJson = Response::error($validate->errors());
            return response()->json($responseJson, 400);
        }


        try {
            Kategori::updateKategori($id, $request->all());
            $responseJson = Response::success('Perubahan berhasil disimpan');
        } catch (Exception $e) {
            $status = 500;
            $responseJson = Response::error($e->getMessage());
        }
        return response()->json($responseJson, $status);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kategori = Kategori::find($id);
        $kategori->delete();

        return response(null, 204);
    }
}
