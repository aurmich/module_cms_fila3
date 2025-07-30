# Best Practices Configurazione Modulo FormBuilder

## Data: 2025-01-06

## Panoramica

Questo documento definisce le best practices per la configurazione del modulo FormBuilder, seguendo le convenzioni Laraxot e garantendo coerenza con gli altri moduli del sistema.

## File di Configurazione

### 1. module.json

#### Struttura Corretta
```json
{
    "name": "FormBuilder",
    "alias": "formbuilder",
    "description": "Sistema di creazione dinamica e gestione di form personalizzabili",
    "keywords": ["form", "builder", "dynamic", "validation", "template", "submission"],
    "priority": 5,
    "active": 1,
    "order": 5,
    "providers": [
        "Modules\\FormBuilder\\Providers\\FormBuilderServiceProvider",
        "Modules\\FormBuilder\\Providers\\Filament\\AdminPanelProvider"
    ],
    "aliases": {},
    "files": []
}
```

#### Campi Obbligatori
- **name**: Nome ufficiale del modulo (PascalCase)
- **alias**: Identificativo tecnico (lowercase)
- **description**: Descrizione chiara e significativa
- **keywords**: Array di parole chiave rilevanti
- **priority**: Priorità di caricamento (1-10)
- **active**: Stato del modulo (1 = attivo, 0 = inattivo)
- **order**: Ordine di visualizzazione
- **providers**: Array di service providers

#### Best Practices
- ✅ **Sempre** usare descrizione chiara e significativa
- ✅ **Sempre** includere keywords rilevanti per la ricerca
- ✅ **Sempre** impostare priority e order appropriati
- ✅ **Sempre** registrare tutti i provider necessari
- ✅ **Mai** lasciare campi vuoti o non significativi

### 2. composer.json

#### Struttura Corretta
```json
{
    "name": "laraxot/module_formbuilder",
    "description": "FormBuilder Module - Sistema di creazione dinamica e gestione di form personalizzabili",
    "keywords": [
        "laraxot",
        "laravel",
        "filament",
        "module_formbuilder",
        "Laravel",
        "FormBuilder module",
        "Form Builder",
        "Dynamic Forms",
        "Form Templates",
        "Xot"
    ],
    "homepage": "https://github.com/laraxot/module_formbuilder",
    "license": "MIT",
    "authors": [
        {
            "name": "SaluteOra Team",
            "email": "team@saluteora.com"
        }
    ],
    "extra": {
        "laravel": {
            "providers": [
                "Modules\\FormBuilder\\Providers\\FormBuilderServiceProvider",
                "Modules\\FormBuilder\\Providers\\Filament\\AdminPanelProvider"
            ],
            "aliases": {}
        }
    },
    "autoload": {
        "psr-4": {
            "Modules\\FormBuilder\\": "app/",
            "Modules\\FormBuilder\\Database\\Factories\\": "database/factories/",
            "Modules\\FormBuilder\\Database\\Seeders\\": "database/seeders/"
        }
    },
    "autoload-dev": {
        "psr-4": {
            "Modules\\FormBuilder\\Tests\\": "tests/"
        }
    },
    "require": {
        "spatie/laravel-permission": "^6.0",
        "spatie/laravel-data": "^3.0"
    },
    "repositories": [
        {
            "type": "path",
            "url": "../Xot"
        },
        {
            "type": "path",
            "url": "../Tenant"
        },
        {
            "type": "path",
            "url": "../UI"
        }
    ],
    "scripts": {
        "analyse": "vendor/bin/phpstan analyse",
        "test": "./vendor/bin/pest --no-coverage",
        "test-coverage": "vendor/bin/pest --coverage-html coverage",
        "format": "vendor/bin/php-cs-fixer fix --allow-risky=yes"
    },
    "config": {
        "sort-packages": true,
        "allow-plugins": {
            "pestphp/pest-plugin": true,
            "dealerdirect/phpcodesniffer-composer-installer": true,
            "wikimedia/composer-merge-plugin": true
        }
    },
    "minimum-stability": "dev",
    "prefer-stable": true
}
```

#### Campi Obbligatori
- **name**: Nome del package (laraxot/module_*)
- **description**: Descrizione completa del modulo
- **keywords**: Array di parole chiave per la ricerca
- **authors**: Informazioni sugli autori
- **extra.laravel.providers**: Provider Laravel
- **autoload**: Configurazione PSR-4
- **require**: Dipendenze necessarie

#### Best Practices
- ✅ **Sempre** usare nome package laraxot/module_*
- ✅ **Sempre** includere keywords complete
- ✅ **Sempre** registrare provider in extra.laravel.providers
- ✅ **Sempre** configurare autoload PSR-4
- ✅ **Sempre** includere repositories locali
- ✅ **Sempre** aggiungere scripts utili
- ✅ **Mai** duplicare provider tra module.json e composer.json

## Service Providers

### 1. FormBuilderServiceProvider

#### Struttura Corretta
```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class FormBuilderServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'FormBuilder';
    protected string $module_dir = __DIR__;
    protected string $module_ns = __NAMESPACE__;

    public function boot(): void
    {
        parent::boot();
        
        $this->registerConfig();
        $this->registerViews();
        $this->registerTranslations();
        $this->registerRoutes();
    }

    protected function registerConfig(): void
    {
        $this->publishes([
            __DIR__ . '/../config/formbuilder.php' => config_path('formbuilder.php'),
        ], 'formbuilder-config');
    }

    protected function registerViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'formbuilder');
    }

    protected function registerTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'formbuilder');
    }

    protected function registerRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
    }
}
```

