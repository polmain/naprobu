/* dropzone */

$("#review_form_submit").click(function () {
	$('#add_review_form').trigger("submit");
});
$("#review_edit_form_submit").click(function () {
	$('#edit_review_form').trigger("submit");
});

if($('#add_review_form, .review-edit').length > 0){
	$('#add_review_form').validate({

		submitHandler: function (form) {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				type: "POST",
				url: form.action,
				data: $(form).serialize(),
				success: function(resp)
				{
					if(resp	===	"OK"){
						$('#add_review').modal('hide');
						$(form).trigger("reset");
						$('#review_sends').modal('show');
					}else{
						$(form).find(".error-message").text(resp);
					}
				},
				error:  function(xhr, str){
					alert('Возникла ошибка: ' + xhr.responseCode);
				}
			});
			return false;
		},
		errorClass: "invalid-feedback",
		errorElement: "div",
		rules: {
			// simple rule, converted to {required:true}
			name: {
				required: true,
				maxlength: 200
			},
			// compound rule
			text: {
				required: true,
				minlength: minCharsets
			}
		},
		messages: {
			name: {
				required: reviewValidate.required,
				maxlength: reviewValidate.maxlength
			},
			text: {
				required: reviewValidate.required,
				minlength: jQuery.validator.format(reviewValidate.minlength)
			}
		},
		highlight: function(element, errorClass) {
			$(element).removeClass(errorClass).addClass("is-invalid");
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).removeClass("is-invalid");
		}
	});

	Dropzone.options.uploadForm = {
		paramName: "upload[]", // The name that will be used to transfer the file
		uploadMultiple: false,
		parallelUploads: 1,
		clickable: '#uploadForm',
		dictDefaultMessage: dropzoneText,
		maxFilesize: 8,
		init: function() {
			var _this = this; // For the closure
			this.on('success', function(file, response) {
				if (response.status == 'OK') {
					if($('#review_images').val() === ''){
						$('#review_images').val('[]');
					}
					var images = JSON.parse($('#review_images').val());
					images.push(response.images[0]);
					$('#review_images').val(JSON.stringify(images));
				} else {
					this.defaultOptions.error(file, response.join('\n'));
				}
			});
			this.on("addedfile", function(file) {
				var removeButton = Dropzone.createElement("<a href=\"#\" class='delete-review-image'>Remove file</a>");
				var _this = this;
				removeButton.addEventListener("click", function(e) {
					e.preventDefault();
					e.stopPropagation();
					if(!$(removeButton).parent().hasClass('dz-error')){
						var images = JSON.parse($('#edit_review_images').val());
						images.splice($(removeButton).parent().index('.dz-preview'),1)
						$('#edit_review_images').val(JSON.stringify(images));
					}
					_this.removeFile(file);
				});
				file.previewElement.appendChild(removeButton);
			});
		},
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
	}

	Dropzone.options.editUploadForm = {
		paramName: "upload[]", // The name that will be used to transfer the file
		uploadMultiple: false,
		parallelUploads: 1,
		clickable: '#editUploadForm',
		dictDefaultMessage: dropzoneText,
		maxFilesize: 8,
		init: function() {
			var _this = this; // For the closure
			this.on('success', function(file, response) {
				if (response.status == 'OK') {
					if($('#edit_review_images').val() === ''){
						$('#edit_review_images').val('[]');
					}
					var images = JSON.parse($('#edit_review_images').val());
					images.push(response.images[0]);
					$('#edit_review_images').val(JSON.stringify(images));
				} else {
					this.defaultOptions.error(file, response.join('\n'));
				}
			});
			this.on("addedfile", function(file) {
				var removeButton = Dropzone.createElement("<a href=\"#\" class='delete-review-image'>Remove file</a>");
				var _this = this;
				removeButton.addEventListener("click", function(e) {
					e.preventDefault();
					e.stopPropagation();
					if(!$(removeButton).parent().hasClass('dz-error')){
						var images = JSON.parse($('#edit_review_images').val());
						images.splice($(removeButton).parent().index('.dz-preview'),1)
						$('#edit_review_images').val(JSON.stringify(images));
					}
					$(removeButton).parent().remove();
				});
				file.previewElement.appendChild(removeButton);
			});
		},
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
	}

	$('#edit_review_form').validate({

		submitHandler: function (form) {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				type: "POST",
				url: form.action,
				data: $(form).serialize(),
				success: function(resp)
				{
					if(resp	===	"OK"){
						$('#edit_review').modal('hide');
						$(form).trigger("reset");
						$('#review_saves').modal('show');
					}else{
						$(form).find(".error-message").text(resp);
					}
				},
				error:  function(xhr, str){
					alert('Возникла ошибка: ' + xhr.responseCode);
				}
			});
			return false;
		},
		errorClass: "invalid-feedback",
		errorElement: "div",
		rules: {
			// simple rule, converted to {required:true}
			name: {
				required: true,
				maxlength: 200
			},
			// compound rule
			text: {
				required: true,
				minlength: minCharsets
			}
		},
		messages: {
			name: {
				required: reviewValidate.required,
				maxlength: reviewValidate.maxlength
			},
			text: {
				required: reviewValidate.required,
				minlength: jQuery.validator.format(reviewValidate.minlength)
			}
		},
		highlight: function(element, errorClass) {
			$(element).removeClass(errorClass).addClass("is-invalid");
		},
		unhighlight: function(element, errorClass, validClass) {
			$(element).removeClass("is-invalid");
		}
	});

}

