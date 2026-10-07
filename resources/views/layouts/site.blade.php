<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light">
    <title>@yield('title', 'Consent for Laravel - Every cookie starts with a choice')</title>
    <meta name="description" content="@yield('description', 'Thoughtful cookie consent for Laravel. A customizable banner, clear preferences, and scripts that respect the choice. Open source. PHP 8.3+, Laravel 12-13.')">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Consent for Laravel">
    <meta property="og:title" content="@yield('title', 'Consent for Laravel - Every cookie starts with a choice')">
    <meta property="og:description" content="@yield('description', 'Thoughtful cookie consent for Laravel. Clear preferences, explicit choices, and scripts that respect them.')">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('assets/social-card.png') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('assets/favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <a class="skip-link" href="#main-content">Skip to content</a>
    <div class="site-frame">
        @include('partials.header')
        @yield('body')
        @include('partials.footer')
    </div>
    @include('partials.search')
    <p class="sr-only" role="status" aria-live="polite" aria-atomic="true" data-site-status></p>
</body>
</html>
