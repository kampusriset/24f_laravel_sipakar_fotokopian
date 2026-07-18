@extends('layout.app')

@section('title', 'Dashboard')

@section('content')
<div class="row g-4">
    
    <!-- ================= BAGIAN ATAS: KATALOG JENIS LAYANAN ================= -->
    <div class="col-12">
        <h5 class="fw-bold text-white mb-3">Jenis Layanan</h5>
        <div class="row g-3">
            <!-- Looping data dari $daftarLayanan -->
            @forelse($daftarLayanan as $layanan)
            <div class="col-6 col-md-3 col-lg-2">
                <div class="card bg-dark border-secondary shadow-sm h-100 hover-card">
                    <div class="card-body text-center p-3 d-flex flex-column justify-content-center">
                        <!-- Sesuaikan 'nama_layanan' dan 'harga' dengan nama kolom di database-mu -->
                        <h6 class="text-light fw-semibold mb-2">{{ $layanan->nama_layanan ?? 'Nama Layanan' }}</h6>
                        <span class="text-primary fw-bold">Rp {{ number_format($layanan->harga ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <p class="text-secondary fst-italic">Belum ada data jenis layanan.</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- ================= BAGIAN BAWAH: TABEL TRANSAKSI SELESAI ================= -->
    <div class="col-12 mt-2">
        <div class="card bg-dark border-secondary shadow-sm rounded-4">
            <div class="card-header border-secondary py-3 px-4">
                <h5 class="mb-0 text-white fw-semibold">
                    <i class="bi bi-list-check text-info me-2"></i>Daftar Transaksi (Selesai)
                </h5>
            </div>
            
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-dark table-hover mb-0 align-middle">
                        <thead class="table-active">
                            <tr>
                                <th class="px-4 py-3">Nama (Opsional)</th>
                                <th class="py-3">File Dokumen</th>
                                <th class="py-3 text-center">Halaman</th>
                                <th class="py-3">Tenggat</th>
                                <th class="py-3">Pembayaran</th>
                                <th class="py-3 text-center">Status</th>
                                <th class="px-4 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            <!-- Looping data dari $transaksiTerbaru -->
                            @forelse($transaksiTerbaru as $trx)
                            <tr>
                                <!-- Opsional Nama -->
                                <td class="px-4 text-white fw-medium">
                                    {{ $trx->nama_pelanggan ?? '-' }}
                                </td>
                                
                                <!-- File Dokumen -->
                                <td class="text-secondary">
                                    {{ $trx->file_dokumen ?? 'Tidak ada file' }}
                                </td>
                                
                                <!-- Halaman -->
                                <td class="text-center text-white">
                                    {{ $trx->jumlah_halaman ?? '-' }}
                                </td>
                                
                                <!-- Tenggat Waktu (Asumsi pakai updated_at) -->
                                <td class="text-secondary">
                                    {{ \Carbon\Carbon::parse($trx->updated_at)->format('d/m/Y') }}
                                </td>
                                
                                <!-- Pembayaran (Cash/TF) -->
                                <td class="text-white">
                                    <span class="badge bg-secondary bg-opacity-25 text-light border border-secondary px-2 py-1">
                                        {{ $trx->metode ?? 'Cash' }}
                                    </span>
                                </td>
                                
                                <!-- Status -->
                                <td class="text-center">
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success px-3 py-1 rounded-pill">
                                        Selesai
                                    </span>
                                </td>
                                
                                <!-- Aksi (Edit, Hapus, Selesai) -->
                                <td class="px-4 text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-sm btn-outline-warning rounded-3" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger rounded-3" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-success rounded-3" title="Selesai">
                                            <i class="bi bi-check2-all"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-secondary">
                                    <i class="bi bi-inbox fs-2 d-block mb-2 opacity-50"></i>
                                    Belum ada data transaksi yang selesai.
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

<!-- CSS untuk efek interaktif kartu -->
<style>
    .hover-card {
        transition: all 0.3s ease;
        border: 1px solid #2b3035;
        cursor: pointer;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        border-color: #0d6efd !important;
        box-shadow: 0 5px 15px rgba(13, 110, 253, 0.15) !important;
    }
</style>
@endsection