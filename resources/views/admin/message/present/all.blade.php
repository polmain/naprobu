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
						<button class="btn btn-danger" onclick="deletePresents()">Удалить</button>
					</div>
				</div>
			</div>
            <!-- Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Подарки</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
					<input type="hidden" name="show-hide-url" value="/admin/user/present/--action--/--id--/">
					<div class="table-responsive">

					<table id="feedback-table" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th width="40"></th>
                            <th width="40">Выбрать</th>
                            <th width="40">id</th>
                            <th>Пользователь</th>
                            <th>Ранг</th>
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
						<button class="btn btn-danger" onclick="deletePresents()">Удалить</button>
					</div>
                </div><!-- /.box-footer-->
            </div><!-- /.box -->
        </div><!-- /.col -->


    </div><!-- /.row -->


@endsection

@section("scripts")
    <script>
		var tableComments = $('#feedback-table').DataTable({
          "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Все"]],
			"pageLength": 25,
			"language": {
				"url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Russian.json"
			},
			"processing": true,
			"serverSide": true,
			"order": [[ 2, "desc" ]],
			columnDefs: [
				{ type: 'natural-nohtml', targets: [2] }
			],
			"ajax": "{!! route('adm_present_ajax') !!}{{(!empty(Request::getQueryString()))?'?'.Request::getQueryString():''}}",
			"columns": [
				{
					"className":      'text-center',
					"orderable":      false,
					"data":           'isSent',
					render: function ( data, type, row ) {
						if(row.isGet == 1){
							if(data == 1){
								return '<span class="label label-success">Отправлен</span>';
							}else{
								return '<span class="label label-warning">Запрос подарка</span>';
							}
						}else{
							return '<span class="label label-danger">Запрос не поступал</span>';
						}

						return '';
					},
					searchable: false
				},
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
						return '<a href="/admin/user/present/'+data+'">'+data+'</a>';
					},
				},
				{
					data: 'user',
				},
				{
					data: 'rang',
				},
				{
					"className":      'text-center',
					data: null,
					render: function ( data, type, row ) {
						    return '<button class="btn btn-danger delete-ajax" id="delete-'+row.id+'" onclick="deletePresent('+row.id+')">Удалить</button>';
					},
					searchable: false,
					"orderable":      false,
				}
			],
			"fnDrawCallback": afterDrawTabel,

		});

		tableComments.on( 'draw', afterDrawTabel() );

		function deletePresent(id) {
			$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
			$('#modal-warning').find(".modal-body").html("<p>Отменить действие будет невозможно!</p>");
			$('#modal-warning').find("#success").attr('onclick','deleteAjax("/admin/user/present/delete/'+id+'/")');
			$('#modal-warning').modal('show');
		}

		function deletePresents() {
			$('#modal-warning').find(".modal-title").text("Подтвердите удаление");
			$('#modal-warning').find(".modal-body").html("<p>Отменить действие будет невозможно!</p>");
			$('#modal-warning').find("#success").attr('onclick','groupAjax("/admin/user/present/delete/--id--/")');
			$('#modal-warning').modal('show');
		}
	</script>
@endsection
