# Gestione degli Appuntamenti

## Introduzione

Questo documento descrive la gestione degli appuntamenti nel modulo SaluteOra, con particolare attenzione alla logica di business, alla validazione e alla gestione degli stati.

## Architettura

### 1. Modelli

```php
class Appointment extends Model
{
    protected $fillable = [
        'doctor_id',
        'patient_id',
        'appointment_date',
        'appointment_time',
        'type',
        'status',
        'notes',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'type' => AppointmentTypeEnum::class,
        'status' => AppointmentStatusEnum::class,
    ];
}
```

### 2. Enum

```php
enum AppointmentTypeEnum: string
{
    case CHECKUP = 'checkup';
    case CONSULTATION = 'consultation';
    case TREATMENT = 'treatment';

    public function getLabel(): string
    {
        return match($this) {
            self::CHECKUP => 'Controllo',
            self::CONSULTATION => 'Consulenza',
            self::TREATMENT => 'Trattamento',
        };
    }
}

enum AppointmentStatusEnum: string
{
    case PENDING = 'pending';
    case CONFIRMED = 'confirmed';
    case CANCELLED = 'cancelled';
    case COMPLETED = 'completed';

    public function getColor(): string
    {
        return match($this) {
            self::PENDING => 'warning',
            self::CONFIRMED => 'success',
            self::CANCELLED => 'danger',
            self::COMPLETED => 'info',
        };
    }
}
```

## Logica di Business

### 1. Creazione Appuntamento

```php
class CreateAppointmentAction
{
    public function __construct(
        private readonly AppointmentRepository $repository,
        private readonly NotificationService $notifications
    ) {}

    public function execute(array $data): Appointment
    {
        // 1. Validare i dati
        $this->validateData($data);

        // 2. Verificare la disponibilità
        $this->checkAvailability($data);

        // 3. Creare l'appuntamento
        $appointment = $this->repository->create($data);

        // 4. Inviare notifiche
        $this->notifications->sendAppointmentCreated($appointment);

        return $appointment;
    }

    private function validateData(array $data): void
    {
        Validator::make($data, [
            'doctor_id' => ['required', 'exists:doctors,id'],
            'patient_id' => ['required', 'exists:patients,id'],
            'appointment_date' => ['required', 'date', 'after:today'],
            'appointment_time' => ['required', 'date_format:H:i'],
            'type' => ['required', 'in:' . implode(',', array_column(AppointmentTypeEnum::cases(), 'value'))],
        ])->validate();
    }

    private function checkAvailability(array $data): void
    {
        $isAvailable = $this->repository->isTimeSlotAvailable(
            $data['doctor_id'],
            $data['appointment_date'],
            $data['appointment_time']
        );

        if (!$isAvailable) {
            throw new TimeSlotNotAvailableException();
        }
    }
}
```

### 2. Gestione degli Stati

```php
class AppointmentStateManager
{
    public function __construct(
        private readonly Appointment $appointment,
        private readonly NotificationService $notifications
    ) {}

    public function confirm(): void
    {
        $this->appointment->update(['status' => AppointmentStatusEnum::CONFIRMED]);
        $this->notifications->sendAppointmentConfirmed($this->appointment);
    }

    public function cancel(string $reason): void
    {
        $this->appointment->update([
            'status' => AppointmentStatusEnum::CANCELLED,
            'cancellation_reason' => $reason
        ]);
        $this->notifications->sendAppointmentCancelled($this->appointment);
    }

    public function complete(): void
    {
        $this->appointment->update(['status' => AppointmentStatusEnum::COMPLETED]);
        $this->notifications->sendAppointmentCompleted($this->appointment);
    }
}
```

## Validazione

### 1. Regole di Validazione

```php
class AppointmentValidationRules
{
    public static function create(): array
    {
        return [
            'doctor_id' => ['required', 'exists:doctors,id'],
            'patient_id' => ['required', 'exists:patients,id'],
            'appointment_date' => [
                'required',
                'date',
                'after:today',
                'before:3 months',
            ],
            'appointment_time' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) {
                    if (!$this->isValidTimeSlot($value)) {
                        $fail('L\'orario selezionato non è valido.');
                    }
                },
            ],
            'type' => [
                'required',
                'in:' . implode(',', array_column(AppointmentTypeEnum::cases(), 'value')),
            ],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    private function isValidTimeSlot(string $time): bool
    {
        $time = Carbon::parse($time);
        $start = Carbon::parse('09:00');
        $end = Carbon::parse('17:00');

        return $time->between($start, $end) && $time->minute === 0;
    }
}
```

### 2. Custom Validation Rules

```php
class ValidAppointmentTimeRule implements Rule
{
    public function passes($attribute, $value): bool
    {
        $time = Carbon::parse($value);
        $start = Carbon::parse('09:00');
        $end = Carbon::parse('17:00');

        return $time->between($start, $end) && $time->minute === 0;
    }

    public function message(): string
    {
        return 'L\'orario selezionato non è valido.';
    }
}
```

## Notifiche

### 1. Template

```php
class AppointmentNotificationTemplate
{
    public static function created(Appointment $appointment): array
    {
        return [
            'subject' => 'Nuovo Appuntamento Creato',
            'body' => view('emails.appointments.created', [
                'appointment' => $appointment,
            ])->render(),
        ];
    }

    public static function confirmed(Appointment $appointment): array
    {
        return [
            'subject' => 'Appuntamento Confermato',
            'body' => view('emails.appointments.confirmed', [
                'appointment' => $appointment,
            ])->render(),
        ];
    }
}
```

### 2. Servizio di Notifica

