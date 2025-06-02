# Widget FullCalendar Multi-Tenant per SaluteOra

## Panoramica

Questo documento descrive l'implementazione di widget FullCalendar specifici per un'applicazione sanitaria multi-tenant, dove i dottori possono lavorare in più sedi e utilizzare il sistema di tenancy di Filament per gestire l'accesso ai dati.

## Architettura Multi-Tenant

### Struttura del Sistema

Il sistema è progettato con tre livelli di accesso:

1. **Paziente**: Visualizza solo i propri appuntamenti
2. **Dottore**: Visualizza gli appuntamenti dello studio selezionato tramite tenancy
3. **Admin**: Visualizza tutti gli appuntamenti di tutti gli studi

### Configurazione Tenancy

Utilizziamo il sistema di tenancy integrato di Filament:

```php
// app/Providers/Filament/AdminPanelProvider.php
use App\Models\Studio;
use Filament\Panel;

public function panel(Panel $panel): Panel
{
    return $panel
        ->id('admin')
        ->tenant(Studio::class)
        ->tenantRegistration(RegisterStudio::class)
        ->tenantProfile(EditStudioProfile::class)
        ->tenantMenuItems([
            'register' => MenuItem::make()->label('Nuovo Studio'),
        ]);
}
```

## Gestione Disponibilità: Policy DRY

La disponibilità del dottore NON è mai gestita tramite una tabella custom (es. doctor_availabilities), ma solo tramite il modello Appointment:
- Gli slot disponibili sono Appointment con type=availability, status=available
- Gli appuntamenti richiesti/confermati sono Appointment con altri type/status

### Esempio di fetch slot disponibili
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

## Widget Specifici per Tipo Utente

### 1. Widget Paziente - `PatientAppointmentWidget`

Widget per pazienti che mostra solo i propri appuntamenti.

```php
<?php

namespace Modules\SaluteOra\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Enums\AppointmentStatus;
use Modules\SaluteOra\App\Enums\AppointmentType;
use Saade\FilamentFullCalendar\Data\EventData;
use Filament\Forms;
use Illuminate\Database\Eloquent\Model;

class PatientAppointmentWidget extends FullCalendarWidget
{
    public Model | string | null $model = Appointment::class;

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
                'daysOfWeek' => [1, 2, 3, 4, 5], // Lunedì-Venerdì
                'startTime' => '08:00',
                'endTime' => '18:00',
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
        ];
    }

    public function fetchEvents(array $fetchInfo): array
    {
        $user = auth()->user();
        
        return Appointment::query()
            ->where('patient_id', $user->id)
            ->whereBetween('start_time', [$fetchInfo['start'], $fetchInfo['end']])
            ->get()
            ->map(function (Appointment $appointment) {
                return EventData::make()
                    ->id($appointment->id)
                    ->title($this->getPatientEventTitle($appointment))
                    ->start($appointment->start_time)
                    ->end($appointment->end_time)
                    ->backgroundColor($this->getPatientEventColor($appointment))
                    ->borderColor($this->getPatientEventColor($appointment))
                    ->textColor('#ffffff')
                    ->extendedProps([
                        'type' => $appointment->type->value,
                        'status' => $appointment->status->value,
                        'doctor' => $appointment->doctor->name,
                        'studio' => $appointment->studio->name,
                        'notes' => $appointment->notes,
                    ]);
            })
            ->toArray();
    }

    protected function getPatientEventTitle(Appointment $appointment): string
    {
        return sprintf(
            '%s - Dr. %s',
            $appointment->type->getLabel(),
            $appointment->doctor->name
        );
    }

    protected function getPatientEventColor(Appointment $appointment): string
    {
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
                        ->label('Titolo')
                        ->disabled(),
                    
                    Forms\Components\Select::make('type')
                        ->label('Tipo Visita')
                        ->options(AppointmentType::class)
                        ->disabled(),
                    
                    Forms\Components\DateTimePicker::make('start_time')
                        ->label('Data e Ora Inizio')
                        ->disabled(),
                    
                    Forms\Components\DateTimePicker::make('end_time')
                        ->label('Data e Ora Fine')
                        ->disabled(),
                    
                    Forms\Components\TextInput::make('doctor.name')
                        ->label('Dottore')
                        ->disabled(),
                    
                    Forms\Components\TextInput::make('studio.name')
                        ->label('Studio')
                        ->disabled(),
                    
                    Forms\Components\Textarea::make('notes')
                        ->label('Note')
                        ->disabled(),
                ])
        ];
    }

    public function eventDidMount(): string
    {
        return <<<JS
        function({ event, el }) {
            // Aggiungi tooltip per i pazienti
            el.setAttribute('title', 
                'Tipo: ' + event.extendedProps.type + 
                '\\nDottore: ' + event.extendedProps.doctor +
                '\\nStudio: ' + event.extendedProps.studio +
                (event.extendedProps.notes ? '\\nNote: ' + event.extendedProps.notes : '')
            );
            
            // Aggiungi icona in base al tipo
            const icon = document.createElement('i');
            icon.className = 'fas fa-tooth mr-1';
            el.querySelector('.fc-event-title').prepend(icon);
        }
        JS;
    }

    protected function modalMaxWidth(): string
    {
        return '2xl';
    }

    public static function canView(): bool
    {
        return auth()->user()->hasRole('patient');
    }
}
```

