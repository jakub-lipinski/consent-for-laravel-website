## Published configuration

```bash
php artisan vendor:publish --tag=consent-config
```

Install the package from [Packagist](https://packagist.org/packages/jakub-lipinski/consent-for-laravel) first; see [installation](/docs/installation). The command above copies its default configuration into `config/consent.php`. All settings live under Laravel's `consent` configuration key.

Edit the existing entries in that file. The examples in these guides are excerpts, so keep unrelated settings and other presets rather than replacing the entire returned array. Configuration must be serializable: use arrays and scalar values, with `env()` calls only inside configuration files. Partial cookie, loader, and UI arrays retain defaults for omitted settings.

## Choose an integration

All presets start with `enabled` set to `false`, and `services` starts empty. For each built-in integration you use, set its existing `enabled` entry to the boolean `true` and provide the corresponding ID in `.env` or your production environment:

| Integration | Set to `true` in `config/consent.php` | Environment ID | Required category in Basic mode |
| --- | --- | --- | --- |
| [GA4](/docs/google-presets) | `presets.ga4.enabled` | `CONSENT_GA4_ID=G-XXXXXXXXXX` | `analytics` |
| [Google Ads](/docs/google-presets) | `presets.google_ads.enabled` | `CONSENT_GOOGLE_ADS_ID=AW-123456789` | `marketing` |
| [Meta Pixel](/docs/meta-pixel) | `presets.meta_pixel.enabled` | `CONSENT_META_PIXEL_ID=123456789012345` | `marketing` |
| [Microsoft Clarity](/docs/microsoft-clarity) | `presets.clarity.enabled` | `CONSENT_CLARITY_ID=abc123def4` | `analytics` |

Replace example IDs with your own. Setting an environment ID alone does not enable a preset. Presets register their purposes and load their SDKs automatically using the shared head/banner components; they need no custom service entry or `@consent` wrapper. Leave unused presets disabled. Google Advanced is an explicit alternative to Basic; Meta and Clarity remain strictly gated in either mode.

For your own scripts, add their purpose to `services` and gate the script with `@consent`; registration alone does not load code. With no optional purpose configured, the interface shows only the preferences launcher. Follow [the quick start](/docs/quick-start) for either path.

## Apply configuration changes

During local development, clear any existing cache after editing this file or environment IDs:

```bash
php artisan config:clear
```

In production, rebuild the cache after the environment values and configuration are ready, then restart long-running workers:

```bash
php artisan config:cache
```

Reload the browser page to receive the new configuration. Do not force-publish `consent-config` over your existing settings when updating the package; merge new options as described in [upgrading](/docs/upgrading).

## Policy and retention

| Key | Default | Validation |
| --- | --- | --- |
| `policy_version` | `'1'` | Non-empty UTF-8 string, at most 128 bytes |
| `retention_days` | `180` | Integer from 1 to 365 |

Increment the policy version when purposes or policy change outside the registered metadata. Retention applies equally to acceptance and refusal. The default is a product setting, not a universal legal requirement.

## Cookie settings

| Key | Default | Meaning |
| --- | --- | --- |
| `cookie.name` | `'consent_preferences'` | Browser-readable preference cookie name |
| `cookie.path` | `'/'` | Cookie scope path |
| `cookie.domain` | `null` | Host-only when null |
| `cookie.secure` | `null` | Follow request HTTPS, or explicitly true/false |
| `cookie.same_site` | `'lax'` | `lax` or `strict` |

The cookie name must start with a letter, use only letters, digits, dots, underscores, or hyphens, and be at most 64 characters. Paths must start with `/` and contain no whitespace, semicolon, or control characters. Domains must be valid cookie domains of at most 254 characters, optionally starting with a dot. `secure` accepts only `null` or an actual boolean. Unknown cookie, loader, UI, and color options are rejected. Session/CSRF cookie-name collisions and names starting with `remember_` are rejected. The provider excludes only this preference cookie from encryption. `HttpOnly` is always false; it is not a configurable authorization cookie.

For proxies, old scopes, expiry, and storage limitations, read [persistence](/docs/persistence).

## Loader limits

| Key | Default | Validation |
| --- | --- | --- |
| `loader.script_timeout_ms` | `15000` | Integer from 1 to 120000 |
| `loader.cleanup_timeout_ms` | `3000` | Integer from 1 to 120000 |

A script timeout fails its block. A cleanup failure or timeout requires safe reload. These limits do not make arbitrary vendor asynchronous tasks part of the package queue.

## UI settings

| Key | Default | Accepted values |
| --- | --- | --- |
| `ui.variant` | `'standard'` | `standard` or `compact`; applies to banner and preferences dialog |
| `ui.position` | `'bottom-left'` | `bottom-left`, `bottom-right`, `bottom-center` |
| `ui.locale` | `null` | App locale fallback; explicit `en` or `pl` |
| `ui.policy_url` | `null` | Absolute website path or safe HTTP(S) URL |
| `ui.validate_contrast` | `false` | Boolean; `true` logs contrast warnings and preserves selected colors |
| `ui.colors` | `[]` | Known six-digit hex colors; malformed values fall back without interrupting rendering |

Color keys are `background`, `text`, `muted`, `accent`, `accent_text`, `border`, `control`, and `focus`. Defaults and contrast rules are listed in [banner and theme](/docs/banner-and-theme).

## Services

`services` defaults to an empty array. Define services keyed by stable IDs. Required fields are `category`, `name`, and `description`. Optional fields are boolean `enabled` and a `cookies` array.

Cookie rules accept exactly one `name` or `prefix`, optional `path` (default `/`), and optional `domain` (default `null`). Cookie names/prefixes start with a letter, digit, or underscore, use letters, digits, dots, underscores, and hyphens, and are at most 128 characters. Wildcards are not supported. Rules must form a list, not an associative map. Their scope follows the preference-cookie path/domain validation. Unknown service options, unknown categories, invalid IDs, and malformed rules are rejected.

See [services and categories](/docs/services-and-categories) for examples and fingerprint behavior.

## Google bridge and presets

| Key | Default | Validation |
| --- | --- | --- |
| `google.enabled` | `null` | Auto with enabled Google presets; `true` for a manual bridge; `false` disables it |
| `google.mode` | `'basic'` | `basic` or explicit `advanced` |
| `presets.ga4.enabled` | `false` | Boolean |
| `presets.ga4.measurement_id` | `env('CONSENT_GA4_ID')` | `G-` plus 4-32 uppercase letters/digits; required if enabled |
| `presets.ga4.send_page_view` | `true` | Boolean |
| `presets.google_ads.enabled` | `false` | Boolean |
| `presets.google_ads.conversion_id` | `env('CONSENT_GOOGLE_ADS_ID')` | `AW-` plus 1-20 digits, first 1-9; required if enabled |

Both presets also accept optional `name`, `description`, `cookie_path` (default `/`), and `cookie_domain` (default `null`). Names/descriptions follow service validation; cookie scopes follow existing cookie-rule validation. Unknown Google/preset keys, malformed disabled definitions, enabled presets alongside `google.enabled: false`, and manual service collisions with enabled preset IDs are rejected.

Cleanup scope declarations do not configure the vendor's cookie scope. Match actual cookies, including parent domains chosen by Google. Google mode/target/init changes are part of the consent fingerprint. See [Consent Mode](/docs/google-consent-mode) and [Google presets](/docs/google-presets) for the signal mapping and complete behavior.

## Meta Pixel and Clarity presets

| Key | Default | Validation |
| --- | --- | --- |
| `presets.meta_pixel.enabled` | `false` | Boolean |
| `presets.meta_pixel.pixel_id` | `env('CONSENT_META_PIXEL_ID')` | String of 1-20 digits, first 1-9; required when enabled |
| `presets.meta_pixel.send_page_view` | `true` | Boolean |
| `presets.clarity.enabled` | `false` | Boolean |
| `presets.clarity.project_id` | `env('CONSENT_CLARITY_ID')` | String of 1-32 lowercase letters/digits; required when enabled |
| `presets.clarity.advertising` | `false` | Boolean; ad storage additionally needs analytics and marketing permission |

Both accept canonical `name`/`description` and cleanup `cookie_path`/`cookie_domain` with the same validation as services. Clarity also accepts `advertising_name`/`advertising_description` for its separate marketing purpose. Disabled definitions are validated; unknown keys, malformed IDs/options, and collisions with enabled preset service IDs are rejected.

Reserved IDs: `meta-pixel`, `microsoft-clarity`, and, with advertising enabled, `microsoft-clarity-ads`. Meta declares `_fbp`/`_fbc`; Clarity declares `_clck`/`_clsk`. Match actual scopes; declarations do not set vendor cookie domains or remove third-party data. ID/options/purposes/scopes enter the consent fingerprint. Google Advanced never relaxes these gates. See [Meta Pixel](/docs/meta-pixel) and [Clarity](/docs/microsoft-clarity).

## Component props

| Component | Props |
| --- | --- |
| `x-consent::head` | `nonce`, `src` |
| `x-consent::banner` | `nonce`, `locale`, `variant`, `position`, `policyUrl`, `styleSrc`, `scriptSrc` |

Use kebab-case attributes in Blade, such as `policy-url`, `style-src`, and `script-src`. Bind values with `:` when they come from PHP expressions. Published asset destinations are in [CSP and caching](/docs/csp-and-caching).
