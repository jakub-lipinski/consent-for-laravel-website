## Both built-in variants

The built-in banner targets the applicable **WCAG 2.2 A and AA** requirements. It uses semantic headings, native controls, a native modal dialog, a default palette with tested contrast, and layouts that adapt to narrow screens and enlarged text.

This is an implementation target supported by automated and native browser checks, not a certification of the complete host website. Custom views, surrounding content, third-party widgets, and actual assistive technology use require verification in your application.

## Keyboard and focus

- The banner does not steal focus when it arrives.
- Opening preferences moves focus to the modal heading.
- Tab and Shift+Tab remain within the native modal; its background is inert.
- Space toggles switches; Enter activates buttons. In both variants, native service disclosures open with Enter or Space without changing consent.
- Escape closes without saving a draft.
- Closing returns focus to the opener, or the preferences launcher when the opener is unavailable.
- Overlays yield when they fully cover a focused host-page control. The launcher can also hide if it fully covers focus. Large page containers and partially visible controls do not dismiss the pending notice.

Keep accessible button names and native dialog semantics when adapting the views. Do not replace controls with click-only generic elements.

## Contrast and visual adaptation

The default palette meets 4.5:1 for ordinary text and 3:1 for focus/control boundaries against the background. Optional `ui.validate_contrast => true` logs warnings for custom combinations below those thresholds while preserving the chosen colors and the page response. It defaults to `false`; accepting a custom color does not establish its accessibility. Invalid color formats fall back to defaults. Custom themes, CSS, and view changes need their own review.

Check at 320 CSS pixels, 200% text resizing, and browser zoom equivalent to 400% reflow. Also apply text-spacing overrides, reduced motion, and forced-color preferences. Check that every actionable control remains visible, usable, and unoccluded.

## Errors and fallback

Saving displays a busy state. A storage failure produces a retryable error and leaves optional processing blocked. Status and error messages have appropriate live-region semantics.

Without JavaScript or the core runtime, optional script templates stay inert. Without native dialog support, readable fallback information and the configured policy link remain. An already valid preference can still be honored by the core runtime even where the UI cannot mount.

## Verification before deployment

Test the actual host page, not only a standalone component: header and footer controls, other modals, sticky elements, scrolling, focus, validation messages, language, and vendor UI all affect the result. Automated axe/jsdom checks do not establish native dialog modality, visual geometry, screen-reader behavior, or every WCAG criterion.

For **v1.2.0**, local `composer check` passed strict Composer validation, Pint, PHPStan level 8, **362 PHP tests / 1999 assertions**, JavaScript syntax checks, and **148 JavaScript tests** on PHP 8.4.25 / Laravel 13.35.0 / Node 22.21.1. The [tag CI matrix](https://github.com/jakub-lipinski/consent-for-laravel/actions/runs/37972130515) separately passed all eight configured PHP 8.3/8.4 and Laravel 12/13 lowest/highest combinations. See [the v1.2.0 verification](https://github.com/jakub-lipinski/consent-for-laravel/blob/v1.2.0/docs/releases/v1.2.0.md#verification) and [detailed interface checks](https://github.com/jakub-lipinski/consent-for-laravel/blob/v1.2.0/docs/interface.md#verification) for evidence and limitations.

These results do not certify other browser engines, screen readers, OS high-contrast modes, arbitrary custom themes, or whole-site accessibility.

For this documentation website's own controls and reporting, read [website accessibility](/accessibility). The normative criteria are available in [WCAG 2.2 from W3C](https://www.w3.org/TR/WCAG22/).

## Language and theme checks

The v1.2.0 native-browser checks covered all seven bundled languages, a partial Dutch dictionary, and a Canadian French override in both variants. Reflow and text-resizing checks included custom dictionaries and the five added languages; French layouts also fit all three positions. These host checks are separate from the release's PHP/Laravel CI matrix.

A disposable host outside the package checkout was checked in the native Codex in-app browser. Light, dark, and auto rendered in both variants with no full-axe violations in the tested banner/modal states; the closed-dialog reference check remained incomplete and was reviewed manually. The browser's actual preference was light. Host-only emulation of the CSS media-rule condition exercised live auto branches and preserved an open draft; an actual OS preference toggle and other browser engines were not verified.

Dark layouts passed 320px reflow with French text, 200% text resizing, increased spacing, all three positions, both variants, and expanded service disclosures. Keyboard focus brought Save fully into view. Native checks covered heading focus, Tab/Shift+Tab wrapping, Space, Escape, focus return, independent palette overrides, published assets under nonce CSP, and gated module ordering. The host had no CSP violations at DOM readiness; later browser instrumentation produced a blocked anonymous inline-style event, so this is not a clean-console claim.

Both default palettes meet the package contrast thresholds; diagnostics check both, including the inactive palette, without changing valid colors. Theme changes do not grant consent or reset an open draft. Recheck custom CSS, RTL layouts, screen readers, forced-colors environments, and the complete host experience. See [theme configuration](/docs/banner-and-theme#light-dark-and-auto).
