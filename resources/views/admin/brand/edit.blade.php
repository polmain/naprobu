@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <form action="{{route('adm_brand_edit',['brand_id'=>$brand->id])}}" method="post" enctype="multipart/form-data" class="validation-form">
            {{ csrf_field() }}
            <div class='col-md-9'>
                <!-- Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Основные параметры Брэнда</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Название Брэнда<span class="input-request">*</span></label>
                                <input type="text" id="name-ru" name="name" class="form-control required" placeholder="Введите название Брэнда..." value="{{$brand->name}}">
                            </div>
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Название Брэнда</label>
                                <input type="text" id="name-ua" name="name_ua" class="form-control" placeholder="Введите название Брэнда..." value="{{$brand->translate->firstWhere('lang', 'ua')? $brand->translate->firstWhere('lang', 'ua')->name : ''}}">
                            </div>
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> Название Брэнда</label>
                                <input type="text" id="name-en" name="name_en" class="form-control" placeholder="Введите название Брэнда..." value="{{$brand->translate->firstWhere('lang', 'en')? $brand->translate->firstWhere('lang', 'en')->name : ''}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Alt Брэнда<span class="input-request">*</span></label>
                                <input type="text" id="name-ru" name="alt" class="form-control project-name" placeholder="Введите alt Брэнда..." value="{{$brand->alt}}">
                            </div>
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Alt Брэнда</label>
                                <input type="text" id="name-ua" name="alt_ua" class="form-control project-name" placeholder="Введите alt Брэнда..." value="{{$brand->translate->firstWhere('lang', 'ua')? $brand->translate->firstWhere('lang', 'ua')->alt : ''}}">
                            </div>
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> Alt Брэнда</label>
                                <input type="text" id="name-en" name="alt_en" class="form-control project-name" placeholder="Введите alt Брэнда..." value="{{$brand->translate->firstWhere('lang', 'en')? $brand->translate->firstWhere('lang', 'en')->alt : ''}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label ">Изображение<span class="input-request">*</span></label>
                                    <div class="load-image-container project-img ">
                                        @if(isset($brand->logo))
                                            <div class="load-img active" style="background-image: url({{$brand->logo}});">
                                                <input type="hidden" class="upload_image_name" name="image" value="{{$brand->logo}}">
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
                        <div class="form-group">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs pull-right">
                                    <li><a href="#text_3-3" data-toggle="tab"><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"></a></li>
                                    <li><a href="#text_2-2" data-toggle="tab"><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"></a></li>
                                    <li class="active"><a href="#text_1-1" data-toggle="tab"><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"></a></li>
                                    <li class="pull-left header"><label>Отзыв</label></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="text_1-1">
                                        <textarea class="editor" name="review" rows="10" cols="80">{!! $brand->review !!}</textarea>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="text_2-2">
                                        <textarea class="editor" name="review_ua" rows="10" cols="80">{!! $brand->translate->firstWhere('lang', 'ua')? $brand->translate->firstWhere('lang', 'ua')->review : '' !!}</textarea>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="text_3-3">
                                        <textarea class="editor" name="review_en" rows="10" cols="80">{!! $brand->translate->firstWhere('lang', 'en')? $brand->translate->firstWhere('lang', 'en')->review : '' !!}</textarea>
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
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
                        <button type="button" class="btn btn-block btn-danger btn-lg" onclick="document.location.href='/admin/brand/';">Отмена</button>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                <!-- Box -->

            </div>
        </form>
    </div><!-- /.row -->
@endsection
