 let id_kategori = $("input[name=kategori]").val();
    let cari = $("#cari").val();
    let dataThumbnail = [];
    let productSelected = [];
    let tmpAddOpt = [];
    let tmpSelected = [];

    $(document).ready(function(){
        $('#modal-form').modal({backdrop: 'static', keyboard: false});
        loadData();
    });

    $(window).bind('scroll resize', function() {
        $('.card-header.text-center')
        .css('position', 'sticky')
        .css('z-index', '1002')
        .css('top', $(this).scrollTop());
        if($(this).scrollTop() > 180) {
            $('.card-header.text-center')
            .css('box-shadow', '0 8px 12px 0 rgb(0 0 0 / 20%)')
            .css('border-bottom-right-radius', '15px')
            .css('border-bottom-left-radius', '15px')
        } else {
            $('.card-header.text-center')
            .css('box-shadow', 'unset')
            .css('border-bottom-right-radius', '0')
            .css('border-bottom-left-radius', '0')
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
            return `<div class="col-md-6 col-xl-3" id="thumbnail${item.id_produk}">
                        <div class="card">
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
                            <div class="card-footer">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button class="btn btn-primary form-control text-center" onclick="selectProduct(this, '${item.id_produk}')">Tambah</button>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>`;
        }).join(' ');
        $("#thumbnail").html(rowProduct);
        renderQty();
    }

    function selectProduct(that, id_produk)
    {
        addToCart(id_produk);
    }

    function addToCart(id_produk)
    {
        $.ajax({
            url: `{{url('app/transaksi-jual/get-add-opt')}}/` + id_produk,
            success: function(response) {
                const {data} = response;
                if(data.length == 0) {
                    const selected = dataThumbnail.find(item => item.id_produk == id_produk);
                    selected.qty_order = selected.qty_order ? selected.qty_order : 1;
                    productSelected.push(selected);
                    renderQty();
                } else {
                    const thumb = dataThumbnail;
                    const selected = thumb.find(item => item.id_produk == id_produk);
                    renderQtyAddOpt(data, selected);
                }
            }
        });
    }

    function renderQtyAddOpt(data, selected)
    {
        tmpAddOpt = [];
        tmpSelected = [];

        selected.qty_order = selected.qty_order ? selected.qty_order : 1;
        selected.addOpt = [];

        tmpSelected = selected;
        tmpAddOpt = data;

        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text(`${tmpSelected.nama_produk} - Rp. ${formatMoney(tmpSelected.harga_jual)}`);

        renderAddOptList();
        renderGrandTotalQtyAddOpt();
    }

    function renderAddOptList()
    {
        let htmlAddOpt = tmpAddOpt.map(item => {
            return `<li class="mb-3"> <h6>${item.nama_add_opt}</h6>
                <ul>
                    ${item.details.map(detail => `
                        <li>
                            <div class="form-check">
                                <input class="form-check-input addtional-options" type="checkbox"
                                    onchange="setAddOpt(this, '${detail.id_add_opt_detail}')"
                                    id="addOpt${detail.id_add_opt_detail}" value="${detail.id_add_opt_detail}">
                                <label class="form-check-label" for="addOpt${detail.id_add_opt_detail}">
                                    ${detail.nama_add_opt_detail} - Rp. ${formatMoney(detail.harga_add_opt_detail)}
                                </label>
                            </div>
                        </li>
                    `).join(' ')}
                </ul>
            </li>`;
        }).join(' ');
        $("#modal-form #listAddOpt").html(`<ul class="list-unstyled mb-0"> ${htmlAddOpt} </ul>`);
    }

    function renderGrandTotalQtyAddOpt()
    {
        if(tmpSelected.qty_order == 0) {
            const newData = productSelected.filter(item => item.id_produk != tmpSelected.id_produk);
            productSelected = newData;
            $("#modal-form").modal('hide');
            renderSelected();
        }
        const html = `<div class="col-md-6">
                            <h6 class="text-white" style="margin-top: 5px;">Jumlah Pesanan</h6>
                        </div>
                        <div class="col-md-6">
                            <div class="qty-update float-end">
                                <div class="d-flex flex-wrap gap-2">
                                    <button type="button" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light" onclick="minQtyTmp(this)">
                                        <i class="fas fa-minus-circle"></i>
                                    </button>
                                    <span class="text-white" style="margin-top: 5px;">${tmpSelected.qty_order}</span>
                                    <button type="button" class="btn btn-success btn-sm btn-rounded waves-effect waves-light" onclick="plusQtyTmp(this)">
                                        <i class="fas fa-plus-circle"></i>
                                    </button>
                                </div>
                            </div>
                        </div>`;
        $("#totalQty").html(html);
        renderGrandTotalPrice();
    }

    function plusQtyTmp(that)
    {
        tmpSelected.qty_order = tmpSelected.qty_order + 1;
        renderGrandTotalQtyAddOpt();
    }

    function minQtyTmp(that)
    {
        tmpSelected.qty_order = tmpSelected.qty_order - 1;
        renderGrandTotalQtyAddOpt();
    }

    function setAddOpt(that, id_add_opt_detail)
    {
        const isChecked = $(that).is(':checked');
        if(isChecked) {
            let selectedAddOpt = tmpAddOpt.reduce((prev, header) => prev || header.details.find(detail => detail.id_add_opt_detail == id_add_opt_detail), undefined)
            tmpSelected.addOpt.push(selectedAddOpt)
        } else {
            const newData = tmpSelected.addOpt.filter(item => item.id_add_opt_detail != id_add_opt_detail);
            tmpSelected.addOpt = newData;
        }
        renderGrandTotalPrice();
    }

    function renderGrandTotalPrice()
    {
        let grandTotal = parseFloat(tmpSelected.harga_jual) * parseFloat(tmpSelected.qty_order);
        if(tmpSelected.addOpt.length > 0) {
            grandTotal += tmpSelected.addOpt.reduce((prev, next) => prev + next.harga_add_opt_detail, 0);
        }
        $("#grandTotal").text(`Rp. ${formatMoney(grandTotal)}`);
    }

    function storeAddOpt()
    {
        productSelected.push(tmpSelected);
        $("#modal-form").modal('hide');
        renderQty();
        renderSelected();
    }

    function renderQty()
    {
        let AllSelected = productSelected;
        productSelected.map(selected => {
            let htmlQty = '';
            if(selected.qty_order == 0) {
                htmlQty = `<div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-primary form-control text-center" id="" onclick="selectProduct(this, '${selected.id_produk}')">Tambah</button>
                                </div>
                            </div>`;
                const newData = productSelected.filter(item => item.id_produk != selected.id_produk);
                productSelected = newData;
            } else {
                if(selected.addOpt) {
                    htmlQty = `<div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-primary form-control text-center" id="" onclick="selectProduct(this, '${selected.id_produk}')">${selected.qty_order} Item</button>
                                </div>
                            </div>`;
                } else {
                    htmlQty = `<div class="row bg-primary" style="padding: 10px 0;border-radius: 10px;">
                                    <div class="col-md-6">
                                        <span class="text-white text-bold" style="margin-top: 5px;">Jumlah Pesanan</span>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="qty-update float-end">
                                            <div class="d-flex flex-wrap gap-2">
                                                <button type="button" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light" onclick="minQty(this, '${selected.id_produk}')">
                                                    <i class="fas fa-minus-circle"></i>
                                                </button>
                                                <span class="text-white" style="margin-top: 5px;">${selected.qty_order}</span>
                                                <button type="button" class="btn btn-success btn-sm btn-rounded waves-effect waves-light" onclick="plusQty(this, '${selected.id_produk}')">
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

    function plusQty(that, id_produk)
    {
        let selected = productSelected.find(item => item.id_produk == id_produk);
        selected.qty_order = selected.qty_order + 1;
        renderQty();
    }

    function minQty(that, id_produk)
    {
        let selected = productSelected.find(item => item.id_produk == id_produk);
        selected.qty_order = selected.qty_order - 1;
        renderQty();
    }

    function renderSelected()
    {
        console.log(productSelected);

        if(productSelected.length) {
            $("#selectedItem").fadeOut(function(){
                $("#selectedItem").fadeIn(1000);
                const total = productSelected.reduce((prev, next) => {
                    let result = prev + (next.harga_jual * next.qty_order);
                    if(next.addOpt) {
                        result += next.addOpt.reduce((prev, next) => prev + next.harga_add_opt_detail, 0);
                    }
                    return result;
                }, 0);
                const totalQty = productSelected.reduce((prev, next) => prev + next.qty_order, 0);
                $("#itemDipilih").text(`(${totalQty}) Item Dipilih`);
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