@extends('layout.app')

@section('title', 'Manajemen Stok')

@section('content')
<style>
    body { background-color: #f8f9fa !important; }

    /* Dashboard Cards */
    .dashboard-card {
        background: #ffffff;
        border: 1px solid #f0f0f0;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        transition: all 0.3s ease;
    }
    
    .summary-card {
        padding: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .icon-box-summary {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 1.2rem;
    }

    /* Status Card */
    .quick-status-card {
        padding: 1.25rem;
        border: 1px solid #f0f0f0;
        border-radius: 14px;
        background: #ffffff;
        box-shadow: 0 2px 10px rgba(0,0,0,0.01);
    }
    .progress-line {
        height: 6px;
        border-radius: 10px;
        background-color: #f1f5f9;
        margin: 10px 0;
        overflow: hidden;
    }
    .progress-bar-custom {
        height: 100%;
        border-radius: 10px;
    }

    /* Tabel & Search Bar */
    .search-wrapper { position: relative; width: 100%; max-width: 300px; }
    .search-icon { position: absolute; left: 1.2rem; top: 50%; transform: translateY(-50%); color: #94a3b8; }
    
    .search-input {
        border-radius: 50rem;
        border: 1px solid #e2e8f0;
        padding: 0.5rem 1rem 0.5rem 2.8rem !important; 
        font-size: 0.9rem;
    }
    
    .filter-btn {
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        padding: 0.5rem 1rem;
        background: #fff;
        color: #64748b;
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

    /* Badges */
    .badge-soft-success { background-color: #ecfdf5; color: #059669; padding: 6px 12px; font-weight: 600; }
    .badge-soft-warning { background-color: #fffbeb; color: #d97706; padding: 6px 12px; font-weight: 600; }
    .badge-soft-danger { background-color: #fef2f2; color: #dc2626; padding: 6px 12px; font-weight: 600; }
    .status-dot { font-size: 6px; vertical-align: middle; margin-right: 4px; padding-bottom: 2px;}

    /* Action Buttons */
    .btn-icon-only {
        border: 1px solid #e2e8f0;
        color: #64748b;
        background: transparent;
        border-radius: 8px;
        padding: 0.4rem 0.6rem;
        transition: all 0.2s;
    }
    .btn-icon-only:hover { background-color: #f1f5f9; color: #0d6efd; border-color: #cbd5e1; }

    /* Modal Form Custom */
    .form-control, .form-select {
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        padding: 0.6rem 1rem;
        font-size: 0.95rem;
    }
    
    /* Footer */
    .page-footer {
        text-align: center;
        padding: 2rem 0;
        color: #94a3b8;
        font-size: 0.85rem;
    }
    .pagination { margin-bottom: 0; gap: 4px; }
    .page-item .page-link {
        border-radius: 8px !important;
        border: 1px solid #e2e8f0;
        color: #475569;
        padding: 0.4rem 0.85rem;
        font-size: 0.85rem;
    }
    .page-item.active .page-link { background-color: #3b82f6; border-color: #3b82f6; color: #fff; }
</style>

<div class="container-xl py-4">

    <!-- HEADER -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h3 class="fw-bold text-dark mb-1">Manajemen Stok</h3>
            <p class="text-muted mb-0">Monitor dan kelola tingkat inventaris.</p>
        </div>
        
        @if(Auth::user()->role === 'admin')
        <button class="btn btn-primary rounded-pill px-4 fw-semibold shadow-sm" data-bs-toggle="modal" data-bs-target="#tambahBarangModal">
            <i class="bi bi-plus-lg me-1"></i> New Stock Entry
        </button>
        @endif
    </div>

    <!-- CARDS  -->
    @php
        $totalBarang = $stokBarang->count();
        $hampirHabis = $stokBarang->filter(function($item) { return $item->jumlah_stok > 0 && $item->jumlah_stok <= ($item->minimum_stok ?? 5); })->count();
        $habis = $stokBarang->where('jumlah_stok', 0)->count();
    @endphp
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="card dashboard-card border-0 h-100 p-4">
                <div class="d-flex justify-content-between align-items-center h-100">
                    <div>
                        <p class="text-muted small fw-semibold mb-2">Jumlah Barang</p>
                        <h2 class="fw-bold text-dark mb-0">{{ $totalBarang }}</h2>
                    </div>
                    <div class="icon-box-summary bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-box"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card dashboard-card border-0 h-100 p-4">
                <div class="d-flex justify-content-between align-items-center h-100">
                    <div>
                        <p class="text-muted small fw-semibold mb-2">Hampir Habis</p>
                        <h2 class="fw-bold text-dark mb-0">{{ $hampirHabis }}</h2>
                    </div>
                    <div class="icon-box-summary bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card dashboard-card border-0 h-100 p-4">
                <div class="d-flex justify-content-between align-items-center h-100">
                    <div>
                        <p class="text-muted small fw-semibold mb-2">Habis</p>
                        <h2 class="fw-bold text-dark mb-0">{{ $habis }}</h2>
                    </div>
                    <div class="icon-box-summary bg-danger bg-opacity-10 text-danger">
                        <i class="bi bi-x-circle"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card dashboard-card border-0 h-100 p-4">
                <div class="d-flex justify-content-between align-items-center h-100">
                    <div>
                        <p class="text-muted small fw-semibold mb-2">Total Supplier</p>
                        <h2 class="fw-bold text-dark mb-0">8</h2>
                    </div>
                    <div class="icon-box-summary" style="background-color: #f3e8ff; color: #9333ea;">
                        <i class="bi bi-truck"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- QUICK STATUS SECTION -->
    <h6 class="fw-bold text-dark mb-3">Quick Status</h6>
    <div class="row g-4 mb-5">
        @foreach($stokBarang->take(3) as $qItem)
        @php
            $minStok = $qItem->minimum_stok ?? 10;
            $persen = ($qItem->jumlah_stok / ($minStok * 3)) * 100;
            $persen = $persen > 100 ? 100 : $persen;
            
            if($qItem->jumlah_stok <= 0) {
                $statusStr = 'Kritis'; $color = 'danger'; $bg = 'bg-danger';
            } elseif($qItem->jumlah_stok <= $minStok) {
                $statusStr = 'Warning'; $color = 'warning'; $bg = 'bg-warning';
            } else {
                $statusStr = 'Aman'; $color = 'success'; $bg = 'bg-success';
            }
        @endphp
        <div class="col-md-4">
            <div class="quick-status-card">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h6 class="fw-bold text-dark mb-0">{{ $qItem->nama_barang }}</h6>
                    <span class="badge badge-soft-{{ $color }} rounded-pill border">
                        <i class="bi bi-circle-fill status-dot"></i> {{ $statusStr }}
                    </span>
                </div>
                <div class="progress-line">
                    <div class="progress-bar-custom {{ $bg }}" style="width: {{ $persen }}%;"></div>
                </div>
                <div class="d-flex justify-content-between text-muted" style="font-size: 0.75rem;">
                    <span>Stok: {{ $qItem->jumlah_stok }} {{ $qItem->satuan }}</span>
                    <span>Min: {{ $minStok }} {{ $qItem->satuan }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- TABEL DAFTAR STOK LENGKAP -->
    <div class="card dashboard-card border-0 overflow-hidden mb-3">
        <!-- Toolbar Table -->
        <div class="card-header bg-white border-bottom border-light p-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <h5 class="mb-0 fw-bold text-dark d-flex align-items-center">
                <i class="bi bi-list-task text-primary me-2"></i>Daftar Stok Lengkap
            </h5>
            <div class="d-flex gap-2">
                <form action="" method="GET" class="search-wrapper m-0">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" name="search" class="form-control search-input" placeholder="Cari barang..." value="{{ request('search') }}">
                </form>
                <button class="filter-btn shadow-sm"><i class="bi bi-funnel"></i></button>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-custom table-borderless mb-0 align-middle">
                    <thead class="bg-white">
                        <tr>
                            <th class="ps-4">Nama Barang</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Minimum</th>
                            <th>Status</th>
                            <th>Update Terakhir</th>
                            @if(Auth::user()->role === 'admin')
                            <th class="text-center pe-4">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse($stokBarang as $item)
                        @php
                            $minStok = $item->minimum_stok ?? 10;
                            if($item->jumlah_stok <= 0) {
                                $status = 'Kritis'; $badge = 'badge-soft-danger';
                            } elseif($item->jumlah_stok <= $minStok) {
                                $status = 'Warning'; $badge = 'badge-soft-warning';
                            } else {
                                $status = 'Aman'; $badge = 'badge-soft-success';
                            }
                        @endphp
                        <tr>
                            <td class="ps-4 fw-bold text-dark">{{ $item->nama_barang }}</td>
                            <td>{{ $item->kategori ?? '-' }}</td>
                            <td class="fw-medium text-dark {{ $item->jumlah_stok <= $minStok ? 'text-danger' : '' }}">{{ $item->jumlah_stok }}</td>
                            <td>{{ $minStok }}</td>
                            <td>
                                <span class="badge {{ $badge }} rounded-pill border">
                                    <i class="bi bi-circle-fill status-dot"></i> {{ $status }}
                                </span>
                            </td>
                            <td class="text-muted small">
                                {{ $item->updated_at ? \Carbon\Carbon::parse($item->updated_at)->diffForHumans() : 'Hari ini' }}
                            </td>
                            
                            @if(Auth::user()->role === 'admin')
                            <td class="pe-4 text-center">
                                <button type="button" class="btn-icon-only" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}" title="Edit Stok">
                                    <i class="bi bi-pencil"></i>
                                </button>
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ Auth::user()->role === 'admin' ? 7 : 6 }}" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2 opacity-50"></i>
                                Belum ada data barang yang sesuai.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- FOOTER PAGINATION -->
        @if(method_exists($stokBarang, 'links'))
        <div class="card-footer bg-white border-top border-light p-4 d-flex flex-column flex-md-row justify-content-between align-items-center">
            <span class="text-muted small mb-3 mb-md-0 fw-medium">
                Showing {{ $stokBarang->firstItem() ?? 0 }} to {{ $stokBarang->lastItem() ?? 0 }} of {{ $stokBarang->total() }} entries
            </span>
            <div>
                {{ $stokBarang->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @else
        <div class="card-footer bg-white border-top border-light p-4 d-flex justify-content-between align-items-center">
            <span class="text-muted small fw-medium">Menampilkan {{ $stokBarang->count() }} data</span>
        </div>
        @endif
    </div>

    <footer class="page-footer">
        © 2026 1HZS Fotocopy & Print. Semua hak dilindungi.
    </footer>
</div>

<!-- MODAL TAMBAH & EDIT -->
@if(Auth::user()->role === 'admin')
<div class="modal fade" id="tambahBarangModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header border-bottom border-light px-4 py-3">
                <h5 class="modal-title fw-bold text-dark"><i class="bi bi-plus-lg text-primary me-2"></i>Tambah Barang Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ url('/stok-barang') }}" method="POST">
                @csrf
                <div class="modal-body px-4 py-3">
                    <div class="mb-3">
                        <label class="form-label text-muted small text-uppercase">Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small text-uppercase">Kategori</label>
                        <input type="text" name="kategori" class="form-control" placeholder="Contoh: Kertas, Tinta, ATK">
                    </div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label text-muted small text-uppercase">Stok Awal</label>
                            <input type="number" name="jumlah_stok" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small text-uppercase">Batas Min</label>
                            <input type="number" name="minimum_stok" class="form-control" placeholder="Misal: 10">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small text-uppercase">Satuan</label>
                            <input type="text" name="satuan" class="form-control" placeholder="Rim, Botol" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top border-light px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Simpan Barang</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@foreach($stokBarang as $item)
<div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header border-bottom border-light px-4 py-3">
                <h5 class="modal-title fw-bold text-dark"><i class="bi bi-pencil-square text-primary me-2"></i>Edit Stok Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ url('/stok-barang/'.$item->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body px-4 py-3">
                    <div class="mb-3">
                        <label class="form-label text-muted small text-uppercase">Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control" value="{{ $item->nama_barang }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted small text-uppercase">Kategori</label>
                        <input type="text" name="kategori" class="form-control" value="{{ $item->kategori }}" required>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label text-muted small text-uppercase">Stok Saat Ini</label>
                            <input type="number" name="jumlah_stok" class="form-control" value="{{ $item->jumlah_stok }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small text-uppercase">Batas Min</label>
                            <input type="number" name="minimum_stok" class="form-control" value="{{ $item->minimum_stok ?? 10 }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small text-uppercase">Satuan</label>
                            <input type="text" name="satuan" class="form-control" value="{{ $item->satuan }}" required>
                        </div>
                    </div>
                    
                    @if(Auth::user()->role === 'admin')
                    <div class="mt-4 pt-3 border-top border-light text-end">
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="if(confirm('Yakin ingin menghapus barang ini?')) { document.getElementById('deleteForm{{ $item->id }}').submit(); }">
                            <i class="bi bi-trash me-1"></i> Hapus Barang Ini
                        </button>
                    </div>
                    @endif
                </div>
                <div class="modal-footer border-top border-light px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Simpan Perubahan</button>
                </div>
            </form>
            
            @if(Auth::user()->role === 'admin')
            <form id="deleteForm{{ $item->id }}" action="{{ url('/stok-barang/'.$item->id) }}" method="POST" class="d-none">
                @csrf
                @method('DELETE')
            </form>
            @endif
        </div>
    </div>
</div>
@endforeach

@endsection