@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <form action="{{route('adm_mainpage_settings_save')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
            {{ csrf_field() }}
        <div class='col-md-9'>
            <!-- Box -->
            <div class="box box-primary collapsed-box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Настройик Главной страницы</h3>
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
                                            @case(4)
                                            <div class="col-md-12">
                                                <label>Текст<span class="input-request">*</span></label>
                                                <select class="form-control select2 blog-select2" name="setting_content[]">
                                                    <option value="0" @if($setting->value == 0) selected="selected" @endif>Последняя новость</option>
                                                    @if($setting->value != 0)
                                                        @php
                                                            $post = $posts->firstWhere('id', $setting->value);
                                                        @endphp
                                                        <option value="{{ $post->id }}" selected="selected">{{ $post->id }}</option>
                                                    @endif
                                                </select>
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
                    <button type="button" class="btn btn-block btn-danger btn-lg" onclick="document.location.href='/admin/settings/main-page-settings/';">Отмена</button>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>

        </form>
    </div><!-- /.row -->
@endsection

@section('scripts')
    <script>
        $('.blog-select2').select2({
            placeholder: "Выберите статью...",
            tegs: true,
            minimumInputLength: 0,
            ajax: {
                url: '{!! route('adm_post_find') !!}',
                dataType: 'json',
                data: function (params) {
                    return {
                        name: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
    </script>
@endsection