$('.review-edit').click(editReviewForm);

function editReviewForm(){
	var form = $('#edit_review');
	var review = $(this).parents('.review-item').eq(0);

	form.find("[name=review_id]").val($(review).attr('id').replace('review-',''));
	form.find("[name=name]").val("");
	form.find("[name=text]").val("");
	form.find("[name=video]").val("");
	$('#edit_review_images').val("");
	form.find("#editUploadForm .dz-preview").remove();
	if($(review).find('.review_name').length > 0){
		form.find("[name=name]").val($(review).find('.review_name').text());
	}

	if($(review).find('.review-text').length > 0){
		form.find("[name=text]").val($(review).find('.review-text').text());
	}

	if($(review).find('.review-video').length > 0){
		form.find("[name=video]").val($(review).find('.review-video').val());
	}

	if($(review).find('.review-image').length > 0){
		$('#edit_review_images').val($(review).find('.review-image-arr').val());
		$(review).find('.review-image').each(function () {
			var bg = $(this).css('background-image');
			bg = bg.replace('url(','').replace(')','').replace(/\"/gi, "");
			form.find("#editUploadForm").append('<div class="dz-preview dz-processing dz-image-preview  dz-complete">\n' +
				'                                    <div class="dz-image">\n' +
				'                                        <img data-dz-thumbnail="" src="'+bg+'">\n' +
				'                                    </div>\n' +
				'                                    <a href="#" class="delete-review-image">Remove file</a>\n' +
				'                                </div>');
		});
	}

	$('.delete-review-image').click(function () {
		e.preventDefault();
		e.stopPropagation();

		var images = JSON.parse($('#edit_review_images').val());
		images.splice($(this).parent().index('.dz-preview'),1)
		$('#edit_review_images').val(JSON.stringify(images));
		$(this).parent().remove();
	})



	form.modal("show");
}
/* End dropzone */

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

/* Main page slaiders */

$('.main-reviews .review-list').slick({
	slidesToShow: 3,
	slidesToScroll: 1,
	variableWidth: true,
	infinite: true,
	responsive: [
		{
			breakpoint: 1200,
			settings: {
				slidesToShow: 3,
				rows: 1,
			}
		},
		{
			breakpoint: 767,
			settings: {
				slidesToShow: 1,
				rows: 1,
				variableWidth: false,
			}
		}
	]
});

$('.brand-list:not(.our-partners-list)').slick({
	slidesPerRow: 6,
	rows: 2,
	infinite: true,
	responsive: [
		{
			breakpoint: 767,
			settings: {
				slidesPerRow: 3,
				rows: 2,
			}
		},

		{
			breakpoint: 450,
			settings: {
				slidesPerRow: 1,
				rows: 1,
				autoplay: true,
				//arrows: false,
			}
		}

	]
});
/* End Main page slaiders */

/* Fancy box review gallery*/

$('.review-image').fancybox({
	thumbs : {
		autoStart : true
	}
});

/* End Fancy box review gallery*/

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

/* Load More */

$('.load-more').click(loadMoreData);

function loadMoreData(){
	var page = getCurrentPage()+1;
	var params = getParamsPage();
	var url = '?' + ((('orderBy' in params)) ? 'orderBy=' + params['orderBy'] + '&' :'') + 'page=' + page;

	$.ajax(
		{
			url: url,
			type: "get",
			cache: false,
			headers: {
				'Cache-Control': 'no-cache, no-store, must-revalidate',
				'Pragma': 'no-cache',
				'Expires': '0'
			},
			beforeSend: function()
			{
				$('.ajax-load').show();
			}
		})
		.done(function(data)
		{
			if(data.isNext){
				$('.load-more').remove();
			}
			$("#ajax-list").append(data.html);

			readmoreInit();
			moreComments();
			showHideComment();
			setLocation(url);
			$('.review-edit').click(editReviewForm);
		})
		.fail(function(jqXHR, ajaxOptions, thrownError)
		{
			alert('server not responding...');
		});
}
function setLocation(curLoc){
	try {
		history.pushState(null, null, curLoc);
		return;
	} catch(e) {}
	location.hash = '#' + curLoc;
}

function getCurrentPage() {
	var params = getParamsPage();
	return +((isNaN(params['page'])) ? 1:params['page']);
}

function getParamsPage(){
	var params = window
		.location
		.search
		.replace('?','')
		.split('&')
		.reduce(
			function(p,e){
				var a = e.split('=');
				p[ decodeURIComponent(a[0])] = decodeURIComponent(a[1]);
				return p;
			},
			{}
		);
	return params;
}

/* End Load More */

/* Reviews pages */

function readmoreInit() {

	$('.review-text').readmore({
		speed: 75,
		collapsedHeight: 140,
		moreLink: '<a href="#" class="read-more">'+readMore.more+'</a>',
		lessLink: '<a href="#" class="read-more">'+readMore.less+'</a>',
		embedCSS: false,
		blockCSS: 'display: block; width: 100%;'
	});
}


function moreComments(){
	$('.more-comment').click(function () {
		$(this).parent().find('.review-comment-item').css('display','block');
		$(this).remove();
	});
}
function showHideComment(){
	$('.review-comment-button').click(function (e) {
		$(this).parents('.review-item').find('.review-comment').slideToggle(500);
	});
}

$(document).ready(function () {
	readmoreInit();
	moreComments();
	showHideComment();
	toUpIsVisible();
});


$('#review_sort').select2({
	width: '100%',
	minimumResultsForSearch: -1
});

$('.review-share a').click(function () {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$.ajax({
		type: "POST",
		url: '/review/share/',
	});
});


/*
$('.category-projects').niceScroll({
	cursorcolor: '#052b5f',
});*/

$('.category-projects').perfectScrollbar({
	minScrollbarLength: 50,
});
$('.category-item-parent').hover(function () {
	$(this).find('.category-projects').scrollTop(2);
});

$('.ps-scrollbar-y-rail').click(function () {
	$(this).parent().css('display','inline-block');
});

$('*').mouseup(function () {
	$('.ps-container').css('display','');
});

/*
$('.review_comment_form').submit(function (e) {
	e.preventDefault();
	var form = $(this);
	if(form.find('input').val()){
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			type: "POST",
			url: form.attr('action'),
			data: form.serialize(),
			success: function(resp)
			{
				if(resp	===	"ok"){
					form.trigger("reset");
					document.location.reload();
				}else{
					form.find(".error-message").text(resp);
				}
			},
			error:  function(xhr, str){
				alert('Возникла ошибка: ' + xhr.responseCode);
			}
		});
	}

	return false;
});*/

$('.review-like:not(.disabled)').click(function () {
	var likeButton = $(this);
	var review_id = likeButton.parents('.review-item').attr('id');
	review_id = review_id.replace('review-','');
	var url = '/review/like/' + review_id + '/';
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			type: "POST",
			url: url,
			success: function(resp)
			{
				if(resp.status	===	"ok"){
					likeButton.toggleClass('active');
					likeButton.find('.like-count').text(resp.like_count);
				}
			},
			error:  function(xhr, str){
				alert('Возникла ошибка: ' + xhr.responseCode);
			}
		});
})

