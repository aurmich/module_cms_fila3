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
    protected function casts(): array
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

## RelationManager in Filament

Entrambi i RelationManager (StudioResource/DoctorsRelationManager e DoctorResource/StudiosRelationManager) devono implementare AttachAction personalizzato per la gestione cross-db, con query manuali e connessione esplicita tramite on().

### Esempio simmetrico

```php
// StudioResource/RelationManagers/DoctorsRelationManager.php
Tables\Actions\AttachAction::make()
    ->preloadRecordSelect(false)
    ->recordSelect(fn (Forms\Components\Select $select) => $select
        ->searchable()
        ->getSearchResultsUsing(function (string $search) {
            return Doctor::on('user')
                ->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })
                ->whereNotIn('id', $this->getOwnerRecord()->doctors->modelKeys())
                ->limit(10)
                ->get()
                ->mapWithKeys(fn ($doctor) => [
                    $doctor->getKey() => "{$doctor->full_name} <{$doctor->email}>"
                ])
                ->toArray();
        })
    );

// DoctorResource/RelationManagers/StudiosRelationManager.php
Tables\Actions\AttachAction::make()
    ->preloadRecordSelect(false)
    ->recordSelect(fn (Forms\Components\Select $select) => $select
        ->searchable()
        ->getSearchResultsUsing(function (string $search) {
            return Studio::on('salute_ora')
                ->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('address', 'like', "%{$search}%");
                })
                ->whereNotIn('id', $this->getOwnerRecord()->studios->modelKeys())
                ->limit(10)
                ->get()
                ->mapWithKeys(fn ($studio) => [
                    $studio->getKey() => "{$studio->name} ({$studio->address})"
                ])
                ->toArray();
        })
    );
```

## Best practice anti-duplicazione trait

- I trait `SoftDeletes`, `BelongsToTenant`, `RelationX` sono già presenti nella catena di ereditarietà (User/BaseUser) e **NON devono mai** essere dichiarati in Doctor.
- Motivazione filosofica: centralizzazione della logica, nessun lock-in, manutenzione semplificata.
- Politica: evitare conflitti, warning, override indesiderati.
- Zen: serenità del codice, un solo punto di verità.

**Esempio corretto:**
```php
class Doctor extends User {
    use HasParent;
    // NIENTE altri trait già ereditati
}
```

**Esempio errato:**
```php
class Doctor extends User {
    use HasParent, SoftDeletes, BelongsToTenant, RelationX; // ❌ ERRORE
}
```

Aggiornare sempre la documentazione e le regole globali se si modifica la catena di ereditarietà.

## Modello pivot DoctorStudio

La relazione molti-a-molti tra Doctor e Studio è gestita tramite un modello pivot custom `DoctorStudio`.

- **Filosofia:** la relazione non è solo una semplice associazione, ma porta con sé informazioni aggiuntive (es. orari, studio principale, policy multi-tenant).
- **Struttura:**
  - Modello: `Modules\SaluteOra\Models\DoctorStudio`
  - Tabella: `doctor_studio`
  - Campi: `doctor_id`, `studio_id`, `schedule` (json), `is_primary` (bool), timestamps
- **Policy:**
  - La chiave primaria è composta (`doctor_id`, `studio_id`)
  - I campi aggiuntivi permettono di gestire orari e priorità
  - La relazione è simmetrica e auditabile
- **Migrazione:** [2025_05_30_000001_create_doctor_studio_table.php](../../database/migrations/2025_05_30_000001_create_doctor_studio_table.php)
  - Usare sempre foreignIdFor(Doctor::class) e foreignIdFor(Studio::class) per le chiavi esterne, mai uuid manuale. Motivazione: coerenza, type safety, migliore integrazione con Eloquent, filosofia zen.
- **Best practice:**
  - Usare sempre un modello pivot custom quando servono dati aggiuntivi sulla relazione
  - Documentare sempre la struttura e la logica della tabella pivot
  - Aggiornare la documentazione e le policy globali se si aggiungono campi o logiche

