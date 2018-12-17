$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var userTable;

    userTable = $('#users_table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        "paging": true,
        "lengthMenu": [10, 20, 50, 100],
        pagingType: "simple_numbers",
        ajax: "/admin/users/get_user_list",
        columns: [{
            data: 'id',
            name: 'id',
            "searchable": true,
            "orderable": true,
        }, {
            data: 'name',
            name: 'name',
            "searchable": true,
            "orderable": true,
        }, {
            data: 'email',
            name: 'email',
            "searchable": true,
            "orderable": true,
        }, {
            data: 'role_name',
            name: 'roles.name',
            "searchable": true,
            "orderable": true,

        }, {
            data: 'created_at',
            name: 'created_at',
            "searchable": true,
            "orderable": true,
        }, {
            data: 'status_id',
            name: 'status_id',
            "searchable": true,
            "orderable": true,

        }, {
            data: null,
            className: "center",
            "searchable": false,
            "orderable": false,
            render: function(data, type, row) {
                var edit, status, deleteRestore;

                if (data.deleted_at == null) {
                    edit = '<a data-toggle="tooltip_edit" title="Edit" style="display: block;float: left;margin-right: 3px;" href="/users/' + data.id + '/edit"><button type="button" class="btn btn-warning edit"><i class="fa fa-edit"></i></button></a>';
                } else {
                    edit = '<a data-toggle="tooltip_edit" title="Edit" style="display: block;float: left;margin-right: 3px;" href="/users/' + data.id + '/edit"><button type="button" class="btn btn-warning edit" disabled><i class="fa fa-edit"></i></button></a>';
                }

                if (data.status_name != "Blocked") {
                    status = '<a data-toggle="tooltip_block" title="Block" style="display: block;float: left;margin-right: 3px;" href="#"><button type="button" id="status" userId="' + data.id + '" status="Blocked" deletedAt="' + data.deleted_at + '" class="btn btn-success dt-status"><i class="fa fa-ban"></i></button></a>';
                } else {
                    status = '<a data-toggle="tooltip_activate" title="Activate" style="display: block;float: left;margin-right: 3px;" href="#"><button type="button" id="status" userId="' + data.id + '" status="Active" deletedAt="' + data.deleted_at + '" class="btn btn-info dt-status"><i class="fa fa-check"></i></button></a>';
                }

                if (data.deleted_at == null) {
                    deleteRestore = '<a data-toggle="tooltip_delete" title="Delete" style="display: block;float: left;margin-right: 3px;" href="#"><button id="delete" userId="' + data.id + '" type="button" class="btn btn-danger dt-delete"><i class="fa fa-remove"></i></button></a>';
                } else {
                    deleteRestore = '<a data-toggle="tooltip_restore" title="Restore" style="display: block;float: left;margin-right: 3px;" href="#"><button id="restore" userId="' + data.id + '" type="button" class="btn btn-default dt-restore"><i class="fa fa-undo"></i></button></a>';
                }

                return edit + status + deleteRestore;
            },
        }]
    });

    //Delete
    $(document).on('click', '#delete', function() {

        var userId = $(this).attr("userId");

        swal({
            title: "Are you sure?",
            text: "Do you want to delete this permission permanently?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "red",
            confirmButtonText: "Confirm",
            dangerMode: true,
            html: false
        }).then((isConfirm) => {
            if (!isConfirm) {
                return false;
            } else {
                $.post("/users/destroy", {
                    userId: userId,
                })
                    .done(function(response) {
                        if (response.status == false) {
                            toastr.error(response.message);
                            userTable.ajax.reload();
                        } else {
                            toastr.success(response.message);
                            userTable.ajax.reload();
                        }
                    });
            }
        });
    });

    //Restore
    $(document).on('click', '#restore', function() {

        var userId = $(this).attr("userId");

        swal({
            title: "Are you sure?",
            text: "Do you want to restore this user?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "red",
            confirmButtonText: "Confirm",
            dangerMode: true,
            html: false
        }).then((isConfirm) => {
            if (!isConfirm) {
                return false;
            } else {
                $.post("/users/restore", {
                    userId: userId,
                })
                    .done(function(response) {
                        if (response.status == false) {
                            toastr.error(response.message);
                            userTable.ajax.reload();
                        } else {
                            toastr.success(response.message);
                            userTable.ajax.reload();
                        }
                    });
            }
        });
    });

    //Change status
    $(document).on('click', '#status', function() {

        var userId = $(this).attr("userId");
        var statusName = $(this).attr("status");
        var deletedAt = $(this).attr("deletedAt");
        var message;
        var deletedValue;

        if (deletedAt == "null") {
            deletedValue = 0;
        } else {
            deletedValue = deletedAt;
        }

        console.log(deletedAt);
        console.log(statusName);

        if (statusName == "Blocked") {
            message = "Do you want to block this user?";
        } else {
            message = "Do you want to activate this user?";
        }

        swal({
            title: "Are you sure?",
            text: message,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "red",
            confirmButtonText: "Confirm",
            dangerMode: true,
            html: false
        }).then((isConfirm) => {
            if (!isConfirm) {
                return false;
            } else {
                $.post("/users/change_status", {
                    userId: userId,
                    statusName: statusName,
                    deletedValue: deletedValue,
                })
                    .done(function(response) {
                        if (response.status == false) {
                            toastr.error(response.message);
                            userTable.ajax.reload();
                        } else {
                            toastr.success(response.message);
                            userTable.ajax.reload();
                        }
                    });
            }
        });
    });
});

$('[data-toggle="tooltip_block"]').tooltip();
$('[data-toggle="tooltip_delete"]').tooltip();
$('[data-toggle="tooltip_restore"]').tooltip();