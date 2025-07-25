<?php

return [
    /*
    |--------------------------------------------------------------------------
    | FullCalendar Configuration
    |--------------------------------------------------------------------------
    |
    | Configurazioni per i widget FullCalendar del modulo SaluteOra.
    | Include impostazioni per colori, performance e widget specifici.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Scheduler License Key
    |--------------------------------------------------------------------------
    |
    | Chiave di licenza per FullCalendar Scheduler (plugin premium).
    | Necessaria solo se si utilizzano funzionalità premium come Timeline.
    |
    */
    'scheduler_license_key' => env('FULLCALENDAR_SCHEDULER_LICENSE_KEY'),

    'widgets' => [
        'patient' => [
            'editable' => false,
            'selectable' => false,
            'initialView' => 'timeGridWeek',
            'eventStartEditable' => false,
            'eventDurationEditable' => false,
            'eventResizableFromStart' => false,
            'dayMaxEvents' => true,
            'moreLinkClick' => 'popover',
        ],
        'doctor' => [
            'editable' => true,
            'selectable' => true,
            'initialView' => 'timeGridWeek',
            'eventStartEditable' => true,
            'eventDurationEditable' => true,
            'eventResizableFromStart' => true,
            'selectMirror' => true,
            'unselectAuto' => false,
        ],
        'admin' => [
            'editable' => true,
            'selectable' => true,
            'initialView' => 'dayGridMonth',
            'eventStartEditable' => true,
            'eventDurationEditable' => true,
            'eventResizableFromStart' => true,
            'dayMaxEvents' => 3,
            'moreLinkClick' => 'popover',
        ],
    ],

    'colors' => [
        'appointment_types' => [
            'consultation' => '#3b82f6', // blu
            'cleaning' => '#10b981', // verde
            'treatment' => '#f59e0b', // arancione
            'emergency' => '#ef4444', // rosso
            'followup' => '#8b5cf6', // viola
            'surgery' => '#6b7280', // grigio
            'orthodontics' => '#ec4899', // rosa
            'prevention' => '#059669', // verde scuro
        ],
        'appointment_status' => [
            'scheduled' => '#3b82f6', // blu
            'confirmed' => '#10b981', // verde
            'in_progress' => '#f59e0b', // arancione
            'completed' => '#059669', // verde scuro
            'cancelled' => '#ef4444', // rosso
            'no_show' => '#dc2626', // rosso scuro
            'rescheduled' => '#8b5cf6', // viola
            'pending' => '#6b7280', // grigio
        ],
        'studios' => [
            '#3b82f6', '#10b981', '#f59e0b', '#ef4444',
            '#8b5cf6', '#ec4899', '#06b6d4', '#84cc16',
            '#f97316', '#14b8a6', '#a855f7', '#e11d48'
        ],
        'emergency_priority' => [
            'critical' => '#dc2626',     // Rosso intenso
            'high' => '#ea580c',         // Arancione rosso
            'medium' => '#d97706',       // Arancione
            'low' => '#65a30d',          // Verde oliva
        ],
    ],

    'performance' => [
        'cache_ttl' => 300, // 5 minuti
        'max_events' => 100,
        'lazy_fetching' => true,
        'enable_caching' => true,
        'prefetch_events' => true,
        'event_limit_per_day' => 20,
    ],

    'localization' => [
        'locale' => 'it',
        'timezone' => 'Europe/Rome',
        'first_day' => 1, // Lunedì
        'button_text' => [
            'today' => 'Oggi',
            'month' => 'Mese',
            'week' => 'Settimana',
            'day' => 'Giorno',
            'list' => 'Lista',
            'prev' => 'Precedente',
            'next' => 'Successivo',
        ],
        'all_day_text' => 'Tutto il giorno',
        'more_link_text' => 'altri',
        'no_events_text' => 'Nessun evento da visualizzare',
        'week_text' => 'Settimana',
        'week_text_long' => 'Settimana',
    ],

    'business_hours' => [
        'days_of_week' => [1, 2, 3, 4, 5, 6], // Lun-Sab
        'start_time' => '08:00',
        'end_time' => '19:00',
    ],

    'time_format' => [
        'hour' => '2-digit',
        'minute' => '2-digit',
        'hour12' => false,
    ],

    'slot_settings' => [
        'duration' => '00:30:00', // 30 minuti
        'min_time' => '08:00:00',
        'max_time' => '19:00:00',
        'label_interval' => '01:00:00', // Etichette ogni ora
        'snap_duration' => '00:15:00', // Snap ogni 15 minuti
    ],

    'view_settings' => [
        'height' => 'auto',
        'aspect_ratio' => 1.35,
        'event_display' => 'block',
        'display_event_time' => true,
        'display_event_end' => true,
        'all_day_slot' => false,
        'now_indicator' => true,
        'scroll_time' => '08:00:00',
        'week_numbers' => true,
        'week_number_format' => [
            'week' => 'numeric',
        ],
        'day_max_events' => true,
        'day_max_event_rows' => 3,
    ],

    'interaction' => [
        'event_constraint' => 'businessHours',
        'select_constraint' => 'businessHours',
        'select_overlap' => false,
        'event_overlap' => false,
        'long_press_delay' => 1000,
        'event_long_press_delay' => 1000,
        'select_long_press_delay' => 1000,
        'drag_revert_duration' => 500,
        'drag_opacity' => 0.75,
        'drag_scroll' => true,
    ],

    'responsive' => [
        'mobile' => [
            'initial_view' => 'listWeek',
            'header_toolbar' => [
                'left' => 'prev,next',
                'center' => 'title',
                'right' => 'today',
            ],
            'height' => 400,
            'aspect_ratio' => 1.0,
        ],
        'tablet' => [
            'initial_view' => 'timeGridWeek',
            'header_toolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'timeGridWeek,listWeek',
            ],
            'height' => 500,
            'aspect_ratio' => 1.2,
        ],
        'desktop' => [
            'initial_view' => 'timeGridWeek',
            'header_toolbar' => [
                'left' => 'prev,next today',
                'center' => 'title',
                'right' => 'dayGridMonth,timeGridWeek,timeGridDay,listWeek',
            ],
            'height' => 'auto',
            'aspect_ratio' => 1.35,
        ],
    ],

    'security' => [
        'mask_patient_names' => false, // Maschera nomi pazienti per privacy
        'audit_trail' => true, // Abilita audit trail
        'log_user_actions' => true, // Log azioni utente
        'encrypt_sensitive_data' => false, // Crittografia dati sensibili
        'csrf_protection' => true,
        'rate_limiting' => true,
        'max_requests_per_minute' => 60,
    ],

    'notifications' => [
        'show_success' => true,
        'show_errors' => true,
        'show_warnings' => true,
        'auto_hide_delay' => 5000, // millisecondi
        'position' => 'top-right',
        'sound_enabled' => false,
    ],

    'accessibility' => [
        'enable_keyboard_navigation' => true,
        'enable_screen_reader' => true,
        'high_contrast_mode' => false,
        'focus_indicators' => true,
        'aria_labels' => true,
        'tab_index' => true,
    ],

    'emergency' => [
        'icon' => '🚨',
        'color' => '#ef4444',
        'priority_boost' => true,
        'auto_notification' => true,
        'sound_alert' => false,
        'flash_effect' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Print Configuration
    |--------------------------------------------------------------------------
    |
    | Configurazioni specifiche per la stampa dei calendari.
    |
    */
    'print' => [
        'hide_weekends' => false,
        'show_time_grid' => true,
        'include_patient_details' => false,
        'watermark' => 'CONFIDENZIALE',
        'header_text' => 'SaluteOra - Calendario Appuntamenti',
        'footer_text' => 'Documento riservato - Non divulgare',
        'show_logo' => true,
        'paper_size' => 'A4',
        'orientation' => 'landscape',
    ],

    /*
    |--------------------------------------------------------------------------
    | Advanced Features
    |--------------------------------------------------------------------------
    |
    | Configurazioni per funzionalità avanzate.
    |
    */
    'advanced' => [
        'enable_recurring_events' => true,
        'enable_event_templates' => true,
        'enable_bulk_operations' => true,
        'enable_export' => true,
        'enable_import' => true,
        'export_formats' => ['ics', 'csv', 'pdf'],
        'max_export_events' => 1000,
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
            'enabled' => false,
            'sync_interval' => 3600, // secondi
            'two_way_sync' => false,
        ],
        'outlook' => [
            'enabled' => false,
            'sync_interval' => 3600,
            'two_way_sync' => false,
        ],
        'sms_notifications' => [
            'enabled' => false,
            'provider' => 'twilio',
            'reminder_hours' => 24,
        ],
        'email_notifications' => [
            'enabled' => true,
            'reminder_hours' => [24, 2],
            'template' => 'saluteora::emails.appointment-reminder',
        ],
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
        'completed' => 'fc-event-completed',
        'cancelled' => 'fc-event-cancelled',
        'no_show' => 'fc-event-no-show',
    ],

    /*
    |--------------------------------------------------------------------------
    | Validation Rules
    |--------------------------------------------------------------------------
    |
    | Regole di validazione per eventi e appuntamenti.
    |
    */
    'validation' => [
        'min_duration_minutes' => 15,
        'max_duration_hours' => 8,
        'max_future_days' => 365,
        'min_advance_hours' => 1,
        'allow_past_events' => false,
        'allow_overlapping' => false,
        'require_patient' => true,
        'require_doctor' => true,
        'require_studio' => true,
    ],
];
