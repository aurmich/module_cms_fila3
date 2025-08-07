# Widget FullCalendar con Parental e Tenancy per SaluteOra

## Panoramica

Questo documento descrive l'implementazione di widget FullCalendar per un'applicazione sanitaria che utilizza:
- **Parental** per Single Table Inheritance (STI) dei tipi di utente
- **Tenancy di Filament** per gestione multi-studio
- **Saade FullCalendar** per i widget calendario

## Architettura del Sistema

### Struttura Utenti con Parental

Il sistema utilizza Single Table Inheritance (STI) con Parental per gestire i tipi di utente:

```php
// User.php (classe base)
class User extends BaseUser
{
    protected $childTypes = [
        'patient' => Patient::class,
        'doctor' => Doctor::class,
        'admin' => Admin::class,
    ];
    
    protected function casts(): array
    {
        return [
            'type' => UserType::class,
            // altri cast...
        ];
    }
}

// Patient.php
class Patient extends User
{
    use HasParent;
    // logica specifica per pazienti
}

// Doctor.php  
class Doctor extends User
{
    use HasParent;
    use BelongsToTenant; // per multi-tenancy
    // logica specifica per dottori
}

// Admin.php
class Admin extends User
{
    use HasParent;
    // logica specifica per admin
}
```

### Enum UserType

```php
enum UserType: string implements HasLabel
{
    case ADMIN = 'admin';
    case DOCTOR = 'doctor';
    case PATIENT = 'patient';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::ADMIN => 'Amministratore',
            self::DOCTOR => 'Medico',
            self::PATIENT => 'Paziente',
        };
    }
}
```

## Modelli Necessari

### Studio (Tenant Model)

```php
<?php

namespace Modules\SaluteOra\Models;

use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Studio extends Model implements HasName
{
    protected $fillable = [
        'name',
        'address',
        'city',
        'phone',
        'email',
        'registration_number',
        'active',
    ];

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
        ];
    }

    public function getFilamentName(): string
    {
        return $this->name;
    }

    public function doctors(): HasMany
    {
        return $this->hasMany(Doctor::class, 'tenant_id');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class, 'studio_id');
    }
}
```

### Appointment (Modello Aggiornato)

```php
<?php

namespace Modules\SaluteOra\Models;

use Modules\SaluteOra\Enums\AppointmentStatus;
use Modules\SaluteOra\Enums\AppointmentType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id', 
        'studio_id',
        'title',
        'start_time',
        'end_time',
        'type',
        'status',
        'notes',
        'emergency',
    ];

    protected function casts(): array
    {
        return [
            'start_time' => 'datetime',
            'end_time' => 'datetime',
            'type' => AppointmentType::class,
            'status' => AppointmentStatus::class,
            'emergency' => 'boolean',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function studio(): BelongsTo
    {
        return $this->belongsTo(Studio::class);
    }
}
```

### Enum per Appuntamenti

```php
// AppointmentType.php
// Path corretto: Modules/SaluteOra/app/Enums/AppointmentType.php
use Modules\SaluteOra\App\Enums\AppointmentType;

enum AppointmentType: string implements HasLabel
{
    case CONSULTATION = 'consultation';
    case CLEANING = 'cleaning';
    case TREATMENT = 'treatment';
    case EMERGENCY = 'emergency';
    case FOLLOWUP = 'followup';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::CONSULTATION => 'Visita',
            self::CLEANING => 'Pulizia',
            self::TREATMENT => 'Trattamento',
            self::EMERGENCY => 'Emergenza',
            self::FOLLOWUP => 'Controllo',
        };
    }
}

// AppointmentStatus.php
enum AppointmentStatus: string implements HasLabel
{
    case SCHEDULED = 'scheduled';
    case CONFIRMED = 'confirmed';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case NO_SHOW = 'no_show';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::SCHEDULED => 'Programmato',
            self::CONFIRMED => 'Confermato',
            self::COMPLETED => 'Completato',
            self::CANCELLED => 'Annullato',
            self::NO_SHOW => 'Assente',
        };
    }
}
```

