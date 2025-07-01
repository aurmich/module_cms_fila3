# InlineDatePicker: Implementazione Livewire per SaluteMo

## Contesto del Modulo

Nel modulo SaluteMo, l'`InlineDatePicker` è utilizzato principalmente nel widget `FindDoctorAndAppointmentWidget` per la selezione di date di appuntamento. L'attuale implementazione passa tutte le date disponibili al frontend tramite `@js($enabledDates->toArray())`.

## Analisi Specifica per SaluteMo

### Caso d'Uso Corrente
- **Widget**: `FindDoctorAndAppointmentWidget`
- **Contesto**: Selezione date per appuntamenti medici
- **Volume Date**: Variabile (tipicamente 30-90 giorni)
- **Dinamicità**: Alta (disponibilità cambia in real-time)

### Problematiche Identificate

#### 1. Disponibilità Real-Time
Nel contesto sanitario, la disponibilità degli slot può cambiare rapidamente:
- Altri pazienti prenotano contemporaneamente
- Medici modificano i loro orari
- Emergenze bloccano slot disponibili

#### 2. Payload Size
Con 3 mesi di disponibilità e controlli orari, l'array può contenere centinaia di date.

#### 3. Sicurezza
La validazione solo lato client può essere aggirata per prenotazioni non autorizzate.

## Implementazione Tecnica Specifica

### 1. Modifica al Widget FindDoctorAndAppointmentWidget

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Filament\Widgets\Patient;

use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Modules\SaluteMo\Services\AppointmentAvailabilityService;
use Carbon\Carbon;

class FindDoctorAndAppointmentWidget extends XotBaseWidget
{
    public string $currentCalendarMonth;
    
    protected AppointmentAvailabilityService $availabilityService;
    
    public function boot(): void
    {
        $this->availabilityService = app(AppointmentAvailabilityService::class);
    }
    
    /**
     * Valida la disponibilità di una data per appuntamento.
     * 
     * @param string $dateString Data nel formato Y-m-d
     * @return array{enabled: bool, reason?: string, availableSlots?: array}
     */
    public function validateAppointmentDate(string $dateString): array
    {
        try {
            $date = Carbon::createFromFormat('Y-m-d', $dateString);
            
            // Controlli di base
            if ($date->isPast()) {
                return [
                    'enabled' => false,
                    'reason' => __('saluteora::appointments.past_date_not_allowed')
                ];
            }
            
            if ($date->isWeekend()) {
                return [
                    'enabled' => false,
                    'reason' => __('saluteora::appointments.weekend_not_available')
                ];
            }
            
            // Controllo disponibilità real-time
            $availability = $this->availabilityService->checkDateAvailability(
                $date, 
                $this->getSelectedDoctor(),
                $this->getSelectedStudio()
            );
            
            if (!$availability->isAvailable()) {
                return [
                    'enabled' => false,
                    'reason' => $availability->getReason()
                ];
            }
            
            return [
                'enabled' => true,
                'availableSlots' => $availability->getAvailableSlots()->map(function($slot) {
                    return [
                        'time' => $slot->format('H:i'),
                        'duration' => $slot->getDuration(),
                        'type' => $slot->getType()
                    ];
                })->toArray()
            ];
            
        } catch (\Exception $e) {
            \Log::error('Errore validazione data appuntamento', [
                'date' => $dateString,
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);
            
            return [
                'enabled' => false,
                'reason' => __('saluteora::appointments.validation_error')
            ];
        }
    }
    
    /**
     * Pre-carica le disponibilità per un mese specifico (ottimizzazione).
     * 
     * @param string $monthString Mese nel formato Y-m
     * @return array
     */
    public function preloadMonthAvailability(string $monthString): array
    {
        $startDate = Carbon::createFromFormat('Y-m', $monthString)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();
        
        $availabilities = $this->availabilityService->getAvailabilitiesForPeriod(
            $startDate,
            $endDate,
            $this->getSelectedDoctor(),
            $this->getSelectedStudio()
        );
        
        return $availabilities->mapWithKeys(function($availability, $date) {
            return [$date => [
                'enabled' => $availability->isAvailable(),
                'slotsCount' => $availability->getAvailableSlots()->count()
            ]];
        })->toArray();
    }
}
```

### 2. Service per Gestione Disponibilità

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Services;

use Carbon\Carbon;
use Modules\SaluteMo\Models\Doctor;
use Modules\SaluteMo\Models\Studio;
use Modules\SaluteMo\Data\AvailabilityData;
use Illuminate\Support\Collection;

class AppointmentAvailabilityService
{
    /**
     * Verifica disponibilità per una data specifica.
     */
    public function checkDateAvailability(
        Carbon $date, 
        ?Doctor $doctor = null, 
        ?Studio $studio = null
    ): AvailabilityData {
        // Cache key basata su parametri
        $cacheKey = "availability_{$date->format('Y-m-d')}_{$doctor?->id}_{$studio?->id}";
        
        return cache()->remember($cacheKey, now()->addMinutes(5), function() use ($date, $doctor, $studio) {
            return $this->calculateAvailability($date, $doctor, $studio);
        });
    }
    
    /**
     * Ottiene disponibilità per un periodo.
     */
    public function getAvailabilitiesForPeriod(
        Carbon $startDate,
        Carbon $endDate,
        ?Doctor $doctor = null,
        ?Studio $studio = null
    ): Collection {
        $availabilities = collect();
        
        $currentDate = $startDate->copy();
        while ($currentDate->lte($endDate)) {
            $availability = $this->checkDateAvailability($currentDate, $doctor, $studio);
            $availabilities->put($currentDate->format('Y-m-d'), $availability);
            $currentDate->addDay();
        }
        
        return $availabilities;
    }
    
    /**
     * Calcola la disponibilità effettiva.
     */
    protected function calculateAvailability(
        Carbon $date, 
        ?Doctor $doctor, 
        ?Studio $studio
    ): AvailabilityData {
        // Logica complessa di calcolo disponibilità
        // - Controllo orari studio
        // - Controllo agenda medico
        // - Controllo appuntamenti esistenti
        // - Controllo ferie/permessi
        // - Controllo emergenze
        
        // Placeholder per logica complessa
        $isAvailable = true;
        $reason = null;
        $availableSlots = collect();
        
        return new AvailabilityData(
            isAvailable: $isAvailable,
            reason: $reason,
            availableSlots: $availableSlots
        );
    }
}
```

### 3. Data Object per Disponibilità

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Data;

use Spatie\LaravelData\Data;
use Illuminate\Support\Collection;

class AvailabilityData extends Data
{
    public function __construct(
        public readonly bool $isAvailable,
        public readonly ?string $reason = null,
        public readonly Collection $availableSlots = new Collection(),
        public readonly array $metadata = []
    ) {}
    
