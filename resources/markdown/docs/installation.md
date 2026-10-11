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

The current documented release is [v1.4.1](https://github.com/jakub-lipinski/consent-for-laravel/releases/tag/v1.4.1), with script-gating, loading-order, audited-reload, and save-error fixes. Matomo, TikTok Pixel, Laravel Boost resources, optional audit history, seven languages, and light/dark/auto themes remain included. Composer resolves a compatible stable release directly from Packagist. No custom repository, Git clone, or minimum-stability change is needed. [GitHub](https://github.com/jakub-lipinski/consent-for-laravel) hosts the source and release notes.

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

The [v1.4.1 tag CI matrix](https://github.com/jakub-lipinski/consent-for-laravel/actions/runs/38172381014) passed all eight PHP 8.3/8.4 and Laravel 12/13 lowest/highest dependency combinations. The release's local `composer check` passed on PHP 8.4.25 / Laravel 13.35.0 / Node 22.21.1, including **531 PHP tests / 2680 assertions** and **258 JavaScript tests**. Native Chrome checks covered script mutation, dynamic order, detachment, audited reloads with SQLite, and save-error retries in both variants and all seven languages at 320px and 200% text size. CI coverage and locally executed checks are separate; they do not cover every possible dependency version. See [the v1.4.1 verification](https://github.com/jakub-lipinski/consent-for-laravel/blob/v1.4.1/docs/releases/v1.4.1.md#verification) for scope and limitations.

Continue with [the quick start](/docs/quick-start).
