# Widget FullCalendar per SaluteOra

## Panoramica

Questo documento descrive i widget FullCalendar specifici per il modulo SaluteOra, fornendo esempi pratici e implementazioni per diversi casi d'uso nel settore sanitario.

## Collegamenti Correlati

- [Integrazione FullCalendar](fullcalendar_integration.md) - Guida principale all'integrazione
- [Filament Best Practices](filament_best_practices.md) - Best practices per Filament
- [Widget Guidelines](../Xot/docs/filament/widgets.md) - Linee guida generali per i widget

## Widget Base FullCalendarWidget

### Struttura Base

Tutti i widget calendar devono estendere `FullCalendarWidget` del plugin Saade:

```php
<?php

namespace Modules\SaluteOra\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class MyCalendarWidget extends FullCalendarWidget
{
    // Implementazione specifica
}
```

### Proprietà Comuni

```php
class MyCalendarWidget extends FullCalendarWidget
{
    // Modello associato al widget
    public Model|string|null $model = MyModel::class;
    
    // Ordinamento del widget nella dashboard
    protected static ?int $sort = 1;
    
    // Altezza massima del widget
    protected static ?string $maxHeight = '600px';
    
    // Titolo del widget (opzionale, gestito dalle traduzioni)
    protected static ?string $heading = null;
    
    // Numero di colonne occupate
    protected int|string|array $columnSpan = 'full';
}
```

## Widget per Appuntamenti Medici

### AppointmentCalendarWidget

Widget principale per la gestione degli appuntamenti:

```php
<?php

namespace Modules\SaluteOra\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Modules\SaluteOra\Models\Appointment;
use Modules\SaluteOra\Enums\AppointmentStatus;
use Modules\SaluteOra\App\Enums\AppointmentType;
use Saade\FilamentFullCalendar\Data\EventData;
use Filament\Forms;

class AppointmentCalendarWidget extends FullCalendarWidget
{
    public Model|string|null $model = Appointment::class;

    protected static ?int $sort = 1;

    public function fetchEvents(array $fetchInfo): array
    {
        return Appointment::query()
            ->whereBetween('start_time', [$fetchInfo['start'], $fetchInfo['end']])
            ->with(['patient:id,first_name,last_name', 'doctor:id,first_name,last_name'])
            ->get()
            ->map(fn (Appointment $appointment) => $this->transformAppointmentToEvent($appointment))
            ->toArray();
    }

    private function transformAppointmentToEvent(Appointment $appointment): array
    {
        return EventData::make()
            ->id($appointment->id)
            ->title($this->formatEventTitle($appointment))
            ->start($appointment->start_time)
            ->end($appointment->end_time)
            ->backgroundColor($this->getStatusColor($appointment->status))
            ->borderColor($this->getTypeColor($appointment->type))
            ->textColor('#ffffff')
            ->extendedProps([
                'patient_name' => $appointment->patient?->full_name,
                'doctor_name' => $appointment->doctor?->full_name,
                'status' => $appointment->status->value,
                'type' => $appointment->type->value,
                'duration' => $appointment->duration,
            ])
            ->toArray();
    }

    public function getFormSchema(): array
    {
        return [
            'basic_info' => Forms\Components\Section::make()
                ->schema([
                    'title' => Forms\Components\TextInput::make('title')
                        ->required()
                        ->maxLength(255),
                    
                    'description' => Forms\Components\Textarea::make('description')
                        ->rows(3),
                ]),

            'participants' => Forms\Components\Section::make()
                ->schema([
                    'patient_id' => Forms\Components\Select::make('patient_id')
                        ->relationship('patient', 'full_name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    
                    'doctor_id' => Forms\Components\Select::make('doctor_id')
                        ->relationship('doctor', 'full_name')
                        ->searchable()
                        ->preload()
                        ->required(),
                ]),

            'scheduling' => Forms\Components\Section::make()
                ->schema([
                    'timing_grid' => Forms\Components\Grid::make(2)
                        ->schema([
                            'start_time' => Forms\Components\DateTimePicker::make('start_time')
                                ->required()
                                ->seconds(false),
                            
                            'end_time' => Forms\Components\DateTimePicker::make('end_time')
                                ->required()
                                ->seconds(false)
                                ->after('start_time'),
                        ]),
                    
                    'details_grid' => Forms\Components\Grid::make(3)
                        ->schema([
                            'type' => Forms\Components\Select::make('type')
                                ->options(AppointmentType::class)
                                ->required(),
                            
                            'status' => Forms\Components\Select::make('status')
                                ->options(AppointmentStatus::class)
                                ->default(AppointmentStatus::SCHEDULED)
                                ->required(),
                            
                            'duration' => Forms\Components\TextInput::make('duration')
                                ->numeric()
                                ->suffix('min')
                                ->helperText('Durata in minuti'),
                        ]),
                ]),
        ];
    }

    public function config(): array
    {
        return [
            'initialView' => 'timeGridWeek',
            'headerToolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'dayGridMonth,timeGridWeek,timeGridDay',
            ],
            'slotMinTime' => '08:00:00',
            'slotMaxTime' => '20:00:00',
            'slotDuration' => '00:15:00',
            'businessHours' => $this->getBusinessHours(),
            'eventConstraint' => 'businessHours',
            'selectConstraint' => 'businessHours',
            'eventOverlap' => false,
            'selectOverlap' => false,
            'height' => 'auto',
            'aspectRatio' => 1.35,
        ];
    }

    private function getBusinessHours(): array
    {
        return [
            'daysOfWeek' => [1, 2, 3, 4, 5], // Lunedì-Venerdì
            'startTime' => '09:00',
            'endTime' => '18:00',
        ];
    }

    private function formatEventTitle(Appointment $appointment): string
    {
        return sprintf(
            '%s - %s',
            $appointment->patient?->full_name ?? 'Paziente',
            $appointment->title
        );
    }

    private function getStatusColor(AppointmentStatus $status): string
    {
        return match ($status) {
            AppointmentStatus::SCHEDULED => '#3b82f6',
            AppointmentStatus::CONFIRMED => '#10b981',
            AppointmentStatus::CANCELLED => '#ef4444',
            AppointmentStatus::COMPLETED => '#8b5cf6',
            AppointmentStatus::NO_SHOW => '#f59e0b',
            default => '#6b7280',
        };
    }

    private function getTypeColor(AppointmentType $type): string
    {
        return match ($type) {
            AppointmentType::CONSULTATION => '#1e40af',
            AppointmentType::TREATMENT => '#059669',
            AppointmentType::FOLLOW_UP => '#7c3aed',
            AppointmentType::EMERGENCY => '#dc2626',
            default => '#374151',
        };
    }
}
```

