@extends('admin.layouts.layout')

@section('content')

    <div class='row'>
        <form action="{{route('adm_project_save',['project_id'=>$project->id])}}" method="post" enctype="multipart/form-data" class="validation-form">
            {{ csrf_field() }}
            <input type="hidden" id="upload_path" value="/uploads/images/">
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
                                <input type="text" id="name-ru" name="name" class="form-control project-name required" value="{{$project->name}}" placeholder="Введите название проекта...">
                            </div>
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Название проекта<span class="input-request">*</span></label>
                                <input type="text" id="name-ua" name="nameUA" class="form-control project-name required" value="{{$translate->name}}" placeholder="Введите название проекта...">
                            </div>
                        </div>
                        <div class="form-group project-url not-edit url-ru" id="project-url-ru"><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Постоянная ссылка: <div class="edit-url">
                                <div class="edit-a active">
                                    <a href="{{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/ru/projects/{{$project->url}}" class="link-url"><span class="static-part">{{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/ru/projects/</span><span class="edit-part">{{$project->url}}</span></a>
                                    <button type="button" class="btn btn-default btn-sm change-url">Изменить</button>
                                </div>
                                <div class="edit-input">
                                    {{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/ru/projects/</span><input type="text" class="new-url" name="url" value="{{$project->url}}">
                                    <button type="button" class="btn btn-success btn-sm save-url">Ок</button>
                                    <button type="button" class="btn btn-default btn-sm cancel-url">Отмена</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group project-url not-edit url-ua" id="project-url-ua"><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Постоянная ссылка: <div class="edit-url">
                                <div class="edit-a active">
                                    <a href="{{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/projects/{{$translate->url}}" class="link-url"><span class="static-part">{{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/projects/</span><span class="edit-part">{{$translate->url}}</span></a>
                                    <button type="button" class="btn btn-default btn-sm change-url">Изменить</button>
                                </div>
                                <div class="edit-input">
                                    {{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/projects/<input type="text" class="new-url" name="urlUA" value="{{$translate->url}}">
                                    <button type="button" class="btn btn-success btn-sm save-url">Ок</button>
                                    <button type="button" class="btn btn-default btn-sm cancel-url">Отмена</button>
                                </div>
                            </div>
                        </div>

                        <script>
							var isURLRoute = "{{route('adm_project_valid_url',[$project->id])}}";
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
                                        <textarea class="form-control required" name="short_description" rows="5" placeholder="Введите краткое описание проекта...">{{$project->short_description}}</textarea>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_2-2">
                                        <textarea class="form-control required" name="short_descriptionUA" rows="5" placeholder="Введите краткое описание проекта...">{{$translate->short_description}}</textarea>
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
                                        <textarea class="editor required" id="text" name="text" rows="10" cols="80">{{$project->text}}</textarea>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="text_2-2">
                                        <textarea class="editor required" id="text" name="textUA" rows="10" cols="80">{{$translate->text}}</textarea>
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Краткое название продукта<span class="input-request">*</span></label>
                                <input type="text" id="product_name" name="product_name" value="{{$project->product_name}}" class="form-control required" placeholder="Введите краткое название продукта...">
                            </div>
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Краткое название продукта<span class="input-request">*</span></label>
                                <input type="text" id="product_nameUA" name="product_nameUA" value="{{$translate->product_name}}" class="form-control required" placeholder="Введите краткое название продукта...">
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
                                                    @if(!empty($project->main_image))
                                                        <div class="load-img active" style="background-image: url({{$project->main_image}});">
                                                            <input type="hidden" class="upload_image_name" name="main_image" value="{{$project->main_image}}">
                                                        </div>
                                                        <button type="button" class="btn btn-primary image_upload">Изменить изображение</button>
                                                        <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                    @else
                                                        <div class="load-img">
                                                            <input type="hidden" class="upload_image_name" name="main_image">
                                                        </div>
                                                        <button type="button" class="btn btn-primary image_upload">Добавить изображение</button>
                                                        <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="avatar" class="control-label">Превью для каталога<span class="input-request">*</span></label>
                                                <div class="load-image-container project-img ">
                                                    @if(!empty($project->preview_image))
                                                        <div class="load-img active" style="background-image: url({{$project->preview_image}});">
                                                            <input type="hidden" class="upload_image_name" name="preview_image" value="{{$project->preview_image}}">
                                                        </div>
                                                        <button type="button" class="btn btn-primary image_upload">Изменить изображение</button>
                                                        <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                    @else
                                                        <div class="load-img">
                                                            <input type="hidden" class="upload_image_name" name="preview_image">
                                                        </div>
                                                        <button type="button" class="btn btn-primary image_upload">Добавить изображение</button>
                                                        <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                    @endif
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
                                                    @if(!empty($translate->main_image))
                                                        <div class="load-img active" style="background-image: url({{$translate->main_image}});">
                                                            <input type="hidden" class="upload_image_name" name="main_image_ua" value="{{$translate->main_image}}">
                                                        </div>
                                                        <button type="button" class="btn btn-primary image_upload">Изменить изображение</button>
                                                        <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                    @else
                                                        <div class="load-img">
                                                            <input type="hidden" class="upload_image_name" name="main_image_ua">
                                                        </div>
                                                        <button type="button" class="btn btn-primary image_upload">Добавить изображение</button>
                                                        <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="avatar" class="control-label">Превью для каталога<span class="input-request">*</span></label>
                                                <div class="load-image-container project-img ">
                                                    @if(!empty($translate->preview_image))
                                                        <div class="load-img active" style="background-image: url({{$translate->preview_image}});">
                                                            <input type="hidden" class="upload_image_name" name="preview_image_ua" value="{{$translate->preview_image}}">
                                                        </div>
                                                        <button type="button" class="btn btn-primary image_upload">Изменить изображение</button>
                                                        <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                    @else
                                                        <div class="load-img">
                                                            <input type="hidden" class="upload_image_name" name="preview_image_ua">
                                                        </div>
                                                        <button type="button" class="btn btn-primary image_upload">Добавить изображение</button>
                                                        <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
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
                        <h3 class="box-title">Результаты проекта</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <div class="questions-list list-child">
                                @foreach($project->blocks as $block)
                                    <div class="question-item active" id="question_{{$block->id}}">
                                        <input type="hidden" name="question[]" class="question_id" value="{{$block->id}}">
                                        <div class="question-header">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <div class="drag-zone">
                                                        <i class="fa fa-arrows-v" aria-hidden="true"></i>
                                                    </div>
                                                    <i class="fa fa-chevron-up" aria-hidden="true"></i>
                                                    <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                                    <span class="question-title">{{$block->text}}</span>
                                                </div>
                                                <div class="col-md-1 text-right">
                                                    <i class="fa fa-times delete-question" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="question-body">
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Подпись<span class="input-request">*</span></label>
                                                    <input type="text" name="label_ru[]" class="form-control question-name none-required" placeholder="Введите подпись..." value="{{$block->text}}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Подпись<span class="input-request">*</span></label>
                                                    <input type="text" name="label_ua[]" class="form-control" placeholder="Введите подпись..." value="{{$block->translate->text}}">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-12">
                                                    <label>Проценты<span class="input-request">*</span></label>
                                                    <input type="text" name="label_procent[]" class="form-control question-name none-required" placeholder="Введите количество процентов..."  value="{{$block->procent}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="add-zone">
                            <i class="fa fa-plus" aria-hidden="true"></i>
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
                                <input type="text" id="title" name="title" value="{{$project->seo_title}}" class="form-control" placeholder="Введите Title проекта...">
                            </div>
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Title</label>
                                <input type="text" id="titleUA" name="titleUA"  value="{{$translate->seo_title}}" class="form-control" placeholder="Введите Title проекта...">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Description</label>
                                <textarea class="form-control" name="seo_description" rows="5" placeholder="Введите Description проекта...">{{$project->seo_description}}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Description</label>
                                <textarea class="form-control" name="seo_description_ua" rows="5" placeholder="Введите Description проекта...">{{$translate->seo_description}}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Keywords</label>
                                <input type="text" class="form-control" name="keywords" value="{{$project->seo_keyword}}" placeholder="Введите Keywords проекта...">
                            </div>
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Keywords</label>
                                <input type="text" class="form-control" name="keywordsUA" value="{{$translate->seo_keyword}}" placeholder="Введите Keywords проекта...">
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->

            </div>
            <div class="col-md-3">
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
                @if($project->type != 'only-expert')
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Управление проектом для блогеров</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        @if($project->bloggers->count() == 0)
                            <a href="{{route('adm_project_blogger_add_member',[$project->id])}}" class="btn btn-block btn-primary btn-lg">Сделать подбор</a>
                        @else
                            <a href="{{route('adm_project_blogger_view_member',[$project->id])}}" class="btn btn-block btn-primary btn-lg">Таблица блоггеров проекта</a>
                        @endif
                            <a href="{{route('adm_project_blogger_post',['project_id'=>$project->id])}}" class="btn btn-block btn-primary btn-lg">Посты блоггеров ({{$project->blogger_posts_count}})</a>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                @endif
                <!-- Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Материалы проекта</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <p><a href="{{route('adm_project_subpage_project',['project_id'=>$project->id])}}">Подстраницы проекта ({{$project->subpages_count}})</a></p>
                        <p><a href="{{route('adm_project_message',['project_id'=>$project->id])}}">Сообщения ({{$project->messages_count}})</a></p>
                        <p><a href="{{route('adm_project_links',['project_id'=>$project->id])}}">Ссылки ({{$project->links_count}})</a></p>
                        <p><a href='{{route('adm_select_project_request',['project_id'=>$project->id])}}'>Заявки на участие в проекте ({{$project->requests_count}})</a></p>
                        <p><a href='{{route('adm_questionnaire_project',['project_id'=>$project->id])}}'>Анкеты проекта ({{$project->questionnaires_count}})</a></p>
                        <p><a href="{{route('adm_review')}}?filter={{ $reviewFilter }}">Отзывы ({{$countReviews}})</a></p>
                        <p><a href="{{route('adm_project_pdf',['project_id'=>$project->id])}}">Выгрузить отзывы в PDF</a></p>
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
                            <input class="form-control" type="text" name="password">
                        </div>
                        <div class="form-group">
                            <label for="category_select">Категория<span class="input-request">*</span></label>
                            <select class="form-control required" id="sub-url" name="category" style="width: 100%;">
                                <option value="">--</option>
                                @foreach($categories as $category)
                                    <option data-url-ru="{{$category->url}}" data-url-ua="{{$category->translate->url}}" value="{{$category->id}}"{{($project->category_id == $category->id)?" selected=selected":""}}>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Тип проекта<span class="input-request">*</span></label>
                            <select class="form-control required" name="type" style="width: 100%;">
                                <option value="">--</option>
                                <option value="only-expert"{{($project->type == "only-expert")?" selected=selected":""}}>Только эксперты</option>
                                <option value="expert-blogger"{{($project->type == "expert-blogger")?" selected=selected":""}}>Блогеры и эксперты</option>
                                <option value="only-blogger"{{($project->type == "only-blogger")?" selected=selected":""}}>Только блогеры</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Аудитория проекта<span class="input-request">*</span></label>
                            <select class="form-control required" name="audience" style="width: 100%;">
                                @foreach($audienceArray as $audience)
                                    <option value="{{$audience}}" @if($project->audience->getValue() === $audience) selected="selected" @endif>{{trans('project.audience_'.$audience)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Статус</label>
                            <select class="form-control" name="status" style="width: 100%;">
                                <option value="">--</option>
                                @foreach($statuses as $status)
                                    <option value="{{$status->id}}"{{($project->status_id == $status->id)?" selected=selected":""}}>{{$status->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Количество участников</label>
                            <input type="number" name="count_users" value="{{$project->count_users}}" class="form-control required" placeholder="Введите Количество участников.." min="0">
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
                            <input size="16" type="text" name="start_registration_time" value="{{$project->start_registration_time}}" class="form-control form_datetime required">
                        </div>
                        <div class="form-group">
                            <label>Дата оканчания регистрации проекта<span class="input-request">*</span></label>
                            <input size="16" type="text" name="end_registration_time" value="{{$project->end_registration_time}}" class="form-control form_datetime required">
                        </div>
                        <div class="form-group">
                            <label>Дата начала тестирования<span class="input-request">*</span></label>
                            <input size="16" type="text" name="start_test_time" value="{{$project->start_test_time}}" class="form-control form_datetime required">
                        </div>
                        <div class="form-group">
                            <label>Дата заполнения отчёта<span class="input-request">*</span></label>
                            <input size="16" type="text" name="start_report_time" value="{{$project->start_report_time}}" class="form-control form_datetime required">
                        </div>
                        <div class="form-group">
                            <label>Дата окончания проекта<span class="input-request">*</span></label>
                            <input size="16" type="text" name="end_project_time" value="{{$project->end_project_time}}" class="form-control form_datetime required">
                        </div>

                    </div><!-- /.box-body -->
                </div><!-- /.box -->

            </div>
        </form>
    </div><!-- /.row -->
    <div class="hide new-template">
        <div class="question-item active">
            <input type="hidden" name="question[]" class="question_id">
            <div class="question-header">
                <div class="row">
                    <div class="col-md-11">
                        <div class="drag-zone">
                            <i class="fa fa-arrows-v" aria-hidden="true"></i>
                        </div>
                        <i class="fa fa-chevron-up" aria-hidden="true"></i>
                        <i class="fa fa-chevron-down" aria-hidden="true"></i>
                        <span class="question-title">тест результат</span>
                    </div>
                    <div class="col-md-1 text-right">
                        <i class="fa fa-times delete-question" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
            <div class="question-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Подпись<span class="input-request">*</span></label>
                        <input type="text" name="label_ru[]" class="form-control question-name none-required" placeholder="Введите подпись...">
                    </div>
                    <div class="col-md-6">
                        <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Подпись<span class="input-request">*</span></label>
                        <input type="text" name="label_ua[]" class="form-control" placeholder="Введите подпись...">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <label>Проценты<span class="input-request">*</span></label>
                        <input type="text" name="label_procent[]" class="form-control question-name none-required" placeholder="Введите количество процентов...">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

