$('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
	checkboxClass: 'icheckbox_minimal-red',
	radioClass   : 'iradio_minimal-red'
});

$( ".list-sort" ).sortable();
$( ".questions-list" ).sortable({
	handle: '.drag-zone'
});
function hexToRgb(hex) {
	var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
	return result ? {
		r: parseInt(result[1], 16),
		g: parseInt(result[2], 16),
		b: parseInt(result[3], 16)
	} : null;
}
$('select.select2').select2();


var table = $('.data-table').DataTable({
  "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Все"]],
	"pageLength": 25,
	"language": {
		"url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Russian.json"
	}
});

table.on( 'draw', afterDrawTabel() );

function afterDrawTabel() {
	$('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
		checkboxClass: 'icheckbox_minimal-red',
		radioClass   : 'iradio_minimal-red'
	});
	$('.show-hide').on('ifChanged', function(event){
		{
			var id = $(this).attr('id').replace('show-hide-','');
			var url = $("input[name='show-hide-url']").val().replace('--id--',id);
			if($(this).prop("checked")){
				url = url.replace('--action--','hide');
			}else{
				url = url.replace('--action--','show');
			}
			AjaxNotRefresh(url);
		}
	});
}
function addSelectFilter(column) {
	var select = $('<select><option value=""></option></select>')
		.appendTo($(column.header()))
		.bind('keyup change', function () {
			column.search($(this).val()).draw();
		} );
	column.data().unique().sort().each(function (d, j) {
		select.append('<option value="' + d + '">' + d + '</option>')
	});
}
/* CKEditor Init */

var options = {
	filebrowserImageBrowseUrl: '/admin/laravel-filemanager',
	filebrowserImageUploadUrl: '/admin/laravel-filemanager/upload?type=Images&_token=',
	filebrowserBrowseUrl: '/admin/laravel-filemanager?type=Files',
	filebrowserUploadUrl: '/admin/laravel-filemanager/upload?type=Files&_token=',
	title: true,
	extraPlugins: 'youtube'
};
$(".editor").each(function () {
	if($(this).parents('.new-template').length == 0){
		$(this).ckeditor(options);
	}
});

/* End CKEditor Init */

/* Images */

var lfm = function(options, cb) {

	var route_prefix = (options && options.prefix) ? options.prefix : '/admin/laravel-filemanager';
	window.SetUrl = cb;
	window.open(route_prefix + '?type=' + options.type || 'file', 'FileManager', 'width=900,height=600');

}

$('.image_upload').click(function () {
	var container = $(this).prev();
	lfm({type: 'image'}, function(url, path) {
		/*var publicPath = path
			.substring(0, path.length - 1)
			.replace('admin/laravel-filemanager','/public/uploads');*/
		var siteUrl = window.location.href;
		var arr = siteUrl.split("/");
		var siteUrl = arr[0] + "//" + arr[2]


		var publicPath = url[0].url.replace(siteUrl+'/','');
		container.css('background-image','url("/'+publicPath+'")');
		container.find('.upload_image_name').val('/'+publicPath);
		container.addClass('active');
		container.next().text('Изменить изображение');
	});
});

$('.image_delete').click(function () {
	var container = $(this).siblings('.load-img');
	container.css('background-image','');
	container.find('.upload_image_name').val('');
	container.removeClass('active');
	container.next().text('Добавить изображение');
});



/* End Images */

/* Date time picker init */

$(".form_datetime").datetimepicker({format: 'dd.mm.yyyy hh:ii'});
$(".form_date").datetimepicker({
	format: 'dd.mm.yyyy',
	weekStart: 1,
	startView: 4,
	language: "ru",
	viewSelect: 2,
	minView: 2,
	autoclose: true

});
/* End Date time picker init */


/* URL generator */

$('.project-name').change(function () {
	var id = $(this).attr('id').replace('name-','');
	var urlContainer = $("#project-url-"+id);
	if(!urlContainer.hasClass("not-edit")){
		var lang = urlContainer.attr('id').replace('project-url-','');
		var url = url_slug($(this).val());

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			type: "GET",
			url: isURLRoute,
			data: {
				'url': url,
				'lang': lang,
			},
			success: function(resp)
			{
				url = resp;
				var statURL = urlContainer.find(".static-part").text();
				urlContainer.find(".new-url").val(url);
				urlContainer.find(".edit-part").text(url);
				urlContainer.find(".link-url").attr("href",statURL+url);
			},
			error:  function(xhr, str){
				alert('Возникла ошибка: ' + xhr.responseCode);
			}
		});
	}
});

