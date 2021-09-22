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
						<button class="btn btn-danger" onclick="deleteComments()">Удалить</button>
						<button class="btn btn-default" onclick="groupAjax('/admin/reviews/comments/status/2/--id--/')">Одобрить</button>
						<button class="btn btn-default" onclick="groupAjax('/admin/reviews/comments/status/3/--id--/')">Отклонить</button>
					</div>
				</div>
			</div>
            <!-- Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Список комментариев к отзывам</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
					<input type="hidden" name="show-hide-url" value="/admin/reviews/comments/--action--/--id--/">
					<div class="table-responsive">
                    <table id="comments-table" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th width="40">Выбрать</th>
                            <th width="40">id</th>
                            <th>Тескт</th>
                            <th>Пользователь</th>
                            <th>Проект</th>
                            <th>Отзыв</th>
                            <th></th>
                            <th>Статус</th>
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
						<button class="btn btn-danger" onclick="deleteComments()">Удалить</button>
						<button class="btn btn-default" onclick="groupAjax('/admin/reviews/comments/status/2/--id--/')">Одобрить</button>
						<button class="btn btn-default" onclick="groupAjax('/admin/reviews/comments/status/3/--id--/')">Отклонить</button>
					</div>
                </div><!-- /.box-footer-->
            </div><!-- /.box -->
        </div><!-- /.col -->


    </div><!-- /.row -->


@endsection

@section("scripts")
    <script>
		var tableUsers = $('#comments-table').DataTable({
          "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Все"]],
			"pageLength": 25,
			"language": {
				"url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Russian.json"
			},
			"processing": true,
			"serverSide": true,
			"ajax": "{!! route('adm_comment_ajax') !!}{{(!empty(Request::getQueryString()))?'?'.Request::getQueryString():''}}",
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
					render: function ( data, type, row ) {
						return '<a href="/admin/reviews/comments/edit/'+data+'">'+data+'</a>';
					},
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
					"className":      'text-center',
					data: 'review',
					render: function ( data, type, row ) {
						return '<a href="/admin/reviews/edit/'+row.review_id+'" target="_blank">'+row.review_id+'</a>';
					},
					"orderable":      false,
				},
                {
                    "className":      'text-center',
                    "orderable":      false,
                    "data":           'id',
                    render: function ( data, type, row ) {
                        /*return '<label>\n' +
                            '     <input type="checkbox" class="minimal-red checkbox-item" id="isMainReview-'+row.id+'"  value="true" '+((data == 1)?'checked':'')+' disabled="disabled">\n' +
                            '</label>';*/

                        return '<a href="{{route('review')}}'+row.review_id+'" target="_blank"><i class="fa fa-external-link" aria-hidden="true"></i></a>';
                    },
                    searchable: false
                },
				{
					"data": "status",
					"orderable":      false,
					render: function ( data, type, row ) {
						var statusHTML = '';
						if(data === "Ожидает модерации"){
							statusHTML += '<p class="text-center">'+data+'</p>';
							statusHTML += '<button class="btn btn-success btn-block delete-ajax"  onclick="deleteAjax(\'/admin/reviews/comments/status/2/'+row.id+'/\')">Одобрить</button>';
							statusHTML += '<button class="btn btn-danger btn-block delete-ajax" onclick="deleteAjax(\'/admin/reviews/comments/status/3/'+row.id+'/\')">Отклонить</button>';
						}else {
							statusHTML += data;
						}
						return statusHTML;
					}
				},
				{
					"className":      'text-center',
					data: null,
					render: function ( data, type, row ) {
						    return '<button class="btn btn-danger delete-ajax" id="delete-'+row.id+'" onclick="deleteComment('+row.id+')">Удалить</button>';
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
					select.append('<option value="Ожидает модерации">Ожидает модерации</option>');
					select.append('<option value="Одобрено">Одобрено</option>');
					select.append('<option value="Отклонено">Отклонено</option>');
				});
			}
		});

		tableUsers.on( 'draw', afterDrawTabel() );
	</script>
@endsection
