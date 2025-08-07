# Configurazione Modulo GDPR

## Installazione

### Requisiti
- PHP >= 8.2
- Laravel >= 10.0
- Modulo Xot installato
- Modulo User installato
- Modulo Activity installato

### Comandi di Setup
```bash

# Installazione via composer
composer require modules/gdpr

# Pubblicazione configurazione
php artisan vendor:publish --tag=gdpr-config

# Migrazione database
php artisan module:migrate Gdpr

# Pubblicazione assets
php artisan module:publish Gdpr

# Generazione documentazione
php artisan gdpr:generate-docs
```

## File di Configurazione

### config/gdpr.php
```php
return [
    // Periodo di retention dei dati (in giorni)
    'retention_period' => env('GDPR_RETENTION_PERIOD', 30),

    // Eliminazione automatica dei dati scaduti
    'auto_delete' => env('GDPR_AUTO_DELETE', true),

    // Durata validità consenso (in giorni)
    'consent_lifetime' => env('GDPR_CONSENT_LIFETIME', 365),

    // Abilitazione logging
    'log_enabled' => env('GDPR_LOG_ENABLED', true),

    // Configurazione storage
    'storage' => [
        'disk' => env('GDPR_STORAGE_DISK', 'local'),
        'path' => env('GDPR_STORAGE_PATH', 'gdpr'),
    ],

    // Configurazione email
    'mail' => [
        'from' => [
            'address' => env('GDPR_MAIL_FROM_ADDRESS', 'privacy@example.com'),
            'name' => env('GDPR_MAIL_FROM_NAME', 'Privacy Team'),
        ],
    ],

    // Configurazione notifiche
    'notifications' => [
        'channels' => ['mail', 'database'],
        'expire_days' => 7,
    ],

    // Configurazione export
    'export' => [
        'chunk_size' => 1000,
        'formats' => ['json', 'csv', 'pdf'],
    ],

    // Configurazione cookie
    'cookies' => [
        'lifetime' => 365,
        'secure' => true,
        'same_site' => 'lax',
    ],
];
```

## Integrazione

### Service Provider
```php
use Modules\Gdpr\Providers\GdprServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    protected array $providers = [
        GdprServiceProvider::class,
    ];
}
```

### Middleware
```php
// In app/Http/Kernel.php
protected $routeMiddleware = [
    'gdpr.consent' => \Modules\Gdpr\Http\Middleware\EnsureValidConsent::class,
    'gdpr.cookies' => \Modules\Gdpr\Http\Middleware\RequireCookieConsent::class,
];
```

### Eventi
```php
// In config/events.php
use Modules\Gdpr\Events\ConsentGiven;
use Modules\Gdpr\Events\DataExported;
use Modules\Gdpr\Listeners\LogConsentActivity;
use Modules\Gdpr\Listeners\NotifyDataExport;

return [
    ConsentGiven::class => [
        LogConsentActivity::class,
    ],
    DataExported::class => [
        NotifyDataExport::class,
    ],
];
```

## Personalizzazione

### Views
```bash

# Pubblicazione views
php artisan vendor:publish --tag=gdpr-views

# Struttura
resources/views/vendor/gdpr/
├── consent
│   ├── form.blade.php
│   └── banner.blade.php
├── export
│   └── data.blade.php
└── emails
    ├── consent.blade.php
    └── export.blade.php
```

### Traduzioni
```bash

# Pubblicazione traduzioni
php artisan vendor:publish --tag=gdpr-translations

# Struttura
resources/lang/vendor/gdpr/
├── en
│   └── messages.php
└── it
    └── messages.php
```

### Assets
```bash

# Pubblicazione assets
php artisan vendor:publish --tag=gdpr-assets

# Struttura
public/vendor/gdpr/
├── css
│   └── gdpr.css
└── js
    └── gdpr.js
```

## Sicurezza

### Encryption
```php
// config/gdpr.php
'encryption' => [
    'key' => env('GDPR_ENCRYPTION_KEY'),
    'cipher' => 'AES-256-CBC',
],
```

### Logging
```php
// config/gdpr.php
'logging' => [
    'channel' => env('GDPR_LOG_CHANNEL', 'gdpr'),
    'level' => env('GDPR_LOG_LEVEL', 'info'),
],
```

## Collegamenti Bidirezionali

### Collegamenti ad Altri Moduli
- [Configurazione User](../User/docs/configuration.md)
- [Configurazione Activity](../Activity/docs/configuration.md)
- [Configurazione Xot](../Xot/docs/configuration.md)

### Collegamenti Interni
- [README Principale](./README.md)
- [Roadmap](./roadmap.md)
- [Bottlenecks](./bottlenecks.md)
- [Implementazione](./implementation.md) 

## Collegamenti tra versioni di configuration.md
* [configuration.md](../../../../docs/configuration.md)
* [configuration.md](../../Xot/docs/configuration.md)
* [configuration.md](../../Cms/docs/configuration.md)

