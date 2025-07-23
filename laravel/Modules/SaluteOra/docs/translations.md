# Traduzioni del Modulo SaluteOra

## Regole fondamentali (aggiornamento 2025-01-07)
- Non togliere mai chiavi esistenti, solo aggiungere o migliorare.
- **REGOLA CRITICA**: Se il valore di 'helper_text' coincide con la chiave padre, va impostato a stringa vuota ('').
- label, placeholder, description devono essere sempre tradotti e contestuali.
- Tutte le lingue devono avere le stesse chiavi.
- Gli array vanno sempre scritti in short syntax `[]` invece di `array()`.
- **SEMPRE** includere `declare(strict_types=1);` all'inizio del file.
- **SEMPRE** implementare traduzioni complete in italiano, inglese e tedesco.

## Correzioni Applicate (2025-01-07)

### File Sistematizzati

1. **cancelled.php** - Traduzioni per appuntamenti cancellati
   - ✅ IT: Traduzione italiana completa
   - ✅ EN: Traduzione inglese creata
   - ✅ DE: Traduzione tedesca creata

2. **no_show.php** - Traduzioni per mancate presentazioni
   - ✅ IT: Traduzione italiana completa
   - ✅ EN: Traduzione inglese creata
   - ✅ DE: Traduzione tedesca creata

3. **pro_bono.php** - Traduzioni per servizi pro bono
   - ✅ IT: Traduzione italiana completa
   - ✅ EN: Traduzione inglese creata
   - ✅ DE: Traduzione tedesca creata

4. **report_completed.php** - Traduzioni per referti completati
   - ✅ IT: Traduzione italiana completa
   - ✅ EN: Traduzione inglese creata
   - ✅ DE: Traduzione tedesca creata

### Correzioni Applicate

1. **Array Syntax**: Convertiti tutti da `array()` a `[]`
2. **Helper Text Fix**: Tutti i `helper_text` uguali alla chiave padre impostati a `''`
3. **Struttura Completa**: Aggiunti `placeholder`, `help`, `description` mancanti
4. **Traduzioni Semantiche**: Traduzioni contestuali appropriate per il dominio sanitario

## Esempio campo 'message' corretto per cancelled.php

```php
// File: laravel/Modules/SaluteOra/lang/it/cancelled.php
'message' => [
    'label' => 'Messaggio di Cancellazione',
    'placeholder' => 'Motivo della cancellazione',
    'help' => 'Messaggio per spiegare la cancellazione dell\'appuntamento',
    'description' => 'Comunicazione relativa all\'appuntamento cancellato',
    'helper_text' => '', // ← CRITICO: Non 'message' ma stringa vuota!
],

// File: laravel/Modules/SaluteOra/lang/en/cancelled.php
'message' => [
    'label' => 'Cancellation Message',
    'placeholder' => 'Reason for cancellation',
    'help' => 'Message to explain the appointment cancellation',
    'description' => 'Communication regarding the cancelled appointment',
    'helper_text' => '',
],

// File: laravel/Modules/SaluteOra/lang/de/cancelled.php
'message' => [
    'label' => 'Stornierungsnachricht',
    'placeholder' => 'Grund für die Stornierung',
    'help' => 'Nachricht zur Erklärung der Terminabsage',
    'description' => 'Mitteilung bezüglich des stornierten Termins',
    'helper_text' => '',
],
```

## Nuovi File di Traduzione Creati

### cancelled.php
- **Scopo**: Gestisce messaggi per appuntamenti cancellati
- **Lingue**: IT, EN, DE
- **Campi**: message (messaggio di cancellazione)

### no_show.php  
- **Scopo**: Gestisce messaggi per mancate presentazioni
- **Lingue**: IT, EN, DE
- **Campi**: message (documentazione no-show)

### pro_bono.php
- **Scopo**: Gestisce traduzioni per servizi pro bono
- **Lingue**: IT, EN, DE
- **Campi**: message, probono_acceptance (accettazione servizio gratuito)

### report_completed.php
- **Scopo**: Gestisce traduzioni per referti medici completati
- **Lingue**: IT, EN, DE
- **Campi**: message (notifica completamento referto)

## Best practice
- Aggiornare sempre tutte le lingue.
- Validare la presenza di tutte le chiavi.
- Aggiornare la documentazione e i backlink dopo ogni fix.
- **MAI** utilizzare stringhe hardcoded nei componenti Filament.
- **SEMPRE** usare `helper_text => ''` quando uguale alla chiave padre.

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
        'help' => 'Il messaggio verrà inviato al paziente',
        'description' => 'Messaggio personalizzato per il paziente',
        'helper_text' => '', // ← Sempre stringa vuota se uguale alla chiave
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
- **cancelled**: Annullato (gestito da cancelled.php)
- **rescheduled**: Riprogrammato per nuova data
- **in_progress**: Attualmente in corso
- **no_show**: Mancata presentazione (gestito da no_show.php)
- **report_completed**: Referto completato (gestito da report_completed.php)

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