/* End Reviews pages */

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

/* sidebar shower */

$('.sidebar-shower').click(function () {
	if($(this).hasClass('active')){
		$(this).parent().animate({height: '68px'}, 500);
	}else{
		var el = $(this).parent(),
			curHeight = el.height(),
			autoHeight = el.css('height', 'auto').height();
		el.height(curHeight).animate({height: autoHeight}, 500);
	}
	$(this).toggleClass('active')


});

/* end sidebar shower */

/* Smooth scrolling */

$(document).on('click', 'a[href^="#"].letter-item', function (event) {
	event.preventDefault();

	$('html, body').animate({
		scrollTop: $($.attr(this, 'href')).offset().top - $('.alphabet').height()
	}, 500);
});

/* end Smooth scrolling */

/* resize */

$(window).resize(resize);
resize();
function resize() {
	if($('.alphabet').length > 0){
		$('body').attr('data-offset',$('.alphabet').height())
	}
}

/* resize */

/* Feedback form */

$('#feedback_form,#contact_form').validate({
	submitHandler: function (form) {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			type: "POST",
			url: form.action,
			data: $(form).serialize(),
			success: function(resp)
			{
				if(resp	===	"OK"){
					$('#feedback_form_modal').modal('hide');
					$(form).trigger("reset");
					$('#feedback_sends').modal('show');
				}else{
					$(form).find(".error-message").text(resp);
				}
			},
			error:  function(xhr, str){
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
			required: true,
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
			required: feedbackValidate.required,
		}
	},
	highlight: function(element, errorClass) {
		$(element).removeClass(errorClass).addClass("is-invalid");
	},
	unhighlight: function(element, errorClass, validClass) {
		$(element).removeClass("is-invalid");
	}
});

