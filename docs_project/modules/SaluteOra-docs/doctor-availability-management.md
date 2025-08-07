# Gestione Disponibilità Dottori con Tenancy

## Introduzione

Il sistema di gestione della disponibilità dei dottori in SaluteOra utilizza un approccio multi-tenant dove ogni studio (tenant) può gestire le disponibilità dei propri dottori in modo indipendente.

## Architettura

### Multi-Tenancy
- **Studio come Tenant**: Ogni studio è un tenant separato
- **Dottori per Studio**: I dottori appartengono a specifici studi
- **Disponibilità per Studio**: Le disponibilità sono specifiche per studio-dottore
- **Isolamento Dati**: Completa separazione dei dati tra studi diversi

### Modelli Coinvolti

#### DoctorStudio (Pivot)
```php
class DoctorStudio extends BasePivot
{
    protected $fillable = [
        'doctor_id',
        'studio_id', 
        'availability', // JSON con orari settimanali
        'is_active',
        'start_date',
        'end_date'
    ];

    protected function casts(): array
    {
        return [
            'availability' => 'array',
            'is_active' => 'boolean',
            'start_date' => 'date',
            'end_date' => 'date'
        ];
    }
}
```

#### Struttura Availability
```php
[
    'monday' => [
        'morning' => '08:00-12:30',
        'afternoon' => '15:00-19:00'
    ],
    'tuesday' => [
        'morning' => '08:00-12:30', 
        'afternoon' => null // Pomeriggio chiuso
    ],
    // ... altri giorni della settimana
]
```

## DoctorAvailabilityPage

### Caratteristiche Principali

1. **Context-Aware**: Utilizza il tenant corrente (studio)
2. **Filament Integration**: Form Filament con OpeningHoursField
3. **Real-time Validation**: Validazione in tempo reale degli orari
4. **User Experience**: Interface intuitiva per la gestione orari

### Implementazione

```php
/**
 * DoctorAvailabilityPage
 *
 * Pagina Filament per permettere ai dottori di gestire le proprie disponibilità
 * presso uno studio specifico nel contesto multi-tenant.
 * 
 * ⚠️ IMPORTANTE: Non ridichiarare mai HasForms o InteractsWithForms
 * perché sono già forniti da XotBasePage (ERRORE GRAVE!)
 */
class DoctorAvailabilityPage extends XotBasePage
{
    // ✅ CORRETTO: Nessuna ridichiarazione di HasForms o InteractsWithForms
    
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static string $view = 'saluteora::filament.pages.doctor-availability';
    
    public array $data = [];
    
    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label(__('saluteora::doctor_availability.actions.save'))
                ->action('save')
                ->color('success')
                ->icon('heroicon-o-check'),
        ];
    }
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                OpeningHoursField::make('schedule')
                    ->label(__('saluteora::doctor_availability.sections.weekly_availability'))
                    ->helperText(__('saluteora::doctor_availability.fields.is_available.help'))
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }
}
```

### Tenancy Integration

```php
class DoctorAvailabilityPage extends XotBasePage
{
    protected function getCurrentDoctor(): User
    {
        return auth()->user();
    }
    
    protected function getCurrentStudio(): Studio
    {
        return Filament::getTenant();
    }
    
    protected function getDoctorStudioPivot(): ?DoctorStudio
    {
        return DoctorStudio::where([
            'doctor_id' => $this->getCurrentDoctor()->id,
            'studio_id' => $this->getCurrentStudio()->id,
        ])->first();
    }
}
```

## Controllo Accessi

### Policy
```php
class DoctorAvailabilityPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['doctor', 'admin']);
    }
    
    public function update(User $user, DoctorStudio $doctorStudio): bool
    {
        // Il dottore può modificare solo la propria disponibilità
        if ($user->hasRole('doctor')) {
            return $user->id === $doctorStudio->doctor_id;
        }
        
        // L'admin può modificare la disponibilità di tutti i dottori del suo studio
        return $user->hasRole('admin') && 
               $user->currentStudio->id === $doctorStudio->studio_id;
    }
}
```

### Middleware
```php
class EnsureDoctorBelongsToStudio
{
    public function handle(Request $request, Closure $next): Response
    {
        $studio = Filament::getTenant();
        $doctor = auth()->user();
        
        if (!$doctor->studios()->where('studio_id', $studio->id)->exists()) {
            abort(403, 'Accesso negato: dottore non appartiene a questo studio');
        }
        
        return $next($request);
    }
}
```

## Validazione Avanzata

### Regole Business
```php
class AvailabilityValidator
{
    public static function rules(): array
    {
        return [
            'availability.*.morning' => [
                'nullable',
                'regex:/^\d{2}:\d{2}-\d{2}:\d{2}$/',
                function ($attribute, $value, $fail) {
                    if ($value && !self::isValidTimeRange($value)) {
                        $fail('Orario non valido: l\'ora di apertura deve essere precedente alla chiusura');
                    }
                },
            ],
            'availability.*.afternoon' => [
                'nullable', 
                'regex:/^\d{2}:\d{2}-\d{2}:\d{2}$/',
                function ($attribute, $value, $fail) {
                    if ($value && !self::isValidTimeRange($value)) {
                        $fail('Orario non valido: l\'ora di apertura deve essere precedente alla chiusura');
                    }
                },
            ],
        ];
    }
    
    private static function isValidTimeRange(string $timeRange): bool
    {
        [$start, $end] = explode('-', $timeRange);
        return Carbon::createFromFormat('H:i', $start) < Carbon::createFromFormat('H:i', $end);
    }
}
```

