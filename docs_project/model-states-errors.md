# Errori comuni nelle transizioni di stato custom (Model States)

## ArgumentCountError su transizioni custom

### Descrizione
Quando una transizione custom (es. `ActiveToSuspended`) richiede più parametri nel costruttore (es. `User $user, string $message`), ma viene chiamata senza tutti i parametri, si verifica un errore di tipo:

```
ArgumentCountError
Too few arguments to function ...::__construct(), 1 passed ... and exactly 2 expected
```

### Causa
- Il sistema Spatie Model States passa solo il modello (`User $user`) per default.
- Se la transizione richiede altri parametri (es. `$message`), questi devono essere passati esplicitamente in tutte le chiamate a `transitionTo`.

### Soluzione
- Allineare la firma del costruttore e le chiamate:
  - Se la transizione richiede un messaggio, tutte le chiamate a `transitionTo` devono fornire anche `$message`.
  - Se il messaggio non è sempre obbligatorio, renderlo opzionale (`string $message = ''`).
- Aggiornare la documentazione e i test.

### Esempio
```php
// Costruttore:
public function __construct(User $user, string $message) { ... }

// Chiamata corretta:
$record->state->transitionTo('suspended', $message);
```

### Checklist
- [ ] Firma del costruttore coerente con le chiamate
- [ ] Tutte le chiamate a transitionTo aggiornate
- [ ] Documentazione aggiornata

### Collegamenti
- [Best practices Model States (Xot)](../../Xot/docs/model-states-best-practices.md)
- [README.md centrale](../../../docs/README.md)
- [Audit trail e motivazioni transizioni](../../Xot/docs/audit-trail.md) 