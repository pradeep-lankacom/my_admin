
$(document).ready(function() {



  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  toastr.options = {
    "closeButton": true,
    "debug": false,
    "progressBar": true,
    "preventDuplicates": false,
    "positionClass": "toast-top-full-width",
    "onclick": null,
    "showDuration": "400",
    "hideDuration": "1000",
    "timeOut": "2500",
    "extendedTimeOut": "100",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  }


    //Update permission
    $("#store-permission").click(function() {
      
        var form = $('#store-permission-form')[0];
        var form_data = new FormData(form);
        $("#store-permission").prop('disabled', true);
        $.ajax({
          url: $("#store-permission-form").attr("action"),
          method: "POST",
          data: form_data,
          cache: false,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function(response) {
            console.log(response);
            if (response.status == false) {
              $("#store-permission").prop('disabled', false);
              toastr.error(response.message, "Error");
            } else {  
              toastr.success(response.message, "Success");
              setTimeout(function() {
                window.location.href = "admin/permissions/list";
              }, 2500);
  
            }
          },
          error: function(data) {
            var error = data.responseJSON;
            $("#store-permission").prop('disabled', false);
            $('.text-danger').html('');
            $('.form-group').removeClass('has-error');
            if (error) {
              $.each(error.errors, function(i, m) {
  
                $('#' + i + '-error').html(m);
                $('#' + i + '-error').parent().parent().addClass('has-error');
  
              });
            }
          }
        });
      
      
    });

 
  

});