$(".change-url").click(function () {
	var lang = $(this).parents('.project-url').attr('id');
	changeModeEditURL(lang);
});
$(".project-url .save-url").click(function () {
	var urlContainer = $(this).parents('.project-url');
	var lang = urlContainer.attr('id');
	changeModeEditURL(lang);

	urlContainer.addClass("not-edit");
	var url = urlContainer.find(".new-url").val();
	var statURL = urlContainer.find(".static-part").text();
	var statURL = statURL + urlContainer.find(".category-part").eq(0).text();
	urlContainer.find(".edit-part").text(url);
	urlContainer.find(".link-url").attr("href",statURL+url);

	var lang = urlContainer.attr('id').replace('project-url-','');


	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$.ajax({
		type: "GET",
		url: isURLRoute,
		data: {
			'url': url,
			'lang': lang,
		},
		success: function(resp)
		{
			url = resp;
			var statURL = urlContainer.find(".static-part").text();
			urlContainer.find(".new-url").val(url);
			urlContainer.find(".edit-part").text(url);
			urlContainer.find(".link-url").attr("href",statURL+url);
		},
		error:  function(xhr, str){
			alert('Возникла ошибка: ' + xhr.responseCode);
		}
	});
});
$(".project-url .cancel-url").click(function () {
	var urlContainer = $(this).parents('.project-url');
	var lang = urlContainer.attr('id');
	changeModeEditURL(lang);
	var url = urlContainer.find(".edit-part").text();
	urlContainer.find(".new-url").val();
});

function changeModeEditURL(lang) {
	$("#"+lang+" .edit-a").toggleClass('active');
	$("#"+lang+" .edit-input").toggleClass('active');
}

var lang = [];
lang[0] = "ru";
lang[1] = "ua";
lang[2] = "en";
/*$("#sub-url").change(function () {
	for(var i=0;i<lang.length;i++){
		$catURL = $(this).find("option:selected").attr("data-url-"+lang[i]);
		$(".url-"+lang[i]+" .category-part").text($catURL+"/");
		var url = $(".url-"+lang[i]+" .static-part").text();
		var url = url + $catURL+"/";
		var url = url + $(".url-"+lang[i]+" .edit-part").text();
		$(".url-"+lang[i]+" a").attr('href',url);
	}
});*/



/* End URL generator */

function generatePassword() {
	var length = 8,
		charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
		retVal = "";
	for (var i = 0, n = charset.length; i < length; ++i) {
		retVal += charset.charAt(Math.floor(Math.random() * n));
	}
	return retVal;
}

$('#pass_gen').click(function () {
	var pass = generatePassword();
	$(this).siblings('.password_gen_view').text(pass);
	$(this).parent().parent().find('input[type="password"]').val(pass);
});



$("input[type='file']:not([multiple])").change(function() {
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

			container.css('background-image', 'url("'+e.target.result+'")');
		};
	}
});
$("input[type='file'][multiple]").change(function() {
	//$("#imageMessage").empty();
	$(this).parent().find('.load-imgs').empty();
	var file = this.files;
	var input = $(this);
	for (var i = 0; i < $(this).get(0).files.length; ++i) {
		var file = $(this).get(0).files[i];
		var imagefile = file.type;
		var match= ["image/jpeg","image/png","image/jpg","image/gif"];
		if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2]) || (imagefile==match[3]) ))
		{
			return false;
		}
		else
		{
			var reader = new FileReader();
			reader.readAsDataURL(file);

			reader.onload = function imageIsLoaded(e) {
				input.addClass('is-valid');
				input.removeClass('is-invalid');
				input.parent().find('.load-imgs').append('<div class="col-md-4 load-image-container"><div class="load-img" style="background-image: url('+e.target.result+')"></div></div>');
			};

		}
	}
});
$('.load-img .delete-image').click(function () {
	var container = $(this).parents('.load-image-container').first();
	var index = container.index();
	var imagesList = JSON.parse($('#images_list').val());
	imagesList.splice(index, 1);
	$('#images_list').val(JSON.stringify(imagesList));
	container.remove();
});



$('.validation-form').submit(function (e) {

	var submit = false;
	$(this).find('.error').remove();
	$(this).find('.input-error').removeClass('input-error');
	$(this).find('.required').each(function () {
		if($(this).val().length < 1){
			submit = true;
			if($(this).hasClass('select2')){
				$(this).next().find('.select2-selection').addClass('input-error');
				$(this).next().after('<div class="error">Это поле обязательно к заполнению</div>');
			}else if($(this).hasClass('editor')){
				$(this).parents('.form-group').addClass('input-error');
				$(this).next().after('<div class="error">Это поле обязательно к заполнению</div>');
			}else{
				$(this).after('<div class="error">Это поле обязательно к заполнению</div>');
				$(this).addClass('input-error');
			}

		}
	});
	if(submit){
		e.preventDefault();
		return false;
	}
});


/* Questions */

$(document).ready(function(){
	var page = 1;
	var base_url = $('input[name="ajax_url"]').val();

	if($('input[name="ajax_url"]').length > 0){
		getQuestionsAjax(base_url,page)
	}
});

