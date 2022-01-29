<?php

namespace App\Http\Controllers;

use App\Library\Response;
use App\Library\UniqueCode;
use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Produk;
use App\Models\StokProduk;
use App\Models\Supplier;
use Exception;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PembelianController extends Controller
{
    public function index()
    {
        $supplier = Supplier::orderBy('nama')->where('status', '1')->get();
        $outlet = DB::table('outlet')->get();
        $status = config('app.status_pembelian');
        return view('pembelian.index', compact('supplier', 'outlet', 'status'));
    }

    public function data(Request $request)
    {
        $status = 200;
        $responseJson = [];
        try {
            $pembelian = Pembelian::getData($request->all(), 'datatable');
            $datatables = DataTables::of($pembelian);
            $responseJson = $datatables->make(true)->original;
        } catch (Exception $e) {
            $status = 500;
            $responseJson = Response::error($e->getMessage());
        }
        return response()->json($responseJson, $status);
    }

    public function updateStatus(Request $request)
    {
        $id = $request->get('id');
        $jenis = $request->get('jenis');
        $header = DB::table('pembelian as pem')
                   ->leftJoin('outlet as o', 'pem.id_outlet', '=', 'o.id_outlet')
                   ->leftJoin('supplier as s', 's.id_supplier', '=', 'pem.id_supplier')
                   ->selectRaw("pem.id_pembelian, pem.kode_pembelian, pem.no_pembelian,
                                o.nama_outlet, s.nama as nama_supplier,
                                DATE_FORMAT(pem.tanggal_pembelian,'%d/%m/%Y') as tanggal_pembelian,
                                pem.total_harga,
                                pem.catatan")
                    ->where('pem.id_pembelian', $id)->first();
        $details = DB::table('pembelian_detail as pd')
                   ->leftJoin('produk as p', 'pd.id_produk', '=', 'p.id_produk')
                   ->leftJoin('uom as u', 'u.id_uom', '=', 'p.id_uom')
                   ->selectRaw('pd.id_pembelian_detail, p.nama_produk, pd.jumlah, u.nama_uom,
                    pd.harga_beli, pd.subtotal')
                   ->where('pd.id_pembelian', $id)->get();
        return view('pembelian.konfirmasi-status', compact('id', 'jenis', 'header', 'details'));
    }

    public function storeStatus(Request $request)
    {
        $id = $request->post('id');
        $jenis = $request->post('jenis');

        $status = 200;
        $responseJson = [];

        DB::beginTransaction();
        try {
            $resultText = '';
            if($jenis == 'terima') {
                $header = DB::table('pembelian')->selectRaw('id_outlet')->where('id_pembelian', $id)->first();
                $details = DB::table('pembelian_detail')->where('id_pembelian', $id)
                           ->selectRaw("id_produk, jumlah, harga_beli, subtotal")->get();
                self::storeStock($header, $details);
                DB::table('pembelian')->where('id_pembelian', $id)->update(['status' => 'DONE', 'updated_at' => date('Y-m-d H:i:s'), 'updated_by' => auth()->user()->name ]);
                $resultText = 'Berhasil menyimpan penerimaan & stok berhasil disimpan';
            } elseif($jenis) {
                DB::table('pembelian')->where('id_pembelian', $id)->update(['status' => 'CANCEL', 'updated_at' => date('Y-m-d H:i:s'), 'updated_by' => auth()->user()->name ]);
                DB::table('pembelian_detail')->where('id_pembelian', $id)->update(['jumlah' => 0]);
                $resultText = 'Berhasil membatalkan';
            } else {
                throw new Exception("Tidak ditemukan paramter simpan");
            }
            $responseJson = Response::success($resultText);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $status = 500;
            $responseJson = Response::error($e->getMessage());
        }
        return response()->json($responseJson, $status);
    }

    private static function storeStock($header, $details)
    {

        try {
            $stokProduk = [];
            $stokProduk['id_outlet'] = $header->id_outlet;
            $stokProduk['tanggal'] = date("Y-m-d");
            $stokProduk['jenis'] = 'PEMBELIAN';
            $stokProduk['reference'] = 'STOKPEMBELIAN';
            $stokProduk['kode'] = (new UniqueCode(StokProduk::class, 'kode', 'ST-B-', 9))->get();;
            $stokProduk['created_at'] = date("Y-m-d H:i:s");
            $stokProduk['created_by'] = auth()->user()->name;
            $id_reference = DB::table('stok_produk')->insertGetId($stokProduk);
            $stokProdukDetail = [];
            foreach ($details as $item) {
                $detail = [];
                $detail['id_produk'] = $item->id_produk;
                $detail['nilai'] = $item->jumlah;
                $detail['harga'] = $item->harga_beli;
                $detail['sub_total'] = $item->subtotal;
                $detail['jenis'] = 'MASUK';
                $detail['sumber'] = 'stok_produk';
                $detail['id_reference'] = $id_reference;
                $detail['kode_reference'] = $stokProduk['kode'];
                $stokProdukDetail[] = $detail;
            }
            DB::table('stok_produk_detail')->insert($stokProdukDetail);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function create($id)
    {
        // $pembelian = new Pembelian();
        // $pembelian->id_supplier = $id;
        // $pembelian->total_item  = 0;
        // $pembelian->total_harga = 0;
        // $pembelian->diskon      = 0;
        // $pembelian->bayar       = 0;
        // $pembelian->save();

        // session(['id_pembelian' => $pembelian->id_pembelian]);
        // session(['id_supplier' => $pembelian->id_supplier]);

        // return redirect()->route('pembelian_detail.index');
    }

    public function store(Request $request)
    {
        $pembelian = Pembelian::findOrFail($request->id_pembelian);
        $pembelian->total_item = $request->total_item;
        $pembelian->total_harga = $request->total;
        $pembelian->diskon = $request->diskon;
        $pembelian->bayar = $request->bayar;
        $pembelian->update();

        $detail = PembelianDetail::where('id_pembelian', $pembelian->id_pembelian)->get();
        foreach ($detail as $item) {
            $produk = Produk::find($item->id_produk);
            $produk->stok += $item->jumlah;
            $produk->update();
        }

        return redirect()->route('pembelian.index');
    }

    public function show($id)
    {
        $detail = PembelianDetail::with('produk')->where('id_pembelian', $id)->get();

        return datatables()
            ->of($detail)
            ->addIndexColumn()
            ->addColumn('kode_produk', function ($detail) {
                return '<span class="label label-success">'. $detail->produk->kode_produk .'</span>';
            })
            ->addColumn('nama_produk', function ($detail) {
                return $detail->produk->nama_produk;
            })
            ->addColumn('harga_beli', function ($detail) {
                return 'Rp. '. format_uang($detail->harga_beli);
            })
            ->addColumn('jumlah', function ($detail) {
                return format_uang($detail->jumlah);
            })
            ->addColumn('subtotal', function ($detail) {
                return 'Rp. '. format_uang($detail->subtotal);
            })
            ->rawColumns(['kode_produk'])
            ->make(true);
    }

    public function destroy($id)
    {
        $pembelian = Pembelian::find($id);
        $detail    = PembelianDetail::where('id_pembelian', $pembelian->id_pembelian)->get();
        foreach ($detail as $item) {
            $produk = Produk::find($item->id_produk);
            if ($produk) {
                $produk->stok -= $item->jumlah;
                $produk->update();
            }
            $item->delete();
        }

        $pembelian->delete();

        return response(null, 204);
    }
}