## Widget per Disponibilità Medici

### DoctorAvailabilityWidget

Widget per visualizzare e gestire la disponibilità dei medici:

```php
<?php

namespace Modules\SaluteOra\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Modules\SaluteOra\Models\DoctorAvailability;
use Saade\FilamentFullCalendar\Data\EventData;
use Filament\Forms;

class DoctorAvailabilityWidget extends FullCalendarWidget
{
    public Model|string|null $model = DoctorAvailability::class;

    protected static ?int $sort = 2;

    public function fetchEvents(array $fetchInfo): array
    {
        return DoctorAvailability::query()
            ->whereBetween('start_time', [$fetchInfo['start'], $fetchInfo['end']])
            ->with('doctor:id,first_name,last_name')
            ->get()
            ->map(function (DoctorAvailability $availability) {
                return EventData::make()
                    ->id($availability->id)
                    ->title("Dr. {$availability->doctor->full_name}")
                    ->start($availability->start_time)
                    ->end($availability->end_time)
                    ->backgroundColor($availability->is_available ? '#dcfce7' : '#fef2f2')
                    ->borderColor($availability->is_available ? '#16a34a' : '#dc2626')
                    ->textColor($availability->is_available ? '#15803d' : '#b91c1c')
                    ->display('background')
                    ->extendedProps([
                        'doctor_id' => $availability->doctor_id,
                        'is_available' => $availability->is_available,
                        'notes' => $availability->notes,
                    ]);
            })
            ->toArray();
    }

    public function getFormSchema(): array
    {
        return [
            'doctor_section' => Forms\Components\Section::make()
                ->schema([
                    'doctor_id' => Forms\Components\Select::make('doctor_id')
                        ->relationship('doctor', 'full_name')
                        ->searchable()
                        ->preload()
                        ->required(),
                ]),

            'availability_section' => Forms\Components\Section::make()
                ->schema([
                    'timing_grid' => Forms\Components\Grid::make(2)
                        ->schema([
                            'start_time' => Forms\Components\DateTimePicker::make('start_time')
                                ->required()
                                ->seconds(false),
                            
                            'end_time' => Forms\Components\DateTimePicker::make('end_time')
                                ->required()
                                ->seconds(false)
                                ->after('start_time'),
                        ]),
                    
                    'is_available' => Forms\Components\Toggle::make('is_available')
                        ->default(true),
                    
                    'notes' => Forms\Components\Textarea::make('notes')
                        ->rows(2),
                ]),
        ];
    }

    public function config(): array
    {
        return [
            'initialView' => 'timeGridWeek',
            'headerToolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'timeGridWeek,timeGridDay',
            ],
            'slotMinTime' => '08:00:00',
            'slotMaxTime' => '20:00:00',
            'allDaySlot' => false,
            'height' => 500,
        ];
    }
}
```

