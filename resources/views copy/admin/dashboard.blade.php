@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Dashboard</li>
@endsection

@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{ $kategori }}</h3>

                <p>Total Kategori</p>
            </div>
            <div class="icon">
                <i class="fa fa-cube"></i>
            </div>
            <a href="{{ route('kategori.index') }}" class="small-box-footer">Lihat <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3>{{ $produk }}</h3>

                <p>Total Produk</p>
            </div>
            <div class="icon">
                <i class="fa fa-cubes"></i>
            </div>
            <a href="{{ route('produk.index') }}" class="small-box-footer">Lihat <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{ $member }}</h3>

                <p>Total Member</p>
            </div>
            <div class="icon">
                <i class="fa fa-id-card"></i>
            </div>
            <a href="{{ route('member.index') }}" class="small-box-footer">Lihat <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{ $supplier }}</h3>

                <p>Total Supplier</p>
            </div>
            <div class="icon">
                <i class="fa fa-truck"></i>
            </div>
            <a href="{{ route('supplier.index') }}" class="small-box-footer">Lihat <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>
<!-- /.row -->
<!-- Main row -->
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Grafik Pendapatan & Grafik Laba Penjualan {{ tanggal_indonesia($tanggal_awal, false) }} s/d {{ tanggal_indonesia($tanggal_akhir, false) }}</h3>
                <a href="{{ route('laporan.index') }}" target="__blank" class="btn btn-sm btn-flat btn-danger pull-right">Lihat Detail Pendapatan</a>
                &nbsp;
                <a href="{{ route('laporan_laba_produk.index') }}" target="__blank" class="btn btn-sm btn-flat btn-danger pull-right">Lihat Detail Penjualan</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="chart">
                            <!-- Sales Chart Canvas -->
                            <canvas id="salesChart" style="height: 180px;"></canvas>
                        </div>
                        <!-- /.chart-responsive -->
                    </div>
                </div>
                <!-- /.row -->
            </div>
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
</div>


<!-- /.row (main row) -->

<div class="row">
    <div class="col-lg-6">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">10 Produk Terlaris</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <canvas id="produkLarisChart" style="height: 180px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">10 List Produk Stok dibawah Minimal</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Kode Produk</th>
                                    <th>Nama</th>
                                    <th class="text-right">Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($produkStokMinimal->count() > 0)
                                    @foreach ($produkStokMinimal as $item)
                                    <tr {{$item->stok < 0 ? 'class="bg-red"' : ''}}>
                                        <td><span class="label bg-primary">{{$item->kode_produk}}</span></td>
                                        <td>{{$item->nama_produk}}</td>
                                        <td class="text-right">{{$item->stok}}</td>
                                    </tr>
                                @endforeach
                                @else
                                    <tr>
                                        <td colspan="3" class="text-center">Tidak stok dibawah minimal</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.row -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- ChartJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js" integrity="sha512-TW5s0IT/IppJtu76UbysrBH9Hy/5X41OTAbQuffZFU6lQ1rdcLHzpU5BzVvr/YFykoiMYZVWlr/PX1mDcfM9Qg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>

$(document).ready(function(){
    renderChartLine();
    renderPie();
});



function renderPie()
{
    var ctx = document.getElementById('produkLarisChart').getContext('2d');
    var myDoughnutChart = new Chart(ctx, {
        type: 'pie',
        data: {
            datasets: [{
                data: <?= json_encode($terlaris['data']) ?>,
                backgroundColor: [
                    '#F44336',
                    '#2196F3',
                    '#9c27b0',
                    '#673ab7',
                    '#3f51b5',
                    '#03a9f4',
                    '#009688',
                    '#4caf50',
                    '#ffeb3b',
                    '#e91e63',
                ],
                borderColor: [
                    '#F44336',
                    '#2196F3',
                    '#9c27b0',
                    '#673ab7',
                    '#3f51b5',
                    '#03a9f4',
                    '#009688',
                    '#4caf50',
                    '#ffeb3b',
                    '#e91e63',
                ]
            }],

            // These labels appear in the legend and in the tooltips when hovering different arcs
            labels: <?= json_encode($terlaris['labels']) ?>
        },
    });
}

function renderChartLine()
{
    var ctx = document.getElementById('salesChart').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'line',

        // The data for our dataset
        data: {
            labels: {{ json_encode($data_tanggal) }},
            datasets: [{
                label: "Pendapatan",
                backgroundColor: '#36a2eb',
                borderColor: '#36a2eb',
                data: {{ json_encode($data_pendapatan) }}
            }, 
            {
                label: "Laba Penjualan",
                backgroundColor: 'rgb(255, 99, 132)',
                borderColor: 'rgb(255, 99, 132)',
                data: {{json_encode($laba_penjualan)}},
            }
            ]
        },

        // Configuration options go here
        options: {}
    });
}


</script>
@endpush