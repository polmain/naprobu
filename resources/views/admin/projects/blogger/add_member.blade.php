@extends('admin.layouts.layout')

@section('content')

    <div class='row'>
            <div class='col-md-9'>
                <!-- Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Поиск блоггеров</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <form id="find_bloggers_form" action="{{route('adm_project_blogger_find_bloggers')}}" method="post" enctype="multipart/form-data" class="validation-form">
                        {{ csrf_field() }}
                    <div class="box-body">

                        <div class="form-group row">
                            <div class="col-md-3">
                                <label for="bloggers" class=" control-label ">Название</label>
                                <div class="">
                                    <select class="form-control" name="bloggers[]" id="bloggers" multiple="multiple">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="categories" class=" control-label ">Категории</label>
                                <div class="">
                                    <select class="form-control" name="categories[]" id="categories" multiple="multiple">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="subjects" class=" control-label ">Тематики</label>
                                <div class="c">
                                    <select class="form-control" name="subjects[]" id="subjects" multiple="multiple">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="cities" class=" control-label ">Города</label>
                                <div class="">
                                    <select class="form-control" name="cities[]" id="cities" multiple="multiple">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3">
                                <label for="social" class=" control-label ">Соц.сети</label>
                                <div class="">
                                    <select class="form-control" name="social" id="social">
                                        <option value=""></option>
                                        <option value="instagram_link">Instagram</option>
                                        <option value="facebook_link">Facebook</option>
                                        <option value="youtube_link">YouTube</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div><!-- /.box-body -->
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-md-4 col-md-offset-4">
                                    <button type="submit" name="submit" value="save-close" class="btn btn-block btn-success btn-lg">Подобрать</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div><!-- /.box -->
                <!-- Box -->
            </div>
            <form action="{{route('adm_project_blogger_save_add_member',['project_id'=>$project->id])}}" method="post" enctype="multipart/form-data" class="validation-form">
                {{ csrf_field() }}
                <div class="col-md-3 pull-right">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Действия</h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            <button type="submit" name="submit" value="save" class="btn btn-block btn-primary btn-lg">Добавить в проект</button>
                            <button type="submit" name="submit" class="btn btn-block btn-success btn-lg">Экспорт</button>
                            <button type="button" class="btn btn-block btn-danger btn-lg" onclick="document.location.href='/admin/project/edit/{{$project->id}}';">Отмена</button>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div>
                <div class="col-md-9">
                    <!-- Box -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Список блоггеров</h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                            <div class="box-body" id="blogger_list">

                            </div><!-- /.box-body -->
                            <div class="box-footer">
                                <button type="button" id="check_all" class="btn btn-primary">Отметить все</button>
                            </div>
                    </div><!-- /.box -->
                </div>
            </form>
    </div><!-- /.row -->

@endsection

@section("scripts")
    <script>
		$('#bloggers').select2({
			placeholder: "Выберите блоггеров..",
			tegs: true,
			minimumInputLength: 0,
			ajax: {
				url: '{!! route('adm_users_blogger_find') !!}',
				dataType: 'json',
				data: function (params) {
					return {
						name: params.term
					};
				},
				processResults: function (data) {
					return {
						results: data
					};
				},
				cache: true
			}
		});
		$('#cities').select2({
			placeholder: "Выберите города..",
			tegs: true,
			minimumInputLength: 0,
			ajax: {
				url: '{!! route('adm_users_blogger_city_find') !!}',
				dataType: 'json',
				data: function (params) {
					return {
						name: params.term
					};
				},
				processResults: function (data) {
					return {
						results: data
					};
				},
				cache: true
			}
		});
		$('#categories').select2({
			placeholder: "Выберите категории...",
			tegs: true,
			minimumInputLength: 0,
			ajax: {
				url: '{!! route('adm_users_blogger_category_find') !!}',
				dataType: 'json',
				data: function (params) {
					return {
						name: params.term
					};
				},
				processResults: function (data) {
					return {
						results: data
					};
				},
				cache: true
			}
		});
		$('#subjects').select2({
			placeholder: "Выберите тематики...",
			tegs: true,
			minimumInputLength: 0,
			ajax: {
				url: '{!! route('adm_users_blogger_subject_find') !!}',
				dataType: 'json',
				data: function (params) {
					return {
						name: params.term
					};
				},
				processResults: function (data) {
					return {
						results: data
					};
				},
				cache: true
			}
		});
		$('#social').select2({
			placeholder: "Выберите тематики...",
			tegs: true,
			minimumInputLength: -1,
		});

		$('#find_bloggers_form').submit(function (e) {
			e.preventDefault();
			form = $(this);
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				type: "GET",
				url: "{{route('adm_project_blogger_find_bloggers')}}",
				data: form.serialize(),
				success: function(resp)
				{
					$('#blogger_list').html(resp.html);
					afterDrawTabel();
				},
				error:  function(xhr, str){
					alert('Возникла ошибка: ' + xhr.responseCode);
				}
			});

			return false;
		});
        $("#check_all").click(function () {
			$('.checkbox-item').iCheck('check');
		})
    </script>
@endsection

