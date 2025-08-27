---
description: Pattern per test unitari Eloquent senza boot del container
---

# Testing Eloquent (Unit) – Istanziazione via Reflection senza boot

## Problema
- Istanziare direttamente un modello Eloquent in test unit (es. `new Model()`) avvia il boot dei trait e necessita del container (es. binding `config`).
- In contesti di unit test puri questo causa `BindingResolutionException: Target class [config] does not exist` e warning su trait initializer.

## Regola
- Per testare metodi protetti/privati/di base (es. `casts()`), usare Reflection per:
  1. Ottenere il `ReflectionMethod` del metodo da testare.
  2. Rendere accessibile il metodo (`setAccessible(true)`).
  3. Creare l'istanza con `newInstanceWithoutConstructor()` per evitare il boot di Eloquent.

## Esempio (estratto reale da `Modules/SaluteMo/tests/Unit/BaseModelTest.php`)
```php
$reflection = new \ReflectionClass(TestBaseModel::class);
$method = $reflection->getMethod('casts');
$method->setAccessible(true);

// Evita il boot di Eloquent e la dipendenza dal container
$instance = $reflection->newInstanceWithoutConstructor();

expect($method->invoke($instance))->toBeArray();
```

## Anti-pattern
- `new Model()` in unit test quando non è necessario l'ambiente applicativo.
- Forzare il container nei test unitari per far passare il boot del modello.

## Applicabilità
- Test unitari su metodi protetti/di base dei modelli (p.es. `casts()`).
- Non usare per integrazione/feature test: in quei casi è corretto istanziare normalmente il modello.

## Collegamenti
- Modulo: `Modules/SaluteMo/tests/Unit/BaseModelTest.php`
- Doc modulo: `Modules/SaluteMo/docs/testing/eloquent-unit-tests.md`
- Doc root: `docs/testing/eloquent-unit-tests.md`
```diff
+ Ultimo aggiornamento: 2025-08-25
```
