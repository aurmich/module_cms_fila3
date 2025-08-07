# FullCalendar Widgets Implementation per SaluteOra

## Panoramica

Questo documento fornisce una guida completa per l'implementazione dei widget FullCalendar nel progetto SaluteOra, utilizzando il plugin Saade FullCalendar per Filament e il sistema di multi-tenancy di Filament. Il calendario è essenziale per la gestione degli appuntamenti medici per donne in gravidanza.

## Architettura Multi-Tenancy

Il sistema utilizza il multi-tenancy di Filament per gestire i dottori che lavorano in più sedi. Ogni sede (clinic) rappresenta un tenant, permettendo ai dottori di vedere solo gli appuntamenti della sede selezionata.

### Tre Widget Specifici per Tipo Utente

1. **PatientAppointmentWidget**: Per i pazienti - visualizza solo i propri appuntamenti
2. **DoctorAppointmentWidget**: Per i dottori - visualizza appuntamenti della sede selezionata (tenant)
3. **AdminAppointmentWidget**: Per gli admin - visualizza tutti gli appuntamenti di tutte le sedi

## Filosofia e Approccio

### Principi Zen del Calendario
- **Semplicità**: Il calendario deve essere intuitivo per utenti non tecnici
- **Chiarezza**: Ogni evento deve essere immediatamente comprensibile
- **Accessibilità**: Supporto completo per screen reader e navigazione da tastiera
- **Responsività**: Funzionamento ottimale su mobile e desktop

### Politica di Implementazione
- **Privacy First**: Tutti i dati sensibili devono essere protetti
- **Inclusività**: Supporto multilingua (IT/EN) come da progetto
- **Trasparenza**: Ogni azione deve essere tracciabile per audit

## Installazione e Setup

### 1. Installazione del Plugin

```bash
composer require saade/filament-fullcalendar:^3.0
```

> **Nota Importante**: I widget FullCalendar estendono direttamente `Saade\FilamentFullCalendar\Widgets\FullCalendarWidget` e non una classe base XotBase, poiché il plugin FullCalendar è specifico del modulo SaluteOra e non è installato nel modulo Xot base.

### 2. Configurazione Multi-Tenancy

Nel `AdminPanelProvider` del modulo SaluteOra con supporto multi-tenancy:

```php
<?php

namespace Modules\SaluteOra\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;
use Modules\SaluteOra\Models\Clinic;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('saluteora')
            ->path('saluteora')
            ->tenant(Clinic::class)
            ->tenantBillingProvider(new \Modules\SaluteOra\Billing\ClinicBillingProvider())
            ->tenantRoutePrefix('/clinic')
            ->plugin(
                FilamentFullCalendarPlugin::make()
                    ->schedulerLicenseKey(config('saluteora.fullcalendar.license_key'))
                    ->selectable(true)
                    ->editable(true)
                    ->timezone(config('app.timezone'))
                    ->locale(app()->getLocale())
                    ->plugins(['dayGrid', 'timeGrid', 'list', 'interaction'])
                    ->config([
                        'firstDay' => 1, // Lunedì come primo giorno
                        'businessHours' => [
                            'daysOfWeek' => [1, 2, 3, 4, 5], // Lun-Ven
                            'startTime' => '08:00',
                            'endTime' => '18:00',
                        ],
                    ])
            );
    }
}
```

## Implementazione Widget Multi-Tenancy

### 1. Widget per Pazienti

```bash
php artisan make:filament-widget PatientAppointmentWidget --module=SaluteOra
```

