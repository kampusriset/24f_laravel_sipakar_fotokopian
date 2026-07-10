<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Fotocopy & Print</title>
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/3063/3063822.png" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #121212; /* Warna background utama */
        }
        /* Efek hover elegan untuk menu Navigasi Atas */
        .nav-link {
            transition: all 0.3s ease;
            border-radius: 6px;
            padding: 8px 16px !important;
            margin: 0 4px;
        }
        .nav-link:hover:not(.active) { 
            background-color: rgba(255, 255, 255, 0.05); 
            transform: translateY(-2px); 
        }
        /* Kartu Dashboard */
        .widget-card { 
            transition: transform 0.3s ease, box-shadow 0.3s ease; 
        }
        .widget-card:hover { 
            transform: translateY(-5px); 
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3); 
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg bg-dark border-bottom border-secondary py-3">
        <div class="container-fluid px-4">
            <a class="navbar-brand fs-4 fw-bold me-5" href="/">
                POS <span class="text-primary">Fotocopy</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active bg-primary text-white fw-medium" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ url('/transaksi') }}">Transaksi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Jenis Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Riwayat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Stok Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Laporan</a>
                    </li>
                </ul>
                
                <div class="d-flex align-items-center text-end mt-3 mt-lg-0">
                    <div>
                        <strong class="d-block lh-1 text-white">Kasir Aktif</strong>
                        <small class="text-muted" style="font-size: 0.8rem;">Super Admin</small>
                    </div>
                </div>
            </div>
        </div>
    </nav>

<!-- JENIS LAYANAN -->
    <div class="container-fluid px-4 py-5">
        <div class="mb-5">
            <h1 class="fw-bold m-0">Dashboard Overview</h1>
            <p class="text-muted mt-1 mb-0">Kamis, 9 Juli 2026</p>
        </div>

        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-5 g-3 mb-5">
            
            @php
                // Variasi warna dan ikon
                $styles = [
                    ['icon' => 'bi-files', 'bg' => 'rgba(108, 117, 125, 0.15)', 'color' => '#adb5bd'],
                    ['icon' => 'bi-printer-fill', 'bg' => 'rgba(13, 110, 253, 0.15)', 'color' => '#0d6efd'],
                    ['icon' => 'bi-printer', 'bg' => 'rgba(248, 249, 250, 0.1)', 'color' => '#f8f9fa'],
                    ['icon' => 'bi-upc-scan', 'bg' => 'rgba(111, 66, 193, 0.15)', 'color' => '#6f42c1'],
                    ['icon' => 'bi-keyboard-fill', 'bg' => 'rgba(25, 135, 84, 0.15)', 'color' => '#198754'],
                ];
            @endphp

            @forelse ($daftarLayanan as $index => $layanan)
                @php
                    $style = $styles[$index % count($styles)];
                @endphp
                
                <div class="col">
                    <div class="card widget-card bg-dark border-0 h-100 shadow-sm">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="d-flex align-items-center justify-content-center rounded-3 mb-3" style="width: 45px; height: 45px; background-color: {{ $style['bg'] }}; color: {{ $style['color'] }};">
                                <i class="bi {{ $style['icon'] }} fs-5"></i>
                            </div>
                            
                            <h6 class="card-title text-muted fw-semibold mb-1" style="font-size: 0.85rem; line-height: 1.4;">
                                {{ $layanan->nama_layanan }}
                            </h6>
                            
                            <h3 class="fw-bold m-0 text-white mt-auto">
                                Rp {{ number_format($layanan->harga_per_lembar, 0, ',', '.') }}
                            </h3>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 w-100 text-center py-4">
                    <p class="text-muted m-0">Belum ada daftar layanan.</p>
                </div>
            @endforelse
            
        </div>

        <div>
            <div class="d-flex justify-content-between align-items-end mb-3">
                <h4 class="fw-bold m-0">Transaksi Terbaru</h4>
                <a href="#" class="text-primary text-decoration-none small fw-medium">Lihat Semua Riwayat &rarr;</a>
            </div>
            
            <div class="card bg-dark border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover table-borderless align-middle mb-0">
                            
                            <thead class="border-bottom border-secondary text-muted">
                                <tr>
                                    <th scope="col" class="py-3 px-4 fw-medium text-uppercase" style="font-size: 0.85rem;">Nama</th>
                                    <th scope="col" class="py-3 fw-medium text-uppercase" style="font-size: 0.85rem;">File</th>
                                    <th scope="col" class="py-3 fw-medium text-uppercase" style="font-size: 0.85rem;">Halaman</th>
                                    <th scope="col" class="py-3 fw-medium text-uppercase" style="font-size: 0.85rem;">Tenggat</th>
                                    <th scope="col" class="py-3 fw-medium text-uppercase" style="font-size: 0.85rem;">Pembayaran</th>
                                    <th scope="col" class="py-3 fw-medium text-uppercase" style="font-size: 0.85rem;">Proses</th>
                                    <th scope="col" class="py-3 text-end px-4 fw-medium text-uppercase" style="font-size: 0.85rem;">Aksi</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                @forelse ($transaksiTerbaru as $trx)
                                    <tr>
                                        <td class="py-3 px-4 fw-semibold text-light">
                                            {{ $trx->nama_pelanggan }}
                                        </td>
                                        
                                        <td class="py-3 text-muted">
                                            @if($trx->file_dokumen)
                                                <i class="bi bi-file-earmark-pdf text-danger me-2"></i>
                                                <span class="d-inline-block text-truncate" style="max-width: 150px;" title="{{ $trx->file_dokumen }}">
                                                    {{ preg_replace('/^[0-9]+_/', '', $trx->file_dokumen) }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary text-light">Dokumen Fisik</span>
                                            @endif
                                        </td>
                                        
                                        <td class="py-3 text-light">{{ $trx->jumlah_halaman }} Lembar</td>
                                        
                                        <td class="py-3 text-warning fw-medium">
                                            {{ \Carbon\Carbon::parse($trx->waktu_deadline)->format('H:i') }} WIB
                                        </td>
                                        
                                        <td class="py-3">
                                            <span class="badge bg-success text-white px-2 py-1 rounded-pill">
                                                {{ $trx->metode }}
                                            </span>
                                        </td>
                                        
                                        <td class="py-3">
                                            @if($trx->status_antrean == 'Selesai')
                                                <span class="badge bg-success px-2 py-1 rounded-pill">{{ $trx->status_antrean }}</span>
                                            @else
                                                <span class="badge bg-primary px-2 py-1 rounded-pill">{{ $trx->status_antrean }}</span>
                                            @endif
                                        </td>
                                        
                                        <td class="py-3 text-end px-4">
                                            <button class="btn btn-sm btn-outline-info me-1" title="Lihat Detail">
                                                &#128065;
                                            </button>
                                            @if($trx->status_antrean != 'Selesai')
                                                <button class="btn btn-sm btn-outline-success" title="Tandai Selesai">
                                                    &#10004;
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            Belum ada transaksi terbaru hari ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>