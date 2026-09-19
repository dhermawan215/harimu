@extends('layouts.admin')
@section('content')
    <section class="row g-3 mt-1" aria-label="Dashboard metrics">
        <div class="col-12 col-sm-6 col-xl-3">
            <article class="metric-card metric-primary">
                <div class="metric-top">
                    <span class="metric-label">Pendapatan</span>
                    <span class="metric-icon"><i class="bi bi-currency-dollar" aria-hidden="true"></i></span>
                </div>
                <div class="metric-value">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</div>
                <div class="metric-meta">
                    <span>dari transaksi berhasil</span>
                </div>
            </article>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <article class="metric-card metric-success">
                <div class="metric-top">
                    <span class="metric-label">Total Pelanggan</span>
                    <span class="metric-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
                </div>
                <div class="metric-value">{{ number_format($totalUsers, 0, ',', '.') }}</div>
                <div class="metric-meta">
                    <span class="text-success">+{{ $newUsersThisWeek }}</span>
                    <span>7 hari terakhir</span>
                </div>
            </article>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <article class="metric-card metric-warning">
                <div class="metric-top">
                    <span class="metric-label">Undangan Dibuat</span>
                    <span class="metric-icon"><i class="bi bi-envelope-heart" aria-hidden="true"></i></span>
                </div>
                <div class="metric-value">{{ number_format($totalInvitations, 0, ',', '.') }}</div>
                <div class="metric-meta">
                    <span>total keseluruhan</span>
                </div>
            </article>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <article class="metric-card metric-danger">
                <div class="metric-top">
                    <span class="metric-label">Pelanggan Baru</span>
                    <span class="metric-icon"><i class="bi bi-person-plus" aria-hidden="true"></i></span>
                </div>
                <div class="metric-value">{{ $newUsersThisWeek }}</div>
                <div class="metric-meta">
                    <span>7 hari terakhir</span>
                </div>
            </article>
        </div>
    </section>

    <section class="panel mt-3">
        <div class="panel-header">
            <div>
                <h2 class="h5 mb-1 section-title"><i class="bi bi-people" aria-hidden="true"></i><span>Pelanggan Terbaru</span></h2>
                <p class="text-muted mb-0">Pendaftar terbaru di platform.</p>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th scope="col">Nama</th>
                        <th scope="col">Email</th>
                        <th scope="col">No. WhatsApp</th>
                        <th scope="col">Bergabung</th>
                    </tr>
                </thead>
                <tbody>
                   
                </tbody>
            </table>
        </div>
    </section>
@endsection
