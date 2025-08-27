# Testing Eloquent (Unit) – Reflection senza boot del container

- **Problema**: `new Model()` in unit test avvia il boot dei trait Eloquent e richiede il container (`config`, eventi, ecc.), causando `BindingResolutionException` e warning.
- **Regola**: per testare metodi protetti (es. `casts()`), usare Reflection e `newInstanceWithoutConstructor()`.

## Esempio (SaluteMo)
```php
$rc = new \ReflectionClass(TestBaseModel::class);
$method = $rc->getMethod('casts');
$method->setAccessible(true);
$instance = $rc->newInstanceWithoutConstructor();
expect($method->invoke($instance))->toBeArray();
```

## Anti-pattern
- Forzare l’istanza del modello con `new` in test unit puri.
- Iniettare manualmente binding di container solo per far passare il test.

## Quando usarla
- Unit test su metodi protetti/di base dei modelli.
- Non per feature/integration test (lì è corretto il boot normale).

## Collegamenti
- Modifica reale: `Modules/SaluteMo/tests/Unit/BaseModelTest.php`
- Doc modulo: `Modules/SaluteMo/docs/testing/eloquent-unit-tests.md`
- Doc root: `docs/testing/eloquent-unit-tests.md`

Aggiornamento: 2025-08-25