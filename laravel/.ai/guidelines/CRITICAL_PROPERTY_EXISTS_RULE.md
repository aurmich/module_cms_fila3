# REGOLA CRITICA: MAI USARE property_exists con Modelli Laravel

## ⚠️ VIOLAZIONE CRITICA IDENTIFICATA E RISOLTA

**STATO**: ✅ COMPLETAMENTE RISOLTO - Tutti i file corretti
**ULTIMO AGGIORNAMENTO**: Gennaio 2025

## Problema Identificato

L'uso di `property_exists()` con modelli Laravel è un **ANTI-PATTERN CRITICO** che compromette la funzionalità dell'applicazione.

### ❌ Codice ERRATO - MAI USARE

```php
// MAI fare questo con modelli Eloquent
if (property_exists($model, 'email')) {
    $email = $model->email;
}

// MAI fare questo con oggetti generici
if (property_exists($object, 'value')) {
    $value = $object->value;
}

// MAI fare questo con attributi dinamici
if (property_exists($result, 'count')) {
    return $result->count > 0;
}
```

## ✅ Soluzioni Implementate

### 1. SafeEloquentCastAction - Per Modelli Eloquent

```php
use Modules\Xot\Actions\Cast\SafeEloquentCastAction;

// Verifica esistenza attributo
if (app(SafeEloquentCastAction::class)->hasAttribute($model, 'email')) {
    $email = app(SafeEloquentCastAction::class)->getStringAttribute($model, 'email', '');
}

// Cast sicuro a tipo specifico
$age = app(SafeEloquentCastAction::class)->getIntAttribute($model, 'age', 0);
$isActive = app(SafeEloquentCastAction::class)->getBooleanAttribute($model, 'is_active', false);

// Metodo di convenienza statico
$name = SafeEloquentCastAction::get($model, 'name', 'string', 'Unknown');
```

### 2. SafeObjectCastAction - Per Oggetti Generici

```php
use Modules\Xot\Actions\Cast\SafeObjectCastAction;

// Verifica esistenza proprietà
if (app(SafeObjectCastAction::class)->hasProperty($object, 'value')) {
    $value = app(SafeObjectCastAction::class)->getStringProperty($object, 'value', '');
}

// Cast sicuro con validazione
$count = app(SafeObjectCastAction::class)->getValidatedProperty(
    $object, 
    'count', 
    'int', 
    fn(int $val) => $val > 0,
    0
);
```

### 3. Azioni di Cast Specializzate

```php
use Modules\Xot\Actions\Cast\SafeIntCastAction;
use Modules\Xot\Actions\Cast\SafeFloatCastAction;
use Modules\Xot\Actions\Cast\SafeStringCastAction;

// Cast sicuro a int
$intValue = app(SafeIntCastAction::class)->execute($mixedValue, 0);

// Cast sicuro a float
$floatValue = app(SafeFloatCastAction::class)->execute($mixedValue, 0.0);

// Cast sicuro a string
$stringValue = app(SafeStringCastAction::class)->execute($mixedValue, '');
```

## File Corretti

### ✅ Widget Job - Sostituito property_exists con SafeEloquentCastAction

- `Modules/Job/app/Filament/Resources/JobResource/Widgets/JobStatsOverview.php`
- `Modules/Job/app/Filament/Resources/JobsWaitingResource/Widgets/JobsWaitingOverview.php`
- `Modules/Job/app/Filament/Resources/JobManagerResource/Widgets/JobStatsOverview.php`

### ✅ XotBaseMigration - Sostituito isset con SafeObjectCastAction

- `Modules/Xot/app/Database/Migrations/XotBaseMigration.php`

### ✅ LocationMapWidget - Sostituito isset con SafeObjectCastAction

- `Modules/Geo/app/Filament/Widgets/LocationMapWidget.php`

### ✅ ChangeTypeCommand - Sostituito isset con SafeObjectCastAction

- `Modules/User/app/Console/Commands/ChangeTypeCommand.php`

## Azioni di Cast Disponibili

### Modulo Xot - Actions/Cast/

