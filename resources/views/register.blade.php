<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - POS Fotocopy & Print</title>
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/3063/3063822.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #121212; 
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
        }
        .register-card {
            background-color: #1e1e1e;
            border: 1px solid #333;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            width: 100%;
            max-width: 450px;
        }
        .form-control:focus, .form-select:focus {
            background-color: #2b2b2b;
            border-color: #0d6efd;
            color: white;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }
    </style>
</head>
<body>

    <div class="container d-flex justify-content-center">
        <div class="register-card p-4 p-sm-5">
            
            <div class="text-center mb-4">
                <h4 class="fw-bold text-white mb-1">Buat <span class="text-primary">Akun</span> Baru</h4>
                <p class="text-muted small">Daftarkan akun Admin atau Kasir untuk POS</p>
            </div>

            @if($errors->any())
                <div id="error-alert" class="alert alert-danger border-0 small py-2">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ url('/register') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold text-uppercase">Nama Lengkap</label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-secondary text-muted"><i class="bi bi-person"></i></span>
                        <input type="text" name="name" class="form-control bg-dark text-light border-secondary" placeholder="Masukkan nama" value="{{ old('name') }}" required autofocus>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold text-uppercase">Alamat Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-secondary text-muted"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" class="form-control bg-dark text-light border-secondary" placeholder="email@contoh.com" value="{{ old('email') }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold text-uppercase">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-secondary text-muted"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" class="form-control bg-dark text-light border-secondary" placeholder="Minimal 6 karakter" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label text-muted small fw-bold text-uppercase">Pilih Jabatan (Role)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-secondary text-muted"><i class="bi bi-shield-lock"></i></span>
                        <select name="role" class="form-select bg-dark text-light border-secondary" required>
                            <option value="" disabled selected>-- Pilih Hak Akses --</option>
                            <option value="kasir">Kasir (Transaksi & Riwayat)</option>
                            <option value="admin">Admin (Akses Penuh)</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 fw-bold py-2 mb-3">
                    Daftar Akun <i class="bi bi-person-plus ms-1"></i>
                </button>

                <div class="text-center">
                    <small class="text-muted">Sudah punya akun? <a href="{{ url('/login') }}" class="text-primary text-decoration-none">Login di sini</a></small>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const alertElement = document.getElementById('error-alert');
            
            if (alertElement) {
                setTimeout(function () {
                    alertElement.style.transition = 'opacity 0.3s ease';
                    alertElement.style.opacity = '0';
                    
                    setTimeout(() => alertElement.remove(), 500); 
                }, 3000);
            }
        });
    </script>
</body>
</html>