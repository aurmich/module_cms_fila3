# Modulo User

## Introduzione

Il modulo User gestisce l'autenticazione, l'autorizzazione e la gestione degli utenti nel sistema. Fornisce funzionalità base per la registrazione, il login, la gestione dei ruoli e dei permessi.

## File Chiave
- [BaseUser.php](app/Models/BaseUser.php)
- [User.php](app/Models/User.php)
- [Doctor.php](../Patient/app/Models/Doctor.php)
- [DoctorResource.php](../Patient/app/Filament/Resources/DoctorResource.php)
- [RegisterAction.php](../Patient/app/Actions/RegisterAction.php)
- [RegistrationWidget.php](app/Filament/Widgets/RegistrationWidget.php)

## Funzionalità

### 1. Autenticazione
- Login/Logout
- Registrazione
- Password Reset
- Email Verification

### 2. Autorizzazione
- Ruoli e Permessi
- Policy
- Gates
- Middleware

### 3. Gestione Utenti
- CRUD Utenti
- Profili
- Impostazioni
- Notifiche
- Team Management
- Tenant Management

### 4. Comandi Console
- [AssignModuleCommand](console_commands/assign-module-command.md) - Assegnazione/revoca moduli con multiselect interattivo
- [AssignRoleCommand](console_commands/assign-role-command.md) - Assegnazione ruoli
- [RemoveRoleCommand](console_commands/remove-role-command.md) - Rimozione ruoli
- [SuperAdminCommand](console_commands/super-admin-command.md) - Gestione super admin

## Widget Filament

### Widget di Autenticazione
- [RegisterWidget](filament/widgets/registration-widget.md) - Registrazione utenti
- [ResetPasswordWidget](filament/widgets/reset-password-widget.md) - Reset password
- [LogoutWidget](filament/widgets/logout-widget.md) - Logout utente

### Architettura Widget
- Estendono `XotBaseWidget`
- Namespace: `Modules\User\Filament\Widgets\Auth`
- View path: `user::widgets.auth.*`
- Traduzioni centralizzate

## Modelli e Relazioni

### BaseUser
- Estende `Authenticatable`
- Implementa `UserContract`
- Trait: `HasRoles`, `HasTeams`, `HasTenants`

### Role
- Estende `SpatieRole`
- Pattern ruoli: `{module}::admin`
- Relazioni: `permissions()`, `team()`

### Permission
- Estende `SpatiePermission`
- Gestione permessi granulari

## Traduzioni

### Struttura File
```
lang/
├── it/
│   ├── actions.php
│   ├── fields.php
│   ├── messages.php
│   └── filament/
│       └── resources/
└── en/
    └── ...
```

### Best Practices
- Struttura espansa per campi e azioni
- Nessuna stringa hardcoded
- Traduzioni centralizzate

## Bug Fixes

### ParseError - Metodi Orfani (2025-01-27)
- **Problema**: Metodi rimasti fuori dalla classe durante refactoring
- **Soluzione**: Pulizia cache opcache + verifica sintassi
- **Prevenzione**: Controlli obbligatori post-modifica
- [Dettagli completi](bug-fixes/parse-error-orphan-methods-2025-01-27.md)

## Comandi Console Aggiornati

### AssignModuleCommand - Versione 2025-01-27
**Nuove Funzionalità:**
- ✅ **Multiselect con Pre-checked**: I moduli già assegnati sono pre-checked
- ✅ **Revoca Moduli**: Possibilità di revocare moduli dechecking
- ✅ **Feedback Migliorato**: Messaggi chiari per assegnazioni e revoche
- ✅ **Gestione Errori**: Controlli preventivi per utenti non trovati

**Utilizzo:**
```bash
php artisan user:assign-module
```

**Esempio Output:**
```
email ? admin@example.com
Current modules for admin@example.com: User, Xot, UI

Select modules (checked = assigned, unchecked = will be revoked):
 ◉ User
 ◉ Xot  
 ◉ UI
 ◯ Performance
 ◯ Patient

✓ Assigned module: Performance
✗ Revoked module: UI
Module assignment updated for admin@example.com
```

## Collegamenti
- [Console Commands Philosophy](console_commands_philosophy.md)
- [Bug Fixing Guidelines](../../../docs/bug-fixing-guidelines.md)
- [Filament Best Practices](../../../docs/FILAMENT-BEST-PRACTICES.md)
- [Translation Standards](../../../docs/translation-standards.md)

## Aggiornamenti Recenti

### 2025-01-27
- ✅ **AssignModuleCommand**: Multiselect con pre-checked e revoca moduli
- ✅ **Widget Auth**: Refactoring completo con architettura XotBaseWidget
- ✅ **Bug Fixes**: Risoluzione ParseError metodi orfani
- ✅ **Documentazione**: Aggiornamento completo con esempi pratici

*Ultimo aggiornamento: 2025-01-27*

## Best Practices

### 1. Ereditarietà
- Estendere sempre `BaseUser` per i modelli utente
- Usare il trait `HasParent` per STI
- Non duplicare trait già presenti nelle classi base

### 2. Validation
- Usare le regole di validazione base
- Estendere le regole quando necessario
- Mantenere la validazione consistente

### 3. Error Handling
- Usare le eccezioni custom fornite
- Implementare logging appropriato
- Gestire gli errori in modo consistente

