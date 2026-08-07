@extends('layout.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="row g-4">
    <!-- Banner Selamat Datang -->
    <div class="col-12">
        <div class="card border-secondary shadow-sm rounded-4" style="background: linear-gradient(145deg, #1a1d20, #121212);">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <!-- <h4 class="fw-bold text-white mb-2">Selamat Datang, {{ Auth::user()->name }}! 👋</h4> -->
                    <h4 class="fw-bold text-white mb-2">Selamat datang, {{ Auth::user()->operator->name }} ! 👋</h4>
                    <p class="text-secondary mb-0">Selamat bertugas hari ini. Silakan mulai transaksi baru atau pantau ketersediaan stok barang.</p>
                </div>
                <div class="d-none d-md-block">
                    <i class="bi bi-cart-check-fill text-primary" style="font-size: 3.5rem; opacity: 0.8;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Jalan Pintas (Quick Actions) -->
    <div class="col-md-6">
        <div class="card bg-dark border-secondary shadow-sm rounded-4 h-100 p-3 hover-card">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                        <i class="bi bi-clock-history text-primary fs-3"></i>
                    </div>
                    <h5 class="fw-bold text-white mb-0">Riwayat Transaksi</h5>
                </div>
                <p class="text-secondary">Catat penjualan fotocopy, print, atau alat tulis kantor (ATK) dengan cepat.</p>
                <a href="{{ url('/riwayat') }}" class="btn btn-primary mt-2 rounded-pill px-4 fw-semibold">
                    <i class="bi bi-clock-history me-1"></i> Buka Riwayat Transaksi
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card bg-dark border-secondary shadow-sm rounded-4 h-100 p-3 hover-card">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-info bg-opacity-10 p-3 rounded-3 me-3">
                        <i class="bi bi-box-seam text-info fs-3"></i>
                    </div>
                    <h5 class="fw-bold text-white mb-0">Ketersediaan Stok</h5>
                </div>
                <p class="text-secondary">Pantau sisa barang fisik seperti kertas, tinta, dan ATK agar tidak kehabisan.</p>
                <a href="{{ url('/stok-barang') }}" class="btn btn-outline-info mt-2 rounded-pill px-4 fw-semibold">
                    <i class="bi bi-search me-1"></i> Lihat Stok
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Tambahan sedikit CSS untuk efek animasi Card -->
<style>
    .hover-card {
        transition: all 0.3s ease;
        border: 1px solid #2b3035;
    }
    .hover-card:hover {
        transform: translateY(-5px); /* Kartu naik sedikit */
        border-color: #0d6efd !important; /* Border menyala biru */
        box-shadow: 0 10px 20px rgba(13, 110, 253, 0.1) !important;
    }
</style>
@endsection