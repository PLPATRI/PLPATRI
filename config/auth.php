<?php

return [


    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],


    'guards' => [
        'admin' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'vendedor' => [
            'driver' => 'session',
            'provider' => 'vendedores',
        ]
    ],


    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],
        'vendedores' => [
            'driver' => 'eloquent',
            'model' => App\Models\Vendedores::class,
        ],
    ],


    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
        'vendedores' => [
            'provider' => 'vendedores',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,

];
