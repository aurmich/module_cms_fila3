# Traduzioni per Widget di Calendario

## Struttura Standard

Le traduzioni per i widget di calendario (FullCalendar, calendari di disponibilità, etc.) in SaluteOra seguono una struttura standardizzata che segue i principi generali del sistema di traduzioni del progetto.

## File di Traduzione Specifici

Ogni tipo di calendario deve avere un file di traduzione dedicato nella directory:

```
Modules/SaluteOra/lang/{locale}/{calendar_type}.php
```

Esempi:
- `doctor_availability_calendar.php`
- `appointment_calendar.php`
- `patient_calendar.php`

## Organizzazione delle Sezioni

Tutti i file di traduzione per i calendari devono seguire questa struttura di sezioni:

```php
return [
    // Navigazione e configurazione generale del widget
    'navigation' => [...],
    
    // Azioni disponibili nel calendario
    'actions' => [...],
    
    // Campi del form per modalità di creazione/modifica
    'fields' => [...],
    
    // Stati possibili degli eventi nel calendario
    'status' => [...],
    
    // Messaggi di feedback per l'utente
    'messages' => [...],
    
    // Contenuto delle finestre modali
    'modals' => [...],
    
    // Elementi comuni del calendario
    'common' => [...],
];
```

## Regole Specifiche per Sezioni

### Navigazione

```php
'navigation' => [
    'label' => 'Nome Widget',
    'group' => 'Gruppo nella navigazione',
    'icon' => 'heroicon-o-calendar',  // Usa sempre heroicon- o saluteora-
    'color' => 'primary',
    'sort' => 10,
    'tooltip' => 'Descrizione tooltip',
],
```

### Azioni

Ogni azione deve includere:

```php
'action_name' => [
    'label' => 'Nome Azione',
    'tooltip' => 'Descrizione Tooltip',
    'icon' => 'heroicon-o-nome-icona',
],
```

### Campi Form

Ogni campo form deve includere:

```php
'field_name' => [
    'label' => 'Etichetta Campo',
    'placeholder' => 'Testo placeholder',
    'helper_text' => 'Testo di aiuto',
    'tooltip' => 'Tooltip campo',
    'required' => true,  // Opzionale
],
```

Per campi select:

```php
'field_name' => [
    // ... altre proprietà
    'options' => [
        'value1' => 'Label 1',
        'value2' => 'Label 2',
    ],
],
```

### Stati

```php
'status' => [
    'available' => 'Disponibile',
    'booked' => 'Prenotato',
    // Altri stati...
],
```

### Messaggi

```php
'messages' => [
    'success' => [
        'created' => 'Elemento creato con successo',
        'updated' => 'Elemento aggiornato con successo',
        // Altri messaggi di successo...
    ],
    'error' => [
        'create' => 'Errore durante la creazione',
        'update' => 'Errore durante l\'aggiornamento',
        // Altri messaggi di errore...
    ],
    'confirm' => [
        'delete' => 'Sei sicuro di voler eliminare questo elemento?',
        'confirm' => 'Conferma',
        'cancel' => 'Annulla',
        // Altri messaggi di conferma...
    ],
],
```

### Finestre Modali

```php
'modals' => [
    'modal_name' => [
        'title' => 'Titolo Modale',
        'description' => 'Descrizione Modale',
    ],
    // Altre modali...
],
```

### Elementi Comuni

```php
'common' => [
    'calendar' => [
        'today' => 'Oggi',
        'month' => 'Mese',
        'week' => 'Settimana',
        'day' => 'Giorno',
        'list' => 'Lista',
        // Altri elementi del calendario...
    ],
    // Altre sottosezioni comuni...
],
```

## Regole Generali

1. Utilizzare SEMPRE la sintassi breve `[]` per gli array
2. Includere SEMPRE `declare(strict_types=1);` all'inizio del file
3. Fornire traduzioni complete per tutti i testi visibili all'utente
4. Non utilizzare MAI stringhe hardcoded nell'interfaccia
5. Mantenere coerenza terminologica tra i diversi file di traduzione
6. Utilizzare il servizio di traduzione centralizzato e non chiamare mai `->label()` direttamente

## Relazione con FullCalendarWidget

Per i widget che estendono `Saade\FilamentFullCalendar\Widgets\FullCalendarWidget`, le traduzioni vengono applicate automaticamente se:

1. Il file di traduzione segue la convenzione di naming basata sul nome della classe del widget
2. I metodi del widget non contengono stringhe hardcoded

## Collegamento con Altre Documentazioni

- [Sistema generale di traduzioni](/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteOra/docs/translations.md)
- [Traduzioni specifiche per FullCalendar](/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteOra/docs/translations/fullcalendar-translations.md)
- [Label Translation System](/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteOra/docs/filament/label-translation-system.md)

## Checklist di Validazione

Prima di considerare completo un file di traduzione per un calendario, verificare:

- [ ] Tutte le sezioni principali sono presenti (`navigation`, `actions`, `fields`, etc.)
- [ ] Tutti i campi form hanno `label`, `placeholder`, `helper_text` e `tooltip`
- [ ] Tutte le azioni hanno `label`, `tooltip` e `icon`
- [ ] Tutti i messaggi di feedback sono presenti nelle categorie appropriate
- [ ] Non ci sono stringhe hardcoded o riferimenti a `->label()` nel codice
- [ ] Il file inizia con `declare(strict_types=1);`
- [ ] La sintassi degli array è coerente (solo `[]`, mai `array()`)
- [ ] La struttura è bilanciata (parentesi graffe corrispondenti)
- [ ] Non ci sono sezioni duplicate o ridondanti
