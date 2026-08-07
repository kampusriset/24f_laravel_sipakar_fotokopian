<!DOCTYPE html>
<html lang="id">
<!-- Hapus data-bs-theme="dark" agar kembali ke mode terang -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'POS Fotocopy & Print')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* Background dasar abu-abu sangat muda khas UI Modern */
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            color: #333;
        }

        /* Navbar Kustom - Terang & Bersih */
        .navbar-light-custom {
            background-color: #ffffff;
            border-bottom: 1px solid #f0f0f0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
        }

        /* Kotak Logo Biru */
        .logo-box {
            background-color: #3b82f6;
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Styling Nav Link (Pill) */
        .nav-link-custom {
            color: #64748b !important;
            font-weight: 600;
            font-size: 0.95rem;
            padding: 0.6rem 1.2rem !important;
            border-radius: 50rem; /* Bentuk melingkar (pill) */
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-link-custom i {
            font-size: 1.1rem;
        }

        .nav-link-custom:hover {
            color: #3b82f6 !important;
            background-color: #f8fafc;
        }

        /* State Aktif Nav Link */
        .nav-link-custom.active {
            background-color: #eff6ff !important;
            color: #2563eb !important;
        }

        /* Tombol Primary Biru (New Jenis Layanan) */
        .btn-primary-custom {
            background-color: #2563eb;
            color: white;
            border: none;
            border-radius: 50rem;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s;
        }

        .btn-primary-custom:hover {
            background-color: #1d4ed8;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        /* Lingkaran Profil & Logout */
        .circle-btn {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            text-decoration: none;
            border: 1px solid #e2e8f0;
            transition: all 0.2s;
        }

        .profile-circle {
            background-color: #f1f5f9;
            color: #475569;
        }
        .profile-circle:hover { background-color: #e2e8f0; }

        .logout-circle {
            background-color: #ffffff;
            color: #64748b;
        }
        .logout-circle:hover {
            background-color: #fee2e2;
            color: #ef4444;
            border-color: #fca5a5;
        }
    </style>
</head>

<body>

    <!-- ================= TOP NAVBAR ================= -->
    <nav class="navbar navbar-expand-lg navbar-light-custom sticky-top py-2">
        <!-- <div class="container-fluid px-4"> -->
        <div class="container-xl">
            
            <!-- 1. Bagian Kiri: Logo & Nama Aplikasi -->
            <a class="navbar-brand d-flex align-items-center gap-3" href="{{ url('/home') }}">
                <div class="logo-box text-white">
                    <i class="bi bi-printer-fill fs-5"></i>
                </div>
                <span class="fw-bold text-dark tracking-tight" style="font-size: 1.1rem;">1HZS FOTOCOPY & PRINT</span>
            </a>

            <!-- Tombol Hamburger -->
            <button class="navbar-toggler shadow-none border-0" type="button" data-bs-toggle="collapse" data-bs-target="#menuNavigasi">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="menuNavigasi">
                
                <!-- 2. Bagian Tengah: Menu Utama (menggunakan mx-auto agar ke tengah) -->
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-1">
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom {{ request()->is('home*') ? 'active' : '' }}" href="{{ url('/home') }}">
                            <i class="bi bi-house-door-fill"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom {{ request()->is('transaksi*') ? 'active' : '' }}" href="{{ url('/transaksi') }}">
                            <i class="bi bi-receipt"></i> Transaksi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom {{ request()->is('riwayat*') ? 'active' : '' }}" href="{{ url('/riwayat') }}">
                            <i class="bi bi-clock"></i> Riwayat
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom {{ request()->is('stok-barang*') ? 'active' : '' }}" href="{{ url('/stok-barang') }}">
                            <i class="bi bi-box"></i> Stok
                        </a>
                    </li>
                    
                    <!-- Laporan dipindah ke depan sesuai gambar -->
                    @if(Auth::check() && Auth::user()->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom {{ request()->is('laporan*') ? 'active' : '' }}" href="{{ url('/laporan') }}">
                            <i class="bi bi-bar-chart-fill"></i> Laporan
                        </a>
                    </li>

                    <!-- Sisa Menu Admin disembunyikan dalam Dropdown agar rapi -->
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-link-custom dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-gear-fill"></i>
                        </a>
                        <ul class="dropdown-menu border-0 shadow-sm mt-2 rounded-3">
                            <li><a class="dropdown-item py-2" href="{{ url('/printer') }}"><i class="bi bi-printer me-2"></i> Perangkat Printer</a></li>
                            <li><a class="dropdown-item py-2" href="{{ route('operator.index') }}"><i class="bi bi-person-badge me-2"></i> Karyawan</a></li>
                            <li><a class="dropdown-item py-2" href="{{ route('pelanggan.index') }}"><i class="bi bi-people me-2"></i> Pelanggan</a></li>
                        </ul>
                    </li>
                    @endif
                </ul>

                <!-- 3. Bagian Kanan: Aksi & Profil -->
                <div class="d-flex align-items-center gap-3 mt-3 mt-lg-0">
                    
                    <!-- Tombol New Jenis Layanan (Khusus Admin, meniru gambar) -->
                    @if(Auth::check() && Auth::user()->role === 'admin')
                    <a href="{{ url('/layanan') }}" class="btn btn-primary-custom d-flex align-items-center gap-2">
                        <i class="bi bi-plus-lg text-white"></i> New Jenis Layanan
                    </a>
                    @endif

                    <!-- Lingkaran Profil (Inisial Nama) -->
                    <a href="{{ url('/profil') }}" class="text-decoration-none" title="Profil {{ Auth::user()->operator->name ?? 'User' }}">
                        <div class="circle-btn profile-circle">
                            {{-- Mengambil 2 huruf pertama dari nama user (Misal: Zidane -> ZI) --}}
                            {{ strtoupper(substr(Auth::user()->operator->name ?? 'US', 0, 2)) }}
                        </div>
                    </a>

                    <!-- Tombol Logout Lingkaran -->
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="circle-btn logout-circle" title="Keluar">
                            <i class="bi bi-box-arrow-right fs-5"></i>
                        </button>
                    </form>
                </div>
                
            </div>
        </div>
    </nav>

    <!-- ================= MAIN CONTENT ================= -->
    <main class="py-4">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>