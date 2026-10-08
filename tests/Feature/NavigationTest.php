<?php

it('links both header menus to the landing sections and documentation from each page', function (string $path, bool $isDocumentation) {
    $response = $this->get($path)->assertOk();

    $document = new DOMDocument;
    $document->loadHTML($response->getContent(), LIBXML_NOERROR | LIBXML_NOWARNING);
    $xpath = new DOMXPath($document);

    foreach (['Main navigation', 'Mobile navigation'] as $label) {
        $links = $xpath->query('//header//nav[@aria-label="'.$label.'"]/a');
        $destinations = [];

        foreach ($links as $link) {
            $destinations[trim($link->textContent)] = $link->getAttribute('href');
        }

        expect($destinations)->toBe([
            'Features' => route('home').'#principles',
            'Integrations' => route('home').'#setup',
            'Live demo' => route('home').'#preview',
            'Documentation' => route('docs.index'),
        ]);
        expect($links->item(3)->getAttribute('aria-current'))->toBe($isDocumentation ? 'page' : '');
    }
})->with([
    'landing page' => ['/', false],
    'documentation' => ['/docs/installation', true],
]);

it('provides an existing landing section for every header fragment link', function () {
    $response = $this->get('/')->assertOk();

    $document = new DOMDocument;
    $document->loadHTML($response->getContent(), LIBXML_NOERROR | LIBXML_NOWARNING);
    $xpath = new DOMXPath($document);
    $links = $xpath->query('//header/nav/a[contains(@href, "#")]');

    expect($links->length)->toBe(3);
    foreach ($links as $link) {
        $fragment = parse_url($link->getAttribute('href'), PHP_URL_FRAGMENT);

        expect($xpath->query('//section[@id="'.$fragment.'"]')->length)->toBe(1);
    }
});
