# Consent for Laravel website

The standalone landing page and documentation for [Consent for Laravel](https://github.com/jakub-lipinski/consent-for-laravel). This repository is a Laravel application; the Composer library lives in its own repository.

## Current scope

Documentation covers `v1.1.0`: service categories, versioned preferences, inert Blade script blocks, the browser runtime, withdrawal, matching Standard/Compact banner and preferences variants, configuration, English/Polish translations, Google Consent Mode v2, GA4/Ads, Meta Pixel, Microsoft Clarity, and integration responsibilities.

The landing page includes an illustrative interface preview. It uses in-memory state only, stores no preference cookie, and runs no analytics or advertising tracker. The website itself is in English; the package interface supports English and Polish.

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

- `config/site.php`: current package release, verified repository URLs, chapter metadata, and navigation groups.
- `app/Documentation.php`: whitelisted chapter loading, safe Markdown rendering, heading anchors, and a text search index.
- `resources/markdown/docs`: documentation source files.
- `resources/views`: landing page, shared shell, documentation layout, and accessibility statement.
- `resources/css/app.css` and `resources/js/app.js`: responsive visual system and progressive enhancement.
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

Set the application's URL and normal Laravel production environment settings. Build Vite assets during deployment, optimize Laravel caches, and point the web server at `public`. The site needs no database-backed product feature, account, consent service, or third-party font request. Use the appropriate production session/cache driver for your hosting environment.

Package installation instructions use the standard Composer package name and stable GitHub tags through the official VCS source; no reduced minimum stability is needed. Update `config/site.php` and all affected guides deliberately for a new release.

The interface preview switches Standard and Compact together with all three positions. Compact keeps category purposes visible and exposes full service details through native disclosures. Preview choices remain in memory; changing the variant never saves a real consent decision.
