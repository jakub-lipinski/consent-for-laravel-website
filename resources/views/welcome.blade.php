@extends('layouts.site')
@section('title', 'Consent for Laravel - Less cookie setup. More building.')
@section('description', 'Add two Blade components, enable a preset, and enter your tracking IDs. Consent for Laravel handles the banner, preferences, and consent-aware loading for GA4, Google Ads, Meta Pixel, and Clarity.')
@section('body')
<main id="main-content" tabindex="-1">
    <div id="top" class="section-rail"><span>Cookie consent for Laravel</span><a href="{{ config('site.repository') }}/releases/tag/{{ config('site.release') }}">{{ config('site.release') }} <x-icon name="arrow-up" /></a></div>
    <section class="hero" aria-labelledby="hero-title">
        <div class="hero-copy">
            <div class="release-label"><span class="status-dot" aria-hidden="true"></span> Built for Laravel developers</div>
            <h1 id="hero-title">Less cookie setup.<br><span class="text-accent">More building.</span></h1>
            <p class="hero-description">Add two Blade components, enable a tracking preset, and enter your GA4 or Meta Pixel ID. Consent for Laravel handles the banner, preferences, and consent-aware script loading.</p>
            <div class="button-row"><a class="button button-primary" href="{{ route('docs.show', 'quick-start') }}">Install the package <x-icon name="arrow-right" /></a><a class="button button-outline" href="{{ route('docs.show', 'introduction') }}">Read the docs</a></div>
            <div class="hero-install" data-install-command>
                <span class="hero-install-label">Install with Composer</span>
                <div class="hero-install-row">
                    <code data-install-code>composer require {{ config('site.package') }}</code>
                    <button class="hero-install-copy" type="button" aria-label="Copy installation command" data-install-copy hidden>
                        <x-icon name="copy" /><span data-install-copy-label>Copy</span>
                    </button>
                </div>
            </div>
            <p class="hero-note">Open source. MIT licensed. Built for PHP 8.3+ and Laravel 12-13.</p>
        </div>
        <div class="hero-art"><img class="permission-study" src="{{ asset('assets/consent-architecture.svg') }}" width="760" height="660" alt="Isometric Laravel app with cookie preferences connected to Consent. Analytics is enabled and running; marketing is disabled and paused."><div class="art-caption"><span>Consent-aware tracking.</span></div></div>
    </section>
    <div class="spec-strip" aria-label="Package essentials"><span><b>PHP</b><span class="spec-separator" aria-hidden="true"></span> 8.3+</span><span><b>Laravel</b><span class="spec-separator" aria-hidden="true"></span> 12-13</span><span><b>Browser</b><span class="spec-separator" aria-hidden="true"></span> No frontend framework</span><a href="{{ config('site.repository') }}/blob/main/LICENSE.md"><b>License</b><span class="spec-separator" aria-hidden="true"></span> MIT <x-icon name="arrow-up" /></a></div>
    <section id="setup" class="developer-section" aria-labelledby="developer-title">
        <div class="section-rail"><span>01 / The setup</span><span>Two components. Your tracking ID.</span></div>
        <div class="developer-grid">
            <div>
                <span class="eyebrow">Google Analytics, without the wiring</span>
                <h2 id="developer-title">Your GA4 ID.<br><span class="text-accent">Consent handled.</span></h2>
                <p>Install the package and publish its config. Set <code>presets.ga4.enabled</code> to <code>true</code> in <code>config/consent.php</code>, then add your measurement ID and the two Blade components.</p>
                <p>The package loads the Google tag and updates Consent Mode v2. No separate GA4 snippet or manual consent checks needed.</p>
                <a class="button button-accent" href="{{ route('docs.show', 'google-presets') }}">Set up GA4 <x-icon name="arrow-right" /></a>
            </div>
            <div class="code-example">
                <div class="code-title"><span>.env</span><span>GA4 preset enabled</span></div>
                <pre><code class="language-dotenv">CONSENT_GA4_ID=G-XXXXXXXXXX</code></pre>
                <p><span class="status-dot" aria-hidden="true"></span> In the default Basic mode, GA4 waits for analytics consent.</p>
                <div class="code-title"><span>Your Blade layout</span><span>Blade</span></div>
                <pre><code class="language-blade">@verbatim&lt;head&gt;
    &lt;x-consent::head /&gt;
