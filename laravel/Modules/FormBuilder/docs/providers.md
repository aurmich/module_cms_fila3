# Providers del Modulo FormBuilder

## Data: 2025-07-29

## Panoramica

Il modulo FormBuilder utilizza diversi service provider per gestire la registrazione dei servizi, la configurazione delle route e l'integrazione con Filament. Tutti i provider seguono le convenzioni Laraxot estendendo le classi base appropriate.

## Service Providers Implementati

### 1. FormBuilderServiceProvider

**Percorso**: `app/Providers/FormBuilderServiceProvider.php`

**Estende**: `Modules\Xot\Providers\XotBaseServiceProvider`

**Responsabilità**:
- Registrazione del modulo nell'applicazione
- Caricamento di configurazioni, traduzioni, viste e migrazioni
- Registrazione di servizi specifici del modulo
- Registrazione del Filament AdminPanelProvider

**Caratteristiche principali**:
```php
class FormBuilderServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'FormBuilder';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;
}
```

**Metodi chiave**:
- `boot()`: Chiama il parent per ereditare comportamenti standard
- `register()`: Registra provider specifici e servizi del modulo

### 2. RouteServiceProvider

**Percorso**: `app/Providers/RouteServiceProvider.php`

**Estende**: `Modules\Xot\Providers\XotBaseRouteServiceProvider`

**Responsabilità**:
- Gestione delle route del modulo (web e API)
- Configurazione di middleware specifici
- Definizione di pattern e model binding per le route

**Caratteristiche principali**:
```php
class RouteServiceProvider extends XotBaseRouteServiceProvider
{
    public string $name = 'FormBuilder';
    protected string $moduleNamespace = 'Modules\\FormBuilder\\Http\\Controllers';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;
}
```

**Metodi chiave**:
- `boot()`: Registra pattern e model binding specifici
- `map()`: Definisce le route dell'applicazione

### 3. EventServiceProvider

**Percorso**: `app/Providers/EventServiceProvider.php`

**Estende**: `Illuminate\Foundation\Support\Providers\EventServiceProvider`

**Responsabilità**:
- Registrazione di eventi e listener del modulo
- Configurazione di observer per i modelli
- Gestione di eventi personalizzati

## Filament Providers

### AdminPanelProvider

**Percorso**: `app/Providers/Filament/AdminPanelProvider.php`

**Estende**: `Modules\Xot\Providers\Filament\XotBasePanelProvider`

**Responsabilità**:
- Configurazione del pannello admin Filament per FormBuilder
- Registrazione di widget specifici del modulo
- Configurazione di plugin Filament
- Personalizzazione dell'interfaccia admin

**Caratteristiche principali**:
```php
class AdminPanelProvider extends XotBasePanelProvider
{
    protected string $module = 'FormBuilder';
    
    public function panel(Panel $panel): Panel
    {
        $panel = parent::panel($panel);
        
        // Personalizzazioni specifiche per FormBuilder
        
        return $panel;
    }
}
```

**Funzionalità configurabili**:
- Widget personalizzati per statistiche form
- Plugin per gestione avanzata dei form
- Gruppi di navigazione specifici
- Middleware personalizzati

## Convenzioni Seguite

### 1. Estensione delle Classi Base

**✅ CORRETTO**:
- `FormBuilderServiceProvider extends XotBaseServiceProvider`
- `RouteServiceProvider extends XotBaseRouteServiceProvider`
- `AdminPanelProvider extends XotBasePanelProvider`

**❌ ERRATO**:
- Estendere direttamente `ServiceProvider` di Laravel
- Estendere `Illuminate\Foundation\Support\Providers\RouteServiceProvider`
- Non utilizzare le classi base Xot

### 2. Proprietà Obbligatorie

Tutti i provider devono definire:
```php
public string $name = 'FormBuilder';           // Nome del modulo
protected string $module_dir = __DIR__;        // Directory del modulo
protected string $module_ns = __NAMESPACE__;   // Namespace del modulo
```