> **Nota di prevenzione:**
> L'enum AppointmentType deve essere sempre posizionato in `Modules/SaluteOra/app/Enums/AppointmentType.php` e importato con il namespace corretto. Aggiornare sempre la documentazione e i file .mdc windsurf/cursor in caso di modifica del path.

## Widget FullCalendar

### 1. PatientCalendarWidget

Widget per pazienti che mostra solo i propri appuntamenti:

```php
<?php

namespace Modules\SaluteOra\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Enums\AppointmentStatus;
use Modules\SaluteOra\Enums\AppointmentType;
use Modules\SaluteOra\Enums\UserType;
use Saade\FilamentFullCalendar\Data\EventData;
use Filament\Forms;
use Illuminate\Database\Eloquent\Model;

class PatientCalendarWidget extends FullCalendarWidget
{
    public Model | string | null $model = Appointment::class;

    public static function canView(): bool
    {
        return auth()->user()?->type === UserType::PATIENT;
    }

    public function config(): array
    {
        return [
            'locale' => 'it',
            'timezone' => 'Europe/Rome',
            'headerToolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'timeGridWeek,timeGridDay'
            ],
            'initialView' => 'timeGridWeek',
            'businessHours' => [
                'daysOfWeek' => [1, 2, 3, 4, 5, 6], // Lun-Sab
                'startTime' => '08:00',
                'endTime' => '19:00',
            ],
            'slotMinTime' => '07:00',
            'slotMaxTime' => '20:00',
            'height' => 'auto',
            'eventDisplay' => 'block',
            'displayEventTime' => true,
            'eventTimeFormat' => [
                'hour' => '2-digit',
                'minute' => '2-digit',
                'hour12' => false
            ],
            'editable' => false, // Pazienti non possono modificare
            'selectable' => false,
        ];
    }

    public function fetchEvents(array $fetchInfo): array
    {
        $user = auth()->user();
        
        return Appointment::query()
            ->where('patient_id', $user->id)
            ->whereBetween('start_time', [$fetchInfo['start'], $fetchInfo['end']])
            ->with(['doctor', 'studio'])
            ->get()
            ->map(function (Appointment $appointment) {
                return EventData::make()
                    ->id($appointment->id)
                    ->title($this->getPatientEventTitle($appointment))
                    ->start($appointment->start_time)
                    ->end($appointment->end_time)
                    ->backgroundColor($this->getEventColor($appointment))
                    ->borderColor($this->getEventColor($appointment))
                    ->textColor('#ffffff')
                    ->extendedProps([
                        'type' => $appointment->type->value,
                        'status' => $appointment->status->value,
                        'doctor' => $appointment->doctor->name,
                        'studio' => $appointment->studio->name,
                        'notes' => $appointment->notes,
                        'emergency' => $appointment->emergency,
                    ]);
            })
            ->toArray();
    }

    protected function getPatientEventTitle(Appointment $appointment): string
    {
        $prefix = $appointment->emergency ? '🚨 ' : '';
        return sprintf(
            '%s%s - Dr. %s',
            $prefix,
            $appointment->type->getLabel(),
            $appointment->doctor->name
        );
    }

    protected function getEventColor(Appointment $appointment): string
    {
        if ($appointment->emergency) {
            return '#dc2626'; // Rosso per emergenze
        }

        return match($appointment->status) {
            AppointmentStatus::SCHEDULED => '#3b82f6', // Blu
            AppointmentStatus::CONFIRMED => '#10b981', // Verde
            AppointmentStatus::COMPLETED => '#6b7280', // Grigio
            AppointmentStatus::CANCELLED => '#ef4444', // Rosso
            AppointmentStatus::NO_SHOW => '#f59e0b',   // Arancione
        };
    }

    public function getFormSchema(): array
    {
        return [
            Forms\Components\Section::make('Dettagli Appuntamento')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->disabled(),
                    
                    Forms\Components\Select::make('type')
                        ->options(AppointmentType::class)
                        ->disabled(),
                    
                    Forms\Components\DateTimePicker::make('start_time')
                        ->disabled(),
                    
                    Forms\Components\DateTimePicker::make('end_time')
                        ->disabled(),
                    
                    Forms\Components\TextInput::make('doctor.name')
                        ->disabled(),
                    
                    Forms\Components\TextInput::make('studio.name')
                        ->disabled(),
                    
                    Forms\Components\Textarea::make('notes')
                        ->disabled(),
                ])
        ];
    }

    public function eventDidMount(): string
    {
        return <<<JS
        function({ event, el }) {
            // Tooltip per pazienti
            el.setAttribute('title', 
                'Tipo: ' + event.extendedProps.type + 
                '\\nDottore: ' + event.extendedProps.doctor +
                '\\nStudio: ' + event.extendedProps.studio +
                (event.extendedProps.notes ? '\\nNote: ' + event.extendedProps.notes : '')
            );
            
            // Icona in base al tipo
            const icon = document.createElement('i');
            if (event.extendedProps.emergency) {
                icon.className = 'fas fa-exclamation-triangle mr-1';
            } else {
                icon.className = 'fas fa-tooth mr-1';
            }
            el.querySelector('.fc-event-title').prepend(icon);
        }
        JS;
    }
}
```