## Struttura
```
User/
├── app/
│   ├── Models/
│   │   ├── User.php
│   │   ├── OauthAccessToken.php
│   │   ├── OauthAuthCode.php
│   │   ├── OauthClient.php
│   │   ├── OauthPersonalAccessClient.php
│   │   └── OauthRefreshToken.php
│   ├── Providers/
│   │   ├── Traits/
│   │   │   ├── HasPassportConfiguration.php
│   │   │   └── HasSocialiteConfiguration.php
│   │   ├── UserServiceProvider.php
│   │   ├── EventServiceProvider.php
│   │   ├── RouteServiceProvider.php
│   │   └── Filament/
│   │       └── AdminPanelProvider.php
│   ├── Filament/
│   │   ├── Resources/
│   │   │   └── UserResource.php
│   │   ├── Widgets/
│   │   │   ├── Auth/
│   │   │   │   ├── LoginWidget.php
│   │   │   │   └── SocialLoginWidget.php
│   │   │   └── User/
│   │   │       ├── UserStatsWidget.php
│   │   │       └── UserActivityWidget.php
│   │   └── Pages/
│   │       └── Auth/
│   │           ├── LoginPage.php
│   │           └── RegisterPage.php
│   └── Http/
│       └── Controllers/
│           └── Auth/
├── config/
│   └── auth.php
├── database/
│   └── migrations/
└── resources/
    └── views/
        └── pages/
            └── auth/
```

## Documentazione Tecnica
- [Architettura](./architecture/README.md)
- [Best Practices](./best-practices/README.md)
- [Error Handling](./error-handling.md)
- [Validation](./validation.md)
- [Linee guida Actions](./actions.mdc)
- [Linee guida Activitylog](./activitylog.mdc)
- [Bug Fixes](./bug-fixes/) - Raccolta bug fixes e soluzioni

## Console Commands Philosophy

Il modulo User definisce lo **standard supremo** per i Console Commands in Laraxot attraverso il capolavoro `ChangeTypeCommand.php`.

### Principi Fondamentali
- **Laravel Prompts Only**: `text()`, `select()`, `confirm()` - mai `ask()` o `choice()`
- **XotData e Contracts**: Accesso ai dati sempre tramite `XotData::make()` e `UserContract`
- **Error Handling Robusto**: Controlli preventivi con `method_exists()`, feedback chiari
- **Enum Handling Moderno**: `tryFrom()`, `getLabel()`, type safety completa
- **Array Helpers Eleganti**: `Arr::mapWithKeys()` per manipolazioni funzionali

### Religione dei Command
- *"Non avrai altro prompting all'infuori di Laravel Prompts"*
- *"Non avrai altro data access all'infuori di XotData e Contracts"*

### Documentazione Completa
- [Console Commands Philosophy](console_commands_philosophy.md) - Standard completo estratto dal capolavoro
- [ChangeTypeCommand.php](../app/Console/Commands/ChangeTypeCommand.php) - Il comando di riferimento supremo

## Collegamenti Bidirezionali
- [Modulo Xot](../Xot/docs/README.md)
- [Modulo Patient](../Patient/docs/README.md)
- [Modulo Dental](../Dental/docs/README.md)
- [Linee guida Actions](./actions.mdc)
- [Linee guida Activitylog](./activitylog.mdc)

## Vedi Anche
- [Documentazione Principale](../../docs/INDEX.md)
- [Architettura Moduli](../../docs/architecture/modules-structure.md)
- [Convenzioni di Nomenclatura](../../docs/standards/file_naming_conventions.md)
- [Struttura del Progetto](../Xot/docs/architecture/struttura-progetto.md)

> **Collegamenti correlati**
> - [README.md documentazione generale](../../../docs/README.md)
> - [README.md toolkit bashscripts](../../../bashscripts/docs/README.md)
> - [README.md modulo GDPR](../Gdpr/docs/README.md)
> - [README.md modulo User](../User/docs/README.md)
> - [README.md modulo Lang](../Lang/docs/README.md)
> - [README.md modulo Activity](../Activity/docs/README.md)
> - [README.md modulo Media](../Media/docs/README.md)
> - [README.md modulo Notify](../Notify/docs/README.md)
> - [README.md modulo Tenant](../Tenant/docs/README.md)
> - [README.md modulo UI](../UI/docs/README.md)
> - [README.md modulo Xot](../Xot/docs/README.md)
> - [Collegamenti documentazione centrale](../../../docs/collegamenti-documentazione.md)

## Indice

### Autenticazione e Autorizzazione
- [Passport Integration](./passport.md) - Integrazione OAuth2
- [Socialite Integration](./socialite.txt) - Login social
- [Two Factor Authentication](./two_factor.txt) - Autenticazione a due fattori
- [Custom Login](./custom_login.md) - Implementazione login personalizzata
- [Volt Folio Logout](./VOLT_FOLIO_LOGOUT.md) - Implementazione logout con Volt e Folio
- [Volt Folio Auth Implementation](./VOLT_FOLIO_AUTH_IMPLEMENTATION.md) - Implementazione completa autenticazione con Volt e Folio
- [Analisi Logout Blade](./LOGOUT_BLADE_ANALYSIS.md) - Analisi e miglioramenti del file logout.blade.php
- [Volt Folio Logout](./VOLT_FOLIO_LOGOUT.md) - Implementazione logout con Volt e Folio
- [Volt Folio Auth Implementation](./VOLT_FOLIO_AUTH_IMPLEMENTATION.md) - Implementazione completa autenticazione con Volt e Folio
- [Analisi Logout Blade](./LOGOUT_BLADE_ANALYSIS.md) - Analisi e miglioramenti del file logout.blade.php

