# Sistema di Deployment

## Introduzione

Questo documento descrive il processo di deployment del tema "One", inclusi gli ambienti, le configurazioni e le best practices per il rilascio in produzione.

## Ambienti

### Sviluppo (Development)
```bash
# Configurazione
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=theme_one_dev
DB_USERNAME=root
DB_PASSWORD=

# Cache
CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync
```

### Staging
```bash
# Configurazione
APP_ENV=staging
APP_DEBUG=false
APP_URL=https://staging.theme-one.com

# Database
DB_CONNECTION=mysql
DB_HOST=staging-db.theme-one.com
DB_PORT=3306
DB_DATABASE=theme_one_staging
DB_USERNAME=staging_user
DB_PASSWORD=******

# Cache
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_DRIVER=redis
```

### Produzione
```bash
# Configurazione
APP_ENV=production
APP_DEBUG=false
APP_URL=https://theme-one.com

# Database
DB_CONNECTION=mysql
DB_HOST=production-db.theme-one.com
DB_PORT=3306
DB_DATABASE=theme_one_prod
DB_USERNAME=prod_user
DB_PASSWORD=******

# Cache
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_DRIVER=redis
```

## Processo di Deployment

### 1. Preparazione
```bash
# Pull ultime modifiche
git pull origin main

# Installazione dipendenze
composer install --no-dev
npm install --production

# Build assets
npm run prod

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### 2. Database
```bash
# Migrazioni
php artisan migrate --force

# Seeding (se necessario)
php artisan db:seed --force
```

### 3. Ottimizzazione
```bash
# Ottimizzazione configurazione
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Ottimizzazione composer
composer dump-autoload --optimize
```

### 4. Verifica
```bash
# Test
php artisan test

# Health check
php artisan health:check
```

## Script di Deployment

### deploy.sh
```bash
#!/bin/bash

# Configurazione
ENV=$1
VERSION=$(git describe --tags)

# Funzioni
function deploy() {
    echo "Inizio deployment su $ENV..."
    
    # Pull e build
    git pull origin main
    composer install --no-dev
    npm install --production
    npm run prod
    
    # Database
    php artisan migrate --force
    
    # Cache
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    
    # Versionamento
    echo "ASSETS_VERSION=$VERSION" >> .env
    
    echo "Deployment completato!"
}

# Esecuzione
case $ENV in
    "staging")
        deploy
        ;;
    "production")
        read -p "Confermi il deployment in produzione? (y/n) " -n 1 -r
        echo
        if [[ $REPLY =~ ^[Yy]$ ]]
        then
            deploy
        fi
        ;;
    *)
        echo "Ambiente non valido"
        exit 1
        ;;
esac
```

## Monitoraggio

### Health Checks
```php
// routes/web.php
Route::get('health', function () {
    return response()->json([
        'status' => 'ok',
        'version' => config('app.version'),
        'environment' => config('app.env'),
        'database' => DB::connection()->getPdo() ? 'connected' : 'disconnected',
        'cache' => Cache::get('test') ? 'working' : 'not working',
    ]);
});
```

### Logging
```php
// config/logging.php
return [
    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['daily', 'slack'],
        ],
        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
            'days' => 14,
        ],
        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Theme One Bot',
            'emoji' => ':boom:',
            'level' => 'critical',
        ],
    ],
];
```

## Rollback

### Script di Rollback
```bash
#!/bin/bash

# Configurazione
ENV=$1
BACKUP_TAG=$2

# Funzioni
function rollback() {
    echo "Inizio rollback su $ENV alla versione $BACKUP_TAG..."
    
    # Ripristino codice
    git checkout $BACKUP_TAG
    
    # Ripristino database
    php artisan migrate:rollback --step=1
    
    # Clear cache
    php artisan cache:clear
    php artisan config:clear
    php artisan view:clear
    
    echo "Rollback completato!"
}

# Esecuzione
case $ENV in
    "staging")
        rollback
        ;;
    "production")
        read -p "Confermi il rollback in produzione? (y/n) " -n 1 -r
        echo
        if [[ $REPLY =~ ^[Yy]$ ]]
        then
            rollback
        fi
        ;;
    *)
        echo "Ambiente non valido"
        exit 1
        ;;
esac
```

## Best Practices

### Deployment
- Automatizzare processi
- Implementare rollback
- Gestire versioni
- Monitorare errori
- Documentare procedure

### Sicurezza
- Proteggere credenziali
- Utilizzare HTTPS
- Gestire permessi
- Monitorare accessi
- Aggiornare dipendenze

### Performance
- Ottimizzare assets
- Gestire cache
- Monitorare risorse
- Implementare CDN
- Analizzare metriche

## Metriche di Successo

### Deployment
- Tempo di deployment
- Stabilità
- Automazione
- Documentazione
- Monitoraggio

### Performance
- Tempo di risposta
- Utilizzo risorse
- Disponibilità
- Scalabilità
- Manutenibilità

## Collegamenti

- [Sistema di Design](../design_system.md)
- [Componenti](../components.md)
- [Guida allo Stile](../style_guide.md)
- [Best Practices](../best_practices.md) 
