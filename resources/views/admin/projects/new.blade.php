@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <form action="{{route('adm_project_create')}}" method="post" enctype="multipart/form-data" class="validation-form">
            {{ csrf_field() }}
            <div class='col-md-9'>
                <!-- Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Основные параметры проекта</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Название проекта<span class="input-request">*</span></label>
                                <input type="text" id="name-ru" name="name" class="form-control project-name required" placeholder="Введите название проекта...">
                            </div>
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Название проекта<span class="input-request">*</span></label>
                                <input type="text" id="name-ua" name="nameUA" class="form-control project-name required" placeholder="Введите название проекта...">
                            </div>
                        </div>
                        <div class="form-group project-url edit url-ru" id="project-url-ru"><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Постоянная ссылка: <div class="edit-url">
                                <div class="edit-a active">
                                    <a href="{{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/ru/projects/" class="link-url"><span class="static-part">{{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/ru/projects/</span><span class="edit-part"></span></a>
                                    <button type="button" class="btn btn-default btn-sm change-url">Изменить</button>
                                </div>
                                <div class="edit-input">
                                    {{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/ru/projects/<input type="text" class="new-url" name="url">
                                    <button type="button" class="btn btn-success btn-sm save-url">Ок</button>
                                    <button type="button" class="btn btn-default btn-sm cancel-url">Отмена</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group project-url edit url-ua" id="project-url-ua"><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Постоянная ссылка: <div class="edit-url">
                                <div class="edit-a active">
                                    <a href="{{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/projects/" class="link-url"><span class="static-part">{{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/projects/</span><span class="edit-part"></span></a>
                                    <button type="button" class="btn btn-default btn-sm change-url">Изменить</button>
                                </div>
                                <div class="edit-input">
                                    {{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/projects/<input type="text" class="new-url" name="urlUA">
                                    <button type="button" class="btn btn-success btn-sm save-url">Ок</button>
                                    <button type="button" class="btn btn-default btn-sm cancel-url">Отмена</button>
                                </div>
                            </div>
                        </div>
                        <script>
							var isURLRoute = "{{route('adm_project_valid_url',[0])}}";
                        </script>
                        <div class="form-group">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs pull-right">
                                    <li><a href="#tab_2-2" data-toggle="tab"><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"></a></li>
                                    <li class="active"><a href="#tab_1-1" data-toggle="tab"><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"></a></li>
                                    <li class="pull-left header"><label>Краткое описание проекта<span class="input-request">*</span></label></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_1-1">
                                        <textarea class="form-control required" name="short_description" rows="5" placeholder="Введите краткое описание проекта..."></textarea>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_2-2">
                                        <textarea class="form-control required" name="short_descriptionUA" rows="5" placeholder="Введите краткое описание проекта..."></textarea>
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs pull-right">
                                    <li><a href="#text_2-2" data-toggle="tab"><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"></a></li>
                                    <li class="active"><a href="#text_1-1" data-toggle="tab"><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"></a></li>
                                    <li class="pull-left header"><label>Полное описание проекта<span class="input-request">*</span></label></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="text_1-1">
                                        <textarea class="editor required" id="text" name="text" rows="10" cols="80"></textarea>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="text_2-2">
                                        <textarea class="editor required" id="text" name="textUA" rows="10" cols="80"></textarea>
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Краткое название продукта<span class="input-request">*</span></label>
                                <input type="text" id="product_name" name="product_name" class="form-control required" placeholder="Введите краткое название продукта...">
                            </div>
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Краткое название продукта<span class="input-request">*</span></label>
                                <input type="text" id="product_nameUA" name="product_nameUA" class="form-control required" placeholder="Введите краткое название продукта...">
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                <!-- Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Изображения проекта</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs pull-right">
                                    <li><a href="#tab_3-2" data-toggle="tab"><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"></a></li>
                                    <li class="active"><a href="#tab_3-1" data-toggle="tab"><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"></a></li>
                                    <li class="pull-left header"><label>Изображения проекта<span class="input-request">*</span></label></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active row" id="tab_3-1">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="avatar" class="control-label ">Главное изображение<span class="input-request">*</span></label>
                                                <div class="load-image-container project-img ">
                                                    <div class="load-img">
                                                        <input type="hidden" class="upload_image_name" name="main_image">
                                                    </div>
                                                    <button type="button" class="btn btn-primary image_upload">Добавить изображение</button>
                                                    <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="avatar" class="control-label">Превью для каталога<span class="input-request">*</span></label>
                                                <div class="load-image-container project-img ">
                                                    <div class="load-img">
                                                        <input type="hidden" class="upload_image_name" name="preview_image">
                                                    </div>
                                                    <button type="button" class="btn btn-primary image_upload">Добавить изображение</button>
                                                    <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane row" id="tab_3-2">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="avatar" class="control-label ">Главное изображение<span class="input-request">*</span></label>
                                                <div class="load-image-container project-img ">
                                                    <div class="load-img">
                                                        <input type="hidden" class="upload_image_name" name="main_image_ua">
                                                    </div>
                                                    <button type="button" class="btn btn-primary image_upload">Добавить изображение</button>
                                                    <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="avatar" class="control-label">Превью для каталога<span class="input-request">*</span></label>
                                                <div class="load-image-container project-img ">
                                                    <div class="load-img">
                                                        <input type="hidden" class="upload_image_name" name="preview_image_ua">
                                                    </div>
                                                    <button type="button" class="btn btn-primary image_upload">Добавить изображение</button>
                                                    <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                </div>
                                            </div>
                                        </div>                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->

                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">SEO проекта</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Title</label>
                                <input type="text" id="title" name="title" class="form-control" placeholder="Введите Title проекта...">
                            </div>
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Title</label>
                                <input type="text" id="titleUA" name="titleUA" class="form-control" placeholder="Введите Title проекта...">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Description</label>
                                <textarea class="form-control" name="seo_description" rows="5" placeholder="Введите Description проекта..."></textarea>
                            </div>
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Description</label>
                                <textarea class="form-control" name="seo_description_ua" rows="5" placeholder="Введите Description проекта..."></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Keywords</label>
                                <input type="text" class="form-control" name="keywords" placeholder="Введите Keywords проекта...">
                            </div>
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Keywords</label>
                                <input type="text" class="form-control" name="keywordsUA" placeholder="Введите Keywords проекта...">
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->



                <div class="form-group">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs pull-right">
                            <li><a href="#text_5-2" data-toggle="tab"><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"></a></li>
                            <li class="active"><a href="#text_5-1" data-toggle="tab"><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"></a></li>
                            <li class="pull-left header"><label>Описание продукта</label></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="text_5-1">
                                <textarea class="editor" id="text" name="product_info" rows="10" cols="80"></textarea>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="text_5-2">
                                <textarea class="editor" id="text" name="product_infoUA" rows="10" cols="80"></textarea>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div>
                </div>

                <div class="form-group">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs pull-right">
                            <li><a href="#text_6-2" data-toggle="tab"><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"></a></li>
                            <li class="active"><a href="#text_6-1" data-toggle="tab"><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"></a></li>
                            <li class="pull-left header"><label>FAQ</label></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="text_6-1">
                                <textarea class="editor" id="text" name="faq" rows="10" cols="80"></textarea>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="text_6-2">
                                <textarea class="editor" id="text" name="faqUA" rows="10" cols="80"></textarea>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div>
                </div>

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
                        <button type="button" class="btn btn-block btn-danger btn-lg" onclick="document.location.href='/admin/project/';">Отмена</button>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                <!-- Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Настройки проекта</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Пароль для просмотра проекта в черновике</label>
                            <input class="form-control" type="text" name="password" value="{{str_random(8)}}">
                        </div>
                        <div class="form-group">
                            <label>Категория<span class="input-request">*</span></label>
                            <select class="form-control required" id="sub-url" name="category" style="width: 100%;">
                                <option selected="selected" value="">--</option>
                                @foreach($categories as $category)
                                    <option data-url-ru="{{$category->url}}" data-url-ua="{{$category->translate->url}}" value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Тип проекта<span class="input-request">*</span></label>
                            <select class="form-control required" name="type" style="width: 100%;">
                                <option selected="selected" value="">--</option>
                                    <option value="only-expert">Только эксперты</option>
                                    <option value="expert-blogger">Блогеры и эксперты</option>
                                    <option value="only-blogger">Только блогеры</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Аудитория проекта<span class="input-request">*</span></label>
                            <select class="form-control required" name="audience" style="width: 100%;">
                                @foreach($audienceArray as $audience)
                                    <option value="{{$audience}}">{{trans('project.audience_'.$audience)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Страна проекта<span class="input-request">*</span></label>
                            <select class="form-control required" name="country" style="width: 100%;">
                                @foreach($countryCollection as $country)
                                    <option value="{{$country->getCode()}}" @if($country->getCode() === 'UA') selected="selected" @endif>{{$country->getName()}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Статус</label>
                            <select class="form-control" name="status" style="width: 100%;">
                                <option selected="selected" value="">--</option>
                                @foreach($statuses as $status)
                                    <option value="{{$status->id}}">{{$status->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Количество участников</label>
                            <input type="number" name="count_users" class="form-control required" placeholder="Введите Количество участников.." min="0">
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                <!-- Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Даты и времена проекта</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Дата начала регистрации проекта<span class="input-request">*</span></label>
                            <input size="16" type="text" name="start_registration_time" class="form-control form_datetime required" autocomplete="false">
                        </div>
                        <div class="form-group">
                            <label>Дата оканчания регистрации проекта<span class="input-request">*</span></label>
                            <input size="16" type="text" name="end_registration_time" class="form-control form_datetime required" autocomplete="false">
                        </div>
                        <div class="form-group">
                            <label>Дата начала тестирования<span class="input-request">*</span></label>
                            <input size="16" type="text" name="start_test_time" class="form-control form_datetime required" autocomplete="false">
                        </div>
                        <div class="form-group">
                            <label>Дата заполнения отчёта<span class="input-request">*</span></label>
                            <input size="16" type="text" name="start_report_time" class="form-control form_datetime required" autocomplete="false">
                        </div>
                        <div class="form-group">
                            <label>Дата окончания проекта<span class="input-request">*</span></label>
                            <input size="16" type="text" name="end_project_time" class="form-control form_datetime required" autocomplete="false">
                        </div>

                    </div><!-- /.box-body -->
                </div><!-- /.box -->

            </div>
        </form>
    </div><!-- /.row -->
@endsection
