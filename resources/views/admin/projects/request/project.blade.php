@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <div class='col-md-8'>
            <!-- Box -->
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
						<button class="btn btn-danger" onclick="deleteRequests()">Удалить</button>
						<button class="btn btn-default" onclick="groupAjax('/admin/project/requests/status/5/--id--/')">Одобрить</button>
						<button class="btn btn-default" onclick="groupAjax('/admin/project/requests/status/3/--id--/')">Отклонить</button>
						<button class="btn btn-success" onclick="groupAjax('/admin/project/requests/status/7/--id--/')">В список участников</button>
					</div>
				</div>
			</div>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Список всех заявок проекта</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <p>Количество участников: {{$approvedRequestsCount}}/{{$project->count_users}}</p>
					<input type="hidden" name="show-hide-url" value="/admin/project/request/--action--/--id--/">
					<div class="table-responsive">
                    <table id="project_request_table" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th width="40">Выбрать</th>
                            <th width="40">id</th>
                            <th>Пользователь</th>
                            <th>Проект</th>
                            <th>Статус</th>
							<th>Время подачи</th>
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
						<button class="btn btn-danger" onclick="deleteRequests()">Удалить</button>
						<button class="btn btn-default" onclick="groupAjax('/admin/project/requests/status/5/--id--/')">Одобрить</button>
						<button class="btn btn-default" onclick="groupAjax('/admin/project/requests/status/3/--id--/')">Отклонить</button>
						<button class="btn btn-success" onclick="groupAjax('/admin/project/requests/status/7/--id--/')">В список участников</button>
					</div>
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
					<form action="{{ route('adm_select_project_request',['project_id' => $project_id]) }}" method="GET" enctype="multipart/form-data">

						<div class="filter-item">
							<div class="filter-name{{(Request::has('status'))?' active':''}}">Статус заявки</div>
							<div class="filter-options" {{(Request::has('status'))?'style=display:block':''}}>
								@foreach($statuses as $status)
									<div class="filter-option-item">
										<label>
											<input type="checkbox" class="minimal-red" name="status[{{$status->id}}]" value="{{$status->id}}" {{(Request::has('status.'.$status->id))?"checked=checked":""}}> {{$status->name}}
										</label>
									</div>
								@endforeach
							</div>
						</div>
						<div class="filter-item">
							<div class="filter-name{{(Request::has('sex'))?' active':''}}">Пол</div>
							<div class="filter-options" {{(Request::has('sex'))?'style=display:block':''}}>
								<div class="filter-option-item">
									<label>
										<input type="checkbox" class="minimal-red" name="sex[1]" value="1" {{(Request::has('sex.1'))?"checked=checked":""}}> Мужской
									</label>
								</div>
								<div class="filter-option-item">
									<label>
										<input type="checkbox" class="minimal-red" name="sex[0]" value="0" {{(Request::has('sex.0'))?"checked=checked":""}}> Женский
									</label>
								</div>
							</div>
						</div>
						<div class="filter-item">
							<div class="filter-name{{(Request::input('old_min') || Request::input('old_max'))?' active':''}}">Год рождения</div>
							<div class="filter-options" {{(Request::input('old_min') || Request::input('old_max'))?'style=display:block':''}}>
								<div class="filter-option-item row">
									<div class="col-md-6">
										<lable>От</lable>
										<input type="text" class="form-control" name="old_min" value="{{Request::input('old_min')}}">
									</div>
									<div class="col-md-6">
										<lable>До</lable>
										<input type="text" class="form-control" name="old_max" value="{{Request::input('old_max')}}">
									</div>
								</div>
							</div>
						</div>
						<div class="filter-item">
							<div class="filter-name{{(Request::input('city'))?' active':''}}">Город</div>
							<div class="filter-options" {{( Request::input('city'))?'style=display:block':''}}>
								<div class="filter-option-item">
									<input type="text" class="form-control tags" data-role="tagsinput" name="city" value="{{Request::input('city')}}">
								</div>
							</div>
						</div>
						<div class="filter-item">
							<div class="filter-name{{(Request::input('region'))?' active':''}}">Область</div>
							<div class="filter-options" {{( Request::input('region'))?'style=display:block':''}}>
								<div class="filter-option-item">
									<input type="text" class="form-control tags" data-role="tagsinput" name="region" value="{{Request::input('region')}}">
								</div>
							</div>
						</div>

						<div class="filter-item">
							<div class="filter-name{{(Request::has('user_status'))?' active':''}}">Статус пользователя</div>
							<div class="filter-options" {{(Request::has('user_status'))?'style=display:block':''}}>
								@foreach($userStatuses as $status)
									<div class="filter-option-item">
										<label>
											<input type="checkbox" class="minimal-red" name="user_status[{{$status->id}}]" value="{{$status->id}}" {{(Request::has('user_status.'.$status->id))?"checked=checked":""}}> {{$status->name}}
										</label>
									</div>
								@endforeach
							</div>
						</div>
					@foreach($filters as $filter)
						@if(($filter->type_id == 3) || ($filter->type_id == 4) || ($filter->type_id == 5))
						<div class="filter-item">
							<div class="filter-name{{(Request::has('option_'.$filter->id))?' active':''}}">{{$filter->name}}</div>
							<div class="filter-options" {{(Request::has('option_'.$filter->id))?'style=display:block':''}}>
								@foreach($filter->options as $option)
									<div class="filter-option-item">
										<label>
											<input type="checkbox" class="minimal-red" name="option_{{$filter->id}}[{{$option->id}}]" value="{{$option->id}}" {{(Request::has('option_'.$filter->id.'.'.$option->id))?"checked=checked":""}}> {{$option->name}}
										</label>
									</div>
								@endforeach
							</div>
						</div>
						@endif
					@endforeach
                        <div class="form-group">
						    <button name="submit" value="filter" type="submit" class="btn btn-primary btn-lg">Фильтровать</button>
						    <button name="submit" value="excel" type="submit" class="btn btn-default btn-lg pull-right">Геннерировать excel</button>
                        </div>
                        <div class="form-group mt-3">
                            <button name="submit" value="randomList" type="submit" class="btn btn-success btn-lg btn-block" @if(($project->count_users - $approvedRequestsCount) === 0) disabled="disabled" @endif>Рандомный список участников ({{$project->count_users - $approvedRequestsCount}})</button>
                        </div>
					</form>
				</div>
			</div>
		</div>

    </div><!-- /.row -->