function getQuestionsAjax(base_url,page) {

	var url = base_url+'?page=' + page;
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
		}
	)
	.done(function(data)
	{



		$(".ajax-questions").append(data.html);

		if(data.isNext){
			page++;
			getQuestionsAjax(base_url,page);
		}else{
			$('.question-item').each(function () {
				initQuestionAction(this);
			});
		}

	})
	.fail(function(jqXHR, ajaxOptions, thrownError)
		{
			alert('server not responding...');
		}
	);

}

var answerTemplate = '<div class="form-group form-child-item row item-sort">\n' +
	'<input type="hidden" name="--id--_children_id[]" value="--id_answer--"> \n'+

	'<div class="col-md-3">' +
	'       <label><img src="/public/images/russia.png" alt="Флаг России"> Значение варианта ответа<span class="input-request">*</span></label>\n' +
	'       <input type="text" name="question_children_--id--[]" class="form-control required" placeholder="Введите вариант ответа...">\n' +
	'</div>' +
	'<div class="col-md-3">' +
	'       <label><img src="/public/images/ukraine.png" alt="Флаг Украины"> Значение варианта ответа</label>\n' +
	'       <input type="text" name="question_children_ua_--id--[]" class="form-control" placeholder="Введите вариант ответа...">\n' +
	'</div>' +
	'<div class="col-md-3">' +
	'       <label><img src="/public/images/united-kingdom.png" alt="Флаг Великой бриатнии"> Значение варианта ответа</label>\n' +
	'       <input type="text" name="question_children_en_--id--[]" class="form-control" placeholder="Введите вариант ответа...">\n' +
	'</div>' +
	'<div class="col-md-3"> ' +
	'<div class="btn btn-danger btn-block delete-child" style="margin-top: 25px">Удалить вариант</div>' +
	'</div>' +
	'<div class="col-md-12">id: <input type="text" value="--id_answer--" readonly></div><br> '+
	'</div>';



$('div.add-zone').click(function () {
	var newQuestion = $('.new-template').find('.question-item').clone().appendTo('.questions-list');
	var id = Date.now();
	$(newQuestion).attr('id','question_'+id);
	var replaced = $(newQuestion).html().replace(/\[\]/g,'['+id+']');
	$(newQuestion).html(replaced);
	$(newQuestion).find('.question_id').val(id);
	$(newQuestion).find('.none-required').addClass('required');
	$(newQuestion).find('.required').removeClass('none-required');
	initQuestionAction(newQuestion);
	$(".editor").each(function () {
		if($(this).parents('.new-template').length == 0){
			$(this).ckeditor(options);
		}
	});
});

$('.question-item').each(function () {
	initQuestionAction(this);
});

function initQuestionAction(questionItem){
	$('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
		checkboxClass: 'icheckbox_minimal-red',
		radioClass   : 'iradio_minimal-red'
	});
	$(questionItem).find('.add-varrible').click(addVarible);
	$(questionItem).find('.question_type').change(function () {
		var id = $(this).parents('.question-item').attr('id');
		var childContainer = $(this).parents('.question-body').find('.child-consructor');
		$(childContainer).html('');
		switch ($(this).val()){
			case "3":
			case "4":
			case "5":
				$(childContainer).addClass('active');
				$(childContainer).append('<label class="child-contructor-title">Варианты ответов</label>' +
					'<div class="list-questions list-child list-sort">' +
					answerTemplate.split('--id--').join(id).split('--id_answer--').join(Date.now())
					+
					'</div>' +
					'<div><div class="btn btn-default add-varrible">Добавить вариант</div>' +
					'' +
					'<label class="child-other">' +
					'    <input type="checkbox" class="minimal-red other" name="'+id+'_other" value="true">\n' +
					'       Добавить вариант другое?\n' +
					'</label>' +
					'</div>');

				$(childContainer).find('.add-varrible').click(addVarible);
				break;
			default:
				$(childContainer).removeClass('active');
		}
		$( ".list-sort" ).sortable();
		$('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
			checkboxClass: 'icheckbox_minimal-red',
			radioClass   : 'iradio_minimal-red'
		});
	});

	$(questionItem).find('.question-header').click(function () {
		$(this).parent().find('.question-body').slideToggle(500);
		$(this).parent().toggleClass('active');
	});

	$('.delete-question').click(function () {
		$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
		$('#modal-warning').find(".modal-body").html("<p>Вы уверенны что хотите удалить этот вопрос?</p>");
		var id = $(this).parents('.question-item').attr('id');
		$('#modal-warning').find("#success").attr('onclick','deleteQuestion("'+id+'")');
		$('#modal-warning').modal('show');
	});

	$('.question-name').change(function () {
		$(this).parents('.question-item').find('.question-title').text($(this).val());
	});

	$('.delete-child-ajax').click(delete_child_ajax);

}

