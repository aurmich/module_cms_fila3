# Traduzioni del Modulo SaluteOra

## Panoramica

Il modulo SaluteOra gestisce la traduzione di tutti i componenti relativi alla gestione degli appuntamenti sanitari, inclusi gli appuntamenti dei dottori, stati degli appuntamenti e azioni correlate.

## File di Traduzione

### doctor_appointments.php

Gestisce le traduzioni per la gestione degli appuntamenti dei dottori.

#### Struttura

```php
'actions' => [
    'delete' => [
        'label' => 'Elimina',
        'tooltip' => 'Elimina questo appuntamento',
        'confirmation' => 'Sei sicuro di voler eliminare questo appuntamento?',
        'success' => 'Appuntamento eliminato con successo',
        'error' => 'Errore durante l\'eliminazione dell\'appuntamento',
    ],
    // Altre azioni...
],
'states' => [
    'pending' => [
        'label' => 'In Attesa',
        'color' => 'warning',
        'bg_color' => '#FEF3C7',
        'icon' => 'heroicon-o-clock',
        'description' => 'Appuntamento in attesa di conferma',
    ],
    // Altri stati...
],
'fields' => [
    'message' => [
        'label' => 'Messaggio',
        'placeholder' => 'Inserisci un messaggio per il paziente',
        'helper_text' => 'Il messaggio verrà inviato al paziente',
        'description' => 'Messaggio personalizzato per il paziente',
    ],
    // Altri campi...
],
```

#### Azioni Supportate

- **delete**: Eliminazione appuntamento
- **accept**: Accettazione appuntamento
- **confirm**: Conferma appuntamento
- **reject**: Rifiuto appuntamento
- **reschedule**: Riprogrammazione appuntamento
- **complete**: Completamento appuntamento
- **cancel**: Annullamento appuntamento
- **view_details**: Visualizzazione dettagli
- **edit**: Modifica appuntamento
- **generate_report**: Generazione report
- **send_reminder**: Invio promemoria
- **add_note**: Aggiunta note

#### Stati Supportati

- **pending**: In attesa di conferma
- **confirmed**: Confermato dal dottore
- **rejected**: Rifiutato dal dottore
- **completed**: Completato con successo
- **cancelled**: Annullato
- **rescheduled**: Riprogrammato per nuova data
- **in_progress**: Attualmente in corso

### appointment.php

Gestisce le traduzioni per la gestione generale degli appuntamenti.

### states.php

Gestisce le traduzioni per gli stati degli appuntamenti.

### actions.php

Gestisce le traduzioni per le azioni generali del modulo.

## Lingue Supportate

- **Italiano (it)**: Lingua principale
- **Inglese (en)**: Traduzioni complete
- **Tedesco (de)**: Traduzioni complete

## Convenzioni

1. **Struttura Espansa**: Tutti i campi utilizzano la struttura espansa con `label`, `placeholder`, `helper_text` e `description`
2. **Sintassi Array**: Utilizzo della sintassi breve `[]` invece di `array()`
3. **Strict Types**: Tutti i file includono `declare(strict_types=1);`
4. **Naming**: Chiavi in inglese, valori tradotti nella lingua target
5. **Azioni Complete**: Ogni azione include `label`, `tooltip`, `confirmation`, `success` e `error`
6. **Stati Completi**: Ogni stato include `label`, `color`, `bg_color`, `icon` e `description`

## Utilizzo

### In Componenti Filament

```php
Actions\DeleteAction::make()
    ->label(__('saluteora::doctor_appointments.actions.delete.label'))
    ->tooltip(__('saluteora::doctor_appointments.actions.delete.tooltip'))
    ->requiresConfirmation()
    ->modalHeading(__('saluteora::doctor_appointments.actions.delete.confirmation'))
    ->successNotificationTitle(__('saluteora::doctor_appointments.actions.delete.success'))
```

### In Stati degli Appuntamenti

```php
Tables\Columns\BadgeColumn::make('status')
    ->label(__('saluteora::doctor_appointments.states.pending.label'))
    ->color(__('saluteora::doctor_appointments.states.pending.color'))
    ->icon(__('saluteora::doctor_appointments.states.pending.icon'))
```

### In Campi del Form

```php
Forms\Components\Textarea::make('message')
    ->label(__('saluteora::doctor_appointments.fields.message.label'))
    ->placeholder(__('saluteora::doctor_appointments.fields.message.placeholder'))
    ->helperText(__('saluteora::doctor_appointments.fields.message.helper_text'))
```

### In Messaggi

```php
Notification::make()
    ->title(__('saluteora::doctor_appointments.messages.appointment_accepted'))
    ->success();
```

## Manutenzione

- Aggiornare le traduzioni quando si aggiungono nuove azioni o stati
- Mantenere coerenza tra le tre lingue
- Verificare che tutti i messaggi di errore siano tradotti
- Testare le traduzioni in tutti i contesti di utilizzo
- Aggiornare la documentazione quando si modificano le traduzioni

## Collegamenti

- [Documentazione Generale SaluteOra](../structure.md)
- [Best Practice Traduzioni](../../../docs/translation-standards.md)
- [Convenzioni Laraxot](../../../docs/laraxot_conventions.md)
- [Gestione Stati Appuntamenti](../appointment_states.md)