### 2. DoctorCalendarWidget

Widget per dottori che mostra appuntamenti dello studio corrente:

```php
<?php

namespace Modules\SaluteOra\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\Studio;
use Modules\SaluteOra\Enums\AppointmentStatus;
use Modules\SaluteOra\Enums\AppointmentType;
use Modules\SaluteOra\Enums\UserType;
use Saade\FilamentFullCalendar\Data\EventData;
use Filament\Forms;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;

class DoctorCalendarWidget extends FullCalendarWidget
{
    public Model | string | null $model = Appointment::class;

    public static function canView(): bool
    {
        $user = auth()->user();
        return $user?->type === UserType::DOCTOR && Filament::getTenant();
    }

    public function config(): array
    {
        return [
            'locale' => 'it',
            'timezone' => 'Europe/Rome',
            'headerToolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'dayGridMonth,timeGridWeek,timeGridDay'
            ],
            'initialView' => 'timeGridWeek',
            'businessHours' => [
                'daysOfWeek' => [1, 2, 3, 4, 5, 6],
                'startTime' => '08:00',
                'endTime' => '19:00',
            ],
            'slotMinTime' => '07:00',
            'slotMaxTime' => '20:00',
            'height' => 'auto',
            'eventDisplay' => 'block',
            'displayEventTime' => true,
            'eventTimeFormat' => [
                'hour' => '2-digit',
                'minute' => '2-digit',
                'hour12' => false
            ],
            'editable' => true,
            'selectable' => true,
            'selectMirror' => true,
            'dayMaxEvents' => true,
            'eventResizableFromStart' => true,
        ];
    }

    public function fetchEvents(array $fetchInfo): array
    {
        $studio = Filament::getTenant();
        $user = auth()->user();
        
        $query = Appointment::query()
            ->where('studio_id', $studio->id)
            ->whereBetween('start_time', [$fetchInfo['start'], $fetchInfo['end']])
            ->with(['patient', 'doctor', 'studio']);

        // Se non è studio admin, mostra solo i propri appuntamenti
        if (!$user->hasRole('studio_admin')) {
            $query->where('doctor_id', $user->id);
        }

        return $query->get()
            ->map(function (Appointment $appointment) {
                return EventData::make()
                    ->id($appointment->id)
                    ->title($this->getDoctorEventTitle($appointment))
                    ->start($appointment->start_time)
                    ->end($appointment->end_time)
                    ->backgroundColor($this->getEventColor($appointment))
                    ->borderColor($this->getEventColor($appointment))
                    ->textColor('#ffffff')
                    ->extendedProps([
                        'type' => $appointment->type->value,
                        'status' => $appointment->status->value,
                        'patient' => $appointment->patient->name,
                        'doctor' => $appointment->doctor->name,
                        'notes' => $appointment->notes,
                        'emergency' => $appointment->emergency,
                    ]);
            })
            ->toArray();
    }

    protected function getDoctorEventTitle(Appointment $appointment): string
    {
        $prefix = $appointment->emergency ? '🚨 ' : '';
        return sprintf(
            '%s%s - %s',
            $prefix,
            $appointment->type->getLabel(),
            $appointment->patient->name
        );
    }

    protected function getEventColor(Appointment $appointment): string
    {
        if ($appointment->emergency) {
            return '#dc2626';
        }

        return match($appointment->type) {
            AppointmentType::CONSULTATION => '#3b82f6',
            AppointmentType::CLEANING => '#10b981',
            AppointmentType::TREATMENT => '#f59e0b',
            AppointmentType::EMERGENCY => '#dc2626',
            AppointmentType::FOLLOWUP => '#8b5cf6',
        };
    }

    public function getFormSchema(): array
    {
        return [
            Forms\Components\Section::make('Dettagli Appuntamento')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->required(),
                    
                    Forms\Components\Select::make('patient_id')
                        ->relationship('patient', 'name')
                        ->searchable()
                        ->required(),
                    
                    Forms\Components\Select::make('doctor_id')
                        ->relationship('doctor', 'name')
                        ->default(auth()->id())
                        ->required(),
                    
                    Forms\Components\Select::make('type')
                        ->options(AppointmentType::class)
                        ->required(),
                    
                    Forms\Components\Select::make('status')
                        ->options(AppointmentStatus::class)
                        ->default(AppointmentStatus::SCHEDULED)
                        ->required(),
                    
                    Forms\Components\DateTimePicker::make('start_time')
                        ->required(),
                    
                    Forms\Components\DateTimePicker::make('end_time')
                        ->required(),
                    
                    Forms\Components\Toggle::make('emergency'),
                    
                    Forms\Components\Textarea::make('notes')
                        ->rows(3),
                ])
                ->columns(2)
        ];
    }

    public function onEventClick(array $info = []): void
    {
        $this->mountAction('edit', $info['event']['id']);
    }

    public function onEventDrop(array $info = []): bool
    {
        $appointment = Appointment::find($info['event']['id']);
        
        if (!$appointment || !$this->canEditAppointment($appointment)) {
            return false;
        }

        $appointment->update([
            'start_time' => $info['event']['start'],
            'end_time' => $info['event']['end'],
        ]);

        return true;
    }

    public function onEventResize(array $info = []): bool
    {
        $appointment = Appointment::find($info['event']['id']);
        
        if (!$appointment || !$this->canEditAppointment($appointment)) {
            return false;
        }

        $appointment->update([
            'start_time' => $info['event']['start'],
            'end_time' => $info['event']['end'],
        ]);

        return true;
    }

    protected function canEditAppointment(Appointment $appointment): bool
    {
        $user = auth()->user();
        $studio = Filament::getTenant();
        
        return $appointment->studio_id === $studio->id &&
               ($user->hasRole('studio_admin') || $appointment->doctor_id === $user->id);
    }

    public function eventDidMount(): string
    {
        return <<<JS
        function({ event, el }) {
            // Tooltip per dottori
            el.setAttribute('title', 
                'Paziente: ' + event.extendedProps.patient + 
                '\\nTipo: ' + event.extendedProps.type +
                '\\nDottore: ' + event.extendedProps.doctor +
                (event.extendedProps.notes ? '\\nNote: ' + event.extendedProps.notes : '')
            );
            
            // Icona in base al tipo
            const icon = document.createElement('i');
            if (event.extendedProps.emergency) {
                icon.className = 'fas fa-exclamation-triangle mr-1';
            } else {
                icon.className = 'fas fa-user-injured mr-1';
            }
            el.querySelector('.fc-event-title').prepend(icon);
        }
        JS;
    }
}
```

