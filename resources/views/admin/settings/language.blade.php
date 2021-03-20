@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <form action="{{route('adm_language_settings_save')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
            {{ csrf_field() }}
        <div class='col-md-9'>
            <!-- Box -->
            <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Строки</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>

                    <div class="box-body">
                        @foreach($strings as $string)
                            <div class="form-group">
                                <input type="hidden" name="strings[]" class="question_id" value="{{$string->id}}">
                                <div class="col-md-4">
                                    {{$string->name}}
                                </div>
                                <div class="col-md-4">
                                    <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"></label>
                                    <input type="text" name="string_ru[]" class="form-control required" placeholder="Перевод на русский" value="{{$string->text}}">
                                </div>
                                <div class="col-md-4">
                                    <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"></label>
                                    <input type="text" name="string_ua[]" class="form-control required" placeholder="Перевод на украинский" value="{{$string->translate->text}}">
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
                    <button type="button" class="btn btn-block btn-danger btn-lg" onclick="document.location.href='/admin/settings/language/';">Отмена</button>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>

        </form>
    </div><!-- /.row -->
@endsection