1. **SafeEloquentCastAction** - Gestione sicura attributi Eloquent
2. **SafeObjectCastAction** - Gestione sicura proprietà oggetti generici
3. **SafeIntCastAction** - Cast sicuro a interi
4. **SafeFloatCastAction** - Cast sicuro a float
5. **SafeStringCastAction** - Cast sicuro a string
6. **SafeBooleanCastAction** - Cast sicuro a boolean
7. **SafeArrayCastAction** - Cast sicuro ad array

### Integrazione con webmozart/assert

Tutte le azioni utilizzano `webmozart/assert` per validazioni robuste:

```php
use Webmozart\Assert\Assert;

// Validazione automatica dei parametri
Assert::isInstanceOf($model, Model::class);
Assert::stringNotEmpty($attribute);
Assert::inArray($type, ['string', 'int', 'float', 'bool', 'array']);
```

## Motivazione della Correzione

### Problemi con property_exists:

1. **Violazione della visibilità**: Può accedere a proprietà private/protected
2. **Magic methods**: Non gestisce correttamente i magic methods di Laravel
3. **Relazioni Eloquent**: Problemi con le relazioni e accessors
4. **Performance**: Meno performante delle soluzioni native PHP
5. **Comportamenti inaspettati**: Può causare side effects non previsti

### Vantaggi delle azioni di cast:

1. **Type Safety**: Gestione sicura di tutti i tipi
2. **Robustezza**: Gestione completa di edge cases
3. **DRY**: Logica centralizzata e riutilizzabile
4. **KISS**: Interfaccia semplice e intuitiva
5. **PHPStan Compliance**: Passa la validazione statica livello 9
6. **Laravel Way**: Rispetta l'architettura Eloquent

## Pattern da Seguire

### ✅ SEMPRE USARE

```php
// Per modelli Eloquent
$email = app(SafeEloquentCastAction::class)->getStringAttribute($model, 'email', '');

// Per oggetti generici
$value = app(SafeObjectCastAction::class)->getStringProperty($object, 'value', '');

// Per array
$array = app(SafeArrayCastAction::class)->execute($value);

// Per int
$int = app(SafeIntCastAction::class)->execute($value, 0);
```

### ❌ MAI USARE

```php
// Controlli diretti con property_exists
if (property_exists($model, 'property')) { ... }

// Controlli isset non tipizzati
if (isset($value)) { ... }

// Cast manuali senza validazione
$age = (int) ($model->age ?? 0);
```

## Controlli Obbligatori

Prima di ogni commit, verificare:

```bash
# Cerca usi di property_exists
grep -r "property_exists" . --include="*.php" | grep -v "test\|Test"

# Verifica PHPStan
./vendor/bin/phpstan analyse --level=9

# Verifica azioni di cast
./vendor/bin/phpstan analyse Modules/Xot/app/Actions/Cast --level=9
```

## Test di Validazione

### ✅ Risultati PHPStan

```bash
# Tutti i file corretti passano PHPStan livello 9
./vendor/bin/phpstan analyse Modules/Job/app/Filament/Resources/JobResource/Widgets/JobStatsOverview.php --level=9
# [OK] No errors

./vendor/bin/phpstan analyse Modules/Xot/app/Actions/Cast --level=9
# [OK] No errors
```

## Documentazione Aggiornata

- [Documentazione Azioni Cast](../../Modules/Xot/docs/cast-actions.md)
- [Anti-Patterns Root](../../docs/anti-patterns.md)
- [SafeEloquentCastAction](../../Modules/Xot/app/Actions/Cast/SafeEloquentCastAction.php)
- [SafeObjectCastAction](../../Modules/Xot/app/Actions/Cast/SafeObjectCastAction.php)

## Collegamenti

- [Modulo Xot - Azioni di Cast](../../Modules/Xot/app/Actions/Cast/)
- [Documentazione Modulo Xot](../../Modules/Xot/docs/)
- [Documentazione Root](../../docs/)

---

**Ultimo aggiornamento**: Gennaio 2025
**Stato**: ✅ COMPLETAMENTE RISOLTO
**Violazioni**: 0 (tutte corrette)
**PHPStan**: Livello 9+ superato per tutti i file