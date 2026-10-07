<?php

return [
    'name' => 'Consent for Laravel',
    'release' => 'v1.0.0-beta.3',
    'package' => 'webcrafts-studio/consent-for-laravel',
    'repository' => 'https://github.com/jakub-lipinski/consent-for-laravel',
    'website_repository' => 'https://github.com/jakub-lipinski/consent-for-laravel-website',
    'documentation' => [
        'Start here' => [
            ['slug' => 'introduction', 'title' => 'Introduction', 'description' => 'The essentials of Consent for Laravel and the current beta.'],
            ['slug' => 'installation', 'title' => 'Installation', 'description' => 'Install the current beta with Composer and Laravel auto-discovery.'],
            ['slug' => 'quick-start', 'title' => 'Quick start', 'description' => 'Register a purpose, add the interface, and gate your first script.'],
        ],
        'The interface' => [
            ['slug' => 'services-and-categories', 'title' => 'Services and categories', 'description' => 'Describe your processing purposes and expose only used categories.'],
            ['slug' => 'banner-and-theme', 'title' => 'Banner and theme', 'description' => 'Choose a position, policy link, and accessible colors.'],
            ['slug' => 'translations', 'title' => 'Translations', 'description' => 'English, Polish, and translated service descriptions.'],
            ['slug' => 'accessibility', 'title' => 'Accessibility', 'description' => 'Keyboard, focus, contrast, reflow, and integration responsibilities.'],
        ],
        'Developer API' => [
            ['slug' => 'blade-directives', 'title' => 'Blade directives', 'description' => 'Cache-safe script blocks with ordering and duplicate prevention.'],
            ['slug' => 'browser-api', 'title' => 'Browser API', 'description' => 'Choose, inspect, refresh, and react to browser preferences.'],
            ['slug' => 'php-api', 'title' => 'PHP API', 'description' => 'Read and persist consent from Laravel controllers and services.'],
            ['slug' => 'configuration', 'title' => 'Configuration reference', 'description' => 'Every implemented option, default, and validation rule.'],
        ],
        'In production' => [
            ['slug' => 'persistence', 'title' => 'Persistence and expiry', 'description' => 'The cookie contract, versions, retention, and invalidation.'],
            ['slug' => 'withdrawal', 'title' => 'Withdrawal and cleanup', 'description' => 'Stop processing safely and remove declared first-party cookies.'],
            ['slug' => 'csp-and-caching', 'title' => 'CSP, assets, and caching', 'description' => 'Nonces, published assets, shared HTML, and deployment caches.'],
            ['slug' => 'spa-integration', 'title' => 'SPA integration', 'description' => 'Fragments, stable IDs, remounting, and provider lifecycles.'],
            ['slug' => 'troubleshooting', 'title' => 'Troubleshooting', 'description' => 'Diagnose loading, storage, configuration, and interface problems.'],
        ],
        'The project' => [
            ['slug' => 'upgrading', 'title' => 'Upgrading', 'description' => 'Move between the development betas without losing valid choices.'],
            ['slug' => 'roadmap', 'title' => 'Roadmap and integrations', 'description' => 'What ships today and what comes next before version 1.0.'],
            ['slug' => 'security', 'title' => 'Security and privacy', 'description' => 'Cookie boundaries, protected state, and site-specific responsibilities.'],
        ],
    ],
];
