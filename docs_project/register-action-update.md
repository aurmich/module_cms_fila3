# Aggiornamento di RegisterAction.php

## Modifica del 2025-05-15

Ho aggiornato la classe `RegisterAction.php` per i dottori nel modulo Patient. Le modifiche includono:

- **Correzione del template email**: Aggiunto uno slug univoco `doctor_registration_pending` per il template email, per differenziarlo da altri template.
- **Rimozione di logica obsoleta**: Eliminata la logica per determinare il nome completo del dottore, poiché non più necessaria con i campi separati `first_name` e `last_name`.

### Motivazione
Queste modifiche migliorano la specificità delle email inviate ai dottori durante la registrazione e semplificano il codice rimuovendo logica non più rilevante.

**Collegamenti correlati**:
- [Documentazione principale](../docs/roadmap_frontoffice/08-registrazione-odontoiatra.md)
- [Documentazione DoctorResource](./doctor-resource-update.md)
- [Documentazione Doctor Model](./doctor-model-update.md)

# RegisterAction: Gestione ValidationException

## Best Practice

Per lanciare errori di validazione custom in Laravel:

```php
throw \Illuminate\Validation\ValidationException::withMessages([
    'email' => ['Un dottore con questa email è già registrato.'],
]);
```

- Usa sempre `withMessages()` per restituire errori custom.
- Passa un array associativo campo → array di messaggi.

## Anti-pattern (da evitare)

```php
throw new \Illuminate\Validation\ValidationException(
    validator([], [])->errors()->add('email', 'Un dottore con questa email è già registrato.')
);
```

- Questo approccio genera errori runtime perché `MessageBag` non ha il metodo `errors()` e il chaining non è supportato.

## Motivazione
- `withMessages()` è il metodo ufficiale Laravel per errori custom.
- Garantisce compatibilità con Livewire, Filament e validazione standard.

## Collegamenti
- [STATUS_ENUMS.md](./STATUS_ENUMS.md)
- [DOCTOR_REGISTRATION_PROCESS.md](./DOCTOR_REGISTRATION_PROCESS.md)
- [form-implementation-errors.md](./form-implementation-errors.md)
