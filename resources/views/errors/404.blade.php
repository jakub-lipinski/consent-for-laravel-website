@extends('layouts.site')
@section('title', 'Page not found - Consent for Laravel')
@section('description', 'Find your way back to the Consent for Laravel documentation.')
@section('body')
<div id="top" class="section-rail"><span>Field notes / 404</span><span>A small detour</span></div>
<main id="main-content" tabindex="-1" class="statement">
    <span class="eyebrow">Page not found</span><h1>A little<br><em>off the path.</em></h1>
    <p>This page does not exist. The documentation is a good place to find your next step.</p>
    <div class="button-row"><a class="button button-primary" href="{{ route('docs.index') }}">Open documentation <x-icon name="arrow-right" /></a><a class="button button-outline" href="{{ route('home') }}">Back to the beginning</a></div>
</main>
@endsection