@endsection
@section("scripts")
	<script>

		$("input.tags").tagsinput('items');
		var tableUsers = $('#project_request_table').DataTable({
			"lengthMenu": [[10, 20, 50, 100, -1], [10, 20, 50, 100, "Все"]],
			"pageLength": 20,
			"language": {
				"url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Russian.json"
			},
			"processing": true,
			"serverSide": true,
			"ajax": "{!! route('adm_select_project_request_ajax',['project_id' => $project_id]) !!}{!!  (!empty(Request::getQueryString()))?'?'.(str_replace('&amp;','&',Request::getQueryString())):''!!}",
			"order": [[ 5, "desc" ]],
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
						return '<a href="/admin/project/requests/edit/'+data+'">'+data+'</a>';
					},
					"orderable":      false,
				},
				{
					data: 'user',
					name: 'user',
					"orderable":      false,
					render: function ( data, type, row ) {
						return '<a href="/admin/users/edit/'+row.user_id+'">'+data+'</a>';
					}
				},
				{
					data: 'project',
					name: 'project',
					"orderable":      false,
				},
				{
					"data": "status",
					"orderable":      false,
					render: function ( data, type, row ) {
						var statusHTML = '';
						if(data === "Ожидает проверки"){
							statusHTML += '<p class="text-center">'+data+'</p>';
							statusHTML += '<button class="btn btn-success btn-block delete-ajax"  onclick="deleteAjax(\'/admin/project/requests/status/5/'+row.id+'/\')">Одобрить</button>';
							statusHTML += '<button class="btn btn-danger btn-block delete-ajax" onclick="deleteAjax(\'/admin/project/requests/status/3/'+row.id+'/\')">Отклонить</button>';
						}else {
							statusHTML += data;
						}
						return statusHTML;
					}
				},
				{
					data: 'created_at',
					name: 'created_at',
				},
				{
					"className":      'text-center',
					data: null,
					render: function ( data, type, row ) {
						    return '<button class="btn btn-danger delete-ajax" id="delete-'+row.id+'" onclick="deleteRequest('+row.id+')">Удалить</button>';
					},
					searchable: false,
					"orderable":      false,
				}
			],
			"fnDrawCallback": afterDrawTabel,
		});

		tableUsers.on( 'draw', afterDrawTabel() );
	</script>
@endsection
