<?php

return[
    'mysql'=>[
        'driver' => env('DB_DRIVER', 'pdo_mysql'),
        'host' => env('DB_HOST', 'mysql'),
        'dbname' => env('DB_DATABASE', 'tutorial'),
        'user' => env('DB_USERNAME', 'tutorial'),
        'password' => env('DB_PASSWORD', 'secret'),
        'port' => env('DB_PORT', 3306),
    ]
];