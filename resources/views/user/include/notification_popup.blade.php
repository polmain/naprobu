@foreach($notifications as $notification)
<div role="alert" aria-live="assertive" aria-atomic="true" class="toast" data-autohide="false">
    <div class="toast-header">
        @if($notification->isImportant)
        <span class="badge badge-success">&nbsp;&nbsp;</span>
        @endif
        <strong class="mr-auto"></strong>
        <small>{{Carbon::parse($notification->created_at)->format('H:i d.m.Y')}}</small>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="toast-body">
        {{$notification->text}}
    </div>
</div>
@endforeach