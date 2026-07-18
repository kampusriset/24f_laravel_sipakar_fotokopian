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
                <button class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#tambahBarangModal">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Barang
                </button>
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
                                <th class="py-3">Harga Satuan</th>
                                <th class="px-4 py-3 text-center" style="width: 15%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            {{-- @forelse digunakan agar aman, tidak error jika data kosong --}}
                            @forelse($stokBarang as $item)
                            <tr>
                                <td class="px-4 text-white fw-medium">{{ $item->nama_barang }}</td>
                                <td class="text-secondary">{{ $item->kategori ?? '-' }}</td>
                                <td class="text-center">
                                    <span class="badge {{ $item->stok < 5 ? 'bg-danger' : 'bg-success' }} bg-opacity-10 text-white border px-3 rounded-pill">
                                        {{ $item->stok }}
                                    </span>
                                </td>
                                <td class="text-white">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                <td class="px-4 text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <button class="btn btn-sm btn-outline-warning rounded-3" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger rounded-3" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
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
@endsection