```php
<?php

namespace Modules\SaluteOra\Filament\Widgets;

use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Enums\AppointmentStatus;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Saade\FilamentFullCalendar\Data\EventData;
use Filament\Facades\Filament;

class PatientAppointmentWidget extends FullCalendarWidget
{
    protected static ?string $heading = null;
    protected static ?int $sort = 1;
    protected static ?string $maxWidth = 'full';
    
    public static function getHeading(): string
    {
        return __('saluteora::calendar.my_appointments');
    }
    
    public function fetchEvents(array $fetchInfo): array
    {
        $patient = Filament::auth()->user()->patient;
        
        if (!$patient) {
            return [];
        }

        return Appointment::query()
            ->with(['doctor', 'clinic'])
            ->where('patient_id', $patient->id)
            ->where('appointment_date', '>=', $fetchInfo['start'])
            ->where('appointment_date', '<=', $fetchInfo['end'])
            ->get()
            ->map(function (Appointment $appointment) {
                return EventData::make()
                    ->id($appointment->id)
                    ->title($this->getPatientEventTitle($appointment))
                    ->start($appointment->appointment_date)
                    ->end($appointment->appointment_end_date)
                    ->backgroundColor($this->getStatusColor($appointment->status))
                    ->borderColor($this->getStatusColor($appointment->status))
                    ->textColor('#ffffff')
                    ->url(route('filament.saluteora.resources.appointments.view', $appointment))
                    ->extendedProps([
                        'clinic' => $appointment->clinic->name,
                        'doctor' => $appointment->doctor->full_name,
                        'status' => $appointment->status->getLabel(),
                        'notes' => $appointment->notes,
                    ]);
            })
            ->toArray();
    }

    private function getPatientEventTitle(Appointment $appointment): string
    {
        return sprintf(
            '%s - Dr. %s',
            $appointment->clinic->name,
            $appointment->doctor->full_name
        );
    }

    public function config(): array
    {
        return [
            'firstDay' => 1,
            'headerToolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'dayGridMonth,listWeek',
            ],
            'initialView' => 'dayGridMonth',
            'height' => 500,
            'editable' => false,
            'selectable' => false,
            'eventClick' => 'function(info) { window.open(info.event.url, "_self"); }',
        ];
    }

    private function getStatusColor(AppointmentStatus $status): string
    {
        return match ($status) {
            AppointmentStatus::SCHEDULED => '#3b82f6', // Blue
            AppointmentStatus::CONFIRMED => '#10b981', // Green
            AppointmentStatus::IN_PROGRESS => '#f59e0b', // Amber
            AppointmentStatus::COMPLETED => '#059669', // Emerald
            AppointmentStatus::CANCELLED => '#ef4444', // Red
            AppointmentStatus::NO_SHOW => '#6b7280', // Gray
            default => '#6b7280',
        };
    }
}
```

### 2. Widget per Dottori (Multi-Tenant)

```bash
php artisan make:filament-widget DoctorAppointmentWidget --module=SaluteOra
```

