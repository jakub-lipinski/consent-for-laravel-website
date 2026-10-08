<?php

use App\Documentation;

it('redirects the documentation entry to the introduction', function () {
    $this->get(route('docs.index'))->assertRedirectToRoute('docs.show', 'introduction');
});

it('renders every published documentation chapter and its title', function (string $slug) {
    $page = app(Documentation::class)->page($slug);
    $this->get(route('docs.show', $slug))
        ->assertOk()
        ->assertSee('<h1>'.$page['title'].'</h1>', false)
        ->assertSee('data-doc-content', false)
        ->assertSee('aria-current="page"', false);
})->with([
    'introduction', 'installation', 'quick-start', 'services-and-categories',
    'banner-and-theme', 'translations', 'accessibility', 'blade-directives',
    'browser-api', 'php-api', 'configuration', 'persistence', 'withdrawal',
    'google-consent-mode', 'google-presets', 'meta-pixel', 'microsoft-clarity', 'csp-and-caching', 'spa-integration', 'troubleshooting', 'upgrading', 'roadmap', 'security',
]);

it('rejects unknown or path-like chapter names', function (string $path) {
    $this->get($path)->assertNotFound();
})->with(['/docs/not-a-chapter', '/docs/README.md', '/docs/%2E%2E%2F.env']);

it('provides searchable text with working named chapter links', function () {
    $response = $this->getJson(route('docs.search'))->assertOk()->assertJsonCount(23);
    $chapters = $response->json();
    $installation = collect($chapters)->firstWhere('slug', 'installation');
    $blade = collect($chapters)->firstWhere('slug', 'blade-directives');
    expect($installation['content'])->toContain('repositories.consent vcs', 'consent-for-laravel:1.0.0-beta.5')->not->toContain('<pre>');
    expect($blade['content'])->toContain('@consent')->toContain('not a PHP condition');
    expect($blade['url'])->toBe(route('docs.show', 'blade-directives'));
});

it('strips executable HTML and unsafe Markdown links', function () {
    $rendered = app(Documentation::class)->render("## Safe heading\n\n<script>alert(1)</script>\n\n[Unsafe](javascript:alert(1))\n\n**Readable**");
    expect($rendered['html'])->not->toContain('<script>')->not->toContain('href="javascript:')->toContain('<strong>Readable</strong>');
});

it('produces unique navigable heading identifiers when titles collide', function () {
    $rendered = app(Documentation::class)->render("## Example\n\n## Example\n\n### Example 2\n\n## Example");
    $ids = array_column($rendered['toc'], 'id');
    expect($ids)->toHaveCount(4)->and(array_unique($ids))->toHaveCount(4);
    foreach ($ids as $id) {
        expect($rendered['html'])->toContain('id="'.$id.'" tabindex="-1"');
    }
});

it('keeps documentation links within published chapters or real website routes', function () {
    $docs = app(Documentation::class);
    foreach ($docs->pages() as $page) {
        preg_match_all('/\]\((\/[^)]+)\)/', $docs->markdown($page['slug']), $matches);
        foreach (array_unique($matches[1]) as $path) {
            $this->get($path)->assertOk();
        }
    }
});

it('presents the current beta honestly and exposes a cookie-free interface preview', function () {
    $this->get(route('home'))->assertOk()
        ->assertSee('v1.0.0-beta.5')
        ->assertSee('No cookies or trackers.')
        ->assertSeeInOrder(['Available in beta.5', 'Google Consent Mode v2', 'Meta Pixel and Microsoft Clarity presets', 'Next steps', 'Deferred, with no assigned beta'])
        ->assertSee('Skip to content')
        ->assertSee('aria-labelledby="preview-title"', false);
});

it('serves a separate accessibility statement with an issue reporting path', function () {
    $this->get(route('accessibility'))->assertOk()
        ->assertSee('Website accessibility - Consent for Laravel')
        ->assertSee('Report a website accessibility issue on GitHub');
});
