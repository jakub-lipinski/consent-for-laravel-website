## Newly inserted fragments

The core runtime observes DOM additions and discovers newly inserted inert consent templates. Register purposes globally and use stable explicit IDs in repeated partials:

```blade
@consent('analytics', 'route-insights')
    <script src="/js/route-insights.js"></script>
@endconsent
```

Already executed blocks do not run again when remounted. Identical IDs/contents deduplicate. A reused ID with different contents reports a conflict. External-source deduplication also applies.

## Keep one runtime owner

Mount the head component and banner in the persistent application layout. Blade's once-per-response rendering does not imply deduplication across separate network responses inserted into an SPA. Avoid injecting additional copies of the core runtime or interface on every route transition.

Wait for the original head component before calling `window.Consent`. The package is framework-free; integration with your navigation framework remains application-owned.

## Route-specific providers

A script block is a one-time activation mechanism, not a full provider mount/unmount system. Initialize a provider once, then use its own route/pageview API only while the category remains allowed. Check `allowed()` before each processing action, not just at first mount.

```js
function recordNavigation(path) {
    if (window.Consent.allowed('analytics')) {
        window.siteInsights.recordPage(path);
    }
}
```

The provider API is illustrative. Unmounting the route or removing a template does not stop running provider code.

## Cleanup and resumption

Use category-level revocation hooks only if all provider processing can stop completely. With cooperative cleanup, a later grant does not rerun the original block. Supply a provider-specific resume path or reload. Default active revocation reload remains the safest generic behavior.

Subscriptions return teardown functions. Do not remove cleanup hooks while their active provider still requires them. Read [withdrawal](/docs/withdrawal).

## Native modal integration

The banner uses a native dialog. Check your framework's DOM morphing and navigation behavior around an open modal, focused controls, and persistent layout. Do not replace or duplicate the mounted preferences dialog mid-interaction. Preserve focus return and ensure other application dialogs do not compete with it.

## GA4 page views

Set `presets.ga4.send_page_view` to `false` if your router owns page-view reporting. Send the intended view after each navigation through `Consent.google.event('G-XXXXXXXXXX', 'page_view', { page_path: '/current-path' })`. Denied events return `false` and are not replayed when consent is later granted. Avoid duplicate router handlers and duplicate vendor installation. See [Google presets](/docs/google-presets).

## Meta and Clarity presets

Keep one SDK owner per document. Set Meta `send_page_view` to false when the router owns page views, then call `Consent.meta.track('PageView')` once per committed navigation. Clarity's SDK handles recording/navigation; do not reinitialize it on fragments. `Consent.clarity.event()` can annotate permitted interactions. Events invoked without permission are discarded rather than replayed on another page. See [Meta](/docs/meta-pixel) and [Clarity](/docs/microsoft-clarity).

## Audit notice ownership

With auditing enabled, keep one persistent banner and one signed `data-consent-notice` block for the document. Route fragments must not inject extra notices. The snapshot belongs to the server-prepared banner/dialog; client-side text mutations are not recaptured automatically.

A policy/purpose change requires fresh server-rendered HTML and the correct policy version, not just a router text replacement. Preserve the original notice when submitting decisions on the current page. See [cached notices](/docs/audit-log#cache-and-signatures).
