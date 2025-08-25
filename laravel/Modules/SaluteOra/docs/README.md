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
