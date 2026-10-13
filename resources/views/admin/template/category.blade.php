@extends('layouts.app')
@section('custom_css')
    <link rel="stylesheet" href="https://cdn.datatables.net/3.0.4/css/dataTables.bootstrap5.min.css" />
    <style>
        #table-template-category th:nth-child(1),
        #table-template-category td:nth-child(1) {
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
                    <span class="page-icon"><i class="bi bi-tags" aria-hidden="true"></i></span>
                    <div>
                        <h1 class="h3 mb-1">Template Category Management</h1>
                        <p class="text-muted mb-0">Template Category Panel</p>
                    </div>
                </div>

            </div>

            <section class="panel rounded-4">
                <div class="m-2 p-2 d-flex flex-wrap align-items-center gap-2">
                    <button data-bs-toggle="modal" data-bs-target="#modal-add" class="btn btn-sm btn-primary rounded-3"
                        id="btn-add"><i class="bi bi-plus"></i>
                        Add</button>
                    <button class="btn btn-sm rounded-3 btn-outline-success" id="btn-refresh"><i
                            class="bi bi-arrow-counterclockwise"></i> Refresh</button>
                    <button class="btn btn-sm rounded-3 btn-outline-secondary" id="btn-reload"
                        onclick="window.location.reload()"><i class="bi bi-arrow-counterclockwise"></i> Reload</button>
                </div>

                <table class="table" id="table-template-category">
                    <thead>
                        <tr>
                            <th style="width: 10px !important">#</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </section>
        </div>
    </main>

    <!-- Modal Add -->
    <div class="modal fade" id="modal-add" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalAddLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form-add" autocomplete="off">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalAddLabel">New Template Category</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label for="name-add" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name-add" name="name" required
                                maxlength="255">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary btn-sm rounded-3"
                            data-bs-dismiss="modal"><i class="bi bi-x"></i> Close</button>
                        <button type="submit" class="btn btn-primary btn-sm rounded-3" id="btn-save">
                            <span class="loading-icons spinner-border spinner-border-sm d-none" role="status"
                                aria-hidden="true"></span>
                            <i class="bi bi-save"></i> Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Update -->
    <div class="modal fade" id="modal-update" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalUpdateLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="form-update" autocomplete="off">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalUpdateLabel">Edit Template Category</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label for="name-edit" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name-edit" name="name" required
                                maxlength="255">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary btn-sm rounded-3"
                            data-bs-dismiss="modal"><i class="bi bi-x"></i> Close</button>
                        <button type="submit" class="btn btn-primary btn-sm rounded-3" id="btn-update">
                            <span class="loading-icons spinner-border spinner-border-sm d-none" role="status"
                                aria-hidden="true"></span>
                            <i class="bi bi-save"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('custom_js')
    <script src="https://cdn.datatables.net/3.0.4/js/dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/3.0.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ asset('adminhmd-1.0.0/assets/js/admin/template/category.min.js?asx=') . time() }}"></script>
@endpush
