<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Laba Produk</title>
    <style>
        .yellow-row {
            background-color: rgb(245, 245, 136);
        }
        table, td, th {
            border: 1px solid black;
        }

        table tr td, table tr th {
            padding: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .text-left {
            text-align: left;
        }
        .bg-gray {
            color: #000;
            background-color: #d2d6de !important;
        }
        .text-red {
            color: #dd4b39 !important;
        }
        h2.title {
            margin: 0;
            padding: 0;
        }
        h4.title {
            margin: 0;
            padding: 0;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h2 class="title text-center">Laporan Laba Produk</h2>
    <h4 class="title text-center">
        (Tanggal {{ tanggal_indonesia($tglAwal, false) }}
        s/d
        Tanggal {{ tanggal_indonesia($tglAkhir, false) }})
    </h4>

    <table class="table table-stiped table-bordered" id="tableLaporan">
        <thead>
            <tr class="bg-gray">
                <th class="text-left">Nama Produk</th>
                <th class="text-right">Diskon</th>
                <th class="text-right">Harga Jual</th>
                <th class="text-right">Harga Beli</th>
                <th class="text-right">Jumlah Penjualan</th>
                <th class="text-right">Sub Total Harga Jual</th>
                <th class="text-right">Sub Total Harga Beli</th>
                <th class="text-right">Laba Bersih</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['row'] as $item)
                <tr class="bg-gray">
                    <th colspan="4" class="text-left">{{tanggal_indonesia($item['tanggal'], false)}} <?= $item['allLabaBersih'] == 0 ? '<span class="text-red"> (TIDAK ADA TRANSAKSI) </span>' : '' ?></th>
                    <th class="text-right">{{$item['allJumlah']}}</th>
                    <th class="text-right">Rp. {{format_uang($item['allSubtotalJual'])}}</th>
                    <th class="text-right">Rp. {{format_uang($item['allSubtotalBeli'])}}</th>
                    <th class="text-right">Rp. {{format_uang($item['allLabaBersih'])}}</th>
                </tr>
                @foreach ($item['details'] as $detail)
                    @if ($detail->labaBersih != 0)
                        <tr <?= $detail->labaBersih == 0 ? 'class="yellow-row' : '' ?>>
                            <td class="text-right">{{$detail->nama_produk}}</td>
                            <td class="text-right">{{$detail->diskon}}</td>
                            <td class="text-right">{{format_uang($detail->harga_jual)}}</td>
                            <td class="text-right">{{format_uang($detail->harga_beli)}}</td>
                            <td class="text-right">{{$detail->jumlahPenjualan}}</td>
                            <td class="text-right">{{format_uang($detail->totalSubtotalJual)}}</td>
                            <td class="text-right">{{format_uang($detail->totalSubtotalBeli)}}</td>
                            <td class="text-right">{{format_uang($detail->labaBersih)}}</td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="8" class="text-center">-------------- Tidak ada transaksi --------------</td>
                        </tr>
                    @endif
                @endforeach
            @endforeach
            <tr class="bg-gray">
                <th colspan="4" class="class="text-left"">TOTAL SEMUA</th>
                <th class="text-right">{{$data['finalJumlah']}}</th>
                <th class="text-right">{{format_uang($data['finalSubTotalJual'])}}</th>
                <th class="text-right">{{format_uang($data['finalSubTotalBeli'])}}</th>
                <th class="text-right">{{format_uang($data['finalBersih'])}}</th>
            </tr>
        </tbody>
    </table>
</body>
</html>