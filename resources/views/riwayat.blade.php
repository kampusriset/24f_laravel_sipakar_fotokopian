@extends('layout.app')

@section('title', 'Riwayat Transaksi')

@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="card bg-dark border-secondary shadow-sm rounded-4">
            <!-- Header -->
            <div class="card-header border-secondary py-3 px-4 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-white fw-semibold">
                    <i class="bi bi-clock-history text-info me-2"></i>Riwayat Transaksi Selesai
                </h5>
                <span class="badge bg-secondary bg-opacity-25 text-light px-3 py-2 border border-secondary">
                    Total: {{ $riwayatTransaksi->count() }} Data
                </span>
            </div>

            <!-- Tabel Riwayat -->
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-dark table-hover mb-0 align-middle">
                        <thead class="table-active">
                            <tr>
                                <th class="px-4 py-3">Pelanggan</th>
                                <th class="py-3">Layanan</th>
                                <th class="py-3 text-center">Halaman</th>
                                <th class="py-3">Total Harga</th>
                                <th class="py-3 text-center">Status</th>
                                <th class="px-4 py-3 text-center" style="width: 15%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            @forelse($riwayatTransaksi as $trx)
                            <tr>
                                <td class="px-4 text-white fw-medium">{{ $trx->nama_pelanggan }}</td>
                                <td class="text-secondary">{{ $trx->nama_layanan }}</td>
                                <td class="text-center">{{ $trx->jumlah_halaman }}</td>
                                <td class="text-white">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success px-3 rounded-pill">
                                        {{ $trx->status_antrean }}
                                    </span>
                                </td>
                                <td class="px-4 text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <!-- Tombol Edit (Memanggil Modal) -->
                                        <!-- <button type="button" class="btn btn-sm btn-outline-primary rounded-3" data-bs-toggle="modal" data-bs-target="#editModal{{ $trx->id_transaksi }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button> -->

                                        <!-- Hapus Data -->
                                        @if(Auth::user()->role === 'admin')
                                        <form action="{{ url('/transaksi/'.$trx->id_transaksi) }}" method="POST" class="m-0" onsubmit="return confirm('Yakin hapus data ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-3">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-secondary">
                                    <i class="bi bi-inbox fs-2 d-block mb-2 opacity-50"></i>
                                    Belum ada riwayat transaksi.
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

<!-- MODAL EDIT (Diletakkan di bawah tabel agar tidak mengganggu layout) -->
@foreach($riwayatTransaksi as $trx)
<div class="modal fade" id="editModal{{ $trx->id_transaksi }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ url('/transaksi/'.$trx->id_transaksi) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-content bg-dark text-white border-secondary">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title">Edit Transaksi: {{ $trx->nama_pelanggan }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Jumlah Halaman</label>
                        <input type="number" name="jumlah_halaman" class="form-control bg-secondary text-white" value="{{ $trx->jumlah_halaman }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Total Harga</label>
                        <input type="number" name="total_harga" class="form-control bg-secondary text-white" value="{{ $trx->total_harga }}" required>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach

@endsection