```php
<?php

namespace Modules\SaluteOra\Filament\Widgets;

use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Enums\AppointmentStatus;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Saade\FilamentFullCalendar\Data\EventData;
use Filament\Facades\Filament;
use Filament\Forms;
use Illuminate\Database\Eloquent\Model;

class DoctorAppointmentWidget extends FullCalendarWidget
{
    public Model|string|null $model = Appointment::class;
    
    protected static ?string $heading = null;
    protected static ?int $sort = 1;
    protected static ?string $maxWidth = 'full';
    
    public static function getHeading(): string
    {
        return __('saluteora::calendar.clinic_appointments');
    }
    
    public function fetchEvents(array $fetchInfo): array
    {
        $tenant = Filament::getTenant();
        $doctor = Filament::auth()->user()->doctor;
        
        if (!$tenant || !$doctor) {
            return [];
        }

        return Appointment::query()
            ->with(['patient', 'doctor'])
            ->where('clinic_id', $tenant->id)
            ->where('doctor_id', $doctor->id)
            ->where('appointment_date', '>=', $fetchInfo['start'])
            ->where('appointment_date', '<=', $fetchInfo['end'])
            ->get()
            ->map(function (Appointment $appointment) {
                return EventData::make()
                    ->id($appointment->id)
                    ->title($this->getDoctorEventTitle($appointment))
                    ->start($appointment->appointment_date)
                    ->end($appointment->appointment_end_date)
                    ->backgroundColor($this->getStatusColor($appointment->status))
                    ->borderColor($this->getStatusColor($appointment->status))
                    ->textColor('#ffffff')
                    ->extendedProps([
                        'patient_id' => $appointment->patient_id,
                        'patient_name' => $appointment->patient->full_name,
                        'status' => $appointment->status->value,
                        'notes' => $appointment->notes,
                    ]);
            })
            ->toArray();
    }

    private function getDoctorEventTitle(Appointment $appointment): string
    {
        return sprintf(
            '%s - %s',
            $appointment->patient->full_name,
            $appointment->status->getLabel()
        );
    }

    public function getFormSchema(): array
    {
        return [
            Forms\Components\Section::make(__('saluteora::appointment.details'))
                ->schema([
                    Forms\Components\Select::make('patient_id')
                        ->relationship('patient', 'full_name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    
                    Forms\Components\DateTimePicker::make('appointment_date')
                        ->required()
                        ->seconds(false)
                        ->minuteStep(15),
                    
                    Forms\Components\DateTimePicker::make('appointment_end_date')
                        ->required()
                        ->seconds(false)
                        ->minuteStep(15)
                        ->after('appointment_date'),
                    
                    Forms\Components\Select::make('status')
                        ->enum(AppointmentStatus::class)
                        ->options(AppointmentStatus::class)
                        ->default(AppointmentStatus::SCHEDULED)
                        ->required(),
                    
                    Forms\Components\Textarea::make('notes')
                        ->rows(3)
                        ->maxLength(500),
                ]),
        ];
    }

    protected function headerActions(): array
    {
        return [
            \Saade\FilamentFullCalendar\Actions\CreateAction::make()
                ->mountUsing(function (Forms\Form $form, array $arguments) {
                    $tenant = Filament::getTenant();
                    $doctor = Filament::auth()->user()->doctor;
                    
                    $form->fill([
                        'appointment_date' => $arguments['start'] ?? null,
                        'appointment_end_date' => $arguments['end'] ?? null,
                        'clinic_id' => $tenant?->id,
                        'doctor_id' => $doctor?->id,
                    ]);
                })
                ->mutateFormDataUsing(function (array $data): array {
                    $tenant = Filament::getTenant();
                    $doctor = Filament::auth()->user()->doctor;
                    
                    // Assicura che clinic_id e doctor_id siano impostati
                    $data['clinic_id'] = $tenant?->id;
                    $data['doctor_id'] = $doctor?->id;
                    
                    // Calcola automaticamente la durata se non specificata
                    if (!isset($data['appointment_end_date']) && isset($data['appointment_date'])) {
                        $data['appointment_end_date'] = \Carbon\Carbon::parse($data['appointment_date'])
                            ->addMinutes(30); // Durata standard 30 minuti
                    }
                    
                    return $data;
                }),
        ];
    }

    public function config(): array
    {
        return [
            'firstDay' => 1,
            'headerToolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'dayGridMonth,timeGridWeek,timeGridDay',
            ],
            'initialView' => 'timeGridWeek',
            'height' => 'auto',
            'aspectRatio' => 1.8,
            'businessHours' => [
                'daysOfWeek' => [1, 2, 3, 4, 5],
                'startTime' => '08:00',
                'endTime' => '18:00',
            ],
            'slotMinTime' => '07:00',
            'slotMaxTime' => '20:00',
            'slotDuration' => '00:15:00',
            'snapDuration' => '00:15:00',
            'allDaySlot' => false,
            'nowIndicator' => true,
            'selectable' => true,
            'selectMirror' => true,
            'editable' => true,
            'eventResizableFromStart' => true,
            'eventDurationEditable' => true,
            'eventStartEditable' => true,
        ];
    }

    private function getStatusColor(AppointmentStatus $status): string
    {
        return match ($status) {
            AppointmentStatus::SCHEDULED => '#3b82f6', // Blue
            AppointmentStatus::CONFIRMED => '#10b981', // Green
            AppointmentStatus::IN_PROGRESS => '#f59e0b', // Amber
            AppointmentStatus::COMPLETED => '#059669', // Emerald
            AppointmentStatus::CANCELLED => '#ef4444', // Red
            AppointmentStatus::NO_SHOW => '#6b7280', // Gray
            default => '#6b7280',
        };
    }
}
```

### 3. Widget per Admin (Visualizza Tutto)

```bash
php artisan make:filament-widget AdminAppointmentWidget --module=SaluteOra
```

