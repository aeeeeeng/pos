@extends('layouts.master')

@section('title')
    Daftar Produk
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Daftar Produk</li>
@endsection

@push('css')
    <style>
        .image-product {
            width: 48px;
            height: 48px;
            border-radius: 4px;
            margin-left: 0;
            overflow: hidden;
            background-color: #f2f2f2;
            margin: 0 10px;
            vertical-align: middle;
        }
        .image-product img {
            width: 100%;
            margin: 5px 0;
            vertical-align: middle;
            border: 0;
        }

        .no-image-product {
            text-transform: uppercase!important;
            width: 48px;
            height: 48px;
            padding: 8px 0;
            text-align: center;
            border-radius: 2px;
            margin: 0 10px;
            vertical-align: middle;
            color: #fff;
            font-weight: 800;
            font-size: 20px;
        }

        input.check, input.checkall {
            height: 20px;
            width: 20px;
        }

    </style>
@endpush

@section('content')
<div class="row">

</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-wrap gap-3 align-items-center">
                    <a href="{{url('produk/create')}}" class="btn btn-success btn-sm btn-flat"><i class="fa fa-plus-circle"></i> Tambah Produk</a>
                    <button onclick="deleteSelected(this)" class="btn btn-danger btn-sm btn-flat"><i class="fa fa-trash"></i> Hapus</button>
                    <button onclick="cetakBarcode('{{ route('produk.cetak_barcode') }}')" class="btn btn-info btn-sm btn-flat"><i class="fa fa-barcode"></i> Cetak Barcode</button>
                </div>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{url('produk')}}" aria-selected="true">
                                <span class="d-block d-sm-none"><i class="fas fa-briefcase"></i></span>
                                <span class="d-none d-sm-block"> <i class="fas fa-briefcase"></i> Produk <span id="totalProduk"></span></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('add-opt')}}" role="tab" aria-selected="false">
                                <span class="d-block d-sm-none"><i class="fas fa-layer-group"></i></span>
                                <span class="d-none d-sm-block"><i class="fas fa-layer-group"></i> Opsi Tambahan ({{$totalAddOpt}})</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('kategori')}}" role="tab" aria-selected="false">
                                <span class="d-block d-sm-none"><i class="fas fa-tag"></i></span>
                                <span class="d-none d-sm-block"><i class="fas fa-tag"></i> Kategori ({{$totalKategori}})</span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content p-3 text-muted">
                        <div class="tab-pane active" id="home1" role="tabpanel">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group mb-4">
                                        <label>Lokasi Outlet</label>
                                        <select name="id_outlet" id="id_outlet" class="form-control form-control-sm" onchange="tableDT.draw()">
                                            <option value="">Semua Outlet</option>
                                            <option value="0">Tidak Punya Outlet</option>
                                            @foreach ($outlet as $item)
                                                <option value="{{$item->id}}" {{$item->id == session()->get('outlet') ? 'selected' : ''}}>{{$item->text}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-4">
                                        <label>Kategori</label>
                                        <select name="id_kategori" id="id_kategori" class="form-control form-control-sm" onchange="tableDT.draw()">
                                            <option value="">Semua Kategori</option>
                                            @foreach ($kategori as $item)
                                                <option value="{{$item->id}}">{{$item->text}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-4">
                                        <label>Status Dijual</label>
                                        <select name="dijual" id="dijual" class="form-control form-control-sm" onchange="tableDT.draw()">
                                            <option value="">Semua Status</option>
                                            <option value="1">Ya</option>
                                            <option value="0">Tidak</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-4">
                                        <label>Cari</label>
                                        <input type="text" class="form-control form-control-sm" id="cari" name="cari" placeholder="Nama Produk / SKU / Barcode" onkeyup="tableDT.draw()">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive mb-0 fixed-solution" data-pattern="priority-columns">

                                        <table class="table table-hover table-sm" id="tableProduct">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <input type="checkbox" onclick="checkAll(this)" class="checkall" id="checkAll">
                                                    </th>
                                                    <th>Nama Produk</th>
                                                    <th>Kategori</th>
                                                    <th>Harga</th>
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
</div>


@endsection

@push('scripts')
<script>

    let tableDT;

    $(document).ready(function(){
        loadTableDT();
    })

    $("#id_outlet").select2();
    $("#id_kategori").select2();
    $("#dijual").select2();

    $(document).on('click', ".page-link", function(){
        $('.checkall').prop('checked', false);
    });

    function loadTableDT()
    {
        tableDT = $("#tableProduct").DataTable({
            responsive: false,
            processing: true,
            serverSide: true,
            searching: false,
            lengthMenu: [
                [10, 20, 50, -1],
                ['10', '20', '50', 'Lihat Semua']
            ],
            ajax: {
                'url': "{{url('produk/data')}}",
                'type': 'GET',
                "dataSrc": function (response) {
                    $("#totalProduk").text(`(${response.recordsFiltered})`);
                    return response.data;
                },
                data: function(d){
                    d.id_outlet = $("#id_outlet").val(),
                    d.id_kategori = $("#id_kategori").val(),
                    d.dijual = $("#dijual").val(),
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
                    className: "text-nowrap text-start",
                    searchable: false,
                    sortable: false,
                    render: function (d,t,r) {
                        return `<input type="checkbox" onclick="check(this)" class="check" value="${r.id_produk}">`
                    }
                },
                {
                    data: 'nama_produk',
                    name: 'p.nama_produk',
                    className: "text-nowrap text-start",
                    render: function(d,t,r) {
                        const url = `{{url('/')}}`
                        let img = ''
                        if(r.gambar == '' || r.gambar == null) {
                            img = `<div class="no-image-product" style="background-color:${backgroundColor(Math.floor(Math.random() * 10))}">${r.imageText}</div>`;
                        } else {
                            img = `
                                <div class="image-product">
                                    <img src="${url}/img/produk-image/${r.gambar}">
                                </div>`;
                        }
                        return `<div class="d-flex flex-wrap gap-3 align-items-center">
                                    ${img}
                                    <span>${d}</<span>
                                </div>`;
                    }
                },
                {
                    data: 'nama_kategori',
                    name: 'k.nama_kategori',
                    className: "text-nowrap text-start"
                },
                {
                    data: 'harga_jual',
                    name: 'p.harga_jual',
                    className: "text-nowrap text-end",
                    render: function(d,t,r) {
                        return formatMoney(d);
                    }
                },
                {
                    data: 'id_produk',
                    name: 'p.id_produk',
                    className: "text-nowrap text-center",
                    render: function(d,t,r) {
                        const btnKelolaStok = `<a class="dropdown-item" href="#" onclick="kelolaStok(this, '${d}')">Kelola Stok</a>`;
                        const btnKelolaBahanBaku = r.tipe == 'komposit' ? `<button type="button" class="dropdown-item" onclick="kelolaBahanBaku(this, '${d}')">Kelola Bahan Baku</button>` : '';
                        return `<div class="dropdown mt-4 mt-sm-0">
                                    <a href="#" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="mdi mdi-chevron-down"></i>
                                    </a>
                                    <div class="dropdown-menu" style="">
                                        ${btnKelolaStok + ' ' + btnKelolaBahanBaku}
                                        <a class="dropdown-item" href="{{url('produk/edit')}}/${d}">Ubah</a>
                                        <a class="dropdown-item" onclick="singleRemove('${d}')" href="#">Hapus</a>
                                    </div>
                                </div>`;
                    }
                }
            ]
        });
    }

    function backgroundColor(randomNumber)
    {
        switch (randomNumber) {
            case 1: return '#ff5252';
            case 2: return '#e040fb';
            case 3: return '#512da8';
            case 4: return '#303f9f';
            case 5: return '#1976d2';
            case 6: return '#039be5';
            case 7: return '#00acc1';
            case 8: return '#00897b';
            case 8: return '#43a047';
            case 9: return '#ffeb3b';
            default: return '#f4511e';
        }
    }

    function kelolaBahanBaku(that, id)
    {
        event.preventDefault();
        $.ajax({
            url: "{{url('produk/kelola-bahan-baku')}}/" + id,
            success: function(response) {
                const dialog = bootbox.dialog({
                    closeButton: false,
                    size: "xl",
                    title: `Kelola Bahan Baku`,
                    message: response
                });
            }
        });
    }

    function kelolaStok(that, id)
    {
        event.preventDefault();
        $.ajax({
            url: "{{url('produk/kelola-stok')}}/" + id,
            success: function(response) {
                const dialog = bootbox.dialog({
                    closeButton: false,
                    size: "xl",
                    title: `Kelola Stok`,
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

    function deleteSelected(that)
    {
        let allCheck = [];
        $(".check:checked").each(function(){
            allCheck.push($(this).val());
        });
        if(allCheck.length < 1) {
            showErrorAlert('Pilih minimal 1 produk untuk dihapus');
            return;
        }
        bootbox.confirm({
            title: "Hapus produk yang dipilih ?",
            message: "-",
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
                        url: `{{url('produk/delete-bulky')}}`,
                        method: 'POST',
                        dataType: 'json',
                        contentType: 'application/json',
                        data: JSON.stringify({allCheck}),
                        beforeSend: function() {
                            blockLoading();
                        }
                    }).done(response => {
                        showSuccessAlert(response.message);
                        tableDT.draw();
                    }).fail(error => {
                        const respJson = $.parseJSON(error.responseText);
                        showErrorAlert(respJson.message);
                    }).always(() => {
                        setTimeout(() => {
                            unBlockLoading();
                        }, 500);
                    })
                }
            }
        });
    }

    function singleRemove(id)
    {
        bootbox.confirm({
            title: "Hapus produk ini ?",
            message: "-",
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
                        url: `{{url('produk/delete')}}/${id}`,
                        method: 'POST',
                        dataType: 'json',
                        contentType: "application/json"
                    }).done(response => {
                        showSuccessAlert(response.message);
                        tableDT.draw();
                    }).fail(error =>{
                        const respJson = $.parseJSON(error.responseText);
                        showErrorAlert(respJson.message);
                    });
                }
            }
        });
    }

    function cetakBarcode(url) {
        if ($('input:checked').length < 1) {
            alert('Pilih data yang akan dicetak');
            return;
        } else if ($('input:checked').length < 3) {
            alert('Pilih minimal 3 data untuk dicetak');
            return;
        } else {
            $('.form-produk')
                .attr('target', '_blank')
                .attr('action', url)
                .submit();
        }
    }
</script>
@endpush
