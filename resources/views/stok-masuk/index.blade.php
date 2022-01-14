@extends('layouts.master')

@section('title')
    Stok Masuk
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item">Persediaan</li>
    <li class="breadcrumb-item active">Stok Masuk</li>
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
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-wrap gap-3 align-items-center">
                    <button onclick="create()" class="btn btn-success btn-sm btn-flat"><i class="fa fa-plus-circle"></i> Tambah Stok Masuk</button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tanggal">Range Tanggal</label>
                            <input type="text" class="form-control form-control-sm" id="tanggalFilter" name="tanggal">
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
                            <button type="button" class="btn btn-flat btn-sm btn-primary form-control" id="filter" onclick="filterTableStokMasukDT()">Filter Table</button>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-sm table-stiped table-bordered" id="tableStokMasuk">
                            <thead>
                                <tr class="bg-primary text-white">
                                    <th width="5%">No</th>
                                    <th>Kode</th>
                                    <th>Gudang</th>
                                    <th>Tanggal</th>
                                    <th>Catatan</th>
                                    <th>Status</th>
                                    <th>#</th>
                                </tr>
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
        tableStokMasukDT();
        
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

    function tableStokMasukDT()
    {
        tableDT = $("#tableStokMasuk").DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            searching: true,
            lengthMenu: [
                [10, 20, 50, -1],
                ['10', '20', '50', 'Lihat Semua']
            ],
            ajax: {
                'url': "{{url('persediaan/stok-masuk/get-data')}}",
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
                        return `<span style="cursor: pointer;" onclick="showDetail('${r.id_stok_produk}')" class="badge bg-primary">${d}</span>`;
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
                    className: "text-left",
                    render: function(d) {
                        if(d == '' || d == null) {
                            return '-';
                        }
                        return d;
                    }
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
                        const cancel = `<button type="button" class="btn btn-danger btn-flat btn-sm" onclick="cancel(this, '${d}')" ><i class="fas fa-times-circle"></i></button>`;
                        return cancel;
                    }
                }
            ]
        });
    }

    function filterTableStokMasukDT()
    {
        tableDT.draw();
    }

    function create(that)
    {
        event.preventDefault();
        $.ajax({
            url: "{{url('persediaan/stok-masuk/create')}}",
            success: function(response) {
                const dialog = bootbox.dialog({
                    closeButton: false,
                    size: "xl",
                    title: 'Tambah Stok Masuk',
                    message: response
                });
            }
        });
    }

    function showDetail(id)
    {
        event.preventDefault();
        $.ajax({
            url: "{{url('persediaan/stok-masuk/detail')}}/" + id,
            success: function(response) {
                bootbox.dialog({
                    closeButton: false,
                    size: "xl",
                    title: 'Detail Stok Masuk',
                    message: response
                });
            }
        });
    }

    function cancel(that, id)
    {

        bootbox.confirm({
            title: "Batalkan Stok Masuk ini ?",
            message: "Semua stok didalam stok masuk ini akan dijadikan 0",
            closeButton: false,
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
                        url: "{{url('persediaan/stok-masuk/cancel')}}/" + id,
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