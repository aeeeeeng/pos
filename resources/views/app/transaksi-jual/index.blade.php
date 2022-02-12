@extends('app.layouts.master')

@section('title')
    Transaksi Jual
@endsection

@push('css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <style>
        .card {
            border: unset;
        }
        #thumbnail .card-title {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box !important;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
        }
        .navbar-header {
            max-width: 100% !important;
            padding-right: 10px !important;
            padding-left: 10px !important;
        }
        .container-fluid {
            max-width: 100% !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
        .spinner-border {
            width: 5rem;
            height: 5rem;
        }
        .image-product {
            width: 100%;
            max-height: 150px;
            /* border-radius: 15px; */
            /* margin-left: 0; */
            overflow: hidden;
            /* background-color: #363fff; */
            /* margin: 0 auto; */
            vertical-align: middle;
            padding: 0 10px;
            /* border: 5px solid #5156bf; */
            border-radius: 15px;
        }
        .image-product img {
            width: 100%;
            height: 100%;
            vertical-align: middle;
            border: 0;
            overflow: hidden;
        }

        .no-image-product {
            text-transform: uppercase!important;
            width: 100%;
            height: 150px;
            padding: 8px 0;
            text-align: center;
            border-radius: 2px;
            margin: 0 auto;
            vertical-align: middle;
            color: #fff;
            font-weight: 800;
            font-size: 80px;
        }

        .product-title {
            text-align: center;
        }

        #selectedItem {
            position: fixed;
            bottom: 20px;
            width: 300px;
            background-color: #5156bf;
            margin-bottom: 10px;
            border: none;
            box-shadow: 0 8px 18px 0 rgb(0 0 0 / 68%);
            border-radius: 100px;
            z-index: 9;
            left: 50%;
            margin-left: -135px;
        }
        .ui-effects-transfer { border: 2px dotted gray; }
        .table-summary>:not(caption)>*>* {
            border-bottom: unset;
        }

        .select2-container--default .select2-selection--single {
            height: 40px;

        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 37px;
        }

        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #b7bec5;
            font-size: 13px;
        }

        .select2-container--default .select2-selection--single .select2-selection__clear {
            height: 38px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 8px;
        }

        .grand-total-bottom {
            position: absolute;bottom: 0;bottom: 0;left: 0;width: 100%;padding: 10px;background-color: #fff; box-shadow:0 -8px 12px 0 rgb(0 0 0 / 20%);
        }

        body[data-layout-mode=dark] .grand-total-bottom {
            background-color: #313533;
        }

        .loading-summary {
            position: absolute;height: 100%;width: 100%;background-color: #fff;z-index: 9;top: 0;left: 0;
        }

        body[data-layout-mode=dark] .loading-summary {
            background-color: #313533;
        }

        @media (max-width: 768px) {
            #thumbnail .image-product {
                position: absolute;
                left: 10px;
                top: 50%;
                transform: translateY(-50%);
                width: 100px;
                max-height: 100px;
            }

            #thumbnail .no-image-product {
                position: absolute;
                left: 10px;
                top: 50%;
                transform: translateY(-50%);
                width: 100px;
                max-height: 100px;
                font-size: 40px;
            }

            #thumbnail .product-title {
                text-align: right;
            }

            #thumbnail .card-footer .btn-primary.btn-rounded, #thumbnail .row.border.border-primary {
                max-width: 200px;
                float: right;
            }

            #thumbnail .card-footer {
                border-top: none;
            }
        }

    </style>
@endpush

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Transaksi Jual</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-center">
                    <div style="overflow-x:scroll;">
                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                            @foreach ($kategori as $i => $item)
                                <input type="radio" class="btn-check" name="kategori" autocomplete="off" value="{{$item->id_kategori}}" id="{{$item->id_kategori}}" {{$i == 0 ? 'checked' : ''}}>
                                <label class="btn btn-outline-primary btn-lg text-nowrap" for="{{$item->id_kategori}}">{{$item->nama_kategori}}</label>
                            @endforeach
                        </div>
                    </div>
                    <div class="row justify-content-center">
                            <div class="col-xl-8">
                                <form class="app-search d-lg-block mb-2" onsubmit="cariProduk(this)">
                                    <div class="position-relative">
                                        <input type="text" class="form-control" placeholder="Cari Produk..." id="cari" autocomplete="off">
                                        <button class="btn btn-primary" type="submit"><i class="bx bx-search-alt align-middle"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                </div>
                <div class="card-body">
                    <div class="row justify-content-md-center" id="thumbnail"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="hiddenCart" style="display:none;"></div>
    <div class="card" id="selectedItem" style="cursor:pointer; display:none;"
        data-bs-toggle="offcanvas"
        data-bs-target="#summary"
        aria-controls="summary" onclick="openSummary()">
        <div class="card-body">
            <button type="button" class="btn btn-sm btn-primary btn-rounded" style="position: absolute;left: -35px;" onclick="resetSelected()"> <i class="fas fa-trash"></i> </button>
            <div class="row">
                <div class="col-4">
                    <div class="float-start text-start">
                        <h5 class="text-white" id="itemDipilih">0 <i class="fas fa-shopping-cart"></i></h5>
                    </div>
                </div>
                <div class="col-8">
                    <div class="float-end text-end">
                        <h5 class="text-white"><span id="totalHarga">Rp. 100.000</span </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