```php
<?php

namespace Modules\SaluteOra\Filament\Widgets;

use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Enums\AppointmentStatus;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Saade\FilamentFullCalendar\Data\EventData;
use Filament\Forms;
use Illuminate\Database\Eloquent\Model;

class AdminAppointmentWidget extends FullCalendarWidget
{
    public Model|string|null $model = Appointment::class;
    
    protected static ?string $heading = null;
    protected static ?int $sort = 1;
    protected static ?string $maxWidth = 'full';
    
    public static function getHeading(): string
    {
        return __('saluteora::calendar.all_appointments');
    }
    
    public function fetchEvents(array $fetchInfo): array
    {
        return Appointment::query()
            ->with(['patient', 'doctor', 'clinic'])
            ->where('appointment_date', '>=', $fetchInfo['start'])
            ->where('appointment_date', '<=', $fetchInfo['end'])
            ->get()
            ->map(function (Appointment $appointment) {
                return EventData::make()
                    ->id($appointment->id)
                    ->title($this->getAdminEventTitle($appointment))
                    ->start($appointment->appointment_date)
                    ->end($appointment->appointment_end_date)
                    ->backgroundColor($this->getStatusColor($appointment->status))
                    ->borderColor($this->getStatusColor($appointment->status))
                    ->textColor('#ffffff')
                    ->extendedProps([
                        'patient_id' => $appointment->patient_id,
                        'patient_name' => $appointment->patient->full_name,
                        'doctor_id' => $appointment->doctor_id,
                        'doctor_name' => $appointment->doctor->full_name,
                        'clinic_id' => $appointment->clinic_id,
                        'clinic_name' => $appointment->clinic->name,
                        'status' => $appointment->status->value,
                        'notes' => $appointment->notes,
                    ]);
            })
            ->toArray();
    }

    private function getAdminEventTitle(Appointment $appointment): string
    {
        return sprintf(
            '%s - Dr. %s (%s)',
            $appointment->patient->full_name,
            $appointment->doctor->full_name,
            $appointment->clinic->name
        );
    }

    public function getFormSchema(): array
    {
        return [
            Forms\Components\Section::make(__('saluteora::appointment.details'))
                ->schema([
                    Forms\Components\Select::make('patient_id')
                        ->relationship('patient', 'full_name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    
                    Forms\Components\Select::make('doctor_id')
                        ->relationship('doctor', 'full_name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    
                    Forms\Components\Select::make('clinic_id')
                        ->relationship('clinic', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    
                    Forms\Components\DateTimePicker::make('appointment_date')
                        ->required()
                        ->seconds(false)
                        ->minuteStep(15),
                    
                    Forms\Components\DateTimePicker::make('appointment_end_date')
                        ->required()
                        ->seconds(false)
                        ->minuteStep(15)
                        ->after('appointment_date'),
                    
                    Forms\Components\Select::make('status')
                        ->enum(AppointmentStatus::class)
                        ->options(AppointmentStatus::class)
                        ->default(AppointmentStatus::SCHEDULED)
                        ->required(),
                    
                    Forms\Components\Textarea::make('notes')
                        ->rows(3)
                        ->maxLength(500),
                ]),
        ];
    }

    protected function headerActions(): array
    {
        return [
            \Saade\FilamentFullCalendar\Actions\CreateAction::make()
                ->mountUsing(function (Forms\Form $form, array $arguments) {
                    $form->fill([
                        'appointment_date' => $arguments['start'] ?? null,
                        'appointment_end_date' => $arguments['end'] ?? null,
                    ]);
                })
                ->mutateFormDataUsing(function (array $data): array {
                    // Calcola automaticamente la durata se non specificata
                    if (!isset($data['appointment_end_date']) && isset($data['appointment_date'])) {
                        $data['appointment_end_date'] = \Carbon\Carbon::parse($data['appointment_date'])
                            ->addMinutes(30); // Durata standard 30 minuti
                    }
                    
                    return $data;
                }),
        ];
    }

    protected function modalActions(): array
    {
        return [
            \Saade\FilamentFullCalendar\Actions\EditAction::make()
                ->mountUsing(function (Appointment $record, Forms\Form $form, array $arguments) {
                    $form->fill([
                        'patient_id' => $record->patient_id,
                        'doctor_id' => $record->doctor_id,
                        'clinic_id' => $record->clinic_id,
                        'appointment_date' => $arguments['event']['start'] ?? $record->appointment_date,
                        'appointment_end_date' => $arguments['event']['end'] ?? $record->appointment_end_date,
                        'status' => $record->status,
                        'notes' => $record->notes,
                    ]);
                }),
            
            \Saade\FilamentFullCalendar\Actions\DeleteAction::make(),
        ];
    }

    protected function viewAction(): \Filament\Actions\Action
    {
        return \Saade\FilamentFullCalendar\Actions\ViewAction::make();
    }

    public function config(): array
    {
        return [
            'firstDay' => 1,
            'headerToolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'dayGridMonth,timeGridWeek,timeGridDay,listWeek',
            ],
            'height' => 'auto',
            'aspectRatio' => 1.8,
            'businessHours' => [
                'daysOfWeek' => [1, 2, 3, 4, 5],
                'startTime' => '08:00',
                'endTime' => '18:00',
            ],
            'slotMinTime' => '07:00',
            'slotMaxTime' => '20:00',
            'slotDuration' => '00:15:00',
            'snapDuration' => '00:15:00',
            'allDaySlot' => false,
            'nowIndicator' => true,
            'selectable' => true,
            'selectMirror' => true,
            'editable' => true,
            'eventResizableFromStart' => true,
            'eventDurationEditable' => true,
            'eventStartEditable' => true,
        ];
    }

    private function getEventTitle(Appointment $appointment): string
    {
        return sprintf(
            '%s - %s',
            $appointment->patient->full_name ?? __('saluteora::appointment.unknown_patient'),
            $appointment->dentist->full_name ?? __('saluteora::appointment.unknown_dentist')
        );
    }

    private function getStatusColor(AppointmentStatus $status): string
    {
        return match ($status) {
            AppointmentStatus::SCHEDULED => '#3b82f6', // Blue
            AppointmentStatus::CONFIRMED => '#10b981', // Green
            AppointmentStatus::IN_PROGRESS => '#f59e0b', // Amber
            AppointmentStatus::COMPLETED => '#059669', // Emerald
            AppointmentStatus::CANCELLED => '#ef4444', // Red
            AppointmentStatus::NO_SHOW => '#6b7280', // Gray
            default => '#6b7280',
        };
    }

    public function eventDidMount(): string
    {
        return <<<JS
            function({ event, timeText, isStart, isEnd, isMirror, isPast, isFuture, isToday, el, view }){
                // Tooltip con informazioni aggiuntive
                el.setAttribute("x-tooltip", "tooltip");
                el.setAttribute("x-data", "{ 
                    tooltip: event.title + '\\n' + 
                             'Status: ' + event.extendedProps.status + '\\n' +
                             'Note: ' + (event.extendedProps.notes || 'Nessuna nota')
                }");
                
                // Aggiunge icone per diversi stati
                if (event.extendedProps.status === 'completed') {
                    el.style.textDecoration = 'line-through';
                }
                
                // Evidenzia appuntamenti urgenti
                if (event.extendedProps.urgent) {
                    el.style.border = '2px solid #ef4444';
                    el.style.animation = 'pulse 2s infinite';
                }
            }
        JS;
    }
}
```

