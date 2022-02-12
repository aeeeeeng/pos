<script>

    function editAddOptDetail(that, key)
    {
        $("#closeDetailAddOpt").trigger('click');
        $("#closeSummary").trigger('click');

        tmpAddOpt = [];
        tmpCart = [];

        const selectedProduct = cart.find(item => item.key == key);

        $.ajax({
            url: `{{url('app/transaksi-jual/get-add-opt')}}/` + selectedProduct.id_produk,
            success: function(response) {
                const {data} = response;
                tmpCart = {
                    qty_order: selectedProduct.qty_order,
                    addOpt: selectedProduct.addOpt,
                    subtotal: selectedProduct.subtotal,
                    ...selectedProduct};
                tmpAddOpt = data;

                console.log(tmpCart);

                renderAddOptList();
                renderGrandTotalQtyAddOpt();

                selectedProduct.addOpt.map(item => {
                    $(`#addOpt${item.id_add_opt_detail}`).prop('checked', true);
                });

                $('#modal-form').modal('show');
                $('#modal-form .modal-title').text(`Ubah ${tmpCart.nama_produk} - Rp. ${formatMoney(tmpCart.harga_jual)}`);
                $("#modal-form").find('#storeAddOptDetail').attr('onclick', `updateAddOpt('${key}')`);
            }
        });
    }

    function updateAddOpt(key)
    {
        let newData = cart.filter(item => item.key != key);
        cart = newData;
        cart.push(tmpCart);
        $("#modal-form").modal('hide');
        renderQty();
        renderSelected();
    }

    function renderQtyAddOpt(data, selected)
    {
        tmpAddOpt = [];
        tmpCart = [];

        tmpCart = {
            qty_order: 1,
            addOpt: [],
            key: cart.length + 1,
            subtotal: 1 * selected.harga_jual,
            ...selected};
        tmpAddOpt = data;

        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text(`${tmpCart.nama_produk} - Rp. ${formatMoney(tmpCart.harga_jual)}`);

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
        if(tmpCart.qty_order == 0) {
            $("#modal-form").modal('hide');
            const updateCart = cart.find(item => item.key == tmpCart.key);
            if(updateCart) {
                updateCart.qty_order = tmpCart.qty_order;
            }
            renderQty();
        }
        const html = `<div class="col-md-6">
                            <h6 class="text-white" style="margin-top: 5px;">Jumlah Pesanan</h6>
                        </div>
                        <div class="col-md-6">
                            <div class="qty-update float-end">
                                <div class="d-flex flex-wrap gap-2">
                                    ${(() => {
                                        if(tmpCart.cartType == 'bonus') {
                                            return `<span class="text-white" style="margin-top: 5px;">${tmpCart.qty_order}</span>`;
                                        } else {
                                            return `<button type="button" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light" onclick="minQtyTmp(this)">
                                                        <i class="fas fa-minus-circle"></i>
                                                    </button>
                                                    <span class="text-white" style="margin-top: 5px;">${tmpCart.qty_order}</span>
                                                    <button type="button" class="btn btn-success btn-sm btn-rounded waves-effect waves-light" onclick="plusQtyTmp(this)">
                                                        <i class="fas fa-plus-circle"></i>
                                                    </button>`;
                                        }
                                    })()}
                                </div>
                            </div>
                        </div>`;
        $("#totalQty").html(html);
        renderGrandTotalPrice();
    }

    function plusQtyTmp(that)
    {
        tmpCart.qty_order = tmpCart.qty_order + 1;
        tmpCart.subtotal = (tmpCart.qty_order * tmpCart.harga_jual) + tmpCart.addOpt.reduce((prev, next) => prev + next.harga_add_opt_detail * tmpCart.qty_order, 0);
        renderGrandTotalQtyAddOpt();
        setSubtotalDetail();
    }

    function minQtyTmp(that)
    {
        tmpCart.qty_order = tmpCart.qty_order - 1;
        tmpCart.subtotal = (tmpCart.qty_order * tmpCart.harga_jual) + tmpCart.addOpt.reduce((prev, next) => prev + next.harga_add_opt_detail * tmpCart.qty_order, 0);
        renderGrandTotalQtyAddOpt();
        setSubtotalDetail();
    }

    function setAddOpt(that, id_add_opt_detail)
    {
        const isChecked = $(that).is(':checked');
        if(isChecked) {
            let selectedAddOpt = tmpAddOpt.reduce((prev, header) => prev || header.details.find(detail => detail.id_add_opt_detail == id_add_opt_detail), undefined);
            tmpCart.addOpt.push(selectedAddOpt);
        } else {
            const newData = tmpCart.addOpt.filter(item => item.id_add_opt_detail != id_add_opt_detail);
            tmpCart.addOpt = newData;
        }
        tmpCart.subtotal = (tmpCart.qty_order * tmpCart.harga_jual) + tmpCart.addOpt.reduce((prev, next) => prev + next.harga_add_opt_detail * tmpCart.qty_order, 0);
        renderGrandTotalPrice();
        setSubtotalDetail();
    }

    function setSubtotalDetail()
    {
        if(tmpCart.addOpt) {
            tmpCart.addOpt.map(item => {
                item.qty_order_detail = tmpCart.qty_order;
                item.subtotal_detail = tmpCart.qty_order * item.harga_add_opt_detail;
            });
        }
    }

    function openDetailAddOpt(that, id_produk)
    {
        const productSelected = cart.filter(item => item.id_produk == id_produk);
        if(productSelected.length > 0) {
            $("#detailAddOptCartBottom #offcanvasBottomLabel").text(productSelected[0].nama_produk);
            const heightLength = productSelected.length == 1 ? 2 : productSelected.length;
            const heightDetail = 45;
            $("#detailAddOptCartBottom").css('height', `${heightDetail}vh`);
            const rowDetail = productSelected.map(item => {
                return `<tr style="cursor:pointer;" onclick="editAddOptDetail(this, '${item.key}')">
                            <td style="width:10%; font-weight:bold;">${item.qty_order}x</td>
                            <td>
                                <span>
                                    ${item.addOpt.length > 0 ? item.addOpt.map(item => item.nama_add_opt_detail).join(', ') : 'Tidak ada yang dipilih'}
                                </span>
                                <br>
                                <a href="#" class="text-link fw-bold">Edit</a>
                            </td>
                            <td style="width:30%; font-weight:bold;">Rp. ${formatMoney(item.subtotal)}</td>
                        </tr>`;
            }).join(' ');
            $("#detailAddOptCartBottom #listDetailAddOpt tbody").html(rowDetail);
            $("#buttonAddOptDetail").html(`<button type="button" onclick="selectProduct(this, '${productSelected[0].id_produk}')" class="btn btn-primary btn-lg btn-rounded w-50">Tambah Satu Lagi</button>`);
        }
    }

</script>
