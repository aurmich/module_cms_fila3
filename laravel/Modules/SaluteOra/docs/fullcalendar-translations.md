# Traduzioni FullCalendar per SaluteOra

## File di Traduzione Italiano

### `lang/it/saluteora.php`

```php
<?php

return [
    'calendar' => [
        'my_appointments' => 'I Miei Appuntamenti',
        'clinic_appointments' => 'Appuntamenti della Clinica',
        'all_appointments' => 'Tutti gli Appuntamenti',
        'doctor_schedule' => 'Orario Dottore',
        'patient_calendar' => 'Calendario Paziente',
        'admin_overview' => 'Panoramica Amministratore',
        
        // Azioni
        'create_appointment' => 'Crea Appuntamento',
        'edit_appointment' => 'Modifica Appuntamento',
        'delete_appointment' => 'Elimina Appuntamento',
        'view_appointment' => 'Visualizza Appuntamento',
        
        // Stati
        'scheduled' => 'Programmato',
        'confirmed' => 'Confermato',
        'in_progress' => 'In Corso',
        'completed' => 'Completato',
        'cancelled' => 'Annullato',
        'no_show' => 'Assente',
        
        // Viste
        'month_view' => 'Vista Mese',
        'week_view' => 'Vista Settimana',
        'day_view' => 'Vista Giorno',
        'list_view' => 'Vista Lista',
        
        // Navigazione
        'today' => 'Oggi',
        'previous' => 'Precedente',
        'next' => 'Successivo',
        
        // Orari
        'business_hours' => 'Orari di Lavoro',
        'all_day' => 'Tutto il Giorno',
        'time_slot' => 'Fascia Oraria',
        
        // Multi-tenancy
        'select_clinic' => 'Seleziona Clinica',
        'current_clinic' => 'Clinica Attuale',
        'switch_clinic' => 'Cambia Clinica',
        'no_clinic_access' => 'Nessun accesso alle cliniche',
        
        // Messaggi
        'no_appointments' => 'Nessun appuntamento trovato',
        'loading_appointments' => 'Caricamento appuntamenti...',
        'appointment_created' => 'Appuntamento creato con successo',
        'appointment_updated' => 'Appuntamento aggiornato con successo',
        'appointment_deleted' => 'Appuntamento eliminato con successo',
        
        // Errori
        'error_loading' => 'Errore nel caricamento del calendario',
        'error_creating' => 'Errore nella creazione dell\'appuntamento',
        'error_updating' => 'Errore nell\'aggiornamento dell\'appuntamento',
        'error_deleting' => 'Errore nell\'eliminazione dell\'appuntamento',
        'unauthorized_clinic' => 'Non autorizzato ad accedere a questa clinica',
        
        // Tooltip
        'patient' => 'Paziente',
        'doctor' => 'Dottore',
        'clinic' => 'Clinica',
        'duration' => 'Durata',
        'status' => 'Stato',
        'notes' => 'Note',
        'created_at' => 'Creato il',
        'updated_at' => 'Aggiornato il',
    ],
    
    'appointment' => [
        'details' => 'Dettagli Appuntamento',
        'patient_info' => 'Informazioni Paziente',
        'doctor_info' => 'Informazioni Dottore',
        'clinic_info' => 'Informazioni Clinica',
        'schedule_info' => 'Informazioni Orario',
        
        'fields' => [
            'patient_id' => 'Paziente',
            'doctor_id' => 'Dottore',
            'clinic_id' => 'Clinica',
            'appointment_date' => 'Data Appuntamento',
            'appointment_end_date' => 'Fine Appuntamento',
            'status' => 'Stato',
            'notes' => 'Note',
            'created_by' => 'Creato da',
            'updated_by' => 'Aggiornato da',
        ],
        
        'placeholders' => [
            'select_patient' => 'Seleziona un paziente...',
            'select_doctor' => 'Seleziona un dottore...',
            'select_clinic' => 'Seleziona una clinica...',
            'enter_notes' => 'Inserisci note aggiuntive...',
        ],
        
        'validation' => [
            'patient_required' => 'Il paziente è obbligatorio',
            'doctor_required' => 'Il dottore è obbligatorio',
            'clinic_required' => 'La clinica è obbligatoria',
            'date_required' => 'La data è obbligatoria',
            'end_date_after_start' => 'La data di fine deve essere successiva alla data di inizio',
            'status_required' => 'Lo stato è obbligatorio',
            'notes_max_length' => 'Le note non possono superare i 500 caratteri',
        ],
    ],
];
```

