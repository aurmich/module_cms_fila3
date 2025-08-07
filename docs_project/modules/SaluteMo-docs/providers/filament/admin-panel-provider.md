# AdminPanelProvider nel Modulo SaluteMo

## Ruolo e Importanza

Il `AdminPanelProvider` è un componente cruciale dell'architettura Filament nel modulo SaluteMo, responsabile della configurazione del pannello amministrativo. Questo provider definisce:

1. Aspetto e comportamento dell'interfaccia amministrativa
2. Autenticazione e autorizzazione
3. Navigazione e menu
4. Localizzazione e internazionalizzazione
5. Risorse e pagine disponibili

## Posizione e Namespace

### Struttura Corretta
```
/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteMo/app/Providers/Filament/AdminPanelProvider.php
```

### Namespace Appropriato
```php
namespace Modules\SaluteMo\Providers\Filament;
```

## Implementazione Conforme

Un `AdminPanelProvider` correttamente implementato nel contesto del modulo SaluteMo deve:

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Modules\SaluteMo\Filament\Pages\Dashboard;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('salutemo')
            ->path('salutemo')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: __DIR__ . '/../../Filament/Resources', for: 'Modules\\SaluteMo\\Filament\\Resources')
            ->discoverPages(in: __DIR__ . '/../../Filament/Pages', for: 'Modules\\SaluteMo\\Filament\\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: __DIR__ . '/../../Filament/Widgets', for: 'Modules\\SaluteMo\\Filament\\Widgets')
            ->widgets([
                // Widgets specifici per SaluteMo
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

## Personalizzazioni per SaluteMo

### Chiave di Identificazione Unica
```php
->id('salutemo')
->path('salutemo')
```

Questo definisce:
- Un identificativo unico per il pannello all'interno del sistema
- Il percorso URL per accedere al pannello (`/salutemo`)

### Integrazione con SaluteOra

Un aspetto fondamentale è la corretta integrazione con il sistema principale SaluteOra:

```php
// Esempio: aggiungere un'icona personalizzata che riflette l'identità di SaluteMo
->brandLogo(fn () => view('salutemo::filament.components.logo'))
->favicon(asset('modules/salutemo/favicon.ico'))

// Esempio: personalizzare i colori per allinearsi con l'identità visiva di SaluteMo
->colors([
    'primary' => Color::hex('#FF9900'),  // Colore specifico per SaluteMo
    'secondary' => Color::hex('#0A56A0'),
])
```

### Configurazione di Navigazione e Risorse
```php
// Esempio di organizzazione delle risorse in gruppi di navigazione
->navigationGroups([
    'App Mobile',
    'Attività Utenti',
    'Configurazione',
])
```

## Registrazione del Provider

Per assicurare che il provider sia correttamente caricato, è necessario registrarlo nel file `module.json`:

```json
{
    "providers": [
        "Modules\\SaluteMo\\Providers\\SaluteMoServiceProvider",
        "Modules\\SaluteMo\\Providers\\Filament\\AdminPanelProvider"
    ]
}
```

Inoltre, verificare che sia registrato anche nel `SaluteMoServiceProvider.php`:

```php
protected array $filamentPanels = [
    \Modules\SaluteMo\Providers\Filament\AdminPanelProvider::class,
];
```

## Considerazioni Architetturali

### Flessibilità e Coerenza
Il provider è progettato per bilanciarsi tra:
- Flessibilità nell'adattarsi alle esigenze specifiche di SaluteMo
- Coerenza con le convenzioni del framework e del progetto SaluteOra

### Estensibilità
Deve supportare l'estensione futura con nuove risorse e funzionalità specifiche per l'app mobile.

### Separazione delle Responsabilità
Il provider si concentra esclusivamente sulla configurazione del pannello, senza includere logica di business, che deve essere gestita nelle rispettive classi di risorse e pagine.

## Errori Comuni da Evitare

1. **Utilizzo di Path Assoluti**
```php
// ❌ ERRATO
->discoverResources(in: '/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteMo/app/Filament/Resources')

// ✅ CORRETTO
->discoverResources(in: __DIR__ . '/../../Filament/Resources', for: 'Modules\\SaluteMo\\Filament\\Resources')
```

2. **Conflitti con Altri Moduli**
```php
// ❌ ERRATO: Utilizza lo stesso ID di altro modulo
->id('admin')

// ✅ CORRETTO: ID univoco
->id('salutemo')
```

3. **Mancata Personalizzazione**
```php
// ❌ ERRATO: Usa configurazione generica
->colors([ 'primary' => Color::Blue ])

// ✅ CORRETTO: Personalizzato per SaluteMo
->colors([ 'primary' => Color::Amber ])
```

## Collegamenti Correlati
- [Dashboard Conventions](../../filament/dashboard-conventions.md)
- [Filament Structure](../../filament/structure.md)
- [Service Provider](../service-provider.md)
