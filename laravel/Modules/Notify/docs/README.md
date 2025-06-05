# Modulo Notify

## Panoramica
Il modulo Notify gestisce il sistema di notifiche dell'applicazione, inclusi template e-mail e gestione dei canali di comunicazione.

## Struttura
Il modulo Notify gestisce tutte le notifiche del sistema, inclusi:
- Email
- SMS
- Notifiche push
- Notifiche in-app
- Notifiche WhatsApp
- Notifiche Telegram

## Documentazione

### Core
- [Struttura del Modulo](./structure.md)
- [Eventi](./events.md)
- [Template](./templates.md)
- [Migrations](./migrations.md)
- [Traduzioni](./translations.md)

### Modelli
- [BaseModel](./base-model.md)
- [Modelli](./models.md)
- [Modifiche Modello MailTemplate](./MODEL_CHANGES.md)
- [Documentazione Tecnica MailTemplate](./mail-templates/MODEL_MAIL_TEMPLATE_CHANGES.md)

### Filament
- [Risorse](./filament-resources.md)
- [Pagine](./filament-pages.md)
- [Miglioramenti UI/UX](./mail-templates/FILAMENT_UI_ENHANCEMENTS.md)
- [Analisi Title With Slug](./mail-templates/TITLE_WITH_SLUG_ANALYSIS.md)
- [Generazione Slug](./mail-templates/FILAMENT_SLUG_GENERATION.md)

