# Documentazione del Modulo Patient - Indice Principale

## Introduzione

Benvenuti nella documentazione completa del modulo Patient. Questo indice fornisce una panoramica di tutti i documenti disponibili, organizzati per categoria.

## Architettura e Struttura

- [Filosofia del Progetto](PHILOSOPHY.md)
- [Struttura del Progetto](architecture/struttura-progetto.md)
- [Architettura Tecnica](architettura-tecnica.md)
- [Roadmap](ROADMAP.md)
- [Convenzioni di Namespace](NAMESPACE_CONVENTIONS.md) - Per comprendere come i namespace influenzano la struttura del progetto.

## Pattern e Best Practices

- [Single Table Inheritance (STI)](SINGLE_TABLE_INHERITANCE.md) - Pattern per l'ereditarietà a tabella singola.
- [Model Inheritance Pattern](MODEL_INHERITANCE_PATTERN.md) - Pattern per l'ereditarietà dei modelli.
- [Data Transfer Objects (DTO)](DATA_TRANSFER_OBJECTS_COMPLETE.md) - Utilizzo dei DTO per il trasferimento dati.
- [Actions Best Practices](ACTIONS_BEST_PRACTICES.md) - Best practices per le azioni.
- [Migrations Best Practices](MIGRATIONS_BEST_PRACTICES.md) - Best practices per le migrazioni.
- [Error Handling Best Practices](ERROR_HANDLING_BEST_PRACTICES.md) - Best practices per la gestione degli errori.
- [Validation Exceptions](VALIDATION_EXCEPTIONS.md) - Gestione delle eccezioni di validazione.
- [Enum Best Practices](Enums/ENUM_BEST_PRACTICES.md) - Best practices per l'utilizzo delle enum.
- [Clean Code](clean-code.md) - Principi di clean code.
- [Inheritance Best Practices](INHERITANCE_BEST_PRACTICES.md) - Linee guida per una corretta implementazione dell'ereditarietà.
- [Model Inheritance](MODEL_INHERITANCE.md) - Detailed guide on model inheritance patterns.
- [Data Transfer Objects](DATA_TRANSFER_OBJECTS.md) - Using DTOs for data transfer.

## Database

- [Database Field Mapping](DATABASE_FIELD_MAPPING.md)
- [Migrations](database/migrations.md)
- [Status Enums](STATUS_ENUMS.md)
- [Migration Best Practices](MIGRATION_BEST_PRACTICES.md) - Approfondimenti sulle migliori pratiche per le migrazioni.

## Modelli

- [Doctor Model](Models/Doctor.md) - Documentazione del modello Doctor.
- [Patient Model](Models/Patient.md) - Documentazione del modello Patient.
- [Doctor Registration Workflow](Models/DoctorRegistrationWorkflow.md) - Workflow di registrazione dei dottori.
- [Patient Management](PATIENT_MANAGEMENT.md) - Managing patient data and interactions.

## Enum

- [Doctor Status](Enums/DoctorStatus.md) - Stati possibili per un dottore.
- [Doctor Registration Status](Enums/DoctorRegistrationStatus.md) - Stati possibili per il workflow di registrazione.
- [Enum Best Practices](Enums/ENUM_BEST_PRACTICES.md) - Best practices per l'utilizzo delle enum.

## Processi

- [Doctor Registration Process](DOCTOR_REGISTRATION_PROCESS.md) - Processo di registrazione dei dottori.
- [Doctor Registration States](doctor-registration-states.md) - Stati del processo di registrazione.
- [Doctor Registration Actions](doctor-registration-actions.md) - Azioni del processo di registrazione.
- [Doctor State Management](doctor-state-management.md) - Gestione degli stati dei dottori.

## Notifiche

- [Email Notifications](notifications/EMAIL_NOTIFICATIONS.md) - Notifiche email.
- [Notification Templates](notifications/NOTIFICATION_TEMPLATES.md) - Modelli di notifica.

## Filament

- [Filament Label Translation System](FILAMENT_LABEL_TRANSLATION_SYSTEM.md) - Sistema di traduzione delle etichette in Filament.
- [Filament Resources Implementation](FILAMENT_RESOURCES_IMPLEMENTATION.md) - Implementazione delle risorse Filament.
- [Filament Directory Structure](filament-directory-structure.md) - Struttura delle directory per Filament.
- [Filament Customization](FILAMENT_CUSTOMIZATION.md) - Personalizzazione di Filament.
- [XotBaseResource Usage](XOT_BASE_RESOURCE_USAGE.md) - Utilizzo della classe XotBaseResource.
- [Filament Components API](filament-components-api.md)
- [Filament Form Components](filament-form-components.md)
- [Filament Tabs Components](filament-tabs-components.md)
- [Filament Form Schema Rules](filament-form-schema-rules.md)
- [Filament Namespace Rules](filament-namespace-rules.md)
- [Filament Resources](filament-resources.md)
- [Filament Customization](FILAMENT_CUSTOMIZATION.md) - Personalizzazioni specifiche per Filament.
- [Filament Best Practices](FILAMENT_BEST_PRACTICES.md) - Best practices for using Filament in modular projects.
- [filament-best-practices.mdc](./filament-best-practices.mdc) — **Regola fondamentale:** chi estende XotBaseResource NON deve dichiarare $navigationGroup, $navigationLabel, né il metodo statico table(Table $table): Table. Seguire sempre questa regola per evitare errori di override e garantire coerenza tra i moduli.

