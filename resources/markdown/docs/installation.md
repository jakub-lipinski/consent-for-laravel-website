## Requirements

- PHP 8.3 or newer.
- Laravel 12 or 13, Composer 2, and provider auto-discovery.
- A browser capable of running the package's JavaScript. The built-in preferences interface uses native `dialog` support.

No npm installation or frontend build step is required in the consuming app. With auditing disabled, no database tables, migrations, or application endpoint are required. Optional [audit history](/docs/audit-log) requires a database, a published migration, an application signing key, and the same-origin JSON endpoint.

## Install with Composer

The package is officially available on [Packagist](https://packagist.org/packages/jakub-lipinski/consent-for-laravel). Run these commands in your Laravel application's root directory, where its `composer.json` and `artisan` files live:

```bash
composer require jakub-lipinski/consent-for-laravel
php artisan vendor:publish --tag=consent-config
```

The current documented release is **v1.5.2**, with optional Livewire 3/4 support and nine bundled languages, including Czech and Dutch. Existing tracker presets, Laravel Boost resources, optional audit history and light/dark/auto/inherit themes remain included. Composer resolves a compatible stable release directly from Packagist. No custom repository, Git clone, or minimum-stability change is needed. [GitHub](https://github.com/jakub-lipinski/consent-for-laravel) hosts the source and release notes.

The provider is discovered automatically. If your application disables discovery or installs with `--no-scripts`, see [provider troubleshooting](/docs/troubleshooting#configuration-cannot-be-published).

Commit your application's `composer.json` and `composer.lock`; production deployments use `composer install` to reproduce the locked version. Check the installed release with:

```bash
composer show jakub-lipinski/consent-for-laravel
```

If you installed through the earlier VCS instructions, follow [switching to Packagist](/docs/upgrading#switching-from-a-vcs-installation).

## What to configure next

Publishing creates `config/consent.php`. All tracker presets are disabled and custom `services` is empty by default. Installing the package alone does not start tracking or show the initial banner: with no optional purpose, the mounted interface shows only the preferences launcher.

Enable a [built-in preset](/docs/configuration#choose-an-integration) and set its ID, or register a [custom service](/docs/services-and-categories) and gate its scripts. Then add the head and banner to your layout and set your policy link. The [quick start](/docs/quick-start) walks through both options.

## Published resources

| Tag | Destination | Purpose |
| --- | --- | --- |
| `consent-config` | `config/consent.php` | Services, preference/audit settings, loader, presets, and UI |
| `consent-views` | `resources/views/vendor/consent` | Optional component customization |
| `consent-translations` | `lang/vendor/consent` | Interface messages and service translations |
| `consent-assets` | `public/vendor/consent` | Separate JavaScript and CSS files |
| `consent-audit-migrations` | `database/migrations` | Optional decision/notice tables; publish and migrate only for audit history |

Start with `consent-config`. Bundled translations, component views, JavaScript, and CSS work from the installed package without publishing them. Publish the other groups only when customizing their files or serving separate assets. Read [CSP and assets](/docs/csp-and-caching) if your deployment requires separate files or nonces.

## Optional audit installation

Keep `audit.enabled` disabled until the connection and table names are selected and the migration has run. Publishing `consent-config` alone does not create tables. Follow [audit enablement](/docs/audit-log#enable) for the full sequence, then rebuild configuration and route caches and refresh published views/assets. Existing users should follow [the upgrade guide](/docs/upgrading#decision-audit-log-update) rather than overwriting their config.

## Optional Laravel Boost resources

Boost can install the package's short guideline and development skill for your selected agents. It is a separate development dependency; installing the consent package needs no Boost setup and activates no AI resource automatically. See [Laravel Boost](/docs/laravel-boost) for installation, copied reference files, updates, and application overrides.

## Configuration caching

While developing, clear any existing configuration cache after editing `config/consent.php` or preset IDs in `.env`:

```bash
php artisan config:clear
```

During production deployment, rebuild the cache after the environment values and configuration are in place:

```bash
php artisan config:cache
```

Restart long-running application workers after deployment. Keep configuration serializable: use arrays and scalar values rather than closures or runtime objects.

## Compatibility

For v1.5.0, the [package CI matrix](https://github.com/jakub-lipinski/consent-for-laravel/actions/runs/39154603383) passed PHP 8.3/8.4 with Laravel 12/13 and lowest/highest dependency combinations. The separate [Livewire checks](https://github.com/jakub-lipinski/consent-for-laravel/actions/runs/39154603376) passed sixteen PHP/Laravel/Livewire combinations, including pinned 3.8.10/4.4.7 baselines and compatible updates, plus Chromium, Firefox and WebKit on four Laravel/Livewire hosts.

For v1.5.2, local `composer check` passed on PHP 8.4.25 / Laravel 13.35.0 / Node 22.21.1 with **593 PHP tests / 3225 assertions** and **309 JavaScript tests**, with ten optional real-Livewire integration skips in the package baseline. Disposable Laravel 12.70.0 / Livewire 3.8.10 and Laravel 13.37.0 / Livewire 4.4.7 hosts passed **202 Chromium/WebKit cases**. Chromium-only garbage-collection cases skip WebKit; six Livewire 4-only browser cases also skip Livewire 3. Coverage includes TikTok readiness across swaps, serialized Blade expressions, detached DOM collection, inherited themes, CSP, modules, history, language changes, shared-cookie audit receipts, active withdrawal, keyboard/focus, reflow, and enlarged text. The CI links above describe v1.5.0; these local checks do not establish a new CI or local Firefox pass, every dependency combination, custom view, screen reader, live vendor report, or complete host-site accessibility.

Continue with [the quick start](/docs/quick-start).
