# Regola Critica: Helper Text

## Regola Fondamentale - SEMPRE APPLICARE

**Quando `helper_text` ha lo stesso valore della chiave del padre, DEVE essere impostato a stringa vuota `''`**

### ❌ ERRORE - Non Permesso
```php
'province' => [
    'description' => 'province',
    'helper_text' => 'province',  // ❌ ERRORE: stesso valore della chiave
    'placeholder' => 'province',
    'label' => 'province',
],
```

### ✅ CORRETTO - Regola Applicata
```php
'province' => [
    'description' => 'province',
    'helper_text' => '',  // ✅ CORRETTO: stringa vuota
    'placeholder' => 'province',
    'label' => 'province',
],
```

## Esempi di Applicazione

### Caso 1: Chiave = Valore
```php
// ❌ ERRORE
'email' => [
    'label' => 'email',
    'helper_text' => 'email',  // Stesso valore della chiave
],

// ✅ CORRETTO
'email' => [
    'label' => 'email',
    'helper_text' => '',  // Stringa vuota
],
```

### Caso 2: Valore Descritto
```php
// ✅ CORRETTO - Valore diverso dalla chiave
'email' => [
    'label' => 'Email',
    'helper_text' => 'Inserisci la tua email',  // Valore descrittivo
],
```

### Caso 3: Valore Tradotto
```php
// ✅ CORRETTO - Valore tradotto
'email' => [
    'label' => 'Email',
    'helper_text' => 'Geben Sie Ihre E-Mail-Adresse ein',  // Tedesco
],
```

## Regola di Validazione Automatica

### Controllo Obbligatorio
Prima di ogni commit o implementazione, verificare:

1. **Identificare chiave padre**: `'province' => [...]`
2. **Controllare helper_text**: Se `'helper_text' => 'province'` → ERRORE
3. **Correggere**: Impostare `'helper_text' => ''`

### Pattern di Correzione
```php
// PRIMA (ERRORE)
'field_name' => [
    'helper_text' => 'field_name',  // Stesso valore della chiave
],

// DOPO (CORRETTO)
'field_name' => [
    'helper_text' => '',  // Stringa vuota
],
```

## Implementazione DRY + KISS

### Struttura Standardizzata
```php
'field_name' => [
    'label' => 'Field Label',
    'placeholder' => 'Enter field value',
    'tooltip' => 'Field tooltip text',
    'helper_text' => '',  // Vuoto se non serve testo aggiuntivo
    'description' => 'Field description',
    'icon' => 'heroicon-o-icon',
    'color' => 'primary',
    'validation' => [
        'required' => 'Field is required',
    ],
],
```

### Regole di Qualità
1. **helper_text vuoto**: Se non serve testo aggiuntivo
2. **helper_text descrittivo**: Se serve spiegazione specifica
3. **Mai ripetere**: Il valore della chiave padre

## Checklist di Verifica

### Prima di Ogni Commit
- [ ] Controllare tutti i `helper_text`
- [ ] Verificare che non ripetano la chiave padre
- [ ] Impostare a `''` se necessario
- [ ] Testare la validazione

### Esempi di Controllo
```php
// ✅ CORRETTO
'email' => [
    'helper_text' => '',  // Vuoto
],

// ✅ CORRETTO
'email' => [
    'helper_text' => 'Inserisci la tua email',  // Descrittivo
],

// ❌ ERRORE - Da Correggere
'email' => [
    'helper_text' => 'email',  // Stesso valore della chiave
],
```

## Note Critiche

- **Regola SEMPRE applicabile**: Non ci sono eccezioni
- **Controllo automatico**: Implementare in CI/CD
- **Documentazione**: Aggiornare sempre le rules
- **Memories**: Mantenere sempre aggiornate

## Collegamenti

- [Regole Traduzioni SaluteOra](README.md#regole-critiche)
- [Audit Traduzioni Province Fields](translation_audit_province_fields.md)
- [Audit Traduzioni Comprehensive Fields](translation_audit_comprehensive_fields.md)

---

*Ultimo aggiornamento: 2025-01-06*
*Regola Critica - SEMPRE APPLICARE*
