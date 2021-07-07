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
                            <div class="col-md-4">id</div>
                            <div class="col-md-4">
                                <input type="text" name="filter[id_min]" class="form-control" placeholder="от">
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="filter[id_max]" class="form-control" placeholder="до">
                            </div>
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
                            <div class="col-md-4">Возраст</div>
                            <div class="col-md-4">
                                <input type="text" name="filter[old_min]" class="form-control" placeholder="от">
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="filter[old_max]" class="form-control" placeholder="до">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">Страна</div>
                            <div class="col-md-8">
                                <select class="form-control select2" name="filter[country]" id="country_id">
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">Область</div>
                            <div class="col-md-8">
                                <select class="form-control select2" name="filter[region]" id="region_id">
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">Город</div>
                            <div class="col-md-8">
                                <select class="form-control select2" name="filter[city][]" multiple="multiple" id="city_id">
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-4">Образование</div>
                            <div class="col-md-8">
                                <select name="filter[education][]" id="education" class="form-control select2-multiple" multiple="multiple">
                                    <option></option>
                                    @foreach($educationArray as $education)
                                        <option value="{{$education}}">@lang("education.".$education)</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">Занятость</div>
                            <div class="col-md-8">
                                <select name="filter[employment][]" id="employment" class="form-control select2-multiple" multiple="multiple">
                                    <option></option>
                                    @foreach($employmentArray as $employment)
                                        <option value="{{$employment}}" >@lang("employment.".$employment)</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">Кем работает</div>
                            <div class="col-md-8">
                                <select name="filter[work][]" id="work" class="form-control select2-multiple" multiple="multiple">
                                    <option></option>
                                    @foreach($workArray as $work)
                                        <option value="{{$work}}">@lang("work.".$work)</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">Семейное положение</div>
                            <div class="col-md-8">
                                <select name="filter[family_status][]" id="family_status" class="form-control select2-multiple" multiple="multiple">
                                    <option></option>
                                    @foreach($familyStatusArray as $familyStatus)
                                        <option value="{{$familyStatus}}">@lang("family_status.".$familyStatus)</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">Материальное положение</div>
                            <div class="col-md-8">
                                <select name="filter[material_condition][]" id="material_condition" class="form-control select2-multiple" multiple="multiple">
                                    <option></option>
                                    @foreach($materialConditionArray as $materialCondition)
                                        <option value="{{$materialCondition}}">@lang("material_condition.".$materialCondition)</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">Увлечения</div>
                            <div class="col-md-8">
                                <select name="filter[hobbies][]" id="hobbies" class="form-control select2-multiple" multiple="multiple">
                                    <option></option>
                                    @foreach($hobbiesArray as $hobby)
                                        <option value="{{$hobby}}">@lang("hobbies.".$hobby)</option>
                                    @endforeach
                                </select>
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
                            <div class="col-md-4">Ранг пользователя</div>
                            <div class="col-md-8">
                                <select name="filter[rang]" class="form-control">
                                    <option value="">--</option>
                                    @foreach($ratingStatuses as $ratingStatus)
                                        <option value="{{$ratingStatus->id}}">{{$ratingStatus->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">Количество баллов</div>
                            <div class="col-md-4">
                                <input type="text" name="filter[rating_min]" class="form-control" placeholder="от" autocomplete="false">
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="filter[rating_max]" class="form-control" placeholder="до" autocomplete="false">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">Был на сайте</div>
                            <div class="col-md-4">
                                <input type="text" name="filter[online_min]" class="form-control form_datetime" placeholder="от" autocomplete="false">
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="filter[online_max]" class="form-control form_datetime" placeholder="до" autocomplete="false">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">Дата регистрации</div>
                            <div class="col-md-4">
                                <input type="text" name="filter[registration_min]" class="form-control form_datetime" placeholder="от" autocomplete="false">
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="filter[registration_max]" class="form-control form_datetime" placeholder="до" autocomplete="false">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">Количество участий в проектах</div>
                            <div class="col-md-4">
                                <input type="text" name="filter[project_min]" class="form-control" placeholder="от" autocomplete="false">
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="filter[project_max]" class="form-control" placeholder="до" autocomplete="false">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">Последнее участие в проекте</div>
                            <div class="col-md-4">
                                <input type="text" name="filter[project_date_min]" class="form-control form_datetime" placeholder="от" autocomplete="false">
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="filter[project_date_max]" class="form-control form_datetime" placeholder="до" autocomplete="false">
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
        $('.select2-multiple').select2({
            tegs: true
        });
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
        $('#country_id').select2({
            placeholder: "Выберите страну...",
            tegs: true,
            minimumInputLength: 0,
            ajax: {
                url: '{!! route('admin.country.find') !!}',
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
        $('#region_id').select2({
            placeholder: "Выберите область...",
            tegs: true,
            minimumInputLength: 0,
            ajax: {
                url: '{!! route('admin.region.find') !!}',
                dataType: 'json',
                data: function (params) {
                    return {
                        name: params.term,
                        country_id: $('#country_id').val()
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
        $('#city_id').select2({
            placeholder: "Выберите город...",
            tegs: true,
            minimumInputLength: 0,
            ajax: {
                url: '{!! route('admin.city.find') !!}',
                dataType: 'json',
                data: function (params) {
                    return {
                        name: params.term,
                        country_id: $('#country_id').val()
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
