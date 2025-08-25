# Modulo SaluteOra - Documentazione Consolidata

## Panoramica

Il modulo SaluteOra gestisce tutte le informazioni relative ai pazienti e ai medici, incluse le loro interazioni con il sistema. Questo modulo implementa funzionalità per la gestione dell'anagrafica, la registrazione di pazienti e medici, la gestione delle visite e dei trattamenti, e l'integrazione con altri moduli del sistema.

**Principi di Design**: DRY, KISS, ROBUST, SOLID

## Architettura e Principi

### DRY (Don't Repeat Yourself)
- **Trait condivisi**: `HasMedia`, `HasStates`, `HasAddress`, `IsTenant`
- **Pattern comuni**: Stati e transizioni ereditano da `BaseTransition`
- **Relazioni standardizzate**: Utilizzo del trait `RelationX` per relazioni cross-database

### KISS (Keep It Simple, Stupid)
- **Ereditarietà lineare**: Catena semplice e prevedibile
- **Relazioni dirette**: Evitare relazioni complesse e circolari
- **Metodi focalizzati**: Ogni metodo ha una responsabilità singola

### ROBUST
- **Validazione**: Controlli di integrità a livello di modello
- **Gestione errori**: Trattamento appropriato di casi limite
- **Logging**: Tracciabilità completa delle operazioni

### SOLID
- **Single Responsibility**: Ogni modello gestisce una sola entità di business
- **Open/Closed**: Estensibile tramite trait e ereditarietà
- **Liskov Substitution**: I modelli figli sono sostituibili ai modelli base
- **Interface Segregation**: Trait specifici per funzionalità specifiche
- **Dependency Inversion**: Dipendenze gestite tramite trait e relazioni

## Funzionalità Principali

- **Gestione Appuntamenti**: Sistema completo per la gestione degli appuntamenti con stati e transizioni
- **Stati Appuntamenti**: Implementazione completa con traduzioni in italiano, inglese e tedesco
- **Widget Calendar**: Widget FullCalendar per dottori, pazienti e amministratori
- **Sistema Multi-Tenant**: Gestione di più studi medici con isolamento dati
- **Relazioni Doctor-Studio**: Gestione pivot many-to-many tra medici e studi
- **Gestione Report**: Sistema completo per report medici e loro allegati

## Modelli e Relazioni

### Documentazione Modelli
- [Modelli Consolidati](models/README.md) - Documentazione rifattorizzata dei modelli
- [Analisi Relazioni](models/relationships-analysis.md) - **⭐ NUOVO** - Analisi relazioni esistenti e mancanti

### Modelli Principali
- **User**: Classe base con Single Table Inheritance (STI)
- **Doctor**: Specializzazione per medici con relazioni studio
- **Patient**: Specializzazione per pazienti con gestione allegati
- **Studio**: Gestione studi medici con multi-tenancy
- **Appointment**: Gestione appuntamenti con stati e transizioni
- **Report**: Gestione report medici e loro allegati
- **Profile**: Profili utente estesi con media

### Modelli Pivot
- **DoctorStudio**: Relazione many-to-many Doctor-Studio con schedule
- **PatientStudio**: Relazione many-to-many Patient-Studio

## Stati degli Appuntamenti

Il modulo implementa un sistema completo di stati per gli appuntamenti con traduzioni complete:

### Stati Implementati
- **Scheduled**: Appuntamento programmato
- **Confirmed**: Appuntamento confermato  
- **In Progress**: Appuntamento in corso
- **Completed**: Appuntamento completato
- **Cancelled**: Appuntamento cancellato
- **No Show**: Paziente non presentato
- **Rejected**: Appuntamento rifiutato
- **Rescheduled**: Appuntamento riprogrammato
- **Refund To Integrate**: Rimborso da integrare
- **Refund Integrate**: Rimborso integrato

### Traduzioni
Tutti gli stati hanno traduzioni complete in:
- **Italiano**: `laravel/Modules/SaluteOra/lang/it/states.php`
- **Inglese**: `laravel/Modules/SaluteOra/lang/en/states.php`  
- **Tedesco**: `laravel/Modules/SaluteOra/lang/de/states.php`

### Icone Corrette
Le icone sono state standardizzate per evitare errori:
- **Stati di rimborso**: `heroicon-o-arrows-up-down`
- **Stati completati**: `heroicon-o-check-circle`
- **Stati in corso**: `heroicon-o-clock`

## Widget Calendar

### DoctorCalendarWidget
- **Estende**: `FullCalendarWidget`
- **Accesso**: Solo dottori (`UserTypeEnum::DOCTOR`)
- **Funzionalità**: CRUD completo appuntamenti
- **Filtro**: Appuntamenti dello studio corrente

### PatientCalendarWidget  
- **Estende**: `FullCalendarWidget`
- **Accesso**: Solo pazienti (`UserTypeEnum::PATIENT`)
- **Funzionalità**: Visualizzazione sola lettura
- **Filtro**: Appuntamenti del paziente corrente

### AdminCalendarWidget
- **Estende**: `FullCalendarWidget` 
- **Accesso**: Solo amministratori (`UserTypeEnum::ADMIN`)
- **Funzionalità**: Vista globale tutti gli appuntamenti
- **Filtro**: Tutti gli appuntamenti del sistema

## Calendar System

### Documentazione Calendar
- [Calendar Architecture](calendar/architecture.md) - Architettura del sistema calendar
- [Calendar Implementation](calendar-implementation.md) - Implementazione completa
- [Theme Calendar Integration](theme-calendar-integration.md) - Integrazione con temi
- [FullCalendar Widget Analysis](fullcalendar-widget-analysis.md) - Analisi tecnica widget
- [FullCalendar Implementation Guide](fullcalendar_implementation_guide.md) - Guida implementazione
- [FullCalendar Summary](fullcalendar-summary.md) - Riepilogo funzionalità

### Widget Calendar Specifici
- [Calendar Widgets Overview](calendar/widgets/README.md) - Panoramica widget calendar
- [Admin Calendar Widget](calendar/widgets/admin-calendar-widget.md) - Widget amministratore
- [Doctor Calendar Widget](calendar/widgets/doctor-calendar-widget.md) - Widget dottore
- [Patient Calendar Widget](calendar/widgets/patient-calendar-widget.md) - Widget paziente

### Funzionalità Calendar
- [Doctor Authentication Calendar](calendar/doctor-authentication-calendar.md) - Autenticazione dottori
- [Doctor Availability Implementation](calendar/doctor-availability-implementation.md) - Implementazione disponibilità
- [Doctor Availability Management](calendar/doctor-availability-management.md) - Gestione disponibilità
- [Patient Booking Flow](calendar/patient_booking_flow.md) - Flusso prenotazione pazienti
- [Patient Calendar Actions](calendar/patient_calendar_actions.md) - Azioni calendar pazienti
- [Fetch Events](calendar/fetch-events.md) - Recupero eventi
- [FullCalendar Widget v3.2.4 Configuration](calendar/fullcalendar-widget-v324-configuration.md) - Configurazione versione specifica

## Stati Appuntamenti

### Documentazione Stati
- [Appointment States](appointment-states.md) - Stati completi degli appuntamenti
- [Appointment States Complete Standardization](appointment-states-complete-standardization.md) - Standardizzazione completa
- [Appointment State Methods Fix](appointment-state-methods-fix.md) - Correzioni metodi stati
- [Appointment Start End Migration](appointment_start_end_migration.md) - Migrazione campi data

### Transizioni Stati
- [Report Pending to Completed Transition](states/report-pending-to-completed-transition.md) - Transizione report completato

### Correzioni Stati
- [Correzione Icona Arrow Path](correzione-icona-arrow-path-2025-01-06.md) - Correzioni icone stati
- [Traduzioni Stati Appuntamenti Correzioni](traduzioni-stati-appuntamenti-correzioni-2025-01-06.md) - Correzioni traduzioni stati

## Traduzioni e Localizzazione

### Sistema Traduzioni
- **Struttura espansa**: Tutti i campi hanno `label`, `placeholder`, `help`
- **Multi-lingua**: Italiano, Inglese, Tedesco
- **Namespace**: `saluteora::` per tutte le traduzioni del modulo

### File di Traduzione
- **Italiano**: `laravel/Modules/SaluteOra/lang/it/`
- **Inglese**: `laravel/Modules/SaluteOra/lang/en/`
- **Tedesco**: `laravel/Modules/SaluteOra/lang/de/`