### Email
- [Sistema Email](./database-mail-system.md)
- [Code Email](./database-mail-queue.md)
- [Template Email](./improved-email-templates.md)
- [Guida all'utilizzo di SpatieEmail](./SPATIE_EMAIL_USAGE_GUIDE.md)
- [Guida alla Migrazione MailTemplate](./MAIL_TEMPLATE_MIGRATION_GUIDE.md)
- [Struttura della Migrazione](./mail-templates/MIGRATION_STRUCTURE.md)
- [Implementazione Campo Slug](./mail-templates/SLUG_FIELD_IMPLEMENTATION.md)
- [Implementazione Modello con Slug](./mail-templates/MODEL_SLUG_IMPLEMENTATION.md)
- [Implementazione Risorsa con Slug](./mail-templates/RESOURCE_SLUG_IMPLEMENTATION.md)
- [Editor WYSIWYG](./email-wysiwyg-editor.md)
- [Test Email](./email-tests.md)
- [Log Email](./email-logs.md)
- [Monitoraggio Email](./email-monitoring.md)
- [Backup Email](./email-backup.md)
- [Cache Email](./email-cache.md)
- [Analytics Email](./email-analytics.md)
- [Traduzioni Email](./email-translations.md)

### Editor
- [GrapesJS](./grapesjs.md)
- [GrapesJS Filament](./grapesjs-filament.md)
- [GrapesJS Enhancement](./grapesjs-enhancement.md)
- [Test Editor](./email-wysiwyg-editor-tests.md)

### Canali
- [WhatsApp](./whatsapp.md)
- [Telegram](./telegram.md)
- [SMS](./sms.md)
- [Push](./send_push_notification_conflict_resolution.md)

### Errori
- [Error Mailer](./error-mailer.md)
- [Conflitti Git](./conflitti_git.md)
- [PHPStan](./phpstan-usage.md)
- [PHPStan Level 10](./phpstan_level10_fixes.md)

### Analisi
- [Analisi Plugin](./email-plugins-analysis.md)
- [Schema Conventions](./schema_conventions.md)
- [Roadmap](./roadmap.md)
- [Packages](./packages.md)

### Changelog e Migrazioni
- [Changelog Migrazioni](./MIGRATIONS_CHANGELOG.md)

### Best Practices
- [Best Practices Email](./EMAIL_BEST_PRACTICES.md)
- [Gestione Errori](./ERROR_HANDLING.md)

### Migrazioni
- [Struttura Migrazioni](./migrations.md)
- [Gestione Conversioni JSON](./mail-templates/MIGRATION_JSON_CONVERSION.md)

## Collegamenti Bidirezionali

### Collegamenti nella Root
- [Architettura dei Moduli](../../../../docs/architecture/modules.md)
- [Gestione Notifiche](../../../../docs/architecture/notifications.md)

### Collegamenti ai Moduli
- [XotBaseModel](../../Xot/docs/XotBaseModel.md)
- [XotBaseResource](../../Xot/docs/XotBaseResource.md)
- [XotBaseServiceProvider](../../Xot/docs/XotBaseServiceProvider.md)

## Note Importanti

1. Estendere sempre le classi base appropriate
2. Non sovrascrivere metodi se non necessario
3. Mantenere la documentazione tecnica aggiornata
4. Seguire le convenzioni di namespace
5. Utilizzare i file di traduzione per le label
- [Regole sulle migration e detection colonne](./MIGRATION_RULES.md)
3. Mantenere la documentazione aggiornata
4. Seguire le convenzioni di namespace
5. Utilizzare i file di traduzione per le label

## Vedi Anche
- [Modulo Notify](./module_notify.md)
- [Notifiche Appuntamenti](./appointment-notifications.md)
- [Test SMTP](./test_smtp.md)
- [Login](./login.md)
- [Firebase](./firebase.md)

## Collegamenti Esterni
- [Laravel Notifications](https://laravel.com/docs/notifications)
- [Filament Documentation](https://filamentphp.com/docs)
- [GrapesJS Documentation](https://grapesjs.com/docs/)
- [WhatsApp Business API](https://developers.facebook.com/docs/whatsapp/cloud-api)
- [Telegram Bot API](https://core.telegram.org/bots/api)

## Collegamenti Principali

### Documentazione Core
- [Struttura del Modulo](./structure.md)
- [Rotte Web](./structure.md#rotte-web)
- [Canali Notifica](./channels.md)
- [Template](./templates.md)
- [Eventi](./events.md)
- [Best Practices](./BEST-PRACTICES.md)

### Integrazioni
- [Integrazione con User](../User/docs/README.md)
- [Integrazione con Xot](../Xot/docs/README.md)
- [Integrazione con Lang](../Lang/docs/README.md)

### Best Practices
- [Convenzioni Notifiche](./notification-conventions.md)
- [Gestione Template](./template-management.md)
- [PHPStan Fixes](./phpstan-fixes.md)

### Testing e Qualità
- [PHPStan Level 9](./PHPSTAN_LEVEL9_FIXES.md)
- [PHPStan Level 10](./PHPSTAN_LEVEL10_FIXES.md)
- [Testing Best Practices](./testing-best-practices.md)

## Struttura del Modulo

```
Notify/
├── app/
│   ├── Models/
│   │   ├── BaseModel.php
│   │   └── NotificationTemplate.php
│   ├── Filament/
│   │   └── Resources/
│   └── Providers/
├── docs/
├── config/
├── resources/
│   └── lang/
└── routes/
```

## Funzionalità Principali
- Gestione template e-mail
- Sistema di notifiche multilingua
- Integrazione con GrapesJS per editor visuale
- Supporto multi-tenant

## Collegamenti alla Documentazione
- [Architettura Modulare](../../../docs/architecture/MODULE_STRUCTURE.md)
- [Convenzioni di Sviluppo](../../../docs/development/CONVENTIONS.md)
- [Gestione dei Conflitti](../../../docs/development/CONFLICT_RESOLUTION.md)

## Best Practices
1. Utilizzare sempre BaseModel come base per i modelli
2. Implementare le traduzioni tramite LangServiceProvider
3. Documentare ogni modifica importante
4. Mantenere i collegamenti bidirezionali con la documentazione principale

## Note di Implementazione
- Il modulo è in fase di aggiornamento per Laravel 12
- In corso l'implementazione di best practices per le traduzioni
- Integrazione in corso con GrapesJS per l'editor visuale
### 1. Template
- Utilizzare Blade per email
- Mantenere SMS concisi
- Supportare multilingua
- Gestire variabili

### 2. Canali
```php
// ❌ NON FARE QUESTO
$user->notify(new WelcomeNotification());

// ✅ FARE QUESTO
Notify::send($user, new WelcomeNotification(), ['mail', 'sms']);
```

### 3. Eventi
```php
// ❌ NON FARE QUESTO
event(new UserRegistered($user));

// ✅ FARE QUESTO
Notify::event('user.registered', $user);
```

## Dipendenze Principali

### Moduli
- **User**: Destinatari notifiche
- **Xot**: Notifiche base
- **Lang**: Traduzioni notifiche

### Pacchetti
- Laravel Framework
- Filament
- Livewire
- Mailgun
- Twilio

## Roadmap

### Prossime Feature
1. Nuovi canali notifica
2. Miglioramento template
3. Ottimizzazione invio

### Miglioramenti Pianificati
1. Refactoring notifiche
2. Miglioramento UI
3. Ottimizzazione performance

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
1. Notifiche non inviate
2. Template non trovati
3. Errori di configurazione

### Soluzioni
1. Verifica configurazione
2. Controlla log
3. Consulta documentazione

## Riferimenti

### Documentazione
- [Laravel Notifications](https://laravel.com/docs/12.x/notifications)
- [Filament](https://filamentphp.com/docs)
- [Mailgun](https://documentation.mailgun.com)
- [Twilio](https://www.twilio.com/docs)

### Collegamenti Interni
- [User Module](../User/docs/README.md)
- [Xot Module](../Xot/docs/README.md)
- [Lang Module](../Lang/docs/README.md)

## Changelog

### [1.0.0] - 2024-03-20
#### Added
- Implementazione iniziale
- Sistema notifiche
- Template base
- Canali multipli

#### Changed
- Miglioramento performance
- Ottimizzazione invio
- Refactoring codice

#### Fixed
- Bug notifiche
- Problemi template
- Errori configurazione 

### Versione Incoming

> **Nota architetturale**: In <nome progetto> non si utilizzano classi Service custom. Tutte le azioni asincrone e la business logic riutilizzabile devono essere implementate come Queueable Actions tramite il package spatie/laravel-queueable-action.
> Vedi [Queueable Actions con Spatie](queueable-actions.md) per definizione, dispatch e testing.

> **Nota UI/UX**: Usa SEMPRE i componenti Blade nativi di Filament (`<x-filament::...>`). Non usare componenti UI custom se esiste un equivalente Filament. Approfondisci in [filament-blade-components.md](/Themes/One/docs/FILAMENT_COMPONENTS.md) e nella [documentazione Filament](https://filamentphp.com/docs/3.x/support/blade-components/overview).

## Table of Contents
- [Panoramica](#panoramica)
- [Struttura della Documentazione](#struttura-della-documentazione)
  - [Template Email](#template-email)
  - [Notifiche](#notifiche)
  - [Integrazioni](#integrazioni)
- [Analisi delle Soluzioni](#analisi-delle-soluzioni)
  - [Soluzioni Analizzate](#soluzioni-analizzate)
  - [Soluzione Scelta](#soluzione-scelta)
- [Queueable Action: Standard <nome progetto>](#queueable-action-standard-<nome progetto>)
- [Componenti Blade: Standard Filament](#componenti-blade-standard-filament)
- [Note](#note)
- [Contribuire](#contribuire)
- [Collegamenti Completi](#collegamenti-completi)

## Queueable Action: Standard <nome progetto>

<nome progetto> adotta come standard [spatie/laravel-queueable-action](https://github.com/spatie/laravel-queueable-action) per la business logic asincrona e la gestione di azioni riutilizzabili. Non utilizzare Service class custom. Approfondisci in [queueable-action.md](queueable-action.md).

## Componenti Blade: Standard Filament

La PRIMA SCELTA per i componenti Blade sono SEMPRE i [componenti nativi Filament](filament-blade-components.md). Non usare componenti custom se esiste un equivalente Filament. Approfondisci in [filament-blade-components.md](filament-blade-components.md) e nella [documentazione Filament](https://filamentphp.com/docs/3.x/support/blade-components/overview).

## Panoramica
### Esempio Rapido di Invio
```php
Mail::to($user)->send(new Modules\Notify\Mail\WelcomeMail($user));
```
Il modulo Notify gestisce tutte le notifiche e le comunicazioni via email del sistema.
Il modulo Notify gestisce tutte le notifiche e le comunicazioni via email del sistema <nome progetto>.

## Struttura della Documentazione

### Template Email
- [README.md Template](templates/README.md)
- [Panoramica Template Email](email-template-landscape.md)
- [Deep Dive Tecnico Template](email-templates-deep-dive.md)
- [Analisi Tools Esterni](codebrisk-tools-analysis.md)
- [Collezione Tailwind CSS](webcrunch-tailwind-collection.md)
- [Gestione Template](templates/gestione.md)
- [Personalizzazione](templates/personalizzazione.md)

### Notifiche
- [README.md Notifiche](notifications/README.md)
- [Configurazione](notifications/configurazione.md)
- [Best Practices](notifications/best-practices.md)

### Integrazioni
- [README.md Integrazioni](integrations/README.md)
- [Mailgun](integrations/mailgun.md)
- [Mailtrap](integrations/mailtrap.md)

## Analisi delle Soluzioni

### Soluzioni Analizzate
1. **Laravel Email Templates**
   - Vantaggi:
     - Integrazione nativa con Laravel
     - Sistema di template semplice
     - Supporto per markdown
   - Svantaggi:
     - Funzionalità limitate
     - Personalizzazione complessa

2. **Spatie Database Mail Templates**
   - Vantaggi:
     - Template gestibili dal database
     - Sistema di versioning
     - API flessibile
   - Svantaggi:
     - Overhead database
     - Complessità aggiuntiva

3. **Mailgun Templates**
   - Vantaggi:
     - Editor visuale
     - Analytics avanzate
     - A/B testing
   - Svantaggi:
     - Costi
     - Dipendenza esterna

4. **Laravel Mail Editor**
   - Vantaggi:
     - Editor visuale integrato
     - Preview in tempo reale
     - Gestione template semplice
   - Svantaggi:
     - Limitazioni personalizzazione
     - Performance overhead

### Soluzione Scelta
Per <nome progetto> è stata scelta una soluzione ibrida che combina:
- Template base in Laravel Markdown
- Editor visuale per personalizzazione
- Integrazione con Mailgun per delivery
- Sistema di versioning dei template

## Note
- Tutti i collegamenti sono relativi
- La documentazione è mantenuta in italiano
- I collegamenti sono bidirezionali quando appropriato
- Ogni sezione ha il suo README.md specifico

## Contribuire
Per contribuire alla documentazione, seguire le [Linee Guida](../../../docs/linee-guida-documentazione.md) e le [Regole dei Collegamenti](../../../docs/regole_collegamenti_documentazione.md).

## Collegamenti Completi
Per una lista completa di tutti i collegamenti tra i README.md, consultare il file [README_links.md](../../../docs/README_links.md).

---

> Per dettagli sulla risoluzione dei conflitti e sugli standard architetturali, vedi anche [INDEX.md](./INDEX.md) e la doc globale [../../../../docs/README.md](../../../../docs/README.md)
