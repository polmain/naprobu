<ul>
@foreach($items as $item)
    <li class="{{($item->hasChildren())?'parent-menu-item':''}}{{($item->isActive)?' active':''}}">
        <a href="{!! $item->url() !!}">{!! $item->title !!} </a>
        @if($item->hasChildren())
            <div class="child-menu-shower"></div>
            <ul class="child-menu">
                @include('include.header_menu', ['items' => $item->children()])
            </ul>
        @endif
    </li>
@endforeach
</ul>