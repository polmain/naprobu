
@forelse($result as $category => $projects)
    <div class="search-category col">
    <div class="search-category-name">{{trans('search.'.$category)}}</div>
    <ul>
    @foreach($projects as $project)
        <li>
            <a class="search-item" href="{{$project["url"]}}">
                {{$project["text"]}}
            </a>
        </li>
    @endforeach
    </ul>
    </div>
@empty
    <div class="search-category col">
        <div class="search-category-name">@lang('search.not_found')</div>
    </div>
@endforelse