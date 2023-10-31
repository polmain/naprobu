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
                    <div class="user-page-block">
                        <div class="user-page-title user-page-title-ref">
                            <p>@lang('user.user_page_text_1')</p>
                            <p>@lang('user.user_page_text_2')</p>
                        </div>
                    </div>
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
                                        <select name="country_id" id="country_id" class="form-control select2" required="required">
                                            @if(Auth::user()->country_model)
                                                @if(App::getLocale() === 'ru')
                                                    <option value="{{Auth::user()->country_model->id}}" selected="selected">{{Auth::user()->country_model->name}}</option>
                                                @else
                                                    <option value="{{Auth::user()->country_model->id}}" selected="selected">{{Auth::user()->country_model->translate->firstWhere('lang', App::getLocale())->name}}</option>
                                                @endif
                                            @endif
                                            @if(!Auth::user()->country_model || $defaultCountry->id !== Auth::user()->country_model->id)
                                                @if(App::getLocale() === 'ru')
                                                    <option value="{{$defaultCountry->id}}">{{$defaultCountry->name}}</option>
                                                @else
                                                    <option value="{{$defaultCountry->id}}">{{$defaultCountry->translate->firstWhere('lang', App::getLocale())->name}}</option>
                                                @endif
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <label for="region_id">@lang("registration.region")</label>
                                        <select name="region_id" id="region_id" class="form-control select2">
                                            @if(Auth::user()->region_model)
                                                @if(App::getLocale() === 'ru')
                                                    <option value="{{Auth::user()->region_model->id}}" selected="selected">{{Auth::user()->region_model->name}}</option>
                                                @else
                                                    <option value="{{Auth::user()->region_model->id}}" selected="selected">{{(Auth::user()->region_model->translate->firstWhere('lang', App::getLocale()) ?? Auth::user()->region_model)->name}}</option>
                                                @endif
                                            @endif
                                            <option value="other">@lang('registration.other_select')</option>
                                        </select>
                                    </div>
                                    <div class="form-group new_region-group">
                                        <label for="new_region">@lang("registration.new_region")</label>
                                        <input id="new_region" type="text" class="form-control" name="new_region" placeholder="@lang("registration.new_region_placeholder")">
                                    </div>
                                    <div class="form-group ">
                                        <label for="city_id">@lang("registration.city")</label>
                                        <select name="city_id" id="city_id" class="form-control select2">
                                            @if(Auth::user()->city_model)
                                                @if(App::getLocale() === 'ru')
                                                    <option value="{{Auth::user()->city_model->id}}" selected="selected">{{Auth::user()->city_model->name}}</option>
                                                @else
                                                    <option value="{{Auth::user()->city_model->id}}" selected="selected">{{(Auth::user()->city_model->translate->firstWhere('lang', App::getLocale()) ?? Auth::user()->city_model)->name}}</option>
                                                @endif
                                            @endif
                                            <option value="other">@lang('registration.other_select')</option>
                                        </select>
                                    </div>
                                    <div class="form-group new_city-group">
                                        <label for="new_city">@lang("registration.new_city")</label>
                                        <input id="new_city" type="text" class="form-control" name="new_city" placeholder="@lang("registration.new_city_placeholder")">
                                    </div>
                                </div>
                                <div class="form-block" id="nova_poshta_block">
                                    <h3>@lang("registration.nova_poshta")</h3>
                                    <div class="form-group ">
                                        <label for="nova_poshta_city">@lang("registration.nova_poshta_city")</label>
                                        <select name="nova_poshta_city" id="nova_poshta_city" class="form-control">
                                            @if( Auth::user()->nova_poshta_city )
                                                <option value="{{Auth::user()->nova_poshta_city}}" selected="selected">{{Auth::user()->nova_poshta_city}}</option>
                                            @endif
                                        </select>
                                    </div>
                                    <input type="hidden" name="nova_poshta_city_name" value="{{ Auth::user()->nova_poshta_city }}">
                                    <div class="form-group ">
                                        <label for="nova_poshta_warehouse">@lang("registration.nova_poshta_warehouse")</label>
                                        <select name="nova_poshta_warehouse" id="nova_poshta_warehouse" class="form-control">
                                            @if( Auth::user()->nova_poshta_warehouse )
                                                <option value="{{Auth::user()->nova_poshta_warehouse}}" selected="selected">{{Auth::user()->nova_poshta_warehouse}}</option>
                                            @endif
                                        </select>
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
                                        <label for="phone">@lang("registration.phone")</label>
                                        <input id="phone" type="tel" class="input-custom input-text form-control" name="phone_mask" required>
                                        <input id="phone-db" type="hidden" class="input-custom input-text form-control" name="phone" required value="{{Auth::user()->phone}}">
                                        <input type="text" class="hide-phone" style="display: none">
                                        <a href="#" id="myPhone" class="btn-orange" style="display: none">@lang("registration.myPhone")</a>
                                    </div>
                                </div>

                                <div class="form-block">
                                    <div class="form-group">
                                        <label for="education">@lang("registration.education")</label>
                                        <select name="education" id="education" class="form-control">
                                            @foreach($educationArray as $education)
                                                <option value="{{$education}}" @if($education->getValue() === Auth::user()->education)selected="selected" @endif>@lang("education.".$education)</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="employment">@lang("registration.employment")</label>
                                        <select name="employment" id="employment" class="form-control">
                                            @foreach($employmentArray as $employment)
                                                <option value="{{$employment}}" @if($employment->getValue() === Auth::user()->employment)selected="selected" @endif>@lang("employment.".$employment)</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group" id="work-group">
                                        <label for="work">@lang("registration.work")</label>
                                        <select name="work" id="work" class="form-control">
                                            @foreach($workArray as $work)
                                                <option value="{{$work}}" @if($work->getValue() === Auth::user()->work)selected="selected" @endif>@lang("work.".$work)</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="family_status">@lang("registration.family_status")</label>
                                        <select name="family_status" id="family_status" class="form-control">
                                            @foreach($familyStatusArray as $familyStatus)
                                                <option value="{{$familyStatus}}" @if($familyStatus->getValue() === Auth::user()->family_status)selected="selected" @endif>@lang("family_status.".$familyStatus)</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="has_child">@lang("registration.has_child")</label>
                                        <select name="has_child" id="has_child" class="form-control">
                                            <option value="1" @if(Auth::user()->has_child === 1)selected="selected" @endif>@lang("global.yes")</option>
                                            <option value="0" @if(Auth::user()->has_child === 0)selected="selected" @endif>@lang("global.no")</option>
                                        </select>
                                    </div>
                                    <div class="form-group" id="child_count_block">
                                        <label for="child_count">@lang("registration.child_count")</label>
                                        <input id="child_count" type="number" class="form-control" name="child_count" value="{{Auth::user()->children->count()}}" placeholder="@lang("registration.child_count")" min="1" max="20">
                                    </div>
                                    <div class="form-group" id="child_list">
                                        @foreach(Auth::user()->children as $key => $child)
                                            <label>@lang("registration.child_birthday") {{$key+1}}</label><input type="date" class="form-control child_birthday" name="child_birthday[]" max="{{date("Y-m-d")}}" value="{{$child->birthday}}">
                                        @endforeach
                                    </div>
                                    <div class="form-group">
                                        <label for="material_condition">@lang("registration.material_condition")</label>
                                        <select name="material_condition" id="material_condition" class="form-control">
                                            @foreach($materialConditionArray as $materialCondition)
                                                <option value="{{$materialCondition}}" @if($materialCondition->getValue() === Auth::user()->material_condition)selected="selected" @endif>@lang("material_condition.".$materialCondition)</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="hobbies">@lang("registration.hobbies")</label>
                                        @foreach($hobbiesArray as $hobby)
                                            <label class="form-check">@lang("hobbies.".$hobby)
                                                <input class="form-check-input" type="checkbox" name="hobbies[]" @if($hobby->isOther())id="hobbies_other_checkbox"@endif  @if(is_array(Auth::user()->hobbies) && in_array($hobby->getValue(), Auth::user()->hobbies))checked="checked" @endif value="{{$hobby}}">
                                                <span class="checkmark"></span>
                                            </label>
                                        @endforeach
                                    </div>
                                    <div class="form-group" id="hobbies_other-group">
                                        <input id="hobbies_other" type="text" class="form-control" name="hobbies_other" placeholder="@lang("hobbies.other")" value="{{Auth::user()->hobbies_other}}">
                                    </div>
                                </div>
                                <div class="form-block">

                                    @php
                                        $blogger = Auth::user()->bloggers->first();
                                        if ($blogger) {
                                           $blogger_status = \App\Entity\UserBloggerStatusEnum::getInstance($blogger->status);
                                        }
                                    @endphp

                                    @if (!$blogger)
                                        <p>{!! trans('user.user_page_text_blogger') !!}</p>
                                    @endif
                                    <label class="form-check">@lang("blogger.i_am_blogger")
                                        @if ($blogger)
                                        @switch(true)
                                            @case($blogger_status->isConfirmed())
                                                <strong style="color: #009933">@lang("blogger.confirmed")</strong>
                                            @break
                                            @case($blogger_status->isRefused())
                                                <strong style="color: #f9423a">@lang("blogger.refused")</strong>
                                            @break
                                            @case($blogger_status->isInModerate())
                                                <strong style="color: #FFCC00">@lang("blogger.om_moderation")</strong>
                                            @break
                                        @endswitch
                                        @endif
                                        <input class="form-check-input" type="checkbox" name="i_am_blogger" id="i_am_blogger_checkbox"  @if($blogger) @if(!$blogger_status->isRefused())checked="checked" @endif @if($blogger_status->isInModerate()) disabled="disabled" @endif @endif value="i_am_blogger">
                                        <span class="checkmark"></span>
                                    </label>
                                    @if(!$blogger || !$blogger_status->isConfirmed())
                                    <div class="form-group i_am_blogger-group">
                                        <label for="blogger_subscriber_count">@lang("blogger.subscriber_count")</label>
                                        <select name="blogger_subscriber_count" id="blogger_subscriber_count" class="form-control"  @if($blogger && $blogger_status->isInModerate()) disabled="disabled" @endif>
                                            @foreach($subscriberCountArray as $subscriberCount)
                                                <option value="{{$subscriberCount}}" @if($blogger && !$blogger_status->isRefused() && $subscriberCount->getValue() === $blogger->subscriber_count)selected="selected" @endif>@lang("blogger.subscriber_count_".$subscriberCount)</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group i_am_blogger-group">
                                        <input id="blog_subject" type="text" class="form-control" name="blog_subject" placeholder="@lang("blogger.blog_subject")" @if($blogger && !$blogger_status->isRefused())value="{{$blogger->blog_subject}}" @if($blogger_status->isInModerate()) disabled="disabled" @endif @endif>
                                    </div>
                                    <div class="form-group i_am_blogger-group">
                                        <input id="blog_platform" type="text" class="form-control" name="blog_platform" placeholder="@lang("blogger.blog_platform")" @if($blogger && !$blogger_status->isRefused())value="{{$blogger->blog_platform}}" @if($blogger_status->isInModerate()) disabled="disabled" @endif @endif>
                                    </div>
                                    <div class="form-group i_am_blogger-group">
                                        <input id="blog_url" type="text" class="form-control" name="blog_url" placeholder="@lang("blogger.blog_url")" @if($blogger && !$blogger_status->isRefused())value="{{$blogger->blog_url}}" @if($blogger_status->isInModerate()) disabled="disabled" @endif @endif>
                                    </div>
                                    @endif
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

    <div class="modal fade" id="validate_phone_sends" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('registration.validate_phone_sends_title')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <img src="{{asset('public/svg/icons/cross.svg')}}" alt="Cross">
                    </button>
                </div>
                <div class="modal-body">
                    @lang('registration.validate_phone_user_sends_text')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('global.close')</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset ("/public/js/jquery.mask.js") }}" type="text/javascript"></script>
    <script src="{{ asset ("/public/js/utils.js") }}" type="text/javascript"></script>
    <script src="{{ asset ("/public/js/intlTelInput.js") }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var lang = "{{App::getLocale()}}";
            $('#country_id').select2({
                placeholder: "{{trans('registration.country_select')}}",
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
                placeholder: "{{trans('registration.region_select')}}",
                tegs: false,
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
                    cache: false
                }
            });

            $('#region_id').change(function (e) {
                if ($(this).val() == 'other') {
                    $('.new_region-group').show();
                } else {
                    $('.new_region-group').hide();
                }
            });
            $('#region_id').change();

            $('#country_id').change(function (e) {
                if ($(this).val() == 637) {
                    $('#nova_poshta_block').show();
                } else {
                    $('#nova_poshta_block').hide();
                }
            });

            $('#city_id').select2({
                placeholder: "{{trans('registration.city_select')}}",
                tegs: true,
                minimumInputLength: 0,
                ajax: {
                    url: '{!! route('city.find') !!}',
                    dataType: 'json',
                    data: function (params) {
                        return {
                            name: params.term,
                            lang: lang,
                            region_id: $('#region_id').val() ? $('#region_id').val() : 0,
                            country_id: $('#country_id').val()
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },
                    cache: false
                }
            });

            $('#city_id').change(function (e) {
                if ($(this).val() == 'other') {
                    $('.new_city-group').show();
                    $('#new_city').attr('required', 'required');
                } else {
                    $('.new_city-group').hide();
                    $('#new_city').removeAttr('required');
                }
            });
            $('#city_id').change();

            /*$.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });*/
            delete $.ajaxSettings.headers["X-CSRF-TOKEN"];

            $('#nova_poshta_city').select2({
                placeholder: "{{trans('registration.new_city_placeholder')}}",
                minimumInputLength: 3,
                ajax: {
                    url: 'https://api.novaposhta.ua/v2.0/json/',
                    dataType: 'json',
                    type: 'POST',
                    data: function (params) {
                        delete $.ajaxSettings.headers["X-CSRF-TOKEN"];
                        var query = {
                            "modelName": "Address",
                            "calledMethod": "searchSettlements",
                            "methodProperties": {
                                "CityName": params.term,
                                "Limit": 10
                            },
                            "apiKey": "72ad00ce8bb01e03fc84ec9493bfa155"
                        };
                        return JSON.stringify(query);
                    },

                    processResults: function (data) {
                        var items = [];
                        if (data.success) {
                            var cities = data.data[0].Addresses;
                            cities.forEach(function (e) {
                                items.push({'id': e.DeliveryCity, 'text': e.Present});
                            })
                        }
                        return {
                            results: items,
                        };
                    },
                    cache: false
                },
            });

            $('#nova_poshta_city').change(function (e) {
                var curOption = $("#nova_poshta_city option:selected");
                $('input[name="nova_poshta_city_name"]').val(curOption.text());

                var query = {
                    "modelName": "AddressGeneral",
                    "calledMethod": "getWarehouses",
                    "methodProperties": {
                        "CityRef": $(this).val(),
                        "Language": "uk"
                    },
                    "apiKey": "72ad00ce8bb01e03fc84ec9493bfa155"
                };
                var data = JSON.stringify(query);

                $.ajax({
                    method: "POST",
                    url: "https://api.novaposhta.ua/v2.0/json/",
                    data: data,
                    dataType: 'json',
                    success: function (resp) {
                        $('#nova_poshta_warehouse').html('');

                        if (resp.success) {
                            resp.data.forEach(function (e) {
                                $('#nova_poshta_warehouse').append('<option val="' + e.Description + '">' + e.Description + '</option>');
                            });
                        }
                    },
                    error: function (xhr, str) {
                        console.log(xhr);
                    }
                });
            });

            $('#nova_poshta_warehouse').select2();

            if ($('#country_id').val() != 637) {
                $('#nova_poshta_block').hide();
            }

            $('#employment').change(function () {
                if ($(this).val() == "{{\App\Entity\EmploymentEnum::WORK}}") {
                    $('#work-group').show();
                } else {
                    $('#work-group').hide();
                }
            });

            $('#employment').change();

            $('#hobbies_other_checkbox').change(function (e) {
                if ($(this).is(':checked')) {
                    $('#hobbies_other-group').show();
                } else {
                    $('#hobbies_other-group').hide();
                }
            });

            $('#hobbies_other_checkbox').change();

            /* INITIALIZE BOTH INPUTS WITH THE intlTelInput FEATURE*/

            var telInput = $("#phone,.hide-phone").intlTelInput({
                initialCountry: "ua",
                preferredCountries: ["ua"],
                separateDialCode: true,
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.14/js/utils.js",
            });

            $("#phone").intlTelInput('setNumber', "{{Auth::user()->phone}}");
            /* ADD A MASK IN PHONE1 INPUT (when document ready and when changing flag) FOR A BETTER USER EXPERIENCE */

            $("#phone").on("countrychange", function (e, countryData) {
                $(".hide-phone").intlTelInput('setCountry', countryData.iso2);
                $(this).val('');
                var placeholder = $(".hide-phone").attr('placeholder');
                if(placeholder){
                    var mask1 = placeholder.replace(/[0-9]/g, 0);
                    $(this).mask(mask1);
                }

                $(this).unmask();
                $(this).attr('placeholder', placeholder);
            });

            $("#phone").keyup(function () {
                var phone = $("#phone").intlTelInput('getNumber');
                $("#phone-db").val(phone);
            });

            $(".hide-phone").parent().hide();

            $('#myPhone').click(function (e) {
                e.preventDefault();

                $.ajax({
                    method: "POST",
                    url: "/validate-phone/",
                    data: {
                        'phone': $("#phone-db").val()
                    },
                    success: function (resp) {
                        if (resp == 'ok') {
                            $('#validate_phone_sends').modal('show');
                        }
                    },
                    error: function (xhr, str) {
                        console.log(xhr);
                    }
                });
            })

            var placeholder = $("#phone").attr('placeholder');
            if(placeholder){
                var mask1 = placeholder.replace(/[0-9]/g, 0);
                $('input[type="tel"]').mask(mask1)
            }

            $('#has_child').change(function (e) {
                if ($(this).val() == 1) {
                    $('#child_count_block').show();
                } else {
                    $('#child_count_block').hide();
                }
            });

            $('#has_child').change();

            $("#child_count").bind('keyup mouseup', function () {
                let childBirthdayCount = $('.child_birthday').length;
                let childCount = $(this).val();

                if (childCount > childBirthdayCount) {
                    for (let i = childBirthdayCount; i < childCount; i++) {
                        $('#child_list').append("<label>@lang("registration.child_birthday") "+(i+1)+'</label><input type="date" class="form-control child_birthday" name="child_birthday[]" max="{{date("Y-m-d")}}">');
                    }
                }

                if (childCount < childBirthdayCount) {
                    for (let i = childCount; i < childBirthdayCount; i++) {
                        $('#child_list').children().last().remove();
                        $('#child_list').children().last().remove();
                    }
                }
            });

            $('#i_am_blogger_checkbox').change(function (e) {
                if ($(this).prop('checked')) {
                    $('.i_am_blogger-group').show();
                } else {
                    $('.i_am_blogger-group').hide();
                }
            });

            $('#i_am_blogger_checkbox').change();
        });
    </script>
@endsection

