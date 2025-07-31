# Componenti Calendar per Tema One

## Panoramica

Il tema One include due componenti calendar per l'integrazione di FullCalendar nel frontend:

1. **`calendar.blade.php`** - Componente base con eventi statici
2. **`calendar-dynamic.blade.php`** - Componente avanzato con caricamento dinamico

Entrambi i componenti sono ottimizzati per il settore sanitario e seguono le best practices di SaluteOra.

## Componente Calendar Base

### Utilizzo

```blade
<x-pub_theme::components.blocks.calendar
    :title="'I miei appuntamenti'"
    :subtitle="'Visualizza i tuoi prossimi appuntamenti'"
    :events="$events"
    :view="'timeGridWeek'"
    :height="'600px'"
    :showLegend="true"
    :showWeekends="true"
    :editable="false"
    :selectable="false"
/>
```

### Parametri

| Parametro | Tipo | Default | Descrizione |
|-----------|------|---------|-------------|
| `title` | string | 'Calendario Appuntamenti' | Titolo del calendario |
| `subtitle` | string | 'I tuoi appuntamenti programmati' | Sottotitolo |
| `events` | array | [] | Array di eventi |
| `view` | string | 'timeGridWeek' | Vista iniziale |
| `height` | string | '600px' | Altezza del calendario |
| `showLegend` | boolean | true | Mostra legenda colori |
| `showWeekends` | boolean | true | Mostra weekend |
| `editable` | boolean | false | Eventi modificabili |
| `selectable` | boolean | false | Selezione slot temporali |
| `businessHours` | array | null | Orari di lavoro |
| `locale` | string | 'it' | Localizzazione |
| `timezone` | string | 'Europe/Rome' | Fuso orario |

### Formato Eventi

```php
$events = [
    [
        'id' => 1,
        'title' => 'Visita Cardiologica',
        'start' => '2024-05-25T10:30:00',
        'end' => '2024-05-25T11:30:00',
        'backgroundColor' => '#3788d8',
        'borderColor' => '#2563eb',
        'textColor' => '#ffffff',
        'extendedProps' => [
            'doctor_name' => 'Dr. Rossi',
            'patient_name' => 'Mario Bianchi',
            'type' => 'consultation',
            'status' => 'confirmed',
            'emergency' => false,
            'tooltip' => 'Visita cardiologica di controllo',
            'can_edit' => false,
        ]
    ],
    // Altri eventi...
];
```

### Esempio Completo

```blade
@php
$appointments = [
    [
        'id' => 1,
        'title' => 'Controllo Prenatale',
        'start' => '2024-05-25T10:30:00',
        'end' => '2024-05-25T11:30:00',
        'backgroundColor' => '#3b82f6',
        'textColor' => '#ffffff',
        'extendedProps' => [
            'doctor_name' => 'Dr. Rossi',
            'type' => 'consultation',
            'status' => 'confirmed',
            'emergency' => false,
            'tooltip' => 'Controllo prenatale di routine'
        ]
    ],
    [
        'id' => 2,
        'title' => 'Igiene Orale',
        'start' => '2024-06-01T15:00:00',
        'end' => '2024-06-01T16:00:00',
        'backgroundColor' => '#10b981',
        'textColor' => '#ffffff',
        'extendedProps' => [
            'doctor_name' => 'Dr. Bianchi',
            'type' => 'cleaning',
            'status' => 'scheduled',
            'emergency' => false,
            'tooltip' => 'Pulizia dentale professionale'
        ]
    ]
];

$businessHours = [
    'daysOfWeek' => [1, 2, 3, 4, 5], // Lun-Ven
    'startTime' => '09:00',
    'endTime' => '18:00',
];
@endphp

<x-pub_theme::components.blocks.calendar
    :title="'Calendario Pazienti'"
    :subtitle="'I tuoi prossimi appuntamenti medici'"
    :events="$appointments"
    :view="'timeGridWeek'"
    :height="'700px'"
    :showLegend="true"
    :showWeekends="false"
    :businessHours="$businessHours"
    :editable="false"
    :selectable="false"
/>
```

