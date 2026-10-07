## Development release policy

The package is in beta. Releases use `v1.0.0-beta.N` until the version 1.0 release is ready. Breaking changes or fixes may require additional betas. Pin the tagged beta for reproducible application testing.

```bash
composer require webcrafts-studio/consent-for-laravel:1.0.0-beta.3
```

This assumes the VCS repository from [installation](/docs/installation) is configured. Review [package releases](https://github.com/jakub-lipinski/consent-for-laravel/releases) before upgrading.

## Beta.1 to beta.2

Beta.1 supplied categories, service metadata, strict versioned cookies, and the PHP API. Beta.2 added the inert Blade directive and browser runtime with ordering, deduplication, withdrawal, cleanup declarations, and CSP support.

Existing beta.1 service fingerprints remain compatible if cookie cleanup rules are absent or empty. Adding non-empty rules changes the fingerprint and makes old decisions pending. Mount the head component to use the browser gate.

## Beta.2 to beta.3

Beta.3 adds the built-in banner, preferences dialog, reopening button, validated colors, position/language settings, and interface translations. Add `<x-consent::banner />` to your layout. Existing custom interfaces may continue to use the browser API.

UI-only changes do not invalidate decisions. Check custom views and CSS for compatibility, and keep only one owner for the preference interface.

## Deployment checklist

1. Review release notes and any changed configuration options.
2. Update the pinned package version and application dependency lock file.
3. Merge published view/translation changes instead of blindly overwriting them.
4. Republish separate assets when used, and invalidate their browser/CDN caches.
5. Rebuild configuration/views and restart long-running workers.
6. Verify pending, refusal, acceptance, expiry, withdrawal, CSP, keyboard, and mobile behavior in the host.

The library repository does not commit a dependency lock file. Your consuming application normally should.

## Future integrations

No Google or Meta presets need migration in beta.3 because they have not shipped. Future betas will document their own setup and vendor-specific verification. Do not assume that upgrading alone will configure a tracker or establish legal compliance.