function deleteQuestion(id) {
	$('#modal-warning').modal('hide');
	var id = id.replace('question_','');
	deleteOption(id,$('#question_'+id));
}

function addVarible() {
	var id = $(this).parents('.question-item').attr('id');
	$(this).parent().parent().find('.list-child').append(answerTemplate.split('--id--').join(id).split('--id_answer--').join(Date.now()));
	initAnswerAction();
}

function initAnswerAction() {
	$('.delete-child').click(function () {
		var id = $(this).parents('.form-child-item').children('input[type="hidden"]').val();
		deleteOption(id, $(this).parents('.form-child-item'));
	});
}

//$('.add-varrible').click(addVarible);
initAnswerAction();

$('.delete-child-ajax').click(delete_child_ajax);

function delete_child_ajax() {
	$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
	$('#modal-warning').find(".modal-body").html("<p>Удаление этого варианта приведет к удалению всех ответов на него!</p>");
	var id = $(this).attr('id').replace('delete-','');
	$('#modal-warning').find("#success").attr('onclick','delete_child_item('+id+')');
	$('#modal-warning').modal('show');

}

function delete_child_item(id) {
	var elem = $('#delete-'+id).parent().parent();
	deleteOption(id,elem)
}

function deleteOption(id,element) {
	$('#modal-warning').modal('hide');
	var url = "/admin/questionnaire/questions/delete/"+id+"/";

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$.ajax({
		type: "GET",
		url: url,
		success: function(resp)
		{
			if(resp==="ok"){
				$(element).remove();
			}
		},
		error:  function(xhr, str){
			alert('Возникла ошибка: ' + xhr.responseCode);
		}
	});
}

function deleteAjax(url) {
	$('#modal-warning').modal('hide');
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$.ajax({
		type: "GET",
		url: url,
		success: function(resp)
		{
			if(resp==="ok"){
				location.reload();
			}else{
				location.reload();
			}
		},
		error:  function(xhr, str){
			alert('Возникла ошибка: ' + xhr.responseCode);
		}
	});
}



function AjaxNotRefresh(url) {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$.ajax({
		type: "GET",
		url: url,
		success: function(resp)
		{
			window.gropAjaxCount--;
			if(window.gropAjaxCount == 0){
				location.reload();
			}
		},
		error:  function(xhr, str){
			console.log('Возникла ошибка: ' + xhr.responseCode);
			window.gropAjaxCount--;
			if(window.gropAjaxCount == 0){
				location.reload();
			}
		}
	});
}

function deleteQuestions(){
	$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
	$('#modal-warning').find(".modal-body").html("<p>Удаление этих вопросов приведет к удалению всех ответов на них!<br>Отменить действие будет невозможно!</p>");
	$('#modal-warning').find("#success").attr('onclick','groupAjax("/admin/questionnaire/questions/delete/--id--/")');
	$('#modal-warning').modal('show');
}

var gropAjaxCount;
function groupAjax(url){
	$('#modal-warning').modal('hide');
	var count = 0;
	window.gropAjaxCount = 0
	$('input.checkbox-item').each(function () {
		if($(this).prop("checked")){
			var id = $(this).attr('id').replace('item-','');
			if(isFinite(id)){
				var itemUrl = url.replace('--id--',id);
				window.gropAjaxCount++;
				AjaxNotRefresh(itemUrl);
			}

		}
	});
}


/* End Question */

/* Questionnaire */

$('#questionnaire_type').change(function () {
	if($(this).val() != "1" && $(this).val() != "5" && $(this).val()){
		$('.select-project').slideDown(500);
		$('.select-project select').addClass('required');
	}else{
		$('.select-project').slideUp(500);
		$('.select-project select').removeClass('required');
	}
});

$("#add-question").click(function () {
	var id = $('#questionns_list').val();
	var text = $("#questionns_list option:selected").text();
	if(id){
		$('.list-questions').append(
			'<div class="form-group form-child-item row item-sort">\n' +
			'   <div class="col-md-10 question-name">\n' +
			'      <input type="hidden" value="'+id+'" name="questions[]">' +text +
			'   </div>\n' +
			'   <div class="col-md-2">\n' +
			'      <div class="btn btn-danger btn-block delete-child"  >Убрать вопрос</div>\n' +
			'   </div>\n' +
			'</div>'
		);
	}
	$('#questionns_list option').eq(0).prop('selected', true);
	$('#questionns_list option').eq(0).change();
	$('.delete-child').click(function () {
		$(this).parents('.form-child-item').remove();
	});
});

