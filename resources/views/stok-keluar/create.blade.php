<form onsubmit="store(this)" id="formStokKeluar" class="">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-2">
                <label for="id_outlet" class="control-label text-start">Outlet <span class="text-danger">*</span> </label>
                <select name="id_outlet" id="id_outlet" class="form-control form-control-sm">
                    <option value="">Pilih Outlet</option>
                    @foreach ($outlet as $item)
                        <option value="{{$item->id_outlet}}" {{$item->id_outlet == session()->get('outlet') ? 'selected' : ''}} >{{$item->nama_outlet}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group mb-2">
                <label for="tanggal" class="control-label text-start ">Tanggal <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm" id="tanggal" name="tanggal">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group mb-2">
                <label for="catatan" class="control-label text-start">Catatan</label>
                <textarea name="catatan" id="catatan" class="form-control form-control-sm"></textarea>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-12">
            <span style="font-size: 12px;font-style: italic;color: red;">Produk yang bisa dipilih, hanya produk yang mempunyai stok</span>
            <select class="pilih-product-adjustment select2 form-control form-control-sm"></select>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-sm table-hover" id="productTable">
                <thead>
                    <tr>
                        <th class="text-start">No</th>
                        <th class="text-start">Kode Produk</th>
                        <th class="text-start" width="30%">Nama Produk</th>
                        <th class="text-end" width="15%">Stok Sisa</th>
                        <th class="text-end" width="15%">Stok Keluar</th>
                        <th class="text-start">Satuan</th>
                        <th class="text-end">Nilai Stok (SISTEM)</th>
                        <th class="text-start">#</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td colspan="7" class="text-center">Data masih kosong, pilih produk pada combobox diatas</td></tr>
                </tbody>
            </table>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <h5>Grand Total : <span id="grandTotal"></span></h5>
        </div>
        <div class="col-md-6">
            <div class="float-end">
                <button type="button" class="btn btn-flat btn-sm btn-secondary" onclick="bootbox.hideAll()"> Batal </button>
                <button type="submit" class="btn btn-flat btn-sm btn-primary"> Simpan </button>
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

        $("#id_outlet").select2({ width: '100%', dropdownParent: $('.modal') });
    });

    $(".pilih-product-adjustment").select2({
        placeholder: "Pilih Barang Melalui Kode/Nama",
        dropdownParent: $('.modal'),
        allowClear: true,
        width: '100%',
        ajax: {
            url: "{{url('persediaan/stok-keluar/get-product')}}",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    id_outlet: $("#id_outlet").val(),
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

    $(document).on('keyup', '.numbersOnly', function () {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
             this.value = this.value.replace(/[^0-9\.]/g, '');
        }
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

        const form = $("#formStokKeluar");

        const id_outlet = $("#id_outlet").val();
        const tanggal = $("#tanggal").val();
        const catatan = $("#catatan").val();

        if(id_outlet == '' || id_outlet == null) {
            showErrorAlert('Outlet harus diisi');
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
        const payloads = {dataDetail, id_outlet, tanggal, catatan};
        $.ajax({
            url: "{{url('persediaan/stok-keluar/store')}}" ,
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
        selected.subtotal = 1 * -1 * selected.nilai_stok
        const checkExist = dataDetail.filter(item => item.id === selected.id).length > 0 ? true : false;
        if(checkExist) {
            const indexExist = dataDetail.findIndex(item => item.id === selected.id);
            dataDetail[indexExist].qty_stok = dataDetail[indexExist].qty_stok + 1;
            const nilai_stok = dataDetail[indexExist].nilai_stok;
            dataDetail[indexExist].subtotal = qty_stok * nilai_stok;
        } else {
            dataDetail.push(selected);
        }
        sumGrandTotal();
    }

    function sumSubTotal(that, id)
    {
        const indexExist = dataDetail.findIndex(item => item.id == id);
        const nilai_stok = dataDetail[indexExist].nilai_stok;
        const qty_stok = dataDetail[indexExist].qty_stok;
        dataDetail[indexExist].subtotal = qty_stok * -1 * nilai_stok;
        $(that).closest('tr').find('td.subtotal').text(`Rp. ${formatMoney(dataDetail[indexExist].subtotal)}`);
        sumGrandTotal();
    }

    function sumGrandTotal()
    {
        const grandTotal = dataDetail.reduce((prev, next) => prev + next.subtotal, 0);
        $("#grandTotal").text(`Rp. ${formatMoney(grandTotal)}`);
    }

    function renderTable()
    {
        const table = $("#productTable");
        if(dataDetail.length == 0) {
            table.find('tbody').html(`<tr><td colspan="7" class="text-center">Data masih kosong, pilih produk pada combobox diatas</td></tr>`);
        } else {
            const row = dataDetail.map((item, index) => `<tr>
                <td>${index+1}</td>
                <td><small class="badge bg-primary">${item.kode_produk}</small></td>
                <td>${item.nama_produk}</td>
                <td class="text-end">${item.stok}</td>
                <td class="text-end">
                    <input type="text" min="0" class="form-control form-control-sm text-end numbersOnly" value="${item.qty_stok}" onkeyup="changeQty(this, '${item.id}')" onchange="changeQty(this, '${item.id}')">
                </td>
                <td class="text-start">${item.nama_uom}</td>
                <td class="text-end subtotal">Rp. ${formatMoney(item.subtotal)}</td>
                <td><button type="button" class="btn btn-sm btn-flat btn-danger btn-xs" onclick="removeDetailArr('${item.id}')"><i class="fa fa-trash"></i></button></td>
            </tr>`).join();
            table.find('tbody').html(row);
        }
    }

    function changeQty(that, id)
    {
        const indexEdit = dataDetail.findIndex(item => item.id == id);
        if($(that).val() < 0 && $(that).val() != '') {
            showErrorAlert('Quantity tidak boleh kurang dari 1');
            $(that).val(1);
        }
        if($(that).val() > dataDetail[indexEdit].stok) {
            showErrorAlert('Stok tidak mencukupi');
            $(that).val(dataDetail[indexEdit].stok);
        }
        dataDetail[indexEdit].qty_stok = parseFloat($(that).val());
        sumSubTotal(that, id)
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
