@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <form action="{{route('adm_menu_save',[$menu->id])}}" method="post" enctype="multipart/form-data" class="validation-form">
            {{ csrf_field() }}
            <div class='col-md-9'>

                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Пункты меню</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="questions-list list-child">
                            @foreach($menu->items->where('lang','ru') as $item)

                            <div class="question-item active" id="item_{{$item->id}}">
                                <input type="hidden" name="item[{{$item->id}}]" class="item_id" value="{{$item->id}}">
                                <div class="question-header">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="drag-zone">
                                                <i class="fa fa-arrows-v" aria-hidden="true"></i>
                                            </div>
                                            <i class="fa fa-chevron-up" aria-hidden="true"></i>
                                            <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                            <span class="question-title">{{$item->name}}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="question-body">
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Подпись<span class="input-request">*</span></label>
                                            <input type="text" name="item_label[{{$item->id}}]" class="form-control required" placeholder="Введите подпись..." value="{{$item->label}}">
                                        </div>
                                        <div class="col-md-6">
                                            <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Подпись<span class="input-request">*</span></label>
                                            <input type="text" name="item_label_ua[{{$item->id}}]" class="form-control required" placeholder="Введите подпись..." value="{{$item->translates->first()->label}}">
                                        </div>
                                    </div>
                                    @if($menu->id == 3)
                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Ссылка<span class="input-request">*</span></label>
                                                <input type="text" name="item_link[{{$item->id}}]" class="form-control required" placeholder="Введите ссылку..." value="{{$item->link}}">
                                            </div>
                                            <div class="col-md-6">
                                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Ссылка<span class="input-request">*</span></label>
                                                <input type="text" name="item_link_ua[{{$item->id}}]" class="form-control required" placeholder="Введите ссылку..." value="{{$item->translates->first()->link}}">
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            @endforeach
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
                        <button type="submit" name="submit" value="save" class="btn btn-block btn-success btn-lg">Сохранить</button>
                        <button type="submit" name="submit" value="save-close" class="btn btn-block btn-primary btn-lg">Сохранить и закрыть</button>
                        <button type="button" class="btn btn-block btn-danger btn-lg" onclick="document.location.href='/admin/menu/';">Отмена</button>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </form>
    </div><!-- /.row -->

@endsection