function deleteQuestionnaireQuestion(id) {
	$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
	$('#modal-warning').find(".modal-body").html("<p>Удаление этого вопроса приведет к потере всех ответов на него!</p>");
	$('#modal-warning').find("#success").attr('onclick','deleteQuestionnaireQuestionAjax('+id+')');
	$('#modal-warning').modal('show');
}
function deleteQuestionnaireQuestionAjax(id) {
	$('#modal-warning').modal('hide');
	var url = "/admin/questionnaire-question/delete/"+id+"/";

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$.ajax({
		type: "GET",
		url: url,
		success: function(resp)
		{
			if(resp==="ok"){
				$('#child-'+id).remove();
			}else{

			}
		},
		error:  function(xhr, str){
			alert('Возникла ошибка: ' + xhr.responseCode);
		}
	});
}

function deleteQuestionnaire(id) {
	$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
	$('#modal-warning').find(".modal-body").html("<p>Удаление этой анкеты приведет к потере всех ответов на неё!<br>Отменить действие будет невозможно!</p>");
	$('#modal-warning').find("#success").attr('onclick','deleteAjax("/admin/questionnaire/delete/'+id+'/")');
	$('#modal-warning').modal('show');
}

function deleteQuestionnaires() {
	$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
	$('#modal-warning').find(".modal-body").html("<p>Удаление этих анкет приведет к потере всех ответов на них!<br>Отменить действие будет невозможно!</p>");
	$('#modal-warning').find("#success").attr('onclick','groupAjax("/admin/questionnaire/delete/--id--/")');
	$('#modal-warning').modal('show');
}

function deleteRequest(id) {
	$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
	$('#modal-warning').find(".modal-body").html("<p>Удаление этой анкеты приведет к потере всех ответов на неё!<br>Отменить действие будет невозможно!</p>");
	$('#modal-warning').find("#success").attr('onclick','deleteAjax("/admin/project/requests/delete/'+id+'/")');
	$('#modal-warning').modal('show');
}

function deleteRequests() {
	$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
	$('#modal-warning').find(".modal-body").html("<p>Удаление этих анкет приведет к потере всех ответов на них!<br>Отменить действие будет невозможно!</p>");
	$('#modal-warning').find("#success").attr('onclick','groupAjax("/admin/project/requests/delete/--id--/")');
	$('#modal-warning').modal('show');
}


/* End Questionnaire */

/* Project */

function deleteProject(id) {
	$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
	$('#modal-warning').find(".modal-body").html("<p>Удаление этого проекта приведет к потере всех заявок, отзывов и всех связанных с нею страниц!<br>Отменить действие будет невозможно!</p>");
	$('#modal-warning').find("#success").attr('onclick','deleteAjax("/admin/project/delete/'+id+'/")');
	$('#modal-warning').modal('show');
}

function deleteProjects() {
	$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
	$('#modal-warning').find(".modal-body").html("<p>Удаление этих проектов приведет к потере всех заявок, отзывов и всех связанных с ними страниц!<br>Отменить действие будет невозможно!</p>");
	$('#modal-warning').find("#success").attr('onclick','groupAjax("/admin/project/delete/--id--/")');
	$('#modal-warning').modal('show');
}

/* End Project */

/* Project */

function deleteProjectPost(id) {
	$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
	$('#modal-warning').find(".modal-body").html("<p>Отменить удаление этого поста будет невозможно!</p>");
	$('#modal-warning').find("#success").attr('onclick','deleteAjax("/admin/project/post/delete/'+id+'/")');
	$('#modal-warning').modal('show');
}

function deleteProjectPosts() {
	$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
	$('#modal-warning').find(".modal-body").html("<p>Отменить удаление этих постов будет невозможно!</p>");
	$('#modal-warning').find("#success").attr('onclick','groupAjax("/admin/project/post/delete/--id--/")');
	$('#modal-warning').modal('show');
}

/* End Project */

/* Project Category */

function deleteProjectCategory(id) {
	$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
	$('#modal-warning').find(".modal-body").html("<p>Удаление этой категории приведет к потери доступа к проектам из этой категории для пользователей!<br>Отменить действие будет невозможно!</p>");
	$('#modal-warning').find("#success").attr('onclick','deleteAjax("/admin/project/category/delete/'+id+'/")');
	$('#modal-warning').modal('show');
}

function deleteProjectCategories() {
	$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
	$('#modal-warning').find(".modal-body").html("<p>Удаление этих категорий приведет к потери доступа к проектам из этих категорий для пользователей!<br>Отменить действие будет невозможно!</p>");
	$('#modal-warning').find("#success").attr('onclick','groupAjax("/admin/project/category/delete/--id--/")');
	$('#modal-warning').modal('show');
}

/* End Project Category */

/* Project Subpage */

function deleteSubpage(id) {
	$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
	$('#modal-warning').find(".modal-body").html("<p>Удаление этой подстраницы приведет к потери доступа к отзывам и комментариям оставленных пользователями на ней!<br>Отменить действие будет невозможно!</p>");
	$('#modal-warning').find("#success").attr('onclick','deleteAjax("/admin/project/subpages/delete/'+id+'/")');
	$('#modal-warning').modal('show');
}

