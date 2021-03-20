<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{$project->name}}</title>
    <style>

        div.page
        {
            page-break-after: always;
            page-break-inside: avoid;
        }
        table, tr, td, th, tbody, thead, tfoot {
            page-break-inside: avoid !important;
        }
        td,th{
            padding: 5px 10px;
        }

        .review-item{
            padding: 5px;
            border-bottom: 1px solid #333;
        }
        .review-user,.comment-user{
            font-weight: 700;
            margin-bottom: 5px;
        }
        .comment-item{
            padding-left: 20px;
            margin-bottom: 10px;
            page-break-inside: avoid !important;
        }
        .review-image{
            display: inline-block;
            margin-right: 10px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
<h1 style="text-align: center">{{$project->name}}</h1>
@foreach($project->subpages as $subpage)
    @if($subpage->reviews->isNotEmpty())
        <h2 style="text-align: center">Страница <em>{{$subpage->name}}</em></h2>
        <div class="review-list">
            @foreach($subpage->reviews as $review)
                <div class="review-item">
                    <div class="review-user">{{$review->user->name}}</div>
                    <div class="review-text">{{$review->text}}</div>
                    @if($review->images)
                    <div class="review-images">
                        @foreach($review->images as $image)
                            <div class="review-image">
                                @php
                                    $path= public_path().'/uploads/images/reviews/'.$image[0];
                                        $type = pathinfo($path, PATHINFO_EXTENSION);
                                        $data = file_get_contents($path);
                                        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                                @endphp
                                <img src="{{$base64}}" alt="">
                            </div>
                        @endforeach
                    </div>
                    @endif
                    @if($review->comments->isNotEmpty())
                        <h3>Комментарии</h3>
                        <div class="comment-list">
                            @foreach($review->comments as $comment)
                                <div class="comment-item">
                                    <div class="comment-user">{{$comment->user->name}}</div>
                                    <div class="comment-text">{{$comment->text}}</div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
    @php

        set_time_limit ( 900 );
    @endphp
@endforeach
</body>
</html>