### Modelli e Profili
- [User Profile Models](./user_profile_models.md) - Modelli profilo utente
- [User Roles](./user_roles.md) - Sistema ruoli
- [User Permissions](./user_permissions.md) - Sistema permessi

### Filament e UI
### Versione HEAD

- [Filament Best Practices](FILAMENT_BEST-PRACTICES.md) - Best practices Filament

### Versione Incoming

- [Filament Best Practices](filament-best-practices.md) - Best practices Filament

---

- [Login Widget](login_widget.md) - Widget login personalizzato
- [User Interface](user_interface.md) - Interfaccia utente

### Best Practices e Convenzioni
### Versione HEAD

- [Best Practices](./BEST-PRACTICES.md) - Linee guida generali
- [Convenzioni Path Actions](./ACTIONS_PATH_CONVENTION.md) - Convenzioni per i percorsi delle Actions
- [Convenzioni Path](./PATH_CONVENTIONS.md) - Convenzioni generali per i percorsi nei moduli
- [Checklist Struttura Directory](./DIRECTORY_STRUCTURE_CHECKLIST.md) - Checklist per la struttura delle directory

### Versione Incoming

- [Best Practices](./best-practices.md) - Linee guida generali

---

- [Testing](./testing.md) - Testing e quality assurance
- [Security](./security.md) - Sicurezza e hardening

### Documentazione Tecnica
- [Roadmap](./roadmap.md) - Piano di sviluppo futuro
- [Bottlenecks](./bottlenecks.md) - Analisi performance e ottimizzazioni
- [Architecture](./architecture.md) - Architettura del modulo