## File di Traduzione Inglese

### `lang/en/saluteora.php`

```php
<?php

return [
    'calendar' => [
        'my_appointments' => 'My Appointments',
        'clinic_appointments' => 'Clinic Appointments',
        'all_appointments' => 'All Appointments',
        'doctor_schedule' => 'Doctor Schedule',
        'patient_calendar' => 'Patient Calendar',
        'admin_overview' => 'Admin Overview',
        
        // Actions
        'create_appointment' => 'Create Appointment',
        'edit_appointment' => 'Edit Appointment',
        'delete_appointment' => 'Delete Appointment',
        'view_appointment' => 'View Appointment',
        
        // Status
        'scheduled' => 'Scheduled',
        'confirmed' => 'Confirmed',
        'in_progress' => 'In Progress',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
        'no_show' => 'No Show',
        
        // Views
        'month_view' => 'Month View',
        'week_view' => 'Week View',
        'day_view' => 'Day View',
        'list_view' => 'List View',
        
        // Navigation
        'today' => 'Today',
        'previous' => 'Previous',
        'next' => 'Next',
        
        // Time
        'business_hours' => 'Business Hours',
        'all_day' => 'All Day',
        'time_slot' => 'Time Slot',
        
        // Multi-tenancy
        'select_clinic' => 'Select Clinic',
        'current_clinic' => 'Current Clinic',
        'switch_clinic' => 'Switch Clinic',
        'no_clinic_access' => 'No clinic access',
        
        // Messages
        'no_appointments' => 'No appointments found',
        'loading_appointments' => 'Loading appointments...',
        'appointment_created' => 'Appointment created successfully',
        'appointment_updated' => 'Appointment updated successfully',
        'appointment_deleted' => 'Appointment deleted successfully',
        
        // Errors
        'error_loading' => 'Error loading calendar',
        'error_creating' => 'Error creating appointment',
        'error_updating' => 'Error updating appointment',
        'error_deleting' => 'Error deleting appointment',
        'unauthorized_clinic' => 'Unauthorized to access this clinic',
        
        // Tooltip
        'patient' => 'Patient',
        'doctor' => 'Doctor',
        'clinic' => 'Clinic',
        'duration' => 'Duration',
        'status' => 'Status',
        'notes' => 'Notes',
        'created_at' => 'Created at',
        'updated_at' => 'Updated at',
    ],
    
    'appointment' => [
        'details' => 'Appointment Details',
        'patient_info' => 'Patient Information',
        'doctor_info' => 'Doctor Information',
        'clinic_info' => 'Clinic Information',
        'schedule_info' => 'Schedule Information',
        
        'fields' => [
            'patient_id' => 'Patient',
            'doctor_id' => 'Doctor',
            'clinic_id' => 'Clinic',
            'appointment_date' => 'Appointment Date',
            'appointment_end_date' => 'End Date',
            'status' => 'Status',
            'notes' => 'Notes',
            'created_by' => 'Created by',
            'updated_by' => 'Updated by',
        ],
        
        'placeholders' => [
            'select_patient' => 'Select a patient...',
            'select_doctor' => 'Select a doctor...',
            'select_clinic' => 'Select a clinic...',
            'enter_notes' => 'Enter additional notes...',
        ],
        
        'validation' => [
            'patient_required' => 'Patient is required',
            'doctor_required' => 'Doctor is required',
            'clinic_required' => 'Clinic is required',
            'date_required' => 'Date is required',
            'end_date_after_start' => 'End date must be after start date',
            'status_required' => 'Status is required',
            'notes_max_length' => 'Notes cannot exceed 500 characters',
        ],
    ],
];
```

## Configurazione Localizzazione FullCalendar

### JavaScript per Localizzazione

