## Composer cannot install the package

Use the exact published name from [Packagist](https://packagist.org/packages/jakub-lipinski/consent-for-laravel), in your Laravel application's root:

```bash
composer require jakub-lipinski/consent-for-laravel
```

Check PHP 8.3+, Laravel 12 or 13, and Composer 2. Read Composer's dependency conflict message before changing constraints. For package lookup or network failures, run `composer diagnose` and `composer show --all jakub-lipinski/consent-for-laravel`; check whether a custom Composer mirror or configuration disables Packagist. If Composer still uses metadata from before publication, run `composer clear-cache` and retry. A VCS entry or reduced minimum stability is unnecessary for the stable package.

If you previously added `repositories.consent`, follow [switching to Packagist](/docs/upgrading#switching-from-a-vcs-installation).

## Configuration cannot be published

If `vendor:publish --tag=consent-config` reports no publishable resources, confirm installation with `composer show jakub-lipinski/consent-for-laravel`. If the app was installed with Composer scripts disabled, rebuild discovery:

```bash
composer dump-autoload
php artisan package:discover
```

Check your application's `composer.json` for `extra.laravel.dont-discover`: either the package name or `*` can disable auto-discovery. If you intentionally keep discovery disabled, add this provider to the existing array in `bootstrap/providers.php`:

```php
ConsentForLaravel\ConsentForLaravel\ConsentForLaravelServiceProvider::class,
```

Then publish `consent-config` again. Normal installations need no manual provider entry.

## Configuration changes are ignored

IDs in `.env` supply preset values but do not enable tracking. Set the corresponding `presets.*.enabled` entry to the boolean `true` in `config/consent.php`. Edit existing entries, retaining the other options and presets; do not paste excerpts over the whole file.

Run `php artisan config:clear` locally after configuration or environment changes. In production, rebuild with `php artisan config:cache` after setting environment values and restart long-running workers. Reload the browser page to receive updated settings. See [configuration](/docs/configuration#choose-an-integration).

## The banner does not appear

Check that both `<x-consent::head />` and `<x-consent::banner />` are in the layout. A valid saved acceptance or refusal shows the launcher instead of the initial banner. With no enabled optional service, only the launcher is shown; this is the fresh installation's default because all presets are disabled and `services` is empty. Enable your preset with its ID or register your custom service, then refresh cached configuration. Use a fresh private session to test an undecided visitor.

Opening preferences should still work through `data-consent-open` or `window.Consent.openPreferences()`. If the method returns false, the interface is not available. Verify JavaScript/CSP errors and native dialog support.

## Compact does not appear

Use `consent.ui.variant: compact` or `<x-consent::banner variant="compact" />`; missing configuration defaults to Standard. The variant applies to both the banner and preferences. Rebuild configuration/view caches, merge the new `variant` prop and `data-consent-variant` attribute into customized published views, and deploy matching, cache-busted package styles. A stale view or stylesheet can keep the original appearance. See [upgrading](/docs/upgrading).

## A category is missing

Only optional categories used by enabled services are shown. The registry is global to the site. Check the service's category, enabled boolean, and configuration cache. Disabled service definitions remain validated.

## A script does not run

Verify a current stored decision, the category's active service, and `window.Consent.allowed()`. Blocks must contain scripts/comments/whitespace only. Check HTTP(S) source URLs, CSP, integrity/CORS settings, network errors, block IDs, and timeouts.

A failed block does not retry. A previously run block will not execute again after SPA remounting or cooperative re-grant. Use the provider's own lifecycle or reload.

```js
document.addEventListener('consent:error', event => {
    console.error(event.detail);
});
```

## A cookie cannot be saved

Check browser restrictions, the configured path/domain, HTTP versus `secure: true`, and trusted proxies. A save failure keeps optional processing denied and displays a retryable UI error. Do not treat clicking accept as a successful grant if persistence failed.

Read [persistence](/docs/persistence) for temporary denial markers and the case where automatic reload is unsafe.

## Preferences reset unexpectedly

The decision may have expired or the policy/service fingerprint may have changed. Active service names, descriptions, categories, IDs, and cookie rules contribute to its version. UI-only changes do not. Shortening retention may invalidate older decisions.

## Withdrawal reloads the page

This is the default safety behavior for running code. Removing scripts cannot stop them. Only opt out with complete cooperative cleanup of every active service in the category. In-flight scripts or cleanup failures still require reload.

## Tracker cookies remain

Cookie deletion needs the correct declared path/domain and browser visibility. HttpOnly, third-party, other-scope cookies, non-cookie storage, and remote data require their own provider/server APIs. Protected preference, session, CSRF, and remember cookies are intentionally excluded.

## Custom theme diagnostics

In 1.1.3 and later, theme contrast does not cause HTTP 500. Diagnostics default to off; set `ui.validate_contrast` to `true` to log warnings without changing the selected colors. Text combinations need 4.5:1 and control/focus colors need 3:1 against the UI background. Invalid six-digit hex formats use default colors and log a warning. If an older installation throws a contrast exception, update the package and rebuild cached configuration/views. See [banner and theme](/docs/banner-and-theme).

## Published views or assets are stale

Compare application-owned published files with the new package version, merge changes deliberately, rebuild view/config caches, republish assets, and update cache-busting. Do not use `--force` to overwrite intentional customizations without review.

## Where to report a problem

Use [package issues](https://github.com/jakub-lipinski/consent-for-laravel/issues) for package behavior and [website issues](https://github.com/jakub-lipinski/consent-for-laravel-website/issues) for documentation/site problems. Include versions, minimal reproduction, expected behavior, and console/network details without secrets or personal data.

## Google does not start

Confirm the preset is enabled, its ID is valid, and the correct category is granted in Basic. Render the head before Google code and remove old gtag bootstraps, populated dataLayer initialization, and duplicate installs. A detected conflict reports `configuration` and leaves optional templates inert. A loader/CSP/network failure reports `google`; fix it and retry on a new document.

`Consent.google.event()` returning `false` means a command was not queued. A `true` result does not prove provider delivery. For Ads, use an enabled destination plus the actual conversion label and event `conversion`. See [Google presets](/docs/google-presets).

## Meta or Clarity does not start

Check the enabled preset and its string ID, required category, saved decision, config cache, CSP, blockers, and timeout. A pre-existing `fbq`/`_fbq`/`clarity` or matching bootstrap causes `configuration` failure. Remove all duplicate snippets and container installs. Failed initialization reports `meta` or `clarity` and never retries in the same document.

For Clarity, enable Require cookie consent and use the case-sensitive Consent API v2 fields. Advertising is off unless explicitly configured and both required categories are granted. For Meta, disable automatic PageView if your router owns it. Helpers returning true only confirm a local SDK command, not server delivery. See [Meta](/docs/meta-pixel) and [Clarity](/docs/microsoft-clarity).

## Theme or language options fail

Check the installed version with `composer show jakub-lipinski/consent-for-laravel`. Older versions such as 1.1.3 do not support `theme`, `dark_colors`, expanded explicit locales, or 72-hour warning suppression. Update the package before using these options.

After upgrading to theme support, compare published views/CSS, merge `data-consent-theme` and both-palette overrides, clear compiled views, and refresh config/asset caches. A valid custom language without dictionaries safely falls back to English; create `lang/vendor/consent/{locale}/messages.php` to supply wording. Malformed explicit tags and non-string messages remain configuration errors.

For repeated theme warnings after installing suppression, use a persistent default cache with atomic `add`. `array` only remembers within its lifetime; cleared or evicted markers allow earlier logging. Cache/logger failure never causes a page error. See [warning suppression](/docs/banner-and-theme#warning-suppression).

## Audit prevents a new grant

Confirm the installed package is at least 1.3.0. Select connection/table names, publish `consent-audit-migrations`, run the migration, and only then enable `audit.enabled`. Rebuild config/route caches and restart workers. Inspect the configured POST endpoint in the Network panel and `consent:error` with code `audit`.

| Response / symptom | Check |
| --- | --- |
| 404 | Audit disabled at boot, stale route cache, changed path, or proxy routing |
| 403 | Exact Origin and Fetch Metadata; HTTPS scheme/host from trusted proxies |
| 413 / oversized render | 60 KiB package request limit and stricter proxy limits; shorten excessive custom markup |
| 415 | JSON content type; blocked or rewritten request |
| 422 | Signed notice, application/previous keys, valid full choices, and matching action |
| 409 | Same event UUID reused with different content or browser identity |
| 503 | Missing tables, connection/permissions, or unavailable storage; response hides database details |
| Timeout / no request | CSP `connect-src 'self'`, blockers, offline state, timeout setting, keepalive quota, or missing/duplicate notice blocks |

Merge updated capture/notice markup into published banner views and cache-bust published `consent.js`. Refresh cached HTML after removing signing keys. Keep session and CSRF cookies encrypted; no CSRF exemption is needed for the bundled endpoint. Refusal and withdrawal still apply locally when delivery fails. See [audit installation and failures](/docs/audit-log).

## Missing audit records or split history

Only explicit browser acceptance, refusal, saved preferences, and withdrawal are recorded. Existing preferences, page loads, dialog opening, expiry, cross-tab checks, and cookie edits are not retroactively logged. PHP cookie helpers need [explicit server integration](/docs/php-api#explicit-server-audit-integration).

Cookie deletion/blocking, different devices, simultaneous first decisions, or changed cookie/endpoint names can split a browser history. Delivery is not guaranteed offline or after reload/tab closure. Review `audit.retention_days` and the application's scheduler if older records disappear. `expires_at` describes preference validity, not the audit deletion date. See [identity](/docs/audit-log#requests-and-browser-identity) and [retention](/docs/audit-log#retention).
