<div class="row">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-sm table-hover">
                    <thead>
                        <tr>
                            <th class="text-nowrap">Nama Produk</th>
                            <th class="text-nowrap">SKU</th>
                            <th class="text-nowrap">Kelola Stok</th>
                            <th class="text-nowrap">Stok Alert</th>
                            <th class="text-nowrap text-end">Alert Stok Ketika</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-nowrap">{{$produk->nama_produk}}</td>
                            <td class="text-nowrap">{{$produk->sku_produk}}</td>
                            <td class="text-nowrap">
                                <div class="">
                                    <input type="checkbox" id="check_kelola_stok" onchange="checkKelolaStok(this)" switch="bool" {{$produk->kelola_stok ? 'checked' : ''}} />
                                    <label for="check_kelola_stok" data-on-label="Ya" data-off-label="Tidak" style="min-width: 65px;"></label>
                                </div>
                            </td>
                            <td class="text-nowrap">
                                <div class="">
                                    <input type="checkbox" id="check_min_stok" onchange="checkMinStok(this)" switch="bool" {{($produk->min_stok == null || $produk->min_stok == '' || $produk->min_stok == 0 ) ? '' : 'checked'}} />
                                    <label for="check_min_stok" data-on-label="Ya" data-off-label="Tidak" style="min-width: 65px;"></label>
                                </div>
                            </td>
                            <td class="text-nowrap text-end float-end">
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm text-end numbersOnly" style="max-width:100px;" id="min_stok" value="{{$produk->min_stok}}" {{($produk->min_stok == null || $produk->min_stok == '' || $produk->min_stok == 0 ) ? 'disabled' : ''}}>
                                        <div class="input-group-text">{{$produk->nama_uom}}</div>
                                    </div>
                            </td>
                        </tr>
                    </tbody>
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
    $(document).on('keyup', '.numbersOnly', function () {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
             this.value = this.value.replace(/[^0-9\.]/g, '');
        }
    });

    function checkKelolaStok(that)
    {
        isChecked = $(that).is(':checked');
        if(!isChecked) {
            $("#check_min_stok").prop('checked', false);
            $("#min_stok").prop('disabled', true).val(null);
        } else {
            @if($produk->min_stok == null || $produk->min_stok == '' || $produk->min_stok == 0 )
                $("#check_min_stok").prop('checked', false);
                $("#min_stok").prop('disabled', true).val(null);
            @else
                $("#check_min_stok").prop('checked', true);
                $("#min_stok").val('{{$produk->min_stok}}').prop('disabled', false);
            @endif

        }
    }

    function checkMinStok(that)
    {
        isChecked = $(that).is(':checked');
        if(isChecked) {
            $("#min_stok").prop('disabled', false).val('{{$produk->min_stok}}');
        } else {
            $("#min_stok").prop('disabled', true).val('');
        }
    }
    function save(that)
    {
        event.preventDefault();
        const kelola_stok = $("#check_kelola_stok").is(':checked') ? 1 : 0;
        let min_stok = null;
        const check_min_stok = $("#check_min_stok").is(':checked') ? 1 : 0;
        if (check_min_stok == 1) {
            min_stok = $("#min_stok").val();
        }

        if(kelola_stok == 0) {
            min_stok = null;
        }

        if(check_min_stok == 1 && (min_stok == '' || min_stok == 0)) {
            showErrorAlert('Minimal stok harus diisi, jika memiliki stok alert'); return;
        }
        $.ajax({
            url: `{{url('produk/store-kelola-stok/' . $produk->id_produk)}}`,
            method: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify({kelola_stok, min_stok}),
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
        })
    }
</script>
