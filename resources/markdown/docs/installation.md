## Requirements

- PHP 8.3 or newer.
- Laravel 12 or 13 with Composer and provider auto-discovery.
- A browser capable of running the package's JavaScript. The built-in preferences interface uses native `dialog` support.

No npm installation, frontend build step, database, migrations, or application endpoint is required in the consuming app.

## Install the current beta

The package is not published on Packagist at this stage. Add the verified GitHub repository as a Composer VCS source, then require the tagged beta:

```bash
composer config repositories.consent vcs https://github.com/jakub-lipinski/consent-for-laravel
composer require webcrafts-studio/consent-for-laravel:1.0.0-beta.4
php artisan vendor:publish --tag=consent-config
```

The Composer publisher is `webcrafts-studio`; the GitHub owner is `jakub-lipinski`. These names intentionally differ. The provider is discovered automatically through Spatie Laravel Package Tools.

## Work from a local checkout

For package development, add a path repository to the host application's `composer.json`. Adjust the path to your own checkout:

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "../consent-for-laravel",
            "options": { "symlink": true }
        }
    ]
}
```

```bash
composer require webcrafts-studio/consent-for-laravel:@dev
```

Use this local development setup instead of the VCS installation above. Do not combine two sources for the same package without understanding Composer repository priority.

## Published resources

| Tag | Destination | Purpose |
| --- | --- | --- |
| `consent-config` | `config/consent.php` | Services, persistence, loader, and UI settings |
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

## Compatibility notes

The package's CI is configured for PHP 8.3/8.4 across Laravel 12/13, including lowest and highest dependency selections. Local beta.4 verification covered highest Laravel 12/13 on PHP 8.3 and lowest Laravel 12/13 on PHP 8.4. Those checks are distinct from an exhaustive claim across every future dependency version.

Continue with [the quick start](/docs/quick-start).
