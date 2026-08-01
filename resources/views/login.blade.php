<!DOCTYPE html>
<html lang="id" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - POS Fotocopy & Print</title>
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/3063/3063822.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #121212;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background-color: #1e1e1e;
            border: 1px solid #333;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            overflow: hidden;
            width: 100%;
            max-width: 400px;
        }

        .form-control:focus {
            background-color: #2b2b2b;
            border-color: #0d6efd;
            color: white;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center">
        <div class="login-card p-4 p-sm-5">

            <!-- Logo & Title -->
            <div class="text-center mb-4">
                <div class="bg-primary text-white d-inline-flex justify-content-center align-items-center rounded-circle mb-3" style="width: 60px; height: 60px;">
                    <i class="bi bi-printer fs-3"></i>
                </div>
                <h4 class="fw-bold text-white mb-1">POS <span class="text-primary">Fotocopy</span></h4>
                <p class="text-muted small">Silakan login untuk mengakses sistem</p>
            </div>

            @if(session('success'))
            <div class="alert alert-success border-0 small py-2 d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
            </div>
            @endif

            <!-- Pesan Error -->
            @if($errors->any())
            <div id="error-alert" class="alert alert-danger border-0 small py-2 d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ $errors->first() }}
            </div>
            @endif

            <!-- Form Login -->
            <form action="{{ url('/login') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label text-muted small fw-bold text-uppercase">Alamat Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-secondary text-muted">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input type="email" name="email" class="form-control bg-dark text-light border-secondary" value="{{ old('email') }}" placeholder="admin@contoh.com" required autofocus>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label text-muted small fw-bold text-uppercase">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark border-secondary text-muted">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input type="password" name="password" class="form-control bg-dark text-light border-secondary" placeholder="Masukkan password" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 fw-bold py-2">
                    Login <i class="bi bi-box-arrow-in-right ms-1"></i>
                </button>

                <div class="d-flex align-items-center my-4">
                    <hr class="flex-grow-1 border-secondary">
                    <span class="mx-3 text-secondary" style="font-size: 0.9rem;">ATAU</span>
                    <hr class="flex-grow-1 border-secondary">
                </div>

                <a href="{{ route('google.login') }}" class="btn btn-outline-light w-100 py-2 fw-bold d-flex align-items-center justify-content-center" style="border-color: #4285F4;">
                    <i class="bi bi-google me-2" style="color: #4285F4; font-size: 1.2rem;"></i>
                    Masuk dengan Google
                </a>

                <!-- <div class="text-center mt-4">
                    <small class="text-muted">Belum punya akun? <a href="{{ url('/register') }}" class="text-primary text-decoration-none">Daftar di sini</a></small>
                </div> -->
            </form>
        </div>
    </div>

    <!-- Laert Notif -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');

            alerts.forEach(function(alertElement) {
                setTimeout(function() {
                    alertElement.style.transition = 'opacity 0.5s ease';
                    alertElement.style.opacity = '0';

                    setTimeout(() => alertElement.remove(), 500);
                }, 3000);
            });
        });
    </script>
</body>

</html>