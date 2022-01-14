<div>    
    <div class="row">
        <div class="col-sm-2">
            <div class="text-gropuping">
                <h6 style="font-weight: bold;">Kode Stok Keluar</h6>
                <span class="">:</span>
            </div>            
        </div>
        <div class="col-sm-2">
            <h6 class="code-badge">{{$header->kode}}</h6>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2">
            <div class="text-gropuping">
                <h6 style="font-weight: bold;">Gudang</h6>
                <span class="">:</span>
            </div>            
        </div>
        <div class="col-sm-5">
            <h6>{{$header->kode_gudang .  ' - ' . $header->nama_gudang}}</h6>
        </div>
        <div class="col-sm-2">
            <div class="text-gropuping">
                <h6 style="font-weight: bold;">Status</h6>
                <span class="">:</span>
            </div>            
        </div>
        <div class="col-sm-2">
            <h6 class="">{!! labelStatusStok($header->status) !!}</h6>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2">
            <div class="text-gropuping">
                <h6 style="font-weight: bold;">Tanggal</h6>
                <span class="">:</span>
            </div>
        </div>
        <div class="col-sm-5">
            <h6>{{tanggal_indonesia($header->tanggal, false)}}</h6>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2">
            <div class="text-gropuping">
                <h6 style="font-weight: bold;">Catatan</h6>
                <span class="">:</span>
            </div>
        </div>
        <div class="col-sm-5">
            <p style="">{{$header->catatan}}</p>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-hover table-sm" id="productTable">
                <thead>
                    <tr>
                        <th class="text-left">No</th>
                        <th class="text-left">Kode Produk</th>
                        <th class="text-left" width="30%">Nama Produk</th>
                        <th class="text-right" width="10%">Stok Masuk</th>
                        <th class="text-right" width="15%">Harga</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($details as $i => $item)
                        <tr>
                            <td class="text-left">{{$i+1}}</td>
                            <td class="text-left"> <small class="badge bg-primary">{{$item->kode_produk}}</small></td>
                            <td class="text-left">{{$item->nama_produk}}</td>
                            <td class="text-right">{{$item->nilai}}</td>
                            <td class="text-right">{{format_uang($item->harga)}}</td>
                            <td class="text-right">{{format_uang($item->sub_total)}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <h5>Grand Total : <span id="grandTotal">{{format_uang($grandTotal)}}</span></h5>
        </div>
        <div class="col-md-6">
            <div class="float-end">
                <button type="button" class="btn btn-flat btn-sm btn-secondary" onclick="bootbox.hideAll()"> Tutup </button>
            </div>
        </div>
    </div>
       
    
</div>