function deleteSubpages() {
	$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
	$('#modal-warning').find(".modal-body").html("<p>Удаление этих подстраниц приведет к потери доступа к отзывам и комментариям оставленных пользователями на них!<br>Отменить действие будет невозможно!</p>");
	$('#modal-warning').find("#success").attr('onclick','groupAjax("/admin/project/subpages/delete/--id--/")');
	$('#modal-warning').modal('show');
}

/* End Project Subpage */

/* Users page */

function deleteUser(id) {
	$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
	$('#modal-warning').find(".modal-body").html("<p>Удаление этого пользователя приведет к потери всех данных о нём и может привести к потери отзывов, комментариев, заявок и ответов на анкеты!<br>Отменить действие будет невозможно!</p>");
	$('#modal-warning').find("#success").attr('onclick','deleteAjax("/admin/users/delete/'+id+'/")');
	$('#modal-warning').modal('show');
}

function deleteUsers() {
	$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
	$('#modal-warning').find(".modal-body").html("<p>Удаление этоих пользователей приведет к потери всех данных о нём и может привести к потери отзывов, комментариев, заявок и ответов на анкеты!<br>Отменить действие будет невозможно!</p>");
	$('#modal-warning').find("#success").attr('onclick','groupAjax("/admin/users/delete/--id--/")');
	$('#modal-warning').modal('show');
}

/* End Users page */

/* Users restore */

function restoreUser(id) {
	$('#modal-warning').find(".modal-title").text("Подтвердите востановление");
	$('#modal-warning').find(".modal-body").html("<p>Вы уверены что хотите востановить пользователя?</p>");
	$('#modal-warning').find("#success").attr('onclick','deleteAjax("/admin/users/restore/'+id+'/")');
	$('#modal-warning').modal('show');
}

function restoreUsers() {
	$('#modal-warning').find(".modal-title").text("Подтвердите востановление");
	$('#modal-warning').find(".modal-body").html("<p>Вы уверены что хотите востановить пользователей?</p>");
	$('#modal-warning').find("#success").attr('onclick','groupAjax("/admin/users/restore/--id--/")');
	$('#modal-warning').modal('show');
}

/* End Users restore */

/* Users page */

function deleteBlogger(id) {
	$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
	$('#modal-warning').find(".modal-body").html("<p>Удаление этого блоггера приведет к потери всех данных о нём и может привести к ошибкам в системе!<br>Отменить действие будет невозможно!</p>");
	$('#modal-warning').find("#success").attr('onclick','deleteAjax("/admin/users/blogger/delete/'+id+'/")');
	$('#modal-warning').modal('show');
}

/* End Users page */

/* Reviews page */

function deleteReview(id) {
	$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
	$('#modal-warning').find(".modal-body").html("<p>Удаление этого отзыва приведет к потери всех комментариев оставленных к нему.<br>Отменить действие будет невозможно!</p>");
	$('#modal-warning').find("#success").attr('onclick','deleteAjax("/admin/reviews/delete/'+id+'/")');
	$('#modal-warning').modal('show');
}

function deleteReviews() {
	$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
	$('#modal-warning').find(".modal-body").html("<p>Удаление этих отзывов приведет к потери всех комментариев оставленных к ним.<br>Отменить действие будет невозможно!</p>");
	$('#modal-warning').find("#success").attr('onclick','groupAjax("/admin/reviews/delete/--id--/")');
	$('#modal-warning').modal('show');
}

/* End Reviews page */

/* Comments page */

function deleteComment(id) {
	$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
	$('#modal-warning').find(".modal-body").html("<p>Удаление этого комментария приведет к невозможности его востановления!</p>");
	$('#modal-warning').find("#success").attr('onclick','deleteAjax("/admin/reviews/comments/delete/'+id+'/")');
	$('#modal-warning').modal('show');
}

function deleteComments() {
	$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
	$('#modal-warning').find(".modal-body").html("<p>Удаление этих комментариев приведет к невозможности их востановления!</p>");
	$('#modal-warning').find("#success").attr('onclick','groupAjax("/admin/reviews/comments/delete/--id--/")');
	$('#modal-warning').modal('show');
}

/* End Comments page */

/* Messages page */

function deleteProjectMessage(id) {
	$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
	$('#modal-warning').find(".modal-body").html("<p>Удаление этого сообщения приведёт к потери всех данных оставленных в нём.<br>Отменить действие будет невозможно!</p>");
	$('#modal-warning').find("#success").attr('onclick','deleteAjax("/admin/project/messages/delete/'+id+'/")');
	$('#modal-warning').modal('show');
}