### Controllo Sovrapposizioni
```php
class AvailabilityOverlapValidator
{
    public static function validateNoOverlaps(array $availability, User $doctor, Studio $studio): bool
    {
        foreach ($availability as $day => $hours) {
            if (!empty($hours['morning']) && !empty($hours['afternoon'])) {
                if (self::timesOverlap($hours['morning'], $hours['afternoon'])) {
                    return false;
                }
            }
        }
        
        return true;
    }
    
    private static function timesOverlap(string $range1, string $range2): bool
    {
        [$start1, $end1] = explode('-', $range1);
        [$start2, $end2] = explode('-', $range2);
        
        $start1 = Carbon::createFromFormat('H:i', $start1);
        $end1 = Carbon::createFromFormat('H:i', $end1);
        $start2 = Carbon::createFromFormat('H:i', $start2);
        $end2 = Carbon::createFromFormat('H:i', $end2);
        
        return $start1 < $end2 && $end1 > $start2;
    }
}
```

## Integrazione con Calendar

### Visualizzazione nel FullCalendar
```php
class DoctorAvailabilityWidget extends FullCalendarWidget
{
    public function fetchEvents(array $fetchInfo): array
    {
        $doctor = auth()->user();
        $studio = Filament::getTenant();
        
        $pivot = DoctorStudio::where([
            'doctor_id' => $doctor->id,
            'studio_id' => $studio->id,
        ])->first();
        
        if (!$pivot || !$pivot->availability) {
            return [];
        }
        
        return $this->generateAvailabilitySlots($pivot->availability, $fetchInfo);
    }
    
    private function generateAvailabilitySlots(array $availability, array $fetchInfo): array
    {
        $events = [];
        $start = Carbon::parse($fetchInfo['start']);
        $end = Carbon::parse($fetchInfo['end']);
        
        for ($date = $start->copy(); $date <= $end; $date->addDay()) {
            $dayKey = strtolower($date->format('l'));
            
            if (isset($availability[$dayKey])) {
                $dayAvailability = $availability[$dayKey];
                
                // Slot mattutino
                if (!empty($dayAvailability['morning'])) {
                    $events[] = $this->createSlotEvent($date, $dayAvailability['morning'], 'Disponibile - Mattina');
                }
                
                // Slot pomeridiano  
                if (!empty($dayAvailability['afternoon'])) {
                    $events[] = $this->createSlotEvent($date, $dayAvailability['afternoon'], 'Disponibile - Pomeriggio');
                }
            }
        }
        
        return $events;
    }
}
```

## Notifications

### Notifiche Cambi Disponibilità
```php
class AvailabilityChangedNotification extends Notification
{
    public function __construct(
        private DoctorStudio $doctorStudio,
        private array $oldAvailability,
        private array $newAvailability
    ) {}
    
    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }
    
    public function toArray($notifiable): array
    {
        return [
            'title' => 'Disponibilità Modificata',
            'message' => "Il Dr. {$this->doctorStudio->doctor->name} ha modificato la propria disponibilità",
            'studio_id' => $this->doctorStudio->studio_id,
            'doctor_id' => $this->doctorStudio->doctor_id,
            'changes' => $this->calculateChanges(),
        ];
    }
}
```

## Testing

### Test Unit
```php
class DoctorAvailabilityTest extends TestCase
{
    /** @test */
    public function doctor_can_set_availability_for_their_studio(): void
    {
        $studio = Studio::factory()->create();
        $doctor = User::factory()->doctor()->create();
        
        $doctor->studios()->attach($studio);
        
        $this->actingAs($doctor)
             ->post(route('filament.pages.doctor-availability.save'), [
                 'availability' => [
                     'monday' => [
                         'morning' => '08:00-12:00',
                         'afternoon' => '14:00-18:00'
                     ]
                 ]
             ])
             ->assertSuccessful();
             
        $this->assertDatabaseHas('doctor_studio', [
            'doctor_id' => $doctor->id,
            'studio_id' => $studio->id,
            'availability->monday->morning' => '08:00-12:00'
        ]);
    }
}
```

## Sicurezza

### Considerazioni di Sicurezza
1. **Validazione Input**: Sempre validare gli orari inseriti
2. **Controllo Accessi**: Verificare che il dottore appartenga allo studio
3. **Audit Log**: Tracciare tutte le modifiche alle disponibilità
4. **Rate Limiting**: Limitare le modifiche frequenti

### Audit Trail
```php
class AvailabilityAuditLog extends Model
{
    protected $fillable = [
        'doctor_id',
        'studio_id', 
        'old_availability',
        'new_availability',
        'changed_by',
        'change_reason',
        'ip_address'
    ];
    
    protected function casts(): array
    {
        return [
            'old_availability' => 'array',
            'new_availability' => 'array'
        ];
    }
}
```

## Collegamenti

- [UI: OpeningHoursField Component](../../UI/docs/components/opening-hours-field.md)
- [Opening Hours Detailed Documentation](opening-hours-filament-field.md)
- [FullCalendar Implementation](fullcalendar_implementation_guide.md)
- [Multi-Tenancy Documentation](../../Tenant/docs/README.md)

---

*Ultimo aggiornamento: Dicembre 2024* 