@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <form action="{{route('adm_page_main_home_save')}}" method="post" enctype="multipart/form-data" class="validation-form">
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
                        <button type="submit" name="submit" value="save-close" class="btn btn-block btn-primary btn-lg">Сохранить и закрыть</button>
                        <button type="submit" name="submit" value="save-new" class="btn btn-block btn-primary btn-lg">Сохранить и добавить новый</button>
                        <button type="submit" name="submit" value="save-hide" class="btn btn-block btn-primary btn-lg">Сохранить в черновик</button>
                        <button type="button" class="btn btn-block btn-danger btn-lg" onclick="document.location.href='/admin/page/';">Отмена</button>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </form>
    </div><!-- /.row -->
@endsection