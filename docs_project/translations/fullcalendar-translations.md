# Traduzioni per i Widget FullCalendar

## Struttura Standard delle Traduzioni

Le traduzioni per i widget FullCalendar in SaluteOra seguono una struttura standardizzata che riflette la filosofia del progetto di separazione completa tra codice e contenuto testuale.

### File di Traduzione Specifico

Ogni widget FullCalendar deve avere un file di traduzione dedicato nella directory:
```
Modules/SaluteOra/lang/{locale}/{widget_name}_calendar.php
```

Esempi:
- `doctor_availability_calendar.php`
- `appointment_calendar.php`

### Struttura Raccomandata

```php
<?php

declare(strict_types=1);

return [
    // Navigazione e configurazione generale del widget
    'navigation' => [
        'label' => 'Nome Widget',
        'group' => 'Gruppo di Navigazione',
        'icon' => 'heroicon-o-calendar',
        'color' => 'primary',
        'sort' => 10,
        'tooltip' => 'Descrizione tooltip',
    ],
    
    // Azioni disponibili nel calendario
    'actions' => [
        'action_name' => [
            'label' => 'Nome Azione',
            'tooltip' => 'Descrizione Tooltip',
        ],
        // Altre azioni...
    ],
    
    // Campi del form per modalità di creazione/modifica
    'fields' => [
        'field_name' => [
            'label' => 'Etichetta Campo',
            'placeholder' => 'Testo placeholder',
            'helper_text' => 'Testo di aiuto',
            'tooltip' => 'Tooltip campo',
        ],
        // Altri campi...
    ],
    
    // Valori di stato utilizzati nel calendario
    'status' => [
        'status_key' => 'Nome Stato',
        // Altri stati...
    ],
    
    // Messaggi di feedback per l'utente
    'messages' => [
        'success' => [
            'created' => 'Elemento creato con successo',
            'updated' => 'Elemento aggiornato con successo',
            'deleted' => 'Elemento eliminato con successo',
        ],
        'error' => [
            'create' => 'Errore durante la creazione',
            'update' => 'Errore durante l\'aggiornamento',
            'delete' => 'Errore durante l\'eliminazione',
        ],
        'confirm' => [
            'delete' => 'Sei sicuro di voler eliminare questo elemento?',
        ],
    ],
    
    // Contenuto delle finestre modali
    'modals' => [
        'modal_name' => [
            'title' => 'Titolo Modale',
            'description' => 'Descrizione Modale',
        ],
        // Altre modali...
    ],
    
    // Elementi comuni del calendario
    'common' => [
        'calendar' => [
            'today' => 'Oggi',
            'month' => 'Mese',
            'week' => 'Settimana',
            'day' => 'Giorno',
            'list' => 'Lista',
        ],
        // Altri elementi comuni...
    ],
];
```

## Regole Fondamentali

1. **Utilizzo della sintassi breve**: Sempre utilizzare `[]` invece di `array()`
2. **Dichiarazione `strict_types`**: Ogni file di traduzione deve iniziare con `declare(strict_types=1);`
3. **Struttura espansa**: Ogni campo deve avere una struttura espansa con almeno `label` e `tooltip`
4. **Indentazione coerente**: Utilizzare 4 spazi per l'indentazione (mai tabs)
5. **Nome chiavi in inglese**: Le chiavi devono essere in inglese, mentre i valori nella lingua target

## Utilizzo con FullCalendarWidget

Le traduzioni vengono utilizzate automaticamente dal `LangServiceProvider` nei widget FullCalendar quando si rispetta la convenzione di naming:

```php
// Esempio di implementazione corretta
class DoctorAvailabilityCalendarWidget extends FullCalendarWidget
{
    // Il LangServiceProvider cercherà le traduzioni in doctor_availability_calendar.php
    // basandosi sul nome della classe
}
```

## Legami con Altri Documenti

- [Sistema di traduzione Filament](/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteOra/docs/filament/label-translation-system.md)
- [Struttura generale delle traduzioni](/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteOra/docs/translations.md)

## Note Importanti

Ricordare sempre:
1. Mai utilizzare il metodo `->label()` nei componenti FullCalendar o Filament
2. Aggiornare le traduzioni quando si aggiungono nuove funzionalità
3. Mantenere la coerenza tra le diverse lingue
4. Le traduzioni sono parte integrante dell'architettura del sistema, non una semplice convenienza
