@extends('layout.app')

@section('title', 'Manajemen Layanan')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-white">Daftar Layanan</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahLayananModal">
            <i class="bi bi-plus-lg me-1"></i> Tambah Layanan
        </button>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" id="myAlert" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card bg-dark border-secondary">
        <div class="card-body p-0">
            <table class="table table-dark table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">No</th>
                        <th>Nama Layanan</th>
                        <th>Harga per Lembar</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($layanan as $index => $item)
                    <tr>
                        <td class="ps-4">{{ $index + 1 }}</td>
                        <td>{{ $item->nama_layanan }}</td>
                        <td>Rp {{ number_format($item->harga_per_lembar, 0, ',', '.') }}</td>
                        <td class="text-end pe-4">
                            <!-- <button class="btn btn-sm btn-warning me-2" onclick="editLayanan({{ $item }})"> -->
                            <button class="btn btn-sm btn-warning me-2" onclick="editLayanan(this)" data-item='@json($item)'>
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <form action="{{ route('layanan.delete', $item->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus layanan ini?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Tambah Layanan -->
    <div class="modal fade" id="tambahLayananModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark border-secondary text-light">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title fw-bold">Tambah Layanan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('layanan.create') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Layanan</label>
                            <input type="text" name="nama_layanan" class="form-control bg-dark text-light border-secondary" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga per Lembar (Rp)</label>
                            <input type="number" name="harga_per_lembar" class="form-control bg-dark text-light border-secondary" required>
                        </div>
                    </div>
                    <div class="modal-footer border-secondary">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary fw-bold">Simpan Layanan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Layanan -->
    <div class="modal fade" id="editLayananModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark border-secondary text-light">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title fw-bold">Edit Layanan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <form id="formEditLayanan" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Layanan</label>
                            <input type="text" name="nama_layanan" id="editNama" class="form-control bg-dark text-light border-secondary" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga per Lembar (Rp)</label>
                            <input type="number" name="harga_per_lembar" id="editHarga" class="form-control bg-dark text-light border-secondary" required>
                        </div>
                    </div>
                    <div class="modal-footer border-secondary">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary fw-bold">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function editLayanan(button) {
        const item = JSON.parse(button.getAttribute('data-item'));

        document.getElementById('editNama').value = item.nama_layanan;
        document.getElementById('editHarga').value = item.harga_per_lembar;

        document.getElementById('formEditLayanan').action = `/layanan/${item.id}`;

        var myModal = new bootstrap.Modal(document.getElementById('editLayananModal'));
        myModal.show();
    }
    
    setTimeout(function() {
        var alertElement = document.getElementById('myAlert');
        if (alertElement) {
            var alert = new bootstrap.Alert(alertElement);
            alert.close();
        }
    }, 3000);
</script>
@endsection