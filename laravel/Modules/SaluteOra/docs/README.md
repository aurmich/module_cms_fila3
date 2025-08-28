# SaluteOra Module

[![Laravel 12.x](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com/)
[![Filament 3.x](https://img.shields.io/badge/Filament-3.x-blue.svg)](https://filamentphp.com/)
[![PHPStan Level 9](https://img.shields.io/badge/PHPStan-Level%209-brightgreen.svg)](https://phpstan.org/)
[![Translation Ready](https://img.shields.io/badge/Translation-IT%20%7C%20EN%20%7C%20DE-green.svg)](https://laravel.com/docs/localization)
[![Single Table Inheritance](https://img.shields.io/badge/STI-Implemented-orange.svg)](https://en.wikipedia.org/wiki/Single_Table_Inheritance)
[![Multi-Tenant](https://img.shields.io/badge/Multi--Tenant-Ready-yellow.svg)](https://laravel.com/docs/tenancy)
[![Quality Score](https://img.shields.io/badge/Quality%20Score-95%25-brightgreen.svg)](https://github.com/laraxot/saluteora-module)

## Quick Reference
SaluteOra is the core healthcare management system handling patient registration, doctor management, appointment scheduling, and reporting for Italian healthcare facilities.

### Core Entities
- **Patients**: Healthcare service recipients with pregnancy management (extends to SaluteMo)
- **Doctors**: Healthcare providers with certifications and studio associations  
- **Studios**: Physical locations where healthcare services are provided
- **Appointments**: Scheduled healthcare visits with full lifecycle management
- **Reports**: Healthcare documentation and patient records

### Key Business Logic
- **User Registration**: Patient and doctor onboarding with Italian compliance
- **Appointment Booking**: Calendar-based scheduling with availability management
- **Studio Management**: Multi-location support with doctor associations
- **State Transitions**: Workflow management for users and appointments

## Design Principles
**Foundation**: DRY, KISS, ROBUST, SOLID

### DRY (Don't Repeat Yourself)
- **Shared Traits**: `HasMedia`, `HasStates`, `HasAddress`, `IsTenant`
- **Common Patterns**: States and transitions inherit from `BaseTransition`
- **Standardized Relations**: Using `RelationX` trait for cross-database relationships

### KISS (Keep It Simple, Stupid)
- **Linear Inheritance**: Simple and predictable chain
- **Direct Relations**: Avoid complex and circular relationships
- **Focused Methods**: Single responsibility principle

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

## Factory e Seeder

### Factory Disponibili
Il modulo include factory complete per la generazione di dati di test:

#### PatientFactory
- **Campi principali**: Nome, cognome, codice fiscale, data nascita, telefono, email, indirizzo
- **Campi specifici**: Stato gravidanza, codice ISEE, assicurazione, note cliniche
- **Stati personalizzati**: `pregnant()`, `lowIsee()`, `highIsee()`
- **Generazione dati**: Codice fiscale univoco, email univoca, date realistiche

#### DoctorFactory
- **Campi principali**: Nome, cognome, email, telefono, indirizzo, specializzazione
- **Campi professionali**: Numero registrazione, anni esperienza, anno laurea, tariffa consultazione
- **Disponibilità**: Orari settimanali, accettazione nuovi pazienti, disponibilità emergenze
- **Stati personalizzati**: `orthodontist()`, `implantologist()`, `endodontist()`, `experienced()`, `newGraduate()`

#### StudioFactory
- **Campi principali**: Nome, indirizzo, telefono, email, orari
- **Campi specifici**: Tipo studio, servizi offerti, certificazioni

#### AppointmentFactory
- **Campi principali**: Data/ora, durata, tipo, stato, note
- **Relazioni**: Doctor, Patient, Studio
- **Stati**: Distribuiti su 30 giorni con stati realistici

### Seeder Principali

#### SaluteOraDatabaseSeeder
Seeder principale che crea:
- **10 studi** (se non esistenti)
- **25 dottori** (se non esistenti)  
- **200 pazienti** (se non esistenti)
- **1000 appuntamenti** distribuiti su 30 giorni
- **200 report** per appuntamenti selezionati

#### MassDataSeeder
Seeder per grandi volumi di dati con:
- Creazione batch per evitare picchi di memoria
- Relazioni automatiche tra entità
- Gestione errori silenziosa per relazioni non configurate

### Utilizzo Factory

```php
// Creazione singola entità
$patient = Patient::factory()->create();
$doctor = Doctor::factory()->create();

// Creazione con stati personalizzati
$pregnantPatient = Patient::factory()->pregnant()->create();
$experiencedDoctor = Doctor::factory()->experienced()->create();

// Creazione multipla
$patients = Patient::factory()->count(100)->create();
$doctors = Doctor::factory()->count(100)->create();

// Creazione con relazioni
$appointment = Appointment::factory()
    ->for($doctor)
    ->for($patient)
    ->for($studio)
    ->create();
```

### Creazione Dati di Test con Tinker

```bash
# Accesso a Tinker
cd /var/www/html/_bases/base_saluteora/laravel
php artisan tinker

# Creazione 100 pazienti
Patient::factory()->count(100)->create();

# Creazione 100 dottori  
Doctor::factory()->count(100)->create();

# Creazione con stati specifici
Patient::factory()->pregnant()->count(20)->create();
Doctor::factory()->experienced()->count(30)->create();
```

## Testing

### Test Disponibili
- **Unit Tests**: Test per modelli, factory e stati
- **Feature Tests**: Test per relazioni e business logic
- **Integration Tests**: Test per widget calendar e seeder

### Best Practices Testing
- Utilizzare sempre le factory per dati di test
- Testare stati personalizzati delle factory
- Verificare relazioni e integrità referenziale
- Testare scenari edge case e validazioni

## Testing Coverage

### Business Logic Tests
- **Models**: Complete coverage for all business logic
- **Actions**: Full testing of business actions and workflows
- **Integration**: End-to-end testing of appointment workflows
- **Authentication**: Complete user authentication testing

### Folio Route Tests
**NEW**: Complete coverage of all 29 Folio routes with dedicated test files:

#### Public Routes
- **Homepage** (`/it`): Index page with content validation
- **Authentication**: Login, register, password reset flows
- **Content Pages**: Learn, pages index, CSS classes
- **Genesis**: About and power-ups pages

#### Protected Routes  
- **Dashboard** (`/it/dashboard`): User dashboard with authentication checks
- **Profile Management**: Profile view, edit, and settings
- **Patient Features**: Booking, creation, medical reports
- **Artisan Commands**: Management interface

#### Test Structure
All Folio tests are located in `tests/Feature/Folio/` and cover:
- ✅ Route accessibility and authentication
- ✅ Content rendering and meta tags
- ✅ Form display and user interactions
- ✅ Redirect logic for authenticated users
- ✅ Error handling and edge cases

**Total Folio Tests**: 29 dedicated test files covering 100% of routes

## Collegamenti

- [Modelli e Relazioni](models/README.md)
- [Stati Appuntamenti](states/README.md)
- [Widget Calendar](widgets/README.md)
- [Factory e Seeder](factories/README.md)
- [Testing](testing/README.md)

---

**Ultimo aggiornamento**: Dicembre 2024
**Versione**: 2.0
**Compatibilità**: Laravel 12, Filament 3, PHP 8.3+
