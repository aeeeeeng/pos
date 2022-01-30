@if ($jenis == 'terima')
    <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show" role="alert">
    <i class="fas fa-check-circle label-icon me-2"></i><strong>Penerimaan {{$header->kode_pembelian}}</strong> - Akan Dilakukan Oleh ({{ auth()->user()->name }})
    </div>
@elseif($jenis == 'batal')
    <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show" role="alert">
        <i class="fas fa-times-circle label-icon me-2"></i><strong>Pembatalan {{$header->kode_pembelian}}</strong> - Akan Dilakukan Oleh ({{ auth()->user()->name }})
    </div>
@endif

<div class="row">
    <div class="col-md-12">
        <table class="">
            <tbody>
                <tr>
                    <td style="min-width: 180px;font-weight: bold;"> Outlet </td>
                    <td> : {{$header->nama_outlet}} </td>
                </tr>
                <tr>
                    <td style="min-width: 180px;font-weight: bold;"> No. PO </td>
                    <td> : {{$header->no_pembelian}} </td>
                </tr>
                <tr>
                    <td style="min-width: 180px;font-weight: bold;"> Supplier </td>
                    <td> : {{$header->nama_supplier}} </td>
                </tr>
                <tr>
                    <td style="min-width: 180px;font-weight: bold;"> Tanngal Pembelian </td>
                    <td> : {{$header->tanggal_pembelian}} </td>
                </tr>
                <tr>
                    <td style="min-width: 180px;font-weight: bold; height: 50px;vertical-align: initial;"> Catatan </td>
                    <td style="min-height: 50px;vertical-align: initial;border-bottom: 1px solid #575d64;"> : {{$header->catatan}} </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-12">
        <table class="table table-sm table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-nowrap text-start">Nama Produk</th>
                    <th class="text-nowrap text-end">Jumlah</th>
                    <th class="text-nowrap text-start">Satuan</th>
                    <th class="text-nowrap text-end">Harga per Unit</th>
                    <th class="text-nowrap text-end">Harga Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($details as $item)
                    <tr>
                        <td class="text-nowrap text-start">{{ $item->nama_produk }}</td>
                        <td class="text-nowrap text-end {{$item->jumlah == 0 ? 'bg-danger text-white' : ''}} ">{{ $item->jumlah }}</td>
                        <td class="text-nowrap text-start">{{ $item->nama_uom }}</td>
                        <td class="text-nowrap text-end">Rp. {{ format_uang($item->harga_beli) }}</td>
                        <td class="text-nowrap text-end {{$item->subtotal == 0 ? 'bg-danger text-white' : ''}} ">Rp. {{ format_uang($item->subtotal) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-6">
        <h5>Grand Total : <span>Rp. {{format_uang($header->total_harga)}}</span></h5>
    </div>
    <div class="col-md-6">
            <div class="float-end">
                @if ($jenis == 'lihat')
                    <button type="button" class="btn btn-flat btn-secondary" onclick="bootbox.hideAll()"> Kembali </button>
                @else
                    <button type="button" class="btn btn-flat btn-secondary" onclick="bootbox.hideAll()"> Batal </button>
                    <button type="submit" class="btn btn-flat btn-primary" onclick="save(this)"> Simpan </button>
                @endif
            </div>
    </div>
</div>

<script>
    function save(that) {
        event.preventDefault();
        const id = `{{$id}}`;
        const jenis = `{{$jenis}}`;
        $.ajax({
            url: `{{url('pembelian/simpan-status')}}`,
            method: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify({id, jenis}),
            beforeSend: function(){
                buttonLoading($(that));
            }
        }).done(response => {
            showSuccessAlert(response.message);
            setTimeout(() => {
                bootbox.hideAll();
                tableDT.draw();
            }, 500);
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