function deleteProjectMessages() {
	$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
	$('#modal-warning').find(".modal-body").html("<p>Удаление этих сообщениний приведёт к потери всех данных оставленных в них.<br>Отменить действие будет невозможно!</p>");
	$('#modal-warning').find("#success").attr('onclick','groupAjax("/admin/project/messages/delete/--id--/")');
	$('#modal-warning').modal('show');
}

/* End Messages page */

/* Links page */

function deleteProjectLink(id) {
	$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
	$('#modal-warning').find(".modal-body").html("<p>Удаление этой ссылки приведёт к потери всех данных оставленных в ней.<br>Отменить действие будет невозможно!</p>");
	$('#modal-warning').find("#success").attr('onclick','deleteAjax("/admin/project/links/delete/'+id+'/")');
	$('#modal-warning').modal('show');
}

function deleteProjectLinks() {
	$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
	$('#modal-warning').find(".modal-body").html("<p>Удаление этих ссылок приведёт к потери всех данных оставленных в них.<br>Отменить действие будет невозможно!</p>");
	$('#modal-warning').find("#success").attr('onclick','groupAjax("/admin/project/links/delete/--id--/")');
	$('#modal-warning').modal('show');
}

/* End Links page */

/* Pages page */

function deletePage(id) {
	$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
	$('#modal-warning').find(".modal-body").html("<p>Удаление этой страницы приведёт к потери всей информации на ней.<br>Отменить действие будет невозможно!</p>");
	$('#modal-warning').find("#success").attr('onclick','deleteAjax("/admin/page/delete/'+id+'/")');
	$('#modal-warning').modal('show');
}

function deletePages() {
	$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
	$('#modal-warning').find(".modal-body").html("<p>Удаление этих страниц приведёт к потери всей информации на них.<br>Отменить действие будет невозможно!</p>");
	$('#modal-warning').find("#success").attr('onclick','groupAjax("/admin/page/delete/--id--/")');
	$('#modal-warning').modal('show');
}

/* End Pages page */

/* Posts page */

function deletePost(id) {
	$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
	$('#modal-warning').find(".modal-body").html("<p>Удаление этой статьи приведёт к потери всей информации на ней.<br>Отменить действие будет невозможно!</p>");
	$('#modal-warning').find("#success").attr('onclick','deleteAjax("/admin/blog/delete/'+id+'/")');
	$('#modal-warning').modal('show');
}

function deletePosts() {
	$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
	$('#modal-warning').find(".modal-body").html("<p>Удаление этих сатей приведёт к потери всей информации на них.<br>Отменить действие будет невозможно!</p>");
	$('#modal-warning').find("#success").attr('onclick','groupAjax("/admin/blog/delete/--id--/")');
	$('#modal-warning').modal('show');
}

/* End Posts page */

/* Comments page */

function deleteBlogComment(id) {
	$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
	$('#modal-warning').find(".modal-body").html("<p>Удаление этого комментария приведет к невозможности его востановления!</p>");
	$('#modal-warning').find("#success").attr('onclick','deleteAjax("/admin/blog/comments/delete/'+id+'/")');
	$('#modal-warning').modal('show');
}

function deleteBlogComments() {
	$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
	$('#modal-warning').find(".modal-body").html("<p>Удаление этих комментариев приведет к невозможности их востановления!</p>");
	$('#modal-warning').find("#success").attr('onclick','groupAjax("/admin/blog/comments/delete/--id--/")');
	$('#modal-warning').modal('show');
}

/* End Comments page */

/* Tag page */

function deleteBlogTag(id) {
	$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
	$('#modal-warning').find(".modal-body").html("<p>Удаление этого тега приведет к невозможности его востановления!</p>");
	$('#modal-warning').find("#success").attr('onclick','deleteAjax("/admin/blog/tag/delete/'+id+'/")');
	$('#modal-warning').modal('show');
}

function deleteBlogTags() {
	$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
	$('#modal-warning').find(".modal-body").html("<p>Удаление этих тегов приведет к невозможности их востановления!</p>");
	$('#modal-warning').find("#success").attr('onclick','groupAjax("/admin/blog/tag/delete/--id--/")');
	$('#modal-warning').modal('show');
}

/* End Tag page */

/* Faq */


function deleteFaqCategory(id) {
	$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
	$('#modal-warning').find(".modal-body").html("<p>Удаление этой группы приведет к потере всех вопросов в ней!<br>Отменить действие будет невозможно!</p>");
	$('#modal-warning').find("#success").attr('onclick','deleteAjax("/admin/faq/delete/'+id+'/")');
	$('#modal-warning').modal('show');
}

function deleteFaqCategories() {
	$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
	$('#modal-warning').find(".modal-body").html("<p>Удаление этих групп приведет к потере всех вопросов в них!<br>Отменить действие будет невозможно!</p>");
	$('#modal-warning').find("#success").attr('onclick','groupAjax("/admin/faq/delete/--id--/")');
	$('#modal-warning').modal('show');
}