### 2. Widget Dottore - `DoctorStudioAppointmentWidget`

Il widget mostra sia gli slot di disponibilità (Appointment type=availability, status=available) sia gli appuntamenti (altri type/status). Tutte le azioni CRUD sono centralizzate su Appointment. Nessuna tabella custom.

```php
<?php

namespace Modules\SaluteOra\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Enums\AppointmentStatus;
use Modules\SaluteOra\App\Enums\AppointmentType;
use Saade\FilamentFullCalendar\Data\EventData;
use Filament\Forms;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;

class DoctorStudioAppointmentWidget extends FullCalendarWidget
{
    public Model | string | null $model = Appointment::class;

    public function config(): array
    {
        return [
            'locale' => 'it',
            'timezone' => 'Europe/Rome',
            'headerToolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            ],
            'initialView' => 'timeGridWeek',
            'businessHours' => [
                'daysOfWeek' => [1, 2, 3, 4, 5, 6], // Lunedì-Sabato
                'startTime' => '08:00',
                'endTime' => '19:00',
            ],
            'slotMinTime' => '07:00',
            'slotMaxTime' => '21:00',
            'slotDuration' => '00:30:00',
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
        ];
    }

    public function fetchEvents(array $fetchInfo): array
    {
        $studio = Filament::getTenant();
        $user = auth()->user();
        
        $query = Appointment::query()
            ->where('studio_id', $studio->id)
            ->whereBetween('start_time', [$fetchInfo['start'], $fetchInfo['end']]);
            
        // Se il dottore non è admin dello studio, mostra solo i suoi appuntamenti
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
                    ->backgroundColor($this->getDoctorEventColor($appointment))
                    ->borderColor($this->getDoctorEventBorderColor($appointment))
                    ->textColor('#ffffff')
                    ->extendedProps([
                        'type' => $appointment->type->value,
                        'status' => $appointment->status->value,
                        'patient_name' => $appointment->patient->name,
                        'patient_phone' => $appointment->patient->phone,
                        'doctor' => $appointment->doctor->name,
                        'notes' => $appointment->notes,
                        'is_urgent' => $appointment->is_urgent,
                    ]);
            })
            ->toArray();
    }

    protected function getDoctorEventTitle(Appointment $appointment): string
    {
        $title = $appointment->patient->name;
        
        if ($appointment->is_urgent) {
            $title = '🚨 ' . $title;
        }
        
        return $title . ' - ' . $appointment->type->getLabel();
    }

    protected function getDoctorEventColor(Appointment $appointment): string
    {
        if ($appointment->is_urgent) {
            return '#dc2626'; // Rosso per urgenze
        }
        
        return match($appointment->type) {
            AppointmentType::CONSULTATION => '#3b82f6',    // Blu
            AppointmentType::CLEANING => '#10b981',        // Verde
            AppointmentType::TREATMENT => '#f59e0b',       // Arancione
            AppointmentType::SURGERY => '#8b5cf6',         // Viola
            AppointmentType::EMERGENCY => '#ef4444',       // Rosso
            AppointmentType::FOLLOW_UP => '#6b7280',       // Grigio
        };
    }

    protected function getDoctorEventBorderColor(Appointment $appointment): string
    {
        return match($appointment->status) {
            AppointmentStatus::SCHEDULED => '#94a3b8',  // Grigio chiaro
            AppointmentStatus::CONFIRMED => '#059669',  // Verde scuro
            AppointmentStatus::COMPLETED => '#374151',  // Grigio scuro
            AppointmentStatus::CANCELLED => '#991b1b',  // Rosso scuro
            AppointmentStatus::NO_SHOW => '#92400e',    // Arancione scuro
        };
    }

    public function getFormSchema(): array
    {
        return [
            Forms\Components\Section::make('Informazioni Paziente')
                ->schema([
                    Forms\Components\Select::make('patient_id')
                        ->label('Paziente')
                        ->relationship('patient', 'name')
                        ->searchable()
                        ->required(),
                    
                    Forms\Components\TextInput::make('patient.phone')
                        ->label('Telefono Paziente')
                        ->disabled(),
                ]),
                
            Forms\Components\Section::make('Dettagli Appuntamento')
                ->schema([
                    Forms\Components\Select::make('type')
                        ->label('Tipo Visita')
                        ->options(AppointmentType::class)
                        ->required(),
                    
                    Forms\Components\DateTimePicker::make('start_time')
                        ->label('Data e Ora Inizio')
                        ->required(),
                    
                    Forms\Components\DateTimePicker::make('end_time')
                        ->label('Data e Ora Fine')
                        ->required(),
                    
                    Forms\Components\Select::make('status')
                        ->label('Stato')
                        ->options(AppointmentStatus::class)
                        ->default(AppointmentStatus::SCHEDULED),
                    
                    Forms\Components\Toggle::make('is_urgent')
                        ->label('Urgente'),
                    
                    Forms\Components\Textarea::make('notes')
                        ->label('Note')
                        ->rows(3),
                ])
        ];
    }

    public function eventDidMount(): string
    {
        return <<<JS
        function({ event, el }) {
            // Aggiungi tooltip dettagliato per i dottori
            el.setAttribute('title', 
                'Paziente: ' + event.extendedProps.patient_name + 
                '\\nTelefono: ' + event.extendedProps.patient_phone +
                '\\nTipo: ' + event.extendedProps.type + 
                '\\nStato: ' + event.extendedProps.status +
                (event.extendedProps.notes ? '\\nNote: ' + event.extendedProps.notes : '')
            );
            
            // Aggiungi icone in base al tipo e stato
            const iconContainer = document.createElement('div');
            iconContainer.className = 'flex items-center space-x-1 mb-1';
            
            // Icona tipo
            const typeIcon = document.createElement('i');
            typeIcon.className = this.getTypeIcon(event.extendedProps.type);
            iconContainer.appendChild(typeIcon);
            
            // Icona stato
            const statusIcon = document.createElement('i');
            statusIcon.className = this.getStatusIcon(event.extendedProps.status);
            iconContainer.appendChild(statusIcon);
            
            el.querySelector('.fc-event-title').prepend(iconContainer);
        }
        JS;
    }

    public function onEventDrop(array $info = []): bool
    {
        $appointment = Appointment::find($info['event']['id']);
        
        if (!$appointment) {
            return false;
        }
        
        // Verifica che il dottore possa modificare questo appuntamento
        if (!auth()->user()->hasRole('studio_admin') && $appointment->doctor_id !== auth()->id()) {
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
        return $this->onEventDrop($info);
    }

    public function onDateSelect(array $info = []): void
    {
        $this->mountAction('create', [
            'start_time' => $info['start'],
            'end_time' => $info['end'],
        ]);
    }

    protected function modalMaxWidth(): string
    {
        return '3xl';
    }

    public static function canView(): bool
    {
        return auth()->user()->hasAnyRole(['doctor', 'studio_admin']);
    }
}
```

