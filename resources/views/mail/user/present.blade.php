@extends('mail.layout.main')

@section('header', $request->subject)

@section('content')
    <p>{!!   $request->text !!}</p>
@endsection