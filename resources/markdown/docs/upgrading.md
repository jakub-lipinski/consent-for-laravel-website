## Updating within version 1

Review [package releases](https://github.com/jakub-lipinski/consent-for-laravel/releases) and the stable versions on [Packagist](https://packagist.org/packages/jakub-lipinski/consent-for-laravel). To use the documented release and allow compatible updates within version 1:

```bash
composer require "jakub-lipinski/consent-for-laravel:^1.1.1"
```

If your application already allows the desired version, use `composer update jakub-lipinski/consent-for-laravel`. Commit the resulting `composer.json` and `composer.lock` changes; deploy with `composer install` to reproduce that version. The public PHP, Blade, browser, and configuration APIs documented here belong to the stable version 1 series. The library itself does not commit a dependency lock file; your application normally should.

## Switching from a VCS installation

Earlier instructions added a `repositories.consent` VCS entry. The official package is now published on Packagist. If you followed those instructions, remove that entry and resolve the same package through Packagist:

```bash
composer config --unset repositories.consent
composer update jakub-lipinski/consent-for-laravel
```

Run this in your consuming Laravel application. If you used another repository key, remove that specific entry instead; keep repositories for intentional forks or local package development. Keep the package requirement in `require`. No minimum-stability change, uninstall, or cookie migration is needed. Your published configuration and customized files remain in place. Commit the Composer file changes.

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

Restart long-running workers. Inline default components use the installed assets directly. Test pending, refusal, acceptance, expiry, withdrawal, CSP, keyboard, and mobile behavior in the host application.

## Provider configuration

Remove duplicate vendor bootstraps and colliding manual purposes before enabling presets. GA4/Google Ads use [Google Consent Mode](/docs/google-consent-mode). [Meta Pixel](/docs/meta-pixel) requires marketing permission. [Clarity](/docs/microsoft-clarity) requires analytics permission; advertising additionally requires explicit enablement and marketing permission. Enable Require cookie consent and review masking in your Clarity project.

Provider settings and processing purposes remain the application's responsibility. An upgrade does not configure an account or establish legal compliance.
