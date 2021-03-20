@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <form action="{{route('adm_review_create')}}" method="post" enctype="multipart/form-data" class="validation-form">
            {{ csrf_field() }}
            <div class='col-md-9'>
                <!-- Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Основные параметры Отзыва</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label>Заголовок отзыва</label>
                                <input type="text" class="form-control" name="name" placeholder="Введите заголовок">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label>Текст отзыва<span class="input-request">*</span></label>
                                <textarea name="text" class="form-control required" rows="10" placeholder="Введите отзыв..."></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label>Ссылка на видео</label>
                                <input type="text" class="form-control" name="video" placeholder="Введите ссылку на отзыв">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="item-form col-md-12">
                                <div class="load-imgs row"></div>
                                <label for="screens">Галерея:</label>
                                <input type="file" name="images[]" multiple />
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->


            </div>
            <div class="col-md-3">
                <!-- Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Действия</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <button type="submit" name="submit" value="save" class="btn btn-block btn-success btn-lg">Опубликовать</button>
                        <button type="submit" name="submit" value="save-close" class="btn btn-block btn-primary btn-lg">Сохранить и закрыть</button>
                        <button type="submit" name="submit" value="save-new" class="btn btn-block btn-primary btn-lg">Сохранить и создать</button>
                        <button type="submit" name="submit" value="save-hide" class="btn btn-block btn-primary btn-lg">Сохранить в черновик</button>
                        <button type="button" class="btn btn-block btn-danger btn-lg" onclick="document.location.href='/admin/reviews/';">Отмена</button>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                <!-- Box -->
                <!-- Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Настройки</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label>Статус<span class="input-request">*</span></label>
                                <select class="form-control required" name="status" style="width: 100%;">
                                    <option selected="selected" value="">--</option>
                                    @foreach($statuses as $status)
                                        <option  value="{{$status->id}}">{{$status->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label>Пользователь<span class="input-request">*</span></label>
                                <select id="user" name="user" class="form-control required"></select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label>Проект<span class="input-request">*</span></label>
                                <select id="project" name="project" class="form-control"></select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label>Подстраница проекта<span class="input-request">*</span></label>
                                <select id="subpage" name="subpage" class="form-control required"></select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" class="minimal-red" name="isMainReview" value="true">
                                На главной отзывов
                            </label>
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" class="minimal-red" name="isProjectGallery" value="true">
                                В каталоге проекта
                            </label>
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" class="minimal-red" name="isReviewCatalog" value="true">
                                В каталоге отзывов
                            </label>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                <!-- Box -->
            </div>
        </form>
    </div><!-- /.row -->
@endsection

@section("scripts")
    <script>
		$('#user').select2({
			placeholder: "Выберите пользователя...",
			minimumInputLength: 2,
			ajax: {
				url: '{!! route('adm_users_find') !!}',
				dataType: 'json',
				data: function (params) {
					return {
						name: params.term
					};
				},
				processResults: function (data) {
					return {
						results: data
					};
				},
				cache: true
			}
		});
		$('#project').select2({
			placeholder: "Выберите проект...",
			minimumInputLength: 2,
			ajax: {
				url: '{!! route('adm_project_find') !!}',
				dataType: 'json',
				data: function (params) {
					return {
						name: params.term
					};
				},
				processResults: function (data) {
					return {
						results: data
					};
				},
				cache: true
			}
		});
		$('#subpage').select2({
			placeholder: "Выберите подстраницу...",
			minimumInputLength: 2,
			ajax: {
				url: '{!! route('adm_project_subpage_find') !!}',
				dataType: 'json',
				data: function (params) {
					return {
						name: params.term,
                        project: $("#project").val()
					};
				},
				processResults: function (data) {
					return {
						results: data
					};
				},
				cache: true
			}
		});
    </script>
@endsection