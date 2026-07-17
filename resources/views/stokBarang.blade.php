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
            background-color: #121212; 
        }
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
        .widget-card { 
            transition: transform 0.3s ease, box-shadow 0.3s ease; 
        }
        .widget-card:hover { 
            transform: translateY(-5px); 
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3); 
        }
    </style>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let alerts = document.querySelectorAll('.alert');
            
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    let bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 3000);
            });
        });
    </script>
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
                        <a class="nav-link text-white fw-medium" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ url('/transaksi') }}">Transaksi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Jenis Layanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ url('/riwayat') }}">Riwayat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active bg-primary text-white" href="{{ url('/stok-barang') }}">Stok Barang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Laporan</a>
                    </li>
                </ul>
                
                <<div class="d-flex align-items-center text-end mt-3 mt-lg-0">
                    <div>
                        <strong class="d-block lh-1 text-white">{{ auth()->user()->name ?? 'Guest' }}</strong>
                        <small class="text-muted" style="font-size: 0.8rem;">
                            {{ ucfirst(auth()->user()->role ?? 'Kasir') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <div class="container py-5">
        <!-- Bagian Header & Notifikasi -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-white fw-bold">Daftar Stok Barang</h3>
            
            <!-- Tombol Pemicu Modal Tambah/Restok -->
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahStok">
                <i class="bi bi-plus-lg me-2"></i> Tambah / Restok Barang
            </button>
        </div>

        <!-- Alert Sukses / Error -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show bg-success text-white border-0 shadow-sm" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show bg-danger text-white border-0 shadow-sm" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Tabel Data Stok -->
        <div class="card bg-dark border-secondary shadow-lg">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0">
                        <thead class="border-secondary">
                            <tr class="text-muted small text-uppercase">
                                <th class="py-3 px-4">No</th>
                                <th>Nama Barang</th>
                                <th>Kategori</th>
                                <th>Jumlah Stok</th>
                                <th>Satuan</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="border-secondary">
                            <!-- Looping data stok -->
                            @forelse($barang as $item)
                            <tr>
                                <td class="px-4">{{ $loop->iteration }}</td>
                                <td class="fw-bold">{{ $item->nama_barang }}</td>
                                <td>{{ $item->kategori }}</td>
                                <td>
                                    <!-- Warna merah jika stok menipis (< 5), hijau jika aman -->
                                    <span class="badge {{ $item->jumlah_stok < 5 ? 'bg-danger' : 'bg-success' }} px-3 py-2 rounded-pill">
                                        {{ $item->jumlah_stok }}
                                    </span>
                                </td>
                                <td>{{ $item->satuan }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <!-- Tombol Edit -->
                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id }}" title="Edit Data">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <!-- Tombol Delete -->
                                        <!-- <form action="{{ route('stok.delete', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus barang ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Data">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form> -->
                                        @if(auth()->check() && auth()->user()->role == 'admin')
                                        <form action="{{ route('stok.destroy', $item->id) }}" method="POST" ...>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal Edit Data (Satu per baris data) -->
                            <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content bg-dark text-white border-secondary">
                                        <div class="modal-header border-secondary">
                                            <h5 class="modal-title fw-bold">Edit Barang: {{ $item->nama_barang }}</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('stok.update', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label text-muted small text-uppercase fw-bold">Nama Barang</label>
                                                    <input type="text" name="nama_barang" class="form-control bg-dark text-light border-secondary" value="{{ $item->nama_barang }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label text-muted small text-uppercase fw-bold">Kategori</label>
                                                    <input type="text" name="kategori" class="form-control bg-dark text-light border-secondary" value="{{ $item->kategori }}" required>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-6">
                                                        <label class="form-label text-muted small text-uppercase fw-bold">Jumlah Stok</label>
                                                        <input type="number" name="jumlah_stok" class="form-control bg-dark text-light border-secondary" value="{{ $item->jumlah_stok }}" required min="0">
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label text-muted small text-uppercase fw-bold">Satuan</label>
                                                        <input type="text" name="satuan" class="form-control bg-dark text-light border-secondary" value="{{ $item->satuan }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-secondary">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            @empty
                            <!-- Jika tabel masih kosong -->
                            <tr>
                                <td colspan="6" class="text-center text-muted py-5">
                                    <i class="bi bi-box-seam fs-1 d-block mb-2"></i>
                                    Belum ada data stok barang.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah / Restok Data (Di luar loop tabel) -->
    <div class="modal fade" id="modalTambahStok" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-white border-secondary">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title fw-bold">Tambah / Restok Barang</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('stok.create') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <!-- Penjelasan Fitur Auto-Restok -->
                        <div class="alert alert-info bg-primary border-0 text-white small shadow-sm">
                            <i class="bi bi-info-circle me-1"></i> Jika <strong>Nama Barang</strong> sama dengan yang sudah ada, sistem otomatis akan melakukan Restok (menambah jumlahnya).
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label text-muted small text-uppercase fw-bold">Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control bg-dark text-light border-secondary" required placeholder="Contoh: Kertas A4">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted small text-uppercase fw-bold">Kategori</label>
                            <input type="text" name="kategori" class="form-control bg-dark text-light border-secondary" required placeholder="Contoh: Kertas">
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="form-label text-muted small text-uppercase fw-bold">Jumlah Masuk</label>
                                <input type="number" name="jumlah_stok" class="form-control bg-dark text-light border-secondary" required min="1" placeholder="0">
                            </div>
                            <div class="col-6">
                                <label class="form-label text-muted small text-uppercase fw-bold">Satuan</label>
                                <input type="text" name="satuan" class="form-control bg-dark text-light border-secondary" required placeholder="Contoh: Rim / Pcs">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-secondary">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Barang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>