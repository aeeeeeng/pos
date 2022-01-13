@extends('layouts.master')

@section('title')
    Gudang
@endsection

@section('breadcrumb')
    @parent
    <li class="">Persediaan</li>
    <li class="active">Gudang</li>
@endsection

@push('css')
    <style>
        hr {
            border-top: 1px solid #f5f5f5;
        }
        .checkbox-kode {
            font-size: 10px;
            font-style: italic;
        }
        .code-form {
            display: block;
            padding: 10px;
            font-size: 17px;
        }
    </style>
@endpush

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                <button onclick="create()" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah</button>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-stiped table-bordered" id="tableGudang">
                    <thead>
                        <th width="5%">No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th><i class="fa fa-cog"></i></th>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let tableDT;

    $(document).ready(function(){
        tableGudangDT();
    });

    function tableGudangDT()
    {
        tableDT = $("#tableGudang").DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            lengthMenu: [
                [10, 20, 50, -1],
                ['10', '20', '50', 'Lihat Semua']
            ],
            ajax: {
                'url': "{{url('persediaan/gudang/get-data')}}",
                'type': 'GET',
                "dataSrc": function (response) {
                    return response.data;
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
                        data: 'kode_gudang',
                        name: 'kode_gudang',
                        className: "text-left",
                        render: function(d,t,r) {
                            return `<span class="label label-success">${d}</span>`;
                        }
                    },
                    {
                        data: 'nama_gudang',
                        name: 'nama_gudang',
                        className: "text-left"
                    },
                    {
                        data: 'alamat_gudang',
                        name: 'alamat_gudang',
                        className: "text-left"
                    },
                    {
                        data: 'id_gudang',
                        name: 'id_gudang',
                        className: "text-center",
                        searchable: false,
                        orderable: false,
                        render(d,t,r){
                            const inactive = `<button type="button" class="btn btn-danger btn-flat btn-sm" onclick="inactive('${d}')" ><i class="fa fa-trash"></i></button>`;
                            const edit = `<button type="button" class="btn btn-primary btn-flat btn-sm" onclick="edit(this, '${d}')" ><i class="fa fa-pencil"></i></button>`
                            return inactive + '&nbsp;' + edit;
                        }
                    }
                ]
        })
    }

    function create(that)
    {
        event.preventDefault();
        $.ajax({
            url: "{{url('persediaan/gudang/create')}}",
            success: function(response) {
                bootbox.dialog({
                    closeButton: false,
                    size: "small",
                    title: 'Tambah Gudang',
                    message: response
                });
            }
        });
    }

    function edit(that, id)
    {
        event.preventDefault();
        $.ajax({
            url: "{{url('persediaan/gudang/edit')}}/" + id,
            success: function(response) {
                bootbox.dialog({
                    closeButton: false,
                    size: "small",
                    title: 'Ubah Gudang',
                    message: response
                });
            }
        });
    }

    function inactive(id)
    {
        bootbox.confirm({
            title: "Non-aktifkan gudang ?",
            message: "Semua data yang berkaitan dengan gudang ini tidak akan muncul di aplikasi",
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
                    blockLoading();
                    $.ajax({
                        url: `{{url('persediaan/gudang/inactive')}}/${id}`,
                        type: 'POST'
                    }).done(response => {
                        showSuccessAlert(response.message);
                        unBlockLoading();
                        tableDT.draw();
                    }).fail(error => {
                        const respJson = $.parseJSON(error.responseText);
                        showErrorAlert(respJson.message);
                        unBlockLoading();
                    });
                }
            }
        });
    }
</script>
@endpush

@stack('subjs')