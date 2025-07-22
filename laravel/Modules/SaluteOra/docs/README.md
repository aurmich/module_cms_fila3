# Modulo Patient

## Panoramica

Il modulo Patient gestisce tutte le informazioni relative ai pazienti e ai medici, incluse le loro interazioni con il sistema. Questo modulo implementa funzionalità per la gestione dell'anagrafica, la registrazione di pazienti e medici, la gestione delle visite e dei trattamenti, e l'integrazione con altri moduli del sistema.

## File Chiave
- [Doctor.php](app/Models/Doctor.php)
- [User.php](app/Models/User.php)
- [BaseUser.php](../User/app/Models/BaseUser.php)
- [DoctorResource.php](app/Filament/Resources/DoctorResource.php)
- [RegisterAction.php](app/Actions/RegisterAction.php)
- [RegistrationWidget.php](../User/app/Filament/Widgets/RegistrationWidget.php)

## Indice della Documentazione

- [Indice Completo](index.md) - Panoramica di tutta la documentazione disponibile

### Architettura e Pattern

- [Single Table Inheritance](single_table_inheritance.md) - Pattern STI per i modelli utente
- [Best Practices per l'Ereditarietà](inheritance_best_practices.md) - Linee guida per l'ereditarietà delle classi
- [Model Inheritance Pattern](model_inheritance_pattern.md) - Pattern di ereditarietà per i modelli
- [Policies di Autorizzazione](policies.md) - Sistema completo di autorizzazioni e permessi

### Best Practices

- [Actions Best Practices](actions_best_practices.md) - Linee guida per le Actions
- [Data Transfer Objects](data_transfer_objects_complete.md) - Implementazione e utilizzo dei DTO
- [Migrations Best Practices](migrations_best_practices.md) - Linee guida per le migrazioni
- [Error Handling Best Practices](error_handling_best_practices.md) - Gestione degli errori
- [Enums Best Practices](enums_best_practices.md) - Utilizzo degli enum in PHP 8.2+

### Widgets

- [StudioFilterWidget](widgets/studio-filter-widget.md) - Widget per la selezione e gestione degli studi medici
- [FindDoctorAndAppointmentWidget Errors](widgets/find-doctor-appointment-widget-errors.md) - Analisi e soluzioni per il widget di prenotazione appuntamenti
- [📊 FindDoctorAndAppointmentWidget Analysis](widgets/find-doctor-appointment-widget-analysis.md) - **CORE**: Analisi completa e roadmap implementazione Step 2, integrazione componenti UI riutilizzabili
- [🛠️ FindDoctorWidget Step 2 Implementation](widgets/find-doctor-appointment-widget-step2-implementation.md) - **IMPLEMENTATION**: Guida dettagliata implementazione secondo step con componenti UI creati

### Errori e Troubleshooting

- [🚨 Array to String Conversion User Registration](errori/array-to-string-conversion-user-registration.md) - **CRITICO**: Errore durante registrazione paziente con allegati, conflitto architetturale Media Library vs Database
- [📧 MissingMailTemplate SpatieEmail](errori/missing-mail-template-spatie-email.md) - **CRITICO**: Template email mancante durante invio notifiche, conflitto timing Spatie MailTemplates
- [🔄 Sync Pivot Schedule Issue](sync_pivot_schedule_issue.md) - **CRITICO**: Campo schedule non aggiornato nel pivot durante sync, problema con belongsToManyX

### Filament

#### Best Practices e Regole
- [📋 Filament Best Practices](filament-best-practices.mdc) - **REGOLE COMPLETE**: Estensione XotBaseResource, namespace, traduzioni, enum
- [📁 Namespace vs File Structure](namespace-vs-file-structure.md) - **CRITICO**: Differenze tra namespace e struttura fisica dei file
- [🏗️ Filament Namespace Rules](filament-namespace-rules.md) - Regole specifiche per namespace Filament

#### Sistema di Traduzione
- [Filament Label Translation System](filament_label_translation_system.md) - Sistema di traduzione delle etichette
- [Filament Resources Implementation](filament_resources_implementation.md) - Implementazione dei resource

#### FullCalendar Multi-Tenant
- [📋 FullCalendar Index](fullcalendar_index.mdc) - **INDICE COMPLETO**: Panoramica e navigazione documentazione FullCalendar
- [🏗️ FullCalendar con Parental](fullcalendar_parental_widgets.md) - **PRINCIPALE**: Architettura completa con Parental STI e tenancy Filament
- [📖 FullCalendar Implementation Guide](fullcalendar_implementation_guide.md) - Guida step-by-step per implementazione
- [⚙️ FullCalendar Configuration](fullcalendar_configuration.mdc) - Configurazioni complete del sistema
- [🔧 FullCalendar Widget Implementation](fullcalendar_widget_implementation.mdc) - Implementazione specifica dei widget
- [🔄 FullCalendar Migration Guide](fullcalendar_migration_guide.mdc) - Guida migrazione da legacy a Parental STI

#### Documentazione Legacy FullCalendar (Riferimento)
- [FullCalendar Integration](fullcalendar_integration.md) - Integrazione base (legacy)
- [FullCalendar Widgets](fullcalendar_widgets.md) - Widget precedenti (legacy)
- [FullCalendar Configuration](fullcalendar_configuration.md) - Configurazioni precedenti (legacy)
- [FullCalendar Multi-Tenant Widgets](fullcalendar_multi_tenant_widgets.md) - Widget multi-tenant precedenti (legacy)

### Modelli

- [Doctor](models/doctor.md) - Documentazione del modello Doctor
- [User](models/user.md) - Documentazione del modello User
- [DoctorRegistrationWorkflow](models/doctor_registration_workflow.md) - Workflow di registrazione dei medici

#### Stati degli Utenti (Spatie Model States)

Il modulo utilizza il package `spatie/laravel-model-states` per gestire gli stati degli utenti attraverso un workflow strutturato con un **pattern architetturale eccellente**:

- [Stati Utente](models/states.md) - Documentazione completa degli stati e transizioni
- [**Pattern BaseTransition**](models/base-transition-pattern.md) - **CAPOLAVORO**: Implementazione DRY & KISS
- [Best Practices Stati](models/state-best-practices.md) - Linee guida per l'implementazione degli stati
- [**Workflow di Integrazione**](models/integration-workflow.md) - **NUOVO**: Flusso completo `IntegrationRequested` → `IntegrationCompleted` → `Active/Rejected/IntegrationRequested`

Il pattern **BaseTransition** è un esempio eccellente di ingegneria software che dimostra come principi semplici (DRY, KISS) possano produrre soluzioni eleganti dove **18 transizioni** sono implementate con solo **3 linee di codice** ciascuna!

**Stati disponibili:**
1. **Pending** - Stato iniziale in attesa di approvazione
2. **Active** - Utente attivo nel sistema
3. **Inactive** - Utente inattivo
4. **Rejected** - Utente respinto
5. **Suspended** - Utente sospeso
6. **IntegrationRequested** - Richiesta integrazione dati aggiuntivi
7. **IntegrationCompleted** - ⭐ **NUOVO**: Integrazione dati completata dall'utente

**Flusso di Integrazione:**
```
Pending → IntegrationRequested → IntegrationCompleted → Active
```

Questo nuovo flusso permette di separare il completamento dei dati dall'approvazione amministrativa, migliorando il tracking del processo di onboarding e fornendo una migliore UX con stati chiari e distinti.

> **Nota:** La moderazione utenti è ora gestita direttamente tramite il modello User. Vedi [moderation-architettura.md](./moderation-architettura.md)

### Processi

- [Doctor Registration Process](doctor_registration_process.md) - Processo di registrazione dei medici
- [Doctor Registration Workflow](doctor_registration_workflow.md) - Workflow di registrazione dei medici

## Regole Fondamentali

### Moderazione utenti
- La moderazione (stato, approvazione, rifiuto, ecc.) va SEMPRE gestita tramite i campi del modello User (`state`, `type`, `moderation_data`, ecc.) e activitylog.
- **Non introdurre mai un modello UserModeration** a meno di workflow/storicizzazione avanzata (vedi [UserModeration_model_valutazione.md](./UserModeration_model_valutazione.md)).
- Documentare sempre la scelta e motivarla.

### 1. Neutralità della Documentazione

**Perché evitare riferimenti a progetti specifici nei docs dei moduli?**
- I moduli sono pensati per essere riutilizzabili in più progetti
- La documentazione deve essere neutra e generica, senza riferimenti a brand/progetti specifici
- È una best practice open source: facilita il riuso, la condivisione e la manutenzione
- Eventuali riferimenti specifici vanno gestiti solo nella documentazione root del progetto, mai nei singoli moduli

### 2. Struttura Corretta dei Resource Filament

**Percorso corretto:**
- Tutti i resource Filament devono essere collocati sotto `Modules/<Modulo>/app/Filament/Resources/`
- Le Pages devono essere in `Modules/<Modulo>/app/Filament/Resources/*/Pages/`

**Regola:**
- Prima di creare, spostare o modificare resource Filament, verificare sempre il percorso corretto
- Non lasciare mai file di resource, pages o manager direttamente sotto `Modules/<Modulo>/Filament/Resources`

### 3. Ereditarietà dei Modelli

**Regole per l'ereditarietà:**
- I modelli specializzati (es. Doctor, Patient, Studio, ecc.) **devono** estendere il modello BaseModel del modulo di appartenenza (es. `Modules\SaluteOra\Models\BaseModel`), **mai** direttamente `Illuminate\Database\Eloquent\Model`.
- Devono usare sempre il trait `\Parental\HasParent` per il corretto funzionamento dello STI (se applicabile).
- MAI ridichiarare trait già presenti nelle classi genitori (es. HasFactory).
- Tutta la logica comune va nel modello base, mentre i modelli specializzati contengono solo le specificità.

**Motivazione filosofica:**
- Centralizzazione della logica comune (connessione, cast, factory, ecc.)
- Coerenza architetturale tra tutti i moduli
- Facilità di override e personalizzazione
- DRY: nessuna duplicazione di logica tra modelli
- Zen: "Un solo BaseModel per domarli tutti"

**Checklist:**
- [ ] Nessun modello estende direttamente `Model` di Laravel
- [ ] Tutti i modelli estendono il BaseModel del modulo
- [ ] La logica comune è centralizzata
- [ ] La documentazione è aggiornata

## Funzionalità Core

### 1. Anagrafica
- Gestione dati personali
- Storia clinica
- Documenti e allegati
- Consensi e privacy

### 2. Gestione ISEE
- Calcolo fasce di reddito
- Documentazione ISEE
- Storico variazioni
- Notifiche scadenze

### 3. Appuntamenti
- Calendario visite
- Gestione disponibilità
- Notifiche automatiche
- Storico appuntamenti

### 4. Cartella Clinica
- Storia medica
- Allergie e patologie
- Farmaci e terapie
- Note cliniche

### 5. Gestione Disponibilità Dottori
- **Multi-Tenancy**: Disponibilità specifica per studio-dottore
- **OpeningHoursField**: Componente UI per gestione orari settimanali
- **Validazione Avanzata**: Controllo sovrapposizioni e logica business
- **Integrazione Calendar**: Visualizzazione disponibilità nel FullCalendar
- **Audit Trail**: Tracciamento modifiche disponibilità

**Documentazione dettagliata**: [Doctor Availability Management](doctor-availability-management.md)

**Componenti utilizzati**:
- [OpeningHoursField](../UI/docs/components/opening-hours-field.md) - Componente UI per orari
- [DoctorAvailabilityPage](app/Filament/Pages/DoctorAvailabilityPage.php) - Pagina Filament con tenancy

### 6. Regole Architetturali

**⚠️ CRITICO**: Seguire rigorosamente le regole di ereditarietà delle classi XotBase per evitare errori gravi.

**Documentazione obbligatoria**: [XotBase Inheritance Rules](xotbase-inheritance-rules.md)

**Errori gravi da evitare**:
- ❌ Non ridichiarare mai `implements HasForms` su classi che estendono `XotBasePage`
- ❌ Non ridichiarare mai `use InteractsWithForms` su classi che estendono `XotBasePage`
- ❌ Non duplicare trait già presenti nelle classi base

### 7. Errori Critici Risolti

**📋 Tracciamento Errori**: [Critical Errors Resolved](critical-errors-resolved.md)

**Errori identificati e risolti**:
1. **Duplicazione Trait**: DoctorAvailabilityPage con trait duplicati (Dicembre 2024)
2. **Missing $view Property**: OpeningHoursField senza proprietà vista (Dicembre 2024)

**Strumenti di Prevenzione**:
- Checklist di verifica pre-commit
- Comandi di debug per identificazione rapida
- Documentazione dettagliata per ogni risoluzione

## Integrazioni

### Con Modulo Dental
- Condivisione anagrafica
- Storico trattamenti
- Pianificazione cure
- Consensi specifici

### Con Modulo Reporting
- Report statistici
- Analisi demografiche
- KPI paziente
- Export dati

## Architettura

### Models
- `Patient.php`: Modello principale paziente
- `MedicalHistory.php`: Storia clinica
- `Appointment.php`: Gestione appuntamenti
- `IseeData.php`: Dati ISEE

### Services
- `PatientService`: Logica business paziente
- `AppointmentService`: Gestione appuntamenti
- `IseeCalculator`: Calcolo fasce ISEE
- `NotificationService`: Notifiche paziente

## Documentazione Tecnica
- [Namespace vs Struttura File](./namespace-vs-file-structure.md) - **IMPORTANTE**: Differenze tra namespace e struttura fisica dei file
- [Convenzioni](./conventions.md) - Convenzioni di codice specifiche del modulo
- [Value Objects](./value-objects/README.md) - Documentazione sui Value Objects utilizzati
- [Standard](./standards/README.md) - Standard specifici del modulo

## Features UI Avanzate

### Campi Condizionali nei Repeater
Il modulo implementa un pattern avanzato per campi condizionali nei repeater Filament:

- **StudioResource**: Il campo `name` negli indirizzi appare solo quando ci sono più di 1 indirizzo
- **UX Intelligente**: L'interfaccia si adatta dinamicamente al contenuto
- **Pattern Riutilizzabile**: Template standardizzato per altri use case

**Documentazione completa**: [Studio Address Repeater Conditional Name](studio_address_repeater_conditional_name.md)

## Collegamenti Bidirezionali

### Moduli Correlati
- [Modulo Dental](../Dental/docs/README.md) - Integrazione con servizi dentistici
- [Modulo Reporting](../Reporting/docs/README.md) - Generazione report e statistiche
- [Modulo User](../User/docs/README.md) - Gestione utenti e autenticazione

### Documentazione Generale (Xot)
- [📋 Filament Best Practices Xot](../Xot/docs/filament-best-practices.md) - **REGOLE GENERALI**: XotBaseResource e architettura Filament
- [🏗️ Architettura Progetto](../Xot/docs/architecture/struttura-progetto.md) - Struttura generale del progetto

### Regole Globali
- [📋 Regole Cursor XotBaseResource](../../../.cursor/rules/filament-xotbase-resource-best-practices.mdc) - Regole per IDE Cursor
- [📋 Regole Windsurf XotBaseResource](../../../.windsurf/rules/filament-xotbase-resource-best-practices.mdc) - Regole per IDE Windsurf
- [📁 Regole Namespace](../../../.cursor/rules/namespace-structure-rules.mdc) - Regole struttura namespace e directory

## Vedi Anche
- [Documentazione Principale](../../docs/INDEX.md) - Indice generale della documentazione
- [Architettura Moduli](../../docs/architecture/modules-structure.md) - Struttura generale dei moduli
- [Convenzioni di Nomenclatura](../../docs/standards/file_naming_conventions.md) - Standard di nomenclatura dei file
- [Struttura del Progetto](../Xot/docs/architecture/struttura-progetto.md) - Documentazione sulla struttura del progetto

## Supporto
Per supporto tecnico, contattare:
- Email: support@example.com
- Telefono: +39 02 1234567

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
* [README.md](laravel/Modules/Chart/docs/README.md)
* [README.md](laravel/Modules/Reporting/docs/README.md)
* [README.md](laravel/Modules/Gdpr/docs/phpstan/README.md)
* [README.md](laravel/Modules/Gdpr/docs/README.md)
* [README.md](laravel/Modules/Notify/docs/phpstan/README.md)
* [README.md](laravel/Modules/Notify/docs/README.md)
* [README.md](laravel/Modules/Xot/docs/filament/README.md)
* [README.md](laravel/Modules/Xot/docs/phpstan/README.md)
* [README.md](laravel/Modules/Xot/docs/exceptions/README.md)
* [README.md](laravel/Modules/Xot/docs/README.md)
* [README.md](laravel/Modules/Xot/docs/standards/README.md)
* [README.md](laravel/Modules/Xot/docs/conventions/README.md)
* [README.md](laravel/Modules/Xot/docs/development/README.md)
* [README.md](laravel/Modules/Dental/docs/README.md)
* [README.md](laravel/Modules/User/docs/phpstan/README.md)
* [README.md](laravel/Modules/User/docs/README.md)
* [README.md](laravel/Modules/User/resources/views/docs/README.md)
* [README.md](laravel/Modules/UI/docs/phpstan/README.md)
* [README.md](laravel/Modules/UI/docs/README.md)
* [README.md](laravel/Modules/UI/docs/standards/README.md)
* [README.md](laravel/Modules/UI/docs/themes/README.md)
* [README.md](laravel/Modules/UI/docs/components/README.md)
* [README.md](laravel/Modules/Lang/docs/phpstan/README.md)
* [README.md](laravel/Modules/Lang/docs/README.md)
* [README.md](laravel/Modules/Job/docs/phpstan/README.md)
* [README.md](laravel/Modules/Job/docs/README.md)
* [README.md](laravel/Modules/Media/docs/phpstan/README.md)
* [README.md](laravel/Modules/Media/docs/README.md)
* [README.md](laravel/Modules/Tenant/docs/phpstan/README.md)
* [README.md](laravel/Modules/Tenant/docs/README.md)
* [README.md](laravel/Modules/Activity/docs/phpstan/README.md)
* [README.md](laravel/Modules/Activity/docs/README.md)
* [README.md](laravel/Modules/Patient/docs/README.md)
* [README.md](laravel/Modules/Patient/docs/standards/README.md)
* [README.md](laravel/Modules/Patient/docs/value-objects/README.md)
* [README.md](laravel/Modules/Cms/docs/blocks/README.md)
* [README.md](laravel/Modules/Cms/docs/README.md)
* [README.md](laravel/Modules/Cms/docs/standards/README.md)
* [README.md](laravel/Modules/Cms/docs/content/README.md)
* [README.md](laravel/Modules/Cms/docs/frontoffice/README.md)
* [README.md](laravel/Modules/Cms/docs/components/README.md)
* [README.md](laravel/Themes/Two/docs/README.md)
* [README.md](laravel/Themes/One/docs/README.md)

## Novità nella registrazione del dottore

Nel primo step della registrazione (getPersonalInfoStep) vengono ora richiesti i campi:
- **first_name**
- **last_name**
- **email**

Il campo `full_name` è stato rimosso per favorire la normalizzazione dei dati e permettere l'invio email immediato.

Per dettagli e motivazioni vedi:
- [DoctorResource: Step Informazioni Personali](./filament/resources/doctor-resource.md)
- [DoctorRegistrationWorkflow: Step personal_info](./Models/DoctorRegistrationWorkflow.md)

## Resource e Proprietà/Metodi Vietati (XotBaseResource)
- NON dichiarare mai:
  - `protected static ?string $navigationIcon`
  - `protected static ?string $navigationGroup`
  - `protected static ?string $translationPrefix`
  - `public static function table()`
  - `public static function getListTableColumns(): array`
- Motivazione: centralizzazione, DRY, coerenza, override gestito dalla base.
- Vedi anche: [filament-resources.md](filament-resources.md)

## ⚠️ REGOLA CRITICA: getTableColumns() Obbligatorio in ListRecords

**Problema ricorrente (PATTERN SISTEMICO):** `BadMethodCallException: Method getTableColumns does not exist`

**Casi risolti:**
1. ✅ **ListAppointments** → [Fix dettagliato](list_appointments_gettablecolumns_fix.md)
2. ✅ **ListAppointmentWorkflows** → [Fix dettagliato](list_appointment_workflows_gettablecolumns_fix.md)
3. ⚠️ **Prossimi probabili**: ListPatients, ListDoctors, ListStudios, ListTreatments

- Tutte le pagine che estendono `XotBaseListRecords` DEVONO implementare il metodo `getTableColumns()`.
- Il metodo deve restituire un array associativo con chiavi stringa (nome campo).
- Le colonne vanno ricavate dal modello e dalla migrazione, senza inventare campi.
- Le etichette sono gestite solo tramite i file di traduzione del modulo (mai ->label()).
- Badge colorati semantici per stati e tipi.
- **Motivazione:** coerenza, automazione, DRY, compatibilità con TableLayoutEnum e HasXotTable.

**Template obbligatorio:**
```php
public function getTableColumns(): array
{
    return [
        'field_name' => TextColumn::make('field_name')
            ->searchable()
            ->sortable(),
        // ...
    ];
}
```

**Checklist:**
- [ ] Estende XotBaseListRecords?
- [ ] Implementa getTableColumns()?
- [ ] Array associativo con chiavi stringa?
- [ ] Colonne basate sul modello reale?
- [ ] PHPDoc completo?

**Regole correlate:**
- [.cursor/rules/gettablecolumns_mandatory_fix.mdc](../../../.cursor/rules/gettablecolumns_mandatory_fix.mdc)
- [.windsurf/rules/gettablecolumns_mandatory_fix.mdc](../../../.windsurf/rules/gettablecolumns_mandatory_fix.mdc)

## Regola fondamentale: aggiornamento documentazione e XotBaseResource

- Prima di ogni implementazione o modifica, aggiornare sempre la documentazione nelle cartelle docs del modulo coinvolto.
- Chi estende XotBaseResource **non deve mai** dichiarare proprietà statiche custom come $navigationIcon, $navigationGroup, $translationPrefix, table(), getListTableColumns().
- Per la regola generale e la motivazione vedi:
  - [Regole XotBaseResource](../Xot/docs/filament/README.md)
  - [DoctorResource: Step Informazioni Personali](./filament/resources/doctor-resource.md)

## Ereditarietà dei modelli specializzati

- I modelli specializzati (es. Doctor, Patient) **devono** estendere il modello User del modulo Patient, **non** Model o BaseModel.
- Devono usare sempre il trait `\Parental\HasParent` per il corretto funzionamento dello STI (Single Table Inheritance).
- Tutta la logica comune va nel modello User, mentre i modelli specializzati contengono solo le specificità.
- Per dettagli vedi:
  - [Modello Doctor](./Models/Doctor.md)
  - [Regole ereditarietà modelli in Xot](../Xot/docs/standards/README.md)

## Gestione campi e migrazioni con STI

> **Nota importante:**
> Con Single Table Inheritance (STI), **tutti i campi usati dai modelli specializzati devono essere presenti nella tabella base** (`users`).
> Se aggiungi un campo (es. `certifications`), aggiorna la migration della tabella `users` e documenta la modifica.
> Esempio di errore tipico: `Unknown column 'certifications' in 'field list'`.

## Collegamenti
- [Modello Doctor](./Models/Doctor.md)
- [Migrazioni](database/migrations.md)
- [Errori di Validazione](errors/validation.md)
- [Ereditarietà](INHERITANCE_BEST_PRACTICES.md)
- [Struttura progetto](../Xot/docs/architecture/struttura-progetto.md)

---

Per dettagli su ogni processo, consulta le relative sezioni interne. Dopo ogni restart, esegui la checklist sopra per evitare errori ricorrenti.

# AVVISO IMPORTANTE: Regole Fondamentali e Checklist di Ripartenza

> **Prima di ogni sviluppo o dopo ogni riavvio:**
> - Consulta la [checklist di ripartenza](../Xot/docs/checklist-di-ripartenza.md) o la versione locale se presente
> - Applica SEMPRE le [Filament Best Practices](./filament-best-practices.md)
> - Ricorda: nessun riferimento a progetti/brand nelle doc dei moduli
> - Non duplicare mai trait già presenti nei modelli base
> - Usa solo ValidationException::withMessages per errori custom
> - Aggiorna la doc PRIMA di ogni modifica
> - Se trovi un warning o errore, aggiorna subito la doc e segnala la regola

## Collegamenti rapidi
- [Filament Best Practices](./filament-best-practices.md)
- [Neutralità documentazione](../module-documentation-neutrality.md)
- [Ereditarietà modelli](../model-inheritance-best-practices.md)
- [Checklist di ripartenza](../Xot/docs/checklist-di-ripartenza.md)

---

# Patient Module

> **Nota fondamentale:**
> Se stai creando o modificando una Filament Resource che estende XotBaseResource, NON dichiarare mai le proprietà statiche $navigationGroup, $navigationLabel, né il metodo statico table(Table $table): Table. Segui la regola documentata in [filament-best-practices.mdc](./filament-best-practices.mdc).

## Best Practices Filament/XotBaseResource

> **Regola vincolante:** Se una risorsa estende `XotBaseResource`, NON deve mai dichiarare:
> - `protected static ?string $navigationGroup`
> - `protected static ?string $navigationLabel`
> - `public static function table(Table $table): Table`

La configurazione di navigazione e la definizione della tabella sono centralizzate nella classe base o nei provider.

**Checklist:**
- [ ] Nessuna dichiarazione di navigationGroup/navigationLabel/table() nelle risorse che estendono XotBaseResource
- [ ] Configurazione centralizzata e DRY

**Vedi anche:**
- [filament-xotbase-resource-best-practices.mdc](../../../.cursor/rules/filament-xotbase-resource-best-practices.mdc)

# Correzione Namespace e Metodi Vietati nelle Resource Filament

- [2024-05-XX] Corretto il namespace delle risorse Filament da `Modules\\SaluteOra\\App\\Filament\\Resources` a `Modules\\SaluteOra\\Filament\\Resources`.
- Rimossi i metodi `getTableFilters` e `getBulkActions` da tutte le risorse che estendono XotBaseResource, come da regole centrali Xot.
- Vedi anche: [Regole generali Xot](../Xot/docs/README.md)

# Correzioni e Migliorie Post-Unificazione

Dopo l'unificazione dei moduli Patient, Dental e Reporting in SaluteOra, sono necessarie le seguenti correzioni e migliorie trasversali:

## 1. Uniformare Modelli e Enum
- **Priorità:** Altissima
- **Motivazione:** Eliminare duplicazioni, garantire type safety, semplificare la manutenzione.
- **Azioni:**
  - Unificare tutti i modelli utente (User, Doctor, Patient) in un'unica gerarchia STI.
  - Usare solo enum PHP 8.1+ per tutti i tipi, stati, ruoli (vedi [ENUMS_BEST_PRACTICES.md](./ENUMS_BEST_PRACTICES.md)).
  - Aggiornare i cast nei modelli.
- **Impatto:** Riduzione bug, maggiore coerenza tra viste, policies e risorse Filament.

## 2. Refactoring Risorse Filament
- **Priorità:** Alta
- **Motivazione:** Evitare duplicazioni, migliorare la UX, semplificare la navigation.
- **Azioni:**
  - Centralizzare le risorse comuni (pazienti, appuntamenti, trattamenti, report) in SaluteOra.
  - Rimuovere/archiviare le vecchie risorse duplicate.
  - Aggiornare la navigation dinamica in base a UserType/tenancy.
- **Impatto:** Navigazione più chiara, meno errori di permessi, manutenzione facilitata.

## 3. Ottimizzazione Performance e Query
- **Priorità:** Alta
- **Motivazione:** Migliorare tempi di risposta, ridurre carico server, evitare timeout.
- **Azioni:**
  - Applicare tutte le ottimizzazioni documentate in [roadmap/bottlenecks.md](./roadmap/bottlenecks.md): lazy loading, caching, indici DB, batch, lock, streaming file, ricerca full-text.
  - Monitorare i colli di bottiglia con strumenti di profiling.
- **Impatto:** Applicazione più veloce e scalabile.

## 4. Revisione Policies e Permessi
- **Priorità:** Media
- **Motivazione:** Garantire sicurezza e coerenza tra i diversi tipi utente.
- **Azioni:**
  - Unificare le policies per pazienti, dottori, admin.
  - Usare solo UserType enum per i controlli.
  - Aggiornare i test di autorizzazione.
- **Impatto:** Sicurezza rafforzata, meno bug di visibilità.

## 5. Aggiornamento Documentazione e Naming
- **Priorità:** Media
- **Motivazione:** Evitare confusione, facilitare onboarding e manutenzione.
- **Azioni:**
  - Aggiornare tutti i riferimenti a Patient/Dental/Reporting in SaluteOra.
  - Uniformare nomi file, classi, route, translation keys.
  - Aggiornare tutti i README, roadmap, bottlenecks, standards.
- **Impatto:** Documentazione chiara, onboarding più rapido.

## 6. Test e Copertura
- **Priorità:** Alta
- **Motivazione:** Garantire stabilità dopo la fusione.
- **Azioni:**
  - Aggiornare/creare test di integrazione e feature per i flussi critici.
  - Validare edge case di tenancy, permessi, ricerca, upload.
- **Impatto:** Riduzione regressioni, maggiore affidabilità.

## 7. Migliorie UI/UX
- **Priorità:** Media
- **Motivazione:** Migliorare l'esperienza utente e la produttività degli operatori.
- **Azioni:**
  - Uniformare layout, badge, icone, colori, filtri tra le vecchie sezioni.
  - Introdurre feedback visivi per operazioni batch/lente.
- **Impatto:** Interfaccia più moderna e coerente.

## 8. Refactoring Migrazioni e Seeder
- **Priorità:** Media
- **Motivazione:** Evitare dati incoerenti e duplicati.
- **Azioni:**
  - Unificare le migrazioni e i seeder di Patient, Dental, Reporting.
  - Rimuovere tabelle/colonne obsolete.
- **Impatto:** Database più pulito e coerente.

## 9. Aggiornamento Roadmap e Bottlenecks
- **Priorità:** Alta
- **Motivazione:** Tenere traccia delle attività e delle criticità post-unificazione.
- **Azioni:**
  - Aggiornare [roadmap/bottlenecks.md](./roadmap/bottlenecks.md) con i nuovi colli di bottiglia e le soluzioni adottate.
  - Mantenere aggiornata la roadmap delle attività.

---

**Nota:** Tutte le correzioni e migliorie devono essere documentate anche nei file roadmap, standards e README delle sottosezioni tecniche.

---

# Errore Critico: Struttura Cartelle fuori da app/

> **Attenzione:** È stato riscontrato un errore ricorrente: la creazione di cartelle come `Enums`, `Actions`, `Models`, `Providers`, `View` direttamente nella root del modulo anziché in `app/`.
>
> - **Regola vincolante:** Tutti i file PHP devono essere in `app/`.
> - **Causa:** Errata comprensione della mappatura PSR-4 e delle regole Laravel Modules.
> - **Impatto:** Autoloading rotto, namespace incoerenti, problemi di refactoring, test, CI/CD, difficoltà di manutenzione.
> - **Checklist:**
>   - [ ] Prima di creare una cartella/file, verifica che sia sotto `app/`
>   - [ ] Controlla sempre la configurazione PSR-4 in composer.json
>   - [ ] Consulta le regole in [namespace-vs-file-structure.md](./namespace-vs-file-structure.md), [filament-namespace-rules.md](./filament-namespace-rules.md), [WINDSURF_RULES.md](./WINDSURF_RULES.md), [CURSOR_RULES.md](./CURSOR_RULES.md)

---

# Gestione Provider e Autoloading

Quando si sposta, rinomina o elimina un ServiceProvider (es. SaluteOraServiceProvider):
1. **Cerca tutti i riferimenti** al provider nel progetto (`composer.json`, `module.json`, `config/app.php`, ecc.)
2. **Aggiorna o rimuovi** i riferimenti obsoleti
3. **Esegui** `composer dump-autoload`
4. **Verifica** che nessun errore di autoloading si presenti (`php artisan`, `composer diagnose`)
5. **Documenta** la modifica nella doc tecnica e nella changelog del modulo

> **Warning:** Un provider mancante o referenziato erroneamente blocca l'avvio di Laravel e genera errori critici di autoloading.

**Checklist rapida:**
- [ ] Nessun provider referenziato che non esiste più
- [ ] Tutti i riferimenti aggiornati dopo spostamento/rinominamento
- [ ] Autoload Composer aggiornato
- [ ] Test di avvio superati
- [ ] Modifica documentata

Vedi anche: [MIGLIORAMENTI_E_CORREZIONI.md](./MIGLIORAMENTI_E_CORREZIONI.md)

---

## Best practice per le traduzioni

- Non usare chiavi che terminano con `.navigation`, ma usare valori localizzati e descrittivi per `label`, `group`, `icon`.
- Tutte le label, placeholder, help, tooltip, description devono essere presenti nei file lang del modulo.
- Aggiorna sempre la struttura delle traduzioni quando aggiungi nuovi campi o azioni.

### Esempio corretto
```php
'navigation' => [
    'label' => 'Gestione Pazienti',
    'group' => 'Pazienti',
    'icon' => 'heroicon-o-user-group',
    'color' => 'primary',
],
'fields' => [
    'first_name' => [
        'label' => 'Nome',
        'placeholder' => 'Inserisci il nome',
        'helper_text' => 'Nome del paziente',
        'description' => 'Il nome anagrafico del paziente',
        'tooltip' => 'Deve corrispondere al nome sul documento d\'identità'
    ],
    // ...
],
```

- Se trovi chiavi `.navigation`, correggile subito e aggiorna la documentazione.

## ⚠️ Regola fondamentale: MAI usare enum PHP per i campi di stato

- Per tutti i campi che rappresentano uno stato (es. user.state, moderation.state) si usa **solo** [spatie/laravel-model-states](https://github.com/spatie/laravel-model-states).
- Le enum PHP (anche se chiamate UserStateEnum, ecc.) sono ammesse **solo** per tipi statici (es. UserType), **mai** per workflow, moderazione, pubblicazione, ecc.

### Struttura corretta
- La classe principale di stato (es. `UserState`) va in `app/States/UserState.php`.
- Le classi concrete (Pending, Active, ecc.) vanno in `app/States/User/`.
- Se trovi una `UserState` in `app/States/User/UserState.php`, rinominala in `.old`.
- Se trovi enum PHP per i campi di stato, eliminala e aggiorna tutti i riferimenti.

### Esempio ERRATO
```php
// ERRATO
use Modules\SaluteOra\Enums\UserStateEnum;
protected $casts = [ 'state' => UserStateEnum::class ];
```

### Esempio CORRETTO
```php
// CORRETTO
use Modules\SaluteOra\States\UserState;
protected $casts = [ 'state' => UserState::class ];
```

### Checklist operativa
- [ ] Nessun campo di stato usa enum PHP (nemmeno UserStateEnum)
- [ ] La classe principale UserState è in app/States/UserState.php
- [ ] Le classi concrete sono in app/States/User/
- [ ] La mappatura degli stati è completa e aggiornata
- [ ] I valori nel database corrispondono alle chiavi mappate
- [ ] Doc e checklist sempre aggiornate

### Warning
> **Se ricevi errori come `Undefined array key ...` o problemi di cast, controlla subito:**
> - Che non stai usando enum PHP per i campi di stato
> - Che la struttura e la mappatura siano corrette
> - Che i valori nel database siano coerenti

### Link utili
- [Regole generali Xot](../Xot/docs/README.md)
- [Spatie Model States](https://github.com/spatie/laravel-model-states)

## Nota importante: posizione corretta di UserState
- La classe principale `UserState` deve essere in `app/States/UserState.php`.
- Le classi concrete (Pending, Active, ecc.) vanno in `app/States/User/`.
- Se trovi una `UserState` in `app/States/User/UserState.php`, rinominala in `.old` e rimuovila dopo verifica.
- **Motivazione:** coerenza con PSR-4, autoloading, best practice Spatie Model States, chiarezza architetturale.

## StudioResource (Filament)

- Implementata la risorsa Filament per il modello Studio secondo tutte le regole del progetto.
- Estende `Modules\Xot\Filament\Resources\XotBaseResource`.
- Namespace: `Modules\SaluteOra\Filament\Resources`.
- Nessuna proprietà navigationLabel/navigationGroup.
- Nessun uso di `->label()` nei form: tutte le etichette sono gestite tramite il file di traduzione `lang/it/studio.php`.
- Form strutturato in Section, colonne e filtri associativi, relazioni pronte per appointments e doctors.
- Docs consultati: `docs/filament-best-practices.mdc`, `docs/README.md`, `lang/it/studio.php`.
- Policy DRY, KISS, zen, coerenza architetturale.

Vedi anche:
- [filament-best-practices.mdc](./filament-best-practices.mdc)
- [lang/it/studio.php](../lang/it/studio.php)

## Aggiornamento gestione indirizzi Studio

- I campi `address`, `city`, `postal_code` sono stati **rimossi** dal modello e dalla tabella `studios`.
- La gestione degli indirizzi avviene ora tramite relazione morphMany verso il modello `Address` del modulo Geo.
- Ogni Studio può avere più indirizzi (es. sede legale, operativa, ecc.), normalizzati e riusabili secondo Schema.org.
- Motivazione: **riuso, normalizzazione, DRY, policy multi-modulo, zen della semantica**.
- Per dettagli sulla struttura degli indirizzi, vedi la documentazione del modulo Geo.

Esempio di accesso all'indirizzo principale:
```php
$studio->addresses()->where('is_primary', true)->first();
```

Esempio di accesso all'indirizzo completo:
```php
$studio->getFullAddress();
```

Tutte le viste, risorse Filament e API devono ora usare la relazione `addresses` per la gestione degli indirizzi Studio.

### Form Components Custom
- [OpeningHoursField: gestione orari di apertura](form-components/opening-hours-field.md) - Campo custom Filament per orari di apertura, compatibile Spatie/opening-hours, UX avanzata

## Aggiornamento 2025-05-28: Colonne tabella ListStudios

La pagina ListStudios ora implementa correttamente il metodo getTableColumns() secondo la policy Xot (array associativo, chiavi stringa, colonne ricavate dal modello e dalla migrazione). Vedi:
- [Xot/docs/filament/listrecords.md](../../Xot/docs/filament/listrecords.md)
- [SaluteOra/docs/resources/studio-resource.md](./resources/studio-resource.md)

## Widget Filament

### Widget FullCalendar
- [**DoctorAvailabilitiesWidget**](widgets/doctor-availabilities-widget.md) - Gestione disponibilità settimanali dottori
- [**DoctorCalendarWidget**](widgets/doctor-calendar-widget.md) - Calendario appuntamenti per dottori  
- [**PatientCalendarWidget**](widgets/patient-calendar-widget.md) - Calendario sola lettura per pazienti
- [**AdminCalendarWidget**](widgets/admin-calendar-widget.md) - Vista globale per amministratori

### Widget Form e Wizard  
- [**FindDoctorAndAppointmentWidget**](widgets/find-doctor-appointment-widget.md) - Ricerca dottori e prenotazione
- [**PatientRegistrationWizard**](widgets/patient-registration-wizard.md) - Registrazione guidata pazienti

### Widget Overview
- [**StudioOverviewWidget**](widgets/studio-overview-widget.md) - Statistiche e panoramica studio

### Architettura Widget
- [**Indice completo Widget**](widgets/index.md) - Documentazione completa di tutti i widget
- [**HasFullCalendarConfig Trait**](traits/has-full-calendar-config.md) - Configurazioni comuni FullCalendar
- [**Best Practices Widget**](widgets/best-practices.md) - Linee guida per lo sviluppo widget

### Filament

#### Widget

Il modulo implementa diversi widget Filament per le dashboard:

- [**DoctorAvailabilitiesWidget Analysis**](widgets/doctor-availabilities-widget-analysis.md) - **NUOVO**: Analisi completa del widget mancante per gestione disponibilità dottori
- [**Widget Improvements Analysis**](widgets/widget-improvements-analysis.md) - **NUOVO**: Audit e piano miglioramenti per tutti i widget esistenti
- [FindDoctorAndAppointmentWidget](widgets/find-doctor-appointment-widget.md) - Widget wizard per prenotazione appuntamenti pazienti

#### ⚠️ PROBLEMI CRITICI IDENTIFICATI

1. **🔴 DoctorAvailabilitiesWidget MANCANTE**: Referenziato in `doctor-home.json` ma non esiste → **Homepage dottore rotta**
2. **🔴 StudioOverviewWidget NON-COMPLIANT**: Viola pattern Laraxot (estende `Widget` invece di `XotBaseWidget`)

#### Pattern di Eccellenza Trovati

- **DoctorCalendarWidget**: Implementazione perfetta con trait `HasFullCalendarConfig`, multi-tenancy, e security robusta
- **BaseTransition Pattern**: Capolavoro di DRY & KISS per gestione stati

### Policy e Autorizzazioni

Il modulo SaluteOra implementa un sistema completo di autorizzazioni basato su policy che estendono `XotBasePolicy`. Ogni modello ha la sua policy dedicata che gestisce l'accesso e le operazioni CRUD.

#### Policy Implementate

- **[DoctorPolicy](app/Models/Policies/DoctorPolicy.php)** - Gestione autorizzazioni per i medici
- **[AppointmentPolicy](app/Models/Policies/AppointmentPolicy.php)** - Gestione autorizzazioni per gli appuntamenti
- **[StudioPolicy](app/Models/Policies/StudioPolicy.php)** - Gestione autorizzazioni per gli studi medici
- **[PatientPolicy](app/Models/Policies/PatientPolicy.php)** - Gestione autorizzazioni per i pazienti
- **[UserPolicy](app/Models/Policies/UserPolicy.php)** - Gestione autorizzazioni per gli utenti
- **[DoctorStudioPolicy](app/Models/Policies/DoctorStudioPolicy.php)** - Gestione autorizzazioni per le associazioni dottore-studio
- **[ReportPolicy](app/Models/Policies/ReportPolicy.php)** - Gestione autorizzazioni per i report medici

#### Pattern delle Policy

Tutte le policy seguono il pattern standard:

```php
class ModelPolicy extends XotBasePolicy
{
    // Metodi CRUD standard
    public function viewAny(UserContract $user): bool
    public function view(UserContract $user, Model $model): bool
    public function create(UserContract $user): bool
    public function update(UserContract $user, Model $model): bool
    public function delete(UserContract $user, Model $model): bool
    public function restore(UserContract $user, Model $model): bool
    public function forceDelete(UserContract $user, Model $model): bool
    
    // Metodi specifici del dominio
    public function specificAction(UserContract $user, Model $model): bool
}
```

#### Regole di Autorizzazione

1. **Super-Admin**: Accesso completo a tutte le funzionalità
2. **Admin**: Gestione completa dei dati e configurazioni
3. **Staff**: Accesso operativo limitato
4. **Doctor**: Accesso ai propri dati e pazienti
5. **Patient**: Accesso solo ai propri dati

#### Best Practices

- Ogni policy estende `XotBasePolicy` per ereditare il controllo super-admin
- Utilizzo di `UserContract` invece di `User` per type safety
- Controlli basati su ruoli e relazioni tra modelli
- Metodi specifici per azioni di dominio (es. `confirm`, `cancel`, `finalize`)
- Documentazione completa con PHPDoc
