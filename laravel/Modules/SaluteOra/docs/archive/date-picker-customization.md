# Personalizzazione Avanzata di DatePicker in Filament

Questo documento descrive in dettaglio come implementare e personalizzare un selettore di date avanzato per i form di Filament, con un focus specifico sulla prenotazione di appuntamenti nel modulo SaluteOra.

## Indice

1. [Introduzione](#introduzione)
2. [Implementazione di Base](#implementazione-di-base)
3. [Personalizzazione Avanzata](#personalizzazione-avanzata)
    - [Disponibilità delle Date](#disponibilità-delle-date)
    - [Gestione dei Giorni Non Lavorativi](#gestione-dei-giorni-non-lavorativi)
    - [Integrazione con il Calendario](#integrazione-con-il-calendario)
    - [Reattività e Stato del Form](#reattività-e-stato-del-form)
4. [Pattern di Implementazione Consigliati](#pattern-di-implementazione-consigliati)
5. [Esempi Completi](#esempi-completi)
6. [Manutenzione e Scalabilità](#manutenzione-e-scalabilità)
7. [Considerazioni di Performance](#considerazioni-di-performance)

## Introduzione

Il componente `DatePicker` di Filament è estremamente versatile ma richiede una configurazione avanzata per soddisfare requisiti specifici come:

- Mostrare direttamente il calendario senza necessità di clic aggiuntivi
- Disabilitare specifici giorni della settimana o date (es. weekend, festività)
- Aggiornare dinamicamente altri campi in base alla data selezionata
- Gestire le disponibilità in tempo reale

Questa guida fornisce un'implementazione dettagliata con best practices e pattern riutilizzabili per tutta l'applicazione.

## Implementazione di Base

Il componente `DatePicker` di base può essere configurato per mostrare automaticamente il calendario e reagire a eventi di selezione:

```php
DatePicker::make('appointment_date')
    ->label(__('saluteora::fields.appointment_date'))
    ->minDate(now())
    ->maxDate(now()->addMonths(3))
    ->required()
    ->native(false)
    ->displayFormat('d/m/Y')
```

## Personalizzazione Avanzata

### Disponibilità delle Date

Per mostrare un calendario direttamente aperto con solo date selezionabili, è necessario:

1. **Mantenere il calendario aperto**:

```php
DatePicker::make('appointment_date')
    // Configurazione base...
    ->disablePopover() // Rimuove il popover tradizionale
    ->closeOnDateSelection(false) // Mantiene il calendario aperto dopo la selezione
    ->openToDate(now()->addDay()) // Apre automaticamente il calendario su una data specifica
```

2. **Disabilitare date non disponibili**:

```php
->disabledDates($this->getDisabledDates())
```

La logica per determinare le date non disponibili può essere implementata come:

```php
/**
 * Ottiene le date non disponibili per gli appuntamenti
 * 
 * @return array<string> Date formattate nel formato Y-m-d
 */
protected function getDisabledDates(): array
{
    $disabledDates = [];
    
    // Disabilita le domeniche per i prossimi 3 mesi
    $startDate = now();
    $endDate = now()->addMonths(3);
    
    for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
        // Disabilita le domeniche (0 = domenica in Carbon)
        if ($date->dayOfWeek === 0) {
            $disabledDates[] = $date->format('Y-m-d');
        }
    }
    
    // Aggiungi festività nazionali
    $holidays = [
        '2025-12-25', // Natale
        '2025-12-26', // Santo Stefano
        '2026-01-01', // Capodanno
        '2026-01-06', // Epifania
        // Altre festività...
    ];
    
    return array_merge($disabledDates, $holidays);
}
```

3. **Date bloccate dinamicamente**:

Per disabilitare date in base a condizioni più complesse (come disponibilità dei medici), è possibile utilizzare un approccio dinamico:

```php
/**
 * Genera la lista di date non disponibili in base alle prenotazioni esistenti
 */
protected function getDynamicallyDisabledDates(): array
{
    if (!$this->data['specialization'] || !$this->data['cap']) {
        return [];
    }

    // Trova i giorni completamente occupati per la specializzazione in questa zona
    return Appointment::query()
        ->whereHas('doctor', function ($query) {
            $query->where('specialization', $this->data['specialization'])
                ->whereHas('clinic', function ($q) {
                    $q->where('cap', $this->data['cap']);
                });
        })
        ->selectRaw('DATE(appointment_date) as date, COUNT(*) as count')
        ->groupBy('date')
        ->havingRaw('COUNT(*) >= (SELECT COUNT(*) FROM doctors WHERE specialization = ? AND cap = ?)', [$this->data['specialization'], $this->data['cap']])
        ->pluck('date')
        ->map(fn($date) => Carbon::parse($date)->format('Y-m-d'))
        ->toArray();
}
```

### Gestione dei Giorni Non Lavorativi

1. **Impostare il primo giorno della settimana**:

```php
->firstDayOfWeek(1) // 1 = lunedì (standard europeo)
```

2. **Timezone corretta**:

```php
->timezone('Europe/Rome')
```

### Integrazione con il Calendario

Per integrare completamente con il sistema di gestione degli appuntamenti:

```php
->afterStateUpdated(function (Set $set, $state) {
    // Aggiorna gli slot orari disponibili
    $this->updateAvailableTimeSlots($set, $state);
})
```

Implementazione del metodo:

```php
/**
 * Aggiorna gli slot orari disponibili in base alla data selezionata
 * 
 * @param \Filament\Forms\Set $set
 * @param string|null $appointmentDate
 * @return void
 */
protected function updateAvailableTimeSlots(Set $set, ?string $appointmentDate): void
{
    if (!$appointmentDate || !$this->data['specialization'] || !$this->data['cap']) {
        $set('available_slots', []);
        return;
    }

    $date = Carbon::parse($appointmentDate);
    
    // Ottieni disponibilità per data, specializzazione e CAP
    $appointments = Appointment::whereDate('appointment_date', $date)
        ->whereHas('doctor', function ($query) {
            $query->where('specialization', $this->data['specialization'])
                ->whereHas('clinic', function ($q) {
                    $q->where('cap', $this->data['cap']);
                });
        })
        ->pluck('time_slot')
        ->toArray();
    
    // Definisci tutti gli slot possibili 
    $allSlots = $this->generateTimeSlots('09:00', '19:00', 30); // dalle 9:00 alle 19:00 con intervalli di 30 minuti
    
    // Rimuovi gli slot già prenotati
    $availableSlots = array_diff($allSlots, $appointments);
    
    $set('available_slots', $availableSlots);
    
    // Se non ci sono slot disponibili, notifica l'utente
    if (empty($availableSlots)) {
        Notification::make()
            ->warning()
            ->title(__('saluteora::notifications.no_available_slots'))
            ->body(__('saluteora::notifications.try_different_date'))
            ->send();
    }
}

/**
 * Genera slot orari a intervalli regolari
 * 
 * @param string $start Orario di inizio (formato H:i)
 * @param string $end Orario di fine (formato H:i)
 * @param int $interval Intervallo in minuti
 * @return array<string> Lista di slot orari
 */
protected function generateTimeSlots(string $start, string $end, int $interval = 30): array
{
    $slots = [];
    $startTime = Carbon::parse($start);
    $endTime = Carbon::parse($end);
    
    while ($startTime < $endTime) {
        $slots[] = $startTime->format('H:i');
        $startTime->addMinutes($interval);
    }
    
    return $slots;
}
```

### Reattività e Stato del Form

Per garantire che il componente reagisca correttamente ad altri cambiamenti nel form:

```php
'appointment_type' => Select::make('appointment_type')
    ->label('saluteora::fields.appointment_type')
    ->options(AppointmentTypeEnum::class)
    ->live() // Abilita la reattività
    ->afterStateUpdated(function (Set $set) {
        // Reinizializza le disponibilità quando cambia il tipo di appuntamento
        if ($this->data['appointment_date']) {
            $this->updateAvailableTimeSlots($set, $this->data['appointment_date']);
        }
    })
    ->required(),
```

## Pattern di Implementazione Consigliati

### 1. Separazione delle Responsabilità

Estrai la logica di business in classi o metodi dedicati:

```php
protected function getDisabledDates(): array 
{
    return app(AppointmentAvailabilityService::class)
        ->getDisabledDates($this->data['specialization'] ?? null);
}
```

### 2. Utilizzo di Servizi Condivisi

```php
// App/Services/AppointmentAvailabilityService.php

class AppointmentAvailabilityService
{
    public function getDisabledDates(?string $specialization = null): array
    {
        $holidays = $this->getNationalHolidays();
        $weekendDays = $this->getWeekendDaysForNextQuarter();
        $fullyBookedDays = $specialization 
            ? $this->getFullyBookedDaysForSpecialization($specialization)
            : [];
            
        return array_unique(array_merge($holidays, $weekendDays, $fullyBookedDays));
    }
    
    // Altri metodi...
}
```

### 3. Caching per Performance

```php
protected function getDisabledDates(): array
{
    $cacheKey = 'disabled_dates_' . ($this->data['specialization'] ?? 'all');
    
    return Cache::remember($cacheKey, now()->addHour(), function () {
        return $this->calculateDisabledDates();
    });
}
```

## Esempi Completi

### Widget di Prenotazione Completo

```php
protected function getDateStep(): array
{
    return [
        'appointment_date' => DatePicker::make('appointment_date')
            ->label(__('saluteora::fields.appointment_date'))
            ->minDate(now())
            ->maxDate(now()->addMonths(3))
            ->required()
            ->native(false)
            ->displayFormat('d/m/Y')
            ->closeOnDateSelection()
            ->timezone('Europe/Rome')
            ->disabledDates($this->getDisabledDates())
            ->afterStateUpdated(function (Set $set, $state) {
                $this->updateAvailableTimeSlots($set, $state);
            })
            ->openToDate(now()->addDay())
            ->firstDayOfWeek(1) // Inizia con lunedì
            ->disablePopover()
            ->closeOnDateSelection(false) // Mantiene il calendario aperto
            ->helperText(__('saluteora::fields.appointment_date_helper')),
            
        'appointment_type' => Select::make('appointment_type')
            ->label(__('saluteora::fields.appointment_type'))
            ->options(AppointmentTypeEnum::class)
            ->live()
            ->afterStateUpdated(function (Set $set) {
                if ($this->data['appointment_date']) {
                    $this->updateAvailableTimeSlots($set, $this->data['appointment_date']);
                }
            })
            ->required()
            ->helperText(__('saluteora::fields.appointment_type_helper')),
    ];
}
```

## Manutenzione e Scalabilità

### Aggiornamento delle Festività Nazionali

Consigliamo di spostare la definizione delle festività in un file di configurazione:

```php
// config/holidays.php
return [
    '2025' => [
        '01-01' => 'Capodanno',
        '01-06' => 'Epifania',
        // ...altri giorni
    ],
    '2026' => [
        // ...
    ],
];
```

Poi utilizzalo nel codice:

```php
protected function getNationalHolidays(): array
{
    $year = now()->year;
    $holidays = config("holidays.{$year}", []);
    
    return collect($holidays)
        ->map(fn ($name, $date) => "{$year}-{$date}")
        ->values()
        ->toArray();
}
```

### Test Automatici

```php
// Modules/SaluteOra/tests/Feature/Widgets/FindDoctorAndAppointmentWidgetTest.php

public function test_disabled_dates_include_sundays(): void
{
    $widget = new FindDoctorAndAppointmentWidget();
    $disabledDates = $widget->getDisabledDates();
    
    // Verifica che tutte le domeniche nei prossimi 3 mesi siano disabilitate
    $startDate = now();
    $endDate = now()->addMonths(3);
    
    for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
        if ($date->dayOfWeek === 0) { // Domenica
            $this->assertContains(
                $date->format('Y-m-d'), 
                $disabledDates, 
                "La domenica {$date->format('Y-m-d')} dovrebbe essere disabilitata"
            );
        }
    }
}
```

## Considerazioni di Performance

1. **Minimizzare i calcoli ripetuti**:
   - Utilizza caching per date disabilitate
   - Calcola le festività nazionali una volta sola

2. **Ottimizza le query al database**:
   - Utilizza indici sulle colonne `appointment_date` e relative foreign keys
   - Esegui query aggregate ottimizzate per disponibilità

3. **Implementa lazy loading per i dati dinamici**:
   - Carica le disponibilità solo quando necessario 
   - Utilizza debounce per evitare troppe richieste

4. **Considera limiti di scalabilità**:
   - Per sistemi con molti appuntamenti, considera l'utilizzo di un sistema di coda
   - Implementa cache con invalidazione selettiva quando vengono create/modificate prenotazioni

---

## Collegamenti alla Documentazione 

- [Implementazione DatePicker Filament](https://filamentphp.com/docs/2.x/forms/fields#date-time-picker)
- [Gestione della Disponibilità](docs/appointment-availability.md)
- [Integration con Filament e Calendar Widgets](docs/calendar-integration.md)

## Esempi di Codice Correlati

- `FindDoctorAndAppointmentWidget.php`
- `AppointmentAvailabilityService.php`
- `DoctorCalendarWidget.php`
