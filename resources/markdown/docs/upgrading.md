## Updating within version 1

Review [package releases](https://github.com/jakub-lipinski/consent-for-laravel/releases) and the stable versions on [Packagist](https://packagist.org/packages/jakub-lipinski/consent-for-laravel). To use the documented release and allow compatible updates within version 1:

```bash
composer require "jakub-lipinski/consent-for-laravel:^1.3.0"
```

If your application already allows the desired version, use `composer update jakub-lipinski/consent-for-laravel`. Commit the resulting `composer.json` and `composer.lock` changes; deploy with `composer install` to reproduce that version. The APIs documented here belong to the version 1 series. The library itself does not commit a dependency lock file; your application normally should.

## Decision audit log update

Version **1.3.0** adds optional database decision history. **Existing configurations keep auditing disabled**, require no audit migration, and preserve cookie schema 1, unchanged service fingerprints, and original choice expiry. See [the v1.3.0 release notes](https://github.com/jakub-lipinski/consent-for-laravel/releases/tag/v1.3.0).

```bash
composer require "jakub-lipinski/consent-for-laravel:^1.3.0"
php artisan view:clear
```

Commit the application's Composer files and deploy with `composer install`. Preserve services, presets, IDs, cookie scopes, policy version, colors, and custom wording.

For audit history, merge this new top-level section into the published `config/consent.php`:

```php
'audit' => [
    'enabled' => false,
    'connection' => null,
    'decisions_table' => 'consent_decisions',
    'notices_table' => 'consent_notices',
    'path' => '/consent/decisions',
    'retention_days' => 180,
    'timeout_ms' => 5000,
],
```

1. Select the database connection and distinct table names before migrating. Keep them stable afterward. Review [validation and defaults](/docs/configuration#decision-audit-settings).
2. Publish and run the optional migration while `audit.enabled` is still false:

```bash
php artisan vendor:publish --tag=consent-audit-migrations
php artisan migrate
```

3. Merge the bundled notice capture block and nonce-protected `data-consent-notice` JSON into any customized published banner view. The capture block must include the actual banner/dialog text. Preserve control bindings and nonce handling. Missing or duplicate notice blocks prevent new grants when auditing is enabled.
4. Refresh/cache-bust published `consent.js`. This release does not change `banner.js` or `consent.css`; update those too when skipping earlier versions that changed them. Inline components use the installed source directly.
5. Set `audit.enabled` to true. Rebuild configuration and route caches, clear compiled views and stale page HTML, and restart long-running workers. The configured endpoint is registered at application boot. Ensure trusted proxies report the correct origin and CSP allows `connect-src 'self'`.
6. Keep a valid `APP_KEY`; `app.previous_keys` can verify notices/identity cookies signed with earlier keys. After key rotation, refresh cached HTML deliberately. Do not add a CSRF exemption or disable session-cookie encryption for the bundled stateless endpoint.
7. Choose a separate audit retention period and schedule `consent:audit-prune` in your application. Null retention disables pruning; 180 days is an editable default, not a legally prescribed duration.
8. Verify acceptance, refusal, partial changes, withdrawal, cached/custom/localized notices, unavailable storage, and retries. New grants wait for a database receipt. Refusal and withdrawal apply locally immediately, including when logging fails.

Existing valid preferences are not retroactively logged or invalidated when auditing is enabled. If your deployment requires a new explicit decision, increment the application-owned policy version and invalidate stale HTML. Text-only changes create a new snapshot on the next explicit decision without resetting existing choice expiry.

See [the complete audit guide](/docs/audit-log) for tables, identity, signatures, retention, custom server interfaces, and delivery limitations. If updating from 1.1.x or earlier, also apply the relevant steps below; the final view/assets must come from the installed 1.3.0 package.

## Earlier releases at a glance

Apply every relevant row between your installed version and 1.3.0. Preserve application-owned settings rather than force-publishing the whole config.

| Release | Configuration changes | Published resources / migration |
| --- | --- | --- |
| 1.3.0 | New optional `audit` section; absent keeps it off | Banner notice capture plus `consent.js`; audit tables only when enabled |
| 1.2.0 | `ui.theme`, independent `ui.dark_colors`; absent keeps light | Banner theme attributes/overrides, CSS, custom dictionaries; no consent-cookie migration |
| 1.1.3 | `ui.validate_contrast` defaults to false; absent remains valid | PHP diagnostics update; no browser asset change from 1.1.2 |
| 1.1.2 | No new settings | Both `consent.js` and `banner.js` for withdrawal, ordering, and timeout recovery |
| 1.1.1 | No new settings | Banner service disclosures/chevrons and matching CSS |
| 1.1.0 | `ui.variant`; absent keeps Standard | Banner variant prop/attribute and matching CSS |
| 1.0.0 | Merge stable preset settings and purposes; reject cookie-name collisions | Views, assets, preset translations; unchanged fingerprints and schema 1 remain compatible |

## Language and theme update

When updating an existing English/Polish, light-only installation, merge the language and theme changes into application-owned files. Older versions such as 1.1.3 reject `theme` and `dark_colors`; update the package before using the new keys.

Version **1.2.0** adds five bundled languages, custom locale fallback, configuration-only light/dark/auto themes, and 72-hour theme warning suppression. The sectioned config adds comments/examples without changing existing defaults. See [the v1.2.0 release notes](https://github.com/jakub-lipinski/consent-for-laravel/releases/tag/v1.2.0).

Update the package in your consuming application before merging the options below:

```bash
composer require "jakub-lipinski/consent-for-laravel:^1.2.0"
php artisan view:clear
```

Commit the application's Composer files and deploy with `composer install`.

1. Merge `ui.theme => 'light'` and `ui.dark_colors => []` when opting into these settings. Old configs work without them, keeping light. Preserve your existing colors, presets, IDs, policy version, cookie scopes, and canonical purposes.
2. Merge the new `data-consent-theme` root attribute and both-palette inline override logic into customized banner views. Theme selection is config-only, not a new Blade prop or visitor button. Keep nonces and control bindings.
3. Refresh/cache-bust published `consent.css` together with the view. The theme update does not change `consent.js` or `banner.js`; update them too if skipping an earlier release that changed them. Inline components use the installed sources directly.
4. Use the additional dictionaries without publishing, or merge changes into application-owned translations. Add custom `messages.php` and optional `services.php` directly; partial dictionaries inherit parent-language and English values.
5. Clear compiled views, rebuild configuration, restart persistent workers, and verify both variants, theme modes, languages, custom colors, strict CSP, mobile layouts, keyboard, saved decisions, and an open draft during auto changes.

These presentation changes preserve the consent schema, unchanged service fingerprints, saved acceptance/refusal, and original expiry. Existing light color overrides stay light; configure dark brand colors independently.

Warning suppression uses the current default cache and adds no cache store, table, cookie, or migration. A persistent store with atomic `add` suppresses across requests; cache/logger failures skip optional diagnostics and preserve rendering. The first warning after upgrading may be reported again because grouping now includes both palettes. See [themes and diagnostics](/docs/banner-and-theme#light-dark-and-auto) and [custom locales](/docs/translations#languages-and-custom-locales).

## Switching from a VCS installation

Earlier instructions added a `repositories.consent` VCS entry. The official package is now published on Packagist. If you followed those instructions, remove that entry and resolve the same package through Packagist:

```bash
composer config --unset repositories.consent
composer update jakub-lipinski/consent-for-laravel
```

Run this in your consuming Laravel application. If you used another repository key, remove that specific entry instead; keep repositories for intentional forks or local package development. Keep the package requirement in `require`. No minimum-stability change, uninstall, or cookie migration is needed. Your published configuration and customized files remain in place. Commit the Composer file changes.

## Moving from 1.1.2 to 1.1.3

Theme contrast no longer interrupts host-page rendering. `ui.validate_contrast` defaults to `false`, including when the key is absent from existing published configuration. Set it to `true` to log contrast warnings while preserving selected colors; an unavailable logger cannot break the page. Invalid color formats fall back to their defaults, unknown color keys are ignored, and malformed color arrays use the default palette. Unsafe values never enter CSS.

Update the package, commit your Composer files, rebuild configuration/view caches, and restart persistent workers. No browser assets, views, translations, cookie schema, service fingerprints, or saved decisions need migration. If upgrading directly from 1.1.1 or earlier, also apply the corresponding earlier upgrade steps below, including the 1.1.2 JavaScript asset changes. Custom colors still need an accessibility review. See [the 1.1.3 release notes](https://github.com/jakub-lipinski/consent-for-laravel/releases/tag/v1.1.3).

## Moving from 1.1.1 to 1.1.2

This patch keeps the pending banner visible when focus moves to a large page container, saves withdrawal independently of pending integration events, and lets gated modules await the Google, Meta, or Clarity event helper without blocking their own loader. A recurring script timeout receives at most one automatic reload per tab until that script succeeds; repeated failures, or unavailable retry storage, request manual recovery through `consent:reload-required` with `automatic: false`.

Update both `consent.js` and `banner.js` if you serve published assets, preserve local customizations, and invalidate cached asset URLs. Inline components use the installed sources. Rebuild relevant application caches and restart persistent workers. CSS, banner views, configuration, translations, cookie schema, fingerprints, and saved decisions remain compatible. See [the 1.1.2 release notes](https://github.com/jakub-lipinski/consent-for-laravel/releases/tag/v1.1.2).

## Moving from 1.1.0 to 1.1.1

Both Standard and Compact now have initially collapsed, independently expandable service lists with a visible chevron beside each label. Click, Enter, or Space opens and closes them. Category purposes remain visible; opening details does not change category switches, save a decision, or enable scripts.

Merge the updated banner view into published customizations: Standard also needs the native service disclosures, and both variants need the chevron in each summary. Deploy/cache-bust the matching CSS, clear compiled views, and restart persistent workers. No new configuration, translations, or cookie migration are required. See [the 1.1.1 release notes](https://github.com/jakub-lipinski/consent-for-laravel/releases/tag/v1.1.1).

## Moving from 1.0 to 1.1

Version 1.1 adds matching Standard and Compact banner/preferences variants. Existing published configuration without `ui.variant` keeps `standard`; set it to `compact` or use `<x-consent::banner variant="compact" />` to opt in. Both retain complete category purposes and service information; since 1.1.1, both variants use native, keyboard-accessible service disclosures with a state-indicating chevron.

No new translation keys or cookie migration are required. Variant changes do not invalidate or extend saved decisions. Presets, purpose fingerprints, cookie schema, retention, and browser APIs remain compatible. The release also isolates policy-link and button spacing from generic host styles.

Merge the current banner view deliberately, including the `variant` prop, `data-consent-variant` root attribute, and service disclosures. Update the CSS and views together; republish/cache-bust separate assets, rebuild configuration/view caches, and restart persistent workers. Check both variants in the integrated host application. See [the 1.1.0 release notes](https://github.com/jakub-lipinski/consent-for-laravel/releases/tag/v1.1.0).

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

Restart long-running workers. Rebuild route caches too when enabling auditing or changing its endpoint. Inline default components use the installed assets directly. Test pending, refusal, acceptance, expiry, withdrawal, CSP, keyboard, and mobile behavior in the host application; with auditing enabled, also verify receipts, signed notices, retries, and storage failure.

## Provider configuration

Remove duplicate vendor bootstraps and colliding manual purposes before enabling presets. GA4/Google Ads use [Google Consent Mode](/docs/google-consent-mode). [Meta Pixel](/docs/meta-pixel) requires marketing permission. [Clarity](/docs/microsoft-clarity) requires analytics permission; advertising additionally requires explicit enablement and marketing permission. Enable Require cookie consent and review masking in your Clarity project.

Provider settings and processing purposes remain the application's responsibility. An upgrade does not configure an account or establish legal compliance.
