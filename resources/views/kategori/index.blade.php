@extends('layouts.master')

@section('title')
    Kategori
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Kategori</li>
@endsection

@section('content')
<div class="row">

</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-wrap gap-3 align-items-center">
                    <button type="button" onclick="formAdd(this)" class="btn btn-success btn-sm btn-flat"><i class="fa fa-plus-circle"></i> Tambah Kategori</button>
                    {{-- <button onclick="deleteSelected(this)" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash"></i> Hapus</button> --}}
                </div>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('produk')}}" aria-selected="false">
                                <span class="d-block d-sm-none"><i class="fas fa-briefcase"></i></span>
                                <span class="d-none d-sm-block"> <i class="fas fa-briefcase"></i> Produk ({{$totalProduk}})</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('add-opt')}}" role="tab" aria-selected="false">
                                <span class="d-block d-sm-none"><i class="fas fa-layer-group"></i></span>
                                <span class="d-none d-sm-block"><i class="fas fa-layer-group"></i> Opsi Tambahan ({{$totalAddOpt}})</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{url('kategori')}}" role="tab" aria-selected="true">
                                <span class="d-block d-sm-none"><i class="fas fa-tag"></i></span>
                                <span class="d-none d-sm-block"><i class="fas fa-tag"></i> Kategori <span id="totalKategori"></span></span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content p-3 text-muted">
                        <div class="tab-pane active" id="home2" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="example-search-input" class="form-label">Cari</label>
                                        <input class="form-control form-control-sm" type="text" placeholder="Cari berdasarkan nama Kategori" id="cari" onkeyup="tableDT.draw();" onchange="tableDT.draw();">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="example-search-input" class="form-label">Outlet</label>
                                        <select name="id_outlet" id="id_outlet" class="form-control form-control-sm" onchange="tableDT.draw()">
                                            <option value="">Semua Outlet</option>
                                            <option value="0">Tidak Punya Outlet</option>
                                            @foreach ($outlet as $item)
                                                <option value="{{$item->id}}" {{$item->id == session()->get('outlet') ? 'selected' : ''}}>{{$item->text}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-hover table-sm" id="tableKategori">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>
                                                    <input type="checkbox" onclick="checkAll(this)" class="checkall" id="checkAll">
                                                </th>
                                                <th>Nama Kategori</th>
                                                <th>Jumlah Produk</th>
                                                <th width="5%">#</th>
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
    </div>
</div>


@endsection

@push('scripts')
<script>
    let tableDT;

    $(document).ready(function(){
        loadTableDT();
        $("#id_outlet").select2();
    });

    function edit(that, id)
    {
        event.preventDefault();
        $.ajax({
            url: "{{url('kategori/edit')}}/" + id,
            success: function(response) {
                const dialog = bootbox.dialog({
                    closeButton: false,
                    size: "sm",
                    title: `Edit Kategori`,
                    message: response
                });
            }
        });
    }

    function formAdd(that)
    {
        event.preventDefault();
        $.ajax({
            url: "{{url('kategori/create')}}",
            success: function(response) {
                const dialog = bootbox.dialog({
                    closeButton: false,
                    size: "sm",
                    title: `Tambah Kategori`,
                    message: response
                });
            }
        });
    }

    function checkAll(that)
    {
        const isChecked = $(that).is(':checked');
        if(isChecked) {
            $(".check").prop('checked', true);
        } else {
            $(".check").prop('checked', false);
        }
    }

    function check(that)
    {
        const isChecked = $(that).is(':checked');
        if(!isChecked) {
            $(".checkall").prop('checked', false);
        }
    }

    function loadTableDT()
    {
        tableDT = $("#tableKategori").DataTable({
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
                'url': "{{url('kategori/data')}}",
                'type': 'GET',
                "dataSrc": function (response) {
                    $("#totalKategori").text(`(${response.recordsFiltered})`);
                    return response.data;
                },
                data: function(d){
                    d.search = $("#cari").val(),
                    d.id_outlet = $("#id_outlet").val()
                },
                error: function(error) {
                    showErrorAlert(error.responseJSON.message);
                }
            },
            columns: [
                {
                    data: 'created_at',
                    name: 'k.created_at',
                    searchable: false,
                    visible: false,
                },
                {
                    data: 'id_kategori',
                    name: 'k.id_kategori',
                    className: "text-nowrap text-start",
                    searchable: false,
                    sortable: false,
                    render: function (d,t,r) {
                        return `<input type="checkbox" onclick="check(this)" class="check" value="${r.id_kategori}">`;
                    }
                },
                {
                    data: 'nama_kategori',
                    name: 'k.nama_kategori',
                    className: "text-nowrap text-start"
                },
                {
                    data: 'totalProduk',
                    name: 'totalProduk',
                    className: "text-nowrap text-end"
                },
                {
                    data: 'id_kategori',
                    name: 'k.id_kategori',
                    className: "text-nowrap text-center",
                    render: function(d,t,r) {
                        return `<div class="dropdown mt-4 mt-sm-0">
                                    <a href="#" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="mdi mdi-chevron-down"></i>
                                    </a>
                                    <div class="dropdown-menu" style="">
                                        <button type="button" class="dropdown-item" onclick="edit(this, '${d}')">Ubah</button>
                                        <button class="dropdown-item" onclick="singleRemove('${d}')" href="#">Hapus</button>
                                    </div>
                                </div>`;
                    }
                }
            ]
        });
    }
</script>
@endpush