## Configurazione Multi-Tenancy per Modelli

### Modello Clinic (Tenant)

```php
<?php

namespace Modules\SaluteOra\Models;

use Filament\Models\Contracts\FilamentTenant;
use Filament\Models\Contracts\HasCurrentTenantLabel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class Clinic extends Model implements FilamentTenant, HasCurrentTenantLabel
{
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function doctors(): BelongsToMany
    {
        return $this->belongsToMany(Doctor::class, 'clinic_doctor')
            ->withPivot(['is_active', 'role'])
            ->withTimestamps();
    }

    public function getTenantName(): string
    {
        return $this->name;
    }

    public function getCurrentTenantLabel(): string
    {
        return $this->name;
    }

    public function canAccessTenant(Model $user): bool
    {
        return $this->doctors()->where('user_id', $user->id)->exists() ||
               $user->hasRole('admin');
    }
}
```

### Modello Doctor con Multi-Tenancy

```php
<?php

namespace Modules\SaluteOra\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Doctor extends Model
{
    protected $fillable = [
        'user_id',
        'license_number',
        'specialization',
        'phone',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function clinics(): BelongsToMany
    {
        return $this->belongsToMany(Clinic::class, 'clinic_doctor')
            ->withPivot(['is_active', 'role'])
            ->withTimestamps();
    }

    public function getFullNameAttribute(): string
    {
        return $this->user->name ?? 'N/A';
    }

    public function canAccessClinic(Clinic $clinic): bool
    {
        return $this->clinics()->where('clinic_id', $clinic->id)->exists();
    }
}
```

## Widget per Dashboard Paziente

### Widget Calendario Paziente

