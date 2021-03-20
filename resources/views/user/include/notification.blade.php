<div class="notification-item{{($notification->isImportant)?' important':''}}">
    <div class="notification-item-icon">
        @if(isset($notification->type->icon))
            <img src="{{asset('/public/svg/icons/'.$notification->type->icon.'.svg')}}" width="20" height="20" alt="{{$notification->type->name}}">
        @endif
    </div>
    @if(isset($notification->link))
        @php
            $link = $notification->link;
            if(!mb_strpos($link,'naprobu.ua')){
                $link = url('/').$link;
            }
        @endphp
        <a href="{{$link}}" class="notification-item-text">{{$notification->text}}</a>
    @else
        <div class="notification-item-text">{{$notification->text}}</div>
    @endif
</div>