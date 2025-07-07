<?php

return [
    'name' => 'SaluteOra',
    'description' => 'Gestione dei pazienti',
    'models' => [
        'saluteora' => \Modules\SaluteOra\Models\SaluteOra::class,
        'document' => \Modules\SaluteOra\Models\Document::class,
        'anamnesis' => \Modules\SaluteOra\Models\Anamnesis::class,
    ],
    'resources' => [
        'saluteora' => \Modules\SaluteOra\Filament\Resources\SaluteOraResource::class,
        'document' => \Modules\SaluteOra\Filament\Resources\DocumentResource::class,
        'anamnesis' => \Modules\SaluteOra\Filament\Resources\AnamnesisResource::class,
    ],
    'routes' => [
        'web' => [
            'prefix' => 'saluteora',
            'middleware' => ['web', 'auth', 'role:doctor|admin'],
        ],
        'api' => [
            'prefix' => 'api/v1/saluteora',
            'middleware' => ['api', 'auth:sanctum'],
        ],
    ],
    'notifications' => [
        'appointment_reminder' => [
            'enabled' => true,
            'template' => 'saluteora::notifications.appointment_reminder',
        ],
        'document_expiry' => [
            'enabled' => true,
            'template' => 'saluteora::notifications.document_expiry',
        ],
        'isee_update' => [
            'enabled' => true,
            'template' => 'saluteora::notifications.isee_update',
        ],
    ],
    'filesystem' => [
        'disk' => 'public',
        'path' => 'saluteoras',
    ],
];
