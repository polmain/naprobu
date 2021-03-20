@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <div class="col-md-3">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Информация о пользователе</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                            <i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label>Имя</label>
                        <p>{{$present->user->name}}</p>
                    </div>
                    <div class="form-group">
                        <label>E-mail</label>
                        <p><a href="mailto:{{$present->user->email}}">{{$present->user->email}}</a></p>
                    </div>
                    <div class="form-group">
                        <label>Ранг</label>
                        <p>{{$present->rang->name}}</p>
                    </div>
                    <div class="form-group">
                        <label>Отправлен</label>
                        <p>{{$present->isSent?"Да":"Нет"}}</p>
                    </div>
                </div>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->
        </div>
        <div class="col-md-9">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Отправить сообщение</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                            <i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <form action="{{route('adm_present_send',[$present->id])}}" method="post" enctype="multipart/form-data" class="validation-form">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label>Тема письма<span class="input-request">*</span></label>
                            <input type="text" id="subject" name="subject" class="form-control required" placeholder="Введите тему письма...">
                        </div>
                        <div class="form-group">
                            <textarea class="editor required" id="text" name="text" rows="10" cols="80">{!! $present->email_text !!}</textarea>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Отправить</button>
                        </div>
                    </div>
                </form>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->
        </div>

    </div><!-- /.row -->
@endsection
