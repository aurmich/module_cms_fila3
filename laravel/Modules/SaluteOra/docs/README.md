# Modulo SaluteOra

Il modulo SaluteOra gestisce tutte le informazioni relative ai pazienti e ai medici, incluse le loro interazioni con il sistema. Questo modulo implementa funzionalità per la gestione dell'anagrafica, la registrazione di pazienti e medici, la gestione delle visite e dei trattamenti, e l'integrazione con altri moduli del sistema.

## Funzionalità Principali

- **Gestione Appuntamenti**: Sistema completo per la gestione degli appuntamenti con stati e transizioni
- **Stati Appuntamenti**: Implementazione completa con traduzioni in italiano, inglese e tedesco
- **Widget Calendar**: Widget FullCalendar per dottori, pazienti e amministratori
- **Sistema Multi-Tenant**: Gestione di più studi medici con isolamento dati
- **Relazioni Doctor-Studio**: Gestione pivot many-to-many tra medici e studi

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

## Enum del Sistema

Il modulo SaluteOra implementa numerosi enum per la gestione tipizzata dei dati:

### Enum Principali
- **AppointmentTypeEnum**: Tipi di appuntamento (consultazione, pulizia, trattamento, emergenza, ecc.)
- **AppointmentStatusEnum**: Stati degli appuntamenti con transizioni complete
- **UserTypeEnum**: Tipi di utente (paziente, dottore, amministratore)
- **PatientAgeRangeEnum**: Fasce d'età delle pazienti (7 fasce da "Inferiore a 20 anni" a "Oltre 40 anni")

### Pattern di Implementazione

Il modulo SaluteOra utilizza due pattern per gli enum:

1. **TransTrait (Raccomandato)**: Utilizza `Modules\Xot\Filament\Traits\TransTrait` per generazione automatica delle chiavi di traduzione
2. **Traduzioni Dirette**: Pattern tradizionale con chiavi hardcoded

**Vantaggi del TransTrait:**
- Generazione automatica delle chiavi di traduzione
- Pattern uniforme per tutti gli enum del modulo
- Meno errori di digitazione nelle chiavi
- Refactoring sicuro quando si cambia il nome della classe

Vedi [Pattern TransTrait](enums/trans-trait-pattern.md) per dettagli completi.
- **DoctorStatusEnum**: Stati dei dottori nel sistema
- **PatientStatusEnum**: Stati dei pazienti nel sistema

### Documentazione Enum
- [Integrazione Enum in Filament](filament-enums-integration.mdc) - Linee guida complete per l'uso degli enum in Filament
- [PatientAgeRangeEnum](enums/patient-age-range-enum.md) - Documentazione specifica per le fasce d'età

### Caratteristiche Enum
- **Tipizzazione Rigorosa**: Tutti gli enum implementano interfacce Filament
- **Traduzioni Complete**: Supporto per italiano, inglese e tedesco
- **Metodi Utilità**: Metodi avanzati per la gestione dei dati
- **Integrazione Filament**: Supporto nativo per form, tabelle e filtri

## Modelli Principali

### DoctorStudio
- **Tipo**: Pivot model many-to-many
- **Funzionalità**: Gestione relazione dottore-studio con orari
- **Cross-Database**: Attraversa database 'user' e 'salute_ora'
- **Caratteristiche**: Gestione orari apertura, slot temporali, date disponibili
- **Documentazione**: [DoctorStudio Model](doctor-studio-model.md)

## Documentazione Recente