    public function isAvailable(): bool
    {
        return $this->isAvailable;
    }
    
    public function getReason(): ?string
    {
        return $this->reason;
    }
    
    public function getAvailableSlots(): Collection
    {
        return $this->availableSlots;
    }
    
    public function hasSlots(): bool
    {
        return $this->availableSlots->isNotEmpty();
    }
}
```

### 4. Modifica alla Vista con Approccio Ibrido

```javascript
// Approccio ibrido: cache + validazione Livewire
x-data="{
    selectedDate: @js($currentValue),
    monthCache: new Map(),
    isValidating: false,
    validationMessage: null,
    availableSlots: [],
    
    async selectDate(dateString) {
        // Controlla cache mensile prima
        const cached = this.getMonthCache(dateString);
        if (cached && !cached.enabled) {
            this.showDateNotAvailable(cached.reason || 'Data non disponibile');
            return;
        }
        
        // Se potenzialmente disponibile, valida con Livewire
        this.isValidating = true;
        this.validationMessage = null;
        
        try {
            const result = await $wire.call('validateAppointmentDate', dateString);
            
            if (result.enabled) {
                this.selectedDate = dateString;
                this.availableSlots = result.availableSlots || [];
                $wire.set('{{ $statePath }}', dateString);
                
                // Mostra slot disponibili
                this.showAvailableSlots();
            } else {
                this.showDateNotAvailable(result.reason);
            }
            
        } catch (error) {
            console.error('Errore validazione:', error);
            this.validationMessage = 'Errore di connessione. Riprova.';
        } finally {
            this.isValidating = false;
        }
    },
    
    async preloadMonth(monthString) {
        if (this.monthCache.has(monthString)) {
            return; // Già in cache
        }
        
        try {
            const monthData = await $wire.call('preloadMonthAvailability', monthString);
            this.monthCache.set(monthString, monthData);
        } catch (error) {
            console.error('Errore preload mese:', error);
        }
    },
    
    getMonthCache(dateString) {
        const monthString = dateString.substring(0, 7); // YYYY-MM
        const monthData = this.monthCache.get(monthString);
        return monthData ? monthData[dateString] : null;
    },
    
    showDateNotAvailable(reason) {
        this.selectedDate = null;
        this.availableSlots = [];
        this.validationMessage = reason;
        $wire.set('{{ $statePath }}', null);
        
        setTimeout(() => {
            this.validationMessage = null;
        }, 4000);
    },
    
    showAvailableSlots() {
        // Trigger evento per mostrare slot disponibili nel step successivo
        $dispatch('date-selected', {
            date: this.selectedDate,
            slots: this.availableSlots
        });
    }
}"
```

## Configurazione e Feature Flags

### 1. Configurazione Modulo

```php
// Modules/SaluteMo/config/saluteora.php

