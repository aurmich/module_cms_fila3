# Best Practices per le Actions

## Introduzione

Le Actions sono classi che implementano una singola responsabilità (principio SRP) e rappresentano un'operazione o un caso d'uso specifico dell'applicazione. In questo modulo, utilizziamo il pattern Action per incapsulare la logica di business e renderla riutilizzabile e testabile.

## Convenzioni dei Nomi e dei Namespace

### Struttura dei Namespace

I namespace delle Actions devono seguire questa struttura:

```
Modules\<ModuleName>\Actions\<Domain>\<ActionName>Action
```

Dove:
- `<ModuleName>`: Nome del modulo in PascalCase (es. `SaluteOra`)
- `<Domain>`: Dominio o contesto dell'azione (es. `Patient`, `Doctor`, `Calendar`)
- `<ActionName>`: Nome descrittivo dell'azione in PascalCase (es. `FetchEvents`)

**Esempi:**
- `Modules\SaluteOra\Actions\Patient\Calendar\FetchEventsAction`
- `Modules\SaluteOra\Actions\Doctor\Appointment\CreateAppointmentAction`

### Convenzioni di Nome
- I nomi delle classi devono terminare con `Action`
- I nomi dei file devono corrispondere esattamente ai nomi delle classi
- I namespace non devono contenere `App\`

## Struttura di una Action

Una Action ben strutturata dovrebbe seguire questi principi:

1. **Singola responsabilità**: Ogni Action dovrebbe fare una cosa sola
2. **Metodo principale**: Implementare un metodo principale (`execute`, `handle` o `__invoke`)
3. **Dipendenze esplicite**: Dichiarare tutte le dipendenze nel costruttore
4. **Gestione degli errori**: Gestire correttamente le eccezioni
5. **Tipi di ritorno espliciti**: Dichiarare sempre il tipo di ritorno

### Esempio di Action ben strutturata

```php
<?php

declare(strict_types=1);

namespace Modules\Patient\Actions\Doctor;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Modules\Notify\Emails\SpatieEmail;
use Modules\Notify\Models\MailTemplate;
use Modules\Patient\Datas\DoctorData;
use Modules\Patient\Enums\DoctorRegistrationStatus;
use Modules\Patient\Models\Doctor;
use Modules\Patient\Models\DoctorRegistrationWorkflow;

class RegisterAction
{
    /**
     * Registra un nuovo dottore nel sistema.
     *
     * @param array<string, mixed> $data Dati del dottore
     * @return Doctor
     * @throws ValidationException Se l'email è già registrata
     */
    public function execute(array $data): Doctor
    {
        // Verifica se esiste già un utente con questa email
        $existingUser = Doctor::where('email', $data['email'])->first();
        
        if ($existingUser) {
            throw ValidationException::withMessages([
                'email' => ['Un dottore con questa email è già registrato.'],
            ]);
        }
        
        // Creazione del dottore
        $doctor = Doctor::create($data);
        
        // Creazione del workflow di registrazione
        DoctorRegistrationWorkflow::create([
            'doctor_id' => $doctor->id,
            'current_step' => 'personal-info',
            'status' => $this->getDoctorRegistrationStatus(),
            'started_at' => now(),
            'last_interaction_at' => now(),
            'session_id' => session()->getId(),
        ]);
        
        // Invio email di conferma
        $this->sendConfirmationEmail($doctor);
        
        return $doctor;
    }
    
    /**
     * Invia l'email di conferma della registrazione.
     *
     * @param Doctor $doctor
     * @return void
     */
    protected function sendConfirmationEmail(Doctor $doctor): void
    {
        // Verifica se esiste già il template, altrimenti crealo
        if (!MailTemplate::where('slug', 'doctor_registration_pending')->exists()) {
            MailTemplate::create([
                'mailable' => SpatieEmail::class,
                'slug' => 'doctor_registration_pending',
                'subject' => 'Benvenuto, {{ first_name }}',
                'html_template' => '<p>Gentile {{ first_name }} {{ last_name }},</p><p>La tua registrazione come dottore è in attesa di approvazione. Ti contatteremo presto.</p>',
                'text_template' => 'Gentile {{ first_name }} {{ last_name }}, la tua registrazione come dottore è in attesa di approvazione. Ti contatteremo presto.'
            ]);
        }
        
        $email = new SpatieEmail($doctor, 'doctor_registration_pending');
        Mail::to($doctor->email)
            ->locale(app()->getLocale())
            ->send($email);
    }
    
