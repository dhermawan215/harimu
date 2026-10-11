var Index = (function () {
    //global variable
    const csrf_token = $('meta[name="csrf-token"]').attr("content");
    const url = $('meta[name="base-url"]').attr("content");
    const endPoint = url + "/admin/user";
    let table;
    let showInActive = false;

    //function application
    //function load data
    const handleData = function () {
        table = $("#table-user").DataTable({
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
                    d.show_inactive = showInActive ? 1 : 0;
                },
            },
            columns: [
                { data: "rnum", orderable: false },
                { data: "name", orderable: false },
                { data: "phone", orderable: false },
                { data: "role", orderable: false },
                { data: "verified", orderable: false },
                { data: "online", orderable: false },
                { data: "last_login", orderable: false },
                { data: "is_active", orderable: false },
            ],
        });
        $("#btn-refresh").click(function (e) {
            e.preventDefault();
            table.ajax.reload();
        });
    };
    //handle toggle show inactive user list
    var handleToggleShowInActive = function () {
        $("#toggle-show-inactive").on("change", function () {
            showInActive = $(this).is(":checked");
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
                    table.ajax.reload();
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

    return {
        init: function () {
            handleData();
            handleToggleShowInActive();
            handleToggleActive();
        },
    };
})();

$(document).ready(function () {
    Index.init();
});