### 3. Widget Admin - `AdminAllAppointmentsWidget`

Widget per amministratori che visualizza tutti gli appuntamenti di tutti gli studi.

```php
<?php

namespace Modules\SaluteOra\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Models\Studio;
use Modules\SaluteOra\Enums\AppointmentStatus;
use Modules\SaluteOra\App\Enums\AppointmentType;
use Saade\FilamentFullCalendar\Data\EventData;
use Filament\Forms;
use Illuminate\Database\Eloquent\Model;

class AdminAllAppointmentsWidget extends FullCalendarWidget
{
    public Model | string | null $model = Appointment::class;

    public ?string $selectedStudio = null;

    public function config(): array
    {
        return [
            'locale' => 'it',
            'timezone' => 'Europe/Rome',
            'headerToolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            ],
            'initialView' => 'dayGridMonth',
            'businessHours' => [
                'daysOfWeek' => [1, 2, 3, 4, 5, 6],
                'startTime' => '08:00',
                'endTime' => '19:00',
            ],
            'slotMinTime' => '07:00',
            'slotMaxTime' => '21:00',
            'height' => 'auto',
            'eventDisplay' => 'block',
            'displayEventTime' => true,
            'eventTimeFormat' => [
                'hour' => '2-digit',
                'minute' => '2-digit',
                'hour12' => false
            ],
            'dayMaxEvents' => 3,
            'moreLinkClick' => 'popover',
        ];
    }

    public function fetchEvents(array $fetchInfo): array
    {
        $query = Appointment::query()
            ->with(['patient', 'doctor', 'studio'])
            ->whereBetween('start_time', [$fetchInfo['start'], $fetchInfo['end']]);
            
        // Filtra per studio se selezionato
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
                    ->backgroundColor($this->getAdminEventColor($appointment))
                    ->borderColor($this->getAdminEventBorderColor($appointment))
                    ->textColor('#ffffff')
                    ->extendedProps([
                        'type' => $appointment->type->value,
                        'status' => $appointment->status->value,
                        'patient_name' => $appointment->patient->name,
                        'doctor_name' => $appointment->doctor->name,
                        'studio_name' => $appointment->studio->name,
                        'studio_id' => $appointment->studio_id,
                        'notes' => $appointment->notes,
                        'is_urgent' => $appointment->is_urgent,
                    ]);
            })
            ->toArray();
    }

    protected function getAdminEventTitle(Appointment $appointment): string
    {
        return sprintf(
            '%s - %s (%s)',
            $appointment->patient->name,
            $appointment->doctor->name,
            $appointment->studio->name
        );
    }

    protected function getAdminEventColor(Appointment $appointment): string
    {
        // Colore basato sullo studio per distinguere visivamente
        $studioColors = [
            '#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', 
            '#ef4444', '#06b6d4', '#84cc16', '#f97316'
        ];
        
        $colorIndex = $appointment->studio_id % count($studioColors);
        return $studioColors[$colorIndex];
    }

    protected function getAdminEventBorderColor(Appointment $appointment): string
    {
        return match($appointment->status) {
            AppointmentStatus::SCHEDULED => '#94a3b8',
            AppointmentStatus::CONFIRMED => '#059669',
            AppointmentStatus::COMPLETED => '#374151',
            AppointmentStatus::CANCELLED => '#991b1b',
            AppointmentStatus::NO_SHOW => '#92400e',
        };
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
                        ->afterStateUpdated(fn () => $this->refreshEvents()),
                ]),
                
            Forms\Components\Section::make('Informazioni Complete')
                ->schema([
                    Forms\Components\TextInput::make('patient.name')
                        ->label('Paziente')
                        ->disabled(),
                    
                    Forms\Components\TextInput::make('doctor.name')
                        ->label('Dottore')
                        ->disabled(),
                    
                    Forms\Components\TextInput::make('studio.name')
                        ->label('Studio')
                        ->disabled(),
                    
                    Forms\Components\Select::make('type')
                        ->label('Tipo Visita')
                        ->options(AppointmentType::class)
                        ->disabled(),
                    
                    Forms\Components\DateTimePicker::make('start_time')
                        ->label('Data e Ora Inizio')
                        ->disabled(),
                    
                    Forms\Components\DateTimePicker::make('end_time')
                        ->label('Data e Ora Fine')
                        ->disabled(),
                    
                    Forms\Components\Select::make('status')
                        ->label('Stato')
                        ->options(AppointmentStatus::class)
                        ->disabled(),
                    
                    Forms\Components\Textarea::make('notes')
                        ->label('Note')
                        ->disabled(),
                ])
        ];
    }

    public function eventDidMount(): string
    {
        return <<<JS
        function({ event, el }) {
            // Tooltip completo per admin
            el.setAttribute('title', 
                'Paziente: ' + event.extendedProps.patient_name + 
                '\\nDottore: ' + event.extendedProps.doctor_name +
                '\\nStudio: ' + event.extendedProps.studio_name +
                '\\nTipo: ' + event.extendedProps.type + 
                '\\nStato: ' + event.extendedProps.status +
                (event.extendedProps.notes ? '\\nNote: ' + event.extendedProps.notes : '')
            );
            
            // Badge per studio
            const studioBadge = document.createElement('span');
            studioBadge.className = 'inline-block px-1 py-0.5 text-xs bg-black bg-opacity-20 rounded';
            studioBadge.textContent = event.extendedProps.studio_name;
            el.querySelector('.fc-event-title').appendChild(studioBadge);
        }
        JS;
    }

    protected function getHeaderActions(): array
    {
        return [
            Forms\Components\Actions\Action::make('exportData')
                ->label('Esporta Dati')
                ->icon('heroicon-o-arrow-down-tray')
                ->action(function () {
                    // Logica per esportare i dati degli appuntamenti
                }),
                
            Forms\Components\Actions\Action::make('generateReport')
                ->label('Genera Report')
                ->icon('heroicon-o-document-chart-bar')
                ->action(function () {
                    // Logica per generare report
                }),
        ];
    }

    protected function modalMaxWidth(): string
    {
        return '4xl';
    }

    public static function canView(): bool
    {
        return auth()->user()->hasRole('super_admin');
    }
}
```

