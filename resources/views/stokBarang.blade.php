@extends('layout.app')

@section('title', 'Manajemen Stok Barang')

@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="card bg-dark border-secondary shadow-sm rounded-4">

            <!-- Header -->
            <div class="card-header border-secondary d-flex justify-content-between align-items-center py-3 px-4">
                <h5 class="mb-0 text-white fw-semibold">
                    <i class="bi bi-box-seam text-info me-2"></i>Daftar Stok Barang
                </h5>

                <!-- HANYA ADMIN YANG BISA TAMBAH BARANG -->
                @if(Auth::user()->role === 'admin')
                <button class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#tambahBarangModal">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Barang
                </button>
                @endif
            </div>

            <!-- Tabel -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-dark table-hover mb-0 align-middle">
                        <thead class="table-active">
                            <tr>
                                <th class="px-4 py-3">Nama Barang</th>
                                <th class="py-3">Kategori</th>
                                <th class="py-3 text-center">Stok</th>
                                <th class="py-3">Satuan Barang</th>
                                <th class="px-4 py-3 text-center" style="width: 15%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            @forelse($stokBarang as $item)
                            <tr>
                                <td class="px-4 text-white fw-medium">{{ $item->nama_barang }}</td>
                                <td class="text-secondary">{{ $item->kategori ?? '-' }}</td>
                                <td class="text-center">
                                    <span class="badge {{ $item->jumlah_stok < 5 ? 'bg-danger' : 'bg-success' }} bg-opacity-10 text-white border px-3 rounded-pill">
                                        {{ $item->jumlah_stok }}
                                    </span>
                                </td>
                                <td class="text-white">{{ $item->satuan }}</td>
                                <td class="px-4 text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button type="button" class="btn btn-sm btn-outline-warning rounded-3" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}" title="Edit Stok">
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        @if(Auth::user()->role === 'admin')
                                        <form action="{{ url('/stok-barang/'.$item->id) }}" method="POST" class="m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-3" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-secondary">
                                    <i class="bi bi-inbox fs-2 d-block mb-2 opacity-50"></i>
                                    Belum ada data barang tersedia.
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

<!-- ================= MODAL TAMBAH BARANG (Khusus Admin) ================= -->
@if(Auth::user()->role === 'admin')
<div class="modal fade" id="tambahBarangModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark border-secondary shadow-lg rounded-4">
            <div class="modal-header border-secondary">
                <h5 class="modal-title text-white fw-bold"><i class="bi bi-plus-circle text-primary me-2"></i>Tambah Barang Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ url('/stok-barang') }}" method="POST">
                @csrf
                <div class="modal-body text-start px-4 py-3">
                    <div class="mb-3">
                        <label class="text-secondary small mb-1 text-uppercase fw-semibold">Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control bg-dark text-white border-secondary shadow-none" required>
                    </div>
                    <div class="mb-3">
                        <label class="text-secondary small mb-1 text-uppercase fw-semibold">Kategori</label>
                        <input type="text" name="kategori" class="form-control bg-dark text-white border-secondary shadow-none">
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="text-secondary small mb-1 text-uppercase fw-semibold">Stok Awal</label>
                            <input type="number" name="jumlah_stok" class="form-control bg-dark text-white border-secondary shadow-none" required>
                        </div>
                        <div class="col-md-6">
                            <label class="text-secondary small mb-1 text-uppercase fw-semibold">Satuan Barang</label>
                            <input type="text" name="satuan" class="form-control bg-dark text-white border-secondary shadow-none" placeholder="Contoh: Lembar, Pcs, Rim" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-3 px-4">Simpan Barang</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- ================= KUMPULAN MODAL EDIT BARANG ================= -->
@foreach($stokBarang as $item)
<div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark border-secondary shadow-lg rounded-4">
            <div class="modal-header border-secondary">
                <h5 class="modal-title text-white fw-bold"><i class="bi bi-pencil text-warning me-2"></i>Edit Stok Barang</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ url('/stok-barang/'.$item->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body text-start px-4 py-3">
                    <div class="mb-3">
                        <label class="text-secondary small mb-1 text-uppercase fw-semibold">Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control bg-dark text-white border-secondary shadow-none" value="{{ $item->nama_barang }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="text-secondary small mb-1 text-uppercase fw-semibold">Kategori</label>
                        <input type="text" name="kategori" class="form-control bg-dark text-white border-secondary shadow-none" value="{{ $item->kategori }}" required>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="text-secondary small mb-1 text-uppercase fw-semibold">Jumlah Stok</label>
                            <input type="number" name="jumlah_stok" class="form-control bg-dark text-white border-secondary shadow-none" value="{{ $item->jumlah_stok }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="text-secondary small mb-1 text-uppercase fw-semibold">Satuan Barang</label>
                            <input type="text" name="satuan" class="form-control bg-dark text-white border-secondary shadow-none" value="{{ $item->satuan }}" required>
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
@endsection