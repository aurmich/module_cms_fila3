# Specifica Tecnica AdminPanelProvider

## Struttura File
Il file deve essere posizionato in:
```
/app/Providers/Filament/AdminPanelProvider.php
```

## Requisiti Tecnici

### Namespace e Import
```php
namespace Modules\SaluteMo\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Modules\Xot\Providers\Filament\XotBaseAdminPanelProvider;
```

### Classe Base
- Deve estendere `XotBaseAdminPanelProvider`
- NON deve estendere direttamente `PanelProvider`
- NON deve usare `BasePanelProvider` come alias

### Configurazione Richiesta

#### Proprietà di Navigazione
```php
protected function panel(Panel $panel): Panel
{
    return $panel
        ->default()
        ->id('salutemo')
        ->path('salutemo')
        ->login()
        ->colors([
            'primary' => Color::Amber,
        ])
        ->discoverResources(in: app_path('Filament/Resources'), for: 'Modules\\SaluteMo\\Filament\\Resources')
        ->discoverPages(in: app_path('Filament/Pages'), for: 'Modules\\SaluteMo\\Filament\\Pages')
        ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'Modules\\SaluteMo\\Filament\\Widgets')
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
```

### Funzionalità da Implementare

#### 1. Autenticazione
- Configurazione login
- Gestione sessioni
- Middleware di autenticazione
- Protezione CSRF

#### 2. Risorse
- Scoperta automatica delle risorse
- Configurazione dei namespace
- Gestione delle autorizzazioni
- Integrazione con il sistema di navigazione

#### 3. Pagine
- Scoperta automatica delle pagine
- Configurazione dei namespace
- Gestione delle autorizzazioni
- Integrazione con il sistema di navigazione

#### 4. Widget
- Scoperta automatica dei widget
- Configurazione dei namespace
- Gestione delle autorizzazioni
- Integrazione con il sistema di navigazione

#### 5. Middleware
- Gestione delle sessioni
- Protezione CSRF
- Autenticazione
- Gestione degli errori

### Best Practices

#### 1. Sicurezza
- Implementare autenticazione robusta
- Gestire correttamente le sessioni
- Proteggere da attacchi CSRF
- Implementare rate limiting

#### 2. Performance
- Ottimizzare il caricamento delle risorse
- Implementare caching appropriato
- Minimizzare le richieste al database
- Gestire correttamente le dipendenze

#### 3. Manutenibilità
- Documentare le configurazioni
- Seguire le convenzioni di naming
- Implementare logging appropriato
- Gestire le dipendenze in modo modulare

#### 4. UX
- Configurare correttamente i colori
- Gestire le traduzioni
- Implementare feedback visivi
- Gestire gli errori in modo user-friendly

### Integrazione

#### 1. Con Altri Moduli
- Gestire correttamente i namespace
- Evitare conflitti di routing
- Gestire le dipendenze
- Mantenere la coerenza

#### 2. Con il Sistema di Navigazione
- Configurare correttamente i gruppi
- Gestire le autorizzazioni
- Implementare la navigazione responsive
- Mantenere la coerenza visiva

#### 3. Con il Sistema di Autorizzazioni
- Implementare i gate necessari
- Gestire i ruoli e i permessi
- Integrare con il sistema di moderazione
- Mantenere la sicurezza

### Note di Implementazione
- Priorità alta
- Fondamentale per l'integrazione con Filament
- Punto di configurazione centrale
- Coerenza con altri moduli 