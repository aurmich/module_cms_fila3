# Modello Doctor

## Panoramica

Il modello `Doctor` rappresenta un medico nel sistema e implementa il pattern Single Table Inheritance (STI). Estende il modello `User` del modulo Patient e utilizza il trait `HasParent` per il corretto funzionamento dell'ereditarietà.

## File Chiave
- [Doctor.php](../../app/Models/Doctor.php)
- [User.php](../../app/Models/User.php)
- [BaseUser.php](../../../User/app/Models/BaseUser.php)
- [DoctorResource.php](../../app/Filament/Resources/DoctorResource.php)
- [RegisterAction.php](../../app/Actions/RegisterAction.php)

## Struttura del Modello

```php
<?php

declare(strict_types=1);

namespace Modules\Patient\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Tenant\Traits\BelongsToTenant;
use Parental\HasParent;

class Doctor extends User
{
    use HasParent;
    use SoftDeletes;
    use BelongsToTenant;

    /**
     * Gli attributi che sono mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'tenant_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'city',
        'registration_number',
        'specialization',
        'certifications',
        'availability',
        'status',
    ];

    /**
     * Definisce i cast per gli attributi.
     *
     * @return array<string, string>
     */
    public function casts(): array
    {
        return array_merge(parent::casts(), [
            'certifications' => 'array',
            'availability' => 'array',
        ]);
    }

    /**
     * Relazione con il workflow di registrazione.
     *
     * @return HasOne
     */
    public function workflow(): HasOne
    {
        return $this->hasOne(DoctorRegistrationWorkflow::class, 'doctor_id');
    }
}
```

## Catena di Ereditarietà

```
BaseUser (Modules\User\app\Models\BaseUser)
   |
   +--> User (Modules\Patient\Models\User)
         |
         +--> Doctor (Modules\Patient\Models\Doctor)
```

## Trait Ereditati e Trait Specifici

### Trait Ereditati (non ridichiarare)

I seguenti trait sono già presenti nelle classi genitori e **NON devono** essere ridichiarati nel modello `Doctor`:

- `HasFactory` (ereditato da `BaseUser`)
- `Notifiable` (ereditato da `BaseUser`)
- `HasApiTokens` (ereditato da `BaseUser`)
- `HasRoles` (ereditato da `BaseUser`)

### Trait Specifici del Modello Doctor

I seguenti trait sono specifici del modello `Doctor` e devono essere dichiarati:

- `HasParent` - Necessario per il funzionamento del pattern STI
- `SoftDeletes` - Per la cancellazione logica dei record
- `BelongsToTenant` - Per la gestione multi-tenant

## Gestione Campi e Single Table Inheritance (STI)

> **Nota importante:**
> Con Single Table Inheritance (STI), **tutti i campi usati dai modelli specializzati (es. Doctor, Patient, ecc.) devono essere presenti nella tabella base** (`users`).
> Se aggiungi un campo (es. `certifications`), aggiorna la migration della tabella `users` e documenta la modifica.
> Esempio di errore tipico: `Unknown column 'certifications' in 'field list'`.

## Regole di Implementazione

### Regola 1: Ereditarietà Corretta

Il modello `Doctor` **deve**:
- Estendere `\Modules\Patient\Models\User` (e non direttamente `Model`, `BaseModel` o `XotBaseModel`)
- Usare il trait `\Parental\HasParent`

**Esempio corretto:**
```php
namespace Modules\Patient\Models;

use Parental\HasParent;

class Doctor extends User
{
    use HasParent;
    // ...
}
```

**Esempio errato:**
```php
// ❌ NON FARE QUESTO
class Doctor extends XotBaseModel
{
    // ...
}
```

### Regola 2: Evitare Duplicazione di Trait

**Esempio errato:**
```php
// ❌ NON FARE QUESTO
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doctor extends User
{
    use HasFactory; // Già ereditato da BaseUser
    use HasParent;
    // ...
}
```

**Esempio corretto:**
```php
// ✅ CORRETTO
class Doctor extends User
{
    use HasParent;
    // ...
}
```

## Motivazione
- **Single Table Inheritance (STI):** Permette di gestire più tipi di utente (es. paziente, dottore) sulla stessa tabella, con comportamenti e relazioni specializzati.
- **Centralizzazione:** Tutta la logica comune va nel modello User, mentre Doctor contiene solo le specificità.
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
- [DoctorRegistrationWorkflow](./DoctorRegistrationWorkflow.md)
- [Struttura progetto e STI](../architecture/struttura-progetto.md)
- [Migrazioni e database](../database/migrations.md)

# Troubleshooting: Errori di Validazione Custom

## Errore tipico

```
Call to undefined method Illuminate\Support\MessageBag::errors()
```

**Causa:** Uso errato di ValidationException. Vedi [../errors/validation.md](../errors/validation.md)

**Soluzione:**

```php
throw \Illuminate\Validation\ValidationException::withMessages([
    'email' => ['Un dottore con questa email è già registrato.'],
]);
```

# Nota importante sui trait ereditiati

Non duplicare mai trait già presenti nei modelli base. Esempio: se `BaseUser` usa `HasFactory`, non aggiungerlo in `User` o `Doctor`.

**Anti-pattern:**
```php
class Doctor extends User {
    use HasFactory; // ❌ Da evitare!
}
```

**Best practice:**
```php
class Doctor extends User {
    // I trait sono già ereditati
}
```

Motivazione: evitare ridondanza, warning, confusione e problemi di override.

---
