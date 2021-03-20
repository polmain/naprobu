@extends('admin.layouts.layout')

@section('content')
    @if(session('success'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> {{session('success')}}</h4>
    </div>
    @endif

    <div class='row'>
        <form action="{{route('adm_users_export_generate')}}" method="post" enctype="multipart/form-data" class="validation-form">
            {{ csrf_field() }}
            <div class='col-md-9'>
                <!-- Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Настройки экспорта</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group row">
                            <div class="col-md-4">Параметр</div>
                            <div class="col-md-8">Фильтр</div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">Пол</div>

                            <div class="col-md-8">
                                <select name="filter[sex]" class="form-control">
                                    <option value="">--</option>
                                    <option value="1">Мужской</option>
                                    <option value="0">Женский</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">Год рождения</div>

                            <div class="col-md-4">
                                <input type="text" name="filter[old_min]" class="form-control" placeholder="от">
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="filter[old_max]" class="form-control" placeholder="до">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">Город</div>
                            <div class="col-md-8">
                                <input type="text" class="form-control tags" name="filter[city]" data-role="tagsinput">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">Область</div>
                            <div class="col-md-8">
                                <input type="text" class="form-control tags" name="filter[region]" data-role="tagsinput">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-4">Роль пользователя</div>
                            <div class="col-md-8">
                                <select name="filter[role]" class="form-control">
                                    <option value="">--</option>
                                    <option value="admin">Администраторы</option>
                                    <option value="moderator">Модераторы</option>
                                    <option value="bloger">Блогеры</option>
                                    <option value="expert">Эксперты</option>
                                    <option value="user">Пользователи</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">Статус пользователя</div>
                            <div class="col-md-8">
                                <select name="filter[status]" class="form-control">
                                    <option value="">--</option>
                                    @foreach($statuses as $status)
                                        <option value="{{$status->id}}">{{$status->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">Подавал заявку в проект</div>
                            <div class="col-md-8">
                                <select class="form-control" id="project" name="filter[project][]" multiple="multiple">
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">Был экспертом в проекте</div>
                            <div class="col-md-8">
                                <select class="form-control" id="projectExpert" name="filter[projectExpert][]" multiple="multiple">
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">Отвечал на вопросы</div>
                            <div class="col-md-8">
                                <select class="form-control" id="questions" name="filter[questions][]" multiple="multiple">
                                </select>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
            <div class="col-md-3">
                <!-- Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Действия</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <button type="submit" class="btn btn-block btn-primary btn-lg">Сгенерировать excel</button>
                        <button type="button" class="btn btn-block btn-danger btn-lg" onclick="document.location.href='/admin/users/';">Отмена</button>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                <!-- Box -->
            </div>
        </form>
    </div><!-- /.row -->


@endsection

@section("scripts")
    <script>

		$("input.tags").tagsinput('items');
		$('#project,#projectExpert').select2({
			placeholder: "Выберите проект...",
            tegs: true,
			minimumInputLength: 2,
			ajax: {
				url: '{!! route('adm_project_find') !!}',
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
		$('#questions').select2({
			placeholder: "Выберите вопрос...",
            tegs: true,
			minimumInputLength: 2,
			ajax: {
				url: '{!! route('adm_question_find') !!}',
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

    </script>
@endsection