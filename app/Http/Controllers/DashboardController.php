<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\LaporanLabaProduct;
use App\Models\Member;
use App\Models\Pembelian;
use App\Models\Pengeluaran;
use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');

    }

    public function oldIndex()
    {
        $kategori = Kategori::count();
        $produk = Produk::count();
        $supplier = Supplier::count();
        $member = Member::count();

        $stokMinimal = Setting::first()->min_stok ?? 0;
        $produkStokMinimal = Produk::where('id_produk', '<', $stokMinimal)
                             ->orderBy('id_produk', 'asc')->take(10)->get();

        $tanggal_awal = date('Y-m-01');
        $tanggal_akhir = date('Y-m-d');

        $data_tanggal = array();
        $data_pendapatan = array();

        while (strtotime($tanggal_awal) <= strtotime($tanggal_akhir)) {
            $data_tanggal[] = (int) substr($tanggal_awal, 8, 2);

            $total_penjualan = Penjualan::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('total_harga');
            $total_pembelian = Pembelian::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('total_harga');
            $total_pengeluaran = Pengeluaran::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('nominal');

            $pendapatan = $total_penjualan - $total_pembelian - $total_pengeluaran;
            $data_pendapatan[] += $pendapatan;

            $tanggal_awal = date('Y-m-d', strtotime("+1 day", strtotime($tanggal_awal)));
        }

        $tanggal_awal = date('Y-m-01');

        $laba_penjualan = self::getDataPenjualan($tanggal_awal, $tanggal_akhir);

        $terlaris = self::getDataTerlaris();

        if (auth()->user()->level == 1) {
            return view('admin.dashboard', compact('kategori', 'produk', 'supplier', 'member', 'tanggal_awal', 'tanggal_akhir', 'data_tanggal', 'data_pendapatan', 'produkStokMinimal', 'laba_penjualan', 'terlaris'));
        } else {
            return view('kasir.dashboard');
        }
    }

    private static function getDataPenjualan($tglAwal, $tglAkhir)
    {

        $data = LaporanLabaProduct::queryGetData($tglAwal, $tglAkhir);

        $resultData = [];


        foreach ($data->groupBy('tanggalJual') as $i => $item ) {
            $labaBersih = 0;
            foreach ($item as $detail) {
                $labaBersih += $detail->labaBersih;
            }
            $resultData[] = $labaBersih;
        }

        return $resultData;

    }

    private static function getDataTerlaris()
    {
        $sql = DB::table('produk as p')->join('penjualan_detail as pd', 'p.id_produk', '=', 'pd.id_produk')
              ->selectRaw("p.id_produk, p.nama_produk, sum(jumlah) as terjual")
              ->groupBy('p.id_produk', 'p.nama_produk')
              ->orderBy(DB::raw('sum(jumlah)'), 'DESC')->take(10)->get();
        $labels = [];
        $data = [];
        foreach ($sql as $item) {
            $labels[] = $item->nama_produk;
            $data[] = $item->terjual;
        }
        return ['labels' => $labels, 'data' => $data];
    }
}
