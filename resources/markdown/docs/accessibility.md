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

For **v1.1.3**, `composer check` passed Composer validation, Pint, PHPStan level 8, **259 PHP tests / 575 assertions**, JavaScript syntax checks, and **132 JavaScript tests** on local PHP 8.4 / Laravel 13. Focused theme, banner, and configuration tests passed 112 cases / 288 assertions in four cached PHP 8.3/8.4 and Laravel 12/13 dependency sets. CI separately passed all eight configured lowest/highest combinations. See [the v1.1.3 verification](https://github.com/jakub-lipinski/consent-for-laravel/blob/v1.1.3/docs/releases/v1.1.3.md#verification).

The v1.1.3 native-browser recheck covered both variants, contrast diagnostics on/off, nonce CSP, preferences, draft versus saved choices, gated script activation, withdrawal/reload, invalid-color fallback, and an unavailable logger. Custom low-contrast colors are intentionally preserved and are not certified by these checks.

Broader [v1.1.2 interface verification](https://github.com/jakub-lipinski/consent-for-laravel/blob/v1.1.2/docs/releases/v1.1.2.md#verification) covered both variants, all three positions, English/Polish, and inline/published assets under nonce CSP. All 24 native axe checks reported no violations. Twelve reflow checks at 320 CSS pixels with 200% text size and increased spacing had no horizontal overflow, with all service lists expanded and the final Save control fully visible. Keyboard interaction, modal focus, disclosures, saved choices, script ordering, and withdrawal were verified. Incomplete axe results were reviewed manually and are not counted as automatic passes.

These results do not certify other browser engines, screen readers, OS high-contrast modes, arbitrary custom themes, or whole-site accessibility.

For this documentation website's own controls and reporting, read [website accessibility](/accessibility). The normative criteria are available in [WCAG 2.2 from W3C](https://www.w3.org/TR/WCAG22/).
