@extends('layout.app')

@section('title', 'Manajemen Transaksi')

@section('content')
<div class="card bg-dark border-secondary shadow-sm rounded-4">
    <div class="card-header border-secondary d-flex justify-content-between align-items-center py-3 px-4">
        <h5 class="mb-0 text-white fw-semibold">
            <i class="bi bi-cart-check-fill text-primary me-2"></i>Daftar Transaksi
        </h5>
        
        @if(Auth::user()->role === 'kasir')
            <button class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm d-flex align-items-center gap-2">
                <i class="bi bi-plus-circle"></i> Transaksi Baru
            </button>
        @endif
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-dark table-hover mb-0 align-middle">
                <thead class="table-active">
                    <tr>
                        <th class="px-4 py-3" style="width: 15%;">ID Transaksi</th>
                        <th class="py-3" style="width: 15%;">Tanggal</th>
                        <th class="py-3" style="width: 25%;">Pelanggan</th>
                        <th class="py-3" style="width: 20%;">Total Belanja</th>
                        <th class="py-3" style="width: 10%;">Status</th>
                        <th class="px-4 py-3 text-center" style="width: 15%;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="border-top-0">
                    @foreach($transaksi as $item)
                        <tr>
                            <td class="px-4 fw-bold text-primary">#TRX-001</td>
                            <td class="text-secondary">18 Jul 2026</td>
                            <td>Budi Santoso</td>
                            <td class="fw-medium">Rp 45.000</td>
                            <td>
                                <span class="badge bg-success bg-opacity-10 text-success border border-success px-3 py-2 rounded-pill">
                                    Selesai
                                </span>
                            </td>
                            <td class="px-4 text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    
                                    <button class="btn btn-sm btn-outline-info rounded-3" title="Detail Transaksi">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    
                                    <button class="btn btn-sm btn-outline-warning rounded-3" title="Edit Transaksi">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <!-- Tombol Delete (D) - HANYA UNTUK ADMIN -->
                                    @if(Auth::user()->role === 'admin')
                                        <!-- Form Delete diarahkan ke route transaksi.delete -->
                                        <form action="#" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-3" title="Hapus Transaksi" onclick="return confirm('Yakin ingin menghapus data transaksi ini secara permanen?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection