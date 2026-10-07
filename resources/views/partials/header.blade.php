<header class="site-header">
    <a class="brand" href="{{ route('home') }}" aria-label="Consent for Laravel home">
        <img src="{{ asset('assets/consent-mark.svg') }}" width="40" height="40" alt="">
        <span>Consent <span class="brand-subtitle">for Laravel</span></span>
    </a>
    <nav class="main-nav" aria-label="Main navigation">
        <a href="{{ route('home') }}#principles">The approach</a>
        <a href="{{ route('home') }}#preview">The interface</a>
        <a href="{{ route('docs.index') }}" @if(request()->routeIs('docs.*')) aria-current="page" @endif>Documentation</a>
    </nav>
    <div class="header-actions">
        <button class="search-trigger" type="button" data-search-open hidden aria-label="Search documentation" aria-keyshortcuts="Meta+K Control+K" title="Search documentation (Command or Control + K)" aria-haspopup="dialog" aria-controls="documentation-search"><x-icon name="search" /><span class="search-trigger-label">Search</span></button>
        <a class="github-link" aria-label="GitHub" href="{{ config('site.repository') }}"><x-icon name="github" /><span>GitHub</span></a>
    </div>
</header>
