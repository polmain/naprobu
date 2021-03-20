@extends('mail.layout.main')

@section('header', trans('mail.verefi_email_header'))

@section('content')
    <p><strong>{{$user->name}}</strong> {!!  trans('mail.verefi_email_text',['link' => route('auth.verify',['user_id'  =>  $user->id,'verify_code'  =>  $user->email_verefy_code])]) !!}.</p>
@endsection