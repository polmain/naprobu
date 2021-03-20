@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <div class='col-md-12'>
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
                        <button class="btn btn-default" onclick="groupAjax('/admin/project/request/status/5/--id--/')">Одобрить</button>
                        <button class="btn btn-default" onclick="groupAjax('/admin/project/request/status/3/--id--/')">Отклонить</button>
                    </div>
                </div>
            </div>
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Список всех заявок</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
					<input type="hidden" name="show-hide-url" value="/admin/project/request/--action--/--id--/">
                    <div class="table-responsive">
                    <table class="table data-table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th width="40">Выбрать</th>
                            <th width="40">id</th>
							<th>Проект</th>
                            <th>Статус</th>
							<th width="20"></th>
                        </tr>
                        </thead>
                        <tbody>
							@foreach($requests as $request)
								<tr>
									<td>
										<label>
											<input type="checkbox" class="minimal-red checkbox-item" id="item-{{$request->id}}"  value="true">
										</label>
									</td>
									<td>
										<a href="/admin/project/requests/edit/{{$request->id}}">{{$request->id}}</a>
									</td>
									<td>{{$request->project->name}}</td>
									<td>
										@if($request->status->name === "Ожидает проверки")
											<p class="text-center">{{$request->status->name}}</p>
										<button class="btn btn-success btn-block delete-ajax"  onclick="deleteAjax('/admin/project/requests/status/5/{{$request->id}}/')">Одобрить</button>
										<button class="btn btn-danger btn-block delete-ajax" onclick="deleteAjax('/admin/project/requests/status/3/{{$request->id}}/')">Отклонить</button>
										@else
											{{$request->status->name}}
										@endif
									</td>
									<td>
										<button class="btn btn-danger delete-ajax" id="delete-'+row.id+'" onclick="deleteRequest({{$request->id}})">Удалить</button>
									</td>
								</tr>
							@endforeach
                        </tbody>
                    </table>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <button type="button" class="btn btn-primary check_all">Отметить все</button>
					<div class="inline">С выбранными:
						<button class="btn btn-danger" onclick="deleteRequests()">Удалить</button>
						<button class="btn btn-default" onclick="groupAjax('/admin/project/request/status/5/--id--/')">Одобрить</button>
						<button class="btn btn-default" onclick="groupAjax('/admin/project/request/status/3/--id--/')">Отклонить</button>
					</div>
                </div><!-- /.box-footer-->
            </div><!-- /.box -->
        </div><!-- /.col -->


    </div><!-- /.row -->


@endsection

