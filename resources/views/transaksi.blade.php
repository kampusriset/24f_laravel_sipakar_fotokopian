@extends('layout.app')

@section('title', 'Transaksi')

@section('content')
<style>
    body { background-color: #f8f9fa !important; }

    /* Styling Card Utama */
    .dashboard-card {
        background: #ffffff;
        border: 1px solid #f0f0f0;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
    }

    .form-label {
        font-weight: 600;
        font-size: 0.85rem;
        color: #475569;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control, .form-select {
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        padding: 0.6rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s;
        background-color: #ffffff;
        color: #334155;
    }
    .form-control:focus, .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        background-color: #ffffff;
    }

    .radio-card-input { display: none; }
    .radio-card-label {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 0.8rem;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        cursor: pointer;
        font-weight: 600;
        color: #64748b;
        transition: all 0.2s;
        background-color: #ffffff;
        margin: 0;
    }
    .radio-card-label:hover {
        background-color: #f8fafc;
        border-color: #cbd5e1;
    }
    .radio-card-input:checked + .radio-card-label {
        background-color: #eff6ff;
        border-color: #3b82f6;
        color: #2563eb;
    }

    .upload-area {
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        padding: 2.5rem 1rem;
        text-align: center;
        background-color: #f8fafc;
        cursor: pointer;
        transition: all 0.3s;
    }
    .upload-area:hover {
        border-color: #3b82f6;
        background-color: #eff6ff;
    }

    .qty-btn {
        background-color: #f1f5f9;
        border: 1px solid #e2e8f0;
        color: #475569;
        width: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        cursor: pointer;
        transition: all 0.2s;
    }
    .qty-btn:hover { background-color: #e2e8f0; }
    .qty-input {
        text-align: center;
        font-weight: bold;
        border-left: 0;
        border-right: 0;
        border-radius: 0;
    }

    .sticky-summary {
        position: sticky;
        top: 90px;
    }

    /* Styling Tabel Clean */
    .table-custom th {
        text-transform: uppercase;
        font-size: 0.7rem;
        color: #64748b;
        font-weight: 700;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #f1f5f9;
        padding: 1.2rem 1rem;
    }
    .table-custom td {
        border-bottom: 1px solid #f8f9fa;
        vertical-align: middle;
        color: #334155;
        font-size: 0.9rem;
        padding: 1rem;
    }
    .table-custom tr:hover td { background-color: #fcfcfc; }

    /* Highlight Baris Pengetikan di Mode Terang */
    .row-highlight td {
        background-color: rgba(245, 158, 11, 0.04) !important; 
    }
    .row-highlight td:first-child {
        border-left: 4px solid #f59e0b;
    }

    /* Badge & Tombol Action */
    .badge-soft-success { background-color: #ecfdf5; color: #059669; }
    .badge-soft-warning { background-color: #fffbeb; color: #d97706; }
    .badge-soft-danger { background-color: #fef2f2; color: #dc2626; }
    .badge-soft-primary { background-color: #eff6ff; color: #2563eb; }

    .btn-icon-custom {
        border: 1px solid #e2e8f0;
        background: transparent;
        border-radius: 8px;
        padding: 0.3rem 0.6rem;
        transition: all 0.2s;
    }
    .btn-icon-custom.edit:hover { background-color: #eff6ff; color: #2563eb; border-color: #bfdbfe; }
    .btn-icon-custom.check:hover { background-color: #ecfdf5; color: #059669; border-color: #a7f3d0; }
    .btn-icon-custom.delete:hover { background-color: #fef2f2; color: #dc2626; border-color: #fecaca; }

    /* CSS FOOTER  */
    .page-footer {
        text-align: center;
        margin-top: 3rem; 
        padding-top: 2rem; 
        padding-bottom: 2rem; 
        color: #94a3b8;
        font-size: 0.85rem;
        border-top: 1px solid #e2e8f0; 
    }
</style>

<div class="container-xl py-4">

    <!-- BAGIAN NOTIFIKASI -->
    <div class="mb-4">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" id="myAlert" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
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
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">Input Antrean Baru</h3>
            <p class="text-muted mb-0">Masukkan detail pesanan pelanggan ke dalam sistem.</p>
        </div>
        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary rounded-pill px-3 py-2 fw-semibold">
            STEP 01/02
        </span>
    </div>

    <form action="{{ url('/transaksi') }}" method="POST" enctype="multipart/form-data" id="formTransaksi">
        @csrf
        <!-- Input Hidden Sesuai Kodingan Asli -->
        <input type="hidden" name="nilai_prioritas" id="input_nilai_prioritas">
        <input type="hidden" name="kategori_prioritas" id="input_kategori_prioritas">

        <div class="row g-4 mb-5">
            
            <!-- KOLOM FORM UTAMA -->
            <div class="col-lg-8">
                
                <!-- Detail Pesanan -->
                <div class="card dashboard-card border-0 mb-4 p-4">
                    <h6 class="fw-bold text-dark mb-4 d-flex align-items-center">
                        <i class="bi bi-person-fill text-primary me-2 fs-5"></i> Detail Pesanan
                    </h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Pelanggan</label>
                            <input type="text" name="nama_pelanggan" class="form-control" placeholder="Contoh: Budi Mahasiswa" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No. WhatsApp</label>
                            <input type="text" name="no_hp" class="form-control" placeholder="08...">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat Pengiriman (Opsional)</label>
                            <input type="text" name="alamat" class="form-control" placeholder="Contoh: Jl. Slamet Riyadi, Solo">
                        </div>
                    </div>
                </div>

                <!-- Sumber Dokumen -->
                <div class="card dashboard-card border-0 mb-4 p-4">
                    <h6 class="fw-bold text-dark mb-4 d-flex align-items-center">
                        <i class="bi bi-folder-fill text-primary me-2 fs-5"></i> Sumber Dokumen
                    </h6>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <input type="radio" name="sumber_dokumen" id="sumber_digital" value="digital" class="radio-card-input" checked>
                            <label class="radio-card-label" for="sumber_digital">
                                <i class="bi bi-cloud-arrow-up fs-5"></i> Dokumen Digital (PDF)
                            </label>
                        </div>
                        <div class="col-sm-6">
                            <input type="radio" name="sumber_dokumen" id="sumber_fisik" value="fisik" class="radio-card-input">
                            <label class="radio-card-label" for="sumber_fisik">
                                <i class="bi bi-file-earmark-text fs-5"></i> Dokumen Fisik (Manual)
                            </label>
                        </div>
                    </div>

                    <!-- Area Upload -->
                    <div class="mt-4" id="wrapper_file">
                        <label class="form-label">File Dokumen PDF</label>
                        <div class="upload-area" onclick="document.getElementById('file_dokumen').click()">
                            <i class="bi bi-cloud-arrow-up upload-icon"></i>
                            <h6 class="fw-bold text-dark mb-1">Klik untuk memilih file PDF</h6>
                            <p class="text-muted small mb-0" id="file_name">Maksimal ukuran file 10MB</p>
                            
                            <input type="file" name="file_dokumen" id="file_dokumen" class="d-none" accept=".pdf" onchange="updateFileName(this)">
                        </div>
                    </div>

                    <!-- Area Input Halaman (Muncul Jika Fisik) -->
                    <div class="mt-4 d-none" id="wrapper_halaman">
                        <label class="form-label">Jumlah Halaman (Manual)</label>
                        <div class="d-flex" style="max-width: 200px;">
                            <button type="button" class="btn qty-btn" style="border-radius: 10px 0 0 10px;" onclick="kurangiHalaman()">-</button>
                            <input type="number" name="jumlah_halaman_manual" id="jumlah_halaman_manual" class="form-control qty-input" value="" placeholder="Jmlh" min="1">
                            <button type="button" class="btn qty-btn" style="border-radius: 0 10px 10px 0;" onclick="tambahHalaman()">+</button>
                        </div>
                    </div>
                </div>

                <!-- Spesifikasi Cetak -->
                <div class="card dashboard-card border-0 mb-4 p-4">
                    <h6 class="fw-bold text-dark mb-4 d-flex align-items-center">
                        <i class="bi bi-sliders text-primary me-2 fs-5"></i> Spesifikasi Cetak
                    </h6>
                    <div class="row g-4">
                        <div class="col-md-12">
                            <label class="form-label">Jenis Layanan</label>
                            <select name="layanan_id" id="layanan_id" class="form-select" required>
                                <option value="" selected disabled>Pilih Layanan...</option>
                                @foreach($layanan as $l)
                                    <option value="{{ $l->id }}">{{ $l->nama_layanan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Kertas -->
                        <div class="col-md-6">
                            <label class="form-label">Ukuran Kertas</label>
                            <select name="ukuran_kertas" class="form-select" required>
                                <option value="A4" selected>A4 (210 x 297 mm)</option>
                                <option value="F4">F4 (215 x 330 mm)</option>
                                <option value="A3">A3 (297 x 420 mm)</option>
                            </select>
                        </div>

                        <!-- Warna -->
                        <div class="col-md-6">
                            <label class="form-label">Warna Cetak</label>
                            <div class="d-flex gap-2">
                                <div class="w-100">
                                    <input type="radio" name="warna_cetak" id="warna_bw" value="Hitam Putih" class="radio-card-input" checked>
                                    <label class="radio-card-label py-2" for="warna_bw" style="font-size: 0.9rem;">B/W</label>
                                </div>
                                <div class="w-100">
                                    <input type="radio" name="warna_cetak" id="warna_fc" value="Full Color" class="radio-card-input">
                                    <label class="radio-card-label py-2" for="warna_fc" style="font-size: 0.9rem;">Warna</label>
                                </div>
                            </div>
                        </div>

                        <!-- Tenggat (Input Menit) -->
                        <div class="col-md-6">
                            <label class="form-label">Tenggat Waktu</label>
                            <div class="input-group">
                                <input type="number" name="waktu_deadline" id="waktu_deadline" class="form-control border-end-0" placeholder="Contoh: 60" min="1" required>
                                <span class="input-group-text bg-white border-start-0 text-muted" style="border-radius: 0 10px 10px 0;">Menit</span>
                            </div>
                        </div>

                        <!-- Metode Pembayaran -->
                        <div class="col-md-6">
                            <label class="form-label">Metode Pembayaran</label>
                            <div class="d-flex gap-2">
                                <div class="w-100">
                                    <input type="radio" name="metode" id="metode_tunai" value="Cash" class="radio-card-input" checked>
                                    <label class="radio-card-label py-2" for="metode_tunai" style="font-size: 0.9rem;">
                                        <i class="bi bi-cash-stack"></i> Cash
                                    </label>
                                </div>
                                <div class="w-100">
                                    <input type="radio" name="metode" id="metode_qris" value="QRIS" class="radio-card-input">
                                    <label class="radio-card-label py-2" for="metode_qris" style="font-size: 0.9rem;">
                                        <i class="bi bi-qr-code"></i> QRIS
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KOLOM RINGKASAN & SUBMIT -->
            <div class="col-lg-4">
                <div class="card dashboard-card border-0 p-4 sticky-summary">
                    <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                        <i class="bi bi-receipt text-primary me-2 fs-5"></i> Ringkasan
                    </h6>
                    <p class="text-muted small mb-4">
                        Estimasi biaya dan nilai prioritas (Sistem Pakar) akan dihitung otomatis setelah antrean masuk ke dalam sistem.
                    </p>
                    <button type="reset" class="btn btn-outline-secondary w-100 rounded-pill fw-semibold py-2 mb-2">Reset Form</button>
                    <button type="submit" id="btnSubmitAntrean" class="btn btn-primary w-100 rounded-pill fw-semibold py-2 shadow-sm">
                        <span id="btnText"><i class="bi bi-send me-1"></i> Masukkan ke Antrean</span>
                        <span id="btnLoading" class="d-none">
                            <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Memproses...
                        </span>
                    </button>
                </div>
            </div>

        </div>
    </form>
    @endif

    <!-- TABEL DAFTAR ANTREAN -->
    <div class="mb-5">
        <div class="card dashboard-card border-0 overflow-hidden">
            <div class="card-header bg-white border-0 pt-4 pb-3 px-4">
                <h5 class="mb-0 fw-bold text-dark d-flex align-items-center">
                    <i class="bi bi-list-task text-primary me-2"></i>Daftar Antrean Aktif
                </h5>
            </div>
            
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-custom table-borderless mb-0 align-middle" id="tabelAntrean">
                        <thead class="bg-white">
                            <tr>
                                <th class="ps-4">Nama Pelanggan</th>
                                <th>File</th>
                                <th class="text-center">Halaman</th>
                                <th>Layanan</th>
                                <th>Selesai Pada</th>
                                <th>Total</th>
                                <th>Metode</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Prioritas</th>
                                <th class="text-center pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white" id="tabel-antrean-body">
                            <!-- SORTING KHUSUS UNTUK MENARIK PENGETIKAN KE ATAS -->
                            @php
                                $sortedTransaksi = $transaksi->sortByDesc(function($trx) {
                                    return $trx->tingkat_prioritas === 'Pengetikan' ? 1 : 0;
                                });
                            @endphp

                            @forelse($sortedTransaksi as $trx)
                            <!-- HIGHLIGHT BARIS JIKA ITU PENGETIKAN -->
                            <tr class="{{ $trx->tingkat_prioritas == 'Pengetikan' ? 'row-highlight' : '' }}">
                                <td class="ps-4 fw-bold text-dark">{{ $trx->nama_pelanggan }}</td>
                                <td>
                                    @if($trx->file_dokumen)
                                        <div class="text-primary text-wrap text-break fw-medium" style="max-width: 150px; font-size: 0.85rem;" title="{{ $trx->file_dokumen }}">
                                            <i class="bi bi-file-earmark-pdf me-1"></i>{{ preg_replace('/^[0-9]+_/', '', $trx->file_dokumen) }}
                                        </div>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border px-2 py-1"><i class="bi bi-file-earmark-text me-1"></i> Fisik</span>
                                    @endif
                                </td>
                                <td class="text-center fw-medium">{{ $trx->jumlah_halaman ?? '-' }}</td>
                                <td>{{ $trx->nama_layanan }}</td>
                                <td class="text-muted" style="font-size: 0.85rem;">{{ \Carbon\Carbon::parse($trx->waktu_deadline)->format('H:i') }}</td>
                                <td class="text-dark fw-bold">Rp {{ number_format($trx->total_bayar, 0, ',', '.') }}</td>
                                <td><span class="badge bg-light text-secondary border px-2 py-1">{{ $trx->metode }}</span></td>
                                
                                <td class="text-center">
                                    <span class="badge border rounded-pill px-3 py-1 {{ $trx->status_antrean == 'Selesai' ? 'badge-soft-success border-success' : 'badge-soft-warning border-warning' }}">
                                        {{ $trx->status_antrean }}
                                    </span>
                                </td>
                                
                                <td class="text-center">
                                    <!-- PRIORITAS -->
                                    @if($trx->tingkat_prioritas == 'Pengetikan')
                                        <span class="badge badge-soft-warning border border-warning text-dark fw-bold shadow-sm px-2 py-1"><i class="bi bi-keyboard me-1"></i>Ketik</span>
                                    @elseif($trx->tingkat_prioritas == 'Tinggi')
                                        <span class="badge badge-soft-danger border border-danger px-2 py-1">Tinggi</span>
                                    @elseif($trx->tingkat_prioritas == 'Normal')
                                        <span class="badge badge-soft-primary border border-primary px-2 py-1">Normal</span>
                                    @else
                                        <span class="badge bg-light border text-secondary px-2 py-1">Rendah</span>
                                    @endif
                                </td>

                                <td class="pe-4 text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <!-- Edit Modal -->
                                        <button type="button" class="btn-icon-custom edit text-secondary" data-bs-toggle="modal" data-bs-target="#editModal{{ $trx->id_transaksi }}" title="Edit Data">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <!-- Status Selesai Cepat -->
                                        <form action="{{ url('/transaksi/'.$trx->id_transaksi) }}" method="POST" class="m-0">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status_antrean" value="Selesai">
                                            <button type="submit" class="btn-icon-custom check text-success border-success" title="Tandai Selesai">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center py-5 text-muted" id="rowKosong">
                                    <div class="d-flex flex-column align-items-center justify-content-center py-3">
                                        <i class="bi bi-inbox fs-2 text-light mb-2"></i>
                                        Belum ada antrean berjalan.
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- PAGE FOOTER COPYRIGHT (DENGAN SPACING SIMETRIS) -->
    <footer class="page-footer">
        © 2026 1HZS Fotocopy & Print. Semua hak dilindungi.
    </footer>

</div>

<!-- MODAL EDIT (Tema Terang) -->
@foreach($transaksi as $trx)
<div class="modal fade" id="editModal{{ $trx->id_transaksi }}" tabindex="-1" aria-labelledby="editModalLabel{{ $trx->id_transaksi}}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header border-bottom border-light px-4 py-3">
                <h5 class="modal-title fw-bold text-dark" id="editModalLabel{{ $trx->id_transaksi}}">
                    <i class="bi bi-pencil-square text-primary me-2"></i>Edit Data Antrean
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ url('/transaksi/'.$trx->id_transaksi) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body px-4 py-4">
                    <div class="row g-4">
                        <div class="col-12">
                            <label class="form-label">Status Saat Ini</label>
                            <select name="status_antrean" class="form-select">
                                <option value="Menunggu" {{ $trx->status_antrean == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="Cetak" {{ $trx->status_antrean == 'Cetak' ? 'selected' : '' }}>Cetak</option>
                                <option value="Selesai" {{ $trx->status_antrean == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Pelanggan</label>
                            <input type="text" name="nama_pelanggan" class="form-control" value="{{ $trx->nama_pelanggan }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Ganti Layanan</label>
                            <select name="layanan_id" class="form-select">
                                @foreach($layanan as $l)
                                <option value="{{ $l->id }}" {{ $trx->layanan_id == $l->id ? 'selected' : '' }}>
                                    {{ $l->nama_layanan }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label">Jumlah Halaman</label>
                            <input type="number" name="jumlah_halaman" class="form-control" value="{{ $trx->jumlah_halaman ?? '' }}" min="1" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Ukuran Kertas</label>
                            <select name="ukuran_kertas" class="form-select" required>
                                <option value="A4" {{ ($trx->ukuran_kertas ?? '') == 'A4' ? 'selected' : '' }}>A4 (210 x 297 mm)</option>
                                <option value="F4" {{ ($trx->ukuran_kertas ?? '') == 'F4' ? 'selected' : '' }}>F4 (215 x 330 mm)</option>
                                <option value="A3" {{ ($trx->ukuran_kertas ?? '') == 'A3' ? 'selected' : '' }}>A3 (297 x 420 mm)</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Warna Cetak</label>
                            <div class="d-flex gap-2">
                                <div class="w-100">
                                    <input type="radio" name="warna_cetak" id="edit_warna_bw_{{ $trx->id_transaksi }}" value="Hitam Putih" class="radio-card-input" {{ ($trx->warna_cetak ?? '') == 'Hitam Putih' ? 'checked' : '' }}>
                                    <label class="radio-card-label py-2" for="edit_warna_bw_{{ $trx->id_transaksi }}" style="font-size: 0.9rem;">B/W</label>
                                </div>
                                <div class="w-100">
                                    <input type="radio" name="warna_cetak" id="edit_warna_fc_{{ $trx->id_transaksi }}" value="Full Color" class="radio-card-input" {{ ($trx->warna_cetak ?? '') == 'Full Color' ? 'checked' : '' }}>
                                    <label class="radio-card-label py-2" for="edit_warna_fc_{{ $trx->id_transaksi }}" style="font-size: 0.9rem;">Warna</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tenggat Waktu (Menit Sisa)</label>
                            @php
                                // Menghitung sisa menit dari waktu sekarang ke waktu_deadline di DB
                                $sisaMenit = \Carbon\Carbon::now()->diffInMinutes(\Carbon\Carbon::parse($trx->waktu_deadline), false);
                                $sisaMenit = (int) max(0, $sisaMenit); // Jika sudah lewat waktu, jadi 0
                            @endphp
                            <div class="input-group">
                                <input type="number" name="waktu_deadline" class="form-control border-end-0" value="{{ $sisaMenit }}" min="1" required>
                                <span class="input-group-text bg-white border-start-0 text-muted" style="border-radius: 0 10px 10px 0;">Menit</span>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Ganti File Dokumen (Opsional)</label>
                            <input type="file" name="file_dokumen" class="form-control" accept=".pdf">
                            <div class="mt-2 text-secondary small">
                                <i class="bi bi-file-earmark-pdf text-danger me-1"></i> File tersimpan:
                                <span class="fw-medium text-dark">{{ $trx->file_dokumen ?? 'Tidak ada file' }}</span>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <label class="form-label">Metode Pembayaran</label>
                            <select name="metode" class="form-select">
                                <option value="Cash" {{ $trx->metode == 'Cash' ? 'selected' : '' }}>Cash</option>
                                <option value="QRIS" {{ $trx->metode == 'QRIS' ? 'selected' : '' }}>QRIS</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top border-light px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<script>
document.addEventListener('DOMContentLoaded', function () {
    const radioDigital = document.getElementById('sumber_digital');
    const radioFisik = document.getElementById('sumber_fisik');
    const wrapperFile = document.getElementById('wrapper_file');
    const wrapperHalaman = document.getElementById('wrapper_halaman');
    const inputFile = document.getElementById('file_dokumen');
    const inputHalaman = document.getElementById('jumlah_halaman_manual');

    function toggleSumberDokumen() {
        if (radioFisik && radioFisik.checked) {
            // Mode Fisik
            wrapperFile.classList.add('d-none');
            inputFile.removeAttribute('required');
            
            wrapperHalaman.classList.remove('d-none');
            inputHalaman.setAttribute('required', 'required');
            if(inputHalaman.value === '') inputHalaman.value = 1;
        } else {
            // Mode Digital
            wrapperHalaman.classList.add('d-none');
            inputHalaman.removeAttribute('required');
            inputHalaman.value = '';
            
            wrapperFile.classList.remove('d-none');
            inputFile.setAttribute('required', 'required');
        }
    }

    if (radioDigital && radioFisik) {
        radioDigital.addEventListener('change', toggleSumberDokumen);
        radioFisik.addEventListener('change', toggleSumberDokumen);
        toggleSumberDokumen(); 
    }

    const formTransaksi = document.getElementById('formTransaksi');
    if(formTransaksi) {
        formTransaksi.addEventListener('submit', function() {
            const btnSubmit = document.getElementById('btnSubmitAntrean');
            const btnText = document.getElementById('btnText');
            const btnLoading = document.getElementById('btnLoading');
            
            btnSubmit.disabled = true; 
            btnText.classList.add('d-none');
            btnLoading.classList.remove('d-none');
        });
    }

    setTimeout(function() {
        var alertElement = document.getElementById('myAlert');
        if (alertElement) {
            var alert = new bootstrap.Alert(alertElement);
            alert.close();
        }
    }, 4000);
});

function updateFileName(input) {
    const fileNameText = document.getElementById('file_name');
    if (input.files && input.files.length > 0) {
        fileNameText.innerHTML = `<span class='text-primary fw-bold'>File terpilih:</span> ${input.files[0].name}`;
    } else {
        fileNameText.innerHTML = 'Maksimal ukuran file 10MB';
    }
}

function tambahHalaman() {
    const inputHalaman = document.getElementById('jumlah_halaman_manual');
    let val = parseInt(inputHalaman.value) || 0;
    inputHalaman.value = val + 1;
}

function kurangiHalaman() {
    const inputHalaman = document.getElementById('jumlah_halaman_manual');
    let val = parseInt(inputHalaman.value) || 1;
    if (val > 1) {
        inputHalaman.value = val - 1;
    }
}
</script>
@endsection