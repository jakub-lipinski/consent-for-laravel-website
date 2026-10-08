## Mount the interface

After [installing and configuring the package](/docs/quick-start), place the head component in your shared layout's head and the banner in its body:

```blade
<x-consent::head />
<x-consent::banner />
```

The built-in interface needs both components. They render once per response. A visitor without a current decision sees a banner with accept, reject, and preferences actions. Optional switches start off. A refusal is remembered just like an acceptance.

After a choice, a small button reopens preferences. If no optional service is registered, only the button appears, allowing visitors to read the necessary category. The modal shows actual purposes and only used optional categories.

## Two matching variants

Set `consent.ui.variant` to `standard` (default) or `compact`. The setting selects both the banner and its preferences dialog; it is independent of position, colors, and language. Existing published configurations without the setting keep Standard. Invalid values are rejected.

- **Standard** preserves the original spacious cards/dialog, filled acceptance/refusal buttons.
- **Compact** uses smaller cards/dialogs, less spacing, simpler corners, outlined acceptance/refusal buttons, and side-by-side choices on wider cards. Category purposes remain visible in both variants.

Both keep the same wording, consent actions, purposes, policy links, switches, and draft/save/withdrawal behavior. In both variants, complete service lists start collapsed inside native disclosures. A chevron beside the label points down when closed and up when open; click, Enter, or Space toggles each category independently. Opening service information makes no decision and does not change category switches. Changing appearance does not invalidate or extend a saved choice. Both variants stack actions and scroll long content on small screens. At the default font size, choice controls are at least 48 CSS pixels high in Standard and 44 in Compact.

The interactive website preview switches both surfaces together, keeps its choices in memory only, and runs no package scripts or trackers.

## Three positions

```php
'ui' => [
    'variant' => 'standard', // standard or compact
    'position' => 'bottom-left',
    'locale' => null,
    'policy_url' => '/cookies',
    'colors' => [],
],
```

- `bottom-left`: card in the lower left.
- `bottom-right`: card in the lower right.
- `bottom-center`: a wide horizontal layout on larger screens.

All three stack on small screens. The launcher follows the selected position. The package's default interface is a white card with a subtle shadow and sentence-case copy. The website preview is illustrative and does not execute package scripts or store decisions.

## Component overrides

```blade
<x-consent::banner
    variant="compact"
    locale="pl"
    position="bottom-right"
    policy-url="/cookies"
/>
```

Use the app locale by leaving `locale` as `null`. Explicit overrides accept only `en` or `pl`. A policy URL may be an absolute website path or an HTTP(S) URL without credentials. Create the example `/cookies` page in your app or use your existing policy URL; the package does not register that route. Whitespace, backslashes, unsafe schemes, and relative paths are rejected. `null` omits the link. Refresh [cached configuration](/docs/configuration#apply-configuration-changes) after editing UI settings in `config/consent.php`.

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

Variant, position, colors, language, and policy links can be configured without publishing views. Publish only when you need to change the component markup:

```bash
php artisan vendor:publish --tag=consent-views
```

Published files are application-owned. Preserve the package's control bindings, labels, native dialog behavior, and focus protections. Recheck contrast, geometry, reflow, text resizing, and keyboard interaction after changes. Variant, theme, position, and UI language changes do not invalidate or extend a decision.

When upgrading published views, merge the `variant` prop and `data-consent-variant` root attribute along with the service disclosures and summary chevrons. Update and cache-bust published styles/scripts together with the views. See [upgrading](/docs/upgrading).
