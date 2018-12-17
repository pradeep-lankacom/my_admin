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
  
    //Approve the mission
    $("#store-role").click(function() {
        
      var form = $('#store-role-form')[0];
      var form_data = new FormData(form);
  
      $.ajax({
        url: $("#store-role-form").attr("action"),
        method: "POST",
        data: form_data,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(response) {
  
          if (response.status==false) {
  
            toastr.error(response.message, "Error");
            setTimeout(function() {
              window.location.href = "/admin/roles/";
            }, 2500);
  
  
          }else{
  
            toastr.success(response.message, "Success");
            setTimeout(function() {
              window.location.href = "/admin/roles/";
            }, 2500);
  
          }
        },
        error: function(data){
          var error = data.responseJSON;
  
          $('.text-danger').html('');
          $('.form-group').parent().removeClass('has-error');
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
  