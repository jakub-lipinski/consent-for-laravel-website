## Requirements

- PHP 8.3 or newer.
- Laravel 12 or 13 with Composer and provider auto-discovery.
- A browser capable of running the package's JavaScript. The built-in preferences interface uses native `dialog` support.

No npm installation, frontend build step, database, migrations, or application endpoint is required in the consuming app.

## Install with Composer

Run these commands in your Laravel application:

```bash
composer require webcrafts-studio/consent-for-laravel
php artisan vendor:publish --tag=consent-config
```

Composer resolves the stable package from Packagist. Your application's `composer.lock` records the installed version. You do not need a custom repository or a reduced minimum stability.

The Composer publisher is `webcrafts-studio`; the GitHub owner is `jakub-lipinski`. The provider is discovered automatically through Spatie Laravel Package Tools. Configure your purposes and enabled presets before adding the [head and banner components](/docs/quick-start).

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

CI covers PHP 8.3/8.4 across Laravel 12/13 with lowest and highest dependency selections. Local release verification also exercises four isolated installed configurations: highest Laravel 12/13 on PHP 8.3 and lowest Laravel 12/13 on PHP 8.4. These checks describe the tested combinations, not every possible dependency version.

Continue with [the quick start](/docs/quick-start).
