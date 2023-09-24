@extends('layouts.main')
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
                                    <label for="country">@lang("registration.birsday")</label>
                                    <select id="birsday" class="form-control" name="birsday">
                                        @for($year = \Carbon\Carbon::now()->year; $year >= 1900; $year--)
                                        <option value="{{$year}}">{{$year}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="form-block">
                                <div class="form-group ">
                                    <label for="country">@lang("registration.country")</label>
                                    <select name="country_id" id="select2_country_id" class="form-control select2" required="required">
                                    </select>
                                </div>
                                <div class="form-group ">
                                    <label for="region_id">@lang("registration.region")</label>
                                    <select name="region_id" id="select2_region_id" class="form-control select2">
                                        <option value="other">@lang('registration.other_select')</option>
                                    </select>
                                </div>
                                <div class="form-group new_region-group">
                                    <label for="new_region">@lang("registration.new_region")</label>
                                    <input id="new_region" type="text" class="form-control" name="new_region" placeholder="@lang("registration.new_region_placeholder")">
                                </div>
                                <div class="form-group ">
                                    <label for="city_id">@lang("registration.city")</label>
                                    <select name="city_id" id="select2_city_id" class="form-control select2">
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
                                    </select>
                                </div>
                                <input type="hidden" name="nova_poshta_city_name">
                                <div class="form-group ">
                                    <label for="nova_poshta_warehouse">@lang("registration.nova_poshta_warehouse")</label>
                                    <select name="nova_poshta_warehouse" id="nova_poshta_warehouse" class="form-control">
                                    </select>
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
                                    <label for="phone">@lang("registration.phone")</label>
                                    <input id="phone" type="tel" class="input-custom input-text form-control" name="phone_mask" required>
                                    <input id="phone-db" type="hidden" class="input-custom input-text form-control" name="phone" required>
                                    <input type="text" class="hide-phone" style="display: none">
                                    <a href="#" id="myPhone" class="btn-orange" style="display: none">@lang("registration.myPhone")</a>
                                </div>
                            </div>
                            <div class="form-block">
                                <div class="form-group ">
                                    <input id="expert-password" type="password" class="form-control" name="password" placeholder="@lang("registration.password")" autocomplete="new-password">
                                </div>
                                <div class="form-group mb-30">
                                    <input id="expert-password_confirmation" type="password" class="form-control" name="password_confirmation" placeholder="@lang("registration.password_confirmation")" autocomplete="new-password">
                                </div>
                            </div>
                            <div class="form-block">
                                <div class="form-group">
                                    <label for="education">@lang("registration.education")</label>
                                    <select name="education" id="education" class="form-control">
                                        @foreach($educationArray as $education)
                                            <option value="{{$education}}">@lang("education.".$education)</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="employment">@lang("registration.employment")</label>
                                    <select name="employment" id="employment" class="form-control">
                                        @foreach($employmentArray as $employment)
                                            <option value="{{$employment}}">@lang("employment.".$employment)</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group" id="work-group">
                                    <label for="work">@lang("registration.work")</label>
                                    <select name="work" id="work" class="form-control">
                                        @foreach($workArray as $work)
                                            <option value="{{$work}}">@lang("work.".$work)</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="family_status">@lang("registration.family_status")</label>
                                    <select name="family_status" id="family_status" class="form-control">
                                        @foreach($familyStatusArray as $familyStatus)
                                            <option value="{{$familyStatus}}">@lang("family_status.".$familyStatus)</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="has_child">@lang("registration.has_child")</label>
                                    <select name="has_child" id="has_child" class="form-control">
                                        <option value="0">@lang("global.no")</option>
                                        <option value="1">@lang("global.yes")</option>
                                    </select>
                                </div>
                                <div class="form-group" id="child_count_block">
                                    <label for="child_count">@lang("registration.child_count")</label>
                                    <input id="child_count" type="number" class="form-control" name="child_count" placeholder="@lang("registration.child_count")" min="1" max="20" value="1">
                                </div>
                                <div class="form-group" id="child_list">
                                        <label>@lang("registration.child_birthday") 1</label><input type="date" class="form-control child_birthday" name="child_birthday[]" max="{{date("Y-m-d")}}">
                                </div>
                                <div class="form-group">
                                    <label for="material_condition">@lang("registration.material_condition")</label>
                                    <select name="material_condition" id="material_condition" class="form-control">
                                        @foreach($materialConditionArray as $materialCondition)
                                            <option value="{{$materialCondition}}">@lang("material_condition.".$materialCondition)</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="hobbies">@lang("registration.hobbies")</label>
                                    @foreach($hobbiesArray as $hobby)
                                    <label class="form-check">@lang("hobbies.".$hobby)
                                        <input class="form-check-input" type="checkbox" name="hobbies[]" @if($hobby->isOther())id="hobbies_other_checkbox"@endif value="{{$hobby}}">
                                        <span class="checkmark"></span>
                                    </label>
                                    @endforeach
                                </div>
                                <div class="form-group" id="hobbies_other-group">
                                    <input id="hobbies_other" type="text" class="form-control" name="hobbies_other" placeholder="@lang("hobbies.other")">
                                </div>
                            </div>
                            <div class="form-block">
                                <label class="form-check">@lang("blogger.i_am_blogger")
                                    <input class="form-check-input" type="checkbox" name="i_am_blogger" id="i_am_blogger_checkbox" value="i_am_blogger">
                                    <span class="checkmark"></span>
                                </label>
                                <div class="form-group i_am_blogger-group">
                                    <input id="blogger_subscriber_count" type="text" class="form-control" name="blogger_subscriber_count" placeholder="@lang("blogger.subscriber_count")">
                                </div>
                                <div class="form-group i_am_blogger-group">
                                    <input id="blog_subject" type="text" class="form-control" name="blog_subject" placeholder="@lang("blogger.blog_subject")">
                                </div>
                                <div class="form-group i_am_blogger-group">
                                    <input id="blog_platform" type="text" class="form-control" name="blog_platform" placeholder="@lang("blogger.blog_platform")">
                                </div>
                                <div class="form-group i_am_blogger-group">
                                    <input id="blog_url" type="text" class="form-control" name="blog_url" placeholder="@lang("blogger.blog_url")">
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
                    @lang('registration.validate_phone_sends_text')
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
    <script src="{{ asset ("/public/js/intlTelInput.js") }}" type="text/javascript"></script>
    <script type="text/javascript">
        var currentLang = "{{App::getLocale()}}";
        var country_select = "{{trans('registration.country_select')}}";
        var region_select = "{{trans('registration.region_select')}}.";
        var city_select = "{{trans('registration.city_select')}}";
        var new_city_placeholder = "{{trans('registration.new_city_placeholder')}}";
        var employment_work = "{{\App\Entity\EmploymentEnum::WORK}}";
    </script>
    <script>
        var telInput = $("#phone,.hide-phone").intlTelInput({
            initialCountry: "ua",
            preferredCountries: ["ua"],
            separateDialCode: true,
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.14/js/utils.js",
        });

        $(document).ready(function () {
            var placeholder = $("#phone").attr('placeholder');
            if(placeholder){
                var mask1 = placeholder.replace(/[0-9]/g, 0);
                $('input[type="tel"]').mask(mask1);
            }
        });

        $("#phone").on("countrychange", function (e, countryData) {
            $(".hide-phone").intlTelInput('setCountry', countryData.iso2);
            $(this).val('');
            var placeholder = $(".hide-phone").attr('placeholder');
            var mask1 = placeholder.replace(/[0-9]/g, 0);
            $(this).unmask();
            $(this).mask(mask1);
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
        });

        $( document ).ready( function() {

            $('#select2_country_id').select2({
                placeholder: "{{trans('registration.country_select')}}",
                minimumInputLength: 0,
                ajax: {
                    url: '{!! route('country.find') !!}',
                    dataType: 'json',
                    data: function (params) {
                        return {
                            "name": params.term,
                            "lang": currentLang,
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
            $('#select2_region_id').select2({
                placeholder: region_select,
                minimumInputLength: 0,
                ajax: {
                    url: '/regions/find/',
                    dataType: 'json',
                    data: function (params) {
                        return {
                            'name': params.term,
                            'lang': currentLang,
                            'country_id': $('#select2_country_id').val()
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


            $('#select2_city_id').select2({
                placeholder: city_select,
                minimumInputLength: 0,
                ajax: {
                    url: '/cities/find/',
                    dataType: 'json',
                    data: function (params) {
                        return {
                            'name': params.term,
                            'lang': currentLang,
                            'region_id': $('#select2_region_id').val() ? $('#select2_region_id').val() :  0,
                            'country_id': $('#select2_country_id').val()
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


        });

        $('#select2_country_id').change(function (e) {
            if ($(this).val() == 637) {
                $('#nova_poshta_block').css('display', 'block');
            } else {
                $('#nova_poshta_block').css('display', 'none');
            }
        });

        $('#select2_region_id').change(function (e) {
            if ($(this).val() == 'other') {
                $('.new_region-group').css('display', 'block');
            } else {
                $('.new_region-group').css('display', 'none');
            }
        });
        $('#select2_region_id').change();

        $('#select2_city_id').change(function (e) {
            if ($(this).val() === 'other') {
                $('.new_city-group').css('display', 'block');
                $('#new_city').attr('required', 'required');
            } else {
                $('.new_city-group').css('display', 'none');
                $('#new_city').removeAttr('required');
            }
        });
        $('#select2_city_id').change();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        delete $.ajaxSettings.headers["X-CSRF-TOKEN"];

        $('#nova_poshta_city').select2({
            placeholder: new_city_placeholder,
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
                        "apiKey": "71190074c2d66199cbd1886cba6f186f"
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
                "apiKey": "71190074c2d66199cbd1886cba6f186f"
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

        $('#nova_poshta_block').hide();

        $('#employment').change(function () {
            if ($(this).val() == employment_work) {
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

        $('#has_child').change(function (e) {
            if ($(this).val() == 1) {
                $('#child_count_block').show();
                $('#child_list').show();
            } else {
                $('#child_count_block').hide();
                $('#child_list').hide();
            }
        });

        $('#has_child').change();

        $("#child_count").bind('keyup mouseup', function () {
            let childBirthdayCount = $('.child_birthday').length;
            let childCount = $(this).val();

            if (childCount > childBirthdayCount) {
                for (let i = childBirthdayCount; i < childCount; i++) {
                    $('#child_list').append('<label>@lang("registration.child_birthday") '+(i+1)+'</label><input type="date" class="form-control child_birthday" name="child_birthday[]" max="{{date("Y-m-d")}}">');
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
    </script>
@endsection