## Configurazione dei Widget nei Panel

### Panel Paziente

```php
// app/Providers/Filament/PatientPanelProvider.php
use Modules\SaluteOra\Filament\Widgets\PatientAppointmentWidget;

public function panel(Panel $panel): Panel
{
    return $panel
        ->id('patient')
        ->widgets([
            PatientAppointmentWidget::class,
        ]);
}
```

### Panel Dottore (con Tenancy)

```php
// app/Providers/Filament/DoctorPanelProvider.php
use Modules\SaluteOra\Filament\Widgets\DoctorStudioAppointmentWidget;
use App\Models\Studio;

public function panel(Panel $panel): Panel
{
    return $panel
        ->id('doctor')
        ->tenant(Studio::class)
        ->widgets([
            DoctorStudioAppointmentWidget::class,
        ]);
}
```

### Panel Admin

```php
// app/Providers/Filament/AdminPanelProvider.php
use Modules\SaluteOra\Filament\Widgets\AdminAllAppointmentsWidget;

public function panel(Panel $panel): Panel
{
    return $panel
        ->id('admin')
        ->widgets([
            AdminAllAppointmentsWidget::class,
        ]);
}
```

## Modelli e Relazioni

### Modello Studio

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Filament\Models\Contracts\HasName;

class Studio extends Model implements HasName
{
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'city',
        'province',
        'cap',
    ];

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function doctors(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'doctor_studio')
            ->wherePivot('role', 'doctor');
    }

    public function getFilamentName(): string
    {
        return $this->name;
    }
}
```

### Modello User (esteso per tenancy)

```php
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class User extends Authenticatable implements FilamentUser, HasTenants
{
    public function studios(): BelongsToMany
    {
        return $this->belongsToMany(Studio::class, 'doctor_studio');
    }

    public function getTenants(Panel $panel): Collection
    {
        return $this->studios;
    }

    public function canAccessTenant(Model $tenant): bool
    {
        return $this->studios()->whereKey($tenant)->exists();
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return match ($panel->getId()) {
            'patient' => $this->hasRole('patient'),
            'doctor' => $this->hasAnyRole(['doctor', 'studio_admin']),
            'admin' => $this->hasRole('super_admin'),
            default => false,
        };
    }
}
```

## Sicurezza e Autorizzazioni

### Policy per Appointment

```php
<?php

