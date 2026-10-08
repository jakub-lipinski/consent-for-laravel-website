## 1. Install the package

Follow [installation](/docs/installation), including the VCS repository while the package is not on Packagist. Publish `consent-config`.

## 2. Describe a purpose

Add a service to `config/consent.php`. This example describes a fictional, locally implemented analytics script. Replace the metadata with your site's actual purpose.

```php
'services' => [
    'site-insights' => [
        'category' => 'analytics',
        'name' => 'Site insights',
        'description' => 'Measure visits and navigation to improve this website.',
    ],
],
```

Registration describes a service; it does not load a script. Only necessary and the globally used analytics category will appear in preferences.

## 3. Add the components

Place the runtime in the layout's head, before any code using `window.Consent`. Mount the banner in the body and wrap the optional scripts:

```blade
<head>
    <x-consent::head />
</head>
<body>
    {{-- Your application content --}}

    <x-consent::banner />

    @consent('analytics', 'site-insights')
        <script src="/js/site-insights.js"></script>
    @endconsent
</body>
```

`/js/site-insights.js` is an example file owned by your app, not supplied by the package. Each component renders once per response. The directive always emits inert HTML. Optional code starts only after the browser has a valid stored decision allowing analytics.

## 4. Set a policy link

```php
'ui' => [
    'position' => 'bottom-left',
    'locale' => null,
    'policy_url' => '/cookies',
    'colors' => [],
],
```

Create that policy page in your host application and describe its real processing. The package does not generate legal text or register a policy route. Rebuild your configuration cache if enabled.

## 5. Add a custom preferences entry

The compact cookie button already reopens preferences after a decision. You may also add a footer button:

```blade
<button type="button" data-consent-open>Cookie preferences</button>
```

Opening and closing preferences does not make a decision. Checkbox changes remain a draft until saved.

## 6. Check the complete lifecycle

Test an undecided visit, explicit rejection, acceptance, returning with each decision, and withdrawal after scripts have started. Confirm no relevant tracking requests occur before permission. Check keyboard focus, mobile reflow, your policy link, and overlays in the actual host application.

Withdrawing an active category reloads by default. Read [withdrawal](/docs/withdrawal) before supplying custom cleanup. For GA4 or Google Ads, use the [built-in presets](/docs/google-presets) instead of wrapping a duplicate vendor bootstrap. They register purposes and apply [Consent Mode v2](/docs/google-consent-mode). For [Meta Pixel](/docs/meta-pixel) or [Clarity](/docs/microsoft-clarity), enable their ID-based presets and use the same components.

## Alternative: GA4 by ID

Keep the same head/banner components, omit the example custom service and script, and enable the preset:

```php
'presets' => [
    'ga4' => [
        'enabled' => true,
        'measurement_id' => env('CONSENT_GA4_ID'),
        'send_page_view' => true,
    ],
],
```

Set `CONSENT_GA4_ID` to your measurement ID. Basic is the default: no Google requests before analytics consent. See [Google presets](/docs/google-presets) for Ads conversions, real cookie scopes, SPA page views, and verification.
