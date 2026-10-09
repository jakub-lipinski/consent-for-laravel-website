## Default inline assets

The components embed the core runtime, banner script, and styles by default. No npm dependency or host build step is needed. With a strict Content Security Policy, pass a fresh application-generated nonce:

```blade
<x-consent::head :nonce="$cspNonce" />
<x-consent::banner :nonce="$cspNonce" />
```

Your host generates the nonce and matching HTTP CSP header. The package does not create that policy. Activated scripts inherit the nonce unless they declare their own. Allow any required external provider hosts in the appropriate CSP directives.

## Publish separate files

This step is optional. Publishing copies the files; point the components at them using the props below. Omit nonce props if your app does not use a nonce-based CSP; `$cspNonce` is supplied by the host application.

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

Republish package assets after updates, using `--force` only after accounting for any application changes. Use your deployment's cache-busting strategy. Published filenames are not automatically content-hashed. For version 1.1, deploy matching views and styles together: customized banner views need the `variant` prop and `data-consent-variant` root attribute for Compact to style both the banner and preferences.

## Shared HTML

`@consent` templates are inert and independent of visitor preferences, making the same HTML safe to reuse across accepted and undecided visitors. The browser performs the gate. Do not introduce server-side preference conditionals into shared cached HTML.

Translations still depend on locale; vary a multilingual cache accordingly. If HTML contains a CSP nonce, your caching layer must ensure the served markup and response header use matching values. Reusing a per-response nonce blindly in shared caches undermines the intended CSP design.

## Server-written decisions

Responses passed through `persist()` or `forget()` are marked `private, no-store`. Preserve those headers in reverse proxies and CDNs. Do not cache consent-writing endpoints or private personalized consent output.

## Deploying configuration changes

Rebuild `config:cache`, clear compiled views where appropriate, restart long-running workers, and update assets. Service/policy changes can invalidate decisions; UI variant, language, position, and color changes do not invalidate or extend them.

Test the real CSP in the browser, including dynamically activated modules, inline initialization, custom colors, and provider hosts. A successful Blade render cannot establish that a browser CSP permits execution.

## Google destinations

The preset's dynamic gtag.js loader inherits the head nonce. Outbound measurement still requires appropriate `connect-src`, `img-src`, and any provider-specific frame policy. Inspect the real destinations for your configured Google products and use the current [Google CSP guidance](https://developers.google.com/tag-platform/security/guides/csp). No broad wildcard policy is supplied. Blocked tag loading reports a `google` error and leaves destinations unconfigured; blocked measurement may occur after commands were successfully queued.

External modules retain their original SRI/credential checks and use a second nonce-bearing import marker to wait for asynchronous module evaluation before continuing the block. The cached module is not executed twice.

## Meta and Clarity origins

Both bootstrap scripts inherit the head nonce. Meta starts from `connect.facebook.net/en_US/fbevents.js`; Clarity from `www.clarity.ms/tag/PROJECT_ID`. Review actual vendor script, image, and connection requirements separately. Microsoft documents `*.clarity.ms` and `c.bing.com`; apply appropriate directives rather than broad unsafe-inline allowances. Nonce inheritance alone does not permit outgoing fetches/images. See [Meta](/docs/meta-pixel) and [Clarity](/docs/microsoft-clarity) for verification.

## Themes and locale fallback

The `data-consent-theme` attribute and scoped CSS resolve auto in the browser, so shared HTML does not need to vary by system color preference. It must still reflect the UI config used to render it, and multilingual HTML must vary by the selected component/config/app locale.

Custom colors in **either** palette emit a nonce-protected inline override even when the main CSS is external. Empty palettes that resolve to defaults need no extra theme style. Deploy updated published CSS and customized banner views together; preserve their nonce and both-palette override logic. The package theme change adds no JavaScript dependency or visitor preference cookie.

The 72-hour warning marker uses the app's default server cache independently of HTML caching and consent decisions. Its failure skips diagnostics without breaking the response. See [the upgrade steps](/docs/upgrading#language-and-theme-update).
