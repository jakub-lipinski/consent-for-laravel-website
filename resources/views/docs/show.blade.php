@extends('layouts.site')
@section('title', $page['title'].' - Consent for Laravel')
@section('description', $page['description'])
@section('body')
<div id="top" class="section-rail docs-rail"><span>Field notes / Documentation</span><span>{{ config('site.release') }}</span></div>
<div class="docs-grid">
    <aside class="docs-sidebar" aria-label="Documentation navigation">
        <details open data-doc-navigation>
            <summary>Browse documentation <x-icon name="plus" /></summary>
            <nav aria-label="Documentation chapters">
                @foreach($navigation as $section => $items)
                <div class="docs-nav-group"><h2>{{ $section }}</h2>
                    @foreach($items as $item)
                    <a href="{{ route('docs.show', $item['slug']) }}" @if($page['slug'] === $item['slug']) aria-current="page" @endif>{{ $item['title'] }}</a>
                    @endforeach
                </div>
                @endforeach
            </nav>
            <a class="sidebar-source" href="{{ config('site.packagist') }}" target="_blank" rel="noopener noreferrer">Package on Packagist <x-icon name="arrow-up-right" /></a>
            <a class="sidebar-source" href="{{ config('site.repository') }}" target="_blank" rel="noopener noreferrer">Read the source <x-icon name="arrow-up-right" /></a>
        </details>
    </aside>
    <main id="main-content" tabindex="-1" class="docs-article">
        <div class="docs-title"><span class="eyebrow">{{ $page['section'] }}</span><h1>{{ $page['title'] }}</h1><p>{{ $page['description'] }}</p></div>
        <details class="mobile-toc"><summary>On this page</summary><nav aria-label="Mobile table of contents">@foreach($toc as $heading)<a href="#{{ $heading['id'] }}">{{ $heading['title'] }}</a>@endforeach</nav></details>
        <article class="docs-prose" data-doc-content>{!! $html !!}</article>
        <nav class="page-pagination" aria-label="Documentation page navigation">
            @if($previous)<a href="{{ route('docs.show', $previous['slug']) }}"><span class="eyebrow">Previous chapter</span><strong>{{ $previous['title'] }}</strong><x-icon name="arrow-left" /></a>@else<div></div>@endif
            @if($next)<a href="{{ route('docs.show', $next['slug']) }}"><span class="eyebrow">Next chapter</span><strong>{{ $next['title'] }}</strong><x-icon name="arrow-right" /></a>@endif
        </nav>
        <div class="docs-bottom-note"><span>For {{ config('site.release') }}</span><a href="{{ config('site.website_repository') }}/blob/main/resources/markdown/docs/{{ $page['slug'] }}.md" target="_blank" rel="noopener noreferrer">Improve this page <x-icon name="arrow-up-right" /></a></div>
    </main>
    <aside class="docs-toc" aria-label="On this page"><div class="docs-toc-inner"><span class="eyebrow">On this page</span><nav aria-label="Table of contents">@foreach($toc as $heading)<a href="#{{ $heading['id'] }}" @class(['toc-subheading' => $heading['level'] === 3])>{{ $heading['title'] }}</a>@endforeach</nav><p>One choice.<br>A clear contract.</p></div></aside>
</div>
@endsection
