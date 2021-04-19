@extends('layouts.main')
@section('content')
<section class="breadcrumb-box">
    <div class="container">
        <div class="row">
            {{ Breadcrumbs::render('review_single',trans('review.single_review_page_header'),$reviews->first()->id) }}
        </div>
    </div>
</section>
<div class="container">
    <div class="row">
        <div class="col-md-12"><h1>@lang('review.single_review_page_header')</h1></div>
    </div>
</div>
    <section class="review-list review-page">
        <div class="container">
            <div class="row" id="ajax-list">
                @include('review.include.review_item')
            </div>
        </div>
    </section>

    @include('review.include.review_comment_success_modal')
@endsection

