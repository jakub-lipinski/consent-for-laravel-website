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
    'theme' => 'light',
    'locale' => null,
    'policy_url' => '/cookies',
    'validate_contrast' => false,
    'colors' => [],
    'dark_colors' => [],
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

Use the app locale by leaving `locale` as `null`. Explicit overrides accept bundled and custom language tags; see [languages and fallback](/docs/translations#languages-and-custom-locales). A policy URL may be an absolute website path or an HTTP(S) URL without credentials. Create the example `/cookies` page in your app or use your existing policy URL; the package does not register that route. Whitespace, backslashes, unsafe schemes, and relative paths are rejected. `null` omits the link. Refresh [cached configuration](/docs/configuration#apply-configuration-changes) after editing UI settings in `config/consent.php`.

## Theme colors

Colors must be six-digit hex values. Supply only the keys you wish to change:

```php
'colors' => [
    'accent' => '#245c49',
    'focus' => '#245c49',
],
```

| Key | Light default | Role |
| --- | --- | --- |
| `background` | `#ffffff` | Card, dialog, and launcher |
| `text` | `#182722` | Headings and ordinary text |
| `muted` | `#52625b` | Secondary descriptions |
| `accent` | `#245c49` | Buttons, links, selected switches |
| `accent_text` | `#ffffff` | Content on the accent |
| `border` | `#e1e7e3` | Decorative dividers |
| `control` | `#67776e` | Outlined controls and unchecked switches |
| `focus` | `#245c49` | Keyboard focus outline |

Contrast diagnostics default to `false`, including when `ui.validate_contrast` is missing from published configuration. Set `ui.validate_contrast` to `true` to log warnings below 4.5:1 for text, muted text, accent links, and accent button text, or below 3:1 for controls and focus against the background. Warnings preserve the selected colors and never interrupt rendering, even if logging fails. Decorative borders are not checked as controls.

Invalid color formats use the corresponding default, unknown keys are ignored, and a malformed colors array uses the default palette. These format problems log a warning independently of the contrast flag. Unsafe values never enter CSS. The default palette meets the contrast thresholds; custom themes and CSS still need their own accessibility review.

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

## Light, dark, and auto

Available since **v1.2.0**. Choose the mode in `config/consent.php`; no visitor-facing theme button or new Blade theme prop is added.

```php
'ui' => [
    'theme' => 'auto', // light, dark, or auto
    'colors' => [],
    'dark_colors' => [],
],
```

This is an excerpt; keep your other UI settings.

- `light` always uses the light palette and remains the default, including in old configs without the key.
- `dark` always uses the dark palette.
- `auto` follows the browser/system preference through CSS `prefers-color-scheme`, including live changes. Browsers without this media feature stay light.

Standard and Compact share the selected palette across the banner, preferences dialog, fallback, and launcher. Scoped `color-scheme` matches native controls and scrollbars without changing the host page. No theme JavaScript, preference cookie, or decision update is needed. A live auto change keeps an open draft intact and does not activate scripts.

### Independent palette overrides

`colors` is the light palette; `dark_colors` is the dark palette. Both default to empty arrays. Missing values inherit their corresponding defaults. Custom light colors are not automatically inverted or converted, so choose compatible brand colors independently:

```php
'colors' => [
    'accent' => '#263c76',
    'focus' => '#263c76',
],
'dark_colors' => [
    'accent' => '#a5e4c4',
    'focus' => '#a5e4c4',
],
```

| Key | Dark default | Role |
| --- | --- | --- |
| `background` | `#111b17` | Card, dialog, fallback, and launcher |
| `text` | `#edf4ef` | Headings and ordinary text |
| `muted` | `#b5c6bc` | Secondary descriptions |
| `accent` | `#8dd8b4` | Buttons, links, selected switches |
| `accent_text` | `#10251b` | Content on the accent |
| `border` | `#31473b` | Decorative dividers |
| `control` | `#8da99a` | Outlined controls and unchecked switches |
| `focus` | `#a5e4c4` | Keyboard focus outline |

The light defaults remain as listed above. Standard fills choice buttons with the accent; Compact puts accent text on the palette background. Both default palettes meet the package's contrast thresholds. The launcher gives its focus outline a backing in its own background color so it remains distinguishable on an opposite-themed host page. Custom CSS/colors still need browser checks.

## Warning suppression

With `ui.validate_contrast` enabled, diagnostics check **both palettes**, including the inactive one, and identify light/dark in each issue. Invalid colors fall back to the relevant palette default and warn regardless of the contrast flag. None of these warnings changes selected valid colors or interrupts rendering.

Identical warnings are grouped by both resolved palettes and the issue list, with one logging attempt every **72 hours**. A changed palette or new issue can be reported immediately. Theme mode, variant, language, position, policy URL, color-key ordering, and HEX casing do not repeat the same warning. Switching between light/dark/auto does not restart the interval.

The app's default Laravel cache claims the interval with atomic `add` before logging. Use a persistent file, Redis, or database store for suppression across requests; file cache is per server, while a shared cache can suppress across workers/servers using the same namespace. `array` only suppresses during its own lifetime; `null` cannot retain the marker and skips these diagnostics.

An unavailable cache, failed/rejected claim, or logger failure never breaks the host page. Cache failure skips logging rather than flooding logs on every request. A logger failure keeps the claimed marker until expiry. Clearing/evicting markers can permit earlier attempts. Healthy palettes do not access the diagnostic cache. No visitor identifier, new cookie, table, or migration is introduced.

For customized views/assets, follow [the upgrade steps](/docs/upgrading#language-and-theme-update). The website's live preview switches light, dark, and auto for both variants. These controls affect only the preview, not the host page.
