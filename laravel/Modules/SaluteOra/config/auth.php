<?php

declare(strict_types=1);

return [
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => \Modules\SaluteOra\Models\User::class,
        ],
    ],
];