/* End Faq */

/* Faq */


function deleteFeedback(id) {
	$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
	$('#modal-warning').find(".modal-body").html("<p>Отменить действие будет невозможно!</p>");
	$('#modal-warning').find("#success").attr('onclick','deleteAjax("/admin/feedback/delete/'+id+'/")');
	$('#modal-warning').modal('show');
}

function deleteFeedbacks() {
	$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
	$('#modal-warning').find(".modal-body").html("<p>Отменить действие будет невозможно!</p>");
	$('#modal-warning').find("#success").attr('onclick','groupAjax("/admin/feedback/delete/--id--/")');
	$('#modal-warning').modal('show');
}

/* End Faq */


/* Countries page */

function deleteCountry(id) {
    $('#modal-warning').find(".modal-title").text("Подтвердите удаление");
    $('#modal-warning').find(".modal-body").html("<p>Удаление этой страны приведет к потери всех областей и городов связанных с ней.<br>Отменить действие будет невозможно!</p>");
    $('#modal-warning').find("#success").attr('onclick','deleteAjax("/admin/countries/delete/'+id+'/")');
    $('#modal-warning').modal('show');
}

function deleteCountries() {
    $('#modal-warning').find(".modal-title").text("Подтвердите удаление");
    $('#modal-warning').find(".modal-body").html("<p>Удаление этих страны приведет к потери всех областей и городов связанных с ними.<br>Отменить действие будет невозможно!</p>");
    $('#modal-warning').find("#success").attr('onclick','groupAjax("/admin/countries/delete/--id--/")');
    $('#modal-warning').modal('show');
}

/* End Countries page */


/* Regions page */

function deleteRegion(id) {
    $('#modal-warning').find(".modal-title").text("Подтвердите удаление");
    $('#modal-warning').find(".modal-body").html("<p>Удаление этой области приведет к потери всех городов связанных с ней.<br>Отменить действие будет невозможно!</p>");
    $('#modal-warning').find("#success").attr('onclick','deleteAjax("/admin/regions/delete/'+id+'/")');
    $('#modal-warning').modal('show');
}

function deleteRegions() {
    $('#modal-warning').find(".modal-title").text("Подтвердите удаление");
    $('#modal-warning').find(".modal-body").html("<p>Удаление этих областей приведет к потери всех городов связанных с ними.<br>Отменить действие будет невозможно!</p>");
    $('#modal-warning').find("#success").attr('onclick','groupAjax("/admin/regions/delete/--id--/")');
    $('#modal-warning').modal('show');
}

/* End Regions page */


/* Regions page */

function deleteCity(id) {
    $('#modal-warning').find(".modal-title").text("Подтвердите удаление");
    $('#modal-warning').find(".modal-body").html("<p>Удаление этого горда приведет к потери этого города у пользователей.<br>Отменить действие будет невозможно!</p>");
    $('#modal-warning').find("#success").attr('onclick','deleteAjax("/admin/cities/delete/'+id+'/")');
    $('#modal-warning').modal('show');
}

function deleteCities() {
    $('#modal-warning').find(".modal-title").text("Подтвердите удаление");
    $('#modal-warning').find(".modal-body").html("<p>Удаление этих городов приведет к потери этих городов у пользователей.<br>Отменить действие будет невозможно!</p>");
    $('#modal-warning').find("#success").attr('onclick','groupAjax("/admin/cities/delete/--id--/")');
    $('#modal-warning').modal('show');
}

/* End Regions page */

/* Phones */

function deletePhones() {
    $('#modal-warning').find(".modal-title").text("Подтвердите удаление");
    $('#modal-warning').find(".modal-body").html("<p>Удаление этой записи приведет к потери возможности верефицировать этот номер!<br>Отменить действие будет невозможно!</p>");
    $('#modal-warning').find("#success").attr('onclick','groupAjax("/admin/users/phones/delete/--id--/")');
    $('#modal-warning').modal('show');
}

/* Phones */


function endStatus(id){
	$('#modal-warning').find(".modal-title").text("Подтвердите досрочную смену статуса");
	$('#modal-warning').find(".modal-body").html("<p>Досрочная смена статуса приведёт к отмене текущего статуса и востановит пользователю его предыдущий статус.</p>");
	$('#modal-warning').find("#success").attr('onclick','deleteAjax("/admin/users/end-status/'+id+'/")');
	$('#modal-warning').modal('show');
}

/* Filters */

$('.filter-name').click(function () {
	$(this).parent().find('.filter-options').slideToggle(500);
	$(this).toggleClass('active');
});

/* End filters */

/* check all */

$(".check_all").click(function () {
	$('.checkbox-item').iCheck('check');
})

/* end check all */
