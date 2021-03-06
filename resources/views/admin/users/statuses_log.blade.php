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
					<input type="hidden" name="show-hide-url" value="/admin/users/status/--action--/--id--/">
					<div class="table-responsive">
                    <table id="users-table" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th width="40">id</th>
                            <th>Пользователь</th>
                            <th>Статус</th>
                            <th>Примечание</th>
                            <th>Время окончания</th>
                            <th>Навсегда?</th>
							<th width="20"></th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
					</div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->


    </div><!-- /.row -->


@endsection

@section("scripts")
    <script>
		var tableUsers = $('#users-table').DataTable({
			"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Все"]],
			"pageLength": 25,
			"language": {
				"url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Russian.json"
			},
			"processing": true,
			"serverSide": true,
			"ajax": "{!! route('adm_users_statuses_log_ajax') !!}",
			"columns": [
				{
					data: 'id'
				},
				{
					data: 'user',
					render: function ( data, type, row ) {
						return '<a href="/admin/users/edit/'+row.user_id+'">'+data+'</a>';
					}
				},
				{
					data: 'status',
				},
				{
					data: 'note'
				},
				{
					data: 'unlock_time',
				},
				{
					className:      'text-center',
					data:	'isForLife',
					render: function ( data, type, row ) {
						return (data)?'Да':'Нет';
					}
				},
				{
					className:      'text-center',
					data: null,
					render: function ( data, type, row ) {
						    return '<button class="btn btn-danger delete-ajax" id="delete-'+row.id+'" onclick="endStatus('+row.id+')">Досрочно завершить</button>';
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