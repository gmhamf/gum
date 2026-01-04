<?php
// config/auth.php

return [
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'gym' => [
            'driver' => 'session',
            'provider' => 'gyms',
        ],

        'trainer' => [
            'driver' => 'session',
            'provider' => 'trainers',
        ],

        'member' => [
            'driver' => 'session',
            'provider' => 'members',
        ],
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        'gyms' => [
            'driver' => 'eloquent',
            'model' => App\Models\Gym::class,
        ],

        'trainers' => [
            'driver' => 'eloquent',
            'model' => App\Models\Trainer::class,
        ],

        'members' => [
            'driver' => 'eloquent',
            'model' => App\Models\Member::class,
        ],
    ],

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],
];
