# Metodi Void nei Modelli Eloquent

## Problema

Quando si definisce un metodo con tipo di ritorno `void` in un modello Eloquent, è necessario assicurarsi che nessun valore venga effettivamente restituito, nemmeno implicitamente.

## Cause Comuni

1. **Ritorno implicito di valori**:
   - Eloquent restituisce valori per operazioni comuni come `save()`, `update()`, `delete()`
   - Se queste sono le ultime istruzioni in un metodo `void`, il loro valore viene implicitamente restituito

2. **Incompatibilità con operatori di callback**:
   - Le arrow function con tipo `: void` non devono restituire valori
   - Errore comune: `fn (Model $record): void => $record->metodo()`
   - Se `metodo()` restituisce un valore, viola la dichiarazione `void`

## Soluzione

### Per metodi di modello

```php
// Errato
public function activate(): void
{
    $this->update(['active' => true]); // Problema: update() restituisce bool
}

// Corretto
public function activate(): void
{
    $this->update(['active' => true]);
    return; // Previene il ritorno implicito
}
```

### Per callback in risorse Filament

```php
// Errato
->action(fn (Studio $record): void => $record->activate())

// Approccio 1: Rimuovere tipo di ritorno void
->action(fn (Studio $record) => $record->activate())

// Approccio 2: Usare statement completo per prevenire ritorno
->action(function (Studio $record): void {
    $record->activate();
    return;
})
```

## Perché Questo è Importante

- PHP 8+ è più rigoroso riguardo ai tipi di ritorno
- I metodi dichiarati come `void` non devono restituire alcun valore, nemmeno `null`
- Errori di tipo causano crash a runtime e possono bloccare funzionalità critiche

## Riferimenti

- [PHP Manual: void](https://www.php.net/manual/en/language.types.void.php)
- [Laravel Eloquent Documentation](https://laravel.com/docs/eloquent)
- [Modules\SaluteOra\Models\Studio](/var/www/html/_bases/base_saluteora/laravel/Modules/SaluteOra/app/Models/Studio.php)
- [Modules\Xot\docs\type-declarations.md](/var/www/html/_bases/base_saluteora/laravel/Modules/Xot/docs/type-declarations.md)
