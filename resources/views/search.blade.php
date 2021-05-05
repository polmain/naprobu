@extends('layouts.main')
@section('content')
<section class="breadcrumb-box mb-4">
    <div class="container">
        <div class="row">
            {{ Breadcrumbs::render('search') }}
        </div>
    </div>
</section>
<div class="container mb-4">
    <div class="row">
        <div class="col-md-12"><h1>{{$page->name}}</h1></div>
    </div>
</div>
<div class="container">
    <form action="{{route('search')}}" method="GET">
        @csrf
        <div class="row">
            <div class="col-9">
                <div class="form-group">
                    <input id="name" type="text" class="form-control" name="name" value="{{ Request::input("name")  }}" placeholder="@lang('search.enter_query')" >
                </div>
            </div>

            <div class="col-3">
                <button type="submit" class="btn-orange btn-orange-small btn-block mb-0">@lang('search.placeholder_search')</button>
            </div>
        </div>
    </form>
</div>
<div class="search-result position-static">
<div class="container">
    <div class="row">
        @forelse($result as $category => $projects)
            <div class="search-category col-12">
                <div class="search-category-name">{{trans('search.'.$category)}}</div>
                <ul>
                    @foreach($projects as $project)
                        <li>
                            <a class="search-item" href="{{$project["url"]}}">
                                {{$project["name"]}}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @empty
            @if(empty($error))
            <div class="search-category col">
                <div class="search-category-name">@lang('search.not_found')</div>
            </div>
            @else
                <div class="search-category col">
                    <div class="search-category-name">{{$error}}</div>
                </div>
            @endif
        @endforelse
    </div>
</div>
</div>
@endsection



