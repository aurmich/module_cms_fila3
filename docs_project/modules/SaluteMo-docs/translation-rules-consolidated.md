# Regole Consolidate per le Traduzioni - Modulo SaluteMo

## Collegamenti Bidirezionali
- [Documentazione Root - Translation Standards](../../../docs/translations-system.md)
- [Modulo Lang - Translation Standards](../../Lang/docs/translation-standards.md)
- [Modulo Lang - Translation Keys Best Practices](../../Lang/docs/translation-keys-best-practices.md)
- [Modulo User - Translation Best Practices](../../User/docs/translation_best_practices.md)
- [Root Docs - Translation Helper Text Standards](../../../docs/translation-helper-text-standards.md)

## Regole Critiche Consolidate

### 1. Struttura Espansa Obbligatoria

**SEMPRE utilizzare la struttura espansa completa per ogni campo:**

```php
'field_name' => [
    'label' => 'Etichetta Campo',
    'placeholder' => 'Testo segnaposto',
    'help' => 'Testo di aiuto descrittivo',
    'description' => 'Descrizione dettagliata del campo',
    'tooltip' => 'Tooltip informativo',
    'helper_text' => '', // Vuoto se uguale alla chiave, altrimenti testo descrittivo
],
```

### 2. Helper Text Rules (CRITICA)

**Regola Fondamentale**: Se `helper_text` è uguale alla chiave dell'array, DEVE essere impostato a stringa vuota (`''`).

#### ✅ CORRETTO
```php
'patient_id' => [
    'label' => 'Paziente',
    'placeholder' => 'Seleziona il paziente',
    'help' => 'Scegli il paziente per questo appuntamento',
    'description' => 'Il paziente che ha prenotato l\'appuntamento',
    'tooltip' => 'Il paziente responsabile dell\'appuntamento',
    'helper_text' => '', // Vuoto perché diverso da 'patient_id'
],
```

#### ❌ ERRATO
```php
'patient_id' => [
    'label' => 'Paziente',
    'helper_text' => 'patient_id', // ERRORE: uguale alla chiave
],
```

### 3. Sintassi Array Moderna (CRITICA)

**SEMPRE utilizzare la sintassi array breve:**

```php
// ✅ CORRETTO
return [
    'field' => [
        'label' => 'Etichetta',
    ],
];

// ❌ ERRATO
return array(
    'field' => array(
        'label' => 'Etichetta',
    ),
);
```

### 4. Strict Types Obbligatorio

**SEMPRE includere `declare(strict_types=1);` all'inizio di ogni file:**

```php
<?php

declare(strict_types=1);

return [
    // contenuto del file
];
```

### 5. Posizionamento e Namespace

- **Posizionamento**: `Modules/{ModuleName}/lang/{locale}/`
- **Namespace**: Mai includere segmento 'App'
- **Strict Types**: `declare(strict_types=1);` obbligatorio

### 6. Naming Convention

#### Chiavi di Traduzione
- ❌ **MAI** chiavi in italiano: `__('Accedi')`, `__('Registrati')`
- ✅ **SEMPRE** chiavi strutturate in inglese: `__('auth.login.button.label')`
- **Formato**: `snake_case` per le chiavi
- **Struttura**: `tipo.entità.elemento` (es. `fields.patient.birth_date.label`)

#### Esempi Corretti
```php
// ❌ ERRATO
{{ __('Accedi') }}
{{ __('Profilo') }}
{{ __('Logout') }}

// ✅ CORRETTO
{{ __('auth.login.button.label') }}
{{ __('user.profile.navigation.label') }}
{{ __('auth.logout.button.label') }}
```

### 7. Integrazione con Filament

#### NO ->label() nei Componenti
```php
// ❌ ERRATO
TextInput::make('patient_id')
    ->label('Paziente')
    ->placeholder('Seleziona paziente')
    ->helperText('Scegli il paziente');

// ✅ CORRETTO
TextInput::make('patient_id')
// Le traduzioni sono gestite automaticamente dal LangServiceProvider
```

