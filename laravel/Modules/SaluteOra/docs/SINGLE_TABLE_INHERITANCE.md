# Single Table Inheritance (STI) nel Modulo Patient

## Introduzione

Questo documento descrive l'implementazione del pattern Single Table Inheritance (STI) nel modulo Patient, con particolare attenzione alla gerarchia dei modelli `User`, `Doctor` e `Patient`.

## Cos'è il Single Table Inheritance (STI)?

Il Single Table Inheritance è un pattern di ereditarietà che consente di rappresentare una gerarchia di classi in un'unica tabella del database. Ogni record nella tabella include un campo discriminatore che indica il tipo specifico dell'oggetto.

Nel contesto di questa applicazione, utilizziamo il package `parental` per implementare il pattern STI, con il campo `type` come discriminatore.

## Struttura di Ereditarietà

Nel modulo Patient, la struttura di ereditarietà è la seguente:

```
BaseUser (Modules\User\Models\BaseUser)
   |
   +--> User (Modules\Patient\Models\User)
         |
         +--> Doctor (Modules\Patient\Models\Doctor)
         |
         +--> Patient (Modules\Patient\Models\Patient)
```

Tutti questi modelli condividono la stessa tabella `users` nel database, con il campo `type` che indica il tipo specifico dell'utente (`doctor` o `patient`).

## Implementazione Corretta

### Modello User

Il modello `User` è la classe base per i tipi specifici di utenti nel modulo Patient:

```php
<?php

declare(strict_types=1);

namespace Modules\Patient\Models;

use Modules\User\Models\BaseUser;

class User extends BaseUser
{
    /* @var string */
    protected $connection = 'user';
    
    /* @var string */
    protected $childColumn = 'type';

    protected $childTypes = [
        'patient' => Patient::class,
        'doctor' => Doctor::class,
    ];
}
```

### Modello Doctor

Il modello `Doctor` deve estendere `User` (non `XotBaseModel` o altre classi) e utilizzare il trait `HasParent` per implementare correttamente l'ereditarietà:

```php
<?php

declare(strict_types=1);

namespace Modules\Patient\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Tenant\Traits\BelongsToTenant;
use Parental\HasParent;

class Doctor extends User
{
    use HasFactory;
    use HasParent;
    use SoftDeletes;
    use BelongsToTenant;

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

    public function casts(): array
    {
        return array_merge(parent::casts(), [
            'certifications' => 'array',
            'availability' => 'array',
        ]);
    }

    public function workflow(): HasOne
    {
        return $this->hasOne(DoctorRegistrationWorkflow::class, 'doctor_id');
    }
}
```

### Modello Patient

Il modello `Patient` segue lo stesso pattern, estendendo `User` e utilizzando il trait `HasParent`:

```php
<?php

declare(strict_types=1);

namespace Modules\Patient\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Tenant\Traits\BelongsToTenant;
use Parental\HasParent;

class Patient extends User
{
    use SoftDeletes, BelongsToTenant;
    use HasParent;

    protected $fillable = [
        'tenant_id',
        'first_name',
        'last_name',
        'email',
        // Altri campi specifici del paziente
    ];

    public function casts(): array
    {
        return array_merge(parent::casts(), [
            'birth_date' => 'date',
            'isee_expiry_date' => 'date',
            // Altri cast specifici del paziente
        ]);
    }
}
```

## Errori Comuni e Come Evitarli

### 1. Estensione Errata

**Errore**:
```php
// ❌ ERRATO
class Doctor extends XotBaseModel
```

**Correzione**:
```php
// ✅ CORRETTO
class Doctor extends User
```

### 2. Mancanza del Trait HasParent

**Errore**:
```php
// ❌ ERRATO
class Doctor extends User
{
    // Manca il trait HasParent
}
```

**Correzione**:
```php
// ✅ CORRETTO
use Parental\HasParent;

class Doctor extends User
{
    use HasParent;
}
```

