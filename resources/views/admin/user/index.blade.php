@extends('layouts.app')
@section('custom_css')
    <link rel="stylesheet" href="https://cdn.datatables.net/3.0.4/css/dataTables.bootstrap5.min.css" />
    <style>
        #table-user th:nth-child(1),
        #table-user td:nth-child(1) {
            width: 7px;
            padding-right: 0.25rem;
            text-align: left;
        }
    </style>
@endsection
@section('content')
    <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">
            <div class="page-heading">
                <div class="page-heading-copy">
                    <span class="page-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
                    <div>
                        <h1 class="h3 mb-1">User Management</h1>
                        <p class="text-muted mb-0">User Panel</p>
                    </div>
                </div>

            </div>

            <section class="panel rounded-4">
                <div class="m-2 p-2 d-flex flex-wrap align-items-center gap-2">
                    <button class="btn btn-sm rounded-3 btn-outline-success" id="btn-refresh"><i
                            class="bi bi-arrow-counterclockwise"></i> Refresh</button>
                    <button class="btn btn-sm rounded-3 btn-outline-secondary" id="btn-reload"
                        onclick="window.location.reload()"><i class="bi bi-arrow-counterclockwise"></i> Reload</button>

                    <div class="form-check form-switch ms-auto mb-0">
                        <input class="form-check-input" type="checkbox" role="switch" id="toggle-show-inactive">
                        <label class="form-check-label" for="toggle-show-inactive">Show inactive user</label>
                    </div>
                </div>

                <table class="table" id="table-user">
                    <thead>
                        <tr>
                            <th style="width: 10px !important">#</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Email Status</th>
                            <th>Online</th>
                            <th>Last Login</th>
                            <th>Active</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </section>
        </div>
    </main>
@endsection
@push('custom_js')
    <script src="https://cdn.datatables.net/3.0.4/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/3.0.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('adminhmd-1.0.0/assets/js/admin/user/view.min.js?asx=') . time() }}"></script>
@endpush
