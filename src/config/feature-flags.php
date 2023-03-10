<?php

use Miguel\FeatureFlags\Data\Constants\Driver;

return [

    'default_driver' => env('FEATURE_FLAGS_DRIVER',Driver::GROWTH_BOOK),

    'providers'=>[
        Driver::GROWTH_BOOK=>\Miguel\FeatureFlags\Drivers\GrowthBook\GrowthBookDriver::class,
    ],
    'params'=>[
        Driver::GROWTH_BOOK=>[
            'url'=>env('FEATURE_FLAGS_GROWTH_BOOK_URL'),
        ],
    ]
];