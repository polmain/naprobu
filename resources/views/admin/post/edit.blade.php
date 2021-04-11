@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <form action="{{route('adm_post_save',['post_id'=>$post->id])}}" method="post" enctype="multipart/form-data" class="validation-form">
            {{ csrf_field() }}
            <div class='col-md-9'>
                <!-- Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Основные параметры Статьи</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Название статьи<span class="input-request">*</span></label>
                                <input type="text" id="name-ru" name="name" class="form-control project-name required" placeholder="Введите название статьи..." value="{{$post->name}}">
                            </div>
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Название статьи<span class="input-request">*</span></label>
                                <input type="text" id="name-ua" name="nameUA" class="form-control project-name required" placeholder="Введите название статьи..." value="{{$post->translate->name}}">
                            </div>
                        </div>
                        <div class="form-group project-url edit not-edit url-ru" id="project-url-ru"><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Постоянная ссылка: <div class="edit-url">
                                <div class="edit-a active">
                                    <a href="{{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/ru/blog/{{$post->url}}" class="link-url"><span class="static-part">{{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/ru/blog/</span><span class="edit-part">{{$post->url}}</span></a>
                                    <button type="button" class="btn btn-default btn-sm change-url">Изменить</button>
                                </div>
                                <div class="edit-input">
                                    {{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/ru/blog/<input type="text" class="new-url" name="url" value="{{$post->url}}">
                                    <button type="button" class="btn btn-success btn-sm save-url">Ок</button>
                                    <button type="button" class="btn btn-default btn-sm cancel-url">Отмена</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group project-url edit not-edit url-ua" id="project-url-ua"><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Постоянная ссылка: <div class="edit-url">
                                <div class="edit-a active">
                                    <a href="{{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/blog/{{$post->translate->url}}" class="link-url"><span class="static-part">{{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/blog/</span><span class="edit-part">{{$post->translate->url}}</span></a>
                                    <button type="button" class="btn btn-default btn-sm change-url">Изменить</button>
                                </div>
                                <div class="edit-input">
                                    {{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/blog/<input type="text" class="new-url" name="urlUA" value="{{$post->translate->url}}">
                                    <button type="button" class="btn btn-success btn-sm save-url">Ок</button>
                                    <button type="button" class="btn btn-default btn-sm cancel-url">Отмена</button>
                                </div>
                            </div>
                        </div>
                        <script>
							var isURLRoute = "{{route('adm_post_valid_url',[$post->id])}}";
                        </script>
                        <div class="form-group">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs pull-right">
                                    <li><a href="#text_2-2" data-toggle="tab"><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"></a></li>
                                    <li class="active"><a href="#text_1-1" data-toggle="tab"><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"></a></li>
                                    <li class="pull-left header"><label>Текст статьи<span class="input-request">*</span></label></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="text_1-1">
                                        <textarea class="editor required" id="text" name="content" rows="10" cols="80">{!! $post->content !!}</textarea>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="text_2-2">
                                        <textarea class="editor required" id="textUA" name="contentUA" rows="10" cols="80">{!! $post->translate->content !!}</textarea>
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->

                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">SEO статьи</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Title</label>
                                <input type="text" id="title" name="seo_title" class="form-control" placeholder="Введите Title статьи..." value="{{$post->seo_title}}">
                            </div>
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Title</label>
                                <input type="text" id="titleUA" name="seo_titleUA" class="form-control" placeholder="Введите Title статьи..." value="{{$post->translate->seo_title}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Description</label>
                                <textarea class="form-control" name="seo_description" rows="5" placeholder="Введите Description статьи...">{{$post->seo_description}}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Description</label>
                                <textarea class="form-control" name="seo_descriptionUA" rows="5" placeholder="Введите Description статьи...">{{$post->translate->seo_description}}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Keywords</label>
                                <input type="text" class="form-control" name="seo_keywords" placeholder="Введите Keywords статьи..." value="{{$post->seo_keywords}}">
                            </div>
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Keywords</label>
                                <input type="text" class="form-control" name="seo_keywordsUA" placeholder="Введите Keywords статьи..." value="{{$post->translate->seo_keywords}}">
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
                        <button type="button" class="btn btn-block btn-danger btn-lg" onclick="document.location.href='/admin/blog/';">Отмена</button>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                <!-- Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Настройки статьи</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Пароль для просмотра проекта в черновике</label>
                            <input class="form-control" type="text" name="password">
                        </div>
                        <div class="form-group">
                            <label>Автор<span class="input-request">*</span></label>
                            <select class="form-control select2 required" name="author_id" id="author_id">
                                <option value="{{Auth::user()->id}}">{{Auth::user()->name}}</option>
                                <option value="{{$post->author->id}}" selected="selected">{{$post->author->name}}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Проект</label>
                            <select class="form-control select2" name="project_id" id="project_id">
                                <option value="">Выберите проект</option>
                                @if($post->project_id)
                                @foreach($projects->reverse() as $project)
                                    @if($project->id == $post->project_id)
                                        <option value="{{$project->id}}" selected="selected">{{$project->name}}</option>
                                        @break
                                    @endif
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Теги</label>
                            <select class="form-control select2" name="tags[]" id="tags" multiple="multiple">
                                @foreach($post->tags as $tag)
                                    <option value="{{$tag->id}}" selected="selcted">{{$tag->name}}
                                        @if($tag->translate->firstWhere('lang', 'ua'))
                                        (укр: {{$tag->translate->firstWhere('lang', 'ua')->name}})
                                        @endif
                                        @if($tag->translate->firstWhere('lang', 'en'))
                                        (eng: {{$tag->translate->firstWhere('lang', 'en')->name}})
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Изображение статьи</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label class="control-label ">Изображение<span class="input-request">*</span></label>
                            <div class="load-image-container project-img ">
                            @if(!empty($post->image))
                                <div class="load-img active" style="background-image: url({{$post->image}});">
                                    <input type="hidden" class="upload_image_name" name="image" value="{{$post->image}}">
                                </div>
                                <button type="button" class="btn btn-primary image_upload">Изменить изображение</button>
                                <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                            @else
                                <div class="load-img">
                                    <input type="hidden" class="upload_image_name" name="image">
                                </div>
                                <button type="button" class="btn btn-primary image_upload">Добавить изображение</button>
                                <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                            @endif
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->

            </div>
        </form>
    </div><!-- /.row -->
@endsection

@section('scripts')
    <script>
		$('#author_id').select2({
			placeholder: "Выберите пользователя...",
			tegs: true,
			minimumInputLength: 0,
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

		$('#project_id').select2({
			placeholder: "Выберите проект...",
			tegs: true,
			minimumInputLength: 0,
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

		$('#tags').select2({
			placeholder: "Выберите теги...",
			tegs: true,
			minimumInputLength: 0,
			ajax: {
				url: '{!! route('adm_post_tag_find') !!}',
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
    </script>
@endsection