### Correzioni e Miglioramenti
- [Audit Traduzioni Campi "Regione", "Provincia", "Accedi"](translation_audit_region_province_login.md) - **⭐ RISOLTO** - Correzione completa traduzioni campi regione, provincia e login
- [Audit Traduzioni Campi "Città"](translation_audit_city_fields.md) - **⭐ RISOLTO** - Correzione completa traduzioni campi città in tutti i file
- [Audit Traduzioni Find Doctor Widget](translation_audit_find_doctor_widget.md) - **⭐ RISOLTO** - Correzione completa traduzioni tedesche widget find doctor
- [Correzione File Traduzione Edit Patient](edit_patient_translation_fix.md) - **⭐ RISOLTO** - Correzione completa file traduzioni modifica paziente
- [Correzione File Traduzione Edit Patient Privacy](edit_patient_privacy_translation_fix.md) - **⭐ RISOLTO** - Correzione completa file traduzioni privacy paziente
- [Correzione Duplicati Chiavi Traduzioni](duplicate-translation-keys-fix-2025-01-27.md) - **⭐ RISOLTO** - Risoluzione duplicati nelle traduzioni
- [Correzione Icona Arrow Path](correzione-icona-arrow-path-2025-01-06.md) - Risoluzione errori icone stati appuntamenti
- [Appointment States](appointment-states.md) - Documentazione completa stati appuntamenti
- [Appointment Report PDF Template](appointment_report_pdf_template.md) - Template PDF appuntamenti
- [Appointment Item Translation Fix](appointment_item_translation_fix.md) - Correzioni traduzioni elementi appuntamenti
- [Appointment Report Multilingual Fix](appointment-report-multilingual-fix.md) - Correzioni multilingua report
- [Appointment State Methods Fix](appointment-state-methods-fix.md) - Correzioni metodi stati
- [Appointment States Complete Standardization](appointment-states-complete-standardization.md) - Standardizzazione completa stati
- [SaluteOra Complete Factory Ecosystem](saluteora_complete_factory_ecosystem.md) - Ecosistema factory completo
- [UserFactory SaluteOra Integration](userfactory_saluteora_integration.md) - Integrazione UserFactory
- [FullCalendar Widget Analysis](fullcalendar-widget-analysis.md) - Analisi tecnica widget FullCalendar

### Modelli e Architettura
- [DoctorStudio Model](doctor-studio-model.md) - Documentazione completa modello pivot dottore-studio

## Regole Critiche

### Traduzioni
- **MAI** rimuovere contenuto dalle traduzioni, solo aggiungere o migliorare
- **SEMPRE** aggiornare tutte e tre le lingue (IT, EN, DE)
- **SEMPRE** verificare che le icone Heroicons esistano realmente
- **SEMPRE** usare il file `states.php` per traduzioni degli stati, non `appointment.php`
- **SEMPRE** verificare l'unicità delle chiavi per evitare duplicati
- **SEMPRE** usare sintassi moderna `[]` invece di `array()`
- **SEMPRE** includere `declare(strict_types=1);` in tutti i file di traduzione

### Stati Appuntamenti
- **Meccanismo traduzione**: `saluteora::states.{state_name}.{property}`
- **File traduzioni**: `laravel/Modules/SaluteOra/lang/{lang}/states.php`
- **Icone**: Verificare sempre esistenza in Heroicons prima dell'uso

### Relazioni Cross-Database
- **DoctorStudio**: Gestisce relazione tra database 'user' e 'salute_ora'
- **Connessione**: Utilizza connessione Studio per relazioni cross-database
- **Orari**: Gestione completa orari di lavoro con Spatie OpeningHours

## Qualità del Codice

### PHPStan
- **Livello**: 9+ per tutto il codice
- **Verifica**: Eseguire dopo ogni modifica alle traduzioni
- **Duplicati**: Identificare e rimuovere chiavi duplicate negli array
- **Stato**: ✅ Nessun errore di duplicati rimanente

### Traduzioni
- **Struttura**: Utilizzare sempre struttura espansa per campi e azioni
- **Coerenza**: Mantenere coerenza tra IT, EN, DE
- **Icone**: Verificare sempre esistenza in Heroicons
- **Duplicati**: Rimuovere solo i duplicati, mantenere il contenuto migliore
- **Stato**: ✅ Tutti i duplicati risolti

---

