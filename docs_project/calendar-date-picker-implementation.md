# Implementazione del Calendario con Date Selezionabili

## Introduzione

Questo documento descrive l'implementazione di un calendario avanzato per la selezione delle date degli appuntamenti nel widget `FindDoctorAndAppointmentWidget`. L'obiettivo è fornire un'esperienza utente ottimizzata che mostri solo le date effettivamente disponibili per gli appuntamenti.

## Architettura

### 1. Componenti Principali

```php
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Illuminate\Support\Collection;
use Carbon\Carbon;
```

### 2. Struttura dei Dati

```php
class AvailableDate
{
    public function __construct(
        public readonly Carbon $date,
        public readonly bool $isAvailable,
        public readonly ?string $reason = null
    ) {}
}
```

## Implementazione

### 1. Modifica del Widget

```php
protected function getDateStep(): array
{
    return [
        'appointment_date' => DatePicker::make('appointment_date')
            ->label('saluteora::fields.appointment_date')
            ->minDate(now())
            ->maxDate(now()->addMonths(3))
            ->required()
            ->native(false)
            ->displayFormat('d/m/Y')
            ->disabledDates(fn () => $this->getDisabledDates())
            ->disabledDays(fn () => $this->getDisabledDays())
            ->helperText(fn () => $this->getDateHelperText())
            ->live()
            ->afterStateUpdated(fn (Set $set) => $this->handleDateSelection($set)),
            
        'appointment_type' => Select::make('appointment_type')
            ->label('saluteora::fields.appointment_type')
            ->options(AppointmentTypeEnum::class)
            ->required()
            ->live()
            ->afterStateUpdated(fn (Set $set) => $this->handleTypeSelection($set)),
    ];
}
```

### 2. Metodi di Supporto

```php
protected function getDisabledDates(): Collection
{
    return $this->getAvailableDates()
        ->filter(fn (AvailableDate $date) => !$date->isAvailable)
        ->map(fn (AvailableDate $date) => $date->date->format('Y-m-d'));
}

protected function getDisabledDays(): array
{
    return [
        Carbon::SUNDAY,
        Carbon::SATURDAY,
    ];
}

protected function getDateHelperText(): string
{
    return trans('saluteora::helpers.select_available_date');
}

protected function handleDateSelection(Set $set): void
{
    $date = $this->form->getState()['appointment_date'] ?? null;
    if (!$date) {
        return;
    }

    $availableDate = $this->getAvailableDates()
        ->first(fn (AvailableDate $d) => $d->date->format('Y-m-d') === $date);

    if (!$availableDate?->isAvailable) {
        $set('appointment_date', null);
        Notification::make()
            ->warning()
            ->title(trans('saluteora::notifications.date_not_available'))
            ->body($availableDate?->reason)
            ->send();
    }
}
```

### 3. Gestione delle Date Disponibili

```php
protected function getAvailableDates(): Collection
{
    $startDate = now();
    $endDate = now()->addMonths(3);
    $dates = collect();

    for ($date = $startDate->copy(); $date <= $endDate; $date->addDay()) {
        $isAvailable = $this->isDateAvailable($date);
        $reason = $isAvailable ? null : $this->getUnavailabilityReason($date);
        
        $dates->push(new AvailableDate(
            date: $date->copy(),
            isAvailable: $isAvailable,
            reason: $reason
        ));
    }

    return $dates;
}

protected function isDateAvailable(Carbon $date): bool
{
    // 1. Verifica se è un giorno lavorativo
    if ($date->isWeekend()) {
        return false;
    }

    // 2. Verifica se ci sono appuntamenti disponibili
    $availableSlots = $this->getAvailableSlotsForDate($date);
    if ($availableSlots->isEmpty()) {
        return false;
    }

    // 3. Verifica se il dottore è disponibile
    $doctorId = $this->form->getState()['doctor_id'] ?? null;
    if ($doctorId && !$this->isDoctorAvailable($doctorId, $date)) {
        return false;
    }

    return true;
}

protected function getUnavailabilityReason(Carbon $date): string
{
    if ($date->isWeekend()) {
        return trans('saluteora::reasons.weekend');
    }

    $availableSlots = $this->getAvailableSlotsForDate($date);
    if ($availableSlots->isEmpty()) {
        return trans('saluteora::reasons.no_slots');
    }

    $doctorId = $this->form->getState()['doctor_id'] ?? null;
    if ($doctorId && !$this->isDoctorAvailable($doctorId, $date)) {
        return trans('saluteora::reasons.doctor_unavailable');
    }

    return trans('saluteora::reasons.unknown');
}
```

## Ottimizzazioni

### 1. Caching

```php
protected function getAvailableDates(): Collection
{
    return Cache::remember(
        "available_dates_{$this->form->getState()['doctor_id']}",
        now()->addMinutes(30),
        fn () => $this->calculateAvailableDates()
    );
}
```

### 2. Lazy Loading

```php
protected function getDateStep(): array
{
    return [
        'appointment_date' => DatePicker::make('appointment_date')
            // ... altre configurazioni ...
            ->lazy()
            ->afterStateUpdated(function (Set $set) {
                $this->loadAvailableDates();
                $this->handleDateSelection($set);
            }),
    ];
}
```

## Best Practices

1. **Performance**
   - Utilizzare il caching per le date disponibili
   - Implementare il lazy loading per i dati
   - Ottimizzare le query al database

2. **UX/UI**
   - Mostrare chiaramente le date disponibili
   - Fornire feedback immediato sulla selezione
   - Includere tooltip informativi

3. **Manutenibilità**
   - Separare la logica di business
   - Utilizzare classi dedicate per i modelli di dati
   - Documentare il codice

4. **Sicurezza**
   - Validare tutte le date lato server
   - Implementare rate limiting
   - Gestire correttamente le sessioni

## Test

```php
class DatePickerTest extends TestCase
{
    public function test_disabled_dates_are_correctly_calculated(): void
    {
        $widget = new FindDoctorAndAppointmentWidget();
        $disabledDates = $widget->getDisabledDates();
        
        $this->assertNotEmpty($disabledDates);
        $this->assertFalse($disabledDates->contains(fn ($date) => Carbon::parse($date)->isWeekend()));
    }

    public function test_available_dates_are_cached(): void
    {
        $widget = new FindDoctorAndAppointmentWidget();
        $dates = $widget->getAvailableDates();
        
        $this->assertTrue(Cache::has("available_dates_{$widget->form->getState()['doctor_id']}"));
    }
}
```

## Collegamenti Correlati

- [Documentazione Filament DatePicker](https://filamentphp.com/docs/3.x/forms/fields/date-picker)
- [Best Practices per i Calendari](calendar-best-practices.md)
- [Gestione degli Appuntamenti](appointment-management.md) 