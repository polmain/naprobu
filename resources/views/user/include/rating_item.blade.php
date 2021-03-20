@foreach($userRatings as $userRating)
    <div class="rating-history-item">
        <div class="rating-history-item-name">
            @if(App::getLocale() == "ru")
                {{$userRating->rating_action->name}}
            @else
                {{$userRating->rating_action->translate->name}}
            @endif
        </div>
        <div class="rating-history-item-point">
            @if($userRating->rating_action->points>0)+@endif {{$userRating->rating_action->points}} {{Lang::choice('user.rating_point',$userRating->rating_action->points)}}
        </div>
    </div>
@endforeach