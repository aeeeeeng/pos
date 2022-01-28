<?php

namespace App\Http\Controllers;

use App\Library\Response;
use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Models\Produk;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PDF;
use stdClass;
use Yajra\DataTables\Facades\DataTables;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataKategori = Kategori::selectRaw("id_kategori as id, nama_kategori as text");
        $dataOutlet = DB::table('outlet')->selectRaw("id_outlet as id, nama_outlet as text");
        $dataAddOpt = DB::table('add_opt');
        $dataProduk = DB::table('produk')->where('status', '1');

        $kategori = $dataKategori->get();
        $outlet = $dataOutlet->get();

        $totalKategori = $dataKategori->where('id_outlet', session()->get('outlet'))->count();
        $totalAddOpt = $dataAddOpt->where('id_outlet', session()->get('outlet'))->count();
        $totalProduk = $dataProduk->where('id_outlet', session()->get('outlet'))->count();

        return view('produk.index', compact('kategori', 'outlet', 'totalKategori', 'totalAddOpt', 'totalProduk'));
    }

    public function data(Request $request)
    {
        $status = 200;
        $responseJson = [];
        try {
            $produk = Produk::getProdukList($request->all(), 'datatable');
            $datatables = DataTables::of($produk);
            $datatables->addColumn('imageText', function($query) {
                $arrProdukName = explode(" ", $query->nama_produk);
                if(count($arrProdukName) > 1) {
                    return substr($arrProdukName[0], 0, 1) . '' . substr($arrProdukName[1], 0, 1);
                }
                return substr($arrProdukName[0], 0, 1);

            });
            $responseJson = $datatables->make(true)->original;
        } catch (Exception $e) {
            $status - 500;
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
        $kategori = json_encode(Kategori::selectRaw("nama_kategori as id, nama_kategori as text")->get());
        $uom = json_encode(DB::table('uom')->selectRaw('nama_uom as id, nama_uom as text')->get());
        return view('produk.create', compact('kategori', 'uom'));
    }

    public function storeAddOpt(Request $request)
    {
        $status = 200;
        $responseJson = [];
        DB::beginTransaction();
        try {
            $payloads = $request->all()['opsiTambahan'];
            $header['id_outlet'] = session()->get('outlet');
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
        $status = 200;
        $responseJson = [];

        $validate = Validator::make($request->all(), Produk::$storeRule);
        if($validate->fails()) {
            $responseJson = Response::error($validate->errors());
            return response()->json($responseJson, 400);
        }
        DB::beginTransaction();
        try {
            $gambar = '';
            if($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $name = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('img/produk-image');
                $file->move($destinationPath, $name);
                $gambar = $name;
            }
            $payloads = $request->all();
            $payloads['gambar'] = $gambar;
            Produk::storeProduk($payloads);
            $responseJson = Response::success('Berhasil menambahkan produk');
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
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
        $status = 200;
        $responseJson = [];
        try {
            $produk = DB::table('produk as p')
                      ->leftJoin('uom as u', 'p.id_uom', '=', 'u.id_uom')
                      ->leftJoin('kategori as k', 'p.id_kategori', '=', 'k.id_kategori')
                      ->selectRaw('p.*, u.nama_uom, k.nama_kategori')
                      ->where('p.id_produk', $id)
                      ->first();
            $produkAddOpt = DB::table('produk_additional')->where('id_produk', $id)->get();
            $responseJson = Response::success('ok', compact('produk', 'produkAddOpt'));
        } catch (Exception $e) {
            $status = 500;
            $responseJson = Response::error($e->getMessage());
        }
        return response()->json($responseJson, $status);
    }

    public function selectProdukTunggal(Request $request)
    {
        $q = $request->get('q');
        $outlet = $request->get('outlet');
        $notIn = $request->get('notIn');
        $produk = DB::table('produk as p')->leftJoin('uom as u', 'u.id_uom', '=', 'p.id_uom')
                  ->selectRaw('p.id_produk as id, p.nama_produk as text, u.nama_uom, p.*')
                  ->where('p.tipe', 'tunggal')->where('p.id_outlet', $outlet)->where('p.status', '1')
                  ->whereNotIn('p.id_produk', $notIn)
                  ->where(function($query) use($q) {
                    $query->where('p.nama_produk', 'like', '%' . $q . '%');
                    $query->orWhere('p.sku_produk', 'like', '%' . $q . '%');
                    $query->orWhere('p.barcode_produk', 'like', '%' . $q . '%');
                  });
        $result['incomplete_results'] = true;
        $result['total_count'] = $produk->count();
        $result['items'] = $produk->get();
        return response()->json($result);
    }

    public function storeKomposit($id, Request $request)
    {
        $status = 200;
        $responseJson = [];
        DB::beginTransaction();
        try {
            Produk::storeKompositProduk($id, $request->all());
            $responseJson = Response::success('Berhasil menyimpan bahan baku');
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            $status = 500;
            $responseJson = Response::error($e->getMessage());
        }
        return response()->json($responseJson, $status);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kategori = json_encode(Kategori::selectRaw("nama_kategori as id, nama_kategori as text")->get());
        $uom = json_encode(DB::table('uom')->selectRaw('nama_uom as id, nama_uom as text')->get());
        return view('produk.edit', compact('kategori', 'uom', 'id'));
    }

    public function kelolaBahanBaku($id)
    {
        $produk = DB::table('produk as p')->where('id_produk', $id)->leftJoin('uom as u', 'p.id_uom', '=', 'u.id_uom')
                  ->selectRaw('p.*, u.nama_uom')
                  ->first();
        $details = DB::table('produk_komposit as pk')->where('pk.id_produk_master', $id)
                   ->selectRaw('p.id_produk, p.nama_produk, pk.jumlah_komposit as jumlah, u.nama_uom')
                   ->join('produk as p', function($join){
                       $join->on('p.id_produk', '=', 'pk.id_produk_detail');
                       $join->where('p.status', '1');
                   })
                   ->leftJoin('uom as u', 'p.id_uom', '=', 'u.id_uom')
                   ->get();
        $jsonDetails = json_encode($details);
        return view('produk.form-kelola-bahan-baku', compact('produk', 'jsonDetails'));
    }

    public function kelolaStok($id)
    {
        $produk = DB::table('produk as p')->where('id_produk', $id)->leftJoin('uom as u', 'p.id_uom', '=', 'u.id_uom')
                  ->selectRaw('p.*, u.nama_uom')
                  ->first();
        return view('produk.kelola-stok', compact('produk'));
    }

    public function storeKelolaStok($id, Request $request)
    {
        $status = 200;
        $responseJson = [];
        $payloads = $request->all();

        DB::beginTransaction();
        try {
            Produk::storeKelolaStokProduk($id, $payloads);
            $responseJson = Response::success('Berhasil Mengubah Kelola Stok');
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            $status = 500;
            $responseJson = Response::error($e->getMessage());
        }

        return response()->json($responseJson, $status);
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

        $newRules = Produk::$storeRule;
        $newRules['sku_produk'] = 'required|string|max:100|unique:produk,sku_produk,' . $id . ',id_produk';
        $newRules['barcode_produk'] = 'nullable|string|max:100|unique:produk,barcode_produk,' . $id . ',id_produk';
        $newRules['nama_produk'] = 'required|string|max:100|unique:produk,nama_produk,' . $id . ',id_produk';

        $validate = Validator::make($request->all(), $newRules);
        if($validate->fails()) {
            $responseJson = Response::error($validate->errors());
            return response()->json($responseJson, 400);
        }
        DB::beginTransaction();
        try {
            $gambar = DB::table('produk')->selectRaw('gambar')->where('id_produk', $id)->first()->gambar;
            if($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $name = time() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('img/produk-image');
                $file->move($destinationPath, $name);
                $gambar = $name;
            }
            $payloads = $request->all();
            $payloads['gambar'] = $gambar;
            Produk::updateProduk($payloads, $id);
            $responseJson = Response::success('Berhasil mengubah produk');
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
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
        $status = 200;
        $responseJson = [];
        try {
            DB::table('produk')->where('id_produk', $id)->update(['status' => '0']);
            $responseJson = Response::success('Berhasil menghapus produk');
        } catch (Exception $e) {
            $status = 500;
            $responseJson = Response::error($e->getMessage());
        }
        return response()->json($responseJson, $status);
    }

    public function deleteBulky(Request $request)
    {
        $status = 200;
        $responseJson = [];

        $idProduk = $request->post('idProduk');

        DB::beginTransaction();
        try {
            foreach ($idProduk as $item) {
                DB::table('produk')->where('id_produk', $item)->update(['status' => '0']);
            }
            $responseJson = Response::success('Berhasil Menghapus Produk');
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $status = 500;
            $responseJson = Response::error($e->getMessage());
        }
        return response()->json($responseJson, $status);
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
