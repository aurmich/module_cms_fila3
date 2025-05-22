# Service Provider: Best Practices in Laraxot

Questo documento definisce le linee guida ufficiali e le best practices per l'implementazione dei Service Provider all'interno del framework Laraxot.

## Regole Fondamentali

### 1. Utilizzo delle Classi Base Corrette

#### ✅ DO - Estendere le classi base di Xot

È **obbligatorio** che tutti i Service Provider estendano le classi base appropriate di Xot:

```php
use Modules\Xot\Providers\XotBaseServiceProvider;

class BrainServiceProvider extends XotBaseServiceProvider
{
    // ...
}
```

```php
use Modules\Xot\Providers\XotBaseRouteServiceProvider;

class RouteServiceProvider extends XotBaseRouteServiceProvider
{
    // ...
}
```

```php
use Modules\Xot\Providers\BaseEventServiceProvider;

class EventServiceProvider extends BaseEventServiceProvider
{
    // ...
}
```

#### ❌ DON'T - Non estendere mai direttamente le classi base di Laravel

```php
// NON FARE MAI QUESTO
use Illuminate\Support\ServiceProvider;

class BrainServiceProvider extends ServiceProvider
{
    // ...
}
```

```php
// NON FARE MAI QUESTO
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    // ...
}
```

```php
// NON FARE MAI QUESTO
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    // ...
}
```

### 2. Chiamata al parent::boot()

#### ✅ DO - Chiamare sempre parent::boot()

È **cruciale** chiamare sempre `parent::boot()` all'inizio del metodo boot():

```php
public function boot(): void
{
    parent::boot(); // Cruciale!
    
    // Il resto del codice...
}
```

#### ❌ DON'T - Non omettere mai la chiamata a parent::boot()

```php
// NON FARE MAI QUESTO
public function boot(): void
{
    // Codice...
}
```

### 3. Proprietà Necessarie nei Provider Principali

#### ✅ DO - Dichiarare sempre le proprietà richieste

```php
protected string $moduleName = 'Brain';
protected string $moduleNameLower = 'brain';
```

#### ❌ DON'T - Non omettere le proprietà richieste

```php
// NON FARE MAI QUESTO - Mancano le proprietà $moduleName e $moduleNameLower
class BrainServiceProvider extends XotBaseServiceProvider
{
    // ...
}
```

### 4. Gestione delle Traduzioni

#### ✅ DO - Usare GetModulePathByGeneratorAction per i path delle traduzioni

Utilizzare sempre l'action `GetModulePathByGeneratorAction` per ottenere il path della cartella `lang` del modulo, con fallback robusto e Assert.

**Esempio corretto:**
```php
try {
    $langPath = app(GetModulePathByGeneratorAction::class)->execute($this->name, 'lang');
    \Webmozart\Assert\Assert::string($langPath, 'Percorso lang non valido');
    $this->loadTranslationsFrom($langPath, $this->nameLower);
} catch (\Throwable $e) {
    $fallbackPath = base_path('Modules/'.$this->name.'/lang');
    $this->loadTranslationsFrom($fallbackPath, $this->nameLower);
}
```

**Esempio sbagliato:**
```php
$langPath = module_path($this->name, 'lang');
$this->loadTranslationsFrom($langPath, $this->nameLower);
```

**Motivazione:**
- Coerenza e robustezza tra i moduli
- Fallback e validazione centralizzata
- Facilità di manutenzione

**Nota:**
Applicare la stessa regola per la registrazione delle traduzioni JSON.

## Implementazione Dettagliata per Tipo di Provider

### 1. Provider Principale del Modulo

```php
<?php

namespace Modules\Brain\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class BrainServiceProvider extends XotBaseServiceProvider
{
    /**
     * Nome del modulo.
     */
    protected string $moduleName = 'Brain';
    
    /**
     * Nome del modulo in lowercase.
     */
    protected string $moduleNameLower = 'brain';
    
    /**
     * Boot del service provider.
     */
    public function boot(): void
    {
        parent::boot();
        
        $this->registerViews();
        $this->registerTranslations();
        $this->registerConfig();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'database/migrations'));
    }
    
    /**
     * Registrazione del service provider.
     */
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
        
        // Registrazione di servizi specifici
        $this->app->singleton('brain.service', function ($app) {
            return new \Modules\Brain\Services\BrainService();
        });
    }
    
    /**
     * Registrazione delle configurazioni.
     */
    protected function registerConfig(): void
    {
        $this->publishes([
            module_path($this->moduleName, 'config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'config/config.php'), $this->moduleNameLower
        );
    }
    
    /**
     * Registrazione delle viste.
     */
    protected function registerViews(): void
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/' . $this->moduleNameLower;
        }, config('view.paths')), [$sourcePath]), $this->moduleNameLower);
    }
    
    /**
     * Registrazione delle traduzioni.
     */
    protected function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'resources/lang'), $this->moduleNameLower);
        }
    }
    
    /**
     * Fornisce i servizi del provider.
     *
     * @return array<int, string>
     */
    public function provides(): array
    {
        return [
            'brain.service',
        ];
    }
}
```

