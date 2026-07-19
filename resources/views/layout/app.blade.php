<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'POS Fotocopy')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* Kustomisasi Typography & Background */
        body {
            background-color: #121212;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        /* Navbar Kustom */
        .custom-navbar {
            background-color: rgba(26, 29, 32, 0.98);
            border-bottom: 1px solid #2b3035;
            backdrop-filter: blur(10px);
        }

        /* Efek Hover Menu Atas */
        .nav-link {
            color: #adb5bd;
            font-weight: 500;
            transition: all 0.3s ease;
            border-radius: 8px;
            padding: 8px 16px !important;
            margin: 0 4px;
        }

        .nav-link:hover,
        .nav-link.active {
            background-color: rgba(13, 110, 253, 0.15);
            /* Efek biru transparan */
            color: #0d6efd;
        }

        /* Kustomisasi Dropdown Admin */
        .dropdown-menu {
            background-color: #1a1d20;
            border: 1px solid #2b3035;
            border-radius: 8px;
        }

        .dropdown-item {
            color: #adb5bd;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: rgba(13, 110, 253, 0.15);
            color: #0d6efd;
        }
    </style>
</head>

<body class="text-light">

    <!-- ================= TOP NAVBAR (NAVIGASI ATAS) ================= -->
    <nav class="navbar navbar-expand-lg custom-navbar sticky-top py-3">
        <div class="container-fluid px-4">
            <!-- Logo Aplikasi -->
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-white me-4" href="{{ url('/stok-barang') }}">
                <i class="bi bi-printer-fill text-primary fs-3"></i>
                <span>POS<span class="text-primary">Fotocopy</span></span>
            </a>

            <!-- Tombol Hamburger (Untuk layar HP) -->
            <button class="navbar-toggler shadow-none border-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#menuNavigasi">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Daftar Menu -->
            <div class="collapse navbar-collapse" id="menuNavigasi">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- Menu Universal -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('home*') ? 'active' : '' }}" href="{{ url('/home') }}">
                            <i class="bi bi-grid-1x2-fill me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('transaksi*') ? 'active' : '' }}" href="{{ url('/transaksi') }}">
                            <i class="bi bi-cart-fill me-1"></i> Transaksi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('stok-barang*') ? 'active' : '' }}" href="{{ url('/stok-barang') }}">
                            <i class="bi bi-box-seam me-1"></i> Stok Barang
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('riwayat*') ? 'active' : '' }}" href="{{ url('/riwayat') }}">
                            <i class="bi bi-clock-history me-1"></i> Riwayat Transaksi
                        </a>
                    </li>

                    <!-- Menu KHUSUS ADMIN (Dibikin Dropdown) -->
                    @if(Auth::check() && Auth::user()->role === 'admin')
                    <li class="nav-item dropdown ms-lg-2 mt-2 mt-lg-0">
                        <!-- <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-shield-lock-fill me-1"></i> Manajemen Admin -->
                        <a class="nav-link dropdown-toggle {{ request()->is('laporan*') || request()->is('operator*') || request()->is('pelanggan*') ? 'active fw-bold' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-shield-lock-fill me-1"></i> Manajemen Admin
                        </a>

                        <ul class="dropdown-menu shadow">
                            <li>
                                <a class="dropdown-item py-2 {{ request()->is('laporan') ? 'active fw-bold' : '' }}" href="{{ url('/laporan') }}">
                                    <i class="bi bi-file-earmark-bar-graph me-2"></i> Laporan Pendapatan
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item py-2 {{ request()->is('operator') ? 'active fw-bold' : '' }}" href="{{ route('operator.index') }}">
                                    <i class="bi bi-person-badge me-2"></i> Manajemen Karyawan
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2 {{ request()->is('pelanggan') ? 'active fw-bold' : '' }}" href="{{ route('pelanggan.index') }}">
                                    <i class="bi bi-people me-2"></i> Data Pelanggan
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endif
                </ul>

                <!-- Profil User & Logout di sebelah kanan -->
                <div class="d-flex align-items-center gap-4 mt-3 mt-lg-0">
                    @if(Auth::check())
                    <div class="text-end d-none d-lg-block">
                        <div class="fw-bold text-white" style="font-size: 0.95rem;">{{ Auth::user()->name }}</div>
                        <div class="text-primary fw-semibold" style="font-size: 0.75rem; letter-spacing: 0.5px;">{{ strtoupper(Auth::user()->role) }}</div>
                    </div>

                    <form action="{{ url('/logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-4 d-flex align-items-center gap-2 w-100">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- ================= MAIN CONTENT ================= -->
    <main class="container-fluid px-4 py-4">
        <!-- Judul Halaman Dinamis -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-semibold text-white">@yield('title', 'Dashboard')</h4>
        </div>

        <div class="row">
            <div class="col-12">
                @yield('content')
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>