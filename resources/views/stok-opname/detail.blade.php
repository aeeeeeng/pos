<div>
    <div class="row">
            <div class="col-sm-2">
                <div class="text-gropuping">
                    <h6 style="font-weight: bold;">Kode Stok Masuk</h6>
                    <span class="">:</span>
                </div>
            </div>
            <div class="col-sm-2">
                <h6 class="badge bg-primary">{{$header->kode}}</h6>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <div class="text-gropuping">
                    <h6 style="font-weight: bold;">Outlet</h6>
                    <span class="">:</span>
                </div>
            </div>
            <div class="col-sm-5">
                <h6>{{$header->nama_outlet}}</h6>
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
            <table class="table table-sm table-hover" id="productTable">
                <thead>
                    <tr>
                        <th class="text-start">No</th>
                        <th class="text-start">Kode Produk</th>
                        <th class="text-start">Nama Produk</th>
                        <th class="text-end">Jumlah Barang (SISTEM)</th>
                        <th class="text-end">Jumlah Barang (AKTUAL)</th>
                        <th class="text-end">Silisih</th>
                        <th class="text-end">Harga Unit (SISTEM)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($details as $i => $item)
                        <tr>
                            <td class="text-start">{{$i+1}}</td>
                            <td class="text-start"> <small class="badge bg-primary">{{$item->kode_produk}}</small></td>
                            <td class="text-start">{{$item->nama_produk}}</td>
                            <td class="text-end">{{$item->jumlah_barang_sistem}}</td>
                            <td class="text-end">{{$item->jumlah_barang_aktual}}</td>
                            <td class="text-end">{{$item->selisih}}</td>
                            <td class="text-end">{{format_uang($item->harga)}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <div class="float-end">
                <button type="button" class="btn btn-flat btn-sm btn-secondary" onclick="bootbox.hideAll()"> Tutup </button>
            </div>
        </div>
    </div>


</div>
