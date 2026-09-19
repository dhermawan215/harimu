<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | Harimu Admin</title>

    <link rel="stylesheet" href="{{ asset('adminhmd-1.0.0/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminhmd-1.0.0/assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('adminhmd-1.0.0/assets/css/style.css') }}">
</head>
<body>
    <div class="admin-shell">
        <div class="sidebar-backdrop" data-sidebar-close></div>

        <aside class="admin-sidebar" id="adminSidebar" aria-label="Main navigation">
            <div class="sidebar-header">
                <a class="brand-mark" href="{{ route('admin.dashboard') }}" aria-label="Harimu admin dashboard">
                    <span class="brand-icon"><i class="bi bi-heart-fill" aria-hidden="true"></i></span>
                    <span class="brand-copy">
                        <span class="brand-title">Harimu</span>
                        <span class="brand-subtitle">Admin Panel</span>
                    </span>
                </a>
            </div>

            <nav class="sidebar-nav">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <span class="nav-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
                    <span class="nav-text">Dashboard</span>
                </a>
                <a class="nav-link" href="#">
                    <span class="nav-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
                    <span class="nav-text">Pengguna</span>
                </a>
                <a class="nav-link" href="#">
                    <span class="nav-icon"><i class="bi bi-easel" aria-hidden="true"></i></span>
                    <span class="nav-text">Template</span>
                </a>
                <a class="nav-link" href="#">
                    <span class="nav-icon"><i class="bi bi-box-seam" aria-hidden="true"></i></span>
                    <span class="nav-text">Paket</span>
                </a>
                <a class="nav-link" href="#">
                    <span class="nav-icon"><i class="bi bi-receipt" aria-hidden="true"></i></span>
                    <span class="nav-text">Transaksi</span>
                </a>
                <a class="nav-link" href="#">
                    <span class="nav-icon"><i class="bi bi-quote" aria-hidden="true"></i></span>
                    <span class="nav-text">Kata &amp; Ayat</span>
                </a>
                <a class="nav-link" href="#">
                    <span class="nav-icon"><i class="bi bi-gear" aria-hidden="true"></i></span>
                    <span class="nav-text">Pengaturan</span>
                </a>
            </nav>

            <div class="sidebar-user">
                <img class="avatar-img avatar-md sidebar-user-avatar" src="{{ asset('adminhmd-1.0.0/assets/images/avatar/avatar.jpg') }}" alt="{{ auth()->user()->name }}">
                <strong>{{ auth()->user()->name }}</strong>
                <small>Administrator</small>
            </div>

            <div class="sidebar-footer">
                <span class="status-dot"></span>
                <span class="sidebar-footer-text">Sistem berjalan normal</span>
            </div>
        </aside>

        <div class="admin-main">
            <nav class="navbar admin-navbar navbar-expand bg-white">
                <div class="container-fluid px-3 px-lg-4">
                    <button class="sidebar-toggle" type="button" data-sidebar-toggle aria-controls="adminSidebar" aria-expanded="true" aria-label="Toggle sidebar">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>

                    <form class="d-none d-md-flex ms-3 flex-grow-1" role="search">
                        <input class="form-control search-input" type="search" placeholder="Cari pengguna, undangan, transaksi" aria-label="Search">
                    </form>

                    <div class="navbar-actions ms-auto">
                        <button class="icon-button theme-toggle" type="button" data-theme-toggle aria-label="Switch color theme" title="Switch color theme">
                            <i class="bi bi-moon-stars" data-theme-icon aria-hidden="true"></i>
                        </button>

                        <div class="dropdown">
                            <button class="profile-button dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <img class="avatar-img avatar-sm" src="{{ asset('adminhmd-1.0.0/assets/images/avatar/avatar.jpg') }}" alt="{{ auth()->user()->name }}">
                                <span class="profile-name d-none d-sm-inline">{{ auth()->user()->name }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Keluar</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <main class="dashboard-content">
                <div class="container-fluid px-3 px-lg-4 py-4">
                    <div class="page-heading">
                        <div class="page-heading-copy">
                            <span class="page-icon"><i class="bi @yield('page-icon', 'bi-speedometer2')" aria-hidden="true"></i></span>
                            <div>
                                <p class="eyebrow mb-1">@yield('page-eyebrow', 'Overview')</p>
                                <h1 class="h3 mb-1">@yield('page-title', 'Dashboard')</h1>
                                <p class="text-muted mb-0">@yield('page-description', '')</p>
                            </div>
                        </div>
                    </div>

                    @yield('content')
                </div>
            </main>

            <footer class="admin-footer">
                <div class="container-fluid px-3 px-lg-4">
                    <span>&copy; {{ date('Y') }} Harimu. Panel administrasi internal.</span>
                </div>
            </footer>
        </div>
    </div>

    <script src="{{ asset('adminhmd-1.0.0/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('adminhmd-1.0.0/assets/js/main.js') }}"></script>
</body>
</html>
