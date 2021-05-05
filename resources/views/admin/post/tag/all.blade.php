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
                        <button class="btn btn-danger" onclick="deleteBlogTags()">Удалить</button>
                    </div>
                    <a href="#" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal-add-tag">Добавить тег</a>
                </div>
            </div>
            <!-- Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Список тегов</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <input type="hidden" name="show-hide-url" value="/admin/blog/tag/--action--/--id--/">
                    <div class="table-responsive">

                    <table id="tag_table" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th width="40">Выбрать</th>
                            <th width="20">#</th>
                            <th>Тэг (RU)</th>
                            <th>Тэг (UA)</th>
                            <th>Тэг (EN)</th>
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
                        <button class="btn btn-danger" onclick="deleteBlogTags()">Удалить</button>
                    </div>
                    <a href="#" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal-add-tag">Добавить тег</a>
                </div><!-- /.box-footer-->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->

    <div class="modal modal-default fade" id="modal-add-tag" style="display: none;">
        <div class="modal-dialog" style="max-width: 400px">
            <div class="modal-content">
                <form action="{{route('adm_post_tag_create')}}" method="post" enctype="multipart/form-data" class="validation-form">
                    {{ csrf_field() }}
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Добвить тег</h4>
                </div>
                <div class="modal-body">

                        <div class="form-group">
                            <label for="name_ru" class="col-form-label"><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Тег<span class="input-request">*</span></label>
                            <input type="text" class="form-control required" id="name_ru" name="name_ru">
                        </div>
                        <div class="form-group">
                            <label for="name_ua" class="col-form-label"><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Тег<span class="input-request">*</span></label>
                            <input type="text" class="form-control required" id="name_ua" name="name_ua">
                        </div>
                        <div class="form-group">
                            <label for="name_en" class="col-form-label"><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> Тег<span class="input-request">*</span></label>
                            <input type="text" class="form-control required" id="name_en" name="name_en">
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-primary" id="success">Добавить</button>
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
		var tableUsers = $('#tag_table').DataTable({
          "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Все"]],
			"pageLength": 25,
			"language": {
				"url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Russian.json"
			},
			"processing": true,
			"serverSide": true,
			"ajax": "{!! route('adm_post_tag_ajax') !!}",
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
				},
				{
					data: 'name',
				},
				{
					data: 'translate_ua',
					searchable: false,
					"orderable":      false,
				},
				{
					data: 'translate_en',
					searchable: false,
					"orderable":      false,
				},
				{
					"className":      'text-center',
					data: null,
					render: function ( data, type, row ) {
						return '<button class="btn btn-danger delete-ajax" id="delete-'+row.id+'" onclick="deleteBlogTag('+row.id+')">Удалить</button>';
					},
					searchable: false,
					"orderable":      false,
				}
			],
			"fnDrawCallback": afterDrawTabel,
		});

		tableUsers.on( 'draw', afterDrawTabel() );
    </script>
@endsection