### Link Esterni
- [Laravel Authentication](https://laravel.com/docs/12.x/authentication)
- [Laravel Authorization](https://laravel.com/docs/12.x/authorization)
- [Filament Documentation](https://filamentphp.com/docs)

## Note Importanti

### Estensione Classi
- Non estendere mai direttamente le classi di Filament
- Utilizzare sempre le classi base di Xot con prefisso XotBase
- Seguire le convenzioni di naming del modulo

### Trait e Service Provider
- I trait per i provider devono essere in `Providers/Traits/`
- Seguire la struttura esistente per nuovi trait
- Documentare sempre l'uso dei trait

### Traduzioni
- Utilizzare il LangServiceProvider per le traduzioni
- Non usare ->label() direttamente
- Struttura corretta: 'source' => ['label'=>'Sorgente']

## Esempi

### Service Provider
```php
use Xot\XotBaseServiceProvider;

class UserServiceProvider extends XotBaseServiceProvider
{
    // Implementazione
}
```

### Widget Base
```php
use Xot\Filament\Widgets\XotBaseWidget;

class LoginWidget extends XotBaseWidget
{
    // Implementazione
}
```

## Dipendenze
- Laravel Framework
- Filament
- Livewire
- Volt
- Folio

## Utilizzo
Il modulo User fornisce funzionalità di autenticazione e autorizzazione attraverso:
- OAuth2 con Passport
- Social login con Socialite
- Sistema ruoli e permessi
- Profili utente personalizzabili
- Interfaccia Filament

## Panoramica
Il modulo User gestisce l'autenticazione, l'autorizzazione e la gestione degli utenti nell'applicazione. È strettamente integrato con altri moduli come Xot, Lang, e Notify.

### Versione HEAD

## Collegamenti Principali

### Documentazione Core
- [Architettura del Modulo](structure.md)
- [Configurazione Passport](passport.md)
- [Integrazione Socialite](socialite.txt)
- [Gestione Profili](user_profile_models.md)
- [Best Practices Filament](FILAMENT_BEST_PRACTICES.md)
- [Roadmap](roadmap.md)
- [Bottlenecks](bottlenecks.md)

### Integrazioni
- [Integrazione con Xot](../Xot/docs/README.md)
- [Integrazione con Lang](../Lang/docs/README.md)
- [Integrazione con Notify](../Notify/docs/README.md)

### Autenticazione
- [Login Personalizzato](custom_login.md)
- [Autenticazione a Due Fattori](two_factor.txt)
- [Single Sign-On](sso.txt)
- [Gestione Password](password.md)

### Autorizzazione
- [Permessi Spatie](spatie_permissions.txt)
- [Gestione Ruoli](repositories.md)
- [Team e Collaborazioni](teams.md)


### Versione Incoming

## Collegamenti Bidirezionali

- [Architettura del Modulo](structure.md) - Struttura e organizzazione del modulo
- [Configurazione Passport](passport.md) - Integrazione con OAuth2
- [Gestione Profili](user_profile_models.md) - Modelli per i profili utente
- [Best Practices Filament](filament-best-practices.md) - Linee guida per Filament
- [Roadmap](roadmap.md) - Piano di sviluppo futuro
- [Bottlenecks](bottlenecks.md) - Analisi performance e ottimizzazioni
- [Login Personalizzato](custom_login.md) - Implementazione login personalizzata
- [Ruoli Utente](user_roles.md) - Sistema di ruoli
- [Permessi Utente](user_permissions.md) - Sistema di permessi

## Vedi Anche

- [Modulo Xot](../Xot/docs/README.md) - Modulo base e linee guida generali
- [Modulo Lang](../Lang/docs/README.md) - Gestione traduzioni
- [Modulo Notify](../Notify/docs/README.md) - Sistema di notifiche
- [Modulo Activity](../Activity/docs/README.md) - Logging e audit trail
- [Convenzioni di Naming](../../../docs/standards/file_naming_conventions.md) - Standard per la nomenclatura dei file


---

### Profili e GDPR
- [Modelli Profilo](./user_profile_models.md)
- [Separazione Profili](./user_profile_separation.md)
- [Conformità GDPR](./gdpr.txt)

### UI/UX
- [Metriche Dashboard](./metrics-dashboard.md)
- [Conflitti JS](./js_conflicts.md)
- [Best Practices Tailwind](./tailwind.txt)

### Sviluppo
- [Convenzioni Namespace](./namespace-conventions.md)
- [Struttura Repository](./repos.txt)
- [Analisi Performance](./BOTTLENECKS.md)

### Testing e Qualità
- [PHPStan Fixes](./phpstan_fixes.md)
- [PHPStan Level 9](./PHPSTAN_LEVEL9_FIXES.md)
- [PHPStan Level 10](./PHPSTAN_LEVEL10_FIXES.md)

## Struttura del Modulo

## Regola fondamentale sulle migration

> **Tutte le migration che riguardano tabelle, colonne o relazioni di un modulo devono essere SEMPRE nella cartella `database/migrations` del modulo stesso (es: `Modules/User/database/migrations/`).**
> Mettere migration in `laravel/database/migrations` è un errore grave che rompe la modularità, il rollback e la chiarezza del progetto.
> Vedi dettagli e motivazione in [PATH_CONVENTIONS.md](./PATH_CONVENTIONS.md).

```
Modules/User/
├── app/
│   ├── Models/
│   │   ├── User.php
│   │   ├── OauthAccessToken.php
│   │   ├── OauthAuthCode.php
│   │   ├── OauthClient.php
│   │   ├── OauthPersonalAccessClient.php
│   │   └── OauthRefreshToken.php
│   ├── Providers/
│   │   ├── Traits/
│   │   │   ├── HasPassportConfiguration.php
│   │   │   └── HasSocialiteConfiguration.php
│   │   ├── UserServiceProvider.php
│   │   ├── EventServiceProvider.php
│   │   ├── RouteServiceProvider.php
│   │   └── Filament/
│   │       └── AdminPanelProvider.php
│   ├── Filament/
│   │   ├── Resources/
│   │   │   └── UserResource.php
│   │   ├── Widgets/
│   │   │   ├── Auth/
│   │   │   │   ├── LoginWidget.php

│   │   │   │   └── SocialLoginWidget.php
│   │   │   └── User/
│   │   │       ├── UserStatsWidget.php
│   │   │       └── UserActivityWidget.php
│   │   └── Pages/
│   │       └── Auth/
│   │           ├── LoginPage.php
│   │           └── RegisterPage.php
│   └── Http/
│       └── Controllers/
│           └── Auth/
├── config/
│   └── auth.php
├── database/
│   └── migrations/
└── resources/
    └── views/
        └── pages/
            └── auth/
```

## Dipendenze Principali

### Moduli
- **Xot**: Fornisce le classi base e l'infrastruttura core
- **Lang**: Gestione delle traduzioni
- **Notify**: Sistema di notifiche
- **UI**: Componenti di interfaccia utente

### Pacchetti
- Laravel Passport
- Laravel Socialite
- Spatie Permission
- Filament

## Best Practices

### 1. Estensione delle Classi
```php
// ❌ NON FARE QUESTO
use Filament\Widgets\Widget;
class LoginForm extends Widget { ... }

// ✅ FARE QUESTO
use Modules\Xot\Filament\Widgets\XotBaseWidget;
class LoginWidget extends XotBaseWidget { ... }
```

### 2. Gestione delle Traduzioni
```php
// ❌ NON FARE QUESTO
->label('Sorgente')

// ✅ FARE QUESTO
->label(['label' => 'Sorgente'])
```

### 3. Configurazione dei Provider
```php
// In Modules/User/app/Providers/UserServiceProvider.php
use Modules\User\Providers\Traits\HasPassportConfiguration;

class UserServiceProvider extends XotBaseServiceProvider
{
    use HasPassportConfiguration;

    public function boot(): void
    {
        $this->configurePassport();
    }
}
```

## Roadmap

### Prossime Feature
1. Miglioramento della gestione dei token OAuth
2. Integrazione con nuovi provider social
3. Ottimizzazione delle performance

### Miglioramenti Pianificati
1. Refactoring del sistema di autenticazione
2. Miglioramento della gestione dei profili
3. Ottimizzazione delle query

## Contribuire

### Setup Sviluppo
1. Clona il repository
2. Installa le dipendenze
3. Configura l'ambiente
4. Esegui i test

### Convenzioni di Codice
- Seguire PSR-12
- Utilizzare type hints
- Documentare il codice
- Scrivere test unitari

### Processo di Pull Request
1. Crea un branch feature
2. Implementa le modifiche
3. Aggiungi i test
4. Aggiorna la documentazione
5. Crea la PR

## Troubleshooting

### Problemi Comuni
1. Conflitti di autenticazione
2. Problemi di performance
3. Errori di configurazione

### Soluzioni
1. Verifica la configurazione
2. Controlla i log
3. Consulta la documentazione

## Widget Filament

### Widget Disponibili
- [RegistrationWidget](./filament/widgets/registration-widget.md) - Widget generico per registrazione utente
- [EditUserWidget](./filament/widgets/edit-user-widget.md) - Widget generico per modifica dati utente
- [Widget Responsive Layout](./filament/widgets-responsive-layout.md) - Layout responsive per widget

## Riferimenti

### Documentazione
- [Laravel Passport](https://laravel.com/docs/12.x/passport)
- [Laravel Socialite](https://laravel.com/docs/12.x/socialite)
- [Spatie Permission](https://spatie.be/docs/laravel-permission/v6/installation-laravel)
- [Filament](https://filamentphp.com/docs)

### Collegamenti Interni
- [Xot Base Classes](../Xot/docs/base-classes.md)
- [Lang Integration](../Lang/docs/lang-link.md)
- [Notify Setup](../Notify/docs/README.md)

## Changelog

### [1.0.0] - 2024-03-20
#### Added
- Implementazione iniziale
- Supporto OAuth2
- Integrazione Socialite
- Sistema di autorizzazione

#### Changed
- Miglioramento performance
- Ottimizzazione query
- Refactoring codice

#### Fixed
- Bug autenticazione
- Problemi di configurazione
### Versione HEAD

- Errori di traduzione 

### Versione Incoming

- Errori di traduzione 
## Collegamenti
- [Indice Documentazione](../../../docs/INDEX.md)
- [README Principale](../../../README.md)
- [API Reference](../docs/api.md)
- [Changelog](../docs/CHANGELOG.md) 
## Collegamenti tra versioni di README.md
* [README.md](bashscripts/docs/README.md)
* [README.md](bashscripts/docs/it/README.md)
* [README.md](docs/laravel-app/phpstan/README.md)
* [README.md](docs/laravel-app/README.md)
* [README.md](docs/moduli/struttura/README.md)
* [README.md](docs/moduli/README.md)
* [README.md](docs/moduli/manutenzione/README.md)
* [README.md](docs/moduli/core/README.md)
* [README.md](docs/moduli/installati/README.md)
* [README.md](docs/moduli/comandi/README.md)
* [README.md](docs/phpstan/README.md)
* [README.md](docs/README.md)
* [README.md](docs/module-links/README.md)
* [README.md](docs/troubleshooting/git-conflicts/README.md)
* [README.md](docs/tecnico/laraxot/README.md)
* [README.md](docs/modules/README.md)
* [README.md](docs/conventions/README.md)
* [README.md](docs/amministrazione/backup/README.md)
* [README.md](docs/amministrazione/monitoraggio/README.md)
* [README.md](docs/amministrazione/deployment/README.md)
* [README.md](docs/translations/README.md)
* [README.md](docs/roadmap/README.md)
* [README.md](docs/ide/cursor/README.md)
* [README.md](docs/implementazione/api/README.md)
* [README.md](docs/implementazione/testing/README.md)
* [README.md](docs/implementazione/pazienti/README.md)
* [README.md](docs/implementazione/ui/README.md)
* [README.md](docs/implementazione/dental/README.md)
* [README.md](docs/implementazione/core/README.md)
* [README.md](docs/implementazione/reporting/README.md)
* [README.md](docs/implementazione/isee/README.md)
* [README.md](docs/it/README.md)
* [README.md](laravel/vendor/mockery/mockery/docs/README.md)
* [README.md](../../../Chart/docs/README.md)
* [README.md](../../../Reporting/docs/README.md)
* [README.md](../../../Gdpr/docs/phpstan/README.md)
* [README.md](../../../Gdpr/docs/README.md)
* [README.md](../../../Notify/docs/phpstan/README.md)
* [README.md](../../../Notify/docs/README.md)
* [README.md](../../../Xot/docs/filament/README.md)
* [README.md](../../../Xot/docs/phpstan/README.md)
* [README.md](../../../Xot/docs/exceptions/README.md)
* [README.md](../../../Xot/docs/README.md)
* [README.md](../../../Xot/docs/standards/README.md)
* [README.md](../../../Xot/docs/conventions/README.md)
* [README.md](../../../Xot/docs/development/README.md)
* [README.md](../../../Dental/docs/README.md)
* [README.md](../../../User/docs/phpstan/README.md)
* [README.md](../../../User/docs/README.md)
* [README.md](../../../User/docs/README.md)
* [README.md](../../../UI/docs/phpstan/README.md)
* [README.md](../../../UI/docs/README.md)
* [README.md](../../../UI/docs/standards/README.md)
* [README.md](../../../UI/docs/themes/README.md)
* [README.md](../../../UI/docs/components/README.md)
* [README.md](../../../Lang/docs/phpstan/README.md)
* [README.md](../../../Lang/docs/README.md)
* [README.md](../../../Job/docs/phpstan/README.md)
* [README.md](../../../Job/docs/README.md)
* [README.md](../../../Media/docs/phpstan/README.md)
* [README.md](../../../Media/docs/README.md)
* [README.md](../../../Tenant/docs/phpstan/README.md)
* [README.md](../../../Tenant/docs/README.md)
* [README.md](../../../Activity/docs/phpstan/README.md)
* [README.md](../../../Activity/docs/README.md)
* [README.md](../../../Patient/docs/README.md)
* [README.md](../../../Patient/docs/standards/README.md)
* [README.md](../../../Patient/docs/value-objects/README.md)
* [README.md](../../../Cms/docs/blocks/README.md)
* [README.md](../../../Cms/docs/README.md)
* [README.md](../../../Cms/docs/standards/README.md)
* [README.md](../../../Cms/docs/content/README.md)
* [README.md](../../../Cms/docs/frontoffice/README.md)
* [README.md](../../../Cms/docs/components/README.md)
* [README.md](../../../../Themes/Two/docs/README.md)
* [README.md](../../../../Themes/One/docs/README.md)


---

## Moderazione Utente Generica dal Modulo User

### Premessa e Neutralità
In questo modulo, la gestione della moderazione non deve mai fare riferimento a ruoli o tipi specifici (es. "dentista", "paziente"). Tutti i tipi di utente sono rappresentati come varianti (type/parental) del modello User, secondo il pattern Single Table Inheritance (STI) o Parental, utilizzando SEMPRE la colonna `type` (vedi [tighten/parental](https://github.com/tighten/parental)). Questo garantisce la massima riusabilità del modulo User in qualsiasi progetto.

### Architettura proposta
- **Model**: User è la base, ogni tipo di utente (es. admin, operator, specialist, ...), è un parental/type di User. La colonna di discriminazione è SEMPRE `type`.
- **Enum/ModelStates**: Lo stato di moderazione è gestito tramite enum o Spatie Model States, utilizzando SEMPRE la colonna `state` (vedi [spatie/laravel-model-states](https://spatie.be/docs/laravel-model-states/v2/working-with-states)), con valori come `pending`, `approved`, `rejected`, applicabile a qualunque tipo di utente.
- **Action**: Azioni queueable (spatie/laravel-queueable-action) per approve/reject, generiche e parametrizzate sul tipo di utente.
- **Notifiche**: Notifiche di stato centralizzate, con template e destinatari dinamici in base al type.
- **UI**: Pannello Filament unico per la moderazione, con filtri per type e stato.
- **Policy**: Policy centralizzate per la moderazione, con possibilità di override per type specifici.
- **Eventi/Listener**: Eventi per transizioni di stato, listener per notifiche e logging, generici e riutilizzabili.

### Flusso Moderazione Utente (Generico)
1. **Registrazione**: L'utente si registra tramite wizard unico, che raccoglie i dati base e quelli specifici del type. Il campo `type` viene valorizzato secondo la variante.
2. **Stato iniziale**: L'utente viene creato in stato `pending` (moderazione richiesta), valorizzando la colonna `state`.
3. **Moderazione**: Un moderatore visualizza la richiesta, può approvare o rifiutare (UI e azioni generiche).
4. **Transizione di stato**: Azione queueable aggiorna la colonna `state`, invia notifica, logga l'evento (tutto generico).
5. **Notifica**: L'utente riceve email con esito e, se approvato, link per completare la registrazione (template dinamico).
6. **Completamento**: L'utente può accedere e completare i dati solo se approvato.

### Percentuali di riuso logica
- Azioni di moderazione: **90%**
- Gestione stati: **100%**
- Notifiche: **80%**
- UI Filament: **80%**
- Eventi/listener: **90%**
- Policy: **80%**

### Dettagli implementativi
- **Wizard di registrazione**: Unico, con step dinamici in base al type (pattern strategy/factory per step specifici). Il campo `type` è centrale.
- **ModerationAction**: Un'unica action queueable, che riceve l'istanza User e il type, e applica la logica di moderazione aggiornando la colonna `state`.
- **Enum/ModelStates**: Enum generico (UserState) con metodi helper per label, colore, icona, ecc., sempre mappato su `state`.
- **Notifiche**: Classe base Notification, con metodi overridabili per type specifici.
- **UI Filament**: Resource/Panel unico, con filtri per type e stato, e policy generiche.
- **Policy**: Policy generica UserModerationPolicy, con possibilità di override tramite strategy pattern.
- **Eventi/Listener**: Eventi generici (UserApproved, UserRejected, ecc.), listener che gestiscono notifiche e side-effect.
- **Documentazione**: Tutte le transizioni di stato, policy e override vanno documentate in modo neutro e generico.
- **Test**: Test end-to-end che coprano il flusso per tutti i type, senza riferimenti a ruoli specifici.

### Esempio di struttura
- `User.php` (modello base, con type/parental e state)
- `UserState.php` (enum generico, mappato su `state`)
- `ModerationAction.php` (action queueable generica)
- `UserModerationNotification.php` (notifica base)
- `UserModerationPolicy.php` (policy generica)
- `UserModerationResource.php` (Filament resource/panel generico)
- `UserApproved.php`, `UserRejected.php` (eventi generici)

### Vantaggi
- Massima riusabilità del modulo User in qualsiasi progetto
- Facilità di estensione per nuovi type/ruoli
- Manutenzione centralizzata
- Coerenza di UX e policy

### TODO
- Prototipo di Model/Action/Resource per la moderazione generica (usando SEMPRE `type` e `state`)
- Refactoring delle azioni e delle policy per eliminare riferimenti a type specifici
- UI Filament unica per la moderazione
- Test end-to-end generici
- Documentazione neutra e riutilizzabile

---

## Convenzioni fondamentali per STI/Parental e Model States

### 1. Single Table Inheritance (STI) / Parental
- **Colonna obbligatoria:** `type` (e NON `user_type`)
- **Motivazione:** Segue la convenzione tighten/parental ([vedi doc](https://github.com/tighten/parental))
- **Esempio migrazione:**
```php
Schema::table('users', function ($table) {
    $table->string('type')->nullable();
});
```
- **Nota:** La colonna `type` deve essere nullable per permettere la compatibilità con modelli base e specializzati.

### 2. Model States (spatie/laravel-model-states)
- **Colonna obbligatoria:** `state` (e NON `moderation_status` o simili)
- **Motivazione:** Segue la convenzione spatie/laravel-model-states ([vedi doc](https://spatie.be/docs/laravel-model-states/v2/working-with-states/01-configuring-states))
- **Motivazione:** Segue la convenzione spatie/laravel-model-states ([vedi doc](https://spatie.be/docs/laravel-model-states/v2/working-with-states))
- **Esempio migrazione:**
```php
Schema::table('users', function ($table) {
    $table->string('state')->nullable();
});
```
- **Nota:** La colonna `state` rappresenta lo stato generico del modello (pending, approved, rejected, ecc.)

### 3. Esempio di implementazione
```php
// Model User.php
use Parental	raits\nuse Spatie\ModelStates\HasStates;

class User extends Model {
    use HasStates;
    // ...
    protected $casts = [
        'state' => UserState::class,
    ];
}

// Enum State
abstract class UserState extends State {
    // ...
}
```

### 4. Motivazione e fonti
- Queste convenzioni garantiscono compatibilità, manutenibilità e aderenza agli standard delle librerie usate.
- Riferimenti:
  - [tighten/parental - Accessing Child Models from Parents](https://github.com/tighten/parental)
  - [spatie/laravel-model-states - Configuring States](https://spatie.be/docs/laravel-model-states/v2/working-with-states/01-configuring-states)
  - [spatie/laravel-model-states - Configuring States](https://spatie.be/docs/laravel-model-states/v2/working-with-states)

---

## Business Logic: Solo Actions, mai Service

### Convenzione di progetto
- **Non utilizzare mai Service** per la business logic.
- Utilizzare SEMPRE le Actions queueable di [spatie/laravel-queueable-action](https://github.com/spatie/laravel-queueable-action).
- Le Actions sono classi dedicate che incapsulano la logica di dominio e possono essere eseguite sia in modo sincrono che asincrono (in coda).

### Motivazione
- Maggiore testabilità e riusabilità
- Supporto nativo a queue, chaining, tagging, middleware, backoff, ecc.
- Costruttore con dependency injection (più flessibile dei Job standard)
- Uniformità e chiarezza architetturale

### Esempio di Action
```php
use Spatie\QueueableAction\QueueableAction;

class ApproveUserAction
{
    use QueueableAction;

    public function execute(User $user): void
    {
        // Logica di approvazione
        $user->state = 'approved';
        $user->save();
    }
}
```

### Esecuzione
```php
// Sincrona
app(ApproveUserAction::class)->execute($user);

// In coda (queue)
app(ApproveUserAction::class)->onQueue()->execute($user);
```

### Testing
```php
use Spatie\QueueableAction\Testing\QueueableActionFake;

Queue::fake();
app(ApproveUserAction::class)->onQueue()->execute($user);
QueueableActionFake::assertPushed(ApproveUserAction::class);
```

### Link utili
- [spatie/laravel-queueable-action - GitHub](https://github.com/spatie/laravel-queueable-action)
- [Blog: Perché usare le Actions](https://stitcher.io/blog/laravel-queueable-actions)

### Note
- Le Actions possono essere concatenate (chaining), taggate (per Horizon), dotate di middleware e backoff personalizzato.
- Per la business logic, **NON** usare Service, ma solo Actions secondo questa convenzione.

## Audit e Logging: Solo Spatie Activitylog, mai ModerationLog custom

### Convenzione di progetto
- **Non utilizzare mai tabelle custom come ModerationLog** per tracciare le azioni di moderazione o audit.
- Utilizzare SEMPRE [spatie/laravel-activitylog](https://spatie.be/docs/laravel-activitylog/v4/introduction) per il logging di tutte le attività rilevanti (moderazione, cambi di stato, ecc.).

### Motivazione
- Activitylog è uno standard de facto, maturo e ampiamente supportato
- Permette di tracciare qualsiasi evento su qualsiasi modello, con metadati, causer, soggetto, ecc.
- Supporta query avanzate, filtraggio, esportazione, notifiche
- Riduce la duplicazione di codice e la complessità
- Facilita l'integrazione con dashboard, notifiche, audit trail

### Esempio di utilizzo
```php
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Model
{
    use LogsActivity;

    protected static $logAttributes = ['state', 'type'];
    protected static $logName = 'user_moderation';
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;
}

// Log manuale di un evento custom
activity()
    ->performedOn($user)
    ->causedBy(auth()->user())
    ->withProperties(['reason' => 'approved by admin'])
    ->log('User approved');
```

### Query e visualizzazione
```php
// Recupera tutte le attività di moderazione di un utente
$logs = $user->activities()->where('log_name', 'user_moderation')->get();
```

### Link utili
- [spatie/laravel-activitylog - Docs](https://spatie.be/docs/laravel-activitylog/v4/introduction)
- [Esempi avanzati](https://spatie.be/docs/laravel-activitylog/v4/advanced-usage)

### Note
- Activitylog può essere integrato facilmente con Filament, dashboard custom, notifiche, ecc.
- Per ogni evento rilevante (moderazione, cambio stato, ecc.) loggare SEMPRE tramite activitylog.
- Non creare mai tabelle custom come ModerationLog: tutta l'audit trail deve essere centralizzata e standardizzata.

## Migrazioni: uso corretto di hasColumn con XotBaseMigration

### Regola fondamentale
- **NON usare mai** `Schema::hasColumn('users', 'state')` nelle migrazioni che estendono XotBaseMigration.
- **Usare SEMPRE** `$this->hasColumn('state')` (o altro nome colonna) come da convenzione XotBaseMigration.

### Esempio corretto
```php
if (! $this->hasColumn('state')) {
    $this->tableUpdate(function (Blueprint $table) {
        $table->string('state')->nullable();
    });
}
```

### Motivazione
- XotBaseMigration fornisce metodi custom per la gestione delle colonne e delle tabelle, garantendo compatibilità multi-db e coerenza tra i moduli.
- Usare Schema direttamente può portare a comportamenti non previsti o errori di compatibilità.

### Checklist
- [ ] Usare SEMPRE $this->hasColumn nelle migrazioni Xot
- [ ] Non usare mai Schema::hasColumn
- [ ] Aggiornare tutte le migrazioni esistenti che non rispettano questa regola

### Collegamenti correlati
- [Linee guida Actions](./actions.mdc)
- [Linee guida Activitylog](./activitylog.mdc)
- [Best Practices](./best-practices.md)
- [Testing](./testing.md)
- [Documentazione centrale](../../../../docs/INDEX.md)

> **Nota fondamentale:**
> Se stai creando o modificando una Filament Resource che estende XotBaseResource, NON dichiarare mai le proprietà statiche $navigationGroup, $navigationLabel, né il metodo statico table(Table $table): Table. Segui la regola documentata in [filament-best-practices.mdc](./filament-best-practices.mdc).

## Best Practice: Implementazione dei Contract

> **Nota fondamentale:**
> Tutti i metodi richiesti dalle interfacce (contract) devono essere implementati come **pubblici** nella classe o trait che li dichiara, anche se la logica è delegata a un metodo privato/protetto (es. `ownsTeamTrait`).
> 
> Questo garantisce:
> - Compatibilità con il contract
> - Autoload e type hint corretti
> - Coerenza architetturale
> - Prevenzione di errori fatali in fase di runtime

### Esempio concreto: TeamContract

- Il contract `HasTeamsContract` richiede il metodo pubblico `ownsTeam(TeamContract $team): bool`.
- Il trait `HasTeams` implementa la logica in `ownsTeamTrait`, ma **deve** dichiarare anche il metodo pubblico `ownsTeam` che delega a `ownsTeamTrait`.

```php
public function ownsTeam(TeamContract $team): bool
{
    return $this->ownsTeamTrait($team);
}
```

**Regola generale:**
- Ogni volta che un contract richiede un metodo, assicurarsi che sia presente come metodo pubblico nella classe/trait.
- Delegare la logica a metodi privati/protetti se necessario, ma la firma pubblica deve sempre esistere.

**Vedi anche:**
- [Best Practices](./best-practices.mdc)
- [TeamContract](../app/Contracts/TeamContract.php)
- [BaseTeam](../app/Models/BaseTeam.php)

## Requisito strutturale: colonna owner_id in teams

> **Nota fondamentale:**
> La tabella `teams` deve avere la colonna `owner_id` (`uuid`, nullable) per garantire la compatibilità con il trait `HasTeams` e tutte le relazioni Eloquent che gestiscono la proprietà dei team.

### Motivazione
- Il trait `HasTeams` e la relazione `ownedTeams()` presuppongono che ogni team abbia un owner identificato da `owner_id`.
- Senza questa colonna, tutte le query che cercano i team di proprietà di un utente falliscono con errore SQL.
- Questa struttura è standard per tutti i pacchetti multi-team (Laravel Jetstream, Spark, ecc.) e garantisce compatibilità con i contract e i trait.

### Checklist
- [ ] La tabella `teams` ha la colonna `owner_id` (`uuid`, nullable)
- [ ] La migration è aggiornata ed eseguita
- [ ] La documentazione tecnica è aggiornata
- [ ] Tutte le relazioni Eloquent funzionano correttamente

### Esempio di migration
```php
Schema::table('teams', function (Blueprint $table) {
    $table->uuid('owner_id')->nullable()->after('id');
    // opzionale: $table->foreign('owner_id')->references('id')->on('users')->nullOnDelete();
});
```

## Best Practice migration modulari

> **Regola fondamentale:**
> Tutte le migration relative a tabelle modulari (es. `teams`, `team_user`, ecc.) devono essere create e mantenute nella cartella `database/migrations` del modulo corrispondente (es. `Modules/User/database/migrations`).

### Motivazione
- Garantisce isolamento e coerenza tra i moduli
- Evita conflitti e doppioni tra migration globali e modulari
- Facilita la manutenzione e la gestione delle dipendenze tra moduli
- Permette di attivare/disattivare moduli senza effetti collaterali

### Conseguenze di errori di path
- Migration duplicate o in conflitto
- Errori di sequenza nell'applicazione delle migration
- Difficoltà di manutenzione e debugging
- Rischio di corruzione dati o incoerenza tra ambienti

### Checklist
- [ ] Tutte le migration modulari sono nella cartella del modulo
- [ ] Nessuna migration di tabelle modulari nella cartella globale
- [ ] La documentazione tecnica è aggiornata
- [ ] I comandi artisan sono lanciati dal path corretto o con namespace modulo

