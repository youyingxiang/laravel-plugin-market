<?php

return [
    'name' => 'PluginMarket',
    'auth' => [
        'guard' => 'market',
        'guards' => [
            'market' => [
                'driver' => 'token',
                'provider' => 'market',
                'hash' => false,
            ],
        ],
        'providers' => [
            'market' => [
                'driver' => 'eloquent',
                'model' => \Yxx\LaravelPluginMarket\Models\MarketUser::class,
            ],
        ]
    ],
    'allow_view_admin' => [
        '1365831278@qq.com'
    ]

];
