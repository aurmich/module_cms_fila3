# Data Transfer Objects (DTO)

## Introduzione

I Data Transfer Objects (DTO) sono oggetti che trasportano dati tra processi o componenti dell'applicazione. In questo modulo, utilizziamo la libreria `spatie/laravel-data` per implementare i DTO in modo elegante e tipo-sicuro.

## Vantaggi dei DTO

1. **Tipi espliciti**: I DTO definiscono chiaramente la struttura dei dati
2. **Validazione integrata**: I DTO possono validare i dati in ingresso
3. **Immutabilità**: I DTO sono immutabili, garantendo l'integrità dei dati
4. **Trasformazione dei dati**: I DTO possono trasformare i dati tra diversi formati
5. **Documentazione implicita**: I DTO documentano la struttura dei dati

## Implementazione Base di un DTO

```php
<?php

declare(strict_types=1);

namespace Modules\Patient\Datas;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;

class DoctorData extends Data
{
    public function __construct(
        #[Required, StringType]
        public readonly string $first_name,
        
        #[Required, StringType]
        public readonly string $last_name,
        
        #[Required, Email]
        public readonly string $email,
        
        #[Required, StringType]
        public readonly string $password,
        
        #[StringType]
        public readonly ?string $phone = null,
        
        #[StringType]
        public readonly ?string $address = null,
        
        #[StringType]
        public readonly ?string $city = null,
        
        #[StringType]
        public readonly ?string $registration_number = null,
        
        #[StringType]
        public readonly ?string $specialization = null,
        
        public readonly ?array $certifications = null,
        
        public readonly ?array $availability = null,
    ) {
    }
}
```

## Utilizzo dei DTO

### Creazione di un DTO da un Array

```php
use Modules\Patient\Datas\DoctorData;

$data = [
    'first_name' => 'John',
    'last_name' => 'Doe',
    'email' => 'john.doe@example.com',
    'password' => 'password',
    'phone' => '1234567890',
];

$doctorData = DoctorData::from($data);
```

### Creazione di un DTO da una Request

```php
use Modules\Patient\Datas\DoctorData;

class DoctorController extends Controller
{
    public function store(Request $request)
    {
        $doctorData = DoctorData::from($request);
        
        // ...
    }
}
```

### Creazione di un DTO da un Modello

```php
use Modules\Patient\Datas\DoctorData;
use Modules\Patient\Models\Doctor;

$doctor = Doctor::find(1);
$doctorData = DoctorData::from($doctor);
```

### Conversione di un DTO in Array

```php
$array = $doctorData->toArray();
```

### Conversione di un DTO in JSON

```php
$json = $doctorData->toJson();
```

## Validazione con DTO

I DTO possono validare i dati in ingresso utilizzando gli attributi di validazione di Laravel:

```php
<?php

declare(strict_types=1);

namespace Modules\Patient\Datas;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;

class DoctorData extends Data
{
    public function __construct(
        #[Required, StringType]
        public readonly string $first_name,
        
        #[Required, StringType]
        public readonly string $last_name,
        
        #[Required, Email, Unique('users', 'email')]
        public readonly string $email,
        
        #[Required, StringType, Password(8)]
        public readonly string $password,
        
        // ...
    ) {
    }
}
```

## DTO con Relazioni

I DTO possono rappresentare relazioni tra entità:

```php
<?php

declare(strict_types=1);

namespace Modules\Patient\Datas;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\DataCollectionOf;

class DoctorData extends Data
{
    public function __construct(
        // ...
        
        #[DataCollectionOf(AppointmentData::class)]
        public readonly ?array $appointments = null,
    ) {
    }
}
```

## DTO con Casting

I DTO possono convertire automaticamente i tipi di dati:

```php
<?php

declare(strict_types=1);

namespace Modules\Patient\Datas;

use Carbon\Carbon;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Attributes\WithCast;

class AppointmentData extends Data
{
    public function __construct(
        // ...
        
        #[WithCast(DateTimeInterfaceCast::class)]
        public readonly Carbon $appointment_date,
        
        // ...
    ) {
    }
}
```

## DTO con Trasformazioni

I DTO possono trasformare i dati prima di restituirli:

```php
<?php

declare(strict_types=1);

namespace Modules\Patient\Datas;

use Spatie\LaravelData\Data;

class DoctorData extends Data
{
    // ...
    
    public function getFullName(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
    
    public static function fromModel(Doctor $doctor): self
    {
        return new self(
            first_name: $doctor->first_name,
            last_name: $doctor->last_name,
            email: $doctor->email,
            password: '', // Non includiamo la password
            phone: $doctor->phone,
            // ...
        );
    }
}
```

## DTO con Lazy Loading

