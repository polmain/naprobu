@extends('layouts.main')
@section('lang_href',$alternet_url)
@section('head')
    <link rel="alternate" href="{{$alternet_url}}" hreflang="{{(App::getLocale() == 'ru')?'uk':'ru'}}-UA" />
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="error-number">
                419
            </div>
            <div class="error-text">
                @lang('page_message.419_text')
            </div>
        </div>
    </div>
@endsection