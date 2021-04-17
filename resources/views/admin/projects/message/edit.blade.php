@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <form action="{{route('adm_project_message_save',['message_id'=>$message->id])}}" method="post" enctype="multipart/form-data" class="validation-form">
            {{ csrf_field() }}

            <input type="hidden" name="project_id" value="{{ $message->project->id }}">
            <div class='col-md-9'>
                <!-- Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Основные параметры сообщения</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <div class="nav-tabs-custom">
                                <ul class="nav nav-tabs pull-right">
                                    <li><a href="#text_2-3" data-toggle="tab"><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"></a></li>
                                    <li><a href="#text_2-2" data-toggle="tab"><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"></a></li>
                                    <li class="active"><a href="#text_1-1" data-toggle="tab"><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"></a></li>
                                    <li class="pull-left header"><label>Полный текст сообщения<span class="input-request">*</span></label></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="text_1-1">
                                        <textarea class="form-control required" id="text" name="text" rows="10" cols="80">{{$message->text}}</textarea>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="text_2-2">
                                        <textarea class="form-control" id="text" name="textUA" rows="10" cols="80">{{$message->translate->firstWhere('lang', 'ua') ? $message->translate->firstWhere('lang', 'ua')->text :''}}</textarea>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" id="text_2-3">
                                        <textarea class="form-control" id="text" name="textEN" rows="10" cols="80">{{$message->translate->firstWhere('lang', 'en') ? $message->translate->firstWhere('lang', 'en')->text :''}}</textarea>
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
                        <button type="button" class="btn btn-block btn-danger btn-lg" onclick="document.location.href='/admin/project/{{$message->project->id}}/messages/';">Отмена</button>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                <!-- Box -->
                <!-- Box -->
                <!-- Box -->
            </div>
        </form>
    </div><!-- /.row -->
@endsection

