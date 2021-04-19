@extends('layouts.main')
@section('content')
    <section class="breadcrumb-box mb-5">
        <div class="container">
            <div class="row">
                {{ Breadcrumbs::render('blog_password',  trans('blog.hide_title'),$post) }}
            </div>
        </div>
    </section>
    <div class="container mb-3">
        <div class="row">
            <div class="col-md-12 text-center"><h1>{{trans('blog.hide_title')}}</h1></div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4">
                <form method="POST" action="{{ route('blog.password') }}">
                    @csrf
                    <input type="hidden" name="post_id" value="{{$post->id}}">
                    <div class="col-12">
                        <div class="form-group ">
                            <input type="password" class="form-control" name="password" placeholder="@lang("blog.password")">
                        </div>
                    </div>
                    <div class="col-sm-8 offset-sm-2">
                        <button type="submit" class="btn-orange btn-block mb-0">
                            @lang("blog.password_submit")
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

