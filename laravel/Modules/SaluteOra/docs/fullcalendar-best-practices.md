# FullCalendar Best Practices per SaluteOra

## Regole Fondamentali

### 1. Estensione Corretta
- **SEMPRE** estendere `Saade\FilamentFullCalendar\Widgets\FullCalendarWidget`
- **MAI** estendere direttamente classi Filament core
- **NON** utilizzare `XotBaseFullCalendarWidget` (non esiste nel modulo Xot)

```php
// CORRETTO
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class PatientAppointmentWidget extends FullCalendarWidget
{
    // implementazione
}

// SBAGLIATO
use Modules\Xot\Filament\Widgets\XotBaseFullCalendarWidget; // Non esiste!

class PatientAppointmentWidget extends XotBaseFullCalendarWidget
{
    // implementazione
}
```

### 1.1. Widget Multi-Tenancy
- **PatientAppointmentWidget**: Per pazienti - solo propri appuntamenti
- **DoctorAppointmentWidget**: Per dottori - appuntamenti della clinica selezionata
- **AdminAppointmentWidget**: Per admin - tutti gli appuntamenti

### 2. Namespace Corretto
- Utilizzare sempre `Modules\SaluteOra\Filament\Widgets\`
- NON utilizzare `Modules\SaluteOra\App\Filament\Widgets\`

```php
// CORRETTO
namespace Modules\SaluteOra\Filament\Widgets;

// SBAGLIATO
namespace Modules\SaluteOra\App\Filament\Widgets;
```

### 3. Traduzioni
- Utilizzare sempre `__('saluteora::calendar.key')` invece di `->label()`
- NON hardcodare testi in italiano o inglese

```php
// CORRETTO
'buttonText' => [
    'today' => __('saluteora::calendar.today'),
    'month' => __('saluteora::calendar.month'),
],

// SBAGLIATO
'buttonText' => [
    'today' => 'Oggi',
    'month' => 'Mese',
],
```

### 4. Enum per Options
- Convertire array di opzioni in Enum quando possibile
- Utilizzare Enum per stati, tipi, colori

```php
// CORRETTO
use Modules\SaluteOra\Enums\AppointmentStatus;

protected function getStatusColor(AppointmentStatus $status): string
{
    return match ($status) {
        AppointmentStatus::SCHEDULED => '#3b82f6',
        AppointmentStatus::CONFIRMED => '#10b981',
        // ...
    };
}

// SBAGLIATO
protected function getStatusColor(string $status): string
{
    $colors = [
        'scheduled' => '#3b82f6',
        'confirmed' => '#10b981',
    ];
    return $colors[$status] ?? '#6b7280';
}
```

### 5. Metodi con Array Associativi
- `getFormSchema()` deve restituire array associativo con chiavi stringa
- Utilizzare nomi descrittivi per le chiavi

```php
// CORRETTO
public function getFormSchema(): array
{
    return [
        'patient_section' => Forms\Components\Section::make(__('saluteora::appointment.patient_details'))
            ->schema([
                'patient_id' => Forms\Components\Select::make('patient_id'),
                // ...
            ]),
    ];
}
```

## Sicurezza

### 1. Filtro Dati Sensibili
```php
public function fetchEvents(array $fetchInfo): array
{
    // Filtra sempre per utente corrente e permessi
    $query = Appointment::query()
        ->with(['patient:id,full_name', 'dentist:id,full_name']) // Solo campi necessari
        ->where('clinic_id', auth()->user()->clinic_id); // Filtro multi-tenant
    
    // NON esporre dati medici nei tooltip
    return $query->get()->map(function (Appointment $appointment) {
        return EventData::make()
            ->title($appointment->patient->initials) // Solo iniziali, non nome completo
            ->extendedProps([
                'type' => 'appointment', // Tipo generico
                // NON includere note mediche o dati sensibili
            ]);
    })->toArray();
}
```

### 2. Autorizzazioni
```php
protected function canCreate(): bool
{
    return auth()->user()->can('create', Appointment::class);
}

protected function canEdit(Model $record): bool
{
    return auth()->user()->can('update', $record);
}

protected function canDelete(Model $record): bool
{
    return auth()->user()->can('delete', $record);
}
```

### 3. Audit Trail
```php
protected function afterCreate(array $data): void
{
    activity()
        ->performedOn($this->record)
        ->causedBy(auth()->user())
        ->withProperties($data)
        ->log('appointment_created_via_calendar');
}
```

## Performance

### 1. Query Optimization
```php
public function fetchEvents(array $fetchInfo): array
{
    return Appointment::query()
        ->select(['id', 'patient_id', 'dentist_id', 'appointment_date', 'appointment_end_date', 'status'])
        ->with([
            'patient:id,full_name',
            'dentist:id,full_name',
            'clinic:id,name'
        ])
        ->whereBetween('appointment_date', [$fetchInfo['start'], $fetchInfo['end']])
        ->limit(config('saluteora.fullcalendar.event_limit', 100))
        ->get()
        ->map(/* ... */);
}
```

### 2. Caching
```php
public function fetchEvents(array $fetchInfo): array
{
    $cacheKey = sprintf(
        'calendar_events_%s_%s_%s',
        auth()->id(),
        $fetchInfo['start'],
        $fetchInfo['end']
    );
    
    return Cache::store('calendar')
        ->remember($cacheKey, 300, function () use ($fetchInfo) {
            return $this->getEventsFromDatabase($fetchInfo);
        });
}
```

### 3. Lazy Loading
```php
protected static bool $isLazy = true;

