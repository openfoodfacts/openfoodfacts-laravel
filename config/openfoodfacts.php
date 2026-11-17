<?php

return [
    'geography' => 'world',
    'max_results' => 1000,
    'cache' => [
        'enabled' => env('OPENFOODFACTS_CACHE_ENABLED', true),
        'store' => env('OPENFOODFACTS_CACHE_STORE'),
        'ttl' => env('OPENFOODFACTS_CACHE_TTL', 3600),
    ],
];
