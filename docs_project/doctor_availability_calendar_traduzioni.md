# Standard e filosofia delle traduzioni per doctor_availability_calendar.php

## Problemi Risolti

### 1. Struttura Non Conforme
Il file iniziale non rispettava la struttura espansa standard del progetto.

### 2. Helper_text Duplicati  
Molti `helper_text` erano identici a `placeholder` o `tooltip`, violando la regola di differenziazione.

### 3. Sintassi Array Legacy
Utilizzo di `array()` invece della sintassi breve `[]`.

### 4. Duplicazioni Strutturali
Presenza di duplicazioni e errori di sintassi nella struttura degli array.

## Filosofia, logica, religione, politica e zen
- **Filosofia**: Centralità della struttura espansa, chiarezza semantica, nessuna duplicazione, DRY, coerenza tra moduli e tra viste Filament.
- **Logica**: Tutte le chiavi devono essere strutturate in array associativi, con label, placeholder, helper_text (diverso da placeholder e tooltip), e tutte le azioni devono essere descritte in modo esplicito e localizzato.
- **Religione**: "Non avrai altro placeholder all'infuori del file lang". Nessuna stringa hardcoded nelle view o nei componenti. "Non avrai altro helper_text uguale a placeholder".
- **Politica**: Ogni campo, azione, stato e messaggio deve essere documentato e aggiornato in docs, con collegamenti bidirezionali e motivazione delle scelte.
- **Zen**: Serenità della manutenzione, portabilità tra moduli, nessun refactoring traumatico, onboarding rapido, differenziazione semantica dei testi.

## Prototipo e struttura standard
- `navigation`: label, group, icon, color, sort, tooltip
- `actions`: ogni azione come array con label, tooltip, icon
- `fields`: ogni campo come array con label, placeholder, helper_text (sempre diverso da placeholder), tooltip, required, options se necessario
- `status`: elenco degli stati disponibili
- `messages`: success, error, confirm, sempre come array
- `modals`: dettagli dei modali con title e description
- `common`: sottoarray per elementi ricorrenti (calendar, time_slots, recurring, filters, legend)
- `validation`: messaggi di validazione
- `empty_states`: stati vuoti con descrizioni

## Esempio di struttura corretta
```php
'fields' => [
    'doctor' => [
        'label' => 'Medico',
        'placeholder' => 'Seleziona il medico',
        'helper_text' => 'Scegli il professionista sanitario',
        'tooltip' => 'Seleziona il medico per visualizzare/modificare la sua disponibilità',
        'required' => true,
    ],
    'date' => [
        'label' => 'Data',
        'placeholder' => 'Seleziona la data',
        'helper_text' => 'Giorno della disponibilità',
        'tooltip' => 'Data per cui impostare la disponibilità',
        'required' => true,
    ],
    // ...
],
```

## Regole applicate nel fix
- ✅ Sintassi breve `[]` invece di `array()`
- ✅ `declare(strict_types=1)` obbligatorio
- ✅ Nessun array() legacy
- ✅ `helper_text` sempre diverso da `placeholder` e `tooltip`
- ✅ Tutte le chiavi in inglese, valori in italiano
- ✅ Struttura espansa completa con tutte le sezioni
- ✅ Rimozione duplicazioni strutturali
- ✅ Aggiunta icone per azioni
- ✅ Sezioni aggiuntive: modals, validation, empty_states
- ✅ Aggiornamento automatico docs e .mdc

## Specifiche delle Correzioni Helper_text

### Prima (❌ ERRATO)
```php
'doctor' => [
    'label' => 'Medico',
    'placeholder' => 'Seleziona il medico',
    'helper_text' => 'Medico per cui gestire la disponibilità',
],
```

### Dopo (✅ CORRETTO)
```php
'doctor' => [
    'label' => 'Medico',
    'placeholder' => 'Seleziona il medico',
    'helper_text' => 'Scegli il professionista sanitario',
    'tooltip' => 'Seleziona il medico per visualizzare/modificare la sua disponibilità',
],
```

## Struttura Completa Implementata

