<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Pendapatan</title>

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
    <h2 class="title text-center">Laporan Pendapatan</h2>
    <h4 class="title text-center">
        (Tanggal {{ tanggal_indonesia($awal, false) }}
        s/d
        Tanggal {{ tanggal_indonesia($akhir, false) }})
    </h4>

    <table class="table table-striped">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Tanggal</th>
                <th>Penjualan</th>
                <th>Pembelian</th>
                <th>Pengeluaran</th>
                <th>Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    @foreach ($row as $col)
                        <td>{{ $col }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>