### 3. AdminCalendarWidget

Widget per admin che vede tutti gli appuntamenti:

```php
<?php

namespace Modules\SaluteOra\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\Studio;
use Modules\SaluteOra\Enums\AppointmentStatus;
use Modules\SaluteOra\Enums\AppointmentType;
use Modules\SaluteOra\Enums\UserType;
use Saade\FilamentFullCalendar\Data\EventData;
use Filament\Forms;
use Illuminate\Database\Eloquent\Model;

class AdminCalendarWidget extends FullCalendarWidget
{
    public Model | string | null $model = Appointment::class;

    public ?string $selectedStudio = null;

    public static function canView(): bool
    {
        return auth()->user()?->type === UserType::ADMIN;
    }

    public function config(): array
    {
        return [
            'locale' => 'it',
            'timezone' => 'Europe/Rome',
            'headerToolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'dayGridMonth,timeGridWeek,timeGridDay'
            ],
            'initialView' => 'dayGridMonth',
            'businessHours' => [
                'daysOfWeek' => [1, 2, 3, 4, 5, 6],
                'startTime' => '08:00',
                'endTime' => '19:00',
            ],
            'height' => 'auto',
            'eventDisplay' => 'block',
            'displayEventTime' => true,
            'eventTimeFormat' => [
                'hour' => '2-digit',
                'minute' => '2-digit',
                'hour12' => false
            ],
            'editable' => true,
            'selectable' => true,
            'dayMaxEvents' => 3,
        ];
    }

    public function fetchEvents(array $fetchInfo): array
    {
        $query = Appointment::query()
            ->whereBetween('start_time', [$fetchInfo['start'], $fetchInfo['end']])
            ->with(['patient', 'doctor', 'studio']);

        // Filtro per studio se selezionato
        if ($this->selectedStudio) {
            $query->where('studio_id', $this->selectedStudio);
        }

        return $query->get()
            ->map(function (Appointment $appointment) {
                return EventData::make()
                    ->id($appointment->id)
                    ->title($this->getAdminEventTitle($appointment))
                    ->start($appointment->start_time)
                    ->end($appointment->end_time)
                    ->backgroundColor($this->getEventColor($appointment))
                    ->borderColor($this->getEventColor($appointment))
                    ->textColor('#ffffff')
                    ->extendedProps([
                        'type' => $appointment->type->value,
                        'status' => $appointment->status->value,
                        'patient' => $appointment->patient->name,
                        'doctor' => $appointment->doctor->name,
                        'studio' => $appointment->studio->name,
                        'notes' => $appointment->notes,
                        'emergency' => $appointment->emergency,
                    ]);
            })
            ->toArray();
    }

    protected function getAdminEventTitle(Appointment $appointment): string
    {
        $prefix = $appointment->emergency ? '🚨 ' : '';
        return sprintf(
            '%s%s - %s @ %s',
            $prefix,
            $appointment->type->getLabel(),
            $appointment->patient->name,
            $appointment->studio->name
        );
    }

    protected function getEventColor(Appointment $appointment): string
    {
        if ($appointment->emergency) {
            return '#dc2626';
        }

        // Colori per studio
        $studioColors = [
            '#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#ef4444', '#06b6d4'
        ];
        
        return $studioColors[$appointment->studio_id % count($studioColors)];
    }

    public function getFormSchema(): array
    {
        return [
            Forms\Components\Section::make('Filtri')
                ->schema([
                    Forms\Components\Select::make('selectedStudio')
                        ->label('Studio')
                        ->options(Studio::pluck('name', 'id'))
                        ->placeholder('Tutti gli studi')
                        ->live()
                        ->afterStateUpdated(fn () => $this->refresh()),
                ])
                ->collapsible(),
                
            Forms\Components\Section::make('Dettagli Appuntamento')
                ->schema([
                    Forms\Components\TextInput::make('title')
                        ->required(),
                    
                    Forms\Components\Select::make('patient_id')
                        ->relationship('patient', 'name')
                        ->searchable()
                        ->required(),
                    
                    Forms\Components\Select::make('doctor_id')
                        ->relationship('doctor', 'name')
                        ->searchable()
                        ->required(),
                    
                    Forms\Components\Select::make('studio_id')
                        ->relationship('studio', 'name')
                        ->required(),
                    
                    Forms\Components\Select::make('type')
                        ->options(AppointmentType::class)
                        ->required(),
                    
                    Forms\Components\Select::make('status')
                        ->options(AppointmentStatus::class)
                        ->default(AppointmentStatus::SCHEDULED)
                        ->required(),
                    
                    Forms\Components\DateTimePicker::make('start_time')
                        ->required(),
                    
                    Forms\Components\DateTimePicker::make('end_time')
                        ->required(),
                    
                    Forms\Components\Toggle::make('emergency'),
                    
                    Forms\Components\Textarea::make('notes')
                        ->rows(3),
                ])
                ->columns(2)
        ];
    }

    public function eventDidMount(): string
    {
        return <<<JS
        function({ event, el }) {
            // Tooltip per admin
            el.setAttribute('title', 
                'Paziente: ' + event.extendedProps.patient + 
                '\\nDottore: ' + event.extendedProps.doctor +
                '\\nStudio: ' + event.extendedProps.studio +
                '\\nTipo: ' + event.extendedProps.type +
                '\\nStato: ' + event.extendedProps.status +
                (event.extendedProps.notes ? '\\nNote: ' + event.extendedProps.notes : '')
            );
            
            // Icona in base al tipo
            const icon = document.createElement('i');
            if (event.extendedProps.emergency) {
                icon.className = 'fas fa-exclamation-triangle mr-1';
            } else {
                icon.className = 'fas fa-calendar-check mr-1';
            }
            el.querySelector('.fc-event-title').prepend(icon);
        }
        JS;
    }
}
```

