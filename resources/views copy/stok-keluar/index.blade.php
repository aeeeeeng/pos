@extends('layouts.master')

@section('title')
    Stok Keluar
@endsection

@section('breadcrumb')
    @parent
    <li class="">Persediaan</li>
    <li class="active">Stok Keluar</li>
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
        .text-gropuping span {
            margin-top: 6px;
        }
        .code-badge {
            background-color: #00a65a !important;
            padding: 10px;
            text-align: center;
            color: #fff;
            font-weight: bold;
            border-radius: 6px;
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
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                <button onclick="create()" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah Stok Keluar</button>
            </div>
            <div class="box-body table-responsive">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tanggal">Range Tanggal</label>
                            <input type="text" class="form-control" id="tanggalFilter" name="tanggal">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tanggal">Gudang</label>
                            <select name="gudang" id="gudang" class="form-control">
                                <option value="">Semua Gudang</option>
                                @foreach ($gudang as $item)
                                    <option value="{{$item->id_gudang}}">{{$item->kode_gudang . ' - ' . $item->nama_gudang}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tanggal">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">Semua Status</option>
                                <option value="1">AKTIF</option>
                                <option value="0">BATAL</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">&nbsp;</label>
                            <button type="button" class="btn btn-flat btn-sm btn-primary form-control" id="filter" onclick="filterTableStokKeluarDT()">Filter Table</button>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-stiped table-bordered" id="tableStokKeluar">
                            <thead>
                                <th width="5%">No</th>
                                <th>Kode</th>
                                <th>Gudang</th>
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

    $(document).ready(function(){
        tableStokKeluarDT();
        
        $("#gudang").select2({ width: '100%' });
        $("#status").select2({ width: '100%' });

        var f3 = flatpickr(document.getElementById('tanggalFilter'), {
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

    function tableStokKeluarDT()
    {
        tableDT = $("#tableStokKeluar").DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            lengthMenu: [
                [10, 20, 50, -1],
                ['10', '20', '50', 'Lihat Semua']
            ],
            ajax: {
                'url': "{{url('persediaan/stok-keluar/get-data')}}",
                'type': 'GET',
                "dataSrc": function (response) {
                    return response.data;
                },
                data: function(d){
                    d.dateStart = dateStart,
                    d.dateEnd = dateEnd,
                    d.gudang = $("#gudang").val(),
                    d.status = $("#status").val()
                },
                error: function(error) {
                    showErrorAlert(error.responseJSON.message);
                }
            },
            columns: [
                {
                    data: '',
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
                        return `<span style="cursor: pointer;" onclick="showDetail('${r.id_stok_produk}')" class="label label-success">${d}</span>`;
                    }
                },
                {
                    data: 'nama_gudang',
                    name: 'g.nama_gudang',
                    className: "text-left"
                },
                {
                    data: 'tanggal',
                    name: 'sp.tanggal',
                    className: "text-left",
                    searchable: false,
                    render: function (d) {
                        return tglIndonesia(d);
                    }
                },
                {
                    data: 'catatan',
                    name: 'sp.catatan',
                    className: "text-left"
                },
                {
                    data: 'status',
                    name: 'sp.status',
                    className: "text-center",
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
                        const cancel = `<button type="button" class="btn btn-danger btn-flat btn-sm" onclick="cancel(this, '${d}')" ><i class="fa fa-close"></i></button>`;
                        return cancel;
                    }
                }
            ]
        });
    }

    function filterTableStokKeluarDT()
    {
        tableDT.draw();
    }

    function create(that)
    {
        event.preventDefault();
        $.ajax({
            url: "{{url('persediaan/stok-keluar/create')}}",
            success: function(response) {
                bootbox.dialog({
                    closeButton: false,
                    size: "large",
                    title: 'Tambah Stok Keluar',
                    message: response
                });
            }
        });
    }

    function showDetail(id)
    {
        event.preventDefault();
        $.ajax({
            url: "{{url('persediaan/stok-keluar/detail')}}/" + id,
            success: function(response) {
                bootbox.dialog({
                    closeButton: false,
                    size: "large",
                    title: 'Detail Stok Keluar',
                    message: response
                });
            }
        });
    }

    function cancel(that, id)
    {

        bootbox.confirm({
            title: "Batalkan Stok Keluar ini ?",
            message: "Semua stok didalam stok keluar ini akan dijadikan 0",
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
                        url: "{{url('persediaan/stok-keluar/cancel')}}/" + id,
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