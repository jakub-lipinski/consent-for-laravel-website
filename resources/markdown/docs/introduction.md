## A choice with a clear contract

Consent for Laravel is a Composer library for explicit, service-based cookie preferences. It gives your Laravel application a configurable banner, a native preferences dialog, versioned decisions, and a browser runtime that gates declared scripts.

The current release is **v1.0.0-beta.4**. The package targets PHP 8.3+ and Laravel 12-13. It does not add a website, dashboard, application routes, database tables, or a frontend framework dependency.

## What ships today

- Five standard categories: necessary, analytics, marketing, performance, and other.
- A service registry describing the actual purposes used by your application.
- Strict, versioned preference persistence shared by the PHP and browser APIs.
- Inert `@consent` script blocks with ordering, duplicate prevention, and checks before activation.
- Safe default reload when consent is withdrawn from running code.
- Three banner positions, a reopening icon, validated colors, and English/Polish translations.
- Keyboard interaction, native modal semantics, responsive layouts, and protection against covering focused host controls.
- Google Consent Mode v2 with Basic and explicit Advanced modes.
- ID-based GA4 and Google Ads presets with permission-checked event routing.

## The lifecycle

1. Register your services and purposes in configuration.
2. Render the head component, banner, and inert script blocks.
3. Until a valid choice exists, necessary is allowed and optional categories are denied. Basic blocks Google requests; explicitly configured Advanced presets can send cookieless pings while denied.
4. An explicit choice is saved before newly allowed scripts start.
5. Scripts run in order, once per document, with permission checked again before activation.
6. Withdrawal cleans declared cookies and reloads by default if optional code is already active.

A saved refusal is a valid decision. A missing, expired, malformed, or outdated preference is pending, not acceptance.

## What is still planned

Google Tag Manager, Meta Pixel, and Microsoft Clarity remain planned. GA4 and Google Ads are available now; follow [Google presets](/docs/google-presets). Custom service registration describes purposes; enabled presets additionally handle their own initialization. Follow [the roadmap](/docs/roadmap).

## Before using it in production

The package is currently in beta. It supplies consent tooling; it does not certify EU legal compliance or the accessibility of your host website. Your implementation must accurately describe processing, gate every relevant request, provide policy information, and honor withdrawal throughout the application.

Read [security and privacy](/docs/security) and [accessibility](/docs/accessibility). Then follow [the quick start](/docs/quick-start).
