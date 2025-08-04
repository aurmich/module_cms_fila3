# Configurazione FullCalendar per SaluteOra

## Panoramica

Questo documento descrive la configurazione completa di FullCalendar per il progetto SaluteOra, incluse le impostazioni specifiche per l'ambiente sanitario italiano e le personalizzazioni per la gestione degli appuntamenti odontoiatrici.

## File di Configurazione

### 1. Configurazione Principale

Creare il file `config/saluteora.php`:

```php
<?php

return [
    /*
    |--------------------------------------------------------------------------
    | FullCalendar Configuration
    |--------------------------------------------------------------------------
    |
    | Configurazione specifica per FullCalendar nel progetto SaluteOra.
    | Queste impostazioni sono ottimizzate per l'ambiente sanitario italiano.
    |
    */
    'fullcalendar' => [
        /*
        |--------------------------------------------------------------------------
        | License Key
        |--------------------------------------------------------------------------
        |
        | Chiave di licenza per le funzionalità premium di FullCalendar.
        | Necessaria per funzionalità come Resource Timeline View.
        |
        */
        'license_key' => env('FULLCALENDAR_LICENSE_KEY'),

        /*
        |--------------------------------------------------------------------------
        | Default View
        |--------------------------------------------------------------------------
        |
        | Vista predefinita del calendario. Ottimizzata per la gestione
        | degli appuntamenti settimanali.
        |
        */
        'default_view' => env('FULLCALENDAR_DEFAULT_VIEW', 'timeGridWeek'),

        /*
        |--------------------------------------------------------------------------
        | Business Hours
        |--------------------------------------------------------------------------
        |
        | Orari di lavoro standard per le cliniche odontoiatriche.
        | Configurabile per ogni clinica specifica.
        |
        */
        'business_hours' => [
            'start' => env('FULLCALENDAR_BUSINESS_START', '08:00'),
            'end' => env('FULLCALENDAR_BUSINESS_END', '18:00'),
            'days' => [1, 2, 3, 4, 5], // Lunedì-Venerdì
        ],

        /*
        |--------------------------------------------------------------------------
        | Slot Configuration
        |--------------------------------------------------------------------------
        |
        | Configurazione degli slot temporali per gli appuntamenti.
        | Durata standard di 15 minuti per massima flessibilità.
        |
        */
        'slot_duration' => env('FULLCALENDAR_SLOT_DURATION', '00:15:00'),
        'snap_duration' => env('FULLCALENDAR_SNAP_DURATION', '00:15:00'),
        'min_time' => env('FULLCALENDAR_MIN_TIME', '07:00:00'),
        'max_time' => env('FULLCALENDAR_MAX_TIME', '20:00:00'),

        /*
        |--------------------------------------------------------------------------
        | Localization
        |--------------------------------------------------------------------------
        |
        | Impostazioni di localizzazione per l'Italia.
        |
        */
        'locale' => 'it',
        'timezone' => 'Europe/Rome',
        'first_day' => 1, // Lunedì come primo giorno della settimana

        /*
        |--------------------------------------------------------------------------
        | Appearance
        |--------------------------------------------------------------------------
        |
        | Configurazioni per l'aspetto del calendario.
        |
        */
        'height' => env('FULLCALENDAR_HEIGHT', 'auto'),
        'aspect_ratio' => env('FULLCALENDAR_ASPECT_RATIO', 1.8),
        'theme' => env('FULLCALENDAR_THEME', 'saluteora'),

        /*
        |--------------------------------------------------------------------------
        | Interaction
        |--------------------------------------------------------------------------
        |
        | Configurazioni per l'interazione utente.
        |
        */
        'selectable' => true,
        'editable' => true,
        'event_resizable' => true,
        'event_draggable' => true,
        'select_mirror' => true,

        /*
        |--------------------------------------------------------------------------
        | Performance
        |--------------------------------------------------------------------------
        |
        | Configurazioni per ottimizzare le performance.
        |
        */
        'lazy_fetching' => true,
        'event_limit' => env('FULLCALENDAR_EVENT_LIMIT', 100),
        'cache_duration' => env('FULLCALENDAR_CACHE_DURATION', 300), // 5 minuti

        /*
        |--------------------------------------------------------------------------
        | Security
        |--------------------------------------------------------------------------
        |
        | Configurazioni di sicurezza per la protezione dei dati.
        |
        */
        'sanitize_html' => true,
        'escape_html' => true,
        'max_events_per_request' => 500,

        /*
        |--------------------------------------------------------------------------
        | Appointment Types Colors
        |--------------------------------------------------------------------------
        |
        | Colori standard per i diversi tipi di appuntamento.
        |
        */
        'colors' => [
            'scheduled' => '#3b82f6',    // Blu
            'confirmed' => '#10b981',    // Verde
            'in_progress' => '#f59e0b',  // Ambra
            'completed' => '#059669',    // Verde smeraldo
            'cancelled' => '#ef4444',    // Rosso
            'no_show' => '#6b7280',      // Grigio
            'emergency' => '#dc2626',    // Rosso scuro
            'follow_up' => '#8b5cf6',    // Viola
            'consultation' => '#06b6d4', // Ciano
            'treatment' => '#84cc16',    // Verde lime
        ],

        /*
        |--------------------------------------------------------------------------
        | Toolbar Configuration
        |--------------------------------------------------------------------------
        |
        | Configurazione della toolbar del calendario.
        |
        */
        'header_toolbar' => [
            'left' => 'prev,next today',
            'center' => 'title',
            'right' => 'dayGridMonth,timeGridWeek,timeGridDay,listWeek',
        ],

        /*
        |--------------------------------------------------------------------------
        | Mobile Configuration
        |--------------------------------------------------------------------------
        |
        | Configurazioni specifiche per dispositivi mobili.
        |
        */
        'mobile' => [
            'default_view' => 'listWeek',
            'header_toolbar' => [
                'left' => 'prev,next',
                'center' => 'title',
                'right' => 'today',
            ],
            'height' => 400,
        ],

        /*
        |--------------------------------------------------------------------------
        | Plugins
        |--------------------------------------------------------------------------
        |
        | Plugin FullCalendar da caricare.
        |
        */
        'plugins' => [
            'dayGrid',
            'timeGrid',
            'list',
            'interaction',
            'rrule', // Per eventi ricorrenti
        ],

        /*
        |--------------------------------------------------------------------------
        | Custom CSS Classes
        |--------------------------------------------------------------------------
        |
        | Classi CSS personalizzate per il tema SaluteOra.
        |
        */
        'css_classes' => [
            'calendar' => 'fc-saluteora-theme',
            'event' => 'fc-event-saluteora',
            'urgent' => 'fc-event-urgent',
            'pregnancy' => 'fc-event-pregnancy',
            'emergency' => 'fc-event-emergency',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Widget Defaults
    |--------------------------------------------------------------------------
    |
    | Configurazioni predefinite per i widget FullCalendar.
    |
    */
    'widget_defaults' => [
        'appointment_calendar' => [
            'sort' => 1,
            'max_width' => 'full',
            'height' => 600,
            'can_create' => true,
            'can_edit' => true,
            'can_delete' => true,
        ],
        'availability_calendar' => [
            'sort' => 2,
            'max_width' => 'full',
            'height' => 500,
            'initial_view' => 'timeGridWeek',
            'can_create' => true,
            'can_edit' => true,
        ],
        'patient_calendar' => [
            'sort' => 1,
            'max_width' => 'full',
            'height' => 400,
            'initial_view' => 'dayGridMonth',
            'can_create' => false,
            'can_edit' => false,
            'can_delete' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Settings
    |--------------------------------------------------------------------------
    |
    | Configurazioni per le notifiche degli appuntamenti.
    |
    */
    'notifications' => [
        'reminder_hours' => [24, 2], // Promemoria a 24h e 2h prima
        'auto_confirm_hours' => 48,  // Auto-conferma dopo 48h
        'cancellation_deadline_hours' => 24, // Deadline per cancellazione
    ],

    /*
    |--------------------------------------------------------------------------
    | Integration Settings
    |--------------------------------------------------------------------------
    |
    | Configurazioni per integrazioni esterne.
    |
    */
    'integrations' => [
        'google_calendar' => [
            'enabled' => env('GOOGLE_CALENDAR_ENABLED', false),
            'client_id' => env('GOOGLE_CALENDAR_CLIENT_ID'),
            'client_secret' => env('GOOGLE_CALENDAR_CLIENT_SECRET'),
        ],
        'outlook_calendar' => [
            'enabled' => env('OUTLOOK_CALENDAR_ENABLED', false),
            'client_id' => env('OUTLOOK_CALENDAR_CLIENT_ID'),
            'client_secret' => env('OUTLOOK_CALENDAR_CLIENT_SECRET'),
        ],
    ],
];
```

