@extends('layouts.site')
@section('title', 'Website accessibility - Consent for Laravel')
@section('description', 'Accessibility features, verification, and reporting for the Consent for Laravel website.')
@section('body')
<div id="top" class="section-rail"><span>Open by design / Accessibility</span><span>Website statement</span></div>
<main id="main-content" tabindex="-1" class="statement">
    <span class="eyebrow">Everyone gets a choice</span><h1>A considered<br>way in.</h1>
    <div class="docs-prose"><p>This website is designed around the applicable WCAG 2.2 A and AA requirements. Accessibility is part of its structure, controls, and visual system.</p>
    <h2>Using this website</h2><ul><li>A skip link takes keyboard users straight to the main content.</li><li>Navigation, search, code copying, and the interface preview work from the keyboard.</li><li>Search and preview dialogs support Escape and return focus to their opener.</li><li>Text can be enlarged and spacing changed. Narrow layouts reflow without requiring page-wide horizontal scrolling.</li><li>Focus indicators, control borders, and text colors have sufficient contrast. We respect reduced motion and forced colors.</li><li>The site works without JavaScript; documentation and navigation remain available.</li></ul>
    <h2>Scope and verification</h2><p>Automated checks and native browser review cover the website's main layouts and interactions. They complement manual assessment. An automated result alone does not certify every experience with every browser or assistive technology.</p><p>The cookie interface preview is an illustration. It does not load analytics or advertising tools, set consent cookies, or change a real website's preferences.</p>
    <h2>Tell us what gets in the way</h2><p><a href="{{ config('site.website_repository') }}/issues" target="_blank" rel="noopener noreferrer">Report a website accessibility issue on GitHub</a>. Include the page, what you tried, what happened, and the browser or assistive technology you used. You can also <a href="{{ config('site.website_repository') }}" target="_blank" rel="noopener noreferrer">browse the source</a>.</p>
    <h2>The package interface</h2><p>The package's banner has its own integration responsibilities. Read <a href="{{ route('docs.show', 'accessibility') }}">the package accessibility guide</a> before adapting it to your application.</p></div>
</main>
@endsection
