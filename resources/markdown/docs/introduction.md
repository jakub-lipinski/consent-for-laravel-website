## A choice with a clear contract

Consent for Laravel is a Composer library for explicit, service-based cookie preferences. It gives your Laravel application a configurable banner, a native preferences dialog, versioned decisions, and a browser runtime that gates declared scripts.

The package is available on [Packagist](https://packagist.org/packages/jakub-lipinski/consent-for-laravel). It targets PHP 8.3+ and Laravel 12-13. It does not add a website, dashboard, application routes, database tables, or a frontend framework dependency.

```bash
composer require jakub-lipinski/consent-for-laravel
php artisan vendor:publish --tag=consent-config
```

Run these in your existing Laravel app. Follow [the quick start](/docs/quick-start) to enable a preset or register your own scripts, add the two Blade components, and verify the result. The [package repository](https://github.com/jakub-lipinski/consent-for-laravel) contains the source and release notes.

## What ships today

- Five standard categories: necessary, analytics, marketing, performance, and other.
- A service registry describing the actual purposes used by your application.
- Strict, versioned preference persistence shared by the PHP and browser APIs.
- Inert `@consent` script blocks with ordering, duplicate prevention, and checks before activation.
- Safe default reload when consent is withdrawn from running code.
- Matching Standard and Compact banners/preferences dialogs, all three banner positions, a reopening icon, safe color-format fallbacks, optional non-blocking contrast diagnostics, and seven bundled languages with custom locale fallback.
- Keyboard interaction, native modal semantics, responsive layouts, and protection against covering focused host controls.
- Google Consent Mode v2 with Basic and explicit Advanced modes.
- ID-based GA4 and Google Ads presets with permission-checked event routing.
- Meta Pixel and Microsoft Clarity presets with strict loading gates, guarded events, and opt-in Clarity advertising.

## Languages and themes

English, Polish, German, French, Italian, Spanish, and European Portuguese are included. Custom dictionaries use regional and English fallback. Choose light, dark, or auto in config, with independent palettes for both variants. Identical theme warnings receive one logging attempt every 72 hours. The published config uses Laravel-style sections and commented examples; the live preview demonstrates the light palette.

Read [theme modes](/docs/banner-and-theme#light-dark-and-auto), [custom languages](/docs/translations#languages-and-custom-locales), and [the upgrade guidance](/docs/upgrading#language-and-theme-update).

## The lifecycle

1. Register your services and purposes in configuration.
2. Render the head component, banner, and inert script blocks.
3. Until a valid choice exists, necessary is allowed and optional categories are denied. Basic blocks Google requests; explicitly configured Advanced presets can send cookieless pings while denied.
4. An explicit choice is saved before newly allowed scripts start.
5. Scripts run in order, once per document, with permission checked again before activation.
6. Withdrawal cleans declared cookies and reloads by default if optional code is already active.

A saved refusal is a valid decision. A missing, expired, malformed, or outdated preference is pending, not acceptance.

## Included integrations

GA4, Google Ads, [Meta Pixel](/docs/meta-pixel), and [Microsoft Clarity](/docs/microsoft-clarity) are included. Custom services describe purposes; enabled presets also initialize their SDKs. See [included features](/docs/integrations).

## Before using it in production

The package supplies consent tooling; it does not certify EU legal compliance or the accessibility of your host website. Your implementation must accurately describe processing, gate every relevant request, provide policy information, and honor withdrawal throughout the application.

Read [security and privacy](/docs/security) and [accessibility](/docs/accessibility). Then follow [the quick start](/docs/quick-start).
