@extends('mail.layout.main')

@section('header', 'Новий пароль для сайту naprobu.ua')

@section('content')
    <p>У зв'язку з оновленням сайту та його системи безпеки ваш пароль було скинуто.</p>
    <p><br/></p>
    <p>Ваш логин: <strong>{{$user->email}}</strong></p>
    <p>Ваш новий пароль: <strong>{{$password}}</strong></p>
    <p><br/></p>
    <p>Ви можете змінити його у своєму <a href="{{route('user.cabinet')}}">особистому кабінеті.</a></p>
@endsection