@extends('layout.app')

@section('title', 'Dashboard')

@section('content')
<style>
    body { background-color: #e3e3e3 !important; }

    .dashboard-card {
        background: #ffffff;
        border: 1px solid #f0f0f0;
        border-radius: 18px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(13, 110, 253, 0.1);
        border-color: #e2e8f0;
    }

    .progress-line {
        height: 6px;
        border-radius: 10px;
        background-color: #f1f5f9;
        margin: 8px 0 0 0;
        overflow: hidden;
    }
    .progress-bar-custom {
        height: 100%;
        border-radius: 10px;
        transition: width 0.4s ease;
    }
    .bg-danger-custom { background-color: #ef4444; }
    .bg-warning-custom { background-color: #f59e0b; }
    .bg-success-custom { background-color: #10b981; }

    .badge-soft-success { background-color: #ecfdf5; color: #059669; padding: 5px 10px; font-weight: 600; font-size: 0.75rem;}
    .badge-soft-warning { background-color: #fffbeb; color: #d97706; padding: 5px 10px; font-weight: 600; font-size: 0.75rem;}
    .badge-soft-danger { background-color: #fef2f2; color: #dc2626; padding: 5px 10px; font-weight: 600; font-size: 0.75rem;}
    .status-dot { font-size: 6px; vertical-align: middle; margin-right: 3px; padding-bottom: 2px;}

    .table-custom th {
        text-transform: uppercase;
        font-size: 0.75rem;
        color: #888;
        font-weight: 600;
        border-bottom: 2px solid #f4f4f4;
        padding: 1rem;
    }
    .table-custom td {
        border-bottom: 1px solid #f8f9fa;
        vertical-align: middle;
        color: #444;
        font-size: 0.9rem;
        padding: 1rem;
    }

    .btn-outline-light-custom {
        border: 1px solid #e2e8f0;
        color: #64748b;
        background: transparent;
        border-radius: 10px;
        font-weight: 600;
        padding: 0.4rem 1rem;
        font-size: 0.85rem;
    }
    .btn-outline-light-custom:hover { background-color: #f8f9fa; color: #3e3c3e; border-color: #a210f0; }
    .btn-icon-only { padding: 0.4rem 0.6rem; border-radius: 8px; }

    .icon-box-md {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
    }

    .page-footer {
        text-align: center;
        padding: 1.5rem 0;
        margin-top: 2rem;
        color: #94a3b8;
        font-size: 0.85rem;
        border-top: 1px solid #e2e8f0;
    }
</style>

<div class="container-xl py-4">

    <!-- HEADER -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h3 class="fw-bold text-dark mb-1">Dashboard Fotocopy & Printing</h3>
            <p class="text-muted mb-0">Ringkasan operasional dan antrean hari ini.</p>
        </div>
        <button class="btn btn-outline-light-custom bg-white shadow-sm" onclick="location.reload()">
            <i class="bi bi-arrow-clockwise me-2"></i>Refresh
        </button>
    </div>

    <!-- WIDGET RINGKASAN ATAS -->
    <div class="row g-4 mb-5">
        <div class="col-12 col-md-4">
            <div class="card dashboard-card p-4 h-100 border-0">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small fw-semibold mb-2">Total Antrean</p>
                        <!-- Ganti angka 12 dengan variabel -->
                        <h2 class="fw-bold mb-2 fs-2 text-dark">{{ $totalAntrean }}</h2>
                        <small class="text-success fw-medium">&uarr; Membutuhkan tindakan</small>
                    </div>
                    <div class="icon-box-md bg-primary bg-opacity-10 text-primary fs-4 p-4 rounded-3">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card dashboard-card p-4 h-100 border-0">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small fw-semibold mb-2">Pekerjaan Hari Ini</p>
                        <h2 class="fw-bold mb-2 fs-2 text-dark">{{ $pekerjaanHariIni }}</h2>
                        <small class="text-muted">{{ $sedangDiproses }} sedang diproses</small>
                    </div>
                    <div class="icon-box-md p-4 rounded-3" style="background-color: #f3e8ff; color: #9333ea; font-size: 1.25rem;">
                        <i class="bi bi-printer-fill"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card dashboard-card p-4 h-100 border-0">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small fw-semibold mb-2">Pesanan Selesai</p>
                        <h2 class="fw-bold mb-2 fs-2 text-dark">{{ $pesananSelesai }}</h2>
                        <small class="text-muted">Siap diambil</small>
                    </div>
                    <div class="icon-box-md bg-success bg-opacity-10 text-success fs-4 p-4 rounded-3">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BAGIAN LAYANAN AKTIF -->
    <div class="mb-5">
        <h5 class="fw-bold text-dark mb-3 fs-5">Layanan Aktif</h5>
        <div class="row g-4"> 
            @forelse($layanan as $l)
            @php
                $icon = 'bi-file-earmark-text';
                $color = 'primary';
                if(stripos($l->nama_layanan, 'warna') !== false) {
                    $icon = 'bi-palette-fill'; $color = 'success';
                } elseif(stripos($l->nama_layanan, 'scan') !== false) {
                    $icon = 'bi-upc-scan'; $color = 'info';
                } elseif(stripos($l->nama_layanan, 'ketik') !== false) {
                    $icon = 'bi-keyboard'; $color = 'warning';
                }
            @endphp
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card dashboard-card hover-card p-3 border-0">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-box-md bg-{{ $color }} bg-opacity-10 text-{{ $color }} fs-5">
                            <i class="bi {{ $icon }}"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold text-dark mb-1" style="font-size: 0.95rem;">{{ $l->nama_layanan }}</h6>
                            <p class="text-muted fw-medium mb-0" style="font-size: 0.8rem;">Rp {{ number_format($l->harga_per_lembar ?? 0, 0, ',', '.') }} / lbr</p>
                        </div>
                        <div>
                            <span class="badge badge-soft-success rounded-pill border px-2 py-1" style="font-size: 0.7rem;">
                                <i class="bi bi-circle-fill status-dot"></i> Aktif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="card dashboard-card p-4 text-center text-muted"><p class="mb-0">Belum ada data jenis layanan.</p></div>
            </div>
            @endforelse
        </div>
    </div>

    <!-- BAGIAN STOK BARANG -->
    <div class="mb-5">
        <h5 class="fw-bold text-dark mb-3 fs-5">Stok Barang Toko</h5>
        <div class="row g-4">
            @forelse($stokBarang ?? [] as $stok)
            @php
                $minStok = $stok->minimum_stok ?? 10; 
                $persen = ($stok->jumlah_stok / ($minStok * 3)) * 100; 
                $persen = $persen > 100 ? 100 : $persen;
                
                if($stok->jumlah_stok <= 0) {
                    $color = 'danger'; $bgClass = 'bg-danger-custom'; $statusText = 'Habis';
                } elseif($stok->jumlah_stok <= $minStok) {
                    $color = 'warning'; $bgClass = 'bg-warning-custom'; $statusText = 'Kritis';
                } else {
                    $color = 'success'; $bgClass = 'bg-success-custom'; $statusText = 'Aman';
                }
            @endphp
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card dashboard-card p-3 border-0">
                    
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <span class="text-muted small text-uppercase fw-semibold" style="font-size: 0.7rem;">{{ $stok->kategori ?? 'Umum' }}</span>
                            <h6 class="text-dark fw-bold mb-0 mt-1" style="font-size: 0.95rem;">{{ $stok->nama_barang }}</h6>
                        </div>
                        <span class="badge badge-soft-{{ $color }} rounded-pill border px-2 py-1" style="font-size: 0.7rem;">
                            <i class="bi bi-circle-fill status-dot"></i> {{ $statusText }}
                        </span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-end mt-2" style="font-size: 0.75rem;">
                        <span class="text-dark fw-medium">Stok: {{ $stok->jumlah_stok }} {{ $stok->satuan }}</span>
                        <span class="text-muted">Min: {{ $minStok }} {{ $stok->satuan }}</span>
                    </div>

                    <div class="progress-line">
                        <div class="progress-bar-custom {{ $bgClass }}" style="width: {{ $persen }}%;"></div>
                    </div>
                    
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="card dashboard-card p-4 text-center text-muted">Belum ada data stok barang.</div>
            </div>
            @endforelse
        </div>
    </div>

    <!-- BAGIAN TABEL TRANSAKSI -->
    <div class="mb-4">
        <div class="card dashboard-card border-0 overflow-hidden">
            <div class="card-header bg-white border-0 pt-4 pb-3 px-4 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold text-dark d-flex align-items-center">
                    <i class="bi bi-list-task text-primary me-2"></i>Daftar Transaksi Terakhir
                </h6>
                <a href="{{ url('/riwayat') }}" class="text-primary text-decoration-none small fw-semibold">Lihat Semua &rarr;</a>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-custom table-borderless mb-0">
                        <thead class="bg-white">
                            <tr>
                                <th class="ps-4">Nama</th>
                                <th>File</th>
                                <th>Layanan</th>
                                <th class="text-center">Halaman</th>
                                <th>Tenggat</th>
                                <th>Status</th>
                                <th class="text-center pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @forelse($transaksiTerbaru->take(5) as $trx)
                            <tr>
                                <td class="fw-bold text-dark ps-4">{{ $trx->nama_pelanggan ?? 'Tanpa Nama' }}</td>
                                <td><span class="text-muted">{{ preg_replace('/^[0-9]+_/', '', $trx->file_dokumen) ?? 'Tidak ada file' }}</span></td>
                                <td><span class="text-dark">{{ $trx->metode ?? 'Print Dokumen' }}</span></td>
                                <td class="text-center">{{ $trx->jumlah_halaman ?? '-' }} Lbr</td>
                                <td>{{ \Carbon\Carbon::parse($trx->waktu_deadline)->format('H:i') }} WIB</td>
                                <td>
                                    <span class="badge badge-soft-success rounded-pill border">
                                        <i class="bi bi-circle-fill status-dot"></i> Selesai
                                    </span>
                                </td>
                                <td class="text-center pe-4">
                                    <button class="btn btn-outline-light-custom btn-icon-only"><i class="bi bi-eye"></i></button>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="text-center py-5 text-muted">Belum ada data transaksi.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- PAGE FOOTER COPYRIGHT -->
    <footer class="page-footer">
        © 2026 1HZS Fotocopy & Print. Semua hak dilindungi.
    </footer>

</div>
@endsection