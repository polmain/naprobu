@extends('layouts.main')
@section('content')
    <div class="container">
        <div class="row">
            <div class="error-number">
                503
            </div>
            <div class="error-text">
                @lang('page_message.503_text')
            </div>
        </div>
    </div>
@endsection