#### Struttura File per Filament Resources
```php
return [
    'navigation' => [
        'label' => 'Etichetta Menu',
        'group' => 'Gruppo Menu',
        'icon' => 'heroicon-o-icon-name',
        'tooltip' => 'Tooltip navigazione',
        'helper_text' => '',
    ],
    'fields' => [
        // Struttura espansa per ogni campo
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Nuovo',
            'modal_heading' => 'Crea Nuovo Elemento',
            'modal_description' => 'Inserisci i dati per creare un nuovo elemento',
            'tooltip' => 'Crea un nuovo record',
            'helper_text' => '',
        ],
    ],
    'messages' => [
        'created' => 'Elemento creato con successo',
        'updated' => 'Elemento aggiornato con successo',
        'deleted' => 'Elemento eliminato con successo',
    ],
    'validation' => [
        'field_required' => 'Il campo è obbligatorio',
        'field_invalid' => 'Il campo non è valido',
    ],
];
```

### 8. Organizzazione e Manutenibilità

#### Sezioni Standard
- `model`: Metadati del modello
- `navigation`: Navigazione e menu
- `pages`: Titoli e descrizioni delle pagine
- `fields`: Campi del form con struttura espansa
- `actions`: Azioni e pulsanti
- `messages`: Messaggi di feedback
- `validation`: Messaggi di validazione
- `statuses`: Stati e opzioni enum

#### Best Practices
1. **Coerenza**: Nomenclatura coerente per chiavi simili
2. **Completezza**: Tradurre tutte le chiavi in tutte le lingue
3. **Struttura**: Mantenere gerarchia logica e chiara
4. **Manutenibilità**: File separati per contesto
5. **Riusabilità**: Evitare duplicazioni

### 9. Validazione e Controlli

#### Checklist Pre-Modifica
- [ ] Verificare che tutte le chiavi seguano la convenzione snake_case
- [ ] Controllare che helper_text non sia uguale alla chiave
- [ ] Assicurarsi che ogni campo abbia la struttura espansa completa
- [ ] Verificare che non ci siano chiavi in italiano
- [ ] Controllare la presenza di declare(strict_types=1)
- [ ] Verificare l'uso della sintassi array breve `[]`

#### Controlli Post-Modifica
- [ ] Validare sintassi PHP del file
- [ ] Verificare coerenza con altre traduzioni del modulo
- [ ] Testare che le traduzioni vengano caricate correttamente
- [ ] Aggiornare documentazione se necessario

## Applicazione al File patient.php

Il file `Modules/SaluteMo/lang/it/patient.php` è stato completamente corretto:

### ✅ Problemi Risolti
1. **Sintassi Array Moderna**: Convertito da `array()` a `[]`
2. **Strict Types**: Aggiunto `declare(strict_types=1);`
3. **Struttura Espansa**: Tutti i campi ora hanno struttura completa
4. **Helper Text Rules**: Tutti i `helper_text` sono corretti
5. **Duplicazioni Rimosse**: Eliminati campi duplicati
6. **Campi Tradotti**: Tutti i campi sono ora tradotti correttamente
7. **Organizzazione**: Struttura coerente con le best practice

### ✅ Miglioramenti Implementati
1. **Sezioni Logiche**: Aggiunte sezioni per organizzare i campi
2. **Azioni Complete**: Ogni azione ha success, error, confirmation
3. **Filtri Migliorati**: Aggiunti tooltip e helper_text
4. **Validazione Estesa**: Messaggi di validazione specifici
5. **Coerenza Terminologica**: Terminologia uniforme in tutto il file

## Regole Critiche Aggiornate (Gennaio 2025)

### 🔥 REGOLE FONDAMENTALI DA RICORDARE SEMPRE

1. **MAI usare `array()`** - SEMPRE usare `[]`
2. **MAI dimenticare `declare(strict_types=1);`**
3. **MAI avere `helper_text` uguale alla chiave** - SEMPRE stringa vuota `''`
4. **MAI rimuovere traduzioni esistenti** - SOLO aggiungere o migliorare
5. **MAI usare chiavi in italiano** - SEMPRE chiavi strutturate in inglese
6. **MAI usare `->label()` nei componenti Filament** - Lasciare al LangServiceProvider
7. **MAI documentare nella root docs** - SEMPRE nella docs del modulo specifico

### 📋 PATTERN CORRETTI IDENTIFICATI

