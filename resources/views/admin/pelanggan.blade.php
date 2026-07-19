@extends('layout.app') 

@section('title', 'Manajemen Pelanggan')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Data Pelanggan</h2>
        <!-- Tombol Kembali ke Karyawan -->
        <a href="{{ url('/operator') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Karyawan
        </a>
    </div>

    <div class="card shadow-sm border-secondary">
        <div class="card-header border-secondary">
            <h5 class="mb-0">Riwayat Pelanggan Terdaftar</h5>
        </div>
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pelanggan</th>
                        <th>No. HP</th>
                        <th>Alamat</th>
                        <th>Tgl Terdaftar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelanggans as $index => $pel)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="fw-bold">{{ $pel->nama }}</td>
                        <td>{{ $pel->no_hp }}</td>
                        <td>{{ $pel->alamat }}</td>
                        <td>{{ \Carbon\Carbon::parse($pel->created_at)->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Belum ada data pelanggan yang tersimpan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection