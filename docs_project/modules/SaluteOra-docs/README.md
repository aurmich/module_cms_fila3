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

## Modelli Principali

### DoctorStudio
- **Tipo**: Pivot model many-to-many
- **Funzionalità**: Gestione relazione dottore-studio con orari
- **Cross-Database**: Attraversa database 'user' e 'salute_ora'
- **Caratteristiche**: Gestione orari apertura, slot temporali, date disponibili
- **Documentazione**: [DoctorStudio Model](doctor-studio-model.md)

## Documentazione Recente

### Correzioni e Miglioramenti
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