    /**
     * Ottiene lo stato di registrazione del dottore.
     *
     * @return string
     */
    private function getDoctorRegistrationStatus(): string
    {
        if (!class_exists(DoctorRegistrationStatus::class)) {
            return 'pending';
        }
        
        try {
            $cases = DoctorRegistrationStatus::cases();
            foreach ($cases as $case) {
                if (strtolower($case->name) === 'pending_moderation') {
                    return $case->value;
                }
            }
            return 'pending_moderation';
        } catch (\Exception $e) {
            return 'pending_moderation';
        }
    }
}
```

## Utilizzo dei Data Transfer Objects (DTO)

Le Actions dovrebbero utilizzare Data Transfer Objects (DTO) per gestire i dati in ingresso e in uscita. Questo approccio offre diversi vantaggi:

1. **Validazione dei dati**: I DTO possono validare i dati in ingresso
2. **Tipi espliciti**: I DTO forniscono tipi espliciti per i dati
3. **Immutabilità**: I DTO sono immutabili, garantendo l'integrità dei dati

### Esempio di Action con DTO

```php
<?php

declare(strict_types=1);

namespace Modules\Patient\Actions\Doctor;

use Illuminate\Support\Facades\DB;
use Modules\Patient\Datas\DoctorData;
use Modules\Patient\Models\Doctor;

class RegisterAction
{
    /**
     * Registra un nuovo dottore nel sistema.
     *
     * @param DoctorData $data Dati del dottore
     * @return Doctor
     */
    public function execute(DoctorData $data): Doctor
    {
        // La validazione è già stata eseguita dal DTO
        
        // Creazione del dottore
        $doctor = Doctor::create($data->toArray());
        
        // ...
        
        return $doctor;
    }
}
```

## Gestione delle Transazioni

Le Actions che modificano più entità dovrebbero utilizzare le transazioni del database per garantire l'integrità dei dati:

```php
use Illuminate\Support\Facades\DB;

public function execute(array $data): Doctor
{
    return DB::transaction(function () use ($data) {
        // Creazione del dottore
        $doctor = Doctor::create($data);
        
        // Creazione del workflow di registrazione
        DoctorRegistrationWorkflow::create([
            'doctor_id' => $doctor->id,
            // ...
        ]);
        
        return $doctor;
    });
}
```

## Gestione degli Errori

Le Actions dovrebbero gestire correttamente gli errori, lanciando eccezioni appropriate:

```php
use Illuminate\Validation\ValidationException;
use Modules\Patient\Exceptions\DoctorRegistrationException;

public function execute(array $data): Doctor
{
    // Verifica se esiste già un utente con questa email
    $existingUser = Doctor::where('email', $data['email'])->first();
    
    if ($existingUser) {
        throw ValidationException::withMessages([
            'email' => ['Un dottore con questa email è già registrato.'],
        ]);
    }
    
    try {
        // Creazione del dottore
        $doctor = Doctor::create($data);
        
        // ...
        
        return $doctor;
    } catch (\Exception $e) {
        throw new DoctorRegistrationException('Errore durante la registrazione del dottore: ' . $e->getMessage(), 0, $e);
    }
}
```

## Testing delle Actions

Le Actions dovrebbero essere facilmente testabili. Ecco un esempio di test per l'action `RegisterAction`:

```php
<?php

namespace Tests\Unit\Modules\Patient\Actions\Doctor;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Modules\Patient\Actions\Doctor\RegisterAction;
use Modules\Patient\Models\Doctor;
use Tests\TestCase;

class RegisterActionTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function it_registers_a_new_doctor()
    {
        // Arrange
        $action = new RegisterAction();
        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'password' => 'password',
            'phone' => '1234567890',
            'specialization' => 'Cardiology',
        ];
        
        // Act
        $doctor = $action->execute($data);
        
        // Assert
        $this->assertInstanceOf(Doctor::class, $doctor);
        $this->assertEquals('John', $doctor->first_name);
        $this->assertEquals('Doe', $doctor->last_name);
        $this->assertEquals('john.doe@example.com', $doctor->email);
        $this->assertNotNull($doctor->workflow);
        $this->assertEquals('pending_moderation', $doctor->workflow->status);
    }
    
    /** @test */
    public function it_throws_validation_exception_if_email_already_exists()
    {
        // Arrange
        $action = new RegisterAction();
        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'password' => 'password',
            'phone' => '1234567890',
            'specialization' => 'Cardiology',
        ];
        
        // Create a doctor with the same email
        Doctor::create([
            'first_name' => 'Existing',
            'last_name' => 'Doctor',
            'email' => 'john.doe@example.com',
            'password' => bcrypt('password'),
        ]);
        
        // Act & Assert
        $this->expectException(ValidationException::class);
        $action->execute($data);
    }
}
```

## Dependency Injection

Le Actions dovrebbero utilizzare l'iniezione delle dipendenze per ricevere i servizi di cui hanno bisogno:

```php
<?php

