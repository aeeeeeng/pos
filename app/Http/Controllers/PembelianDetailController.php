<?php

namespace App\Http\Controllers;

use App\Library\Response;
use App\Library\UniqueCode;
use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Produk;
use App\Models\Setting;
use App\Models\StokProduk;
use App\Models\Supplier;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class PembelianDetailController extends Controller
{
    public function index(Request $request)
    {
        $id_supplier = base64_decode($request->get('data'));
        $supplier = Supplier::find($id_supplier);

        $outlet = DB::table('outlet')->selectRaw("id_outlet as id, nama_outlet as text")->get();

        if (! $supplier) {
            abort(404);
        }

        return view('pembelian_detail.index', compact('supplier', 'outlet'));
    }

    public function getDataProduct(Request $request)
    {
        $q = $request->get('q');
        $id_outlet = $request->get('id_outlet');

        $sql = DB::table('produk as p')->selectRaw('
                                                p.id_produk as id,
                                                p.id_produk,
                                                p.id_kategori,
                                                p.kode_produk, p.nama_produk,
                                                p.merk,
                                                p.harga_jual, p.diskon,
                                                p.created_at, p.updated_at,
                                                u.nama_uom,
                                                IFNULL(round(sum(nilai), 2),0) as stok,
                                                IFNULL(round(sum(sub_total) / sum(nilai),2),0) as hpp')
        ->leftJoin('uom as u', 'u.id_uom', '=', 'p.id_uom')
        ->leftJoin('stok_produk_detail as spd', 'p.id_produk', '=', 'spd.id_produk')
        ->where('p.id_outlet', $id_outlet)
        ->where('p.kelola_stok', '1')
        ->where('p.status', '1')
        ->where(function($query) use($q) {
            $query->where('p.kode_produk', 'like', '%'.strtoupper($q).'%');
            $query->orWhere('p.nama_produk', 'like', '%'.$q.'%');
        })
        ->groupBy('p.id_produk', 'p.id_kategori',
                'p.kode_produk', 'p.nama_produk',
                'p.merk', 'u.nama_uom',
                'p.harga_jual', 'p.diskon', 'p.created_at', 'p.updated_at');

        $result['incomplete_results'] = true;
        $result['total_count'] = $sql->count();
        $result['items'] = $sql->get();
        return response()->json($result);
    }

    public function generateNoPo()
    {
        $status = 200;
        $responseJson = [];
        try {
            $lastNoPo = (new UniqueCode(Pembelian::class, 'no_pembelian', 'NPO-YNTKTS-', 9, true))->get();
            $responseJson = Response::success('OK', compact('lastNoPo'));
        } catch (Exception $e) {
            $status = 500;
            $responseJson = Response::error($e->getMessage());
        }
        return response()->json($responseJson, $status);
    }

    public function data($id)
    {
        $detail = PembelianDetail::with('produk')
            ->where('id_pembelian', $id)
            ->get();
        $data = array();
        $total = 0;
        $total_item = 0;

        foreach ($detail as $item) {
            $row = array();
            $row['kode_produk'] = '<span class="label label-success">'. $item->produk['kode_produk'] .'</span';
            $row['nama_produk'] = $item->produk['nama_produk'];
            $row['harga_beli']  = 'Rp. '. format_uang($item->harga_beli);
            $row['jumlah']      = '<input type="number" class="form-control input-sm quantity" data-id="'. $item->id_pembelian_detail .'" value="'. $item->jumlah .'">';
            $row['subtotal']    = 'Rp. '. format_uang($item->subtotal);
            $row['aksi']        = '<div class="btn-group">
                                    <button onclick="deleteData(`'. route('pembelian_detail.destroy', $item->id_pembelian_detail) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                                </div>';
            $data[] = $row;

            $total += $item->harga_beli * $item->jumlah;
            $total_item += $item->jumlah;
        }
        $data[] = [
            'kode_produk' => '
                <div class="total hide">'. $total .'</div>
                <div class="total_item hide">'. $total_item .'</div>',
            'nama_produk' => '',
            'harga_beli'  => '',
            'jumlah'      => '',
            'subtotal'    => '',
            'aksi'        => '',
        ];

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['aksi', 'kode_produk', 'jumlah'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $status = 200;
        $responseJson = [];

        DB::beginTransaction();
        try {
            $payloads = $request->all();
            $header = [];
            $details = [];
            $resultStok = [];

            $header['id_supplier'] = $payloads['id_supplier'];
            $header['id_outlet'] = $payloads['id_outlet'];
            $header['kode_pembelian'] = (new UniqueCode(Pembelian::class, 'kode_pembelian', 'PO-', 9, true))->get();
            $header['no_pembelian'] = $payloads['no_pembelian'];
            $header['tanggal_pembelian'] = Carbon::createFromFormat('d/m/Y', $payloads['tanggal_pembelian'])->format('Y-m-d');
            $header['total_item'] = count($payloads['dataDetail']);
            $header['total_harga'] = $payloads['grandTotal'];
            $header['catatan'] = $payloads['catatan'];
            $header['status'] = ($payloads['terima'] == true) ? 'DONE' : 'DRAFT';

            $header['created_at'] = date("Y-m-d H:i:s");
            $header['created_by'] = auth()->user()->name;

            $id_pembelian = DB::table('pembelian')->insertGetId($header);
            foreach ($payloads['dataDetail'] as $item) {
                $detail = [];
                $detail['id_pembelian'] = $id_pembelian;
                $detail['id_produk'] = $item['id_produk'];
                $detail['harga_beli'] = $item['harga_beli'];
                $detail['jumlah'] = $item['qty_order'];
                $detail['subtotal'] = $item['subtotal'];
                $detail['created_at'] = date("Y-m-d H:i:s");
                $resultStok[] = [
                    'id_produk' => $item['id_produk'],
                    'kode_produk' => $item['kode_produk'],
                    'nama_produk' => $item['nama_produk'],
                    'stok_tambah' => $item['qty_order'],
                    'stok_lama' => StokProduk::getLastStockProduct($item['id_produk']),
                    'stok_sekarang' => floatval(StokProduk::getLastStockProduct($item['id_produk'])) + floatval($detail['jumlah'])
                ];
                $details[] = $detail;
            }
            DB::table('pembelian_detail')->insert($details);
            if($payloads['terima'] == true) {
                self::storeStock($payloads['id_outlet'], $details);
            }
            $responseJson = Response::success('Berhasil menyimpan transaksi', $resultStok);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $status = 500;
            $responseJson = Response::error($e->getMessage());
        }
        return response()->json($responseJson, $status);
    }

    private static function storeStock($idOutlet, $detail)
    {
        try {
            $stokProduk = [];
            $stokProduk['id_outlet'] = $idOutlet;
            $stokProduk['tanggal'] = date("Y-m-d");
            $stokProduk['jenis'] = 'PEMBELIAN';
            $stokProduk['reference'] = 'STOKPEMBELIAN';
            $stokProduk['kode'] = (new UniqueCode(StokProduk::class, 'kode', 'ST-B-', 9))->get();;
            $stokProduk['created_at'] = date("Y-m-d H:i:s");
            $stokProduk['created_by'] = auth()->user()->name;
            $id_reference = DB::table('stok_produk')->insertGetId($stokProduk);
            $stokProdukDetail = [];
            foreach ($detail as $item) {
                $detail = [];
                $detail['id_produk'] = $item['id_produk'];
                $detail['nilai'] = $item['jumlah'];
                $detail['harga'] = $item['harga_beli'];
                $detail['sub_total'] = $item['subtotal'];
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

    private static function updateStock($idProduct, $qty)
    {
        try {
            DB::table('produk')->where('id_produk', $idProduct)
            ->update([
                'stok' => DB::raw('produk.stok + ' . $qty)
            ]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    private static function getStokLama($idProduct)
    {
        try {
            return DB::table('produk')->selectRaw('stok')->where('id_produk', $idProduct)->first();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }


    public function update(Request $request, $id)
    {
        $detail = PembelianDetail::find($id);
        $detail->jumlah = $request->jumlah;
        $detail->subtotal = $detail->harga_beli * $request->jumlah;
        $detail->update();
    }

    public function destroy($id)
    {
        $detail = PembelianDetail::find($id);
        $detail->delete();

        return response(null, 204);
    }

    public function loadForm($diskon, $total)
    {
        $bayar = $total - ($diskon / 100 * $total);
        $data  = [
            'totalrp' => format_uang($total),
            'bayar' => $bayar,
            'bayarrp' => format_uang($bayar),
            'terbilang' => ucwords(terbilang($bayar). ' Rupiah')
        ];

        return response()->json($data);
    }

    public function getDataProductAdj()
    {
        return view('pembelian/price-adjustment');
    }

    public function storeAdjustment(Request $request)
    {

        $status = 200;
        $responseJson = [];

        DB::beginTransaction();
        try {
            $product = $request->post('productAdj');
            foreach ($product as $item) {
                DB::table('produk')->where('id_produk', $item['id_produk'])
                ->update([
                    'harga_beli' => $item['new_harga_beli'],
                    'harga_jual' => $item['new_harga_jual']
                ]);
            }
            $responseJson = Response::success('Berhasil menyimpan harga terbaru', $request->all());
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            $status = 500;
            $responseJson = Response::error($e->getMessage());
        }
        return response()->json($responseJson, $status);
    }
}
