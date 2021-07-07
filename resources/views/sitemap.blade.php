<?php
echo '<?xml version="1.0"?>';
?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
    <url>
        <loc>{{ route('home') }}</loc>
        <xhtml:link rel="alternate" hreflang="uk" href="{{route('home')}}"/>
        <xhtml:link rel="alternate" hreflang="ru" href="{{route('home').'ru/'}}"/>
        <xhtml:link rel="alternate" hreflang="en" href="{{route('home').'en/'}}"/>
        <lastmod>{{ \App\Model\Page::where([
			['url','/'],
			['lang','ru'],
		])->first()->updated_at->tz('GMT+3')->toAtomString() }}</lastmod>
        <priority>1</priority>
    </url>
    <url>
        <loc>{{ route('about') }}</loc>
        <xhtml:link rel="alternate" hreflang="uk" href="{{route('about')}}"/>
        <xhtml:link rel="alternate" hreflang="ru" href="{{route('home').'ru/about/'}}"/>
        <xhtml:link rel="alternate" hreflang="en" href="{{route('home').'en/about/'}}"/>
        <lastmod>{{ \App\Model\Page::where([
			['url','about'],
			['lang','ru'],
		])->first()->updated_at->tz('GMT+3')->toAtomString() }}</lastmod>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>{{ route('faq') }}</loc>
        <xhtml:link rel="alternate" hreflang="uk" href="{{route('faq')}}"/>
        <xhtml:link rel="alternate" hreflang="ru" href="{{route('home').'ru/faq/'}}"/>
        <xhtml:link rel="alternate" hreflang="en" href="{{route('home').'en/faq/'}}"/>
        <lastmod>{{ \App\Model\Page::where([
			['url','faq'],
			['lang','ru'],
		])->first()->updated_at->tz('GMT+3')->toAtomString() }}</lastmod>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>{{ route('contact') }}</loc>
        <xhtml:link rel="alternate" hreflang="uk" href="{{route('contact')}}"/>
        <xhtml:link rel="alternate" hreflang="ru" href="{{route('home').'ru/contact/'}}"/>
        <xhtml:link rel="alternate" hreflang="en" href="{{route('home').'en/contact/'}}"/>
        <lastmod>{{ \App\Model\Page::where([
			['url','contact'],
			['lang','ru'],
		])->first()->updated_at->tz('GMT+3')->toAtomString() }}</lastmod>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ route('partner') }}</loc>
        <xhtml:link rel="alternate" hreflang="uk" href="{{route('partner')}}"/>
        <xhtml:link rel="alternate" hreflang="ru" href="{{route('home').'ru/partner/'}}"/>
        <xhtml:link rel="alternate" hreflang="en" href="{{route('home').'en/partner/'}}"/>
        <lastmod>{{ \App\Model\Page::where([
			['url','partner'],
			['lang','ru'],
		])->first()->updated_at->tz('GMT+3')->toAtomString() }}</lastmod>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>{{ route('project') }}</loc>
        <xhtml:link rel="alternate" hreflang="uk" href="{{route('project')}}"/>
        <xhtml:link rel="alternate" hreflang="ru" href="{{route('home').'ru/project/'}}"/>
        <xhtml:link rel="alternate" hreflang="en" href="{{route('home').'en/project/'}}"/>
        <lastmod>{{ \App\Model\Page::where([
			['url','projects'],
			['lang','ru'],
		])->first()->updated_at->tz('GMT+3')->toAtomString() }}</lastmod>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>{{ route('review') }}</loc>
        <xhtml:link rel="alternate" hreflang="uk" href="{{route('review')}}"/>
        <xhtml:link rel="alternate" hreflang="ru" href="{{route('home').'ru/review/'}}"/>
        <xhtml:link rel="alternate" hreflang="en" href="{{route('home').'en/review/'}}"/>
        <lastmod>{{ \App\Model\Page::where([
			['url','reviews'],
			['lang','ru'],
		])->first()->updated_at->tz('GMT+3')->toAtomString() }}</lastmod>
        <priority>0.9</priority>
    </url>
    <url>
        <loc>{{ route('blog') }}</loc>
        <xhtml:link rel="alternate" hreflang="uk" href="{{route('blog')}}"/>
        <xhtml:link rel="alternate" hreflang="ru" href="{{route('home').'ru/blog/'}}"/>
        <xhtml:link rel="alternate" hreflang="en" href="{{route('home').'en/blog/'}}"/>
        <lastmod>{{ \App\Model\Page::where([
			['url','blog'],
			['lang','ru'],
		])->first()->updated_at->tz('GMT+3')->toAtomString() }}</lastmod>
        <priority>0.8</priority>
    </url>
    <url>
        <loc>{{ route('archive') }}</loc>
        <xhtml:link rel="alternate" hreflang="uk" href="{{route('archive')}}"/>
        <xhtml:link rel="alternate" hreflang="ru" href="{{route('home').'ru/archive/'}}"/>
        <xhtml:link rel="alternate" hreflang="en" href="{{route('home').'en/archive/'}}"/>
        <lastmod>{{ \App\Model\Page::where([
			['url','archive'],
			['lang','ru'],
		])->first()->updated_at->tz('GMT+3')->toAtomString() }}</lastmod>
        <priority>0.7</priority>
    </url>
    <url>
        <loc>{{ route('registration') }}</loc>
        <xhtml:link rel="alternate" hreflang="uk" href="{{route('registration')}}"/>
        <xhtml:link rel="alternate" hreflang="ru" href="{{route('home').'ru/registration/'}}"/>
        <xhtml:link rel="alternate" hreflang="en" href="{{route('home').'en/registration/'}}"/>
        <lastmod>{{ \App\Model\Page::where([
			['url','registration'],
			['lang','ru'],
		])->first()->updated_at->tz('GMT+3')->toAtomString() }}</lastmod>
        <priority>0.9</priority>
    </url>
    @foreach ($categories as $category)
        <url>
            @php
                $catgoryUA = $category->translate->firstWhere('lang','ua');
                $catgoryEN = $category->translate->firstWhere('lang','en');
            @endphp
            @if($catgoryUA)
            <loc>{{ route('project.level2',[$catgoryUA->url]) }}</loc>
            @else
            <loc>{{ route('project.level2',[$category->url]) }}</loc>
            @endif
            @if($catgoryUA)
            <xhtml:link rel="alternate" hreflang="uk" href="{{route('project.level2',[$catgoryUA->url])}}"/>
            @endif
            <xhtml:link rel="alternate" hreflang="ru" href="{{route('home').'ru/project/'.$category->url.'/'}}"/>
            @if($catgoryEN)
            <xhtml:link rel="alternate" hreflang="en" href="{{route('home').'en/project/'.$catgoryEN->url.'/'}}"/>
            @endif
            <lastmod>{{ $category->updated_at->tz('GMT+3')->toAtomString() }}</lastmod>
            <priority>0.9</priority>
        </url>
    @endforeach
    @foreach ($projects as $project)
        <url>
            @php
                $projectUA = $project->translate->firstWhere('lang','ua');
                $projectEN = $project->translate->firstWhere('lang','en');
            @endphp
            @if($projectUA)
                <loc>{{ route('project.level2',[$projectUA->url]) }}</loc>
            @else
                <loc>{{ route('project.level2',[$project->url]) }}</loc>
            @endif
            @if($projectUA)
            <xhtml:link rel="alternate" hreflang="uk" href="{{route('project.level2',[$projectUA->url])}}"/>
            @endif
            <xhtml:link rel="alternate" hreflang="ru" href="{{route('home').'ru/project/'.$project->url.'/'}}"/>
            @if($projectEN)
            <xhtml:link rel="alternate" hreflang="en" href="{{route('home').'en/project/'.$projectEN->url.'/'}}"/>
            @endif
            <lastmod>{{ $project->updated_at->tz('GMT+3')->toAtomString() }}</lastmod>
            <priority>0.8</priority>
        </url>
        @foreach ($project->subpages as $subpage)
        <url>
            @php
                $subpageUA = $subpage->translate->firstWhere('lang','ua');
                $subpageEN = $subpage->translate->firstWhere('lang','en');
            @endphp
            @if($projectUA && $subpageUA)
                <loc>{{ route('project.subpage',[$projectUA->url,$subpageUA->url]) }}</loc>
            @else
                <loc>{{ route('project.subpage',[$project->url,$subpage->url]) }}</loc>
            @endif
            @if($projectUA && $subpageUA)
            <xhtml:link rel="alternate" hreflang="uk" href="{{route('project.subpage',[$projectUA->url,$subpageUA->url])}}"/>
            @endif
            <xhtml:link rel="alternate" hreflang="ru" href="{{route('home').'ru/project/'.$project->url.'/',$subpage->url.'/'}}"/>
            @if($projectEN && $subpageEN)
            <xhtml:link rel="alternate" hreflang="en" href="{{route('home').'en/project/'.$projectEN->url.'/',$subpageEN->url.'/'}}"/>
            @endif
            <lastmod>{{ $subpage->updated_at->tz('GMT+3')->toAtomString() }}</lastmod>
            <priority>0.7</priority>
        </url>
        @endforeach
    @endforeach
    @foreach ($categories as $category)
        <url>
            @php
                $categoryUA = $category->translate->firstWhere('lang','ua');
                $categoryEN = $category->translate->firstWhere('lang','en');
            @endphp
            @if($categoryUA)
                <loc>{{ route('blog.level2',[$categoryUA->url]) }}</loc>
            @else
                <loc>{{ route('blog.level2',[$category->url]) }}</loc>
            @endif
            @if($categoryUA)
            <xhtml:link rel="alternate" hreflang="uk" href="{{route('blog.level2',[$categoryUA->url])}}"/>
            @endif
            <xhtml:link rel="alternate" hreflang="ru" href="{{route('home').'ru/blog/'.$category->url.'/'}}"/>
            @if($categoryEN)
            <xhtml:link rel="alternate" hreflang="en" href="{{route('home').'en/blog/'.$categoryEN->url.'/'}}"/>
            @endif
            <lastmod>{{ $category->updated_at->tz('GMT+3')->toAtomString() }}</lastmod>
            <priority>0.9</priority>
        </url>
    @endforeach
    @foreach ($posts as $post)
        <url>
            @php
                $postUA = $post->translate->firstWhere('lang','ua');
                $postEN = $post->translate->firstWhere('lang','en');
            @endphp
            @if($postUA)
                <loc>{{ route('blog.level2',[$postUA->url]) }}</loc>
            @else
                <loc>{{ route('blog.level2',[$post->url]) }}</loc>
            @endif
            @if($postUA)
            <xhtml:link rel="alternate" hreflang="uk" href="{{route('blog.level2',[$postUA->url])}}"/>
            @endif
            <xhtml:link rel="alternate" hreflang="ru" href="{{route('home').'ru/blog/'.$post->url.'/'}}"/>
            @if($postEN)
            <xhtml:link rel="alternate" hreflang="en" href="{{route('home').'en/blog/'.$postEN->url.'/'}}"/>
            @endif
            <lastmod>{{ $post->updated_at->tz('GMT+3')->toAtomString() }}</lastmod>
            <priority>0.7</priority>
        </url>
    @endforeach

    @foreach ($categories as $category)
        <url>
            @php
                $categoryUA = $category->translate->firstWhere('lang','ua');
                $categoryEN = $category->translate->firstWhere('lang','en');
            @endphp
            @if($categoryUA)
                <loc>{{ route('review.level2',[$categoryUA->url]) }}</loc>
            @else
                <loc>{{ route('review.level2',[$category->url]) }}</loc>
            @endif
            @if($categoryUA)
            <xhtml:link rel="alternate" hreflang="uk" href="{{route('review.level2',[$categoryUA->url])}}"/>
            @endif
            <xhtml:link rel="alternate" hreflang="ru" href="{{route('home').'ru/review/'.$category->url.'/'}}"/>
            @if($categoryEN)
                <xhtml:link rel="alternate" hreflang="en" href="{{route('home').'en/review/'.$categoryEN->url.'/'}}"/>
            @endif
            <lastmod>{{ $category->updated_at->tz('GMT+3')->toAtomString() }}</lastmod>
            <priority>0.9</priority>
        </url>
    @endforeach
</urlset>
