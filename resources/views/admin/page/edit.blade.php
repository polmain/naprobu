@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <form action="{{route('adm_page_save',['page_id'=>$page->id])}}" method="post" enctype="multipart/form-data" class="validation-form">
            {{ csrf_field() }}
            <div class='col-md-9'>
                <!-- Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Основные параметры Страницы</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Название страницы<span class="input-request">*</span></label>
                                <input type="text" id="name-ru" name="name" class="form-control project-name required" placeholder="Введите название страницы..." value="{{$page->name}}">
                            </div>
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Название страницы<span class="input-request">*</span></label>
                                <input type="text" id="name-ua" name="nameUA" class="form-control project-name required" placeholder="Введите название страницы..." value="{{$page->translate->name}}">
                            </div>
                        </div>
                        <div class="form-group project-url edit not-edit url-ru" id="project-url-ru"><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Постоянная ссылка: <div class="edit-url">
                                <div class="edit-a active">
                                    <a href="{{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/ru/{{$page->url}}" class="link-url"><span class="static-part">{{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/ru/</span><span class="edit-part">{{$page->url}}</span></a>
                                    {{--<button type="button" class="btn btn-default btn-sm change-url">Изменить</button>--}}
                                </div>
                                <div class="edit-input">
                                    {{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/ru/<input type="text" class="new-url" name="url" value="{{$page->url}}">
                                    <button type="button" class="btn btn-success btn-sm save-url">Ок</button>
                                    <button type="button" class="btn btn-default btn-sm cancel-url">Отмена</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group project-url edit not-edit url-ua" id="project-url-ua"><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Постоянная ссылка: <div class="edit-url">
                                <div class="edit-a active">
                                    <a href="{{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/{{$page->translate->url}}" class="link-url"><span class="static-part">{{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/</span><span class="edit-part">{{$page->translate->url}}</span></a>
                                    {{--<button type="button" class="btn btn-default btn-sm change-url">Изменить</button>--}}
                                </div>
                                <div class="edit-input">
                                    {{(Request::secure())?"https://":"http://"}}{{Request::getHost()}}/<input type="text" class="new-url" name="urlUA" value="{{$page->translate->url}}">
                                    <button type="button" class="btn btn-success btn-sm save-url">Ок</button>
                                    <button type="button" class="btn btn-default btn-sm cancel-url">Отмена</button>
                                </div>
                            </div>
                        </div>

                        <script>
							var isURLRoute = "{{route('adm_page_url')}}";
                        </script>
                        <div class="form-group">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs pull-right">
                                    <li><a href="#text_2-2" data-toggle="tab"><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"></a></li>
                                    <li class="active"><a href="#text_1-1" data-toggle="tab"><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"></a></li>
                                    <li class="pull-left header"><label>Текст страницы</label></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="text_1-1">
                                        <textarea class="editor" id="text" name="content" rows="10" cols="80">{!! $page->content !!}</textarea>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="text_2-2">
                                        <textarea class="editor" id="textUA" name="contentUA" rows="10" cols="80">{!! $page->translate->content !!}</textarea>
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
                        <h3 class="box-title">SEO страницы</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Title</label>
                                <input type="text" id="title" name="seo_title" class="form-control" placeholder="Введите Title проекта..." value="{{$page->seo_title}}">
                            </div>
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Title</label>
                                <input type="text" id="titleUA" name="seo_titleUA" class="form-control" placeholder="Введите Title проекта..." value="{{$page->translate->seo_title}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Description</label>
                                <textarea class="form-control" name="seo_description" rows="5" placeholder="Введите Description проекта...">{{$page->seo_description}}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Description</label>
                                <textarea class="form-control" name="seo_descriptionUA" rows="5" placeholder="Введите Description проекта...">{{$page->translate->seo_description}}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Keywords</label>
                                <input type="text" class="form-control" name="seo_keywords" placeholder="Введите Keywords проекта..." value="{{$page->seo_keywords}}">
                            </div>
                            <div class="col-md-6">
                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Keywords</label>
                                <input type="text" class="form-control" name="seo_keywordsUA" placeholder="Введите Keywords проекта..." value="{{$page->translate->seo_keywords}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="control-label ">Изображение<span class="input-request">*</span></label>
                                <div class="load-image-container project-img ">
                                    @if(!empty($page->og_image))
                                        <div class="load-img active" style="background-image: url({{$page->og_image}});">
                                            <input type="hidden" class="upload_image_name" name="og_image" value="{{$page->og_image}}">
                                        </div>
                                        <button type="button" class="btn btn-primary image_upload">Изменить изображение</button>
                                        <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                    @else
                                        <div class="load-img">
                                            <input type="hidden" class="upload_image_name" name="og_image">
                                        </div>
                                        <button type="button" class="btn btn-primary image_upload">Добавить изображение</button>
                                        <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->


                @if($page->blocks->where('lang','ru')->first())
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Блоки на странице</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="questions-list list-child">
                            @foreach($page->blocks->where('lang','ru') as $block)

                                <div class="question-item active" id="item_{{$block->id}}">
                                    <input type="hidden" name="block[]" class="block_id" value="{{$block->id}}">
                                    <div class="question-header">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <i class="fa fa-chevron-up" aria-hidden="true"></i>
                                                <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                                <span class="question-title">{{$block->name}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="question-body">
                                        <div class="form-group row">
                                            @switch($block->type_id)
                                                @case(1)
                                                    <div class="col-md-6">
                                                        <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Текст<span class="input-request">*</span></label>
                                                        <input type="text" name="block_content[]" class="form-control required" placeholder="Введите строку..." value="{{$block->content}}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Текст<span class="input-request">*</span></label>
                                                        <input type="text" name="block_content_ua[]" class="form-control required" placeholder="Введите строку..." value="{{$block->translate->first()->content}}">
                                                    </div>
                                                @break
                                                @case(2)
                                                    <div class="nav-tabs-custom">
                                                        <ul class="nav nav-tabs pull-right">
                                                            <li><a href="#text_{{$block->id}}-2" data-toggle="tab"><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"></a></li>
                                                            <li class="active"><a href="#text_{{$block->id}}-1" data-toggle="tab"><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"></a></li>
                                                            <li class="pull-left header"><label>Текст<span class="input-request">*</span></label></li>
                                                        </ul>
                                                        <div class="tab-content">
                                                            <div class="tab-pane active" id="text_{{$block->id}}-1">
                                                                <textarea class="editor" name="block_content[]" rows="10" cols="80">{!! $block->content !!}</textarea>
                                                            </div>
                                                            <!-- /.tab-pane -->
                                                            <div class="tab-pane" id="text_{{$block->id}}-2">
                                                                <textarea class="editor" name="block_content_ua[]" rows="10" cols="80">{!! $block->translate->first()->content !!}</textarea>
                                                            </div>
                                                            <!-- /.tab-pane -->
                                                        </div>
                                                        <!-- /.tab-content -->
                                                    </div>
                                                @break
                                                @case(3)
                                                    <div class="col-md-6">
                                                        <label class="control-label "><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Картинка<span class="input-request">*</span></label>
                                                        <div class="load-image-container project-img ">
                                                            @if(!empty($block->content))
                                                                <div class="load-img active" style="background-image: url({{$block->content}});">
                                                                    <input type="hidden" class="upload_image_name" name="block_content[]" value="{{$block->content}}">
                                                                </div>
                                                                <button type="button" class="btn btn-primary image_upload">Изменить изображение</button>
                                                                <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                            @else
                                                                <div class="load-img">
                                                                    <input type="hidden" class="upload_image_name" name="block_content[]">
                                                                </div>
                                                                <button type="button" class="btn btn-primary image_upload">Добавить изображение</button>
                                                                <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="control-label "><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Картинка<span class="input-request">*</span></label>
                                                        <div class="load-image-container project-img ">
                                                            @if(!empty($block->translate->first()->content))
                                                                <div class="load-img active" style="background-image: url({{$block->translate->first()->content}});">
                                                                    <input type="hidden" class="upload_image_name" name="block_content_ua[]" value="{{$block->translate->first()->content}}">
                                                                </div>
                                                                <button type="button" class="btn btn-primary image_upload">Изменить изображение</button>
                                                                <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                            @else
                                                                <div class="load-img">
                                                                    <input type="hidden" class="upload_image_name" name="block_content_ua[]">
                                                                </div>
                                                                <button type="button" class="btn btn-primary image_upload">Добавить изображение</button>
                                                                <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @break
                                            @endswitch
                                        </div>
                                    </div>
                                </div>

                            @endforeach
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                @endif

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
                        <button type="button" class="btn btn-block btn-danger btn-lg" onclick="document.location.href='/admin/page/';">Отмена</button>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                <!-- Box -->
            </div>
        </form>
    </div><!-- /.row -->
@endsection