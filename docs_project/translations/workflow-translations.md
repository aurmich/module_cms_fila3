# Gestione Traduzioni per i Workflow in SaluteOra

## Struttura dei File di Traduzione per Workflow

I file di traduzione relativi ai workflow (es. `appointment_workflow.php`) devono seguire una struttura standardizzata per garantire coerenza e manutenibilità in tutto il progetto.

### Principi Fondamentali

1. **Sintassi corretta**
   - Utilizzare SEMPRE la sintassi breve per gli array `[]` (mai `array()`)
   - Includere SEMPRE `declare(strict_types=1);`
   - Indentare con 4 spazi (non tabulazioni)

2. **Completezza dei campi**
   - Ogni etichetta deve includere una struttura completa
   - Mai utilizzare etichette temporanee o placeholder
   - Includere tooltip, helper_text e placeholder per i campi form

3. **Organizzazione gerarchica**
   - Separazione chiara tra navigation, model, actions, fields
   - Struttura dei campi annidati per relazioni
   - Organizzazione coherente delle azioni e messaggi

## Struttura Standard

```php
<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Etichetta Navigazione',
        'group' => 'Gruppo Navigazione',
        'icon' => 'heroicon-o-nome-icona',
        'sort' => 50, // Ordine nel menu
        'tooltip' => 'Descrizione tooltip della voce di menu',
    ],
    'model' => [
        'label' => 'Etichetta Singolare',
        'plural_label' => 'Etichetta Plurale',
    ],
    'actions' => [
        'create' => [
            'label' => 'Etichetta Azione',
            'tooltip' => 'Descrizione Azione',
            'icon' => 'heroicon-o-plus',
        ],
        // Altre azioni...
    ],
    'fields' => [
        'field_name' => [
            'label' => 'Etichetta Campo',
            'tooltip' => 'Tooltip del campo',
            'placeholder' => 'Placeholder del campo',
            'helper_text' => 'Testo di aiuto per il campo',
        ],
        // Altri campi...
    ],
    'filters' => [
        'title' => 'Titolo Filtri',
        'open' => 'Apri Filtri',
        'apply' => 'Applica Filtri',
        'reset' => 'Reimposta Filtri',
        'close' => 'Chiudi Filtri',
    ],
    'table' => [
        'empty' => 'Messaggio quando la tabella è vuota',
        'loading' => 'Messaggio durante il caricamento',
    ],
    'messages' => [
        'success' => [
            'created' => 'Messaggio di successo creazione',
            'updated' => 'Messaggio di successo aggiornamento',
            'deleted' => 'Messaggio di successo eliminazione',
        ],
        'error' => [
            'create' => 'Messaggio di errore creazione',
            'update' => 'Messaggio di errore aggiornamento',
            'delete' => 'Messaggio di errore eliminazione',
        ],
        'confirm' => [
            'delete' => 'Messaggio di conferma eliminazione',
        ],
    ],
];
```

## Campi Obbligatori per Workflow

### Navigation
- `label`: Nome visualizzato nel menu di navigazione
- `group`: Gruppo di appartenenza nel menu
- `icon`: Icona Heroicon (es. heroicon-o-document-chart-bar)
- `sort`: Posizione nel menu (numerico)
- `tooltip`: Descrizione al passaggio del mouse

### Actions
Ogni azione deve avere:
- `label`: Etichetta del pulsante
- `tooltip`: Descrizione dell'azione
- `icon`: Icona dell'azione

### Azioni Standard da Includere
- `create`: Creazione nuovo elemento
- `edit`: Modifica elemento esistente
- `delete`: Eliminazione elemento
- `view`: Visualizzazione dettaglio

### Stato Workflow
Traduzioni per gli stati comuni dei workflow:
- `pending`: In attesa
- `active`: Attivo
- `completed`: Completato
- `cancelled`: Annullato

## Checklist di Validazione

Prima di considerare completo un file di traduzione per workflow, verificare:

- [ ] File utilizza sintassi breve per gli array `[]`
- [ ] Presente dichiarazione `declare(strict_types=1);`
- [ ] Tutte le etichette sono significative (mai "Temporary Label" o simili)
- [ ] Ogni campo ha tooltip e placeholder quando applicabile
- [ ] Presenti tutte le azioni standard (create, edit, delete, view)
- [ ] Presenti messaggi di successo/errore per ogni azione
- [ ] Incluse opzioni per filtri e gestione tabella
- [ ] Struttura gerarchica coerente e ben organizzata

## Collegamenti

- [Calendar Translations](calendar-translations.md)
- [FullCalendar Translations](fullcalendar-translations.md)
- [Widget Translations](/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteOra/docs/translations/widget-translations.md)

## Esempi di File Corretti

- [appointment_workflow.php](/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteOra/lang/it/appointment_workflow.php)
- [doctor_availability_manager.php](/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteOra/lang/it/doctor_availability_manager.php)