return [
    'appointments' => [
        'date_picker' => [
            'validation_method' => env('SALUTEORA_DATE_VALIDATION', 'hybrid'),
            'cache_ttl' => env('SALUTEORA_AVAILABILITY_CACHE_TTL', 300), // 5 minuti
            'preload_months' => env('SALUTEORA_PRELOAD_MONTHS', true),
            'max_advance_days' => env('SALUTEORA_MAX_ADVANCE_DAYS', 90),
        ],
        
        'availability' => [
            'check_real_time' => env('SALUTEORA_REALTIME_AVAILABILITY', true),
            'emergency_buffer_minutes' => env('SALUTEORA_EMERGENCY_BUFFER', 30),
            'weekend_appointments' => env('SALUTEORA_WEEKEND_APPOINTMENTS', false),
        ]
    ]
];
```

### 2. Provider di Configurazione

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Providers;

use Modules\Xot\Providers\XotBaseServiceProvider;

class SaluteMoServiceProvider extends XotBaseServiceProvider
{
    protected string $module_name = 'SaluteMo';
    
    public function register(): void
    {
        parent::register();
        
        // Bind del service
        $this->app->singleton(
            \Modules\SaluteMo\Services\AppointmentAvailabilityService::class
        );
    }
}
```

## Testing e Monitoraggio

### 1. Test di Performance

```php
<?php

declare(strict_types=1);

namespace Modules\SaluteMo\Tests\Feature;

use Tests\TestCase;
use Modules\SaluteMo\Filament\Widgets\Patient\FindDoctorAndAppointmentWidget;

class DatePickerPerformanceTest extends TestCase
{
    /** @test */
    public function date_validation_response_time_is_acceptable(): void
    {
        $widget = new FindDoctorAndAppointmentWidget();
        
        $startTime = microtime(true);
        $result = $widget->validateAppointmentDate('2024-06-15');
        $endTime = microtime(true);
        
        $responseTime = ($endTime - $startTime) * 1000; // in ms
        
        $this->assertLessThan(500, $responseTime, 'Validazione deve essere < 500ms');
        $this->assertArrayHasKey('enabled', $result);
    }
    
    /** @test */
    public function month_preload_is_efficient(): void
    {
        $widget = new FindDoctorAndAppointmentWidget();
        
        $startTime = microtime(true);
        $result = $widget->preloadMonthAvailability('2024-06');
        $endTime = microtime(true);
        
        $responseTime = ($endTime - $startTime) * 1000;
        
        $this->assertLessThan(2000, $responseTime, 'Preload mese deve essere < 2s');
        $this->assertIsArray($result);
    }
}
```

### 2. Monitoraggio Prestazioni

```php
// Middleware per monitoraggio chiamate Livewire
class LivewirePerformanceMonitor
{
    public function handle($request, Closure $next)
    {
        if ($request->header('X-Livewire')) {
            $startTime = microtime(true);
            
            $response = $next($request);
            
            $duration = (microtime(true) - $startTime) * 1000;
            
            if ($duration > 1000) { // Log se > 1s
                \Log::warning('Livewire call slow', [
                    'duration' => $duration,
                    'component' => $request->header('X-Livewire-Component'),
                    'method' => $request->input('method'),
                ]);
            }
            
            return $response;
        }
        
        return $next($request);
    }
}
```

## Migrazione Graduale

### Fase 1: Implementazione Parallela
- Mantenere approccio attuale
- Implementare nuovi metodi Livewire
- Testing A/B con feature flag

### Fase 2: Rollout Graduale
- Attivare per 10% utenti
- Monitorare performance e errori
- Raccogliere feedback UX

### Fase 3: Migrazione Completa
- Rollout al 100% se test positivi
- Rimozione codice legacy
- Documentazione aggiornata

## Conclusioni Specifiche SaluteMo

L'implementazione Livewire per il date picker in SaluteMo offre vantaggi significativi:

1. **Disponibilità Real-Time**: Cruciale in ambiente sanitario
2. **Sicurezza**: Prevenzione prenotazioni non autorizzate
3. **Scalabilità**: Gestione efficiente di molti medici/studi
4. **Audit Trail**: Tracciamento completo delle interazioni

La strategia ibrida con cache è particolarmente adatta al contesto sanitario, bilanciando UX e sicurezza.

## Collegamenti e Riferimenti

- [Documentazione generale ottimizzazione](../../../docs/inline-date-picker-optimization.md)
- [Modulo SaluteMo: Widget Documentation](./widgets-documentation.md)
- [Modulo SaluteMo: Services Architecture](./services-architecture.md) 