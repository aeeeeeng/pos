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
    .card-body {
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
    <li class="breadcrumb-item active">Laporan Penjualan Produk</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header with-border">
                <button onclick="updatePeriode()" class="btn btn-info btn-sm btn-flat"><i class="fa fa-plus-circle"></i> Ubah Periode</button>
                <a href="#" target="_blank" onclick="exportPdf(this)" class="btn btn-success btn-sm btn-flat"><i class="fa fa-file-excel-o"></i> Export PDF</a>
                <span class="filter-label"></span>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-sm table-stiped table-bordered" id="tableLaporan">
                    <thead>
                        <tr class="bg-primary">
                            <th>Jam</th>
                            <th>Nama Produk</th>
                            <th class="text-end">Diskon</th>
                            <th class="text-end">Harga Jual</th>
                            <th class="text-end">Harga Beli</th>
                            <th class="text-end">Jumlah Penjualan</th>
                            <th class="text-end">Sub Total Harga Jual</th>
                            <th class="text-end">Sub Total Harga Beli</th>
                            <th class="text-end">Laba Bersih</th>
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
                row += `<tr class="bg-light">
                    <th colspan="5">${tglIndonesia(item.tanggal)} ${item.allLabaBersih == 0 ? '<span class="text-danger"> (TIDAK ADA TRANSAKSI) </span>' : ''}</th>
                    <th class="text-end">${item.allJumlah}</th>
                    <th class="text-end">Rp. ${formatMoney(item.allSubtotalJual)}</th>
                    <th class="text-end">Rp. ${formatMoney(item.allSubtotalBeli)}</th>
                    <th class="text-end">Rp. ${formatMoney(item.allLabaBersih)}</th>
                </tr>`;
                item.details.map(detail => {
                    if(item.allLabaBersih != 0) {
                        row += `
                        <tr ${detail.labaBersih == 0 ? `class="yellow-row"` : ''}>
                            <td class="text-left text-nowrap">${detail.jam_penjualan}</td>
                            <td class="text-left text-nowrap">${detail.nama_produk}</td>
                            <td class="text-end text-nowrap">${detail.diskon}</td>
                            <td class="text-end text-nowrap">Rp. ${formatMoney(detail.harga_jual)}</td>
                            <td class="text-end text-nowrap">Rp. ${formatMoney(detail.harga_beli)}</td>
                            <td class="text-end text-nowrap">${detail.jumlahPenjualan}</td>
                            <td class="text-end text-nowrap">Rp. ${formatMoney(detail.totalSubtotalJual)}</td>
                            <td class="text-end text-nowrap">Rp. ${formatMoney(detail.totalSubtotalBeli)}</td>
                            <td class="text-end text-nowrap">Rp. ${formatMoney(detail.labaBersih)}</td>
                        </tr>
                        `;
                    }
                });
            });

            row += `<tr class="bg-light">
                <th colspan="5">TOTAL SEMUA</th>
                <th class="text-end">${response.data.finalJumlah}</th>
                <th class="text-end">Rp. ${formatMoney(response.data.finalSubTotalJual)}</th>
                <th class="text-end">Rp. ${formatMoney(response.data.finalSubTotalBeli)}</th>
                <th class="text-end">Rp. ${formatMoney(response.data.finalBersih)}</th>
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
