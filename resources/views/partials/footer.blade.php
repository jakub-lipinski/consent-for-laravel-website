<footer class="site-footer">
    <div class="footer-brand">
        <a class="brand" href="{{ route('home') }}"><img src="{{ asset('assets/consent-mark.svg') }}?v=2" width="40" height="40" alt=""><span>Consent <span class="brand-subtitle">for Laravel</span></span></a>
        <p>Cookie consent that fits<br>your Laravel workflow.</p>
        <span class="eyebrow">Open source / MIT</span>
    </div>
    <nav class="footer-links" aria-label="Footer documentation">
        <span class="eyebrow">Setup and configuration</span>
        <a href="{{ route('docs.show', 'installation') }}">Installation</a>
        <a href="{{ route('docs.show', 'quick-start') }}">Quick start</a>
        <a href="{{ route('docs.show', 'configuration') }}">Configuration</a>
        <a href="{{ route('docs.show', 'integrations') }}">Included features</a>
    </nav>
    <nav class="footer-links" aria-label="Footer project links">
        <span class="eyebrow">Project on GitHub</span>
        <a href="{{ config('site.repository') }}">Source code <x-icon name="arrow-up-right" /></a>
        <a href="{{ config('site.repository') }}/issues">Issues <x-icon name="arrow-up-right" /></a>
        <a href="{{ config('site.repository') }}/releases">Releases <x-icon name="arrow-up-right" /></a>
        <a href="{{ route('accessibility') }}">Website accessibility</a>
    </nav>
    <div class="footer-bottom"><span>© {{ date('Y') }} Consent for Laravel</span><span>More time for your application.</span><a href="#top">Back to top <x-icon name="chevron-up" /></a></div>
</footer>
