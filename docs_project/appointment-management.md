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
    case AVAILABILITY = 'availability';

    public function getLabel(): string
    {
        return match($this) {
            self::CHECKUP => 'Controllo',
            self::CONSULTATION => 'Consulenza',
            self::TREATMENT => 'Trattamento',
            self::AVAILABILITY => 'Disponibilità',
        };
    }
}

enum AppointmentStatusEnum: string
{
    case PENDING = 'pending';
    case CONFIRMED = 'confirmed';
    case CANCELLED = 'cancelled';
    case COMPLETED = 'completed';
    case AVAILABLE = 'available';

    public function getColor(): string
    {
        return match($this) {
            self::PENDING => 'warning',
            self::CONFIRMED => 'success',
            self::CANCELLED => 'danger',
            self::COMPLETED => 'info',
            self::AVAILABLE => 'success',
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

## [AGGIORNAMENTO 2024-06-XX] - Disponibilità solo su appointments

**Regola fondamentale:**
- Le disponibilità dei dottori vanno gestite solo tramite la tabella `appointments` (con `patient_id` null o flag dedicato).
- È vietato creare tabelle o modelli separati (es. doctor_availabilities) per le disponibilità.
- Tutto il calendario (FullCalendar/Filament) lavora su appointments, distinguendo tra disponibilità e appuntamenti tramite i campi esistenti.

**Motivazione:**
- Filosofia: un solo punto di verità, nessuna duplicazione, serenità del codice.
- Logica: DRY, KISS, nessun lock-in, massima compatibilità con FullCalendar e Filament.
- Religione: non avrai altro modello di disponibilità all'infuori di Appointment.
- Politica: ogni modulo è autonomo, ma rispetta la centralizzazione delle entità.
- Zen: serenità, nessun errore di sync, nessuna tabella fantasma, nessun refactor doloroso.

**Checklist aggiornata:**
- Gestire sempre le disponibilità tramite appointments
- Vietato creare/gestire tabelle o modelli separati per le disponibilità
- Aggiornare la documentazione ogni volta che si modifica la logica di disponibilità/appuntamenti
- Seguire sempre la filosofia DRY, KISS, centralizzazione

**Collegamenti:**
- [calendar/doctor-availability-management.md](calendar/doctor-availability-management.md)
- [calendar/widgets/doctor-calendar-widget.md](calendar/widgets/doctor-calendar-widget.md)
- [fullcalendar_parental_widgets.md](fullcalendar_parental_widgets.md)

# Disponibilità del Dottore: Policy DRY

## Un solo punto di verità: Appointment

La disponibilità del dottore NON è gestita tramite una tabella custom (es. doctor_availabilities), ma è rappresentata da record nella tabella `appointments` con:
- `type = availability` (o valore equivalente nell'enum AppointmentTypeEnum)
- `status = available` (o valore equivalente nell'enum AppointmentStatusEnum)

Tutti gli slot disponibili, le prenotazioni e gli appuntamenti sono gestiti tramite il modello Appointment.

### Esempio di query per slot disponibili
```php
Appointment::where('doctor_id', $doctorId)
    ->where('type', AppointmentTypeEnum::AVAILABILITY)
    ->where('status', AppointmentStatusEnum::AVAILABLE)
    ->get();
```

### Motivazione filosofica, politica, zen
- Un solo punto di verità: nessuna duplicazione, nessun lock-in
- DRY, KISS, serenità del codice
- Refactoring sicuro, massima estendibilità

## Architettura aggiornata
- Tutte le logiche di disponibilità, prenotazione, approvazione sono centralizzate su Appointment
- Nessuna tabella custom per la disponibilità
- Gli slot disponibili sono Appointment con type/status specifici
- Gli appuntamenti richiesti/confermati sono Appointment con altri type/status

## Logica di business aggiornata
- Per aggiungere una disponibilità: crea un Appointment con type=availability, status=available
- Per prenotare: il paziente seleziona uno slot disponibile (Appointment già esistente) oppure crea un nuovo Appointment con type=visita, status=pending
- Per approvare: il dottore cambia lo status dell'Appointment

## Gestione Doctor come User (STI/Parental)

Nel sistema SaluteOra, il dottore (**Doctor**) non è una tabella separata, ma un tipo di User gestito tramite Single Table Inheritance (STI) o Parental. La tabella di riferimento è sempre `users`, e il tipo è identificato dal campo `type` (stringa o enum).

- **Vietato** cercare la colonna `user_id` nella tabella `users` (non esiste).
- **Vietato** creare join o modelli duplicati per Doctor.
- **Tutta la logica di fetch, policy, tenancy, va fatta su User filtrando per type = 'doctor'** (o enum).

### Esempio di query corretta
```php
User::where('id', $id)->where('type', 'doctor')->firstOrFail();
// oppure con enum
User::where('id', $id)->where('type', UserTypeEnum::DOCTOR->value)->firstOrFail();
```

### Motivazione filosofica, politica, zen
- Un solo punto di verità: User è la tabella, Doctor è solo un "type"
- Nessuna duplicazione: niente modelli, tabelle, join inutili
- DRY, KISS, serenità del codice: tutto centralizzato, nessun errore di mapping, refactoring sicuro
- Politica: ogni modulo è autonomo, ma rispetta la centralizzazione delle entità
- Religione: "Non avrai altro modello di dottore all'infuori di User"

## Widget FullCalendar: policy di configurazione

La configurazione del calendario FullCalendar (plugin Saade/FilamentFullCalendar) va fatta **solo** tramite override del metodo `config(): array` in un widget custom che estende FullCalendarWidget. **Non è mai consentito** usare metodi fluenti come `->config()` su FullCalendarWidget::make().

### Esempio corretto
```php
class DoctorAvailabilityCalendarWidget extends FullCalendarWidget
{
    public function config(): array
    {
        return [
            'initialView' => 'timeGridWeek',
            // ...altre opzioni
        ];
    }
}
```

### Motivazione filosofica, politica, zen
- Un solo punto di verità: la configurazione è centralizzata nel widget custom
- DRY, KISS, serenità del codice: niente hack, niente override strani, tutto documentato e coerente
- Politica: ogni modulo è autonomo, ma rispetta la centralizzazione delle entità e dei componenti

## Errori comuni nella configurazione FullCalendar

### 1. Errori di sintassi array
- **Errore tipico:** chiudere un array con `])` invece che solo `]`, oppure lasciare una virgola in eccesso.
- **Corretto:**
```php
'businessHours' => [
    'startTime' => '08:00',
    'endTime' => '19:00',
    'daysOfWeek' => [1, 2, 3, 4, 5],
],
```

### 2. Errori di import Action
- **Errore tipico:** `use Filament\Pages\Actions\Action;` (classe non trovata)
- **Corretto:** `use Filament\Actions\Action;`

### 3. Errori di configurazione FullCalendar
- **Errore tipico:** usare `->config([...])` su `FullCalendarWidget::make()`
- **Corretto:** override del metodo `config()` in un widget custom.

### Motivazione filosofica, politica, zen
- Un solo punto di verità: sintassi e import corretti, configurazione centralizzata
- DRY, KISS, serenità del codice: niente hack, niente override strani, tutto documentato e coerente
- Politica: ogni modulo è autonomo, ma rispetta la centralizzazione delle entità e dei componenti