## Widget per Sale Operatorie

### OperatingRoomWidget

Widget per la gestione delle sale operatorie:

```php
<?php

namespace Modules\SaluteOra\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Modules\SaluteOra\Models\Surgery;
use Modules\SaluteOra\Enums\SurgeryStatus;
use Saade\FilamentFullCalendar\Data\EventData;
use Filament\Forms;

class OperatingRoomWidget extends FullCalendarWidget
{
    public Model|string|null $model = Surgery::class;

    protected static ?int $sort = 3;

    public function fetchEvents(array $fetchInfo): array
    {
        return Surgery::query()
            ->whereBetween('scheduled_at', [$fetchInfo['start'], $fetchInfo['end']])
            ->with(['patient:id,first_name,last_name', 'surgeon:id,first_name,last_name', 'operatingRoom'])
            ->get()
            ->map(function (Surgery $surgery) {
                return EventData::make()
                    ->id($surgery->id)
                    ->title($this->formatSurgeryTitle($surgery))
                    ->start($surgery->scheduled_at)
                    ->end($surgery->scheduled_at->addMinutes($surgery->estimated_duration))
                    ->backgroundColor($this->getSurgeryStatusColor($surgery->status))
                    ->borderColor('#1f2937')
                    ->textColor('#ffffff')
                    ->resourceId($surgery->operating_room_id)
                    ->extendedProps([
                        'patient_name' => $surgery->patient?->full_name,
                        'surgeon_name' => $surgery->surgeon?->full_name,
                        'room_name' => $surgery->operatingRoom?->name,
                        'procedure' => $surgery->procedure,
                        'status' => $surgery->status->value,
                        'duration' => $surgery->estimated_duration,
                    ]);
            })
            ->toArray();
    }

    public function getFormSchema(): array
    {
        return [
            'surgery_details' => Forms\Components\Section::make()
                ->schema([
                    'procedure' => Forms\Components\TextInput::make('procedure')
                        ->required()
                        ->maxLength(255),
                    
                    'description' => Forms\Components\Textarea::make('description')
                        ->rows(3),
                ]),

            'participants' => Forms\Components\Section::make()
                ->schema([
                    'patient_id' => Forms\Components\Select::make('patient_id')
                        ->relationship('patient', 'full_name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    
                    'surgeon_id' => Forms\Components\Select::make('surgeon_id')
                        ->relationship('surgeon', 'full_name')
                        ->searchable()
                        ->preload()
                        ->required(),
                ]),

            'scheduling' => Forms\Components\Section::make()
                ->schema([
                    'operating_room_id' => Forms\Components\Select::make('operating_room_id')
                        ->relationship('operatingRoom', 'name')
                        ->required(),
                    
                    'timing_grid' => Forms\Components\Grid::make(2)
                        ->schema([
                            'scheduled_at' => Forms\Components\DateTimePicker::make('scheduled_at')
                                ->required()
                                ->seconds(false),
                            
                            'estimated_duration' => Forms\Components\TextInput::make('estimated_duration')
                                ->numeric()
                                ->suffix('min')
                                ->required(),
                        ]),
                    
                    'status' => Forms\Components\Select::make('status')
                        ->options(SurgeryStatus::class)
                        ->default(SurgeryStatus::SCHEDULED)
                        ->required(),
                ]),
        ];
    }

    public function config(): array
    {
        return [
            'initialView' => 'resourceTimelineDay',
            'headerToolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'resourceTimelineDay,resourceTimelineWeek',
            ],
            'resources' => $this->getOperatingRooms(),
            'slotMinTime' => '06:00:00',
            'slotMaxTime' => '22:00:00',
            'slotDuration' => '00:30:00',
            'height' => 600,
            'resourceAreaWidth' => '15%',
        ];
    }

    private function getOperatingRooms(): array
    {
        return \Modules\SaluteOra\Models\OperatingRoom::all()
            ->map(fn ($room) => [
                'id' => $room->id,
                'title' => $room->name,
                'extendedProps' => [
                    'capacity' => $room->capacity,
                    'equipment' => $room->equipment,
                ],
            ])
            ->toArray();
    }

    private function formatSurgeryTitle(Surgery $surgery): string
    {
        return sprintf(
            '%s - %s',
            $surgery->patient?->full_name ?? 'Paziente',
            $surgery->procedure
        );
    }

    private function getSurgeryStatusColor(SurgeryStatus $status): string
    {
        return match ($status) {
            SurgeryStatus::SCHEDULED => '#3b82f6',
            SurgeryStatus::IN_PROGRESS => '#f59e0b',
            SurgeryStatus::COMPLETED => '#10b981',
            SurgeryStatus::CANCELLED => '#ef4444',
            SurgeryStatus::POSTPONED => '#8b5cf6',
            default => '#6b7280',
        };
    }
}
```

