# Provider Filament - Configurazione FormBuilder

## Panoramica

Il modulo FormBuilder include un provider Filament dedicato (`AdminPanelProvider`) che gestisce la configurazione del panel amministrativo per la gestione dei form dinamici.

## Struttura Provider

### Posizionamento
```
Modules/FormBuilder/app/Providers/Filament/
└── AdminPanelProvider.php
```

### Implementazione Base

```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Providers\Filament;

use Filament\Panel;
use Modules\Xot\Providers\Filament\XotBasePanelProvider;

/**
 * Admin Panel Provider per il modulo FormBuilder.
 *
 * Gestisce la configurazione del panel Filament per il modulo FormBuilder,
 * estendendo XotBasePanelProvider per garantire coerenza e funzionalità standard.
 */
class AdminPanelProvider extends XotBasePanelProvider
{
    protected string $module = 'FormBuilder';

    /**
     * Configura il panel Filament per il modulo FormBuilder.
     *
     * @param \Filament\Panel $panel
     * @return \Filament\Panel
     */
    public function panel(Panel $panel): Panel
    {
        $panel = parent::panel($panel);

        // Configurazioni specifiche del modulo FormBuilder
        // Qui possono essere aggiunte configurazioni specifiche per form builder
        // come plugin, widget, o altre personalizzazioni

        return $panel;
    }
}
```

## Registrazione Provider

### 1. File module.json

```json
{
    "name": "FormBuilder",
    "alias": "formbuilder",
    "description": "Modulo per la gestione dinamica di form personalizzabili con integrazione Filament",
    "keywords": ["forms", "form-builder", "dynamic-forms", "filament", "validation"],
    "priority": 0,
    "providers": [
        "Modules\\FormBuilder\\Providers\\FormBuilderServiceProvider",
        "Modules\\FormBuilder\\Providers\\Filament\\AdminPanelProvider"
    ],
    "files": []
}
```

### 2. File composer.json

```json
{
    "extra": {
        "laravel": {
            "providers": [
                "Modules\\FormBuilder\\Providers\\FormBuilderServiceProvider",
                "Modules\\FormBuilder\\Providers\\Filament\\AdminPanelProvider"
            ],
            "aliases": {}
        }
    }
}
```

## Configurazioni Avanzate

### 1. Registrazione Widget

```php
public function panel(Panel $panel): Panel
{
    $panel = parent::panel($panel);

    // Registra widget specifici del modulo
    $panel->widgets([
        \Modules\FormBuilder\Filament\Widgets\FormStatsWidget::class,
        \Modules\FormBuilder\Filament\Widgets\RecentFormsWidget::class,
    ]);

    return $panel;
}
```

### 2. Registrazione Plugin

```php
public function panel(Panel $panel): Panel
{
    $panel = parent::panel($panel);

    // Registra plugin specifici per form builder
    $panel->plugin(
        \Modules\FormBuilder\Filament\Plugins\FormBuilderPlugin::make()
            ->config([
                'enable_templates' => true,
                'enable_validation' => true,
                'enable_submissions' => true,
            ])
    );

    return $panel;
}
```

### 3. Configurazione Navigation Groups

```php
public function panel(Panel $panel): Panel
{
    $panel = parent::panel($panel);

    // Configura gruppi di navigazione specifici
    $panel->navigationGroups([
        \Filament\Navigation\NavigationGroup::make('Form Management')
            ->label(__('formbuilder::navigation.groups.form_management'))
            ->icon('heroicon-o-document-text')
            ->collapsible(),
    ]);

    return $panel;
}
```

### 4. Middleware Personalizzato

```php
public function panel(Panel $panel): Panel
{
    $panel = parent::panel($panel);

    // Aggiungi middleware specifici per form builder
    $panel->middleware([
        \Modules\FormBuilder\Http\Middleware\FormBuilderMiddleware::class,
    ]);

    return $panel;
}
```

## Best Practices

### 1. Estensione Classe Base
- **SEMPRE** estendere `XotBasePanelProvider`
- **MAI** estendere direttamente `PanelProvider` di Filament
- **SEMPRE** chiamare `parent::panel($panel)` all'inizio

### 2. Configurazione Modulo
- **SEMPRE** impostare `protected string $module = 'FormBuilder'`
- **SEMPRE** registrare il provider in `module.json` e `composer.json`
- **SEMPRE** seguire le convenzioni di naming Laraxot

### 3. Funzionalità Specifiche
- **SEMPRE** aggiungere configurazioni specifiche del modulo
- **SEMPRE** documentare le personalizzazioni
- **MAI** duplicare funzionalità già presenti nella classe base

### 4. Testing e Validazione
- **SEMPRE** testare la registrazione del provider
- **SEMPRE** verificare che le configurazioni siano applicate
- **SEMPRE** validare con PHPStan livello 9+

## Errori Comuni

### ❌ Non Estendere Classe Base
```php
// ERRORE: Non estendere direttamente PanelProvider
use Filament\PanelProvider;

class AdminPanelProvider extends PanelProvider
{
    // ...
}
```

### ❌ Non Chiamare Parent
```php
// ERRORE: Non chiamare parent::panel()
public function panel(Panel $panel): Panel
{
    // Configurazioni senza chiamare parent
    return $panel;
}
```

### ❌ Registrazione Mancante
```json
// ERRORE: Provider non registrato in module.json
{
    "providers": [
        "Modules\\FormBuilder\\Providers\\FormBuilderServiceProvider"
        // Manca AdminPanelProvider
    ]
}
```

## Testing

### Test di Registrazione Provider

```php
<?php

namespace Modules\FormBuilder\Tests\Unit\Providers;

use Tests\TestCase;
use Modules\FormBuilder\Providers\Filament\AdminPanelProvider;

class AdminPanelProviderTest extends TestCase
{
    /** @test */
    public function it_registers_formbuilder_panel_provider()
    {
        $provider = new AdminPanelProvider($this->app);
        
        $this->assertInstanceOf(AdminPanelProvider::class, $provider);
        $this->assertEquals('FormBuilder', $provider->module);
    }

    /** @test */
    public function it_configures_panel_correctly()
    {
        $provider = new AdminPanelProvider($this->app);
        
        // Test configurazione panel
        $panel = \Filament\Panel::make('admin');
        $configuredPanel = $provider->panel($panel);
        
        $this->assertInstanceOf(\Filament\Panel::class, $configuredPanel);
    }
}
```

## Collegamenti

- [Filament Integration](../filament-integration.md) - Integrazione completa Filament
- [Provider Best Practices](../../Xot/docs/service-provider-best-practices.md) - Best practices provider
- [Module Configuration](../architecture.md) - Configurazione modulo

---

**Ultimo aggiornamento**: 2025-01-06
**Stato**: ✅ Implementato