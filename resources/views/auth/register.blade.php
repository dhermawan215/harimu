<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar — {{ config('app.name', 'Harimu') }}</title>

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
                <div class="col-md-8 col-lg-6">
                    <div class="text-center mb-4">
                        <a href="/" class="navbar-brand-name fs-3 text-decoration-none">
                            <i class="bi bi-heart-fill me-1"></i>Harimu
                        </a>
                    </div>
                    <div class="auth-card bg-white p-4 p-md-5">
                        <h3 class="fw-bold text-center mb-1">Buat Akun Baru</h3>
                        <p class="text-secondary text-center mb-4">Mulai buat undangan pernikahan digitalmu</p>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-medium">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                    class="form-control form-control-lg @error('name') is-invalid @enderror"
                                    required autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-medium">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="form-control form-control-lg @error('email') is-invalid @enderror"
                                    required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-medium">Nomor WhatsApp</label>
                                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx"
                                    class="form-control form-control-lg @error('phone') is-invalid @enderror"
                                    required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-medium">Kata Sandi</label>
                                    <div class="input-group">
                                        <input type="password" name="password" id="password"
                                            class="form-control form-control-lg @error('password') is-invalid @enderror"
                                            required>
                                        <button class="btn btn-outline-brand" type="button" tabindex="-1" data-toggle-password="#password">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-medium">Ulangi Kata Sandi</label>
                                    <div class="input-group">
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            class="form-control form-control-lg" required>
                                        <button class="btn btn-outline-brand" type="button" tabindex="-1" data-toggle-password="#password_confirmation">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-brand btn-lg w-100 rounded-pill mt-2">Daftar Gratis</button>
                        </form>

                        <p class="text-center text-secondary mt-4 mb-0">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="text-brand fw-semibold text-decoration-none">Masuk di sini</a>
                        </p>
                    </div>
                    <p class="text-center mt-4">
                        <a href="/" class="text-secondary text-decoration-none small">
                            <i class="bi bi-arrow-left me-1"></i>Kembali ke beranda
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @include('partials.password-toggle-script')
</body>
</html>
