@extends('layout.app')

@section('title', 'Dashboard')

@section('content')
<link rel="stylesheet" href="{{ asset('asset/css/cardLayanan.css') }}">

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

<div class="row g-4">

    <!-- BAGIAN LAYANAN TERSEDIA (CENTERED) -->
    <div class="col-12">
        <h5 class="fw-bold text-white mb-3">
            <i class="bi bi-grid-1x2 text-primary me-2"></i>Layanan Tersedia
        </h5>
        <div class="row g-3 justify-content-center">
            @forelse($layanan as $l)
            @php
            $icon = 'bi-file-earmark-text';
            $color = 'primary';

            if(stripos($l->nama_layanan, 'warna') !== false) {
                $icon = 'bi-palette-fill';
                $color = 'success';
            } elseif(stripos($l->nama_layanan, 'scan') !== false) {
                $icon = 'bi-upc-scan';
                $color = 'warning';
            } elseif(stripos($l->nama_layanan, 'hitam') !== false || stripos($l->nama_layanan, 'putih') !== false) {
                $icon = 'bi-printer-fill';
                $color = 'secondary';
            }
            @endphp

            <div class="col-8 col-md-6 col-lg-2">
                <div class="card bg-dark border-secondary shadow-sm h-100 hover-card rounded-4 p-4">
                    <div class="d-flex flex-column align-items-center text-center justify-content-center h-100">
                        <div class="rounded-4 mb-3 d-flex align-items-center justify-content-center bg-{{ $color }} bg-opacity-10" style="width: 60px; height: 60px;">
                            <i class="bi {{ $icon }} fs-3 text-{{ $color }}"></i>
                        </div>
                        <h6 class="text-light fw-bold mb-1" style="font-size: 1rem;">{{ $l->nama_layanan }}</h6>
                        <span class="text-primary fw-bold" style="font-size: 0.95rem;">Rp {{ number_format($l->harga_per_lembar ?? 0, 0, ',', '.') }}</span>
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

    <!-- BAGIAN INFORMASI STOK BARANG -->
    <div class="col-12 mt-4">
        <h5 class="fw-bold text-white mb-3">
            <i class="bi bi-box-seam text-warning me-2"></i>Informasi Stok Barang Toko
        </h5>

        <div class="row g-3 justify-content-center">
            {{-- Pastikan di controller Home/Dashboard kamu mengirimkan variabel $stokBarang --}}
            @forelse($stokBarang ?? [] as $stok)
            <div class="col-md-4 col-lg-3">
                <div class="card bg-dark border-secondary shadow-sm rounded-4 p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-secondary small text-uppercase fw-semibold">{{ $stok->kategori }}</span>
                            <h6 class="text-white fw-bold mb-1">{{ $stok->nama_barang }}</h6>
                            <span class="badge {{ $stok->jumlah_stok <= 5 ? 'bg-danger' : 'bg-success' }} bg-opacity-25 text-{{ $stok->jumlah_stok <= 5 ? 'danger' : 'success' }} border border-{{ $stok->jumlah_stok <= 5 ? 'danger' : 'success' }}">
                                Stok: {{ $stok->jumlah_stok }} {{ $stok->satuan }}
                            </span>
                        </div>
                        <div class="rounded-circle bg-secondary bg-opacity-10 p-3 text-secondary">
                            <i class="bi bi-box fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="card bg-dark border-secondary rounded-4 p-3 text-center text-secondary">
                    Belum ada data stok barang yang tersedia.
                </div>
            </div>
            @endforelse
        </div>
    </div>

    <!-- BAGIAN BAWAH: TABEL TRANSAKSI SELESAI -->
    <div class="col-12 mt-4">
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
                                <th class="py-3">Total</th>
                                <th class="py-3">Pembayaran</th>
                                <th class="py-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            @forelse($transaksiTerbaru->take(5) as $trx)
                            <tr>
                                <td class="px-4 text-white fw-medium">
                                    {{ $trx->nama_pelanggan ?? '-' }}
                                </td>
                                <td class="text-secondary">
                                    {{ preg_replace('/^[0-9]+_/', '', $trx->file_dokumen) }}
                                </td>
                                <td class="text-center text-white">
                                    {{ $trx->jumlah_halaman ?? '-' }}
                                </td>
                                <td class="text-secondary">
                                    {{ \Carbon\Carbon::parse($trx->waktu_deadline)->format('d/m/Y') }}
                                </td>
                                <td class="text-primary fw-bold">
                                    Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                                </td>
                                <td class="text-white">
                                    <span class="badge bg-secondary bg-opacity-25 text-light border border-secondary px-2 py-1">
                                        {{ $trx->metode ?? 'Cash' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success px-3 py-1 rounded-pill">
                                        Selesai
                                    </span>
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
@endsection