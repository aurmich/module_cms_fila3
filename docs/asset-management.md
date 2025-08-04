# Gestione degli Asset nel Progetto

## Struttura degli Asset

### Directory Principali
```
public_html/
├── css/
│   ├── filament/
│   └── dotswan/
├── js/
│   ├── filament/
│   └── dotswan/
└── vendor/
```

## Pubblicazione degli Asset

### Comandi Principali
```bash

# 1. Pulizia Cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# 2. Pubblicazione Asset Filament
php artisan filament:assets

# 3. Ottimizzazione
php artisan optimize
```

### Asset per Modulo
Ogni modulo può avere i propri asset che devono essere pubblicati separatamente:

```php
// ModuleNameServiceProvider.php
public function boot(): void
{
    parent::boot();
    
    $this->publishes([
        __DIR__.'/../resources/dist' => public_path('vendor/module-name'),
    ], 'module-name-assets');
}
```

## Errori Comuni e Soluzioni

### 1. Timeout durante la Pubblicazione
```bash

# Soluzione 1: Aumentare il timeout
php artisan vendor:publish --tag=package-assets --timeout=3600

# Soluzione 2: Pubblicare singolarmente
php artisan filament:assets
php artisan vendor:publish --tag=module-name-assets
```

### 2. Asset non Trovati
```bash

# Verifica dei percorsi
ls -la public_html/vendor
ls -la public_html/css/filament
ls -la public_html/js/filament

# Ripubblicazione mirata
php artisan vendor:publish --tag=filament-assets --force
```

### 3. Permessi Errati
```bash

# Correzione permessi
chmod -R 775 public_html/vendor
chown -R www-data:www-data public_html/vendor
```

## Best Practices

### 1. Gestione delle Dipendenze
```json
// composer.json
{
    "scripts": {
        "post-update-cmd": [
            "@php artisan filament:assets",
            "@php artisan optimize"
        ]
    }
}
```

### 2. Versionamento degli Asset
```php
// config/app.php
'asset_version' => env('ASSET_VERSION', '1.0.0'),

// In blade
<link href="{{ asset('css/app.css') }}?v={{ config('app.asset_version') }}" rel="stylesheet">
```

### 3. Ottimizzazione
```bash

# Compressione degli asset
npm run production

# Cache delle viste
php artisan view:cache

# Cache delle route
php artisan route:cache
```

## Troubleshooting

### Checklist di Verifica
1. Asset pubblicati correttamente?
   ```bash
   ls -la public_html/vendor
   ls -la public_html/css/filament
   ```

2. Permessi corretti?
   ```bash
   stat public_html/vendor
   stat public_html/css/filament
   ```

3. Cache pulita?
   ```bash
   php artisan cache:clear
   php artisan view:clear
   ```

### Risoluzione Problemi
1. Se gli asset non vengono caricati:
   - Verificare il percorso nel browser (F12)
   - Controllare i log di Laravel
   - Verificare i permessi dei file

2. Se la pubblicazione fallisce:
   - Aumentare il timeout
   - Pubblicare un pacchetto alla volta
   - Verificare lo spazio su disco

## Manutenzione

### Aggiornamenti
```bash

# 1. Backup degli asset
cp -r public_html/vendor public_html/vendor_backup

# 2. Aggiornamento dei pacchetti
composer update

# 3. Ripubblicazione degli asset
php artisan filament:assets
```

### Pulizia
```bash

# Rimozione asset non utilizzati
php artisan vendor:cleanup

# Pulizia cache
php artisan cache:clear
php artisan view:clear
```

## Note Importanti
- Mantenere un elenco degli asset necessari per ogni modulo
- Documentare i tag di pubblicazione utilizzati
- Verificare sempre dopo la pubblicazione
- Usare percorsi relativi nei file di configurazione
- Mantenere un backup degli asset prima degli aggiornamenti
