@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-xl-3 col-md-6">
        <!-- card -->
        <div class="card card-h-100 bg-primary border-primary text-white">
            <!-- card body -->
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-12">
                        <span class="text-white mb-3 lh-1 d-block text-truncate">Total Kategori</span>
                        <h4 class="mb-3 text-white">
                            <span class="counter-value" data-target="{{ $kategori }}">0</span>
                        </h4>
                    </div>
                </div>
                <div class="text-end">
                    <a href="{{ route('kategori.index') }}" class="ms-1 text-white font-size-13">Lihat <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->

    <div class="col-xl-3 col-md-6">
        <!-- card -->
        <div class="card card-h-100 bg-success border-success text-white">
            <!-- card body -->
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-12">
                        <span class="text-white mb-3 lh-1 d-block text-truncate">Total Produk</span>
                        <h4 class="mb-3 text-white">
                            <span class="counter-value" data-target="{{ $produk }}">0</span>
                        </h4>
                    </div>
                </div>
                <div class="text-end">
                    <a href="{{ url('produk') }}" class="ms-1 text-white font-size-13">Lihat <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->

    <div class="col-xl-3 col-md-6">
        <!-- card -->
        <div class="card card-h-100 bg-warning border-warning text-white">
            <!-- card body -->
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-12">
                        <span class="text-white mb-3 lh-1 d-block text-truncate">Total Member</span>
                        <h4 class="mb-3 text-white">
                            <span class="counter-value" data-target="{{ $member }}">0</span>
                        </h4>
                    </div>
                </div>
                <div class="text-end">
                    <a href="{{ route('member.index') }}" class="ms-1 text-white font-size-13">Lihat <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->

    <div class="col-xl-3 col-md-6">
        <!-- card -->
        <div class="card card-h-100 bg-danger border-danger text-white">
            <!-- card body -->
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-12">
                        <span class="text-white mb-3 lh-1 d-block text-truncate">Total Supplier</span>
                        <h4 class="mb-3 text-white">
                            <span class="counter-value" data-target="{{ $supplier }}">0</span>
                        </h4>
                    </div>
                </div>
                <div class="text-end">
                    <a href="{{ route('supplier.index') }}" class="ms-1 text-white font-size-13">Lihat <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->

</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card card-h-100">
            <div class="card-body">
                <div class="d-flex flex-wrap align-items-center mb-4">
                    <h5 class="card-title me-2">Grafik Pendapatan & Grafik Laba Penjualan {{ tanggal_indonesia($tanggal_awal, false) }} s/d {{ tanggal_indonesia($tanggal_akhir, false) }}</h5>
                    <div class="ms-auto">
                        <div>
                            <a href="{{ route('laporan.index') }}" target="__blank" class="btn btn-sm btn-flat btn-danger pull-right">Lihat Detail Pendapatan</a>
                            &nbsp;
                            <a href="{{ route('laporan_laba_produk.index') }}" target="__blank" class="btn btn-sm btn-flat btn-danger pull-right">Lihat Detail Penjualan</a>
                        </div>
                    </div>
                </div>
                <div class="chart">
                    <canvas id="salesChart" style="max-height: 250px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-6">
        <div class="card card-h-100">
            <div class="card-body">
                <div class="d-flex flex-wrap align-items-center mb-4">
                    <h5 class="card-title me-2">10 Produk Terlaris</h5>
                </div>
                <canvas id="produkLarisChart" style="max-height: 250px;"></canvas>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card card-h-100">
            <div class="card-body">
                <div class="d-flex flex-wrap align-items-center mb-4">
                    <h5 class="card-title me-2">10 List Produk Stok dibawah Minimal</h5>
                </div>
                <div class="row">
                    <div class="col-sm-12">
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
