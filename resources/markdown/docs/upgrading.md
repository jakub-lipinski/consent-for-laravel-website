## Updating within version 1

Review [package releases](https://github.com/jakub-lipinski/consent-for-laravel/releases), update the application dependency, and commit the resulting application lock file:

```bash
composer require jakub-lipinski/consent-for-laravel:^1.0
```

The public PHP, Blade, browser, and configuration APIs documented here belong to the stable version 1 series. The library itself does not commit a dependency lock file; your application normally should.

## Moving an existing installation to 1.0

Merge the current configuration into published `config/consent.php`. Keep your actual service descriptions, IDs, policy version, cookie scopes, and UI choices. Presets remain disabled by default, so the upgrade alone does not activate a tracker.

Merge current English/Polish messages into published translations. Keep `google_advanced` and all enabled preset purposes under `messages.presets`, including `meta-pixel`, `microsoft-clarity`, and `microsoft-clarity-ads`. Review customized views against the current components rather than blindly overwriting them.

Version 1.0 preserves cookie schema 1 and unchanged service fingerprints. UI-only changes do not invalidate decisions. Enabling or changing services, preset IDs, initialization options, processing purposes, advertising mode, or cleanup rules changes the fingerprint and makes old decisions pending. Changing the application-owned policy version also requires a fresh decision.

Google event helpers capture permission and JSON parameters at invocation and recheck permission before dispatch. Calls made without permission are not replayed after a queued grant. A failing Google command queue cannot prevent the runtime's active withdrawal cleanup and reload.

The preference cookie name must be separate from session and CSRF names, and cannot start with `remember_`. This prevents the consent provider from exempting Laravel remember-me cookies from encryption. Change any conflicting preference name before deploying.

## Published assets and deployment

If you use separate assets, republish their current contents and invalidate browser/CDN caches:

```bash
php artisan vendor:publish --tag=consent-assets --force
php artisan config:cache
php artisan view:clear
```

Restart long-running workers. Inline default components use the installed assets directly. Test pending, refusal, acceptance, expiry, withdrawal, CSP, keyboard, and mobile behavior in the host application.

## Provider configuration

Remove duplicate vendor bootstraps and colliding manual purposes before enabling presets. GA4/Google Ads use [Google Consent Mode](/docs/google-consent-mode). [Meta Pixel](/docs/meta-pixel) requires marketing permission. [Clarity](/docs/microsoft-clarity) requires analytics permission; advertising additionally requires explicit enablement and marketing permission. Enable Require cookie consent and review masking in your Clarity project.

Provider settings and processing purposes remain the application's responsibility. An upgrade does not configure an account or establish legal compliance.
