<!-- BELUM SINKRON KE DATABASE BAGIAN UPDATE FULL DATANYA -->
<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Fotocopy - Transaksi</title>
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
        .form-control, .form-select {
            background-color: #1e2125;
            border-color: #373b3e;
            padding: 0.6rem 1rem;
        }
        .form-control:focus, .form-select:focus {
            background-color: #1e2125;
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }
        .form-label {
            font-size: 0.85rem;
            font-weight: 500;
            color: #adb5bd;
        }
    </style>
</head>
<body>
    
    <nav class="navbar navbar-expand-lg bg-dark border-bottom border-secondary py-3">
        <div class="container-fluid px-4">
            <a class="navbar-brand fs-4 fw-bold me-5" href="/">
                POS <span class="text-primary">Fotocopy</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active bg-primary text-white fw-medium" href="/transaksi">Transaksi</a>
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

    <div class="container-fluid px-4 py-5">
        
        <div class="card bg-dark border-0 shadow-sm mb-5">
            <div class="card-body p-4 p-lg-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold m-0">Input Antrean Baru</h4>
                        <p class="text-muted mt-1 mb-0" style="font-size: 0.9rem;">Masukkan detail pesanan pelanggan ke dalam sistem.</p>
                    </div>
                    <i class="bi bi-cart-plus text-primary" style="font-size: 2rem;"></i>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" id="myAlert" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="/transaksi" method="POST" enctype="multipart/form-data">
                    @csrf 
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small text-uppercase fw-bold">Nama Pelanggan</label>
                            <input type="text" name="nama_pelanggan" class="form-control bg-dark text-light border-secondary focus-ring focus-ring-primary" placeholder="Contoh: Budi Mahasiswa" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small text-uppercase fw-bold">No HP / WhatsApp</label>
                            <input type="text" name="no_hp" class="form-control bg-dark text-light border-secondary focus-ring focus-ring-primary" placeholder="Contoh: 081234567890" >
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label text-muted small text-uppercase fw-bold">Alamat</label>
                            <textarea name="alamat" class="form-control bg-dark text-light border-secondary focus-ring focus-ring-primary" rows="2" placeholder="Contoh: Jl. Slamet Riyadi, Solo" ></textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small text-uppercase fw-bold">File Dokumen PDF</label>
                            <input type="file" name="file_dokumen" class="form-control bg-dark text-light border-secondary focus-ring focus-ring-primary" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small text-uppercase fw-bold">Jenis Layanan</label>
                            <select name="layanan_id" class="form-select bg-dark text-light border-secondary focus-ring focus-ring-primary" required>
                                <option value="" selected disabled>Pilih Layanan...</option>
                                <option value="1">Fotocopy Hitam Putih</option>
                                <option value="2">Print Warna</option>
                                <option value="3">Print Hitam Putih</option>
                                <option value="4">Scan Dokumen</option>
                                <option value="5">Pengetikan Dokumen</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            
                            <label for="tenggat_waktu" class="form-label text-muted small text-uppercase fw-bold">Tenggat Waktu</label>
                            <input type="time" class="form-control bg-dark text-light border-secondary focus-ring focus-ring-primary"" name="waktu_deadline" required>

                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small text-uppercase fw-bold">Metode Pembayaran</label>
                            <select name="metode" class="form-select bg-dark text-light border-secondary focus-ring focus-ring-primary" required>
                                <option value="Cash">Cash</option>
                                <option value="QRIS">QRIS</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-2">
                        <button type="reset" class="btn btn-outline-secondary px-4 me-2">Reset</button>
                        <button type="submit" class="btn btn-primary px-5 fw-medium">
                            <i class="bi bi-send me-2"></i> Masukkan ke Antrean
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Daftar Antrean -->
        <div>
            <div class="d-flex justify-content-between align-items-end mb-3">
                <div>
                    <h4 class="fw-bold m-0">Daftar Antrean Aktif</h4>
                    <p class="text-muted mt-1 mb-0" style="font-size: 0.9rem;">Pesanan yang sedang diproses hari ini.</p>
                </div>
            </div>
            
            <div class="card bg-dark border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover table-borderless align-middle mb-0">
                            <thead class="border-bottom border-secondary text-muted">
                                <tr>
                                    <th scope="col" class="py-3 px-4 fw-medium text-uppercase" style="font-size: 0.85rem;">Nama Pelanggan</th>
                                    <th scope="col" class="py-3 fw-medium text-uppercase" style="font-size: 0.85rem;">File</th>
                                    <th scope="col" class="py-3 fw-medium text-uppercase" style="font-size: 0.85rem;">Halaman</th>
                                    <th scope="col" class="py-3 fw-medium text-uppercase" style="font-size: 0.85rem;">Layanan</th>
                                    <th scope="col" class="py-3 fw-medium text-uppercase" style="font-size: 0.85rem;">Tenggat</th>
                                    <th scope="col" class="py-3 fw-medium text-uppercase" style="font-size: 0.85rem;">Total</th>
                                    <th scope="col" class="py-3 fw-medium text-uppercase" style="font-size: 0.85rem;">Metode</th>
                                    <th scope="col" class="py-3 fw-medium text-uppercase" style="font-size: 0.85rem;">Status</th>
                                    <th scope="col" class="py-3 text-end px-4 fw-medium text-uppercase" style="font-size: 0.85rem;">Aksi</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                @forelse ($antreanAktif as $antrean)
                                    <tr>
                                        <td class="py-3 px-4 fw-semibold text-light">
                                            {{ $antrean->nama_pelanggan }}
                                        </td>
                                        
                                        <td class="py-3 text-muted">
                                            @if($antrean->file_dokumen)
                                                <i class="bi bi-file-earmark-pdf text-danger me-2"></i>
                                                <span class="d-inline-block text-truncate" style="max-width: 150px;" title="{{ $antrean->file_dokumen }}">
                                                    {{ preg_replace('/^[0-9]+_/', '', $antrean->file_dokumen) }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary text-light">Dokumen Fisik</span>
                                            @endif
                                        </td>

                                        <td class="py-3">{{ $antrean->jumlah_halaman ?? '-' }} Lembar</td>

                                        <td class="py-3">{{ $antrean->nama_layanan }}</td>

                                        <td class="py-3 text-warning fw-medium">
                                            {{ \Carbon\Carbon::parse($antrean->waktu_deadline)->format('H:i') }} WIB
                                        </td>

                                        <td class="py-3 fw-semibold text-success">
                                            Rp {{ number_format($antrean->total_harga, 0, ',', '.') }}
                                        </td>

                                        <td class="py-3">
                                            @if($antrean->metode == 'Cash')
                                                <span class="badge bg-success">{{ $antrean->metode }}</span>
                                            @elseif($antrean->metode == 'QRIS')
                                                <span class="badge bg-info text-dark">{{ $antrean->metode }}</span>
                                            @else
                                                <span class="badge bg-primary">{{ $antrean->metode }}</span>
                                            @endif
                                        </td>
                                        
                                        <td class="py-3">
                                            <span class="badge bg-primary">{{ $antrean->status_antrean }}</span>
                                        </td>

                                        <td class="py-3 px-4">
                                                <div class="d-flex gap-2 justify-content-end">
                                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $antrean->id_transaksi }}" title="Edit Data">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>

                                                <form action="{{ route('transaksi.update', $antrean->id_transaksi) }}" method="POST" onsubmit="return confirm('Tandai antrean ini selesai?');">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status_antrean" value="Selesai">
                                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Tandai Selesai">
                                                        <i class="bi bi-check-lg"></i>
                                                    </button>
                                                </form>

                                                <form action="{{ route('transaksi.delete', $antrean->id_transaksi) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus antrean ini dari sistem?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus Data">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                                </form>
                                            </div>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5 text-muted">
                                            <i class="bi bi-emoji-smile fs-4 d-block mb-2"></i>
                                            Antrean kosong. Belum ada pesanan yang harus diproses.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @foreach($antreanAktif as $antrean)
            <!-- Modal Edit Data -->
            <div class="modal fade" id="modalEdit{{ $antrean->id_transaksi }}" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content bg-dark text-white border-secondary">
                        <div class="modal-header border-secondary">
                            <h5 class="modal-title" id="modalEditLabel">Edit Data: {{ $antrean->pelanggan->nama }}</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        
                        <form action="{{ route('transaksi.update', $antrean->id_transaksi) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <!-- Nama, No HP, Alamat -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label>Nama Pelanggan</label>
                                        <input type="text" name="nama_pelanggan" class="form-control bg-secondary text-white border-0" value="{{ $antrean->pelanggan->nama }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label>No HP</label>
                                        <input type="text" name="no_hp" class="form-control bg-secondary text-white border-0" value="{{ $antrean->pelanggan->no_hp }}">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label>Alamat</label>
                                    <textarea name="alamat" class="form-control bg-secondary text-white border-0">{{ $antrean->pelanggan->alamat }}</textarea>
                                </div>

                                <!-- File, Jml Halaman, Metode -->
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label>Ganti File PDF</label>
                                        <input type="file" name="file_dokumen" class="form-control bg-secondary text-white border-0">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Jml Halaman</label>
                                        <input type="number" name="jumlah_halaman" class="form-control bg-secondary text-white border-0" value="{{ $antrean->detail_layanan->jumlah_halaman }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label>Metode Pembayaran</label>
                                        <select name="metode" class="form-select bg-secondary text-white border-0">
                                            <option value="Cash" {{ $antrean->pembayaran->metode == 'Cash' ? 'selected' : '' }}>Cash</option>
                                            <option value="QRIS" {{ $antrean->pembayaran->metode == 'QRIS' ? 'selected' : '' }}>QRIS</option>
                                        </select>
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
        @endforeach
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        setTimeout(function() {
            var alertElement = document.getElementById('myAlert');
            if (alertElement) {
                var alert = new bootstrap.Alert(alertElement);
                alert.close();
            }
        }, 3000); 
    </script>
</body>
</html>