## Componente Calendar Dinamico

### Utilizzo

```blade
<x-pub_theme::components.blocks.calendar-dynamic
    :title="'Calendario Dinamico'"
    :subtitle="'Appuntamenti in tempo reale'"
    :apiEndpoint="'/api/appointments'"
    :userType="'patient'"
    :studioId="auth()->user()->studio_id"
    :refreshInterval="300000"
    :enableRealtime="true"
/>
```

### Parametri Aggiuntivi

| Parametro | Tipo | Default | Descrizione |
|-----------|------|---------|-------------|
| `apiEndpoint` | string | '/api/appointments' | Endpoint API per eventi |
| `refreshInterval` | integer | 300000 | Intervallo auto-refresh (ms) |
| `enableRealtime` | boolean | false | Aggiornamenti real-time |
| `userType` | string | null | Tipo utente (patient/doctor/admin) |
| `studioId` | string | null | ID studio per multi-tenancy |

### Endpoint API

L'endpoint API deve restituire eventi nel formato FullCalendar:

```php
// AppointmentController.php
public function index(Request $request)
{
    $start = $request->get('start');
    $end = $request->get('end');
    $userType = $request->get('user_type');
    $studioId = $request->get('studio_id');
    
    $query = Appointment::query()
        ->whereBetween('start_time', [$start, $end])
        ->with(['patient', 'doctor', 'studio']);
    
    // Filtri per tipo utente
    if ($userType === 'patient') {
        $query->where('patient_id', auth()->id());
    } elseif ($userType === 'doctor') {
        $query->where('studio_id', $studioId);
    }
    
    $appointments = $query->get();
    
    return $appointments->map(function ($appointment) {
        return [
            'id' => $appointment->id,
            'title' => $appointment->title,
            'start' => $appointment->start_time->toISOString(),
            'end' => $appointment->end_time->toISOString(),
            'backgroundColor' => $this->getStatusColor($appointment->status),
            'borderColor' => $this->getTypeColor($appointment->type),
            'textColor' => '#ffffff',
            'extendedProps' => [
                'doctor_name' => $appointment->doctor?->full_name,
                'patient_name' => $appointment->patient?->full_name,
                'type' => $appointment->type->value,
                'status' => $appointment->status->value,
                'emergency' => $appointment->emergency,
                'tooltip' => $this->formatTooltip($appointment),
                'can_edit' => $this->canEdit($appointment),
            ]
        ];
    });
}
```

### Esempio con Laravel Echo

```blade
@push('scripts')
<script>
// Configurazione Laravel Echo per real-time
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '{{ config('broadcasting.connections.pusher.key') }}',
    cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
    forceTLS: true
});
</script>
@endpush

<x-pub_theme::components.blocks.calendar-dynamic
    :title="'Calendario Real-time'"
    :apiEndpoint="'/api/appointments'"
    :enableRealtime="true"
    :refreshInterval="0"
/>
```

## Configurazione nel CMS

### Utilizzo in Folio/CMS

```json
{
    "type": "calendar",
    "data": {
        "view": "pub_theme::components.blocks.calendar",
        "title": "Calendario",
        "subtitle": "I tuoi appuntamenti programmati",
        "events": [
            {
                "title": "Controllo Prenatale",
                "start": "2024-05-25T10:30:00",
                "end": "2024-05-25T11:30:00",
                "backgroundColor": "#3788d8",
                "textColor": "#ffffff"
            }
        ]
    }
}
```

### Configurazione Dinamica

```json
{
    "type": "calendar_dynamic",
    "data": {
        "view": "pub_theme::components.blocks.calendar-dynamic",
        "title": "Calendario Dinamico",
        "subtitle": "Appuntamenti in tempo reale",
        "apiEndpoint": "/api/appointments",
        "userType": "patient",
        "refreshInterval": 300000,
        "enableRealtime": true
    }
}
```

## Personalizzazione

