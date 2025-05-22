# Regole di Ereditarietà dei Modelli nei Moduli

- Ogni modello specializzato (es. Doctor) deve estendere il modello User del proprio modulo.
- Il modello User del modulo deve estendere BaseUser del modulo User.
- BaseUser estende Authenticatable.
- **Mai estendere direttamente Model o BaseModel nei modelli child.**

## Esempio
```php
// Modules/User/app/Models/BaseUser.php
class BaseUser extends Authenticatable { /* ... */ }

// Modules/Patient/app/Models/User.php
namespace Modules\Patient\Models;
use Modules\User\Models\BaseUser;
class User extends BaseUser { /* ... */ }

// Modules/Patient/app/Models/Doctor.php
namespace Modules\Patient\Models;
class Doctor extends User { /* ... */ }
```

## Motivazione
- Garantisce coerenza, riuso, centralizzazione delle policy e delle relazioni, e semplifica la gestione dei permessi e delle query.
- Permette di sfruttare la Single Table Inheritance (STI) con tighten/parental. 

## Enum di Utilizzo Comune

- Le enum di uso trasversale (es. DayOfWeek) devono essere definite in `\Modules\Xot\Enums`.
- Nei moduli si importano sempre da Xot, non si duplicano.

### Esempio
```php
// Modules/Xot/Enums/DayOfWeek.php
namespace Modules\Xot\Enums;
enum DayOfWeek: string { /* ... */ }

// Uso nei moduli
use Modules\Xot\Enums\DayOfWeek;
Forms\Components\Select::make('day')
    ->options(DayOfWeek::options())
```

### Motivazione
- Centralizzazione = riuso, coerenza, DRY
- Facilità di localizzazione e validazione
- Manutenzione semplificata
