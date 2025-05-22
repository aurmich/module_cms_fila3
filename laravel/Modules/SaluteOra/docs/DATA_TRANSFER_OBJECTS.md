# Data Transfer Objects (DTOs) nel Modulo Patient

## Introduzione

Questo documento descrive l'utilizzo e l'implementazione dei Data Transfer Objects (DTOs) nel modulo Patient. I DTOs sono oggetti utilizzati per trasportare dati tra i diversi strati dell'applicazione, garantendo la tipizzazione e la validazione dei dati.

## Struttura dei DTOs

Nel modulo Patient, i DTOs sono implementati utilizzando la libreria `spatie/laravel-data` e sono collocati nel namespace `Modules\Patient\Datas`.

### Convenzioni di Naming

- I DTOs devono essere nominati in modo descrittivo, indicando il tipo di dati che trasportano
- I nomi devono terminare con il suffisso `Data` (es. `DoctorData`, `PatientData`)
- I DTOs devono estendere la classe `Spatie\LaravelData\Data`

## Implementazione

### Esempio: DoctorData

```php
<?php

declare(strict_types=1);

namespace Modules\Patient\Datas;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\ArrayCast;

class DoctorData extends Data
{
    public function __construct(
        #[Required]
        #[StringType]
        public readonly string $first_name,

        #[Required]
        #[StringType]
        public readonly string $last_name,

        #[Required]
        #[Email]
        public readonly string $email,

        #[WithCast(ArrayCast::class)]
        public readonly ?array $certifications = null,

        // Altri campi...
    ) {
    }
    
    /**
     * Crea un'istanza di DoctorData da un array di dati.
     *
     * @param array<string, mixed> $data
     * @return self
     */
    public static function from(array $data): self
    {
        return new self(
            first_name: $data['first_name'] ?? '',
            last_name: $data['last_name'] ?? '',
            email: $data['email'] ?? '',
            certifications: $data['certifications'] ?? null,
            // Altri campi...
        );
    }
}
```

## Utilizzo

I DTOs possono essere utilizzati in vari contesti, come:

### 1. Azioni

```php
namespace Modules\Patient\Actions\Doctor;

use Modules\Patient\Datas\DoctorData;
use Modules\Patient\Models\Doctor;

class RegisterAction
{
    /**
     * Esegue l'azione di registrazione del dottore.
     *
     * @param array<string, mixed> $data
     * @return Doctor
     */
    public function execute(array $data): Doctor
    {
        $doctorData = DoctorData::from($data);
        
        // Utilizzo dei dati tipizzati
        $doctor = Doctor::create([
            'first_name' => $doctorData->first_name,
            'last_name' => $doctorData->last_name,
            'email' => $doctorData->email,
            // Altri campi...
        ]);
        
        return $doctor;
    }
}
```

### 2. Form Requests

```php
namespace Modules\Patient\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Patient\Datas\DoctorData;

class DoctorRegistrationRequest extends FormRequest
{
    // Regole di validazione...
    
    /**
     * Ottiene i dati validati come DTO.
     *
     * @return DoctorData
     */
    public function toData(): DoctorData
    {
        return DoctorData::from($this->validated());
    }
}
```

## Best Practices

### 1. Validazione

Utilizzare gli attributi di validazione forniti dalla libreria `spatie/laravel-data` per garantire la validazione dei dati:

```php
#[Required]
#[StringType]
public readonly string $first_name;

#[Email]
public readonly string $email;
```

### 2. Casting

Utilizzare gli attributi di casting per convertire automaticamente i dati nel tipo corretto:

```php
#[WithCast(ArrayCast::class)]
public readonly ?array $certifications = null;

#[WithCast(DateTimeInterfaceCast::class)]
public readonly ?Carbon $birth_date = null;
```

### 3. Metodi Factory

Implementare metodi factory come `from()` per creare istanze del DTO da diverse fonti di dati:

```php
public static function from(array $data): self
{
    return new self(
        // Mappatura dei campi...
    );
}

public static function fromRequest(Request $request): self
{
    return self::from($request->validated());
}
```

## Linee Guida per l'Utilizzo dei DTOs nel Modulo Patient

