# Consent for Laravel website

The standalone landing page and documentation for [Consent for Laravel](https://github.com/jakub-lipinski/consent-for-laravel), available on [Packagist](https://packagist.org/packages/jakub-lipinski/consent-for-laravel). This repository is a Laravel application; the Composer library lives in its own repository.

## Install the package in your Laravel app

Run these commands in the root of the Laravel application where you want to use consent:

```bash
composer require jakub-lipinski/consent-for-laravel
php artisan vendor:publish --tag=consent-config
```

The stable package installs directly from Packagist with Laravel provider auto-discovery. No custom Composer repository or minimum-stability change is needed. Requirements are PHP 8.3+ and Laravel 12 or 13; the default flow requires no npm build, database, or migrations. Optional decision audit history uses owner-installed database tables and a same-origin endpoint.

Next, edit `config/consent.php`, enable the presets you use and supply their IDs, then add `<x-consent::head />` in your layout's head and `<x-consent::banner />` in its body. All presets start disabled; setting an ID in `.env` alone does not enable one. For your own scripts, register a service and gate its script with `@consent` instead. Follow the [quick start](resources/markdown/docs/quick-start.md) for complete examples, a policy link, and verification.

Use `php artisan config:clear` while developing after changes to cached configuration; rebuild with `php artisan config:cache` during production deployment. If you followed the previous VCS instructions, see [switching to Packagist](resources/markdown/docs/upgrading.md#switching-from-a-vcs-installation).

## Current scope

Documentation covers `v1.3.0`: optional decision audit history and signed notices, seven languages and custom locale fallback, light/dark/auto themes, 72-hour diagnostic suppression, service categories, versioned preferences, browser script gating, withdrawal, Standard/Compact interfaces, configuration, and Google/Meta/Clarity presets. The upgrade guide covers config, views, assets, and migration requirements for earlier stable releases.

The landing page includes an interactive preview of the package interface. It uses in-memory state only, stores no preference cookie, and runs no analytics or advertising tracker. The website's own GA4 preset uses the real installed package in Basic mode and loads only after analytics permission. `CONSENT_GA4_ID` overrides the public measurement ID configured for the official site. The website itself is in English; the package interface supports seven bundled languages and custom dictionaries. The website keeps its own audit logging disabled; no audit tables or identity cookie are introduced for visitors.

## Local development

Requirements: PHP 8.3+, Composer, and Node compatible with Vite 8. The local Herd domain is `consent-for-laravel-website.test`.

```bash
composer install
cp .env.example .env
php artisan key:generate
npm ci --ignore-scripts
npm run build
```

Herd serves the application. Run `npm run dev` when actively editing frontend assets. Do not commit `.env`, `vendor`, `node_modules`, or built Vite assets.

## Structure

- `config/site.php`: current package release, Packagist and repository URLs, chapter metadata, and navigation groups.
- `app/Documentation.php`: whitelisted chapter loading, safe Markdown rendering, heading anchors, and a text search index.
- `resources/markdown/docs`: documentation source files.
- `resources/views`: landing page, shared shell, documentation layout, and accessibility statement.
- `resources/css/app.css` and `resources/js/app.js`: responsive visual system and progressive enhancement.
- `resources/css/consent-preview.css`: unmodified package CSS matching the installed `v1.3.0` release, rendered inside a Shadow DOM so Tailwind and website typography cannot override it.
- `resources/css/preview-frame.css`: isolates inherited website styles and contains banner placement in the illustrated app. The native preferences dialog retains the package geometry, colors, typography, hover, and focus styles.
- `public/assets`: original line-art brand assets, illustration, favicon, and social image.

To add a chapter, create its Markdown file and register it in `config/site.php`. Chapter content is rendered with raw HTML stripped and unsafe links disabled. Search results are created using DOM text nodes. Code examples never execute.

## Verification

```bash
php artisan test --compact
vendor/bin/pint --dirty --format agent
npm run build
```

Feature coverage checks published chapters, search data, internal documentation links, unknown paths, safe rendering, unique heading IDs, the landing page, and the accessibility statement. Browser verification covers keyboard modal behavior, focus return, narrow layouts, enlarged text, search, copy controls, and the cookie-free preview. Automated checks do not constitute an accessibility certification.

## Production

Set the application's URL and normal Laravel production environment settings. Build Vite assets during deployment, optimize Laravel caches, and point the web server at `public`. The site keeps optional audit logging disabled and adds no account, audit tables, or third-party font request. Use the appropriate production session/cache driver for your hosting environment.

Package installation instructions use the stable release published on Packagist and the same Composer command throughout the site. For a new release, synchronize `config/site.php`, the installed Composer version, README, Introduction, Installation, Included features, upgrade instructions, and verification evidence. Review every chapter against the tagged source and check published package metadata before documenting new options. Keep earlier versions explicitly scoped to upgrade history or dated verification results.

The interface preview switches Standard and Compact together with all three positions. Both variants keep category purposes visible and expose full service lists through initially collapsed native disclosures with a state-indicating chevron. Switching variants preserves the preview's disclosure state. Preview choices remain in memory; changing the variant never saves a real consent decision.

Preview controls sit above the illustrated app. Standard/Compact remains available at every width; the position selector is hidden at the package's mobile breakpoint (35rem), where the banner fills the available width. The preview uses the package's default colors, close/launcher SVG geometry, English copy, and four built-in service descriptions.

When updating the package release, copy `resources/css/consent.css` from that tagged source verbatim into `resources/css/consent-preview.css` and update the release fingerprint test. Keep containment rules in `preview-frame.css`; do not modify the package stylesheet to match the website. Recheck both variants, native preferences, hover/focus, and mobile layouts against a disposable app rendering the released package.

The v1.3.0 audit chapter documents optional enablement, all config keys, the two related tables, custom/localized/cached notices, signing-key rotation, receipt-gated grants, immediate refusal, browser identity, pruning, and delivery limitations. Search/sidebar navigation includes this chapter; the landing links to it and to the upgrade sequence. The installed package and lock file match the documented release.
