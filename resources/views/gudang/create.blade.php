<form onsubmit="store(this);" id="formGudang">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group mb-3">
                <label for="nama_gudang">Kode Gudang</label>
                <input type="text" class="form-control" id="kode_gudang" name="kode_gudang">
                <input type="checkbox" id="isAutoCode" name="isAutoCode" onchange="autoCode(this)" value="1">
                <span class="checkbox-kode">Centang untuk generate kode gudang otomatis dari sistem </span>
            </div>
            <div class="form-group mb-3">
                <label for="nama_gudang">Nama Gudang</label>
                <input type="text" class="form-control" id="nama_gudang" name="nama_gudang">
            </div>
            <div class="form-group mb-3">
                <label for="alamat_gudang">Alamat Gudang</label>
                <textarea type="text" class="form-control" id="alamat_gudang" name="alamat_gudang"></textarea>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div class="pull-right">
                <button type="button" class="btn btn-flat btn-secondary" onclick="bootbox.hideAll()"> Batal </button>
                <button type="submit" class="btn btn-flat btn-primary"> Simpan </button>
            </div>
        </div>
    </div>
</form>

<script>

    function autoCode(that)
    {
        const checked = $(that).is(':checked');
        if(checked) {
            $("#kode_gudang").attr('readonly', true);
            getAutoCode();
        } else {
            $("#kode_gudang").val('');
            $("#kode_gudang").attr('readonly', false);
        }
    }

    function getAutoCode()
    {
        $.ajax({
            url: `{{url('persediaan/gudang/last-code')}}`
        }).done(response => {
            $("#kode_gudang").val(response.message);
        }).fail(error => {
            const respJson = $.parseJSON(error.responseText);
            showErrorAlert(respJson.message);
        })
    }

    function store(that)
    {
        event.preventDefault();        
        const form = $("#formGudang");
        removeErrorInput(form);
        buttonLoading(form.find('button[type=submit]'));
        var formData = formToJson(form);
        $.ajax({
            type: "POST",
            url: "{{url('persediaan/gudang/store')}}",
            data: formData,
            dataType: "json",
            contentType: "application/json"
        }).done(Response => {
            showSuccessAlert(Response.message);
            bootbox.hideAll();
            tableDT.draw();
        }).fail(error => {
            const respJson = $.parseJSON(error.responseText);
            if(typeof(respJson.message) === 'object') {
                errorInput(respJson);
            } else {
                showErrorAlert(respJson.message);
            }
        }).always(()=> {
            buttonUnloading(form.find('button[type=submit]'), 'Simpan');
        });
    }
</script>