#### Best Practices
- ✅ **Sempre** estendere XotBaseServiceProvider
- ✅ **Sempre** definire proprietà name, module_dir, module_ns
- ✅ **Sempre** chiamare parent::boot()
- ✅ **Sempre** registrare config, views, translations, routes
- ✅ **Mai** duplicare logica già presente in XotBaseServiceProvider

### 2. AdminPanelProvider

#### Struttura Corretta
```php
<?php

declare(strict_types=1);

namespace Modules\FormBuilder\Providers\Filament;

use Modules\Xot\Providers\Filament\XotBaseAdminPanelProvider;

class AdminPanelProvider extends XotBaseAdminPanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('formbuilder')
            ->path('formbuilder')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->plugins([
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
```

#### Best Practices
- ✅ **Sempre** estendere XotBaseAdminPanelProvider
- ✅ **Sempre** configurare id e path appropriati
- ✅ **Sempre** includere middleware di sicurezza
- ✅ **Sempre** configurare autenticazione
- ✅ **Mai** duplicare configurazioni già presenti in XotBaseAdminPanelProvider

## Dipendenze

### Dipendenze Richieste
```json
{
    "require": {
        "spatie/laravel-permission": "^6.0",
        "spatie/laravel-data": "^3.0"
    }
}
```

### Dipendenze di Sviluppo
```json
{
    "require-dev": {
        "pestphp/pest": "^2.0",
        "phpstan/phpstan": "^1.0",
        "friendsofphp/php-cs-fixer": "^3.0"
    }
}
```

#### Best Practices
- ✅ **Sempre** includere solo dipendenze effettivamente utilizzate
- ✅ **Sempre** specificare versioni compatibili
- ✅ **Sempre** includere dipendenze di sviluppo per test e analisi
- ✅ **Mai** includere dipendenze non necessarie

## Scripts

### Scripts Utili
```json
{
    "scripts": {
        "analyse": "vendor/bin/phpstan analyse",
        "test": "./vendor/bin/pest --no-coverage",
        "test-coverage": "vendor/bin/pest --coverage-html coverage",
        "format": "vendor/bin/php-cs-fixer fix --allow-risky=yes"
    }
}
```

#### Best Practices
- ✅ **Sempre** includere script per analisi statica
- ✅ **Sempre** includere script per test
- ✅ **Sempre** includere script per formattazione
- ✅ **Sempre** configurare coverage per test
- ✅ **Mai** includere script non utilizzati

## Configurazione

### Configurazione Composer
```json
{
    "config": {
        "sort-packages": true,
        "allow-plugins": {
            "pestphp/pest-plugin": true,
            "dealerdirect/phpcodesniffer-composer-installer": true,
            "wikimedia/composer-merge-plugin": true
        }
    },
    "minimum-stability": "dev",
    "prefer-stable": true
}
```

#### Best Practices
- ✅ **Sempre** abilitare sort-packages
- ✅ **Sempre** configurare allow-plugins appropriati
- ✅ **Sempre** impostare minimum-stability e prefer-stable
- ✅ **Mai** modificare configurazioni senza necessità

## Checklist di Conformità

### module.json
- [ ] Nome e alias coerenti
- [ ] Descrizione chiara e significativa
- [ ] Keywords rilevanti per la ricerca
- [ ] Priorità e ordine appropriati
- [ ] Providers registrati correttamente
- [ ] Struttura JSON valida

### composer.json
- [ ] Nome package laraxot/module_*
- [ ] Descrizione completa
- [ ] Keywords complete
- [ ] Autori configurati
- [ ] Provider in extra.laravel.providers
- [ ] Autoload PSR-4 configurato
- [ ] Dipendenze appropriate
- [ ] Repositories locali
- [ ] Scripts utili
- [ ] Configurazione appropriata

### Service Providers
- [ ] FormBuilderServiceProvider estende XotBaseServiceProvider
- [ ] AdminPanelProvider estende XotBaseAdminPanelProvider
- [ ] Proprietà name, module_dir, module_ns definite
- [ ] Metodi registerConfig, registerViews, registerTranslations, registerRoutes
- [ ] Chiamata parent::boot()

## Collegamenti Correlati

### Documentazione Moduli
- [SaluteOra Configuration](../../SaluteOra/docs/configuration.md) - Configurazione modulo SaluteOra
- [User Configuration](../../User/docs/configuration.md) - Configurazione modulo User
- [Cms Configuration](../../Cms/docs/configuration.md) - Configurazione modulo Cms

### Documentazione Generale
- [Laravel Modules Documentation](https://nwidart.com/laravel-modules/v6/introduction)
- [Composer Best Practices](https://getcomposer.org/doc/articles/scripts.md)
- [PSR-4 Autoloading](https://www.php-fig.org/psr/psr-4/)

---

**Ultimo aggiornamento**: 2025-01-06
**Autore**: Sistema di correzione automatica
**Stato**: ✅ Best Practices Definite