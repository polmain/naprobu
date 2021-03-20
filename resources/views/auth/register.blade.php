@extends('layouts.main')
@section('lang_href',$alternet_url)
@section('head')
    <link rel="alternate" href="{{$alternet_url}}" hreflang="{{(App::getLocale() == 'ru')?'uk':'ru'}}-UA" />
@endsection
@section('content')
    <section class="breadcrumb-box mb-4">
        <div class="container">
            <div class="row">
                {{ Breadcrumbs::render('registration') }}
            </div>
        </div>
    </section>
    <div class="registration-page">
        <div class="container mb-30">
            <div class="row">
                <div class="col-md-12"><h1 class="mb-0">{{$page->name}}</h1></div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <section class="registration-text">
                        {!! $page->content !!}
                    </section>
                </div>
                <div class="col-md-5">
                    <form method="POST" action="{{ route('register.expert') }}" id="register_expert">
                        @csrf
                        <div class="col-12">
                            <div class="form-block">
                                <div class="form-group ">
                                    <input id="last_name" type="text" class="form-control" name="last_name" placeholder="@lang("registration.last_name")">
                                </div>
                                <div class="form-group ">
                                    <input id="first_name" type="text" class="form-control" name="first_name" placeholder="@lang("registration.first_name")">
                                </div>
                                <div class="form-group ">
                                    <input id="patronymic" type="text" class="form-control" name="patronymic" placeholder="@lang("registration.patronymic")">
                                </div>
                            </div>
                            <div class="form-block">
                                <div class="form-group ">
                                    <label for="sex">@lang("registration.sex")</label>
                                    <select name="sex" id="sex" class="form-control">
                                        <option value="1">@lang("registration.man")</option>
                                        <option value="0">@lang("registration.woman")</option>
                                    </select>
                                </div>
                                <div class="form-group ">
                                    <input id="birsday" type="text" class="form-control" name="birsday" placeholder="@lang("registration.birsday")">
                                </div>
                            </div>
                            <div class="form-block">
                                <div class="form-group ">

                                    <label for="country">@lang("registration.country")</label>
                                    <select name="country" id="country" class="form-control select2">

                                       @foreach($countries as $country)
                                            <option value="{{(App::getLocale()=='ru')?$country->name_ru:$country->name_ua}}" data-iso="{{$country->iso}}" @if($country->iso == 'UA') selected="selected" @endif>{{(App::getLocale()=='ru')?$country->name_ru:$country->name_ua}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group ">
                                    <label for="region">@lang("registration.region")</label>
                                    <select name="region" id="region_select" class="form-control select2" disabled="disabled">

                                    </select>
                                    <input id="region" type="text" class="form-control d-none" name="region" placeholder="@lang("registration.region")" disabled="disabled">
                                </div>
                                <div class="form-group ">
                                    <label for="region">@lang("registration.city")</label>
                                    <select name="city" id="city_select" class="form-control select2" disabled="disabled">

                                    </select>
                                    <input id="city" type="text" class="form-control d-none" name="city" placeholder="@lang("registration.city")" disabled="disabled">
                                </div>
                            </div>
                            <div class="form-block">
                                <div class="form-group ">
                                    <input id="expert-name" type="text" class="form-control" name="name" placeholder="@lang("registration.name")">
                                </div>
                                <div class="form-group ">
                                    <input id="expert-email" type="email" class="form-control" name="email" placeholder="Email">
                                </div>
                                <div class="form-group ">
                                    <input id="phone" type="tel" class="form-control" name="phone" placeholder="Телефон">
                                </div>
                            </div>
                            <div class="form-block">
                                <div class="form-group ">
                                    <input id="expert-password" type="password" class="form-control" name="password" placeholder="@lang("registration.password")">
                                </div>
                                <div class="form-group mb-30">
                                    <input id="expert-password_confirmation" type="password" class="form-control" name="password_confirmation" placeholder="@lang("registration.password_confirmation")">
                                </div>
                            </div>
                            <div class="form-group mb-30">
                                <p class="text-center small-text">
                                    {!!  trans('modal.user_agreement',['url' => route('simple',['legal'])]) !!}
                                </p>
                            </div>
                        </div>
                        <div class="col-sm-8 offset-sm-2">
                            <button type="submit" class="btn-orange btn-block mb-0">
                                @lang("registration.submit")
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
        	var lang = "{{(App::getLocale() == 'ru'?'ru':'uk')}}";

            $("#country").change(function(){
            	var country = $('option:selected', this).data('iso');
				$("#region, #region_select").attr('disabled','disabled');
				$("#region_select").html('');

				$.ajax({
					method: "get",
					url: "{{route('registration.region')}}",
                    data: {
						country: country,
						lang: lang,
                    },
					success: function(resp)
					{
						if(resp.result==="ok"){
							if(resp.data.length > 0){
								$("#region").addClass('d-none');
								$("#region_select").removeClass('d-none');
								$("#region_select").removeAttr('disabled');
								resp.data.forEach(function (e) {
									$("#region_select").append('<option value="'+e.name+'" data-iso="'+e.id+'">'+e.name+'</option>')
								})
								$("#region_select").change();
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

						}
					},
					error:  function(xhr, str){
						console.log(xhr);
					}
				});
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
								resp.data.forEach(function (e) {
									if (prevCity != e.name) {
										prevCity = e.name;
										$("#city_select").append('<option value="' + e.name + '">' + e.name + '</option>');
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