### 1. Struttura dei DTOs

- Creare DTOs come classi PHP semplici o utilizzare pacchetti come `spatie/laravel-data` per funzionalità avanzate.
- Collocare i DTOs in una directory dedicata `Data` o `DTOs` all'interno del modulo (ad esempio, `Modules/Patient/Data`).

### 2. Convenzioni di Naming

- Nominare i DTOs in modo descrittivo, riflettendo i dati che trasportano (ad esempio, `PatientProfileData`, `DoctorRegistrationData`).
- Utilizzare suffissi come `Data` o `DTO` per distinguere i DTOs dai modelli o altre classi.

### 3. Validazione

- Incorporare regole di validazione all'interno dei DTOs se si utilizza un pacchetto come `spatie/laravel-data`, o validare i dati prima di creare il DTO.
- Assicurarsi che i campi sensibili (ad esempio, le password) siano gestiti in modo sicuro e non esposti inutilmente.

### 4. Utilizzo in API

- Convertire i modelli Eloquent in DTOs prima di restituirli nelle risposte API per controllare i campi esposti.
- Utilizzare i DTOs per standardizzare i dati di input per gli endpoint API, garantendo una struttura dati coerente.

### 5. Utilizzo in Form

- Mappare le richieste di form ai DTO per semplificare la gestione dei dati nei controller o nelle azioni.
- Utilizzare i DTOs per passare i dati di form validati ai servizi o repository.

## Esempio di Implementazione

- **Definizione di un DTO** (utilizzando `spatie/laravel-data`):
  ```php
  namespace Modules\Patient\Data;

  use Spatie\LaravelData\Data;

  class PatientProfileData extends Data
  {
      public function __construct(
          public string $name,
          public string $email,
          public ?string $phone = null,
      ) {}

      public static function rules(): array
      {
          return [
              'name' => ['required', 'string', 'max:255'],
              'email' => ['required', 'email', 'max:255'],
              'phone' => ['nullable', 'string', 'max:20'],
          ];
      }
  }
  ```

- **Utilizzo di un DTO in un Controller**:
  ```php
  use Modules\Patient\Data\PatientProfileData;

  public function update(Request $request, Patient $patient)
  {
      $data = PatientProfileData::from($request->all());
      $patient->update($data->toArray());
      return response()->json($data);
  }
  ```

## Vantaggi nel Modulo Patient

1. **Sicurezza**:
   - I DTOs impediscono l'esposizione eccessiva dei dati sensibili dei pazienti definendo esplicitamente quali campi sono inclusi nelle risposte.

2. **Coerenza**:
   - Standardizzare le strutture dati in tutti gli endpoint e form relativi alla gestione dei pazienti e dei medici.

3. **Manutenibilità**:
   - Le modifiche alle strutture dati possono essere gestite in un unico luogo (la classe DTO), riducendo il rischio di errori durante gli aggiornamenti.

## Errori Comuni e Come Evitarli

- **Sovraccarico dei DTO**: Mantenere i DTO focalizzati su casi d'uso specifici. Evitare di creare DTO monolitici che gestiscono troppi dati.
- **Ignorare la Validazione**: Sempre validare i dati all'interno o prima di creare i DTO per prevenire la propagazione di dati non validi nel sistema.
- **Mappatura Diretta dei Modelli**: Evitare di mappare direttamente i modelli Eloquent ai DTO senza filtrare i campi sensibili.

## Conclusione

L'utilizzo dei DTOs nel modulo Patient migliora la gestione dei dati fornendo un modo strutturato, sicuro e manutenibile per trasferire informazioni tra i diversi strati dell'applicazione. L'applicazione coerente dei DTO in tutti gli endpoint e form garantisce l'integrità dei dati e migliora la qualità generale del codice.

## Documentazione Correlata

- [Sicurezza API](API_SECURITY.md)
- [Ottimizzazione delle Prestazioni](PERFORMANCE_OPTIMIZATION.md)
- [Ereditarietà dei Modelli](MODEL_INHERITANCE.md)
- [Linee Guida per la Risoluzione degli Errori](../../../../docs/ERROR_RESOLUTION_GUIDELINES.md)