1. **Struttura Espansa**: Tutti i campi utilizzano la struttura espansa con `label`, `placeholder`, `help`, `description` e `helper_text`
2. **Sintassi Array**: Utilizzo della sintassi breve `[]` invece di `array()`
3. **Strict Types**: Tutti i file includono `declare(strict_types=1);`
4. **Naming**: Chiavi in inglese, valori tradotti nella lingua target
5. **Azioni Complete**: Ogni azione include `label`, `tooltip`, `confirmation`, `success` e `error`
6. **Stati Completi**: Ogni stato include `label`, `color`, `bg_color`, `icon` e `description`
7. **Helper Text Rule**: Se `helper_text` = chiave padre, impostare a `''`

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

### Per Appuntamenti Cancellati

```php
// Uso corretto per messaggi di cancellazione
Notification::make()
    ->title(__('saluteora::cancelled.fields.message.label'))
    ->body(__('saluteora::cancelled.fields.message.description'))
    ->warning();
```

### Per Servizi Pro Bono

```php
// Checkbox per accettazione pro bono
Forms\Components\Checkbox::make('probono_acceptance')
    ->label(__('saluteora::pro_bono.fields.probono_acceptance.label'))
    ->helperText(__('saluteora::pro_bono.fields.probono_acceptance.help'))
```

### Per Referti Completati

```php
// Notifica completamento referto
Notification::make()
    ->title(__('saluteora::report_completed.fields.message.label'))
    ->body(__('saluteora::report_completed.fields.message.description'))
    ->success();
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
    ->helperText(__('saluteora::doctor_appointments.fields.message.help'))
```

### In Messaggi

```php
Notification::make()
    ->title(__('saluteora::doctor_appointments.messages.appointment_accepted'))
    ->success();
```

## Controllo Qualità e Validazione

### Checklist Pre-Deploy
- [ ] Tutti i file hanno `declare(strict_types=1);`
- [ ] Sintassi array breve `[]` utilizzata ovunque
- [ ] Nessun `helper_text` uguale alla chiave padre
- [ ] Struttura espansa completa per tutti i campi
- [ ] Traduzioni coerenti in tutte e tre le lingue
- [ ] Nessuna stringa hardcoded nei componenti

### Script di Validazione
```bash
# Controllo helper_text problematici
grep -r "helper_text.*message" Modules/SaluteOra/lang/
grep -r "helper_text.*state" Modules/SaluteOra/lang/
grep -r "helper_text.*probono_acceptance" Modules/SaluteOra/lang/

# Controllo array syntax
grep -r "array (" Modules/SaluteOra/lang/

# Controllo strict types
grep -L "declare(strict_types=1);" Modules/SaluteOra/lang/**/*.php
```

## Manutenzione

- Aggiornare le traduzioni quando si aggiungono nuove azioni o stati
- Mantenere coerenza tra le tre lingue
- Verificare che tutti i messaggi di errore siano tradotti
- Testare le traduzioni in tutti i contesti di utilizzo
- Aggiornare la documentazione quando si modificano le traduzioni
- **SEMPRE** applicare la regola helper_text per nuovi campi
- Documentare ogni aggiunta/modifica con data e motivazione

## Cronologia Modifiche

### 2025-01-07 - Sistematizzazione Traduzioni
- ✅ Corretti tutti i file esistenti (array syntax, helper_text)
- ✅ Creati file mancanti per EN e DE
- ✅ Implementata struttura espansa completa
- ✅ Aggiunte traduzioni semantiche per dominio sanitario
- ✅ Documentazione aggiornata con nuove regole

### 2024-06 - Regole Fondamentali
- Definite regole base per helper_text
- Implementato supporto multilingua
- Standardizzata struttura espansa

## Collegamenti

- [Documentazione Generale SaluteOra](../structure.md)
- [Best Practice Traduzioni](../../../docs/translation-standards.md)
- [Convenzioni Laraxot](../../../docs/laraxot_conventions.md)
- [Gestione Stati Appuntamenti](../appointment_states.md)
- [Regole Helper Text](../../../docs/translation-helper-text-rules.md)
- [Modulo Media Traduzioni](../../Media/docs/translations.md)
- [Modulo UI Traduzioni](../../UI/docs/translations.md)
