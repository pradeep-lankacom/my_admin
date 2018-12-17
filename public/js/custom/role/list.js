$(document).ready(function() {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });
    var route_table = $('#role-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        "paging": true,
        "lengthMenu": [10, 20, 50, 100],
        pagingType: "simple_numbers",
        ajax: "/admin/roles/get_role_list",
        columns: [{
            data: 'name',
            name: 'name',
            "searchable": true,
            "orderable": true,
        }, {
            data: 'description',
            name: 'description',
            "searchable": true,
            "orderable": true,
        },{
            data: 'created_at',
            name: 'created_at',
            "searchable": true,
            "orderable": true,
        },{
            data: 'action',
            name: 'action',
            "searchable": false,
            "orderable": false,
        }]
    });

});
