<?php

namespace App\Http\Controllers;

use App\Library\Response;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Models\Produk;
use Exception;
use Illuminate\Support\Facades\DB;
use PDF;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori = Kategori::all()->pluck('nama_kategori', 'id_kategori');

        return view('produk.index', compact('kategori'));
    }

    public function data()
    {
        $produk = DB::table('produk as p')->leftJoin('kategori as k', 'k.id_kategori', '=', 'p.id_kategori')
                ->leftJoin('stok_produk_detail as spd', 'spd.id_produk', 'p.id_produk')
                ->selectRaw("
                    p.id_produk,
                    p.nama_produk,
                    k.nama_kategori,
                    p.merk,
                    p.kode_produk,
                    p.diskon,
                    IFNULL(sum(sub_total) / sum(nilai),0) as hpp,
                    p.harga_jual,
                    IFNULL(sum(spd.nilai),0) as stok
                ")
                ->groupBy('p.id_produk', 'p.nama_produk', 'k.nama_kategori', 'p.merk', 'p.kode_produk', 'p.diskon', 'p.harga_jual')
                ->get();


        return datatables()
            ->of($produk)
            ->addIndexColumn()
            ->addColumn('select_all', function ($produk) {
                return '
                    <input type="checkbox" name="id_produk[]" value="'. $produk->id_produk .'">
                ';
            })
            ->addColumn('kode_produk', function ($produk) {
                return '<span class="label label-success">'. $produk->kode_produk .'</span>';
            })
            ->addColumn('harga_beli', function ($produk) {
                return format_uang($produk->hpp);
            })
            ->addColumn('harga_jual', function ($produk) {
                return format_uang($produk->harga_jual);
            })
            ->addColumn('stok', function ($produk) {
                return format_uang($produk->stok);
            })
            ->addColumn('aksi', function ($produk) {
                return '
                <div class="d-flex flex-wrap gap-1 align-items-center">
                    <button type="button" onclick="editForm(`'. route('produk.update', $produk->id_produk) .'`)" class="btn btn-sm btn-info btn-flat"><i class="fa fa-wrench"></i></button>
                    <button type="button" onclick="deleteData(`'. route('produk.destroy', $produk->id_produk) .'`)" class="btn btn-sm btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'kode_produk', 'select_all'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategori = json_encode(Kategori::selectRaw("id_kategori as id, nama_kategori as text")->get());
        return view('produk.create', compact('kategori'));
    }

    public function storeAddOpt(Request $request)
    {
        $status = 200;
        $responseJson = [];
        DB::beginTransaction();
        try {
            $payloads = $request->all()['opsiTambahan'];
            $header['nama_add_opt'] = $payloads['group'];
            $header['punya_bahan_baku'] = $payloads['punya_bahan_baku'];
            $header['created_at'] = date("Y-m-d H:i:s");
            $header['created_by'] = auth()->user()->name;
            $idAddOpt = DB::table('add_opt')->insertGetId($header);

            $details = [];
            foreach ($payloads['detail'] as $item) {
                $detail['id_add_opt'] = $idAddOpt;
                $detail['nama_add_opt_detail'] = $item['nama'];
                $detail['harga_add_opt_detail'] = $item['harga'];
                $details[] = $detail;
            }
            DB::table('add_opt_detail')->insert($details);
            $responseJson = Response::success('berhasil menambahkan tambahan optional');
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $status = 500;
            $responseJson = Response::error($e->getMessage());
        }
        return response()->json($responseJson, $status);
    }

    public function listDataAddOpt()
    {
        $headers = DB::table('add_opt')->get();
        foreach ($headers as $header) {
            $header->detail = DB::table('add_opt_detail')->where('id_add_opt', $header->id_add_opt)->get();
        }
        return response()->json(Response::success('oke', $headers));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $produk = Produk::latest()->first() ?? new Produk();
        $request['kode_produk'] = 'P'. tambah_nol_didepan((int)$produk->id_produk +1, 6);

        $produk = Produk::create($request->all());

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produk = Produk::find($id);

        return response()->json($produk);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $produk = Produk::find($id);
        $produk->update($request->all());

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produk = Produk::find($id);
        $produk->delete();

        return response(null, 204);
    }

    public function deleteSelected(Request $request)
    {
        foreach ($request->id_produk as $id) {
            $produk = Produk::find($id);
            $produk->delete();
        }

        return response(null, 204);
    }

    public function cetakBarcode(Request $request)
    {
        $dataproduk = array();
        foreach ($request->id_produk as $id) {
            $produk = Produk::find($id);
            $dataproduk[] = $produk;
        }

        $no  = 1;
        $pdf = PDF::loadView('produk.barcode', compact('dataproduk', 'no'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('produk.pdf');
    }
}
