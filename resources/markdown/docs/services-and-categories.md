## Services describe purposes

Configure a stable ID for each service. The registry is global to the website, not just the current route. Service definitions must contain a category, a non-empty UTF-8 name, and a meaningful description.

```php
'services' => [
    'site-insights' => [
        'category' => 'analytics',
        'name' => 'Site insights',
        'description' => 'Measure visits and navigation.',
        'enabled' => true,
        'cookies' => [
            ['name' => '_insights', 'path' => '/', 'domain' => null],
            ['prefix' => '_insights_', 'path' => '/', 'domain' => null],
        ],
    ],
],
```

`enabled` defaults to `true` and must be an actual boolean. Disabled definitions are still validated but are excluded from the active registry. Unknown options are rejected. IDs start with a letter, contain only letters, digits, dots, underscores, or hyphens, and are at most 128 characters long.

## The five categories

| Key | Default English label | Intended purpose |
| --- | --- | --- |
| `necessary` | Necessary | Essential site operation and remembering preferences |
| `analytics` | Analytics | Audience and usage measurement |
| `marketing` | Marketing | Advertising and campaign measurement |
| `performance` | Performance | Performance measurement and diagnostics |
| `other` | Other | Additional purposes clearly described by your service |

Necessary is always allowed. Assign categories according to actual processing. Putting an optional tracker into necessary does not make it essential or exempt from applicable requirements. The package does not scan or classify cookies for you.

Preferences show necessary plus the optional categories used by enabled services. Acceptance is category-based, not an individual toggle for each service. Services within the same category share its decision.

## Cookie cleanup declarations

Each cookie rule uses exactly one `name` or `prefix`. `path` defaults to `/` and `domain` to `null`. Supply the actual domain and path where the service writes its cookie. A prefix can match several visible cookies, so use a precise service-specific prefix.

The runtime can remove only accessible first-party cookies in the declared scope. Protected application cookies are excluded. Read [withdrawal and cleanup](/docs/withdrawal) for the limits.

## Registry API

```php
use ConsentForLaravel\ConsentForLaravel\ServiceRegistry;

$services = app(ServiceRegistry::class);
$services->all();
$services->get('site-insights');
$services->forCategory('analytics');
$services->categories();
$services->uses('analytics');
$services->version();
```

`all()` returns enabled services keyed by ID. `get()` returns immutable metadata and throws `InvalidArgumentException` for an unknown or disabled ID. `categories()` returns `Category` enum cases in necessary, analytics, marketing, performance, other order, excluding unused optional categories. `uses()` tells you whether a category is active, with necessary always active. `version()` is the deterministic active-service fingerprint. Category-taking registry methods accept a `Category` enum case or a valid category string; invalid strings throw `ValueError`.

## Purpose changes invalidate choices

Adding, removing, enabling, disabling, or materially changing an active service invalidates previous decisions. UI translations can be provided separately without changing the fingerprint. Read [translations](/docs/translations) and [persistence](/docs/persistence).
