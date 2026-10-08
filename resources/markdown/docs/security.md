## Preference state is not authorization

The preference cookie is intentionally readable by JavaScript, unsigned, and user-editable. It represents browser preferences. Do not use it to grant protected access, identify a visitor, authorize a purchase, or prove who made a decision. The package has no database audit trail.

Malformed or outdated values deny optional processing. This fail-closed behavior does not turn the cookie into a trusted security credential.

## Keep application cookies protected

The provider excludes only the configured consent cookie from encryption. Do not broadly disable Laravel cookie encryption. Session, CSRF, and remember cookies must remain protected. Cookie configuration rejects application-cookie collisions, and browser cleanup excludes protected names.

Use HTTPS and correct trusted-proxy settings. Scope the preference cookie deliberately; changing scope requires removing old cookies with their old attributes.

## Server processing

`@consent` is not a PHP conditional. All server-side work inside a Blade block still runs. The preference API is not an authorization boundary for server-side tracking, personal-data processing, or access control. Your application owns those policies and endpoints.

If you provide a server-written choice route, keep it CSRF-protected, validate submitted data, require an explicit action, and preserve private/no-store response headers.

## Scope of browser protection

Only declared inert script blocks are gated. Trackers outside blocks, tracking pixels, iframes, tag containers, service workers, background requests, and independently running provider code require deliberate integration. Necessary is not an exemption switch for an optional purpose.

The package does not scan cookies, generate legal policy text, inspect vendor contracts, or certify EU legal compliance. Describe actual purposes and providers, collect an appropriate choice, provide policy information, and honor withdrawal across every processing path.

## Safe diagnostics

`consent:error` reports runtime failures. Log technical details without preference-cookie contents, personal data, CSP nonces, or provider secrets. Do not put credentials or confidential data into scripts or service metadata delivered to the browser.

## Reporting

Review [the package repository](https://github.com/jakub-lipinski/consent-for-laravel) for its current security reporting options. Avoid publishing an exploitable issue or secret in a public issue. Documentation corrections can be raised in [website issues](https://github.com/jakub-lipinski/consent-for-laravel-website/issues).

## Google modes and event data

Basic makes no Google requests before a valid category grant. Explicit Advanced presets can send cookieless pings before a choice and after refusal, so evaluate and disclose that processing. Consent Mode supplies vendor signals, not legal certification. Avoid personal data in ordinary analytics parameters; enhanced conversions and user-provided data are outside this beta. The event helper guards destinations and permissions but cannot intercept tracking installed independently. See [Google Consent Mode](/docs/google-consent-mode).