## Widget per Emergenze

### EmergencyCalendarWidget

Widget specializzato per la gestione delle emergenze:

```php
<?php

namespace Modules\SaluteOra\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Modules\SaluteOra\Models\Emergency;
use Modules\SaluteOra\Enums\EmergencyPriority;
use Modules\SaluteOra\Enums\EmergencyStatus;
use Saade\FilamentFullCalendar\Data\EventData;

class EmergencyCalendarWidget extends FullCalendarWidget
{
    public Model|string|null $model = Emergency::class;

    protected static ?int $sort = 4;

    public function fetchEvents(array $fetchInfo): array
    {
        return Emergency::query()
            ->whereBetween('created_at', [$fetchInfo['start'], $fetchInfo['end']])
            ->with(['patient:id,first_name,last_name', 'assignedDoctor:id,first_name,last_name'])
            ->get()
            ->map(function (Emergency $emergency) {
                return EventData::make()
                    ->id($emergency->id)
                    ->title($this->formatEmergencyTitle($emergency))
                    ->start($emergency->created_at)
                    ->end($emergency->resolved_at ?? $emergency->created_at->addHours(2))
                    ->backgroundColor($this->getPriorityColor($emergency->priority))
                    ->borderColor($this->getStatusBorderColor($emergency->status))
                    ->textColor('#ffffff')
                    ->extendedProps([
                        'patient_name' => $emergency->patient?->full_name,
                        'doctor_name' => $emergency->assignedDoctor?->full_name,
                        'priority' => $emergency->priority->value,
                        'status' => $emergency->status->value,
                        'triage_code' => $emergency->triage_code,
                        'chief_complaint' => $emergency->chief_complaint,
                    ]);
            })
            ->toArray();
    }

    public function config(): array
    {
        return [
            'initialView' => 'listDay',
            'headerToolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'listDay,listWeek,timeGridDay',
            ],
            'height' => 400,
            'eventOrder' => 'priority,start',
        ];
    }

    private function formatEmergencyTitle(Emergency $emergency): string
    {
        return sprintf(
            '[%s] %s - %s',
            $emergency->triage_code,
            $emergency->patient?->full_name ?? 'Paziente',
            $emergency->chief_complaint
        );
    }

    private function getPriorityColor(EmergencyPriority $priority): string
    {
        return match ($priority) {
            EmergencyPriority::CRITICAL => '#dc2626',
            EmergencyPriority::HIGH => '#ea580c',
            EmergencyPriority::MEDIUM => '#d97706',
            EmergencyPriority::LOW => '#65a30d',
            default => '#6b7280',
        };
    }

    private function getStatusBorderColor(EmergencyStatus $status): string
    {
        return match ($status) {
            EmergencyStatus::WAITING => '#f59e0b',
            EmergencyStatus::IN_TREATMENT => '#3b82f6',
            EmergencyStatus::RESOLVED => '#10b981',
            EmergencyStatus::TRANSFERRED => '#8b5cf6',
            default => '#6b7280',
        };
    }

    public function eventDidMount(): string
    {
        return <<<JS
            function({ event, el }) {
                // Aggiungi icone di priorità
                const priority = event.extendedProps.priority;
                const icon = document.createElement('i');
                
                switch(priority) {
                    case 'critical':
                        icon.className = 'fas fa-exclamation-triangle text-red-500';
                        break;
                    case 'high':
                        icon.className = 'fas fa-exclamation text-orange-500';
                        break;
                    case 'medium':
                        icon.className = 'fas fa-info-circle text-yellow-500';
                        break;
                    case 'low':
                        icon.className = 'fas fa-check-circle text-green-500';
                        break;
                }
                
                icon.style.marginRight = '5px';
                el.querySelector('.fc-list-event-title').prepend(icon);
                
                // Aggiungi tooltip con dettagli
                el.setAttribute('title', 
                    'Paziente: ' + (event.extendedProps.patient_name || 'N/A') + '\\n' +
                    'Medico: ' + (event.extendedProps.doctor_name || 'Non assegnato') + '\\n' +
                    'Priorità: ' + priority + '\\n' +
                    'Stato: ' + event.extendedProps.status
                );
            }
        JS;
    }
}
```

