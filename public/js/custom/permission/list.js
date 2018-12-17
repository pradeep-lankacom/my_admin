$(document).ready(function() {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  var route_table = $('#route_table').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    "paging": true,
    "lengthMenu": [10, 20, 50, 100],
    pagingType: "simple_numbers",
    ajax: "/admin/permissions/get_permission_list",
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
    }, {
      data: 'slug',
      name: 'slug',
      "searchable": true,
      "orderable": true,
    }, {
      data: 'breadcrumb',
      name: 'breadcrumb',
      "searchable": true,
      "orderable": true,
    }, {
      data: 'title',
      name: 'title',
      "searchable": true,
      "orderable": true,
    }, {
      data: null,
      className: "center",

      "searchable": false,
      "orderable": false,
      render: function(data, type, row) {
        return '<a data-toggle="tooltip_view" title="View" style="display: block;float: left;margin-right: 3px;" href="/permissions/' + data.id + '"><button type="button" class="btn btn-success btn-xs dt-view"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></button></a>' +
          '<a data-toggle="tooltip_edit" title="Edit" style="display: block;float: left;margin-right: 3px;" href="/permissions/' + data.id + '/edit"><button type="button" class="btn btn-primary btn-xs dt-edit"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button></a>';
      },
    }]
  });

  $("#delete").click(function(e) {
    swal({
      title: "Are you sure?",
      text: "Do you want to delete this permission permanently?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "red",
      confirmButtonText: "Confirm",
      dangerMode: true,
      html: false
    }, function(isConfirm) {
      if (!isConfirm) {
        return false;
      } else {
        $.ajax({
          url: "/admin/permissions/delete/",
          method: 'post',
          //data: { _method: 'delete' },
          success: function(result) {
            console.log(result);
            //window.location = "/mission_list";
          }
        });
      }
    });
  });






});

$('[data-toggle="tooltip_view"]').tooltip();
$('[data-toggle="tooltip_edit"]').tooltip();
$('[data-toggle="tooltip_delete"]').tooltip();