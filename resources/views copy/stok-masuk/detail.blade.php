<div>    
    <div class="row">
        <div class="col-sm-2">
            <div class="text-gropuping">
                <h5 style="font-weight: bold;">Kode Stok Masuk</h5>
                <span class="">:</span>
            </div>            
        </div>
        <div class="col-sm-2">
            <h5 class="code-badge">{{$header->kode}}</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2">
            <div class="text-gropuping">
                <h5 style="font-weight: bold;">Gudang</h5>
                <span class="">:</span>
            </div>            
        </div>
        <div class="col-sm-5">
            <h5>{{$header->kode_gudang .  ' - ' . $header->nama_gudang}}</h5>
        </div>
        <div class="col-sm-2">
            <div class="text-gropuping">
                <h5 style="font-weight: bold;">Status</h5>
                <span class="">:</span>
            </div>            
        </div>
        <div class="col-sm-2">
            <h5 class="">{!! labelStatusStok($header->status) !!}</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2">
            <div class="text-gropuping">
                <h5 style="font-weight: bold;">Tanggal</h5>
                <span class="">:</span>
            </div>
        </div>
        <div class="col-sm-5">
            <h5>{{tanggal_indonesia($header->tanggal, false)}}</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2">
            <div class="text-gropuping">
                <h5 style="font-weight: bold;">Catatan</h5>
                <span class="">:</span>
            </div>
        </div>
        <div class="col-sm-5">
            <p style="margin-bottom: 0;margin-top: 6px;">{{$header->catatan}}</p>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-hover" id="productTable">
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
                            <td class="text-left"> <small class="label bg-primary">{{$item->kode_produk}}</small></td>
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
            <h4>Grand Total : <span id="grandTotal">{{format_uang($grandTotal)}}</span></h4>
        </div>
        <div class="col-md-6">
            <div class="pull-right">
                <button type="button" class="btn btn-flat btn-secondary" onclick="bootbox.hideAll()"> Tutup </button>
            </div>
        </div>
    </div>
       
    
</div>