@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <form action="{{route('adm_review_save',['review_id'=>$review->id])}}" method="post" enctype="multipart/form-data" class="validation-form">
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
                                <input type="text" class="form-control" name="name" placeholder="Введите заголовок" value="{{$review->name}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label>Текст отзыва<span class="input-request">*</span></label>
                                <textarea name="text" class="form-control required" rows="10" placeholder="Введите отзыв...">{{$review->text}}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label>Ссылка на видео</label>
                                <input type="text" class="form-control" name="video" placeholder="Введите ссылку на отзыв" value="{{$review->video}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label>Видео</label>
                                <iframe width="100%" height="315" src="{{$review->video}}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="item-form col-md-12">
                                <label for="screens">Галерея:</label>
                                <input type="hidden" name="images" id="images_list" value="{{json_encode($review->images)}}">
                                <div class="load-imgs row">
                                    @if(!empty($review->images))
                                        @foreach($review->images as $image)
                                            <div class="col-md-4 load-image-container">
                                                <div class="load-img active" style="background-image: url('/public/uploads/images/reviews/{{$image[1]}}')">
                                                    <i class="fa fa-times delete-image" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
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
                        <button type="submit" name="submit" value="save" class="btn btn-block btn-success btn-lg">Сохранить</button>
                        <button type="submit" name="submit" value="save-close" class="btn btn-block btn-primary btn-lg">Сохранить и закрыть</button>
                        <button type="submit" name="submit" value="save-next" class="btn btn-block btn-primary btn-lg">Сохранить и перейти к следующему</button>
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
                        <p><a href="{{route('adm_comment')}}?filter={{ $commentFilter }}">Комментарии к отзыву ({{$countComments}})</a></p>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label>Статус<span class="input-request">*</span></label>
                                <select class="form-control required" name="status" style="width: 100%;">
                                    <option value="">--</option>
                                    @foreach($statuses as $status)
                                        <option  value="{{$status->id}}"{{($review->status_id == $status->id)?" selected=selected":''}}>{{$status->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label>Пользователь<span class="input-request">*</span></label>
                                <select id="user" name="user" class="form-control required">
                                    <option  value="{{$review->user->id}}" selected=selected >{{$review->user->name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label>Проект<span class="input-request">*</span></label>
                                <select id="project" name="project" class="form-control">
                                    <option  value="{{$review->subpage->project->id}}" selected=selected >{{$review->subpage->project->name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label>Подстраница проекта<span class="input-request">*</span></label>
                                <select id="subpage" name="subpage" class="form-control required">
                                    <option  value="{{$review->subpage->id}}" selected=selected >{{$review->subpage->name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" class="minimal-red" name="isMainReview" value="true"{{($review->isMainReview)?" checked=checked":""}}>
                                На главной отзывов
                            </label>
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" class="minimal-red" name="isProjectGallery" value="true"{{($review->isProjectGallery)?" checked=checked":""}}>
                                В каталоге проекта
                            </label>
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" class="minimal-red" name="isReviewCatalog" value="true"{{($review->isReviewCatalog)?" checked=checked":""}}>
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
