<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Canali di Notifica
    |--------------------------------------------------------------------------
    |
    | Qui puoi configurare i canali di notifica disponibili e le loro impostazioni.
    | Ogni canale può avere le proprie configurazioni specifiche.
    |
    */
    'channels' => [
        'mail' => [
            'driver' => 'mail',
            'from' => [
                'address' => env('MAIL_FROM_ADDRESS', 'noreply@<nome progetto>.it'),
                'name' => env('MAIL_FROM_NAME', 'il progetto'),
            ],
            'reply_to' => [
                'address' => env('MAIL_REPLY_TO_ADDRESS', 'info@<nome progetto>.it'),
                'name' => env('MAIL_REPLY_TO_NAME', 'il progetto Support'),
            ],
            'tracking' => [
                'opens' => true,
                'clicks' => true,
            ],
        ],

        'sms' => [
            'driver' => env('SMS_DRIVER', 'twilio'),
            'from' => env('SMS_FROM', 'il progetto'),
            'twilio' => [
                'account_sid' => env('TWILIO_ACCOUNT_SID'),
                'auth_token' => env('TWILIO_AUTH_TOKEN'),
                'from' => env('TWILIO_FROM'),
            ],
        ],

        'database' => [
            'driver' => 'database',
            'table' => 'notifications',
            'connection' => null,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Canale di Default
    |--------------------------------------------------------------------------
    |
    | Questo è il canale che verrà utilizzato quando non viene specificato
    | un canale specifico per l'invio di una notifica.
    |
    */
    'default_channel' => env('NOTIFY_DEFAULT_CHANNEL', 'mail'),

    /*
    |--------------------------------------------------------------------------
    | Code
    |--------------------------------------------------------------------------
    |
    | Configurazione per la gestione delle code di notifica.
    | Le notifiche possono essere inviate in modo sincrono o asincrono.
    |
    */
    'queue' => [
        'enabled' => true,
        'connection' => env('QUEUE_CONNECTION', 'database'),
        'queue' => env('NOTIFY_QUEUE', 'notifications'),
        'tries' => 3,
        'retry_after' => 60,
    ],

    /*
    |--------------------------------------------------------------------------
    | Template
    |--------------------------------------------------------------------------
    |
    | Configurazione per i template di notifica predefiniti.
    | Questi template possono essere sovrascritti nel database.
    |
    */
    'templates' => [
        'appointment_reminder' => [
            'subject' => 'Promemoria Appuntamento',
            'body' => 'Gentile {patient_name}, le ricordiamo l\'appuntamento del {appointment_date} presso {dentist_name}.',
        ],
        'document_expiry' => [
            'subject' => 'Scadenza Documento',
            'body' => 'Gentile {patient_name}, il documento {document_name} scadrà il {expiry_date}.',
        ],
        'isee_update' => [
            'subject' => 'Aggiornamento ISEE',
            'body' => 'Gentile {patient_name}, il suo ISEE è stato aggiornato. Nuovo valore: {isee_value}.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    |
    | Configurazione per il rate limiting delle notifiche.
    | Previene l'invio eccessivo di notifiche allo stesso destinatario.
    |
    */
    'rate_limiting' => [
        'enabled' => true,
        'max_attempts' => 5,
        'decay_minutes' => 1,
    ],

    /*
    |--------------------------------------------------------------------------
    | Tracking
    |--------------------------------------------------------------------------
    |
    | Configurazione per il tracking delle notifiche.
    | Permette di tracciare aperture, click e altri eventi.
    |
    */
    'tracking' => [
        'enabled' => true,
        'pixel' => [
            'enabled' => true,
            'route' => 'notify.track.open',
        ],
        'links' => [
            'enabled' => true,
            'route' => 'notify.track.click',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Pulizia Automatica
    |--------------------------------------------------------------------------
    |
    | Configurazione per la pulizia automatica dei log delle notifiche.
    | I log più vecchi verranno eliminati automaticamente.
    |
    */
    'cleanup' => [
        'enabled' => true,
        'older_than_days' => 30,
        'keep_failed' => true,
        'batch_size' => 1000,
    ],

    /*
    |--------------------------------------------------------------------------
    | GrapesJS Editor
    |--------------------------------------------------------------------------
    |
    | Configurazione per l'editor visuale GrapesJS.
    | Permette di creare e modificare i template in modo visuale.
    |
    */
    'grapesjs' => [
        'enabled' => env('NOTIFY_GRAPESJS_ENABLED', true),
        'storage' => [
            'type' => env('NOTIFY_GRAPESJS_STORAGE', 'remote'),
            'endpoint' => env('NOTIFY_GRAPESJS_ENDPOINT', '/api/notify/templates'),
        ],
        'assets' => [
            'css' => [
                'https://unpkg.com/grapesjs/dist/css/grapes.min.css',
            ],
            'js' => [
                'https://unpkg.com/grapesjs',
            ],
        ],
        'plugins' => [
            'gjs-preset-webpage',
            'gjs-blocks-basic',
        ],
        'blocks' => [
            'basic' => true,
            'forms' => true,
            'components' => true,
        ],
    ],
]; 