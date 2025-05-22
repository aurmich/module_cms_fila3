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

- [Indice Completo](INDEX.md) - Panoramica di tutta la documentazione disponibile

### Architettura e Pattern

- [Single Table Inheritance](SINGLE_TABLE_INHERITANCE.md) - Pattern STI per i modelli utente
- [Best Practices per l'Ereditarietà](INHERITANCE_BEST_PRACTICES.md) - Linee guida per l'ereditarietà delle classi
- [Model Inheritance Pattern](MODEL_INHERITANCE_PATTERN.md) - Pattern di ereditarietà per i modelli

### Best Practices

- [Actions Best Practices](ACTIONS_BEST_PRACTICES.md) - Linee guida per le Actions
- [Data Transfer Objects](DATA_TRANSFER_OBJECTS_COMPLETE.md) - Implementazione e utilizzo dei DTO
- [Migrations Best Practices](MIGRATIONS_BEST_PRACTICES.md) - Linee guida per le migrazioni
- [Error Handling Best Practices](ERROR_HANDLING_BEST_PRACTICES.md) - Gestione degli errori
- [Enums Best Practices](ENUMS_BEST_PRACTICES.md) - Utilizzo degli enum in PHP 8.2+

### Filament

- [Filament Label Translation System](FILAMENT_LABEL_TRANSLATION_SYSTEM.md) - Sistema di traduzione delle etichette
- [Filament Resources Implementation](FILAMENT_RESOURCES_IMPLEMENTATION.md) - Implementazione dei resource

### Modelli

- [Doctor](Models/Doctor.md) - Documentazione del modello Doctor
- [User](Models/User.md) - Documentazione del modello User
- [DoctorRegistrationWorkflow](Models/DoctorRegistrationWorkflow.md) - Workflow di registrazione dei medici

> **Nota:** La moderazione utenti è ora gestita direttamente tramite il modello User. Vedi [moderation-architettura.md](./moderation-architettura.md)

### Processi

- [Doctor Registration Process](DOCTOR_REGISTRATION_PROCESS.md) - Processo di registrazione dei medici
- [Doctor Registration Workflow](DOCTOR_REGISTRATION_WORKFLOW.md) - Workflow di registrazione dei medici

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
- I modelli specializzati (es. Doctor, Patient) **devono** estendere il modello User del modulo Patient
- Devono usare sempre il trait `\Parental\HasParent` per il corretto funzionamento dello STI
- MAI ridichiarare trait già presenti nelle classi genitori (es. HasFactory)
- Tutta la logica comune va nel modello User, mentre i modelli specializzati contengono solo le specificità

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

## Collegamenti Bidirezionali
- [Modulo Dental](../Dental/docs/README.md) - Integrazione con servizi dentistici
- [Modulo Reporting](../Reporting/docs/README.md) - Generazione report e statistiche
- [Modulo User](../User/docs/README.md) - Gestione utenti e autenticazione

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
- [DoctorResource: Step Informazioni Personali](./filament/resources/doctor-resource.md)
- [Standard Xot: Ereditarietà dei Modelli](../Xot/docs/standards/README.md)
- [Struttura progetto e STI](./architecture/struttura-progetto.md)
- [Migrazioni e database](./database/migrations.md)

# Errori di Validazione Custom

Per restituire errori custom nei form, usa sempre:

```php
throw \Illuminate\Validation\ValidationException::withMessages([
    'campo' => ['Messaggio di errore personalizzato.'],
]);
```

Vedi dettagli in [errors/validation.md](./errors/validation.md)

# Regola: Non duplicare trait già presenti nei modelli base

Se un trait (es. HasFactory) è già presente in un modello base (es. BaseUser), **non aggiungerlo** nei modelli che lo estendono (es. User, Doctor, Patient).

Motivazione: evitare ridondanza, warning, confusione e problemi di override.

## Checklist di Ripartenza (dopo restart)
- Verifica che tutte le migration siano applicate (`users` aggiornata per STI)
- Controlla che i trait NON siano duplicati nei modelli specializzati
- Verifica la catena di ereditarietà: Doctor → User → BaseUser
- Controlla che le ValidationException usino sempre `withMessages`
- Assicurati che la documentazione sia aggiornata e neutra
- Controlla i file chiave:
  - [Doctor.php](app/Models/Doctor.php)
  - [User.php](app/Models/User.php)
  - [BaseUser.php](../User/app/Models/BaseUser.php)
  - [DoctorResource.php](app/Filament/Resources/DoctorResource.php)
  - [RegisterAction.php](app/Actions/RegisterAction.php)
  - [RegistrationWidget.php](../User/app/Filament/Widgets/RegistrationWidget.php)
  - [UserType.php](app/Enums/UserType.php)
  - [UserState.php](app/Enums/UserState.php)
- Consulta le sezioni:
  - [Modello Doctor](Models/Doctor.md)
  - [Errori di Validazione](errors/validation.md)
  - [Migrazioni e STI](database/migrations.md)
  - [Best Practices](ACTIONS_BEST_PRACTICES.md)
  - [Ereditarietà](INHERITANCE_BEST_PRACTICES.md)
  - [Analisi UserModeration](UserModeration_model_valutazione.md)

## Regole Fondamentali
- Documentazione sempre neutra
- Mai duplicare trait già presenti nei modelli base
- Usare sempre il trait HasParent per STI
- Validazione custom solo con ValidationException::withMessages
- Aggiornare sempre la doc PRIMA di ogni modifica

## Collegamenti
- [Modello Doctor](Models/Doctor.md)
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

## ⚠️ Regola fondamentale: Mai usare ->label() nei componenti Filament

- Tutte le label, placeholder, help, tooltip, description devono essere gestite tramite i file di traduzione del modulo, mai tramite `->label()`.
- Il LangServiceProvider intercetta automaticamente le label tramite la struttura delle chiavi di traduzione.
- Consulta anche:
  - [Regole traduzioni Filament](../../Lang/docs/filament-translations.md)
  - [Regole generali Xot](../../Xot/docs/README.md)

### Checklist revisione codice
- [ ] Nessun uso di `->label()` nei componenti Filament
- [ ] Tutte le label sono gestite tramite i file di traduzione
- [ ] Namespace corretti (Modules\<NomeModulo>\Filament)
- [ ] Nessuna estensione diretta di classi Filament

# Errori comuni: path e namespace

- Tutti i file PHP devono essere in `app/` (es: `app/Enums/UserType.php`, `app/Filament/Resources/UserResource.php`)
- Il namespace non deve mai contenere `App` (es: `Modules\SaluteOra\Enums\UserType`)
- La struttura fisica e quella logica devono essere coerenti, ma la root del codice è sempre `app/`
- Se trovi file o namespace errati, correggi subito e aggiorna la doc
- Vedi anche: [Regole generali Xot](../Xot/docs/README.md)

## Checklist di Ripartenza (dopo restart)
- Verifica che tutte le migration siano applicate (`users` aggiornata per STI)
- Controlla che i trait NON siano duplicati nei modelli specializzati
- Verifica la catena di ereditarietà: Doctor → User → BaseUser
- Controlla che le ValidationException usino sempre `withMessages`
- Assicurati che la documentazione sia aggiornata e neutra
- Controlla i file chiave:
  - [Doctor.php](app/Models/Doctor.php)
  - [User.php](app/Models/User.php)
  - [BaseUser.php](../User/app/Models/BaseUser.php)
  - [DoctorResource.php](app/Filament/Resources/DoctorResource.php)
  - [RegisterAction.php](app/Actions/RegisterAction.php)
  - [RegistrationWidget.php](../User/app/Filament/Widgets/RegistrationWidget.php)
  - [UserType.php](app/Enums/UserType.php)
  - [UserState.php](app/Enums/UserState.php)
- Consulta le sezioni:
  - [Modello Doctor](Models/Doctor.md)
  - [Errori di Validazione](errors/validation.md)
  - [Migrazioni e STI](database/migrations.md)
  - [Best Practices](ACTIONS_BEST_PRACTICES.md)
  - [Ereditarietà](INHERITANCE_BEST_PRACTICES.md)
  - [Analisi UserModeration](UserModeration_model_valutazione.md)

## [2024-05-XX] Correzione risorse Filament: rispetto regole XotBaseResource
- Rimossi da UserResource e ListUsers tutte le proprietà/metodi vietati: navigationIcon, table, getTableFilters, getBulkActions, ecc.
- Le select usano ora direttamente gli enum (UserType::toSelectArray, UserState::toSelectArray)
- Vedi anche: [Regole generali Xot](../Xot/docs/README.md)

## Regola: Icone SVG custom per navigation.icon
- Le icone SVG custom vanno salvate in `resources/svg/` del modulo, con nome `<modulo>-<icona>.svg` (es. `saluteora-doctor.svg`).
- In navigation.icon dei file di traduzione si usa l'identificatore `<modulo>-<icona>` (es. `'icon' => 'saluteora-doctor'`).
- Gli array vanno sempre in short syntax (`[]`).
- Tutti i file PHP devono iniziare con `declare(strict_types=1);`.
- Esempio:
```php
<?php
declare(strict_types=1);
return [
    'navigation' => [
        'icon' => 'saluteora-doctor',
        // ...
    ],
];
```
- Vedi anche: [Regole generali Xot](../Xot/docs/README.md)

- [2024-05-XX] Corretto: ListDoctorAvailabilities ora estende XotBaseListRecords (non più ListRecords). Vedi anche: [Regole generali Xot](../Xot/docs/README.md)

## Regola fondamentale: Stati e workflow con Spatie Model States
- Tutti i campi che rappresentano uno stato (es. user.state, moderation.state) devono usare [spatie/laravel-model-states](https://github.com/spatie/laravel-model-states), **non** enum PHP native.
- Le enum PHP sono ammesse solo per tipi statici (es. UserType), **mai** per workflow, moderazione, pubblicazione, ecc.

### Motivazione
- Gestione delle transizioni tra stati (solo quelle consentite)
- Logica custom per ogni stato (side effect, permessi, validazione)
- Integrazione con Eloquent (cast automatico, query, observer)
- Eventi sulle transizioni
- Best practice per workflow e moderazione

### Esempio pratico
```php
// ERRATO
use Modules\SaluteOra\Enums\UserStateEnum;
protected $casts = [ 'state' => UserState::class ];

// CORRETTO
use Modules\SaluteOra\States\UserState;
protected $casts = [ 'state' => UserState::class ];

// State class
class UserState extends State { ... }
```

### Checklist
- [ ] Nessun campo di stato usa enum PHP
- [ ] Tutti i campi di stato usano Spatie Model States
- [ ] Modelli, risorse, form, policy aggiornati
- [ ] Doc aggiornata

### Errori comuni
- Usare enum PHP per i campi di stato
- Dimenticare di configurare le transizioni
- Non aggiornare la doc

### Link doc
- [Regole generali Xot](../Xot/docs/README.md)
- [Spatie Model States](https://github.com/spatie/laravel-model-states)

# Errori comuni: Model States (Spatie)

## Esempio reale di errore
```
Undefined array key "Modules\SaluteOra\States\User\Pending"
```
- Stack trace: Spatie\ModelStates\StateCaster::get
- Tipico durante login o istanziazione User

## Cause tipiche
- Uso di enum PHP per il campo di stato (es. UserState)
- Mappatura degli stati incompleta o errata
- Namespace delle classi di stato errato o classi mancanti
- Valori nel database che non corrispondono alle chiavi mappate

## Soluzione passo-passo
1. **Elimina ogni uso di enum PHP per i campi di stato** (UserState, ecc.)
2. **Crea la classe UserState** in Modules\SaluteOra\States\UserState che estende Spatie\ModelStates\State
3. **Crea tutte le classi di stato concrete** (Pending, Active, ecc.) in Modules\SaluteOra\States\User\
4. **Configura la mappatura degli stati** in UserState:
   ```php
   public static $states = [
       'pending' => \Modules\SaluteOra\States\User\Pending::class,
       'active' => \Modules\SaluteOra\States\User\Active::class,
       // ...
   ];
   ```
5. **Aggiorna il modello User**:
   ```php
   use Modules\SaluteOra\States\UserState;
   protected $casts = [ 'state' => UserState::class ];
   ```
6. **Verifica i valori nel database**: tutti i valori in users.state devono essere tra le chiavi mappate (es. "pending", "active", ecc.)

## Checklist di debug
- [ ] Nessun campo di stato usa enum PHP
- [ ] Tutte le classi di stato esistono e sono nel namespace corretto
- [ ] La mappatura degli stati è completa
- [ ] I valori nel database corrispondono alle chiavi mappate
- [ ] Doc aggiornata

## Link utili
- [Regole generali Xot](../Xot/docs/README.md)
- [Spatie Model States](https://github.com/spatie/laravel-model-states)

## Nota importante: posizione corretta di UserState
- La classe principale `UserState` deve essere in `app/States/UserState.php`.
- Le classi concrete (Pending, Active, ecc.) vanno in `app/States/User/`.
- Se trovi una `UserState` in `app/States/User/UserState.php`, rinominala in `.old` e rimuovila dopo verifica.
- **Motivazione:** coerenza con PSR-4, autoloading, best practice Spatie Model States, chiarezza architetturale.

