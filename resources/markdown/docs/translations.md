## English and Polish

This section describes stable **v1.1.3**. Five additional bundled languages and custom locale selection are documented below as [unreleased additions](#unreleased-languages-and-custom-locales).

`ui.locale` is `null` by default, following the application's locale. `pl`, `pl_PL`, and `pl-PL` select Polish. Other application locales fall back to English. An explicit UI override must be `en` or `pl`.

```php
'ui' => [
    'locale' => 'pl',
],
```

```blade
<x-consent::banner locale="en" />
```

## Publish interface messages

English and Polish work from the installed package without publishing files. Publish translations only when changing the bundled wording:

```bash
php artisan vendor:publish --tag=consent-translations
```

Edit `lang/vendor/consent/en/messages.php` or `lang/vendor/consent/pl/messages.php`. Preserve accurate meaning, accessible names, and equal prominence for acceptance and rejection. Longer translations need reflow and text-resizing checks.

## Translate service descriptions

Canonical registry metadata remains the source of truth and contributes to the consent fingerprint. To localize display text separately, create `lang/vendor/consent/pl/services.php`:

```php
<?php

return [
    'site-insights' => [
        'name' => 'Statystyki strony',
        'description' => 'Pomiar odwiedzin i sposobu korzystania ze strony.',
    ],
];
```

A missing translation falls back to the service's canonical name and description. IDs containing dots use Laravel's dot lookup and need corresponding nested translation arrays.

## Language and consent versions

Changing display translations does not invalidate a decision. A material change of processing purpose must update canonical service metadata or your application-owned `policy_version`, even if the displayed wording is also translated.

If you share-cache HTML in multiple languages, vary the cache by locale. Inert script blocks are preference-independent, but translated interface text still depends on the language of the response.

## Google preset wording

Default GA4/Ads, Meta, and Clarity purposes and the Advanced-mode disclosure are available in English and Polish. Canonical preset name/description changes keep their custom wording rather than being replaced by bundled defaults. You can explicitly translate the `google-ga4` / `google-ads` display fields in `consent::services`. Published `messages.php` files should retain `google_advanced` and all used preset purposes under `presets`, including `meta-pixel`, `microsoft-clarity`, and `microsoft-clarity-ads`. The same `consent::services` display overrides work for these IDs. Canonical description changes still affect the fingerprint.

Standard and Compact share the same interface dictionaries and service-purpose translations. No extra translation keys are needed for version 1.1; both variants' service disclosures use the existing `services_label` message.

## Unreleased languages and custom locales

The following behavior is implemented for the next package release and is **not yet available in v1.1.3 on Packagist**. Standard and Compact share the same dictionaries, including category purposes, preset descriptions, accessible names, status/error messages, and the Advanced Google notice.

| Locale | Bundled language |
| --- | --- |
| `en` | English |
| `pl` | Polish |
| `de` | German |
| `fr` | French |
| `it` | Italian |
| `es` | Spanish |
| `pt` | European Portuguese |

Publishing is not required to use these defaults. Select a locale through the component, config, or app; precedence is **component > config > application**. The package does not change the application's locale.

```php
'ui' => [
    'locale' => 'fr',
],
```

```blade
<x-consent::banner locale="fr-CA" />
```

### Add your own language

There is no package language allowlist. For example, create `lang/vendor/consent/nl/messages.php` directly in your application:

```php
<?php

return [
    'banner_title' => 'Uw privacy telt',
    'accept_all' => 'Alles accepteren',
    'reject_optional' => 'Optionele weigeren',
];
```

Set the app locale or `ui.locale` to `nl`, or use `<x-consent::banner locale="nl" />`. A partial file overrides these keys and inherits the rest; copy the structure of a bundled dictionary to translate the entire interface. No translation/view publishing step is needed to add this file. Publishing bundled dictionaries is still available for wording overrides.

### Regional and per-key fallback

Requested tags fall back through their parents and then English: `fr-CA` → `fr` → `en`, or `zh-Hant-TW` → `zh-Hant` → `zh` → `en`. This chain is independent of the app's configured fallback locale. Missing or blank keys inherit the next dictionary. Translation values must be strings.

Use normalized hyphen or underscore directories, such as `fr-CA` or `fr_CA`. If both supply the same key, the hyphen form wins. A regional file can override just a few messages while inheriting the parent language.

A syntactically valid language without dictionaries safely renders English instead of failing. Malformed explicit tags remain configuration errors; examples of supported syntax are `nl`, `fr-CA`, and `pt_BR`. Conventional casing and underscores are normalized. The root `lang` uses the first matching nonempty UI dictionary, or `en` if none matches. A regional service-only dictionary is still considered even when UI text comes from a parent language.

### Service text and custom wording

Create `lang/vendor/consent/{locale}/services.php` using the service structure shown above. Service display translations follow the same parent-language/English chain, then canonical metadata. Built-in preset wording is translated only if its canonical name/description has not been customized; explicit service translations can still override it. IDs containing dots require corresponding nested arrays.

Display wording and locale changes preserve consent fingerprints and original decision expiry. A real purpose change still needs updated canonical metadata or `policy_version`. Vary shared HTML caches by the locale used to render the UI, including config/component overrides. The built-in layout is left-to-right; custom RTL languages also need a published view/layout adaptation and native browser verification.

See [the unreleased upgrade guidance](/docs/upgrading#unreleased-ui-update) for application-owned dictionaries.
