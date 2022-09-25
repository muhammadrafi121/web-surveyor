<ul class="navbar-nav bg-white sidebar accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard">
        <img src="/img/apple-logo.png" width="33px" alt="" />
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0" />

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link active" href="/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider" />

    @canany(['isAdmin', 'isSurveyor'])
        <li class="nav-item">
            <a class="nav-link collapsed" href="" data-toggle="collapse" data-target="#collapseThree"
                aria-expanded="true" aria-controls="collapseThree">
                <i class="fas fa-fw fa-database"></i>
                <span>Data</span>
            </a>
            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionSidebar">
                <div class="bg-green-blue py-2 collapse-inner">
                    @can('isAdmin')
                        <a class="collapse-item" href="/inventory">Inventory</a>
                        <a class="collapse-item" href="/location">Jalur</a>
                    @endcan
                    <a class="collapse-item" href="/tower">Tapak Tower</a>
                    <a class="collapse-item" href="/row">ROW</a>
                    <a class="collapse-item" href="/land">Lahan</a>
                    <a class="collapse-item" href="/dailyreport">Daily Report</a>
                </div>
            </div>
        </li>
    @endcanany

    @can('isAdmin')
        <!-- Nav Item - laporan -->
        <li class="nav-item">
            <a class="nav-link" href="laporan.html">
                <i class="fas fa-fw fa-chart-line"></i>
                <span>Laporan</span>
            </a>
        </li>

        <!-- Nav Item - Peta -->
        <li class="nav-item">
            <a class="nav-link" href="/map">
                <i class="fas fa-fw fa-map-location-dot"></i>
                <span>Peta</span></a>
        </li>
    @endcan

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-cog"></i>
            <span>Pengaturan</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-green-blue py-2 collapse-inner">
                @can('isAdmin')
                    <a class="collapse-item" href="login.html">Tambah Akun</a>
                    <a class="collapse-item" href="forgot-password.html">List User</a>
                @endcan
                <a class="collapse-item" href="register.html">Profil</a>
            </div>
        </div>
    </li>

    @can('isAdmin')
        <!-- Nav Item - Charts -->
        <li class="nav-item">
            <a class="nav-link" href="charts.html">
                <i class="fas fa-fw fa-wrench"></i>
                <span>Alat</span></a>
        </li>
    @endcan

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block" />

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
