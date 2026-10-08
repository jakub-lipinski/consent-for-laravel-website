## The banner does not appear

Check that both `<x-consent::head />` and `<x-consent::banner />` are in the layout. A valid saved acceptance or refusal shows the launcher instead of the initial banner. With no enabled optional service, only the launcher is shown. Rebuild a stale configuration cache.

Opening preferences should still work through `data-consent-open` or `window.Consent.openPreferences()`. If the method returns false, the interface is not available. Verify JavaScript/CSP errors and native dialog support.

## A category is missing

Only optional categories used by enabled services are shown. The registry is global to the site. Check the service's category, enabled boolean, and configuration cache. Disabled service definitions remain validated.

## A script does not run

Verify a current stored decision, the category's active service, and `window.Consent.allowed()`. Blocks must contain scripts/comments/whitespace only. Check HTTP(S) source URLs, CSP, integrity/CORS settings, network errors, block IDs, and timeouts.

A failed block does not retry. A previously run block will not execute again after SPA remounting or cooperative re-grant. Use the provider's own lifecycle or reload.

```js
document.addEventListener('consent:error', event => {
    console.error(event.detail);
});
```

## A cookie cannot be saved

Check browser restrictions, the configured path/domain, HTTP versus `secure: true`, and trusted proxies. A save failure keeps optional processing denied and displays a retryable UI error. Do not treat clicking accept as a successful grant if persistence failed.

Read [persistence](/docs/persistence) for temporary denial markers and the case where automatic reload is unsafe.

## Preferences reset unexpectedly

The decision may have expired or the policy/service fingerprint may have changed. Active service names, descriptions, categories, IDs, and cookie rules contribute to its version. UI-only changes do not. Shortening retention may invalidate older decisions.

## Withdrawal reloads the page

This is the default safety behavior for running code. Removing scripts cannot stop them. Only opt out with complete cooperative cleanup of every active service in the category. In-flight scripts or cleanup failures still require reload.

## Tracker cookies remain

Cookie deletion needs the correct declared path/domain and browser visibility. HttpOnly, third-party, other-scope cookies, non-cookie storage, and remote data require their own provider/server APIs. Protected preference, session, CSRF, and remember cookies are intentionally excluded.

## A custom theme is rejected

Use known keys and six-digit hex values. Text combinations need 4.5:1 and control/focus colors need 3:1 against the UI background. A color that looks fine alone may fail in combination. See [banner and theme](/docs/banner-and-theme).

## Published views or assets are stale

Compare application-owned published files with the new package version, merge changes deliberately, rebuild view/config caches, republish assets, and update cache-busting. Do not use `--force` to overwrite intentional customizations without review.

## Where to report a problem

Use [package issues](https://github.com/jakub-lipinski/consent-for-laravel/issues) for package behavior and [website issues](https://github.com/jakub-lipinski/consent-for-laravel-website/issues) for documentation/site problems. Include versions, minimal reproduction, expected behavior, and console/network details without secrets or personal data.

## Google does not start

Confirm the preset is enabled, its ID is valid, and the correct category is granted in Basic. Render the head before Google code and remove old gtag bootstraps, populated dataLayer initialization, and duplicate installs. A detected conflict reports `configuration` and leaves optional templates inert. A loader/CSP/network failure reports `google`; fix it and retry on a new document.

`Consent.google.event()` returning `false` means a command was not queued. A `true` result does not prove provider delivery. For Ads, use an enabled destination plus the actual conversion label and event `conversion`. See [Google presets](/docs/google-presets).
