<?php

declare(strict_types=1);

return [
    'stats' => [
        'total_doctors' => 'Medici Totali',
        'active_doctors' => 'Medici Attivi',
        'total_patients' => 'Pazienti Totali',
        'active_patients' => 'Pazienti Attivi',
        'total_appointments' => 'Appuntamenti Totali',
        'today_appointments' => 'Appuntamenti Oggi',
        'pending_verifications' => 'Verifiche in Sospeso',
        'app_downloads' => 'Download App',
        'active_sessions' => 'Sessioni Attive',
        'avg_response_time' => 'Tempo Medio di Risposta',
        'satisfaction_rate' => 'Tasso di Soddisfazione',
        'increase' => '+:percent%',
        'decrease' => '-:percent%',
        'unchanged' => 'Invariato',
    ],
    'charts' => [
        'appointments_trend' => [
            'title' => 'Trend Appuntamenti',
            'subtitle' => 'Andamento degli appuntamenti negli ultimi 30 giorni',
        ],
        'user_registrations' => [
            'title' => 'Registrazioni Utenti',
            'subtitle' => 'Nuove registrazioni medici e pazienti',
        ],
        'specializations_distribution' => [
            'title' => 'Distribuzione Specializzazioni',
            'subtitle' => 'Percentuale medici per specializzazione',
        ],
        'geographic_distribution' => [
            'title' => 'Distribuzione Geografica',
            'subtitle' => 'Utenti per regione',
        ],
        'app_usage' => [
            'title' => 'Utilizzo App',
            'subtitle' => 'Sessioni giornaliere e durata media',
        ],
    ],
    'notifications' => [
        'title' => 'Notifiche Push',
        'subtitle' => 'Sistema di invio notifiche',
        'fields' => [
            'message' => [
                'label' => 'Messaggio',
                'placeholder' => 'Inserisci il messaggio da inviare',
            ],
            'title' => [
                'label' => 'Titolo',
                'placeholder' => 'Titolo della notifica',
            ],
            'recipients' => [
                'label' => 'Destinatari',
                'placeholder' => 'Seleziona i destinatari',
                'options' => [
                    'all' => 'Tutti gli utenti',
                    'doctors' => 'Solo medici',
                    'patients' => 'Solo pazienti',
                    'active' => 'Solo utenti attivi',
                ],
            ],
            'priority' => [
                'label' => 'Priorità',
                'options' => [
                    'low' => 'Bassa',
                    'normal' => 'Normale',
                    'high' => 'Alta',
                    'urgent' => 'Urgente',
                ],
            ],
        ],
        'actions' => [
            'send' => [
                'label' => 'Invia',
                'icon' => 'heroicon-o-paper-airplane',
            ],
            'schedule' => [
                'label' => 'Programma',
                'icon' => 'heroicon-o-clock',
            ],
            'preview' => [
                'label' => 'Anteprima',
                'icon' => 'heroicon-o-eye',
            ],
        ],
    ],
    'verification_queue' => [
        'title' => 'Coda Verifiche',
        'subtitle' => 'Medici in attesa di verifica',
        'fields' => [
            'doctor_name' => 'Nome Medico',
            'registration_date' => 'Data Registrazione',
            'documents_status' => 'Stato Documenti',
            'license_number' => 'Numero Iscrizione',
        ],
        'actions' => [
            'verify' => [
                'label' => 'Verifica',
                'icon' => 'heroicon-o-check-circle',
            ],
            'reject' => [
                'label' => 'Rifiuta',
                'icon' => 'heroicon-o-x-circle',
            ],
            'view_documents' => [
                'label' => 'Vedi Documenti',
                'icon' => 'heroicon-o-document-text',
            ],
        ],
    ],
    'appointment_monitor' => [
        'title' => 'Monitor Appuntamenti',
        'subtitle' => 'Appuntamenti in tempo reale',
        'status' => [
            'scheduled' => 'Programmati',
            'confirmed' => 'Confermati',
            'in_progress' => 'In Corso',
            'completed' => 'Completati',
            'cancelled' => 'Cancellati',
            'no_show' => 'Non Presentati',
        ],
        'actions' => [
            'view_details' => [
                'label' => 'Dettagli',
                'icon' => 'heroicon-o-eye',
            ],
            'contact_patient' => [
                'label' => 'Contatta Paziente',
                'icon' => 'heroicon-o-phone',
            ],
            'contact_doctor' => [
                'label' => 'Contatta Medico',
                'icon' => 'heroicon-o-phone',
            ],
        ],
    ],
    'system_health' => [
        'title' => 'Stato Sistema',
        'subtitle' => 'Monitoraggio infrastruttura',
        'metrics' => [
            'server_status' => 'Stato Server',
            'database_status' => 'Stato Database',
            'push_service_status' => 'Servizio Push',
            'api_response_time' => 'Tempo Risposta API',
            'uptime' => 'Uptime',
            'error_rate' => 'Tasso di Errore',
        ],
        'status' => [
            'online' => 'Online',
            'offline' => 'Offline',
            'warning' => 'Attenzione',
            'error' => 'Errore',
        ],
    ],
    'feedback_monitor' => [
        'title' => 'Monitor Feedback',
        'subtitle' => 'Recensioni e valutazioni',
        'metrics' => [
            'average_rating' => 'Valutazione Media',
            'total_reviews' => 'Recensioni Totali',
            'recent_feedback' => 'Feedback Recenti',
        ],
        'actions' => [
            'view_all' => [
                'label' => 'Vedi Tutti',
                'icon' => 'heroicon-o-eye',
            ],
            'respond' => [
                'label' => 'Rispondi',
                'icon' => 'heroicon-o-chat-bubble-left-right',
            ],
        ],
    ],
    'mobile_app_analytics' => [
        'title' => 'Analytics App Mobile',
        'subtitle' => 'Statistiche utilizzo app',
        'metrics' => [
            'daily_active_users' => 'Utenti Attivi Giornalieri',
            'monthly_active_users' => 'Utenti Attivi Mensili',
            'session_duration' => 'Durata Media Sessione',
            'retention_rate' => 'Tasso di Ritenzione',
            'crash_rate' => 'Tasso di Crash',
        ],
        'charts' => [
            'user_activity' => 'Attività Utenti',
            'feature_usage' => 'Utilizzo Funzionalità',
            'performance_metrics' => 'Metriche Performance',
        ],
    ],
];
