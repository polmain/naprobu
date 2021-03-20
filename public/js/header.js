/* Search */

$('.header-search').click(function () {
  $('.search-block').slideToggle(300);
  $(this).toggleClass('active');
});
jQuery(function($){
  $(document).click(function (e){
    var div = $('.search-block');
    var parent = $('.header-search');
    if (!div.is(e.target)
        && div.has(e.target).length === 0
        && !parent.is(e.target)
        && parent.has(e.target).length === 0
    ) {
      div.slideUp(300);
      parent.removeClass('active');
    }
  });
});

/* End Search */

/* Auth Modal form validate */

$('#btn_login').click(function (e) {
  e.preventDefault();
  var form = $("#auth_form");
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    type: "GET",
    url: "/auth/login/",
    data: form.serialize(),
    success: function(resp)
    {
      if(resp	===	"ok"){
        form.submit();
      }else{
        form.find(".error-message").text(resp);
        //823
      }
    },
    error:  function(xhr, str){
      alert('Возникла ошибка: ' + xhr.responseCode);
    }
  });
  return false;
});

$('#btn_register').click(function (e) {
  e.preventDefault();
  var form = $("#register_form");

  if(form.find('[name="password"]').val() != form.find('[name="password_confirmation"]').val()){
    form.find(".error-message").text(password_confirmation);
    return false;
  }

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    type: "GET",
    url: "/auth/register/",
    data: form.serialize(),
    success: function(resp)
    {
      if(resp	===	"ok"){
        form.submit();
      }else{
        form.find(".error-message").text(resp);
        //823
      }
    },
    error:  function(xhr, str){
      alert('Возникла ошибка: ' + xhr.responseCode);
    }
  });
  return false;
});

/* End Auth Modal form validate */

/* Registration */

$('#register_form').validate({
  errorClass: "invalid-feedback",
  errorElement: "div",
  rules: {
    name: {
      required: true,
      maxlength: 200,
      remote: {
        url: "/check-name/",
        type: "get",
        data: {
          email: function () {
            return $("#registration [name=name]").val();
          }
        }
      }
    },
    email: {
      required: true,
      email: true,
      maxlength: 200,
      remote: {
        url: "/check-email/",
        type: "get",
        data: {
          email: function () {
            return $("#registration [name=email]").val();
          }
        }
      }
    },
    password: {
      required: true,
      minlength: 8,
      maxlength: 200
    },
    password_confirmation: {
      required: true,
      equalTo: "#register_form [name=password]"
    },
  },
  messages: {
    name: {
      required: registerValidate.required,
      maxlength: jQuery.validator.format(registerValidate.maxlength),
      remote: registerValidate.isName,
    },
    email: {
      required: registerValidate.required,
      email: registerValidate.email,
      maxlength: jQuery.validator.format(registerValidate.maxlength),
      remote: registerValidate.isEmail
    },
    password: {
      required: registerValidate.required,
      minlength: jQuery.validator.format(registerValidate.minlength),
      maxlength: jQuery.validator.format(registerValidate.maxlength)
    },
    password_confirmation: {
      required: registerValidate.required,
      equalTo: registerValidate.equalTo
    },
  },
  highlight: function(element, errorClass) {
    $(element).removeClass(errorClass).addClass("is-invalid");
  },
  unhighlight: function(element, errorClass, validClass) {
    $(element).removeClass("is-invalid");
  }
});



$('#register_expert').validate({
  errorClass: "invalid-feedback",
  errorElement: "div",
  rules: {
    last_name: {
      required: true,
      maxlength: 200
    },
    first_name: {
      required: true,
      maxlength: 200
    },
    patronymic: {
      maxlength: 200
    },
    birsday: {
      required: true,
      minlength: 4,
      maxlength: 4
    },
    country: {
      required: true,
      maxlength: 200
    },
    region: {
      required: true,
      maxlength: 200
    },
    city: {
      required: true,
      maxlength: 200
    },
    name: {
      required: true,
      maxlength: 200,
      remote: {
        url: "/check-name/",
        type: "get",
        data: {
          email: function () {
            return $("#register_expert [name=name]").val();
          }
        }
      }
    },
    email: {
      required: true,
      email: true,
      maxlength: 200,
      remote: {
        url: "/check-email/",
        type: "get",
        data: {
          email: function () {
            return $("#register_expert [name=email]").val();
          }
        }
      }
    },
    password: {
      required: true,
      minlength: 8,
      maxlength: 200
    },
    password_confirmation: {
      required: true,
      equalTo: "[name=password]"
    },
  },
  messages: {
    last_name: {
      required: registerValidate.required,
      maxlength: jQuery.validator.format(registerValidate.maxlength)
    },
    first_name: {
      required: registerValidate.required,
      maxlength: jQuery.validator.format(registerValidate.maxlength)
    },
    patronymic: {
      maxlength: jQuery.validator.format(registerValidate.maxlength)
    },
    birsday: {
      required: registerValidate.required,
      minlength: jQuery.validator.format(registerValidate.minlength),
      maxlength: jQuery.validator.format(registerValidate.maxlength)
    },
    country: {
      required: registerValidate.required,
      maxlength: jQuery.validator.format(registerValidate.maxlength)
    },
    region: {
      required: registerValidate.required,
      maxlength: jQuery.validator.format(registerValidate.maxlength)
    },
    city: {
      required: registerValidate.required,
      maxlength: jQuery.validator.format(registerValidate.maxlength)
    },
    name: {
      required: registerValidate.required,
      maxlength: jQuery.validator.format(registerValidate.maxlength),
      remote: registerValidate.isName,
    },
    email: {
      required: registerValidate.required,
      email: registerValidate.email,
      maxlength: jQuery.validator.format(registerValidate.maxlength),
      remote: registerValidate.isEmail
    },
    password: {
      required: registerValidate.required,
      minlength: jQuery.validator.format(registerValidate.minlength),
      maxlength: jQuery.validator.format(registerValidate.maxlength)
    },
    password_confirmation: {
      required: registerValidate.required,
      equalTo: registerValidate.equalTo
    },
  },
  highlight: function(element, errorClass) {
    $(element).removeClass(errorClass).addClass("is-invalid");
  },
  unhighlight: function(element, errorClass, validClass) {
    $(element).removeClass("is-invalid");
  }
});

