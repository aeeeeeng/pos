<?php

namespace App\Http\Controllers;

use App\Library\Response;
use App\Library\UniqueCode;
use App\Models\Gudang;
use Dotenv\Loader\Resolver;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;

class GudangController extends Controller
{
    public function index()
    {
        return view('gudang.index');
    }

    public function create()
    {
        return view('gudang.create');
    }

    public function edit($id)
    {
        $gudang = Gudang::showGudangBy($id);
        return view('gudang.edit', compact('gudang', 'id'));
    }

    public function getData(Request $request)
    {
        $status = 200;
        $responseJson = [];

        try {
            $gudang = Gudang::getAllGudangActive('datatable');
            $datatables = DataTables::of($gudang);
            $responseJson = $datatables->make(true)->original;
        } catch (Exception $e) {
            $status = 500;
            $responseJson = Response::error($e->getMessage());
        }
        return response()->json($responseJson, $status);
    }

    public function inActive($id)
    {
        $status = 200;
        $responseJson = [];
        try {
            Gudang::inActiveGudang($id);
            $responseJson = Response::success('Berhasil menonaktifkan gudang');
        } catch (Exception $e) {
            $status = 500;
            $responseJson = Response::error($e->getMessage());
        }
        return response()->json($responseJson, $status);
    }

    public function store(Request $request)
    {
        $status = 200;
        $responseJson = [];

        $newRules = Gudang::$validationForm;
        $newRules['kode_gudang'] = 'required|string|max:100|unique:gudang,kode_gudang';

        $validate = Validator::make($request->all(), $newRules);
        if($validate->fails()) {
            $responseJson = Response::error($validate->errors());
            return response()->json($responseJson, 400);
        }

        try {
            $payloads = $request->all();
            unset($payloads['isAutoCode']);
            Gudang::storeGudang($payloads);
            $responseJson = Response::success('Berhasil Menyimpan');
        } catch (Exception $e) {
            $status = 500;
            $responseJson = Response::error($e->getMessage());
        }
        return response()->json($responseJson, $status);
    }

    public function update($id, Request $request)
    {
        $status = 200;
        $responseJson = [];

        $newRules = Gudang::$validationForm;
        $newRules['nama_gudang'] = 'required|string|max:100|unique:gudang,nama_gudang,' . $id . ',id_gudang';
        $validate = Validator::make($request->all(), $newRules);

        if($validate->fails()) {
            $responseJson = Response::error($validate->errors());
            return response()->json($responseJson, 400);
        }

        try {
            Gudang::updateGudang($id, $request->all());
            $responseJson = Response::success('Berhasil Menyimpan');
        } catch (Exception $e) {
            $status = 500;
            $responseJson = Response::error($e->getMessage());
        }
        return response()->json($responseJson, $status);
    }

    public function getLastCode()
    {
        $responseJson = [];
        $status = 200;
        try {
            $uniqeCode = (new UniqueCode(Gudang::class, 'kode_gudang', 'GD-', 4))->get();
            $responseJson = Response::success($uniqeCode);
        } catch (Exception $e) {
            $status = 500;
            $responseJson = Response::error($e->getMessage());
        }
        return response()->json($responseJson, $status);
    }
}
