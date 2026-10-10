<?php

return [
    // Increment when the purposes or consent policy change.
    'policy_version' => '1',

    // Acceptance and refusal have the same lifetime, measured from the decision.
    'retention_days' => 180,

    'cookie' => [
        'name' => 'consent_preferences',
        'path' => '/',
        'domain' => null,
        // null follows the request's HTTPS status. Configure trusted proxies.
        'secure' => null,
        'same_site' => 'lax',
    ],

    // This website keeps database decision history disabled.
    // See /docs/audit-log for optional migration and enablement in your app.
    'audit' => [
        'enabled' => false,
        'connection' => null,
        'decisions_table' => 'consent_decisions',
        'notices_table' => 'consent_notices',
        'path' => '/consent/decisions',
        'retention_days' => 180,
        'timeout_ms' => 5000,
    ],

    'loader' => [
        'script_timeout_ms' => 15000,
        'cleanup_timeout_ms' => 3000,
    ],

    'ui' => [
        // Applies to both the banner and the preferences dialog.
        'variant' => 'compact', // standard or compact
        'position' => 'bottom-right',
        'theme' => 'light',
        // null uses the application's locale, with English as the fallback.
        'locale' => null,
        'policy_url' => null,
        // Optional contrast warnings in the application log; never interrupt rendering.
        'validate_contrast' => false,
        // Invalid color formats fall back to their defaults and log a warning.
        'colors' => [
            'accent' => '#315fe9',
            'focus' => '#315fe9',
        ],
        'dark_colors' => [],
    ],

    // null enables the bridge automatically when a Google preset is enabled.
    // true enables consent signals for your own gated gtag scripts; false disables it.
    // Advanced explicitly allows Google tags and cookieless pings before permission.
    'google' => ['enabled' => null, 'mode' => 'basic'],

    // Presets register their services, cleanup rules, and browser initialization.
    'presets' => [
        'ga4' => [
            'enabled' => true,
            'measurement_id' => env('CONSENT_GA4_ID', 'G-1MCJC174G4'),
            'send_page_view' => true,
        ],
        'google_ads' => [
            'enabled' => false,
            'conversion_id' => env('CONSENT_GOOGLE_ADS_ID'),
        ],
        'meta_pixel' => [
            'enabled' => false,
            'pixel_id' => env('CONSENT_META_PIXEL_ID'),
            'send_page_view' => true,
        ],
        'clarity' => [
            'enabled' => false,
            'project_id' => env('CONSENT_CLARITY_ID'),
            // Also requires marketing permission. Analytics alone never grants ad storage.
            'advertising' => false,
        ],
    ],

    // Custom services describe purposes. Gate their scripts with @consent.
    // Each service requires category, name, description, and an optional boolean enabled.
    // Optional cookies: [['name' => '_example', 'path' => '/', 'domain' => null]].
    // Use prefix instead of name to match visible cookies with a known prefix.
    'services' => [],
];
