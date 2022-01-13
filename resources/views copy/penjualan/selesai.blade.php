<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-body">
                <div class="alert alert-success alert-dismissible">
                    <i class="fa fa-check icon"></i>
                    Data Transaksi telah selesai.
                </div>
            </div>
            <div class="box-footer">
                <center>
                    @if ($setting->tipe_nota == 1)
                    <button class="btn btn-warning btn-flat" onclick="notaKecil('{{ url('transaksi/nota-kecil?id_penjualan=' . $id_penjualan) }}', 'Nota Kecil')">Cetak Ulang Nota</button>
                    @else
                    <button class="btn btn-warning btn-flat" onclick="notaBesar('{{ url('transaksi/nota-besar?id_penjualan=' . $id_penjualan) }}', 'Nota PDF')">Cetak Ulang Nota</button>
                    @endif
                    <a href="{{url('transaksi')}}" class="btn btn-primary btn-flat">Transaksi Baru</a>
                </center>
            </div>
        </div>
    </div>
</div>
