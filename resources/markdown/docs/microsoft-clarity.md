## Microsoft Clarity in beta.5

Enable the optional analytics preset in `config/consent.php`:

```php
'presets' => [
    // Preserve any other presets you use.
    'clarity' => [
        'enabled' => true,
        'project_id' => env('CONSENT_CLARITY_ID'),
        'advertising' => false,
    ],
],
```

```dotenv
CONSENT_CLARITY_ID=abc123def4
```

Replace the example with your own project ID: a string of 1-32 lowercase letters/digits. The preset is disabled by default. Analytics alone never grants advertising storage.

Use the existing `<x-consent::head />` before vendor code and `<x-consent::banner />` in your application layout. No extra Blade block or manual service is required. Remove duplicate snippets and tag-manager installs. These presets are strictly gated even if Google Advanced is configured. See [quick start](/docs/quick-start) and [configuration](/docs/configuration).

## Activation and consent


The `microsoft-clarity` service uses `analytics`, with an English/Polish recording and heatmap purpose. The preset installs a queue stub and loads `https://www.clarity.ms/tag/PROJECT_ID` only after analytics permission. It uses the recommended `consentv2` API, including its exact case-sensitive keys. Calls address the current `window.clarity` because the SDK replaces the stub.

In your Clarity project, enable **Require cookie consent** and review masking before production. The package passes site-level consent signals; it does not register as a Microsoft CMP partner or send a fabricated CMP source ID.

### Signals and optional advertising

| Visitor/configuration state | `analytics_Storage` | `ad_Storage` | Load Clarity |
| --- | --- | --- | --- |
| Pending, refused, or analytics denied | `denied` | `denied` | No |
| Analytics granted, default `advertising: false` | `granted` | `denied` | Yes |
| Analytics granted, advertising enabled, marketing denied | `granted` | `denied` | Yes |
| Analytics and marketing granted, advertising enabled | `granted` | `granted` | Yes |

Advertising remains off even after Accept all unless explicitly enabled in configuration. When you enable `presets.clarity.advertising`, the registry adds the separate `microsoft-clarity-ads` marketing purpose, so the marketing category appears even without another marketing tool. You can customize that purpose with `advertising_name` and `advertising_description`. Marketing alone never starts Clarity.

```php
'clarity' => [
    'enabled' => true,
    'project_id' => env('CONSENT_CLARITY_ID'),
    'advertising' => true,
    'advertising_description' => 'Your accurate Clarity advertising purpose.',
],
```

Both consent fields are sent before change listeners and before reload. Saved decisions, expiry, forgetting, external cookie updates, and storage failures use the same mapping; draft switches never signal a grant. Google consent settings do not substitute for Clarity's consent API.

### Clarity events and state

```javascript
const signals = Consent.clarity.state();
// Frozen { analytics_Storage: 'granted' | 'denied', ad_Storage: ... }.

try {
    const queued = await Consent.clarity.event('checkout-completed');
} catch (error) {
    // Handle invalid input or an unavailable provider API.
}
```

`event(name)` submits Clarity's custom event only with analytics permission and initialized SDK. It returns `Promise<boolean>`: true for a submitted local SDK command, false when denied or unavailable, without confirming network delivery. Invalid input or a disabled preset rejects. It checks permission at invocation and dispatch and never replays denied calls. Names start with an ASCII letter, contain letters/digits/underscores/dots/hyphens, and have at most 128 characters. `state()` only inspects signals, is available with the preset disabled, and never loads a tracker. No user identification API is supplied. Existing recording and SPA tracking remain the SDK's responsibility; do not reload the SDK on route changes.

### Masking and privacy

Consent does not remove sensitive content from recordings. Configure the project's masking and use explicit masks for private regions:

```blade
<div data-clarity-mask="true">
    {{-- Private account details --}}
</div>
```

Avoid sensitive data in URLs, event names, attributes, and CSS. Exclude recording entirely from pages where the configured masking and purposes are insufficient. The package does not change remote masking settings or delete historical recordings.

## Withdrawal and cleanup

The new `consentv2` signals are sent synchronously before listeners and reload. Active analytics withdrawal always reloads. With advertising enabled, withdrawing marketing also reloads, including while the Clarity library is in flight, even if analytics remains granted. Custom `reload: false` hooks cannot suppress preset reloads. A fresh document starts only still-allowed presets.

Clarity's denied storage mode can still perform limited cookieless tracking. This package gates the library and reloads active withdrawal to avoid treating storage denial as a complete stop API. An in-flight request can finish during navigation; removal cannot undo previously transmitted data or delete historical recordings.

Declared cleanup cookies are `_clck` and `_clsk`. `cookie_path` defaults to `/`, `cookie_domain` to `null`; match actual vendor scopes, including parent domains. These settings describe cleanup, not SDK cookie creation. They do not delete third-party cookies such as MUID, HttpOnly cookies, or remote data. Optional `name`/`description` customize analytics purpose; `advertising_name`/`advertising_description` customize the separate marketing purpose. See [withdrawal](/docs/withdrawal).

## CSP and diagnosis

The library comes from `www.clarity.ms/tag/PROJECT_ID`, inherits the head nonce, and uses the existing timeout/ordered loader. Microsoft documents Clarity hosts under `*.clarity.ms` and `c.bing.com`. Review required script/connection/image directives on your host, retaining a nonce or strict-dynamic policy rather than copying an overly broad unsafe-inline example. A nonce does not authorize connections or images. See [Microsoft's CSP guide](https://learn.microsoft.com/en-us/clarity/setup-and-installation/clarity-csp).

An existing `clarity` global or matching bootstrap causes a `configuration` error before package activation. A failed load/initialization emits `clarity` and is not retried in the document; independent permitted integrations continue after ordinary failures. A load timeout requests a fresh document and stops further activation. Check Require cookie consent, correct field casing, project ID, masking, CSP, and blockers. Use the helper rather than unguarded direct SDK calls.

## Upgrading and verification

Merge configuration and English/Polish translations, remove duplicate snippets/manual purposes, and republish/cache-bust external assets when used. Reserved service IDs are `microsoft-clarity` and, with advertising enabled, `microsoft-clarity-ads`. Enabling or changing ID, advertising, purpose, or cleanup scope invalidates saved decisions. With the new presets off, beta.4 fingerprints stay compatible. See [upgrading](/docs/upgrading).

Local tests cover replacement APIs, granular consent, recordings-library gating, guarded events, withdrawal, CSP, and interface behavior with mocks. Verify live project recording, masked regions, consent, and network traffic separately on a controlled host. This preset does not provide vendor certification or a universal legal compliance claim. Microsoft excludes websites/apps targeting users under 18 from Clarity use; review provider eligibility before enabling it.

## Primary references

Checked on 2026-10-08:

- [Clarity Consent API v2](https://learn.microsoft.com/en-us/clarity/setup-and-installation/clarity-consent-api-v2).
- [Clarity cookies](https://learn.microsoft.com/en-us/clarity/setup-and-installation/clarity-cookies).
- [Clarity client API](https://learn.microsoft.com/en-us/clarity/setup-and-installation/clarity-api).
- [Clarity masking](https://learn.microsoft.com/en-us/clarity/setup-and-installation/clarity-masking).