### 2. Variabili d'Ambiente

Aggiungere al file `.env`:

```env

# FullCalendar Configuration
FULLCALENDAR_LICENSE_KEY=your_license_key_here
FULLCALENDAR_DEFAULT_VIEW=timeGridWeek
FULLCALENDAR_BUSINESS_START=08:00
FULLCALENDAR_BUSINESS_END=18:00
FULLCALENDAR_SLOT_DURATION=00:15:00
FULLCALENDAR_SNAP_DURATION=00:15:00
FULLCALENDAR_MIN_TIME=07:00:00
FULLCALENDAR_MAX_TIME=20:00:00
FULLCALENDAR_HEIGHT=auto
FULLCALENDAR_ASPECT_RATIO=1.8
FULLCALENDAR_THEME=saluteora
FULLCALENDAR_EVENT_LIMIT=100
FULLCALENDAR_CACHE_DURATION=300

# External Calendar Integrations
GOOGLE_CALENDAR_ENABLED=false
GOOGLE_CALENDAR_CLIENT_ID=
GOOGLE_CALENDAR_CLIENT_SECRET=
OUTLOOK_CALENDAR_ENABLED=false
OUTLOOK_CALENDAR_CLIENT_ID=
OUTLOOK_CALENDAR_CLIENT_SECRET=
```

