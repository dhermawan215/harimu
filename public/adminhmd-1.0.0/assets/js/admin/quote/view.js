var Index = (function () {
    //global variable
    const csrf_token = $('meta[name="csrf-token"]').attr("content");
    const url = $('meta[name="base-url"]').attr("content");
    const endPoint = url + "/admin/quote";
    let table;
    let editEntity = null;

    //function application
    //function load data
    const handleData = function () {
        table = $("#table-quote").DataTable({
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
            columnDefs: [{ orderable: false, targets: 0 }],
            processing: true,
            serverSide: true,
            ajax: {
                url: endPoint + "/list",
                type: "POST",
                data: function (d) {
                    d._token = csrf_token;
                },
            },
            columns: [
                { data: "rnum", orderable: false },
                { data: "source_type", orderable: false },
                { data: "reference", orderable: false },
                { data: "arabic_text", orderable: false },
                { data: "translation_text", orderable: false },
                { data: "visibility", orderable: false },
                { data: "is_active", orderable: false },
                { data: "action", orderable: false },
            ],
        });
        $("#btn-refresh").click(function (e) {
            e.preventDefault();
            table.ajax.reload();
        });
    };
    //handle toggle active/inactive status per row
    var handleToggleActive = function () {
        $(document).on("change", ".toggle-active", function () {
            var checkbox = $(this);
            var id = checkbox.data("change-active");
            var isActive = checkbox.is(":checked");

            checkbox.prop("disabled", true);
            $.ajax({
                type: "POST",
                url: endPoint + "/change-status",
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
                    $("#source_type-edit").val(responseData.source_type);
                    $("#visibility-edit").val(responseData.visibility);
                    $("#reference-edit").val(responseData.reference);
                    $("#arabic_text-edit").val(responseData.arabic_text);
                    $("#translation_text-edit").val(responseData.translation_text);
                    $("#is_active-edit").prop("checked", responseData.is_active);
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
            handleToggleActive();
            handleResetAddForm();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
