@extends('layout.app')

@section('title', 'Transaksi')

@section('content')
<div class="row g-4">
    <!-- BAGIAN NOTIFIKASI -->
    <div class="col-12 mb-0">
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
    </div>

    <!-- FORM INPUT TRANSAKSI -->
    @if(Auth::user()->role === 'kasir')
    <div class="col-12">
        <div class="card bg-dark border-secondary shadow-sm rounded-4">
            <div class="card-body p-4">
                <!-- Header Section -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="text-white fw-bold mb-0">Input Antrean Baru</h4>
                        <p class="text-secondary mb-0">Masukkan detail pesanan pelanggan ke dalam sistem.</p>
                    </div>
                    <i class="bi bi-cart-plus text-primary fs-2"></i>
                </div>

                <form action="{{ url('/transaksi/create') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <!-- Row 1: Nama & No HP -->
                        <div class="col-md-6">
                            <label class="text-secondary fw-semibold small mb-1 text-uppercase">Nama Pelanggan</label>
                            <input type="text" name="nama_pelanggan" class="form-control bg-dark text-white border-secondary" placeholder="Contoh: Budi Mahasiswa" required>
                        </div>
                        <div class="col-md-6">
                            <label class="text-secondary fw-semibold small mb-1 text-uppercase">No HP / Whatsapp</label>
                            <input type="text" name="no_hp" class="form-control bg-dark text-white border-secondary" placeholder="Contoh: 081234567890">
                        </div>

                        <!-- Row 2: Alamat -->
                        <div class="col-12">
                            <label class="text-secondary fw-semibold small mb-1 text-uppercase">Alamat</label>
                            <input type="text" name="alamat" class="form-control bg-dark text-white border-secondary" placeholder="Contoh: Jl. Slamet Riyadi, Solo">
                        </div>

                        <!-- Row 3: File & Layanan -->
                        <div class="col-md-6">
                            <label class="text-secondary fw-semibold small mb-1 text-uppercase">File Dokumen PDF</label>
                            <input type="file" name="file_dokumen" class="form-control bg-dark text-white border-secondary" accept=".pdf" required>
                        </div>
                        <div class="col-md-6">
                            <label class="text-secondary fw-semibold small mb-1 text-uppercase">Jenis Layanan</label>
                            <select name="layanan_id" class="form-select bg-dark text-white border-secondary" required>
                                <option value="">Pilih Layanan...</option>
                                @foreach($layanan as $l)
                                <option value="{{ $l->id }}">{{ $l->nama_layanan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tenggat & Metode -->
                        <div class="col-md-6">
                            <label class="text-secondary fw-semibold small mb-1 text-uppercase">Tenggat Waktu</label>
                            <input type="time" name="waktu_deadline" class="form-control bg-dark text-white border-secondary" required>
                        </div>
                        <div class="col-md-6">
                            <label class="text-secondary fw-semibold small mb-1 text-uppercase">Metode Pembayaran</label>
                            <select name="metode" class="form-select bg-dark text-white border-secondary" required>
                                <option value="Cash">Cash</option>
                                <option value="QRIS">QRIS</option>
                            </select>
                        </div>
                    </div>

                    <!-- Footer Buttons -->
                    <div class="d-flex justify-content-end mt-4">
                        <button type="reset" class="btn btn-outline-secondary px-4 me-2">Reset</button>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">
                            <i class="bi bi-send me-1"></i> Masukkan ke Antrean
                        </button>
                    </div>
                </form>
            </div>
            @endif
        </div>
    </div>

    <!-- TABEL DAFTAR ANTREAN -->
    <div class="col-12">
        <div class="card bg-dark border-secondary shadow-sm rounded-4">
            <div class="card-header border-secondary py-3 px-4">
                <h5 class="mb-0 text-white fw-semibold"><i class="bi bi-list-task text-info me-2"></i>Daftar Antrean</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-dark table-hover mb-0 align-middle">
                        <thead class="table-active">
                            <tr>
                                <th class="px-4">Nama Pelanggan</th>
                                <th>File</th>
                                <th class="text-center">Halaman</th>
                                <th>Layanan</th>
                                <th>Tenggat</th>
                                <th>Total</th>
                                <th>Metode</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Kita standarkan variabelnya menjadi $trx --}}
                            @forelse($transaksi as $trx)
                            <tr>
                                <td class="px-4 fw-bold">{{ $trx->nama_pelanggan }}</td>
                                <td><small class="text-secondary">{{ $trx->file_dokumen }}</small></td>
                                <td class="text-center">{{ $trx->jumlah_halaman }}</td>
                                <td>{{ $trx->nama_layanan }}</td>
                                <td>{{ $trx->waktu_deadline }} m</td>
                                <td class="text-primary fw-bold">Rp {{ number_format($trx->total_bayar, 0, ',', '.') }}</td>
                                <td>{{ $trx->metode }}</td>
                                <td class="text-center">
                                    <span class="badge bg-opacity-10 border {{ $trx->status_antrean == 'Selesai' ? 'bg-success text-success border-success' : 'bg-warning text-warning border-warning' }}">
                                        {{ $trx->status_antrean }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <!-- Tombol Edit Modal -->
                                        <button type="button" class="btn btn-sm btn-outline-primary rounded-3" data-bs-toggle="modal" data-bs-target="#editModal{{ $trx->id_transaksi }}" title="Edit Data">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <!-- Tombol Status Selesai Cepat -->
                                        <form action="{{ url('/transaksi/'.$trx->id_transaksi) }}" method="POST" class="m-0">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status_antrean" value="Selesai">
                                            <button type="submit" class="btn btn-sm btn-outline-success rounded-3" title="Tandai Selesai">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </form>

                                        <!-- Update HANYA ADMIN -->
                                        @if(Auth::user()->role === 'admin')
                                        <!-- <a href="#" class="btn btn-sm btn-outline-warning"><i class="bi bi-pencil"></i></a> -->
                                        <form action="{{ url('/transaksi/'.$trx->id_transaksi) }}" method="POST" class="m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data antrean ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-3" title="Hapus Transaksi">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-secondary">Belum ada antrean.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ================= KUMPULAN MODAL EDIT (Di-loop di luar tabel) ================= -->
@foreach($transaksi as $trx)
<div class="modal fade" id="editModal{{ $trx->id_transaksi }}" tabindex="-1" aria-labelledby="editModalLabel{{ $trx->id_transaksi}}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-dark border-secondary shadow-lg rounded-4">

            <div class="modal-header border-secondary">
                <h5 class="modal-title text-white fw-bold" id="editModalLabel{{ $trx->id_transaksi}}">
                    <i class="bi bi-pencil-square text-primary me-2"></i>Edit Data Antrean
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Form mengarah ke route update -->
            <form action="{{ url('/transaksi/'.$trx->id_transaksi) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-body text-start px-4 py-3">
                    <div class="row g-4">
                        <!-- Status Antrean -->
                        <div class="col-12">
                            <label class="text-secondary small mb-2 text-uppercase fw-semibold">Status Saat Ini</label>
                            <select name="status_antrean" class="form-select bg-dark text-white border-secondary shadow-none">
                                <option value="Menunggu" {{ $trx->status_antrean == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="Cetak" {{ $trx->status_antrean == 'Cetak' ? 'selected' : '' }}>Cetak</option>
                                <option value="Selesai" {{ $trx->status_antrean == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>

                        <!-- Edit Nama -->
                        <div class="col-md-6">
                            <label class="text-secondary small mb-2 text-uppercase fw-semibold">Nama Pelanggan</label>
                            <input type="text" name="nama_pelanggan" class="form-control bg-dark text-white border-secondary shadow-none" value="{{ $trx->nama_pelanggan }}">
                        </div>

                        <!-- Edit Layanan -->
                        <div class="col-md-6">
                            <label class="text-secondary small mb-2 text-uppercase fw-semibold">Ganti Layanan</label>
                            <select name="layanan_id" class="form-select bg-dark text-white border-secondary shadow-none">
                                @foreach($layanan as $l)
                                <option value="{{ $l->id }}" {{ $trx->layanan_id == $l->id ? 'selected' : '' }}>
                                    {{ $l->nama_layanan }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Update File PDF -->
                        <div class="col-12">
                            <label class="text-secondary small mb-2 text-uppercase fw-semibold">Ganti File Dokumen (Opsional)</label>
                            <input type="file" name="file_dokumen" class="form-control bg-dark text-white border-secondary shadow-none" accept=".pdf">
                            <div class="mt-2 text-secondary small">
                                <i class="bi bi-file-earmark-pdf text-danger me-1"></i> File tersimpan:
                                <span class="text-light">{{ $trx->file_dokumen ?? 'Tidak ada file' }}</span>
                            </div>
                        </div>

                        <!-- Edit Tenggat -->
                        <div class="col-md-6">
                            <label class="text-secondary small mb-2 text-uppercase fw-semibold">Tenggat Waktu</label>
                            <input type="time" name="waktu_deadline" class="form-control bg-dark text-white border-secondary shadow-none" value="{{ $trx->waktu_deadline }}">
                        </div>

                        <!-- Edit Metode Pembayaran -->
                        <div class="col-md-6">
                            <label class="text-secondary small mb-2 text-uppercase fw-semibold">Metode Pembayaran</label>
                            <select name="metode" class="form-select bg-dark text-white border-secondary shadow-none">
                                <option value="Cash" {{ $trx->metode == 'Cash' ? 'selected' : '' }}>Cash</option>
                                <option value="QRIS" {{ $trx->metode == 'QRIS' ? 'selected' : '' }}>QRIS</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-3 px-4">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
<!-- ================= END MODAL ================= -->

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
@endsection