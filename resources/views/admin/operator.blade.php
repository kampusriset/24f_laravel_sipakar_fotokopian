@extends('layout.app')

@section('title', 'Manajemen Operator')

@section('content')
<div class="container">
    <!-- Header Bagian Atas -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Manajemen Karyawan</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahOperatorModal" style="transition: all 0.3s ease;">
            + Tambah Karyawan
        </button>
    </div>

    <!-- Menampilkan Pesan Sukses/Error -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" id="myAlert" role="alert">
        {{ session('success') }}
    </div>
    @endif
    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" id="myAlert" role="alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Tabel Daftar Karyawan -->
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($operators as $index => $op)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $op->operator?->name ?? 'Belum ada nama' }}</td>
                        <td>{{ $op->email }}</td>
                        <td>
                            <span class="badge bg-secondary">{{ strtoupper($op->role) }}</span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $op->id }}">
                                Edit
                            </button>

                            <form action="{{ route('operator.delete', $op->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus karyawan ini?')">Hapus</button>
                            </form>

                            <!-- ================= MODAL EDIT UNTUK KARYAWAN INI ================= -->
                            <div class="modal fade" id="editModal{{ $op->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content text-start">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Data: {{ $op->nama }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <form action="{{ route('operator.update', $op->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Nama Lengkap</label>
                                                    <input type="text" name="name" class="form-control" value="{{ $op->name }}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Email Karyawan</label>
                                                    <input type="email" name="email" class="form-control" value="{{ $op->email }}" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Jabatan (Role)</label>
                                                    <select name="role" class="form-select" required>
                                                        <option value="kasir" {{ $op->role == 'kasir' ? 'selected' : '' }}>Kasir</option>
                                                        <option value="admin" {{ $op->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Reset Password <span class="text-muted" style="font-size: 0.8em;">(Kosongkan jika tidak diubah)</span></label>
                                                    <input type="password" name="password" class="form-control" minlength="6" placeholder="Ketik password baru di sini...">
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-warning text-dark fw-bold">Update Data</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH KARYAWAN -->
<div class="modal fade" id="tambahOperatorModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Tambah Karyawan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('operator.create') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Karyawan</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password Sementara</label>
                        <input type="password" name="password" class="form-control" required minlength="6">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jabatan (Role)</label>
                        <select name="role" class="form-select" required>
                            <option value="kasir">Kasir</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(function() {
            var alertElement = document.getElementById('myAlert');
            if (alertElement) {
                var bsAlert = new bootstrap.Alert(alertElement);
                bsAlert.close();
            }
        }, 3000);
    });
</script>
@endsection