@includeIf('app.transaksi-jual.add-to-cart')
@includeIf('app.transaksi-jual.detail-add-opt-cart')
@includeIf('app.transaksi-jual.summary')
@includeIf('app.transaksi-jual.payment')
@includeIf('app.transaksi-jual.discount-a')
@endsection

@push('scripts')
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script>

    let id_kategori = $("input[name=kategori]").val();
    let cari = $("#cari").val();
    let product = [];
    let cart = [];

    let tmpAddOpt = [];
    let tmpCart = [];

    let member = {}, grandTotal = 0, promo = [], promoManual = [], promoTotal = 0, customAmmount = 0, diskon = {tipe:'', val:''}, catatan = '', finalTotal = 0;

    $(document).ready(function(){
        $('#modal-form').modal({backdrop: 'static', keyboard: false});
        loadData();
    });

    $(window).bind('scroll resize', function() {
        $('.card-header.text-center')
        .css('position', 'sticky')
        .css('top', $(this).scrollTop());
        if($(this).scrollTop() > 180) {
            $('.card-header.text-center')
            .css('box-shadow', '0 8px 12px 0 rgb(0 0 0 / 20%)')
            .css('border-bottom-right-radius', '15px')
            .css('border-bottom-left-radius', '15px')
            .css('z-index', '1002');
        } else {
            $('.card-header.text-center')
            .css('box-shadow', 'unset')
            .css('border-bottom-right-radius', '0')
            .css('border-bottom-left-radius', '0')
            .css('z-index', '99');
        }
    });


    $('input[type=radio][name=kategori]').on('change', function() {
        id_kategori = $(this).val();
        loadData();
    });

    function cariProduk(that)
    {
        event.preventDefault();
        cari = $("#cari").val();
        loadData();
    }

    function loadData()
    {
        $.ajax({
            url: `{{url('app/transaksi-jual/get-data-produk')}}`,
            dataType: 'json',
            contentType: 'application/json',
            data: {id_kategori, cari},
            beforeSend: function() {
                loadingCard();
            }
        }).done(response => {
            const {data} = response;
            if(data.length < 1) {
                $("#thumbnail").html(`<div class="col-md-12 col-xl-12"> <p class="text-center">Tidak Ditemukan Data</p> </div>`);
                return;
            }
            product = data;
            renderThumbnail();
        }).fail(error => {
            const respJson = $.parseJSON(error.responseText);
            showErrorAlert(respJson.message);
            $("#thumbnail").html('');
        });
    }

    function renderThumbnail()
    {
        const rowProduct = product.map(item => {
            return `<div class="col-xs-6 col-md-4 col-xxl-2" id="thumbnail${item.id_produk}">
                        <div class="card" style="box-shadow:0 8px 12px 0 rgb(0 0 0 / 20%); border-radius: 15px;">
                            <div class="card-body product-title">
                                <h6 class="card-title"
                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="${item.nama_produk}">${item.nama_produk}</h6>
                                <h6 class="card-subtitle text-muted">Rp. ${formatMoney(item.harga_jual)}</h6>
                            </div>
                            ${(() => {
                                const url = `{{url('/')}}`;
                                if(item.gambar == '' || item.gambar == null) {
                                    return `<div class="img-fluid no-image-product mb-2" style="background-color:${backgroundColor(Math.floor(Math.random() * 10))}">${item.imageText}</div>`;
                                }
                                return `<div class="img-fluid image-product mb-2">
                                            <img src="${url}/img/produk-image/${item.gambar}">
                                        </div>`;
                            })()}
                            <div class="card-footer" style="border-bottom-right-radius: 15px;border-bottom-left-radius: 15px;">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button class="btn btn-primary btn-rounded w-100 text-center" onclick="selectProduct(this, '${item.id_produk}')">Tambah</button>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>`;
        }).join(' ');
        $("#thumbnail").html(rowProduct);
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
        renderQty();
    }

    function selectProduct(that, id_produk)
    {
        $("#modal-form").find('#storeAddOptDetail').attr('onclick', `storeAddOpt()`);
        $("#closeDetailAddOpt").trigger('click');
        addToCart(id_produk);
    }



    function addToCart(id_produk)
    {
        $.ajax({
            url: `{{url('app/transaksi-jual/get-add-opt')}}/` + id_produk,
            success: function(response) {
                const {data} = response;
                if(data.length == 0) {
                    const productSelected = product.find(item => item.id_produk == id_produk);
                    const isExist = cart.find(item => item.id_produk == id_produk);
                    if(!isExist) {
                        cart.push({
                            key: cart.length + 1, qty_order: 1, subtotal: 1 * productSelected.harga_jual, ...productSelected});
                    }
                    renderQty();
                } else {
                    const productSelected = product.find(item => item.id_produk == id_produk);
                    renderQtyAddOpt(data, productSelected);
                }
            }
        });
    }



    function renderGrandTotalPrice()
    {
        $("#grandTotal").text(`Rp. ${formatMoney(tmpCart.subtotal)}`);
    }

    function storeAddOpt()
    {
        const checkExist = cart.find(item => {
            if(item.id_produk == tmpCart.id_produk) {
                if(tmpCart.addOpt == false || tmpCart.addOpt.length == 0) {
                    return item;
                } else {
                    return item.addOpt.find(header1 => {
                        return tmpCart.addOpt.find(header2 => {
                            if(header1.id_add_opt_detail == header2.id_add_opt_detail) {
                                return item;
                            }
                        })
                    })
                }
            }
        });

        if(checkExist) {
            checkExist.qty_order = checkExist.qty_order + tmpCart.qty_order;
            if(tmpCart.addOpt == true || tmpCart.addOpt.length > 0) {
                checkExist.addOpt.map(detail1 => {
                    tmpCart.addOpt.map(detail2 => {
                        if(detail1.id_add_opt_detail == detail2.id_add_opt_detail) {
                            detail1.qty_order_detail = detail1.qty_order_detail + detail2.qty_order_detail;
                        }
                    })
                })
            }
            $("#modal-form").modal('hide');
            renderQty();
            renderSelected();
            return;
        }

        cart.push(tmpCart);
        $("#modal-form").modal('hide');
        renderQty();
        renderSelected();
    }



    function renderQty()
    {
        let AllSelected = cart;
        cart.map(selected => {

            if(selected.qty_order == 0) {
                const newData = cart.filter(item => item.key != selected.key);
                cart = newData;
            }

            const totalQty = cart.filter(item => item.id_produk == selected.id_produk).reduce((prev, next) => prev + next.qty_order, 0);
            let htmlQty = '';

            if(totalQty == 0) {
                htmlQty = `<div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-primary btn-rounded form-control text-center" id="" onclick="selectProduct(this, '${selected.id_produk}')">Tambah</button>
                                </div>
                            </div>`;
            } else {
                if(selected.addOpt) {

                    htmlQty = `<div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-primary btn-rounded w-100 text-center" data-bs-toggle="offcanvas" data-bs-target="#detailAddOptCartBottom" onclick="openDetailAddOpt(this, '${selected.id_produk}')">${totalQty} Item</button>
                                </div>
                            </div>`;
                } else {
                    htmlQty = `<div class="row border border-primary" style="padding: 10px 0;border-radius: 10px;">
                                    <div class="col-md-12">
                                        <div class="qty-update">
                                            <div class="d-flex flex-wrap gap-4 align-items-center justify-content-center">
                                                <button type="button" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light" onclick="minQty(this, '${selected.key}')">
                                                    <i class="fas fa-minus-circle"></i>
                                                </button>
                                                <span class="text-primary" style="margin-top: 5px;">${totalQty}</span>
                                                <button type="button" class="btn btn-success btn-sm btn-rounded waves-effect waves-light" onclick="plusQty(this, '${selected.key}')">
                                                    <i class="fas fa-plus-circle"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
                }
            }
            $(`#thumbnail${selected.id_produk}`).find('.card-footer').html(htmlQty);
        });
        renderSelected();
    }

    function plusQty(that, key)
    {
        let selected = cart.find(item => item.key == key);
        selected.qty_order = selected.qty_order + 1;
        selected.subtotal = selected.qty_order * selected.harga_jual;
        renderQty();
    }

    function minQty(that, key)
    {
        let selected = cart.find(item => item.key == key);
        selected.qty_order = selected.qty_order - 1;
        selected.subtotal = selected.qty_order * selected.harga_jual;
        renderQty();
    }

    function renderSelected()
    {
        console.log(cart);

        if(cart.length) {
            $("#selectedItem").fadeOut(function(){
                $("#selectedItem").fadeIn();
                const total = cart.reduce((prev, next) => prev + next.subtotal, 0);
                const totalQty = cart.reduce((prev, next) => prev + next.qty_order, 0);
                $("#itemDipilih").html(`(${totalQty}) <i class="fas fa-shopping-cart"></i>`);
                $("#totalHarga").text(`Rp. ${formatMoney(total)}`);
                $("#selectedItem").effect("shake", {
                    times: 2
                }, 200);
            });
        } else {
            $("#selectedItem").fadeOut();
            $("#itemDipilih").html(`0 <i class="fas fa-shopping-cart"></i>`);
            $("#totalHarga").text(`Rp. 0`);
        }
    }

    function loadingCard()
    {
        $("#thumbnail").html(`<div class="text-center">
            <div class="spinner-border text-primary m-1" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>`);
    }

    function resetSelected()
    {
        cart = [];
        renderSelected();
        renderThumbnail();
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

</script>
    @includeIf('app.transaksi-jual.js-add-opt-cart')
    @includeIf('app.transaksi-jual.js-summary')
    @includeIf('app.transaksi-jual.js-a-discount')
@endpush
