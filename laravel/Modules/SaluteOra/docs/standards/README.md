# Standard Patient

Questo documento contiene gli standard specifici per il modulo Patient.

## Modelli

### Nomenclatura
- Nome in PascalCase
- Prefisso `XotBase` per le classi base
- Suffisso `Patient` per i modelli principali
- Suffisso `Record` per i record medici

### Struttura Base
```php
namespace Modules\Patient\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class XotBasePatient extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'tax_code',
        'birth_date',
        'gender',
        'address',
        'phone',
        'email',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'gender' => GenderType::class,
    ];

    public function medicalRecords(): HasMany
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
```

## Value Objects

### Nomenclatura
- Nome in PascalCase
- Classe `final`
- Immutabile
- Validazione integrata

### Esempio
```php
namespace Modules\Patient\app\ValueObjects;

final class TaxCode
{
    private string $value;
    
    public function __construct(string $taxCode)
    {
        if (!$this->isValid($taxCode)) {
            throw new InvalidTaxCodeException($taxCode);
        }
        
        $this->value = $taxCode;
    }
    
    public function value(): string
    {
        return $this->value;
    }
    
    private function isValid(string $taxCode): bool
    {
        return (bool) preg_match('/^[A-Z]{6}[0-9]{2}[A-Z][0-9]{2}[A-Z][0-9]{3}[A-Z]$/', $taxCode);
    }
}
```

## Enums

### Nomenclatura
- Nome in PascalCase
- Suffisso `Type`
- Valori in UPPERCASE
- Metodi di utilità

### Esempio
```php
namespace Modules\Patient\app\Enums;

enum GenderType: string
{
    case FEMALE = 'F';
    case MALE = 'M';
    case OTHER = 'O';
    
    public function label(): string
    {
        return match($this) {
            self::FEMALE => 'Femminile',
            self::MALE => 'Maschile',
            self::OTHER => 'Altro',
        };
    }
}
```

## Azioni Queueable (Spatie)

### Nomenclatura
- Nome in PascalCase
- Suffisso `Action`
- Singola responsabilità (SRP)
- Utilizzare il trait `Spatie\QueueableAction\QueueableAction`

### Linee guida
1. **Nessuna classe `*Service`**: tutta la business logic deve essere incapsulata in `*Action`.
2. Ogni `Action` espone un **metodo `execute()`** come entry point.
3. Le azioni possono essere invocate sincrone (`app(MyAction::class)->execute(...)`) o asincrone (`MyAction::dispatch(...)`).
4. Le dipendenze si risolvono via costruttore (auto-injection) o parametri di metodo.
5. Scrivere test unitari per ogni Action.

### Esempio
```php
namespace Modules\Patient\Actions;

use Spatie\QueueableAction\QueueableAction;
use Modules\Patient\Models\DoctorRegistrationWorkflow;
use Modules\Patient\States\Approved;

class DoctorModerationAction
{
    use QueueableAction;

    public function execute(DoctorRegistrationWorkflow $workflow, bool $approved, ?string $notes, int $moderatorId): void
    {
        // Aggiorna stato tramite Model States
        $workflow->status->transitionTo($approved ? Approved::class : Rejected::class);

        // Salva note, invia email, log activity...
    }
}
```

> Vedi anche: [wizard-moderation-flow.md](../wizard-moderation-flow.md) per un caso d'uso completo.

## Repository

### Nomenclatura
- Nome in PascalCase
- Suffisso `Repository`
- Interfaccia + Implementazione
- Query Builder

### Esempio
```php
namespace Modules\Patient\app\Repositories;

interface PatientRepositoryInterface
{
    public function find(int $id): ?Patient;
    public function findByTaxCode(string $taxCode): ?Patient;
    public function create(array $data): Patient;
}

class PatientRepository implements PatientRepositoryInterface
{
    public function __construct(
        private Patient $model
    ) {}

    public function find(int $id): ?Patient
    {
        return $this->model->find($id);
    }
}
```

## Form Requests

### Nomenclatura
- Nome in PascalCase
- Suffisso `Request`
- Validazione completa
- Messaggi personalizzati

### Esempio
```php
namespace Modules\Patient\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'tax_code' => ['required', 'string', 'size:16', 'unique:patients,tax_code'],
            'birth_date' => ['required', 'date', 'before:today'],
            'gender' => ['required', 'string', 'in:' . implode(',', GenderType::values())],
        ];
    }
}
```

## Controllers

### Nomenclatura
- Nome in PascalCase
- Suffisso `Controller`
- Single Action quando possibile
- Resource Controller quando necessario

### Esempio
```php
namespace Modules\Patient\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Patient\app\Services\PatientService;
use Modules\Patient\app\Http\Requests\StorePatientRequest;

class PatientController extends Controller
{
    public function __construct(
        private PatientService $service
    ) {}

    public function store(StorePatientRequest $request): JsonResponse
    {
        $patient = $this->service->create($request->validated());
        
        return response()->json($patient, 201);
    }
}
```

## Testing

### Unit Tests
- Test per ogni classe
- Test per ogni metodo
- Data providers
- Mocking appropriato

