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
                    <h3 class="box-title">Список блогеров</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
					<div class="table-responsive">
                    <table id="blogger_table" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th width="40">id</th>
                            <th>Логин</th>
                            <th>e-mail</th>
                            <th>Статус</th>
							<th>Дата подачи/изменения</th>
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
		var bloggerTable = $('#blogger_table').DataTable({
          "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Все"]],
			"pageLength": 25,
			"language": {
				"url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Russian.json"
			},
			"processing": true,
			"serverSide": true,
			"ajax": "{!! route('adm_blogger_requests_ajax') !!}{{(!empty(Request::getQueryString()))?'?'.Request::getQueryString():''}}",
            "order": [[ 4, "asc" ]],
			"columns": [
                {
                    "className":      'text-center',
                    data: 'user_id',
                    render: function ( data, type, row ) {
                        return '<a href="/admin/users/edit/'+data+'">'+data+'</a>';
                    }
                },
                {
                    data: 'name',
                    render: function ( data, type, row ) {
                        return '<a href="/admin/users/edit/'+row.user_id+'">'+data+'</a>';
                    }
                },
                { "data": "email" },
				{
					"data": "status_name",
					"orderable":      false,
				},
                { "data": "updated_at" },
			],
			"fnDrawCallback": afterDrawTabel
		});

        bloggerTable.on( 'draw', afterDrawTabel() );
    </script>
@endsection
