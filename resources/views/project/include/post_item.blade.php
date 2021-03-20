@foreach($posts as $post)
    <div class="col-md-4 col-sm-6">
        <div>{!! $post->code !!}</div>
    </div>
@endforeach
