## Development release policy

The package is in beta. Releases use `v1.0.0-beta.N` until the version 1.0 release is ready. Breaking changes or fixes may require additional betas. Pin the tagged beta for reproducible application testing.

```bash
composer require webcrafts-studio/consent-for-laravel:1.0.0-beta.5
```

This assumes the VCS repository from [installation](/docs/installation) is configured. Review [package releases](https://github.com/jakub-lipinski/consent-for-laravel/releases) before upgrading.

## Beta.1 to beta.2

Beta.1 supplied categories, service metadata, strict versioned cookies, and the PHP API. Beta.2 added the inert Blade directive and browser runtime with ordering, deduplication, withdrawal, cleanup declarations, and CSP support.

Existing beta.1 service fingerprints remain compatible if cookie cleanup rules are absent or empty. Adding non-empty rules changes the fingerprint and makes old decisions pending. Mount the head component to use the browser gate.

## Beta.2 to beta.3

Beta.3 adds the built-in banner, preferences dialog, reopening button, validated colors, position/language settings, and interface translations. Add `<x-consent::banner />` to your layout. Existing custom interfaces may continue to use the browser API.

UI-only changes do not invalidate decisions. Check custom views and CSS for compatibility, and keep only one owner for the preference interface.

## Beta.3 to beta.4

Merge the new `google` and `presets` settings. Presets are disabled by default, so upgrading alone makes no Google requests. Enable the presets you need and supply IDs; remove old gtag bootstraps and duplicate manual services. The reserved preset IDs are `google-ga4` and `google-ads`. Read [Google presets](/docs/google-presets).

Basic is the default. Advanced is explicit and permits cookieless pings before permission; the built-in interface discloses that behavior. Update published banner views and translations to preserve the disclosure. Active preset withdrawal always reloads, including when custom cleanup requests `reload: false`.

Enabling or changing Google targets, IDs, mode, page-view settings, or cleanup metadata invalidates old decisions. With the bridge and presets inactive, beta.3 decisions remain compatible. The cookie schema stays unchanged. External module loading now also waits for top-level await after the original SRI-checked load.

## Beta.4 to beta.5

Merge `presets.meta_pixel` and `presets.clarity` from the new configuration. Both are disabled by default. Supply IDs and enable only needed tools; remove old snippets, noscript pixels, tag-manager installs, and colliding manual services. Reserved IDs are `meta-pixel`, `microsoft-clarity`, and optionally `microsoft-clarity-ads`.

Meta needs marketing. Clarity needs analytics; ad storage is off by default and additionally requires explicitly enabled advertising plus marketing permission. Enable Require cookie consent and configure masking in your Clarity project. Both presets use strict gates regardless of Google Advanced. Active withdrawal always reloads, including Clarity advertising withdrawal.

Merge the three new `messages.presets` entries into published English/Polish translations. No new dependency or migration is required. The schema is unchanged; with the new presets disabled, beta.4 fingerprints remain compatible, including Google-only setups. Enabled IDs/options/purposes/scopes participate in the service fingerprint and invalidate old decisions. See [Meta Pixel](/docs/meta-pixel) and [Microsoft Clarity](/docs/microsoft-clarity).

## Deployment checklist

1. Review release notes and any changed configuration options.
2. Update the pinned package version and application dependency lock file.
3. Merge published view/translation changes instead of blindly overwriting them.
4. Republish separate assets when used, and invalidate their browser/CDN caches.
5. Rebuild configuration/views and restart long-running workers.
6. Verify pending, refusal, acceptance, expiry, withdrawal, CSP, keyboard, and mobile behavior in the host.

The library repository does not commit a dependency lock file. Your consuming application normally should.

## Future integrations

GTM is deferred with no assigned beta. The next planned milestone is beta.6 release preparation and integrated verification. Do not assume that upgrading alone configures a tracker or establishes legal compliance.
