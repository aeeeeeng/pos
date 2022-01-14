<form onsubmit="store(this);" id="formGudang">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group mb-3">
                <label for="nama_gudang">Kode Gudang</label>
                <span class="badge bg-success code-form">{{$gudang->kode_gudang}}</span>
            </div>
            
            <div class="form-group mb-3">
                <label for="nama_gudang">Nama Gudang</label>
                <input type="text" class="form-control" id="nama_gudang" name="nama_gudang" value="{{$gudang->nama_gudang}}">
            </div>
            <div class="form-group mb-3">
                <label for="alamat_gudang">Alamat Gudang</label>
                <textarea type="text" class="form-control" id="alamat_gudang" name="alamat_gudang">{{$gudang->alamat_gudang}}</textarea>
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
    function store(that)
    {
        event.preventDefault();        
        const form = $("#formGudang");
        removeErrorInput(form);
        buttonLoading(form.find('button[type=submit]'));
        var formData = formToJson(form);
        $.ajax({
            type: "POST",
            url: "{{url('persediaan/gudang/update/'.$id)}}",
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