### 3. Relazione Errata con User

**Errore**:
```php
// ❌ ERRATO
// Doctor non dovrebbe avere una relazione belongsTo con User
// poiché è già un'estensione di User
public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}
```

**Correzione**:
```php
// ✅ CORRETTO
// Rimuovere la relazione user() e il campo user_id
// Doctor è già un User, quindi non ha bisogno di una relazione con esso
```

### 4. Duplicazione di Trait Ereditati

**Errore**:
```php
// ❌ ERRATO
class Doctor extends User
{
    use HasFactory; // Già ereditato da BaseUser
    use HasParent;
    use SoftDeletes;
    use BelongsToTenant;
}
```

**Correzione**:
```php
// ✅ CORRETTO
class Doctor extends User
{
    use HasParent;
    use SoftDeletes;
    use BelongsToTenant;
}
```

Ricorda che quando una classe estende un'altra classe, eredita automaticamente tutti i trait della classe genitore. Pertanto, è necessario evitare di ridichiarare gli stessi trait nella classe figlia. Nel nostro caso, `HasFactory` è già presente nella classe `BaseUser`, quindi non deve essere ridichiarato in `Doctor`.

## Migrazioni e STI

Con Single Table Inheritance (STI), **tutti i campi usati dai modelli specializzati devono essere presenti nella tabella base** (`users`).

Se aggiungi un campo (es. `certifications`), aggiorna la migration della tabella `users` e documenta la modifica:

```php
Schema::table('users', function (Blueprint $table) {
    $table->json('certifications')->nullable();
});
```

## Utilizzo nei Controller e nelle Azioni

Quando si utilizza il pattern STI, è importante ricordare che i modelli specializzati (`Doctor`, `Patient`) sono anche istanze del modello base (`User`). Questo significa che:

1. Puoi utilizzare `Doctor::find($id)` per ottenere un dottore specifico
2. Puoi utilizzare `User::where('type', 'doctor')->get()` per ottenere tutti i dottori
3. Un'istanza di `Doctor` ha accesso a tutti i metodi e le proprietà di `User`

## Collegamenti

