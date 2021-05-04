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
            {{ Breadcrumbs::render('user_review') }}
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

                <section class="review-list review-page">
                    <div class="container">
                        <div class="row" id="ajax-list">
                            @include('review.include.review_item_user')
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
@auth

    @include('review.include.review_comment_success_modal')

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
{{--
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
                                <small id="passwordHelpBlock" class="form-text text-muted">
                                    @lang('project.review_form_video_note')
                                </small>
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
    --}}

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
		var minCharsets = 0;
		var reviewValidate = {
			required: "@lang('validation.required')",
			maxlength: "@lang('validation.maxlength')",
			minlength: "@lang('validation.minlength')",
		}
    </script>
@endauth
@endsection

