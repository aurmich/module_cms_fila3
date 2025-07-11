# Modulo Lang - Documentazione

## Panoramica

Il modulo Lang gestisce tutte le traduzioni dell'applicazione, fornendo un sistema centralizzato per la localizzazione e un'interfaccia Filament per la gestione dei file di traduzione.

## Documentazione Principale

### Sistema di Traduzioni
- [Sistema di Traduzione](./translation-system.md) - Architettura e funzionamento del sistema
- [Standard di Traduzione](./translation-standards.md) - Convenzioni e best practices
- [Best Practices](./translation-keys-best-practices.md) - Linee guida per le chiavi di traduzione

### Gestione File
- [Gestione File di Traduzione](./translation-file-management.md) - Architettura del sistema di gestione
- [Editor File di Traduzione](./translation-file-editor.md) - Guida all'utilizzo dell'interfaccia

### Implementazione
- [Implementazione Laravel Localization](./laravel-localization-implementation.md) - Dettagli tecnici
- [Utilizzo Laravel Localization](./laravel-localization-usage.md) - Esempi pratici
- [Integrazione Completa](./laravel-localization-complete.md) - Integrazione completa

### Filament Integration
- [Integrazione Filament](./filament-translations.md) - Integrazione con Filament
- [Integrazione Folio](./laravel-localization-folio.md) - Integrazione con Laravel Folio
- [Integrazione Livewire Volt](./laravel-localization-livewire-volt.md) - Integrazione con Livewire Volt

### Funzionalità Avanzate
- [Cambio Lingua Avanzato](./advanced-language-switching.md) - Gestione avanzata delle lingue
- [Traduzioni Automatiche](./automatic-translations.md) - Sistema di traduzioni automatiche
- [Localizzazione Date e Valute](./localizing-dates-and-currencies.md) - Gestione date e valute

### Validazione e Messaggi
- [Traduzione Messaggi di Validazione](./translating-validation-messages.md) - Gestione messaggi di validazione
- [Forme Plurali e Singolari](./translating-plural-singular-forms.md) - Gestione plurali
- [Messaggi di Validazione](./validation-messages.md) - Standard per i messaggi

### Struttura e Organizzazione
- [Struttura Traduzioni](./struttura-traduzioni.md) - Organizzazione dei file
- [Sintassi File Traduzione](./translation-file-syntax.md) - Sintassi corretta
- [Storage Traduzioni](./translations-storage.md) - Archiviazione traduzioni

### Troubleshooting
- [Errori Comuni](./errori-comuni-traduzione.md) - Risoluzione problemi comuni
- [Permessi Filesystem](./permessi-errori-filesystem.md) - Gestione permessi
- [Permessi Lang](./permessi-lang.md) - Permessi specifici del modulo

### Strumenti e Comandi
- [Comandi Autoregistrazione](./autoregistration-commands.md) - Comandi automatici
- [Gestione Pacchetti](./translation-management-packages.md) - Pacchetti di terze parti
- [FAQ](./translations-faq.md) - Domande frequenti

## Quick Start

### 1. Accesso Editor Traduzioni
```
Menu: Sistema → File di Traduzione
URL: /admin/translation-files
```

### 2. Modifica Traduzioni
1. Seleziona il file da modificare
2. Clicca su "Modifica"
3. Modifica le traduzioni nell'editor Key-Value
4. Salva le modifiche

### 3. Best Practices
- Usa struttura gerarchica per le chiavi
- Mantieni coerenza tra moduli
- Valida sempre la sintassi PHP
- Crea backup prima di modifiche critiche

## Collegamenti Utili

- [Laravel Localization](https://laravel.com/docs/localization)
- [Filament i18n](https://filamentphp.com/docs/internationalization)
- [Spatie Laravel Translatable](https://github.com/spatie/laravel-translatable)

## Note per lo Sviluppo

Il modulo Lang è progettato per essere:
- **Modulare**: Ogni modulo gestisce le proprie traduzioni
- **Estendibile**: Facile aggiungere nuove funzionalità
- **Manutenibile**: Struttura chiara e documentata
- **Performante**: Caricamento ottimizzato delle traduzioni
