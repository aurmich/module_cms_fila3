# Pattern di Ereditarietà dei Modelli nel Modulo Patient

## Panoramica

Questo documento descrive il pattern di ereditarietà utilizzato per i modelli nel modulo Patient, con particolare attenzione alla gerarchia dei modelli e alle classi base appropriate.

## Struttura di Ereditarietà

Nel modulo Patient, utilizziamo due pattern di ereditarietà principali:

### 1. Single Table Inheritance (STI) per Utenti

Utilizziamo il pattern STI tramite il pacchetto `parental` per gestire diversi tipi di utenti (dottori, pazienti) che condividono la stessa tabella di base ma hanno comportamenti e attributi specifici.

```
BaseUser (Modules\User\Models\BaseUser)
   |
   +--> User (Modules\Patient\Models\User)
         |
         +--> Doctor (Modules\Patient\Models\Doctor)
         |
         +--> Patient (Modules\Patient\Models\Patient)
```

### 2. Ereditarietà Standard per Altri Modelli

Per i modelli che non sono tipi di utenti, utilizziamo un'ereditarietà standard tramite la classe base `BaseModel` del modulo:

```
Illuminate\Database\Eloquent\Model
   |
   +--> Modules\Patient\Models\BaseModel
         |
         +--> DoctorRegistrationWorkflow
         |
         +--> DoctorAvailability
         |
         +--> Altri modelli specifici del modulo
```

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

Il modello `Doctor` deve estendere `User` e utilizzare il trait `HasParent` per implementare correttamente l'ereditarietà:

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
    use SoftDeletes, BelongsToTenant;
    use HasParent;

    protected $fillable = [
        'tenant_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'city',
        'registration_number',
        'certification',
        'certifications',
        'availability',
    ];

    /**
     * Get the attributes that should be cast.
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
     * Get the workflow for this doctor's registration.
     */
    public function workflow(): HasOne
    {
        return $this->hasOne(DoctorRegistrationWorkflow::class);
    }
}
```

### Modello Patient

Il modello `Patient` estende `User` e utilizza il trait `HasParent`:

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
        // Altri campi...
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    public function casts(): array
    {
        return array_merge(parent::casts(), [
            'birth_date' => 'date',
            'isee_expiry_date' => 'date',
            'is_pregnant' => 'boolean',
            'isee_value' => 'decimal:2',
        ]);
    }
}
```

## Regole di Implementazione

### 1. Per Modelli Utente (Doctor, Patient)

I modelli che rappresentano tipi di utenti devono estendere `User` e utilizzare il trait `HasParent`:

```php
// ✅ CORRETTO
use Modules\Patient\Models\User;
use Parental\HasParent;

class Doctor extends User
{
    use HasParent;
    // ...
}
```

### 2. Per Altri Modelli

Tutti gli altri modelli specifici del modulo Patient devono estendere `BaseModel`:

```php
// ✅ CORRETTO
use Modules\Patient\Models\BaseModel;

class DoctorRegistrationWorkflow extends BaseModel
{
    // ...
}
```

### 3. Errori Comuni

#### Estensione Errata per Modelli Utente

```php
// ❌ ERRATO
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    // ...
}

// ❌ ERRATO
use Modules\Patient\Models\BaseModel;

class Doctor extends BaseModel
{
    // ...
}
```

#### Estensione Errata per Altri Modelli

```php
// ❌ ERRATO
use Illuminate\Database\Eloquent\Model;

class DoctorRegistrationWorkflow extends Model
{
    // ...
}
```

### 2. Mancanza del Trait HasParent

Un altro errore comune è omettere il trait `HasParent`, necessario per il funzionamento corretto dell'ereditarietà:

```php
// ❌ ERRATO
class Doctor extends User
{
    // Manca il trait HasParent
}

// ✅ CORRETTO
use Parental\HasParent;

class Doctor extends User
{
    use HasParent;
}
```

### 3. Metodo casts() vs Proprietà $casts

In Laravel 12.x, la proprietà `$casts` è deprecata. Il nuovo approccio consigliato è utilizzare il metodo `casts()`:

```php
// ❌ ERRATO (deprecato in Laravel 12.x)
protected $casts = [
    'certifications' => 'array',
    'availability' => 'array',
];

// ✅ CORRETTO
public function casts(): array
{
    return array_merge(parent::casts(), [
        'certifications' => 'array',
        'availability' => 'array',
    ]);
}
```

## Vantaggi del Pattern di Ereditarietà

1. **Riutilizzo del Codice**: Comportamenti comuni possono essere definiti nella classe base
2. **Polimorfismo**: Trattare diversi tipi di utenti in modo uniforme quando necessario
3. **Organizzazione del Codice**: Separazione chiara delle responsabilità
4. **Estensibilità**: Facilità nell'aggiungere nuovi tipi di utenti

## Documentazione Correlata

- [Pattern di Ereditarietà nei Modelli](/docs/model-inheritance-patterns.md)
- [Gestione degli Utenti](/docs/user-management.md)
- [Pacchetto Parental per Laravel](https://github.com/calebporzio/parental)
