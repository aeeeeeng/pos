@extends('layouts.master')

@section('title')
    Transaksi Penjualan
@endsection

@push('css')
<style>
    .tampil-bayar {
        font-size: 3em;
        text-align: center;
        height: 100%;
    }

    .tampil-terbilang {
        padding: 10px;
        background: #f0f0f0;
    }

    .table-penjualan tbody tr:last-child {
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
    <li class="breadcrumb-item active">Transaksi Penjaualn</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">

                <div class="form-group mb-2 row">
                    <label for="kode_produk" class="col-md-3">Cari Member Berdasar Kode / Nama Member -> </label>
                    <div class="col-lg-8">
                        <div class="input-group">
                            <select class="pilih-member select2 form-control form-control-sm" style="width:500px;"></select>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-2 row">
                    <label for="kode_produk" class="col-md-3">Cari Produk Berdasar Kode / Nama Produk -> </label>
                    <div class="col-lg-8">
                        <div class="input-group">
                            <select class="pilih-product select2 form-control form-control-sm" style="width:500px;"></select>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tablePenjualan">
                                <thead>
                                    <th width="5%">No</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th class="text-end">Harga</th>
                                    <th class="text-end" width="15%">Jumlah</th>
                                    <th class="text-end">Diskon</th>
                                    <th class="text-end">Subtotal</th>
                                    <th class="text-center"><i class="fa fa-cog"></i></th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="8" class="text-center">Belum ada data</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <hr>
                <div class="row mb-3" id="detailTransaksi">
                    <div class="col-lg-5">
                        <div class="tampil-bayar bg-primary text-white">Total Belanja<br>0</div>
                    </div>
                    <div class="col-lg-7">


                            <input type="hidden" name="total" id="total">
                            <input type="hidden" name="total_item" id="total_item">
                            <input type="hidden" name="bayar" id="bayar">

                            <div class="form-group mb-2 row">
                                <label for="totalrp" class="col-lg-2 control-label">Total</label>
                                <div class="col-lg-8">
                                    <input type="text" id="totalrp" class="form-control form-control-sm text-end" readonly>
                                </div>
                            </div>
                            {{-- <div class="form-group mb-2 row">
                                <label for="kode_member" class="col-lg-2 control-label">Member</label>
                                <div class="col-lg-8">

                                </div>
                            </div> --}}
                            <div class="form-group mb-2 row">
                                <label for="diskon" class="col-lg-2 control-label">Diskon</label>
                                <div class="col-lg-8">
                                    <input type="number" name="diskon" id="diskon" class="form-control form-control-sm text-end"
                                        value="{{$diskon}}"
                                        readonly>
                                </div>
                            </div>
                            <div class="form-group mb-2 row">
                                <label for="bayar" class="col-lg-2 control-label">Bayar</label>
                                <div class="col-lg-8">
                                    <input type="text" id="bayarrp" class="form-control form-control-sm text-end" readonly>
                                </div>
                            </div>
                            <div class="form-group mb-2 row">
                                <label for="diterima" class="col-lg-2 control-label">Diterima</label>
                                <div class="col-lg-8">
                                    <input type="number" id="diterima" onchange="diterimaUang(this)" onkeyup="diterimaUang(this)" class="form-control form-control-sm text-end" name="diterima" value="{{ $penjualan->diterima ?? 0 }}">
                                </div>
                            </div>
                            <div class="form-group mb-2 row">
                                <label for="kembali" class="col-lg-2 control-label">Kembali</label>
                                <div class="col-lg-8">
                                    <input type="text" id="kembali" name="kembali" class="form-control form-control-sm text-end" value="0" readonly>
                                </div>
                            </div>

                    </div>
                </div>
            </div>

            <div class="card-footer">
                <center>
                    <button type="button" class="btn btn-primary btn-flat" onclick="simpan(this)"><i class="fa fa-floppy-o"></i> &nbsp; Simpan Transaksi</button>
                </center>
            </div>
        </div>
    </div>
</div>

@includeIf('penjualan_detail.produk')
@includeIf('penjualan_detail.member')
@endsection

@push('scripts')
<script>

    let dataDetail = [];
    let grandTotal = 0;
    let totalBayar = 0;
    let totalKembalian = 0;
    let member = null

    $(document).ready(function(){
        document.body.setAttribute("data-sidebar-size", "sm");
    });

    $(".pilih-product").select2({
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

    $(".pilih-member").select2({
        placeholder: "Pilih Member Melalui Kode/Nama",
        allowClear: true,
        ajax: {
            url: "{{url('transaksi/get-member')}}",
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
        templateResult: formatResultMember,
        templateSelection: formatResultSelectionMember
    });

    $('.pilih-product').on('select2:select', function (e) {
        var data = e.params.data;
        storeOptionProduct(data);
        $(".pilih-product").val('').trigger('change');
        renderTable();
        console.log(dataDetail);
    });

    $('.pilih-member').on('select2:select', function (e) {
        var data = e.params.data;
    });

    function storeOptionProduct(selected)
    {
        selected.qty_order = 1;
        selected.subtotal = 1 * (selected.harga_jual - (selected.diskon/100*selected.harga_jual));
        const checkExist = dataDetail.filter(item => item.id === selected.id).length > 0 ? true : false;
        if(checkExist) {
            const indexExist = dataDetail.findIndex(item => item.id === selected.id);
            dataDetail[indexExist].qty_order = dataDetail[indexExist].qty_order + 1;
            const harga_jual = dataDetail[indexExist].harga_jual;
            const qty_order = dataDetail[indexExist].qty_order;
            const discount = dataDetail[indexExist].diskon;
            dataDetail[indexExist].subtotal = qty_order * (harga_jual - (discount/100*harga_jual));
        } else {
            dataDetail.push(selected);
        }
        sumGrandTotal();
        sumTotalBayar();
        renderTampilBayar();
    }

    function changeQty(that, id)
    {
        const indexEdit = dataDetail.findIndex(item => item.id == id);
        if($(that).val() < 0) {
            showErrorAlert('Quantity tidak boleh kurang dari 0');
            $(that).val(1);
        }
        dataDetail[indexEdit].qty_order = parseInt($(that).val());
        sumSubTotal(that, id);
        $("#diterima").val('0').trigger('change');
    }

    function sumSubTotal(that, id)
    {
        const indexExist = dataDetail.findIndex(item => item.id == id);
        const harga_jual = dataDetail[indexExist].harga_jual;
        const qty_order = dataDetail[indexExist].qty_order;
        const discount = dataDetail[indexExist].diskon;
        dataDetail[indexExist].subtotal = qty_order * (harga_jual - (discount/100*harga_jual));
        $(that).closest('tr').find('td.subtotal').text(formatMoney(dataDetail[indexExist].subtotal));
        if(parseInt(qty_order) > dataDetail[indexExist].stok) {
            console.log(parseInt(qty_order), dataDetail[indexExist].stok);
            $(that).closest('tr').css('background-color', '#f5f588');
            showErrorAlert('Stok Tersedia tidak Mencukupi, tetapi masih boleh menyimpan dengan Stok Tersedia Minus');
        } else {
            $(that).closest('tr').css('background-color', 'unset');
        }
        sumGrandTotal();
        sumTotalBayar();
        renderTampilBayar();
    }

    function renderTable()
    {
        const table = $("#tablePenjualan");
        if(dataDetail.length == 0) {
            table.find('tbody').html(`<tr>
                                        <td colspan="8" class="text-center">Belum ada data</td>
                                    </tr>`);
        } else {
            const row = dataDetail.map((item, index) => `<tr ${item.qty_order > item.stok ? `style="background-color:#f5f588"` : ''}>
                <td>${index+1}</td>
                <td><small class="badge bg-primary">${item.kode_produk}</small></td>
                <td>${item.nama_produk}</td>
                <td class="text-end">${formatMoney(item.harga_jual)}</td>
                <td class="text-end">
                    <input type="number" min="0" class="form-control form-control-sm text-end" value="${item.qty_order}" onkeyup="changeQty(this, '${item.id}')" onchange="changeQty(this, '${item.id}')">
                </td>
                <td class="text-end">${item.diskon}</td>
                <td class="text-end subtotal">${formatMoney(item.subtotal)}</td>
                <td class="text-center"><button type="button" class="btn btn-flat btn-danger btn-sm" onclick="removeDetailArr('${item.id}')"><i class="fa fa-trash"></i></button></td>
            </tr>`).join();
            table.find('tbody').html(row);
        }
    }

    function sumGrandTotal()
    {
        grandTotal = dataDetail.reduce((prev, next) => prev + next.subtotal, 0);
        $("#totalrp").val(formatMoney(grandTotal));
    }

    function sumTotalBayar()
    {
        const diskon = parseFloat($("#diskon").val());
        totalBayar = grandTotal - (grandTotal/100*diskon);
        $("#bayarrp").val(formatMoney(totalBayar));
    }

    function renderTampilBayar()
    {
        if($("#diterima").val() == 0 || $("#diterima").val() == '' || $("#diterima").val() == null) {
            $(".tampil-bayar").html(`Total Belanja <br> ${formatMoney(totalBayar)}`);
        } else {
            $(".tampil-bayar").html(`Kembalian <br> ${formatMoney(totalKembalian)}`);
        }
    }

    function diterimaUang(that)
    {
        const value = $(that).val();
        if(value == 0 || value == '' || value == null) {
            totalKembalian = 0;
        } else {
            totalKembalian = value - totalBayar;
        }
        $("#kembali").val(formatMoney(totalKembalian));
        renderTampilBayar();
    }

    function removeDetailArr(id)
    {
        const newData = dataDetail.filter(item => item.id != id);
        console.log(newData);
        dataDetail = newData;
        renderTable();
        sumGrandTotal();
        sumTotalBayar();
        renderTampilBayar();
        $("#diterima").val('0').trigger('change');
    }

    function simpan(that)
    {
        event.preventDefault();
        const diterima = $("#diterima").val();
        const member = $(".pilih-member").val();
        const diskon = `{{$diskon}}`;
        const payloads = {dataDetail, grandTotal, totalBayar, totalKembalian, diterima, member, diskon};
        if(dataDetail.length == 0) {
            showErrorAlert('Produk harus berisi minimal 1 baris');
            return;
        }
        if(totalKembalian < 0) {
            showErrorAlert('Uang yang diterima tidak valid');
            return;
        }
        if(totalBayar == 0) {
            showErrorAlert('Total bayar tidak valid');
            return;
        }

        $.ajax({
            url: "{{url('transaksi/simpan')}}" ,
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
            $.ajax({
                url: `{{url('transaksi/selesai')}}?id_penjualan=${id_penjualan}`,
                success: function(response) {
                    bootbox.dialog({
                        closeButton: false,
                        size: "medium",
                        title: 'Penjualan telah selesai',
                        message: response
                    });
                }
            });
        }).fail(error => {
            const respJson = $.parseJSON(error.responseText);
            showErrorAlert(respJson.message);
            unBlockLoading();
        });

    }

    function mustBeNumber(that)
    {
        if($(that).val() == '' || $(that).val() == null) {
            $(that).val('0');
        }
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

    function formatResultMember(item) {
        if (item.loading) {
            return item.text;
        }

        var $container = $(
            "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__meta'>" +
                    "<div class='select2-result-repository__kode_member'></div>" +
                    "<div class='select2-result-repository__nama_member'></div>" +
                "</div>" +
            "</div>"
        );

        $container.find(".select2-result-repository__kode_member").text(item.kode_member);
        $container.find(".select2-result-repository__nama_member").text(item.nama_member);

        return $container;
    }

    function formatResultSelectionMember(item) {
        if(item.kode_member == undefined || item.nama_member == undefined) {
            return item.text;
        }
        return item.kode_member + ' - ' + item.nama_member;
    }


    /// SELESAI

    document.cookie = "innerHeight=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";

    function notaKecil(url, title) {
        popupCenter(url, title, 625, 500);
    }

    function notaBesar(url, title) {
        popupCenter(url, title, 900, 675);
    }

    function popupCenter(url, title, w, h) {
        const dualScreenLeft = window.screenLeft !==  undefined ? window.screenLeft : window.screenX;
        const dualScreenTop  = window.screenTop  !==  undefined ? window.screenTop  : window.screenY;

        const width  = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        const height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

        const systemZoom = width / window.screen.availWidth;
        const left       = (width - w) / 2 / systemZoom + dualScreenLeft
        const top        = (height - h) / 2 / systemZoom + dualScreenTop
        const newWindow  = window.open(url, title,
        `
            scrollbars=yes,
            width  = ${w / systemZoom},
            height = ${h / systemZoom},
            top    = ${top},
            left   = ${left}
        `
        );

        if (window.focus) newWindow.focus();
    }

</script>
@endpush
