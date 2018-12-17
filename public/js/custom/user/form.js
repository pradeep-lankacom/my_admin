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

    //Store user
    $("#store-user").click(function() {

        var form = $('#store-user-form')[0];
        var form_data = new FormData(form);

        $("#store-user").prop('disabled', true);

        console.log($("#store-user-form").attr("action"));

        $.ajax({
            url: $("#store-user-form").attr("action"),
            method: "POST",
            data: form_data,
            cache: false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function(response) {
                console.log(response);
                if (response.status == false) {
                    $("#store-user").prop('disabled', false);
                    toastr.error(response.message, "Error");
                } else {
                    toastr.success(response.message, "Success");
                    setTimeout(function() {
                        window.location.href = "/admin/users";
                    }, 2500);

                }
            },
            error: function(data) {
                var error = data.responseJSON;
                $("#store-user").prop('disabled', false);
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

    function readURL(input, id) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#'+id).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#image").change(function() {
        readURL(this , 'preview_profile_image');
    });

    $("#signature_image").change(function() {
        readURL(this , 'preview_signature');
    });
});