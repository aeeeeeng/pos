<?php

namespace App\Http\Controllers;

use App\Library\Response;
use App\Library\UniqueCode;
use Illuminate\Http\Request;
use App\Models\Pengeluaran;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PengeluaranController extends Controller
{
    public function index()
    {
        $outlet = DB::table('outlet')->selectRaw("id_outlet as id, nama_outlet as text")->get();
        return view('pengeluaran.index', compact('outlet'));
    }

    public function data(Request $request)
    {
        $payloads = $request->all();
        $pengeluaran = Pengeluaran::orderBy('id_pengeluaran', 'desc')
                       ->where('status', '1');

        if(isset($payloads['search'])) {
            $pengeluaran->where('kode_pengeluaran', 'like', '%' . $payloads['search'] . '%');
            $pengeluaran->orWhere('deskripsi', 'like', '%' . $payloads['search'] . '%');
        }

        if(isset($payloads['dateStart'])) {
            $pengeluaran->whereBetween('tanggal_pengeluaran', [$payloads['dateStart'], $payloads['dateEnd']]);
        }

        if(isset($payloads['id_outlet'])) {
            $pengeluaran->where('id_outlet', $payloads['id_outlet']);
        }

        $pengeluaran->get();

        return datatables()
            ->of($pengeluaran)
            ->addIndexColumn()
            ->addColumn('tanggal_pengeluaran', function ($pengeluaran) {
                return tanggal_indonesia($pengeluaran->tanggal_pengeluaran, false);
            })
            ->addColumn('nominal', function ($pengeluaran) {
                return format_uang($pengeluaran->nominal);
            })
            ->addColumn('aksi', function ($pengeluaran) {
                return '
                <div class="flex-wrap gap-1 align-items-center text-center">
                    <center>
                        <button type="button" onclick="editForm(`'. route('pengeluaran.update', $pengeluaran->id_pengeluaran) .'`)" class="btn btn-sm btn-info btn-flat"><i class="fa fa-wrench"></i></button>
                        <button type="button" onclick="deleteData(`'. route('pengeluaran.destroy', $pengeluaran->id_pengeluaran) .'`)" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                    </center>
                </div>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

        $validate = Validator::make($request->all(), Pengeluaran::$storeRule);
        if($validate->fails()) {
            $responseJson = Response::error($validate->errors());
            return response()->json($responseJson, 400);
        }

        try {
            $payloads = $request->all();
            $payloads['kode_pengeluaran'] = (new UniqueCode(Pengeluaran::class, 'kode_pengeluaran', 'PL-', 9, true))->get();
            $payloads['tanggal_pengeluaran'] = Carbon::createFromFormat('d/m/Y', $payloads['tanggal_pengeluaran'])->format('Y-m-d');
            $payloads['created_at'] = date('Y-m-d H:i:s');
            $payloads['created_by'] = auth()->user()->name;
            unset($payloads['_token']);
            unset($payloads['_method']);
            Pengeluaran::insert($payloads);
            $responseJson = Response::success('Berhasil menambahkan pengeluaran');
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
        $pengeluaran = Pengeluaran::selectRaw("pengeluaran.*, DATE_FORMAT(pengeluaran.tanggal_pengeluaran,'%d/%m/%Y') AS TanggalPengeluaranFormat")->find($id);
        return response()->json($pengeluaran);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

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

        $validate = Validator::make($request->all(), Pengeluaran::$storeRule);
        if($validate->fails()) {
            $responseJson = Response::error($validate->errors());
            return response()->json($responseJson, 400);
        }

        try {
            $payloads = $request->all();
            $payloads['tanggal_pengeluaran'] = Carbon::createFromFormat('d/m/Y', $payloads['tanggal_pengeluaran'])->format('Y-m-d');
            $payloads['updated_at'] = date('Y-m-d H:i:s');
            $payloads['updated_by'] = auth()->user()->name;
            unset($payloads['_token']);
            unset($payloads['_method']);
            DB::table('pengeluaran')->where('id_pengeluaran', $id)->update($payloads);
            $responseJson = Response::success('Berhasil mengubah pengeluaran');
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
        DB::table('pengeluaran')->where('id_pengeluaran', $id)->update(['status' => '0']);
        return response(null, 204);
    }
}
