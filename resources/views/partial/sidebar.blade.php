<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/home" class="nav-link">Home</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/contact" class="nav-link">Kontak</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ asset('Juknis/Juknis.pdf') }}" target="_blank" class="nav-link">Baca Juknisnya!</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/lastes-version" class="nav-link">Apa Yang Baru?</a>
        </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        {{-- fullscreen --}}
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle pt-1" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600">{{ Auth::user()->nama }}</span>
                <img class="img-profile rounded-circle"
                    src="{{ asset('file_upload/foto profil/' . (Auth::user() && Auth::user()->gambar ? Auth::user()->gambar : 'user profil.png')) }}"
                    style="width: 35px">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="/profile">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <div class="dropdown-divider"></div>
                {{-- <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal"> //standard --}}
                <a class="dropdown-item" href="" id="logout"> {{-- sweatallert  --}}
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->


<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4 sidebar-light-primary">
    <!-- Brand Logo -->
    <a href="/home" class="brand-link bg-primary">
        <img src="{{ asset('img/icon_logo.png') }}" alt="Logo" class="brand-image" style="width: 33px;">
        <span class="brand-text font-weight-light" style="letter-spacing: 4px;"> <i><b>Si -
                    AuDi</b><sup style="font-size: 10pt; letter-spacing: 1px;">(Apl-Audit)</sup></i> </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
            <div class="image pl-1">
                <div class="position-relative">
                    <div
                        class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1">
                    </div>
                    <img style="width: 45px;"
                        src="{{ asset('file_upload/foto profil/' . (Auth::user() && Auth::user()->gambar ? Auth::user()->gambar : 'user profil.png')) }}"
                        class="img-circle elevation-2" alt="User Image">
                </div>
            </div>
            <div class="info">
                <a href="/profile" class="d-block">{{ Auth::user()->nama }}</a>
                <span>{{ Auth::user()->sub_jabatan }}</span>
            </div>
        </div>


        <!-- Sidebar Menu -->
        @if (auth()->user()->id_cabang == '0')
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-item {{ request()->is('/home') ? 'menu-open' : '' }}">
                        <a href="/home" class="nav-link {{ Request::is('home*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>

                    <li class="nav-item {{ request()->is('/risk-event') ? 'menu-open' : '' }}">
                        <a href="/risk-event" class="nav-link {{ Request::is('risk-event*') ? 'active' : '' }}">
                            <i class="nav-icon fa-brands fa-elementor"></i>
                            <p>
                                Risk Event
                            </p>
                        </a>
                    </li>

                    <li class="nav-item {{ request()->is('debitur*') ? 'menu-open' : '' }}">
                        <a href="/debitur" class="nav-link {{ Request::is('debitur*') ? 'active' : '' }}">
                            <i class="nav-icon fa-solid fa-users-viewfinder"></i>
                            <p>
                                Data Debitur
                            </p>
                        </a>
                    </li>

                    <li class="nav-item {{ request()->is('data-kkpk*') ? 'menu-open' : '' }}">
                        <a href="/data-kkpk" class="nav-link {{ Request::is('data-kkpk*') ? 'active' : '' }}">
                            <i class="nav-icon fa-solid fa-file-invoice"></i>
                            <p>
                                Data KKPK
                            </p>
                        </a>
                    </li>

                    <li
                        class="nav-item {{ request()->is('data-lkhp*', 'lkhp-ops*', 'lkhp-final*') ? 'active menu-is-opening menu-open' : '' }}">
                        <a href="#"
                            class="nav-link  {{ request()->is('data-lkhp*', 'lkhp-ops*', 'lkhp-final*') ? 'active aria-expanded= "true"' : 'collapsed' }}">
                            <i class="nav-icon fa-solid fa-book"></i>
                            <p>
                                Data LKHP
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul
                            class="nav nav-treeview  {{ request()->is('data-lkhp*', 'lkhp-ops*', 'lkhp-final*') ? 'style="display: block;"' : '' }}">
                            <li class="nav-item">
                                <a href="/data-lkhp"
                                    class="nav-link {{ Request::is('data-lkhp*', 'lkhp-ops*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>LKHP Bayangan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/lkhp-final"
                                    class="nav-link {{ Request::is('lkhp-final*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>LKHP Final</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li
                        class="nav-item {{ request()->is('potensi-kerugian*', 'potensi-loss-konsolidasi*', 'temuan-berulang*') ? 'active menu-is-opening menu-open' : '' }}">
                        <a href="#"
                            class="nav-link  {{ request()->is('potensi-kerugian*', 'potensi-loss-konsolidasi*', 'temuan-berulang*') ? 'active aria-expanded= "true"' : 'collapsed' }}">
                            <i class="fa-regular fa-folder-open nav-icon"></i>
                            <p>
                                Rekap LKHP
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul
                            class="nav nav-treeview  {{ request()->is('potensi-kerugian*', 'potensi-loss-konsolidasi*', 'temuan-berulang*') ? 'style="display: block;"' : '' }}">
                            <li class="nav-item">
                                <a href="/potensi-kerugian"
                                    class="nav-link {{ Request::is('potensi-kerugian*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Potensi Kerugian</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/potensi-loss-konsolidasi"
                                    class="nav-link {{ Request::is('potensi-loss-konsolidasi*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Konsolidasi</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="/temuan-berulang"
                                    class="nav-link {{ Request::is('temuan-berulang*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Temuan Berulang</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item {{ request()->is('lainnya*') ? 'menu-open' : '' }}">
                        <a href="/lainnya" class="nav-link {{ Request::is('lainnya*') ? 'active' : '' }}">
                            <i class="nav-icon fa-solid fa-person-dots-from-line"></i>
                            <p>
                                Lainnya
                            </p>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->is('log-act*') ? 'menu-open' : '' }}">
                        <a href="/log-act" class="nav-link {{ Request::is('log-act*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-history" aria-hidden="true"></i>
                            <p>
                                Log Activity
                            </p>
                        </a>
                    </li>


                </ul>
            </nav>
        @else
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-item {{ request()->is('/home') ? 'menu-open' : '' }}">
                        <a href="/home" class="nav-link {{ Request::is('home*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>

                    <li class="nav-item {{ request()->is('lkhp-final*') ? 'menu-open' : '' }}">
                        <a href="/lkhp-final" class="nav-link {{ Request::is('lkhp-final*') ? 'active' : '' }}">
                            <i class="nav-icon fa-solid fa-person-dots-from-line"></i>
                            <p>LKHP Final</p>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->is('log-act*') ? 'menu-open' : '' }}">
                        <a href="/log-act" class="nav-link {{ Request::is('log-act*') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-history" aria-hidden="true"></i>
                            <p>
                                Log Activity
                            </p>
                        </a>
                    </li>


                </ul>
            </nav>
        @endif
    </div>
</aside>


<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Yakin Keluar?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Pilih "Logout" Jika Anda Yakin Akan Keluar.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-primary">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>
