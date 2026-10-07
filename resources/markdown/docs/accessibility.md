## The default interface

The built-in banner targets the applicable **WCAG 2.2 A and AA** requirements. It uses semantic headings, native controls, a native modal dialog, validated contrast, and layouts that adapt to narrow screens and enlarged text.

This is an implementation target supported by automated and native browser checks, not a certification of the complete host website. Custom views, surrounding content, third-party widgets, and actual assistive technology use require verification in your application.

## Keyboard and focus

- The banner does not steal focus when it arrives.
- Opening preferences moves focus to the modal heading.
- Tab and Shift+Tab remain within the native modal; its background is inert.
- Space toggles switches; Enter activates buttons.
- Escape closes without saving a draft.
- Closing returns focus to the opener, or the preferences launcher when the opener is unavailable.
- Overlays yield when they would cover a focused host-page control. The launcher can also hide if it would obscure focus.

Keep accessible button names and native dialog semantics when adapting the views. Do not replace controls with click-only generic elements.

## Contrast and visual adaptation

Built-in theme validation checks 4.5:1 for ordinary text and 3:1 for focus/control boundaries against the background. Six-digit color values are checked as a combination, not in isolation. Published CSS or view changes bypass the assurance provided by those defaults and need their own review.

Check at 320 CSS pixels, 200% text resizing, and browser zoom equivalent to 400% reflow. Also apply text-spacing overrides, reduced motion, and forced-color preferences. Check that every actionable control remains visible, usable, and unoccluded.

## Errors and fallback

Saving displays a busy state. A storage failure produces a retryable error and leaves optional processing blocked. Status and error messages have appropriate live-region semantics.

Without JavaScript or the core runtime, optional script templates stay inert. Without native dialog support, readable fallback information and the configured policy link remain. An already valid preference can still be honored by the core runtime even where the UI cannot mount.

## Verification before deployment

Test the actual host page, not only a standalone component: header and footer controls, other modals, sticky elements, scrolling, focus, validation messages, language, and vendor UI all affect the result. Automated axe/jsdom checks do not establish native dialog modality, visual geometry, screen-reader behavior, or every WCAG criterion.

Beta.3 package verification included automated PHP/Node checks and native browser review of modules, CSP, geometry, contrast, keyboard modality, reflow, and text resizing. It did not constitute exhaustive testing with every screen reader/browser combination.

For this documentation website's own controls and reporting, read [website accessibility](/accessibility). The normative criteria are available in [WCAG 2.2 from W3C](https://www.w3.org/TR/WCAG22/).
