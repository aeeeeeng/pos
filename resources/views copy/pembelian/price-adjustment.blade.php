<div class="row">
    <div class="col-lg-12">
        <select class="pilih-product-adjustment select2 form-control"></select>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <table class="table table-hover" id="productTable">
            <thead>
                <tr>
                    <th class="text-left">No</th>
                    <th class="text-left">Kode Produk</th>
                    <th class="text-left">Nama Produk</th>
                    <th class="text-right">Harga Beli</th>
                    <th class="text-right">Harga Jual</th>
                    <th class="text-right">Harga Beli Baru</th>
                    <th class="text-right">Harga Jual Baru</th>
                    <th class="text-left">#</th>
                </tr>
            </thead>
            <tbody>
                <tr><td colspan="8" class="text-center">Data masih kosong, pilih data pada combobox diatas</td></tr>
            </tbody>
        </table>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-lg-12">
        <center>
            <button type="button" class="btn btn-flat bg-gray" onclick="bootbox.hideAll();">Tutup</button>
            <button type="button" class="btn btn-flat btn-primary" onclick="saveProdujAdj();">Simpan</button>
        </center>
    </div>
</div>


<script>

    var productAdj = [];

     $(".pilih-product-adjustment").select2({
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
        templateResult: formatResultAdjustment,
        templateSelection: formatResultAdjustmentSelection
    });

    $('.pilih-product-adjustment').on('select2:select', function (e) {
        var data = e.params.data;
        storeProdukAdj(data);
        $(".pilih-product-adjustment").val('').trigger('change');
        renderTableAdj();
    });

    function renderTableAdj()
    {
        if(productAdj.length == 0) {
            $("#productTable").find('tbody').html(`<tr><td colspan="8" class="text-center">Data masih kosong, pilih data pada combobox diatas</td></tr>`);
        } else { 
            const row = productAdj.map((item, index) => {
                return `<tr>
                    <td>${index+1}</td>
                    <td><small class="label bg-primary">${item.kode_produk}</small></td>
                    <td>${item.nama_produk}</td>
                    <td class="text-right">${formatMoney(item.harga_beli)}</td>
                    <td class="text-right">${formatMoney(item.harga_jual)}</td>
                    <td class="text-right">
                        <input type="number" min="0" class="form-control text-right" value="${item.new_harga_beli}" onkeyup="updateHargaBeli(this, '${item.id}')" onchange="updateHargaBeli(this, '${item.id}')">
                    </td>
                    <td class="text-right">
                        <input type="number" min="0" class="form-control text-right" value="${item.new_harga_jual}" onkeyup="updateHargaJual(this, '${item.id}')" onchange="updateHargaJual(this, '${item.id}')">
                    </td>
                    <td><button type="button" class="btn btn-flat btn-danger btn-xs" onclick="removeProductAdj('${item.id}')"><i class="fa fa-trash"></i></button></td>
                </tr>`;
            }).join();
            $("#productTable").find('tbody').html(row);
        }
    }

    function removeProductAdj(id)
    {
        const newData = productAdj.filter(item => item.id != id);
        productAdj = newData;
        renderTableAdj();
    }

    function updateHargaBeli(that, id)
    {
        const indexEdit = productAdj.findIndex(item => item.id == id);
        if($(that).val() < 1) {
            showErrorAlert('Harga tidak boleh kurang dari 1');
            $(that).val(1);
        } 
        productAdj[indexEdit].new_harga_beli = parseInt($(that).val());
    }

    function updateHargaJual(that, id)
    {
        const indexEdit = productAdj.findIndex(item => item.id == id);
        if($(that).val() < 1) {
            showErrorAlert('Harga tidak boleh kurang dari 1');
            $(that).val(1);
        } 
        productAdj[indexEdit].new_harga_jual = parseInt($(that).val());
    }

    function saveProdujAdj()
    {
        event.preventDefault();
        const payloads = {productAdj};
        if(productAdj.length == 0) {
            showErrorAlert('Tidak ada yang akan diubah, isi minimal 1 produk');
            return;
        }
        $.ajax({
            url: "{{url('pembelian_detail/store-adjustment')}}" ,
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
        }).fail(error => {
            const respJson = $.parseJSON(error.responseText);
            showErrorAlert(respJson.message);
            unBlockLoading();
        });
    }

    function storeProdukAdj(selected)
    {
        
        const checkExist = productAdj.filter(item => item.id === selected.id).length > 0 ? true : false;
        if(checkExist) {
            showErrorAlert('Produk sudah ditambahkan');
        } else {
            selected.new_harga_beli = selected.harga_beli;
            selected.new_harga_jual = selected.harga_jual;
            productAdj.push(selected);
        }
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