**Ultimo aggiornamento**: 27 Gennaio 2025
**Stato**: ✅ Attivo e mantenuto
**PHPStan**: ✅ Livello 9+ compatibile, nessun errore
**Traduzioni**: ✅ Complete in IT, EN, DE, nessun duplicato
**Icone**: ✅ Tutte verificate e valide

## Collegamenti

- [📊 **Project Analysis 2025-08-18**](../Xot/docs/project-analysis-2025-08-18.md) - **⭐ NUOVO** - Analisi completa architettura e stato progetto  
- [Modulo User](../User/docs/README.md) - Gestione utenti e autenticazione
- [Modulo UI](../UI/docs/README.md) - Componenti UI condivisi
- [Modulo Geo](../Geo/docs/README.md) - Gestione indirizzi e localizzazione
- [Documentazione Progetto](../../docs_project/README.md) - Documentazione generale progetto

## Models
- [Models Index](models/index.md) - Indice completo dei modelli
- [Doctor Studio Pivot Model](models/doctor-studio-pivot-model.md) - **⭐ NUOVO** - Modello pivot per relazione Doctor-Studio
- [DoctorStudio Technical Analysis](models/doctor-studio-technical-analysis.md) - **⭐ NUOVO** - Analisi tecnica approfondita
- [Doctor Studio Relationship](models/doctor-studio-relationship.md) - Relazione many-to-many
- [Pivot Models](models/pivot-models.md) - Convenzioni per modelli pivot
- [Doctor](models/doctor.md) - Modello principale per i medici
- [Patient](models/patient.md) - Modello per i pazienti
- [Studio](models/studio-model.md) - Modello per gli studi medici
- [Appointment States](models/appointment-states.md) - Stati degli appuntamenti
- [States](models/states.md) - Gestione stati dei modelli
- [State Best Practices](models/state-best-practices.md) - Best practices per stati
- [Single Table Inheritance](models/single-table-inheritance.md) - Pattern STI
- [User Inheritance Pattern](models/user-inheritance-pattern.md) - Pattern ereditarietà utenti
- [Pivot Models Pattern](pivot-models-pattern.md) - Pattern per modelli pivot
- [RelationX Trait](models/relationx-trait.md) - Trait per relazioni avanzate
- [Doctor Studio Model](doctor-studio-model.md) - Modello pivot Doctor-Studio
- [Doctor Studio Pivot Model](doctor-studio-pivot-model.md) - Documentazione completa pivot

## Factory System

### UserFactory e Ecosistema
- [UserFactory Implementation Completed](factories/userfactory_implementation_completed.md) - Implementazione completata
- [UserFactory Advanced Improvements](factories/userfactory-advanced-improvements-analysis.md) - Miglioramenti avanzati
- [UserFactory Implementation Guide](factories/userfactory-implementation-guide.md) - Guida implementazione
- [UserFactory Implementation Final](factories/userfactory-implementation-final.md) - Implementazione finale
- [Patient Doctor Admin Factories](factories/patient-doctor-admin-factories-implementation-complete.md) - Factory complete
- [PHPStan Factory Compliance](factories/phpstan-factory-compliance.md) - Conformità PHPStan

## Analisi Modelli

### Modelli Non Utilizzati
- [Analisi Modelli Non Utilizzati](unused-models-analysis.md) - **⭐ NUOVO** - Identificazione modelli non utilizzati per pulizia codice

### PHPStan e Qualità Codice
- [🚨 PHPStan Critical Rules](../Xot/docs/phpstan-critical-rules.md) - **🚨 CRITICO** - phpstan.neon INTOCCABILE
- [PHPStan Relationship Covariance Fix](phpstan-relationship-covariance-fix.md) - **⭐ NUOVO** - Correzione errori covarianza relazioni Eloquent
- [PHPStan Covariance Resolution Summary](phpstan-covariance-resolution-summary.md) - **⭐ NUOVO** - Riepilogo completo risoluzione

## Models
