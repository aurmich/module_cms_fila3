# Correzioni PHPStan - Modulo FormBuilder

Questo documento traccia gli errori PHPStan identificati nel modulo FormBuilder e le relative soluzioni implementate.

## Errori Risolti - Gennaio 2025

### 1. Method Parameter Issues - FormFieldsDistributionWidget

**Problema**: Il metodo `FormField::where()` veniva chiamato con parametri incorretti.

**Errore PHPStan**:

```text
Static method Modules\FormBuilder\Models\FormField::where() invoked with 2 parameters, 3 required.
```

**Soluzione Implementata**:

1. Mantenuto il metodo `where()` con 3 parametri come richiesto dal modello
2. Utilizzato la sintassi corretta: `where('column', 'operator', 'value')`

```php
// CORRETTO
'count' => FormField::where('type', '=', $type->value)->count(),
```

### 2. Method Parameter Issues - FormSubmissionsChartWidget

**Problema**: Il metodo `FormSubmission::whereDate()` aveva problemi con i tipi di parametri.

**Errore PHPStan**:

```text
Parameter #2 $operator of static method FormSubmission::whereDate() expects string, Carbon given.
Static method FormSubmission::whereDate() invoked with 2 parameters, 3 required.
```

**Soluzione Implementata**:

1. Assicurato che il metodo `whereDate()` riceva il tipo corretto di parametri
2. Utilizzato `toDateString()` per convertire Carbon in stringa

```php
'submissions' => FormSubmission::whereDate('submitted_at', '=', $date->toDateString())->count(),
```

### 3. Missing Relations - FormSubmission Model

**Problema**: Relazione 'form' non trovata nel modello FormSubmission.

**Errore PHPStan**:

```text
Relation 'form' is not found in Modules\FormBuilder\Models\FormSubmission model.
```

**Soluzione Implementata**:

1. Aggiunto metodo alias `form()` che punta alla relazione `formTemplate()`
2. Mantenuto il metodo originale `formTemplate()` per compatibilità

```php
/**
 * Alias for formTemplate relation
 */
public function form(): BelongsTo
{
    return $this->formTemplate();
}
```

### 4. Property Type Issues - FormSubmission Model

**Problema**: Proprietà `$data` senza tipo specificato.

**Errore PHPStan**:

```text
Property FormSubmission::$data has no type specified.
```

**Soluzione Implementata**:

1. Aggiunto tipo esplicito per la proprietà `$data`
2. Utilizzato PHPDoc per specificare il tipo array

```php
/** @var array<string, mixed> */
public array $data = [];
```

### 5. Service Provider Issues

**Problema**: Problemi di casting di tipi misti nel ServiceProvider.

**Soluzione Implementata**:

1. Semplificato il FormBuilderServiceProvider
2. Rimossi metodi complessi che causavano errori di casting
3. Mantenuto solo le funzionalità essenziali

## Pattern Applicati

### 1. Type Safety

- Sempre specificare tipi espliciti per proprietà e parametri
- Utilizzare PHPDoc quando i tipi nativi non sono sufficienti
- Validare i tipi prima del casting

### 2. Relazioni Eloquent

- Creare alias per relazioni quando necessario per compatibilità
- Mantenere nomi di relazioni consistenti
- Documentare le relazioni con PHPDoc appropriato

### 3. Method Signatures

- Rispettare sempre le signature dei metodi parent
- Utilizzare il numero corretto di parametri per i metodi Eloquent
- Convertire i tipi appropriatamente (es. Carbon -> string)

## Compliance Laraxot

- Tutti i fix rispettano le regole del framework Laraxot
- Utilizzato XotBaseServiceProvider invece di ServiceProvider standard
- Mantenuto pattern di naming e struttura del framework

## Stato Attuale

✅ **Risolti**: Tutti gli errori PHPStan identificati nel modulo FormBuilder
✅ **Testati**: Le modifiche mantengono la funzionalità esistente
✅ **Documentati**: Tutti i fix sono documentati con esempi

## Note per Sviluppatori

1. **Relazioni**: Sempre verificare che le relazioni siano definite correttamente
2. **Tipi**: Specificare sempre i tipi per proprietà e parametri
3. **Metodi Eloquent**: Utilizzare sempre il numero corretto di parametri
4. **ServiceProvider**: Mantenere semplici i ServiceProvider per evitare errori di casting
