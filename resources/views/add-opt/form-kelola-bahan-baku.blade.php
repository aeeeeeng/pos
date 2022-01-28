<div class="row">
    <div class="row">
        <div class="col md-12">
            <div class="table-responsive">
                <table class="table table-sm table-hover" id="tableBahanBaku">
                    <thead>
                        <tr>
                            <th>Opsi Tambahan</th>
                            <th>Bahan Baku</th>
                            <th class="text-end" colspan="2">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
    <hr>
    <div class="col-md-12">
        <div class="float-end">
            <button type="button" class="btn btn-flat btn-secondary" onclick="bootbox.hideAll()"> Batal </button>
            <button type="submit" class="btn btn-flat btn-primary" onclick="save(this)"> Simpan </button>
        </div>
    </div>
</div>

<script>
    var payloads = [];

    $(document).ready(function(){
        payloads = JSON.parse(`{!! json_encode($addOpt) !!}`);
        loadTable();
    });

    $(document).on('keyup', '.numbersOnly', function () {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
             this.value = this.value.replace(/[^0-9\.]/g, '');
        }
    });

    $(document).on('select2:select', 'select.pilih-product', function(e){
        const data = e.params.data;
        const key = $(this).closest('tr').data('key');
        const keyParent = $(this).closest('tr').data('parent');
        payloads[keyParent].detail[key].id_produk_detail = data.id;
        payloads[keyParent].detail[key].nama_produk = data.text;
        payloads[keyParent].detail[key].nama_uom = data.nama_uom;
        loadTable();
    });

    function initializeSelect()
    {
        $(".pilih-product").each(function(){
            const key = $(this).closest('tr').data('key');
            const keyParent = $(this).closest('tr').data('parent');

            const notIn = payloads[keyParent].detail.map(item => item.id_produk_detail == '' ? 'x' : item.id_produk_detail);
            const outlet = payloads[keyParent].id_outlet;

            $(this).select2({
                placeholder: "Pilih Barang Melalui Kode/Nama",
                dropdownParent: $('.modal'),
                ajax: {
                    url: "{{url('produk/select-produk-tunggal')}}",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page,
                            outlet: outlet,
                            notIn: notIn
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
            payloads.map((header, indexParent) => {
                header.detail.map((item, index) => {
                    if(item.id_produk_detail != '' || item.id_produk_detail != null) {
                        var $newOption = $("<option selected='selected'></option>").val(item.id_produk_detail).text(item.nama_produk)
                        $(`tr[data-key=${index}][data-parent=${indexParent}]`).find('.pilih-product').append($newOption).trigger('change');
                    }
                })
            })
        });
    }

    function loadTable()
    {
        const row = payloads.map((header, indexParent) => {
            const col = header.detail.length;
            return header.detail.map((item, index) => {
                const no = index+1;
                const headerRow = (no == 1) &&  `<td rowspan="${col}" style="vertical-align: middle;">${header.nama_add_opt_detail}</td>`;
                return `<tr data-key="${index}" data-parent="${indexParent}">
                            ${headerRow}
                            <td>
                                <div class="d-flex flex-wrap gap-3 align-items-center">
                                    <select class="pilih-product select2 form-control form-control-sm" style="width:500px;" data-val></select>
                                    ${col > 1 ? `<button class="btn btn-sm btn-danger" onclick="removeBahanBaku(this, '${indexParent}', '${index}')"><i class="fas fa-trash"></i></button>` : ''}
                                </div>
                                ${col-1 == index ? `<a href="#" class="text-link mt-1" onclick="addRow(this, ${indexParent})" style="display:block;" >+ Tambah Bahan Baku </a>` : ''}
                            </td>
                            <td>
                                <input type="text" class="form-control form-control-sm jumlah numbersOnly text-end" onchange="updateJumlah(this, '${indexParent}', '${index}')" id="jumlah" value="${item.jumlah_komposit}" style="width:80px;">
                            </td>
                            <td>${item.nama_uom == '' ? '----' : item.nama_uom}</td>
                        </tr>`;
            }).join();
        }).join();
        $("#tableBahanBaku").find('tbody').html(row);
        initializeSelect();
    }

    function addRow(that, indexParent)
    {
        event.preventDefault();
        const newRow = {id_produk_detail: '', nama_produk: '', jumlah_komposit: '', nama_uom: ''};
        payloads[indexParent].detail.push(newRow);
        loadTable();
    }

    function removeBahanBaku(that, keyParent, key)
    {
        const newPayloads = payloads[0].detail.filter((item, index) => index != key);
        payloads[keyParent].detail = newPayloads;
        loadTable();
    }

    function updateJumlah(that, keyParent, key)
    {
        if($(that).val() < 0) {
            showErrorAlert('Jumlah tidak boleh kurang dari 0');
            $(that).val(1);
        }
        payloads[keyParent].detail[key].jumlah_komposit = $(that).val();
        loadTable();
    }

    function formatResultSelection(item) {
     return item.text;
    }

    function formatResult(item)
    {
        if (item.loading) {
            return item.text;
        }

        var $container = $(
            "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__meta'>" +
                    "<div class='select2-result-repository__sku_produk'></div>" +
                    "<div class='select2-result-repository__nama_produk'></div>" +
                "</div>" +
            "</div>"
        );

        $container.find(".select2-result-repository__sku_produk").text(item.sku_produk);
        $container.find(".select2-result-repository__nama_produk").text(item.nama_produk);

        return $container;
    }

    function removeError()
    {
        $(".jumlah").each(function(){
            $(this).removeClass('is-invalid');
        });
    }

    function save(that)
    {
        removeError();

        const error = [];
        payloads.map((header, indexParent) => {
            header.detail.map((item, index) => {
                if(item.id_produk_detail != '' && item.jumlah_komposit == '') {
                    error.push({keyParent: indexParent, key: index});
                }
            });
        })
        if(error.length > 0) {
            error.map(item => {
                $(`tr[data-key=${item.key}][data-parent=${item.keyParent}]`).find('.jumlah').addClass('is-invalid');
            });
            return;
        }

        $.ajax({
            url: `{{url('add-opt/store-kelola-bahan-baku/' . $id)}}`,
            method: 'post',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify(payloads),
            beforeSend: function() {
                buttonLoading($(that));
            }
        }).done(response => {
            showSuccessAlert(response.message);
            bootbox.hideAll();
            tableDT.draw();
        }).fail(error => {
            const respJson = $.parseJSON(error.responseText);
            showErrorAlert(respJson.message);
        }).always(() => {
            setTimeout(() => {
                buttonUnloading($(that), 'Simpan');
            }, 500);
        });
    }
</script>
