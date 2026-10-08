## Included in version 1.1

Consent for Laravel supplies an in-application consent interface and runtime. Installation adds no separate dashboard, website, application route, database table, or frontend framework.

## Interface and languages

- Five categories: necessary, analytics, marketing, performance, and other.
- Only used optional categories appear in preferences.
- Matching Standard and Compact banners/preferences dialogs, with bottom-left, bottom-right, and wide bottom-center placement. Category purposes stay visible; Compact uses native service-list disclosures.
- Validated theme colors, configurable policy link, and editable copy.
- A native preferences dialog and a small icon for reopening a saved choice.
- English and Polish interface messages and preset purposes.
- Native controls, keyboard interaction, managed focus, responsive reflow, and optional contrast diagnostics.

Read [banner and theme](/docs/banner-and-theme), [translations](/docs/translations), and [accessibility](/docs/accessibility).

## Consent lifecycle and custom scripts

Register processing purposes, render the components, and gate custom scripts with `@consent`. Optional categories remain denied without a current valid decision. An explicit acceptance or refusal is saved before newly allowed code activates. The browser runtime preserves script order, prevents duplicate activation, and rechecks permission before each script.

Preferences use a versioned browser-readable cookie shared by the stateless PHP and browser APIs. Expired or incompatible decisions become pending. Active withdrawal cleans declared visible first-party cookies and reloads by default to stop running optional code.

Read [Blade directives](/docs/blade-directives), [browser API](/docs/browser-api), [PHP API](/docs/php-api), and [withdrawal](/docs/withdrawal).

## ID-based presets

| Integration | Required permission | Included behavior |
| --- | --- | --- |
| [GA4](/docs/google-presets) | Analytics for guarded events and Basic loading | Measurement ID, optional automatic page view, routed events, scoped cleanup |
| [Google Ads](/docs/google-presets) | Marketing for guarded conversions and Basic loading | Conversion ID, explicit conversion labels, routed conversion events, scoped cleanup |
| [Meta Pixel](/docs/meta-pixel) | Marketing | Pixel ID, optional PageView, standard/custom events, optional eventID, scoped cleanup |
| [Microsoft Clarity](/docs/microsoft-clarity) | Analytics | Project ID, Consent API v2, custom events, recording masking guidance, scoped cleanup |

Google uses denied defaults and ordered Consent Mode v2 updates. Basic blocks Google requests before a grant. Explicit Advanced allows cookieless pings while denied; event helpers still require permission. Clarity advertising is off by default and additionally requires both analytics and marketing permission when enabled. Meta and Clarity retain strict loading gates in either Google mode.

Presets initialize once per document. Helpers check permission at invocation and dispatch and never replay denied calls. Active preset withdrawal signals denial before cleanup and mandatory reload.

## Integration responsibilities

Use actual provider IDs, remove duplicate snippets, describe your processing accurately, and configure vendor accounts and cookie scopes. Local release checks use SDK mocks rather than live measurements. Verify account delivery in your controlled host environment. The package supplies consent tooling, not whole-site legal or accessibility certification.
