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
					<div class="table-responsive">
                    <table id="phone-table" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th width="40">id</th>
                            <th>Телефон</th>
                            <th>Количество дублей</th>
                            <th>Статус</th>
                            <th>Новый пользователь?</th>
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
		var tableUsers = $('#phone-table').DataTable({
          "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Все"]],
			"pageLength": 25,
			"language": {
				"url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Russian.json"
			},
			"processing": true,
			"serverSide": true,
			"ajax": "{!! route('admin.phone.ajax') !!}{{(!empty(Request::getQueryString()))?'?'.Request::getQueryString():''}}",
			"columns": [
				{
					"className":      'text-center',
					data: 'id',
					render: function ( data, type, row ) {
						return '<a href="/admin/users/phones/edit/'+data+'">'+data+'</a>';
					}
				},
				{
					data: 'phone',
					render: function ( data, type, row ) {
						return '<a href="/admin/users/phones/edit/'+row.id+'">'+data+'</a>';
					}
				},
				{ "data": "duplicates" },
				{
					"data": "status_name",
					"orderable":      false,
				},
				{
					"data": "is_new_user_string",
					"orderable":      false,
				},
				{
					"className":      'text-center',
					data: null,
					render: function ( data, type, row ) {
						    return '<button class="btn btn-danger delete-ajax" id="delete-'+row.id+'" onclick="deletePhones('+row.id+')">Удалить</button>';
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