**Nota importante:**
La logica di `belongsToManyX` centralizza automaticamente la gestione del modello pivot, dei campi extra e delle policy multi-tenant. **Non serve** aggiungere chaining come `->using()`, `->withPivot()`, `->withTimestamps()`: è tutto gestito dal trait.

**Motivazione:** DRY, nessun lock-in, un solo punto di verità, coerenza con la filosofia Xot.

**Esempio di relazione nel modello Doctor:**
```php
public function studios(): BelongsToMany
{
    return $this->belongsToManyX(Studio::class);
}
```

**Esempio di relazione nel modello Studio:**
```php
public function doctors(): BelongsToMany
{
    return $this->belongsToManyX(Doctor::class);
}
```

## Policy sulla relazione studios()

- La relazione studios() deve usare solo belongsToManyX senza chaining superfluo (niente ->using, ->withPivot, ->withTimestamps).
- Motivazione: DRY, centralizzazione della logica, nessun lock-in, coerenza con la filosofia Xot.
- La logica di belongsToManyX gestisce automaticamente modello pivot, campi extra e timestamps.
- Vedi anche: [studio-doctor-relationship.md](../studio-doctor-relationship.md) e [.windsurf/rules/models.md](../../../../.windsurf/rules/models.md)

## Policy sulle chiavi esterne nelle tabelle pivot

- Usare sempre `$table->foreignIdFor(Modello::class)` per le chiavi esterne nelle tabelle pivot (es. doctor_id, studio_id).
- Non usare mai `$table->uuid()` o `$table->integer()` manuale: si perde type safety, coerenza e integrazione con Eloquent.
- Motivazione: coerenza, type safety, DRY, migliore integrazione con Eloquent, nessun lock-in.
- Filosofia: un solo punto di verità, nessuna duplicazione, rispetto della struttura modulare.
- Politica: audit trail, policy multi-tenant, massima estendibilità.

**Esempio corretto:**
```php
$table->foreignIdFor(\Modules\SaluteOra\Models\Doctor::class)
    ->comment('ID del dottore (riferimento alla tabella users)');
$table->foreignIdFor(\Modules\SaluteOra\Models\Studio::class)
    ->comment('ID dello studio (riferimento alla tabella studios)');
```

## Policy su timestamp e soft delete nelle migrazioni Xot

- Nelle migrazioni che estendono XotBaseMigration **non si usa mai** $table->timestamps().
- Si usa sempre $this->tableUpdate con updateTimestamps($table, true) dopo la creazione della tabella.
- Motivazione: centralizzazione della logica, coerenza, DRY, gestione automatica di soft delete e campi utente.
- Vedi anche: [.windsurf/rules/models.md](../../../../.windsurf/rules/models.md)

## Policy su BasePivot e nome tabella

- Chi estende BasePivot **non deve mai** dichiarare protected $table: la gestione del nome tabella è centralizzata in BasePivot/Xot.
- Motivazione: DRY, coerenza, nessun lock-in, filosofia zen.
- Vedi anche: [.windsurf/rules/models.md](../../../../.windsurf/rules/models.md)

## Policy sui pivot custom (BasePivot)

- I pivot custom (es. DoctorStudio) devono **sempre** estendere BasePivot.
- Non dichiarare mai `protected $table`: la gestione della tabella è centralizzata e automatica secondo la filosofia Xot.
- Motivazione: type safety, DRY, coerenza, nessun lock-in, serenità del codice.
- Filosofia: un solo punto di verità, nessuna duplicazione, rispetto della struttura modulare.
- Politica: gestione centralizzata, refactoring semplice, policy multi-tenant.
- Zen: codice pulito, nessun errore di mapping o override.

**Esempio corretto:**
```php
class DoctorStudio extends BasePivot
{
    // NIENTE protected $table
    // ...
}
```

---
