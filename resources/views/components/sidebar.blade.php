<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion d-none d-md-block" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('sbadmin2/img/logoSmk.png') }}" alt="Logo" style="width: 70px; height: auto;">
        </div>
        <div class="sidebar-brand-text mx-3">SMKN<sup>7</sup> Jember</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Sidebar Menu Items -->
    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="ti ti-layout-dashboard fs-4 me-2"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('chart.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('chart.index') }}">
            <i class="ti ti-bar-chart fs-4 me-2"></i>
            <span>Grafik</span>
        </a>
    </li>

    <hr class="sidebar-divider my-0">

    <li class="nav-item {{ request()->routeIs('bagian.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('bagian.index') }}">
            <i class="ti ti-list-details fs-4 me-2"></i>
            <span>Bagian</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('ruang.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('ruang.index') }}">
            <i class="ti ti-list-details fs-4 me-2"></i>
            <span>Ruang</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('categories.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('categories.index') }}">
            <i class="ti ti-list-details fs-4 me-2"></i>
            <span>Kategori Barang</span>
        </a>
    </li>

    <hr class="sidebar-divider my-0">

    <li class="nav-item {{ request()->routeIs('barang.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('barang.index') }}">
            <i class="ti ti-file-info fs-4 me-2"></i>
            <span>Barang</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('peminjaman.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('peminjaman.index') }}">
            <i class="ti ti-book fs-4 me-2"></i>
            <span>Peminjaman</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('barangkeluar.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('barangkeluar.index') }}">
            <i class="ti ti-file-text fs-4 me-2"></i>
            <span>Barang Keluar</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('download.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('download.index') }}">
            <i class="ti ti-file-text fs-4 me-2"></i>
            <span>Download Barcode</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('scan.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('scan.index') }}">
            <i class="ti ti-scan fs-4 me-2"></i>
            <span>Scan Barcode</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('report.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('report.index') }}">
            <i class="ti ti-file-text fs-4 me-2"></i>
            <span>Laporan</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('backup.database') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('backup.database') }}">
            <i class="ti ti-database fs-4 me-2"></i>
            <span>Backup Database</span>
        </a>
    </li>
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Logout -->
    <li class="nav-item d-flex justify-content-center">
        <form method="POST" action="{{ route('logout') }}" class="mt-1 mb-1">
            @csrf
            <button type="submit" class="btn btn-sm btn-danger">
                <i class="ti ti-logout me-1"></i> Logout
            </button>
        </form>
    </li>

    <div class="d-none d-md-flex justify-content-center mt-3">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>

<!-- Bottom Navigation Bar for Mobile (Scrollable) -->
<div class="d-md-none fixed-bottom bg-gradient-primary text-white shadow overflow-auto"
    style="padding-top: 0.75rem; padding-bottom: 0.75rem;">
    <div class="d-flex flex-nowrap justify-content-start text-center px-2"
        style="overflow-x: auto; white-space: nowrap;">

        <a href="{{ route('dashboard') }}"
            class="text-white mx-2 d-inline-block {{ request()->routeIs('dashboard') ? 'fw-bold' : '' }}"
            style="min-width: 80px;">
            <div class="d-flex flex-column align-items-center justify-content-center">
                <i class="ti ti-layout-dashboard fs-4 mb-1"></i>
                <small class="lh-1">Dashboard</small>
            </div>
        </a>

        <a href="{{ route('chart.index') }}"
            class="text-white mx-2 d-inline-block {{ request()->routeIs('chart.*') ? 'fw-bold' : '' }}"
            style="min-width: 80px;">
            <div class="d-flex flex-column align-items-center justify-content-center">
                <i class="ti ti-bar-chart fs-4 mb-1"></i>
                <small class="lh-1">Grafik</small>
            </div>
        </a>

        <a href="{{ route('bagian.index') }}"
            class="text-white mx-2 d-inline-block {{ request()->routeIs('bagian.*') ? 'fw-bold' : '' }}"
            style="min-width: 80px;">
            <div class="d-flex flex-column align-items-center justify-content-center">
                <i class="ti ti-list-details fs-4 mb-1"></i>
                <small class="lh-1">Bagian</small>
            </div>
        </a>

        <a href="{{ route('ruang.index') }}"
            class="text-white mx-2 d-inline-block {{ request()->routeIs('ruang.*') ? 'fw-bold' : '' }}"
            style="min-width: 80px;">
            <div class="d-flex flex-column align-items-center justify-content-center">
                <i class="ti ti-list-details fs-4 mb-1"></i>
                <small class="lh-1">Ruang</small>
            </div>
        </a>

        <a href="{{ route('categories.index') }}"
            class="text-white mx-2 d-inline-block {{ request()->routeIs('categories.*') ? 'fw-bold' : '' }}"
            style="min-width: 80px;">
            <div class="d-flex flex-column align-items-center justify-content-center">
                <i class="ti ti-list-details fs-4 mb-1"></i>
                <small class="lh-1">Kategori</small>
            </div>
        </a>

        <a href="{{ route('barang.index') }}"
            class="text-white mx-2 d-inline-block {{ request()->routeIs('barang.*') ? 'fw-bold' : '' }}"
            style="min-width: 80px;">
            <div class="d-flex flex-column align-items-center justify-content-center">
                <i class="ti ti-file-info fs-4 mb-1"></i>
                <small class="lh-1">Barang</small>
            </div>
        </a>

        <a href="{{ route('peminjaman.index') }}"
            class="text-white mx-2 d-inline-block {{ request()->routeIs('peminjaman.*') ? 'fw-bold' : '' }}"
            style="min-width: 80px;">
            <div class="d-flex flex-column align-items-center justify-content-center">
                <i class="ti ti-book fs-4 mb-1"></i>
                <small class="lh-1">Pinjam</small>
            </div>
        </a>

        <a href="{{ route('barangkeluar.index') }}"
            class="text-white mx-2 d-inline-block {{ request()->routeIs('barangkeluar.*') ? 'fw-bold' : '' }}"
            style="min-width: 80px;">
            <div class="d-flex flex-column align-items-center justify-content-center">
                <i class="ti ti-file-text fs-4 mb-1"></i>
                <small class="lh-1 text-nowrap">Barang Keluar</small>
            </div>
        </a>

        <a href="{{ route('download.index') }}"
            class="text-white mx-2 d-inline-block {{ request()->routeIs('download.*') ? 'fw-bold' : '' }}"
            style="min-width: 80px;">
            <div class="d-flex flex-column align-items-center justify-content-center">
                <i class="ti ti-file-text fs-4 mb-1"></i>
                <small class="lh-1">Download</small>
            </div>
        </a>

        <a href="{{ route('scan.index') }}"
            class="text-white mx-2 d-inline-block {{ request()->routeIs('scan.*') ? 'fw-bold' : '' }}"
            style="min-width: 80px;">
            <div class="d-flex flex-column align-items-center justify-content-center">
                <i class="ti ti-scan fs-4 mb-1"></i>
                <small class="lh-1">Scan</small>
            </div>
        </a>

        <a href="{{ route('report.index') }}"
            class="text-white mx-2 d-inline-block {{ request()->routeIs('report.*') ? 'fw-bold' : '' }}"
            style="min-width: 80px;">
            <div class="d-flex flex-column align-items-center justify-content-center">
                <i class="ti ti-file-text fs-4 mb-1"></i>
                <small class="lh-1">Laporan</small>
            </div>
        </a>

        <a href="{{ route('backup.database') }}"
            class="text-white mx-2 d-inline-block {{ request()->routeIs('backup.database') ? 'fw-bold' : '' }}"
            style="min-width: 80px;">
            <div class="d-flex flex-column align-items-center justify-content-center">
                <i class="ti ti-database fs-4 mb-1"></i>
                <small class="lh-1">Backup</small>
            </div>
        </a>

        <!-- Logout button in mobile bottom navbar -->
        <form method="POST" action="{{ route('logout') }}" class="mx-2 d-inline-block" style="min-width: 80px;">
            @csrf
            <button type="submit"
                class="btn btn-danger p-0 m-0 d-flex flex-column align-items-center justify-content-center"
                style="width: 100%; border: none;">
                <i class="ti ti-logout fs-4 mb-1"></i>
                <small class="lh-1">Logout</small>
            </button>
        </form>

    </div>
</div>

<script>
    // Simpan posisi scroll navbar bawah
    const navBar = document.querySelector('.fixed-bottom .d-flex');

    // Saat halaman akan unload, simpan posisi scroll ke localStorage
    window.addEventListener('beforeunload', () => {
        if (navBar) {
            localStorage.setItem('bottomNavScroll', navBar.scrollLeft);
        }
    });

    // Setelah halaman load, ambil posisi scroll dari localStorage
    document.addEventListener('DOMContentLoaded', () => {
        const scrollPos = localStorage.getItem('bottomNavScroll');
        if (navBar && scrollPos !== null) {
            navBar.scrollLeft = scrollPos;
        }
    });
</script>

<script>
    // Sidebar scroll simpan & restore
    const sidebar = document.getElementById('accordionSidebar');

    // Simpan scroll saat halaman ditutup atau reload
    window.addEventListener('beforeunload', () => {
        if (sidebar) {
            localStorage.setItem('sidebarScroll', sidebar.scrollTop);
        }
    });

    // Ambil scroll saat halaman dimuat
    document.addEventListener('DOMContentLoaded', () => {
        const sidebarScrollPos = localStorage.getItem('sidebarScroll');
        if (sidebar && sidebarScrollPos !== null) {
            sidebar.scrollTop = sidebarScrollPos;
        }
    });
</script>