declare(strict_types=1);

namespace Modules\Patient\Actions\Doctor;

use Illuminate\Contracts\Mail\Mailer;
use Modules\Patient\Models\Doctor;
use Modules\Patient\Repositories\DoctorRepository;

class RegisterAction
{
    public function __construct(
        private readonly DoctorRepository $doctorRepository,
        private readonly Mailer $mailer
    ) {
    }
    
    public function execute(array $data): Doctor
    {
        // Verifica se esiste già un utente con questa email
        if ($this->doctorRepository->existsByEmail($data['email'])) {
            // ...
        }
        
        // Creazione del dottore
        $doctor = $this->doctorRepository->create($data);
        
        // Invio email
        $this->mailer->to($doctor->email)
            ->send(new DoctorRegistrationEmail($doctor));
        
        return $doctor;
    }
}
```

## Errori Comuni e Come Evitarli

### 1. Logica di Business nei Controller

```php
// ❌ ERRATO
class DoctorController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            // ...
        ]);
        
        $doctor = Doctor::create($data);
        
        DoctorRegistrationWorkflow::create([
            'doctor_id' => $doctor->id,
            // ...
        ]);
        
        // Invio email...
        
        return redirect()->route('doctors.index');
    }
}

// ✅ CORRETTO
class DoctorController extends Controller
{
    public function register(Request $request, RegisterAction $registerAction)
    {
        $data = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            // ...
        ]);
        
        $doctor = $registerAction->execute($data);
        
        return redirect()->route('doctors.index');
    }
}
```

### 2. Mancanza di Gestione degli Errori

```php
// ❌ ERRATO
public function execute(array $data): Doctor
{
    $doctor = Doctor::create($data);
    
    DoctorRegistrationWorkflow::create([
        'doctor_id' => $doctor->id,
        // ...
    ]);
    
    return $doctor;
}

// ✅ CORRETTO
public function execute(array $data): Doctor
{
    return DB::transaction(function () use ($data) {
        $doctor = Doctor::create($data);
        
        DoctorRegistrationWorkflow::create([
            'doctor_id' => $doctor->id,
            // ...
        ]);
        
        return $doctor;
    });
}
```

### 3. Dipendenze Implicite

```php
// ❌ ERRATO
public function execute(array $data): Doctor
{
    $service = app(SomeService::class);
    
    // ...
}

// ✅ CORRETTO
public function __construct(
    private readonly SomeService $service
) {
}

public function execute(array $data): Doctor
{
    // Usa $this->service
    
    // ...
}
```

### 4. Mancanza di Tipi di Ritorno

```php
// ❌ ERRATO
public function execute(array $data)
{
    // ...
}

// ✅ CORRETTO
public function execute(array $data): Doctor
{
    // ...
}
```

## Conclusione

Le Actions sono un pattern potente per organizzare la logica di business nell'applicazione. Seguendo le best practices descritte in questo documento, puoi creare Actions robuste, testabili e manutenibili che rappresentano i casi d'uso della tua applicazione in modo chiaro e conciso.

# Best Practices per Actions (Queueable)

## Regola Fondamentale

Tutte le Actions che possono essere eseguite in modo asincrono o che richiedono scalabilità devono SEMPRE usare il trait `Spatie\QueueableAction\QueueableAction`.

- Permette di eseguire l'action sia in modo sincrono che asincrono (onQueue)
- Garantisce compatibilità con Horizon, retry, chain, ecc.
- Favorisce la testabilità e la separazione delle responsabilità

## Esempio
```php
use Spatie\QueueableAction\QueueableAction;

final class FetchEventsAction
{
    use QueueableAction;
    // ...
}
```

## Motivazione
- Scalabilità: permette di delegare carichi pesanti alla coda
- Performance: evita blocchi nel thread principale
- Standardizzazione: tutte le actions seguono lo stesso pattern

## Collegamenti
- [queueable-actions-guide.md](queueable-actions-guide.md)
- [Xot/docs/struttura-path-moduli.mdc](../../Xot/docs/struttura-path-moduli.mdc)
- [directory-structure.md](directory-structure.md)
- [README.md](README.md)
- [fullcalendar_parental_widgets.md](fullcalendar_parental_widgets.md)
