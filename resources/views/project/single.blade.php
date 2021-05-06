@extends('layouts.main')
@section('content')
<section class="breadcrumb-box">
    <div class="container">
        <div class="row">
                {{ Breadcrumbs::render('project_single',($lang !== 'ru')?$project->category->translate->firstWhere('lang', $lang):$project->category,$project) }}
        </div>
    </div>
</section>
<div class="project-page">
    <div class="container">
        <nav class="category-list categories-project ">
            <ul class="row ">
                @foreach($categories as $category)
                    <li class="category-item col-md col-12{{($project->category->id == $category->id?" active":"")}}">
                        <a href="{{route('project.level2',['url' =>  $category->url])}}">{{$category->name}}</a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
    <div class="container">
        <div class="row">
            <div class="d-lg-none sidebar sidebar-project project-mobile-registration col-lg-4 order-lg-2">
                <div class="project-status">
                    <div class="project-status-icon project-status-{{$base->status_id}}">
                        <svg id="icon_новый_проект" data-name="icon новый проект" xmlns="http://www.w3.org/2000/svg" width="50.312" height="56.44" viewBox="0 0 50.312 56.44">
                            <defs>
                                <style>
                                    .cls-1, .cls-5 {
                                        fill: #fff;
                                    }

                                    .cls-1, .cls-4, .cls-6 {
                                        fill-rule: evenodd;
                                    }

                                    .cls-2 {
                                        fill: #e4e4e4;
                                    }

                                    .cls-3 {
                                        fill: #ededed;
                                    }
                                    .cls-6 {
                                        fill: none;
                                        stroke: #052b5f;
                                        stroke-width: 3px;
                                    }
                                </style>
                            </defs>
                            <path id="Прямоугольник_скругл._углы_1" data-name="Прямоугольник, скругл. углы 1" class="cls-1" d="M412.974,1559.06l3.045-3.04a0.775,0.775,0,0,1,1.107,0l3.045,3.04a0.786,0.786,0,0,1,0,1.11l-3.045,3.05a0.793,0.793,0,0,1-1.107,0l-3.045-3.05A0.786,0.786,0,0,1,412.974,1559.06Z" transform="translate(-409.344 -1551.03)"/>
                            <path id="Прямоугольник_скругл._углы_1_копия" data-name="Прямоугольник, скругл. углы 1 копия" class="cls-1" d="M448.337,1559.06l3.045-3.04a0.775,0.775,0,0,1,1.107,0l3.045,3.04a0.788,0.788,0,0,1,0,1.11l-3.045,3.05a0.793,0.793,0,0,1-1.107,0l-3.045-3.05A0.786,0.786,0,0,1,448.337,1559.06Z" transform="translate(-409.344 -1551.03)"/>
                            <ellipse id="Эллипс_2_копия" data-name="Эллипс 2 копия" class="cls-2" cx="24.812" cy="31.22" rx="21.75" ry="21.75"/>
                            <rect id="Прямоугольник_скругл._углы_2" data-name="Прямоугольник, скругл. углы 2" class="cls-5" x="20.625" width="8.594" height="6.22" rx="2" ry="2"/>
                            <path id="Эллипс_1" data-name="Эллипс 1" class="cls-6" d="M434.5,1558.66a23.655,23.655,0,1,1-23.656,23.65A23.654,23.654,0,0,1,434.5,1558.66Z" transform="translate(-409.344 -1551.03)"/>
                        </svg>
                    </div>
                    <div class="status-name">{{$project->status->name}}</div>
                    <div class="status-date">
                        @switch($base->status_id)
                            @case(4)
                            {{ Carbon::parse($base->start_registration_time)->format('d.m.Y')}}
                            @break
                            @case(2)
                            {{ Carbon::parse($base->start_registration_time)->format('d.m.Y')}} - {{ Carbon::parse($project->end_registration_time)->format('d.m.Y')}}
                            @break
                            @case(7)
                            {{ Carbon::parse($base->end_registration_time)->format('d.m.Y')}} - {{ Carbon::parse($project->start_test_time)->format('d.m.Y')}}
                            @break
                            @case(6)
                            {{ Carbon::parse($base->start_test_time)->format('d.m.Y')}} - {{ Carbon::parse($project->start_report_time)->format('d.m.Y')}}
                            @break
                            @case(5)
                            {{ Carbon::parse($base->start_report_time)->format('d.m.Y')}} - {{ Carbon::parse($project->end_project_time)->format('d.m.Y')}}
                            @break
                            @case(1)
                            @case(3)
                            {{ Carbon::parse($base->end_project_time)->format('d.m.Y')}}
                            @break
                        @endswitch
                    </div>

                </div>
                @auth()
                    @if($base->status_id == 2 && empty($projectRequest) && $base->questionnaires->where('type_id',2)->first())
                        <a href="{{route('project.questionnaire',['id'=>$base->questionnaires->where('type_id',2)->first()->id??1])}}" class="questionnaite-link project-sidebar-link">@lang('project.register_project')</a>
                    @endif

                    @if($base->status_id == 5 && isset($projectRequest) && $base->questionnaires->where('type_id',3)->first())
                        @if($projectRequest->status_id == 7)
                            <a href="{{route('project.questionnaire',['id'=>$base->questionnaires->where('type_id',3)->first()->id??1])}}" class="questionnaite-link project-sidebar-link">@lang('project.write_report')</a>
                        @endif
                    @endif
                    @if(isset($projectRequest) && $base->questionnaires->where('type_id',4)->first())

                        @if($projectRequest->status_id == 9)
                            <a href="{{route('project.questionnaire',['id'=>$base->questionnaires->where('type_id',4)->first()->id??1])}}" class="questionnaite-link project-sidebar-link">@lang('project.write_post_report')</a>
                        @endif
                    @endif
                @else
                    @if($base->status_id == 2 && $base->questionnaires->where('type_id',2)->first())
                        <a href="#" class="questionnaite-link project-sidebar-link"  data-toggle="modal" data-target="#login">@lang('project.register_project')</a>
                    @endif

                    @if($base->status_id == 5 && $base->questionnaires->where('type_id',3)->first())
                        <a href="#" class="questionnaite-link project-sidebar-link"  data-toggle="modal" data-target="#login">@lang('project.write_report')</a>
                    @endif
                @endauth
            </div>
            <aside class="sidebar sidebar-project col-lg-4 order-lg-2">
                <div class="d-lg-none sidebar-shower project-sidebar-link">
                    @lang('project.project_name')
                </div>
                <div class="project-status d-none d-lg-block">
                    <div class="project-status-icon project-status-{{$base->status_id}}">
                        <svg id="icon_новый_проект" data-name="icon новый проект" xmlns="http://www.w3.org/2000/svg" width="50.312" height="56.44" viewBox="0 0 50.312 56.44">
                            <defs>
                                <style>
                                    .cls-1, .cls-5 {
                                        fill: #fff;
                                    }

                                    .cls-1, .cls-4, .cls-6 {
                                        fill-rule: evenodd;
                                    }

                                    .cls-2 {
                                        fill: #e4e4e4;
                                    }

                                    .cls-3 {
                                        fill: #ededed;
                                    }
                                    .cls-6 {
                                        fill: none;
                                        stroke: #052b5f;
                                        stroke-width: 3px;
                                    }
                                </style>
                            </defs>
                            <path id="Прямоугольник_скругл._углы_1" data-name="Прямоугольник, скругл. углы 1" class="cls-1" d="M412.974,1559.06l3.045-3.04a0.775,0.775,0,0,1,1.107,0l3.045,3.04a0.786,0.786,0,0,1,0,1.11l-3.045,3.05a0.793,0.793,0,0,1-1.107,0l-3.045-3.05A0.786,0.786,0,0,1,412.974,1559.06Z" transform="translate(-409.344 -1551.03)"/>
                            <path id="Прямоугольник_скругл._углы_1_копия" data-name="Прямоугольник, скругл. углы 1 копия" class="cls-1" d="M448.337,1559.06l3.045-3.04a0.775,0.775,0,0,1,1.107,0l3.045,3.04a0.788,0.788,0,0,1,0,1.11l-3.045,3.05a0.793,0.793,0,0,1-1.107,0l-3.045-3.05A0.786,0.786,0,0,1,448.337,1559.06Z" transform="translate(-409.344 -1551.03)"/>
                            <ellipse id="Эллипс_2_копия" data-name="Эллипс 2 копия" class="cls-2" cx="24.812" cy="31.22" rx="21.75" ry="21.75"/>
                            <rect id="Прямоугольник_скругл._углы_2" data-name="Прямоугольник, скругл. углы 2" class="cls-5" x="20.625" width="8.594" height="6.22" rx="2" ry="2"/>
                            <path id="Эллипс_1" data-name="Эллипс 1" class="cls-6" d="M434.5,1558.66a23.655,23.655,0,1,1-23.656,23.65A23.654,23.654,0,0,1,434.5,1558.66Z" transform="translate(-409.344 -1551.03)"/>
                        </svg>
                    </div>
                    <div class="status-name">{{$project->status->name}}</div>
                    <div class="status-date">
                        @switch($base->status_id)
                            @case(4)
                                {{ Carbon::parse($base->start_registration_time)->format('d.m.Y')}}
                            @break
                            @case(2)
                                {{ Carbon::parse($base->start_registration_time)->format('d.m.Y')}} - {{ Carbon::parse($project->end_registration_time)->format('d.m.Y')}}
                            @break
                            @case(7)
                                {{ Carbon::parse($base->end_registration_time)->format('d.m.Y')}} - {{ Carbon::parse($project->start_test_time)->format('d.m.Y')}}
                            @break
                            @case(6)
                                {{ Carbon::parse($base->start_test_time)->format('d.m.Y')}} - {{ Carbon::parse($project->start_report_time)->format('d.m.Y')}}
                            @break
                            @case(5)
                                {{ Carbon::parse($base->start_report_time)->format('d.m.Y')}} - {{ Carbon::parse($project->end_project_time)->format('d.m.Y')}}
                            @break
                            @case(1)
                            @case(3)
                                {{ Carbon::parse($base->end_project_time)->format('d.m.Y')}}
                            @break
                        @endswitch
                    </div>

                </div>
                @auth()
                    @if($base->status_id == 2 && empty($projectRequest) && $base->questionnaires->where('type_id',2)->first())
                        <a href="{{route('project.questionnaire',['id'=>$base->questionnaires->where('type_id',2)->first()->id??1])}}" class=" d-none d-lg-block questionnaite-link project-sidebar-link">@lang('project.register_project')</a>
                    @endif

                    @if($base->status_id == 5 && isset($projectRequest) && $base->questionnaires->where('type_id',3)->first())
                        @if($projectRequest->status_id == 7)
                        <a href="{{route('project.questionnaire',['id'=>$base->questionnaires->where('type_id',3)->first()->id??1])}}" class=" d-none d-lg-block questionnaite-link project-sidebar-link">@lang('project.write_report')</a>
                        @endif
                    @endif
                    @if(isset($projectRequest) && $base->questionnaires->where('type_id',4)->first())

                        @if($projectRequest->status_id == 9)
                            <a href="{{route('project.questionnaire',['id'=>$base->questionnaires->where('type_id',4)->first()->id??1])}}" class="d-none d-lg-block questionnaite-link project-sidebar-link">@lang('project.write_post_report')</a>
                        @endif
                    @endif
                @else
                    @if($base->status_id == 2 && $base->questionnaires->where('type_id',2)->first())
                        <a href="#" class=" d-none d-lg-block questionnaite-link project-sidebar-link"  data-toggle="modal" data-target="#login">@lang('project.register_project')</a>
                    @endif

                    @if($base->status_id == 5 && $base->questionnaires->where('type_id',3)->first())
                        <a href="#" class=" d-none d-lg-block questionnaite-link project-sidebar-link"  data-toggle="modal" data-target="#login">@lang('project.write_report')</a>
                    @endif
                @endauth

                @foreach($base->links->where('lang',$lang) as $links)
                    <a href="{{$links->link}}" class="project-sidebar-link project-sidebar-link_blue" target="_blank">{{$links->text}}</a>
                @endforeach


                @if($base->subpages->where('type_id',9)->where('lang',$lang)->first())
                    <a href="{{route('project.subpage',[$project->url,$base->subpages->where('type_id',9)->where('lang',$lang)->first()->url])}}" class="project-rules project-sidebar-link">{{$base->subpages->where('type_id',9)->where('lang',$lang)->first()->name}}</a>
                @endif

                @if($base->subpages->where('type_id',7)->where('lang',$lang)->first())
                    <a href="{{route('project.subpage',[$project->url,$base->subpages->where('type_id',7)->where('lang',$lang)->first()->url])}}" class="project-qa project-sidebar-link">{{$base->subpages->where('type_id',7)->where('lang',$lang)->first()->name}}</a>
                @endif

                @if($base->subpages->where('type_id',5)->where('lang',$lang)->first())
                    <a href="{{route('project.subpage',[$project->url,$base->subpages->where('type_id',5)->where('lang',$lang)->first()->url])}}" class="project-members project-sidebar-link">{{$base->subpages->where('type_id',5)->where('lang',$lang)->first()->name}}</a>
                @endif
                @foreach($base->subpages->where('lang',$lang) as $subpage)
                    @if(!in_array($subpage->type_id,[9,7,5,3,15])  )
                        <a href="{{route('project.subpage',[$project->url,$subpage->url])}}" class="project-sidebar-link">{{$subpage->name}}</a>
                    @endif
                @endforeach
                @if(isset($lastPost))
                    <div class="sidebar-block sidebar-project-blog">
                        <div class="sidebar-header">@lang('project.blog_header')</div>
                        <a href="{{route('blog.level2',['url'=>$lastPost->url])}}" class="sidebar-content">
                            <img src="{{($lang == 'ru')?$lastPost->image:$lastPost->base->image}}" alt="{{$lastPost->name}}">
                            <div class="sidebar-title">{{$lastPost->name}}</div>
                        </a>
                        <div class="sidebar-footer">
                            <a href="{{route('blog.level2',[$project->url])}}" class="sidebar-more-link">@lang('project.blog_link')</a>
                        </div>
                    </div>
                @endif
                @foreach($base->subpages->where('lang',$lang) as $subpage)
                    @if( $subpage->type_id == 3 )
                        <div class="sidebar-block sidebar-project-contest">
                            <div class="sidebar-header">Конкурс</div>
                            <a href="{{route('project.subpage',[$project->url,$subpage->url])}}" class="sidebar-content">
                                @if(isset($subpage->image))
                                <img src="{{$subpage->image}}" alt="{{$subpage->name}}">
                                @endif
                                <div class="sidebar-title">{{$subpage->name}}</div>
                            </a>
                            <div class="sidebar-footer">
                                <a href="{{route('project.subpage',[$project->url,$subpage->url])}}" class="sidebar-more-link">@lang('project.contest_rule')</a>
                            </div>
                        </div>
                    @endif
                @endforeach
                @if($base->subpages->where('type_id',15)->where('lang',$lang)->first())
                    <div class="sidebar-block sidebar-project-contest">
                        <div class="sidebar-header">@lang('project.blogger_header')</div>
                        <a href="{{route('project.subpage',[$project->url,$base->subpages->where('type_id',15)->where('lang',$lang)->first()->url])}}" class="sidebar-content">
                            @if(isset($base->subpages->where('type_id',15)->where('lang',$lang)->first()->image))
                                <img src="{{asset($base->subpages->where('type_id',15)->where('lang',$lang)->first()->image)}}" alt="{{$base->subpages->where('type_id',15)->where('lang',$lang)->first()->name}}">
                            @endif
                        </a>
                        <div class="sidebar-footer">
                            <a href="{{route('project.subpage',[$project->url,$base->subpages->where('type_id',15)->where('lang',$lang)->first()->url])}}" class="sidebar-more-link">@lang('project.blogger_link')</a>
                        </div>
                    </div>
                @endif
            </aside>
            <div class="content col-lg-8 order-lg-1">
                <section class="project-header ">

                    <h1>{{$project->name}}</h1>
                    <div class="project-main-img">
                        <img src="{{$project->main_image}}" alt="{{$project->name}}">
                        @if($project->country && $project->audience->isWord())
                            <div class="project-country">
                                <img src="{{$project->country->getFlag()}}" alt="{{$project->country->getName()}}">
                            </div>
                        @endif
                    </div>
                    <div class="share-project">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={!!   urlencode(route('project.level2',['url'=>$project->url])) !!}"
                           onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600');return false;"
                           target="_blank" title="@lang('global.facebook_share')">
                            @lang('global.facebook_share')
                        </a>
                    </div>
                    @if($base->messages->where('isHide',0)->count()>0)
                        <div class="project-message">
                            <h2>@lang('project.project_message')</h2>
                            <div class="project-message-list">
                                @foreach($base->messages->where('isHide',0)->where('lang',$lang) as $message)
                                    <div class="project-message-item">
                                        {{$message->text}}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </section>

                @if($blocks->count()>0)
                    @php
                        $col = 12/$blocks->count();
                    @endphp
                <section class="project-results">
                    <h2>@lang('project.project_result')</h2>
                    <div class="project-results-wrap">
                        <div class="row">
                            @foreach($blocks as $block)
                            <div class="col-lg-{{$col}}">
                                <div class="why-this-interesting-block">
                                    <div class="why-this-interesting-block-number">
                                        <div class="progress" data-percentage="{{  $block->procent }}">
                                <span class="progress-left">
                                    <span class="progress-bar"></span>
                                </span>
                                            <span class="progress-right">
                                    <span class="progress-bar"></span>
                                </span>
                                            <div class="progress-value">{{  $block->procent }}%</div>
                                        </div>
                                    </div>
                                    <div class="why-this-interesting-block-text">
                                        {{  $block->text }}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </section>
                @endif
                <section class="project-text">
                    <div class="project-text-wrap">
                        {!! $project->text !!}
                    </div>
                </section>
                @if($project->product_info)
                    <section class="project-text">
                        <h2>@lang('project.product_info')</h2>
                        <div class="project-text-wrap">
                            {!! $project->product_info !!}
                        </div>
                    </section>
                @endif
                @if($project->faq)
                    <section class="project-text">
                        <h2>@lang('project.faq')</h2>
                        <div class="project-text-wrap">
                            {!! $project->faq !!}
                        </div>
                    </section>
                @endif
                @if($reviews->count()>0)
                    <section class="project-review">
                        <h2>@lang('project.project_review')</h2>
                        <div class="review-list review-page row">
                            @include('review.include.review_item_project_page')
                        </div>
                        <div class="row">
                            <div class="col-xl-4 col-md-6 offset-xl-4 offset-md-3">
                                <a href="{{route('project.subpage',[$project->url, ($lang == "ru")? $reviews->first()->subpage->url : ($reviews->first()->subpage->translate->firstWhere('lang', $lang)? $reviews->first()->subpage->translate->firstWhere('lang', $lang)->url : $reviews->first()->subpage->url)])}}" class="more-link">@lang('project.project_review_all')</a>
                            </div>
                        </div>
                    </section>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    @if($project->audience->isWord() && $lang === 'ru')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <script>
        const googleTranslateConfig = {
            lang: "ru",
        };
        TranslateSetCookie("{{strtolower($project->country->getCode())}}")

        function TranslateInit() {
            // Инициализируем виджет с языком по умолчанию
            new google.translate.TranslateElement({
                pageLanguage: googleTranslateConfig.lang,
            });
        }

        function TranslateGetCode() {
            // Если куки нет, то передаем дефолтный язык
            let lang = ($.cookie('googtrans') != undefined && $.cookie('googtrans') != "null") ? $.cookie('googtrans') : googleTranslateConfig.lang;
            return lang.substr(-2);
        }

        function TranslateClearCookie() {
            $.cookie('googtrans', null);
            $.cookie("googtrans", null, {
                domain: "." + document.domain,
            });
        }

        function TranslateSetCookie(code) {
            // Записываем куки /язык_который_переводим/язык_на_который_переводим
            $.cookie('googtrans', "/auto/" + code);
            $.cookie("googtrans", "/auto/" + code, {
                domain: "." + document.domain,
            });
        }

    </script>
    <script src="//translate.google.com/translate_a/element.js?cb=TranslateInit"></script>
    @endif
@endsection

