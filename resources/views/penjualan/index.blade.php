@extends('layouts.master')

@section('title')
    Daftar Penjualan
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item">Daftar Penjualan</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-sm table-stiped table-bordered table-penjualan">
                    <thead>
                        <th class="text-center" width="5%">No</th>
                        <th>Tanggal</th>
                        <th>Kode Member</th>
                        <th class="text-end">Total Item</th>
                        <th class="text-end">Total Harga</th>
                        <th class="text-end">Diskon</th>
                        <th class="text-end">Total Bayar</th>
                        <th>Kasir</th>
                        <th class="text-center"><i class="fa fa-cog"></i></th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

@includeIf('penjualan.detail')
@endsection

@push('scripts')
<script>
    let table, table1;

    $(function () {
        table = $('.table-penjualan').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('penjualan.data') }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false, className: 'text-center'},
                {data: 'tanggal'},
                {data: 'kode_member'},
                {data: 'total_item', className: 'text-end'},
                {data: 'total_harga', className: 'text-end'},
                {data: 'diskon', className: 'text-end'},
                {data: 'bayar', className: 'text-end'},
                {data: 'kasir'},
                {data: 'aksi', searchable: false, sortable: false, className: 'text-center'},
            ]
        });

        table1 = $('.table-detail').DataTable({
            processing: true,
            bSort: false,
            dom: 'Brt',
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'kode_produk'},
                {data: 'nama_produk'},
                {data: 'harga_jual', className: 'text-end'},
                {data: 'jumlah', className: 'text-end'},
                {data: 'subtotal',className: 'text-end'},
            ]
        })
    });

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