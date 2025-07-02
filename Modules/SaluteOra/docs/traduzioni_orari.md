# Traduzioni Orari di Apertura - Modulo SaluteOra

## Introduzione
Documentazione delle traduzioni per la gestione degli orari di apertura e disponibilità dei dottori nel modulo SaluteOra.

## File di Traduzione

### widgets.php
Contiene le traduzioni per tutti i widget relativi alle disponibilità dei dottori.

**Percorso**: `Modules/SaluteOra/lang/it/widgets.php`

#### Sezioni Principali:
- `doctor_availabilities`: Widget per la gestione delle disponibilità dei dottori
- `schedule`: Messaggi relativi agli orari non configurati
- `actions`: Azioni disponibili (modifica, visualizza)
- `empty_state`: Stato vuoto quando non ci sono configurazioni

### opening_hours.php
Contiene le traduzioni per la gestione degli orari di apertura.

**Percorso**: `Modules/SaluteOra/lang/it/opening_hours.php`

#### Sezioni Principali:
- `title` e `description`: Titoli e descrizioni generali
- `fields`: Tutti i campi del form per configurare gli orari
- `actions`: Azioni per salvare, ripristinare e copiare orari
- `sections`: Sezioni del form (orari settimanali, speciali, pause)
- `messages`: Messaggi di feedback per l'utente
- `validation`: Messaggi di validazione

## Esempi di Utilizzo

### Nel Codice PHP (Widget)
```php
// Widget delle disponibilità dottori
protected function getEmptyStateHeading(): ?string
{
    return __('saluteora::widgets.doctor_availabilities.empty_state.heading');
}

protected function getEmptyStateDescription(): ?string
{
    return __('saluteora::widgets.doctor_availabilities.empty_state.description');
}
```

### Nei Form Filament
```php
// Campi per gli orari di apertura
TextInput::make('opening_time')
    ->label(__('saluteora::opening_hours.fields.opening_time.label'))
    ->placeholder(__('saluteora::opening_hours.fields.opening_time.placeholder'))
    ->helperText(__('saluteora::opening_hours.fields.opening_time.help')),

Select::make('day_of_week')
    ->label(__('saluteora::opening_hours.fields.day_of_week.label'))
    ->options([
        'monday' => __('saluteora::opening_hours.fields.day_of_week.options.monday'),
        'tuesday' => __('saluteora::opening_hours.fields.day_of_week.options.tuesday'),
        // ... altri giorni
    ]),
```

### Nelle Action Filament
```php
// Action per modificare gli orari
Action::make('edit_schedule')
    ->label(__('saluteora::widgets.doctor_availabilities.actions.edit_schedule.label'))
    ->modalHeading(__('saluteora::widgets.doctor_availabilities.actions.edit_schedule.modal_heading'))
    ->modalDescription(__('saluteora::widgets.doctor_availabilities.actions.edit_schedule.modal_description'))
    ->successNotificationTitle(__('saluteora::widgets.doctor_availabilities.actions.edit_schedule.success')),
```

### Nelle View Blade
```blade
<h2>{{ __('saluteora::opening_hours.title.label') }}</h2>
<p>{{ __('saluteora::opening_hours.title.description') }}</p>

@if(!$hasSchedule)
    <div class="text-center py-4">
        <p>{{ __('saluteora::widgets.doctor_availabilities.schedule.no_schedule.label') }}</p>
        <small>{{ __('saluteora::widgets.doctor_availabilities.schedule.click_edit_to_configure.help') }}</small>
    </div>
@endif
```

## Struttura Espansa

Tutte le traduzioni seguono la **struttura espansa** richiesta da Laraxot:

### Per i Campi
```php
'nome_campo' => [
    'label' => 'Etichetta del campo',
    'placeholder' => 'Testo placeholder',
    'help' => 'Testo di aiuto esplicativo',
],
```

### Per le Azioni
```php
'nome_azione' => [
    'label' => 'Etichetta azione',
    'tooltip' => 'Tooltip descrittivo', 
    'modal_heading' => 'Titolo modale',
    'modal_description' => 'Descrizione modale',
    'success' => 'Messaggio di successo',
    'error' => 'Messaggio di errore',
],
```

## Best Practice

1. **MAI** utilizzare `->label()`, `->placeholder()` o `->helperText()` hardcoded nei componenti
2. **SEMPRE** utilizzare la funzione `__()` per referenziare le traduzioni
3. **SEMPRE** includere tutti e tre i campi: `label`, `placeholder`, `help`
4. **SEMPRE** includere `declare(strict_types=1);` nei file di traduzione
5. **SEMPRE** utilizzare la sintassi array breve `[]` invece di `array()`

## Validazione

Per verificare che le traduzioni siano utilizzate correttamente:

```bash
# Cerca hardcoded strings nei widget
grep -r "->label(" Modules/SaluteOra/app/Filament/Widgets/

# Verifica struttura traduzioni
php artisan translation:validate-structure saluteora
```

## Collegamenti

- [Documentazione Root Traduzioni](../../../docs/translation-standards.md)
- [Regole Generali Traduzioni](../../Xot/docs/TRANSLATION_RULES.md)
- [Widgets SaluteOra](./widgets_disponibilita.md)

*Ultimo aggiornamento: dicembre 2024* 