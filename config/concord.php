<?php

return [
    'modules' => [
        Konekt\AppShell\Providers\ModuleServiceProvider::class => [
            'ui' => [
                'name' => 'Vanilo',
                'url' => '/admin/product'
            ]
        ],
        Vanilo\Framework\Providers\ModuleServiceProvider::class => [
            'image' => [
                'variants' => [
                    'thumbnail' => [
                        'width'  => 250,
                        'height' => 188,
                        'fit' => 'fill'
                    ],
                    'medium' => [
                        'width'  => 540,
                        'height' => 406,
                        'fit' => 'fill'
                    ]
                ]
            ],
            'currency'    => [
                'code'   => 'EUR',
                'sign'   => '€',
                // For the format_price() template helper method:
                'format' => '%1$g%2$s' // see sprintf. Amount is the first argument, currency is the second
            ]
        ]
    ]
];
