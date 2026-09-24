var Index = (function () {
    //global variable
    const csrf_token = $('meta[name="csrf-token"]').attr("content");
    const url = $('meta[name="base-url"]').attr("content");
    const endPoint = url + "/admin/music";
    let table;
    let aSelected = [];
    let editEntity = null;
    let showDeleted = false;

    //function application
    //function load data
    const handleData = function () {
        table = $("#table-music").DataTable({
            scrollX: true,
            scrollCollapse: true,
            autoWidth: false,
            pageLength: 10,
            searching: true,
            paging: true,
            lengthMenu: [
                [10, 25, 50],
                [10, 25, 50],
            ],
            language: {
                info: "Show _START_ - _END_ from _TOTAL_ data",
                infoEmpty: "Show 0 - 0 from 0 data",
                infoFiltered: "",
                zeroRecords: "Data not found",
                loadingRecords: "Loading...",
                processing: "Processing...",
            },
            columnDefs: [
                { searchable: false, targets: [0, 1] },
                { orderable: false, targets: 0 },
            ],
            processing: true,
            serverSide: true,
            ajax: {
                url: endPoint + "/list",
                type: "POST",
                data: function (d) {
                    d._token = csrf_token;
                    d.show_deleted = showDeleted ? 1 : 0;
                },
            },
            columns: [
                { data: "cbox", orderable: false },
                { data: "rnum", orderable: false },
                { data: "title", orderable: false },
                { data: "artist", orderable: false },
                { data: "duration", orderable: false },
                { data: "tier", orderable: false },
                { data: "is_active", orderable: false },
                { data: "action", orderable: false },
            ],
            drawCallback: function (settings) {
                $(".data-menu-cbox").on("click", function () {
                    handleAddDeleteAselected(
                        $(this).val(),
                        $(this).parents()[1],
                    );

                    // sync state chk-all
                    var total = $(".data-menu-cbox").length;
                    var checked = $(".data-menu-cbox:checked").length;

                    if (checked === 0) {
                        $("#chk-all")
                            .prop("indeterminate", false)
                            .prop("checked", false);
                    } else if (checked === total) {
                        $("#chk-all")
                            .prop("indeterminate", false)
                            .prop("checked", true);
                    } else {
                        $("#chk-all").prop("indeterminate", true); // sebagian dipilih
                    }
                });

                // reset chk-all setiap redraw (pindah halaman, search, dll)
                $("#chk-all")
                    .prop("checked", false)
                    .prop("indeterminate", false);
                aSelected.splice(0, aSelected.length);
                handleBtnDisableEnable();
            },
        });
        handleCheckboxAll();
        $("#btn-refresh").click(function (e) {
            e.preventDefault();
            table.ajax.reload();
        });
    };
    //add delete data array
    var handleAddDeleteAselected = function (value, parentElement) {
        var check_value = $.inArray(value, aSelected);
        if (check_value !== -1) {
            $(parentElement).removeClass("table-info");
            aSelected.splice(check_value, 1);
        } else {
            $(parentElement).addClass("table-info");
            aSelected.push(value);
        }

        handleBtnDisableEnable();
    };
    //control button disabled enable
    var handleBtnDisableEnable = function () {
        var target = showDeleted ? $("#btn-restore") : $("#btn-delete");
        if (aSelected.length > 0) {
            target.removeAttr("disabled");
        } else {
            target.attr("disabled", "");
        }
    };
    //handle toggle show deleted data
    var handleToggleShowDeleted = function () {
        $("#toggle-show-deleted").on("change", function () {
            showDeleted = $(this).is(":checked");
            aSelected.splice(0, aSelected.length);

            $("#btn-add").toggleClass("d-none", showDeleted);
            $("#btn-delete").toggleClass("d-none", showDeleted);
            $("#btn-restore").toggleClass("d-none", !showDeleted);

            table.ajax.reload();
        });
    };
    //function checkbox all
    var handleCheckboxAll = function () {
        $("#chk-all").on("change", function () {
            var isChecked = $(this).is(":checked");

            $(".data-menu-cbox").each(function () {
                var parentRow = $(this).parents()[1];
                var value = $(this).val();
                var existingIndex = $.inArray(value, aSelected);

                if (isChecked) {
                    $(this).prop("checked", true);
                    if (existingIndex === -1) {
                        $(parentRow).addClass("table-info");
                        aSelected.push(value);
                    }
                } else {
                    $(this).prop("checked", false);
                    if (existingIndex !== -1) {
                        $(parentRow).removeClass("table-info");
                        aSelected.splice(existingIndex, 1);
                    }
                }
            });

            handleBtnDisableEnable();
        });
    };
    //function delete data (single/multiple)
    var handleDelete = function () {
        $("#btn-delete").click(function (e) {
            e.preventDefault();
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: endPoint + "/delete",
                        data: {
                            _token: csrf_token,
                            dValue: aSelected,
                            _method: 'DELETE'
                        },
                        success: function (response) {
                            if (response.success == true) {
                                Swal.fire(
                                    "Deleted!",
                                    "The data has been deleted.",
                                    "success",
                                );
                                table.ajax.reload();
                            }
                        },
                        error: function (response) {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Internal Server Error",
                            });
                        },
                    });
                }
            });
        });
    };
    //function restore data (bulk, from checkbox selection)
    var handleRestore = function () {
        $("#btn-restore").click(function (e) {
            e.preventDefault();
            restoreByIds(aSelected);
        });
    };
    //function restore data (single row)
    var handleRestoreSingle = function () {
        $(document).on("click", ".btn-restore", function () {
            var id = $(this).data("restore");
            restoreByIds([id]);
        });
    };
    //shared ajax call to restore music by encrypted ids
    var restoreByIds = function (ids) {
        $.ajax({
            type: "POST",
            url: endPoint + "/restore",
            data: {
                _token: csrf_token,
                dValue: ids,
            },
            success: function (response) {
                toastr.success(response.message);
                table.ajax.reload();
            },
            error: function (response) {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Internal Server Error",
                });
            },
        });
    };
    //handle toggle active/inactive status per row
    var handleToggleActive = function () {
        $(document).on("change", ".toggle-active", function () {
            var checkbox = $(this);
            var id = checkbox.data("id");
            var isActive = checkbox.is(":checked");

            checkbox.prop("disabled", true);
            $.ajax({
                type: "POST",
                url: endPoint + "/toggle-active",
                data: {
                    _token: csrf_token,
                    xvalue: id,
                    is_active: isActive ? 1 : 0,
                },
                success: function (response) {
                    toastr.success(response.message);
                },
                error: function (response) {
                    // revert the switch back if the request failed
                    checkbox.prop("checked", !isActive);
                    if (response.responseJSON && response.responseJSON.message) {
                        toastr.error(response.responseJSON.message);
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Internal Server Error",
                        });
                    }
                },
                complete: function () {
                    checkbox.prop("disabled", false);
                },
            });
        });
    };
    //handle save data
    var handleSave = function () {
        let isSubmit = false;
        $("#form-add").submit(function (e) {
            e.preventDefault();
            if (isSubmit) return;

            isSubmit = true;
            const form = $(this);
            let formData = new FormData(form[0]);

            $("#btn-save").prop("disabled", true);
            $("#btn-save .loading-icons").removeClass("d-none");
            $("#btn-save .bi-save").addClass("d-none");
            $.ajax({
                type: "POST",
                url: endPoint + "/save",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    toastr.success(response.message);
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                },
                error: function (response) {
                    $.each(response.responseJSON, function (key, value) {
                        toastr.error(value);
                    });
                },
                complete: function () {
                    $("#btn-save").prop("disabled", false);
                    $("#btn-save .loading-icons").addClass("d-none");
                    $("#btn-save .bi-save").removeClass("d-none");
                    isSubmit = false;
                },
            });
        });
    };
    //handle edit
    var handleEdit = function () {
        $(document).on("click", ".btn-edit", function () {
            const edit = $(this).data("edit");
            $.ajax({
                type: "post",
                url: endPoint + "/edit",
                data: {
                    _token: csrf_token,
                    xvalue: edit,
                },
                dataType: "json",
                success: function (response) {
                    const responseData = response.data;
                    editEntity = responseData.xvalue;

                    $("#form-update")[0].reset();
                    $("#title-edit").val(responseData.title);
                    $("#artist-edit").val(responseData.artist);
                    $("#tier-edit").val(responseData.tier);
                    $("#is_active-edit").prop(
                        "checked",
                        responseData.is_active,
                    );

                    var fileName = responseData.file_name || "-";
                    if (responseData.duration) {
                        var mins = Math.floor(responseData.duration / 60);
                        var secs = responseData.duration % 60;
                        fileName +=
                            " (" +
                            mins +
                            ":" +
                            (secs < 10 ? "0" : "") +
                            secs +
                            ")";
                    }
                    $("#file-name-edit").text(fileName);
                },
                error: function (response) {
                    $.each(response.responseJSON, function (key, value) {
                        toastr.error(value);
                    });
                },
            });
        });
    };
    //handle update
    var handleUpdate = function () {
        let isSubmit = false;
        $("#form-update").submit(function (e) {
            e.preventDefault();
            if (isSubmit) return;

            isSubmit = true;
            const form = $(this);
            let formData = new FormData(form[0]);
            formData.append("xvalue", editEntity);

            $("#btn-update").prop("disabled", true);
            $("#btn-update .loading-icons").removeClass("d-none");
            $("#btn-update .bi-save").addClass("d-none");
            $.ajax({
                type: "POST",
                url: endPoint + "/update",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    toastr.success(response.message);
                    setTimeout(() => {
                        document.location.reload();
                    }, 1000);
                },
                error: function (response) {
                    $.each(response.responseJSON, function (key, value) {
                        toastr.error(value);
                    });
                },
                complete: function () {
                    $("#btn-update").prop("disabled", false);
                    $("#btn-update .loading-icons").addClass("d-none");
                    $("#btn-update .bi-save").removeClass("d-none");
                    isSubmit = false;
                },
            });
        });
    };

    //reset form-add every time the modal is closed/reopened
    var handleResetAddForm = function () {
        $("#modal-add").on("hidden.bs.modal shown.bs.modal", function () {
            $("#form-add")[0].reset();
        });
    };

    return {
        init: function () {
            handleData();
            handleSave();
            handleEdit();
            handleUpdate();
            handleDelete();
            handleRestore();
            handleRestoreSingle();
            handleToggleShowDeleted();
            handleToggleActive();
            handleResetAddForm();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});