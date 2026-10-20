## Updating within version 1

Review [package releases](https://github.com/jakub-lipinski/consent-for-laravel/releases) and the stable versions on [Packagist](https://packagist.org/packages/jakub-lipinski/consent-for-laravel). To use the documented release and allow compatible updates within version 1:

```bash
composer require "jakub-lipinski/consent-for-laravel:^1.5.2"
```

If your application already allows the desired version, use `composer update jakub-lipinski/consent-for-laravel`. Commit the resulting `composer.json` and `composer.lock` changes; deploy with `composer install` to reproduce that version. The APIs documented here belong to the version 1 series. The library itself does not commit a dependency lock file; your application normally should.

## Navigation fixes and inherited themes

Version **1.5.2** fixes TikTok SDK readiness across Livewire visits, preserves Blade/PHP expressions containing script-like values in gated Livewire 4 component scripts, and releases detached page DOM while preserving script identities and revocation history. It also adds the optional `ui.theme=inherit` mode. Existing APIs, configuration defaults, cookie schema, service fingerprints, and saved-choice lifetimes remain compatible. No migration, policy-version change, or consent reset is required.

1. Update the package with the command above, commit the application's Composer files, and preserve its existing services, presets, cookie scopes, audit settings, colors, and wording. Production deployments use `composer install`.
2. Refresh/cache-bust published **`consent.js` and `consent.css`**, preserving application changes. Inline components use the installed sources. From 1.5.1, head/banner markup, `banner.js`, and translations do not need an update. Apply the relevant earlier steps below when skipping releases.
3. Run `php artisan view:clear` after installing the PHP changes. Livewire 4 also clears its compiled component files through this command. Invalidate stale cached HTML, rebuild relevant deployment caches, and restart persistent workers so old script preparation and inline assets are not reused.
4. To follow the website's theme switch, set `theme` to `inherit` inside the existing `ui` section. Set the host's CSS `color-scheme` to `light` or `dark` in the corresponding theme rules. Class names and data attributes alone do not define a scheme. The package selects its configured `colors` and `dark_colors`; it adds no theme observer or preference storage. Existing configs keep the light default, and browsers without `light-dark()` keep a light fallback. See [the host CSS example](/docs/banner-and-theme#follow-the-website-theme).
5. Refresh selected Boost resources with `php artisan boost:update`, preserving application overrides. The existing interface, Livewire, TikTok, and verification references cover the changes; no new skill or reference is needed.
6. Verify pending/refused/granted navigation, TikTok readiness before/during/after a swap, script-like values serialized with `@json`/`@js` in component scripts, stable-ID remounting, and active withdrawal after a template disappears. Test host theme changes against the system preference with an open draft. Memory checks need actual garbage collection or heap-retainer inspection; a remount count alone does not prove that old DOM is collectible.

## Cross-tab audit fix

Version **1.5.1** fixes an older acceptance receipt overwriting a newer saved decision from another tab when optional auditing is enabled. The runtime reconciles shared preferences before applying the receipt and discards pending choices superseded by an external change. A newer refusal, partial selection, or removal of the preference cookie stays effective, including when the original tab already refreshed its state. See [audit failures and withdrawal](/docs/audit-log#failures-and-withdrawal).

1. Update the package with the command above and commit the application's Composer files. Existing APIs, configuration, cookie schema, service fingerprints and preference lifetimes remain compatible. No migration, policy-version change or consent reset is required for this fix.
2. Refresh/cache-bust published `consent.js`, preserving application-owned changes. Inline components use the installed source. Clear compiled views and invalidate cached HTML containing the old inline runtime, refresh relevant asset/CDN caches, and restart persistent workers. From 1.5.0, no banner markup, `banner.js`, CSS or translation update is required. Apply the relevant earlier steps below when skipping releases.
3. If using Boost, refresh selected resources with `php artisan boost:update`, preserving application overrides. The existing skill and audit/verification references cover the fix; no additional skill or reference is needed.
4. In two tabs sharing cookies, delay a successful acceptance receipt in the first tab, then refuse, save a partial selection, or forget the decision in the second. For the forget scenario, begin with a saved decision so there is a preference cookie to remove. Release the held receipt both before polling and after explicitly refreshing the first tab. The newer saved state must remain effective, and scripts for denied categories must make no requests. Also verify ordinary acceptance and mixed changes with active withdrawal/reload in the host application.

## Livewire and language update

Version **1.5.0** adds optional Livewire 3/4 support and complete Czech (`cs`) and Dutch (`nl`) dictionaries. Existing browser/PHP APIs, cookie schema, service fingerprints and saved-choice lifetimes remain compatible. There is no new migration or automatic consent reset.

1. Update the package with the command above, commit the application's Composer files and preserve application-owned settings. Older published configurations inherit these optional top-level defaults:

```php
'livewire' => [
    'enabled' => true,
    'navigation' => 'auto',
],
```

2. Livewire remains optional. For apps using it, use Livewire 3.8.10+ or 4.4.7+. `auto` coordinates SPA visits; choose `reload` for full visits or boolean `enabled=false` to disable special navigation/UI coordination. Keep one head and banner in each participating shared layout. Read [Livewire](/docs/livewire) before adapting custom navigation.
3. Merge the current head and banner into customized published views. Preserve the head's `consent-runtime-context` marker, external runtime's `data-navigate-track`, and banner bootstrap's `data-navigate-once`. Keep the full UI and signed notice inside `data-consent-container`, with the bundled `wire:ignore`, presentation-dependent `wire:key` and locale/context attributes. Keep the bootstrap outside that protected container. Do not copy only the visible banner text or detach its audit notice.
4. Refresh/cache-bust published `consent.js`, `banner.js` and `consent.css` together. The CSS includes the wrapper's layout rule. Inline components use installed sources. Clear compiled Blade and Livewire component caches and invalidate old page HTML. Rebuild relevant configuration/route caches and restart persistent workers. A stale/missing runtime marker or changed configuration/assets requires fresh-document recovery.
5. Use stable explicit `@consent` IDs for dynamic components and shared scripts; keep each ID's category and code unchanged. Do not nest `@script`/`@assets` with `@consent`. Keep ordinary gated tags in single-file/multi-file views. Check [script ownership](/docs/livewire#scripts-in-components) and [CSP](/docs/livewire#csp-and-deployment): nonce-bearing Livewire 3 visits use full reloads in auto mode, while strict Livewire 4 needs its CSP-safe build and a compatible style policy.
6. To follow site-language changes, leave `ui.locale=null`, omit an explicit banner locale and set/preserve the application locale before page/component rendering. `@persist` must preserve the complete UI/notice wrapper outside components; app/config-locale changes can require a full refresh. Czech and Dutch work without publishing. Merge application-owned dictionaries as needed; partial Dutch overrides now inherit remaining Dutch package messages before English. Existing regional/custom fallback and saved-choice expiry remain unchanged.
7. Refresh selected Boost resources with `php artisan boost:update`, preserving application overrides. The package still uses one skill, now with thirteen references including Livewire. Do not maintain edits inside generated or vendor files.
8. Verify pending, refusal, restored consent, ordinary morphs, navigation, Back/Forward, locale changes, persisted UI, delayed/failed audits, CSP/modules and active withdrawal in the actual host browser. Check duplicate SDK requests, keyboard/focus, narrow layouts and enlarged text. The `consent:navigated` event sends no automatic measurement; register any guarded SPA reporting once and review vendor history settings to avoid duplicates.

Apply the relevant earlier steps below if skipping releases. The final views and assets must match the installed package.

## Stability and bug-fix update

Version **1.4.1** fixes changed script blocks, dynamic loading order, detached templates, mixed audited choices across reload, and save-error wording. **Existing APIs, configuration, cookie schema, service fingerprints, and decision lifetimes remain compatible.** No new migration or consent reset is required. See [the v1.4.1 release notes](https://github.com/jakub-lipinski/consent-for-laravel/releases/tag/v1.4.1).

1. Update the package with the command above and preserve application-owned settings. If serving published assets, refresh/cache-bust `consent.js`. Inline components use the installed sources. The banner view, `banner.js`, and CSS are unchanged from 1.4.0.
2. Merge the updated `save_failed` text into published or custom dictionaries. The bundled English text is "Your preferences could not be saved. Please try again." An audit failure can preserve earlier grants, so custom errors must not claim that every optional cookie is blocked or assume a cookie-storage failure.
3. Keep each discovered script block's ID, category, and content unchanged. Give a different logical block its own stable ID. Waiting blocks use current DOM order; detached templates cannot activate, and detaching an active block prevents its remaining scripts from starting. Removal cannot stop already running code. See [SPA integration](/docs/spa-integration#newly-inserted-fragments).
4. With auditing enabled, verify a mixed change that withdraws an active category and grants another. Withdrawal stays immediate; after reload, the runtime retries the same event and waits for a matching receipt before granting. A newer choice or failed/expired recovery keeps the new grant denied. See [audit failures and withdrawal](/docs/audit-log#failures-and-withdrawal).
5. Clear compiled views and stale HTML, rebuild relevant configuration caches, and restart persistent workers. If using Boost, refresh selected resources with `php artisan boost:update`, preserving application overrides. Verify script ordering, conflicts, removal, receipt failures, and a successful save retry in the host application.

## Matomo, TikTok, and Boost update

Version **1.4.0** adds Matomo and TikTok Pixel presets plus Laravel Boost resources. **Existing configurations keep both presets disabled** when their entries are absent. Cookie schema 1, unchanged service fingerprints, and original saved-choice expiry remain compatible. No database migration is added by this release. See [the v1.4.0 release notes](https://github.com/jakub-lipinski/consent-for-laravel/releases/tag/v1.4.0).

1. Update the package with the command above. Preserve existing services, presets, destination IDs, canonical purposes, cookie scopes, policy version, audit settings, colors, and custom wording. Do not force-publish the entire config over your application settings.
2. If using a new integration, merge the relevant entry into the existing `presets` array:

```php
'matomo' => [
    'enabled' => false,
    'url' => env('CONSENT_MATOMO_URL'),
    'site_id' => env('CONSENT_MATOMO_SITE_ID'),
    'send_page_view' => true,
    'enable_link_tracking' => true,
    'cookie_path' => '/',
    'cookie_domain' => null,
],
'tiktok_pixel' => [
    'enabled' => false,
    'pixel_id' => env('CONSENT_TIKTOK_PIXEL_ID'),
    'send_page_view' => true,
    'cookie_path' => '/',
    'cookie_domain' => null,
],
```

3. Supply the actual instance base URL/site ID or public Pixel ID, remove duplicate tracker installations, and enable only the requested preset. Matomo needs analytics consent; TikTok needs marketing. Matomo's prior-consent preset does not implement an exempt baseline. Read [Matomo](/docs/matomo), [TikTok](/docs/tiktok-pixel), and [configuration rules](/docs/configuration#matomo-and-tiktok-presets) before enabling either.
4. Refresh/cache-bust published `consent.js` before serving either enabled preset. An old runtime rejects the new configuration. Inline components use installed sources. The banner view, `banner.js`, and `consent.css` are unchanged from 1.3.0; merge earlier updates too if skipping releases. Preserve the audit notice capture block in customized views.
5. Bundled purposes work in all seven languages without publishing translations. Merge the `matomo` and `tiktok-pixel` entries under `messages.presets` into application-owned dictionaries when maintaining your own wording. Custom service display overrides and regional fallback keep their existing behavior.
6. Rebuild configuration/view caches, refresh stale page HTML, and restart long-running workers. With auditing enabled, rebuild route caches if its settings changed. Enabling a new preset or changing its destination/options/purpose/scope invalidates old decisions; visitors must choose again. Adding only Boost resources does not affect decisions.
7. Verify pending, refusal, each relevant category, restored consent, active/in-flight withdrawal, CSP, declared cookie scopes, and actual vendor reporting. Review automatic page/link/SPA settings to avoid duplicate measurements. Business events need explicit application calls after successful actions. If auditing is enabled, verify receipts, persisted notices/decisions, and immediate refusal when storage fails.

For AI assistance, install Boost as an optional development dependency if needed, then run its installer:

```bash
composer require laravel/boost --dev
php artisan boost:install
```

Select AI Guidelines, Agent Skills, this package, and your agents. Existing Boost applications can discover the newly available resources with `php artisan boost:update --discover`; subsequent updates refresh the selected guideline and complete skill. Preserve custom instructions and skill overrides through Boost's application mechanisms. Do not edit generated copies or vendor files. See [Laravel Boost](/docs/laravel-boost) for the package tree, generated files, and updates.

Version 1.4.0 introduced one development skill with twelve references, including dedicated Matomo and TikTok references. Installing it does not enable a tracker, modify consent configuration, or require runtime Boost. Applications without Boost continue using the same consent functionality.

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

See [the complete audit guide](/docs/audit-log) for tables, identity, signatures, retention, custom server interfaces, and delivery limitations. If updating from 1.1.x or earlier, also apply the relevant steps below; the final views/assets must come from the installed package version.

## Earlier releases at a glance

Apply every relevant row between your installed version and 1.5.2. Preserve application-owned settings rather than force-publishing the whole config.

| Release | Configuration changes | Published resources / migration |
| --- | --- | --- |
| 1.5.2 | Optional `ui.theme=inherit`; older configs keep light; no migration or reset | Updated `consent.js` and `consent.css`; clear compiled Blade/Livewire views; refresh selected Boost references |
| 1.5.1 | No new settings or migration | Updated `consent.js` for delayed cross-tab audit receipts; invalidate old inline HTML |
| 1.5.0 | Optional `livewire` settings; absent inherits enabled/auto; no new migration | Current head/banner, all JS/CSS assets, Czech/Dutch dictionaries, Livewire Boost reference; preserve UI/notice pairing |
| 1.4.1 | No new settings or migration | Updated `consent.js`, `save_failed` wording, and selected Boost references; preserve block identity |
| 1.4.0 | Optional Matomo/TikTok preset entries; absent keeps both off | `consent.js`, new purpose translations, optional Boost refresh; no new migration |
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