namespace Modules\SaluteOra\Policies;

use App\Models\User;
use Modules\SaluteOra\Models\Appointment;
use Filament\Facades\Filament;

class AppointmentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['patient', 'doctor', 'studio_admin', 'super_admin']);
    }

    public function view(User $user, Appointment $appointment): bool
    {
        // Paziente può vedere solo i suoi appuntamenti
        if ($user->hasRole('patient')) {
            return $appointment->patient_id === $user->id;
        }

        // Dottore può vedere appuntamenti del suo studio
        if ($user->hasRole('doctor')) {
            $tenant = Filament::getTenant();
            return $appointment->studio_id === $tenant?->id && 
                   $appointment->doctor_id === $user->id;
        }

        // Studio admin può vedere tutti gli appuntamenti del suo studio
        if ($user->hasRole('studio_admin')) {
            $tenant = Filament::getTenant();
            return $appointment->studio_id === $tenant?->id;
        }

        // Super admin può vedere tutto
        return $user->hasRole('super_admin');
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['doctor', 'studio_admin', 'super_admin']);
    }

    public function update(User $user, Appointment $appointment): bool
    {
        return $this->view($user, $appointment) && 
               $user->hasAnyRole(['doctor', 'studio_admin', 'super_admin']);
    }

    public function delete(User $user, Appointment $appointment): bool
    {
        return $this->update($user, $appointment);
    }
}
```

## Configurazione Avanzata

### Trait per Configurazioni Comuni

```php
<?php

