## Both built-in variants

The built-in banner targets the applicable **WCAG 2.2 A and AA** requirements. It uses semantic headings, native controls, a native modal dialog, a default palette with tested contrast, and layouts that adapt to narrow screens and enlarged text.

This is an implementation target supported by automated and native browser checks, not a certification of the complete host website. Custom views, surrounding content, third-party widgets, and actual assistive technology use require verification in your application.

## Keyboard and focus

- The banner does not steal focus when it arrives.
- Opening preferences moves focus to the modal heading.
- Tab and Shift+Tab remain within the native modal; its background is inert.
- Space toggles switches; Enter activates buttons. In Compact, native service disclosures open with Enter or Space without changing consent.
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

Version 1.1.1 package checks passed 246 PHP tests / 475 assertions and 122 JavaScript tests on local PHP 8.4 / Laravel 13. Native WebKit checks covered both variants, all three positions, English/Polish, inline/published assets under nonce CSP, module ordering, geometry, full axe checks, keyboard modality, service disclosures, saved choices, and withdrawal. The 1.1.1 recheck verified initially collapsed, independently expandable service lists with decorative chevrons that change direction in both variants, Enter/Space/Tab interaction, and unchanged consent until an explicit choice. Both variants/languages had no horizontal overflow at 320 CSS pixels with 200% text size and increased spacing, including every service list expanded in both variants; the final Save control scrolled fully into view. Policy links aligned with text and actions despite generic host-page spacing. Axe reported no violations in tested banner/modal states; incomplete closed-dialog references, close-glyph name checks, and overlapping backgrounds were reviewed manually. CI separately covers eight PHP 8.3/8.4 and Laravel 12/13 lowest/highest combinations. These checks do not certify other engines, screen readers, OS high-contrast modes, or whole-site accessibility.

For this documentation website's own controls and reporting, read [website accessibility](/accessibility). The normative criteria are available in [WCAG 2.2 from W3C](https://www.w3.org/TR/WCAG22/).
