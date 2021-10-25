@extends('layouts.main')
@section('head')
    @if($reviews->previousPageUrl())
        @if($reviews->currentPage() == 2)
            <link rel="prev" href="{{$reviews->resolveCurrentPath()}}/" />
        @else
            <link rel="prev" href="{{$reviews->previousPageUrl()}}" />
        @endif
    @endif
    @if($reviews->nextPageUrl())
    <link rel="next" href="{{$reviews->nextPageUrl()}}" />
    @endif
@endsection
@section('content')
    <section class="breadcrumb-box mb-4">
        <div class="container">
            <div class="row">
                {{ Breadcrumbs::render('project_subpage',(App::getLocale() !== 'ru')?$project->category->translate->firstWhere('lang', App::getLocale()):$project->category,$project,$subpage) }}
            </div>
        </div>
    </section>
    <div class="container mb-3">
        <div class="row">
            <div class="col-lg-9"><h1 class="button-right">{{$subpage->name}}</h1></div>
            <div class="col-lg-3"><a href="{{route('project.level2',$project->url)}}" class="back-project">@lang('project.back_to_project')</a></div>
        </div>
    </div>
    @if( isset($subpage->text) && $subpage->text !== '')
    <section class="subpage-text">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="subpage-text-container">
                        {!! $subpage->text !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    @if($subpage->hasReviews)
        <div class="review-images">
            @php
                $i = 0;
                $max_image = 3;
            @endphp
            @foreach($subpage_base->project->review_images as $image)
                @if(++$i <= $max_image || count($subpage_base->project->review_images) <= $max_image)
                    <a class="review-image" data-fancybox="review_{{$review->id}}" href="/public/uploads/images/projects/{{$image[1]}}" style="background-image: url('/public/uploads/images/reviews/{{$image[0]}}')"></a>
                @elseif(++$i == 4)
                    <a class="review-image" data-fancybox="review_{{$review->id}}" href="/public/uploads/images/projects/{{$image[1]}}" style="background-image: url('/public/uploads/images/reviews/{{$image[0]}}')"><div class="more-image">{{count($subpage_base->project->review_images) - 2}}</div></a>
                @else
                    <a class="review-image review-image-hidden" data-fancybox="review_gallery" href="/public/uploads/images/projects/{{$image[1]}}"></a>
                @endif
            @endforeach
        </div>
        @if($subpage->type_id == 1 && count($topReviews) > 0)
        <div class="main-reviews mb-4">
            <div class="container">
                <h2>@lang('review.top_reviews')</h2>

                    <div class="review-list">
                        @foreach($topReviews as $review)
                            @include('review.include.review_item_slide')
                        @endforeach
                    </div>
            </div>
        </div>
        @endif

    <div class="container mb-4">
        <div class="row">

            <div class="col-lg-3 col-md-4 col-sm-6 offset-lg-6 offset-md-4 mb-sm-0 mb-3">
                @auth
                    @if($subpage->isReviewForm && (isset($projectRequest) || $subpage->type_id != 1))
                        <a href="#" class="add-review-button" data-toggle="modal" data-target="#add_review">
                            @if($subpage->type_id == 7)
                                @lang('project.add_question')
                            @else
                                @lang('project.add_review')
                            @endif
                        </a>
                    @endif
                @else
                    @if($subpage->isReviewForm)
                        <a href="#" class="add-review-button" data-toggle="modal" data-target="#login">
                            @if($subpage->type_id == 7)
                                @lang('project.add_question')
                            @else
                                @lang('project.add_review')
                            @endif
                        </a>
                    @endif
                @endauth
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6">
                @include('review.include.review_sort')
            </div>

        </div>
    </div>


    <section class="review-list review-page">
        <div class="container">
            <div class="row" id="ajax-list">
                @include('review.include.review_item_subpage')
            </div>
            @if($reviews->nextPageUrl())
            <div class="row">
                <div class="col-md-4 offset-md-4">
                    <button class="load-more">@lang('global.load_more')</button>
                </div>
            </div>
            @endif
        </div>
    </section>
    @endif

    @auth

        @include('review.include.review_comment_success_modal')

        <div class="modal fade" id="review_sends" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('project.review_success_header')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <img src="{{asset('public/svg/icons/cross.svg')}}" alt="Cross">
                        </button>
                    </div>
                    <div class="modal-body">
                        @lang('project.review_success_text')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('global.close')</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="review_saves" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('project.review_save_success_header')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <img src="{{asset('public/svg/icons/cross.svg')}}" alt="Cross">
                        </button>
                    </div>
                    <div class="modal-body">
                        @lang('project.review_save_success_text')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('global.close')</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="add_review" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('project.add_review_header')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <img src="{{asset('public/svg/icons/cross.svg')}}" alt="Cross">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="add_review_form" action="{{route('review.create',[$subpage->id])}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="lang" value="{{ App::getLocale()}}">
                            <input type="hidden" name="subpage" value="{{ $subpage_base->id}}">
                            <input type="hidden" name="subpage_type" value="{{ $subpage_base->type_id}}">
                            <input type="hidden" name="images" id="review_images">
                            <div class="error-message">

                            </div>
                            <div class="form-group ">
                                <div class="col-md-12">
                                    <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required placeholder="@lang('project.review_form_name')">
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="col-md-12">
                                    <textarea name="text" class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}" cols="30" rows="3" placeholder="@lang('project.review_form_text')"></textarea>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="col-md-12">
                                    <input type="text" class="form-control{{ $errors->has('video') ? ' is-invalid' : '' }}" name="video" value="{{ old('video') }}" placeholder="@lang('project.review_form_video')">
                                    {{--<small id="passwordHelpBlock" class="form-text text-muted">
                                        @lang('project.review_form_video_note')
                                    </small>--}}
                                </div>
                            </div>
                        </form>
                        <div class="form-group">
                            <div class="col-md-12">
                                <form action="{{ route('review.addimage') }}" role='form' id='uploadForm' name='uploadForm' method='post' enctype='multipart/form-data' class="dropzone">
                                    <div class="form-group" id="attachment">
                                        <div class="controls text-center">
                                            <div class="input-group w-100">

                                            </div>
                                        </div>
                                    </div>
                                    <input type='hidden' name='_token' value='{{csrf_token()}}'>
                                </form>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <button type="button" class="btn-modal-submit" id="review_form_submit">@lang('project.review_form_submit')</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="edit_review" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">@lang('project.edit_review_header')</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <img src="{{asset('public/svg/icons/cross.svg')}}" alt="Cross">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="edit_review_form" action="{{route('review.edit')}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <input type="hidden" name="lang" value="{{ App::getLocale()}}">
                            <input type="hidden" name="images" id="edit_review_images" value=''>
                            <input type="hidden" name="review_id">
                            <div class="error-message">

                            </div>
                            <div class="form-group ">
                                <div class="col-md-12">
                                    <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required placeholder="@lang('project.review_form_name')">
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="col-md-12">
                                    <textarea name="text" class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}" cols="30" rows="3" placeholder="@lang('project.review_form_text')"></textarea>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="col-md-12">
                                    <input type="text" class="form-control{{ $errors->has('video') ? ' is-invalid' : '' }}" name="video" value="{{ old('video') }}" placeholder="@lang('project.review_form_video')">
                                    {{--<small id="passwordHelpBlock" class="form-text text-muted">
                                        @lang('project.review_form_video_note')
                                    </small>--}}
                                </div>
                            </div>
                        </form>
                        <div class="form-group">
                            <div class="col-md-12">
                                <form action="{{ route('review.addimage') }}" role='form' id='editUploadForm' name='editUploadForm' method='post' enctype='multipart/form-data' class="dropzone">
                                    <div class="form-group" id="attachmentEdit">
                                        <div class="controls text-center">
                                            <div class="input-group w-100">

                                            </div>
                                        </div>
                                    </div>
                                    <input type='hidden' name='_token' value='{{csrf_token()}}'>

                                </form>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <button type="button" class="btn-modal-submit" id="review_edit_form_submit">@lang('project.edit_form_submit')</button>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <script>
			var dropzoneText = "@lang('project.review_dropzone_text')";
			var minCharsets = {{$subpage_base->min_charsets}};
			var reviewValidate = {
				required: "@lang('validation.required')",
				maxlength: "@lang('validation.maxlength')",
				minlength: "@lang('validation.minlength')",
			}
        </script>
    @endauth
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
                // Инициализируем виджет с языком по умолчанию
                new google.translate.TranslateElement({
                    pageLanguage: googleTranslateConfig.lang,
                });
            }

            function TranslateGetCode() {
                // Если куки нет, то передаем дефолтный язык
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
                // Записываем куки /язык_который_переводим/язык_на_который_переводим
                $.cookie('googtrans', "/auto/" + code);
                $.cookie("googtrans", "/auto/" + code, {
                    domain: "." + document.domain,
                });
            }

        </script>
        <script src="//translate.google.com/translate_a/element.js?cb=TranslateInit"></script>
    @endif
@endsection
