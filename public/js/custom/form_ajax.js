$("form").on("submit", function (event) {
    event.preventDefault();

    var form = $(this);
    var formData = new FormData(this);
    var method = form.attr("method");
    var action = form.attr("action");
    var submitButton = form.find("button[type=submit]");
    var originalButtonText = submitButton.html();

    formData.append("_token", csrf_token);

    form.find('input[money],input[type="tel"],input[yuzde]').each(function(key, val) {
        val = $(this);
        var name = val.attr('name');
        formData.append(name, val.inputmask('unmaskedvalue'));
    });

    submitButton.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> İşleniyor...')
            .prop("disabled", true);

    $('[error-name]').removeClass('alert alert-danger mt-2').html('');
    $('[success-msg]').removeClass('alert alert-success mt-2').html('');
    $.ajax({
        url: action,
        type: method,
        data: formData,
        processData: false,
        contentType: false, 
        success: function (response) {
            if(typeof(response.success_msg) !== 'undefined'){
                $('[success-msg]').addClass('alert alert-success mt-2').text(response.success_msg);
                setTimeout(function(){
                    window.location.reload();
                }, 1500);
            }
            if(typeof(response.redirect) !== 'undefined') {
                window.location.href = response.redirect;
            }
            if(typeof(response.reload) !== 'undefined') {
                window.location.reload();
            }
        },
        error: function (error) {
            console.error( error.responseText);

            if(error.status === 422) {
                var errors = error.responseJSON.errors;
                $.each(errors, function (key, value) {
                    $('[error-name="' + key + '"]').addClass('alert alert-danger mt-2').text(value[0]);
                });
            }
        },
        complete: function () {
            submitButton.html(originalButtonText).prop("disabled", false);
        }
    });
});