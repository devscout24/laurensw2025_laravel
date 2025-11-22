<?php

return [

    'paths'                    => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods'          => ['*'],

    // 'allowed_origins'          => ['*'],

    'allowed_origins'          => [
        'http://localhost:5173', // Vite React dev server
        'http://127.0.0.1:5173',
        'http://172.16.100.26:5173',
        'http://localhost:3000',
        'http://127.0.0.1:3001',
        'https://polar-traveler.vercel.app',
        'http://127.0.0.1:3002',
        'https://polar-traveler-psq3gixhp-mobaroks-projects-dfd8e6fb.vercel.app',
        'https://laurensw2025.softvencefsd.xyz',
        'https://admin.polartraveler.com',
        'https://polartraveler.com',
        'https://tahirtaim.dev',
        'http://128.199.31.100:3000',

    ],

    'allowed_origins_patterns' => [],

    'allowed_headers'          => ['*'],

    'exposed_headers'          => [],

    'max_age'                  => 0,

    'supports_credentials'     => true,

];
