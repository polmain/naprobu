@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Информация о сообщении</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                            <i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label>Имя</label>
                        <p>{{$feedback->name}}</p>
                    </div>
                    <div class="form-group">
                        <label>E-mail</label>
                        <p><a href="mailto:{{$feedback->email}}">{{$feedback->email}}</a></p>
                    </div>
                    <div class="form-group">
                        <label>Тема</label>
                        <p>{{$feedback->subject}}</p>
                    </div>
                    <div class="form-group">
                        <label>Сообщение</label>
                        <p>{{$feedback->text}}</p>
                    </div>
                </div>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->
        </div>

    </div><!-- /.row -->
@endsection