```php
class AppointmentNotificationService
{
    public function __construct(
        private readonly Mailer $mailer,
        private readonly NotificationChannel $notificationChannel
    ) {}

    public function sendAppointmentCreated(Appointment $appointment): void
    {
        $template = AppointmentNotificationTemplate::created($appointment);
        
        $this->mailer->to($appointment->patient->email)
            ->send(new AppointmentNotification($template));
            
        $this->notificationChannel->send(
            $appointment->patient,
            $template['subject'],
            $template['body']
        );
    }
}
```

## Test

### 1. Unit Test

```php
class AppointmentTest extends TestCase
{
    public function test_can_create_appointment(): void
    {
        $action = new CreateAppointmentAction(
            $this->app->make(AppointmentRepository::class),
            $this->app->make(NotificationService::class)
        );

        $appointment = $action->execute([
            'doctor_id' => $this->doctor->id,
            'patient_id' => $this->patient->id,
            'appointment_date' => now()->addDay(),
            'appointment_time' => '10:00',
            'type' => AppointmentTypeEnum::CHECKUP->value,
        ]);

        $this->assertInstanceOf(Appointment::class, $appointment);
        $this->assertEquals(AppointmentStatusEnum::PENDING, $appointment->status);
    }
}
```

### 2. Feature Test

```php
class AppointmentBookingTest extends TestCase
{
    public function test_patient_can_book_appointment(): void
    {
        $this->actingAs($this->patient)
            ->post(route('appointments.store'), [
                'doctor_id' => $this->doctor->id,
                'appointment_date' => now()->addDay()->format('Y-m-d'),
                'appointment_time' => '10:00',
                'type' => AppointmentTypeEnum::CHECKUP->value,
            ])
            ->assertRedirect()
            ->assertSessionHas('success');
    }
}
```

## Monitoraggio

### 1. Metriche

```php
class AppointmentMetrics
{
    public function trackAppointmentCreated(Appointment $appointment): void
    {
        Metrics::increment('appointments.created');
        Metrics::timing('appointment.creation_time', $appointment->created_at->diffInMilliseconds());
    }

    public function trackAppointmentStatusChange(Appointment $appointment): void
    {
        Metrics::increment("appointments.status.{$appointment->status->value}");
    }
}
```

### 2. Logging

```php
class AppointmentLogger
{
    public function logAppointmentCreated(Appointment $appointment): void
    {
        Log::channel('appointments')->info('Appuntamento creato', [
            'id' => $appointment->id,
            'doctor_id' => $appointment->doctor_id,
            'patient_id' => $appointment->patient_id,
            'date' => $appointment->appointment_date->format('Y-m-d'),
            'time' => $appointment->appointment_time,
            'type' => $appointment->type->value,
        ]);
    }
}
```

## Collegamenti Correlati

- [Implementazione del Calendario](calendar-date-picker-implementation.md)
- [Best Practices per i Calendari](calendar-best-practices.md)
- [Documentazione Filament](https://filamentphp.com/docs)

## [AGGIORNAMENTO 2024-06-XX] - Standardizzazione Traduzioni

La struttura delle traduzioni per gli appuntamenti è stata aggiornata secondo le regole di progetto, la filosofia DRY/KISS, la religione della centralizzazione e la politica del nessun lock-in. Tutte le chiavi sono ora in inglese, strutturate gerarchicamente e coerenti con le best practice del modulo Lang.

### Nuova struttura esempio (estratto da lang/it/appointment.php):

```php
return [
    'navigation' => [
        'label' => 'Appuntamenti',
        'group' => 'Gestione Clinica',
        'icon' => 'heroicon-o-calendar',
        'color' => 'success',
        'sort' => 3,
        'tooltip' => 'Gestione degli appuntamenti e delle visite',
    ],
    'model' => [
        'label' => 'Appuntamento',
        'plural' => 'Appuntamenti',
    ],
    'fields' => [
        'title' => [...],
        'doctor_id' => [...],
        'patient_id' => [...],
        'studio_id' => [...],
        'start_time' => [...],
        'end_time' => [...],
        'status' => [...],
        'notes' => [...],
        'reason' => [...],
    ],
    'actions' => [...],
    'filters' => [...],
    'calendar' => [...],
    'notifications' => [...],
    'messages' => [...],
];
```

- Le chiavi sono solo in inglese, mai in italiano.
- Ogni campo ha label, placeholder, helper_text, description.
- Gli status sono centralizzati e coerenti con enums e states.php.
- Le azioni sono DRY e riutilizzabili.
- La documentazione Lang è ora collegata: vedi [Lang/translation-standards.md](../../Lang/docs/translation-standards.md) e [Lang/translation_keys_best_practices.md](../../Lang/docs/translation_keys_best_practices.md).

### Motivazione della correzione
- Evitare errori di duplicazione, chiavi ambigue, lock-in e mancanza di coerenza tra moduli.
- Garantire la massima manutenibilità e la serenità del codice (zen).

### Checklist per evitare errori futuri
- Usare sempre chiavi inglesi e struttura gerarchica.
- Aggiornare la documentazione Lang e SaluteOra ad ogni modifica.
- Non duplicare chiavi tra moduli.
- Validare la presenza di tutte le chiavi in tutte le lingue.
- Seguire la filosofia DRY, KISS, centralizzazione.

---

Per dettagli sulle regole di traduzione, vedi anche:
- [Lang/translation-standards.md](../../Lang/docs/translation-standards.md)
- [Lang/translation_keys_best_practices.md](../../Lang/docs/translation_keys_best_practices.md)
- [SaluteOra/filament-best-practices.mdc](./filament-best-practices.mdc) 
