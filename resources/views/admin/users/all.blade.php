@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <div class='col-md-8'>
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Панель управления</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
						<button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
					</div>
				</div>
				<div class="box-footer">
					<button type="button" class="btn btn-primary check_all">Отметить все</button>
					<div class="inline">С выбранными:
						<button class="btn btn-danger" onclick="deleteUsers()">Удалить</button>
					</div>
					<a href="{{route('adm_users_new')}}" class="btn btn-primary pull-right">Добавить пользователя</a>
				</div>
			</div>
            <!-- Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Список пользователей</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
					<input type="hidden" name="show-hide-url" value="/admin/users/--action--/--id--/">
					<div class="table-responsive">
                    <table id="users-table" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th width="40">Выбрать</th>
                            <th width="40">id</th>
                            <th>Логин</th>
                            <th>Имя</th>
                            <th>e-mail</th>
                            <th width="60">Роль</th>
                            <th>В сети</th>
                            <th>Статус</th>
                            <th>Приоритет</th>
                            <th>Рейтинг</th>
							<th width="20"></th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
					</div>
                </div><!-- /.box-body -->
                <div class="box-footer">
					<button type="button" class="btn btn-primary check_all">Отметить все</button>
					<div class="inline">С выбранными:
						<button class="btn btn-danger" onclick="deleteUsers()">Удалить</button>
					</div>
                    <a href="{{route('adm_users_new')}}" class="btn btn-primary pull-right">Добавить пользователя</a>
                </div><!-- /.box-footer-->
            </div><!-- /.box -->
        </div><!-- /.col -->
        <div class="col-md-4">
            <!-- Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Фильтры</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <form action="{{ route('adm_users') }}" method="GET" enctype="multipart/form-data">
                        <div class="filter-item">
                            <div class="filter-name{{(Request::input('filter.id_min') || Request::input('filter.id_max'))?' active':''}}">id</div>
                            <div class="filter-options" {{(Request::input('filter.id_min') || Request::input('filter.id_max'))?'style=display:block':''}}>
                                <div class="filter-option-item row">
                                    <div class="col-md-6">
                                        <lable>От</lable>
                                        <input type="text" class="form-control" name="filter[id_min]" value="{{Request::input('filter.id_min')}}">
                                    </div>
                                    <div class="col-md-6">
                                        <lable>До</lable>
                                        <input type="text" class="form-control" name="filter[id_max]" value="{{Request::input('filter.id_max')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="filter-name{{(Request::input('filter.sex'))?' active':''}}">Пол</div>
                            <div class="filter-options" {{(Request::input('filter.sex'))?'style=display:block':''}}>
                                <div class="filter-option-item">
                                    <select name="filter[sex]" class="form-control">
                                        <option value="">--</option>
                                        <option value="1" @if(Request::input('filter.sex') === "1")selected="selected" @endif>Мужской</option>
                                        <option value="0" @if(Request::input('filter.sex') === "0")selected="selected" @endif>Женский</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="filter-name{{(Request::input('filter.old_min') || Request::input('filter.old_max'))?' active':''}}">Возраст</div>
                            <div class="filter-options" {{(Request::input('filter.old_min') || Request::input('filter.old_max'))?'style=display:block':''}}>
                                <div class="filter-option-item row">
                                    <div class="col-md-6">
                                        <lable>От</lable>
                                        <input type="text" class="form-control" name="filter[old_min]" value="{{Request::input('filter.old_min')}}">
                                    </div>
                                    <div class="col-md-6">
                                        <lable>До</lable>
                                        <input type="text" class="form-control" name="filter[old_max]" value="{{Request::input('filter.old_max')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="filter-name{{(Request::has('filter.country'))?' active':''}}">Страна</div>
                            <div class="filter-options" {{( Request::has('filter.country'))?'style=display:block':''}}>
                                <div class="filter-option-item">
                                    <select class="form-control select2" name="filter[country]" id="country_id">
                                        @if($country)
                                            <option value="{{$country->id}}" selected="selected">{{$country->name}}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="filter-name{{(Request::has('filter.region'))?' active':''}}">Область</div>
                            <div class="filter-options" {{( Request::has('filter.region'))?'style=display:block':''}}>
                                <div class="filter-option-item">
                                    <select class="form-control select2" name="filter[region]" id="region_id">
                                        @if($region)
                                            <option value="{{$region->id}}" selected="selected">{{$region->name}}</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="filter-name{{(Request::has('filter.city'))?' active':''}}">Город</div>
                            <div class="filter-options" {{( Request::has('filter.city'))?'style=display:block':''}}>
                                <div class="filter-option-item">
                                    <select class="form-control select2" name="filter[city][]" multiple="multiple" id="city_id">
                                        @foreach($cities as $city)
                                            <option value="{{$city->id}}" selected="selected">{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="filter-name{{(Request::has('filter.education'))?' active':''}}">Образование</div>
                            <div class="filter-options" {{( Request::has('filter.education'))?'style=display:block':''}}>
                                <div class="filter-option-item">
                                    <select class="form-control select2-multiple" name="filter[education][]" multiple="multiple" id="education">
                                        @foreach($educationArray as $education)
                                            <option value="{{$education}}" @if(is_array(Request::input('filter.education')) && in_array($education->getValue(), Request::input('filter.education')))selected="selected" @endif>@lang("education.".$education)</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="filter-name{{(Request::has('filter.employment'))?' active':''}}">Занятость</div>
                            <div class="filter-options" {{( Request::has('filter.employment'))?'style=display:block':''}}>
                                <div class="filter-option-item">
                                    <select class="form-control select2-multiple" name="filter[employment][]" multiple="multiple" id="employment">
                                        @foreach($employmentArray as $employment)
                                            <option value="{{$employment}}" @if(is_array(Request::input('filter.employment')) && in_array($employment->getValue(), Request::input('filter.employment')))selected="selected" @endif>@lang("employment.".$employment)</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="filter-name{{(Request::has('filter.work'))?' active':''}}">Кем работает</div>
                            <div class="filter-options" {{( Request::has('filter.work'))?'style=display:block':''}}>
                                <div class="filter-option-item">
                                    <select class="form-control select2-multiple" name="filter[work][]" multiple="multiple" id="work">
                                        @foreach($workArray as $work)
                                            <option value="{{$work}}" @if(is_array(Request::input('filter.work')) && in_array($work->getValue(), Request::input('filter.work')))selected="selected" @endif>@lang("work.".$work)</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="filter-name{{(Request::has('filter.family_status'))?' active':''}}">Семейное положение</div>
                            <div class="filter-options" {{( Request::has('filter.family_status'))?'style=display:block':''}}>
                                <div class="filter-option-item">
                                    <select class="form-control select2-multiple" name="filter[family_status][]" multiple="multiple" id="family_status">
                                        @foreach($familyStatusArray as $familyStatus)
                                            <option value="{{$familyStatus}}" @if(is_array(Request::input('filter.family_status')) && in_array($familyStatus->getValue(), Request::input('filter.family_status')))selected="selected" @endif>@lang("family_status.".$familyStatus)</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="filter-name{{(Request::has('filter.material_condition'))?' active':''}}">Материальное положение</div>
                            <div class="filter-options" {{( Request::has('filter.material_condition'))?'style=display:block':''}}>
                                <div class="filter-option-item">
                                    <select class="form-control select2-multiple" name="filter[material_condition][]" multiple="multiple" id="material_condition">
                                        @foreach($materialConditionArray as $materialCondition)
                                            <option value="{{$materialCondition}}" @if(is_array(Request::input('filter.material_condition')) && in_array($materialCondition->getValue(), Request::input('filter.material_condition')))selected="selected" @endif>@lang("material_condition.".$materialCondition)</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="filter-name{{(Request::has('filter.hobbies'))?' active':''}}">Увлечения</div>
                            <div class="filter-options" {{( Request::has('filter.hobbies'))?'style=display:block':''}}>
                                <div class="filter-option-item">
                                    <select class="form-control select2-multiple" name="filter[hobbies][]" multiple="multiple" id="hobbies">
                                        @foreach($hobbiesArray as $hobby)
                                            <option value="{{$hobby}}" @if(is_array(Request::input('filter.hobbies')) && in_array($hobby->getValue(), Request::input('filter.hobbies')))selected="selected" @endif>@lang("hobbies.".$hobby)</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="filter-item">
                            <div class="filter-name{{(Request::input('filter.role'))?' active':''}}">Роль</div>
                            <div class="filter-options" {{(Request::input('filter.role'))?'style=display:block':''}}>
                                <div class="filter-option-item row">
                                    <div class="col-md-12">
                                        <select name="filter[role]" class="form-control">
                                            <option value="">--</option>
                                            <option value="admin" @if(Request::has('filter.role') && Request::input('filter.role') == "admin")selected="selected" @endif>Администраторы</option>
                                            <option value="moderator" @if(Request::has('filter.role') && Request::input('filter.role') == "moderator")selected="selected" @endif>Модераторы</option>
                                            <option value="bloger" @if(Request::has('filter.role') && Request::input('filter.role') == "bloger")selected="selected" @endif>Блогеры</option>
                                            <option value="expert" @if(Request::has('filter.role') && Request::input('filter.role') == "expert")selected="selected" @endif>Эксперты</option>
                                            <option value="user" @if(Request::has('filter.role') && Request::input('filter.role') == "user")selected="selected" @endif>Пользователи</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="filter-item">
                            <div class="filter-name{{(Request::input('filter.status'))?' active':''}}">Статус пользователя</div>
                            <div class="filter-options" {{(Request::input('filter.status'))?'style=display:block':''}}>
                                <select name="filter[status]" class="form-control">
                                    <option value="">--</option>
                                    @foreach($statuses as $status)
                                        <option value="{{$status->id}}" @if(Request::has('filter.status') && Request::input('filter.status') == $status->id)selected="selected" @endif>{{$status->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="filter-item">
                            <div class="filter-name{{(Request::input('filter.rang'))?' active':''}}">Ранг пользователя</div>
                            <div class="filter-options" {{( Request::input('filter.rang'))?'style=display:block':''}}>
                                <div class="filter-option-item">
                                    <select class="form-control" name="filter[rang]" id="rang">
                                        <option value="">--</option>
                                        @foreach($ratingStatuses as $ratingStatus)
                                            <option value="{{$ratingStatus->id}}" {{$ratingStatus->id == Request::input('filter.rang')?"selected=selected":""}}>{{$ratingStatus->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="filter-item">
                            <div class="filter-name{{(Request::input('filter.rating_min') || Request::input('filter.rating_max'))?' active':''}}">Количество баллов</div>
                            <div class="filter-options" {{(Request::input('filter.rating_min') || Request::input('filter.rating_max'))?'style=display:block':''}}>
                                <div class="filter-option-item row">
                                    <div class="col-md-6">
                                        <lable>От</lable>
                                        <input type="text" class="form-control" name="filter[rating_min]" value="{{Request::input('filter.rating_min')}}">
                                    </div>
                                    <div class="col-md-6">
                                        <lable>До</lable>
                                        <input type="text" class="form-control" name="filter[rating_max]" value="{{Request::input('filter.rating_max')}}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="filter-item">
                            <div class="filter-name{{(Request::input('filter.online_min') || Request::input('filter.online_max'))?' active':''}}">Был на сайте</div>
                            <div class="filter-options" {{(Request::input('filter.online_min') || Request::input('filter.online_max'))?'style=display:block':''}}>
                                <div class="filter-option-item row">
                                    <div class="col-md-6">
                                        <lable>От</lable>
                                        <input type="text" class="form-control form_datetime" name="filter[online_min]" value="{{Request::input('filter.online_min')}}">
                                    </div>
                                    <div class="col-md-6">
                                        <lable>До</lable>
                                        <input type="text" class="form-control form_datetime" name="filter[online_max]" value="{{Request::input('filter.online_max')}}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="filter-item">
                            <div class="filter-name{{(Request::input('filter.registration_min') || Request::input('filter.registration_max'))?' active':''}}">Дата регистрации</div>
                            <div class="filter-options" {{(Request::input('filter.registration_min') || Request::input('filter.registration_max'))?'style=display:block':''}}>
                                <div class="filter-option-item row">
                                    <div class="col-md-6">
                                        <lable>От</lable>
                                        <input type="text" class="form-control form_datetime" name="filter[registration_min]" value="{{Request::input('filter.registration_min')}}">
                                    </div>
                                    <div class="col-md-6">
                                        <lable>До</lable>
                                        <input type="text" class="form-control form_datetime" name="filter[registration_max]" value="{{Request::input('filter.registration_max')}}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="filter-item">
                            <div class="filter-name{{(Request::input('filter.project_min') || Request::input('filter.project_max'))?' active':''}}">Количество участий в проектах</div>
                            <div class="filter-options" {{(Request::input('filter.project_min') || Request::input('filter.project_max'))?'style=display:block':''}}>
                                <div class="filter-option-item row">
                                    <div class="col-md-6">
                                        <lable>От</lable>
                                        <input type="text" class="form-control" name="filter[project_min]" value="{{Request::input('filter.project_min')}}">
                                    </div>
                                    <div class="col-md-6">
                                        <lable>До</lable>
                                        <input type="text" class="form-control" name="filter[project_max]" value="{{Request::input('filter.project_max')}}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="filter-item">
                            <div class="filter-name{{(Request::input('filter.project_date_min') || Request::input('filter.project_date_max'))?' active':''}}">Последнее участие в проекте</div>
                            <div class="filter-options" {{(Request::input('filter.project_date_min') || Request::input('filter.project_date_max'))?'style=display:block':''}}>
                                <div class="filter-option-item row">
                                    <div class="col-md-6">
                                        <lable>От</lable>
                                        <input type="text" class="form-control form_datetime" name="filter[project_date_min]" value="{{Request::input('filter.project_date_min')}}">
                                    </div>
                                    <div class="col-md-6">
                                        <lable>До</lable>
                                        <input type="text" class="form-control form_datetime" name="filter[project_date_max]" value="{{Request::input('filter.project_date_max')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="filter-name{{(Request::has('filter.project'))?' active':''}}">Подавал заявку в проект</div>
                            <div class="filter-options" {{( Request::has('filter.project'))?'style=display:block':''}}>
                                <div class="filter-option-item">
                                    <select class="form-control select2" name="filter[project][]" multiple="multiple" id="project">
                                        @foreach($projects as $project)
                                            <option value="{{$project->id}}" selected="selected">{{$project->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="filter-name{{(Request::has('filter.projectExpert'))?' active':''}}">Был экспертом в проекте</div>
                            <div class="filter-options" {{( Request::has('filter.projectExpert'))?'style=display:block':''}}>
                                <div class="filter-option-item">
                                    <select class="form-control select2" name="filter[projectExpert][]" multiple="multiple" id="projectExpert">
                                        @foreach($projectsExpert as $project)
                                            <option value="{{$project->id}}" selected="selected">{{$project->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="filter-item">
                            <div class="filter-name{{(Request::has('filter.questions'))?' active':''}}">Отвечал на вопросы</div>
                            <div class="filter-options" {{( Request::has('filter.questions'))?'style=display:block':''}}>
                                <div class="filter-option-item">
                                    <select class="form-control select2" name="filter[questions][]" multiple="multiple" id="questions">
                                        @foreach($questions as $question)
                                            <option value="{{$question->id}}" selected="selected">{{$question->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button name="submit" value="filter" type="submit" class="btn btn-primary btn-lg">Фильтровать</button>
                            <button name="submit" value="excel" type="submit" class="btn btn-default btn-lg pull-right">Геннерировать excel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div><!-- /.row -->


@endsection

@section("scripts")
    <script>
		var tableUsers = $('#users-table').DataTable({
          "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Все"]],
			"pageLength": 25,
			"language": {
				"url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Russian.json"
			},
			"processing": true,
			"serverSide": true,
			"ajax": "{!! route('adm_users_ajax') !!}?isArchive={{isset($isArchive)?1:0}}{{(isset($role))?('&role='.$role):''}}{!!  (!empty(Request::getQueryString()))?(str_replace('&amp;','&',Request::getQueryString())):''!!}",
			"columns": [
				{
					"className":      'text-center',
					"orderable":      false,
					"data":           null,
					render: function ( data, type, row ) {
						return '<label>\n' +
							'     <input type="checkbox" class="minimal-red checkbox-item" id="item-'+row.id+'"  value="true">\n' +
							'</label>';
					},
					searchable: false
				},
				{
					"className":      'text-center',
					data: 'id',
					render: function ( data, type, row ) {
						return '<a href="/admin/users/edit/'+data+'">'+data+'</a>';
					}
				},
				{
					data: 'name',
					render: function ( data, type, row ) {
						return '<a href="/admin/users/edit/'+row.id+'">'+data+'</a>';
					}
				},
				{
					data: 'first_name',
					visible: false,
				},
				{ "data": "email" },
				{
					"data": "role",
					"orderable":      false,
				},
				{
					data: 'isOnline',
					render: function ( data, type, row ) {
						if(data){
						    return '<td><i class="fa fa-circle text-success" aria-hidden="true"></i> Online</td>'
                        }else{
							return ' <td><i class="fa fa-circle text-danger" aria-hidden="true"></i> Был '+row.lastOnline+'</td>'
                        }
					},
					searchable: false,
					"orderable":      false,
				},
				{
					"data": "status",
					"orderable":      false,
				},
				{
					"data": "priority",
                    searchable: false,
                    "orderable":      false,
				},
				{
					"data": "current_rating",
				},
				{
					"className":      'text-center',
					data: null,
					render: function ( data, type, row ) {
						    return '<button class="btn btn-danger delete-ajax" id="delete-'+row.id+'" onclick="deleteUser('+row.id+')">Удалить</button>';
					},
					searchable: false,
					"orderable":      false,
				}
			],
			"fnDrawCallback": afterDrawTabel
		});

		tableUsers.on( 'draw', afterDrawTabel() );

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
