@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Оповещение отправленно</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                            <i class="fa fa-minus"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <p>Процесс отправки оповещения запущен. Все пользователи получат оповещения в течении определенного времени.</p>
                    <p>Время отправки оповещений зависит от количества пользователей которые должны получить сообщение.</p>
                </div>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->
        </div>

    </div><!-- /.row -->
@endsection