## Configurazione Panel

### Panel Paziente

```php
// app/Providers/Filament/PatientPanelProvider.php
public function panel(Panel $panel): Panel
{
    return $panel
        ->id('patient')
        ->path('/patient')
        ->login()
        ->registration()
        ->widgets([
            PatientCalendarWidget::class,
        ])
        ->middleware([
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            AuthenticateSession::class,
            ShareErrorsFromSession::class,
            VerifyCsrfToken::class,
            SubstituteBindings::class,
            DisableBladeIconComponents::class,
            DispatchServingFilamentEvent::class,
        ])
        ->authMiddleware([
            Authenticate::class,
            EnsureUserType::class.':patient',
        ]);
}
```

### Panel Dottore

```php
// app/Providers/Filament/DoctorPanelProvider.php
public function panel(Panel $panel): Panel
{
    return $panel
        ->id('doctor')
        ->path('/doctor')
        ->tenant(Studio::class)
        ->tenantRegistration(RegisterStudio::class)
        ->tenantProfile(EditStudioProfile::class)
        ->login()
        ->widgets([
            DoctorCalendarWidget::class,
        ])
        ->middleware([
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            AuthenticateSession::class,
            ShareErrorsFromSession::class,
            VerifyCsrfToken::class,
            SubstituteBindings::class,
            DisableBladeIconComponents::class,
            DispatchServingFilamentEvent::class,
        ])
        ->authMiddleware([
            Authenticate::class,
            EnsureUserType::class.':doctor',
        ]);
}
```

