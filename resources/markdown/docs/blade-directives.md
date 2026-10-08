## A browser gate, not a PHP condition

```blade
@consent('analytics', 'site-insights')
    <script src="/js/site-insights.js"></script>
    <script>
        window.siteInsights.initialize();
    </script>
@endconsent
```

The service must be registered and the category must be used. The provider path and API above are examples owned by your app.

The directive always renders an inert HTML template, regardless of the request cookie. Blade expressions, includes, and PHP inside the block still execute on the server. Do not use it as an authorization check or as a way to suppress server-side processing.

The browser checks current permission before each script starts, including immediately after acceptance on the same page. Shared HTML can therefore serve both accepted and undecided visitors.

## Allowed block contents

Blocks accept script elements, whitespace, and comments. Classic inline/external scripts, modules, and JSON data scripts are supported. External script sources must use HTTP(S).

Do not put images, iframes, arbitrary HTML, tracking `noscript` fallbacks, or nested consent blocks inside. Network requests elsewhere in your page remain your application's responsibility. Render such features through a separate lifecycle you control.

## Stable block IDs

The second argument is an optional stable block ID. Use it for repeated partials and SPA fragments. `consent-auto-` is reserved for automatically generated IDs.

Identical explicit IDs with identical contents deduplicate. Reusing an ID for different contents reports a diagnostic rather than executing conflicting code. A block executes at most once per document; remounting it does not restart it.

## Ordering and deduplication

Scripts run in document order among currently allowed categories. A library finishes loading before its following initialization code. Modules wait for imports and top-level await. The loader checks permission again between activations.

External sources are deduplicated using their resolved URL, classic/module type, integrity, CORS, and referrer policy. A failed block stops its dependent scripts; independent blocks can still proceed. Failed blocks are not retried in the same document. A script timeout can reload once per tab until that script succeeds. Repeated timeouts, or unavailable retry storage, stop activation and emit `consent:reload-required` with `automatic: false` for host-managed manual recovery.

The loader's timeout covers its own activation lifecycle, not every asynchronous operation later scheduled by a provider. Use `window.Consent.whenIdle()` to await package operations, then use the provider's own readiness API when needed.

## Changes and withdrawal

Removing a script element cannot stop executed JavaScript. Revoking an active category reloads by default. Cooperative cleanup is possible only if you can completely stop every service in that category. See [withdrawal](/docs/withdrawal).

For asset nonces, shared HTML, and deployment settings, read [CSP and caching](/docs/csp-and-caching).
