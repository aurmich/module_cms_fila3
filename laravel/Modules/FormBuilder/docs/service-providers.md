# Service Providers - Modulo FormBuilder

## Panoramica

Il modulo FormBuilder utilizza tre service provider principali che seguono le convenzioni Laraxot:

1. **FormBuilderServiceProvider** - Provider principale del modulo
2. **EventServiceProvider** - Gestione eventi e listener
3. **RouteServiceProvider** - Registrazione e gestione route

## FormBuilderServiceProvider

### Estensione e Pattern
```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class FormBuilderServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'FormBuilder';
    protected string $moduleName = 'FormBuilder';
    protected string $moduleNameLower = 'formbuilder';

    public function boot(): void
    {
        parent::boot();
    }

    public function register(): void
    {
        parent::register();
    }

    protected function bootObservers(): void
    {
        // Observer per modelli FormBuilder
    }
}
```

### Caratteristiche
- **Estende XotBaseServiceProvider** per ereditare funzionalità standard
- **Pattern semplificato** seguendo SaluteOra
- **Nessun trait non necessario** (rimosso PathNamespace)
- **Metodi essenziali solo** (boot, register, bootObservers)

### Responsabilità
- Registrazione del modulo nel sistema Laraxot
- Caricamento automatico di views, translations, migrations
- Configurazione observer per modelli
- Integrazione con sistema di eventi

## EventServiceProvider

### Configurazione Standard
```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [];
    protected static $shouldDiscoverEvents = false;

    public function boot(): void
    {
        //
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
```

### Caratteristiche
- **shouldDiscoverEvents = false** - Scoperta automatica disabilitata
- **Metodi standard** - boot() e shouldDiscoverEvents()
- **strict_types** - Tipizzazione rigorosa
- **Listeners manuali** - Eventuali listener vanno registrati manualmente

### Eventi Supportati
```php
protected $listen = [
    // FormCreated::class => [
    //     FormCreatedListener::class,
    // ],
    // FormSubmitted::class => [
    //     FormSubmittedListener::class,
    // ],
];
```

## RouteServiceProvider

### Configurazione Semplificata
```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Providers;

use Modules\Xot\Providers\XotBaseRouteServiceProvider;

class RouteServiceProvider extends XotBaseRouteServiceProvider
{
    public string $name = 'FormBuilder';
    protected string $moduleNamespace = 'Modules\FormBuilder\Http\Controllers';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;
}
```

### Caratteristiche
- **Estende XotBaseRouteServiceProvider** per ereditare logica centralizzata
- **Proprietà essenziali solo** - Niente duplicazioni
- **Nessun metodo custom** - Tutto gestito dalla base
- **Namespace corretto** - Controllers nel namespace del modulo

### Route Automatiche
- **Web routes**: `routes/web.php`
- **API routes**: `routes/api.php`
- **Middleware**: Gestiti automaticamente dalla base
- **Namespace**: `Modules\FormBuilder\Http\Controllers`

## Best Practice Applicate

### 1. Estensione Classi Base
- ✅ **SEMPRE** estendere classi XotBase
- ❌ **MAI** estendere direttamente classi Laravel/Filament
- ✅ **SEMPRE** chiamare parent::boot() e parent::register()

### 2. Semplificazione
- ✅ **Rimuovere** trait non necessari
- ✅ **Eliminare** metodi complessi non standard
- ✅ **Seguire** pattern degli altri moduli (es. SaluteOra)

### 3. Tipizzazione
- ✅ **declare(strict_types=1)** in tutti i file
- ✅ **Tipi espliciti** per proprietà e metodi
- ✅ **PHPDoc** completo per documentazione

### 4. Configurazione Eventi
- ✅ **shouldDiscoverEvents = false** per performance
- ✅ **Listener manuali** per controllo completo
- ✅ **Eventi specifici** del modulo solo

## Registrazione nel Sistema

### module.json
```json
{
    "providers": [
        "Modules\\FormBuilder\\Providers\\FormBuilderServiceProvider",
        "Modules\\FormBuilder\\Providers\\Filament\\AdminPanelProvider"
    ]
}
```

### composer.json
```json
{
    "extra": {
        "laravel": {
            "providers": [
                "Livewire\\LivewireServiceProvider",
                "Modules\\FormBuilder\\Providers\\FormBuilderServiceProvider"
            ]
        }
    }
}
```

## Testing e Verifica

### Test Registrazione
```bash
php artisan module:list
# Verificare che FormBuilder sia attivo
```

### Test Route
```bash
php artisan route:list --module=FormBuilder
# Verificare che le route siano registrate
```

### Test Eventi
```bash
php artisan event:list
# Verificare che gli eventi FormBuilder siano registrati
```

## Documentazione Correlata

- [module-configuration.md](module-configuration.md) - Configurazione generale
- [architecture.md](architecture.md) - Architettura modulo
- [filament-integration.md](filament-integration.md) - Integrazione Filament

---

**Ultimo aggiornamento**: 2025-01-06
**Stato**: ✅ Service providers corretti e conformi Laraxot