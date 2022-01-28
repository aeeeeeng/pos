<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu mm-active" >
    <div data-simplebar class="h-100">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li>
                    <a href="{{ route('dashboard') }}">
                        <i data-feather="home"></i>
                        <span data-key="t-dashboard">Dashboard</span>
                    </a>
                </li>
                @if (auth()->user()->level == 1)
                    <li class="menu-title" data-key="t-inventori">INVENTORI</li>
                    <li>
                        <a href="{{ url('produk') }}">
                            <i data-feather="briefcase"></i>
                            <span>Produk</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('member.index') }}">
                            <i data-feather="user"></i>
                             <span>Member</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('supplier.index') }}">
                            <i data-feather="truck"></i>
                            <span>Supplier</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript: void(0);" class="has-arrow">
                            <i data-feather="grid"></i>
                            <span data-key="t-persediaan">Persediaan</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{ url('persediaan/gudang/') }}"> Gudang </a></li>
                            <li><a href="#"> Transfer Stok </a></li>
                            <li><a href="#"> Kartu Stok</a></li>
                            <li><a href="{{url('persediaan/stok-masuk')}}"> Stok Masuk</a></li>
                            <li><a href="{{url('persediaan/stok-keluar')}}"> Stok Keluar</a></li>
                            <li><a href="{{url('persediaan/stok-opname')}}"> Stok Opname</a></li>
                        </ul>
                    </li>
                    <li class="menu-title" data-key="t-transaksi">TRANSAKSI</li>
                    <li>
                        <a href="{{ route('pengeluaran.index') }}">
                            <i data-feather="dollar-sign"></i>
                            <span>Pengeluaran</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pembelian.index') }}">
                            <i data-feather="download"></i>
                            <span>Pembelian</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('penjualan.index') }}">
                            <i data-feather="upload"></i>
                            <span>Penjualan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('transaksi.index') }}">
                            <i data-feather="shopping-cart"></i>
                            <span>Transaksi Jual</span>
                        </a>
                    </li>
                    <li class="menu-title" data-key="t-report">REPORT</li>
                    <li>
                        <a href="{{ route('laporan.index') }}">
                            <i data-feather="file-text"></i>
                            <span>Laporan</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('laporan_laba_produk.index') }}">
                            <i data-feather="file-text"></i>
                            <span>Laporan Penjualan</span>
                        </a>
                    </li>
                    <li class="menu-title" data-key="t-system">SYSTEM</li>
                    <li>
                        <a href="{{ route('user.index') }}">
                            <i data-feather="users"></i>
                            <span>User</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route("setting.index") }}">
                            <i data-feather="settings"></i>
                            <span>Pengaturan</span>
                        </a>
                    </li>
                @else
                    <li>
                        <a href="{{ route('transaksi.index') }}">
                            <i data-feather="shopping-cart"></i>
                            <span>Transaksi Jual</span>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
