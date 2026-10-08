## Requirements

- PHP 8.3 or newer.
- Laravel 12 or 13 with Composer and provider auto-discovery.
- A browser capable of running the package's JavaScript. The built-in preferences interface uses native `dialog` support.

No npm installation, frontend build step, database, migrations, or application endpoint is required in the consuming app.

## Install with Composer

Install the stable GitHub release through Composer. Register the official VCS source once in your Laravel application:

```bash
composer config repositories.consent vcs https://github.com/jakub-lipinski/consent-for-laravel.git
composer require jakub-lipinski/consent-for-laravel:^1.1.1
php artisan vendor:publish --tag=consent-config
```

Packagist does not currently index this package. The VCS source lets Composer resolve the stable `v1.1.1` GitHub tag. Your application's `composer.lock` records the installed version; no reduced minimum stability or development branch is needed.

The Composer publisher and GitHub owner are both `jakub-lipinski`. The provider is discovered automatically through Spatie Laravel Package Tools. Configure your purposes and enabled presets before adding the [head and banner components](/docs/quick-start).

## Published resources

| Tag | Destination | Purpose |
| --- | --- | --- |
| `consent-config` | `config/consent.php` | Services, persistence, loader, presets, and UI settings |
| `consent-views` | `resources/views/vendor/consent` | Optional component customization |
| `consent-translations` | `lang/vendor/consent` | Interface messages and service translations |
| `consent-assets` | `public/vendor/consent` | Separate JavaScript and CSS files |

Only configuration is normally needed. The default components embed their assets, so publishing browser files is optional. Read [CSP and assets](/docs/csp-and-caching) if your deployment requires separate files or nonces.

## Configuration caching

After editing configuration, rebuild any existing cache and restart long-running application workers:

```bash
php artisan config:cache
```

Keep configuration serializable. Use arrays and scalar values rather than closures or runtime objects.

## Compatibility

The version 1.1 CI matrix passed all eight PHP 8.3/8.4 and Laravel 12/13 lowest/highest dependency combinations. Local package verification used PHP 8.4 / Laravel 13, including a clean installation from the exported archive. These checks describe the tested combinations, not every possible dependency version.

Continue with [the quick start](/docs/quick-start).
