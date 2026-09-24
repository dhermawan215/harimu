@extends('layouts.app')
@section('content')
<main class="dashboard-content">
    <div class="container-fluid px-3 px-lg-4 py-4">
        <div class="page-heading">
            <div class="page-heading-copy">
                <span class="page-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
                <div>
                    <p class="eyebrow mb-1">@yield('page-eyebrow', 'Overview')</p>
                    <h1 class="h3 mb-1">@yield('page-title', 'Dashboard')</h1>
                    <p class="text-muted mb-0">@yield('page-description', '')</p>
                </div>
            </div>
        </div>
        <section class="row g-3 mt-1" aria-label="Dashboard metrics">
            <div class="col-12 col-sm-6 col-xl-3">

            </div>

            <div class="col-12 col-sm-6 col-xl-3">

            </div>

            <div class="col-12 col-sm-6 col-xl-3">

            </div>

            <div class="col-12 col-sm-6 col-xl-3">

            </div>
        </section>

        <section class="panel mt-3">

        </section>
    </div>
</main>


@endsection