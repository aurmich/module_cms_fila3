# Appointment System Implementation

## Database Structure

### Appointments Table Migration
```php
Schema::create('appointments', function (Blueprint $table) {
    $table->id();
    $table->foreignId('doctor_id')->constrained('users');
    $table->foreignId('patient_id')->constrained('users');
    $table->string('title');
    $table->text('description')->nullable();
    $table->dateTime('start_time');
    $table->dateTime('end_time');
    $table->string('status')->default('scheduled');
    $table->string('type');
    $table->text('notes')->nullable();
    $table->timestamps();
    $table->softDeletes();
});
```

## Models and Relationships

### Appointment Model
```php
namespace Modules\SaluteOra\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'doctor_id',
        'patient_id',
        'title',
        'description',
        'start_time',
        'end_time',
        'status',
        'type',
        'notes',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
}
```

## Filament Resources

### Appointment Resource
```php
namespace Modules\SaluteOra\Filament\Resources;

use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Modules\SaluteOra\Filament\Resources\AppointmentResource\Pages;
use Modules\SaluteOra\Models\Appointment;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;
    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('doctor_id')
                    ->relationship('doctor', 'name')
                    ->required(),
                Forms\Components\Select::make('patient_id')
                    ->relationship('patient', 'name')
                    ->required(),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('start_time')
                    ->required(),
                Forms\Components\DateTimePicker::make('end_time')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'scheduled' => 'Scheduled',
                        'confirmed' => 'Confirmed',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535),
                Forms\Components\Textarea::make('notes')
                    ->maxLength(65535),
            ]);
    }
}
```

## Calendar Widget Implementation

### Calendar Widget with Real Data
```php
namespace Modules\SaluteOra\Filament\Widgets;

use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;
use Modules\SaluteOra\Models\Appointment;

class AppointmentCalendar extends \Saade\FilamentFullCalendar\Widgets\FullCalendarWidget
{
    protected static string $view = 'saluteora::widgets.appointment-calendar';
    
    protected static ?string $heading = 'Appointment Calendar';
    
    public function fetchEvents(array $fetchInfo): array
    {
        return Appointment::query()
            ->where('start_time', '>=', $fetchInfo['start'])
            ->where('end_time', '<=', $fetchInfo['end'])
            ->get()
            ->map(function (Appointment $appointment) {
                return [
                    'id' => $appointment->id,
                    'title' => $appointment->title,
                    'start' => $appointment->start_time,
                    'end' => $appointment->end_time,
                    'url' => route('filament.resources.appointments.edit', $appointment),
                    'shouldOpenUrlInNewTab' => true,
                    'backgroundColor' => $this->getStatusColor($appointment->status),
                    'borderColor' => $this->getStatusColor($appointment->status),
                    'extendedProps' => [
                        'status' => $appointment->status,
                        'doctor' => $appointment->doctor->name,
                        'patient' => $appointment->patient->name,
                    ],
                ];
            })
            ->toArray();
    }
    
    protected function getStatusColor(string $status): string
    {
        return match($status) {
            'scheduled' => '#3b82f6', // blue-500
            'confirmed' => '#10b981',  // emerald-500
            'completed' => '#6b7280',  // gray-500
            'cancelled' => '#ef4444', // red-500
            default => '#9ca3af',     // gray-400
        };
    }
}
```

### Custom Calendar View
Create `resources/views/vendor/filament/widgets/appointment-calendar.blade.php`:

```php
<x-filament-widgets::widget>
    <x-filament::card>
        <div 
            x-data="calendar({
                events: $wire.entangle('events').defer,
                initialView: 'timeGridWeek',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                eventDidMount: function(info) {
                    // Add tooltip
                    tippy(info.el, {
                        content: `
                            <div class="p-2">
                                <div class="font-bold">${info.event.title}</div>
                                <div>Doctor: ${info.event.extendedProps.doctor}</div>
                                <div>Patient: ${info.event.extendedProps.patient}</div>
                                <div>Status: ${info.event.extendedProps.status}</div>
                            </div>
                        `,
                        allowHTML: true,
                        theme: 'light',
                    });
                },
                eventClick: function(info) {
                    info.jsEvent.preventDefault();
                    if (info.event.url) {
                        window.open(info.event.url, '_blank');
                    }
                },
                dateClick: function(info) {
                    window.livewire.emit('createAppointment', info.dateStr);
                },
                eventDrop: function(info) {
                    // Handle event drop
                    window.livewire.emit('eventDrop', {
                        id: info.event.id,
                        start: info.event.start,
                        end: info.event.end,
                    });
                },
            })"
            wire:ignore
            class="fi-wi-stats-overview-stats-container"
        >
            <div id='calendar'></div>
        </div>
    </x-filament::card>
</x-filament-widgets::widget>
```