## Widget Personalizzati per Specializzazioni

### DentalAppointmentWidget

Widget specifico per appuntamenti dentistici:

```php
<?php

namespace Modules\SaluteOra\Filament\Widgets;

use Modules\SaluteOra\Filament\Widgets\AppointmentCalendarWidget;
use Modules\SaluteOra\Models\DentalAppointment;
use Modules\SaluteOra\Enums\DentalProcedureType;

class DentalAppointmentWidget extends AppointmentCalendarWidget
{
    public Model|string|null $model = DentalAppointment::class;

    protected static ?string $heading = 'Appuntamenti Dentistici';

    public function fetchEvents(array $fetchInfo): array
    {
        return DentalAppointment::query()
            ->whereBetween('start_time', [$fetchInfo['start'], $fetchInfo['end']])
            ->with(['patient:id,first_name,last_name', 'dentist:id,first_name,last_name', 'dentalChair'])
            ->get()
            ->map(function (DentalAppointment $appointment) {
                return EventData::make()
                    ->id($appointment->id)
                    ->title($this->formatDentalTitle($appointment))
                    ->start($appointment->start_time)
                    ->end($appointment->end_time)
                    ->backgroundColor($this->getDentalProcedureColor($appointment->procedure_type))
                    ->resourceId($appointment->dental_chair_id)
                    ->extendedProps([
                        'patient_name' => $appointment->patient?->full_name,
                        'dentist_name' => $appointment->dentist?->full_name,
                        'chair_name' => $appointment->dentalChair?->name,
                        'procedure_type' => $appointment->procedure_type->value,
                        'tooth_number' => $appointment->tooth_number,
                        'notes' => $appointment->notes,
                    ]);
            })
            ->toArray();
    }

    public function config(): array
    {
        return array_merge(parent::config(), [
            'initialView' => 'resourceTimeGridDay',
            'resources' => $this->getDentalChairs(),
            'resourceAreaWidth' => '20%',
        ]);
    }

    private function getDentalChairs(): array
    {
        return \Modules\SaluteOra\Models\DentalChair::all()
            ->map(fn ($chair) => [
                'id' => $chair->id,
                'title' => $chair->name,
                'extendedProps' => [
                    'equipment' => $chair->equipment,
                    'location' => $chair->location,
                ],
            ])
            ->toArray();
    }

    private function formatDentalTitle(DentalAppointment $appointment): string
    {
        return sprintf(
            '%s - %s%s',
            $appointment->patient?->full_name ?? 'Paziente',
            $appointment->procedure_type->getLabel(),
            $appointment->tooth_number ? " (#{$appointment->tooth_number})" : ''
        );
    }

    private function getDentalProcedureColor(DentalProcedureType $type): string
    {
        return match ($type) {
            DentalProcedureType::CLEANING => '#10b981',
            DentalProcedureType::FILLING => '#3b82f6',
            DentalProcedureType::EXTRACTION => '#ef4444',
            DentalProcedureType::ROOT_CANAL => '#8b5cf6',
            DentalProcedureType::CROWN => '#f59e0b',
            DentalProcedureType::IMPLANT => '#06b6d4',
            default => '#6b7280',
        };
    }
}
```

