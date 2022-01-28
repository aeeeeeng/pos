<div class="row">
    <div class="col-md-12">
        <div class="form-group mb-3">
            <label for="group">Nama Group Opsi Tambahan</label>
            <input type="text" class="form-control form-control-sm" id="nama_group" name="nama_group">
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-12">
        <table class="table table-hover table-sm" id="tableOpsiTambahan">
            <thead>
                <tr>
                    <th>Nama Opsi Tambahan</th>
                    <th class="text-end">Harga</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
                <tr>
                    <td colspan="3">
                        <a href="#" onclick="tambahRowOpsi(this);" class="text-primary">Tambah Opsi Lain</a>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="d-flex flex-wrap gap-2 mb-3"">
            <label>Apakah Produk Memiliki Bahan Baku ? </label>
            <div class="">
                <input type="checkbox" id="punya_bahan_baku" switch="bool" />
                <label for="punya_bahan_baku" data-on-label="Ya" data-off-label="Tidak"></label>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-12">
            <div class="float-end">
                <button type="button" class="btn btn-flat btn-secondary" onclick="bootbox.hideAll()"> Batal </button>
                <button type="submit" class="btn btn-flat btn-primary" onclick="simpanAddOpt(this)"> Simpan </button>
            </div>
    </div>
</div>

<script>

    var opsiTambahan = {
        group: '',
        punya_bahan_baku: '0',
        detail: [{
            nama: '',
            harga: ''
        }]
    };

    $(document).ready(function(){
        renderTableOpsiTambahan();
    });

    $(document).on('keyup', '.numbersOnly', function () {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
             this.value = this.value.replace(/[^0-9\.]/g, '');
        }
    });

    function cleanArrAddOpt()
    {

    }

    function simpanAddOpt(that)
    {
        event.preventDefault();
        opsiTambahan.group = $("#nama_group").val();
        opsiTambahan.punya_bahan_baku = $("#punya_bahan_baku").is(":checked");
        const searchInvalidDetail = opsiTambahan.detail.filter(item => item.harga == '' || item.nama == '');
        if(searchInvalidDetail.length > 0) {
            showErrorAlert('Lengkapi isian nama opsi tambahan dan harga yang masih kosong');
            return;
        }
        if(opsiTambahan.group == '' || opsiTambahan.group == null) {
            showErrorAlert('Nama group tidak boleh kosong');
            return;
        }
        $.ajax({
            url: `{{url('produk/simpan-add-opt')}}`,
            method: 'post',
            dataType: 'json',
            contentType: "application/json",
            data: JSON.stringify({opsiTambahan}),
            beforeSend: () => {
                buttonLoading($(that));
            }
        }).done(response => {
            setTimeout(() => {
                buttonUnLoading($(that), 'Simpan');
            }, 1000);
            showSuccessAlert(response.message);
            bootbox.hideAll();
            tableDT.draw();
        }).fail(error => {
            const respJson = $.parseJSON(error.responseText);
            showErrorAlert(respJson.message);
            setTimeout(() => {
                buttonUnLoading($(that), 'Simpan');
            }, 1000);
        });
    }

    function tambahRowOpsi(that)
    {
        event.preventDefault();
        const newRow = {nama: '', harga: ''};
        opsiTambahan.detail.push(newRow);
        renderTableOpsiTambahan();
    }

    function renderTableOpsiTambahan()
    {
        const row = opsiTambahan.detail.map((item, i) => {
            return `<tr>
                        <td>
                            <input type="text" class="form-control form-control-sm" value="${item.nama}" onkeyup="changeNamaAdd(this, '${i}')">
                        </td>
                        <td>
                            <input type="text" class="form-control form-control-sm text-end numbersOnly" value="${item.harga}" onkeyup="changeHargaAdd(this, '${i}')">
                        </td>
                        <td>
                            ${opsiTambahan.detail.length == 1 ? '' : `<button onclick="removeAddOpt('${i}')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>`}
                        </td>
                    </tr>`;
        }).join();
        $("#tableOpsiTambahan tbody").html(row);
    }

    function changeNamaAdd(that, index)
    {
        opsiTambahan.detail[index].nama = $(that).val();
    }

    function changeHargaAdd(that, index)
    {
        if($(that).val() < 0) {
            showErrorAlert('Harga Beli tidak boleh kurang dari 0');
            $(that).val(0);
        }
        opsiTambahan.detail[index].harga = $(that).val();
    }

    function removeAddOpt(index)
    {
        event.preventDefault();
        const newData = opsiTambahan.detail.filter((item, i) => i != index);
        opsiTambahan.detail = newData;
        renderTableOpsiTambahan();
    }

</script>
