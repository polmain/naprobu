@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <form action="{{route('adm_user_rating_settings_save')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
            {{ csrf_field() }}
        <div class='col-md-9'>
            <!-- Box -->
            <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Балы за действия</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>

                    <div class="box-body">
                        @foreach($ratingActions as $ratingAction)
                            <div class="form-group">
                                <input type="hidden" name="rating_action[]" class="question_id" value="{{$ratingAction->id}}">
                                <div class="col-md-4">
                                    <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Действие<span class="input-request">*</span></label>
                                    <input type="text" name="rating_action_name[]" class="form-control question-name required" placeholder="Введите название действия..." value="{{$ratingAction->name}}">
                                </div>
                                <div class="col-md-3">
                                    <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Действие<span class="input-request">*</span></label>
                                    <input type="text" name="rating_action_name_ua[]" class="form-control required" placeholder="Введите название действия..." value="{{$ratingAction->translate->firstWhere('lang', 'ua')? $ratingAction->translate->firstWhere('lang', 'ua')->name : ''}}">
                                </div>
                                <div class="col-md-3">
                                    <label><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> Действие<span class="input-request">*</span></label>
                                    <input type="text" name="rating_action_name_en[]" class="form-control required" placeholder="Введите название действия..." value="{{$ratingAction->translate->firstWhere('lang', 'en')? $ratingAction->translate->firstWhere('lang', 'en')->name : ''}}">
                                </div>
                                <div class="col-md-2">
                                    <label> Баллы<span class="input-request">*</span></label>
                                    <input type="text" name="rating_action_points[]" class="form-control required" placeholder="Введите количество баллов за действие..." value="{{$ratingAction->points}}">
                                </div>
                            </div>
                        @endforeach
                    </div><!-- /.box-body -->
            </div><!-- /.box -->

            <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Ступени рейтинга</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>

                    <div class="box-body">
                        @foreach($ratingStatuses as $ratingStatus)
                            <div class="form-group">
                                <input type="hidden" name="rating_status[]" class="question_id" value="{{$ratingStatus->id}}">
                                <div class="col-md-4">
                                    <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Ступень<span class="input-request">*</span></label>
                                    <input type="text" name="rating_status_name[]" class="form-control question-name required" placeholder="Введите название ступени..." value="{{$ratingStatus->name}}">
                                </div>
                                <div class="col-md-3">
                                    <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Ступень<span class="input-request">*</span></label>
                                    <input type="text" name="rating_status_name_ua[]" class="form-control required" placeholder="Введите название ступени..." value="{{$ratingStatus->translate->firstWhere('lang', 'ua')? $ratingStatus->translate->firstWhere('lang', 'ua')->name : ''}}">
                                </div>
                                <div class="col-md-3">
                                    <label><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> Ступень<span class="input-request">*</span></label>
                                    <input type="text" name="rating_status_name_en[]" class="form-control required" placeholder="Введите название ступени..." value="{{$ratingStatus->translate->firstWhere('lang', 'en')? $ratingStatus->translate->firstWhere('lang', 'en')->name : ''}}">
                                </div>
                                <div class="col-md-1">
                                    <label> От<span class="input-request">*</span></label>
                                    <input type="text" name="rating_status_min[]" class="form-control required" placeholder="Введите количество баллов от..." value="{{$ratingStatus->min}}">
                                </div>
                                <div class="col-md-1">
                                    <label> До<span class="input-request">*</span></label>
                                    <input type="text" name="rating_status_max[]" class="form-control required" placeholder="Введите количество баллов до..." value="{{$ratingStatus->max}}">
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
                    <button type="button" class="btn btn-block btn-danger btn-lg" onclick="document.location.href='/admin/settings/user_rating';">Отмена</button>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>

        </form>
    </div><!-- /.row -->
@endsection
