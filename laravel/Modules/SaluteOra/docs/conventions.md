# Convenzioni di Codice - Modulo Patient

## Struttura delle Classi

### Models
```php
namespace Modules\Patient\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Patient\Traits\HasMedicalRecords;
use Modules\Patient\Traits\HasAppointments;

class Patient extends Model
{
    use HasMedicalRecords, HasAppointments;

    protected $fillable = [
        'first_name',
        'last_name',
        'fiscal_code',
        'birth_date',
        'gender',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
```

### Controllers
```php
namespace Modules\Patient\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Patient\Models\Patient;
use Modules\Patient\Http\Requests\StorePatientRequest;
use Modules\Patient\Http\Resources\PatientResource;

class PatientController extends Controller
{
    public function store(StorePatientRequest $request): JsonResponse
    {
        $patient = Patient::create($request->validated());
        
        return response()->json([
            'data' => new PatientResource($patient),
            'message' => 'Patient created successfully',
        ], 201);
    }
}
```

### Requests
```php
namespace Modules\Patient\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'fiscal_code' => ['required', 'string', 'size:16'],
            'birth_date' => ['required', 'date'],
            'gender' => ['required', 'string', 'in:M,F'],
        ];
    }
}
```

## Naming Conventions

### Files
- Models: `Patient.php`, `MedicalRecord.php`
- Controllers: `PatientController.php`, `MedicalRecordController.php`
- Requests: `StorePatientRequest.php`, `UpdatePatientRequest.php`
- Resources: `PatientResource.php`, `MedicalRecordResource.php`
- Views: `patient.blade.php`, `medical-record.blade.php`

### Database
- Tables: `patients`, `medical_records`
- Columns: `first_name`, `last_name`, `fiscal_code`
- Foreign Keys: `patient_id`, `doctor_id`

### Routes
```php
Route::prefix('patients')->group(function () {
    Route::get('/', [PatientController::class, 'index']);
    Route::post('/', [PatientController::class, 'store']);
    Route::get('/{patient}', [PatientController::class, 'show']);
    Route::put('/{patient}', [PatientController::class, 'update']);
    Route::delete('/{patient}', [PatientController::class, 'destroy']);
});
```

## Best Practices

### 1. Validazione
- Utilizzare sempre Form Requests
- Validare tutti gli input
- Sanitizzare i dati sensibili
- Implementare regole di validazione personalizzate

### 2. Sicurezza
- Crittografare dati sensibili
- Implementare controlli di accesso
- Logging delle attività
- Conformità GDPR

### 3. Performance
- Utilizzare eager loading
- Implementare caching
- Ottimizzare query
- Utilizzare indici database

### 4. Testing
- Test unitari per modelli
- Test di validazione
- Test di autorizzazione
- Test di performance

## Struttura Directory
```
Modules/Patient/
├── Config/
├── Database/
│   ├── Migrations/
│   └── Seeders/
├── Http/
│   ├── Controllers/
│   ├── Middleware/
│   ├── Requests/
│   └── Resources/
├── Models/
├── Providers/
├── Resources/
│   ├── js/
│   ├── sass/
│   └── views/
├── Routes/
└── Tests/
```

## Documentazione
- Commentare il codice
- Documentare le API
- Mantenere aggiornato il changelog
- Seguire le convenzioni PSR-12 
## Collegamenti tra versioni di CONVENTIONS.md
* [CONVENTIONS.md](laravel/Modules/Xot/docs/CONVENTIONS.md)
* [CONVENTIONS.md](laravel/Modules/Dental/docs/CONVENTIONS.md)
* [CONVENTIONS.md](laravel/Modules/Patient/docs/CONVENTIONS.md)


## Collegamenti tra versioni di conventions.md
* [conventions.md](../../../../docs/tecnico/filament/conventions.md)
* [conventions.md](../../../../docs/conventions.md)
* [conventions.md](../../Xot/docs/conventions.md)
* [conventions.md](../../Dental/docs/conventions.md)