### Panel Admin

```php
// app/Providers/Filament/AdminPanelProvider.php
public function panel(Panel $panel): Panel
{
    return $panel
        ->id('admin')
        ->path('/admin')
        ->login()
        ->widgets([
            AdminCalendarWidget::class,
        ])
        ->middleware([
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            AuthenticateSession::class,
            ShareErrorsFromSession::class,
            VerifyCsrfToken::class,
            SubstituteBindings::class,
            DisableBladeIconComponents::class,
            DispatchServingFilamentEvent::class,
        ])
        ->authMiddleware([
            Authenticate::class,
            EnsureUserType::class.':admin',
        ]);
}
```

## Middleware per Controllo Tipo Utente

```php
<?php

namespace Modules\SaluteOra\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\SaluteOra\Enums\UserType;

class EnsureUserType
{
    public function handle(Request $request, Closure $next, string $type): mixed
    {
        $user = auth()->user();
        
        if (!$user || $user->type->value !== $type) {
            abort(403, 'Accesso non autorizzato per questo tipo di utente.');
        }

        return $next($request);
    }
}
```

## Policy per Sicurezza

```php
<?php

namespace Modules\SaluteOra\Policies;

use Modules\SaluteOra\Models\User;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Enums\UserType;
use Filament\Facades\Filament;

class AppointmentPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->type, [UserType::PATIENT, UserType::DOCTOR, UserType::ADMIN]);
    }

    public function view(User $user, Appointment $appointment): bool
    {
        return match($user->type) {
            UserType::PATIENT => $appointment->patient_id === $user->id,
            UserType::DOCTOR => $this->doctorCanView($user, $appointment),
            UserType::ADMIN => true,
        };
    }

    public function create(User $user): bool
    {
        return in_array($user->type, [UserType::DOCTOR, UserType::ADMIN]);
    }

    public function update(User $user, Appointment $appointment): bool
    {
        return match($user->type) {
            UserType::PATIENT => false, // Pazienti non possono modificare
            UserType::DOCTOR => $this->doctorCanEdit($user, $appointment),
            UserType::ADMIN => true,
        };
    }

    public function delete(User $user, Appointment $appointment): bool
    {
        return $this->update($user, $appointment);
    }

    protected function doctorCanView(User $user, Appointment $appointment): bool
    {
        $studio = Filament::getTenant();
        
        return $appointment->studio_id === $studio?->id &&
               ($user->hasRole('studio_admin') || $appointment->doctor_id === $user->id);
    }

    protected function doctorCanEdit(User $user, Appointment $appointment): bool
    {
        return $this->doctorCanView($user, $appointment);
    }
}
```

