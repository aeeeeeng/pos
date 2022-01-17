@extends('layouts.master')

@section('title')
    Transaksi Pembelian
@endsection

@push('css')
<style>
    .tampil-bayar {
        font-size: 5em;
        text-align: center;
        height: 100px;
    }

    .tampil-terbilang {
        padding: 10px;
        background: #f0f0f0;
    }

    .table-pembelian tbody tr:last-child {
        display: none;
    }

    .select2-container--default .select2-selection--single {
        border-radius: unset;
        height: 35px;
    }

    @media(max-width: 768px) {
        .tampil-bayar {
            font-size: 20px;
            position: fixed;
            height: 60px;
            bottom: 0;
            left: 0;
            z-index: 9;
            width: 100%;
        }
    }
</style>
@endpush

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item">Pembelian</li>
    <li class="breadcrumb-item active">Transaksi Pembelian</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">

            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table>
                            <tr>
                                <th>Supplier</th>
                                <td>: {{ $supplier->nama }}</td>
                            </tr>
                            <tr>
                                <th>Telepon</th>
                                <td>: {{ $supplier->telepon }}</td>
                            </tr>
                            <tr>
                                <th>Alamat</th>
                                <td>: {{ $supplier->alamat }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <div class="float-end">
                            <button class="btn btn-flat btn-md btn-warning" onclick="priceAdjustment()"> <i class="fa fa-coins"></i> &nbsp; Penyesuaian Harga Produk</button>
                        </div>
                        {{-- <div class="pull-right">
                            <span>Jangan Lupa, sesuaikan harga terlebih dahulu sebelum melakukan transaksi pembelian</span>
                        </div> --}}
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-2 form-group">
                            <label for="kode_produk">Cari Produk Berdasar Kode / Nama Produk -> </label>
                            <select class="pilih-product select2 form-control form-control-sm"></select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-sm table-stiped table-bordered" id="tablePembelian">
                                <thead>
                                    <th width="5%">No</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th class="text-end">HPP (SISTEM)</th>
                                    <th class="text-end">Stok Akhir</th>
                                    <th class="text-end">Harga</th>
                                    <th class="text-end">Jumlah</th>
                                    <th class="text-end">Subtotal</th>
                                    <th <i class="fa fa-cog"></i></th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="9" class="text-center">Belum ada data</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <hr>
                <div class="row">
                    <div class="col-lg-5">
                        <div class="tampil-bayar bg-primary text-white"></div>
                    </div>
                    <div class="col-lg-7">

                            <div class="form-group mb-2 row">
                                <label for="totalrp" class="col-lg-2 control-label">Total</label>
                                <div class="col-lg-8">
                                    <input type="text" id="totalrp" class="form-control form-control-sm" readonly>
                                </div>
                            </div>
                            <div class="form-group mb-2 row">
                                <label for="diskon" class="col-lg-2 control-label">Diskon</label>
                                <div class="col-lg-8">
                                    <input type="number" name="diskon" id="diskon" class="form-control form-control-sm" value="" onkeyup="updateDiskon(this)" onchange="updateDiskon(this)">
                                </div>
                            </div>
                            <div class="form-group mb-2 row">
                                <label for="bayar" class="col-lg-2 control-label">Bayar</label>
                                <div class="col-lg-8">
                                    <input type="number" id="bayarrp" class="form-control form-control-sm">
                                </div>
                            </div>

                    </div>
                </div>
            </div>

            <div class="card-footer">
                <center>
                    <button type="submit" onclick="simpan(this)" class="btn btn-primary btn-sm btn-flat pull-right btn-simpan"><i class="fa fa-floppy-o"></i> &nbsp; Simpan Transaksi</button>
                </center>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    let dataDetail = [];
    let grandTotal = 0;
    let totalBayar = 0;
    let diskon = 0;
    let id_supplier = `{{$supplier->id_supplier}}`;

    $(document).ready(function(){
        document.body.setAttribute("data-sidebar-size", "sm");
        $("#diskon").val(diskon);
        $("#totalrp").val(grandTotal);
    });

    $(".pilih-product").select2({
        width: "100%",
        placeholder: "Pilih Barang Melalui Kode/Nama",
        allowClear: true,
        ajax: {
            url: "{{url('transaksi/get-product')}}",
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
        templateResult: formatResult,
        templateSelection: formatResultSelection
    });

    $('.pilih-product').on('select2:select', function (e) {
        var data = e.params.data;
        storeOptionProduct(data);
        $(".pilih-product").val('').trigger('change');
        renderTable();
        sumGrandTotal();
        sumTotalBayar();
    });

    function priceAdjustment()
    {
        $.ajax({
            url: `{{url('pembelian_detail/price-adjustment')}}`,
            success: function(response) {
                bootbox.dialog({
                    closeButton: false,
                    size: "large",
                    title: 'Penyesuaian Harga Produk',
                    message: response
                });
            }
        });
    }

    function updateDiskon(that)
    {
        const valDiskon = $(that).val();
        diskon = valDiskon == '' ? 0 : parseFloat(valDiskon);
        sumTotalBayar();
        setTimeout(() => {
            $(that).val(diskon);
        }, 1000);
    }

    function changeQty(that, id)
    {
        const indexEdit = dataDetail.findIndex(item => item.id == id);
        if($(that).val() < 0) {
            showErrorAlert('Quantity tidak boleh kurang dari 0');
            $(that).val(0);
        }
        dataDetail[indexEdit].qty_order = parseInt($(that).val());
        sumSubTotal(that, id);
        sumGrandTotal();
        sumTotalBayar();
    }

    function changeHargaBeli(that, id)
    {
        const indexEdit = dataDetail.findIndex(item => item.id == id);
        if($(that).val() < 0) {
            showErrorAlert('Harga Beli tidak boleh kurang dari 0');
            $(that).val(0);
        }
        dataDetail[indexEdit].harga_beli = parseInt($(that).val());
        sumSubTotal(that, id);
        sumGrandTotal();
        sumTotalBayar();
    }

    function removeDetailArr(id)
    {
        const newData = dataDetail.filter(item => item.id != id);
        dataDetail = newData;
        renderTable();
        sumGrandTotal();
        sumTotalBayar();
    }

    function storeOptionProduct(selected)
    {
        selected.qty_order = 1;
        selected.harga_beli = 0;
        selected.subtotal = 1 * (selected.harga_beli - (selected.diskon/100*selected.harga_beli));
        const checkExist = dataDetail.filter(item => item.id === selected.id).length > 0 ? true : false;
        if(checkExist) {
            const indexExist = dataDetail.findIndex(item => item.id === selected.id);
            dataDetail[indexExist].qty_order = dataDetail[indexExist].qty_order + 1;
            const harga_beli = dataDetail[indexExist].harga_beli;
            const qty_order = dataDetail[indexExist].qty_order;
            const discount = dataDetail[indexExist].diskon;
            dataDetail[indexExist].subtotal = qty_order * (harga_beli - (discount/100*harga_beli));
        } else {
            dataDetail.push(selected);
        }
    }

    function sumGrandTotal()
    {
        grandTotal = dataDetail.reduce((prev, next) => prev + next.subtotal, 0);
        $("#totalrp").val(formatMoney(grandTotal));
    }

    function renderTable()
    {
        const table = $("#tablePembelian");
        if(dataDetail.length == 0) {
            table.find('tbody').html(`<tr>
                                        <td colspan="9" class="text-center">Belum ada data</td>
                                    </tr>`);
        } else {
            const row = dataDetail.map((item, index) => `<tr>
                <td>${index+1}</td>
                <td><small class="badge bg-primary">${item.kode_produk}</small></td>
                <td>${item.nama_produk}</td>
                <td class="text-end">${formatMoney(item.hpp)}</td>
                <td class="text-end">${item.stok}</td>
                <td class="text-end">
                    <input type="number" min="0" class="form-control form-control-sm text-end" value="${item.harga_beli}" onkeyup="changeHargaBeli(this, '${item.id}')" onchange="changeHargaBeli(this, '${item.id}')">
                </td>
                <td class="text-end">
                    <input type="number" min="0" class="form-control form-control-sm text-end" value="${item.qty_order}" onkeyup="changeQty(this, '${item.id}')" onchange="changeQty(this, '${item.id}')">
                </td>
                <td class="text-end subtotal">${formatMoney(item.subtotal)}</td>
                <td><button type="button" class="btn btn-flat btn-danger btn-sm" onclick="removeDetailArr('${item.id}')"><i class="fa fa-trash"></i></button></td>
            </tr>`).join();
            table.find('tbody').html(row);
        }
    }

    function sumSubTotal(that, id)
    {
        const indexExist = dataDetail.findIndex(item => item.id == id);
        const harga_beli = dataDetail[indexExist].harga_beli;
        const qty_order = dataDetail[indexExist].qty_order;
        const discount = dataDetail[indexExist].diskon;
        dataDetail[indexExist].subtotal = qty_order * harga_beli;
        $(that).closest('tr').find('td.subtotal').text(formatMoney(dataDetail[indexExist].subtotal));

    }

    function sumTotalBayar()
    {
        totalBayar = grandTotal - (grandTotal/100*diskon);
        $("#bayarrp").val(totalBayar);
        $(".tampil-bayar").text(formatMoney(totalBayar));
    }


    function formatResult(item) {
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

    function formatResultSelection(item) {
     return item.text;
    }

    function simpan(that)
    {
        event.preventDefault();
        const payloads = {dataDetail, grandTotal, totalBayar, diskon, id_supplier};
        if(dataDetail.length == 0) {
            showErrorAlert('Produk harus berisi minimal 1 baris');
            return;
        }
        if(totalBayar < 0) {
            showErrorAlert('Total bayar tidak valid');
            return;
        }

        $.ajax({
            url: "{{url('pembelian_detail/store')}}" ,
            type: "POST",
            dataType: "json",
            contentType: "application/json",
            data: JSON.stringify(payloads),
            beforeSend: () => {
                blockLoading();
            }
        }).done(response => {
            showSuccessAlert(response.message);
            unBlockLoading();
            const id_penjualan = response.data.id_penjualan;
            const row = response.data.map(item => {
                return `<tr>
                    <td><small class="badge bg-primary">${item.kode_produk}</small></td>
                    <td>${item.nama_produk}</td>
                    <td class="text-end" ${parseFloat(item.stok_lama) < 0 ? `style="background-color:red;color:#fff;"` : ``}>${item.stok_lama}</td>
                    <td class="text-end">${item.stok_tambah}</td>
                    <td class="text-end">${item.stok_sekarang}</td>
                </tr>`;
            }).join();
            const table = `<table class="table table-sm table-hover table-bordered" style="margin-top:10px;">
            <thead>
                <tr>
                    <th>Kode Produk</th>
                    <th>Nama Produk</th>
                    <th class="text-end">Stok Lama</th>
                    <th class="text-end">Stok Tambah</th>
                    <th class="text-end">Stok Sekarang</th>
                </tr>
            </thead>
            <tbody>${row}</tbody>
            </table>`;
            bootbox.dialog({
                closeButton: false,
                size: "large",
                title: 'Info',
                message: `
                    <div class="alert alert-success alert-dismissible">
                        <i class="fa fa-check icon"></i>
                        Data Transaksi Pembelian Telah Selesai.
                    </div>
                    <hr>
                    <span style="font-size:15px; font-weight:bold;">Informasi Perubahan Stok</span>
                    ${table}
                    <center>
                        <a href="{{url('pembelian')}}" class="btn btn-sm btn-primary btn-flat">Kembali</a>
                    </center>
                `
            });
        }).fail(error => {
            const respJson = $.parseJSON(error.responseText);
            showErrorAlert(respJson.message);
            unBlockLoading();
        });

    }

</script>
@endpush