### Colori Personalizzati

```php
// Nel controller o service
private function getStatusColor($status): string
{
    return match($status) {
        AppointmentStatus::SCHEDULED => '#3b82f6',
        AppointmentStatus::CONFIRMED => '#10b981',
        AppointmentStatus::CANCELLED => '#ef4444',
        AppointmentStatus::COMPLETED => '#8b5cf6',
        AppointmentStatus::NO_SHOW => '#f59e0b',
        default => '#6b7280',
    };
}

private function getTypeColor($type): string
{
    return match($type) {
        AppointmentType::CONSULTATION => '#1e40af',
        AppointmentType::TREATMENT => '#059669',
        AppointmentType::EMERGENCY => '#dc2626',
        AppointmentType::SURGERY => '#b91c1c',
        default => '#374151',
    };
}
```

### CSS Personalizzato

```css
/* Personalizzazione tema calendario */
.calendar-container {
    --primary-color: #667eea;
    --success-color: #10b981;
    --warning-color: #f59e0b;
    --danger-color: #ef4444;
}

/* Eventi personalizzati */
.fc-event.consultation {
    background: var(--primary-color) !important;
}

.fc-event.emergency {
    background: var(--danger-color) !important;
    animation: pulse 2s infinite;
}

/* Responsive personalizzato */
@media (max-width: 640px) {
    .calendar-container {
        margin: 0 -1rem;
        border-radius: 0;
    }
}
```

## Integrazione con Filament

### Widget Filament

```php
// PatientCalendarWidget.php
class PatientCalendarWidget extends Widget
{
    protected static string $view = 'pub_theme::components.blocks.calendar-dynamic';
    
    protected function getViewData(): array
    {
        return [
            'title' => 'I miei appuntamenti',
            'apiEndpoint' => route('api.appointments.index'),
            'userType' => 'patient',
            'refreshInterval' => 300000,
            'enableRealtime' => true,
        ];
    }
}
```

### Middleware di Sicurezza

```php
// EnsureCalendarAccess.php
class EnsureCalendarAccess
{
    public function handle($request, Closure $next, $userType = null)
    {
        if ($userType && auth()->user()->type !== $userType) {
            abort(403, 'Accesso non autorizzato al calendario');
        }
        
        return $next($request);
    }
}
```

## Best Practices

### Performance

1. **Limitare gli eventi**: Max 100 eventi per chiamata
2. **Caching**: Utilizzare cache per eventi frequenti
3. **Lazy loading**: Caricare eventi solo quando necessario
4. **Debouncing**: Limitare le chiamate API

### Sicurezza

1. **Validazione input**: Validare sempre i parametri
2. **Autorizzazione**: Verificare permessi utente
3. **Sanitizzazione**: Pulire i dati prima della visualizzazione
4. **Rate limiting**: Limitare le chiamate API

### UX/UI

1. **Loading states**: Mostrare indicatori di caricamento
2. **Error handling**: Gestire errori gracefully
3. **Responsive**: Ottimizzare per mobile
4. **Accessibilità**: Supportare screen reader

### Manutenibilità

1. **Documentazione**: Documentare configurazioni
2. **Testing**: Testare componenti isolatamente
3. **Versioning**: Gestire versioni API
4. **Monitoring**: Monitorare performance

## Troubleshooting

### Problemi Comuni

1. **Eventi non caricati**: Verificare endpoint API
2. **Errori CORS**: Configurare headers corretti
3. **Performance lente**: Ottimizzare query database
4. **Layout rotto**: Verificare CSS conflicts

### Debug

```javascript
// Debug calendario
console.log('Calendar instance:', window.calendar_[ID]);
console.log('Events loaded:', calendar.getEvents());
console.log('Current view:', calendar.view.type);
```

### Log Laravel

```php
// Nel controller
Log::info('Calendar events requested', [
    'user_id' => auth()->id(),
    'start' => $request->get('start'),
    'end' => $request->get('end'),
    'events_count' => $appointments->count()
]);
``` 
