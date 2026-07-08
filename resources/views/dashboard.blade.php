<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Fotocopy - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        body {
            background-color: #121212;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        /* Navbar */
        .navbar-custom {
            background-color: #1a1a1a;
            border-bottom: 1px solid #2d2d2d;
        }
        .nav-link {
            color: #a0a0a0;
            font-weight: 500;
            margin: 0 5px;
            transition: all 0.3s ease;
        }
        .nav-link:hover, .nav-link.active {
            color: #ffffff;
            border-bottom: 2px solid #0d6efd;
        }

        /* Menu Pintasan (Shortcut) */
        .shortcut-card {
            background: linear-gradient(145deg, #222222, #1a1a1a);
            border: 1px solid #333;
            border-radius: 12px;
            color: #a0a0a0;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 15px 10px;
        }
        .shortcut-card:hover {
            transform: translateY(-5px);
            background: linear-gradient(145deg, #2a2a2a, #222222);
            color: #ffffff;
            border-color: #0d6efd;
            box-shadow: 0 8px 15px rgba(13, 110, 253, 0.15);
        }
        .shortcut-icon {
            font-size: 1.5rem;
            margin-bottom: 8px;
        }
        .shortcut-text {
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        /* Jenis Layanan */
        .layanan-box {
            background-color: #1a1a1a;
            border: 1px solid #333;
            border-radius: 12px;
            transition: transform 0.2s ease, border-color 0.2s ease;
            cursor: pointer;
        }
        .layanan-box:hover {
            transform: translateY(-3px);
            border-color: #6c757d;
        }

        /* Tabel Antrean */
        .table-dark {
            --bs-table-bg: transparent;
        }
        .table-container {
            background-color: #1a1a1a;
            border: 1px solid #333;
            border-radius: 8px;
            overflow: hidden;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-custom py-3 sticky-top mb-4">
    <div class="container-fluid px-4">
        <a class="navbar-brand text-white fw-bold d-flex align-items-center" href="#">
            <i class="bi bi-printer-fill text-primary me-2 fs-4"></i> POS Print
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Transaksi</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Jenis Layanan</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Riwayat</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Stok</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Laporan</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid px-4 pb-5">

    <h5 class="text-white mb-3 fw-semibold">Menu</h5>
    <div class="row g-3 mb-5">
        <div class="col-4 col-md-2">
            <a href="#" class="shortcut-card">
                <i class="bi bi-house-door shortcut-icon text-light"></i>
                <span class="shortcut-text">Home</span>
            </a>
        </div>
        <div class="col-4 col-md-2">
            <a href="#" class="shortcut-card">
                <i class="bi bi-cart-plus shortcut-icon text-success"></i>
                <span class="shortcut-text">Transaksi</span>
            </a>
        </div>
        <div class="col-4 col-md-2">
            <a href="#" class="shortcut-card">
                <i class="bi bi-grid shortcut-icon text-info"></i>
                <span class="shortcut-text">Layanan</span>
            </a>
        </div>
        <div class="col-4 col-md-2">
            <a href="#" class="shortcut-card">
                <i class="bi bi-clock-history shortcut-icon text-warning"></i>
                <span class="shortcut-text">Riwayat</span>
            </a>
        </div>
        <div class="col-4 col-md-2">
            <a href="#" class="shortcut-card">
                <i class="bi bi-box-seam shortcut-icon text-danger"></i>
                <span class="shortcut-text">Stok</span>
            </a>
        </div>
        <div class="col-4 col-md-2">
            <a href="#" class="shortcut-card">
                <i class="bi bi-graph-up shortcut-icon text-primary"></i>
                <span class="shortcut-text">Laporan</span>
            </a>
        </div>
    </div>
    
    <h5 class="text-white mb-3 fw-semibold">Jenis Layanan</h5>
    <div class="row g-3 mb-5">
        <div class="col-6 col-md-3 col-lg-2">
            <div class="layanan-box text-center p-4 h-100">
                <i class="bi bi-file-earmark-text fs-2 text-primary mb-2 d-block"></i>
                <span class="text-light fw-semibold">Fotocopy</span>
            </div>
        </div>
        <div class="col-6 col-md-3 col-lg-2">
            <div class="layanan-box text-center p-4 h-100">
                <i class="bi bi-palette fs-2 text-danger mb-2 d-block"></i>
                <span class="text-light fw-semibold">Print</span>
            </div>
        </div>
        <div class="col-6 col-md-3 col-lg-2">
            <div class="layanan-box text-center p-4 h-100">
                <i class="bi bi-upc-scan fs-2 text-success mb-2 d-block"></i>
                <span class="text-light fw-semibold">Scan Dokumen</span>
            </div>
        </div>
        <div class="col-6 col-md-3 col-lg-2">
            <div class="layanan-box text-center p-4 h-100">
                <i class="bi bi-book fs-2 text-warning mb-2 d-block"></i>
                <span class="text-light fw-semibold">Jasa Ketik</span>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-white m-0 fw-semibold">Antrean Berjalan</h5>
        <button class="btn btn-sm btn-outline-light" onclick="muatAntrean()">
            <i class="bi bi-arrow-clockwise"></i> Refresh
        </button>
    </div>
    
    <div class="table-container">
        <table class="table table-dark table-hover align-middle mb-0">
            <thead>
                <tr class="border-bottom border-secondary">
                    <th class="ps-3 py-3">Nama</th>
                    <th class="py-3">File</th>
                    <th class="py-3">Layanan</th>
                    <th class="py-3">Halaman</th>
                    <th class="py-3">Tenggat</th>
                    <th class="py-3">Status</th>
                    <th class="text-center py-3 pe-3">Aksi</th>
                </tr>
            </thead>
            <tbody id="wadah-tabel-antrean">
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">
                        <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                        Memuat data...
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</div>

<script>
    function muatAntrean() {
        const tbody = document.getElementById('wadah-tabel-antrean');
        
        fetch('http://127.0.0.1:8000/api/antrean')
            .then(response => response.json())
            .then(hasil => {
                if (hasil.status === 'success') {
                    let barisHTML = '';
                    
                    if(hasil.data.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="7" class="text-center py-4 text-muted">Tidak ada antrean pending.</td></tr>';
                        return;
                    }

                    hasil.data.forEach(item => {
                        barisHTML += `
                            <tr class="border-bottom border-secondary">
                                <td class="ps-3 fw-semibold text-light">${item.transaksi.pelanggan.nama}</td>
                                <td><i class="bi bi-file-pdf text-danger me-2"></i>${item.file_dokumen}</td>
                                <td>${item.layanan.nama_layanan}</td>
                                <td>${item.jumlah_halaman} Lembar</td>
                                <td class="text-warning fw-bold">
                                    <i class="bi bi-clock-history me-1"></i> 
                                    ${new Date(item.waktu_deadline).toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'})}
                                </td>
                                <td><span class="badge bg-danger rounded-pill px-3 py-1">Pending</span></td>
                                <td class="text-center pe-3">
                                    <button class="btn btn-sm btn-outline-info me-1" title="Edit"><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-sm btn-outline-success" title="Selesai"><i class="bi bi-check2"></i></button>
                                </td>
                            </tr>
                        `;
                    });
                    
                    tbody.innerHTML = barisHTML;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                tbody.innerHTML = '<tr><td colspan="7" class="text-center py-4 text-danger">Gagal terhubung ke server.</td></tr>';
            });
    }

    document.addEventListener("DOMContentLoaded", muatAntrean);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.css"></script>
</body>
</html>