@extends('layouts.app')
@section('custom_css')
    <link rel="stylesheet" href="https://cdn.datatables.net/3.0.4/css/dataTables.bootstrap5.min.css" />
    <style>
        #table-music th:nth-child(1),
        #table-music td:nth-child(1) {
            width: 7px;
            padding-right: 0.25rem;
            text-align: left;
        }

        #table-music th:nth-child(2),
        #table-music td:nth-child(2) {
            width: 7px;
            padding-left: 0.25rem;
            text-align: left;
        }
    </style>
@endsection
@section('content')
    <main class="dashboard-content">
        <div class="container-fluid px-3 px-lg-4 py-4">
            <div class="page-heading">
                <div class="page-heading-copy">
                    <span class="page-icon"><i class="bi bi-file-music" aria-hidden="true"></i></span>
                    <div>
                        <h1 class="h3 mb-1">Music Management</h1>
                        <p class="text-muted mb-0">Music Invitation Panel</p>
                    </div>
                </div>

            </div>

            <section class="panel rounded-4">
                <div class="m-2 p-2 d-flex flex-wrap align-items-center gap-2">
                    <button data-bs-toggle="modal" data-bs-target="#modal-add" class="btn btn-sm btn-primary rounded-3"
                        id="btn-add"><i class="bi bi-plus"></i>
                        Add</button>
                    <button class="btn btn-sm btn-danger rounded-3" id="btn-delete" disabled><i class="bi bi-trash"></i>
                        Delete</button>
                    <button class="btn btn-sm btn-success rounded-3 d-none" id="btn-restore" disabled><i
                            class="bi bi-arrow-counterclockwise"></i> Restore</button>
                    <button class="btn btn-sm rounded-3 btn-outline-success" id="btn-refresh"><i
                            class="bi bi-arrow-counterclockwise"></i> Refresh</button>
                    <button class="btn btn-sm rounded-3 btn-outline-secondary" id="btn-reload"
                        onclick="window.location.reload()"><i class="bi bi-arrow-counterclockwise"></i> Reload</button>

                    <div class="form-check form-switch ms-auto mb-0">
                        <input class="form-check-input" type="checkbox" role="switch" id="toggle-show-deleted">
                        <label class="form-check-label" for="toggle-show-deleted">Show deleted file</label>
                    </div>
                </div>

                <table class="table"id="table-music">
                    <thead>
                        <tr>
                            <th style="width: 10px !important">
                                <input type="checkbox" class="form-check-input" id="chk-all">
                            </th>
                            <th style="width: 10px !important">#</th>
                            <th>Title</th>
                            <th>Artist</th>
                            <th>Duration</th>
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
                <form id="form-add" enctype="multipart/form-data" autocomplete="off">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalAddLabel">Upload Music</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label for="title-add" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title-add" name="title" required
                                maxlength="255">
                        </div>
                        <div class="mb-3">
                            <label for="artist-add" class="form-label">Artist</label>
                            <input type="text" class="form-control" id="artist-add" name="artist" maxlength="255">
                        </div>
                        <div class="mb-3">
                            <label for="file-add" class="form-label">File <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="file-add" name="file"
                                accept="audio/mp3,audio/wav,audio/ogg,.mp3,.wav,.ogg" required>
                            <div class="form-text">Format mp3, wav, atau ogg. Maksimal 15MB.</div>
                        </div>
                        <div class="mb-3">
                            <label for="tier-add" class="form-label">Tier <span class="text-danger">*</span></label>
                            <select class="form-select" id="tier-add" name="tier" required>
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
                <form id="form-update" enctype="multipart/form-data" autocomplete="off">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalUpdateLabel">Edit Music</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label for="title-edit" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title-edit" name="title" required
                                maxlength="255">
                        </div>
                        <div class="mb-3">
                            <label for="artist-edit" class="form-label">Artist</label>
                            <input type="text" class="form-control" id="artist-edit" name="artist" maxlength="255">
                        </div>
                        <div class="mb-3">
                            <label for="file-edit" class="form-label">File</label>
                            <input type="file" class="form-control" id="file-edit" name="file"
                                accept="audio/mp3,audio/wav,audio/ogg,.mp3,.wav,.ogg">
                            <div class="form-text">Current file: <span id="file-name-edit">-</span>. Set blank if you dont
                                replace it.</div>
                        </div>
                        <div class="mb-3">
                            <label for="tier-edit" class="form-label">Tier <span class="text-danger">*</span></label>
                            <select class="form-select" id="tier-edit" name="tier" required>
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
    <script src="{{ asset('adminhmd-1.0.0/assets/js/admin/music/view.min.js?asx=') . time() }}"></script>
@endpush
