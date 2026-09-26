@extends('layouts.app')
@section('custom_css')
    <link rel="stylesheet" href="https://cdn.datatables.net/3.0.4/css/dataTables.bootstrap5.min.css" />
    <style>
        #table-package th:nth-child(1),
        #table-package td:nth-child(1) {
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
                    <span class="page-icon"><i class="bi bi-box-seam" aria-hidden="true"></i></span>
                    <div>
                        <h1 class="h3 mb-1">Package Management</h1>
                        <p class="text-muted mb-0">Package Panel</p>
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

                    <div class="form-check form-switch ms-auto mb-0">
                        <input class="form-check-input" type="checkbox" role="switch" id="toggle-show-inactive">
                        <label class="form-check-label" for="toggle-show-inactive">Show inactive package</label>
                    </div>
                </div>

                <table class="table" id="table-package">
                    <thead>
                        <tr>
                            <th style="width: 10px !important">#</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Duration</th>
                            <th>Invitation Quota</th>
                            <th>Guest Quota</th>
                            <th>WA Blast Quota</th>
                            <th>Tier</th>
                            <th>Active</th>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="form-add" autocomplete="off">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalAddLabel">New Package</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label for="name-add" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name-add" name="name" required
                                maxlength="255">
                        </div>
                        <div class="mb-3">
                            <label for="description-add" class="form-label">Description</label>
                            <textarea class="form-control" id="description-add" name="description" rows="2"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price-add" class="form-label">Price (Rp) <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="price-add" name="price" min="0"
                                    step="0.01" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="duration_days-add" class="form-label">Duration (days)</label>
                                <input type="number" class="form-control" id="duration_days-add" name="duration_days"
                                    min="1">
                                <div class="form-text">Set to 0 if unlimited.</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="max_invitations-add" class="form-label">Invitation Quota <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="max_invitations-add" name="max_invitations"
                                    min="1" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="max_guests-add" class="form-label">Guest Quota <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="max_guests-add" name="max_guests"
                                    min="1" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="max_wa_blast-add" class="form-label">WA Blast Quota <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="max_wa_blast-add" name="max_wa_blast"
                                    min="0" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="template_tier-add" class="form-label">Template Tier <span
                                    class="text-danger">*</span></label>
                            <select class="form-select" id="template_tier-add" name="template_tier" required>
                                <option value="free">Free</option>
                                <option value="basic">Basic</option>
                                <option value="premium">Premium</option>
                            </select>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="is_active-add"
                                name="is_active" value="1" checked>
                            <label class="form-check-label" for="is_active-add">Set Active</label>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="form-update" autocomplete="off">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalUpdateLabel">Edit Package</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label for="name-edit" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name-edit" name="name" required
                                maxlength="255">
                        </div>
                        <div class="mb-3">
                            <label for="description-edit" class="form-label">Description</label>
                            <textarea class="form-control" id="description-edit" name="description" rows="2"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="price-edit" class="form-label">Price (Rp) <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="price-edit" name="price"
                                    min="0" step="0.01" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="duration_days-edit" class="form-label">Duration (days)</label>
                                <input type="number" class="form-control" id="duration_days-edit" name="duration_days"
                                    min="1">
                                <div class="form-text">Kosongkan jika paket tidak punya masa berlaku.</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="max_invitations-edit" class="form-label">Invitation Quota <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="max_invitations-edit"
                                    name="max_invitations" min="1" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="max_guests-edit" class="form-label">Guest Quota <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="max_guests-edit" name="max_guests"
                                    min="1" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="max_wa_blast-edit" class="form-label">WA Blast Quota <span
                                        class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="max_wa_blast-edit" name="max_wa_blast"
                                    min="0" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="template_tier-edit" class="form-label">Template Tier <span
                                    class="text-danger">*</span></label>
                            <select class="form-select" id="template_tier-edit" name="template_tier" required>
                                <option value="free">Free</option>
                                <option value="basic">Basic</option>
                                <option value="premium">Premium</option>
                            </select>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="is_active-edit"
                                name="is_active" value="1">
                            <label class="form-check-label" for="is_active-edit">Set Active</label>
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
    <script src="{{ asset('adminhmd-1.0.0/assets/js/admin/package/view.min.js?asx=') . time() }}"></script>
@endpush