$('#brif_form').validate({
	submitHandler: function (form) {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			type: "POST",
			url: form.action,
			data: $(form).serialize(),
			success: function(resp)
			{
				if(resp	===	"OK"){
					$(form).trigger("reset");
					$('#brif_sends').modal('show');
				}else{
					$(form).find(".error-message").text(resp);
				}
			},
			error:  function(xhr, str){
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
	},
	highlight: function(element, errorClass) {
		$(element).removeClass(errorClass).addClass("is-invalid");
	},
	unhighlight: function(element, errorClass, validClass) {
		$(element).removeClass("is-invalid");
	}
});

/* End Feedback form */

/* Faq */

$('.faq-category-item').click(function(){
	var id = this.id;
	$(this).siblings().removeClass('active');
	$(this).addClass('active');
	var questions = $('#'+id+'-questions');
	questions.siblings().hide(500);
	questions.show(500);

	var top = $('#'+id+'-questions').offset().top - 80;

	//анимируем переход на расстояние - top за 1500 мс
	$('body,html').animate({scrollTop: top}, 1500);

});

$('.faq-category-question-item-question').click(function(){
	var parent = $(this).parent();
	$(parent).toggleClass('active');
	$(this).next().toggle(300);
});

/* End Faq */

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

/* questionnaire */

$(function () {
	$('[data-toggle="popover"]').popover();

	$('.relation-question').each(function () {
		var answer = $(this).attr("relation-question");
		$("#option_"+answer).addClass('relation-answer');
	});
})



$('.questionnaire-form select').change(function(){
	if($('option.other-answer', this).length > 0){
		var questionId = 'question_'+$('option.other-answer', this).val();
		if($('option:selected', this).hasClass('other-answer')){
			$("#"+questionId).show(300);
		}else{
			$("#"+questionId).hide(300);
		}
	}

	if($('option.relation-answer', this).length > 0){
		var questionId = $('option.relation-answer', this).val();
		if($('option:selected', this).hasClass('relation-answer')){
			$(".relation-question_"+questionId).show(300);
		}else{
			$(".relation-question_"+questionId).hide(300);
		}
	}
});

$('.questionnaire-form input[type="radio"], .questionnaire-form input[type="checkbox"]').change(function(){
	var name = $(this).attr('name');

	if($("input[name='"+name+"'].other-answer").length > 0){
		var questionId = 'question_'+$("input[name='"+name+"'].other-answer").val();
		if($("input[name='"+name+"'].other-answer:checked").length > 0){
			$("#"+questionId).show(300);
		}else{
			$("#"+questionId).hide(300);
		}
	}
	if($("input[name='"+name+"'].relation-answer").length > 0){
		$("input[name='"+name+"'].relation-answer").each(function(){
			var questionId = $(this).val();
			if($(this).prop('checked')){
				$(".relation-question_"+questionId).show(300);
			}else{
				$(".relation-question_"+questionId).hide(300);
			}
		})
	}

});
$('.questionnaire-form').submit(function (e) {
	e.preventDefault();
	$(this).find('.is-invalid').removeClass('is-invalid');
	$(this).find('.invalid-feedback').remove();

	$(this).find("input[type=text].required, input[type=date].required, input[type=number].required, textarea.required, select.required").each(function () {
		if(!$(this).val() && $(this).parent().is(':visible')){
			$(this).addClass('is-invalid');
			$(this).after('<div class="invalid-feedback">'+questionnaireValidate.required+'</div>');
		}
	});
	$(this).find("input[type=radio].required, input[type=checkbox].required").each(function () {
		var name = $(this).attr('name');
		if(!$("input[name='" + name + "']").parent().hasClass('is-invalid')) {
			if ($("input[name='" + name + "']:checked").length == 0 && $(this).parent().parent().is(':visible')) {
				$("input[name='" + name + "']").parent().addClass('is-invalid');
				$("input[name='" + name + "']").parent().parent().append('<div class="invalid-feedback">'+questionnaireValidate.required+'</div>');
			}
		}
	});
	$(this).find("input[type=radio].required.other-answer:checked, input[type=checkbox].required.other-answer:checked").each(function () {
		if(!$(this).parent().hasClass('is-invalid')) {
			var questionId = 'question_'+$(this).val();
			if(!$("#"+questionId).hasClass('is-invalid')){
				if(!$("#"+questionId).val() && $(this).parent().is(':visible')){
					$("#"+questionId).addClass('is-invalid');
					$("#"+questionId).after('<div class="invalid-feedback">'+questionnaireValidate.required+'</div>');
				}
			}
		}
	});
	$(this).find("select.required").each(function () {
		if($('option:selected', this).hasClass('other-answer')){
			var questionId = 'question_'+$('option.other-answer', this).val();
			if(!$("#"+questionId).hasClass('is-invalid')){
				if(!$("#"+questionId).val() && $(this).parent().is(':visible')){
					$("#"+questionId).addClass('is-invalid');
					$("#"+questionId).after('<div class="invalid-feedback">'+questionnaireValidate.required+'</div>');
				}
			}
		}
	});

	$(this).find("input[type=text], textarea").each(function () {
		if(!$(this).hasClass('is-invalid')) {
			if ($(this).is('[valid-min]')) {
				if ($(this).val().length < $(this).attr('valid-min') && $(this).parent().is(':visible')) {
					$(this).addClass('is-invalid');
					$(this).after('<div class="invalid-feedback">'+questionnaireValidate.min_chars.replace("--numb--",$(this).attr("valid-min"))+'</div>');
				}
			}
		}
		if(!$(this).hasClass('is-invalid')) {
			if ($(this).is('[valid-max]')) {
				if ($(this).val().length > $(this).attr('valid-max') && $(this).parent().is(':visible')) {
					$(this).addClass('is-invalid');
					$(this).after('<div class="invalid-feedback">'+questionnaireValidate.max_chars.replace("--numb--",$(this).attr("valid-max"))+'</div>');
				}
			}
		}
	});

	$(this).find("input[type=number]").each(function () {
		if(!$(this).hasClass('is-invalid')) {
			if ($(this).is('[valid-min]')) {
				if (+$(this).val() < $(this).attr('valid-min') && $(this).parent().is(':visible')) {
					$(this).addClass('is-invalid');
					$(this).after('<div class="invalid-feedback">'+questionnaireValidate.min_numb.replace("--numb--",$(this).attr("valid-min"))+'</div>');
				}
			}
		}
		if(!$(this).hasClass('is-invalid')) {
			if ($(this).is('[valid-max]')) {
				if (+$(this).val() > $(this).attr('valid-max') && $(this).parent().is(':visible')) {
					$(this).addClass('is-invalid');
					$(this).after('<div class="invalid-feedback">'+questionnaireValidate.max_numb.replace("--numb--",$(this).attr("valid-max"))+'</div>');
				}
			}
		}
	});

	$(this).find("input[type=checkbox]").each(function () {
		var name = $(this).attr('name');

		var count = $("input[name='" + name + "']:not(.other-answer):checked").length
		if($("input[name='" + name + "'].other-answer:checked").length > 0){
			var questionId = 'question_'+$(this).val();
			if($("#"+questionId).val()){
				count++;
			}
		}


		if(!$("input[name='" + name + "']").parent().hasClass('is-invalid')) {
			if ($(this).is('[valid-min]')) {
				if (count < $(this).attr('valid-min') && $(this).parent().parent().is(':visible')) {
					$("input[name='" + name + "']").parent().addClass('is-invalid');
					$("input[name='" + name + "']").parent().parent().append('<div class="invalid-feedback">'+questionnaireValidate.min_check.replace("--numb--",$(this).attr("valid-min"))+'</div>');
				}
			}
		}

		if(!$("input[name='" + name + "']").parent().hasClass('is-invalid')) {
			if ($(this).is('[valid-max]')) {
				if (count > $(this).attr('valid-max') && $(this).parent().parent().is(':visible')) {
					$("input[name='" + name + "']").parent().addClass('is-invalid');
					$("input[name='" + name + "']").parent().parent().append('<div class="invalid-feedback">'+questionnaireValidate.max_check.replace("--numb--",$(this).attr("valid-max"))+'</div>');
				}
			}
		}
	});

	if($(this).find('.is-invalid').length == 0){
		form = $(this)
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			type: "POST",
			url: form.attr('action'),
			data: form.serialize(),
			success: function(resp)
			{
				if(resp.status == "ok"){
					window.location.href = resp.route;
				}else{
					alert(resp.error);
				}

			},
			error:  function(xhr, str){
				alert('Возникла ошибка: ' + xhr.responseCode);
			}
		});
		return false;
	}
});


