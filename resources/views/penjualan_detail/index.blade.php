@extends('layouts.master')

@section('title')
    Transaksi Penjualan
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

    .table-penjualan tbody tr:last-child {
        display: none;
    }

    .select2-container--default .select2-selection--single {
        border-radius: unset;
        height: 35px;
    }

    @media(max-width: 768px) {
        .tampil-bayar {
            font-size: 3em;
            height: 70px;
            padding-top: 5px;
        }
    }
</style>
@endpush

@section('breadcrumb')
    @parent
    <li class="active">Transaksi Penjaualn</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-body">
                    
                <form class="form-produk">
                    @csrf
                    <div class="form-group row">
                        <label for="kode_produk" class="col-md-3">Cari Berdasar Kode / Nama Produk -> </label>
                        <div class="col-lg-8">
                            <div class="input-group">
                                <select class="pilih-product select2 form-control" style="width:500px;"></select>
                            </div>
                        </div>
                    </div>
                </form>

                <table class="table table-bordered" id="tablePenjualan">
                    <thead>
                        <th width="5%">No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th class="text-right">Harga</th>
                        <th class="text-right" width="15%">Jumlah</th>
                        <th class="text-right">Diskon</th>
                        <th class="text-right">Subtotal</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="8" class="text-center">Belum ada data</td>
                        </tr>
                    </tbody>
                </table>
                <hr>
                <div class="row" id="detailTransaksi">
                    <div class="col-lg-8">
                        <div class="tampil-bayar bg-primary">0</div>
                        <div class="tampil-terbilang"></div>
                    </div>
                    <div class="col-lg-4">
                        
                            
                            <input type="hidden" name="total" id="total">
                            <input type="hidden" name="total_item" id="total_item">
                            <input type="hidden" name="bayar" id="bayar">

                            <div class="form-group row">
                                <label for="totalrp" class="col-lg-2 control-label">Total</label>
                                <div class="col-lg-8">
                                    <input type="text" id="totalrp" class="form-control text-right" readonly>
                                </div>
                            </div>
                            {{-- <div class="form-group row">
                                <label for="kode_member" class="col-lg-2 control-label">Member</label>
                                <div class="col-lg-8">
                                    
                                </div>
                            </div> --}}
                            <div class="form-group row">
                                <label for="diskon" class="col-lg-2 control-label">Diskon</label>
                                <div class="col-lg-8">
                                    <input type="number" name="diskon" id="diskon" class="form-control text-right" 
                                        value="{{$diskon}}" 
                                        readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="bayar" class="col-lg-2 control-label">Bayar</label>
                                <div class="col-lg-8">
                                    <input type="text" id="bayarrp" class="form-control text-right" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="diterima" class="col-lg-2 control-label">Diterima</label>
                                <div class="col-lg-8">
                                    <input type="number" id="diterima" onchange="diterimaUang(this)" onkeyup="diterimaUang(this)" class="form-control text-right" name="diterima" value="{{ $penjualan->diterima ?? 0 }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kembali" class="col-lg-2 control-label">Kembali</label>
                                <div class="col-lg-8">
                                    <input type="text" id="kembali" name="kembali" class="form-control text-right" value="0" readonly>
                                </div>
                            </div>
                        
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <button type="button" class="btn btn-primary btn-flat pull-right" onclick="simpan(this)"><i class="fa fa-floppy-o"></i> Simpan Transaksi</button>
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

    $('.pilih-product').on('select2:select', function (e) {
        var data = e.params.data;
        storeOptionProduct(data);
        $(".pilih-product").val('').trigger('change');
        renderTable();
        console.log(dataDetail);
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
        dataDetail[indexEdit].qty_order = $(that).val();
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
            const row = dataDetail.map((item, index) => `<tr>
                <td>${index+1}</td>
                <td><small class="label bg-primary">${item.kode_produk}</small></td>
                <td>${item.nama_produk}</td>
                <td class="text-right">${formatMoney(item.harga_jual)}</td>
                <td class="text-right">
                    <input type="number" min="0" class="form-control text-right" value="${item.qty_order}" onkeyup="changeQty(this, '${item.id}')" onchange="changeQty(this, '${item.id}')">
                </td>
                <td class="text-right">${item.diskon}</td>
                <td class="text-right subtotal">${formatMoney(item.subtotal)}</td>
                <td><button type="button" class="btn btn-flat btn-danger btn-xs" onclick="removeDetailArr('${item.id}')"><i class="fa fa-trash"></i></button></td>
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
            $(".tampil-bayar").text(formatMoney(totalBayar));
        } else {
            $(".tampil-bayar").text(formatMoney(totalKembalian));
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
        const payloads = {dataDetail, grandTotal, totalBayar, totalKembalian, diterima};
        console.log(payloads);
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
     return item.kode_produk;
    }

</script>
@endpush