### 1. Navigation
- `label`, `group`, `icon`, `color`, `sort`, `tooltip`

### 2. Actions
- `legend`, `refresh`, `create`, `edit`, `delete`, `view`
- Ogni azione con `label`, `tooltip`, `icon`

### 3. Fields
- `doctor`, `date`, `start_time`, `end_time`, `status`, `recurring`, `repeat_until`, `notes`
- Ogni campo con `label`, `placeholder`, `helper_text`, `tooltip`, `required`
- Campo `status` con `options` per valori enum

### 4. Status
- Elenco completo degli stati disponibili

### 5. Messages
- `success`: created, updated, deleted, bulk_created, recurring_created, saved
- `error`: create, update, delete, overlap, past_date, invalid_time_range, outside_working_hours, not_found  
- `confirm`: delete, delete_recurring, bulk_delete, confirm, cancel

### 6. Modals
- `availability_details`, `create_availability`, `edit_availability`, `legend`

### 7. Common
- `calendar`: controlli e visualizzazioni del calendario
- `time_slots`: gestione fasce orarie
- `recurring`: opzioni di ricorrenza
- `filters`: filtri di ricerca
- `legend`: legenda colori e stati

### 8. Validation
- Messaggi di validazione personalizzati

### 9. Empty States
- Stati vuoti con descrizioni utili

## Collegamenti e Documentazione Correlata
- [list_appointments_gettablecolumns_fix.md](list_appointments_gettablecolumns_fix.md) - Fix delle colonne Filament
- [filament-best-practices.mdc](filament-best-practices.mdc) - Best practice Filament
- [.cursor/rules/filament-column-types-usage.mdc](../../.cursor/rules/filament-column-types-usage.mdc) - Regole tipi colonna
- [.windsurf/rules/filament-column-types-usage.mdc](../../.windsurf/rules/filament-column-types-usage.mdc) - Regole tipi colonna
- [README.md](README.md) - Documentazione generale modulo
- [doctor_availability.php](../lang/it/doctor_availability.php) - Altre traduzioni correlate
- [appointment.php](../lang/it/appointment.php) - Traduzioni appuntamenti

## Motivazione della correzione
1. **Conformità**: Allineamento agli standard Laraxot per traduzioni
2. **Manutenibilità**: Struttura standardizzata facilita manutenzione
3. **UX**: Helper_text differenziati migliorano l'esperienza utente
4. **Consistenza**: Coerenza con altri moduli del progetto
5. **Automazione**: Struttura espansa permette automazioni future
6. **Onboarding**: Struttura chiara facilita comprensione per nuovi sviluppatori

## Test di Verifica
- [x] File sintatticamente valido (nessun errore PHP)
- [x] Struttura espansa completa
- [x] Nessun `helper_text` uguale a `placeholder`
- [x] Sintassi `[]` utilizzata ovunque
- [x] `declare(strict_types=1)` presente
- [x] Tutte le icone configurate
- [x] Sezioni complete (navigation, actions, fields, status, messages, modals, common, validation, empty_states)
- [x] Collegamenti bidirezionali aggiornati
- [x] Documentazione aggiornata

## Checklist Finale
- [x] Sintassi `[]` 
- [x] `declare(strict_types=1)`
- [x] `helper_text` sempre diverso da `placeholder` e `tooltip`
- [x] Struttura espansa completa
- [x] Icone configurate per azioni
- [x] Sezioni aggiuntive implementate
- [x] Documentazione aggiornata con motivazioni
- [x] Collegamenti bidirezionali
- [x] Regole .mdc create per Cursor e Windsurf
- [x] Correzioni TextColumn::boolean() → IconColumn::boolean() documentate

## Note per il Futuro
1. Sempre verificare che `helper_text` sia diverso da `placeholder` e `tooltip`
2. Utilizzare la struttura espansa completa per ogni file di traduzione
3. Aggiornare sempre la documentazione quando si modificano le traduzioni
4. Creare collegamenti bidirezionali tra documentazioni correlate
5. Documentare sempre la filosofia e la motivazione delle correzioni