## Errori Comuni e Soluzioni

- [Undefined Method Can](errors/undefined-method-can.md)
- [Undefined Type Pending](errors/undefined-type-pending.md)
- [Undefined Type SpatieEmail](errors/undefined-type-spatieemail.md)
- [Undefined Type Tenant](errors/undefined-type-tenant.md)
- [Errore Form Schema Widget Doctor](errore-form-schema-widget-doctor.md)
- [Filament Error FileUpload ButtonLabel](filament-error-fileupload-buttonlabel.md)
- [Filament Error FileUpload Icon](filament-error-fileupload-icon.md)
- [Filament Error FileUpload PrefixIcon](filament-error-fileupload-prefixicon.md)
- [Filament Error Tab Description](filament-error-tab-description.md)
- [Validation Errors](VALIDATION_ERRORS.md) - Approfondimenti sugli errori di validazione.

## Convenzioni e Standard

- [Convenzioni](conventions.md)
- [Filament Wizard Step Naming](filament/wizard-step-naming.md)
- [Filament Label Translation System](filament/label-translation-system.md)
- [Clean Code Wizard Steps](clean-code-wizard-steps.md)
- [Wizard Schema Separation](clean-code/wizard-schema-separation.md)

## API e Integrazione

- [API](api.md)
- [Doctor Email Templates](doctor-email-templates.md)
- [API Security](API_SECURITY.md) - Security measures for API endpoints.

## Guida Rapida alla Risoluzione dei Problemi

### Problemi di Validazione

Se riscontri errori di validazione come `Call to undefined method Illuminate\Support\MessageBag::errors()`, consulta:
- [Validation Exceptions](VALIDATION_EXCEPTIONS.md)
- [Error Handling Best Practices](ERROR_HANDLING_BEST_PRACTICES.md)

### Problemi con Single Table Inheritance

Se riscontri errori relativi all'ereditarietà dei modelli, consulta:
- [Single Table Inheritance (STI)](SINGLE_TABLE_INHERITANCE.md)
- [Model Inheritance Pattern](MODEL_INHERITANCE_PATTERN.md)

### Problemi con Enum

Se riscontri errori relativi agli enum, consulta:
- [Enums Best Practices](ENUMS_BEST_PRACTICES.md)
- [Status Enums](STATUS_ENUMS.md)

### Problemi con Filament

Se riscontri errori relativi a Filament, consulta:
- [Filament Label Translation System](FILAMENT_LABEL_TRANSLATION_SYSTEM.md)
- [Filament Resources Implementation](FILAMENT_RESOURCES_IMPLEMENTATION.md)
- [Filament Form Schema Rules](filament-form-schema-rules.md)

### Problemi con le Migrazioni

Se riscontri errori relativi alle migrazioni, consulta:
- [Migrations Best Practices](MIGRATIONS_BEST_PRACTICES.md)
- [Database Field Mapping](DATABASE_FIELD_MAPPING.md)

## Traduzioni

- [Translations](TRANSLATIONS.md) - Sistema di traduzione del modulo.
- [Translation Keys](TRANSLATION_KEYS.md) - Chiavi di traduzione utilizzate nel modulo.
- [Translation System](TRANSLATION_SYSTEM.md) - Architettura del sistema di traduzione.
- [Translation Workflow](TRANSLATION_WORKFLOW.md) - Flusso di lavoro per la gestione delle traduzioni.
- [Translation Best Practices](TRANSLATION_BEST_PRACTICES.md) - Best practices per le traduzioni.
- [URL Localization](URL_LOCALIZATION.md) - Linee guida per la localizzazione degli URL.

## API

- [API Overview](API_OVERVIEW.md) - Panoramica delle API del modulo.
- [API Authentication](API_AUTHENTICATION.md) - Autenticazione per le API.
- [API Endpoints](API_ENDPOINTS.md) - Endpoints disponibili.
- [API Versioning](API_VERSIONING.md) - Gestione delle versioni delle API.
- [API Documentation](API_DOCUMENTATION.md) - Documentazione completa delle API.

