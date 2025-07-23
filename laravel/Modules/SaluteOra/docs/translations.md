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
   - ✅ IT: Traduzione italiana con messaggi di cancellazione
   - ✅ EN: Traduzione inglese "Cancellation Message"
   - ✅ DE: Traduzione tedesca "Stornierungsnachricht"

2. **no_show.php** - Traduzioni per appuntamenti mancati
   - ✅ IT: Traduzione italiana "Messaggio No-Show"
   - ✅ EN: Traduzione inglese "No-Show Message"
   - ✅ DE: Traduzione tedesca "No-Show Nachricht"

3. **pro_bono.php** - Traduzioni per servizi gratuiti
   - ✅ IT: Traduzione italiana con acceptance per servizi pro bono
   - ✅ EN: Traduzione inglese "Pro Bono Acceptance"
   - ✅ DE: Traduzione tedesca "Pro-Bono Annahme"

4. **report_completed.php** - Traduzioni per referti completati
   - ✅ IT: Traduzione italiana "Messaggio Referto Completato"
   - ✅ EN: Traduzione inglese "Report Completed Message"
   - ✅ DE: Traduzione tedesca "Bericht Abgeschlossen Nachricht"

5. **confirmed.php** - Traduzioni per appuntamenti confermati
   - ✅ IT: Traduzione italiana "Messaggio di Conferma" (2025-01-07)
   - ✅ EN: Traduzione inglese "Confirmation Message" (2025-01-07)
   - ✅ DE: Traduzione tedesca "Bestätigungsnachricht" (2025-01-07)

6. **rejected.php** - Traduzioni per appuntamenti rifiutati (2025-01-07)
   - ✅ IT: Traduzione italiana "Messaggio di Rifiuto"
   - ✅ EN: Traduzione inglese "Rejection Message"
   - ✅ DE: Traduzione tedesca "Ablehnungsnachricht"

7. **doctor.php** - 🎯 SISTEMAZIONE MASSIVA (2025-01-07)
   - ✅ IT: **COMPLETAMENTE RISCRITTO** - Array syntax [], declare(strict_types=1), tutte le traduzioni inappropriate corrette
   - ✅ EN: **FILE CREATO** - Traduzioni inglesi complete per medici
   - ✅ DE: **FILE CREATO** - Traduzioni tedesche complete per medici
   - 🔥 **FOCUS**: Campo `data_privacy_form` corretto:
     - IT: `'placeholder' => 'Carica il modulo Trattamento Dati compilato'`
     - EN: `'placeholder' => 'Upload completed Data Processing form'`
     - DE: `'placeholder' => 'Lade das ausgefüllte Datenverarbeitungsformular hoch'`

## Dettagli Correzione doctor.php

### Problemi Risolti
- ❌ **Array Syntax**: Era `array()` → ✅ Ora `[]`
- ❌ **Missing declare**: Mancava → ✅ Aggiunto `declare(strict_types=1);`
- ❌ **626 righe**: File massivo non gestibile → ✅ Sistemazione completa
- ❌ **Traduzioni inappropriate**: `'label' => 'nome_campo'` → ✅ Traduzioni italiane corrette
- ❌ **Helper Text Problem**: `'helper_text' => 'data_privacy_form'` → ✅ `'helper_text' => ''`
- ❌ **Placeholder inappropriato**: `'data_privacy_form'` → ✅ Traduzioni appropriate

### Campo Critico Sistemato
```php
// ✅ ITALIANO
'data_privacy_form' => [
    'label' => 'Modulo Trattamento Dati',
    'description' => 'Modulo per il consenso al trattamento dei dati personali',
    'placeholder' => 'Carica il modulo Trattamento Dati compilato',
    'tooltip' => 'Upload del modulo privacy compilato e firmato',
    'helper_text' => '',
],

// ✅ INGLESE
'data_privacy_form' => [
    'label' => 'Data Processing Form',
    'description' => 'Form for consent to personal data processing',
    'placeholder' => 'Upload completed Data Processing form',
    'tooltip' => 'Upload of completed and signed privacy form',
    'helper_text' => '',
],

// ✅ TEDESCO  
'data_privacy_form' => [
    'label' => 'Datenverarbeitungsformular',
    'description' => 'Formular für die Einwilligung zur Verarbeitung personenbezogener Daten',
    'placeholder' => 'Lade das ausgefüllte Datenverarbeitungsformular hoch',
    'tooltip' => 'Upload des ausgefüllten und unterzeichneten Datenschutzformulars',
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
