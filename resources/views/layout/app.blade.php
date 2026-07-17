<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Fotocopy</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        /* Kustomisasi UI/UX */
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background-color: #121212;
        }
        .sidebar { 
            min-height: 100vh; 
            background-color: #0a0a0a;
            border-right: 1px solid #333;
        }
        .topbar {
            background-color: #0a0a0a;
            border-bottom: 1px solid #333;
        }
        .nav-link { 
            transition: all 0.3s ease; 
            color: #adb5bd;
        }
        .nav-link:hover, .nav-link.active { 
            background-color: rgba(255,255,255,0.05); 
            border-radius: 8px; 
            color: #fff;
        }
    </style>
</head>
<body class="text-light">

    <div class="d-flex">
        <!-- ================= SIDEBAR ================= -->
        <div class="sidebar p-3" style="width: 260px;">
            <h4 class="mb-4 mt-2 text-center text-primary fw-bold">
                <i class="bi bi-printer-fill me-2"></i>POS Fotocopy
            </h4>
            <hr class="border-secondary">
            
            <ul class="nav flex-column gap-1">
                <!-- Menu Universal (Bisa diakses semua) -->
                <li class="nav-item">
                    <a href="#" class="nav-link active"><i class="bi bi-house-door me-2"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="bi bi-cart-check me-2"></i> Transaksi</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="bi bi-box-seam me-2"></i> Stok Barang</a>
                </li>

                <!-- Menu KHUSUS ADMIN (Menggunakan @if) -->
                @if(Auth::check() && Auth::user()->role === 'admin')
                <li class="nav-item mt-4 mb-2">
                    <small class="text-secondary text-uppercase fw-bold px-3" style="font-size: 0.75rem;">Manajemen Admin</small>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="bi bi-graph-up me-2"></i> Laporan</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link"><i class="bi bi-people me-2"></i> Pelanggan & Operator</a>
                </li>
                @endif
            </ul>
        </div>

        <!-- ================= MAIN CONTENT ================= -->
        <div class="flex-grow-1 d-flex flex-column">
            <!-- Navbar / Topbar -->
            <nav class="topbar px-4 py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold">@yield('title', 'Dashboard')</h5>
                
                <div class="d-flex align-items-center gap-3">
                    @if(Auth::check())
                        <div class="text-end me-2">
                            <div class="fw-bold fs-6">{{ Auth::user()->name }}</div>
                            <div class="text-muted" style="font-size: 0.8rem;">{{ ucfirst(Auth::user()->role) }}</div>
                        </div>
                        <!-- Tombol Logout -->
                        <form action="/logout" method="POST" class="m-0">
                            @csrf
                            <button class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    @endif
                </div>
            </nav>

            <!-- Area Konten Dinamis (Di sinilah halaman lain akan disuntikkan) -->
            <div class="p-4">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>