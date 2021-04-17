@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <form action="{{route('adm_questionnaire_create')}}" method="post" enctype="multipart/form-data" class="validation-form">
            {{ csrf_field() }}
            <div class='col-md-9'>
                <!-- Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Основные параметры анкеты</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Название анкеты<span class="input-request">*</span></label>
                                <input type="text" id="name" name="name" class="form-control required" placeholder="Введите название анкеты...">
                            </div>
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Название анкеты</label>
                                <input type="text" id="nameUA" name="nameUA" class="form-control" placeholder="Введите название анкеты...">
                            </div>
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> Название анкеты</label>
                                <input type="text" id="nameEN" name="nameEN" class="form-control" placeholder="Введите название анкеты...">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Тип анкеты<span class="input-request">*</span></label>
                            <select class="form-control required" name="questionnaire_type" id="questionnaire_type">
                                <option value="">Выберите тип анкеты</option>
                                @foreach($questionnaireTypes as $questionnaireType)
                                    <option value="{{$questionnaireType->id}}">{{$questionnaireType->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group select-project" style="display: none;">
                            <label>Проект<span class="input-request">*</span></label>
                            <select class="form-control select2" name="project_id" id="project_id">
                                <option value="">Выберите проект</option>
                                @foreach($projects->reverse() as $project)
                                    <option value="{{$project->id}}">{{$project->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs pull-right">
                                    <li><a href="#tab_3-3" data-toggle="tab"><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"></a></li>
                                    <li><a href="#tab_2-2" data-toggle="tab"><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"></a></li>
                                    <li class="active"><a href="#tab_1-1" data-toggle="tab"><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"></a></li>
                                    <li class="pull-left header"><label>Описание анкеты</label></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_1-1">
                                        <textarea class="editor" id="text" name="text" rows="10" cols="80"></textarea>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_2-2">
                                        <textarea class="editor" id="textUA" name="textUA" rows="10" cols="80"></textarea>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="tab_3-3">
                                        <textarea class="editor" id="textEN" name="textEN" rows="10" cols="80"></textarea>
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
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
                        <button type="button" class="btn btn-block btn-danger btn-lg" onclick="document.location.href='/admin/questionnaire/';">Отмена</button>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </form>
    </div><!-- /.row -->
@endsection