```php
<?php

namespace Modules\SaluteOra\Filament\Widgets;

use Modules\SaluteOra\Models\Appointment;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Saade\FilamentFullCalendar\Data\EventData;
use Filament\Facades\Filament;

class PatientAppointmentWidget extends FullCalendarWidget
{
    protected static ?string $heading = 'I Miei Appuntamenti';
    protected static ?int $sort = 1;
    protected static bool $isLazy = false;

    public function fetchEvents(array $fetchInfo): array
    {
        $patient = Filament::auth()->user()->patient;
        
        if (!$patient) {
            return [];
        }

        return Appointment::query()
            ->where('patient_id', $patient->id)
            ->where('appointment_date', '>=', $fetchInfo['start'])
            ->where('appointment_date', '<=', $fetchInfo['end'])
            ->with(['dentist', 'clinic'])
            ->get()
            ->map(function (Appointment $appointment) {
                return EventData::make()
                    ->id($appointment->id)
                    ->title($this->getPatientEventTitle($appointment))
                    ->start($appointment->appointment_date)
                    ->end($appointment->appointment_end_date)
                    ->backgroundColor($this->getStatusColor($appointment->status))
                    ->url(route('filament.saluteora.resources.appointments.view', $appointment))
                    ->extendedProps([
                        'clinic' => $appointment->clinic->name,
                        'dentist' => $appointment->dentist->full_name,
                        'status' => $appointment->status->getLabel(),
                    ]);
            })
            ->toArray();
    }

    private function getPatientEventTitle(Appointment $appointment): string
    {
        return sprintf(
            '%s - Dr. %s',
            $appointment->clinic->name,
            $appointment->dentist->full_name
        );
    }

    public function config(): array
    {
        return [
            'firstDay' => 1,
            'headerToolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'dayGridMonth,listWeek',
            ],
            'initialView' => 'dayGridMonth',
            'height' => 500,
            'editable' => false,
            'selectable' => false,
            'eventClick' => 'function(info) { window.open(info.event.url, "_self"); }',
        ];
    }

    public function eventDidMount(): string
    {
        return <<<JS
            function({ event, el }){
                el.setAttribute("x-tooltip", "tooltip");
                el.setAttribute("x-data", "{ 
                    tooltip: event.title + '\\n' + 
                             'Clinica: ' + event.extendedProps.clinic + '\\n' +
                             'Dentista: ' + event.extendedProps.dentist + '\\n' +
                             'Stato: ' + event.extendedProps.status
                }");
            }
        JS;
    }
}
```

## Configurazioni Avanzate

### 1. Configurazione Multi-Tenant

```php
// Nel config/saluteora.php
return [
    'fullcalendar' => [
        'license_key' => env('FULLCALENDAR_LICENSE_KEY'),
        'default_view' => 'timeGridWeek',
        'business_hours' => [
            'start' => '08:00',
            'end' => '18:00',
            'days' => [1, 2, 3, 4, 5], // Lun-Ven
        ],
        'slot_duration' => '00:15:00',
        'snap_duration' => '00:15:00',
    ],
];
```

### 2. Personalizzazione CSS

```css
/* resources/css/fullcalendar-saluteora.css */
.fc-saluteora-theme {
    --fc-border-color: #e5e7eb;
    --fc-button-bg-color: #3b82f6;
    --fc-button-border-color: #3b82f6;
    --fc-button-hover-bg-color: #2563eb;
    --fc-button-active-bg-color: #1d4ed8;
}

.fc-event-saluteora-scheduled {
    background-color: #3b82f6 !important;
    border-color: #2563eb !important;
}

.fc-event-saluteora-confirmed {
    background-color: #10b981 !important;
    border-color: #059669 !important;
}

.fc-event-saluteora-cancelled {
    background-color: #ef4444 !important;
    border-color: #dc2626 !important;
    text-decoration: line-through;
}

.fc-event-saluteora-urgent {
    animation: pulse 2s infinite;
    border: 2px solid #ef4444 !important;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}
```

### 3. Traduzione Completa

```php
// lang/it/fullcalendar.php
return [
    'month' => 'Mese',
    'week' => 'Settimana',
    'day' => 'Giorno',
    'list' => 'Lista',
    'today' => 'Oggi',
    'prev' => 'Precedente',
    'next' => 'Successivo',
    'more' => 'altri',
    'no_events' => 'Nessun appuntamento da visualizzare',
    'all_day' => 'Tutto il giorno',
    'time' => 'Ora',
    'event' => 'Evento',
    'delete_event' => 'Elimina appuntamento',
    'edit_event' => 'Modifica appuntamento',
    'create_event' => 'Crea appuntamento',
];
```

