## Read without side effects

```php
use ConsentForLaravel\ConsentForLaravel\ConsentManager;

$consent = app(ConsentManager::class);
$state = $consent->read($request);

$state->hasDecision();
$state->allows('analytics');
$state->choices;
$state->toArray();
$consent->needsConsent($request);
```

Missing, invalid, expired, or outdated cookies produce a pending state: necessary allowed, optional denied. Reads never write or renew a cookie. `needsConsent()` is false if no optional services are used.

`allows()` accepts a `Category` enum case or a valid category string; an unknown string throws `ValueError`. `ConsentState` also implements JSON serialization using the same fields as `toArray()`.

The cookie is unsigned and user-editable. Never use its choices as an authorization, authentication, billing, or database audit mechanism.

## Create an explicit decision

```php
$decision = $consent->acceptAll();
$decision = $consent->rejectOptional();
$decision = $consent->choose(['analytics' => true, 'marketing' => false]);
```

These methods return an immutable state without saving it. `choose()` replaces all choices. Omitted optional categories are denied. Values must be actual booleans. Unknown categories, denying necessary, and granting unused categories throw `InvalidArgumentException`.

## Persist on a response

```php
return $consent->persist($decision, response()->noContent(), $request);
```

Only a current valid decision can be persisted. The response gets the configured preference cookie and `Cache-Control: private, no-store`. Calling a state creation method alone does not attach a cookie.

## An application-owned endpoint

With auditing disabled, the package registers no decision route. Enabling auditing registers only its JSON audit endpoint; it does not turn the PHP cookie helpers into automatic audit writers. You may create a CSRF-protected web endpoint for your own explicit interface actions:

```php
use ConsentForLaravel\ConsentForLaravel\ConsentManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/privacy/reject-optional', function (
    Request $request,
    ConsentManager $consent,
) {
    return $consent->persist(
        $consent->rejectOptional(),
        response()->noContent(),
        $request,
    );
})->name('privacy.reject');
```

Submit using the normal Laravel web/CSRF flow. If you accept category data, validate keys and genuine boolean values before passing them to `choose()`. The browser runtime is still needed to react to a changed cookie on the current document and gate its scripts.

## Remove a decision

```php
return $consent->forget(response()->noContent(), $request);
```

This expires the preference cookie in its configured scope and marks the response private/no-store. The next read is pending. It does not delete vendor cookies, stop running code, or invoke vendor withdrawal APIs. A remembered refusal is usually preferable to forgetting if the visitor's intent is to reject optional processing.

## Explicit server audit integration

`ConsentManager::persist()` and `forget()` remain cookie helpers, even when auditing is enabled. They cannot infer what a custom server interface showed and do not create database decisions. The bundled browser runtime supplies the notice automatically; custom server flows explicitly integrate these classes:

| API | Contract |
| --- | --- |
| `AuditNotice::seal($html, $locale, $requestedLocale, $presentation)` | Capture server-prepared UI HTML, effective/requested locales, and presentation metadata; return `{payload, signature}`, or null when auditing is disabled |
| `AuditRecorder::record($input, $consentId = null)` | Verify/store a complete signed submission; return `{id, consent_id}` after the transaction |

Both classes use the `ConsentForLaravel\ConsentForLaravel` namespace and are resolved through Laravel's container. Recorder input contains an event `id` (lowercase UUID v4), the signed `notice`, an `action` (`accept_all`, `reject_optional`, `save_preferences`, or `withdraw`), and all five boolean `choices`. Necessary stays true; unused optional categories stay false. A supplied browser history ID must be a validated UUID from your trusted integration.

Keep the original server-prepared notice with the interface. Do not reconstruct historical text from current translations at submit time or sign arbitrary client-supplied markup. Reuse the event UUID only for delivery retries of the same event. Conflicting reuse throws `AuditConflict`; invalid submissions throw `InvalidArgumentException`. Custom endpoints own identity-cookie handling, CSRF, response headers, and failure handling. See [the audit guide](/docs/audit-log).
