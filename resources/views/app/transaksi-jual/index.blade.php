@extends('app.layouts.master')

@section('title')
    Transaksi Jual
@endsection

@push('css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <style>
        .spinner-border {
            width: 5rem;
            height: 5rem;
        }
        .image-product {
            width: 150px;
            height: 150px;
            border-radius: 15px;
            margin-left: 0;
            overflow: hidden;
            background-color: #343a40;
            margin: 0 auto;
            vertical-align: middle;
            padding: 10px;
        }
        .image-product img {
            width: 100%;
            height: 100%;
            vertical-align: middle;
            border: 0;
        }

        .no-image-product {
            text-transform: uppercase!important;
            width: 150px;
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
            left: 30%;
            bottom: 0;
            width: calc(100% - 60%);
            background-color: #5156bf;
            margin-bottom: 10px;
            border: none;
            box-shadow: 0 8px 18px 0 rgb(0 0 0 / 68%);
            border-radius: 100px;
            z-index: 9;
        }
        .ui-effects-transfer { border: 2px dotted gray; }
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
                <div class="card-header text-center" style="overflow-x:scroll;">
                        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                            @foreach ($kategori as $i => $item)
                                <input type="radio" class="btn-check" name="kategori" autocomplete="off" value="{{$item->id_kategori}}" id="{{$item->id_kategori}}" {{$i == 0 ? 'checked' : ''}}>
                                <label class="btn btn-outline-primary btn-lg text-nowrap" for="{{$item->id_kategori}}">{{$item->nama_kategori}}</label>
                            @endforeach
                        </div>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                            <div class="col-xl-8">
                                <form class="app-search d-none d-lg-block mb-2" onsubmit="cariProduk(this)">
                                    <div class="position-relative">
                                        <input type="text" class="form-control" placeholder="Cari Produk..." id="cari">
                                        <button class="btn btn-primary" type="submit"><i class="bx bx-search-alt align-middle"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <div class="row" id="thumbnail"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="hiddenCart" style="display:none;"></div>
    <div class="card" id="selectedItem" style="cursor:pointer; display:none;">
        <div class="card-body">
            <button type="button" class="btn btn-sm btn-outline-primary btn-rounded" style="position: absolute;left: -40px;" onclick="resetSelected()"> <i class="fas fa-times"></i> </button>
            <div class="row">
                <div class="col-md-6 col-xl-6">
                    <div class="float-start text-start">
                        <h5 class="text-white" id="itemDipilih">0 Item Dipilih</h5>
                    </div>
                </div>
                <div class="col-md-6 col-xl-6">
                    <div class="float-end text-end">
                        <h5 class="text-white"><span id="totalHarga">Rp. 100.000</span> &nbsp; <i class="fas fa-shopping-cart"></i> </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script>

    let id_kategori = $("input[name=kategori]").val();
    let cari = $("#cari").val();
    let dataThumbnail = [];
    let productSelected = [];

    $(document).ready(function(){
        loadData();
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
            dataThumbnail = data;
            renderThumbnail();
        }).fail(error => {
            const respJson = $.parseJSON(error.responseText);
            showErrorAlert(respJson.message);
            $("#thumbnail").html('');
        });
    }

    function renderThumbnail()
    {
        const rowProduct = dataThumbnail.map(item => {
            return `<div class="col-md-6 col-xl-3">
                        <div style="cursor: pointer;" class="card" onclick="selectProduct(this, '${item.id_produk}')">
                            <div class="card-body product-title">
                                <h4 class="card-title">${item.nama_produk}</h4>
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

                        </div>
                    </div>`;
        }).join(' ');
        $("#thumbnail").html(rowProduct);
    }

    function selectProduct(that, id_produk)
    {
        const selected = dataThumbnail.find(item => item.id_produk == id_produk);
        productSelected.push(selected);
        renderSelected();
    }

    function renderSelected()
    {
        if(productSelected.length) {
            $("#selectedItem").fadeOut(function(){
                $("#selectedItem").fadeIn(1000);
                const total = productSelected.reduce((prev, next) => prev + next.harga_jual, 0);
                $("#itemDipilih").text(`(${productSelected.length}) Item Dipilih`);
                $("#totalHarga").text(`Rp. ${formatMoney(total)}`);
                $("#selectedItem").effect("shake", {
                    times: 2
                }, 200);
            });
        } else {
            $("#selectedItem").fadeOut(1000);
            $("#itemDipilih").text(`0 Item Dipilih`);
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
        productSelected = [];
        renderSelected();
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

    function addToChart(that)
    {
        var cart = $('#selectedItem');
        var elToDrag = $(that).find('.img-fluid').eq(0);
        if (elToDrag) {
            var imgclone = elToDrag.clone()
            .offset({
                top: elToDrag.offset().top,
                left: elToDrag.offset().left
            })
            .css({
                'opacity': '0.1',
                'position': 'absolute',
                'height': '150px',
                'width': '150px',
                'z-index': '100'
            })
            .appendTo($('body'))
            .animate({
                'top': cart.offset().top + 10,
                'left': cart.offset().left + 10,
                'width': 75,
                'height': 75
            }, 1000, 'easeInOutExpo');

            setTimeout(function () {
                cart.effect("shake", {
                    times: 2
                }, 200);
            }, 1500);

            imgclone.animate({
                'width': 0,
                'height': 0
            }, function () {
                $(that).detach()
            });
        }
    }

</script>
@endpush