```javascript
// resources/js/fullcalendar-locale.js
document.addEventListener('DOMContentLoaded', function() {
    // Configurazione locale italiana per FullCalendar
    const calendarLocale = {
        code: 'it',
        week: {
            dow: 1, // Lunedì come primo giorno
            doy: 4  // Prima settimana dell'anno
        },
        buttonText: {
            prev: 'Prec',
            next: 'Succ',
            today: 'Oggi',
            month: 'Mese',
            week: 'Settimana',
            day: 'Giorno',
            list: 'Lista'
        },
        weekText: 'Sm',
        allDayText: 'Tutto il giorno',
        moreLinkText: function(n) {
            return '+altri ' + n;
        },
        noEventsText: 'Nessun evento da visualizzare',
        navLinkDayClick: function(date, jsEvent) {
            console.log('day', date.toISOString());
            console.log('coords', jsEvent.pageX, jsEvent.pageY);
        }
    };

    // Applica la localizzazione a tutti i calendari
    window.calendarLocale = calendarLocale;
});
```

## CSS per Personalizzazione Italiana

### `resources/css/fullcalendar-it.css`

```css
/* Personalizzazioni per calendario italiano */
.fc-toolbar-title {
    font-family: 'Inter', sans-serif;
    font-weight: 600;
    color: #1f2937;
}

.fc-button {
    font-family: 'Inter', sans-serif;
    font-size: 0.875rem;
    font-weight: 500;
}

.fc-event-title {
    font-family: 'Inter', sans-serif;
    font-size: 0.8rem;
    font-weight: 500;
}

/* Colori per stati appuntamenti italiani */
.fc-event.status-scheduled {
    background-color: #3b82f6;
    border-color: #2563eb;
}

.fc-event.status-confirmed {
    background-color: #10b981;
    border-color: #059669;
}

.fc-event.status-in-progress {
    background-color: #f59e0b;
    border-color: #d97706;
}

.fc-event.status-completed {
    background-color: #059669;
    border-color: #047857;
}

.fc-event.status-cancelled {
    background-color: #ef4444;
    border-color: #dc2626;
}

.fc-event.status-no-show {
    background-color: #6b7280;
    border-color: #4b5563;
}

/* Tooltip personalizzati */
.fc-event-tooltip {
    background: #1f2937;
    color: white;
    padding: 8px 12px;
    border-radius: 6px;
    font-size: 0.875rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

/* Responsive per mobile */
@media (max-width: 768px) {
    .fc-toolbar {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .fc-toolbar-chunk {
        display: flex;
        justify-content: center;
    }
    
    .fc-button {
        padding: 0.375rem 0.75rem;
        font-size: 0.75rem;
    }
}
```

## Configurazione Enum AppointmentStatus

### `app/Enums/AppointmentStatus.php`

```php
<?php

namespace Modules\SaluteOra\Enums;

enum AppointmentStatus: string
{
    case SCHEDULED = 'scheduled';
    case CONFIRMED = 'confirmed';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case NO_SHOW = 'no_show';

    public function getLabel(): string
    {
        return match ($this) {
            self::SCHEDULED => __('saluteora::calendar.scheduled'),
            self::CONFIRMED => __('saluteora::calendar.confirmed'),
            self::IN_PROGRESS => __('saluteora::calendar.in_progress'),
            self::COMPLETED => __('saluteora::calendar.completed'),
            self::CANCELLED => __('saluteora::calendar.cancelled'),
            self::NO_SHOW => __('saluteora::calendar.no_show'),
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::SCHEDULED => '#3b82f6',
            self::CONFIRMED => '#10b981',
            self::IN_PROGRESS => '#f59e0b',
            self::COMPLETED => '#059669',
            self::CANCELLED => '#ef4444',
            self::NO_SHOW => '#6b7280',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::SCHEDULED => 'heroicon-o-clock',
            self::CONFIRMED => 'heroicon-o-check-circle',
            self::IN_PROGRESS => 'heroicon-o-play-circle',
            self::COMPLETED => 'heroicon-o-check-badge',
            self::CANCELLED => 'heroicon-o-x-circle',
            self::NO_SHOW => 'heroicon-o-exclamation-triangle',
        };
    }

    public static function getOptions(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn($case) => [$case->value => $case->getLabel()])
            ->toArray();
    }
}
``` 