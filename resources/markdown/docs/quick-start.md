## 1. Install the package

In the root of your Laravel 12 or 13 application running PHP 8.3+, install the stable package from [Packagist](https://packagist.org/packages/jakub-lipinski/consent-for-laravel) and publish its configuration:

```bash
composer require jakub-lipinski/consent-for-laravel
php artisan vendor:publish --tag=consent-config
```

Laravel discovers the provider automatically. The package's default assets need no npm install or build. See [installation](/docs/installation) for requirements and optional published resources.

## 2. Enable a preset and supply its ID

This walkthrough uses GA4. Set your real measurement ID in your application's `.env`:

```dotenv
CONSENT_GA4_ID=G-XXXXXXXXXX
```

In the published `config/consent.php`, edit the existing `ga4` entry inside `presets`:

```php
'presets' => [
    // Keep the other preset entries from the published configuration.
    'ga4' => [
        'enabled' => true,
        'measurement_id' => env('CONSENT_GA4_ID'),
        'send_page_view' => true,
    ],
],
```

An ID alone does not enable a preset: `enabled` must be the boolean `true`. GA4 registers its analytics purpose and loads its tag automatically after analytics consent in the default Basic mode. Remove any existing standalone GA4 snippet or duplicate installation; a preset needs no manual service definition or `@consent` wrapper.

For other tools, follow [Google Ads](/docs/google-presets), [Meta Pixel](/docs/meta-pixel), or [Microsoft Clarity](/docs/microsoft-clarity). You can enable several presets in the same `presets` array. For a script without a built-in preset, use [the custom-script alternative](/docs/quick-start#alternative-your-own-script) below.

## 3. Add the components

Add these to the shared Blade layout used by the pages requiring consent. Place the runtime in the head before any vendor code or code using `window.Consent`; mount the banner in the body:

```blade
<head>
    <x-consent::head />
</head>
<body>
    {{-- Your application content --}}

    <x-consent::banner />
</body>
```

Each component renders once per response. JavaScript and CSS are embedded by default. If your app uses a nonce-based Content Security Policy, pass the same application-generated nonce to both components; see [CSP and assets](/docs/csp-and-caching).

## 4. Choose the interface and set a policy link

```php
'ui' => [
    'variant' => 'standard', // standard or compact; banner and preferences
    'position' => 'bottom-left',
    'locale' => null,
    'policy_url' => '/cookies',
    'validate_contrast' => false,
    'colors' => [],
],
```

Edit the existing `ui` array in `config/consent.php`. Create the `/cookies` page in your application and describe its real processing, or replace the example URL with your existing policy page. The package does not generate a policy page. See [banner and theme](/docs/banner-and-theme) for colors, positions, and component overrides.

The cookie icon already reopens preferences after a decision. You can also add a footer button:

```blade
<button type="button" data-consent-open>Cookie preferences</button>
```

Opening and closing preferences does not make a decision. Checkbox changes remain a draft until saved.

## 5. Apply configuration changes

After editing configuration or `.env`, clear any cached configuration while developing:

```bash
php artisan config:clear
```

During production deployment, run `php artisan config:cache` after setting environment values and restart long-running application workers. Reload the page so the browser receives the updated configuration.

## 6. Verify the result

1. Open a fresh private browser session. With GA4 enabled, the banner should appear and preferences should show Necessary and Analytics. In Basic mode, no Google tag or measurement request should occur before permission.
2. Reject optional cookies and reload. Refusal remains remembered, GA4 stays inactive, and the preferences launcher remains available.
3. Reopen preferences and save an analytics grant. GA4 should initialize and its configured page view can be sent. Confirm requests in the browser's Network panel and your own staging property.
4. Withdraw analytics after it starts. The page reloads by default, and GA4 stays inactive on the new document. See [withdrawal](/docs/withdrawal) for cleanup scopes and custom lifecycles.
5. Check keyboard focus, mobile layout, the policy link, and your custom preferences button if present.

With all presets disabled and no optional custom service, only the preferences launcher appears; that is the expected empty configuration. For a missing banner, stale settings, or provider errors, see [troubleshooting](/docs/troubleshooting).

## Alternative: your own script

Use this path for an integration without a built-in preset. Keep the same installation, head/banner components, UI settings, and cache steps. Register your actual purpose in `config/consent.php`:

```php
'services' => [
    'site-insights' => [
        'category' => 'analytics',
        'name' => 'Site insights',
        'description' => 'Measure visits and navigation to improve this website.',
    ],
],
```

Registration describes the purpose; it does not load your script. Place its script block in the layout's body after the head runtime, wrapped by the directive:

```blade
@consent('analytics', 'site-insights')
    <script src="/js/site-insights.js"></script>
@endconsent
```

This fictional script is supplied by your application at `public/js/site-insights.js`; replace it with your provider's real script and any initialization. The directive emits inert HTML, then activates it only after a valid analytics grant. Keep all optional bootstrap code inside the block and remove duplicate ungated scripts. Read [Blade directives](/docs/blade-directives) for ordering and supported contents, and [services](/docs/services-and-categories) for cookie cleanup declarations.
