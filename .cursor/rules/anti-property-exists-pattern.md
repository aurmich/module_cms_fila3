# Regola Critica: MAI USARE property_exists con Modelli Laravel

## ⚠️ REGOLA ASSOLUTA

**MAI utilizzare `property_exists()` con modelli Laravel o oggetti Eloquent.**

## Problema

`property_exists()` è problematico perché:
- È una funzione PHP generica che non conosce l'architettura Laravel
- Può dare falsi positivi con proprietà dinamiche di Eloquent
- È meno performante e meno leggibile
- Non segue i principi DRY e KISS
- Può causare errori di tipo e comportamenti imprevedibili

## Soluzioni Corrette

### Per Modelli Eloquent
```php
use Modules\Xot\Actions\Cast\SafeEloquentCastAction;

// Verifica esistenza attributo
if (app(SafeEloquentCastAction::class)->hasAttribute($model, 'email')) {
    $email = app(SafeEloquentCastAction::class)->getStringAttribute($model, 'email', '');
}

// Cast sicuro a tipo specifico
$age = app(SafeEloquentCastAction::class)->getIntAttribute($model, 'age', 0);
```

### Per Oggetti Generici
```php
use Modules\Xot\Actions\Cast\SafeObjectCastAction;

// Verifica esistenza proprietà
if (app(SafeObjectCastAction::class)->hasProperty($object, 'value')) {
    $value = app(SafeObjectCastAction::class)->getStringProperty($object, 'value', '');
}
```

## Azioni di Cast Disponibili

- `SafeEloquentCastAction` - Per modelli Eloquent
- `SafeObjectCastAction` - Per oggetti generici
- `SafeIntCastAction` - Per cast a interi
- `SafeFloatCastAction` - Per cast a float
- `SafeStringCastAction` - Per cast a string
- `SafeBooleanCastAction` - Per cast a boolean
- `SafeArrayCastAction` - Per cast ad array

## Collegamenti

- [Documentazione Azioni Cast](../../laravel/Modules/Xot/docs/cast-actions.md)
- [Anti-Patterns Root](../../docs/anti-patterns.md)
- [Guidelines AI](../../laravel/.ai/guidelines/CRITICAL_PROPERTY_EXISTS_RULE.md)

---

**Questa regola è CRITICA e va applicata SEMPRE. Violarla causa problemi di sicurezza, performance e manutenibilità.**
