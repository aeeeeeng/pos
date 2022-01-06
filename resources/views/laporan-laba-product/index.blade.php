@extends('layouts.master')

@section('title')
    Laporan Penjualan Produk
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('/AdminLTE-2/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<style>
    .red-row {
        background-color: red;
        color:#fff;
    }
    .yellow-row {
        background-color: rgb(245, 245, 136);
    }
    .table {
        thead tr:nth-child(1) th{
            background: white;
            position: sticky;
            top: 0;
            z-index: 10;
        }
    }
    .table {
        position: sticky;
        top: 0;
        z-index: 10;
    }
    .box-body {
        max-height: 500px;
        overflow: auto;
    }

    #tableLaporan thead tr {
        position: sticky;
        top: -11px;
        background-color: #fff;
    }
    .filter-label {    
        font-size: 15px;
        margin-left: 10px;
        font-weight: 600;
    }
</style>
@endpush

@section('breadcrumb')
    @parent
    <li class="active">Laporan Penjualan Produk</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                <button onclick="updatePeriode()" class="btn btn-info btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Ubah Periode</button>
                <a href="#" target="_blank" onclick="exportPdf(this)" class="btn btn-success btn-xs btn-flat"><i class="fa fa-file-excel-o"></i> Export PDF</a>
                <span class="filter-label"></span>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-stiped table-bordered" id="tableLaporan">
                    <thead>
                        <tr class="bg-gray">
                            <th>Nama Produk</th>
                            <th class="text-right">Diskon</th>
                            <th class="text-right">Harga Jual</th>
                            <th class="text-right">Harga Beli</th>
                            <th class="text-right">Jumlah Penjualan</th>
                            <th class="text-right">Sub Total Harga Jual</th>
                            <th class="text-right">Sub Total Harga Beli</th>
                            <th class="text-right">Laba Bersih</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@includeIf('laporan-laba-product.form')
@endsection

@push('scripts')
<script src="{{ asset('/AdminLTE-2/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script>

    let tglAwal = `{{$tglAwal}}`;
    let tglAkhir = `{{$tglAkhir}}`;

    $(document).ready(function(){
        getData();
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
        renderFilterLebel();
    });

    function getData()
    {
        $.ajax({
            url: `{{url('laporan-laba-produk/data')}}`,
            data:{tglAwal, tglAkhir},
            beforeSend: () => {
                blockLoading();
            }
        }).done(response => {
            console.log(response);

            const table = $("#tableLaporan");

            let html = '';
            let header = '';
            let row = '';

            response.data.row.map(item => {
                row += `<tr class="bg-gray">
                    <th colspan="4">${tglIndonesia(item.tanggal)} ${item.allLabaBersih == 0 ? '<span class="text-red"> (TIDAK ADA TRANSAKSI) </span>' : ''}</th>
                    <th class="text-right">${item.allJumlah}</th>
                    <th class="text-right">Rp. ${formatMoney(item.allSubtotalJual)}</th>
                    <th class="text-right">Rp. ${formatMoney(item.allSubtotalBeli)}</th>
                    <th class="text-right">Rp. ${formatMoney(item.allLabaBersih)}</th>
                </tr>`;
                item.details.map(detail => {
                    if(item.allLabaBersih != 0) {
                        row += `
                        <tr ${detail.labaBersih == 0 ? `class="yellow-row"` : ''}>
                            <td class="text-left">${detail.nama_produk}</td>
                            <td class="text-right">${detail.diskon}</td>
                            <td class="text-right">Rp. ${formatMoney(detail.harga_jual)}</td>
                            <td class="text-right">Rp. ${formatMoney(detail.harga_beli)}</td>
                            <td class="text-right">${detail.jumlahPenjualan}</td>
                            <td class="text-right">Rp. ${formatMoney(detail.totalSubtotalJual)}</td>
                            <td class="text-right">Rp. ${formatMoney(detail.totalSubtotalBeli)}</td>
                            <td class="text-right">Rp. ${formatMoney(detail.labaBersih)}</td>
                        </tr>
                        `;
                    }
                });
            });

            row += `<tr class="bg-gray">
                <th colspan="4">TOTAL SEMUA</th>
                <th class="text-right">${response.data.finalJumlah}</th>
                <th class="text-right">Rp. ${formatMoney(response.data.finalSubTotalJual)}</th>
                <th class="text-right">Rp. ${formatMoney(response.data.finalSubTotalBeli)}</th>
                <th class="text-right">Rp. ${formatMoney(response.data.finalBersih)}</th>
            </tr>`;

            table.find('tbody').html(row);

            unBlockLoading();
        }).fail(error => {
            const respJson = $.parseJSON(error.responseText);
            showErrorAlert(respJson.message);
            unBlockLoading();
        });
    }

    function updatePeriode() {
        $('#modal-form').modal('show');
    }

    function updateTglAwal(that)
    {
        tglAwal = $(that).val();
    }

    function updateTglAkhir(that)
    {
        tglAkhir = $(that).val();
    }

    function refresh()
    {
        $('#modal-form').modal('hide');
        getData();
        renderFilterLebel();
    }

    function renderFilterLebel()
    {
        const label = `Filter Tanggal : ${tglIndonesia(tglAwal)} - ${tglIndonesia(tglAkhir)}`;
        $(".filter-label").text(label);
    }

    function exportPdf(that)
    {
        const url = `{{url('laporan-laba-produk/export-pdf')}}/${tglAwal}/${tglAkhir}`;
        window.open(url, '_blank');
    }
    
</script>
@endpush