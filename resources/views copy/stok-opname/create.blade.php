@extends('layouts.master')

@section('title')
    Buat Stok Opname
@endsection

@section('breadcrumb')
    @parent
    <li class="">Persediaan</li>
    <li class="">Stok Opname</li>
    <li class="active">Buat Stok Opname</li>
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
                &nbsp;
            </div>
            <div class="box-body table-responsive">
                <form onsubmit="store(this)" id="formStokOpname" class="">    
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label for="id_gudang" class="col-sm-2 control-label text-left">Gudang <span class="text-red">*</span> </label>
                            <div class="col-sm-5">
                                <select name="id_gudang" id="id_gudang" class="form-control">
                                    <option value="">Pilih Gudang</option>
                                    @foreach ($gudang as $item)
                                        <option value="{{$item->id_gudang}}">{{$item->kode_gudang . ' - ' . $item->nama_gudang}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="catatan" class="col-sm-2 control-label text-left">Catatan</label>
                            <div class="col-sm-5">
                                <textarea name="catatan" id="catatan" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12">
                            <select class="pilih-product-adjustment select2 form-control"></select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-hover" id="productTable">
                                <thead>
                                    <tr>
                                        <th class="text-left">No</th>
                                        <th class="text-left">Kode Produk</th>
                                        <th class="text-left">Nama Produk</th>
                                        <th class="text-right">Jumlah Barang (SISTEM)</th>
                                        <th class="text-right">Jumlah Barang (AKTUAL)</th>
                                        <th class="text-right">Silisih</th>
                                        <th class="text-right">Harga Unit (SISTEM)</th>
                                        <th class="text-left">#</th>
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
                            <div class="pull-right">
                                <button type="button" class="btn btn-flat btn-secondary" onclick="window.location.href = '{{url('persediaan/stok-opname')}}'"> Batal </button>
                                <button type="submit" class="btn btn-flat btn-primary"> Simpan </button>
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
                <td><small class="label bg-primary">${item.kode_produk}</small></td>
                <td>${item.nama_produk}</td>
                <td class="text-right">${item.stok}</td>
                <td class="text-right">
                    <input type="number" min="0" class="form-control text-right" value="${item.qty_stok}" onkeyup="changeQty(this, '${item.id}')" onchange="changeQty(this, '${item.id}')">
                </td>
                <td class="text-right stok_selisih">
                    ${item.stok_selisih >= 0 ? `<span class="text-success"> <i class="fa fa-angle-up"></i> ${item.stok_selisih}</span>` : `<span class="text-red"> <i class="fa fa-angle-down"></i> ${item.stok_selisih}</span>`}
                </td>
                <td class="text-right">${formatMoney(item.nilai_stok)}</td>
                <td><button type="button" class="btn btn-flat btn-danger btn-xs" onclick="removeDetailArr('${item.id}')"><i class="fa fa-trash"></i></button></td>
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
            `${dataDetail[indexExist].stok_selisih >= 0 ? `<span class="text-green"> <i class="fa fa-angle-up"></i> ${dataDetail[indexExist].stok_selisih}</span>` : `<span class="text-red"> <i class="fa fa-angle-down"></i> ${dataDetail[indexExist].stok_selisih}</span>`}`
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