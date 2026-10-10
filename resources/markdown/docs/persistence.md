## One shared preference format

The PHP API and browser runtime read/write the same first-party cookie. Its payload contains no identity, IP address, or generated visitor identifier.

```json
{
    "schemaVersion": 1,
    "policyVersion": "1",
    "servicesVersion": "generated fingerprint of enabled services",
    "choices": {
        "necessary": true,
        "analytics": true,
        "marketing": false,
        "performance": false,
        "other": false
    },
    "decidedAt": 1791374400,
    "expiresAt": 1806926400
}
```

This is an illustration, not a cookie to copy. The package generates the real fingerprint and UTC Unix-second timestamps. Pending states have null timestamps and cannot be persisted as decisions.

## Fail closed

Optional processing is denied for missing, malformed, incomplete, overlong, future-dated, expired, or incompatible values. The maximum payload is 3072 UTF-8 bytes. Choices must include all five categories as booleans, with necessary allowed and unused optional categories denied.

The cookie is browser-readable, unsigned, user-editable, and `HttpOnly=false`. It is a preference store, not proof of a particular person's consent or an authorization mechanism. Optional [database audit history](/docs/audit-log) is separate from this cookie.

## Versions with different jobs

- The package release comes from its Git tag.
- `schemaVersion` identifies the cookie format.
- `policy_version` belongs to your application; increment it for material policy/purpose changes.
- `servicesVersion` fingerprints enabled service IDs, categories, names, descriptions, and non-empty cookie cleanup rules.

Adding, enabling, disabling, removing, renaming, or changing an active definition invalidates previous decisions. Reordering definitions, trimming outer whitespace, editing disabled metadata, and changing UI variant/colors/position/language do not invalidate or extend a decision.

## Expiry

Acceptance and refusal both expire after `retention_days`, measured from the explicit choice. Reads never extend it. The runtime checks the exact expiry second even if an old cookie is still present.

Shortening retention invalidates decisions beyond the new limit. Increasing retention does not extend an existing decision. The default 180 days is not a universal legal expiry period; select a setting appropriate to your actual processing and jurisdiction.

## Scope and encryption

The default cookie is host-only, scoped to `/`, with `SameSite=Lax`. `secure: null` follows request HTTPS; configure trusted proxies correctly, or set `secure: true` on an HTTPS-only deployment. `SameSite` accepts `lax` or `strict`.

Only the configured preference cookie is excluded from Laravel encryption. Session, CSRF, and remember cookies remain protected. Changing the name, path, or domain does not remove the old cookie: expire it separately with its original scope.

## Failed storage

A failed preference write does not grant optional processing. The runtime denies in memory and attempts a temporary denial marker in session storage, then an object-form history state while preserving existing fields.

If neither marker can persist, automatic reload could restore an old accepted cookie. The runtime therefore reports a storage-denial diagnostic and `consent:reload-required` with `automatic: false`. Already running code cannot be made safe merely by removing its element; your interface must explain the failure and allow the visitor to close the page. A later successful decision clears temporary denial markers.

## Cross-tab updates

The runtime rechecks about once per second and on focus, pageshow, and visibility changes. Another tab's refusal, policy mismatch, or expiry can trigger withdrawal in a running document. Permission is also checked again before each script activation.

## Google configuration changes

Enabled Google IDs, Basic/Advanced mode, automatic page-view configuration, canonical preset purposes, and cleanup rules contribute to the active-service fingerprint. Changing them makes old decisions pending. Disabled presets and an inactive bridge preserve existing fingerprints. The preference cookie remains schema version 1.

## Optional audit history

With `audit.enabled`, explicit browser choices are also submitted to the audit endpoint. New optional grants require a committed receipt; refusal and withdrawal take effect locally immediately. Cookie reads, expiry, cross-tab refresh, and manual cookie edits do not append history.

The audit endpoint issues a separate signed HttpOnly `{preference cookie name}_audit` cookie, host-only and scoped to its own path. It groups browser decisions while available and does not authenticate a person. Clearing it or using another device can split the history; there is no fingerprint-based reconnection.

Preference `retention_days` controls current browser choice lifetime. `audit.retention_days` controls explicit pruning of historical decisions. The stored `expires_at` uses the original signed notice's preference lifetime and the server's UTC receipt time; it is not the audit deletion deadline and can differ slightly from the browser clock. A logged submission can still be followed by a failed preference-cookie write. See [stored data](/docs/audit-log#stored-data) and [failure behavior](/docs/audit-log#failures-and-withdrawal).
