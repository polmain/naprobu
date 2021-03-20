@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <div class='col-md-12'>
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
                    <table id="users-table" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th width="40">Выбрать</th>
                            <th width="40">id</th>
                            <th>Пользователь</th>
                            <th>Статус</th>
                            <th>Причина</th>
                            <th>Время окончания</th>
							<th width="20"></th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </div><!-- /.box-body -->
                <div class="box-footer">
					<div class="inline">С выбранными:
						<button class="btn btn-danger" onclick="deleteUsersBlackList()">Удалить</button>
					</div>
                    <a href="{{route('adm_users_new')}}" class="btn btn-primary pull-right">Добавить пользователя</a>
                </div><!-- /.box-footer-->
            </div><!-- /.box -->
        </div><!-- /.col -->


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
			"ajax": "{!! route('adm_users_ajax') !!}",
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
    </script>
@endsection