protected function getPollingInterval(): ?string
{
    return '30s'; // Aggiorna ogni 30 secondi
}
```

## Accessibilità

### 1. WCAG Compliance
```php
public function eventDidMount(): string
{
    return <<<JS
        function({ event, el }){
            // Aggiunge attributi per screen reader
            el.setAttribute('role', 'button');
            el.setAttribute('aria-label', event.title + ' - ' + event.start.toLocaleString());
            el.setAttribute('tabindex', '0');
            
            // Supporto keyboard navigation
            el.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    el.click();
                }
            });
        }
    JS;
}
```

### 2. Contrasto Colori
```php
private function getStatusColor(AppointmentStatus $status): string
{
    // Colori conformi WCAG AA (contrasto 4.5:1)
    return match ($status) {
        AppointmentStatus::SCHEDULED => '#1d4ed8', // Blu scuro
        AppointmentStatus::CONFIRMED => '#047857', // Verde scuro
        AppointmentStatus::CANCELLED => '#dc2626', // Rosso scuro
        // ...
    };
}
```

## Testing

### 1. Test Widget
```php
<?php

namespace Modules\SaluteOra\Tests\Feature\Widgets;

use Tests\TestCase;
use Modules\SaluteOra\Filament\Widgets\AppointmentCalendarWidget;

class AppointmentCalendarWidgetTest extends TestCase
{
    /** @test */
    public function it_extends_correct_base_class(): void
    {
        $widget = new AppointmentCalendarWidget();
        $this->assertInstanceOf(
            \Saade\FilamentFullCalendar\Widgets\FullCalendarWidget::class,
            $widget
        );
    }
    
    /** @test */
    public function it_filters_events_by_user_permissions(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        
        $widget = new AppointmentCalendarWidget();
        $events = $widget->fetchEvents([
            'start' => now()->format('Y-m-d'),
            'end' => now()->addWeek()->format('Y-m-d'),
        ]);
        
        // Verifica che tutti gli eventi appartengano all'utente corrente
        foreach ($events as $event) {
            $appointment = Appointment::find($event['id']);
            $this->assertTrue($user->can('view', $appointment));
        }
    }
}
```

### 2. Test Permessi
```php
/** @test */
public function it_respects_user_permissions(): void
{
    $user = User::factory()->create();
    $user->givePermissionTo('view_appointments');
    $user->revokePermissionTo('create_appointments');
    
    $this->actingAs($user);
    
    $widget = new AppointmentCalendarWidget();
    
    $this->assertTrue($widget->canView());
    $this->assertFalse($widget->canCreate());
}
```

## Errori Comuni da Evitare

### 1. Estensione Sbagliata
```php
// SBAGLIATO - Non esiste!
use Modules\Xot\Filament\Widgets\XotBaseFullCalendarWidget;

class MyWidget extends XotBaseFullCalendarWidget {} // ERRORE!

// CORRETTO
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class MyWidget extends FullCalendarWidget {}
```

### 2. Namespace Sbagliato
```php
// SBAGLIATO
namespace Modules\SaluteOra\App\Filament\Widgets;

// CORRETTO
namespace Modules\SaluteOra\Filament\Widgets;
```

### 3. Hardcoding Testi
```php
// SBAGLIATO
protected static ?string $heading = 'Calendario Appuntamenti';

// CORRETTO
protected static ?string $heading = null;

public function getHeading(): string
{
    return __('saluteora::calendar.appointments_calendar');
}
```

### 4. Esposizione Dati Sensibili
```php
// SBAGLIATO - Espone dati medici
->extendedProps([
    'medical_notes' => $appointment->medical_notes,
    'diagnosis' => $appointment->diagnosis,
])

// CORRETTO - Solo dati necessari e sicuri
->extendedProps([
    'type' => 'appointment',
    'status' => $appointment->status->value,
])
```

## Integrazione Multi-Modulo

### 1. Eventi da Altri Moduli
```php
// Ascolta eventi da modulo Patient
protected $listeners = [
    'patient-registered' => 'refreshCalendar',
    'appointment-status-changed' => 'updateEvent',
];

public function refreshCalendar(): void
{
    $this->dispatch('refresh-calendar');
}
```

### 2. Notifiche
```php
// Integrazione con modulo Notification
protected function afterCreate(array $data): void
{
    event(new AppointmentCreated($this->record));
}
```

## Documentazione Obbligatoria

### 1. PHPDoc Completo
```php
/**
 * Widget per la gestione del calendario degli appuntamenti odontoiatrici.
 * 
 * Questo widget permette di visualizzare, creare, modificare ed eliminare
 * appuntamenti attraverso un'interfaccia calendario intuitiva.
 * 
 * @package Modules\SaluteOra\Filament\Widgets
 * @author Team SaluteOra
 * @since 1.0.0
 * 
 * @see \Saade\FilamentFullCalendar\Widgets\FullCalendarWidget
 * @see \Modules\SaluteOra\Models\Appointment
 */
class AppointmentCalendarWidget extends FullCalendarWidget
{
    /**
     * Recupera gli eventi per il range di date specificato.
     * 
     * @param array $fetchInfo Array contenente 'start' e 'end' date
     * @return array Array di EventData per FullCalendar
     * 
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function fetchEvents(array $fetchInfo): array
    {
        // implementazione
    }
}
```

## Collegamenti alla Documentazione

- [Documentazione Completa Widget](./fullcalendar-widgets-implementation.md)
- [Configurazione FullCalendar](./fullcalendar-configuration.md)
- [Integrazione Rapida](./fullcalendar_integration.md)
- [Best Practices Filament](../filament/filament-best-practices.md)
- [Gestione Permessi](../gestione_permessi_filament.md)

---

*Seguire sempre queste best practices per garantire coerenza, sicurezza e manutenibilità del codice FullCalendar nel progetto SaluteOra.* 
