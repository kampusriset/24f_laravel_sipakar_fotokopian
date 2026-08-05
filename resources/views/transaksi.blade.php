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

                    <form action="{{ url('/transaksi') }}" method="POST" enctype="multipart/form-data" id="formTransaksi">
                        @csrf
                        
                        <!-- Input Hidden (Bisa dibiarkan jika masih terhubung dengan JS lama) -->
                        <input type="hidden" name="nilai_prioritas" id="input_nilai_prioritas">
                        <input type="hidden" name="kategori_prioritas" id="input_kategori_prioritas">

                        <div class="row g-3">
                            <!-- Nama & No HP -->
                            <div class="col-md-6">
                                <label class="text-secondary fw-semibold small mb-1 text-uppercase">Nama Pelanggan</label>
                                <input type="text" name="nama_pelanggan" class="form-control bg-dark text-white border-secondary" placeholder="Contoh: Budi Mahasiswa" required>
                            </div>
                            <div class="col-md-6">
                                <label class="text-secondary fw-semibold small mb-1 text-uppercase">No HP / Whatsapp</label>
                                <input type="text" name="no_hp" class="form-control bg-dark text-white border-secondary" placeholder="Contoh: 081234567890">
                            </div>

                            <!-- Alamat -->
                            <div class="col-12">
                                <label class="text-secondary fw-semibold small mb-1 text-uppercase">Alamat</label>
                                <input type="text" name="alamat" class="form-control bg-dark text-white border-secondary" placeholder="Contoh: Jl. Slamet Riyadi, Solo">
                            </div>

                            <div class="col-md-6">
                                <label class="text-secondary fw-semibold small mb-1 text-uppercase">Sumber Dokumen</label>
                                <select id="sumber_dokumen" name="sumber_dokumen" class="form-select bg-dark text-white border-secondary" required>
                                    <option value="digital">Dokumen Digital (Upload File PDF)</option>
                                    <option value="fisik">Dokumen Fisik (Input Manual Halaman)</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="text-secondary fw-semibold small mb-1 text-uppercase">Jenis Layanan</label>
                                <select name="layanan_id" id="layanan_id" class="form-select bg-dark text-white border-secondary" required>
                                    <option value="">Pilih Layanan...</option>
                                    @foreach($layanan as $l)
                                    <option value="{{ $l->id }}">{{ $l->nama_layanan }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6" id="wrapper_file">
                                <label class="text-secondary fw-semibold small mb-1 text-uppercase">File Dokumen PDF</label>
                                <input type="file" name="file_dokumen" id="file_dokumen" class="form-control bg-dark text-white border-secondary" accept=".pdf">
                            </div>

                            <div class="col-md-6 d-none" id="wrapper_halaman">
                                <label class="text-secondary fw-semibold small mb-1 text-uppercase">Jumlah Halaman (Manual)</label>
                                <input type="number" name="jumlah_halaman_manual" id="jumlah_halaman_manual" class="form-control bg-dark text-white border-secondary" placeholder="Contoh: 50" min="1">
                            </div>

                            <!-- Tenggat (DIBUAT MENJADI INPUT MENIT) & Metode -->
                            <div class="col-md-6">
                                <label class="text-secondary fw-semibold small mb-1 text-uppercase">Tenggat Waktu (Menit)</label>
                                <input type="number" name="waktu_deadline" id="waktu_deadline" class="form-control bg-dark text-white border-secondary" placeholder="Contoh: 60" min="1" required>
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
                            <button type="submit" id="btnSubmitAntrean" class="btn btn-primary px-4 fw-bold">
                                <span id="btnText"><i class="bi bi-send me-1"></i> Masukkan ke Antrean</span>
                                <span id="btnLoading" class="d-none">
                                    <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Memproses...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- TABEL DAFTAR ANTREAN -->
    <div class="col-12">
        <div class="card bg-dark border-secondary shadow-sm rounded-4">
            <div class="card-header border-secondary py-3 px-4">
                <h5 class="mb-0 text-white fw-semibold"><i class="bi bi-list-task text-info me-2"></i>Daftar Antrean</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-dark table-hover mb-0 align-middle" id="tabelAntrean">
                        <thead class="table-active">
                            <tr>
                                <th class="px-4">Nama Pelanggan</th>
                                <th>File</th>
                                <th class="text-center">Halaman</th>
                                <th>Layanan</th>
                                <th>Selesai Pada</th>
                                <th>Total</th>
                                <th>Metode</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Prioritas</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tabel-antrean-body">
                            <!-- SORTING KHUSUS UNTUK MENARIK PENGETIKAN KE ATAS -->
                            @php
                                $sortedTransaksi = $transaksi->sortByDesc(function($trx) {
                                    return $trx->tingkat_prioritas === 'Pengetikan' ? 1 : 0;
                                });
                            @endphp

                            @forelse($sortedTransaksi as $trx)
                            <!-- HIGHLIGHT BARIS JIKA ITU PENGETIKAN -->
                            <tr class="{{ $trx->tingkat_prioritas == 'Pengetikan' ? 'border-warning' : '' }}" style="{{ $trx->tingkat_prioritas == 'Pengetikan' ? 'background-color: rgba(255, 193, 7, 0.05);' : '' }}">
                                <td class="px-4 fw-bold">{{ $trx->nama_pelanggan }}</td>
                                <td>
                                @if($trx->file_dokumen)
                                    <div class="text-info text-wrap text-break" style="max-width: 180px; font-size: 0.85rem;" title="{{ $trx->file_dokumen }}">
                                        <i class="bi bi-file-earmark-pdf me-1"></i>{{ preg_replace('/^[0-9]+_/', '', $trx->file_dokumen) }}
                                    </div>
                                @else
                                    <span class="badge bg-secondary"><i class="bi bi-file-earmark-text me-1"></i> Dokumen Fisik</span>
                                @endif
                                </td>
                                <td class="text-center">{{ $trx->jumlah_halaman }}</td>
                                <td>{{ $trx->nama_layanan }}</td>
                                <td>{{ \Carbon\Carbon::parse($trx->waktu_deadline)->format('H:i') }}</td>
                                <td class="text-primary fw-bold">Rp {{ number_format($trx->total_bayar, 0, ',', '.') }}</td>
                                <td>{{ $trx->metode }}</td>
                                <td class="text-center">
                                    <span class="badge bg-opacity-10 border {{ $trx->status_antrean == 'Selesai' ? 'bg-success text-success border-success' : 'bg-warning text-warning border-warning' }}">
                                        {{ $trx->status_antrean }}
                                    </span>
                                </td>
                                
                                <td class="text-center">
                                    <!-- BADGE PRIORITAS KHUSUS PENGETIKAN -->
                                    @if($trx->tingkat_prioritas == 'Pengetikan')
                                        <span class="badge bg-warning text-dark fw-bold shadow-sm"><i class="bi bi-keyboard me-1"></i>Ketik</span>
                                    @elseif($trx->tingkat_prioritas == 'Tinggi')
                                        <span class="badge bg-danger">Tinggi</span>
                                    @elseif($trx->tingkat_prioritas == 'Normal')
                                        <span class="badge bg-primary">Normal</span>
                                    @else
                                        <span class="badge bg-secondary">Rendah</span>
                                    @endif
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
                                <td colspan="10" class="text-center py-4 text-secondary" id="rowKosong">Belum ada antrean.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL EDIT  -->
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
                        <div class="col-12">
                            <label class="text-secondary small mb-2 text-uppercase fw-semibold">Status Saat Ini</label>
                            <select name="status_antrean" class="form-select bg-dark text-white border-secondary shadow-none">
                                <option value="Menunggu" {{ $trx->status_antrean == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="Cetak" {{ $trx->status_antrean == 'Cetak' ? 'selected' : '' }}>Cetak</option>
                                <option value="Selesai" {{ $trx->status_antrean == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="text-secondary small mb-2 text-uppercase fw-semibold">Nama Pelanggan</label>
                            <input type="text" name="nama_pelanggan" class="form-control bg-dark text-white border-secondary shadow-none" value="{{ $trx->nama_pelanggan }}">
                        </div>
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
                        <div class="col-12">
                            <label class="text-secondary small mb-2 text-uppercase fw-semibold">Ganti File Dokumen (Opsional)</label>
                            <input type="file" name="file_dokumen" class="form-control bg-dark text-white border-secondary shadow-none" accept=".pdf">
                            <div class="mt-2 text-secondary small">
                                <i class="bi bi-file-earmark-pdf text-danger me-1"></i> File tersimpan:
                                <span class="text-light">{{ $trx->file_dokumen ?? 'Tidak ada file' }}</span>
                            </div>
                        </div>
                        <!-- Catatan: Waktu pada form edit tetap menampilkan format Jam (H:i) -->
                        <div class="col-md-6">
                            <label class="text-secondary small mb-2 text-uppercase fw-semibold">Tenggat Waktu</label>
                            <input type="time" name="waktu_deadline" class="form-control bg-dark text-white border-secondary shadow-none" value="{{ \Carbon\Carbon::parse($trx->waktu_deadline)->format('H:i') }}">
                        </div>
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    // --- 1. LOGIKA TOGGLE SUMBER DOKUMEN ---
    const sumberDokumen = document.getElementById('sumber_dokumen');
    const wrapperFile = document.getElementById('wrapper_file');
    const wrapperHalaman = document.getElementById('wrapper_halaman');
    const inputFile = document.getElementById('file_dokumen');
    const inputHalaman = document.getElementById('jumlah_halaman_manual');

    function toggleSumberDokumen() {
        if (sumberDokumen.value === 'fisik') {
            wrapperFile.classList.add('d-none');
            inputFile.removeAttribute('required');
            
            wrapperHalaman.classList.remove('d-none');
            inputHalaman.setAttribute('required', 'required');
        } else {
            wrapperHalaman.classList.add('d-none');
            inputHalaman.removeAttribute('required');
            
            wrapperFile.classList.remove('d-none');
            inputFile.setAttribute('required', 'required');
        }
    }

    if (sumberDokumen) {
        sumberDokumen.addEventListener('change', toggleSumberDokumen);
        toggleSumberDokumen();
    }

    // --- 2. LOGIKA EFEK LOADING SAAT SUBMIT FORM ---
    const formTransaksi = document.getElementById('formTransaksi');
    
    if(formTransaksi) {
        formTransaksi.addEventListener('submit', function() {
            const btnSubmit = document.getElementById('btnSubmitAntrean');
            const btnText = document.getElementById('btnText');
            const btnLoading = document.getElementById('btnLoading');
            
            // Ubah tampilan tombol jadi Loading & cegah klik ganda (Double Click)
            btnSubmit.disabled = true; 
            btnText.classList.add('d-none');
            btnLoading.classList.remove('d-none');
        });
    }

    // --- 3. AUTO CLOSE ALERT NOTIFIKASI ---
    setTimeout(function() {
        var alertElement = document.getElementById('myAlert');
        if (alertElement) {
            // Karena menggunakan Bootstrap 5
            var alert = new bootstrap.Alert(alertElement);
            alert.close();
        }
    }, 3000);
});
</script>
@endsection