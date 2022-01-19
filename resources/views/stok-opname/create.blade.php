@extends('layouts.master')

@section('title')
    Buat Stok Opname
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item">Persediaan</li>
    <li class="breadcrumb-item">Stok Opname</li>
    <li class="breadcrumb-item active">Buat Stok Opname</li>
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
            <div class="card-body">
                <form onsubmit="store(this)" id="formStokOpname" class="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="id_gudang" class="control-label text-start">Gudang <span class="text-danger">*</span> </label>
                                <select name="id_gudang" id="id_gudang" class="form-control form-control-sm">
                                    <option value="">Pilih Gudang</option>
                                    @foreach ($gudang as $item)
                                        <option value="{{$item->id_gudang}}">{{$item->kode_gudang . ' - ' . $item->nama_gudang}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="catatan" class="control-label text-start">Catatan</label>
                                <textarea name="catatan" id="catatan" class="form-control form-control-sm"></textarea>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12">
                            <select class="pilih-product-adjustment select2 form-control form-control-sm"></select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-sm table-hover" id="productTable">
                                <thead>
                                    <tr>
                                        <th class="text-start">No</th>
                                        <th class="text-start">Kode Produk</th>
                                        <th class="text-start">Nama Produk</th>
                                        <th class="text-end">Jumlah Barang (SISTEM)</th>
                                        <th class="text-end">Jumlah Barang (AKTUAL)</th>
                                        <th class="text-end">Silisih</th>
                                        <th class="text-end">Harga Unit (SISTEM)</th>
                                        <th class="text-start">#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td colspan="9" class="text-center">Data masih kosong, pilih produk pada combobox diatas</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="float-end">
                                <button type="button" class="btn btn-flat btn-sm btn-secondary" onclick="window.location.href = '{{url('persediaan/stok-opname')}}'"> Batal </button>
                                <button type="submit" class="btn btn-flat btn-sm btn-primary"> Simpan </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>

    var dataDetail = [];

    $(document).ready(function(){

        $("#id_gudang").select2({ width: '100%' });

        $('body').addClass('sidebar-collapse');
    });

    $(".pilih-product-adjustment").select2({
        placeholder: "Pilih Barang Melalui Kode/Nama",
        allowClear: true,
        width: '100%',
        ajax: {
            url: "{{url('persediaan/stok-opname/get-product')}}",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;

                return {
                    results: data.items,
                    pagination: {
                    more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: true
        },
        minimumInputLength: 2,
        templateResult: formatResultAdjustment,
        templateSelection: formatResultAdjustmentSelection
    });

    $('.pilih-product-adjustment').on('select2:select', function (e) {
        var data = e.params.data;
        storeOptionProduct(data);
        $(".pilih-product-adjustment").val('').trigger('change');
        console.log(dataDetail);
        renderTable();
    });

    function store(that)
    {
        event.preventDefault();

        bootbox.confirm({
            closeButton: false,
            title: "Apakah anda yakin ?",
            message: "Semua stok opname akan disimpan",
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
                    const form = $("#formStokOpname");

                    const id_gudang = $("#id_gudang").val();
                    const catatan = $("#catatan").val();

                    if(id_gudang == '' || id_gudang == null) {
                        showErrorAlert('Gudang harus diisi');
                        return;
                    }
                    if(dataDetail.length == 0) {
                        showErrorAlert('Produk harus berisi minimal 1 baris');
                        return;
                    }
                    const payloads = {dataDetail, id_gudang, catatan};
                    $.ajax({
                        url: "{{url('persediaan/stok-opname/store')}}" ,
                        type: "POST",
                        dataType: "json",
                        contentType: "application/json",
                        data: JSON.stringify(payloads),
                        beforeSend: () => {
                            buttonLoading(form.find('button[type=submit]'));
                        }
                    }).done(response => {
                        showSuccessAlert(response.message);
                        setTimeout(() => {
                            window.location.href = `{{url('persediaan/stok-opname')}}`;
                        }, 500);
                    }).fail(error => {
                        const respJson = $.parseJSON(error.responseText);
                        showErrorAlert(respJson.message);
                        buttonUnloading(form.find('button[type=submit]'), 'Simpan');
                    });
                }
            }
        });
    }

    function storeOptionProduct(selected)
    {
        selected.qty_stok = selected.stok;
        selected.stok_selisih = selected.qty_stok - selected.stok;
        const checkExist = dataDetail.filter(item => item.id === selected.id).length > 0 ? true : false;
        if(checkExist) {
            const indexExist = dataDetail.findIndex(item => item.id === selected.id);
            dataDetail[indexExist].qty_stok = dataDetail[indexExist].qty_stok + 1;
            const stok = dataDetail[indexExist].stok;
            dataDetail[indexExist].stok_selisih - qty_stok - stok;
        } else {
            dataDetail.push(selected);
        }
    }

    function renderTable()
    {
        const table = $("#productTable");
        if(dataDetail.length == 0) {
            table.find('tbody').html(`<tr><td colspan="9" class="text-center">Data masih kosong, pilih produk pada combobox diatas</td></tr>`);
        } else {
            const row = dataDetail.map((item, index) => `<tr>
                <td>${index+1}</td>
                <td><small class="badge bg-primary">${item.kode_produk}</small></td>
                <td>${item.nama_produk}</td>
                <td class="text-end">${item.stok}</td>
                <td class="text-end">
                    <input type="number" min="0" class="form-control form-control-sm text-end" value="${item.qty_stok}" onkeyup="changeQty(this, '${item.id}')" onchange="changeQty(this, '${item.id}')">
                </td>
                <td class="text-end stok_selisih">
                    ${item.stok_selisih >= 0 ? `<span class="text-success"> <i class="fa fa-angle-up"></i> ${item.stok_selisih}</span>` : `<span class="text-danger"> <i class="fa fa-angle-down"></i> ${item.stok_selisih}</span>`}
                </td>
                <td class="text-end">${formatMoney(item.nilai_stok)}</td>
                <td><button type="button" class="btn btn-flat btn-danger btn-sm" onclick="removeDetailArr('${item.id}')"><i class="fa fa-trash"></i></button></td>
            </tr>`).join();
            table.find('tbody').html(row);
        }
    }

    function sumSelisih(that, id)
    {
        const indexExist = dataDetail.findIndex(item => item.id == id);
        const stok = dataDetail[indexExist].stok;
        const qty_stok = dataDetail[indexExist].qty_stok;
        dataDetail[indexExist].stok_selisih = isNaN(parseInt(qty_stok - Math.abs(stok))) ? 0 : parseInt(qty_stok - Math.abs(stok));
        $(that).closest('tr').find('td.stok_selisih').html(
            `${dataDetail[indexExist].stok_selisih >= 0 ? `<span class="text-success"> <i class="fa fa-angle-up"></i> ${dataDetail[indexExist].stok_selisih}</span>` : `<span class="text-danger"> <i class="fa fa-angle-down"></i> ${dataDetail[indexExist].stok_selisih}</span>`}`
        );
    }

    function changeQty(that, id)
    {
        const indexEdit = dataDetail.findIndex(item => item.id == id);
        if($(that).val() < 0 && $(that).val() != '') {
            showErrorAlert('Stok Aktual tidak boleh kurang dari 0');
            $(that).val(0);
        }
        dataDetail[indexEdit].qty_stok = parseInt($(that).val());
        sumSelisih(that, id);
    }

    function removeDetailArr(id)
    {
        const newData = dataDetail.filter(item => item.id != id);
        dataDetail = newData;
        renderTable();
    }

    function formatResultAdjustment(item) {
        if (item.loading) {
            return item.text;
        }

        var $container = $(
            "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__meta'>" +
                    "<div class='select2-result-repository__kode_produk'></div>" +
                    "<div class='select2-result-repository__nama_produk'></div>" +
                "</div>" +
            "</div>"
        );

        $container.find(".select2-result-repository__kode_produk").text(item.kode_produk);
        $container.find(".select2-result-repository__nama_produk").text(item.nama_produk);

        return $container;
    }

    function formatResultAdjustmentSelection(item) {
     return item.text;
    }

</script>
@endpush