### Traduzioni Principali
- [Doctor](lang/it/doctor.php) - Traduzioni per modello dottore
- [Patient](lang/it/patient.php) - Traduzioni per modello paziente
- [Studio](lang/it/studio.php) - Traduzioni per modello studio
- [Appointment](lang/it/appointment.php) - Traduzioni per modello appuntamento
- [Report](lang/it/report.php) - Traduzioni per modello report

## Best Practices e Regole

### Regole Cursor
- [Regole Cursor](cursor.mdc) - Regole specifiche per sviluppo Cursor
- [Regole Windsurf](windsurf.mdc) - Regole per sviluppo Windsurf

### Filament Best Practices
- [Filament Best Practices](filament-best-practices.mdc) - Best practices per Filament
- [FullCalendar Best Practices](fullcalendar-best-practices.mdc) - Best practices per FullCalendar

### Convenzioni di Codice
- **Namespace**: `Modules\SaluteOra\...` (senza segmento 'App')
- **Ereditarietà**: Estendere sempre `BaseModel` del proprio modulo
- **Trait**: Non ridichiarare trait già ereditati
- **Relazioni**: Utilizzare `belongsToManyX` per relazioni cross-database

## Sviluppo e Manutenzione

### Ambiente di Sviluppo
- **PHP**: 8.2+
- **Laravel**: 12.x
- **Filament**: 3.x
- **Database**: MySQL 8.0+

### Strumenti di Qualità
- **PHPStan**: Livello 9+ obbligatorio
- **Pint**: Laravel coding standards
- **PHP CS Fixer**: PSR-12 compliance

### Testing
- **Unit Tests**: Per tutti i modelli e relazioni
- **Feature Tests**: Per workflow e integrazioni
- **Performance Tests**: Per evitare N+1 queries

## Collegamenti e Riferimenti

### Documentazione Interna
- [Modelli SaluteOra](models/README.md) - Documentazione consolidata modelli
- [Analisi Relazioni](models/relationships-analysis.md) - Analisi relazioni mancanti
- [Architettura Tecnica](architettura-tecnica.md) - Architettura del sistema

### Documentazione Esterna
- [Laravel Documentation](https://laravel.com/docs)
- [Filament Documentation](https://filamentphp.com/docs)
- [FullCalendar Documentation](https://fullcalendar.io/docs)

---

**Ultimo aggiornamento**: Gennaio 2025
**Versione**: 2.0 (Rifattorizzata)
**Principi**: DRY, KISS, ROBUST, SOLID
**Stato**: Documentazione consolidata, pronto per implementazione relazioni

## Stato Implementazione

### ✅ Modelli Completamente Documentati
- **User** - Base class con STI e trait condivisi
- **Doctor** - Specializzazione medico con relazioni studio
- **Patient** - Specializzazione paziente con gestione allegati
- **Studio** - Gestione studi medici con multi-tenancy
- **Appointment** - Gestione appuntamenti con stati
- **Report** - **AGGIORNATO** - Con relazione studio attraverso appointment
- **Profile** - Profili utente estesi

### 🔧 Relazioni Implementate Recentemente
- **`Report.studio()`** - Accessor verso Studio attraverso Appointment (Gennaio 2025)

# Modulo SaluteOra

## Testing

### ❌ REGOLA CRITICA: MAI USARE RefreshDatabase
- I test di business logic devono essere puri e veloci
- Usare oggetti in memoria (object) invece di factory
- Performance: i test devono essere istantanei

### Documentazione Testing
- [Testing Guidelines](testing.md) - Regole fondamentali per i test
- [Appointment Business Logic Testing](appointment-business-logic-testing.md) - Test specifici per appuntamenti
- [Common Testing Errors](common-testing-errors.md) - Errori comuni e soluzioni
- [Testing Best Practices](testing-best-practices.md) - Best practice per i test

### Pattern Test Corretto
```php
// ✅ CORRETTO - Test puro senza database
uses(TestCase::class); // SENZA RefreshDatabase!

beforeEach(function () {
    $this->patient = (object) ['id' => 1001, 'name' => 'Mario Rossi'];
    $this->doctor = (object) ['id' => 2001, 'name' => 'Dr. Bianchi'];
});

// ❌ ERRATO - Test lento con database
uses(TestCase::class, RefreshDatabase::class); // MAI!
```

## Struttura del Modulo

- **Models**: Modelli Eloquent per entità di business
- **Enums**: Enumerazioni per stati e tipi
- **Tests**: Test di business logic puri e veloci
- **Docs**: Documentazione completa e aggiornata
