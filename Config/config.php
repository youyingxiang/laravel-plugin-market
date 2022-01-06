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
                'model' => \Plugins\PluginMarket\Models\MarketUser::class,
            ],
        ]
    ],

];
