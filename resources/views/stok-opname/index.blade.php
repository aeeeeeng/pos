@extends('layouts.master')

@section('title')
    Stok Opname
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item">Persediaan</li>
    <li class="breadcrumb-item active">Stok Opname</li>
@endsection

@push('css')
    <style>
        hr {
            border-top: 1px solid #f5f5f5;
        }
        #productTable {
            margin-top: 10px;
        }
        .text-gropuping {
            display: inline-flex;
            width: 100%;
            justify-content: space-between;
        }
        @media (min-width: 768px) {
            .form-horizontal .control-label {
                padding-top: 7px;
                margin-bottom: 0;
                text-align: left;
            }
        }
    </style>
@endpush

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header with-border">
                <button onclick="create()" class="btn btn-success btn-sm btn-flat"><i class="fa fa-plus-circle"></i> Tambah Stok Opname</button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tanggal">Periode</label>
                            <input type="text" class="form-control form-control-sm" id="tanggalFilter" name="tanggal" onchange="filterTableStokOpnameDT()">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tanggal">Outlet</label>
                            <select name="outlet" id="outlet" class="form-control" onchange="filterTableStokOpnameDT()">
                                <option value="">Semua Outlet</option>
                                @foreach ($outlet as $item)
                                    <option value="{{$item->id_outlet}}">{{$item->nama_outlet}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tanggal">Status</label>
                            <select name="status" id="status" class="form-control form-control-sm" onchange="filterTableStokOpnameDT()">
                                <option value="">Semua Status</option>
                                <option value="1">AKTIF</option>
                                <option value="0">BATAL</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">Cari</label>
                            <input type="text" class="form-control form-control-sm" id="cari" name="cari" placeholder="Cari berdasarkan Kode / Catatan Stok Opname" onchange="filterTableStokOpnameDT()" onkeyup="filterTableStokOpnameDT()">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-sm table-hover" id="tableStokOpname">
                            <thead>
                                <th></th>
                                <th width="5%">No</th>
                                <th>Kode</th>
                                <th>Outlet</th>
                                <th>Tanggal</th>
                                <th>Catatan</th>
                                <th>Status</th>
                                <th>#</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script>

    let tableDT, dateStart, dateEnd;

    dateStart = formatDateIso(Date.now());
    dateEnd = formatDateIso(Date.now());

    $(document).ready(function(){
        tableStokOpnameDT();

        $("#outlet").select2({ width: '100%' });
        $("#status").select2({ width: '100%' });

        var f3 = flatpickr(document.getElementById('tanggalFilter'), {
            mode: "range",
            dateFormat: "d/m/Y",
            defaultDate: [formatDateIsoFlatP(Date.now()), formatDateIsoFlatP(Date.now())],
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

    function tableStokOpnameDT()
    {
        tableDT = $("#tableStokOpname").DataTable({
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
                'url': "{{url('persediaan/stok-opname/get-data')}}",
                'type': 'GET',
                "dataSrc": function (response) {
                    return response.data;
                },
                data: function(d){
                    d.dateStart = dateStart,
                    d.dateEnd = dateEnd,
                    d.id_outlet = $("#outlet").val(),
                    d.status = $("#status").val(),
                    d.search = $("#cari").val()
                },
                error: function(error) {
                    showErrorAlert(error.responseJSON.message);
                }
            },
            columns: [
                {
                    data: 'created_at',
                    name: 'sp.created_at',
                    searchable: false,
                    visible: false,
                },
                {
                    data: 'reference',
                    name: 'no',
                    render: function(data, type, row, attr) {
                        return attr.row + attr.settings._iDisplayStart + 1;
                    },
                    searchable: false,
                    orderable: false,
                    className: "text-center"
                },
                {
                    data: 'kode',
                    name: 'sp.kode',
                    className: "text-center",
                    render: function(d,t,r) {
                        return `<span class="badge bg-primary">${d}</span>`;
                    }
                },
                {
                    data: 'nama_outlet',
                    name: 'o.nama_outlet',
                    className: "text-start"
                },
                {
                    data: 'tanggal',
                    name: 'sp.tanggal',
                    className: "text-start",
                    searchable: false,
                    render: function (d) {
                        return tglIndonesia(d);
                    }
                },
                {
                    data: 'catatan',
                    name: 'sp.catatan',
                    className: "text-start"
                },
                {
                    data: 'status',
                    name: 'sp.status',
                    className: "text-start",
                    render: function(d) {
                        return labelStatusStok(d);
                    }
                },
                {
                    data: 'id_stok_produk',
                    name: 'sp.id_stok_produk',
                    className: "text-center",
                    searchable: false,
                    orderable: false,
                    render(d,t,r){
                        return `<div class="dropdown mt-4 mt-sm-0">
                                    <a href="#" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="mdi mdi-chevron-down"></i>
                                    </a>
                                    <div class="dropdown-menu" style="">
                                        <button class="dropdown-item" onclick="showDetail('${d}')"> <i class="fas fa-check-circle text-dark me-3"></i> Lihat Detail </button>
                                    </div>
                                </div>`;
                    }
                }
            ]
        });
    }

    function filterTableStokOpnameDT()
    {
        tableDT.draw();
    }

    function create(that)
    {
        window.location.href = `{{url('persediaan/stok-opname/create')}}`;
    }

    function showDetail(id)
    {
        event.preventDefault();
        $.ajax({
            url: "{{url('persediaan/stok-opname/detail')}}/" + id,
            success: function(response) {
                bootbox.dialog({
                    closeButton: false,
                    size: "xl",
                    title: 'Detail Stok Opname',
                    message: response
                });
            }
        });
    }

    function cancel(that, id)
    {

        bootbox.confirm({
            closeButton: false,
            title: "Batalkan Stok Opname ini ?",
            message: "Semua stok didalam stok opname ini akan dijadikan 0",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> Batal'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> Ya'
                }
            },
            callback: function (result) {
                if(result) {
                    $.ajax({
                        url: "{{url('persediaan/stok-opname/cancel')}}/" + id,
                        type: "POST",
                        dataType: "json",
                        contentType: "application/json",
                        beforeSend: () => {
                            buttonLoading($(that));
                        }
                    }).done(response => {
                        showSuccessAlert(response.message);
                        buttonUnloading($(that), '<i class="fa fa-close"></i>');
                        tableDT.draw();
                    }).fail(error => {
                        const respJson = $.parseJSON(error.responseText);
                        showErrorAlert(respJson.message);
                        buttonUnloading($(that), '<i class="fa fa-close"></i>');
                    });
                }
            }
        });
    }
</script>

@endpush
