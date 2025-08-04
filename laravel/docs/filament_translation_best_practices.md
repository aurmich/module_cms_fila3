# Filament Translation Best Practices

## Data: 2025-01-06

## REGOLA CRITICA: MAI usare ->label()

### ❌ ERRORE CRITICO - NON FARE MAI QUESTO
```php
// ❌ ERRORE - Non usare mai ->label()
TextColumn::make('name')->label('Nome')
Action::make('save')->label('Salva')
Select::make('status')->label('Stato')
TextInput::make('email')->label('Email')
```

### ✅ CORRETTO - Sistema Traduzioni Automatico
```php
// ✅ CORRETTO - Usa il sistema di traduzioni automatico
TextColumn::make('name')
Action::make('save')
Select::make('status')
TextInput::make('email')
```

## Sistema Traduzioni Automatico

### Come Funziona
- Il `LangServiceProvider` gestisce automaticamente le traduzioni
- Le chiavi vengono generate automaticamente dal nome del campo
- Struttura: `modulo::risorsa.fields.campo.label`

### Implementazione Corretta

#### 1. Prima implementa le traduzioni
```php
// File: Modules/User/lang/it/fields.php
return [
    'name' => [
        'label' => 'Nome',
        'placeholder' => 'Inserisci nome',
        'tooltip' => 'Nome completo dell\'utente',
        'helper_text' => 'Nome e cognome dell\'utente',
    ],
    'email' => [
        'label' => 'Email',
        'placeholder' => 'Inserisci email',
        'tooltip' => 'Indirizzo email dell\'utente',
        'helper_text' => 'Email valida per le comunicazioni',
    ],
];
```

#### 2. Poi usa il componente senza ->label()
```php
// ✅ CORRETTO
TextColumn::make('name')
TextColumn::make('email')
```

## Struttura Traduzioni Obbligatoria

### Struttura Espansa Completa
```php
'field_name' => [
    'label' => 'Etichetta',
    'placeholder' => 'Placeholder diverso',
    'help' => 'Aiuto specifico',
    'description' => 'Descrizione campo',
    'tooltip' => 'Tooltip informativo', // OBBLIGATORIO
    'helper_text' => '', // Vuoto se diverso da placeholder
],
```

### Regole Specifiche
- **MAI** usare `->label()` nei componenti Filament
- **SEMPRE** struttura espansa completa
- **SEMPRE** `declare(strict_types=1);`
- **SEMPRE** sintassi moderna `[]` invece di `array()`

## Sincronizzazione Lingue

### Regola Critica
- **TUTTI** i file `lang/en/` devono avere le stesse voci di `lang/it/`
- **SEMPRE** confrontare file IT e EN prima di modifiche
- **SEMPRE** aggiungere nuove voci in entrambe le lingue
- **NUOVO**: Aggiungere sempre anche traduzioni tedesche (DE)

### Esempio Sincronizzazione
```php
// File: Modules/User/lang/it/fields.php
'status' => [
    'label' => 'Stato',
    'placeholder' => 'Seleziona stato',
    'tooltip' => 'Stato attuale dell\'elemento',
    'helper_text' => 'Stato attivo o inattivo',
],

// File: Modules/User/lang/en/fields.php
'status' => [
    'label' => 'Status',
    'placeholder' => 'Select status',
    'tooltip' => 'Current element status',
    'helper_text' => 'Active or inactive status',
],

// File: Modules/User/lang/de/fields.php
'status' => [
    'label' => 'Status',
    'placeholder' => 'Status auswählen',
    'tooltip' => 'Aktueller Elementstatus',
    'helper_text' => 'Aktiver oder inaktiver Status',
],
```

## Esempi di Errori Comuni

### ❌ ERRORE - Label hardcoded
```php
TextColumn::make('user_name')->label('Nome Utente')
```

### ✅ CORRETTO - Traduzione automatica
```php
// Prima implementa in lang/it/fields.php
'user_name' => [
    'label' => 'Nome Utente',
    'placeholder' => 'Inserisci nome utente',
    'tooltip' => 'Nome completo dell\'utente',
    'helper_text' => 'Nome e cognome dell\'utente',
],

// Poi usa senza ->label()
TextColumn::make('user_name')
```

### ❌ ERRORE - Label in inglese
```php
TextColumn::make('status')->label('Status')
```

### ✅ CORRETTO - Traduzione italiana
```php
// Prima implementa in lang/it/fields.php
'status' => [
    'label' => 'Stato',
    'placeholder' => 'Seleziona stato',
    'tooltip' => 'Stato attuale dell\'elemento',
    'helper_text' => 'Stato attivo o inattivo',
],

// Poi usa senza ->label()
TextColumn::make('status')
```

## Checklist Pre-Implementazione

Prima di usare qualsiasi componente Filament:

- [ ] Implementare traduzioni in `lang/it/fields.php`
- [ ] Implementare traduzioni in `lang/en/fields.php`
- [ ] Implementare traduzioni in `lang/de/fields.php`
- [ ] Verificare struttura espansa (label, placeholder, tooltip, helper_text)
- [ ] Non usare mai `->label()` nel codice
- [ ] Verificare sincronizzazione tra lingue
- [ ] Testare traduzioni in ambiente di sviluppo

## Verifica Automatica

### PHPStan Rule (Ideale)
```php
// Regola PHPStan per rilevare ->label()
// Implementare in phpstan.neon
rules:
    - rule: Never use ->label() in Filament components
```

### Code Review Checklist
- [ ] Nessun `->label()` nel codice
- [ ] Tutte le traduzioni implementate
- [ ] Struttura espansa completa
- [ ] Sincronizzazione IT/EN/DE
- [ ] Test traduzioni funzionanti

## Penalità per Violazioni

### Livello 1 - Warning
- Commento nel code review
- Richiesta di correzione

### Livello 2 - Blocco
- Blocco del merge
- Correzione obbligatoria

### Livello 3 - Sanzione
- Documentazione della violazione
- Training obbligatorio

## Collegamenti

- [Translation Standards](translation_standards.md)
- [LangServiceProvider Documentation](lang_service_provider.md)
- [UI Module Best Practices](../Modules/UI/docs/never_use_label_rule.md)

## Memoria Permanente

**RICORDA SEMPRE**: 
- MAI `->label()` 
- SEMPRE traduzioni nei file lang/
- SEMPRE struttura espansa
- SEMPRE sincronizzazione IT/EN/DE

*Ultimo aggiornamento: 2025-01-06* 