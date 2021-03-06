@extends('layouts.main')
@section('content')
    <section class="breadcrumb-box mb-4">
        <div class="container">
            <div class="row">
                {{ Breadcrumbs::render('project_questionnaire',(App::getLocale() !== 'ru')?$project->category->translate->firstWhere('lang', App::getLocale()):$project->category,$project,$base) }}
            </div>
        </div>
    </section>
    <div class="container mb-3">
        <div class="row">
            <div class="col-lg-9"><h1 class="button-right">{{$questionnaire->name}}</h1></div>
            <div class="col-lg-3"><a href="{{route('project.level2',$project->url)}}" class="back-project">@lang('project.back_to_project')</a></div>
        </div>
    </div>
    @if( isset($questionnaire->text) && $questionnaire->text !== '')
    <section class="subpage-text">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="subpage-text-container">
                        {!! $questionnaire->text !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-8">

            <form action="{{route('project.questionnaire.send',[$base->id])}}" method="post" class="questionnaire-form">
                @csrf
                @auth()
                @else
                    <div class="col-12">
                        <div class="subpage-text-container">
                            @lang('questionnaire.not_registration_text')
                        </div>
                    </div>
                <div class="col-sm-8 offset-sm-2">
                    <input type="hidden" name="lang" value="{{ App::getLocale()}}">
                    <div class="form-group ">
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="last_name" placeholder="@lang('registration.last_name')" required>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="first_name" placeholder="@lang('registration.first_name')" required>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="patronymic" placeholder="@lang('registration.patronymic')" required>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-md-12">
                            <label for="sex">@lang("registration.sex")</label>
                            <select name="sex" id="sex" class="form-control">
                                <option value="1">@lang("registration.man")</option>
                                <option value="0">@lang("registration.woman")</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group ">
                        <div class="col-md-12">
                            <input type="email" class="form-control" name="email" placeholder="Email" required>
                        </div>
                    </div>

                    <div class="form-group ">
                        <div class="col-md-12">
                            <input type="phone" class="form-control" name="phone" placeholder="@lang("registration.phone")" required>
                        </div>
                    </div>

                    <div class="form-group ">
                        <div class="col-md-12">
                            <input type="text" class="form-control" name="name" placeholder="@lang('modal.nickname')" required>
                        </div>
                    </div>

                    <div class="form-group ">
                        <div class="col-md-12">
                            <input type="password" class="form-control" name="password" placeholder="@lang('modal.make_passord')" required>
                        </div>
                    </div>

                    <div class="form-group ">
                        <div class="col-md-12">
                            <input type="password" class="form-control" name="password_confirmation" placeholder="@lang('modal.repeat_passord')" required>
                        </div>
                    </div>
                </div>
                @endauth
                @include('questionnaire.questions')
                <div class="col-sm-8 offset-sm-2">
                    <button type="submit" class="btn-orange btn-block mb-0">
                        @lang('questionnaire.submit')
                    </button>
                </div>
            </form>

                </div>
            </div>
        </div>
    </section>
    <script>
        var questionnaireValidate = {
        	required: "@lang('questionnaire.required')",
			min_chars: "@lang('questionnaire.min_chars')",
			max_chars: "@lang('questionnaire.max_chars')",
			min_numb: "@lang('questionnaire.min_numb')",
			max_numb: "@lang('questionnaire.max_numb')",
			min_check: "@lang('questionnaire.min_check')",
			max_check: "@lang('questionnaire.max_check')",
        }
    </script>
@endsection

@section('scripts')
    @if($project->audience->isWord() && App::getLocale() === 'ru')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
        <script>
            const googleTranslateConfig = {
                lang: "ru",
            };
            TranslateSetCookie("{{strtolower($project->country->getCode())}}")

            function TranslateInit() {
                // ???????????????????????????? ???????????? ?? ???????????? ???? ??????????????????
                new google.translate.TranslateElement({
                    pageLanguage: googleTranslateConfig.lang,
                });
            }

            function TranslateGetCode() {
                // ???????? ???????? ??????, ???? ???????????????? ?????????????????? ????????
                let lang = ($.cookie('googtrans') != undefined && $.cookie('googtrans') != "null") ? $.cookie('googtrans') : googleTranslateConfig.lang;
                return lang.substr(-2);
            }

            function TranslateClearCookie() {
                $.cookie('googtrans', null);
                $.cookie("googtrans", null, {
                    domain: "." + document.domain,
                });
            }

            function TranslateSetCookie(code) {
                // ???????????????????? ???????? /????????_??????????????_??????????????????/????????_????_??????????????_??????????????????
                $.cookie('googtrans', "/auto/" + code);
                $.cookie("googtrans", "/auto/" + code, {
                    domain: "." + document.domain,
                });
            }

        </script>
        <script src="//translate.google.com/translate_a/element.js?cb=TranslateInit"></script>
    @endif
@endsection
