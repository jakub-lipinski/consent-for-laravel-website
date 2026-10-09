## Configure your Google tools

Enable a preset and supply its ID. The package registers the purpose, applies [Consent Mode v2](/docs/google-consent-mode), loads one shared Google tag, and manages category-based activation. Basic is the default; explicitly configured Advanced permits cookieless pings before consent.

## Quick setup

First [install the package from Packagist and publish its configuration](/docs/installation). Edit the existing preset entries in `config/consent.php`, keeping any other presets you use:

```php
'presets' => [
    // Preserve the other preset entries from the published configuration.
    'ga4' => [
        'enabled' => true,
        'measurement_id' => env('CONSENT_GA4_ID'),
        'send_page_view' => true,
    ],
    'google_ads' => [
        'enabled' => true,
        'conversion_id' => env('CONSENT_GOOGLE_ADS_ID'),
    ],
],
```

```dotenv
CONSENT_GA4_ID=G-XXXXXXXXXX
CONSENT_GOOGLE_ADS_ID=AW-123456789
```

Set these values in your application's `.env` or production environment and replace the example IDs with your own. Either preset can be enabled independently; leave an unused one disabled. An ID alone does not enable a preset. Leave `google.enabled` at its default `null` for automatic bridge activation and `google.mode` at `basic` for loading only after permission. Refresh [cached configuration](/docs/configuration#apply-configuration-changes) after editing settings or IDs.

No manual service definition, vendor bootstrap, or `@consent` block is needed for a preset:

```blade
<head>
    <x-consent::head :nonce="$cspNonce" />
</head>
<body>
    {{-- Application content --}}
    <x-consent::banner :nonce="$cspNonce" />
</body>
```

Omit nonce props when the host does not use nonce-based CSP. Render the head before any Google tag, config, event, or consumer of `Consent`. Remove old standalone gtag snippets and duplicate GA4/Ads installations, including tracking supplied by another package. A detected preexisting gtag, populated/non-array dataLayer, or Google bootstrap script makes the runtime fail closed with a `configuration` diagnostic. The package cannot undo earlier requests.

## Events and conversion routing

Use an explicit registered destination:

```javascript
const queued = await Consent.google.event('G-XXXXXXXXXX', 'purchase', {
    transaction_id: 'order-123',
    value: 49.90,
    currency: 'PLN',
});

const conversionQueued = await Consent.google.event(
    'AW-123456789/YOUR_CONVERSION_LABEL',
    'conversion',
    { transaction_id: 'order-123', value: 49.90, currency: 'PLN' },
);
```

`event(destination, name, parameters = {})` returns a promise resolving to `true` when the command was queued, or `false` when permission/initialization is unavailable. It captures JSON parameters and checks permission when called, waits for preset initialization, and rechecks permission immediately before queueing. It does not remember denied events for later replay, confirm network delivery, or deduplicate transactions for you. Use your actual Ads conversion label; enabling Ads alone sends no conversion event. Keep personally identifying data out of ordinary event parameters and assess the provider's applicable data rules.

Invalid destinations, missing Ads labels, non-conversion Ads events, invalid event names, non-object parameters, and `send_to` / `event_callback` overrides reject with `TypeError`. GA4 uses its exact registered ID. Ads requires its registered `AW-...` ID plus a label of 1-128 letters, digits, underscores, or hyphens. Event names start with a letter and use letters, digits, or underscores up to 40 characters. Provider-specific event parameter validation remains the application's responsibility.

For SPA navigation, set `ga4.send_page_view` to `false` and send the intended `page_view` through this helper after each permitted navigation. Re-grant after active withdrawal occurs on the reloaded document, preventing an old tracker instance from silently resuming.

## Preset configuration and cleanup

Both presets accept actual boolean `enabled` (default `false`), optional canonical `name` / `description`, and optional `cookie_path` (default `/`) / `cookie_domain` (default `null`). GA4 additionally accepts boolean `send_page_view` (default `true`). Unknown keys are rejected. IDs must match `G-` plus 4-32 uppercase letters/digits, or `AW-` plus 1-20 digits starting with 1-9. Disabled definitions are also validated; a disabled ID can be null.

Enabled GA4 registers `google-ga4` in analytics with `_ga` and `_ga_` cleanup rules. Enabled Ads registers `google-ads` in marketing with `_gcl_` rules. These IDs must not collide with custom services. Default purposes have display translations in all seven bundled languages and support custom locale fallback. Canonical overrides take precedence over built-in default wording; `consent::services` translations can still explicitly override display fields. Describe the real processing rather than relying on generic defaults.

Match cleanup scopes to the cookies actually written by the vendor. Google can choose a parent-domain cookie automatically; if appropriate, explicitly set the matching domain:

```php
'ga4' => [
    'enabled' => true,
    'measurement_id' => env('CONSENT_GA4_ID'),
    'cookie_domain' => '.example.com',
    'cookie_path' => '/',
],
```

These options declare deletion scope, not gtag cookie configuration. Additional scopes require custom cookie rules in separately named service definitions. Only declared visible first-party cookies can be removed; HttpOnly, third-party, other storage, or previous remote processing cannot be erased by this library.

Active preset withdrawal always reloads, even if a custom `onRevoke` hook uses `reload: false`. Google has no complete cooperative stop lifecycle supplied by the package. GA4 is disabled immediately on Basic denial and on active Advanced withdrawal, and Google receives denied consent before cleanup/reload. In Advanced, a subsequent refused document again runs the explicitly enabled cookieless mode.

Changing enabled targets, IDs, mode, page-view settings, canonical purposes, or cleanup rules changes the service fingerprint. Old decisions become pending. With the bridge disabled and presets inactive, existing fingerprints are preserved. UI-only variant/translation/position/color changes do not invalidate or extend consent.

## Next steps

Check [Consent Mode](/docs/google-consent-mode), [CSP](/docs/csp-and-caching), [withdrawal](/docs/withdrawal), and your actual staging property/network. Local package verification uses mock tags, not live Google measurements.
