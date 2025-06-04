# DRY Model Traits: HasFactory e Catena di Ereditarietà

## Regola
**Non dichiarare mai il trait `HasFactory` nei modelli che lo ereditano già da una classe base.**

## Motivazione
- Il trait `HasFactory` è già incluso nella catena di ereditarietà tramite `BaseUser` (o `BaseModel`), quindi dichiararlo nelle classi figlie (es. `Admin`, `Patient`, ecc.) è ridondante.
- La duplicazione può causare warning, confusione e violazioni del principio DRY.
- Mantenere la dichiarazione solo nella base garantisce coerenza e facilita la manutenzione.

## Esempio

```php
// BaseUser.php
abstract class BaseUser extends Authenticatable {
    use HasFactory;
    // ...
}

// Admin.php
class Admin extends User {
    // NON serve: use HasFactory;
    // ...
}
```

## Checklist
- [ ] Verifica che nessun modello figlio dichiari `use HasFactory` se già presente nella base
- [ ] Aggiorna la docstring della classe per segnalare la motivazione
- [ ] Documenta la regola in docs e .mdc

## Collegamenti
- `.cursor/rules/DRY-model-traits.mdc`
- `.windsurf/rules/DRY-model-traits.mdc`

---
Ultimo aggiornamento: 2025-06-04
