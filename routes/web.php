<?php

use App\Http\Controllers\{
    DashboardController,
    GudangController,
    KategoriController,
    LaporanController,
    LaporanLabaProductController,
    ProdukController,
    MemberController,
    PengeluaranController,
    PembelianController,
    PembelianDetailController,
    PenjualanController,
    PenjualanDetailController,
    SettingController,
    StokKeluarController,
    StokMasukController,
    StokOpnameController,
    SupplierController,
    UserController,
};
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::group(['middleware' => 'level:1'], function () {
        Route::get('/kategori/data', [KategoriController::class, 'data'])->name('kategori.data');
        Route::resource('/kategori', KategoriController::class);

        Route::get('/produk/data', [ProdukController::class, 'data'])->name('produk.data');
        Route::post('/produk/delete-selected', [ProdukController::class, 'deleteSelected'])->name('produk.delete_selected');
        Route::post('/produk/cetak-barcode', [ProdukController::class, 'cetakBarcode'])->name('produk.cetak_barcode');
        Route::resource('/produk', ProdukController::class);

        Route::get('/member/data', [MemberController::class, 'data'])->name('member.data');
        Route::post('/member/cetak-member', [MemberController::class, 'cetakMember'])->name('member.cetak_member');
        Route::resource('/member', MemberController::class);

        Route::get('/supplier/data', [SupplierController::class, 'data'])->name('supplier.data');
        Route::resource('/supplier', SupplierController::class);

        Route::get('/pengeluaran/data', [PengeluaranController::class, 'data'])->name('pengeluaran.data');
        Route::resource('/pengeluaran', PengeluaranController::class);

        Route::get('/pembelian/data', [PembelianController::class, 'data'])->name('pembelian.data');
        Route::get('/pembelian/{id}/create', [PembelianController::class, 'create'])->name('pembelian.create');
        Route::resource('/pembelian', PembelianController::class)
            ->except('create');

        Route::get('/pembelian_detail/{id}/data', [PembelianDetailController::class, 'data'])->name('pembelian_detail.data');
        Route::get('/pembelian_detail/loadform/{diskon}/{total}', [PembelianDetailController::class, 'loadForm'])->name('pembelian_detail.load_form');
        Route::resource('/pembelian_detail', PembelianDetailController::class)
            ->except('create', 'show', 'edit');
        Route::post('/pembelian_detail/store', [PembelianDetailController::class, 'store'])->name('pembelian_detail.store');
        Route::get('/pembelian_detail', [PembelianDetailController::class, 'index'])->name('pembelian_detail.index');

        Route::get('/pembelian_detail/price-adjustment', [PembelianDetailController::class, 'getDataProductAdj'])->name('transaksi.price_adjustment');
        Route::post('/pembelian_detail/store-adjustment', [PembelianDetailController::class, 'storeAdjustment'])->name('transaksi.price_adjustment');

        Route::get('/penjualan/data', [PenjualanController::class, 'data'])->name('penjualan.data');
        Route::get('/penjualan', [PenjualanController::class, 'index'])->name('penjualan.index');
        Route::get('/penjualan/{id}', [PenjualanController::class, 'show'])->name('penjualan.show');
        Route::delete('/penjualan/{id}', [PenjualanController::class, 'destroy'])->name('penjualan.destroy');
    });

    Route::group(['middleware' => 'level:1,2'], function () {
        Route::get('/transaksi/baru', [PenjualanController::class, 'create'])->name('transaksi.baru');
        Route::get('/transaksi/selesai', [PenjualanController::class, 'selesai'])->name('transaksi.selesai');
        Route::get('/transaksi/nota-kecil', [PenjualanController::class, 'notaKecil'])->name('transaksi.nota_kecil');
        Route::get('/transaksi/nota-besar', [PenjualanController::class, 'notaBesar'])->name('transaksi.nota_besar');

        Route::get('/transaksi/{id}/data', [PenjualanDetailController::class, 'data'])->name('transaksi.data');
        Route::get('/transaksi/loadform/{diskon}/{total}/{diterima}', [PenjualanDetailController::class, 'loadForm'])->name('transaksi.load_form');
        Route::resource('/transaksi', PenjualanDetailController::class)
            ->except('create', 'show', 'edit');
        
        Route::get('transaksi/get-product', [PenjualanDetailController::class, 'getDataProduct'])->name('transaksi.autocomplete-product');
        Route::post('transaksi/simpan', [PenjualanDetailController::class, 'store'])->name('transaksi.simpan');

        // search member
        Route::get('transaksi/get-member', [MemberController::class, 'searchMember'])->name('transaksi.autocomplete-member');
    });

    Route::group(['middleware' => 'level:1'], function () {
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/data/{awal}/{akhir}', [LaporanController::class, 'data'])->name('laporan.data');
        Route::get('/laporan/pdf/{awal}/{akhir}', [LaporanController::class, 'exportPDF'])->name('laporan.export_pdf');

        Route::get('/laporan-laba-produk', [LaporanLabaProductController::class, 'index'])->name('laporan_laba_produk.index');
        Route::get('/laporan-laba-produk/data', [LaporanLabaProductController::class, 'getData'])->name('laporan_laba_produk.data');
        Route::get('/laporan-laba-produk/export-pdf/{tglAwal}/{tglAkhir}', [LaporanLabaProductController::class, 'exportPDF'])->name('laporan_laba_produk.export_pdf');

        Route::get('/user/data', [UserController::class, 'data'])->name('user.data');
        Route::resource('/user', UserController::class);

        Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
        Route::get('/setting/first', [SettingController::class, 'show'])->name('setting.show');
        Route::post('/setting', [SettingController::class, 'update'])->name('setting.update');
    });
 
    Route::group(['middleware' => 'level:1,2'], function () {
        Route::get('/profil', [UserController::class, 'profil'])->name('user.profil');
        Route::post('/profil', [UserController::class, 'updateProfil'])->name('user.update_profil');
    });
    Route::prefix('persediaan')->middleware('level:1')->group(function(){
        Route::prefix('gudang')->group(function(){
            Route::get('/', [GudangController::class, 'index'])->name('gudang.index');
            Route::get('create', [GudangController::class, 'create'])->name('gudang.create');
            Route::get('edit/{id}', [GudangController::class, 'edit'])->name('gudang.edit');
            Route::get('get-data', [GudangController::class, 'getData'])->name('gudang.data');
            Route::post('inactive/{id}', [GudangController::class, 'inActive'])->name('gudang.inactive');
            Route::post('store', [GudangController::class, 'store'])->name('gudang.store');
            Route::post('update/{id}', [GudangController::class, 'update'])->name('gudang.update');
            Route::get('last-code', [GudangController::class, 'getLastCode'])->name('gudang.lastcode');
        }); 

        Route::prefix('stok-masuk')->group(function(){
            Route::get('/', [StokMasukController::class, 'index']);
            Route::get('create', [StokMasukController::class, 'create']);
            Route::get('get-data', [StokMasukController::class, 'getData']);
            Route::get('detail/{id}', [StokMasukController::class, 'showDetail']);
            Route::post('store', [StokMasukController::class, 'store']);
            Route::post('cancel/{id}', [StokMasukController::class, 'cancel']);
        });

        Route::prefix('stok-keluar')->group(function(){
            Route::get('/', [StokKeluarController::class, 'index']);
            Route::get('create', [StokKeluarController::class, 'create']);
            Route::get('get-data', [StokKeluarController::class, 'getData']);
            Route::get('get-product', [StokKeluarController::class, 'getProduct']);
            Route::get('detail/{id}', [StokKeluarController::class, 'showDetail']);
            Route::post('store', [StokKeluarController::class, 'store']);
            Route::post('cancel/{id}', [StokKeluarController::class, 'cancel']);
        });

        Route::prefix('stok-opname')->group(function(){
            Route::get('/', [StokOpnameController::class, 'index']);
            Route::get('create', [StokOpnameController::class, 'create']);
            Route::get('get-data', [StokOpnameController::class, 'getData']);
            Route::get('get-product', [StokOpnameController::class, 'getProduct']);
            Route::post('store', [StokOpnameController::class, 'store']);
            Route::post('cancel/{id}', [StokOpnameController::class, 'cancel']);
            Route::get('detail/{id}', [StokOpnameController::class, 'showDetail']);
        });
    });
    
});