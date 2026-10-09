<?php

return [
    'name' => 'Consent for Laravel',
    'release' => 'v1.1.3',
    'package' => 'jakub-lipinski/consent-for-laravel',
    'packagist' => 'https://packagist.org/packages/jakub-lipinski/consent-for-laravel',
    'repository' => 'https://github.com/jakub-lipinski/consent-for-laravel',
    'website_repository' => 'https://github.com/jakub-lipinski/consent-for-laravel-website',
    'documentation' => [
        'Start here' => [
            ['slug' => 'introduction', 'title' => 'Introduction', 'description' => 'The essentials of Consent for Laravel and version 1.1.'],
            ['slug' => 'installation', 'title' => 'Installation', 'description' => 'Install from Packagist, publish the configuration, and check Laravel auto-discovery.'],
            ['slug' => 'quick-start', 'title' => 'Quick start', 'description' => 'Install with Composer, enable a preset or your own script, and add the interface.'],
        ],
        'The interface' => [
            ['slug' => 'services-and-categories', 'title' => 'Services and categories', 'description' => 'Describe your processing purposes and expose only used categories.'],
            ['slug' => 'banner-and-theme', 'title' => 'Banner and theme', 'description' => 'Variants, positions, colors, and upcoming light/dark/auto modes.'],
            ['slug' => 'translations', 'title' => 'Translations', 'description' => 'English/Polish plus upcoming bundled languages and custom locale fallback.'],
            ['slug' => 'accessibility', 'title' => 'Accessibility', 'description' => 'Keyboard, focus, contrast, reflow, and integration responsibilities.'],
        ],
        'Developer API' => [
            ['slug' => 'blade-directives', 'title' => 'Blade directives', 'description' => 'Cache-safe script blocks with ordering and duplicate prevention.'],
            ['slug' => 'browser-api', 'title' => 'Browser API', 'description' => 'Choose, inspect, refresh, and react to browser preferences.'],
            ['slug' => 'php-api', 'title' => 'PHP API', 'description' => 'Read and persist consent from Laravel controllers and services.'],
            ['slug' => 'configuration', 'title' => 'Configuration reference', 'description' => 'Stable options and unreleased additions, with defaults and validation.'],
        ],
        'Google integrations' => [
            ['slug' => 'google-consent-mode', 'title' => 'Google Consent Mode v2', 'description' => 'Basic and Advanced modes, denied defaults, signal mapping, and withdrawal.'],
            ['slug' => 'google-presets', 'title' => 'GA4 and Google Ads', 'description' => 'Enable presets by ID, send guarded events, and configure cookie cleanup.'],
        ],
        'Other integrations' => [
            ['slug' => 'meta-pixel', 'title' => 'Meta Pixel', 'description' => 'Marketing consent, ID-based setup, guarded events, and PageView control.'],
            ['slug' => 'microsoft-clarity', 'title' => 'Microsoft Clarity', 'description' => 'Analytics gating, Consent API v2, optional advertising, and masking.'],
        ],
        'In production' => [
            ['slug' => 'persistence', 'title' => 'Persistence and expiry', 'description' => 'The cookie contract, versions, retention, and invalidation.'],
            ['slug' => 'withdrawal', 'title' => 'Withdrawal and cleanup', 'description' => 'Stop processing safely and remove declared first-party cookies.'],
            ['slug' => 'csp-and-caching', 'title' => 'CSP, assets, and caching', 'description' => 'Nonces, published assets, shared HTML, and deployment caches.'],
            ['slug' => 'spa-integration', 'title' => 'SPA integration', 'description' => 'Fragments, stable IDs, remounting, and provider lifecycles.'],
            ['slug' => 'troubleshooting', 'title' => 'Troubleshooting', 'description' => 'Diagnose loading, storage, configuration, and interface problems.'],
        ],
        'The project' => [
            ['slug' => 'upgrading', 'title' => 'Upgrading', 'description' => 'Upgrade safely, merge published resources, and preserve valid choices.'],
            ['slug' => 'integrations', 'title' => 'Included features', 'description' => 'The implemented interface, consent lifecycle, and tracker integrations.'],
            ['slug' => 'security', 'title' => 'Security and privacy', 'description' => 'Cookie boundaries, protected state, and site-specific responsibilities.'],
        ],
    ],
];
