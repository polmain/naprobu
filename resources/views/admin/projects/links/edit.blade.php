@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <form action="{{route('adm_project_links_save',['link_id'=>$link->id])}}" method="post" enctype="multipart/form-data" class="validation-form">

            {{ csrf_field() }}

            <input type="hidden" name="project_id" value="{{ $link->project->id }}">
            <div class='col-md-9'>
                <!-- Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Основные параметры ссылки</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <div class="nav-tabs-custom">
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Текст ссылки<span class="input-request">*</span></label>
                                        <input type="text" id="text-ru" name="text" class="form-control required" placeholder="Введите текст ссылки..." value="{{$link->text}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Текст ссылки<span class="input-request">*</span></label>
                                        <input type="text" id="text-ua" name="textUA" class="form-control required" placeholder="Введите текст ссылки..." value="{{(!empty($link->translate))?$link->translate->text:''}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Ссылка<span class="input-request">*</span></label>
                                        <input type="text" id="link-ru" name="link" class="form-control required" placeholder="Введите ссылку..." value="{{$link->link}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Ссылка<span class="input-request">*</span></label>
                                        <input type="text" id="link-ua" name="linkUA" class="form-control required" placeholder="Введите ссылку..." value="{{(!empty($link->link))?$link->translate->link:''}}">
                                    </div>
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
                        <button type="button" class="btn btn-block btn-danger btn-lg" onclick="document.location.href='/admin/project/{{$link->project->id}}/links/';">Отмена</button>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                <!-- Box -->
                <!-- Box -->
                <!-- Box -->
            </div>
        </form>
    </div><!-- /.row -->
@endsection

