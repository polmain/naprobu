@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <form action="{{route('adm_project_subpage_save',['subpage_id'=>$subpage->id])}}" method="post" enctype="multipart/form-data" class="validation-form">
            {{ csrf_field() }}
            <div class='col-md-9'>
                <!-- Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Основные параметры подстраницы</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Название подстраницы<span class="input-request">*</span></label>
                                <input type="text" id="name-ru" name="name" value="{{$subpage->name}}" class="form-control project-name required" placeholder="Введите название подстраницы...">
                            </div>
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Название подстраницы<span class="input-request">*</span></label>
                                <input type="text" id="name-ua" name="nameUA" value="{{$translate->name}}" class="form-control project-name required" placeholder="Введите название подстраницы...">
                            </div>
                        </div>
                        <div class="form-group project-url edit url-ru" id="project-url-ru"><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Постоянная ссылка: <div class="edit-url">
                                <div class="edit-a active">
                                    <a href="{{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/ru/projects/{{$subpage->project->url}}/{{$subpage->url}}" class="link-url"><span class="static-part">{{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/ru/projects/</span><span class="category-part">{{$subpage->project->url}}/</span><span class="edit-part">{{$subpage->url}}</span></a>
                                    <button type="button" class="btn btn-default btn-sm change-url">Изменить</button>
                                </div>
                                <div class="edit-input">
                                    {{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/ru/projects/<span class="category-part">{{$subpage->project->url}}/</span><input type="text" class="new-url" value="{{$subpage->url}}" name="url">
                                    <button type="button" class="btn btn-success btn-sm save-url">Ок</button>
                                    <button type="button" class="btn btn-default btn-sm cancel-url">Отмена</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group project-url edit url-ua" id="project-url-ua"><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Постоянная ссылка: <div class="edit-url">
                                <div class="edit-a active">
                                    <a href="{{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/projects/{{(!empty($translate->project))?$translate->project->url."/":""}}{{$translate->url}}" class="link-url"><span class="static-part">{{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/projects/</span><span class="category-part">{{(!empty($translate->project))?$translate->project->url."/":""}}</span><span class="edit-part">{{$translate->url}}</span></a>
                                    <button type="button" class="btn btn-default btn-sm change-url">Изменить</button>
                                </div>
                                <div class="edit-input">
                                    {{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/projects/{{(!empty($translate->project))?$translate->project->url."/":""}}<span class="category-part"></span><input type="text" class="new-url" name="urlUA" value="{{$translate->url}}">
                                    <button type="button" class="btn btn-success btn-sm save-url">Ок</button>
                                    <button type="button" class="btn btn-default btn-sm cancel-url">Отмена</button>
                                </div>
                            </div>
                        </div>
                        <script>
							var isURLRoute = "{{route('adm_project_subpage_valid_url',[$subpage->id])}}";
                        </script>

                        <div class="form-group">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs pull-right">
                                    <li><a href="#text_2-2" data-toggle="tab"><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"></a></li>
                                    <li class="active"><a href="#text_1-1" data-toggle="tab"><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"></a></li>
                                    <li class="pull-left header"><label>Текст подстраницы</label></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="text_1-1">
                                        <textarea class="editor" id="text" name="text" rows="10" cols="80">{{$subpage->text}}</textarea>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="text_2-2">
                                        <textarea class="editor" id="text" name="textUA" rows="10" cols="80">{{$translate->text}}</textarea>
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->

                <div class="row">
                    <div class="col-md-6">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title"><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Изображение подстраницы</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="avatar" class="control-label ">Превью</label>
                                    <div class="load-image-container project-img ">
                                        @if(!empty($subpage->image))
                                            <div class="load-img active" style="background-image: url({{$subpage->image}});">
                                                <input type="hidden" class="upload_image_name" name="image" value="{{$subpage->image}}">
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
                    <div class="col-md-6">

                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title"><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Изображение подстраницы</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="avatar" class="control-label ">Превью</label>
                                    <div class="load-image-container project-img ">
                                        @if(!empty($translate->image))
                                            <div class="load-img active" style="background-image: url({{$translate->image}});">
                                                <input type="hidden" class="upload_image_name" name="image_ua" value="{{$translate->image}}">
                                            </div>
                                            <button type="button" class="btn btn-primary image_upload">Изменить изображение</button>
                                            <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                        @else
                                            <div class="load-img">
                                                <input type="hidden" class="upload_image_name" name="image_ua">
                                            </div>
                                            <button type="button" class="btn btn-primary image_upload">Добавить изображение</button>
                                            <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                        @endif
                                    </div>
                                </div>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div>
                </div>

                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">SEO подстраницы</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Title</label>
                                <input type="text" id="title" name="title" class="form-control" placeholder="Введите Title подстраницы..." value="{{$subpage->seo_title}}">
                            </div>
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Title</label>
                                <input type="text" id="titleUA" name="titleUA" class="form-control" placeholder="Введите Title подстраницы..." value="{{$translate->seo_title}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Description</label>
                                <textarea class="form-control" name="description" rows="5" placeholder="Введите Description подстраницы...">{{$subpage->seo_description}}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Description</label>
                                <textarea class="form-control" name="descriptionUA" rows="5" placeholder="Введите Description подстраницы...">{{$translate->seo_description}}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Keywords</label>
                                <input type="text" class="form-control" name="keywords" placeholder="Введите Keywords подстраницы..." value="{{$subpage->seo_keyword}}">
                            </div>
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Keywords</label>
                                <input type="text" class="form-control" name="keywordsUA" placeholder="Введите Keywords подстраницы..." value="{{$translate->seo_keyword}}">
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
                        <button type="button" class="btn btn-block btn-danger btn-lg" onclick="document.location.href='/admin/project/subpages/';">Отмена</button>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                <!-- Box -->
                <!-- Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Материалы подстраница</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <p><a href="{{route('adm_review')}}?filter={{ $reviewFilter }}">Отзывы ({{$countReviews}})</a></p>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                <!-- Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Настройки подстраницы</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Тип страницы<span class="input-request">*</span></label>
                            <select class="form-control required" name="type" style="width: 100%;">
                                <option selected="selected" value="">--</option>
                                @foreach($types as $type)
                                    <option  value="{{$type->id}}"{{($subpage->type_id == $type->id)?" selected=selected":""}}>{{$type->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Проект<span class="input-request">*</span></label>
                            <select class="form-control required select2" id="sub-url" name="project" style="width: 100%;">
                                <option selected="selected" value="">--</option>
                                @foreach($projects->reverse() as $project)
                                    <option data-url-ru="{{$project->category->url}}/{{$project->url}}" data-url-ua="{{$project->category->translate->url}}/{{(!empty($project->translate))?$project->translate->url:''}}" value="{{$project->id}}"{{($subpage->project_id == $project->id)?" selected=selected":""}}>{{$project->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" class="minimal-red" name="isReview" value="true"{{($subpage->hasReviews)?" checked=checked":""}}>
                                Отзывы
                            </label>
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" class="minimal-red" name="isComments" value="true"{{($subpage->hasComments)?" checked=checked":""}}>
                                Комментарии
                            </label>
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" class="minimal-red" name="isForm" value="true"{{($subpage->isReviewForm)?" checked=checked":""}}>
                                Форма новых отзывов/комментариев
                            </label>
                        </div>
                        <div class="form-group">
                            <label>Минимальное количество символов для формы отзывов</label>
                            <input type="number" class="form-control" name="min_charsets" min="0" value="{{$subpage->min_charsets}}">
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                <!-- Box -->
                <!-- Box -->
            </div>
        </form>
    </div><!-- /.row -->
@endsection
