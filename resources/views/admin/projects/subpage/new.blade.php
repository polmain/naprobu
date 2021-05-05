@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <form action="{{route('adm_project_subpage_create')}}" method="post" enctype="multipart/form-data" class="validation-form">
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
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Название подстраницы<span class="input-request">*</span></label>
                                <input type="text" id="name-ru" name="name" class="form-control project-name required" placeholder="Введите название подстраницы...">
                            </div>
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Название подстраницы</label>
                                <input type="text" id="name-ua" name="nameUA" class="form-control project-name" placeholder="Введите название подстраницы...">
                            </div>
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> Название подстраницы</label>
                                <input type="text" id="name-en" name="nameEN" class="form-control project-name" placeholder="Введите название подстраницы...">
                            </div>
                        </div>
                        <div class="form-group project-url edit url-ru" id="project-url-ru"><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Постоянная ссылка: <div class="edit-url">
                                <div class="edit-a active">
                                    <a href="{{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/ru/projects/" class="link-url"><span class="static-part">{{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/ru/projects/</span><span class="category-part"></span><span class="edit-part"></span></a>
                                    <button type="button" class="btn btn-default btn-sm change-url">Изменить</button>
                                </div>
                                <div class="edit-input">
                                    {{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/ru/projects/<span class="category-part"></span><input type="text" class="new-url" name="url">
                                    <button type="button" class="btn btn-success btn-sm save-url">Ок</button>
                                    <button type="button" class="btn btn-default btn-sm cancel-url">Отмена</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group project-url edit url-ua" id="project-url-ua"><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Постоянная ссылка: <div class="edit-url">
                                <div class="edit-a active">
                                    <a href="{{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/projects/" class="link-url"><span class="static-part">{{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/projects/</span><span class="category-part"></span><span class="edit-part"></span></a>
                                    <button type="button" class="btn btn-default btn-sm change-url">Изменить</button>
                                </div>
                                <div class="edit-input">
                                    {{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/projects/<span class="category-part"></span><input type="text" class="new-url" name="urlUA">
                                    <button type="button" class="btn btn-success btn-sm save-url">Ок</button>
                                    <button type="button" class="btn btn-default btn-sm cancel-url">Отмена</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group project-url edit url-en" id="project-url-en"><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> Постоянная ссылка: <div class="edit-url">
                                <div class="edit-a active">
                                    <a href="{{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/en/projects/" class="link-url"><span class="static-part">{{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/en/projects/</span><span class="category-part"></span><span class="edit-part"></span></a>
                                    <button type="button" class="btn btn-default btn-sm change-url">Изменить</button>
                                </div>
                                <div class="edit-input">
                                    {{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/en/projects/<span class="category-part"></span><input type="text" class="new-url" name="urlEN">
                                    <button type="button" class="btn btn-success btn-sm save-url">Ок</button>
                                    <button type="button" class="btn btn-default btn-sm cancel-url">Отмена</button>
                                </div>
                            </div>
                        </div>

                        <script>
							var isURLRoute = "{{route('adm_project_subpage_valid_url',[0])}}";
                        </script>
                        <div class="form-group">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs pull-right">
                                    <li><a href="#text_2-3" data-toggle="tab"><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"></a></li>
                                    <li><a href="#text_2-2" data-toggle="tab"><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"></a></li>
                                    <li class="active"><a href="#text_1-1" data-toggle="tab"><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"></a></li>
                                    <li class="pull-left header"><label>Описание подстраницы</label></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="text_1-1">
                                        <textarea class="editor" id="text" name="text" rows="10" cols="80"></textarea>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="text_2-2">
                                        <textarea class="editor" id="text" name="textUA" rows="10" cols="80"></textarea>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="text_2-3">
                                        <textarea class="editor" id="text" name="textEN" rows="10" cols="80"></textarea>
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title"><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Изображение подстраницы</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="avatar" class="control-label">Превью</label>
                                    <div class="load-image-container project-img ">
                                        <div class="load-img">
                                            <input type="hidden" class="upload_image_name" name="image">
                                        </div>
                                        <button type="button" class="btn btn-primary image_upload">Добавить изображение</button>
                                        <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                    </div>
                                </div>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div>
                    <div class="col-md-4">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title"><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Изображение подстраницы</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="avatar" class="control-label">Превью</label>
                                    <div class="load-image-container project-img ">
                                        <div class="load-img">
                                            <input type="hidden" class="upload_image_name" name="image_ua">
                                        </div>
                                        <button type="button" class="btn btn-primary image_upload">Добавить изображение</button>
                                        <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                    </div>
                                </div>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div>
                    <div class="col-md-4">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title"><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> Изображение подстраницы</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="avatar" class="control-label">Превью</label>
                                    <div class="load-image-container project-img ">
                                        <div class="load-img">
                                            <input type="hidden" class="upload_image_name" name="image_en">
                                        </div>
                                        <button type="button" class="btn btn-primary image_upload">Добавить изображение</button>
                                        <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
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
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Title</label>
                                <input type="text" id="title" name="title" class="form-control" placeholder="Введите Title подстраницы...">
                            </div>
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Title</label>
                                <input type="text" id="titleUA" name="titleUA" class="form-control" placeholder="Введите Title подстраницы...">
                            </div>
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> Title</label>
                                <input type="text" id="titleEN" name="titleEN" class="form-control" placeholder="Введите Title подстраницы...">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Description</label>
                                <textarea class="form-control" name="description" rows="5" placeholder="Введите Description подстраницы..."></textarea>
                            </div>
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Description</label>
                                <textarea class="form-control" name="descriptionUA" rows="5" placeholder="Введите Description подстраницы..."></textarea>
                            </div>
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> Description</label>
                                <textarea class="form-control" name="descriptionEN" rows="5" placeholder="Введите Description подстраницы..."></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Keywords</label>
                                <input type="text" class="form-control" name="keywords" placeholder="Введите Keywords подстраницы...">
                            </div>
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Keywords</label>
                                <input type="text" class="form-control" name="keywordsUA" placeholder="Введите Keywords подстраницы...">
                            </div>
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> Keywords</label>
                                <input type="text" class="form-control" name="keywordsEN" placeholder="Введите Keywords подстраницы...">
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
                                    <option  value="{{$type->id}}">{{$type->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Проект<span class="input-request">*</span></label>
                            <select class="form-control required select2" id="sub-url" name="project" style="width: 100%;">
                                <option selected="selected" value="">--</option>
                                @foreach($projects->reverse() as $project)
                                    <option
                                        data-url-ru="{{$project->url}}"
                                        data-url-ua="{{$project->translate->firstWhere('lang','ua')?$project->translate->firstWhere('lang','ua')->url:''}}"
                                        data-url-en="{{$project->translate->firstWhere('lang','en')?$project->translate->firstWhere('lang','en')->url:''}}"
                                        value="{{$project->id}}">
                                        {{$project->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" class="minimal-red" name="isReview" value="true">
                                Отзывы
                            </label>
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" class="minimal-red" name="isComments" value="true">
                                Комментарии
                            </label>
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" class="minimal-red" name="isForm" value="true" checked>
                                Форма новых отзывов/комментариев
                            </label>
                        </div>
                        <div class="form-group">
                            <label>Минимальное количество символов для формы отзывов</label>
                            <input type="number" class="form-control" name="min_charsets" min="0" value="0">
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                <!-- Box -->
                <!-- Box -->

            </div>
        </form>
    </div><!-- /.row -->
@endsection
