## Meta Pixel

First [install the package from Packagist and publish its configuration](/docs/installation). Edit the existing `meta_pixel` entry in `config/consent.php` to enable the optional marketing preset:

```php
'presets' => [
    // Preserve any other presets you use.
    'meta_pixel' => [
        'enabled' => true,
        'pixel_id' => env('CONSENT_META_PIXEL_ID'),
        'send_page_view' => true,
    ],
],
```

```dotenv
CONSENT_META_PIXEL_ID=123456789012345
```

Set this value in your application's `.env` or production environment. Replace the example with your own Pixel ID: a string of 1-20 digits starting with 1-9, not an access token. The preset is disabled by default; setting the ID alone does not enable it. Set `enabled` to the boolean `true`, keep other preset entries, and refresh [cached configuration](/docs/configuration#apply-configuration-changes).

Use the existing `<x-consent::head />` before vendor code and `<x-consent::banner />` in your application layout. No extra Blade block or manual service is required. Remove duplicate snippets and tag-manager installs. These presets are strictly gated even if Google Advanced is configured. See [quick start](/docs/quick-start) and [configuration](/docs/configuration).

## Activation and events


The `meta-pixel` service uses `marketing`. Its default English/Polish purpose is shown automatically. The preset creates the vendor-compatible `fbq` queue with revoked consent, applies a current saved grant, then loads `https://connect.facebook.net/en_US/fbevents.js` only with marketing permission. It rechecks permission before `init` and the optional `PageView`. Initialization and automatic PageView happen once per document. There is no noscript tracking image, automatic matching payload, Conversions API request, or server-side event integration supplied by this preset.

### Standard and custom events

```javascript
try {
    const queued = await Consent.meta.track('Purchase', {
        value: 49.90,
        currency: 'PLN',
    }, { eventID: 'order-123' });

    await Consent.meta.trackCustom('NewsletterSignup', { source: 'footer' });
} catch (error) {
    // Handle invalid input or an unavailable provider API.
}
```

`track(name, parameters = {}, options = {})` calls the vendor's `track`; `trackCustom` calls `trackCustom`. Use Meta standard event names with `track` and your own names with `trackCustom`. The preset owns one Pixel ID; do not initialize other pixels through the same `fbq` global.

Parameters must be an object with JSON-serializable data. The optional options object accepts only `eventID`, a non-empty string up to 128 characters, for your own event deduplication strategy. An event ID does not add a server-side integration or deduplicate every repeated browser call automatically. Do not include personal data or sensitive page contents in event parameters.

Both helpers return `Promise<boolean>`: `true` means a command was submitted to the local vendor API, not delivered to Meta; `false` means permission or initialization was unavailable. They check consent at invocation and again immediately before dispatch. Calls made without permission are discarded, including calls behind an already queued acceptance. Failed or denied events are never replayed after a later grant. Invalid input or a disabled preset rejects. Payloads are captured at invocation so later mutations do not alter a pending event.

Event names accepted by the package start with an ASCII letter, use letters/digits/underscores/dots/hyphens, and are at most 128 characters. Meta can impose further restrictions on its own event schemas.

### SPA page views

Set `send_page_view` to `false` when your router owns page views. After a committed route change, call `Consent.meta.track('PageView')` once. Keep one head/runtime per document; remounting the banner or inserting Blade fragments must not initialize a second pixel. Events requested without permission are not retained for later navigation.

### Meta product settings

Review Events Manager's automatic events, matching, data-sharing, and event setup separately. The preset does not configure your Meta account or police code calling `fbq` directly. A marketing grant is not permission to send arbitrary identifiers, form values, or sensitive URLs. Review the actual processing and describe it in the host's policy.

## Withdrawal and cookie cleanup

Marketing withdrawal sends `fbq('consent', 'revoke')` before listeners and reload. The preset always reloads when active or in flight, even if a custom cleanup hook requests `reload: false`. A fresh document keeps denied code inactive; an in-flight request may still finish during navigation.

The preset declares `_fbp` and `_fbc`. Optional `cookie_path` and `cookie_domain` settings default to `/` and `null`. Match actual cookies, including parent domains. These declarations do not configure Meta's cookie scope or remove third-party/HttpOnly cookies or remote data. Optional `name` and `description` customize canonical purpose metadata. See [withdrawal](/docs/withdrawal).

## CSP and diagnosis

Bootstrap scripts inherit the head nonce and use the ordered loader. Permit the appropriate vendor script, connection, and image origins; a nonce does not authorize requests or images. The initial library comes from `connect.facebook.net`. Review the provider's current CSP needs and verify on your host.

A detected existing `fbq`, `_fbq`, or matching bootstrap fails closed with a `configuration` diagnostic; it cannot undo earlier requests from another installation. A loader/initialization failure emits `meta`, does not retry in the document, and does not block independent permitted presets or Blade blocks after an ordinary failure. A load timeout requests a fresh document and stops further activation. Do not replace globals or initialize extra pixels yourself. See [troubleshooting](/docs/troubleshooting).

## Upgrading and verification

Merge the new configuration and English/Polish preset translations, remove the manual `meta-pixel` service if duplicating the enabled preset, and republish/cache-bust separate assets when used. Enabling or changing the preset's ID, PageView option, purpose, or cookie scope invalidates saved decisions. With the new presets off, existing fingerprints remain compatible. See [upgrading](/docs/upgrading).

Local tests use SDK mocks and native browser checks for consent, events, ordering, CSP, and withdrawal. They do not confirm delivery to your Meta account. Verify Events Manager/Test Events in your own controlled host environment without transmitting personal test data.

## Primary references

Checked on 2026-10-08. Meta's developer documentation was rate-limited here; the official maintained integration source confirms the queue, bootstrap, consent commands, events, and cookie names.

- [Meta's official pixel implementation source](https://github.com/facebook/facebook-for-woocommerce/blob/main/facebook-commerce-pixel-event.php).
- [Meta consent documentation](https://developers.facebook.com/docs/meta-pixel/implementation/gdpr/).
