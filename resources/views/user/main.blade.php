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
                                    {{Auth::user()->current_rating}} {{Lang::choice('user.rating_point',Auth::user()->current_rating)}}
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
                                        <select name="country" id="country" class="form-control select2">
                                            @php

                                                $hasCountry = false;
                                            @endphp
                                            @if(App::getLocale() === 'en')
                                                @foreach($countryCollection as $country)
                                                    @php
                                                        if($country->getName() == Auth::user()->country){
                                                            $hasCountry = true;
                                                        }
                                                    @endphp
                                                    <option value="{{$country->getName()}}">{{$country->getName()}}</option>
                                                @endforeach
                                            @else
                                                @foreach($countries as $country)
                                                    @php
                                                        if($country->name_ru == Auth::user()->country || $country->name_ua == Auth::user()->country){
                                                            $hasCountry = true;
                                                        }
                                                    @endphp
                                                    <option value="{{(App::getLocale()=='ru')?$country->name_ru:$country->name_ua}}" data-iso="{{$country->iso}}" @if($country->name_ru == Auth::user()->country || $country->name_ua == Auth::user()->country) selected="selected" @endif>{{(App::getLocale()=='ru')?$country->name_ru:$country->name_ua}}</option>
                                                @endforeach
                                            @endif
                                            @if(!$hasCountry)
                                                <option value="{{Auth::user()->country}}" selected="selected">{{Auth::user()->country}}</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <label for="region">@lang("registration.region")</label>
                                        {{--<select name="region" id="region_select" class="form-control select2" disabled="disabled">

                                        </select>--}}
                                        <input id="region" type="text" class="form-control d-none" name="region" placeholder="@lang("registration.region")" value="{{Auth::user()->region}}">
                                    </div>
                                    <div class="form-group ">
                                        <label for="region">@lang("registration.city")</label>
                                        {{--<select name="city" id="city_select" class="form-control select2" disabled="disabled">

                                        </select>--}}
                                        <input id="city" type="text" class="form-control d-none" name="city" placeholder="@lang("registration.city")" value="{{Auth::user()->city}}">
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
                                        <input id="phone" type="tel" class="form-control" name="phone" value="{{Auth::user()->phone}}" placeholder="Телефон">
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
            var lang = "{{(App::getLocale() == 'ua'?'uk':App::getLocale())}}";

			$("#country").change(function() {
				var country = $('option:selected', this).data('iso');
				$("#region, #region_select").attr('disabled', 'disabled');
				$("#region_select").html('');
                if(country){
                    $.ajax({
                        method: "get",
                        url: "{{route('registration.region')}}",
                        data: {
                            country: country,
                            lang: lang,
                        },
                        success: function (resp) {
                            if (resp.result === "ok") {
                                if (resp.data.length > 0) {
                                    $("#region").addClass('d-none');
                                    $("#region_select").removeClass('d-none');
                                    $("#region_select").removeAttr('disabled');
                                    let region = $("#region").val();
                                    resp.data.forEach(function (e) {
                                        $("#region_select").append('<option value="' + e.name + '" data-iso="' + e.id + '" ' + ((region == e.name) ? 'selected="selected"' : '') + '>' + e.name + '</option>')
                                    })

                                    $("#region_select").change();


									$("#region").removeAttr('disabled');
									$("#region_select").addClass('d-none');
									$("#region").removeClass('d-none');

									$("#city").removeAttr('disabled');
									$("#city_select").addClass('d-none');
									$("#city").removeClass('d-none');
									$("#city_select").attr('disabled', 'disabled');
									$("#city_select").html('');
                                } else {
                                    $("#region").removeAttr('disabled');
                                    $("#region_select").addClass('d-none');
                                    $("#region").removeClass('d-none');

                                    $("#city").removeAttr('disabled');
                                    $("#city_select").addClass('d-none');
                                    $("#city").removeClass('d-none');
                                    $("#city_select").attr('disabled', 'disabled');
                                    $("#city_select").html('');
                                }

                            }else{
                                $("#region").removeAttr('disabled');
                                $("#region_select").addClass('d-none');
                                $("#region").removeClass('d-none');

                                $("#city").removeAttr('disabled');
                                $("#city_select").addClass('d-none');
                                $("#city").removeClass('d-none');
                                $("#city_select").attr('disabled','disabled');
                                $("#city_select").html('');
                            }
                        },
                        error: function (xhr, str) {
                            console.log(xhr);
                        }
                    });
                }else{
					$("#region").removeAttr('disabled');
					$("#region_select").addClass('d-none');
					$("#region").removeClass('d-none');

					$("#city").removeAttr('disabled');
					$("#city_select").addClass('d-none');
					$("#city").removeClass('d-none');
					$("#city_select").attr('disabled', 'disabled');
					$("#city_select").html('');
                }
			});
			$("#country").change();
			$("#region_select").change(function(){
				var region = $('option:selected', this).data('iso');
				$("#city_select").attr('disabled','disabled');
				$("#city_select").html('');

				$.ajax({
					method: "get",
					url: "{{route('registration.city')}}",
					data: {
						region: region,
						lang: lang,
					},
					success: function(resp)
					{
						if(resp.result==="ok"){

							if(resp.data.length > 0) {
								$("#city").addClass('d-none');
								$("#city_select").removeClass('d-none');
								$("#city_select").removeAttr('disabled');
								var prevCity = "";
								var city = $("#city").val();
								resp.data.forEach(function (e) {
									if (prevCity != e.name) {
										prevCity = e.name;
										$("#city_select").append('<option value="' + e.name + '" '+((city == e.name)?'selected="selected"':'')+'>' + e.name + '</option>');
									}

								})
							}else{
								$("#city").removeAttr('disabled');
								$("#city_select").addClass('d-none');
								$("#city").removeClass('d-none');
							}
						}
					},
					error:  function(xhr, str){
						console.log(xhr);
					}
				});
			});
		});
    </script>
@endsection