## Testing

- [Testing Overview](TESTING_OVERVIEW.md) - Panoramica dei test del modulo.
- [Unit Testing](UNIT_TESTING.md) - Test unitari.
- [Feature Testing](FEATURE_TESTING.md) - Test delle funzionalità.
- [Integration Testing](INTEGRATION_TESTING.md) - Test di integrazione.
- [End-to-End Testing](END_TO_END_TESTING.md) - Test end-to-end.

## Deployment

- [Deployment Overview](DEPLOYMENT_OVERVIEW.md) - Panoramica del deployment.
- [Deployment Process](DEPLOYMENT_PROCESS.md) - Processo di deployment.
- [Deployment Environments](DEPLOYMENT_ENVIRONMENTS.md) - Ambienti di deployment.
- [Deployment Checklist](DEPLOYMENT_CHECKLIST.md) - Checklist per il deployment.
- [Deployment Rollback](DEPLOYMENT_ROLLBACK.md) - Procedura di rollback.

## Riferimenti

- [Migrations Best Practices](MIGRATIONS_BEST_PRACTICES.md) - Best practices per le migrazioni.
- [Database Field Mapping](DATABASE_FIELD_MAPPING.md) - Mappatura dei campi del database.
- [Enum Best Practices](Enums/ENUM_BEST_PRACTICES.md) - Best practices per l'utilizzo delle enum.
- [Model Inheritance Best Practices](MODEL_INHERITANCE_PATTERN.md) - Best practices per l'ereditarietà dei modelli.
- [Notification Templates](notifications/NOTIFICATION_TEMPLATES.md) - Modelli di notifica.

## Come Contribuire alla Documentazione

Per contribuire alla documentazione del modulo Patient, seguire queste linee guida:

1. Creare un nuovo file Markdown nella directory appropriata
2. Seguire le convenzioni di naming esistenti
3. Aggiungere il nuovo file all'indice principale
4. Aggiungere collegamenti bidirezionali ad altri documenti correlati (almeno 5)
5. Aggiungere una breve descrizione del documento
6. Aggiungere una sezione "Collegamenti correlati" alla fine del documento
7. Assicurarsi che il documento sia generico e riutilizzabile
8. Evitare riferimenti specifici al progetto
9. Inviare una pull request con le modifiche

## Convenzioni di Stile della Documentazione

- Utilizza titoli di primo livello (`#`) per il titolo del documento
- Utilizza titoli di secondo livello (`##`) per le sezioni principali
- Utilizza titoli di terzo livello (`###`) per le sottosezioni
- Utilizza elenchi puntati (`-`) per gli elenchi non ordinati
- Utilizza elenchi numerati (`1.`) per gli elenchi ordinati o le istruzioni sequenziali
- Utilizza blocchi di codice con evidenziazione della sintassi per gli esempi di codice
- Utilizza emoji ✅ e ❌ per indicare esempi corretti ed errati
- Includi una sezione "Errori Comuni e Come Evitarli" quando appropriato
- Includi una sezione "Conclusione" alla fine del documento

## Conclusione

Questa documentazione è in continua evoluzione. Se trovi aree che necessitano di miglioramento o hai suggerimenti, non esitare a contribuire. L'obiettivo è fornire una risorsa completa e aggiornata per tutti gli sviluppatori che lavorano con questo modulo.

## Performance Optimization

- [Performance Optimization](PERFORMANCE_OPTIMIZATION.md) - Techniques for optimizing module performance.

## Analisi e Scelte Architetturali
- [UserModeration_model_valutazione.md](./UserModeration_model_valutazione.md) — **Analisi: perché NON introdurre UserModeration**. Tutta la moderazione va gestita tramite i campi di User e activitylog. Vedi documento per motivazione e casi limite.

## Best Practices Filament/XotBaseResource

> **Regola vincolante:** Se una risorsa estende `XotBaseResource`, NON deve mai dichiarare:
> - `protected static ?string $navigationGroup`
> - `protected static ?string $navigationLabel`
> - `public static function table(Table $table): Table`

La configurazione di navigazione e la definizione della tabella sono centralizzate nella classe base o nei provider.

**Checklist:**
- [ ] Nessuna dichiarazione di navigationGroup/navigationLabel/table() nelle risorse che estendono XotBaseResource
- [ ] Configurazione centralizzata e DRY
- [ ] **Moderazione SEMPRE su User, mai su UserModeration** (vedi [UserModeration_model_valutazione.md](./UserModeration_model_valutazione.md))

## Moderazione Utenti

La moderazione utenti è ora gestita direttamente tramite il modello User. Per motivazione e dettagli architetturali vedi [moderation-architettura.md](./moderation-architettura.md)
