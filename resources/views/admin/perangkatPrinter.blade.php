@extends('layout.app')

@section('title', 'Manajemen Printer')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-white">Daftar Perangkat Printer</h4>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahPrinterModal">
            <i class="bi bi-plus-lg me-1"></i> Tambah Printer
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
                        <th>Nama Printer</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($printer as $index => $p)
                    <tr>
                        <td class="ps-4">{{ $index + 1 }}</td>
                        <td>{{ $p->nama_printer }}</td>
                        <td>
                            <span class="badge {{ $p->status == 'Aktif' ? 'bg-success' : 'bg-danger' }}">
                                {{ $p->status }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <button class="btn btn-sm btn-warning me-2" onclick="editPrinter(this)" data-item='@json($p)'>
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <form action="{{ route('printer.delete', $p->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus printer ini?')">
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
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="tambahPrinterModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark border-secondary text-light">
            <div class="modal-header border-secondary">
                <h5 class="modal-title">Tambah Printer</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('printer.create') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Printer</label>
                        <input type="text" name="nama_printer" class="form-control bg-dark text-light border-secondary" required>
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" class="form-select bg-dark text-light border-secondary">
                            <option value="Aktif">Aktif</option>
                            <option value="Perbaikan">Perbaikan</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="editPrinterModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark border-secondary text-light">
            <div class="modal-header border-secondary">
                <h5 class="modal-title">Edit Printer</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEditPrinter" method="POST">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Printer</label>
                        <input type="text" name="nama_printer" id="editNama" class="form-control bg-dark text-light border-secondary" required>
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" id="editStatus" class="form-select bg-dark text-light border-secondary">
                            <option value="Aktif">Aktif</option>
                            <option value="Perbaikan">Perbaikan</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function editPrinter(button) {
        const p = JSON.parse(button.getAttribute('data-item'));
        document.getElementById('editNama').value = p.nama_printer;
        document.getElementById('editStatus').value = p.status;
        document.getElementById('formEditPrinter').action = `/printer/${p.id}`;
        new bootstrap.Modal(document.getElementById('editPrinterModal')).show();
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