## Event Handling

### Create Appointment Action
```php
namespace Modules\SaluteOra\Filament\Resources\AppointmentResource\Pages;

use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Modules\SaluteOra\Filament\Resources\AppointmentResource;
use Modules\SaluteOra\Models\Appointment;

class ListAppointments extends ListRecords
{
    protected static string $resource = AppointmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('create')
                ->label('New Appointment')
                ->url(route('filament.admin.resources.appointments.create')),
            \Filament\Actions\Action::make('calendar')
                ->label('Calendar View')
                ->url(route('filament.admin.pages.calendar')),
        ];
    }
}
```

## Testing the Implementation

### Feature Test Example
```php
namespace Tests\Feature\Appointments;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\SaluteOra\Models\Appointment;
use Tests\TestCase;

class AppointmentCalendarTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_calendar()
    {
        $this->actingAs($this->createUser());
        
        $response = $this->get(route('filament.admin.pages.calendar'));
        
        $response->assertStatus(200);
    }
    
    public function test_can_fetch_events()
    {
        $user = $this->createUser();
        $this->actingAs($user);
        
        $appointment = Appointment::factory()->create([
            'doctor_id' => $user->id,
            'start_time' => now(),
            'end_time' => now()->addHour(),
        ]);
        
        $response = $this->post(route('filament.api.resources.appointments.fetch'), [
            'start' => now()->subDays(7)->toIsoString(),
            'end' => now()->addDays(7)->toIsoString(),
        ]);
        
        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment(['id' => $appointment->id]);
    }
}
```

## Performance Optimization

1. **Eager Loading**
   ```php
   // In your widget
   public function fetchEvents(array $fetchInfo): array
   {
       return Appointment::with(['doctor', 'patient'])
           ->where('start_time', '>=', $fetchInfo['start'])
           ->where('end_time', '<=', $fetchInfo['end'])
           ->get()
           ->map(function ($appointment) {
               // ...
           });
   }
   ```

2. **Caching**
   ```php
   use Illuminate\Support\Facades\Cache;
   
   public function fetchEvents(array $fetchInfo): array
   {
       $cacheKey = 'appointments-' . md5(json_encode($fetchInfo));
       
       return Cache::remember($cacheKey, now()->addHour(), function () use ($fetchInfo) {
           return Appointment::with(['doctor', 'patient'])
               ->where('start_time', '>=', $fetchInfo['start'])
               ->where('end_time', '<=', $fetchInfo['end'])
               ->get()
               ->map(function ($appointment) {
                   // ...
               });
       });
   }
   ```

## Security Considerations

1. **Authorization**
   - Implement policies to control access to calendar data
   - Filter events based on user roles and permissions
   - Validate all user inputs

2. **Rate Limiting**
   ```php
   // In your route service provider
   RateLimiter::for('api', function (Request $request) {
       return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
   });
   ```

## Deployment

1. **Assets**
   ```bash
   npm install
   npm run build
   php artisan optimize
   ```

2. **Cache Clearing**
   ```bash
   php artisan config:clear
   php artisan view:clear
   php artisan cache:clear
   ```

## Monitoring

1. **Logging**
   ```php
   // In your widget
   public function fetchEvents(array $fetchInfo): array
   {
       \Log::info('Fetching calendar events', [
           'start' => $fetchInfo['start'],
           'end' => $fetchInfo['end'],
           'user_id' => auth()->id(),
       ]);
       
       // ... rest of the method
   }
   ```

## Future Enhancements

1. **Recurring Appointments**
   - Implement RRULE for recurring events
   - Add exceptions to recurring series
   - Handle timezone conversions

2. **Calendar Subscriptions**
   - iCal feed for external calendar integration
   - Google Calendar sync
   - Outlook integration

3. **Reminders and Notifications**
   - Email reminders
   - SMS notifications
   - In-app notifications

4. **Advanced Views**
   - Timeline view
   - Resource timeline view
   - Custom views for different user roles

## Path corretto per AppointmentType:
## Modules/SaluteOra/app/Enums/AppointmentType.php
use Modules\SaluteOra\App\Enums\AppointmentType;

> **Nota di prevenzione:**
> L'enum AppointmentType deve essere sempre posizionato in `Modules/SaluteOra/app/Enums/AppointmentType.php` e importato con il namespace corretto. Aggiornare sempre la documentazione e i file .mdc windsurf/cursor in caso di modifica del path.