## Caratteristiche Specifiche Sanitarie

### Localizzazione Italiana

```php
// lang/it/fullcalendar.php
return [
    'months' => [
        'Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno',
        'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'
    ],
    'days' => [
        'Domenica', 'Lunedì', 'Martedì', 'Mercoledì', 'Giovedì', 'Venerdì', 'Sabato'
    ],
    'today' => 'Oggi',
    'month' => 'Mese',
    'week' => 'Settimana',
    'day' => 'Giorno',
    'list' => 'Lista',
];
```

### Orari Sanitari

- **Orari lavorativi**: Lunedì-Sabato 8:00-19:00
- **Slot temporali**: 30 minuti per visita standard
- **Emergenze**: Evidenziate in rosso con icona di allerta
- **Colori per tipo**: Diversi colori per tipo di trattamento

### Performance e Caching

```php
// Caching specifico per tenant
public function fetchEvents(array $fetchInfo): array
{
    $cacheKey = sprintf(
        'calendar_events_%s_%s_%s_%s',
        auth()->id(),
        Filament::getTenant()?->id ?? 'global',
        $fetchInfo['start'],
        $fetchInfo['end']
    );

    return cache()->remember($cacheKey, 300, function () use ($fetchInfo) {
        // Query per eventi...
    });
}
```

## Installazione e Configurazione

### 1. Installazione Plugin

```bash
composer require saade/filament-fullcalendar
```

### 2. Pubblicazione Assets

```bash
php artisan filament:assets
```

### 3. Configurazione Database

```bash
php artisan make:migration create_studios_table
php artisan make:migration update_appointments_table
php artisan migrate
```

### 4. Registrazione Widget

```php
// In ogni PanelProvider
->widgets([
    PatientCalendarWidget::class,
    DoctorCalendarWidget::class,
    AdminCalendarWidget::class,
])
```

## Conclusioni

Questa implementazione fornisce:

1. **Sicurezza**: Isolamento completo dei dati per tipo utente
2. **Multi-tenancy**: Gestione studi con tenancy Filament
3. **Parental STI**: Gestione elegante dei tipi utente
4. **Localizzazione**: Interfaccia completamente in italiano
5. **Performance**: Caching intelligente per tenant
6. **Sanitario**: Funzionalità specifiche per ambiente medico

Il sistema garantisce che ogni tipo di utente veda solo i dati appropriati, mantenendo la sicurezza e la privacy richieste in ambito sanitario.

# Flusso Prenotazione Paziente con FullCalendar

## Esperienza Utente

1. **Scelta dello Studio**
   - Il paziente, dopo aver effettuato il login, seleziona lo studio dentistico presso cui desidera prenotare.
   - Questa scelta è fondamentale per isolare la disponibilità e le regole di prenotazione per ogni studio (multi-tenant).
   - ![Selezione studio](../images/7.png)