### Feature Tests
- Test per ogni endpoint
- Test per ogni flusso
- Test per errori
- Test per validazione

## Sicurezza

### Dati Sensibili
- Crittografia
- Masking
- Audit log
- Access control

### GDPR
- Right to be forgotten
- Data portability
- Consent management
- Data retention 
## Collegamenti tra versioni di README.md
* [README.md](bashscripts/docs/README.md)
* [README.md](bashscripts/docs/it/README.md)
* [README.md](docs/laravel-app/phpstan/README.md)
* [README.md](docs/laravel-app/README.md)
* [README.md](docs/moduli/struttura/README.md)
* [README.md](docs/moduli/README.md)
* [README.md](docs/moduli/manutenzione/README.md)
* [README.md](docs/moduli/core/README.md)
* [README.md](docs/moduli/installati/README.md)
* [README.md](docs/moduli/comandi/README.md)
* [README.md](docs/phpstan/README.md)
* [README.md](docs/README.md)
* [README.md](docs/module-links/README.md)
* [README.md](docs/troubleshooting/git-conflicts/README.md)
* [README.md](docs/tecnico/laraxot/README.md)
* [README.md](docs/modules/README.md)
* [README.md](docs/conventions/README.md)
* [README.md](docs/amministrazione/backup/README.md)
* [README.md](docs/amministrazione/monitoraggio/README.md)
* [README.md](docs/amministrazione/deployment/README.md)
* [README.md](docs/translations/README.md)
* [README.md](docs/roadmap/README.md)
* [README.md](docs/ide/cursor/README.md)
* [README.md](docs/implementazione/api/README.md)
* [README.md](docs/implementazione/testing/README.md)
* [README.md](docs/implementazione/pazienti/README.md)
* [README.md](docs/implementazione/ui/README.md)
* [README.md](docs/implementazione/dental/README.md)
* [README.md](docs/implementazione/core/README.md)
* [README.md](docs/implementazione/reporting/README.md)
* [README.md](docs/implementazione/isee/README.md)
* [README.md](docs/it/README.md)
* [README.md](laravel/vendor/mockery/mockery/docs/README.md)
* [README.md](laravel/Modules/Chart/docs/README.md)
* [README.md](laravel/Modules/Reporting/docs/README.md)
* [README.md](laravel/Modules/Gdpr/docs/phpstan/README.md)
* [README.md](laravel/Modules/Gdpr/docs/README.md)
* [README.md](laravel/Modules/Notify/docs/phpstan/README.md)
* [README.md](laravel/Modules/Notify/docs/README.md)
* [README.md](laravel/Modules/Xot/docs/filament/README.md)
* [README.md](laravel/Modules/Xot/docs/phpstan/README.md)
* [README.md](laravel/Modules/Xot/docs/exceptions/README.md)
* [README.md](laravel/Modules/Xot/docs/README.md)
* [README.md](laravel/Modules/Xot/docs/standards/README.md)
* [README.md](laravel/Modules/Xot/docs/conventions/README.md)
* [README.md](laravel/Modules/Xot/docs/development/README.md)
* [README.md](laravel/Modules/Dental/docs/README.md)
* [README.md](laravel/Modules/User/docs/phpstan/README.md)
* [README.md](laravel/Modules/User/docs/README.md)
* [README.md](laravel/Modules/User/resources/views/docs/README.md)
* [README.md](laravel/Modules/UI/docs/phpstan/README.md)
* [README.md](laravel/Modules/UI/docs/README.md)
* [README.md](laravel/Modules/UI/docs/standards/README.md)
* [README.md](laravel/Modules/UI/docs/themes/README.md)
* [README.md](laravel/Modules/UI/docs/components/README.md)
* [README.md](laravel/Modules/Lang/docs/phpstan/README.md)
* [README.md](laravel/Modules/Lang/docs/README.md)
* [README.md](laravel/Modules/Job/docs/phpstan/README.md)
* [README.md](laravel/Modules/Job/docs/README.md)
* [README.md](laravel/Modules/Media/docs/phpstan/README.md)
* [README.md](laravel/Modules/Media/docs/README.md)
* [README.md](laravel/Modules/Tenant/docs/phpstan/README.md)
* [README.md](laravel/Modules/Tenant/docs/README.md)
* [README.md](laravel/Modules/Activity/docs/phpstan/README.md)
* [README.md](laravel/Modules/Activity/docs/README.md)
* [README.md](laravel/Modules/Patient/docs/README.md)
* [README.md](laravel/Modules/Patient/docs/standards/README.md)
* [README.md](laravel/Modules/Patient/docs/value-objects/README.md)
* [README.md](laravel/Modules/Cms/docs/blocks/README.md)
* [README.md](laravel/Modules/Cms/docs/README.md)
* [README.md](laravel/Modules/Cms/docs/standards/README.md)
* [README.md](laravel/Modules/Cms/docs/content/README.md)
* [README.md](laravel/Modules/Cms/docs/frontoffice/README.md)
* [README.md](laravel/Modules/Cms/docs/components/README.md)
* [README.md](laravel/Themes/Two/docs/README.md)
* [README.md](laravel/Themes/One/docs/README.md)

