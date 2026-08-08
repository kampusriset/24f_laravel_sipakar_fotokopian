@extends('layout.app')

@section('title', 'Riwayat Transaksi')

@section('content')
<style>
    body { background-color: #f8f9fa !important; }

    .dashboard-card {
        background: #ffffff;
        border: 1px solid #f0f0f0;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
    }

    .search-wrapper {
        position: relative;
        width: 100%;
        max-width: 320px;
    }
    .search-icon {
        position: absolute;
        left: 1.2rem;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
    }
    .search-input {
        border-radius: 50rem;
        border: 1px solid #e2e8f0;
        padding: 0.6rem 1rem 0.6rem 2.8rem;
        background-color: #ffffff;
        font-size: 0.9rem;
        transition: all 0.3s;
    }
    .search-input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    .filter-select {
        border-radius: 50rem;
        border: 1px solid #e2e8f0;
        padding: 0.6rem 2rem 0.6rem 1.2rem;
        background-color: #ffffff;
        color: #475569;
        font-weight: 500;
        font-size: 0.9rem;
        min-width: 160px;
    }

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
        padding: 1.2rem 1rem;
    }
    .table-custom tr:hover td { background-color: #fcfcfc; }

    .text-trx { color: #2563eb; font-weight: 600; font-size: 0.85rem; }

    .badge-soft-success { background-color: #ecfdf5; color: #059669; padding: 6px 12px; font-weight: 600; }
    .badge-soft-danger { background-color: #fef2f2; color: #dc2626; padding: 6px 12px; font-weight: 600; }
    .badge-soft-warning { background-color: #fffbeb; color: #d97706; padding: 6px 12px; font-weight: 600; }
    .status-dot { font-size: 6px; vertical-align: middle; margin-right: 4px; padding-bottom: 2px;}

    .btn-outline-light-custom {
        border: 1px solid #e2e8f0;
        color: #64748b;
        background: transparent;
        border-radius: 8px;
        padding: 0.3rem 0.6rem;
        transition: all 0.2s;
    }
    .btn-outline-light-custom:hover { background-color: #f1f5f9; color: #0d6efd; border-color: #cbd5e1; }
    
    .btn-outline-danger-custom {
        border: 1px solid #fee2e2;
        color: #ef4444;
        background: #fff;
        border-radius: 8px;
        padding: 0.3rem 0.6rem;
        transition: all 0.2s;
    }
    .btn-outline-danger-custom:hover { background-color: #fef2f2; }

    .pagination {
        margin-bottom: 0;
        gap: 6px;
    }
    .page-item .page-link {
        border-radius: 8px !important;
        border: 1px solid #e2e8f0;
        color: #475569;
        padding: 0.4rem 0.85rem;
        font-size: 0.9rem;
        font-weight: 500;
        background-color: #ffffff;
        transition: all 0.2s;
        box-shadow: 0 1px 2px rgba(0,0,0,0.02);
    }
    .page-item.active .page-link {
        background-color: #2563eb;
        border-color: #2563eb;
        color: #ffffff;
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.2);
    }
    .page-item .page-link:hover {
        background-color: #f8fafc;
        border-color: #cbd5e1;
        color: #2563eb;
    }
    .page-item.disabled .page-link {
        background-color: #f1f5f9;
        color: #94a3b8;
        border-color: #e2e8f0;
        box-shadow: none;
    }
</style>

<div class="container-xl py-4">

    <!-- HEADER HALAMAN -->
    <div class="mb-4">
        <h3 class="fw-bold text-dark mb-1">Riwayat Transaksi</h3>
        <p class="text-muted mb-0">Lacak riwayat pesanan selesai.</p>
    </div>

    <div class="row g-4">
        <div class="col-12">
            <div class="card dashboard-card border-0">
                
                <div class="card-header bg-white border-bottom border-light p-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3" style="border-radius: 16px 16px 0 0;">
                    
                    <form action="" method="GET" class="search-wrapper m-0">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" name="search" class="form-control search-input" placeholder="Cari Nomor, Nama..." value="{{ request('search') }}">
                    </form>

                </div>

                <!-- TABEL DATA -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-custom table-borderless mb-0 align-middle">
                            <thead class="bg-white">
                                <tr>
                                    <th class="ps-4">Nomor</th>
                                    <th>Tanggal / Tenggat</th>
                                    <th>Nama Pelanggan</th>
                                    <th>File & Layanan</th>
                                    <th class="text-center">Status</th>
                                    <th>Total</th>
                                    <th class="text-center">Pembayaran</th>
                                    @if(Auth::check() && Auth::user()->role === 'admin')
                                    <th class="text-center pe-4">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @forelse($riwayatTransaksi as $trx)
                                @php
                                    $statusClass = 'badge-soft-success'; 
                                    $statusStatus = strtolower($trx->status_antrean);
                                    if(str_contains($statusStatus, 'batal')) {
                                        $statusClass = 'badge-soft-danger'; 
                                    } elseif(str_contains($statusStatus, 'tunggu') || str_contains($statusStatus, 'proses')) {
                                        $statusClass = 'badge-soft-warning'; 
                                    }
                                @endphp
                                <tr>
                                    <td class="ps-4">
                                        <span class="text-trx">#TRX-{{ str_pad($trx->id_transaksi, 4, '0', STR_PAD_LEFT) }}</span>
                                    </td>
                                    <td>
                                        <span class="text-muted" style="font-size: 0.85rem;">
                                            {{ date('d M Y, H:i', strtotime($trx->updated_at)) }}
                                        </span>
                                    </td>
                                    <td class="fw-medium text-dark">
                                        {{ $trx->nama_pelanggan ?? 'Tanpa Nama' }}
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="text-dark" style="font-size: 0.9rem;">{{ preg_replace('/^[0-9]+_/', '', $trx->file_dokumen) ?? '-' }}</span>
                                            <span class="text-muted" style="font-size: 0.8rem;">{{ $trx->jumlah_halaman }} Lembar</span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge {{ $statusClass }} rounded-pill border">
                                            <i class="bi bi-circle-fill status-dot"></i> {{ $trx->status_antrean }}
                                        </span>
                                    </td>
                                    <td class="fw-bold text-dark">
                                        Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-secondary border px-3 rounded-pill" style="font-weight: 500;">
                                            {{ $trx->metode ?? 'Cash' }}
                                        </span>
                                    </td>
                                    
                                    @if(Auth::check() && Auth::user()->role === 'admin')
                                    <td class="pe-4 text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <button type="button" class="btn btn-outline-light-custom" data-bs-toggle="modal" data-bs-target="#editModal{{ $trx->id_transaksi }}" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <form action="{{ url('/transaksi/'.$trx->id_transaksi) }}" method="POST" class="m-0" onsubmit="return confirm('Yakin hapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger-custom" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="{{ (Auth::check() && Auth::user()->role === 'admin') ? 8 : 7 }}" class="text-center py-5 text-muted">
                                        <div class="d-flex flex-column align-items-center justify-content-center py-4">
                                            <i class="bi bi-inbox fs-1 text-light mb-3"></i>
                                            <h6 class="fw-semibold">Belum ada riwayat transaksi.</h6>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- FOOTER -->
                @if($riwayatTransaksi->hasPages())
                <div class="card-footer bg-white border-top border-light p-4 d-flex flex-column flex-md-row justify-content-between align-items-center" style="border-radius: 0 0 16px 16px;">
                    
                    <span class="text-muted small mb-3 mb-md-0 fw-medium">
                        Menampilkan {{ $riwayatTransaksi->firstItem() ?? 0 }}–{{ $riwayatTransaksi->lastItem() ?? 0 }} dari {{ $riwayatTransaksi->total() }} data
                    </span>
                    
                    <div>
                        {{ $riwayatTransaksi->appends(request()->query())->links('pagination::bootstrap-5') }}
                    </div>
                    
                </div>
                @endif

            </div>
        </div>
    </div>
</div>

<!-- ================= EDIT POP UP ================= -->
@foreach($riwayatTransaksi as $trx)
<div class="modal fade" id="editModal{{ $trx->id_transaksi }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ url('/transaksi/'.$trx->id_transaksi) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                <div class="modal-header border-bottom border-light px-4 py-3">
                    <div>
                        <h5 class="modal-title fw-bold text-dark mb-0">Edit Transaksi</h5>
                        <small class="text-muted">Pelanggan: {{ $trx->nama_pelanggan }}</small>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4 py-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">Jumlah Halaman</label>
                        <div class="input-group">
                            <input type="number" name="jumlah_halaman" class="form-control bg-light border-light" value="{{ $trx->jumlah_halaman }}" required>
                            <span class="input-group-text bg-white border-light text-muted">Lbr</span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-secondary small">Total Harga (Rp)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-light text-muted">Rp</span>
                            <input type="number" name="total_harga" class="form-control bg-light border-light" value="{{ $trx->total_harga }}" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top border-light px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach

@endsection