## Configurazione Plugin Filament

### 1. AdminPanelProvider

```php
<?php

namespace Modules\SaluteOra\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('saluteora')
            ->path('saluteora')
            ->plugin(
                FilamentFullCalendarPlugin::make()
                    ->schedulerLicenseKey(config('saluteora.fullcalendar.license_key'))
                    ->selectable(config('saluteora.fullcalendar.selectable'))
                    ->editable(config('saluteora.fullcalendar.editable'))
                    ->timezone(config('saluteora.fullcalendar.timezone'))
                    ->locale(config('saluteora.fullcalendar.locale'))
                    ->plugins(config('saluteora.fullcalendar.plugins'))
                    ->config($this->getFullCalendarConfig())
            );
    }

    private function getFullCalendarConfig(): array
    {
        $config = config('saluteora.fullcalendar');
        
        return [
            'firstDay' => $config['first_day'],
            'headerToolbar' => $config['header_toolbar'],
            'height' => $config['height'],
            'aspectRatio' => $config['aspect_ratio'],
            'businessHours' => [
                'daysOfWeek' => $config['business_hours']['days'],
                'startTime' => $config['business_hours']['start'],
                'endTime' => $config['business_hours']['end'],
            ],
            'slotMinTime' => $config['min_time'],
            'slotMaxTime' => $config['max_time'],
            'slotDuration' => $config['slot_duration'],
            'snapDuration' => $config['snap_duration'],
            'allDaySlot' => false,
            'nowIndicator' => true,
            'selectable' => $config['selectable'],
            'selectMirror' => $config['select_mirror'],
            'editable' => $config['editable'],
            'eventResizableFromStart' => $config['event_resizable'],
            'eventDurationEditable' => $config['event_resizable'],
            'eventStartEditable' => $config['event_draggable'],
            'eventConstraint' => 'businessHours',
            'selectConstraint' => 'businessHours',
            'eventOverlap' => false,
            'selectOverlap' => false,
            'eventDisplay' => 'block',
            'dayMaxEvents' => true,
            'moreLinkClick' => 'popover',
            'eventTimeFormat' => [
                'hour' => '2-digit',
                'minute' => '2-digit',
                'hour12' => false,
            ],
            'slotLabelFormat' => [
                'hour' => '2-digit',
                'minute' => '2-digit',
                'hour12' => false,
            ],
            'buttonText' => [
                'today' => __('saluteora::calendar.today'),
                'month' => __('saluteora::calendar.month'),
                'week' => __('saluteora::calendar.week'),
                'day' => __('saluteora::calendar.day'),
                'list' => __('saluteora::calendar.list'),
            ],
            'noEventsText' => __('saluteora::calendar.no_events'),
            'allDayText' => __('saluteora::calendar.all_day'),
            'moreLinkText' => function($num) {
                return __('saluteora::calendar.more_events', ['count' => $num]);
            },
        ];
    }
}
```

## Configurazione CSS Personalizzata

### 1. File CSS Principale

Creare `resources/css/fullcalendar-saluteora.css`:

```css
/* FullCalendar SaluteOra Theme */
.fc-saluteora-theme {
    --fc-border-color: #e5e7eb;
    --fc-button-bg-color: #3b82f6;
    --fc-button-border-color: #3b82f6;
    --fc-button-hover-bg-color: #2563eb;
    --fc-button-active-bg-color: #1d4ed8;
    --fc-today-bg-color: rgba(59, 130, 246, 0.1);
    --fc-event-bg-color: #3b82f6;
    --fc-event-border-color: #2563eb;
    --fc-event-text-color: #ffffff;
}

/* Eventi per stato appuntamento */
.fc-event-saluteora-scheduled {
    background-color: #3b82f6 !important;
    border-color: #2563eb !important;
}

.fc-event-saluteora-confirmed {
    background-color: #10b981 !important;
    border-color: #059669 !important;
}

.fc-event-saluteora-in-progress {
    background-color: #f59e0b !important;
    border-color: #d97706 !important;
}

.fc-event-saluteora-completed {
    background-color: #059669 !important;
    border-color: #047857 !important;
}

.fc-event-saluteora-cancelled {
    background-color: #ef4444 !important;
    border-color: #dc2626 !important;
    text-decoration: line-through;
    opacity: 0.7;
}

.fc-event-saluteora-no-show {
    background-color: #6b7280 !important;
    border-color: #4b5563 !important;
    opacity: 0.8;
}

/* Eventi speciali */
.fc-event-urgent {
    animation: pulse 2s infinite;
    border: 2px solid #ef4444 !important;
    box-shadow: 0 0 10px rgba(239, 68, 68, 0.5);
}

.fc-event-pregnancy {
    background: linear-gradient(45deg, #ec4899, #f97316) !important;
    border-color: #ec4899 !important;
}

.fc-event-emergency {
    background-color: #dc2626 !important;
    border-color: #991b1b !important;
    animation: blink 1s infinite;
}

/* Animazioni */
@keyframes pulse {
    0%, 100% { 
        opacity: 1; 
        transform: scale(1);
    }
    50% { 
        opacity: 0.8; 
        transform: scale(1.02);
    }
}

@keyframes blink {
    0%, 50% { opacity: 1; }
    51%, 100% { opacity: 0.7; }
}

/* Responsive design */
@media (max-width: 768px) {
    .fc-saluteora-theme .fc-toolbar {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .fc-saluteora-theme .fc-toolbar-chunk {
        display: flex;
        justify-content: center;
    }
    
    .fc-saluteora-theme .fc-event {
        font-size: 0.75rem;
        padding: 1px 2px;
    }
}

/* Accessibilità */
.fc-event:focus {
    outline: 2px solid #3b82f6;
    outline-offset: 2px;
}

.fc-event[aria-selected="true"] {
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
}

/* Tooltip personalizzati */
.fc-event-tooltip {
    background-color: rgba(0, 0, 0, 0.9);
    color: white;
    padding: 8px 12px;
    border-radius: 6px;
    font-size: 0.875rem;
    max-width: 250px;
    z-index: 9999;
}

/* Disponibilità dentisti */
.fc-event-availability {
    background-color: rgba(16, 185, 129, 0.2) !important;
    border-color: #10b981 !important;
    color: #065f46 !important;
}

/* Slot non disponibili */
.fc-slot-unavailable {
    background-color: rgba(239, 68, 68, 0.1);
    pointer-events: none;
}

/* Orari di lavoro evidenziati */
.fc-non-business {
    background-color: rgba(107, 114, 128, 0.05);
}

/* Personalizzazione pulsanti */
.fc-saluteora-theme .fc-button-primary {
    background-color: #3b82f6;
    border-color: #3b82f6;
    color: white;
    font-weight: 500;
    border-radius: 6px;
    padding: 0.375rem 0.75rem;
    transition: all 0.2s ease-in-out;
}

.fc-saluteora-theme .fc-button-primary:hover {
    background-color: #2563eb;
    border-color: #2563eb;
    transform: translateY(-1px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.fc-saluteora-theme .fc-button-primary:active {
    background-color: #1d4ed8;
    border-color: #1d4ed8;
    transform: translateY(0);
}

/* Personalizzazione header */
.fc-saluteora-theme .fc-toolbar-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #1f2937;
}

/* Grid personalizzata */
.fc-saluteora-theme .fc-col-header-cell {
    background-color: #f9fafb;
    border-color: #e5e7eb;
    font-weight: 600;
    color: #374151;
}

.fc-saluteora-theme .fc-daygrid-day-number {
    color: #6b7280;
    font-weight: 500;
}

.fc-saluteora-theme .fc-day-today .fc-daygrid-day-number {
    color: #3b82f6;
    font-weight: 700;
}

/* Loading state */
.fc-saluteora-theme.fc-loading {
    position: relative;
}

.fc-saluteora-theme.fc-loading::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(255, 255, 255, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 999;
}

.fc-saluteora-theme.fc-loading::before {
    content: 'Caricamento...';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1000;
    color: #6b7280;
    font-weight: 500;
}
```

