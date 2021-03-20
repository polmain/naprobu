@extends('mail.layout.main')

@section('header', $subject)

@section('content')
    <p>{!! $body !!}</p>
@endsection