<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Fotocopy - Dashboard Antrean</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        body {
            background-color: #121212;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .sidebar {
            height: 100vh;
            background-color: #1e1e1e;
            border-right: 1px solid #333;
        }
        .nav-link {
            color: #a0a0a0;
            transition: all 0.3s ease;
        }
        .nav-link:hover, .nav-link.active {
            color: #ffffff;
            background-color: #2d2d2d;
            border-radius: 8px;
        }
        .card-antrean {
            background-color: #1e1e1e;
            border: 1px solid #333;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .card-antrean:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.4);
            border-color: #5c636a;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-3 col-lg-2 d-md-block sidebar py-4">
            <div class="position-sticky px-3">
                <h4 class="text-white mb-5">
                    <i class="bi bi-printer me-2"></i> POS Print
                </h4>
                <ul class="nav flex-column gap-2">
                    <li class="nav-item">
                        <a class="nav-link active" href="#"><i class="bi bi-display me-2"></i> Dashboard Antrean</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-cart-plus me-2"></i> Kasir Baru</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-clock-history me-2"></i> Riwayat Transaksi</a>
                    </li>
                </ul>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom border-secondary">
                <h1 class="h2 text-white">Antrean Berjalan</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-sm btn-outline-light">
                        <i class="bi bi-arrow-clockwise"></i> Refresh Data
                    </button>
                </div>
            </div>

            <div id="wadah-antrean" class="row g-4">
                <div class="col-12 text-center text-muted mt-5" id="loading-pesan">
                    <div class="spinner-border text-light mb-3" role="status"></div>
                    <p>Menghubungkan ke server antrean...</p>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
    // Fungsi untuk data dari Laravel API
    function muatAntrean() {
        const wadah = document.getElementById('wadah-antrean');
        
        fetch('http://127.0.0.1:8000/api/antrean')
            .then(response => response.json())
            .then(hasil => {
                if (hasil.status === 'success') {
                    let kartuHTML = '';
                    
                    if(hasil.data.length === 0) {
                        wadah.innerHTML = '<div class="col-12 text-center text-muted">Tidak ada antrean saat ini.</div>';
                        return;
                    }

                    // Melakukan perulangan data JSON menjadi elemen HTML
                    hasil.data.forEach(item => {
                        kartuHTML += `
                            <div class="col-md-6 col-xl-4">
                                <div class="card card-antrean h-100 p-3">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <h5 class="card-title text-white mb-0">${item.layanan.nama_layanan}</h5>
                                        <span class="badge bg-danger rounded-pill px-3 py-2">Prioritas Tinggi</span>
                                    </div>
                                    <h6 class="card-subtitle mb-3 text-muted">
                                        <i class="bi bi-person"></i> ${item.transaksi.pelanggan.nama}
                                    </h6>
                                    <div class="d-flex justify-content-between text-light mb-2">
                                        <small><i class="bi bi-file-earmark-text"></i> ${item.jumlah_halaman} Halaman</small>
                                        <small class="text-warning"><i class="bi bi-hourglass-split"></i> Deadline: ${new Date(item.waktu_deadline).toLocaleTimeString('id-ID', {hour: '2-digit', minute:'2-digit'})}</small>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    
                    wadah.innerHTML = kartuHTML;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                wadah.innerHTML = '<div class="col-12 text-center text-danger">Gagal terhubung ke database. Pastikan server Laravel menyala.</div>';
            });
    }

    document.addEventListener("DOMContentLoaded", muatAntrean);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.css"></script>
</body>
</html>