/* end questionnaire */

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

$("input[type='file']#avatar").change(function() {
	//$("#imageMessage").empty();
	var file = this.files[0];
	var imagefile = file.type;
	var match= ["image/jpeg","image/png","image/jpg","image/gif"];
	if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])|| (imagefile==match[3])))
	{
		return false;
	}
	else
	{
		var reader = new FileReader();
		reader.readAsDataURL(file);

		var input = $(this);

		reader.onload = function imageIsLoaded(e) {
			input.addClass('is-valid');
			input.removeClass('is-invalid');

			input.parent().prev().css('background-image', 'url("'+e.target.result+'")');
			input.parent().next().show();
		};
	}
});
$('[data-toggle="tooltip"]').tooltip();

$('.present.active').click(function(){
	$(this).tooltip('hide');
  	var text = $("#present_modal .text").text();
  	var text = text.replace(':rating_name:',$(this).attr('role-name'));
	$("#present_modal .text").text(text);

	axios.post('/cabinet/present/', {
		present_id: $(this).attr('present-id')
	});

	$(this).remove();
	$("#present_modal").modal("show");
});

if($('#user_data_form').length > 0){
	$('#user_data_form').validate({
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
					url: "/check-name-register/",
					type: "get",
					data: {
						email: function () {
							return $("#user_data_form [name=name]").val();
						}
					}
				}
			},
			email: {
				required: true,
				email: true,
				maxlength: 200,
				remote: {
					url: "/check-email-register/",
					type: "get",
					data: {
						email: function () {
							return $("#user_data_form [name=email]").val();
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
}


/* End user */

/* Partner page */


$('.partner-cases-list').slick({
	slidesPerRow: 1,
	rows: 1,
});
if($('.brand-item-partner').length > 0 ){
	var review = $('.brand-item-partner.active').find('.brand-review').html();
	$('.brand-item-text').html(review);
}

$('.brand-item-partner').click(function () {
	$('.brand-item-partner').removeClass('active');
	$(this).addClass('active');
	var review = $(this).find('.brand-review').html();
	$('.brand-item-text').hide(0,function () {
		$('.brand-item-text').html(review);
		$('.brand-item-text').show(0);
	});
});

/* End Partner page */

/* Blog */

$('.blog-comment-form').submit(function (e) {
	e.preventDefault();
	var form = $(this);
	if(form.find('input').val()){
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			type: "POST",
			url: form.attr('action'),
			data: form.serialize(),
			success: function(resp)
			{
				if(resp	===	"ok"){
					//form.trigger("reset");
					//$('#comment_sends').modal('show');
					location.reload();
				}else{
					form.find(".error-message").text(resp);
				}
			},
			error:  function(xhr, str){
				alert('Возникла ошибка: ' + xhr.responseCode);
			}
		});
	}

	return false;
});

/* End Blog */

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


/* Massonry */

$('.massonry-list').masonry({
	// options
	//itemSelector: '.massonry-item',
	itemSelector: 'a',
	gutter: 30
});

/* End Massonry */

/* Up button */

$(window).scroll(function () {
	toUpIsVisible();
});

function toUpIsVisible(){
	if($(window).scrollTop() > 0){
		$('.to-up').css('display','inline-block');
	}else{
		$('.to-up').css('display','none');
	}
}

$('.to-up').click(function(){
	//анимируем переход на расстояние - top за 1500 мс
	$('body,html').animate({scrollTop: 0}, 1500);
});

/* End Up button */