- [Documentazione del package parental](https://github.com/calebporzio/parental)
- [Pattern di ereditarietà dei modelli](MODEL_INHERITANCE_PATTERN.md)
- [Migrazioni e STI](database/migrations.md)
- [Documentazione del modello Doctor](Models/Doctor.md)

## Single Table Inheritance (STI) in Patient Module

## Overview
This document explains the concept of Single Table Inheritance (STI) and its application within the Patient module of a modular Laravel application. STI is a model inheritance pattern that maps multiple models to a single database table, using a discriminator column to differentiate between model types.

## What is Single Table Inheritance?

Single Table Inheritance is a database design pattern where multiple types of entities are stored in the same table, and a specific column (often called `type` or `discriminator`) determines which class or type each row represents. In Laravel, this pattern is supported by Eloquent's ability to instantiate different model classes based on a discriminator value.

## Use Case in Patient Module

In the Patient module, STI is used to manage different types of users such as `Patient` and `Doctor` within a single `users` table. This approach simplifies the database structure by avoiding the need for separate tables for each user type, making it easier to query and manage user data collectively.

## Implementation

1. **Database Structure**:
   - A single table (e.g., `users`) contains all attributes for all user types.
   - A `type` column acts as the discriminator to indicate whether a row represents a `Patient`, `Doctor`, or another user type.
   - Attributes specific to certain types (e.g., `specialization` for `Doctor`) are stored as nullable columns, remaining `NULL` for other types.

2. **Base Model Configuration**:
   - Define a base model (e.g., `User`) that extends Laravel's `Authenticatable` class or another appropriate base.
   - Set up the discriminator logic to map `type` values to specific model classes.
   - Example:
     ```php
     namespace Modules\Patient\App\Models;

     use Illuminate\Foundation\Auth\User as Authenticatable;

     class User extends Authenticatable
     {
         protected $fillable = ['name', 'email', 'password', 'type'];

         protected $discriminator = 'type';

         protected $casts = [
             'email_verified_at' => 'datetime',
             'password' => 'hashed',
         ];

         protected $with = [];

         public static $typeMap = [
             'patient' => Patient::class,
             'doctor' => Doctor::class,
         ];

         public function newFromBuilder($attributes = [], $connection = null)
         {
             $type = $attributes[$this->discriminator] ?? null;
             $class = static::$typeMap[$type] ?? static::class;

             $model = new $class;
             $model->exists = true;
             $model->setRawAttributes((array) $attributes);
             $model->setConnection($connection ?: $this->getConnectionName());

             return $model;
         }
     }
     ```

3. **Child Models**:
   - Create child models (`Patient`, `Doctor`) that extend the base `User` model.
   - Define specific attributes, relationships, and methods relevant to each type.
   - Example for `Patient`:
     ```php
     namespace Modules\Patient\App\Models;

     class Patient extends User
     {
         protected $fillable = ['name', 'email', 'password', 'type', 'medical_history'];

         public function appointments()
         {
             return $this->hasMany(Appointment::class);
         }
     }
     ```
   - Example for `Doctor`:
     ```php
     namespace Modules\Patient\App\Models;

     class Doctor extends User
     {
         protected $fillable = ['name', 'email', 'password', 'type', 'specialization', 'license_number'];

         public function patients()
         {
             return $this->hasManyThrough(Patient::class, Appointment::class);
         }
     }
     ```

## Advantages of STI

- **Simplified Database Structure**: Using a single table reduces the complexity of database schema and eliminates the need for joins when querying across user types.
- **Efficient Queries**: Fetching data for multiple user types is more straightforward and performant since all data resides in one table.
- **Code Reusability**: Common functionality (e.g., authentication, password reset) can be defined in the base model and reused across all child models.

## Challenges of STI

- **Table Clutter**: As the number of user types grows, the table can become cluttered with nullable columns specific to certain types, leading to wasted storage space.
- **Performance with Scale**: For very large datasets, the single table can become a bottleneck, especially if many columns are sparsely populated.
- **Complexity in Logic**: Application logic must handle type-specific behaviors, which can become complex as the number of types increases.

## Best Practices

1. **Choose STI for Simplicity**:
   - Use STI when user types share many common attributes and relationships, and the differences are minimal or can be managed with nullable columns.

2. **Index the Discriminator**:
   - Add an index on the `type` column to improve query performance when filtering by user type.

3. **Keep the Base Model Lean**:
   - Define only truly shared attributes and methods in the base model to avoid unnecessary complexity in child models.

4. **Document Type-Specific Logic**:
   - Clearly document any type-specific logic or attributes in the respective child model documentation to aid developers in understanding the structure.

## Common Pitfalls and How to Avoid Them

- **Overloading the Table**: Avoid adding too many type-specific columns to the shared table. If differences between types are significant, consider using Class Table Inheritance (CTI) instead.
- **Incorrect Type Mapping**: Ensure the `typeMap` in the base model accurately reflects all possible user types to prevent instantiation errors.
- **Performance Issues**: Regularly monitor query performance on the shared table, especially as data grows, and optimize indexes or consider partitioning if necessary.

## Conclusion

Single Table Inheritance is a powerful pattern for managing multiple user types within the Patient module, balancing simplicity with functionality. By storing all user data in a single table with a discriminator, developers can streamline database operations and code management. However, careful consideration of scale and complexity is necessary to ensure this pattern remains effective as the application evolves.

## Related Documentation

- [Model Inheritance](MODEL_INHERITANCE.md)
- [Data Transfer Objects](DATA_TRANSFER_OBJECTS.md)
- [Performance Optimization](PERFORMANCE_OPTIMIZATION.md)
- [Error Resolution Guidelines](../../../../docs/ERROR_RESOLUTION_GUIDELINES.md)
