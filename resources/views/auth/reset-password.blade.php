<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Atur Ulang Kata Sandi — {{ config('app.name', 'Harimu') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    @include('partials.brand-styles')
</head>
<body>
    <div class="auth-page py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7 col-lg-5">
                    <div class="text-center mb-4">
                        <a href="/" class="navbar-brand-name fs-3 text-decoration-none">
                            <i class="bi bi-heart-fill me-1"></i>Harimu
                        </a>
                    </div>
                    <div class="auth-card bg-white p-4 p-md-5">
                        <h3 class="fw-bold text-center mb-1">Buat Kata Sandi Baru</h3>
                        <p class="text-secondary text-center mb-4">Masukkan kata sandi baru untuk akun Anda.</p>

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="mb-3">
                                <label class="form-label fw-medium">Kata Sandi Baru</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="password"
                                        class="form-control form-control-lg @error('password') is-invalid @enderror"
                                        required autofocus>
                                    <button class="btn btn-outline-brand" type="button" tabindex="-1" data-toggle-password="#password">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-medium">Ulangi Kata Sandi Baru</label>
                                <div class="input-group">
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control form-control-lg" required>
                                    <button class="btn btn-outline-brand" type="button" tabindex="-1" data-toggle-password="#password_confirmation">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-brand btn-lg w-100 rounded-pill">Simpan Kata Sandi</button>
                        </form>

                        <p class="text-center text-secondary mt-4 mb-0">
                            <a href="{{ route('login') }}" class="text-brand fw-semibold text-decoration-none">Kembali ke halaman masuk</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @include('partials.password-toggle-script')
</body>
</html>
