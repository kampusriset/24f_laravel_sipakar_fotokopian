@extends('layout.app')

@section('title', 'Profil')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <h3 class="fw-bold mb-4">Pengaturan Profil</h3>

            <div class="col-12 mb-0">
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

                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
            </div>

            <div class="card shadow border-secondary">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4 pb-3 border-bottom border-secondary">
                        <i class="bi bi-person-circle text-secondary me-3" style="font-size: 4rem;"></i>
                        <div>
                            <h4 class="fw-bold mb-1">{{ $user->operator->name ?? 'Nama Pengguna' }}</h4>
                            <span class="badge bg-primary">{{ strtoupper($user->role) }}</span>
                        </div>
                    </div>

                    <form action="{{ route('profil.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label text-muted">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="{{ $user->operator->name ?? '' }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted">Email Akses</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                            @error('email')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted">Password Baru</label>
                            <input type="password" name="password" class="form-control" minlength="6" placeholder="Kosongkan jika tidak ingin mengubah password">
                            <small class="text-secondary mt-1 d-block">Minimal 6 karakter.</small>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary fw-bold py-2">
                                Simpan Perubahan Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    setTimeout(function() {
        var alertElement = document.getElementById('myAlert');
        if (alertElement) {
            var alert = new bootstrap.Alert(alertElement);
            alert.close();
        }
    }, 3000);
</script>
@endsection