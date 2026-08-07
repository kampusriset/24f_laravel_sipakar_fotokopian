@extends('layout.app')

@section('title', 'Laporan Pendapatan')

@section('content')
<div class="row g-4">
    <div class="col-12">
        <!-- Tombol Aksi -->
        <div class="d-flex justify-content-end mb-3 gap-2">
            <a href="{{ url('/laporan/cetak-pdf') }}" class="btn btn-danger rounded-3 shadow-sm">
                <i class="bi bi-file-earmark-pdf-fill me-1"></i> Download PDF
            </a>
            <button class="btn btn-outline-info rounded-3 shadow-sm" onclick="window.print()">
                <i class="bi bi-printer-fill me-1"></i> Print Langsung
            </button>
        </div>

        <!-- Card Kertas Laporan -->
        <div class="card bg-dark border-secondary shadow-lg rounded-4 overflow-hidden">
            <div class="card-body p-5">

                <!-- Kop Surat -->
                <div class="text-center border-bottom border-secondary pb-4 mb-4">
                    <h3 class="text-white fw-bold text-uppercase mb-1">1HZS TOKO FOTOCOPY & PRINT</h3>
                    <p class="text-secondary mb-1">Jl. Contoh Alamat No. 123, Kota, Provinsi, Kode Pos 12345</p>
                    <p class="text-secondary mb-0">
                        <i class="bi bi-telephone-fill me-1"></i> 0812-3456-7890 |
                        <i class="bi bi-envelope-fill me-1"></i> email@tokofotocopy.com
                    </p>
                </div>

                <h5 class="text-center text-white fw-semibold mb-4">LAPORAN PENDAPATAN 1HZS FOTOCOPY & PRINT </h5>

                <!-- Tabel -->
                <div class="table-responsive">
                    <table class="table table-dark table-borderless align-middle">
                        <thead class="text-secondary text-uppercase" style="font-size: 0.85rem; letter-spacing: 0.05rem;">
                            <tr class="border-bottom border-secondary">
                                <th class="py-3 ps-3" width="5%">No</th>
                                <th class="py-3" width="15%">ID Transaksi</th>
                                <th class="py-3" width="15%">Tanggal</th>
                                <th class="py-3">Layanan</th>
                                <th class="py-3" width="10%">Metode</th>
                                <th class="py-3 text-end pe-3" width="20%">Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($laporan as $index => $trx)
                            <tr class="border-bottom border-secondary">
                                <td class="py-3 ps-3 text-secondary">{{ $index + 1 }}</td>
                                <td class="py-3 text-info font-monospace">{{ $trx->id }}</td>
                                <td class="py-3 text-white">{{ date('d/m/Y', strtotime($trx->updated_at)) }}</td>
                                <td class="py-3 text-white">{{ $trx->nama_layanan ?? 'Dokumen' }}</td>
                                <td class="py-3">
                                    <span class="badge bg-dark border border-secondary text-secondary px-2">
                                        {{ $trx->metode ?? 'Cash' }}
                                    </span>
                                </td>
                                <td class="py-3 text-end pe-3 text-white fw-bold">
                                    {{ number_format($trx->total_harga, 0, ',', '.') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-secondary">Belum ada data pendapatan.</td>
                            </tr>
                            @endforelse

                            <!-- Baris Total -->
                            <tr>
                                <td colspan="5" class="text-end pt-4 fw-bold text-secondary">TOTAL PENDAPATAN :</td>
                                <td class="text-end pt-4 pe-3 fw-bold text-white fs-5">
                                    Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Tanda Tangan -->
                <div class="row mt-5">
                    <div class="col-8"></div>
                    <div class="col-4 text-center">
                        <p class="text-secondary mb-5">Admin Bertugas,</p>
                        <br>
                        <p class="text-white fw-bold text-decoration-underline mb-0">{{ Auth::user()->name ?? 'Administrator' }}</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection