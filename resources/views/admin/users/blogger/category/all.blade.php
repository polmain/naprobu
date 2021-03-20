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
						<a class="btn btn-primary"  data-toggle="modal" data-target="#modal-add-category">Добавить категорию</a>
					</div>
				</div>
			</div>
            <!-- Box -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Список категорий</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
					<div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th width="40">#</th>
                            <th>Категория</th>
                            <th>Количество пользователей</th>
                        </tr>
                        </thead>
                        <tbody>
							@foreach($categories as $category)
								<tr>
									<td><a href="#" data-toggle="modal" data-target="#modal-edit-category" data-name="{{$category->name}}" data-action="{{route('adm_blogger_category_save',[$category->id])}}" >{{$category->id}}</a></td>
									<td><a href="#" data-toggle="modal" data-target="#modal-edit-category" data-name="{{$category->name}}" data-action="{{route('adm_blogger_category_save',[$category->id])}}">{{$category->name}}</a></td>
									<td>{{$category->bloggers->count()}}</td>
								</tr>
							@endforeach
                        </tbody>
                    </table>
					</div>
                </div><!-- /.box-body -->
                <div class="box-footer">
					<div class="pull-right">
						<a class="btn btn-primary"  data-toggle="modal" data-target="#modal-add-category">Добавить категорию</a>
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
			<a href="{{route('adm_users_bloger')}}" class="btn btn-block btn-primary btn-lg">Блоггеры</a>
			<a href="{{route('adm_users_blogger_city')}}" class="btn btn-block btn-primary btn-lg">Города</a>
			<a href="{{route('adm_users_blogger_subject')}}" class="btn btn-block btn-primary btn-lg">Тематики</a>
		</div><!-- /.box-body -->
	</div><!-- /.box -->
</div>

    </div><!-- /.row -->

	<div class="modal modal-default fade" id="modal-add-category" style="display: none;">
		<div class="modal-dialog" style="max-width: 400px">
			<div class="modal-content">
				<form action="{{route('adm_blogger_category_create')}}" method="post" enctype="multipart/form-data" class="validation-form">
					{{ csrf_field() }}
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span></button>
						<h4 class="modal-title">Добвить категорию</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="name_ru" class="col-form-label">Категория<span class="input-request">*</span></label>
							<input type="text" class="form-control required" id="name" name="name">
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
	<div class="modal modal-default fade" id="modal-edit-category" style="display: none;">
		<div class="modal-dialog" style="max-width: 400px">
			<div class="modal-content">
				<form action="" method="post" enctype="multipart/form-data" class="validation-form">
					{{ csrf_field() }}
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span></button>
						<h4 class="modal-title">Изменить категорию</h4>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<label for="name_ru" class="col-form-label">Категория<span class="input-request">*</span></label>
							<input type="text" class="form-control required" id="edit_name" name="name" >
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Отмена</button>
						<button type="submit" class="btn btn-primary" id="success">Сохранить</button>
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
		$('#modal-edit-category').on('show.bs.modal', function (event) {
			var button = $(event.relatedTarget)
			var modal = $(this)
			modal.find('form').attr('action', button.data('action'))
			modal.find('#edit_name').val(button.data('name'))
		})
    </script>
@endsection