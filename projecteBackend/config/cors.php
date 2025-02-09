<?php
return [

    'paths' => ['api/*', 'sanctum/csrf-cookie', 'login/google', 'login/google/callback'],

    'allowed_methods' => ['*'],

    'allowed_origins' => ['http://localhost:5173','http://localhost:5174', 'http://your-vue-app-domain.com'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];