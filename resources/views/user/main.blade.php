@extends('layouts.main')
@section('content')
<section class="breadcrumb-box mb-4">
    <div class="container">
        <div class="row">
            {{ Breadcrumbs::render('user') }}
        </div>
    </div>
</section>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6  col-sm-8 offset-sm-2 offset-md-3 offset-lg-0">
                @include("user.include.sidebar")
            </div>
            <div class="col-lg-9">

                @include('user.include.cabinet_menu')

                <section class="user-content">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="user-page-block">
                                <div class="user-page-block-title">
                                    @lang('user.user_rating_count')
                                </div>
                                <div class="user-page-block-value">
                                    {{Auth::user()->history->sum('score')}} {{Lang::choice('user.rating_point',Auth::user()->history->sum('score'))}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 rating-scale">
                        <div class="row">
                            @include("user.include.rating_scale")
                        </div>
                    </div>
                    @auth
                    @if(!Auth::user()->hasRole('expert'))
                    <div class="user-page-block text-center">
                        <div class="user-page-title user-page-title-ref">
                            @lang('user.user_not_expert')
                        </div>
                    </div>
                    @endif
                    @endauth
                    <div class="col-12">
                        <div class="row">
                        <form method="POST" id="user_data_form" action="{{ route('user.data_save') }}" class="form-user-edit-data">
                            @csrf
                                <div class="form-block">
                                    <div class="form-group ">
                                        <input id="last_name" type="text" class="form-control" name="last_name" value="{{Auth::user()->last_name}}" placeholder="@lang("registration.last_name")">
                                    </div>
                                    <div class="form-group ">
                                        <input id="first_name" type="text" class="form-control" name="first_name" value="{{Auth::user()->first_name}}" placeholder="@lang("registration.first_name")">
                                    </div>
                                    <div class="form-group ">
                                        <input id="patronymic" type="text" class="form-control" name="patronymic" value="{{Auth::user()->patronymic}}" placeholder="@lang("registration.patronymic")">
                                    </div>
                                </div>
                                <div class="form-block">
                                    <div class="form-group ">
                                        <label for="sex">@lang("registration.sex")</label>
                                        <select name="sex" id="sex" class="form-control">
                                            <option value="1" {!!  Auth::user()->sex == 1?'selected="selected"':'' !!}>@lang("registration.man")</option>
                                            <option value="0" {!!  Auth::user()->sex == 0?'selected="selected"':'' !!}>@lang("registration.woman")</option>
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <input id="birsday" type="text" class="form-control" name="birsday" value="{{Auth::user()->birsday}}" placeholder="@lang("registration.birsday")">
                                    </div>
                                </div>

                                <div class="form-block">
                                    <div class="form-group ">
                                        <label for="country">@lang("registration.country")</label>
                                        <select name="country_id" id="country_id" class="form-control select2">
                                            @if(Auth::user()->country_model)
                                                @if(App::getLocale() === 'ru')
                                                    <option value="{{Auth::user()->country_model->id}}" selected="selected">{{Auth::user()->country_model->id}}</option>
                                                @else
                                                    <option value="{{Auth::user()->country_model->id}}" selected="selected">{{Auth::user()->country_model->translate->firstWhere('lang', App::getLocale()->name}}</option>
                                                @endif
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <label for="region_id">@lang("registration.region")</label>
                                        <select name="region_id" id="region_id" class="form-control select2">
                                            @if(Auth::user()->region_model)
                                                @if(App::getLocale() === 'ru')
                                                    <option value="{{Auth::user()->region_model->id}}" selected="selected">{{Auth::user()->region_model->id}}</option>
                                                @else
                                                    <option value="{{Auth::user()->region_model->id}}" selected="selected">{{(Auth::user()->region_model->translate->firstWhere('lang', App::getLocale()) ?? Auth::user()->region_model)->name}}</option>
                                                @endif
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <label for="new_region">@lang("registration.new_region")</label>
                                        <input id="new_region" type="text" class="form-control" name="new_region" placeholder="@lang("registration.new_region_placeholder")">
                                    </div>
                                    <div class="form-group ">
                                        <label for="city_id">@lang("registration.city")</label>
                                        <select name="city_id" id="city_id" class="form-control select2">
                                            @if(Auth::user()->city_model)
                                                @if(App::getLocale() === 'ru')
                                                    <option value="{{Auth::user()->city_model->id}}" selected="selected">{{Auth::user()->city_model->id}}</option>
                                                @else
                                                    <option value="{{Auth::user()->city_model->id}}" selected="selected">{{(Auth::user()->city_model->translate->firstWhere('lang', App::getLocale()) ?? Auth::user()->city_model)->name}}</option>
                                                @endif
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <label for="new_city">@lang("registration.new_city")</label>
                                        <input id="new_city" type="text" class="form-control" name="new_city" placeholder="@lang("registration.new_city_placeholder")">
                                    </div>
                                </div>
                                <div class="form-block">
                                    <div class="form-group ">
                                        <input id="expert-name" type="text" class="form-control" name="name" value="{{Auth::user()->name}}" placeholder="@lang("registration.name")">
                                    </div>
                                    <div class="form-group ">
                                        <input id="expert-email" type="email" class="form-control" name="email" value="{{Auth::user()->email}}" placeholder="Email">
                                    </div>
                                    <div class="form-group ">
                                        <input id="phone" type="tel" class="form-control" name="phone" value="{{Auth::user()->phone}}" placeholder="@lang("registration.phone")">
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <input id="expert-password" type="password" class="form-control" name="password" autocomplete="off" placeholder="@lang("registration.password")">
                                </div>
                                <div class="form-group mb-30">
                                    <input id="expert-password_confirmation" type="password" class="form-control" name="password_confirmation" placeholder="@lang("registration.password_confirmation")">
                                </div>
                            <div class="col-sm-6 offset-sm-3">
                                <button type="submit" class="btn-orange btn-block mb-0">
                                    @lang("user.setting_submit")
                                </button>
                            </div>
                        </form>
                        </div>
                    </div>

                </section>


                <div class="user-page-block text-center">
                    <div class="user-page-title user-page-title-ref">
                        @lang('user.user_ref')
                    </div>
                    <div class="user-page-ref">
                        {{route('user.ref',[Auth::user()->id])}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
		$(document).ready(function () {
            var lang = "{{App::getLocale()}}";
            $('#country_id').select2({
                placeholder: "Выберите страну...",
                tegs: true,
                minimumInputLength: 0,
                ajax: {
                    url: '{!! route('country.find') !!}',
                    dataType: 'json',
                    data: function (params) {
                        return {
                            name: params.term,
                            lang: lang
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
                    url: '{!! route('region.find') !!}',
                    dataType: 'json',
                    data: function (params) {
                        return {
                            name: params.term,
                            lang: lang,
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
            $('#city_id').select2({
                placeholder: "Выберите город...",
                tegs: true,
                minimumInputLength: 0,
                ajax: {
                    url: '{!! route('city.find') !!}',
                    dataType: 'json',
                    data: function (params) {
                        return {
                            name: params.term,
                            lang: lang,
                            region_id: $('#region_id').val(),
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
		});
    </script>
@endsection

