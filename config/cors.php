<?php


return [

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'http://localhost:5173',    // Vite React dev server
        'http://127.0.0.1:5173',
        'http://172.16.100.26:5173',
        'http://localhost:3000',
        'http://127.0.0.1:3001',
        'http://127.0.0.1:3002',
        'https://laurensw2025.softvencefsd.xyz'
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];