## Architettura Widget

### Classe Base Personalizzata (Opzionale)

Se in futuro si dovessero creare molti widget FullCalendar con funzionalità comuni, si potrebbe considerare la creazione di una classe base nel modulo SaluteOra:

```php
<?php

namespace Modules\SaluteOra\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

abstract class SaluteOraBaseFullCalendarWidget extends FullCalendarWidget
{
    // Funzionalità comuni per tutti i widget calendario di SaluteOra
    
    protected function getDefaultConfig(): array
    {
        return [
            'locale' => 'it',
            'timezone' => 'Europe/Rome',
            'firstDay' => 1,
            'businessHours' => config('saluteora.fullcalendar.business_hours'),
            // ... altre configurazioni comuni
        ];
    }
    
    protected function getStatusColor(AppointmentStatus $status): string
    {
        return config('saluteora.fullcalendar.colors')[$status->value] ?? '#6b7280';
    }
}
```

Tuttavia, per ora utilizziamo direttamente la classe Saade per semplicità e per evitare over-engineering.

## Best Practices per SaluteOra

### 1. Sicurezza e Privacy
- **Filtro dati sensibili**: Non esporre mai dati medici nei tooltip
- **Autorizzazioni**: Verificare sempre i permessi prima di mostrare eventi
- **Audit trail**: Loggare tutte le modifiche agli appuntamenti

### 2. Performance
- **Lazy loading**: Caricare solo gli eventi necessari
- **Caching**: Utilizzare cache per disponibilità ricorrenti
- **Paginazione**: Limitare il range di date per query pesanti

### 3. Accessibilità
- **Keyboard navigation**: Supporto completo per navigazione da tastiera
- **Screen readers**: Descrizioni appropriate per tutti gli elementi
- **Contrasto**: Colori conformi alle linee guida WCAG

### 4. Mobile First
- **Touch gestures**: Supporto per swipe e pinch
- **Responsive breakpoints**: Layout ottimizzato per tutti i dispositivi
- **Performance mobile**: Ridurre al minimo le animazioni su mobile

## Integrazione con Altri Moduli

### 1. Modulo Patient
```php
// Sincronizzazione automatica con registrazione paziente
class PatientRegisteredListener
{
    public function handle(PatientRegistered $event): void
    {
        // Crea slot di disponibilità per primo appuntamento
        $this->createInitialAvailabilitySlots($event->patient);
    }
}
```

### 2. Modulo Notification
```php
// Notifiche automatiche per appuntamenti
class AppointmentReminderJob implements ShouldQueue
{
    public function handle(): void
    {
        $upcomingAppointments = Appointment::query()
            ->where('appointment_date', '>', now())
            ->where('appointment_date', '<=', now()->addDay())
            ->where('status', AppointmentStatus::CONFIRMED)
            ->get();

        foreach ($upcomingAppointments as $appointment) {
            $this->sendReminder($appointment);
        }
    }
}
```

## Testing

### 1. Test Widget
```php
<?php

namespace Modules\SaluteOra\Tests\Feature\Widgets;

use Tests\TestCase;
use Modules\SaluteOra\Filament\Widgets\AppointmentCalendarWidget;
use Modules\SaluteOra\Models\Appointment;

class AppointmentCalendarWidgetTest extends TestCase
{
    /** @test */
    public function it_can_fetch_appointments_for_date_range(): void
    {
        $appointment = Appointment::factory()->create([
            'appointment_date' => now()->addDays(1),
        ]);

        $widget = new AppointmentCalendarWidget();
        $events = $widget->fetchEvents([
            'start' => now()->format('Y-m-d'),
            'end' => now()->addWeek()->format('Y-m-d'),
        ]);

        $this->assertCount(1, $events);
        $this->assertEquals($appointment->id, $events[0]['id']);
    }
}
```

## Troubleshooting

### Problemi Comuni

1. **Eventi non visualizzati**
   - Verificare timezone configuration
   - Controllare filtri di date nel fetchEvents
   - Verificare permessi utente

2. **Performance lente**
   - Implementare eager loading per relazioni
   - Aggiungere indici database appropriati
   - Utilizzare cache per query ricorrenti

