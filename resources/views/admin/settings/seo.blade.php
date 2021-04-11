@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <form action="{{route('adm_seo_settings_save')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
            {{ csrf_field() }}
        <div class='col-md-9'>
            <!-- Box -->
            <div class="box box-primary collapsed-box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Настройик SEO</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-plus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>

                    <div class="box-body">
                        @foreach($settings as $setting)
                            <div class="question-item active" id="item_{{$setting->id}}">
                                <input type="hidden" name="setting[]" class="setting_id" value="{{$setting->id}}">
                                <div class="question-header">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <i class="fa fa-chevron-up" aria-hidden="true"></i>
                                            <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                            <span class="question-title">{{$setting->label}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="question-body">
                                    <div class="form-group row">
                                        @switch($setting->type_id)
                                            @case(1)
                                            <div class="col-md-4">
                                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Текст<span class="input-request">*</span></label>
                                                <input type="text" name="setting_content[]" class="form-control required" placeholder="Введите строку..." value="{{$setting->value}}">
                                            </div>
                                            <div class="col-md-4">
                                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Текст<span class="input-request">*</span></label>
                                                <input type="text" name="setting_content_ua[]" class="form-control required" placeholder="Введите строку..." value="{{$setting->translate->firstWhere('lang', 'ua')? $setting->translate->firstWhere('lang', 'ua')->value: ''}}">
                                            </div>
                                            <div class="col-md-4">
                                                <label><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> Текст<span class="input-request">*</span></label>
                                                <input type="text" name="setting_content_en[]" class="form-control required" placeholder="Введите строку..." value="{{$setting->translate->firstWhere('lang', 'en')? $setting->translate->firstWhere('lang', 'en')->value: ''}}">
                                            </div>
                                            @break
                                            @case(2)
                                            <div class="nav-tabs-custom">
                                                <ul class="nav nav-tabs pull-right">
                                                    <li><a href="#text_{{$block->id}}-3" data-toggle="tab"><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"></a></li>
                                                    <li><a href="#text_{{$block->id}}-2" data-toggle="tab"><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"></a></li>
                                                    <li class="active"><a href="#text_{{$block->id}}-1" data-toggle="tab"><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"></a></li>
                                                    <li class="pull-left header"><label>Текст<span class="input-request">*</span></label></li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="text_{{$block->id}}-1">
                                                        <textarea class="editor" name="setting_content[]" rows="10" cols="80">{!! $setting->value !!}</textarea>
                                                    </div>
                                                    <!-- /.tab-pane -->
                                                    <div class="tab-pane" id="text_{{$block->id}}-2">
                                                        <textarea class="editor" name="setting_content_ua[]" rows="10" cols="80">{!! $setting->translate->firstWhere('lang', 'ua')? $setting->translate->firstWhere('lang', 'ua')->value: '' !!}</textarea>
                                                    </div>
                                                    <!-- /.tab-pane -->
                                                    <div class="tab-pane" id="text_{{$block->id}}-3">
                                                        <textarea class="editor" name="setting_content_en[]" rows="10" cols="80">{!! $setting->translate->firstWhere('lang', 'en')? $setting->translate->firstWhere('lang', 'en')->value: ''!!}</textarea>
                                                    </div>
                                                    <!-- /.tab-pane -->
                                                </div>
                                                <!-- /.tab-content -->
                                            </div>
                                            @break
                                            @case(3)
                                            <div class="col-md-4">
                                                <label class="control-label "><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Картинка<span class="input-request">*</span></label>
                                                <div class="load-image-container project-img ">
                                                    @if(!empty($setting->value))
                                                        <div class="load-img active" style="background-image: url({{$setting->value}});">
                                                            <input type="hidden" class="upload_image_name" name="setting_content[]" value="{{$setting->value}}">
                                                        </div>
                                                        <button type="button" class="btn btn-primary image_upload">Изменить изображение</button>
                                                        <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                    @else
                                                        <div class="load-img">
                                                            <input type="hidden" class="upload_image_name" name="setting_content[]">
                                                        </div>
                                                        <button type="button" class="btn btn-primary image_upload">Добавить изображение</button>
                                                        <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="control-label "><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Картинка<span class="input-request">*</span></label>
                                                <div class="load-image-container project-img ">
                                                    @if(!empty($setting->translate->firstWhere('lang', 'ua')) && $setting->translate->firstWhere('lang', 'ua')->value))
                                                        <div class="load-img active" style="background-image: url({{$setting->translate->first()->value}});">
                                                            <input type="hidden" class="upload_image_name" name="setting_content_ua[]" value="{{$setting->translate->firstWhere('lang', 'ua')->value}}">
                                                        </div>
                                                        <button type="button" class="btn btn-primary image_upload">Изменить изображение</button>
                                                        <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                    @else
                                                        <div class="load-img">
                                                            <input type="hidden" class="upload_image_name" name="setting_content_ua[]">
                                                        </div>
                                                        <button type="button" class="btn btn-primary image_upload">Добавить изображение</button>
                                                        <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="control-label "><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> Картинка<span class="input-request">*</span></label>
                                                <div class="load-image-container project-img ">
                                                    @if(!empty($setting->translate->firstWhere('lang', 'en')) && $setting->translate->firstWhere('lang', 'en')->value))
                                                        <div class="load-img active" style="background-image: url({{$setting->translate->first()->value}});">
                                                            <input type="hidden" class="upload_image_name" name="setting_content_en[]" value="{{$setting->translate->firstWhere('lang', 'en')->value}}">
                                                        </div>
                                                        <button type="button" class="btn btn-primary image_upload">Изменить изображение</button>
                                                        <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                    @else
                                                        <div class="load-img">
                                                            <input type="hidden" class="upload_image_name" name="setting_content_en[]">
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
                    </div><!-- /.box-body -->
            </div><!-- /.box -->
            <div class="box box-primary collapsed-box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Настройик SEO Страниц Блога</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-plus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>

                    <div class="box-body">
                        @foreach($blog_settings as $setting)
                            <div class="question-item active" id="item_{{$setting->id}}">
                                <input type="hidden" name="setting[]" class="setting_id" value="{{$setting->id}}">
                                <div class="question-header">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <i class="fa fa-chevron-up" aria-hidden="true"></i>
                                            <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                            <span class="question-title">{{$setting->label}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="question-body">
                                    <div class="form-group row">
                                        @switch($setting->type_id)
                                            @case(1)
                                            <div class="col-md-4">
                                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Текст<span class="input-request">*</span></label>
                                                <input type="text" name="setting_content[]" class="form-control required" placeholder="Введите строку..." value="{{$setting->value}}">
                                            </div>
                                            <div class="col-md-4">
                                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Текст<span class="input-request">*</span></label>
                                                <input type="text" name="setting_content_ua[]" class="form-control required" placeholder="Введите строку..." value="{{$setting->translate->firstWhere('lang', 'ua')? $setting->translate->firstWhere('lang', 'ua')->value: ''}}">
                                            </div>
                                            <div class="col-md-4">
                                                <label><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> Текст<span class="input-request">*</span></label>
                                                <input type="text" name="setting_content_en[]" class="form-control required" placeholder="Введите строку..." value="{{$setting->translate->firstWhere('lang', 'en')? $setting->translate->firstWhere('lang', 'en')->value: ''}}">
                                            </div>
                                            @break
                                            @case(2)
                                            <div class="nav-tabs-custom">
                                                <ul class="nav nav-tabs pull-right">
                                                    <li><a href="#text_{{$block->id}}-3" data-toggle="tab"><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"></a></li>
                                                    <li><a href="#text_{{$block->id}}-2" data-toggle="tab"><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"></a></li>
                                                    <li class="active"><a href="#text_{{$block->id}}-1" data-toggle="tab"><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"></a></li>
                                                    <li class="pull-left header"><label>Текст<span class="input-request">*</span></label></li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="text_{{$block->id}}-1">
                                                        <textarea class="editor" name="setting_content[]" rows="10" cols="80">{!! $setting->value !!}</textarea>
                                                    </div>
                                                    <!-- /.tab-pane -->
                                                    <div class="tab-pane" id="text_{{$block->id}}-2">
                                                        <textarea class="editor" name="setting_content_ua[]" rows="10" cols="80">{!! $setting->translate->firstWhere('lang', 'ua')? $setting->translate->firstWhere('lang', 'ua')->value: '' !!}</textarea>
                                                    </div>
                                                    <!-- /.tab-pane -->
                                                    <div class="tab-pane" id="text_{{$block->id}}-3">
                                                        <textarea class="editor" name="setting_content_en[]" rows="10" cols="80">{!! $setting->translate->firstWhere('lang', 'en')? $setting->translate->firstWhere('lang', 'en')->value: ''!!}</textarea>
                                                    </div>
                                                    <!-- /.tab-pane -->
                                                </div>
                                                <!-- /.tab-content -->
                                            </div>
                                            @break
                                            @case(3)
                                            <div class="col-md-4">
                                                <label class="control-label "><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Картинка<span class="input-request">*</span></label>
                                                <div class="load-image-container project-img ">
                                                    @if(!empty($setting->value))
                                                        <div class="load-img active" style="background-image: url({{$setting->value}});">
                                                            <input type="hidden" class="upload_image_name" name="setting_content[]" value="{{$setting->value}}">
                                                        </div>
                                                        <button type="button" class="btn btn-primary image_upload">Изменить изображение</button>
                                                        <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                    @else
                                                        <div class="load-img">
                                                            <input type="hidden" class="upload_image_name" name="setting_content[]">
                                                        </div>
                                                        <button type="button" class="btn btn-primary image_upload">Добавить изображение</button>
                                                        <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="control-label "><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Картинка<span class="input-request">*</span></label>
                                                <div class="load-image-container project-img ">
                                                    @if(!empty($setting->translate->firstWhere('lang', 'ua')) && $setting->translate->firstWhere('lang', 'ua')->value))
                                                    <div class="load-img active" style="background-image: url({{$setting->translate->first()->value}});">
                                                        <input type="hidden" class="upload_image_name" name="setting_content_ua[]" value="{{$setting->translate->firstWhere('lang', 'ua')->value}}">
                                                    </div>
                                                    <button type="button" class="btn btn-primary image_upload">Изменить изображение</button>
                                                    <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                    @else
                                                        <div class="load-img">
                                                            <input type="hidden" class="upload_image_name" name="setting_content_ua[]">
                                                        </div>
                                                        <button type="button" class="btn btn-primary image_upload">Добавить изображение</button>
                                                        <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="control-label "><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> Картинка<span class="input-request">*</span></label>
                                                <div class="load-image-container project-img ">
                                                    @if(!empty($setting->translate->firstWhere('lang', 'en')) && $setting->translate->firstWhere('lang', 'en')->value))
                                                    <div class="load-img active" style="background-image: url({{$setting->translate->first()->value}});">
                                                        <input type="hidden" class="upload_image_name" name="setting_content_en[]" value="{{$setting->translate->firstWhere('lang', 'en')->value}}">
                                                    </div>
                                                    <button type="button" class="btn btn-primary image_upload">Изменить изображение</button>
                                                    <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                    @else
                                                        <div class="load-img">
                                                            <input type="hidden" class="upload_image_name" name="setting_content_en[]">
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
                    </div><!-- /.box-body -->
            </div><!-- /.box -->
            <div class="box box-primary collapsed-box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Настройик SEO Отзывов</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-plus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>

                    <div class="box-body">
                        @foreach($revew_settings as $setting)
                            <div class="question-item active" id="item_{{$setting->id}}">
                                <input type="hidden" name="setting[]" class="setting_id" value="{{$setting->id}}">
                                <div class="question-header">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <i class="fa fa-chevron-up" aria-hidden="true"></i>
                                            <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                            <span class="question-title">{{$setting->label}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="question-body">
                                    <div class="form-group row">
                                        @switch($setting->type_id)
                                            @case(1)
                                            <div class="col-md-4">
                                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Текст<span class="input-request">*</span></label>
                                                <input type="text" name="setting_content[]" class="form-control required" placeholder="Введите строку..." value="{{$setting->value}}">
                                            </div>
                                            <div class="col-md-4">
                                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Текст<span class="input-request">*</span></label>
                                                <input type="text" name="setting_content_ua[]" class="form-control required" placeholder="Введите строку..." value="{{$setting->translate->firstWhere('lang', 'ua')? $setting->translate->firstWhere('lang', 'ua')->value: ''}}">
                                            </div>
                                            <div class="col-md-4">
                                                <label><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> Текст<span class="input-request">*</span></label>
                                                <input type="text" name="setting_content_en[]" class="form-control required" placeholder="Введите строку..." value="{{$setting->translate->firstWhere('lang', 'en')? $setting->translate->firstWhere('lang', 'en')->value: ''}}">
                                            </div>
                                            @break
                                            @case(2)
                                            <div class="nav-tabs-custom">
                                                <ul class="nav nav-tabs pull-right">
                                                    <li><a href="#text_{{$block->id}}-3" data-toggle="tab"><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"></a></li>
                                                    <li><a href="#text_{{$block->id}}-2" data-toggle="tab"><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"></a></li>
                                                    <li class="active"><a href="#text_{{$block->id}}-1" data-toggle="tab"><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"></a></li>
                                                    <li class="pull-left header"><label>Текст<span class="input-request">*</span></label></li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="text_{{$block->id}}-1">
                                                        <textarea class="editor" name="setting_content[]" rows="10" cols="80">{!! $setting->value !!}</textarea>
                                                    </div>
                                                    <!-- /.tab-pane -->
                                                    <div class="tab-pane" id="text_{{$block->id}}-2">
                                                        <textarea class="editor" name="setting_content_ua[]" rows="10" cols="80">{!! $setting->translate->firstWhere('lang', 'ua')? $setting->translate->firstWhere('lang', 'ua')->value: '' !!}</textarea>
                                                    </div>
                                                    <!-- /.tab-pane -->
                                                    <div class="tab-pane" id="text_{{$block->id}}-3">
                                                        <textarea class="editor" name="setting_content_en[]" rows="10" cols="80">{!! $setting->translate->firstWhere('lang', 'en')? $setting->translate->firstWhere('lang', 'en')->value: ''!!}</textarea>
                                                    </div>
                                                    <!-- /.tab-pane -->
                                                </div>
                                                <!-- /.tab-content -->
                                            </div>
                                            @break
                                            @case(3)
                                            <div class="col-md-4">
                                                <label class="control-label "><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Картинка<span class="input-request">*</span></label>
                                                <div class="load-image-container project-img ">
                                                    @if(!empty($setting->value))
                                                        <div class="load-img active" style="background-image: url({{$setting->value}});">
                                                            <input type="hidden" class="upload_image_name" name="setting_content[]" value="{{$setting->value}}">
                                                        </div>
                                                        <button type="button" class="btn btn-primary image_upload">Изменить изображение</button>
                                                        <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                    @else
                                                        <div class="load-img">
                                                            <input type="hidden" class="upload_image_name" name="setting_content[]">
                                                        </div>
                                                        <button type="button" class="btn btn-primary image_upload">Добавить изображение</button>
                                                        <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="control-label "><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Картинка<span class="input-request">*</span></label>
                                                <div class="load-image-container project-img ">
                                                    @if(!empty($setting->translate->firstWhere('lang', 'ua')) && $setting->translate->firstWhere('lang', 'ua')->value))
                                                    <div class="load-img active" style="background-image: url({{$setting->translate->first()->value}});">
                                                        <input type="hidden" class="upload_image_name" name="setting_content_ua[]" value="{{$setting->translate->firstWhere('lang', 'ua')->value}}">
                                                    </div>
                                                    <button type="button" class="btn btn-primary image_upload">Изменить изображение</button>
                                                    <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                    @else
                                                        <div class="load-img">
                                                            <input type="hidden" class="upload_image_name" name="setting_content_ua[]">
                                                        </div>
                                                        <button type="button" class="btn btn-primary image_upload">Добавить изображение</button>
                                                        <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="control-label "><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> Картинка<span class="input-request">*</span></label>
                                                <div class="load-image-container project-img ">
                                                    @if(!empty($setting->translate->firstWhere('lang', 'en')) && $setting->translate->firstWhere('lang', 'en')->value))
                                                    <div class="load-img active" style="background-image: url({{$setting->translate->first()->value}});">
                                                        <input type="hidden" class="upload_image_name" name="setting_content_en[]" value="{{$setting->translate->firstWhere('lang', 'en')->value}}">
                                                    </div>
                                                    <button type="button" class="btn btn-primary image_upload">Изменить изображение</button>
                                                    <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                    @else
                                                        <div class="load-img">
                                                            <input type="hidden" class="upload_image_name" name="setting_content_en[]">
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
                    </div><!-- /.box-body -->
            </div><!-- /.box -->
            <div class="box box-primary collapsed-box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Настройик SEO Личного кабинета</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-plus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>

                    <div class="box-body">
                        @foreach($user_settings as $setting)
                            <div class="question-item active" id="item_{{$setting->id}}">
                                <input type="hidden" name="setting[]" class="setting_id" value="{{$setting->id}}">
                                <div class="question-header">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <i class="fa fa-chevron-up" aria-hidden="true"></i>
                                            <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                            <span class="question-title">{{$setting->label}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="question-body">
                                    <div class="form-group row">
                                        @switch($setting->type_id)
                                            @case(1)
                                            <div class="col-md-4">
                                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Текст<span class="input-request">*</span></label>
                                                <input type="text" name="setting_content[]" class="form-control required" placeholder="Введите строку..." value="{{$setting->value}}">
                                            </div>
                                            <div class="col-md-4">
                                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Текст<span class="input-request">*</span></label>
                                                <input type="text" name="setting_content_ua[]" class="form-control required" placeholder="Введите строку..." value="{{$setting->translate->firstWhere('lang', 'ua')? $setting->translate->firstWhere('lang', 'ua')->value: ''}}">
                                            </div>
                                            <div class="col-md-4">
                                                <label><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> Текст<span class="input-request">*</span></label>
                                                <input type="text" name="setting_content_en[]" class="form-control required" placeholder="Введите строку..." value="{{$setting->translate->firstWhere('lang', 'en')? $setting->translate->firstWhere('lang', 'en')->value: ''}}">
                                            </div>
                                            @break
                                            @case(2)
                                            <div class="nav-tabs-custom">
                                                <ul class="nav nav-tabs pull-right">
                                                    <li><a href="#text_{{$block->id}}-3" data-toggle="tab"><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"></a></li>
                                                    <li><a href="#text_{{$block->id}}-2" data-toggle="tab"><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"></a></li>
                                                    <li class="active"><a href="#text_{{$block->id}}-1" data-toggle="tab"><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"></a></li>
                                                    <li class="pull-left header"><label>Текст<span class="input-request">*</span></label></li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="text_{{$block->id}}-1">
                                                        <textarea class="editor" name="setting_content[]" rows="10" cols="80">{!! $setting->value !!}</textarea>
                                                    </div>
                                                    <!-- /.tab-pane -->
                                                    <div class="tab-pane" id="text_{{$block->id}}-2">
                                                        <textarea class="editor" name="setting_content_ua[]" rows="10" cols="80">{!! $setting->translate->firstWhere('lang', 'ua')? $setting->translate->firstWhere('lang', 'ua')->value: '' !!}</textarea>
                                                    </div>
                                                    <!-- /.tab-pane -->
                                                    <div class="tab-pane" id="text_{{$block->id}}-3">
                                                        <textarea class="editor" name="setting_content_en[]" rows="10" cols="80">{!! $setting->translate->firstWhere('lang', 'en')? $setting->translate->firstWhere('lang', 'en')->value: ''!!}</textarea>
                                                    </div>
                                                    <!-- /.tab-pane -->
                                                </div>
                                                <!-- /.tab-content -->
                                            </div>
                                            @break
                                            @case(3)
                                            <div class="col-md-4">
                                                <label class="control-label "><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Картинка<span class="input-request">*</span></label>
                                                <div class="load-image-container project-img ">
                                                    @if(!empty($setting->value))
                                                        <div class="load-img active" style="background-image: url({{$setting->value}});">
                                                            <input type="hidden" class="upload_image_name" name="setting_content[]" value="{{$setting->value}}">
                                                        </div>
                                                        <button type="button" class="btn btn-primary image_upload">Изменить изображение</button>
                                                        <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                    @else
                                                        <div class="load-img">
                                                            <input type="hidden" class="upload_image_name" name="setting_content[]">
                                                        </div>
                                                        <button type="button" class="btn btn-primary image_upload">Добавить изображение</button>
                                                        <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="control-label "><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Картинка<span class="input-request">*</span></label>
                                                <div class="load-image-container project-img ">
                                                    @if(!empty($setting->translate->firstWhere('lang', 'ua')) && $setting->translate->firstWhere('lang', 'ua')->value))
                                                    <div class="load-img active" style="background-image: url({{$setting->translate->first()->value}});">
                                                        <input type="hidden" class="upload_image_name" name="setting_content_ua[]" value="{{$setting->translate->firstWhere('lang', 'ua')->value}}">
                                                    </div>
                                                    <button type="button" class="btn btn-primary image_upload">Изменить изображение</button>
                                                    <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                    @else
                                                        <div class="load-img">
                                                            <input type="hidden" class="upload_image_name" name="setting_content_ua[]">
                                                        </div>
                                                        <button type="button" class="btn btn-primary image_upload">Добавить изображение</button>
                                                        <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="control-label "><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> Картинка<span class="input-request">*</span></label>
                                                <div class="load-image-container project-img ">
                                                    @if(!empty($setting->translate->firstWhere('lang', 'en')) && $setting->translate->firstWhere('lang', 'en')->value))
                                                    <div class="load-img active" style="background-image: url({{$setting->translate->first()->value}});">
                                                        <input type="hidden" class="upload_image_name" name="setting_content_en[]" value="{{$setting->translate->firstWhere('lang', 'en')->value}}">
                                                    </div>
                                                    <button type="button" class="btn btn-primary image_upload">Изменить изображение</button>
                                                    <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                    @else
                                                        <div class="load-img">
                                                            <input type="hidden" class="upload_image_name" name="setting_content_en[]">
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
                    </div><!-- /.box-body -->
            </div><!-- /.box -->
            <div class="box box-primary collapsed-box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Настройик SEO Профиля пользователей</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-plus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>

                    <div class="box-body">
                        @foreach($profile_settings as $setting)
                            <div class="question-item active" id="item_{{$setting->id}}">
                                <input type="hidden" name="setting[]" class="setting_id" value="{{$setting->id}}">
                                <div class="question-header">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <i class="fa fa-chevron-up" aria-hidden="true"></i>
                                            <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                            <span class="question-title">{{$setting->label}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="question-body">
                                    <div class="form-group row">
                                        @switch($setting->type_id)
                                            @case(1)
                                            <div class="col-md-4">
                                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Текст<span class="input-request">*</span></label>
                                                <input type="text" name="setting_content[]" class="form-control required" placeholder="Введите строку..." value="{{$setting->value}}">
                                            </div>
                                            <div class="col-md-4">
                                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Текст<span class="input-request">*</span></label>
                                                <input type="text" name="setting_content_ua[]" class="form-control required" placeholder="Введите строку..." value="{{$setting->translate->firstWhere('lang', 'ua')? $setting->translate->firstWhere('lang', 'ua')->value: ''}}">
                                            </div>
                                            <div class="col-md-4">
                                                <label><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> Текст<span class="input-request">*</span></label>
                                                <input type="text" name="setting_content_en[]" class="form-control required" placeholder="Введите строку..." value="{{$setting->translate->firstWhere('lang', 'en')? $setting->translate->firstWhere('lang', 'en')->value: ''}}">
                                            </div>
                                            @break
                                            @case(2)
                                            <div class="nav-tabs-custom">
                                                <ul class="nav nav-tabs pull-right">
                                                    <li><a href="#text_{{$block->id}}-3" data-toggle="tab"><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"></a></li>
                                                    <li><a href="#text_{{$block->id}}-2" data-toggle="tab"><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"></a></li>
                                                    <li class="active"><a href="#text_{{$block->id}}-1" data-toggle="tab"><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"></a></li>
                                                    <li class="pull-left header"><label>Текст<span class="input-request">*</span></label></li>
                                                </ul>
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="text_{{$block->id}}-1">
                                                        <textarea class="editor" name="setting_content[]" rows="10" cols="80">{!! $setting->value !!}</textarea>
                                                    </div>
                                                    <!-- /.tab-pane -->
                                                    <div class="tab-pane" id="text_{{$block->id}}-2">
                                                        <textarea class="editor" name="setting_content_ua[]" rows="10" cols="80">{!! $setting->translate->firstWhere('lang', 'ua')? $setting->translate->firstWhere('lang', 'ua')->value: '' !!}</textarea>
                                                    </div>
                                                    <!-- /.tab-pane -->
                                                    <div class="tab-pane" id="text_{{$block->id}}-3">
                                                        <textarea class="editor" name="setting_content_en[]" rows="10" cols="80">{!! $setting->translate->firstWhere('lang', 'en')? $setting->translate->firstWhere('lang', 'en')->value: ''!!}</textarea>
                                                    </div>
                                                    <!-- /.tab-pane -->
                                                </div>
                                                <!-- /.tab-content -->
                                            </div>
                                            @break
                                            @case(3)
                                            <div class="col-md-4">
                                                <label class="control-label "><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Картинка<span class="input-request">*</span></label>
                                                <div class="load-image-container project-img ">
                                                    @if(!empty($setting->value))
                                                        <div class="load-img active" style="background-image: url({{$setting->value}});">
                                                            <input type="hidden" class="upload_image_name" name="setting_content[]" value="{{$setting->value}}">
                                                        </div>
                                                        <button type="button" class="btn btn-primary image_upload">Изменить изображение</button>
                                                        <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                    @else
                                                        <div class="load-img">
                                                            <input type="hidden" class="upload_image_name" name="setting_content[]">
                                                        </div>
                                                        <button type="button" class="btn btn-primary image_upload">Добавить изображение</button>
                                                        <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="control-label "><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Картинка<span class="input-request">*</span></label>
                                                <div class="load-image-container project-img ">
                                                    @if(!empty($setting->translate->firstWhere('lang', 'ua')) && $setting->translate->firstWhere('lang', 'ua')->value))
                                                    <div class="load-img active" style="background-image: url({{$setting->translate->first()->value}});">
                                                        <input type="hidden" class="upload_image_name" name="setting_content_ua[]" value="{{$setting->translate->firstWhere('lang', 'ua')->value}}">
                                                    </div>
                                                    <button type="button" class="btn btn-primary image_upload">Изменить изображение</button>
                                                    <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                    @else
                                                        <div class="load-img">
                                                            <input type="hidden" class="upload_image_name" name="setting_content_ua[]">
                                                        </div>
                                                        <button type="button" class="btn btn-primary image_upload">Добавить изображение</button>
                                                        <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="control-label "><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> Картинка<span class="input-request">*</span></label>
                                                <div class="load-image-container project-img ">
                                                    @if(!empty($setting->translate->firstWhere('lang', 'en')) && $setting->translate->firstWhere('lang', 'en')->value))
                                                    <div class="load-img active" style="background-image: url({{$setting->translate->first()->value}});">
                                                        <input type="hidden" class="upload_image_name" name="setting_content_en[]" value="{{$setting->translate->firstWhere('lang', 'en')->value}}">
                                                    </div>
                                                    <button type="button" class="btn btn-primary image_upload">Изменить изображение</button>
                                                    <button type="button" class="btn btn-danger image_delete">Удалить изображение</button>
                                                    @else
                                                        <div class="load-img">
                                                            <input type="hidden" class="upload_image_name" name="setting_content_en[]">
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
                    </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->


        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Действия</h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <button type="submit" name="submit" value="save" class="btn btn-block btn-primary btn-lg">Сохранить</button>
                    <button type="button" class="btn btn-block btn-danger btn-lg" onclick="document.location.href='/admin/settings/seo/';">Отмена</button>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>

        </form>
    </div><!-- /.row -->
@endsection
