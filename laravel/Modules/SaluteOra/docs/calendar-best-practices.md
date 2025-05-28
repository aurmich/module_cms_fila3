# Best Practices per l'Implementazione dei Calendari

## Introduzione

Questo documento descrive le best practices per l'implementazione dei calendari nel modulo SaluteOra, con particolare attenzione all'esperienza utente, alle performance e alla manutenibilità.

## Principi Fondamentali

### 1. UX/UI

#### Visualizzazione
- Utilizzare colori distintivi per le date disponibili/non disponibili
- Mostrare tooltip informativi al passaggio del mouse
- Implementare feedback visivi per le interazioni
- Mantenere una coerenza visiva con il design system

#### Interazione
- Permettere la navigazione rapida tra i mesi
- Implementare scorciatoie da tastiera
- Fornire feedback immediato sulle azioni
- Gestire correttamente gli stati di caricamento

### 2. Performance

#### Ottimizzazione dei Dati
```php
// Utilizzare il caching per le date disponibili
protected function getAvailableDates(): Collection
{
    return Cache::remember(
        "available_dates_{$this->doctorId}",
        now()->addMinutes(30),
        fn () => $this->calculateAvailableDates()
    );
}

// Implementare il lazy loading
protected function loadAvailableDates(): void
{
    $this->availableDates = $this->getAvailableDates();
    $this->dispatch('available-dates-loaded');
}
```

#### Query al Database
```php
// Ottimizzare le query per gli slot disponibili
protected function getAvailableSlotsForDate(Carbon $date): Collection
{
    return Appointment::query()
        ->where('doctor_id', $this->doctorId)
        ->whereDate('appointment_date', $date)
        ->where('status', AppointmentStatus::AVAILABLE)
        ->select(['id', 'time_slot'])
        ->get();
}
```

### 3. Manutenibilità

#### Struttura del Codice
```php
// Separare la logica di business
class AppointmentCalendar
{
    public function __construct(
        private readonly Doctor $doctor,
        private readonly AppointmentRepository $repository
    ) {}

    public function getAvailableDates(): Collection
    {
        return $this->repository->getAvailableDates($this->doctor);
    }
}

// Utilizzare DTO per i dati
class AvailableDateDTO
{
    public function __construct(
        public readonly Carbon $date,
        public readonly bool $isAvailable,
        public readonly ?string $reason = null
    ) {}
}
```

#### Documentazione
```php
/**
 * Calcola le date disponibili per un dottore.
 *
 * @param Doctor $doctor Il dottore per cui calcolare le date
 * @param Carbon $startDate La data di inizio
 * @param Carbon $endDate La data di fine
 * @return Collection<AvailableDateDTO>
 */
public function calculateAvailableDates(
    Doctor $doctor,
    Carbon $startDate,
    Carbon $endDate
): Collection
```

### 4. Sicurezza

#### Validazione
```php
// Validare le date lato server
public function rules(): array
{
    return [
        'appointment_date' => [
            'required',
            'date',
            'after:today',
            'before:3 months',
            function ($attribute, $value, $fail) {
                if (!$this->isDateAvailable($value)) {
                    $fail('La data selezionata non è disponibile.');
                }
            },
        ],
    ];
}
```

#### Rate Limiting
```php
// Implementare rate limiting per le richieste
Route::middleware(['throttle:60,1'])->group(function () {
    Route::get('/available-dates', [AppointmentController::class, 'getAvailableDates']);
});
```

## Implementazione Consigliata

### 1. Componente Base
```php
class AppointmentDatePicker extends DatePicker
{
    public function __construct(string $name)
    {
        parent::__construct($name);

        $this
            ->minDate(now())
            ->maxDate(now()->addMonths(3))
            ->displayFormat('d/m/Y')
            ->native(false)
            ->live();
    }
}
```

### 2. Gestione degli Stati
```php
class AppointmentCalendarState
{
    public function __construct(
        public readonly ?Carbon $selectedDate = null,
        public readonly ?string $selectedTime = null,
        public readonly ?AppointmentTypeEnum $type = null
    ) {}

    public function isValid(): bool
    {
        return $this->selectedDate && $this->selectedTime && $this->type;
    }
}
```

### 3. Eventi e Notifiche
```php
class AppointmentCalendarEvents
{
    public const DATE_SELECTED = 'appointment.date.selected';
    public const TIME_SELECTED = 'appointment.time.selected';
    public const TYPE_SELECTED = 'appointment.type.selected';
}
```

## Test

### 1. Unit Test
```php
class AppointmentCalendarTest extends TestCase
{
    public function test_calculates_available_dates_correctly(): void
    {
        $calendar = new AppointmentCalendar($this->doctor);
        $dates = $calendar->getAvailableDates();

        $this->assertNotEmpty($dates);
        $this->assertFalse($dates->contains(fn ($date) => $date->isWeekend()));
    }
}
```

### 2. Feature Test
```php
class AppointmentBookingTest extends TestCase
{
    public function test_user_can_select_available_date(): void
    {
        $this->actingAs($this->user)
            ->get(route('appointments.available-dates'))
            ->assertOk()
            ->assertJsonStructure(['dates']);
    }
}
```

## Monitoraggio

### 1. Metriche da Tracciare
- Tempo di caricamento del calendario
- Numero di richieste per le date disponibili
- Tasso di conversione (selezioni completate)
- Errori e fallimenti

### 2. Logging
```php
Log::channel('appointments')->info('Date disponibili calcolate', [
    'doctor_id' => $this->doctorId,
    'date_range' => [
        'start' => $startDate->format('Y-m-d'),
        'end' => $endDate->format('Y-m-d'),
    ],
    'available_dates_count' => $dates->count(),
]);
```

## Collegamenti Correlati

- [Implementazione del Calendario](calendar-date-picker-implementation.md)
- [Gestione degli Appuntamenti](appointment-management.md)
- [Documentazione Filament](https://filamentphp.com/docs)

## Gestione Orari di Apertura: Best Practice

Per la gestione degli orari di apertura di studi, risorse e servizi, utilizzare SEMPRE il campo custom [OpeningHoursField](../form-components/opening-hours-field.md), che garantisce:
- Compatibilità diretta con la libreria Spatie/opening-hours
- UX avanzata e validazione live
- Serializzazione standard e riuso in più moduli

Vedi anche: [form-components/README.md](../form-components/README.md) 
