@extends('layouts.main')
@section('content')
<section class="breadcrumb-box mb-4">
    <div class="container">
        <div class="row">
            {{ Breadcrumbs::render('error', 'Бан') }}
        </div>
    </div>
</section>
<div class="container mb-4">
    <div class="row">
        <div class="col-md-12"><h1>@lang('page_message.ban_header') {{ (App::getLocale() == 'ru')?$user->status->name:$user->status->translate->name }}</h1></div>
    </div>
</div>
<div class="container">
    <div class="row">
    @if($user->ban)
        <div class="col-md-12">
            @if($user->ban->isForLife)
                @lang('page_message.ban_for_life')
            @else
                @lang('page_message.ban_for_time') <strong>{{Carbon::parse($user->ban->time)->format('H:i d.m.Y')}}</strong>
            @endif
        </div>
        @if(isset($user->ban->note))
            <div class="col-md-12">
                <strong>@lang('page_message.ban_note')</strong> {{$user->ban->note}}
            </div>
        @endif
    @else
        <div class="col-md-12">
            @lang('page_message.ban_for_life')
        </div>
    @endif

    </div>
</div>
@endsection

