<div class="row kategori">
        <div class="col-md-12">
            <div class="form-group mb-2">
                <label for="">Nama Kategori <span class="text-danger">*</span> </label>
                <input type="text" class="form-control form-sm" id="nama_kategori" name="nama_kategori" value="{{$kategori->nama_kategori}}">
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
                <div class="float-end">
                    <button type="button" class="btn btn-flat btn-secondary" onclick="bootbox.hideAll()"> Batal </button>
                    <button type="submit" class="btn btn-flat btn-primary" onclick="update(this)"> Simpan </button>
                </div>
        </div>
    </div>

    <script>
        function update(that)
        {
            removeErrorInput($(".kategori"));
            const nama_kategori = $("#nama_kategori").val();
            $.ajax({
                url: `{{url('kategori/update/' . $kategori->id_kategori)}}`,
                method: 'post',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify({nama_kategori}),
                beforeSend: function() {
                    buttonLoading($(that));
                }
            }).done(response => {
                showSuccessAlert(response.message);
                bootbox.hideAll();
                tableDT.draw();
            }).fail(error => {
                const respJson = $.parseJSON(error.responseText);
                if(error.status == 500 || error.status == 400) {
                    if(typeof(respJson.message) === 'object') {
                        errorInput(respJson);
                    } else {
                        showErrorAlert(respJson.message);
                    }
                } else {
                    showErrorAlert(respJson.message);
                }
            }).always(() => {
                setTimeout(() => {
                    buttonUnloading($(that), 'Simpan');
                }, 500);
            })
        }
    </script>
