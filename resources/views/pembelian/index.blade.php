@extends('layouts.master')

@section('title')
    Daftar Pembelian
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Daftar Pembelian</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header with-border">
                <button onclick="addForm()" class="btn btn-success btn-sm btn-flat"><i class="fa fa-plus-circle"></i> Transaksi Baru</button>
            </div>
            <div class="card-body">
                <table class="table table-stiped table-sm table-bordered table-pembelian">
                    <thead>
                        <th class="text-center" width="5%">No</th>
                        <th>Tanggal</th>
                        <th>Supplier</th>
                        <th class="text-end">Total Item</th>
                        <th class="text-end">Total Harga</th>
                        <th class="text-end">Diskon</th>
                        <th class="text-end">Total Bayar</th>
                        <th class="text-center"><i class="fa fa-cog"></i></th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@includeIf('pembelian.supplier')
@includeIf('pembelian.detail')
@endsection

@push('scripts')
<script>
    let table, table1;

    $(function () {
        table = $('.table-pembelian').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('pembelian.data') }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false, className: 'text-center'},
                {data: 'tanggal'},
                {data: 'supplier'},
                {data: 'total_item', className: 'text-end'},
                {data: 'total_harga', className: 'text-end'},
                {data: 'diskon', className: 'text-end'},
                {data: 'bayar', className: 'text-end'},
                {data: 'aksi', searchable: false, sortable: false, className: 'text-center'},
            ]
        });

        $('.table-supplier').DataTable();
        table1 = $('.table-detail').DataTable({
            processing: true,
            bSort: false,
            dom: 'Brt',
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'kode_produk'},
                {data: 'nama_produk'},
                {data: 'harga_beli', className: 'text-end'},
                {data: 'jumlah', className: 'text-end'},
                {data: 'subtotal', className: 'text-end'},
            ]
        })
    });

    function addForm() {
        $('#modal-supplier').modal('show');
    }

    function showDetail(url) {
        $('#modal-detail').modal('show');

        table1.ajax.url(url);
        table1.ajax.reload();
    }

    function deleteData(url) {
        if (confirm('Yakin ingin menghapus data terpilih?')) {
            $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    table.ajax.reload();
                })
                .fail((errors) => {
                    alert('Tidak dapat menghapus data');
                    return;
                });
        }
    }
</script>
@endpush