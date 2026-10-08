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
        <span class="eyebrow">Project resources</span>
        <a href="{{ config('site.packagist') }}" target="_blank" rel="noopener noreferrer">Package on Packagist <x-icon name="arrow-up-right" /></a>
        <a href="{{ config('site.repository') }}" target="_blank" rel="noopener noreferrer">Source code <x-icon name="arrow-up-right" /></a>
        <a href="{{ config('site.repository') }}/issues" target="_blank" rel="noopener noreferrer">Issues <x-icon name="arrow-up-right" /></a>
        <a href="{{ config('site.repository') }}/releases" target="_blank" rel="noopener noreferrer">Releases <x-icon name="arrow-up-right" /></a>
        <a href="{{ route('accessibility') }}">Website accessibility</a>
    </nav>
    <div class="footer-bottom"><span>© {{ date('Y') }} Consent for Laravel</span><span>Created by <a href="https://lipinskijakub.pl/" target="_blank" rel="noopener noreferrer">Jakub Lipiński</a></span><a href="#top">Back to top <x-icon name="chevron-up" /></a></div>
</footer>
