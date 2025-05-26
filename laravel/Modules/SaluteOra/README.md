# Modulo SaluteOra

## Descrizione
Modulo principale per la gestione del sistema sanitario, inclusa la gestione di appuntamenti, pazienti, medici e risorse correlate.

## Documentazione

### Struttura e Convenzioni
- [Struttura Directory](docs/directory-structure.md) - Standard e convenzioni per l'organizzazione del codice
- [Autenticazione & Autorizzazione](docs/authentication-authorization.md) - Gestione ruoli e permessi
- [Convenzione per le icone SVG](docs/ICON_CONVENTION.md) - Linee guida per l'utilizzo e la creazione di icone SVG
- [Gestione degli Stati](docs/STATE_MANAGEMENT.md) - Guida all'utilizzo di spatie/laravel-model-states

### Funzionalità Principali
- [Calendario Appuntamenti](docs/calendar/README.md) - Gestione completa del calendario
- [Gestione Pazienti](docs/patient-management.md) - Anagrafica e cartelle cliniche
- [Gestione Medici](docs/doctor-management.md) - Profili e disponibilità

## Struttura del Modulo (PSR-4)

```
SaluteOra/
├── app/                    # Codice sorgente PHP (PSR-4)
│   ├── Actions/           # Classi per azioni specifiche
│   │   └── Calendar/      # Azioni relative al calendario
│   ├── Enums/             # Enumerazioni PHP
│   ├── Http/
│   │   ├── Controllers/  # Controller
│   │   ├── Livewire/      # Componenti Livewire
│   │   └── Middleware/    # Middleware HTTP
│   ├── Models/            # Modelli Eloquent
│   ├── Policies/          # Policy di autorizzazione
│   └── Services/          # Servizi di business logic
├── config/                # File di configurazione
├── database/
│   ├── factories/       # Factory per i test
│   ├── migrations/        # Migrazioni del database
│   └── seeders/          # Seeder per dati iniziali
├── docs/                  # Documentazione
├── lang/                  # File di traduzione
├── resources/
│   ├── css/             # Fogli di stile
│   ├── js/               # Script JavaScript
│   └── views/            # Viste Blade
└── routes/                # Definizioni delle rotte
```

## Installazione e Configurazione

1. **Requisiti**
   - PHP 8.2+
   - Laravel 10.0+
   - Spatie Laravel Permission
   - Spatie Laravel Model States

2. **Installazione**
   ```bash
   # Installare le dipendenze
   composer require spatie/laravel-permission
   
   # Pubblicare le migrazioni e i file di configurazione
   php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
   
   # Eseguire le migrazioni
   php artisan migrate
   ```

3. **Configurazione**
   - Verificare che il provider del modulo sia registrato in `config/app.php`
   - Configurare i percorsi di autenticazione in `config/auth.php`

## Best Practices

### Convenzioni di Codice
1. **Naming**
   - Classi: `PascalCase`
   - Metodi e proprietà: `camelCase`
   - File di migrazione: `YYYY_MM_DD_HHMMSS_descriptive_name.php`
   - Viste: `kebab-case`

2. **Struttura del Codice**
   - Mantenere i controller snelli
   - Utilizzare le Action classes per la logica di business
   - Implementare le interfacce per i servizi principali
   - Utilizzare i DTO per il passaggio dei dati tra i layer

3. **Sicurezza**
   - Validare sempre l'input
   - Utilizzare le policy per l'autorizzazione
   - Implementare rate limiting per le API
   - Utilizzare HTTPS in produzione

### Performance
- Utilizzare eager loading per le relazioni
- Implementare la cache per i dati frequentemente letti
- Utilizzare le code per le operazioni pesanti
- Monitorare le query SQL

## Sviluppo

### Strumenti Consigliati
- PHPStan per l'analisi statica del codice
- PHP_CodeSniffer per lo stile del codice
- PHPUnit per i test
- Laravel Telescope per il debug

### Workflow di Sviluppo
1. Creare un nuovo branch per ogni funzionalità
2. Scrivere i test prima dell'implementazione (TDD)
3. Eseguire i test localmente
4. Creare una pull request
5. Eseguire il codice review
6. Eseguire il merge solo dopo l'approvazione

## Documentazione Aggiuntiva

- [Guida allo Sviluppo](docs/development-guide.md)
- [Linee Guida API](docs/api-guidelines.md)
- [Convenzioni di Testing](docs/testing-conventions.md)
- [Deployment](docs/deployment.md)
   - Implementare la validazione dei file
   - Gestire correttamente i permessi

## Errori Comuni
1. **File Upload**
   - Non utilizzare `prefixIcon()` o `icon()` direttamente su `FileUpload`
   - Utilizzare `Section` per aggiungere icone ai componenti di upload

