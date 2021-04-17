@extends('layouts.main')
@section('content')
    <section class="breadcrumb-box mb-4">
        <div class="container">
            <div class="row">
                @if(isset($header))
                    {{ Breadcrumbs::render('error', $header) }}
                @else
                    {{ Breadcrumbs::render('error',trans('page_message.default_header')) }}
                @endif
            </div>
        </div>
    </section>
    <div class="container mb-4">
        <div class="row">
            @if(isset($header))
                <div class="col-md-12"><h1>{{$header}}</h1></div>
            @else
                <div class="col-md-12"><h1>@lang('page_message.default_header')</h1></div>
            @endif
        </div>
    </div>


    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-4">
                {!! $message !!}
            </div>
            <div class="col-md-4 col-xl-3 mb-5">
                <a href="{{route('home')}}" class="btn-orange btn-block">@lang('global.go_to_home')</a>
            </div>
        </div>
    </div>
@endsection