&lt;/head&gt;

&lt;!-- Before the closing body tag --&gt;
&lt;x-consent::banner /&gt;@endverbatim</code></pre>
            </div>
        </div>
    </section>
    <section id="integrations" class="numbered-section" aria-labelledby="integrations-title">
        <div class="section-rail"><span>02 / The integrations</span><span>Add IDs. Skip the custom consent logic.</span></div>
        <div class="section-intro"><h2 id="integrations-title">Bring your tools.<br><span class="text-accent">Skip the wiring.</span></h2><p>Connecting a tracker usually means adding tags, checking consent, and handling changed choices. Enable a built-in preset and supply its ID; the package takes care of that consent logic.</p></div>
        <div class="release-grid">
            <div class="release-current">
                <span class="eyebrow">Included in version 1.1</span>
                <h3>Four built-in integrations</h3>
                <ul>
                    <li><x-icon name="arrow-down-right" />GA4 and Google Ads setup from your IDs</li>
                    <li><x-icon name="arrow-down-right" />Google Consent Mode v2 with Basic and Advanced</li>
                    <li><x-icon name="arrow-down-right" />Meta Pixel and Microsoft Clarity presets</li>
                </ul>
                <a href="{{ route('docs.show', 'integrations') }}">Explore the integrations <x-icon name="arrow-up" /></a>
            </div>
            <div class="release-planned">
                <span class="eyebrow">Consent throughout the lifecycle</span>
                <div><strong>Loading follows the choice</strong><span>GA4 and Clarity use analytics consent; Ads and Meta use marketing. Google Basic waits for permission.</span></div>
                <div><strong>Consent checks are built in</strong><span>Use the event helpers to check permission before sending events. Your app supplies the events and conversion details.</span></div>
                <div><strong>Withdrawal is already handled</strong><span>The presets apply denied signals, clear declared cookies, and reload when an active tracker needs to stop.</span></div>
                <a href="{{ route('docs.show', 'google-consent-mode') }}">Understand Basic and Advanced <x-icon name="arrow-up" /></a>
            </div>
        </div>
    </section>
    <section id="principles" class="numbered-section" aria-labelledby="principles-title">
        <div class="section-rail"><span>03 / The approach</span><span>Less work on every project</span></div>
        <div class="section-intro"><h2 id="principles-title">A banner is only<br><span class="text-accent">the beginning</span></h2><p>Saving a choice, blocking scripts, and handling withdrawal all need code. Use one ready-made consent flow and spend that time on your application's features.</p></div>
        <div class="principle-grid">
            @foreach([
                ['choice', 'Skip the UI build', 'Start with a complete banner and preferences screen. Choose Standard or Compact, then adjust the colors, position, and wording to match your app.'],
                ['code', 'Your scripts, too', 'Register a custom service and wrap its script in the consent Blade directive. Reuse the same consent checks instead of writing another loader.'],
                ['layers', 'One cached page', 'Serve the same cached HTML to everyone. Consent is checked in the browser, so you do not need a page variant for each consent choice.'],
                ['refresh', 'No second settings flow', 'Visitors can reopen preferences and withdraw consent. The package remembers their choices and applies changes, including a reload when active trackers require it.'],
                ['keyboard', 'Focus handled for you', 'Native controls, keyboard navigation, and focus management are already built. Keep your frontend work focused on the rest of your app.'],
                ['globe', 'Translations ready', 'English and Polish interface copy and preset descriptions are included. Adapt the wording to your site without translating everything from scratch.'],
            ] as $index => [$icon, $title, $description])
            <div class="principle"><div class="principle-top"><x-icon :name="$icon" /><span>0{{ $index + 1 }}</span></div><h3>{{ $title }}</h3><p>{{ $description }}</p></div>
            @endforeach
        </div>
    </section>
    <section id="preview" class="numbered-section" aria-labelledby="preview-title">
        <div class="section-rail"><span>04 / The interface</span><span>Adapt it to your project</span></div>
        <div class="section-intro"><h2 id="preview-title">Ready to use.<br><span class="text-accent">Easy to make yours.</span></h2><p>Choose Standard or Compact for the banner and preferences. Match the position, colors, and wording to your app. No Tailwind, Alpine, or Livewire required. Try the banner and preferences below; this preview stores no cookies and loads no trackers.</p></div>
        @include('partials.consent-preview')
    </section>
    <section class="numbered-section guide-section" aria-labelledby="guides-title"><div class="section-rail"><span>05 / Getting started</span><span>A clear path from install to launch</span></div><div class="guide-heading"><h2 id="guides-title">Make consent part<br><span class="text-accent">of your next app</span></h2><a class="text-link" href="{{ route('docs.index') }}">Browse the docs <x-icon name="arrow-right" /></a></div><div class="guide-grid">@foreach([['01', 'quick-start', 'Install and add the UI', 'Install with Composer, publish the config, and add the two Blade components. Follow the quick start for your first working consent flow.'], ['02', 'banner-and-theme', 'Match your design', 'Choose a matching banner and preferences variant, set the position and colors, and link your privacy policy. Keep the consent interface consistent with your app.'], ['03', 'withdrawal', 'Check withdrawal', 'Review how active scripts stop and declared cookies are cleared, then check the behavior with your actual tracking setup.']] as [$number, $slug, $title, $description])<a class="guide-card" href="{{ route('docs.show', $slug) }}"><span class="eyebrow">Guide / {{ $number }}</span><h3>{{ $title }}</h3><p>{{ $description }}</p><x-icon name="arrow-up" /></a>@endforeach</div></section>
    <section class="faq-section" aria-labelledby="faq-title">
        <div><span class="eyebrow">Questions before you install</span><h2 id="faq-title">Before your<br> <span class="text-accent">first install</span></h2></div>
        <div class="faq-list">
            <details><summary>Will it fit my Laravel project?<x-icon name="plus" /></summary><p>Consent supports PHP 8.3+ and Laravel 12-13. It runs in your app without Tailwind, Alpine, Livewire, a database, or an npm build. Start with the <a href="{{ route('docs.show', 'installation') }}">installation guide</a>.</p></details>
            <details><summary>Is my GA4 ID all I need?<x-icon name="plus" /></summary><p>Once the package is installed and the two Blade components are in your layout, publish the config, enable the GA4 preset, and set <code>CONSENT_GA4_ID</code>. The preset registers GA4 and handles its consent checks and tag loading. Remove any old standalone GA4 snippet to avoid duplicate tracking. See the <a href="{{ route('docs.show', 'google-presets') }}">GA4 setup</a>.</p></details>
            <details><summary>Can I use it with my own scripts?<x-icon name="plus" /></summary><p>Yes. Register a service with its category and purpose, then wrap its script in the <a href="{{ route('docs.show', 'blade-directives') }}">consent Blade directive</a>. The script waits for the matching consent, including on cached pages. Scripts outside this flow remain your responsibility.</p></details>
            <details><summary>What happens when someone changes their mind?<x-icon name="plus" /></summary><p>Visitors can reopen preferences and update or withdraw their choice. The package saves the new state and clears declared first-party cookies. Withdrawing consent from an active built-in tracker reloads the page to stop it. See <a href="{{ route('docs.show', 'withdrawal') }}">withdrawal and cleanup</a> for custom scripts and cookie scopes.</p></details>
            <details><summary>Does it make my site GDPR compliant?<x-icon name="plus" /></summary><p>No package can guarantee that. Consent provides the choices, script controls, and withdrawal mechanism. You still need accurate service descriptions, privacy information, and a tracking setup that matches your site's requirements. See <a href="{{ route('docs.show', 'security') }}">security and privacy</a>.</p></details>
            <details><summary>Do I need a hosted consent platform?<x-icon name="plus" /></summary><p>No. Consent is an open-source, MIT-licensed Composer package. The interface and configuration live in your Laravel app, with no separate consent dashboard to manage.</p></details>
        </div>
    </section>
    <section class="closing-section" aria-labelledby="closing-title"><img src="{{ asset('assets/consent-mark.svg') }}" width="72" height="72" alt=""><span class="eyebrow">Open source for Laravel</span><h2 id="closing-title">Get back to<br><span class="text-accent">building your app</span></h2><div class="button-row"><a class="button button-primary" href="{{ route('docs.show', 'installation') }}">Install the package <x-icon name="arrow-right" /></a><a class="button button-outline" href="{{ config('site.repository') }}">View on GitHub <x-github-mark /></a></div><p>Let the package handle consent and tracking setup. Spend your next commit on the features your app needs.</p></section>
</main>
@endsection
