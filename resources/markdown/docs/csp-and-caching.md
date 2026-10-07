## Default inline assets

The components embed the core runtime, banner script, and styles by default. No npm dependency or host build step is needed. With a strict Content Security Policy, pass a fresh application-generated nonce:

```blade
<x-consent::head :nonce="$cspNonce" />
<x-consent::banner :nonce="$cspNonce" />
```

Your host generates the nonce and matching HTTP CSP header. The package does not create that policy. Activated scripts inherit the nonce unless they declare their own. Allow any required external provider hosts in the appropriate CSP directives.

## Publish separate files

```bash
php artisan vendor:publish --tag=consent-assets
```

```blade
<x-consent::head
    :src="asset('vendor/consent/consent.js')"
    :nonce="$cspNonce"
/>
<x-consent::banner
    :style-src="asset('vendor/consent/consent.css')"
    :script-src="asset('vendor/consent/banner.js')"
    :nonce="$cspNonce"
/>
```

The head component emits configuration before the runtime. Custom colors still create a small inline theme style, so a matching style nonce is required even when the main stylesheet is external. Serve published files from a CSP-allowed origin.

Republish package assets after updates, using `--force` only after accounting for any application changes. Use your deployment's cache-busting strategy. Published filenames are not automatically content-hashed.

## Shared HTML

`@consent` templates are inert and independent of visitor preferences, making the same HTML safe to reuse across accepted and undecided visitors. The browser performs the gate. Do not introduce server-side preference conditionals into shared cached HTML.

Translations still depend on locale; vary a multilingual cache accordingly. If HTML contains a CSP nonce, your caching layer must ensure the served markup and response header use matching values. Reusing a per-response nonce blindly in shared caches undermines the intended CSP design.

## Server-written decisions

Responses passed through `persist()` or `forget()` are marked `private, no-store`. Preserve those headers in reverse proxies and CDNs. Do not cache consent-writing endpoints or private personalized consent output.

## Deploying configuration changes

Rebuild `config:cache`, clear compiled views where appropriate, restart long-running workers, and update assets. Service/policy changes can invalidate decisions; UI language, position, and color changes do not.

Test the real CSP in the browser, including dynamically activated modules, inline initialization, custom colors, and provider hosts. A successful Blade render cannot establish that a browser CSP permits execution.
