# Best Practices per i Modelli in SaluteMo

## Struttura e Convenzioni

### Posizione Corretta
Tutti i modelli devono essere posizionati nella directory:
```
Modules/SaluteMo/app/Models/
```

### Namespace Corretto
```php
namespace Modules\SaluteMo\Models;
```

## Regole per i Modelli

### 1. Utilizzo di strict_types
Ogni file PHP deve iniziare con la dichiarazione:
```php
<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Models;
```

### 2. Proprietà Cast e Date

**ATTENZIONE**: `protected $casts` e `protected $dates` sono deprecati. Utilizzare le seguenti alternative:

#### Approccio Deprecato
❌ **NON UTILIZZARE**:
```php
protected $casts = [
    'active' => 'boolean',
    'created_at' => 'datetime',
];

protected $dates = ['published_at', 'expires_at'];
```

#### Approccio Corretto
✅ **UTILIZZARE**:
```php
// Cast utilizzando proprietà tipizzate con PHP 8
public bool $active;
public Carbon $created_at;

// Per datetime personalizzati
protected function casts(): array
{
    return [
        'published_at' => 'datetime',
        'expires_at' => 'datetime',
    ];
}
```

### 3. Enum per Stati e Tipi

Utilizzare enum PHP 8.1+ per gestire stati e tipi anziché array costanti:

❌ **NON UTILIZZARE**:
```php
const TYPE_PATIENT = 'patient';
const TYPE_DOCTOR = 'doctor';
const TYPE_ADMIN = 'admin';

public static function getTypes(): array
{
    return [
        self::TYPE_PATIENT => 'Paziente',
        self::TYPE_DOCTOR => 'Dottore',
        self::TYPE_ADMIN => 'Amministratore',
    ];
}
```

✅ **UTILIZZARE**:
```php
enum UserType: string
{
    case PATIENT = 'patient';
    case DOCTOR = 'doctor';
    case ADMIN = 'admin';
    
    public function label(): string
    {
        return match($this) {
            self::PATIENT => 'Paziente',
            self::DOCTOR => 'Dottore',
            self::ADMIN => 'Amministratore',
        };
    }
}

// Nel modello
protected $casts = [
    'type' => UserType::class,
];
```

### 4. Type Hints e Return Types

Utilizzare sempre type hints per parametri e return types per metodi:

```php
public function scopeActive(Builder $query): Builder
{
    return $query->where('active', true);
}

public function appointments(): HasMany
{
    return $this->hasMany(Appointment::class);
}
```

### 5. Docblocks per Metodi Pubblici

Ogni metodo pubblico deve avere un docblock completo:

```php
/**
 * Trova gli slot disponibili per un dottore in un dato giorno.
 *
 * @param \Carbon\Carbon $date La data per cui cercare disponibilità
 * @param int $doctorId L'ID del dottore
 * 
 * @return \Illuminate\Support\Collection Collezione di slot disponibili
 */
public function findAvailableSlots(Carbon $date, int $doctorId): Collection
{
    // Implementazione...
}
```

### 6. Pattern State per Stati Complessi

Utilizzare il pattern State di Spatie per gestire stati complessi:

```php
use Spatie\ModelStates\HasStates;

class Appointment extends Model
{
    use HasStates;
    
    protected function registerStates(): void
    {
        $this->addState('status', AppointmentStatus::class)
            ->default(AppointmentStatus::PENDING)
            ->allowTransition(AppointmentStatus::PENDING, AppointmentStatus::CONFIRMED)
            ->allowTransition(AppointmentStatus::PENDING, AppointmentStatus::CANCELLED)
            ->allowTransition(AppointmentStatus::CONFIRMED, AppointmentStatus::COMPLETED)
            ->allowTransition(AppointmentStatus::CONFIRMED, AppointmentStatus::CANCELLED);
    }
}
```

## Collegamenti Correlati
- [Struttura del Modulo](../structure/namespace-conventions.md)
- [Pattern State](../patterns/state-pattern.md)
- [Convenzioni DB](../database/migrations.md)
