@foreach ($outlet->chunk(4) as $chunk)
    <div class="row">
        @foreach ($chunk as $item)
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{$item->nama_outlet}}</h4>
                    <h6 class="card-subtitle text-muted">{{$item->telepon}}</h6>
                </div>
                <img class="img-fluid" style="max-width: 170px;text-align: center;margin: 0 auto;" src="{{url($item->path_logo)}}" alt="Card image cap">
                <div class="card-body">
                    <p class="card-text">{{$item->alamat}}</p>
                    <a href="javascript: void(0);" onclick="pilihOutlet('{{$item->id_outlet}}');" class="text-end card-link">Pilih Outlet</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endforeach

<script>
    function pilihOutlet(id_outlet)
    {
        blockLoading();
        $.ajax({
            url: `{{url('outlet/set-outlet')}}`,
            method: 'post',
            data: {id_outlet}
        }).done(response => {
            window.location.reload();
        }).fail(error => {
            const respJson = $.parseJSON(error.responseText);
            showErrorAlert(respJson.message);
        })
    }
</script>