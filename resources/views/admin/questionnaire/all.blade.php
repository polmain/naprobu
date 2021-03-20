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
						<button class="btn btn-default" onclick="groupAjax('/admin/questionnaire/show/--id--/')">Показать</button>
						<button class="btn btn-default" onclick="groupAjax('/admin/questionnaire/hide/--id--/')">Скрыть</button>
						<button class="btn btn-danger" onclick="deleteQuestionnaires()">Удалить</button>
					</div>
					<a href="{{route('adm_questionnaire_new')}}" class="btn btn-primary pull-right">Создать анкету</a>
				</div>
			</div>
            <!-- Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Список анкет</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <input type="hidden" name="show-hide-url" value="/admin/questionnaire/--action--/--id--/">
					<div class="table-responsive">
                    <table class="table table-bordered table-hover" id="questionnaire-table">
                        <thead>
                        <tr>
                            <th width="40">Выбрать</th>
                            <th width="20">#</th>
                            <th>Анкета</th>
                            <th>Тип Анкеты</th>
                            <th>Проект</th>
                            <th width="20">Скрыт</th>
                            <th width="20"></th>
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
                        <button class="btn btn-default" onclick="groupAjax('/admin/questionnaire/show/--id--/')">Показать</button>
                        <button class="btn btn-default" onclick="groupAjax('/admin/questionnaire/hide/--id--/')">Скрыть</button>
                        <button class="btn btn-danger" onclick="deleteQuestionnaires()">Удалить</button>
                    </div>
                    <a href="{{route('adm_questionnaire_new')}}" class="btn btn-primary pull-right">Создать анкету</a>
                </div><!-- /.box-footer-->
            </div><!-- /.box -->
        </div><!-- /.col -->


    </div><!-- /.row -->
@endsection
{{--
    <tr>


        <td class="text-center">{{$questionnaire->questions_count}}</td>

        <td class="text-center">
            <a href="{{route('adm_questionnaire_copy',['questionnaire_id'=>$questionnaire->id])}}" class="btn btn-success">Дублировать</a>
        </td>
    </tr>
--}}
@section("scripts")
    <script>
		var tableUsers = $('#questionnaire-table').DataTable({
          "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Все"]],
			"pageLength": 25,
			"language": {
				"url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Russian.json"
			},
			"processing": true,
			"serverSide": true,
			"ajax": "{!! route('adm_questionnaire_ajax') !!}",
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
						return '<a href="/admin/questionnaire/edit/'+data+'">'+data+'</a>';
					}
				},
				{
					data: 'name',
				    render: function ( data, type, row ) {
                        return '<a href="/admin/questionnaire/edit/'+row.id+'">'+data+'</a>';
                    }
				},
				{
					data: 'type',
					searchable: false,
					"orderable":      false,
				},
				{
					data: 'project',
					searchable: false,
					"orderable":      false,
				},

				{
					"className":      'text-center',
					"orderable":      false,
					"data":           'isHide',
					render: function ( data, type, row ) {
						return '<label>\n' +
							'     <input type="checkbox" class="minimal-red show-hide" id="show-hide-'+row.id+'"  value="true" '+((data == 1)?'checked':'')+'>\n' +
							'</label>';
					},
					searchable: false
				},
				{
					"className":      'text-center',
					data: null,
					render: function ( data, type, row ) {
						return '<a class="btn btn-success" href="/admin/questionnaire/copy/'+row.id+'" >Дублировать</a>';
					},
					searchable: false,
					"orderable":      false,
				},
				{
					"className":      'text-center',
					data: null,
					render: function ( data, type, row ) {
						return '<button class="btn btn-danger delete-ajax" id="delete-'+row.id+'" onclick="deleteQuestionnaire('+row.id+')">Удалить</button>';
					},
					searchable: false,
					"orderable":      false,
				}
			],
			"fnDrawCallback": afterDrawTabel,
			initComplete: function () {
				/*this.api().columns([5]).every(function () {
					addSelectFilter(this);
				});*/
			}
		});

		tableUsers.on( 'draw', afterDrawTabel() );
    </script>
@endsection