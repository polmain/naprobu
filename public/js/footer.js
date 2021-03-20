$('#feedback_form,#contact_form').validate({
  ignore: ".ignore",
  submitHandler: function submitHandler(form) {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
      type: "POST",
      url: form.action,
      data: $(form).serialize(),
      success: function success(resp) {
        if (resp === "OK") {
          $('#feedback_form_modal').modal('hide');
          $(form).trigger("reset");
          $('#feedback_sends').modal('show');
        } else {
          $(form).find(".error-message").text(resp);
        }
      },
      error: function error(xhr, str) {
        alert('Возникла ошибка: ' + xhr.responseCode);
      }
    });
    return false;
  },
  errorClass: "invalid-feedback",
  errorElement: "div",
  rules: {
    name: {
      required: true,
      maxlength: 200
    },
    email: {
      required: true,
      email: true
    },
    subject: {
      required: true,
      maxlength: 200
    },
    text: {
      required: true
    },
    hiddenRecaptcha: {
      required: function required() {
        if (grecaptcha.getResponse() == '') {
          return true;
        } else {
          return false;
        }
      }
    }
  },
  messages: {
    name: {
      required: feedbackValidate.required,
      maxlength: feedbackValidate.maxlength
    },
    email: {
      required: feedbackValidate.required,
      email: feedbackValidate.email
    },
    subject: {
      required: feedbackValidate.required,
      maxlength: feedbackValidate.maxlength
    },
    text: {
      required: feedbackValidate.required
    },
    hiddenRecaptcha: {
      required: feedbackValidate.recaptcha
    }
  },
  highlight: function highlight(element, errorClass) {
    $(element).removeClass(errorClass).addClass("is-invalid");
  },
  unhighlight: function unhighlight(element, errorClass, validClass) {
    $(element).removeClass("is-invalid");
  }
});

$('.b2b-form').submit(function (e){
  e.preventDefault();

  var form = this;

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    type: "POST",
    url: form.action,
    data: $(form).serialize(),
    success: function success(resp) {
      if (resp === "OK") {
        $(form).trigger("reset");
        $('#feedback_sends').modal('show');
      } else {
        $(form).find(".error-message").text(resp);
      }
    },
    error: function error(xhr, str) {
      alert('Возникла ошибка: ' + xhr.responseCode);
    }
  });

  return false;
});