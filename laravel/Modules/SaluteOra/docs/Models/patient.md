# Modello Patient

## Panoramica

Il modello `Patient` rappresenta un paziente nel sistema e implementa il pattern Single Table Inheritance (STI). Estende il modello `User` del modulo Patient e utilizza il trait `HasParent` per il corretto funzionamento dell'ereditarietà.

## Struttura del Modello

```php
<?php

declare(strict_types=1);

namespace Modules\Patient\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Parental\HasParent;

class Patient extends User
{
    use HasParent;

    /**
     * @var string
     */
    protected $table = 'patients';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'date_of_birth',
        'gender',
        'address',
        'phone',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    public function casts(): array
    {
        return [
            'date_of_birth' => 'date',
        ];
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return parent::belongsTo(User::class, 'user_id');
    }
}
```

## Catena di Ereditarietà

```
BaseUser (Modules\User\app\Models\BaseUser)
   |
   +--> User (Modules\Patient\Models\User)
         |
         +--> Patient (Modules\Patient\Models\Patient)
```

## Trait Ereditati e Trait Specifici

### Trait Ereditati (non ridichiarare)

I seguenti trait sono già presenti nelle classi genitori e **NON devono** essere ridichiarati nel modello `Patient`:

- `HasFactory` (ereditato da `BaseUser`)
- `Notifiable` (ereditato da `BaseUser`)
- `HasApiTokens` (ereditato da `BaseUser`)
- `HasRoles` (ereditato da `BaseUser`)

### Trait Specifici del Modello Patient

I seguenti trait sono specifici del modello `Patient` e devono essere dichiarati:

- `HasParent` - Necessario per il funzionamento del pattern STI

## Gestione Campi e Single Table Inheritance (STI)

> **Nota importante:**
> Con Single Table Inheritance (STI), **tutti i campi usati dai modelli specializzati (es. Doctor, Patient, ecc.) devono essere presenti nella tabella base** (`users`).
> Se aggiungi un campo (es. `date_of_birth`), aggiorna la migration della tabella `users` e documenta la modifica.
> Esempio di errore tipico: `Unknown column 'date_of_birth' in 'field list'`.

## Regole di Implementazione

### Regola 1: Ereditarietà Corretta

Il modello `Patient` **deve**:
- Estendere `\Modules\Patient\Models\User` (e non direttamente `Model`, `BaseModel` o `XotBaseModel`)
- Usare il trait `\Parental\HasParent`

**Esempio corretto:**
```php
namespace Modules\Patient\Models;

use Parental\HasParent;

class Patient extends User
{
    use HasParent;
    // ...
}
```

**Esempio errato:**
```php
// ❌ NON FARE QUESTO
class Patient extends XotBaseModel
{
    // ...
}
```

### Regola 2: Evitare Duplicazione di Trait

**Esempio errato:**
```php
// ❌ NON FARE QUESTO
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends User
{
    use HasFactory; // Già ereditato da BaseUser
    use HasParent;
    // ...
}
```

**Esempio corretto:**
```php
// ✅ CORRETTO
class Patient extends User
{
    use HasParent;
    // ...
}
```

## Motivazione
- **Single Table Inheritance (STI):** Permette di gestire più tipi di utente (es. paziente, dottore) sulla stessa tabella, con comportamenti e relazioni specializzati.
- **Centralizzazione:** Tutta la logica comune va nel modello User, mentre Patient contiene solo le specificità.
- **Manutenibilità:** Cambiando la logica in User, tutti i figli (Doctor, Patient, ...) ne beneficiano.
- **Compatibilità con Parental:** Il trait `HasParent` è obbligatorio per il corretto funzionamento dello STI con tighten/parental.

## Regole Generali
- **Mai** estendere direttamente `Model`, `BaseModel` o `XotBaseModel` nei modelli specializzati.
- **Sempre** estendere il modello User del modulo e usare `HasParent`.
- **Mai** ridichiarare trait già presenti nelle classi genitori.
- **Sempre** verificare la catena di ereditarietà completa prima di aggiungere trait.

## Collegamenti
- [Single Table Inheritance](../SINGLE_TABLE_INHERITANCE.md)
- [Best Practices per l'Ereditarietà](../INHERITANCE_BEST_PRACTICES.md)
- [Model Inheritance Pattern](../MODEL_INHERITANCE_PATTERN.md)
