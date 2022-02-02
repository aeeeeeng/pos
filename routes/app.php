<?php

use App\Http\Controllers\app\AppDashboardController;
use App\Http\Controllers\app\TransaksiJualController;
use Illuminate\Support\Facades\Route;

    Route::get('/', function () {
        return redirect()->route('login');
    });

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/dashboard', [AppDashboardController::class, 'index']);
    });

    Route::prefix('transaksi-jual')->middleware('level:1,2')->group(function(){
        Route::get('/', [TransaksiJualController::class, 'index']);
        Route::get('get-data-produk', [TransaksiJualController::class, 'getDataProduk']);
    });