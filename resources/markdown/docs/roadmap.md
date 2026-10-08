## Available now: beta.5

The package includes the PHP consent foundation, service registry, versioned preferences, inert Blade blocks, ordered browser loading, withdrawal, three banner positions, native preferences, validated colors, English/Polish UI, Google Consent Mode v2, GA4, Google Ads, Meta Pixel, and Microsoft Clarity.

## Beta.4: Google consent foundation

Implemented: denied defaults and ordered updates, Basic and explicit Advanced, shared gtag.js loading, GA4/Ads presets, guarded events, cleanup, and mandatory active withdrawal reload. See [Consent Mode](/docs/google-consent-mode) and [Google presets](/docs/google-presets).

## Beta.5: Meta Pixel and Microsoft Clarity

Implemented: strict category gates, ID-based setup, automatic purposes and cleanup, Meta standard/custom events and PageView control, Clarity Consent API v2 and custom events, separately enabled advertising, English/Polish purposes, and denial-before-reload withdrawal. See [Meta Pixel](/docs/meta-pixel) and [Clarity](/docs/microsoft-clarity).

Local verification uses SDK mocks, including native browser checks, rather than measurements sent to live provider accounts. Verify actual account delivery and host settings separately.

## Beta.6: Release preparation

Planned: integrated verification, API review, documentation, and preparation for version 1.0. The beta count remains flexible; corrective releases can be added as needed. This is a milestone, not a promised date or a completed audit.

## Google Tag Manager: deferred

GTM is postponed and has no assigned beta. There is no built-in container loader, GTM consent template, or GTM event API. A container can load arbitrary tags and needs tag-specific consent ownership. Existing gtag presets do not become a GTM integration.

## Towards version 1.0

Release 1.0 only after the integrated lifecycle, public API, documentation, and accessibility responsibilities are verified. Host processing and jurisdiction still determine legal compliance.

Follow [GitHub releases](https://github.com/jakub-lipinski/consent-for-laravel/releases) or [raise an issue](https://github.com/jakub-lipinski/consent-for-laravel/issues).
