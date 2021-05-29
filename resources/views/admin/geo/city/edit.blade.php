@extends('admin.layouts.layout')

@section('content')
    <div class='row'>
        <form action="{{route('admin.city.save',['city_id'=>$city->id])}}" method="post" enctype="multipart/form-data" class="validation-form">
            {{ csrf_field() }}
            <div class='col-md-9'>
                <!-- Box -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Основные параметры Города</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/russia.png')}}" alt="Флаг России"> Название страны<span class="name-input-required input-request">*</span></label>
                                <input type="text" id="name-ru" name="name" class="form-control name-required required" placeholder="Введите название города..." value="{{$city->name}}">
                            </div>
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/ukraine.png')}}" alt="Флаг Украины"> Название страны<span class="name-input-required input-request">*</span></label>
                                <input type="text" id="name-ua" name="nameUA" class="form-control name-required required" placeholder="Введите название города..." value="{{$city->translate->firstWhere('lang', 'ua')? $city->translate->firstWhere('lang', 'ua')->name : ''}}">
                            </div>
                            <div class="col-md-4">
                                <label><img src="{{asset('/public/images/united-kingdom.png')}}" alt="Флаг Великой бриатнии"> Название страны<span class="name-input-required input-request">*</span></label>
                                <input type="text" id="name-en" name="nameEN" class="form-control name-required required" placeholder="Введите название города..." value="{{$city->translate->firstWhere('lang', 'en')? $city->translate->firstWhere('lang', 'en')->name : ''}}">
                            </div>
                        </div>
                        @if(!$city->is_verify)
                            <label>Поменять этот город на этот город</label>
                            <select class="form-control select2" name="new_city_id" id="new_city_id">
                            </select>
                        @endif
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label>Страна<span class="input-request">*</span></label>
                                <select class="form-control select2 required" name="country_id" id="country_id">
                                    <option value="{{$city->country->id}}" selected="selected">{{$city->country->name}}</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label>Область/Штат</label>
                                <select class="form-control select2" name="region_id" id="region_id">
                                    @if($city->region)
                                    <option value="{{$city->region->id}}" selected="selected">{{$city->region->name}}</option>
                                    @endif
                                </select>
                                @if($city->region && !$city->region->is_verify)
                                    <p class="text-red">Внимание!!! Обасть не верефицированна!</p>
                                @endif
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
                        <button type="submit" name="submit" value="save" class="btn btn-block btn-success btn-lg">Сохранить</button>
                        <button type="submit" name="submit" value="save-close" class="btn btn-block btn-primary btn-lg">Сохранить и закрыть</button>
                        <button type="submit" name="submit" value="save-new" class="btn btn-block btn-primary btn-lg">Сохранить и создать</button>
                        <button type="button" class="btn btn-block btn-danger btn-lg" onclick="document.location.href='/admin/cities/';">Отмена</button>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                <!-- Box -->

            </div>
        </form>
    </div><!-- /.row -->
@endsection
@section('scripts')
    <script>
        $('#country_id').select2({
            placeholder: "Выберите страну...",
            tegs: true,
            minimumInputLength: 0,
            ajax: {
                url: '{!! route('admin.country.find') !!}',
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
        $('#region_id').select2({
            placeholder: "Выберите область...",
            tegs: true,
            minimumInputLength: 0,
            ajax: {
                url: '{!! route('admin.region.find') !!}',
                dataType: 'json',
                data: function (params) {
                    return {
                        name: params.term,
                        country_id: $('#country_id').val()
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
        @if(!$city->is_verify)
        $('#new_city_id').select2({
            placeholder: "Выберите другой город...",
            tegs: true,
            minimumInputLength: 0,
            ajax: {
                url: '{!! route('admin.cite.find') !!}',
                dataType: 'json',
                data: function (params) {
                    return {
                        name: params.term,
                        country_id: $('#country_id').val()
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
        $('#new_city_id').change(function (e){
            $('.name-required').removeClass('required');
            $('.name-input-required').remove();
        });
        @endif
    </script>
@endsection