2. **Visualizzazione Calendario**
   - Dopo la selezione dello studio, viene mostrato il calendario (FullCalendar) con evidenziati i giorni prenotabili.
   - I giorni disponibili sono calcolati in base alle regole di business dello studio, alle fasce orarie e alle disponibilità dei dottori.
   - I giorni non prenotabili sono disabilitati o non cliccabili.
   - ![Calendario giorni disponibili](../images/8.png)

3. **Selezione Giorno**
   - Il paziente clicca su un giorno disponibile.
   - Sotto il calendario, vengono mostrati gli orari disponibili per la prenotazione in quel giorno (slot orari).
   - ![Orari disponibili](../images/9.png)

4. **Scelta Orario e Conferma**
   - Il paziente seleziona uno degli orari disponibili e conferma la prenotazione.
   - Il sistema verifica in tempo reale la disponibilità e registra l'appuntamento.
   - Viene mostrata una conferma visiva e inviata una notifica.

## Motivazione Scelta FullCalendar

- **Standard di mercato**: FullCalendar è la libreria di riferimento per la gestione di calendari interattivi in ambito web, usata da moltissimi prodotti enterprise e open source.
- **Flessibilità**: Permette di personalizzare la visualizzazione (giorno, settimana, mese), integrare facilmente logiche di business, e supporta eventi dinamici, drag&drop, e responsive design.
- **Accessibilità**: Supporta localizzazione, accessibilità e mobile out-of-the-box.
- **Ecosistema**: Ampio supporto di plugin, documentazione, community e compatibilità con framework moderni.
- **Performance**: Gestisce bene dataset anche di grandi dimensioni grazie a virtualizzazione e lazy loading.
- **Alternativa**: Soluzioni custom sarebbero più costose, meno manutenibili e meno standardizzate. Altre librerie non offrono lo stesso livello di maturità e supporto.

## Architettura e Implicazioni

- **Multi-tenant**: Ogni studio ha regole e disponibilità proprie; la selezione dello studio filtra tutti i dati e le azioni successive.
- **Widget Calendar**: Il widget FullCalendar viene configurato dinamicamente in base allo studio selezionato e al tipo utente (paziente, dottore, admin).
- **Slot Orari**: Gli slot vengono calcolati lato backend e restituiti in risposta alla selezione del giorno, garantendo coerenza e prevenendo overbooking.
- **Sicurezza**: Il paziente può vedere solo i giorni/orari effettivamente prenotabili secondo le policy dello studio.
- **UX**: Il flusso è ottimizzato per semplicità, immediatezza e riduzione degli errori.

## Riferimenti Immagini
- [7.png](../images/7.png): Selezione studio
- [8.png](../images/8.png): Visualizzazione giorni disponibili
- [9.png](../images/9.png): Orari disponibili per il giorno selezionato

## Note
- Il sistema può essere facilmente esteso per gestire regole di business più complesse (es. limiti di prenotazione, fasce prioritarie, promemoria, ecc.)
- FullCalendar consente di integrare facilmente logiche di validazione, feedback visivo e notifiche in tempo reale.

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
- [appointment-management.md](appointment-management.md)

## Policy di implementazione widget FullCalendar (2024)

- I widget FullCalendar **devono sempre** essere implementati come classi custom che estendono FullCalendarWidget.
- Tutte le opzioni vanno fornite tramite override del metodo config().
- Gli eventi vanno forniti tramite override di fetchEvents().
- **Non usare mai** FullCalendarWidget::make()->options() o ->config() o ->events(): questi metodi non esistono e generano errori.
- Nelle pagine Filament, includere solo la classe custom nei metodi getHeaderWidgets() o simili.

### Esempio corretto

```php
// Widget custom
class DoctorCalendarWidget extends FullCalendarWidget {
    public function config(): array { /* ... */ }
    public function fetchEvents(array $fetchInfo): array { /* ... */ }
}

// Nella pagina
protected function getHeaderWidgets(): array {
    return [\Modules\SaluteOra\Filament\Widgets\DoctorCalendarWidget::class];
}
```

### Errori comuni da evitare

- Usare FullCalendarWidget::make()->options([...]) // ❌ ERRORE
- Usare metodi fluenti su FullCalendarWidget // ❌ ERRORE