/* End Registration */

/* Header menu adaptive */

$('.menu-burger').click(function () {
  $(this).next().slideToggle(500);
});

jQuery(function($){
  $(document).click(function (e) {
    if ($(window).width() <= '990'){
      var parent = $('.menu-burger');
      var div = parent.next();

      if (!div.is(e.target)
          && div.has(e.target).length === 0
          && !parent.is(e.target)
          && parent.has(e.target).length === 0
      ) {
        div.slideUp(500);
      }
    }
  });
});

$('.child-menu-shower').click(function () {
  $(this).next().slideToggle(500);
  $(this).toggleClass('active');
});
/* End Header menu adaptive */

/* Header lang switcher adaptive */
$('.other-lang').hide(0);
$('header .lang').click(function () {
  $('.other-lang').slideToggle(500);
});
jQuery(function($){
  $(document).click(function (e){
    var parent = $('.current-lang');
    var div = parent.siblings();

    if (!div.is(e.target)
        && div.has(e.target).length === 0
        && !$('header .lang').is(e.target)
        && $('header .lang').has(e.target).length === 0
    ) {
      div.slideUp(500);
    }
  });
});

/* end Header lang switcher adaptive */

/* Live search */
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
function fetch_customer_data(query)
{

  $.ajax({
    url:"/livesearch/",
    method:'GET',
    data:{
      name:query,
      lang: $('html').attr('lang')
    },
    dataType:'json',
    success:function(data)
    {
      $('#live_search_result').html(data.html);
    }
  })
}

$(document).on('keyup', '#live_search', function(){
  var query = $(this).val();
  if(query.length > 2){
    fetch_customer_data(query);
  }else{
    $('#live_search_result').html('');
  }

});

/* End Live search */

/* User */

$('.auth-header.user-notification').click(function(){
  $('.user-notification-icon').next().slideToggle(500);
  axios.post('/notofication/onview/');
  $('.user-notification-icon').removeClass('active');
});

jQuery(function($){
  $(document).click(function (e){
    var parent = $('.user-notification-icon');
    var div = parent.next();

    if (!div.is(e.target)
        && div.has(e.target).length === 0
        && !$('.auth-header.user-notification').is(e.target)
        && $('.auth-header.user-notification').has(e.target).length === 0
    ) {
      div.slideUp(500);
    }
  });
});

$('.user-header').on('click',function(){
  $(this).find('.user-header-menu').slideToggle(500);
});

jQuery(function($){
  $(document).click(function (e){
    var parent = $('.user-header');
    var div = parent.find('.user-header-menu');

    if (!div.is(e.target)
        && div.has(e.target).length === 0
        && !parent.is(e.target)
        && parent.has(e.target).length === 0
    ) {
      div.slideUp(500);
    }
  });
});

jQuery(function($){
  $(document).click(function (e){
    var div = $('.search-block');
    var parent = $('.header-search');
    if (!div.is(e.target)
        && div.has(e.target).length === 0
        && !parent.is(e.target)
        && parent.has(e.target).length === 0
    ) {
      div.slideUp(300);
      parent.removeClass('active');
    }
  });
});

/* push */

if($('.push-container').length > 0){
  setInterval(getNotifications,15000);
}
function getNotifications(){
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.ajax({
    type: "GET",
    url: '/notification/get/',
  }).done(function(data)
  {
    if(data.html != ""){
      $(".push-container").append(data.html);
      $('.toast').toast('show')
    }
    if(data.notification != ""){
      $(".user-notification-list").prepend(data.notification);
      $(".user-notification-icon").addClass("active");
    }
  });
}
/* end push */
