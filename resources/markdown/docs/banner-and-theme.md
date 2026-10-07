## Mount the interface

```blade
<x-consent::head />
<x-consent::banner />
```

The built-in interface needs both components. They render once per response. A visitor without a current decision sees a banner with accept, reject, and preferences actions. Optional switches start off. A refusal is remembered just like an acceptance.

After a choice, a small button reopens preferences. If no optional service is registered, only the button appears, allowing visitors to read the necessary category. The modal shows actual purposes and only used optional categories.

## Three positions

```php
'ui' => [
    'position' => 'bottom-left',
    'locale' => null,
    'policy_url' => '/cookies',
    'colors' => [],
],
```

- `bottom-left`: compact card in the lower left.
- `bottom-right`: compact card in the lower right.
- `bottom-center`: a wide horizontal layout on larger screens.

All three stack on small screens. The launcher follows the selected position. The package's default interface is a white card with a subtle shadow and sentence-case copy. The website preview is illustrative and does not execute package scripts or store decisions.

## Component overrides

```blade
<x-consent::banner
    locale="pl"
    position="bottom-right"
    policy-url="/cookies"
/>
```

Use the app locale by leaving `locale` as `null`. Explicit overrides accept only `en` or `pl`. A policy URL may be an absolute website path or an HTTP(S) URL without credentials. Whitespace, backslashes, unsafe schemes, and relative paths are rejected. `null` omits the link.

## Theme colors

Colors must be six-digit hex values. Supply only the keys you wish to change:

```php
'colors' => [
    'accent' => '#245c49',
    'focus' => '#245c49',
],
```

| Key | Default | Role |
| --- | --- | --- |
| `background` | `#ffffff` | Card, dialog, and launcher |
| `text` | `#182722` | Headings and ordinary text |
| `muted` | `#52625b` | Secondary descriptions |
| `accent` | `#245c49` | Buttons, links, selected switches |
| `accent_text` | `#ffffff` | Content on the accent |
| `border` | `#e1e7e3` | Decorative dividers |
| `control` | `#67776e` | Outlined controls and unchecked switches |
| `focus` | `#245c49` | Keyboard focus outline |

The renderer rejects invalid colors and combinations below 4.5:1 for text, muted text, accent links, and accent button text. Controls and focus need at least 3:1 against the interface background. Decorative borders are not checked as controls.

## Preferences and custom openers

```blade
<button type="button" data-consent-open>Cookie preferences</button>
```

```js
const opened = window.Consent.openPreferences();
```

The browser method returns `true` if the mounted UI handles the request and `false` otherwise. Opening, closing, Escape, backdrop dismissal, and draft checkbox changes do not grant permission or write a cookie. Dismissing a pending banner applies only to the current document; a later visit can show it again.

## Customize published views

```bash
php artisan vendor:publish --tag=consent-views
```

Published files are application-owned. Preserve the package's control bindings, labels, native dialog behavior, and focus protections. Recheck contrast, geometry, reflow, text resizing, and keyboard interaction after changes. Theme, position, and UI language changes do not invalidate a decision.
