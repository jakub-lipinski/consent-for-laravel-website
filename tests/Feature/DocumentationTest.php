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
    'google-consent-mode', 'google-presets', 'meta-pixel', 'microsoft-clarity', 'csp-and-caching', 'spa-integration', 'troubleshooting', 'upgrading', 'integrations', 'security',
]);

it('rejects unknown or path-like chapter names', function (string $path) {
    $this->get($path)->assertNotFound();
})->with(['/docs/not-a-chapter', '/docs/README.md', '/docs/%2E%2E%2F.env']);

it('provides searchable text with working named chapter links', function () {
    $response = $this->getJson(route('docs.search'))->assertOk()->assertJsonCount(23);
    $chapters = $response->json();
    foreach ($chapters as $chapter) {
        expect(strtolower($chapter['content']))->not->toContain('beta.', 'gtm', 'tag manager', 'planned milestone');
    }
    $installation = collect($chapters)->firstWhere('slug', 'installation');
    $blade = collect($chapters)->firstWhere('slug', 'blade-directives');
    expect($installation['content'])->toContain('composer require jakub-lipinski/consent-for-laravel')->toContain('repositories.consent vcs https://github.com/jakub-lipinski/consent-for-laravel.git', 'consent-for-laravel:^1.1.1')->not->toContain('@dev')->not->toContain('<pre>');
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

it('presents the stable release honestly and exposes a cookie-free interface preview', function () {
    $this->get(route('home'))->assertOk()
        ->assertSee('v1.1.1')
        ->assertSee('composer require jakub-lipinski/consent-for-laravel')
        ->assertDontSee('beta')
        ->assertDontSee('GTM')
        ->assertDontSee('Google Tag Manager')
        ->assertSee('No cookies or trackers.')
        ->assertSee('Interface variant')
        ->assertSee('Services in this category')
        ->assertDontSee('data-preview-services open', false)
        ->assertDontSee('<summary hidden>', false)
        ->assertSee('name="preview-variant" value="standard"', false)
        ->assertSee('name="preview-variant" value="compact"', false)
        ->assertSeeInOrder(['Included in version 1.1', 'Google Consent Mode v2', 'Meta Pixel and Microsoft Clarity presets', 'Consent throughout the lifecycle'])
        ->assertSee('Skip to content')
        ->assertSee('aria-labelledby="preview-title"', false);
});

it('serves a separate accessibility statement with an issue reporting path', function () {
    $this->get(route('accessibility'))->assertOk()
        ->assertSee('Website accessibility - Consent for Laravel')
        ->assertSee('Report a website accessibility issue on GitHub');
});

it('isolates the preview with the unmodified released package stylesheet', function () {
    $this->get(route('home'))->assertOk()
        ->assertSee('shadowrootmode="open"', false)
        ->assertSee('data-preview-package-styles', false)
        ->assertSee('data-preview-position-selector', false)
        ->assertSeeInOrder(['name="preview-variant"', 'name="preview-position"', 'data-preview-stage'], false)
        ->assertSee('Google Analytics 4')
        ->assertSee('Microsoft Clarity')
        ->assertSee('Google Ads')
        ->assertSee('Meta Pixel');

    expect(hash_file('sha256', resource_path('css/consent-preview.css')))->toBe('0440a1a5c538d32e44a1fcf98606b5c48b003cfadbd4fa57e567e295365782d3');
});

it('opens GitHub links in a new tab across the website and every documentation chapter', function () {
    $paths = [route('home'), route('accessibility')];
    foreach (app(Documentation::class)->pages() as $page) {
        $paths[] = route('docs.show', $page['slug']);
    }

    foreach ($paths as $path) {
        $response = $this->get($path)->assertOk();
        $document = new DOMDocument;
        $document->loadHTML($response->getContent(), LIBXML_NOERROR | LIBXML_NOWARNING);
        $links = (new DOMXPath($document))->query('//a[starts-with(@href, "https://github.com/")]');

        expect($links->length)->toBeGreaterThan(0);
        foreach ($links as $link) {
            expect($link->getAttribute('target'))->toBe('_blank');
            expect(explode(' ', $link->getAttribute('rel')))->toContain('noopener', 'noreferrer');
        }
    }
});

it('opens only GitHub Markdown links in a new tab and preserves link titles', function () {
    $rendered = app(Documentation::class)->render(<<<'MARKDOWN'
[Repository](https://github.com/laravel/framework "Source")
[Gist](https://gist.github.com/example/123)
[Uppercase](https://GITHUB.COM/laravel/framework)
[Internal](/docs/installation)
[Other](https://laravel.com/docs)
[Lookalike](https://github.com.example.com/repo)
MARKDOWN);
    $document = new DOMDocument;
    $document->loadHTML($rendered['html'], LIBXML_NOERROR | LIBXML_NOWARNING);

    foreach ($document->getElementsByTagName('a') as $link) {
        if (in_array($link->textContent, ['Repository', 'Gist', 'Uppercase'], true)) {
            expect($link->getAttribute('target'))->toBe('_blank');
            expect(explode(' ', $link->getAttribute('rel')))->toContain('noopener', 'noreferrer');
        } else {
            expect($link->hasAttribute('target'))->toBeFalse();
            expect($link->hasAttribute('rel'))->toBeFalse();
        }

        if ($link->textContent === 'Repository') {
            expect($link->getAttribute('title'))->toBe('Source');
        }
    }
});
