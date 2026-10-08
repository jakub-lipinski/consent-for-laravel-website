## English and Polish

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

Default GA4/Ads purposes and the Advanced-mode disclosure are available in English and Polish. Canonical preset name/description changes keep their custom wording rather than being replaced by bundled defaults. You can explicitly translate the `google-ga4` / `google-ads` display fields in `consent::services`. Published `messages.php` files should merge beta.4's `presets` and `google_advanced` keys.
