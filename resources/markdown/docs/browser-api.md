## Availability

`<x-consent::head />` initializes the frozen `window.Consent` API. Put it before code using the API. Use methods from explicit user actions and catch rejected promises. The built-in banner already handles those actions.

## Inspect current preferences

```js
window.Consent.allowed('analytics'); // boolean
window.Consent.state();             // immutable snapshot
```

Necessary is always allowed. Optional categories need a current valid stored decision. State includes schema/policy/service versions, five boolean choices, and decision/expiry timestamps. Pending timestamps are `null`.

## Replace the selection

```js
try {
    await window.Consent.choose({ analytics: true, marketing: false });
    await window.Consent.whenIdle();
} catch (error) {
    // Show a save error in your own interface.
}
```

`choose()` replaces the entire selection. Omitted optional categories become denied. Values must be actual booleans; unknown categories, unused-category grants, and `necessary: false` are invalid.

```js
await window.Consent.acceptAll();
await window.Consent.rejectOptional();
await window.Consent.forget();
await window.Consent.refresh();
```

Acceptance grants only used categories. Rejection creates a remembered refusal. Forgetting removes the saved decision and returns to pending. Refresh reads the cookie again and completes any resulting cleanup.

Choice promises cover persistence and cleanup; they do not wait for newly allowed scripts to finish loading. `whenIdle()` awaits the package's initialization, operations, cleanup, and load queues. It does not await arbitrary vendor background tasks.

## Open preferences

```js
const handled = window.Consent.openPreferences();
```

Returns `true` if the mounted interface handles the request, otherwise `false`. Opening the interface never grants a choice.

## Subscribe to changes

```js
const unsubscribe = window.Consent.onChange((current, previous, source) => {
    console.log(current.choices.analytics, source);
});

// On teardown:
unsubscribe();
```

This subscription does not replace an initial state read. Changes use `choice`, `forget`, `refresh`, or `storage-error` as their source. A cookie may change in another tab or expire while the page is open. The runtime polls about once per second and rechecks on focus, pageshow, and visibility changes.

## Revocation hooks

```js
const unsubscribe = window.Consent.onRevoke('analytics', async () => {
    await window.siteInsights.stopCompletely();
}, { reload: false });
```

The provider method above is fictional. `reload` defaults to `true`. Opting out requires complete cooperative cleanup by every hook for the category. Running code, in-flight scripts, timeouts, and cleanup failures need careful handling. Read [withdrawal](/docs/withdrawal) before using `reload: false`.

## Document events

| Event | Detail / behavior |
| --- | --- |
| `consent:ready` | `{ current }` when initialization is ready |
| `consent:change` | `{ current, previous, source }` |
| `consent:error` | `{ code, message, block }` diagnostics; block may be absent |
| `consent:reload-required` | `{ reason }`; may include `automatic: false` when automatic reload would be unsafe |
| `consent:open-preferences` | Cancelable UI request; no detail payload |

```js
document.addEventListener('consent:error', event => {
    console.error(event.detail.code, event.detail.message);
});
```

Mount listeners before the head component if you need the one-time ready event. Otherwise read `state()` and use subscriptions after initialization. Do not mutate snapshots or replace the global API.

## Google events

```javascript
const signals = Consent.google.state();
const queued = await Consent.google.event('G-XXXXXXXXXX', 'page_view', {
    page_path: '/account',
});
```

`state()` returns a frozen mapped signal snapshot and does not load a tracker. `event(destination, name, parameters = {})` requires an enabled preset's destination and current category permission, waits for initialization, and checks permission again before queueing. It returns `true` for a queued command or `false` when denied/unavailable. It does not replay denied events or confirm delivery. Invalid destinations/labels/events and `send_to` or `event_callback` overrides reject with `TypeError`.

Ads requires `AW-.../CONVERSION_LABEL` and event `conversion`. Use the [Google presets guide](/docs/google-presets) for complete examples. These methods exist even when the bridge is disabled; no registered destination means event routing rejects.

## Meta and Clarity events

```javascript
await Consent.meta.track('Purchase', { value: 49.90, currency: 'PLN' }, { eventID: 'order-123' });
await Consent.meta.trackCustom('NewsletterSignup');
await Consent.clarity.event('checkout-completed');
const signals = Consent.clarity.state();
```

Event helpers require their enabled preset, current permission at invocation and dispatch, and an initialized SDK. They return `true` for a submitted command and `false` for denied/unavailable processing; they do not confirm delivery or replay denied events. Invalid inputs and disabled presets reject. Names start with a letter, contain letters/digits/underscores/dots/hyphens, and have at most 128 characters. Meta parameters are a JSON-serializable object; options accept only a non-empty `eventID` string up to 128 characters. Payloads are captured at invocation.

Clarity state is a frozen `analytics_Storage`/`ad_Storage` snapshot and loads nothing. Clarity advertising requires explicit configuration plus analytics and marketing permission. Active preset withdrawal always reloads. Full examples: [Meta Pixel](/docs/meta-pixel) and [Microsoft Clarity](/docs/microsoft-clarity).
