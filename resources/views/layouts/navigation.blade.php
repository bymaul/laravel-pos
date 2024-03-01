<nav
    class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
    <div class="container-fluid d-flex flex-column p-0"><a
            class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0"
            href="/">
            <div class="sidebar-brand-icon rotate-n-15"><i
                    class="fas fa-coffee"></i></div>
            <div class="sidebar-brand-text mx-3">
                <span>{{ config('app.name') }}</span></div>
        </a>
        <hr class="sidebar-divider my-0">
        <ul class="navbar-nav text-light" id="accordionSidebar">
            <li class="nav-item"><a
                    class="nav-link {{ request()->is('/') ? 'active' : '' }}"
                    href="/"><i
                        class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
            </li>
            @if (Auth()->user()->role == 'admin')
                <li class="nav-item"><a
                        class="nav-link {{ request()->routeIs('category.index') ? 'active' : '' }}"
                        href="{{ route('category.index') }}"><i
                            class="fas fa-tags"></i><span>Kategori</span></a>
                </li>
                <li class="nav-item"><a
                        class="nav-link {{ request()->routeIs('product.index') ? 'active' : '' }}"
                        href="{{ route('product.index') }}"><i
                            class="fas fa-box"></i></i><span>Produk</span></a>
                </li>
            @endif
            <hr class="sidebar-divider mt-2">
            <div class="sidebar-heading">Transaksi</div>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('transaction.index') ? 'active' : '' }}"
                    href="{{ route('transaction.index') }}">
                    <i class="fas fa-cart-plus"></i>
                    <span>Transaksi</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('sale.index') ? 'active' : '' }}"
                    href="{{ route('sale.index') }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span>Penjualan</span>
                </a>
            </li>

            @if (Auth()->user()->role == 'admin')
                <hr class="sidebar-divider mt-2">
                <div class="sidebar-heading">Laporan</div>
                <li class="nav-item"><a
                        class="nav-link {{ request()->routeIs('report.index') ? 'active' : '' }}"
                        href="{{ route('report.index') }}"><i
                            class="fas fa-file"></i><span>Laporan</span></a>
                </li>
                <hr class="sidebar-divider mt-2">
                <div class="sidebar-heading">Pengaturan</div>
                <li class="nav-item"><a
                        class="nav-link {{ request()->routeIs('user.index') ? 'active' : '' }}"
                        href="{{ route('user.index') }}"><i
                            class="fas fa-user"></i><span>Pengguna</span></a>
                </li>
            @endif
            <hr class="sidebar-divider mt-2">
        </ul>
        <div class="d-none d-md-inline text-center"><button
                class="btn rounded-circle border-0" id="sidebarToggle"
                type="button"></button></div>
    </div>
</nav>
