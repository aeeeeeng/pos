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
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group mb-3">
                            <label for="id_outlet">Outlet</label>
                            <select name="id_outlet" id="id_outlet" class="form-control form-control-sm" onchange="tableDT.draw();">
                                <option value="">Semua Outlet</option>
                                @foreach ($outlet as $item)
                                    <option value="{{$item->id_outlet}}" {{$item->id_outlet == session()->get('outlet') ? 'selected' : ''}}>{{$item->nama_outlet}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-3">
                            <label for="id_supplier">Supplier</label>
                            <select name="id_supplier" id="id_supplier" class="form-control form-control-sm" onchange="tableDT.draw();">
                                <option value="">Semua Supplier</option>
                                @foreach ($supplier as $item)
                                    <option value="{{$item->id_supplier}}">{{$item->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-3">
                            <label for="periode">Periode</label>
                            <input type="text" class="form-control form-control-sm" id="periode" name="periode" placeholder="klik untuk memilih periode" onchange="tableDT.draw();">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-3">
                            <label for="status_filter">Status</label>
                            <select name="status_filter" id="status_filter" class="form-control form-control-sm" onchange="tableDT.draw();">
                                <option value="">Semua Status</option>
                                @foreach ($status as $item)
                                    <option value="{{$item['id']}}">{{$item['nama']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="cari">Cari</label>
                            <input type="text" class="form-control form-control-sm" id="cari" name="cari" placeholder="Ketik disini untuk mencari Kode / Nomor PO" onchange="tableDT.draw();" onkeyup="tableDT.draw();">
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover table-sm" id="tablePembelian">
                            <thead>
                                <th></th>
                                <th>Kode PO</th>
                                <th>Supplier</th>
                                <th>No PO</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th class="text-center"><i class="fa fa-cog"></i></th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@includeIf('pembelian.supplier')
@includeIf('pembelian.detail')
@endsection

@push('scripts')
<script>
    let tableDT, dateStart, dateEnd;

    $(function () {
        loadTableDT();
        $("#id_outlet").select2();
        $("#id_supplier").select2();
        $("#status_filter").select2();
        var f4 = flatpickr(document.getElementById('periode'), {
            mode: "range",
            dateFormat: "d/m/Y",
            onChange: function(dates) {
                if (dates.length == 2) {
                    dateStart = formatDateIso(dates[0]);
                    dateEnd = formatDateIso(dates[1]);
                } else {
                    dateStart = null;
                    dateEnd = null;
                }
            }
        });
    });

    function loadTableDT()
    {
        tableDT = $("#tablePembelian").DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: false,
            lengthMenu: [
                [10, 20, 50, -1],
                ['10', '20', '50', 'Lihat Semua']
            ],
            "order": [[0, "desc" ]],
            ajax: {
                'url': "{{url('pembelian/data')}}",
                'type': 'GET',
                "dataSrc": function (response) {
                    return response.data;
                },
                data: function(d){
                    d.id_outlet = $("#id_outlet").val(),
                    d.id_supplier = $("#id_supplier").val(),
                    d.status = $("#status_filter").val(),
                    d.dateStart = dateStart,
                    d.dateEnd = dateEnd,
                    d.cari = $("#cari").val()
                },
                error: function(error) {
                    showErrorAlert(error.responseJSON.message);
                }
            },
            columns: [
                {
                    data: 'created_at',
                    name: 'p.created_at',
                    searchable: false,
                    visible: false,
                },
                {
                    data: 'kode_pembelian',
                    name: 'p.kode_pembelian',
                    className: "text-nowrap text-start"
                },
                {
                    data: 'nama_supplier',
                    name: 's.nama',
                    className: "text-nowrap text-start"
                },
                {
                    data: 'no_pembelian',
                    name: 'p.no_pembelian',
                    className: "text-nowrap text-start"
                },
                {
                    data: 'tanggal_pembelian',
                    name: 'p.tanggal_pembelian',
                    className: "text-nowrap text-start"
                },
                {
                    data: 'status',
                    name: 'p.status',
                    className: "text-nowrap text-start",
                    render: function(d,t,r) {
                        return `${iconStatus(d)} ${textStatus(d)}`;
                    }
                },
                {
                    data: 'id_pembelian',
                    name: 'p.id_pembelian',
                    className: "text-nowrap text-start",
                    render: function(d,t,r) {
                        const btnDiterima = r.status == 'DRAFT' ? `<button class="dropdown-item" onclick="updateStatus('terima', '${d}')"> <i class="fas fa-check-circle text-success me-3"></i> Penerimaan</button>` : '';
                        const btnDibatalkan = r.status == 'DRAFT' ? `<button class="dropdown-item" onclick="updateStatus('batal', '${d}')"><i class="fas fa-times-circle text-danger me-3"></i> Pembatalan</button>` : '';

                            return `<div class="dropdown mt-4 mt-sm-0">
                                    <a href="#" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="mdi mdi-chevron-down"></i>
                                    </a>
                                    <div class="dropdown-menu" style="">
                                        ${btnDiterima + ' ' + btnDibatalkan}
                                        <button class="dropdown-item" onclick="updateStatus('lihat', '${d}')"> <i class="fas fa-check-circle text-dark me-3"></i> Lihat Detail </button>
                                    </div>
                                </div>`;
                    }
                }
            ]
        });
    }

    function updateStatus(jenis, id)
    {
        event.preventDefault();
        $.ajax({
            url: "{{url('pembelian/ganti-status')}}",
            data: {jenis, id},
            success: function(response) {

                let title = '';
                if(jenis == 'terima') {
                    title = 'Penerimaan';
                } else if (jenis == 'batal') {
                    title = 'Pembatalan';
                } else if (jenis == 'lihat') {
                    title = 'Data PO';
                }

                const dialog = bootbox.dialog({
                    closeButton: false,
                    size: "xl",
                    title: title,
                    message: response
                });
            }
        });
    }

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

    function textStatus(status)
    {
        switch (status) {
            case 'DRAFT': return 'Dipesan';
            case 'DONE': return 'Diterima';
            case 'CANCEL': return 'Dibatalkan';
            default: return '-';
        }
    }

    function iconStatus(status)
    {
        switch (status) {
            case 'DRAFT': return `<i class="fas fa-cart-arrow-down text-info me-3"></i>`;
            case 'DONE': return `<i class="fas fa-check-circle text-success me-3"></i>`;
            case 'CANCEL': return `<i class="fas fa-times-circle text-danger me-3"></i>`;
            default: return '-';
        }
    }
</script>
@endpush