## File di Traduzione

### 1. Traduzioni Italiane

Creare `lang/it/calendar.php`:

```php
<?php

return [
    // Navigazione
    'today' => 'Oggi',
    'prev' => 'Precedente',
    'next' => 'Successivo',
    
    // Viste
    'month' => 'Mese',
    'week' => 'Settimana',
    'day' => 'Giorno',
    'list' => 'Lista',
    
    // Eventi
    'event' => 'Evento',
    'events' => 'Eventi',
    'no_events' => 'Nessun appuntamento da visualizzare',
    'all_day' => 'Tutto il giorno',
    'more_events' => '+:count altri',
    
    // Azioni
    'create_event' => 'Crea Appuntamento',
    'edit_event' => 'Modifica Appuntamento',
    'delete_event' => 'Elimina Appuntamento',
    'view_event' => 'Visualizza Appuntamento',
    
    // Stati appuntamento
    'status' => [
        'scheduled' => 'Programmato',
        'confirmed' => 'Confermato',
        'in_progress' => 'In corso',
        'completed' => 'Completato',
        'cancelled' => 'Annullato',
        'no_show' => 'Assente',
    ],
    
    // Tipi appuntamento
    'type' => [
        'consultation' => 'Consulenza',
        'treatment' => 'Trattamento',
        'follow_up' => 'Controllo',
        'emergency' => 'Emergenza',
        'cleaning' => 'Pulizia',
        'surgery' => 'Intervento',
    ],
    
    // Messaggi
    'appointment_created' => 'Appuntamento creato con successo',
    'appointment_updated' => 'Appuntamento aggiornato con successo',
    'appointment_deleted' => 'Appuntamento eliminato con successo',
    'appointment_confirmed' => 'Appuntamento confermato',
    'appointment_cancelled' => 'Appuntamento annullato',
    
    // Errori
    'error_loading_events' => 'Errore nel caricamento degli eventi',
    'error_saving_event' => 'Errore nel salvataggio dell\'evento',
    'error_deleting_event' => 'Errore nell\'eliminazione dell\'evento',
    'slot_not_available' => 'Slot non disponibile',
    'outside_business_hours' => 'Fuori dall\'orario di lavoro',
    
    // Tooltip
    'patient' => 'Paziente',
    'dentist' => 'Dentista',
    'clinic' => 'Clinica',
    'duration' => 'Durata',
    'notes' => 'Note',
    'status' => 'Stato',
    'type' => 'Tipo',
    
    // Conferme
    'confirm_delete' => 'Sei sicuro di voler eliminare questo appuntamento?',
    'confirm_cancel' => 'Sei sicuro di voler annullare questo appuntamento?',
    
    // Validazione
    'validation' => [
        'start_required' => 'La data di inizio è obbligatoria',
        'end_required' => 'La data di fine è obbligatoria',
        'end_after_start' => 'La data di fine deve essere successiva a quella di inizio',
        'patient_required' => 'Il paziente è obbligatorio',
        'dentist_required' => 'Il dentista è obbligatorio',
        'title_required' => 'Il titolo è obbligatorio',
    ],
];
```

### 2. Traduzioni Inglesi

Creare `lang/en/calendar.php`:

