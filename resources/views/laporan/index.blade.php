@extends('layouts.master')

@section('title')
    Laporan Pendapatan {{ tanggal_indonesia($tanggalAwal, false) }} s/d {{ tanggal_indonesia($tanggalAkhir, false) }}
@endsection

@push('css')
<style>
    .red-row {
        background-color: red;
        color:#fff;
    }
    .yellow-row {
        background-color: rgb(245, 245, 136);
    }
</style>
@endpush

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Laporan</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header with-border">
                <button onclick="updatePeriode()" class="btn btn-info btn-sm btn-flat"><i class="fa fa-plus-circle"></i> Ubah Periode</button>
                <a href="{{ route('laporan.export_pdf', [$tanggalAwal, $tanggalAkhir]) }}" target="_blank" class="btn btn-success btn-sm btn-flat"><i class="fa fa-file-excel-o"></i> Export PDF</a>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-sm table-stiped table-bordered">
                    <thead>
                        <th width="5%">No</th>
                        <th>Tanggal</th>
                        <th class="text-end">Penjualan</th>
                        <th class="text-end">Pembelian</th>
                        <th class="text-end">Pengeluaran</th>
                        <th class="text-end">Pendapatan</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@includeIf('laporan.form')
@endsection

@push('scripts')
<script>
    let table;

    $(function () {
        table = $('.table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('laporan.data', [$tanggalAwal, $tanggalAkhir]) }}',
            },
            createdRow: function( row, data, dataIndex ) {
              if(parseFloat(data.pendapatan) < 0) {
                $(row).addClass('red-row');
              }
              if(parseFloat(data.pendapatan) == 0) {
                  $(row).addClass('yellow-row');
              }
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'tanggal'},
                {data: 'penjualan',  className: 'text-end'},
                {data: 'pembelian', className: 'text-end'},
                {data: 'pengeluaran', className: 'text-end'},
                {data: 'pendapatan', className: 'text-end'}
            ],
            dom: 'Brt',
            bSort: false,
            bPaginate: false,
        });

        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });
    });

    function updatePeriode() {
        $('#modal-form').modal('show');
    }
</script>
@endpush