### 2. Route Service Provider

```php
<?php

namespace Modules\Brain\Providers;

use Illuminate\Support\Facades\Route;
use Modules\Xot\Providers\XotBaseRouteServiceProvider;

class RouteServiceProvider extends XotBaseRouteServiceProvider
{
    /**
     * Nome del modulo in lowercase.
     */
    protected string $moduleNameLower = 'brain';
    
    /**
     * Namespace delle routes del controller.
     */
    protected string $namespace = 'Modules\Brain\Http\Controllers';
    
    /**
     * Boot del route service provider.
     */
    public function boot(): void
    {
        parent::boot();
    }
    
    /**
     * Mappa le routes API.
     */
    protected function mapApiRoutes(): void
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(module_path('Brain', '/routes/api.php'));
    }
    
    /**
     * Mappa le routes web.
     */
    protected function mapWebRoutes(): void
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(module_path('Brain', '/routes/web.php'));
    }
    
    /**
     * Mappa le routes admin.
     */
    protected function mapAdminRoutes(): void
    {
        Route::middleware(['web', 'auth', 'admin'])
            ->prefix('admin')
            ->namespace($this->namespace . '\Admin')
            ->group(module_path('Brain', '/routes/admin.php'));
    }
}
```

### 3. Event Service Provider

```php
<?php

namespace Modules\Brain\Providers;

use Modules\Xot\Providers\BaseEventServiceProvider;

class EventServiceProvider extends BaseEventServiceProvider
{
    /**
     * Gli event listeners da registrare.
     *
     * @var array<string, array<int, string>>
     */
    protected $listen = [
        'Modules\Brain\Events\SocioCreated' => [
            'Modules\Brain\Listeners\SendSocioNotification',
        ],
        'Modules\Brain\Events\ConvenzioneUpdated' => [
            'Modules\Brain\Listeners\NotifySocioConvenzione',
            'Modules\Brain\Listeners\UpdateConvenzioneStats',
        ],
    ];
    
    /**
     * Gli subscribers da registrare.
     *
     * @var array<int, string>
     */
    protected $subscribe = [
        'Modules\Brain\Listeners\BrainEventSubscriber',
    ];
    
    /**
     * Boot dell'event service provider.
     */
    public function boot(): void
    {
        parent::boot();
        
        // Eventuali registrazioni aggiuntive...
    }
}
```

## Funzionalità delle Classi Base di Xot

Le classi base di Xot implementano numerose funzionalità cruciali che non sono disponibili nelle classi base di Laravel:

### XotBaseServiceProvider

- Registrazione automatica delle traduzioni con supporto avanzato
- Caricamento intelligente di helper e traits
- Gestione automatica di hook di modulo
- Registrazione automatica dei comandi console
- Supporto per la pubblicazione di assets e configurazioni specifiche per i moduli
- Integrazione di middleware specifici

### XotBaseRouteServiceProvider

- Supporto per diversi gruppi di route (web, api, admin, etc.)
- Gestione avanzata dei middleware per route
- Pattern e prefissi configurabili a livello di modulo
- Integrazione con i sistemi di autorizzazione
- Cache intelligente delle route

### BaseEventServiceProvider

- Gestione avanzata degli eventi e listener
- Supporto per subscriber con funzionalità estese
- Integrazione con i sistemi di logging
- Gestione automatica delle dipendenze

## Vantaggi dell'Approccio Laraxot

L'utilizzo delle classi base di Xot offre numerosi vantaggi:

1. **Coerenza**: Tutti i moduli seguono lo stesso pattern, facilitando la manutenzione
2. **Funzionalità aggiuntive**: Accesso a funzionalità non disponibili nelle classi base di Laravel
3. **Automazione**: Registrazione automatica di molti componenti, riducendo il codice boilerplate
4. **Integrazione**: Perfetta integrazione con il resto dell'ecosistema Laraxot
5. **Performance**: Ottimizzazioni specifiche per l'architettura modulare

## Perché è Cruciale

Non estendere le classi base di Laravel può causare i seguenti problemi:

1. **Mancata inizializzazione**: Funzionalità fondamentali non vengono inizializzate correttamente
2. **Traduzioni non funzionanti**: I meccanismi di traduzione specifici di Laraxot non vengono attivati
3. **Routing errato**: Le route potrebbero non essere registrate correttamente o mancare di funzionalità critiche
4. **Incompatibilità**: Impossibilità di utilizzare caratteristiche specifiche di Laraxot
5. **Errori difficili da diagnosticare**: Problemi che emergono in fase di runtime

