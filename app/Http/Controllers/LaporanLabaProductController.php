<?php

namespace App\Http\Controllers;

use App\Library\Response;
use Illuminate\Http\Request;
use App\Models\LaporanLabaProduct;
use Exception;
use PDF;

class LaporanLabaProductController extends Controller
{

    public function index()
    {
        $tglAwal = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        $tglAkhir = date('Y-m-d');

        return view('laporan-laba-product.index', compact('tglAwal', 'tglAkhir'));
    }

    public function getData(Request $request)
    {
        $status = 200;
        $responseJson = [];

        $tglAwal = $request->get('tglAwal');
        $tglAkhir = $request->get('tglAkhir');

        try {
            $data = LaporanLabaProduct::queryGetData($tglAwal, $tglAkhir);
            $finalResult = [];
            $resultData = [];
            
            $finalResult['finalJumlah'] = 0;
            $finalResult['finalSubTotalJual'] = 0;
            $finalResult['finalSubTotalBeli'] = 0;
            $finalResult['finalBersih'] = 0;
            foreach ($data->groupBy('tanggalJual') as $i => $item ) {
                $header['tanggal'] = $i;
                $header['allJumlah'] = 0;
                $header['allSubtotalJual'] = 0;
                $header['allSubtotalBeli'] = 0;
                $header['allLabaBersih'] = 0;
                $details = [];
                foreach ($item as $detail) {
                    $details[] = $detail;
                    $header['allJumlah'] += $detail->jumlahPenjualan;
                    $header['allSubtotalJual'] += $detail->totalSubtotalJual;
                    $header['allSubtotalBeli'] += $detail->totalSubtotalBeli;
                    $header['allLabaBersih'] += $detail->labaBersih;
                }
                $header['details'] = $details;

                $finalResult['finalJumlah'] += $header['allJumlah'];
                $finalResult['finalSubTotalJual'] += $header['allSubtotalJual'];
                $finalResult['finalSubTotalBeli'] += $header['allSubtotalBeli'];
                $finalResult['finalBersih'] += $header['allLabaBersih'];

                $resultData[] = $header;
            }
            $finalResult['row'] = $resultData;
            $responseJson = Response::success('berhasil fetch', $finalResult);
        } catch (Exception $e) {
            $status = 500;
            $responseJson = Response::error($e->getMessage());
        }
        return response()->json($responseJson, $status);
    }

    public function exportPDF($tglAwal, $tglAkhir)
    {
        $data = LaporanLabaProduct::queryGetData($tglAwal, $tglAkhir);
        $finalResult = [];
        $resultData = [];
        
        $finalResult['finalJumlah'] = 0;
        $finalResult['finalSubTotalJual'] = 0;
        $finalResult['finalSubTotalBeli'] = 0;
        $finalResult['finalBersih'] = 0;
        foreach ($data->groupBy('tanggalJual') as $i => $item ) {
            $header['tanggal'] = $i;
            $header['allJumlah'] = 0;
            $header['allSubtotalJual'] = 0;
            $header['allSubtotalBeli'] = 0;
            $header['allLabaBersih'] = 0;
            $details = [];
            foreach ($item as $detail) {
                $details[] = $detail;
                $header['allJumlah'] += $detail->jumlahPenjualan;
                $header['allSubtotalJual'] += $detail->totalSubtotalJual;
                $header['allSubtotalBeli'] += $detail->totalSubtotalBeli;
                $header['allLabaBersih'] += $detail->labaBersih;
            }
            $header['details'] = $details;

            $finalResult['finalJumlah'] += $header['allJumlah'];
            $finalResult['finalSubTotalJual'] += $header['allSubtotalJual'];
            $finalResult['finalSubTotalBeli'] += $header['allSubtotalBeli'];
            $finalResult['finalBersih'] += $header['allLabaBersih'];

            $resultData[] = $header;
        }
        $finalResult['row'] = $resultData;

        $data = $finalResult;
        
        $pdf = PDF::loadView('laporan-laba-product.pdf', compact('tglAwal', 'tglAkhir', 'data'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan-penjualan-produk-'. date('Y-m-d-his') .'.pdf');

    }
}
