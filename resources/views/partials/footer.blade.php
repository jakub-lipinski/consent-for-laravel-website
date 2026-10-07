<footer class="site-footer">
    <div class="footer-brand">
        <a class="brand" href="{{ route('home') }}"><img src="{{ asset('assets/consent-mark.svg') }}" width="40" height="40" alt=""><span>Consent <span class="brand-subtitle">for Laravel</span></span></a>
        <p>Small footprint.<br>Considered choices.</p>
        <span class="eyebrow">Open source / MIT</span>
    </div>
    <nav class="footer-links" aria-label="Footer documentation">
        <span class="eyebrow">Get to know Consent</span>
        <a href="{{ route('docs.show', 'installation') }}">Installation</a>
        <a href="{{ route('docs.show', 'quick-start') }}">Quick start</a>
        <a href="{{ route('docs.show', 'configuration') }}">Configuration</a>
        <a href="{{ route('docs.show', 'roadmap') }}">Roadmap</a>
    </nav>
    <nav class="footer-links" aria-label="Footer project links">
        <span class="eyebrow">Out in the open</span>
        <a href="{{ config('site.repository') }}">Source code <x-icon name="arrow-up-right" /></a>
        <a href="{{ config('site.repository') }}/issues">Issues <x-icon name="arrow-up-right" /></a>
        <a href="{{ config('site.repository') }}/tags">Releases <x-icon name="arrow-up-right" /></a>
        <a href="{{ route('accessibility') }}">Website accessibility</a>
    </nav>
    <div class="footer-bottom"><span>© {{ date('Y') }} Consent for Laravel</span><span>Designed around the choice.</span><a href="#top">Back to top <x-icon name="chevron-up" /></a></div>
</footer>
