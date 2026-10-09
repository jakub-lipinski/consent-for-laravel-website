## Consent Mode v2

The optional gtag.js bridge applies Google consent signals to GA4 and Google Ads. It is not a Google-certified CMP. Begin with [Google presets](/docs/google-presets).

## Basic and Advanced

`google.enabled` defaults to `null`: automatically enable the bridge when a preset is enabled. `true` enables consent signals for custom gated gtag code without requiring a preset. `false` disables the bridge and is rejected alongside enabled presets. `google.mode` defaults to `basic`.

**Basic** queues consent commands locally but makes no Google tag request while pending or refused. After a valid grant, it loads one shared gtag.js library using the first allowed destination's ID and configures only allowed destinations. Analytics alone never configures Ads. Granting another category later reuses that library. Each destination initializes once per document.

**Advanced** is explicit:

```php
'google' => ['enabled' => null, 'mode' => 'advanced'],
```

Enabled presets load and configure while optional consent is denied. Google's tags can then send cookieless measurement pings. This is processing before consent, not a promise of zero requests or zero personal data. Decide whether this is appropriate for the site's processing and jurisdiction, explain it in the policy, and test the actual network. The built-in banner and dialog display an additional localized disclosure. The event helper still refuses optional events without permission. Custom `@consent` blocks remain gated in both modes; Advanced changes built-in presets only.

## Signals and ordering

Every page begins with denied optional defaults, followed by the restored/current decision before measurement configuration. A persisted change updates Google synchronously before change listeners, new script activation, or withdrawal reload.

| Signal | Mapping |
| --- | --- |
| `analytics_storage` | Analytics |
| `ad_storage` | Marketing |
| `ad_user_data` | Marketing |
| `ad_personalization` | Marketing |
| `personalization_storage` | Marketing |
| `functionality_storage` | Always denied; no functionality preset is supplied |
| `security_storage` | Granted for necessary security storage |

The bridge sets `ads_data_redaction: true` and `url_passthrough: false`. Presets disable Google signals and ad personalization signals; category acceptance does not enable these optional product features. Do not add conflicting global commands outside the package. Region-specific defaults, enhanced conversions, user ID, user-provided data, and arbitrary gtag configuration are not provided in the package.

```javascript
const signals = Consent.google.state();
```

This returns a frozen mapped snapshot, not proof of Google's delivery or a valid audit record. The method exists even without an enabled bridge; it does not itself load Google.

## Withdrawal

Google receives the denied update synchronously before change callbacks or reload. Active built-in presets always reload, including with custom `reload: false` cleanup. GA4 is disabled immediately on Basic denial and active Advanced withdrawal. After an Advanced-mode reload, explicitly enabled presets again allow denied cookieless measurement.

## CSP and verification

The dynamic Google loader inherits the head component's nonce and uses the existing timeout/cancellation path. Allow the required script, connection, image, and frame destinations according to your actual Google setup. A script nonce alone does not allow outbound measurement requests. Do not copy a broad CSP wildcard; inspect the provider's current guidance and your host's policy.

Use a staging property, the real site's CSP, browser network inspection, and Google Tag Assistant to verify actual vendor behavior. Test pending/refusal/restored grant, separate category grants, expiry, cross-tab changes, blocked cookies, blocked provider requests, and withdrawal. Local package checks use mock tags rather than sending measurements to a live Google property; they establish command ordering and lifecycle behavior, not vendor account configuration or legal certification.

Primary references checked for this milestone:

- [Google consent implementation and ordering](https://developers.google.com/tag-platform/security/guides/consent)
- [Basic and Advanced Consent Mode](https://developers.google.com/tag-platform/security/concepts/consent-mode)
- [gtag API reference](https://developers.google.com/tag-platform/gtagjs/reference)
- [Google privacy controls](https://developers.google.com/tag-platform/security/guides/privacy)
- [EDPB consent guidelines, including withdrawal](https://www.edpb.europa.eu/system/files/documents/files/file1/edpb_guidelines_202005_consent_en.pdf)

Google Consent Mode is a vendor signal protocol. It is not a substitute for the site's valid legal basis, accurate information, meaningful choices, or evidence obligations.