## Esempi di Errori Comuni

### Errore: Traduzioni Mancanti

Quando un Service Provider non estende `XotBaseServiceProvider` o non chiama `parent::boot()`:

```php
// Provider errato
class BrainServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Manca parent::boot() o estende la classe sbagliata
        $this->loadTranslationsFrom(...);
    }
}

// Risultato: le traduzioni non funzionano correttamente, mancano molte chiavi
// e l'integrazione con LangServiceProvider è compromessa
```

### Errore: Route Non Registrate

Quando un Route Service Provider non estende `XotBaseRouteServiceProvider`:

```php
// Provider errato
class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Codice personalizzato che non accede alle funzionalità di Xot
    }
}

// Risultato: le route potrebbero non essere caricate correttamente, mancare di 
// middleware essenziali o non essere integrate con il sistema di permessi
```


### Errore: Eventi non ascoltati## Troubleshooting

### Problema: Traduzioni non caricate

**Soluzione:** Verificare che:
1. Il Service Provider estenda `XotBaseServiceProvider`
2. Il metodo `boot()` chiami `parent::boot()`
3. Le proprietà `$moduleName` e `$moduleNameLower` siano definite correttamente

### Problema: Route non funzionanti

**Soluzione:** Verificare che:
1. Il Route Provider estenda `XotBaseRouteServiceProvider`
2. Il metodo `boot()` chiami `parent::boot()`
3. La proprietà `$moduleNameLower` sia definita correttamente
4. I file di route siano nei percorsi corretti (web.php, api.php, admin.php)

### Problema: Eventi non ascoltati
b6f667c (.)
### Errore: Eventi non ascoltati

**Soluzione:** Verificare che:
1. L'Event Provider estenda `BaseEventServiceProvider`
2. Il metodo `boot()` chiami `parent::boot()`
3. Gli eventi e i listener siano definiti correttamente nell'array `$listen`

## Checklist di Implementazione

- [ ] Il Service Provider principale estende `XotBaseServiceProvider`
- [ ] Il Route Provider estende `XotBaseRouteServiceProvider`
- [ ] L'Event Provider estende `BaseEventServiceProvider`
- [ ] Tutti i metodi `boot()` chiamano `parent::boot()` all'inizio
- [ ] Le proprietà `$moduleName` e `$moduleNameLower` sono definite correttamente
- [ ] I metodi di registrazione specifici sono implementati e chiamati in ordine corretto
- [ ] I provider necessari sono registrati nel metodo `register()`
- [ ] Le pubblicazioni sono configurate correttamente

## Riferimenti

