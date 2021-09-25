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
						<button class="btn btn-danger" onclick="deleteReviews()">Удалить</button>
						<button class="btn btn-default" onclick="groupAjax('/admin/reviews/status/2/--id--/')">Одобрить</button>
						<button class="btn btn-default" onclick="groupAjax('/admin/reviews/status/3/--id--/')">Отклонить</button>
					</div>
					<a href="{{route('adm_review_new')}}" class="btn btn-primary pull-right">Добавить отзыв</a>
				</div>
			</div>
            <!-- Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Список отзывов</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
					<input type="hidden" name="show-hide-url" value="/admin/reviews/--action--/--id--/">
					<div class="table-responsive">
                    <table id="reviews-table" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th width="40">Выбрать</th>
                            <th width="40">id</th>
                            <th width="140">Дата и время</th>
                            <th>Заголовок</th>
                            <th>Тескт</th>
                            <th>Пользователь</th>
                            <th>Проект</th>
                            <th>Страница</th>
                            <th>Статус</th>
                            <th></th>
                            <th></th>
                            <th></th>
							<th width="20">На главной отзывов</th>
							<th width="20">В каталоге проекта</th>
							<th width="20">В каталоге отзывов</th>
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
						<button class="btn btn-danger" onclick="deleteReviews()">Удалить</button>
						<button class="btn btn-default" onclick="groupAjax('/admin/reviews/status/2/--id--/')">Одобрить</button>
						<button class="btn btn-default" onclick="groupAjax('/admin/reviews/status/3/--id--/')">Отклонить</button>
					</div>
                    <a href="{{route('adm_review_new')}}" class="btn btn-primary pull-right">Добавить отзыв</a>
                </div><!-- /.box-footer-->
            </div><!-- /.box -->
        </div><!-- /.col -->


    </div><!-- /.row -->


@endsection

@section("scripts")
    <script>
		var tableUsers = $('#reviews-table').DataTable({
          "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Все"]],
			"pageLength": 25,
			"language": {
				"url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Russian.json"
			},
			"processing": true,
			"serverSide": true,
			"ajax": "{!! route('adm_review_ajax') !!}{{(!empty(Request::getQueryString()))?'?'.Request::getQueryString():''}}",
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
					name: 'id',
					"orderable":      false,
					render: function ( data, type, row ) {
						return '<a href="/admin/reviews/edit/'+data+'">'+data+'</a>';
					}
				},
				{
					"className":      'text-center',
					data: 'created_at',
					name: 'created_at',
					"orderable":      false,
				},
				{
					data: 'name',
					name: 'name',
					"orderable":      false,
				},
				{
					data: 'text',
					name: 'text',
					"orderable":      false,
				},
				{
					data: 'user',
					name: 'user',
					"orderable":      false,
				},
				{
					data: 'project',
					name: 'project',
					"orderable":      false,
				},
				{
					data: 'subpage',
					name: 'subpage',
					"orderable":      false,
				},
				{
					"data": "status",
					"orderable":      false,
				},
				{
					"className":      'text-center',
					"orderable":      false,
					"data":           'images',
					render: function ( data, type, row ) {
						/*return '<label>\n' +
							'     <input type="checkbox" class="minimal-red checkbox-item" id="isMainReview-'+row.id+'"  value="true" '+((data == 1)?'checked':'')+' disabled="disabled">\n' +
							'</label>';*/

						return ((data)?'<i class="fa fa-picture-o" aria-hidden="true"></i>':'');
					},
					searchable: false
				},
				{
					"className":      'text-center',
					"orderable":      false,
					"data":           'video',
					render: function ( data, type, row ) {
						/*return '<label>\n' +
							'     <input type="checkbox" class="minimal-red checkbox-item" id="isMainReview-'+row.id+'"  value="true" '+((data == 1)?'checked':'')+' disabled="disabled">\n' +
							'</label>';*/

						return ((data && data !== "")?'<i class="fa fa-youtube-play" aria-hidden="true"></i>':'');
					},
					searchable: false
				},
				{
					"className":      'text-center',
					"orderable":      false,
					"data":           'id',
					render: function ( data, type, row ) {
						/*return '<label>\n' +
							'     <input type="checkbox" class="minimal-red checkbox-item" id="isMainReview-'+row.id+'"  value="true" '+((data == 1)?'checked':'')+' disabled="disabled">\n' +
							'</label>';*/

						return '<a href="{{route('review')}}'+row.id+'" target="_blank"><i class="fa fa-external-link" aria-hidden="true"></i></a>';
					},
					searchable: false
				},
				{
					"className":      'text-center',
					"orderable":      false,
					"data":           'isMainReview',
					render: function ( data, type, row ) {
						/*return '<label>\n' +
							'     <input type="checkbox" class="minimal-red checkbox-item" id="isMainReview-'+row.id+'"  value="true" '+((data == 1)?'checked':'')+' disabled="disabled">\n' +
							'</label>';*/

						return ((data == 1)?' Да':'Нет');
					},
					searchable: false
				},
				{
					"className":      'text-center',
					"orderable":      false,
					"data":           'isProjectGallery',
					render: function ( data, type, row ) {
						/*return '<label>\n' +
							'     <input type="checkbox" class="minimal-red checkbox-item" id="isProjectGallery-'+row.id+'"  value="true" '+((data == 1)?'checked':'')+' disabled="disabled">\n' +
							'</label>';*/
						return ((data == 1)?' Да':'Нет');
					},
					searchable: false
				},
				{
					"className":      'text-center',
					"orderable":      false,
					"data":           'isReviewCatalog',
					render: function ( data, type, row ) {
						/*return '<label>\n' +
							'     <input type="checkbox" class="minimal-red checkbox-item" id="isReviewCatalog-'+row.id+'"  value="true" '+((data == 1)?'checked':'')+' disabled="disabled">\n' +
							'</label>';*/
						return ((data == 1)?' Да':'Нет');
					},
					searchable: false
				},
				{
					"className":      'text-center',
					data: null,
					render: function ( data, type, row ) {
						    return '<button class="btn btn-danger delete-ajax" id="delete-'+row.id+'" onclick="deleteReview('+row.id+')">Удалить</button>';
					},
					searchable: false,
					"orderable":      false,
				}
			],
			"fnDrawCallback": afterDrawTabel,
            initComplete: function () {
                this.api().columns([7]).every(function () {
                    var column = this;
                    var select = $('<select><option value=""></option></select>')
                        .appendTo($(column.header()))
                        .bind('keyup change', function () {
                            column.search($(this).val()).draw();
                        } );
                    @foreach($projects as $project)
                    select.append('<option value="{{$project->name}}">{{$project->name}}</option>');
                    @endforeach
                });
            }
		});

		tableUsers.on( 'draw', afterDrawTabel() );
	</script>
@endsection
