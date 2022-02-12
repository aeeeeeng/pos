<script>
    $("#summary").on("shown.bs.offcanvas", function () {
        const backdrop = $(".offcanvas-backdrop");
        const parent = backdrop.parent();
        const cloned = backdrop.clone();
        backdrop.remove();
        parent.append(cloned);
        renderGrandTotal();
        renderMember();
        renderDiskon();
        renderCustomAmmount();
        renderCatatan();
        renderAndSumFinalTotal();
        loadPromo();
        $('ul.nav a[href="#listProduct"]').tab('show');
    }).on("hide.bs.offcanvas", function () {
        $(".offcanvas-backdrop").remove();
        loadData();
    });

    $(document).on('keyup', '.numbersOnly', function () {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
             this.value = this.value.replace(/[^0-9\.]/g, '');
        }
    });

    $("#member").select2({
        placeholder: "Pilih Member Melalui Kode/Nama",
        allowClear: true,
        dropdownParent: $('#summary'),
        width: '100%',
        height: '100%',
        ajax: {
            url: "{{url('app/transaksi-jual/get-member')}}",
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

    $('#member').on('select2:select', function (e) {
        var data = e.params.data;
        member = data;
        renderMember();
    });

    $('#member').on('select2:clearing', function (e) {
        member = '';
        renderMember();
    });

    function formatResultSelectionMember(item) {
        if(item.kode_member == undefined || item.nama_member == undefined) {
            return item.text;
        }
        return item.kode_member + ' - ' + item.nama_member;
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

    function openSummary()
    {
        if(cart.length > 0) {
            const tableHtml = cart.map(item => {
                return `<table class="table table-sm table-summary" id="summary${item.key}">
                            <tbody>
                                <tr ${item.cartType == 'bonus' ? `class="bg-success text-white"` : ''}>
                                    <th style="width: 40%">
                                        ${(() => {
                                            if(item.addOpt) {
                                                return `<a href="javascript:void(0)" class="text-link" onclick="editAddOptDetail(this, '${item.key}')">
                                                            ${item.nama_produk}
                                                        </a>`;
                                            } else {
                                                return item.nama_produk;
                                            }
                                        })()}

                                    </th>
                                    <th style="width: 40%">
                                        <div class="d-flex flex-wrap gap-1 align-items-center justify-content-center">
                                            ${item.cartType != 'bonus' ? `<button type="button" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light" onclick="minQtyCart(this, '${item.key}')">
                                                <i class="fas fa-minus-circle"></i>
                                            </button>
                                            <span class="qty_order" style="margin-top: 5px;min-width: 20px;text-align: center;">${item.qty_order}</span>
                                            <button type="button" class="btn btn-success btn-sm btn-rounded waves-effect waves-light" onclick="plusQtyCart(this, '${item.key}')">
                                                <i class="fas fa-plus-circle"></i>
                                            </button>` : `<span class="qty_order" style="margin-top: 5px;min-width: 20px;text-align: center;">${item.qty_order}</span>`}
                                        </div>
                                    </th>
                                    <th class="subtotal">Rp. ${formatMoney(item.subtotal)}</th>
                                </tr>
                                ${(() => {
                                    if(item.addOpt) {
                                        if(item.addOpt.length > 0) {
                                            return item.addOpt.map(detail => {
                                                return `<tr class="productDetail">
                                                            <td style="width: 40%;">
                                                                <span style="margin-left:20px;">${detail.nama_add_opt_detail}</span>
                                                            </td>
                                                            <td style="width: 40%">
                                                                <div class="d-flex flex-wrap gap-1 align-items-center justify-content-center">
                                                                    <button type="button" class="btn btn-outline-danger btn-sm btn-rounded waves-effect waves-light" onclick="minQtyAddOptCart(this, '${item.key}', '${detail.id_add_opt_detail}')">
                                                                        <i class="fas fa-minus-circle"></i>
                                                                    </button>
                                                                    <span class="qty_order_detail" style="margin-top: 5px;min-width: 20px;text-align: center;">${detail.qty_order_detail}</span>
                                                                    <button type="button" class="btn btn-outline-success btn-sm btn-rounded waves-effect waves-light" onclick="plusQtyAddOptCart(this, '${item.key}', '${detail.id_add_opt_detail}')">
                                                                        <i class="fas fa-plus-circle"></i>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                            <td class="subtotal_detail">Rp. ${formatMoney(detail.subtotal_detail)}</td>
                                                        </tr>`;
                                            }).join(' ')
                                        } else { return ''; }
                                    } else { return ''; }
                                })()}
                            </tbody>
                        </table> `;
            }).join('<hr>')

            $("#summary #productSummary").html(tableHtml);

        } else {
            $("#closeSummary").trigger('click');
            resetSelected();
        }
    }

    function minQtyCart(that, key)
    {
        const productSelected = cart.find(item => item.key == key);
        productSelected.qty_order = productSelected.qty_order - 1;
        productSelected.subtotal = productSelected.harga_jual * productSelected.qty_order;
        if(productSelected.addOpt) {
            productSelected.subtotal = productSelected.subtotal + productSelected.addOpt.reduce((prev, next) => prev + next.subtotal_detail, 0);
        }
        renderQtyAndSubtotal(that, productSelected);
        loadPromo();
    }

    function plusQtyCart(that, key)
    {
        const productSelected = cart.find(item => item.key == key);
        productSelected.qty_order = productSelected.qty_order + 1;
        productSelected.subtotal = productSelected.harga_jual * productSelected.qty_order;
        if(productSelected.addOpt) {
            productSelected.subtotal = productSelected.subtotal + productSelected.addOpt.reduce((prev, next) => prev + next.subtotal_detail, 0);
        }
        renderQtyAndSubtotal(that, productSelected);
        loadPromo();
    }

    function renderQtyAndSubtotal(that, productSelected)
    {
        if(productSelected.qty_order == 0) {
            const newData = cart.filter(item => item.key != productSelected.key);
            cart = newData;
            openSummary();
            renderGrandTotal();
            return;
        }
        $(that).closest('.table-summary').find('.qty_order').text(productSelected.qty_order);
        $(that).closest('.table-summary').find('.subtotal').text(`Rp. ${formatMoney(productSelected.subtotal)}`);
        renderGrandTotal();
    }

    function minQtyAddOptCart(that, key, id_add_opt_detail)
    {
        const productSelected = cart.find(item => item.key == key);
        const detailSelected = productSelected.addOpt.find(item => item.id_add_opt_detail == id_add_opt_detail);
        detailSelected.qty_order_detail = detailSelected.qty_order_detail - 1;
        detailSelected.subtotal_detail = detailSelected.harga_add_opt_detail * detailSelected.qty_order_detail;
        productSelected.subtotal = productSelected.subtotal - detailSelected.harga_add_opt_detail;
        renderQtyAndSubtotal(that, productSelected);
        renderQtyAndSubtotalAddOpt(that, key, detailSelected);
        loadPromo();
    }

    function plusQtyAddOptCart(that, key, id_add_opt_detail)
    {
        const productSelected = cart.find(item => item.key == key);
        const detailSelected = productSelected.addOpt.find(item => item.id_add_opt_detail == id_add_opt_detail);
        detailSelected.qty_order_detail = detailSelected.qty_order_detail + 1;
        detailSelected.subtotal_detail = detailSelected.harga_add_opt_detail * detailSelected.qty_order_detail;
        productSelected.subtotal = productSelected.subtotal + detailSelected.harga_add_opt_detail;
        renderQtyAndSubtotal(that, productSelected);
        renderQtyAndSubtotalAddOpt(that, key, detailSelected);
        loadPromo();
    }

    function renderQtyAndSubtotalAddOpt(that, key, detailSelected)
    {
        if(detailSelected.qty_order_detail == 0) {
            const productSelected = cart.find(item => item.key == key);
            const newDataDetail = productSelected.addOpt.filter(item => item.id_add_opt_detail != detailSelected.id_add_opt_detail);
            productSelected.addOpt = newDataDetail;
            openSummary();
            return;
        }
        $(that).closest('.productDetail').find('.qty_order_detail').text(detailSelected.qty_order_detail);
        $(that).closest('.productDetail').find('.subtotal_detail').text(`Rp. ${formatMoney(detailSelected.subtotal_detail)}`);
        renderGrandTotal();
    }

    function renderGrandTotal()
    {
        grandTotal = cart.reduce((prev, next) => prev + next.subtotal, 0);
        $("#summary #grandTotal").text(`Rp. ${formatMoney(grandTotal)}`);
        renderAndSumFinalTotal();
    }

    function renderMember()
    {
        const namaMember = (member.nama_member) ? member.nama_member : '-';
        $("#nama_member").text(namaMember);
        renderAndSumFinalTotal();
    }

    function renderDiskon()
    {

        const diskon_tipe = $("#diskon_tipe").val();
        const diskon_value = $("#diskon_value").val();

        if(diskon_tipe == '%' && diskon_value > 100) {
            showErrorAlert('Tidak bisa melebihi 100');
            $("#diskon_value").val(diskon.val);
            return;
        }
        diskon.tipe = diskon_tipe;
        diskon.val = diskon_value;
        const diskon_value_text = diskon.val == '' ? 0 : diskon.val;
        const diskon_tipe_text = (diskon.tipe == '%') ? `${diskon_value_text}%` : `Rp. ${formatMoney(diskon_value_text)}`;
        $("#diskkon_value_text").text(diskon_tipe_text);
        renderAndSumFinalTotal();
    }

    function renderCustomAmmount()
    {
        customAmmount = $("#customAmmount").val();
        $("#customAmmount_text").text(`Rp. ${formatMoney(customAmmount)}`);
        renderAndSumFinalTotal();
    }

    function renderCatatan()
    {
        catatan = $("#catatan").val();
        $("#catatan_text").text(catatan);
        renderAndSumFinalTotal();
    }

    function renderAndSumFinalTotal()
    {
        const totalPromo = promo.reduce((p,n) => p+n.money_val,0);
        const diskonFinal = (diskon.tipe == '%') ? grandTotal * (diskon.val == '' ? 0 : diskon.val / 100) : diskon.val == '' ? 0 : diskon.val;
        finalTotal = (grandTotal - totalPromo - diskonFinal) + (customAmmount == '' ? 0 : parseFloat(customAmmount));
        $("#finalTotal").text(`Rp.${formatMoney(finalTotal)}`);
    }

    function loadPromo()
    {
        const payloadCart = cart.filter(item => item.cartType != 'bonus');
        const payloads = {member, grandTotal, finalTotal, detail: payloadCart}
        $.ajax({
            url: `{{url('app/transaksi-jual/get-promo-auto')}}`,
            method: `POST`,
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify(payloads),
            beforeSend: function(){
                $(".loading-summary").fadeIn();
            }
        }).done(response => {
            let dataPromo = response.data;
            let subtotalThis = 0;
            promo = dataPromo.map(item => {
                if(item.diskon_unit == '%') {
                    if(item.tipe_diskon == 'promoQtyProduk') {
                        const insertVal = cart.filter(itemCart => itemCart.id_produk == item.id_produk_beli)
                                           .reduce((prev, next) => prev + next.subtotal, 0) - subtotalThis;
                        item.money_val = insertVal * (parseFloat(item.diskon_val) / 100);
                        subtotalThis = insertVal - (insertVal * (parseFloat(item.diskon_val) / 100));
                    } else {
                        item.money_val = parseFloat(grandTotal) * (parseFloat(item.diskon_val) / 100);
                    }
                } else {
                    item.money_val = item.diskon_val;
                }
                return item;
            });
            promoManual.map(item => {
                if(item.diskon_unit == '%') {
                    item.money_val = parseFloat(grandTotal) * (parseFloat(item.diskon_val) / 100);
                } else {
                    item.money_val = item.diskon_val;
                }
                promo.push(item);
            });
            promoTotal = promo.reduce((prev, next) => prev + next.money_val, 0);
            $("#promoTotal").text(`Rp. ${formatMoney(promoTotal)}`);
            renderPromo();
            $(".loading-summary").fadeOut();
        }).fail(error => {
            $(".loading-summary").fadeOut();
            const respJson = $.parseJSON(error.responseText);
            showErrorAlert(respJson.message);
        })
    }

    function renderPromo()
    {
        const checkExistBogo = promo.filter(item => item.tipe_diskon == 'promoBogo');

        if(checkExistBogo.length == 0) {
            const newCart = cart.filter(item => item.cartType != 'bonus');
            cart = newCart;
        }

        if(promo.length > 0) {
            const html = promo.map(item => {
                let totalPromo = -1 * item.money_val;
                if(item.tipe_diskon == 'promoBogo') {
                    const productSelected = product.find(selected => selected.id_produk == item.id_produk_bonus);
                    const searchExistBonus = cart.find(selected => selected.id_produk == item.id_produk_bonus && selected.cartType == 'bonus');
                    if(searchExistBonus == undefined) {
                        const tmpCart = {
                            qty_order: item.qty_produk_bonus,
                            addOpt: [],
                            key: cart.length + 1,
                            subtotal: item.qty_produk_bonus * productSelected.harga_jual,
                            cartType: 'bonus',
                            ...productSelected};
                        tmpCart.nama_produk = tmpCart.nama_produk + ' (BONUS)';
                        cart.push(tmpCart);
                        totalPromo = -1 * item.qty_produk_bonus * item.money_val;
                    }
                }
                return `<div class="alert alert-success alert-label-icon label-arrow fade show" role="alert">
                            <i class="fas fa-cut label-icon text-warning"></i>
                            <div class="d-flex justify-content-between w-100">
                                <span class="w-50">
                                    ${item.nama_promo}
                                </span>
                                <span class="text-danger">
                                    ${item.diskon_unit == 'rp' ? formatMoney(totalPromo) : `${item.diskon_val}% (${formatMoney(totalPromo)})`}
                                </span>
                            </div>
                        </div>`;

            }).join(' ');
            $("#promoAuto").html(html);
        } else {
            $("#promoAuto").html('');
        }
        // const totalPromo = promo.reduce((p,n) => p+n.money_val,0);
        // finalTotal = finalTotal - totalPromo;
        // $("#finalTotal").text(`Rp.${formatMoney(finalTotal)}`);
        renderGrandTotal();
        renderAndSumFinalTotal();
        openSummary();
    }

</script>
