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

    .absolute-center {
        position: absolute;
        top: 40%;
        right: 30%;
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
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label for="id_outlet">Outlet <span class="text-danger">*</span></label>
                            <select name="id_outlet" id="id_outlet" class="form-control form-control-sm">
                                <option value="">Pilih Outlet</option>
                                @foreach ($outlet as $item)
                                    <option value="{{$item->id}}" {{$item->id == session()->get('outlet') ? 'selected' : ''}}>{{$item->text}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label for="no_pembelian">No. PO <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="no_pembelian" name="no_pembelian" placeholder="Isi Nomor PO...">
                            <div class="d-flex flex-wrap gap-3 mt-1">
                                <span>Gunakan No. PO Sistem</span>
                                <div class="">
                                    <input type="checkbox" id="autoNoPo" switch="bool" onchange="generateNoPo(this)" />
                                    <label for="autoNoPo" data-on-label="Ya" data-off-label="Tidak" style="min-width: 65px;"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label for="tanggal_pembelian">Tanggal <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="tanggal_pembelian" name="tanggal_pembelian" placeholder="Klik untuk memilih tanggal...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group ">
                            <label for="tanggal_pembelian">Catatan</label>
                            <textarea name="catatan" id="catatan" class="form-control form-control-sm" cols="30" rows="5" placeholder="Isi Keterangan atau Catatan..."></textarea>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-2 form-group">
                            <select class="pilih-product select2 form-control form-control-sm"></select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover" id="tablePembelian">
                                <thead>
                                    <th width="5%">No</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th class="text-end">HPP (SISTEM)</th>
                                    <th class="text-end">Stok Akhir</th>
                                    <th class="text-end">Harga</th>
                                    <th class="text-end">Jumlah</th>
                                    <th class="text-start">Satuan</th>
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
                    <div class="col-lg-6">
                        <div class="tampil-bayar bg-primary text-white"></div>
                    </div>
                    <div class="col-lg-6">
                        <div class="d-flex flex-wrap gap-3 align-items-center text-center absolute-center">
                            <button type="button" onclick="back(this)" class="btn btn-secondary btn-sm btn-flat float-end btn-simpan"><i class="fa fa-arrow-left"></i> &nbsp; Kembali</button>
                            <button type="submit" onclick="simpan(this)" class="btn btn-primary btn-sm btn-flat float-end btn-simpan"><i class="fa fa-save"></i> &nbsp; Simpan Transaksi</button>
                            <button type="submit" onclick="simpan(this, true)" class="btn btn-success btn-sm btn-flat float-end btn-simpan"><i class="fa fa-save"></i> &nbsp; Simpan & Terima Barang</button>
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
    let dataDetail = [];
    let grandTotal = 0;
    let totalBayar = 0;
    let diskon = 0;
    let id_supplier = `{{$supplier->id_supplier}}`;

    $(document).ready(function(){
        document.body.setAttribute("data-sidebar-size", "sm");

        var f3 = flatpickr(document.getElementById('tanggal_pembelian'), {
            dateFormat: "d/m/Y"
        });

        $("#id_outlet").select2({ width: '100%'});
    });

    $(".pilih-product").select2({
        width: "100%",
        placeholder: "Pilih Barang Melalui Kode/Nama",
        allowClear: true,
        ajax: {
            url: "{{url('pembelian_detail/get-data-product')}}",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page,
                    id_outlet: $("#id_outlet").val()
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

    $(document).on('keyup', '.numbersOnly', function () {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
             this.value = this.value.replace(/[^0-9\.]/g, '');
        }
    });

    $('.pilih-product').on('select2:select', function (e) {
        var data = e.params.data;
        storeOptionProduct(data);
        $(".pilih-product").val('').trigger('change');
        renderTable();
        sumGrandTotal();
        sumTotalBayar();
    });

    function generateNoPo(that)
    {
        const isChecked = $(that).is(':checked');
        if(isChecked) {
            $.ajax({
                url: `{{url('pembelian_detail/generate-no-po')}}`,
            }).done(response => {
                $("#no_pembelian").val(response.data.lastNoPo).prop('disabled', true);
            }).fail(error => {
                const respJson = $.parseJSON(error.responseText);
                showErrorAlert(respJson.message);
            });
        } else {
            $("#no_pembelian").val('').prop('disabled', false);
        }
    }

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
        dataDetail[indexEdit].qty_order = parseFloat($(that).val());
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
        dataDetail[indexEdit].harga_beli = parseFloat($(that).val());
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
                    <input type="text" min="0" class="form-control form-control-sm text-end numbersOnly" value="${item.harga_beli}" onkeyup="changeHargaBeli(this, '${item.id}')" onchange="changeHargaBeli(this, '${item.id}')">
                </td>
                <td class="text-end">
                    <input type="text" min="0" class="form-control form-control-sm text-end numbersOnly" value="${item.qty_order}" onkeyup="changeQty(this, '${item.id}')" onchange="changeQty(this, '${item.id}')">
                </td>
                <td class="text-start">${item.nama_uom == '' ? '-' : item.nama_uom}</td>
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

    function simpan(that, terima = false)
    {
        event.preventDefault();
        const id_outlet = $("#id_outlet").val();
        const no_pembelian = $("#no_pembelian").val();
        const tanggal_pembelian = $("#tanggal_pembelian").val();
        const catatan = $("#catatan").val();

        const payloads = {id_outlet, no_pembelian, tanggal_pembelian, catatan, dataDetail, grandTotal, id_supplier, terima};

        if(id_outlet == '' || no_pembelian == '' || tanggal_pembelian == '') {
            showErrorAlert('tanda berwarna bintang merah, wajib diisi');
            return;
        }

        if(dataDetail.length == 0) {
            showErrorAlert('Produk harus berisi minimal 1 baris');
            return;
        }

        $.ajax({
            url: "{{url('pembelian_detail/store')}}" ,
            type: "POST",
            dataType: "json",
            contentType: "application/json",
            data: JSON.stringify(payloads),
            beforeSend: () => {
                buttonLoading($(that));
            }
        }).done(response => {
            showSuccessAlert(response.message);
            setTimeout(() => {
                window.location.href = `{{url('pembelian')}}`;
            }, 500);
        }).fail(error => {
            const respJson = $.parseJSON(error.responseText);
            showErrorAlert(respJson.message);
        }).always(() => {
            setTimeout(() => {
                buttonUnloading($(that));
            }, 500);
        })

    }

    function back(that)
    {
        window.location.href = `{{url('pembelian')}}`;
    }

</script>
@endpush