I DTO possono caricare i dati in modo lazy:

```php
<?php

declare(strict_types=1);

namespace Modules\Patient\Datas;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Lazy;

class DoctorData extends Data
{
    public function __construct(
        // ...
        
        public readonly Lazy|AppointmentData $appointments,
    ) {
    }
    
    public static function fromModel(Doctor $doctor): self
    {
        return new self(
            // ...
            
            appointments: Lazy::create(fn () => AppointmentData::collection($doctor->appointments)),
        );
    }
}
```

## Best Practices per i DTO

### 1. Immutabilità

I DTO dovrebbero essere immutabili, utilizzando proprietà `readonly`:

```php
public readonly string $first_name;
```

### 2. Validazione

Utilizza gli attributi di validazione per validare i dati in ingresso:

```php
#[Required, Email, Unique('users', 'email')]
public readonly string $email;
```

### 3. Tipi Espliciti

Dichiara sempre i tipi delle proprietà:

```php
public readonly string $first_name;
public readonly ?array $certifications = null;
```

### 4. Metodi Factory

Implementa metodi factory per creare DTO da diverse fonti:

```php
public static function fromRequest(Request $request): self
{
    return new self(
        first_name: $request->input('first_name'),
        last_name: $request->input('last_name'),
        // ...
    );
}

public static function fromModel(Doctor $doctor): self
{
    return new self(
        first_name: $doctor->first_name,
        last_name: $doctor->last_name,
        // ...
    );
}
```

### 5. Documentazione

Documenta le proprietà e i metodi del DTO:

```php
/**
 * DTO per i dati del dottore.
 */
class DoctorData extends Data
{
    /**
     * @param string $first_name Nome del dottore
     * @param string $last_name Cognome del dottore
     * @param string $email Email del dottore
     * @param string $password Password del dottore
     * @param string|null $phone Telefono del dottore
     * @param string|null $address Indirizzo del dottore
     * @param string|null $city Città del dottore
     * @param string|null $registration_number Numero di registrazione del dottore
     * @param string|null $specialization Specializzazione del dottore
     * @param array|null $certifications Certificazioni del dottore
     * @param array|null $availability Disponibilità del dottore
     */
    public function __construct(
        // ...
    ) {
    }
}
```

## Errori Comuni e Come Evitarli

### 1. Proprietà Mutabili

```php
// ❌ ERRATO
public string $first_name;

// ✅ CORRETTO
public readonly string $first_name;
```

### 2. Mancanza di Tipi

```php
// ❌ ERRATO
public readonly $first_name;

// ✅ CORRETTO
public readonly string $first_name;
```

### 3. Logica di Business nei DTO

```php
// ❌ ERRATO
public function save(): Doctor
{
    return Doctor::create([
        'first_name' => $this->first_name,
        'last_name' => $this->last_name,
        // ...
    ]);
}

// ✅ CORRETTO
// La logica di business dovrebbe essere nelle Actions, non nei DTO
```

### 4. DTO Troppo Complessi

```php
// ❌ ERRATO
// Un DTO con troppe proprietà e responsabilità
class DoctorData extends Data
{
    public function __construct(
        public readonly string $first_name,
        public readonly string $last_name,
        // ... 20+ altre proprietà
    ) {
    }
}

// ✅ CORRETTO
// Suddividere in DTO più piccoli e specifici
class DoctorPersonalInfoData extends Data
{
    public function __construct(
        public readonly string $first_name,
        public readonly string $last_name,
        public readonly string $email,
        // ...
    ) {
    }
}

class DoctorProfessionalInfoData extends Data
{
    public function __construct(
        public readonly string $registration_number,
        public readonly string $specialization,
        public readonly array $certifications,
        // ...
    ) {
    }
}
```

## Integrazione con Filament

I DTO possono essere utilizzati con Filament per gestire i dati dei form:

```php
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Modules\Patient\Datas\DoctorData;

public function form(Form $form): Form
{
    return $form
        ->schema([
            TextInput::make('first_name')
                ->required(),
            TextInput::make('last_name')
                ->required(),
            TextInput::make('email')
                ->email()
                ->required()
                ->unique('users', 'email'),
            // ...
        ])
        ->statePath('data');
}

public function register()
{
    $doctorData = DoctorData::from($this->data);
    
    $registerAction = app(RegisterAction::class);
    $doctor = $registerAction->execute($doctorData);
    
    // ...
}
```

## Conclusione

I Data Transfer Objects sono un pattern potente per gestire i dati in modo tipo-sicuro e immutabile. Utilizzando la libreria `spatie/laravel-data`, puoi implementare DTO eleganti e robusti che migliorano la qualità e la manutenibilità del tuo codice.
