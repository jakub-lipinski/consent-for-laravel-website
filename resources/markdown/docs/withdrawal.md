## Default to safe reload

Removing a script element does not stop a tracker, its timers, event listeners, queues, or outgoing requests. When an active category is revoked, the runtime saves the new selection, removes declared accessible cookies, and reloads by default. The next document starts with the new permission state.

```js
await window.Consent.rejectOptional();
```

You can also replace a selection with `choose()` or return to pending with `forget()`. A saved refusal avoids repeatedly asking on each visit.

## Cooperative cleanup

Only disable reload if every active service in the category has complete stop behavior:

```js
window.Consent.onRevoke('analytics', async () => {
    await window.siteInsights.stopCompletely();
}, { reload: false });
```

This provider method is a placeholder, not a built-in API. Complete cleanup must stop all processing, pending work, timers, listeners, and queues for that purpose. A cleanup callback that merely removes a DOM node is insufficient.

Every applicable hook must explicitly opt out of reload and succeed. In-flight script activation still requires reload. Cleanup errors and timeouts fall back to reload; the default cleanup timeout is 3000 milliseconds.

## Re-granting after cooperative cleanup

A script block runs once per document. If you stop a provider without reloading, accepting its category again does not execute the same block again. Supply provider-specific resumption through `onChange()` or deliberately reload. Unsubscribe hooks when their owner is genuinely torn down, but do not unregister the only cleanup path while its provider is still active.

## Cookie removal

Declare cookies per service:

```php
'cookies' => [
    ['name' => '_insights', 'path' => '/', 'domain' => null],
    ['prefix' => '_insights_', 'path' => '/', 'domain' => null],
],
```

Rules run on denied startup, refusal, expiry, and invalidation as well as active withdrawal. Only matching visible first-party cookies in the configured scope can be removed. Necessary-category cookies are not removed by optional withdrawal.

Preference, optional audit identity, configured session, CSRF, and `remember_` cookies are protected. The browser cannot remove HttpOnly or third-party cookies, cookies in inaccessible scopes, vendor storage outside cookies, or remote data. Use the appropriate application or provider APIs for those.

## Save failures

A failed choice remains denied in memory. A temporary denial marker normally allows a safe reload. If neither session storage nor history state can hold that marker, an automatic reload might restore the old grant. In that case the runtime reports that automatic reload is unavailable rather than claiming running code has stopped. See [persistence](/docs/persistence).

Pending Google, Meta, and Clarity helper events never delay saving a refusal. Permission is rechecked immediately before dispatch; events still waiting when consent is withdrawn are not sent.

## Verify the provider lifecycle

Exercise acceptance, active refusal, re-grant, another tab's change, expiry, storage failure, script failure, and cleanup timeout. Inspect actual network requests and provider state. The built-in Google presets update Consent Mode signals before cleanup and always reload after active withdrawal. Custom cleanup cannot disable this preset reload. Generic blocks do not automatically implement other provider consent APIs. See [Google Consent Mode](/docs/google-consent-mode).

## Built-in Meta and Clarity withdrawal

Meta sends revoked consent before listeners/reload; Clarity sends both updated `consentv2` fields. Active preset withdrawal always reloads, including Clarity advertising withdrawal with analytics still granted or its SDK in flight. Custom `reload: false` cannot suppress it. Clarity's storage-denied SDK mode can still collect limited cookieless activity, so the package gates loading and uses a fresh document to stop active processing.

Meta cleanup covers declared `_fbp`/`_fbc` scopes; Clarity covers `_clck`/`_clsk`. Scope declarations do not configure vendor cookies or remove third-party/remote data. See [Meta](/docs/meta-pixel) and [Clarity](/docs/microsoft-clarity).

## Audit delivery during withdrawal

When auditing is enabled, explicit refusal, saved reductions, and `forget()` start a keepalive submission before cleanup can reload the page. Local denial never waits for a database receipt. A late pending grant cannot reverse a later refusal or withdrawal.

The audit promise can reject while refusal remains effective. Offline state, tab closure, shared keepalive quotas, and a reload preventing a retry can leave the event unrecorded; there is no persistent queue or guaranteed final delivery. Removing browser permission remains the priority. Expiry and cross-tab observation do not create new events. See [audit failure behavior](/docs/audit-log#failures-and-withdrawal).
