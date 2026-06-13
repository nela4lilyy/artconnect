<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin – ArtConnect</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; background: #f4f5f7; min-height: 100vh; display: flex; align-items: center; }
        .login-card { border: none; border-radius: 20px; box-shadow: 0 8px 40px rgba(0,0,0,.12); max-width: 420px; width: 100%; }
        .login-brand { font-family: 'Playfair Display', serif; font-size: 2rem; color: #6F42C1; }
        .btn-login { background: #6F42C1; border-color: #6F42C1; font-weight: 600; padding: .75rem; border-radius: 10px; }
        .btn-login:hover { background: #5a34a3; border-color: #5a34a3; }
        .form-control { border-radius: 10px; padding: .7rem 1rem; border-color: #e0e0e0; }
        .form-control:focus { border-color: #6F42C1; box-shadow: 0 0 0 .2rem rgba(111,66,193,.15); }
        .form-label { font-weight: 500; font-size: .88rem; color: #555; }
        .input-group-text { border-radius: 10px 0 0 10px; border-color: #e0e0e0; background: #f8f9fa; color: #888; }
        .input-group .form-control { border-radius: 0 10px 10px 0; }
    </style>
</head>
<body>
<div class="container">
    <div class="d-flex justify-content-center">
        <div class="login-card card p-4 p-md-5">
            <div class="text-center mb-4">
                <div class="login-brand"><i class="bi bi-palette2 me-2"></i>ArtConnect</div>
                <p class="text-muted small mt-1">Panel Administrasi</p>
            </div>

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3" style="border-radius:10px;font-size:.85rem">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" placeholder="admin@artconnect.com">
                    </div>
                    @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                               placeholder="••••••••">
                    </div>
                    @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4 d-flex align-items-center justify-content-between">
                    <div class="form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label small" for="remember">Ingat saya</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-login w-100 text-white">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                </button>
            </form>

            <div class="text-center mt-4">
                <a href="{{ route('home') }}" class="text-muted small text-decoration-none">
                    <i class="bi bi-arrow-left me-1"></i>Kembali ke website
                </a>
            </div>
        </div>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
