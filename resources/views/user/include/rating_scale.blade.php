@php($maxPrev = 0)
@foreach($ratingStatuses as $ratingStatus)
    <div class="col-sm rating-item{{(Auth::user()->rang_id >= $ratingStatus->id)?" active":""}}">
        @if($ratingStatus->max <= 10000)
            <div class="rating-range">{{$ratingStatus->min}}-{{$ratingStatus->max}}<br>@if($ratingStatus->min_projects > 0)
                    @lang('user.menu_project'): {{$ratingStatus->min_projects}}+@else &nbsp;@endif</div>
        @else
            <div class="rating-range">{{$ratingStatus->min}}+<br>@if($ratingStatus->min_projects > 0) @lang('user.menu_project'): {{$ratingStatus->min_projects}}+@endif</div>
        @endif
        <div class="rating-icon"></div>
        <div class="rating-progress-bar">
            @if(Auth::user()->current_rating >= $ratingStatus->min)
                <div class="rating-progress-bar-active" style="width: 100%"></div>
            @elseif(Auth::user()->current_rating > $maxPrev)
                <div class="rating-progress-bar-active" style="width: {{(Auth::user()->current_rating - $maxPrev) / ($ratingStatus->min - $maxPrev) * 100 }}%"></div>
            @else
                <div class="rating-progress-bar-active"></div>
            @endif
            @php($maxPrev = $ratingStatus->min)
            @if($ratingStatus->id >= 7)
                @if(Auth::user()->rang_id >= 7)
                    @if( $present = Auth::user()->presents->where('rang_id',$ratingStatus->id)->first())
                        @if(!$present->isGet)
                            <div data-toggle="tooltip" data-placement="top" title="Получить подарок" present-id="{{$present->id}}" role-name="{{(App::getLocale() == 'ru')?$ratingStatus->name:$ratingStatus->translate->name}}" class="present active"></div>
                        @endif
                        @else
                            <div class="present"></div>
                    @endif
                @else
                    <div class="present"></div>
                @endif
            @endif
        </div>
        @if(App::getLocale() == 'ru')
            <div class="rating-title">{{$ratingStatus->name}}</div>
        @else
            <div class="rating-title">{{$ratingStatus->translate->firstWhere('lang', App::getLocale())->name}}</div>
        @endif
    </div>
@endforeach

<div class="modal fade" id="present_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('user.congratulation')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <img src="{{asset('public/svg/icons/cross.svg')}}" alt="Cross">
                </button>
            </div>
            <div class="modal-body">
                <div class="col text">
                    @lang('user.present_text')
                </div>
            </div>
        </div>
    </div>
</div>
