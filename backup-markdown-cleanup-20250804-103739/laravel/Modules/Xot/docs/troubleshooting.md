# Troubleshooting

## Problemi Comuni

### 1. Errori di Installazione

#### Composer
```bash
# Pulire la cache di Composer
composer clear-cache

# Reinstallare le dipendenze
composer install --no-scripts
```

#### NPM
```bash
# Pulire la cache di NPM
npm cache clean --force

# Reinstallare le dipendenze
npm install
```

### 2. Errori di Database

#### Migrazioni
```bash
# Ripristinare le migrazioni
php artisan migrate:fresh

# Eseguire i seed
php artisan db:seed
```

#### Connessione
```bash
# Verificare la connessione
php artisan db:monitor

# Testare la connessione
php artisan db:test
```

### 3. Errori di Cache

#### Pulizia Cache
```bash
# Pulire la cache dell'applicazione
php artisan cache:clear

# Pulire la cache delle viste
php artisan view:clear

# Pulire la cache delle configurazioni
php artisan config:clear

# Pulire la cache delle rotte
php artisan route:clear
```

## Moduli

### 1. Errori di Attivazione
```bash
# Verificare lo stato dei moduli
php artisan module:list

# Attivare un modulo
php artisan module:enable ModuleName

# Disattivare un modulo
php artisan module:disable ModuleName
```

### 2. Errori di Pubblicazione
```bash
# Pubblicare gli assets
php artisan module:publish ModuleName

# Pubblicare le configurazioni
php artisan module:publish-config ModuleName

# Pubblicare le migrazioni
php artisan module:publish-migration ModuleName
```

## Temi

### 1. Errori di Compilazione
```bash
# Compilare gli assets
npm run build

# Compilare gli assets del tema
npm run theme:build
```

### 2. Errori di Visualizzazione
```bash
# Pulire la cache delle viste
php artisan view:clear

# Verificare i permessi
chmod -R 775 storage bootstrap/cache
```

### 3. Errori di copia asset
Se si ottiene un errore **Permission denied** durante la copia degli asset, eseguire:
```bash
mkdir -p public_html/assets/<module>/<path>
chmod -R 755 public_html/assets
```
Assicurarsi che l'utente del web server (es. www-data) abbia i permessi di scrittura su `public_html/assets`.

## Filament

### 1. Errori del Pannello
```bash
# Pubblicare gli assets
php artisan filament:assets

# Pubblicare le configurazioni
php artisan filament:config
```

### 2. Errori dei Widget
```bash
# Pubblicare i widget
php artisan filament:widgets

# Verificare i widget
php artisan filament:check
```

## Volt e Livewire

### 1. Errori dei Componenti

#### Pubblicazione Assets e Configurazioni
```bash
# Pubblicare gli assets
php artisan livewire:publish --assets

# Pubblicare le configurazioni
php artisan livewire:publish --config
```

#### Errore: Multiple Root Elements Detected

Se riscontri questo errore:
```
Livewire\Features\SupportMultipleRootElementDetection\MultipleRootElementsDetectedException
Livewire only supports one HTML element per component. Multiple root elements detected.
```

Soluzione:
1. Ogni componente Volt deve avere un singolo elemento HTML radice
2. Racchiudi tutti gli elementi del componente in un unico `<div>` o altro elemento contenitore

**Esempio corretto:**
```php
@volt('register')
<div>
    <!-- Tutti gli elementi qui -->
    <div class="header">...</div>
    <div class="content">...</div>
</div>
@endvolt
```

**Esempio errato:**
```php
@volt('register')
<!-- Errore: elementi multipli a livello radice -->
<div class="header">...</div>
<div class="content">...</div>
@endvolt
```

Per ulteriori dettagli, consulta la [documentazione sui componenti Volt](../../Themes/One/docs/volt-components.md).

### 2. Errori di Compilazione
```bash
# Compilare gli assets
npm run dev

# Verificare gli errori
npm run build
```

## Log e Debug

### 1. Log dell'Applicazione
```bash
# Visualizzare i log
tail -f storage/logs/laravel.log

# Pulire i log
php artisan log:clear
```

### 2. Debug
```php
// Abilitare il debug
APP_DEBUG=true

// Disabilitare il debug
APP_DEBUG=false
```

## Collegamenti

- [Installazione](installation.md)
- [Configurazione](configuration.md)
- [Regole di Documentazione](documentation-rules.md) 

## Collegamenti tra versioni di troubleshooting.md
* [troubleshooting.md](../../../Xot/docs/troubleshooting.md)
* [troubleshooting.md](../../../Cms/docs/frontoffice/troubleshooting.md)

