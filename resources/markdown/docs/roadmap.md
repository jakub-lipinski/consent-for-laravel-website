## Available now: beta.4

The current release includes the PHP consent foundation, service registry, strict versioned preferences, inert Blade blocks, framework-free ordered browser loading, withdrawal, three banner positions, native preferences dialog, validated colors, English/Polish UI, Google Consent Mode v2, GA4, and Google Ads presets.

The website documents these implemented APIs. It does not describe a planned preset as usable today.

## Beta.4: Google consent foundation

Implemented: Google Consent Mode v2, denied defaults and ordered updates, Basic/explicit Advanced modes, shared gtag.js loading, GA4 and Google Ads configuration, guarded event destinations, cleanup rules, and mandatory reload after active preset withdrawal. See [Consent Mode](/docs/google-consent-mode) and [presets](/docs/google-presets). Vendor behavior was checked against current primary documentation; local browser verification uses mock tags, not live property measurements.

## Beta.5: Google Tag Manager

Planned scope: a GTM bridge, consent template, and container configuration guidance. A container can load arbitrary tags, so the integration must document the boundaries between package preferences and each tag's consent requirements.

## Beta.6: Additional presets

Planned scope: Meta Pixel and Microsoft Clarity, with provider-specific activation and withdrawal behavior. Presets should simplify configuration without hiding their actual processing purposes or lifecycle limits.

## Beta.7: Release preparation

Planned scope: integrated verification, documentation, and preparation for version 1.0. The number of betas is not fixed. Smaller corrective releases can be added when needed; a milestone is not a promised release date.

## Towards version 1.0

Version 1.0 should ship only after the integrated lifecycle is verified, the public API is coherent, documentation is accurate, and accessibility/integration responsibilities are clear. Legal compliance still depends on the host's processing and jurisdiction.

Follow [GitHub releases](https://github.com/jakub-lipinski/consent-for-laravel/releases) or [raise a focused issue](https://github.com/jakub-lipinski/consent-for-laravel/issues) to discuss a specific behavior.