#### Struttura Campo Completa
```php
'field_name' => [
    'label' => 'Etichetta Campo',
    'placeholder' => 'Testo segnaposto',
    'help' => 'Testo di aiuto descrittivo',
    'description' => 'Descrizione dettagliata',
    'tooltip' => 'Tooltip informativo',
    'helper_text' => '', // SEMPRE vuoto se diverso dalla chiave
],
```

#### Struttura Azione Completa
```php
'action_name' => [
    'label' => 'Etichetta Azione',
    'icon' => 'heroicon-o-icon-name',
    'tooltip' => 'Descrizione tooltip',
    'success' => 'Messaggio di successo',
    'error' => 'Messaggio di errore',
    'confirmation' => 'Messaggio di conferma', // Per azioni distruttive
    'helper_text' => '',
],
```

#### Struttura File Completa
```php
<?php

declare(strict_types=1);

return [
    'navigation' => [...],
    'model' => [...],
    'pages' => [...],
    'fields' => [...],
    'actions' => [...],
    'filters' => [...],
    'bulk_actions' => [...],
    'messages' => [...],
    'notifications' => [...],
    'validation' => [...],
];
```

## Regole Comportamentali Aggiornate (Gennaio 2025)

### 🔄 PROCESSO DI AGGIORNAMENTO TRADUZIONI

#### Fase 1: Studio e Analisi
1. **Studiare tutte le migrazioni correlate** (locali e cross-module)
2. **Studiare le documentazioni del modulo** relative alle migrazioni
3. **Analizzare le traduzioni esistenti** per identificare pattern
4. **Identificare problemi e miglioramenti** necessari

#### Fase 2: Implementazione
1. **MAI rimuovere chiavi di traduzione** - SOLO aggiungere o migliorare
2. **SEMPRE usare sintassi array breve** `[]` invece di `array()`
3. **SEMPRE includere `declare(strict_types=1);`**
4. **SEMPRE struttura espansa completa** per tutti i campi
5. **SEMPRE rispettare helper_text rules**

#### Fase 3: Documentazione
1. **Aggiornare solo le docs del modulo** - MAI le root docs
2. **Aggiornare regole interne** per riflettere cambiamenti comportamentali
3. **Mantenere collegamenti bidirezionali** tra documentazioni
4. **Validare con checklist** post-modifica

### 🎯 COMPORTAMENTO SPECIFICO PER TASK

#### Per Aggiornamenti Traduzioni
- **Prima**: Studio migrazioni + docs + traduzioni esistenti
- **Durante**: Solo aggiungere/migliorare, mai rimuovere
- **Dopo**: Aggiornare solo module docs, non root docs

#### Per Documentazione
- **Posizionamento**: `Modules/{ModuleName}/docs/` - MAI root docs
- **Contenuto**: Regole specifiche del modulo + collegamenti bidirezionali
- **Aggiornamento**: Contemporaneo alle modifiche del codice

#### Per Regole Interne
- **Memorizzazione**: Pattern corretti identificati
- **Applicazione**: Sempre prima di ogni modifica
- **Validazione**: Checklist pre e post modifica

### 📊 CHECKLIST COMPORTAMENTALE

#### Pre-Modifica
- [ ] Studio migrazioni correlate (locali e cross-module)
- [ ] Studio docs del modulo relative alle migrazioni
- [ ] Analisi traduzioni esistenti
- [ ] Identificazione problemi e miglioramenti
- [ ] Verifica regole interne aggiornate

#### Durante Modifica
- [ ] Solo aggiungere/migliorare traduzioni
- [ ] Mai rimuovere chiavi esistenti
- [ ] Usare sempre sintassi array breve `[]`
- [ ] Includere `declare(strict_types=1);`
- [ ] Struttura espansa completa per tutti i campi
- [ ] Rispettare helper_text rules

#### Post-Modifica
- [ ] Aggiornare solo module docs (non root docs)
- [ ] Aggiornare regole interne
- [ ] Validare sintassi PHP
- [ ] Verificare coerenza con altre traduzioni
- [ ] Testare caricamento traduzioni

## Aggiornamenti Futuri

Quando si aggiungono nuovi campi o si modificano traduzioni:
1. Seguire sempre la struttura espansa
2. Aggiornare questa documentazione
3. Mantenere collegamenti bidirezionali
4. Validare con checklist

---

*Ultimo aggiornamento: Gennaio 2025*
*Versione: 1.3*
*Compatibilità: Laravel 12.x, Filament 3.x*
