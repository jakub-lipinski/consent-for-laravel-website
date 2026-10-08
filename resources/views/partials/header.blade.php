<header class="site-header">
    <a class="brand" href="{{ route('home') }}" aria-label="Consent for Laravel home">
        <img src="{{ asset('assets/consent-mark.svg') }}?v=2" width="40" height="40" alt="">
        <span>Consent <span class="brand-subtitle">for Laravel</span></span>
    </a>
    <nav class="main-nav" aria-label="Main navigation">
        <x-navigation-links />
    </nav>
    <div class="header-actions">
        <details class="mobile-navigation" data-mobile-navigation>
            <summary class="menu-trigger" aria-label="Main navigation" aria-controls="mobile-site-navigation" title="Menu"><x-icon name="menu" class="menu-open-icon" /><x-icon name="close" class="menu-close-icon" /></summary>
            <nav id="mobile-site-navigation" class="mobile-nav-panel" aria-label="Mobile navigation">
                <x-navigation-links />
            </nav>
        </details>
        <button class="search-trigger" type="button" data-search-open hidden aria-label="Search documentation" aria-keyshortcuts="Meta+K Control+K" title="Search documentation (Command or Control + K)" aria-haspopup="dialog" aria-controls="documentation-search"><x-icon name="search" /><span class="search-trigger-label">Search</span></button>
        <a class="github-link" aria-label="GitHub" href="{{ config('site.repository') }}" target="_blank" rel="noopener noreferrer"><x-github-mark /><span>GitHub</span></a>
    </div>
</header>