3. **Problemi di localizzazione**
   - Verificare configurazione locale nel plugin
   - Controllare file di traduzione
   - Testare con diversi browser/locale

## Permessi e Policy

### Policy per Widget

Creare policy per controllare l'accesso ai widget:

```php
<?php

namespace Modules\SaluteOra\Policies;

use Modules\SaluteOra\Models\Appointment;
use Modules\User\Models\User;
use Filament\Facades\Filament;

class AppointmentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'doctor', 'patient']);
    }

    public function view(User $user, Appointment $appointment): bool
    {
        // Admin può vedere tutto
        if ($user->hasRole('admin')) {
            return true;
        }

        // Paziente può vedere solo i propri appuntamenti
        if ($user->hasRole('patient')) {
            return $appointment->patient_id === $user->patient?->id;
        }

        // Dottore può vedere appuntamenti della clinica corrente
        if ($user->hasRole('doctor')) {
            $tenant = Filament::getTenant();
            return $appointment->clinic_id === $tenant?->id && 
                   $appointment->doctor_id === $user->doctor?->id;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'doctor']);
    }

    public function update(User $user, Appointment $appointment): bool
    {
        // Admin può modificare tutto
        if ($user->hasRole('admin')) {
            return true;
        }

        // Dottore può modificare solo i propri appuntamenti nella clinica corrente
        if ($user->hasRole('doctor')) {
            $tenant = Filament::getTenant();
            return $appointment->clinic_id === $tenant?->id && 
                   $appointment->doctor_id === $user->doctor?->id;
        }

        return false;
    }

    public function delete(User $user, Appointment $appointment): bool
    {
        return $this->update($user, $appointment);
    }
}
```

### Middleware per Tenancy

```php
<?php

namespace Modules\SaluteOra\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;

class EnsureClinicAccess
{
    public function handle(Request $request, Closure $next)
    {
        $user = Filament::auth()->user();
        $tenant = Filament::getTenant();

        if (!$user || !$tenant) {
            abort(403, 'Accesso negato');
        }

        // Admin ha accesso a tutto
        if ($user->hasRole('admin')) {
            return $next($request);
        }

        // Verifica accesso dottore alla clinica
        if ($user->hasRole('doctor')) {
            $doctor = $user->doctor;
            if (!$doctor || !$doctor->canAccessClinic($tenant)) {
                abort(403, 'Non autorizzato ad accedere a questa clinica');
            }
        }

        return $next($request);
    }
}
```

### Registrazione Policy

Nel `AuthServiceProvider`:

```php
<?php

namespace Modules\SaluteOra\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Policies\AppointmentPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Appointment::class => AppointmentPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
```

### Controllo Permessi nei Widget

Aggiungere controlli di autorizzazione nei widget:

```php
// Nel DoctorAppointmentWidget
public function fetchEvents(array $fetchInfo): array
{
    $tenant = Filament::getTenant();
    $doctor = Filament::auth()->user()->doctor;
    
    // Verifica autorizzazioni
    if (!$tenant || !$doctor || !$doctor->canAccessClinic($tenant)) {
        return [];
    }
    
    // ... resto del codice
}

// Nel PatientAppointmentWidget  
public function fetchEvents(array $fetchInfo): array
{
    $patient = Filament::auth()->user()->patient;
    
    // Verifica che l'utente sia un paziente
    if (!$patient) {
        return [];
    }
    
    // ... resto del codice
}
```

## Roadmap Future

### Funzionalità Pianificate
- [ ] Integrazione con sistemi di pagamento
- [ ] Notifiche push per mobile app
- [ ] Sincronizzazione con calendari esterni (Google, Outlook)
- [ ] AI per ottimizzazione automatica degli slot
- [ ] Reportistica avanzata con grafici

### Miglioramenti Tecnici
- [ ] Migrazione a FullCalendar v6
- [ ] Implementazione PWA per offline support
- [ ] Microservizi per scalabilità
- [ ] GraphQL API per performance

## Collegamenti alla Documentazione

- [Documentazione Filament](../filament/filament-best-practices.md)
- [Gestione Permessi](../gestione_permessi_filament.md)
- [Traduzioni](../translations.md)
- [API Security](../api_security.md)
- [Performance Optimization](../performance_optimization.md)

---

*Documentazione aggiornata il: {{ date('Y-m-d H:i:s') }}*
*Versione: 1.0.0*
*Autore: Team SaluteOra* 
