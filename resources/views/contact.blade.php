@extends('layouts.main')
@section('content')
<section class="breadcrumb-box mb-4">
    <div class="container">
        <div class="row">
            {{ Breadcrumbs::render('contact') }}
        </div>
    </div>
</section>
<div class="contact-page">
    <div class="container mb-4">
        <div class="row">
            <div class="col-md-12"><h1 class="mb-0">{{$page->name}}</h1></div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d24169.20101032328!2d30.43487141241057!3d50.45089172722645!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xebfdc0b469bd12d6!2z0JHRg9GA0LTQsC3Qo9C60YDQsNC40L3QsA!5e0!3m2!1sru!2sua!4v1558447714428!5m2!1sru!2sua" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
            <div class="col-md-5">
                <div class="contact-page-form">
                    <h2>@lang('contact.form_header')</h2>
                    <form id="contact_form" method="POST" action="{{route('feedback')}}" >

                        @csrf
                            <div class="form-block">
                                <div class="form-group ">
                                    <input id="name" type="text" class="form-control" name="name" placeholder="@lang('contact.name')">
                                </div>
                                <div class="form-group ">
                                    <input id="email" type="email" class="form-control" name="email" placeholder="Email">

                                </div>
                                <div class="form-group ">
                                    <input id="subject" type="text" class="form-control" name="subject" placeholder="@lang('contact.subject')">
                                </div>
                                <div class="form-group ">
                                    <textarea name="text" class="form-control" cols="30" rows="5" placeholder="@lang('contact.text')"></textarea>
                                </div>
                            </div>
                        <div class="col-sm-8 offset-sm-2">
                            <button type="submit" class="btn-orange btn-block mb-0">
                                @lang('contact.submit')
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

