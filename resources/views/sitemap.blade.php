<?php
echo '<?xml version="1.0"?>';
?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
    <url>
        <loc>{{ route('home') }}</loc>
        <xhtml:link rel="alternate" hreflang="uk" href="{{route('home')}}"/>
        <xhtml:link rel="alternate" hreflang="ru" href="{{route('home').'ru/'}}"/>
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
        <lastmod>{{ \App\Model\Page::where([
			['url','registration'],
			['lang','ru'],
		])->first()->updated_at->tz('GMT+3')->toAtomString() }}</lastmod>
        <priority>0.9</priority>
    </url>
    @foreach ($categories as $category)
        <url>
            <loc>{{ route('project.level2',[$category->translate->url]) }}</loc>
            <xhtml:link rel="alternate" hreflang="uk" href="{{route('project.level2',[$category->translate->url])}}"/>
            <xhtml:link rel="alternate" hreflang="ru" href="{{route('home').'ru/project/'.$category->url.'/'}}"/>
            <lastmod>{{ $category->updated_at->tz('GMT+3')->toAtomString() }}</lastmod>
            <priority>0.9</priority>
        </url>
    @endforeach
    @foreach ($projects as $project)
        <url>
            <loc>{{ route('project.level2',[$project->translate->url]) }}</loc>
            <xhtml:link rel="alternate" hreflang="uk" href="{{route('project.level2',[$project->translate->url])}}"/>
            <xhtml:link rel="alternate" hreflang="ru" href="{{route('home').'ru/project/'.$project->url.'/'}}"/>
            <lastmod>{{ $project->updated_at->tz('GMT+3')->toAtomString() }}</lastmod>
            <priority>0.8</priority>
        </url>
        @foreach ($project->subpages as $subpage)
            @if(isset($subpage->translate))
            <url>
                <loc>{{ route('project.subpage',[$project->translate->url,$subpage->translate->url]) }}</loc>
                <xhtml:link rel="alternate" hreflang="uk" href="{{route('project.subpage',[$project->translate->url,$subpage->translate->url])}}"/>
                <xhtml:link rel="alternate" hreflang="ru" href="{{route('home').'ru/project/'.$project->url.'/',$subpage->url.'/'}}"/>
                <lastmod>{{ $subpage->updated_at->tz('GMT+3')->toAtomString() }}</lastmod>
                <priority>0.7</priority>
            </url>
            @endif
        @endforeach
    @endforeach
    @foreach ($categories as $category)
        <url>
            <loc>{{ route('blog.level2',[$category->translate->url]) }}</loc>
            <xhtml:link rel="alternate" hreflang="uk" href="{{route('blog.level2',[$category->translate->url])}}"/>
            <xhtml:link rel="alternate" hreflang="ru" href="{{route('home').'ru/'.$category->url.'/'}}"/>
            <lastmod>{{ $category->updated_at->tz('GMT+3')->toAtomString() }}</lastmod>
            <priority>0.9</priority>
        </url>
    @endforeach
    @foreach ($posts as $post)
        <url>
            <loc>{{ route('blog.level2',[$post->translate->url]) }}</loc>
            <xhtml:link rel="alternate" hreflang="uk" href="{{route('blog.level2',[$post->translate->url])}}"/>
            <xhtml:link rel="alternate" hreflang="ru" href="{{route('home').'ru/blog/'.$post->url.'/'}}"/>
            <lastmod>{{ $post->updated_at->tz('GMT+3')->toAtomString() }}</lastmod>
            <priority>0.7</priority>
        </url>
    @endforeach

    @foreach ($categories as $category)
        <url>
            <loc>{{ route('review.level2',[$category->translate->url]) }}</loc>
            <xhtml:link rel="alternate" hreflang="uk" href="{{route('review.level2',[$category->translate->url])}}"/>
            <xhtml:link rel="alternate" hreflang="ru" href="{{route('home').'ru/review/'.$category->url.'/'}}"/>
            <lastmod>{{ $category->updated_at->tz('GMT+3')->toAtomString() }}</lastmod>
            <priority>0.9</priority>
        </url>
    @endforeach
</urlset>