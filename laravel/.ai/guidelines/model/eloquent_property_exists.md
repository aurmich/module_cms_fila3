# ERRORE CRITICO: MAI USARE property_exists() CON MODELLI ELOQUENT

## Problema Identificato
L'uso di `property_exists()` con modelli Laravel Eloquent è un errore critico che può causare comportamenti imprevedibili e bug difficili da tracciare.

## Perché è un Errore
I modelli Eloquent utilizzano proprietà magiche (`__get()` e `__set()`) per accedere agli attributi del database:

- Gli attributi del database **NON** sono proprietà PHP reali del modello
- `property_exists($model, 'attributo')` restituirà **SEMPRE `false`** per attributi del database
- Questo porta a logica applicativa errata e comportamenti imprevedibili
- Causa problemi di analisi statica con PHPStan

## Alternative Corrette e Sicure

### 1. Per verificare se un attributo è impostato
```php
// ❌ ERRATO
if (property_exists($model, 'attributo')) { ... }

// ✅ CORRETTO
if (isset($model->attributo)) { ... }
```

### 2. Per verificare se una colonna esiste nel database
```php
// ❌ ERRATO
if (property_exists($model, 'colonna')) { ... }

// ✅ CORRETTO
if (array_key_exists('colonna', $model->getAttributes())) { ... }
```

### 3. Per verificare se esiste un accessor
```php
// ❌ ERRATO
if (property_exists($model, 'nome_completo')) { ... }

// ✅ CORRETTO
if ($model->hasGetMutator('nome_completo')) { ... }
```

### 4. Per verificare se esiste l'ID o chiave primaria
```php
// ❌ ERRATO
if (property_exists($model, 'id') && $model->id) { ... }

// ✅ CORRETTO
if ($model instanceof Model && $model->getKey() !== null) { ... }
```

### 5. Per confrontare istanze di modelli
```php
// ❌ ERRATO
if (property_exists($modelA, 'id') && property_exists($modelB, 'id') && $modelA->id === $modelB->id) { ... }

// ✅ CORRETTO
if ($modelA instanceof Model && $modelB instanceof Model && $modelA->is($modelB)) { ... }
```

## Altri Metodi Utili di Laravel
- `$model->getAttribute('attributo')` - Ottiene un attributo in modo sicuro (null se non esiste)
- `$model->hasAttribute('attributo')` - Verifica se un attributo esiste
- `$model->getAttributes()` - Ottiene tutti gli attributi come array
- `$model->getKey()` - Ottiene il valore della chiave primaria
- `$model->is($otherModel)` - Confronta due istanze di modello
- `$model->exists` - Verifica se il modello esiste nel database

## Casi Particolari
- Per gestire relazioni: usa `$model->relationLoaded('relation')` o `$model->getRelation('relation')`
- Per verificare se un model è di un certo tipo: usa `$model instanceof ModelClass`
- Per verificare enum e altri tipi speciali: verifica il tipo esplicito con `$model->getAttribute('type') instanceof \BackedEnum`

## Impatto dell'Errore
L'uso di `property_exists()` su modelli Eloquent può portare a:
- Condizioni che non si attivano mai (false negativo)
- Accessi a proprietà inesistenti (null pointer)
- Bug difficili da debuggare
- Comportamento inconsistente tra ambienti

Tutti i casi di `property_exists()` su modelli Eloquent devono essere sostituiti con le alternative sicure sopra elencate.