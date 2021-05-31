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
                                    <input id="birsday" type="text" class="form-control" name="birsday" placeholder="@lang("registration.birsday")">
                                </div>
                            </div>
                            <div class="form-block">
                                <div class="form-group ">
                                    <label for="country">@lang("registration.country")</label>
                                    <select name="country_id" id="country_id" class="form-control select2">
                                    </select>
                                </div>
                                <div class="form-group ">
                                    <label for="region_id">@lang("registration.region")</label>
                                    <select name="region_id" id="region_id" class="form-control select2">
                                    </select>
                                </div>
                                <div class="form-group ">
                                    <label for="new_region">@lang("registration.new_region")</label>
                                    <input id="new_region" type="text" class="form-control" name="new_region" placeholder="@lang("registration.new_region_placeholder")">
                                </div>
                                <div class="form-group ">
                                    <label for="city_id">@lang("registration.city")</label>
                                    <select name="city_id" id="city_id" class="form-control select2">
                                    </select>
                                </div>
                                <div class="form-group ">
                                    <label for="new_city">@lang("registration.new_city")</label>
                                    <input id="new_city" type="text" class="form-control" name="new_city" placeholder="@lang("registration.new_city_placeholder")">
                                </div>
                            </div>
                            <div class="form-block">
                                <div class="form-group ">
                                    <label for="nova_poshta_region">@lang("registration.nova_poshta_region")</label>
                                    <select name="nova_poshta_region" id="nova_poshta_region" class="form-control">
                                    </select>
                                </div>
                                <div class="form-group ">
                                    <label for="nova_poshta_city">@lang("registration.nova_poshta_city")</label>
                                    <select name="nova_poshta_city" id="nova_poshta_city" class="form-control">
                                    </select>
                                </div>
                                <div class="form-group ">
                                    <input id="expert-email" type="email" class="form-control" name="email" placeholder="Email">
                                </div>
                                <div class="form-group ">
                                    <input id="phone" type="tel" class="form-control" name="phone" placeholder="@lang("registration.phone")">
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
                                    <input id="phone" type="tel" class="form-control" name="phone" placeholder="@lang("registration.phone")">
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
                placeholder: "{{trans('registration.region_select')}}.",
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
                            region_id: $('#region_id').val() ?? 0,
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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        delete $.ajaxSettings.headers["X-CSRF-TOKEN"];
        $.ajax({
            method: 'POST',
            dataType: 'json',
            url: 'https://api.novaposhta.ua/v2.0/json/',
            data: JSON.stringify({
                "apiKey": "561c40b8c8c50432066bc12cc25edefd",
                "modelName": "Address",
                "calledMethod": "getAreas",
                "methodProperties": {}
            }),
            success: function(response){
                if(response.success){
                    response.data.forEach(function (item){
                        $('#nova_poshta_region').append("<option value='"+item.Ref+"'>"+item.Description+"</option>");
                    });
                }
            }
        });
        $('#nova_poshta_city').select2({
            placeholder: "Введіть населений пункт",
            minimumInputLength: 3,
            ajax: {
                url: 'https://api.novaposhta.ua/v2.0/json/',
                dataType: 'json',
                type: 'POST',
                data: function (params) {
                    var query = {
                        "modelName": "Address",
                        "calledMethod": "searchSettlements",
                        "methodProperties": {
                            "CityName":params.term,
                            "Limit": 10
                        },
                        "apiKey": "561c40b8c8c50432066bc12cc25edefd"
                    };
                    return JSON.stringify(query);
                },

                processResults: function (data) {
                    var items = [];
                    if(data.success){
                        var cities = data.data[0].Addresses;
                        cities.forEach(function (e) {
                            items.push({'id':e.DeliveryCity,'text':e.Present});
                        })
                    }
                    return {
                        results: items,
                    };
                },
                cache: false
            },
        });

        });

    </script>
@endsection