```php
<?php

return [
    // Navigation
    'today' => 'Today',
    'prev' => 'Previous',
    'next' => 'Next',
    
    // Views
    'month' => 'Month',
    'week' => 'Week',
    'day' => 'Day',
    'list' => 'List',
    
    // Events
    'event' => 'Event',
    'events' => 'Events',
    'no_events' => 'No appointments to display',
    'all_day' => 'All day',
    'more_events' => '+:count more',
    
    // Actions
    'create_event' => 'Create Appointment',
    'edit_event' => 'Edit Appointment',
    'delete_event' => 'Delete Appointment',
    'view_event' => 'View Appointment',
    
    // Appointment statuses
    'status' => [
        'scheduled' => 'Scheduled',
        'confirmed' => 'Confirmed',
        'in_progress' => 'In Progress',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
        'no_show' => 'No Show',
    ],
    
    // Appointment types
    'type' => [
        'consultation' => 'Consultation',
        'treatment' => 'Treatment',
        'follow_up' => 'Follow-up',
        'emergency' => 'Emergency',
        'cleaning' => 'Cleaning',
        'surgery' => 'Surgery',
    ],
    
    // Messages
    'appointment_created' => 'Appointment created successfully',
    'appointment_updated' => 'Appointment updated successfully',
    'appointment_deleted' => 'Appointment deleted successfully',
    'appointment_confirmed' => 'Appointment confirmed',
    'appointment_cancelled' => 'Appointment cancelled',
    
    // Errors
    'error_loading_events' => 'Error loading events',
    'error_saving_event' => 'Error saving event',
    'error_deleting_event' => 'Error deleting event',
    'slot_not_available' => 'Slot not available',
    'outside_business_hours' => 'Outside business hours',
    
    // Tooltip
    'patient' => 'Patient',
    'dentist' => 'Dentist',
    'clinic' => 'Clinic',
    'duration' => 'Duration',
    'notes' => 'Notes',
    'status' => 'Status',
    'type' => 'Type',
    
    // Confirmations
    'confirm_delete' => 'Are you sure you want to delete this appointment?',
    'confirm_cancel' => 'Are you sure you want to cancel this appointment?',
    
    // Validation
    'validation' => [
        'start_required' => 'Start date is required',
        'end_required' => 'End date is required',
        'end_after_start' => 'End date must be after start date',
        'patient_required' => 'Patient is required',
        'dentist_required' => 'Dentist is required',
        'title_required' => 'Title is required',
    ],
];
```

## Configurazione Database

### 1. Indici per Performance

```sql
-- Indici per ottimizzare le query del calendario
CREATE INDEX idx_appointments_date_range ON appointments(appointment_date, appointment_end_date);
CREATE INDEX idx_appointments_patient_date ON appointments(patient_id, appointment_date);
CREATE INDEX idx_appointments_dentist_date ON appointments(dentist_id, appointment_date);
CREATE INDEX idx_appointments_clinic_date ON appointments(clinic_id, appointment_date);
CREATE INDEX idx_appointments_status ON appointments(status);

-- Indici per disponibilità dentisti
CREATE INDEX idx_dentist_availability_date_range ON dentist_availability(start_time, end_time);
CREATE INDEX idx_dentist_availability_dentist ON dentist_availability(dentist_id, start_time);
```

## Configurazione Cache

### 1. Cache Configuration

```php
// config/cache.php - aggiungere store specifico per calendar
'stores' => [
    // ... altri stores
    'calendar' => [
        'driver' => 'redis',
        'connection' => 'calendar',
        'prefix' => 'saluteora_calendar',
    ],
],

// config/database.php - aggiungere connessione Redis per calendar
'redis' => [
    // ... altre connessioni
    'calendar' => [
        'host' => env('REDIS_HOST', '127.0.0.1'),
        'password' => env('REDIS_PASSWORD', null),
        'port' => env('REDIS_PORT', 6379),
        'database' => env('REDIS_CALENDAR_DB', 2),
    ],
],
```

## Configurazione Sicurezza

### 1. Rate Limiting

```php
// config/saluteora.php - aggiungere sezione rate limiting
'rate_limiting' => [
    'calendar_events' => [
        'max_attempts' => 60,
        'decay_minutes' => 1,
    ],
    'appointment_creation' => [
        'max_attempts' => 10,
        'decay_minutes' => 1,
    ],
],
```

### 2. Validation Rules

```php
// app/Rules/AppointmentTimeSlot.php
class AppointmentTimeSlot implements Rule
{
    public function passes($attribute, $value)
    {
        $config = config('saluteora.fullcalendar');
        $startTime = Carbon::parse($value);
        
        // Verifica orari di lavoro
        $businessStart = Carbon::parse($config['business_hours']['start']);
        $businessEnd = Carbon::parse($config['business_hours']['end']);
        
        return $startTime->between($businessStart, $businessEnd) &&
               in_array($startTime->dayOfWeek, $config['business_hours']['days']);
    }
    
    public function message()
    {
        return __('saluteora::calendar.outside_business_hours');
    }
}
```

---

*Questa configurazione fornisce una base solida e scalabile per FullCalendar nel progetto SaluteOra, ottimizzata per l'ambiente sanitario italiano.* 
