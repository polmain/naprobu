@extends('admin.layouts.layout')

@section('content')
    <div class='row'>

        <div class='col-md-9'>
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Панель управления</h3>
					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
						<button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
					</div>
				</div>
				<div class="box-footer">
					<div class="pull-right">
						<button class="btn btn-success" data-toggle="modal" data-target="#modal-import-blogger">Импорт Блоггеров</button>
						<a href="{{route('adm_blogger_new')}}" class="btn btn-primary">Добавить блоггера</a>
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
					<input type="hidden" name="show-hide-url" value="/admin/users/blogger/--action--/--id--/">
					<div class="table-responsive">
                    <table id="users-table" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th width="40">#</th>
                            <th>Название</th>
                            <th>Город</th>
                            <th>Категории</th>
                            <th>Тематика</th>
                            <th>Соц. сети</th>
                            <th>Подписчики</th>
							<th width="20"></th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
					</div>
                </div><!-- /.box-body -->
                <div class="box-footer">
					<div class="pull-right">
						<button class="btn btn-success" data-toggle="modal" data-target="#modal-import-blogger">Импорт Блоггеров</button>
						<a href="{{route('adm_blogger_new')}}" class="btn btn-primary">Добавить блоггера</a>
					</div>
                </div><!-- /.box-footer-->
            </div><!-- /.box -->
        </div><!-- /.col -->
<div class="col-md-3 pull-right">
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">Ресурсы</h3>
			<div class="box-tools pull-right">
				<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
				<button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
			</div>
		</div>
		<div class="box-body">
			<a href="{{route('adm_users_blogger_city')}}" class="btn btn-block btn-primary btn-lg">Города</a>
			<a href="{{route('adm_users_blogger_category')}}" class="btn btn-block btn-primary btn-lg">Категории</a>
			<a href="{{route('adm_users_blogger_subject')}}" class="btn btn-block btn-primary btn-lg">Тематики</a>
		</div><!-- /.box-body -->
	</div><!-- /.box -->
</div>

    </div><!-- /.row -->


	<div class="modal fade" id="modal-import-blogger" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span></button>
					<h4 class="modal-title">Импорт блоггеров</h4>
				</div>
				<form action="{{route('adm_blogger_importExcel')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
					{{ csrf_field() }}
				<div class="modal-body">
					<div class="">
						<label for="exampleInputFile">Excel Файл с Блоггерами</label>
						<input type="file" name="file">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Отмена</button>
					<button type="submit" class="btn btn-primary" id="success">Импорт</button>
				</div>
				</form>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>

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
			"ajax": "{!! route('adm_users_bloger_ajax') !!}",
			"columns": [
				{
					"className":      'text-center',
					data: 'id',
					render: function ( data, type, row ) {
						return '<a href="/admin/users/blogger/edit/'+data+'">'+data+'</a>';
					}
				},
				{
					data: 'name',
					render: function ( data, type, row ) {
						return '<a href="/admin/users/blogger/edit/'+row.id+'">'+data+'</a>';
					}
				},
				{ "data": "city" },
				{
					"data": "categories",
					"orderable":      false,
				},
				{
					"data": "subjects",
					"orderable":      false,
				},
				{
					render: function ( data, type, row ) {
						var socialnetwork = "";
						if(row.instagram_link){
							socialnetwork += 'instagram, '
						}
						if(row.facebook_link){
							socialnetwork += 'facebook, '
						}
						if(row.youtube_link){
							socialnetwork += 'YouTube, '
						}
						socialnetwork = socialnetwork.substring(0, socialnetwork.length - 2)
						return socialnetwork;
					},
					"orderable":      false,
				},
				{
					render: function ( data, type, row ) {
						var socialnetwork = 0;
						if(row.instagram_subscriber){
							socialnetwork += (roughScale(row.instagram_subscriber,10))
						}
						if(row.facebook_subscriber){
							socialnetwork += (roughScale(row.facebook_subscriber,10))
						}
						if(row.youtube_subscriber){
							socialnetwork += (roughScale(row.youtube_subscriber,10))
						}
						return socialnetwork;
					},
					"orderable":      false,
				},
				{
					"className":      'text-center',
					data: null,
					render: function ( data, type, row ) {
						    return '<button class="btn btn-danger delete-ajax" id="delete-'+row.id+'" onclick="deleteBlogger('+row.id+')">Удалить</button>';
					},
					searchable: false,
					"orderable":      false,
				}
			],
			"fnDrawCallback": afterDrawTabel
		});
		function roughScale(x, base) {
			var parsed = parseInt(x, base);
			if (isNaN(parsed)) { return 0 }
			return parsed;
		}
		tableUsers.on( 'draw', afterDrawTabel() );
    </script>
@endsection