2. **Migrations**
   - Verificare sempre le dipendenze tra le tabelle
   - Utilizzare i tipi di colonna appropriati
   - Implementare gli indici necessari

## Errore critico: No hint path defined for [patient]

**Problema:**
Se accedi a `/it/auth/patient/register` e ricevi l'errore:

```
InvalidArgumentException
No hint path defined for [patient].
```

**Motivo:**
Nel codice del modulo viene usato il namespace Blade `patient::` (es: `Forms\Components\View::make('patient::privacy-policy')`), ma il modulo si chiama `SaluteOra` e il suo ServiceProvider registra solo il namespace `saluteora`.

**Soluzione:**
1. **Registrare il namespace Blade 'patient' nel ServiceProvider del modulo.**
   - Apri `app/Providers/SaluteOraServiceProvider.php`.
   - All'interno del metodo `boot()`, aggiungi:
     ```php
     use Illuminate\Support\Facades\Blade;
     // ...
     public function boot()
     {
         parent::boot();
         \Illuminate\Support\Facades\View::addNamespace('patient', base_path('laravel/Modules/SaluteOra/resources/views'));
     }
     ```
   - In alternativa, sostituisci tutte le chiamate a `patient::` con `saluteora::` nel codice del modulo.

2. **Svuota la cache delle view:**
   ```bash
   php artisan view:clear
   php artisan cache:clear
   ```

3. **Verifica:**
   - Ricarica la pagina `/it/auth/patient/register` e controlla che l'errore sia risolto.

**Nota:**
- È preferibile uniformare i namespace usati nel codice e nella registrazione delle viste per evitare errori simili in futuro.
- Aggiorna anche la documentazione interna e i commenti nei file dove viene usato `patient::`.

## Documentazione
- [Component Icon Support](/docs/filament/component-icon-support.md)
- [File Upload Component](/docs/filament/file-upload-component.md)
- [Database Migrations](/docs/database-migrations.md)

## Testing
- Eseguire i test unitari: `php artisan test --filter=Patient`
- Verificare la copertura del codice
- Testare le funzionalità principali

## Deployment
1. Eseguire le migrazioni
2. Pubblicare gli assets
3. Aggiornare la cache
4. Verificare i permessi

## Manutenzione
- Monitorare i log per errori
- Verificare periodicamente le performance
- Aggiornare le dipendenze
- Mantenere la documentazione aggiornata

## Troubleshooting

### Errore: `No hint path defined for [patient]`

**Descrizione:**
Se accedi alla URL `/it/auth/patient/register` e ricevi un errore `Internal Server Error` con messaggio:

```
InvalidArgumentException
No hint path defined for [patient].
```

significa che Laravel non trova il namespace Blade `patient::` richiesto da alcune view o componenti (es. `<x-patient::patient-registration-wizard />` o `@extends('patient::layouts.app')`).

**Cause comuni:**
- Il namespace Blade `patient` non è stato registrato nei service provider.
- Il componente Blade è presente in `resources/views/components/` ma non è pubblicato/registrato come namespace.
- Il modulo non ha un ServiceProvider che esegue la registrazione dei componenti Blade con `Blade::componentNamespace()` o `Blade::component()`.

**Soluzione:**
1. **Verifica la presenza del ServiceProvider**
   - Controlla che in `Providers/SaluteOraServiceProvider.php` (o simile) sia presente la registrazione del namespace Blade per i componenti patient:
   ```php
   use Illuminate\Support\Facades\Blade;
   // ...
   public function boot()
   {
       Blade::componentNamespace('Modules\\SaluteOra\\View\Components', 'patient');
   }
   ```
   - Se usi componenti class-based, assicurati che la directory e il namespace siano corretti.

2. **Verifica la struttura delle view**
   - I file Blade usati come componenti devono trovarsi in `resources/views/components/` e seguire la naming convention corretta.
   - Se usi `@extends('patient::layouts.app')`, assicurati che esista la view `resources/views/layouts/app.blade.php` e che il namespace sia registrato.

3. **Cache delle view**
   - Dopo aver registrato il namespace, svuota la cache delle view:
   ```bash
   php artisan view:clear
   php artisan cache:clear
   ```

4. **Ricarica la pagina**
   - Verifica che l'errore sia risolto accedendo nuovamente alla URL.

**Nota:**
Se il modulo viene installato come package, assicurati che il ServiceProvider sia correttamente registrato in `composer.json` e caricato da Laravel.

**Riferimenti:**
- [Documentazione Laravel Blade Components](https://laravel.com/docs/12.x/blade#manually-registering-components)
- [Esempio di registrazione namespace Blade](https://laravel.com/docs/12.x/blade#registering-package-components)
