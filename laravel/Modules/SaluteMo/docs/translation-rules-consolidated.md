# Regole Consolidate per le Traduzioni - Modulo SaluteMo

## Collegamenti Bidirezionali
- [Documentazione Root - Translation Standards](../../../docs/translations-system.md)
- [Modulo Lang - Translation Standards](../../Lang/docs/translation-standards.md)
- [Modulo Lang - Translation Keys Best Practices](../../Lang/docs/translation-keys-best-practices.md)
- [Modulo User - Translation Best Practices](../../User/docs/translation_best_practices.md)
- [Root Docs - Translation Helper Text Standards](../../../docs/translation-helper-text-standards.md)
- [Implementazione Appointment Report](./appointment_report_translations_implementation.md)

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
    'description' => 'Identificativo del paziente',
    'tooltip' => 'Paziente responsabile dell\'appuntamento',
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
// ✅ CORRETTO
'fields' => [
    'patient_id' => [
        'label' => 'Paziente',
        'placeholder' => 'Seleziona il paziente',
    ],
],

// ❌ ERRATO
'fields' => [
    'patient_id' => 'Paziente', // Struttura piatta
],
```

### 7. Organizzazione per Sezioni

**Struttura completa obbligatoria:**

```php
return [
    // Navigation
    'navigation' => [...],
    
    // Model labels
    'model' => [...],
    
    // Pages
    'pages' => [...],
    
    // Fields - Struttura espansa completa
    'fields' => [...],
    
    // Actions
    'actions' => [...],
    
    // Messages
    'messages' => [...],
    
    // Validation
    'validation' => [...],
];
```

## Benefici dell'Implementazione DRY + KISS

### DRY (Don't Repeat Yourself)
- **Struttura Espansa Unificata**: Tutti i campi seguono lo stesso pattern
- **Helper Text Rules**: Regola centralizzata per `helper_text`
- **Sintassi Array Moderna**: Uso consistente di `[]`
- **Strict Types**: Applicato a tutti i file
- **Documentazione Consolidata**: Regole in un unico posto

### KISS (Keep It Simple, Stupid)
- **Struttura Lineare**: Organizzazione logica e prevedibile
- **Naming Coerente**: Chiavi in inglese, valori in italiano
- **Documentazione Chiara**: Ogni sezione ben documentata
- **Pattern Ripetibili**: Struttura facilmente replicabile

## Pattern Identificati e Validati

### Pattern per Campi del Modello Report
```php
// Campi principali
'patient_id', 'appointment_id', 'has_mouth_or_teeth_pain', 
'mouth_teeth_pain_frequency', 'pregnancy_month', 'pregnancy_week',
'teeth_brushing_frequency', 'smokes', 'visits_dentist_yearly',
'has_diseases', 'specify_diseases', 'follows_diet_rules',
'uses_asl_clinic_for_dental_care', 'missing_teeth', 'specify_missing_teeth',
'more_info_missing_teeth', 'decayed_teeth', 'specify_decayed_teeth',
'more_info_decayed_teeth', 'has_fixed_prosthesis_or_implants',
'specify_prosthesis_or_implants', 'more_info_prosthesis', 'has_tartar',
'specify_tartar', 'more_info_tartar', 'has_plaque', 'specify_plaque',
'more_info_plaque', 'needs_more_dental_care', 'further_notes', 'invoice'
```

### Pattern per Azioni CRUD
```php
'actions' => [
    'create' => [
        'label' => 'Nuovo Elemento',
        'icon' => 'heroicon-o-plus',
        'tooltip' => 'Crea un nuovo elemento',
        'success' => 'Elemento creato con successo',
        'error' => 'Errore durante la creazione',
        'confirmation' => 'Sei sicuro di voler creare questo elemento?',
        'helper_text' => '',
    ],
    // ... altre azioni
],
```

## Checklist Implementazione Aggiornata

### ✅ Pre-Implementazione
- [x] Studio modello e campi `$fillable`
- [x] Analisi documentazione traduzioni esistenti
- [x] Identificazione pattern e regole da seguire
- [x] Verifica regole DRY + KISS
- [x] Studio migrazioni correlate (locali e cross-module)

### ✅ Durante Implementazione
- [x] Sintassi array breve `[]` invece di `array()`
- [x] `declare(strict_types=1);` incluso
- [x] Struttura espansa completa per tutti i campi
- [x] Helper text rules rispettate
- [x] Chiavi in inglese, valori in italiano
- [x] Organizzazione logica per sezioni
- [x] Solo aggiungere/migliorare traduzioni (mai rimuovere)

### ✅ Post-Implementazione
- [x] Documentazione aggiornata nel modulo
- [x] Collegamenti bidirezionali creati
- [x] Validazione sintassi PHP
- [x] Coerenza con altre traduzioni verificata
- [x] Test caricamento traduzioni
- [x] Aggiornamento regole interne

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
*Versione: 1.4*
*Compatibilità: Laravel 12.x, Filament 3.x*