### 3. Documentazione PHPDoc

Tutti i provider devono avere:
- Documentazione completa della classe
- Descrizione delle responsabilità
- Annotazioni dei parametri e tipi di ritorno
- Esempi di utilizzo quando appropriato

### 4. Strict Types

Tutti i file provider devono includere:
```php
<?php

declare(strict_types=1);
```

## Registrazione dei Provider

I provider vengono registrati automaticamente attraverso:

1. **FormBuilderServiceProvider**: Registrato nel `config/app.php` o attraverso auto-discovery
2. **RouteServiceProvider**: Registrato dal FormBuilderServiceProvider principale
3. **EventServiceProvider**: Registrato dal FormBuilderServiceProvider principale
4. **AdminPanelProvider**: Registrato esplicitamente nel FormBuilderServiceProvider

## Personalizzazioni Specifiche

### FormBuilder Service Bindings

Il FormBuilderServiceProvider può registrare servizi specifici:
```php
// Esempio di binding di servizi
$this->app->bind(
    \Modules\FormBuilder\Contracts\FormBuilderServiceInterface::class,
    \Modules\FormBuilder\Services\FormBuilderService::class
);
```

### Route Patterns e Model Binding

Il RouteServiceProvider può definire pattern specifici:
```php
// Esempio di pattern per ID form
Route::pattern('form_id', '[0-9]+');

// Esempio di model binding
Route::model('form', \Modules\FormBuilder\Models\Form::class);
```

### Filament Customizations

L'AdminPanelProvider può configurare:
```php
// Esempio di widget personalizzati
$panel->widgets([
    \Modules\FormBuilder\Filament\Widgets\FormStatsWidget::class,
    \Modules\FormBuilder\Filament\Widgets\RecentFormsWidget::class,
]);

// Esempio di plugin personalizzati
$panel->plugin(
    \Modules\FormBuilder\Filament\Plugins\FormBuilderPlugin::make()
        ->config([
            'enable_templates' => true,
            'enable_validation' => true,
        ])
);
```

## Best Practices

### 1. Chiamare Sempre il Parent

```php
public function boot(): void
{
    parent::boot(); // ✅ Sempre chiamare il parent
    
    // Logica specifica del modulo
}
```

### 2. Evitare Duplicazioni

Non reimplementare funzionalità già presenti nelle classi base:
- Caricamento di viste, traduzioni, migrazioni
- Registrazione di route standard
- Configurazioni base di Filament

### 3. Documentare le Personalizzazioni

Ogni personalizzazione deve essere documentata con:
- Motivazione della personalizzazione
- Esempi di utilizzo
- Impatti su altri moduli

### 4. Testing

I provider devono essere testabili:
```php
public function test_form_builder_service_provider_registers_services(): void
{
    $this->assertTrue($this->app->bound(FormBuilderServiceInterface::class));
}
```

## Troubleshooting

### Problemi Comuni

1. **Provider non registrato**: Verificare che sia incluso nel FormBuilderServiceProvider principale
2. **Route non funzionanti**: Controllare che il RouteServiceProvider estenda XotBaseRouteServiceProvider
3. **Filament non configurato**: Verificare che AdminPanelProvider sia registrato correttamente

### Debug

Per verificare la registrazione dei provider:
```php
// In tinker o in un controller di test
dd(app()->getLoadedProviders());
```

## Collegamenti

- [Architecture Overview](architecture.md) - Panoramica architettura del modulo
- [Service Layer](services/README.md) - Documentazione dei servizi
- [Filament Integration](filament/integration-guide.md) - Guida integrazione Filament

## Aggiornamenti

- **2025-07-29**: Creazione documentazione provider
- **2025-07-29**: Implementazione AdminPanelProvider
- **2025-07-29**: Aggiornamento RouteServiceProvider per estendere XotBaseRouteServiceProvider
- **2025-07-29**: Refactoring FormBuilderServiceProvider per estendere XotBaseServiceProvider