## Best Practices per Widget

### Performance

1. **Eager Loading**: Sempre utilizzare `with()` per le relazioni
2. **Caching**: Implementare cache per eventi frequentemente richiesti
3. **Paginazione**: Per grandi dataset, utilizzare lazy loading

### Sicurezza

1. **Autorizzazioni**: Implementare `canView()` per controllo accessi
2. **Filtri**: Filtrare eventi basati sui permessi utente
3. **Validazione**: Validare sempre i dati in input

### Usabilità

1. **Colori Consistenti**: Utilizzare schema colori coerente
2. **Tooltip Informativi**: Fornire informazioni aggiuntive nei tooltip
3. **Icone Descrittive**: Utilizzare icone per identificare rapidamente i tipi

### Manutenibilità

1. **Metodi Privati**: Estrarre logica complessa in metodi privati
2. **Configurazione Centralizzata**: Utilizzare file di configurazione per impostazioni comuni
3. **Documentazione**: Documentare configurazioni personalizzate

## Conclusioni

I widget FullCalendar per SaluteOra forniscono una base solida per la gestione di calendari sanitari. Seguendo i pattern e le best practices documentate, è possibile creare widget performanti, sicuri e facilmente estendibili per qualsiasi esigenza specifica del settore sanitario.

## Vedi Anche

- [Integrazione FullCalendar](fullcalendar_integration.md)
- [Documentazione FullCalendar](https://fullcalendar.io/docs)
- [Plugin Saade](https://filamentphp.com/plugins/saade-fullcalendar)
- [Filament Widgets](https://filamentphp.com/docs/3.x/panels/widgets)

> **Nota di prevenzione:**
> L'enum AppointmentType deve essere sempre posizionato in `Modules/SaluteOra/app/Enums/AppointmentType.php` e importato con il namespace corretto. Aggiornare sempre la documentazione e i file .mdc windsurf/cursor in caso di modifica del path.

## [AGGIORNAMENTO 2024-06-XX] - Disponibilità solo su appointments

**Regola fondamentale:**
- Le disponibilità dei dottori vanno gestite solo tramite la tabella `appointments` (con `type` = `AVAILABILITY`).
- È vietato creare tabelle o modelli separati (es. doctor_availabilities) per le disponibilità.
- Tutto il calendario (FullCalendar/Filament) lavora su appointments, distinguendo tra disponibilità e appuntamenti tramite i campi esistenti.

**Motivazione:**
- Filosofia: un solo punto di verità, nessuna duplicazione, serenità del codice.
- Logica: DRY, KISS, nessun lock-in, massima compatibilità con FullCalendar e Filament.
- Religione: "Non avrai altro modello all'infuori di appointments".
- Politica: centralizzazione, audit trail, refactoring sicuro.
- Zen: serenità nella manutenzione.

**Checklist:**
- [x] Nessun modello/tabella separata per disponibilità
- [x] Tutte le query calendar filtrano per type
- [x] Documentazione aggiornata
- [x] Colori e icone diverse per disponibilità

**Collegamenti:**
- [appointment-management.md](appointment-management.md)
- [calendar/doctor-availability-management.md](calendar/doctor-availability-management.md)
- [fullcalendar_parental_widgets.md](fullcalendar_parental_widgets.md)

## Collegamenti

- [Indice e link FullCalendar root](../../../../docs/fullcalendar_widgets_and_tenancy.mdc)
- [Regole generali FullCalendar/Xot](../../../Xot/docs/filament_widget_regole.md)
- [Stub: fullcalendar-implementation.md](./fullcalendar-implementation.md)
- [Stub: fullcalendar-correct-implementation.md](./fullcalendar-correct-implementation.md)
- [Stub: fullcalendar-implementation-guide.md](./fullcalendar-implementation-guide.md)
