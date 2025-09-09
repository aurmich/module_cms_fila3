# Regola Critica: Utilizzo Azioni Cast Centralizzate

## Regola Fondamentale
**SEMPRE** utilizzare le azioni cast centralizzate in `Modules\Xot\Actions\Cast` per risolvere problemi di cast PHPStan. **MAI** creare logiche di cast custom.

## Azioni Disponibili

### SafeIntCastAction
```php
use Modules\Xot\Actions\Cast\SafeIntCastAction;

// Cast semplice
$duration = SafeIntCastAction::cast($mixedValue);

// Con range validation
$hour = SafeIntCastAction::castWithRange($value, 9, 17);

// Come ID positivo
$id = SafeIntCastAction::castAsId($value);
```

### SafeStringCastAction
```php
use Modules\Xot\Actions\Cast\SafeStringCastAction;

$name = SafeStringCastAction::cast($mixedValue);
```

### SafeFloatCastAction
```php
use Modules\Xot\Actions\Cast\SafeFloatCastAction;

$rate = SafeFloatCastAction::cast($mixedValue);
```

## Applicazione Obbligatoria

- **Factory**: Tutte le factory devono usare queste azioni per faker values
- **Seeder**: Tutti i seeder devono usare queste azioni per dati dinamici
- **Controllers**: Per input validation e cast sicuri
- **Models**: Per accessor/mutator che richiedono cast

## Esempio Correzione PHPStan

### Prima (Problematico)
```php
// ❌ ERRORE: mixed cannot be cast to string
$name = $this->faker->randomElement($types) . ' ' . $this->faker->lastName();

// ❌ ERRORE: mixed property access
$type->value;
```

### Dopo (Corretto)
```php
// ✅ CORRETTO: Uso azioni cast centralizzate
use Modules\Xot\Actions\Cast\SafeStringCastAction;

$type = SafeStringCastAction::cast($this->faker->randomElement($types));
$lastName = SafeStringCastAction::cast($this->faker->lastName());
$name = $type . ' ' . $lastName;
```

## Motivazione
- **DRY**: Un solo punto di verità per logiche di cast
- **Type Safety**: Conformità PHPStan livello 9+
- **Manutenibilità**: Gestione centralizzata degli edge cases
- **Coerenza**: Comportamento uniforme in tutto il codebase

## IMPORTANTE
Questa regola è **CRITICA** e va applicata **SEMPRE**. Aggiornare docs e memories ogni volta che si utilizzano queste azioni.

*Ultimo aggiornamento: gennaio 2025*
