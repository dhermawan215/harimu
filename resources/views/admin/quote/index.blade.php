@extends('layouts.app')
@section('custom_css')
    <link rel="stylesheet" href="https://cdn.datatables.net/3.0.4/css/dataTables.bootstrap5.min.css" />
    <style>
        #table-quote th:nth-child(1),
        #table-quote td:nth-child(1) {
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
                    <span class="page-icon"><i class="bi bi-chat-quote" aria-hidden="true"></i></span>
                    <div>
                        <h1 class="h3 mb-1">Quote Management</h1>
                        <p class="text-muted mb-0">Quote Panel</p>
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

                <table class="table" id="table-quote">
                    <thead>
                        <tr>
                            <th style="width: 10px !important">#</th>
                            <th>Source Type</th>
                            <th>Reference</th>
                            <th>Arabic Text</th>
                            <th>Translation Text</th>
                            <th>Visibility</th>
                            <th>Status</th>
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
                        <h1 class="modal-title fs-5" id="modalAddLabel">New Quote</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="source_type-add" class="form-label">Source Type <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="source_type-add" name="source_type" required>
                                    <option value="quran">Quran</option>
                                    <option value="hadith">Hadith</option>
                                    <option value="quote">Quote</option>
                                    <option value="custom">Custom</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="visibility-add" class="form-label">Visibility <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="visibility-add" name="visibility" required>
                                    <option value="global">Global</option>
                                    <option value="private">Private</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="reference-add" class="form-label">Reference</label>
                            <input type="text" class="form-control" id="reference-add" name="reference"
                                maxlength="255" placeholder="e.g. QS. Ar-Rum: 21">
                        </div>
                        <div class="mb-3">
                            <label for="arabic_text-add" class="form-label">Arabic Text</label>
                            <textarea class="form-control" id="arabic_text-add" name="arabic_text" rows="2"
                                dir="rtl"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="translation_text-add" class="form-label">Translation Text <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control" id="translation_text-add" name="translation_text" rows="3"
                                required></textarea>
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
                        <h1 class="modal-title fs-5" id="modalUpdateLabel">Edit Quote</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="source_type-edit" class="form-label">Source Type <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="source_type-edit" name="source_type" required>
                                    <option value="quran">Quran</option>
                                    <option value="hadith">Hadith</option>
                                    <option value="quote">Quote</option>
                                    <option value="custom">Custom</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="visibility-edit" class="form-label">Visibility <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="visibility-edit" name="visibility" required>
                                    <option value="global">Global</option>
                                    <option value="private">Private</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="reference-edit" class="form-label">Reference</label>
                            <input type="text" class="form-control" id="reference-edit" name="reference"
                                maxlength="255" placeholder="e.g. QS. Ar-Rum: 21">
                        </div>
                        <div class="mb-3">
                            <label for="arabic_text-edit" class="form-label">Arabic Text</label>
                            <textarea class="form-control" id="arabic_text-edit" name="arabic_text" rows="2"
                                dir="rtl"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="translation_text-edit" class="form-label">Translation Text <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control" id="translation_text-edit" name="translation_text"
                                rows="3" required></textarea>
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
    <script src="{{ asset('adminhmd-1.0.0/assets/js/admin/quote/view.min.js?asx=') . time() }}"></script>
@endpush
