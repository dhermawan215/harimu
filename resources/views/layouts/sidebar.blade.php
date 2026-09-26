<aside class="admin-sidebar" id="adminSidebar" aria-label="Main navigation">
    <div class="sidebar-header">
        <a class="brand-mark" href="{{ route('admin.dashboard') }}" aria-label="Harimu admin dashboard">
            <span class="brand-icon"><i class="bi bi-heart-fill" aria-hidden="true"></i></span>
            <span class="brand-copy">
                <span class="brand-title">Harimu</span>
                <span class="brand-subtitle">Application Panel</span>
            </span>
        </a>
    </div>

    <nav class="sidebar-nav">
        <h6 class="text-muted">User Panel</h6>
        <hr>
        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
            <span class="nav-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
            <span class="nav-text">Dashboard</span>
        </a>
        <a class="nav-link" href="#">
            <span class="nav-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
            <span class="nav-text">Manajemen Undangan</span>
        </a>
        <a class="nav-link" href="#">
            <span class="nav-icon"><i class="bi bi-easel" aria-hidden="true"></i></span>
            <span class="nav-text">Manajemen Tamu</span>
        </a>
        <a class="nav-link" href="#">
            <span class="nav-icon"><i class="bi bi-box-seam" aria-hidden="true"></i></span>
            <span class="nav-text">Manajemen Quote</span>
        </a>
        <a class="nav-link" href="#">
            <span class="nav-icon"><i class="bi bi-receipt" aria-hidden="true"></i></span>
            <span class="nav-text">Transaksi</span>
        </a>
        @if (Auth::user()->role == 'admin')
            <hr>
            <h6 class="text-muted mt-2">Admin Panel</h6>
            <hr>
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                href="{{ route('admin.dashboard') }}">
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
            <a class="nav-link {{ request()->route('/admin/package*') ? 'active' : '' }}"
                href="{{ route('admin.package') }}">
                <span class="nav-icon"><i class="bi bi-box-seam" aria-hidden="true"></i></span>
                <span class="nav-text">Package</span>
            </a>
            <a class="nav-link" href="#">
                <span class="nav-icon"><i class="bi bi-receipt" aria-hidden="true"></i></span>
                <span class="nav-text">Transaksi</span>
            </a>
            <a class="nav-link" href="#">
                <span class="nav-icon"><i class="bi bi-quote" aria-hidden="true"></i></span>
                <span class="nav-text">Kata &amp; Ayat</span>
            </a>
            <a class="nav-link {{ request()->route('/admin/music*') ? 'active' : '' }}"
                href="{{ route('admin.music') }}">
                <span class="nav-icon"><i class="bi bi-music-note-list"></i></span>
                <span class="nav-text">Music</span>
            </a>
            <a class="nav-link" href="#">
                <span class="nav-icon"><i class="bi bi-gear" aria-hidden="true"></i></span>
                <span class="nav-text">Pengaturan</span>
            </a>
        @endif
    </nav>

    <div class="sidebar-footer">
        <span class="status-dot"></span>
        <span class="sidebar-footer-text">Sistem berjalan normal</span>
    </div>
</aside>
