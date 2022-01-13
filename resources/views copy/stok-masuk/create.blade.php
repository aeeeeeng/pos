<form onsubmit="store(this)" id="formStokMasuk" class="">    
    <div class="form-horizontal">
        <div class="form-group">
            <label for="id_gudang" class="col-sm-2 control-label text-left">Gudang <span class="text-red">*</span> </label>
            <div class="col-sm-5">
                <select name="id_gudang" id="id_gudang" class="form-control">
                    <option value="">Pilih Gudang</option>
                    @foreach ($gudang as $item)
                        <option value="{{$item->id_gudang}}">{{$item->kode_gudang . ' - ' . $item->nama_gudang}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="tanggal" class="col-sm-2 control-label text-left ">Tanggal <span class="text-red">*</span></label>
            <div class="col-sm-5">
                <input type="text" class="form-control" id="tanggal" name="tanggal">
            </div>
        </div>
        <div class="form-group">
            <label for="catatan" class="col-sm-2 control-label text-left">Catatan</label>
            <div class="col-sm-5">
                <textarea name="catatan" id="catatan" class="form-control"></textarea>
            </div>
        </div>
    </div>
    <hr>
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
                        <th class="text-left" width="30%">Nama Produk</th>
                        <th class="text-right" width="10%">Stok Masuk</th>
                        <th class="text-right" width="15%">Harga</th>
                        <th class="text-right">Subtotal</th>
                        <th class="text-left">#</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td colspan="5" class="text-center">Data masih kosong, pilih produk pada combobox diatas</td></tr>
                </tbody>
            </table>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <h4>Grand Total : <span id="grandTotal"></span></h4>
        </div>
        <div class="col-md-6">
            <div class="pull-right">
                <button type="button" class="btn btn-flat btn-secondary" onclick="bootbox.hideAll()"> Batal </button>
                <button type="submit" class="btn btn-flat btn-primary"> Simpan </button>
            </div>
        </div>
    </div>
</form>

<script>

    var dataDetail = [];

    $(document).ready(function(){
        
        var f3 = flatpickr(document.getElementById('tanggal'), {
            dateFormat: "d/m/Y"
        });

        $("#id_gudang").select2({ width: '100%' });
    });

    $(".pilih-product-adjustment").select2({
        placeholder: "Pilih Barang Melalui Kode/Nama",
        allowClear: true,
        width: '100%',
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
        storeOptionProduct(data);
        $(".pilih-product-adjustment").val('').trigger('change');
        console.log(dataDetail);
        renderTable();
    });

    function store(that)
    {
        event.preventDefault();
        
        const form = $("#formStokMasuk");

        const id_gudang = $("#id_gudang").val();
        const tanggal = $("#tanggal").val();
        const catatan = $("#catatan").val();

        if(id_gudang == '' || id_gudang == null) {
            showErrorAlert('Gudang harus diisi');
            return;
        }
        if(tanggal == '' || tanggal == null) {
            showErrorAlert('Tanggal harus diisi');
            return;
        }
        if(dataDetail.length == 0) {
            showErrorAlert('Produk harus berisi minimal 1 baris');
            return;
        }
        if(dataDetail.reduce((prev, next) => prev + next.subtotal, 0) == 0) {
            showErrorAlert('Grand total tidak valid');
            return;
        }
        const payloads = {dataDetail, id_gudang, tanggal, catatan};
        $.ajax({
            url: "{{url('persediaan/stok-masuk/store')}}" ,
            type: "POST",
            dataType: "json",
            contentType: "application/json",
            data: JSON.stringify(payloads),
            beforeSend: () => {
                buttonLoading(form.find('button[type=submit]'));
            }
        }).done(response => {
            showSuccessAlert(response.message);
            buttonUnloading(form.find('button[type=submit]'), 'Simpan');
            bootbox.hideAll();
            tableDT.draw();
        }).fail(error => {
            const respJson = $.parseJSON(error.responseText);
            showErrorAlert(respJson.message);
            buttonUnloading(form.find('button[type=submit]'), 'Simpan');
        });
    }

    function storeOptionProduct(selected)
    {
        selected.qty_stok = 1;
        selected.harga_beli = 0;
        selected.subtotal = 1 * selected.harga_beli;
        const checkExist = dataDetail.filter(item => item.id === selected.id).length > 0 ? true : false;
        if(checkExist) {
            const indexExist = dataDetail.findIndex(item => item.id === selected.id);
            dataDetail[indexExist].qty_stok = dataDetail[indexExist].qty_stok + 1;
            const harga_beli = dataDetail[indexExist].harga_beli;
            const qty_stok = dataDetail[indexExist].qty_stok;
            dataDetail[indexExist].subtotal = qty_stok * harga_beli;
        } else {
            dataDetail.push(selected);
        }
        sumGrandTotal();
    }
    

    function sumSubTotal(that, id)
    {
        const indexExist = dataDetail.findIndex(item => item.id == id);
        const harga_beli = dataDetail[indexExist].harga_beli;
        const qty_stok = dataDetail[indexExist].qty_stok;
        dataDetail[indexExist].subtotal = qty_stok * harga_beli;
        $(that).closest('tr').find('td.subtotal').text(formatMoney(dataDetail[indexExist].subtotal));
        sumGrandTotal();
    }

    function sumGrandTotal()
    {
        const grandTotal = dataDetail.reduce((prev, next) => prev + next.subtotal, 0);
        $("#grandTotal").text(formatMoney(grandTotal));
    }

    function renderTable()
    {
        const table = $("#productTable");
        if(dataDetail.length == 0) {
            table.find('tbody').html(`<tr><td colspan="5" class="text-center">Data masih kosong, pilih produk pada combobox diatas</td></tr>`);
        } else {
            const row = dataDetail.map((item, index) => `<tr>
                <td>${index+1}</td>
                <td><small class="label bg-primary">${item.kode_produk}</small></td>
                <td>${item.nama_produk}</td>
                <td class="text-right">
                    <input type="number" min="0" class="form-control text-right" value="${item.qty_stok}" onkeyup="changeQty(this, '${item.id}')" onchange="changeQty(this, '${item.id}')">
                </td>
                <td class="text-right">
                    <input type="number" min="0" class="form-control text-right" value="${item.harga_beli}" onkeyup="changeHargaBeli(this, '${item.id}')" onchange="changeHargaBeli(this, '${item.id}')">
                </td>
                <td class="text-right subtotal">${formatMoney(item.subtotal)}</td>
                <td><button type="button" class="btn btn-flat btn-danger btn-xs" onclick="removeDetailArr('${item.id}')"><i class="fa fa-trash"></i></button></td>
            </tr>`).join();
            table.find('tbody').html(row);
        }
    }

    function changeQty(that, id)
    {
        const indexEdit = dataDetail.findIndex(item => item.id == id);
        if($(that).val() < 1 && $(that).val() != '') {
            showErrorAlert('Quantity tidak boleh kurang dari 0');
            $(that).val(1);
        } 
        dataDetail[indexEdit].qty_stok = parseInt($(that).val());
        sumSubTotal(that, id);
    }

    function changeHargaBeli(that, id)
    {
        const indexEdit = dataDetail.findIndex(item => item.id == id);
        if($(that).val() < 1 && $(that).val() != '') {
            showErrorAlert('Harga tidak boleh kurang dari 0');
            $(that).val(1);
        } 
        dataDetail[indexEdit].harga_beli = parseInt($(that).val());
        sumSubTotal(that, id);
    }

    function removeDetailArr(id)
    {
        const newData = dataDetail.filter(item => item.id != id);
        dataDetail = newData;
        renderTable();
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