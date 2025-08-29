---
title: Installazione Automatizzata
description: Installazione Automatizzata
extends: _layouts.documentation
section: content
---

# Installazione

Questa guida descrive il processo di installazione del modulo CMS.

## Requisiti

- PHP 8.2 o superiore
- Laravel 11.x
- Composer 2.x
- Node.js 18.x o superiore
- MySQL 8.0 o PostgreSQL 14.x
- Redis 7.x

## Installazione via Composer

```bash
composer require modules/cms
```

## Pubblicazione delle Risorse

```bash
php artisan vendor:publish --tag=cms-config
php artisan vendor:publish --tag=cms-migrations
php artisan vendor:publish --tag=cms-assets
```

## Configurazione

1. Aggiungere il service provider in `config/app.php`:

```php
'providers' => [
    // ... existing code ...
    Modules\Cms\Providers\CmsServiceProvider::class,
],
```

2. Configurare il file `.env`:

```env
CMS_CACHE_ENABLED=true
CMS_MEDIA_DISK=public
CMS_API_PREFIX=api/cms
```

3. Configurare il file `config/cms.php`:

```php
return [
    'cache' => [
        'enabled' => env('CMS_CACHE_ENABLED', true),
        'ttl' => 3600,
    ],
    'media' => [
        'disk' => env('CMS_MEDIA_DISK', 'public'),
        'allowed_types' => ['jpg', 'jpeg', 'png', 'gif', 'pdf'],
        'max_size' => 10240, // KB
    ],
    'api' => [
        'prefix' => env('CMS_API_PREFIX', 'api/cms'),
        'middleware' => ['api', 'auth:sanctum'],
    ],
];
```

## Migrazione Database

```bash
php artisan migrate
```

## Installazione Assets Frontend

```bash
npm install
npm run build
```

## Verifica Installazione

```bash
php artisan cms:check
```

## Configurazione Opzionale

### Cache

Per ottimizzare le performance:

```bash
php artisan cms:cache:clear
php artisan cms:cache:warm
```

### Queue

Per processare i job in background:

```bash
php artisan queue:table
php artisan migrate
php artisan queue:work
```

### Storage

Per il caricamento file:

```bash
php artisan storage:link
```

## Troubleshooting

### Errori Comuni

1. **Class not found**
   - Eseguire `composer dump-autoload`
   - Verificare il namespace nel composer.json

2. **Migrations non trovate**
   - Verificare la pubblicazione delle migrazioni
   - Controllare i permessi della cartella

3. **Assets non caricati**
   - Eseguire `npm run build`
   - Verificare il mix-manifest.json

### Logs

I log sono disponibili in:
- `storage/logs/cms.log`
- `storage/logs/laravel.log`

## Collegamenti

- [Configurazione](configuration.md)
- [Architettura](architecture.md)
- [Sviluppo](developer/README.md)
- [Utente](user/README.md)

## Collegamenti tra versioni di installation.md
* [installation.md](laravel/Modules/Xot/docs/filament/installation.md)
* [installation.md](laravel/Modules/Xot/docs/installation.md)
* [installation.md](laravel/Modules/Xot/docs/base/installation.md)
* [installation.md](laravel/Modules/User/resources/views/docs/installation.md)
* [installation.md](laravel/Modules/Lang/docs/installation.md)
* [installation.md](laravel/Modules/Cms/docs/installation.md)
* [installation.md](laravel/Themes/One/docs/installation.md)

