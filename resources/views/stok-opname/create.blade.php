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

        .table-scroll {
            overflow-y: scroll;
            height: 500px;
        }

        .sticky {
            position: fixed;
            top: 0;
            z-index: 9999;
            width: 75%;
        }

        @media  only screen and (max-width: 990px) {
            .freeze {
                position: -webkit-sticky;
                position: sticky;
                background-color: grey !important;
                color: #ffffff !important;
                border-width: 0 !important;
                border-top: unset !important;
            }
            .first-col {
                width: 100px;
                min-width: 30px;
                left: 0px;
            }
            .second-col {
                width: 150px;
                max-width: 165px;
                left: 60px;
                overflow: hidden;
                overflow-x: scroll;
            }
            .second-col::-webkit-scrollbar {
                display: none;
            }
            .table-hover>tbody>tr:hover>* {
                --bs-table-accent-bg: unset;
                color: #495057;
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
                                <label for="id_outlet" class="control-label text-start">Outlet <span class="text-danger">*</span> </label>
                                <select name="id_outlet" id="id_outlet" class="form-control form-control-sm" onchange="selectedOutlet(this)">
                                    <option value="">Pilih Outlet</option>
                                    @foreach ($outlet as $item)
                                        <option value="{{$item->id_outlet}}">{{$item->nama_outlet}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="catatan" class="control-label text-start">Catatan</label>
                                <textarea name="catatan" id="catatan" class="form-control form-control-sm" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div id="resultDetail" class="mt-3" style="display:none;">
                        <div class="row" id="filterEl" style="padding: 10px;background-color: #4ba6ef;border-radius: 10px;color: #fff;">
                                <div class="col-md-1" style="height: 60px;line-height: 60px;">
                                    <h6 class="text-white" style="display: inline-block;vertical-align: middle;line-height: normal;">Filter : </h6>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-2">
                                        <label for="filter_sku">Cari SKU</label>
                                        <input type="text" class="form-control form-control-sm search-key" placeholder="Cari berdasarkan SKU" id="filter_sku_produk" onkeyup="filterTable(this)">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-2">
                                        <label for="filter_produk">Cari Produk</label>
                                        <input type="text" class="form-control form-control-sm search-key" placeholder="Cari berdasarkan nama produk" id="filter_nama_produk" onkeyup="filterTable(this)">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive table-scroll">
                                        <table class="table table-sm table-hover" id="productTable">
                                            <thead>
                                                <tr>
                                                    <th class="text-start">Kode Produk</th>
                                                    <th class="text-start freeze first-col">SKU</th>
                                                    <th class="text-start freeze second-col">Nama Produk</th>
                                                    <th class="text-end">Jumlah Barang (SISTEM)</th>
                                                    <th class="text-end">Jumlah Barang (AKTUAL)</th>
                                                    <th class="text-end">Silisih</th>
                                                    <th class="text-start">Satuan</th>
                                                    <th class="text-end">Nilai Stok (SISTEM)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr><td colspan="9" class="text-center">Data masih kosong, pilih produk pada combobox diatas</td></tr>
                                            </tbody>
                                        </table>
                                    </div>
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
        document.body.setAttribute("data-sidebar-size", "sm");
        $("#id_outlet").select2({ width: '100%' });
        $('body').addClass('sidebar-collapse');

    });

    $(document).on('keyup', '.numbersOnly', function () {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
             this.value = this.value.replace(/[^0-9\.]/g, '');
        }
    });

    function filterTable(that)
    {
        $('#productTable').find('tbody tr').hide().filter(function() {
            return $(this).find('td').filter(function() {
                const tdText = $(this).text().toLowerCase();
                const inputValue = $('#' + $(this).data('input')).val() != undefined ? $('#' + $(this).data('input')).val().toLowerCase() : '';
                return tdText.indexOf(inputValue) != -1;
            }).length == $(this).find('td').length;
        }).show();
    }

    function selectedOutlet(that)
    {
        const val = $(that).val();
        const text = $(that).find('option:selected').text();

        if(val != '') {
            bootbox.confirm({
                closeButton: false,
                title: "Outlet Stok Opname",
                message: `<span style="font-weight:bold;color:red;">Stok Opname</span> pada outlet ${text}, lanjutkan ?`,
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
                        $(that).prop('disabled', true);
                        $.ajax({
                            url: `{{url('persediaan/stok-opname/get-product')}}`,
                            data: {id_outlet: val},
                            beforeSend: function(){
                                blockLoading();
                            }
                        }).done(response => {
                            dataDetail = response.data;
                            renderTable();
                            setTimeout(() => {
                                unBlockLoading();
                                $("#resultDetail").fadeIn(1000);
                            }, 500);
                        }).fail(error => {
                            const respJson = $.parseJSON(error.responseText);
                            showErrorAlert(respJson.message);
                            $(that).val('').trigger('change');
                        })
                    } else {
                        $(that).val('').trigger('change');
                    }
                }
            });
        }
    }

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

                    const id_outlet = $("#id_outlet").val();
                    const catatan = $("#catatan").val();

                    if(id_outlet == '' || id_outlet == null) {
                        showErrorAlert('Gudang harus diisi');
                        return;
                    }
                    if(dataDetail.length == 0) {
                        showErrorAlert('Produk harus berisi minimal 1 baris');
                        return;
                    }
                    const payloads = {dataDetail, id_outlet, catatan};
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

    function renderTable()
    {
        const table = $("#productTable");
        if(dataDetail.length == 0) {
            table.find('tbody').html(`<tr><td colspan="9" class="text-center">Data masih kosong, pilih produk pada combobox diatas</td></tr>`);
        } else {
            const row = dataDetail.map((item, index) => `<tr>
                <td data-input="filter_xxx"><small class="badge bg-primary">${item.kode_produk}</small></td>
                <td data-input="filter_sku_produk" class="freeze first-col"><small class="badge bg-primary">${item.sku_produk}</small></td>
                <td data-input="filter_nama_produk" class="freeze second-col">${item.nama_produk}</td>
                <td data-input="filter_xxx" class="text-end">${item.stok}</td>
                <td data-input="filter_xxx" class="text-end float-end">
                    <input type="text" class="form-control form-control-sm text-end numbersOnly" value="${item.qty_stok}" onkeyup="changeQty(this, '${item.id}')" onchange="changeQty(this, '${item.id}')">
                </td>
                <td data-input="filter_xxx" class="text-end stok_selisih">
                    ${item.stok_selisih >= 0 ? `<span class="text-success"> <i class="fa fa-angle-up"></i> ${item.stok_selisih}</span>` : `<span class="text-danger"> <i class="fa fa-angle-down"></i> ${item.stok_selisih}</span>`}
                </td>
                <td data-input="filter_xxx" class="text-start">${item.nama_uom}</td>
                <td data-input="filter_xxx" class="text-end">Rp. ${formatMoney(item.nilai_stok)}</td>
            </tr>`).join();
            table.find('tbody').html(row);
        }
    }

    function sumSelisih(that, id)
    {
        const indexExist = dataDetail.findIndex(item => item.id == id);
        const stok = dataDetail[indexExist].stok;
        const qty_stok = dataDetail[indexExist].qty_stok;
        dataDetail[indexExist].stok_selisih = isNaN(parseFloat(qty_stok - Math.abs(stok))) ? 0 : parseFloat(qty_stok - Math.abs(stok)).toFixed(2);
        $(that).closest('tr').find('td.stok_selisih').html(
            `${dataDetail[indexExist].stok_selisih >= 0 ? `<span class="text-success"> <i class="fa fa-angle-up"></i> ${dataDetail[indexExist].stok_selisih}</span>` : `<span class="text-danger"> <i class="fa fa-angle-down"></i> ${dataDetail[indexExist].stok_selisih}</span>`}`
        );
    }

    function changeHpp(that, id)
    {
        const indexExist = dataDetail.findIndex(item => item.id == id);
        const new_nilai_stok = $(that).val();
        dataDetail[indexExist].new_nilai_stok = isNaN(parseFloat(new_nilai_stok)) ? 0 : new_nilai_stok;
    }

    function changeQty(that, id)
    {
        const indexEdit = dataDetail.findIndex(item => item.id == id);
        if($(that).val() < 0 && $(that).val() != '') {
            showErrorAlert('Stok Aktual tidak boleh kurang dari 0');
            $(that).val(0);
        }
        dataDetail[indexEdit].qty_stok = parseFloat($(that).val());
        sumSelisih(that, id);
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