- [Documentazione Ufficiale Laravel Service Provider](https://laravel.com/docs/providers)
- [XotBaseServiceProvider](/var/www/html/exa/base_orisbroker_fila3/laravel/Modules/Xot/Providers/XotBaseServiceProvider.php)
- [XotBaseRouteServiceProvider](/var/www/html/exa/base_orisbroker_fila3/laravel/Modules/Xot/Providers/XotBaseRouteServiceProvider.php)
- [BaseEventServiceProvider](/var/www/html/exa/base_orisbroker_fila3/laravel/Modules/Xot/Providers/BaseEventServiceProvider.php)


# Best Practices per ServiceProvider

## Regole Fondamentali

1. **Estendere la Classe Base Corretta**
   - Per moduli: estendere `XotBaseServiceProvider`
   - Per temi: estendere `XotBaseThemeServiceProvider`
   - Per route: estendere `XotBaseRouteServiceProvider`
   - Per eventi: estendere `XotBaseEventServiceProvider`
   - Per applicazione principale: estendere `XotBaseServiceProvider`
   - NON estendere direttamente `Illuminate\Support\ServiceProvider`

2. **Proprietà Obbligatorie**
   ```php
   public string $name = 'NomeModulo';
   public string $nameLower = 'nomemodulo';
   protected string $module_dir = __DIR__;
   protected string $module_ns = __NAMESPACE__;
   ```

3. **Boot Method**
   ```php
   public function boot(): void
   {
       parent::boot(); // SEMPRE chiamare il parent::boot()
       // Aggiungere solo logica specifica del modulo/tema
   }
   ```

4. **Register Method**
   ```php
   public function register(): void
   {
       parent::register(); // SEMPRE chiamare il parent::register()
       // Aggiungere solo binding specifici del modulo/tema
   }
   ```

## Cosa NON Fare

❌ **Non Duplicare Metodi Standard**
```php
// NO: Questi metodi sono già nelle classi base
public function registerTranslations(): void { }
public function registerConfig(): void { }
public function registerViews(): void { }
public function registerBladeComponents(): void { }
```

❌ **Non Registrare Manualmente Componenti**
```php
// NO: La registrazione è automatica
Blade::componentNamespace('Modules\Module\View\Components', 'module');
Blade::component('component-name', ComponentClass::class);
```

## Cosa Fare

✅ **Struttura Base per Moduli**
```php
<?php

declare(strict_types=1);

namespace Modules\MyModule\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class MyModuleServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'MyModule';
    public string $nameLower = 'mymodule';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;

    public function boot(): void
    {
        parent::boot();
        // Logica specifica del modulo
    }
}
```

✅ **Struttura Base per Temi**
```php
<?php

declare(strict_types=1);

namespace Themes\MyTheme\Providers;

use Modules\Xot\Providers\XotBaseThemeServiceProvider;

class ThemeServiceProvider extends XotBaseThemeServiceProvider
{
    public string $name = 'MyTheme';
    public string $nameLower = 'mytheme';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;

    public function boot(): void
    {
        parent::boot();
        // Logica specifica del tema
    }
}
```

✅ **Struttura Base per Applicazione**
```php
<?php

declare(strict_types=1);

namespace App\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class AppServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'App';
    public string $nameLower = 'app';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;

    public function boot(): void
    {
        parent::boot();
        // Logica specifica dell'applicazione
    }
}
```

✅ **Aggiungere Solo Logica Specifica**
```php
protected function registerCustomFeatures(): void
{
    // Registrazione di feature specifiche del modulo/tema
}
```

## Registrazione Componenti Blade

### ❌ Cosa NON Fare
```php
// NO: Non registrare manualmente i componenti
public function boot(): void
{
    Blade::componentNamespace('Modules\Module\View\Components', 'module');
    Blade::component('component-name', ComponentClass::class);
}
```

### ✅ Cosa Fare
1. **Creare il Componente nella Directory Corretta**
```php
<?php

declare(strict_types=1);

namespace Modules\MyModule\View\Components;

use Illuminate\View\Component;

class MyComponent extends Component
{
    public function render()
    {
        return view('my-module::components.my-component');
    }
}
```

2. **Creare il Template nella Directory Corretta**
```blade
{{-- resources/views/components/my-component.blade.php --}}
<div>
    {{ $slot }}
</div>
```

3. **Utilizzare il Componente**
```blade
<x-my-module::my-component>
    Contenuto
</x-my-module::my-component>
```

## Troubleshooting

### Stringhe Non Tradotte
- Verificare che i file di traduzione siano nella directory corretta (`lang/`)
- Verificare che il nome del modulo/tema sia corretto in `$name` e `$nameLower`

### Route Non Funzionanti
- Verificare che `RouteServiceProvider` sia registrato correttamente
- Verificare che le route siano nel file corretto (`routes/web.php` o `routes/api.php`)

### Eventi Non Ascoltati
- Verificare che `EventServiceProvider` sia registrato correttamente
- Verificare che gli eventi e i listener siano mappati correttamente

### Componenti Blade Non Funzionanti
- Verificare che i componenti siano nella directory corretta (`View/Components/`)
- Verificare che i template siano in `resources/views/components/`
- Verificare che i nomi dei componenti seguano le convenzioni

## Link Utili
- [XotBaseServiceProvider](XotBaseServiceProvider.md)
- [XotBaseThemeServiceProvider](XotBaseThemeServiceProvider.md)
- [XotBaseRouteServiceProvider](XotBaseRouteServiceProvider.md)
- [XotBaseEventServiceProvider](XotBaseEventServiceProvider.md)
- [blade-component-registration.md](blade-component-registration.md)
- [filament-best-practices.md](filament-best-practices.md)b6f667c (.)

## Correzione e motivazione (2025-05-13)

- Seguire le regole e i pattern documentati in [XotBaseServiceProvider.md](./XotBaseServiceProvider.md).
- Centralizzare la logica di fallback per path e namespace in metodi protected riutilizzabili.
- Loggare i casi di fallback e le eccezioni non bloccanti.
- Ogni override deve chiamare sempre `parent::method()` e non cambiare la visibilità delle proprietà/metodi ereditati.
- Rafforzare la tipizzazione e la documentazione PHPDoc.
- Usare metodi protected per facilitare il mocking nei test.
- Implementare test di integrazione per la registrazione delle risorse.
- Introdurre versioning e validazione per le icone SVG.

**Esempi di override**

Corretto:
```php
public function boot(): void
{
    parent::boot();
    // Estensioni specifiche...
}
```

Sbagliato:
```php
public function boot(): void
{
    // parent::boot() mancante!
    // ...
}
```

**Collegamento:** Vedi anche [XotBaseServiceProvider.md](./XotBaseServiceProvider.md)
- [filament-best-practices.md](filament-best-practices.md)
