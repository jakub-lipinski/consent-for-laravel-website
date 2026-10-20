## Setup

Livewire support is optional. Use Livewire 3.8.10+ or 4.4.7+ with PHP 8.3+ and Laravel 12-13. The package detects the installed Livewire version and keeps its existing Blade components and browser API. It does not install Alpine, start Livewire, add a consent component or require a frontend build.

Keep one runtime early in the shared head and one banner in the body of every page participating in `wire:navigate`:

```blade
<head>
    <x-consent::head />
    {{-- Application / Livewire assets --}}
</head>
<body>
    {{ $slot }}
    <x-consent::banner />
</body>
```

Older published configurations inherit the following top-level defaults:

```php
'livewire' => [
    'enabled' => true,
    'navigation' => 'auto', // auto | reload
],
```

`auto` coordinates SPA visits. `reload` converts Livewire navigation into full visits. Boolean `enabled=false` disables special navigation/UI coordination; generic fragment loading and single-file inert-script protection remain. See [configuration](/docs/configuration#livewire-settings).

## Language changes

Leave `ui.locale=null` and omit an explicit banner locale to follow the application. Set its locale before rendering the page or component:

```php
app()->setLocale($locale);
```

Preserve that selection across Livewire update requests through your middleware/session handling. The package renders the supplied locale; it does not infer one from the URL or create a separate language cookie. Component and config locale overrides keep their existing priority. Czech, Dutch and regional/custom locales follow the [same translation rules](/docs/translations).

Navigation replaces banner/dialog text, accessible names, status/error messages, service descriptions and the signed audit notice together. A banner initially rendered inside a Livewire component also follows language changes when that component rerenders. Its presentation key replaces the complete UI/notice container. Ordinary morphs with unchanged presentation preserve the dialog draft; a language replacement discards the draft and restores the saved choice.

Prefer a global banner outside components. Only one active consent interface is supported. Do not first lazy-load the entire banner/bootstrap into a document without the UI runtime. Language changes, renders and visits do not save a decision, add audit rows or extend expiry.

## Scripts in components

Register services globally and use ordinary inert blocks with explicit stable IDs:

```blade
<div>
    @consent('analytics', 'site-statistics-loader')
        <script src="/js/site-statistics.js"></script>
    @endconsent
</div>
```

The source is illustrative. Presets need no extra wrapper or SDK bootstrap. The package supplies a Livewire key on its templates when Livewire is installed. Keep each logical ID's category and code stable. Auto-generated IDs restart with a server render; avoid them for dynamic shared bootstraps. Read [block identity and ordering](/docs/blade-directives#stable-block-ids).

Identical blocks and SDKs load once per document, including across navigation/history. New blocks run only with permission. A removed block cannot start its remaining scripts; a preserved unchanged block pauses during navigation and resumes at its next script. Running code remains in the withdrawal lifecycle after its template disappears.

Class-based, single-file and multi-file views support ordinary gated markup. Livewire 4 extracts some single-file scripts before Blade compilation; the package protects gated tokens before extraction, including unindented tags. Do not nest `@script`/`@assets` with `@consent`: Livewire owns those separate execution transports. The preparation hook rejects that nesting; it is unsupported elsewhere too. Blade/PHP expressions inside gated scripts remain available to normal Blade compilation, including `@json` and `@js` values containing script-like text. Separate modules, raw vendor calls and PHP/Livewire actions are not automatically gated.

Omit explicit script nonces inside a block to inherit the runtime nonce. Nonce-only differences between identical replacement copies do not conflict. An explicitly invalid nonce is never repaired; mutation of an already discovered template remains an error.

The directive runs once per document. Widgets needing initialization on every component mount must manage DOM references/cleanup through the application's lifecycle and recheck `Consent.allowed(category)` before optional work.

## Navigation and focus

New activations pause at `livewire:navigating`. The adapter checks the destination's runtime context, synchronizes current consent/cleanup, then resumes after `livewire:navigated`. A canceled visit before the swap preserves the dialog and draft. A real swap closes the dialog without saving the draft or returning focus to the departing page. The destination owns focus.

The head marker compares configuration and asset revisions. Changed policy/services, cookie scopes, loader settings or package assets require a fresh document before further activation. Missing/multiple markers also require recovery. An automatic same-tab retry is bounded to one; unavailable retry storage or repeated failure emits `consent:reload-required` with `automatic:false`.

Active withdrawal still sends consent signals, cleans declared cookies, cancels queued work and performs a full reload where required. `Livewire.navigate()` cannot stop already running trackers. Existing [withdrawal rules](/docs/withdrawal) apply. Navigation preserves refusal and audit-recovery state across history changes and never restarts bootstrap recovery or records a decision. Audited actions retain the notice captured when invoked; a delayed receipt cannot override a newer refusal.

## Persisted interfaces

`@persist` is optional. Keep its layout-level wrapper outside Livewire components and preserve the complete UI with its matching notice:

```blade
@persist('site-consent')
    <div><x-consent::banner /></div>
@endpersist
```

A preserved dialog still closes on a real visit. If an app/config-locale interface differs from the incoming page's locale, the adapter performs a full refresh to update both the interface and notice. Component-explicit locale overrides remain pinned. For other presentation changes, change the persist key or use normal remount.

Customized views must preserve the full `wire:ignore`, presentation-dependent `wire:key` and UI/notice pairing inside `data-consent-container`. Merge the current head marker and banner wrapper during [upgrades](/docs/upgrading#livewire-and-language-update).

## SPA measurements

The adapter sends no automatic measurements. It dispatches `consent:navigated` once per completed compatible page swap with `{ id, url, title, previousUrl }`. The ID is a document-local counter; URL/title describe the destination, including redirects. Initial load, prefetch, canceled visits, morphs and hash-only changes without a swap emit no event.

Register a listener once, outside repeatedly executed component scripts. For example, retain Matomo's initial page view and add subsequent views:

```js
document.addEventListener('consent:navigated', event => {
    const destination = new URL(event.detail.url);
    destination.search = ''; // Adapt filtering to your application's data model.
    destination.hash = '';
    Consent.matomo.pageView({ url: destination.href, title: event.detail.title })
        .catch(error => console.error('Matomo page view failed', error));
});
```

Call only your enabled integration's [guarded helpers](/docs/browser-api). Denied calls are discarded and never replayed after acceptance. Filter sensitive URL parameters. Coordinate GA4 manual views with enhanced history measurement: `send_page_view=false` does not disable every automatic history event. See [Google's SPA guidance](https://developers.google.com/analytics/devguides/collection/ga4/single-page-applications). Clarity retains its SDK behavior; Ads conversions remain separate from page views.

`Consent.whenIdle()` includes already started navigation/cleanup/loader work, without awaiting arbitrary application callbacks. Do not await it inside a gated module.

## CSP and deployment

Supply matching application nonces to both components and Livewire. Livewire 4 needs its [CSP-safe build](https://livewire.laravel.com/docs/4.x/csp) when excluding `unsafe-eval`. Default Livewire 3/Alpine has no such guarantee. Auto mode uses full visits with nonce-bearing runtimes on Livewire 3 or unknown majors.

The original document's CSP governs SPA destinations. A new response nonce does not replace that policy. Livewire's DOMParser can report style nonce violations before adoption; exact static-style hashes can be needed in addition to nonces. Published consent CSS avoids its inline-style hash; custom inline palettes still need an appropriate style policy. The package never loosens CSP. Test the application's actual headers and assets; see [CSP and caching](/docs/csp-and-caching#livewire-navigation).

Refresh customized views and published assets together, invalidate stale HTML, clear compiled Blade/Livewire caches, rebuild relevant configuration/route caches and restart persistent workers. Livewire support changes neither cookie schema, service fingerprints nor saved-choice lifetimes. Follow the [upgrade sequence](/docs/upgrading#livewire-and-language-update).

## Verify in your application

Check pending, refused and saved choices during real component updates and `wire:navigate`, including Back/Forward, canceled visits, language changes and `@persist`. Inspect Network for denied requests and duplicate SDKs; verify stable script ordering, modules, CSP, active withdrawal and audit failures. Check native dialog focus, keyboard modality, 320px reflow and enlarged text in your supported browsers. Automated DOM checks alone do not establish these behaviors. See [compatibility checks](/docs/installation#compatibility) and [accessibility](/docs/accessibility).