namespace Modules\SaluteOra\Traits;

trait HasFullCalendarConfig
{
    protected function getCommonConfig(): array
    {
        return [
            'locale' => 'it',
            'timezone' => 'Europe/Rome',
            'firstDay' => 1, // Lunedì
            'weekNumbers' => true,
            'weekText' => 'Sett.',
            'allDayText' => 'Tutto il giorno',
            'moreLinkText' => 'altri',
            'noEventsText' => 'Nessun appuntamento',
            'buttonText' => [
                'today' => 'Oggi',
                'month' => 'Mese',
                'week' => 'Settimana',
                'day' => 'Giorno',
                'list' => 'Lista'
            ],
        ];
    }

    protected function getHealthcareBusinessHours(): array
    {
        return [
            'daysOfWeek' => [1, 2, 3, 4, 5, 6], // Lun-Sab
            'startTime' => '08:00',
            'endTime' => '19:00',
        ];
    }

    protected function getHealthcareColors(): array
    {
        return [
            'consultation' => '#3b82f6',
            'cleaning' => '#10b981',
            'treatment' => '#f59e0b',
            'surgery' => '#8b5cf6',
            'emergency' => '#ef4444',
            'follow_up' => '#6b7280',
        ];
    }
}
```

## Best Practices

### 1. Performance
- Utilizzare eager loading per le relazioni
- Implementare caching per i dati frequentemente acceduti
- Limitare il range di date per le query

### 2. Sicurezza
- Sempre verificare i permessi a livello di policy
- Utilizzare il sistema di tenancy per l'isolamento dei dati
- Validare tutti gli input utente

### 3. UX/UI
- Fornire feedback visivo per le azioni
- Utilizzare colori consistenti per i tipi di appuntamento
- Implementare tooltip informativi

### 4. Manutenibilità
- Utilizzare enum per stati e tipi
- Centralizzare le configurazioni comuni
- Documentare le personalizzazioni specifiche

Questa implementazione fornisce un sistema completo di gestione appuntamenti multi-tenant specifico per il settore sanitario, con tre livelli di accesso distinti e funzionalità appropriate per ogni tipo di utente. 

> **Nota di prevenzione:**
> L'enum AppointmentType deve essere sempre posizionato in `Modules/SaluteOra/app/Enums/AppointmentType.php` e importato con il namespace corretto. Aggiornare sempre la documentazione e i file .mdc windsurf/cursor in caso di modifica del path.

## Policy di Centralizzazione Configurazione FullCalendar

La configurazione del calendario FullCalendar DEVE essere centralizzata nel metodo `config()` del widget custom che estende `FullCalendarWidget`.

- **Vietato** usare metodi fluenti come `->config()` su FullCalendarWidget::make().
- **Obbligatorio** override del metodo `config(): array` nel widget custom.
- Tutte le opzioni (headerToolbar, initialView, slotDuration, ecc.) vanno definite in `config()`.

### Esempio corretto
```php
class DoctorAvailabilityCalendarWidget extends FullCalendarWidget
{
    public function config(): array
    {
        return [
            'headerToolbar' => [...],
            'initialView' => 'timeGridWeek',
            // ...altre opzioni
        ];
    }
}
```

### Motivazione filosofica, politica, zen
- Un solo punto di verità: configurazione centralizzata, nessuna duplicazione
- DRY, KISS, serenità del codice
- Refactoring sicuro, massima estendibilità
