# Errori di Validazione Custom in Laravel

## Best Practice

Usa sempre `ValidationException::withMessages()` per restituire errori custom:

```php
throw \Illuminate\Validation\ValidationException::withMessages([
    'campo' => ['Messaggio di errore personalizzato.'],
]);
```

## Anti-pattern

```php
throw new \Illuminate\Validation\ValidationException(
    validator([], [])->errors()->add('campo', 'Messaggio di errore.')
);
```

- Questo genera errori runtime e non è supportato.

## Motivazione
- Compatibilità con Livewire, Filament, Laravel
- Messaggi visualizzati correttamente nei form

## Collegamenti
- [register-action-update.md](../register-action-update.md)
- [form-implementation-errors.md](../form-implementation-errors.md) 
