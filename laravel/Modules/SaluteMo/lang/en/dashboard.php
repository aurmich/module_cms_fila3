<?php

return [
    'title' => 'Dashboard',
    'description' => 'Overview of your SaluteMo module',
    'model' => [
        'label' => 'Dashboard',
        'plural' => 'Dashboard',
    ],
    'navigation' => [
        'label' => 'Dashboard',
        'group' => 'Dashboard',
        'icon' => 'heroicon-o-home',
        'sort' => '1',
    ],
    'pages' => [
        'index' => [
            'title' => 'Dashboard SaluteMo',
            'subtitle' => 'Overview of the mobile module for doctors and patients',
            'description' => 'Complete management of the SaluteMo mobile application for connecting doctors and patients',
        ],
    ],
    'sections' => [
        'overview' => [
            'title' => 'General Overview',
            'description' => 'Main statistics of the mobile app',
        ],
        'users' => [
            'title' => 'User Management',
            'description' => 'Registered doctors and patients',
        ],
        'appointments' => [
            'title' => 'Appointments',
            'description' => 'Visit booking system',
        ],
        'analytics' => [
            'title' => 'Analytics',
            'description' => 'Usage and performance analysis',
        ],
        'notifications' => [
            'title' => 'Notifications',
            'description' => 'Push communication system',
        ],
        'system' => [
            'title' => 'System',
            'description' => 'Infrastructure status and monitoring',
        ],
    ],
    'quick_actions' => [
        'add_doctor' => [
            'label' => 'Add Doctor',
            'icon' => 'heroicon-o-user-plus',
            'tooltip' => 'Add a new doctor to the system',
            'route' => 'filament.admin.resources.doctors.create',
        ],
        'add_patient' => [
            'label' => 'Add Patient',
            'icon' => 'heroicon-o-user-plus',
            'tooltip' => 'Add a new patient to the system',
            'route' => 'filament.admin.resources.patients.create',
        ],
        'send_notification' => [
            'label' => 'Send Notification',
            'icon' => 'heroicon-o-bell',
            'tooltip' => 'Send a notification to users',
            'action' => 'send-notification',
        ],
        'view_analytics' => [
            'label' => 'View Analytics',
            'icon' => 'heroicon-o-chart-pie',
            'tooltip' => 'View system analytics',
            'route' => 'filament.admin.pages.analytics',
        ],
        'system_health' => [
            'label' => 'System Status',
            'icon' => 'heroicon-o-cog-6-tooth',
            'tooltip' => 'View system status',
            'route' => 'filament.admin.pages.system-health',
        ],
    ],
    'widgets' => [
        'stats_overview' => [
            'title' => 'General Statistics',
            'description' => 'Main numerical overview',
            'cards' => [
                'total_doctors' => 'Total Doctors',
                'total_patients' => 'Total Patients',
                'active_appointments' => 'Active Appointments',
                'pending_verifications' => 'Pending Verifications',
            ],
        ],
        'appointments_chart' => [
            'title' => 'Grafico Appuntamenti',
            'description' => 'Trend degli appuntamenti nel tempo',
            'filters' => [
                'daily' => 'Giornaliero',
                'weekly' => 'Settimanale',
                'monthly' => 'Mensile',
            ],
        ],
        'user_distribution' => [
            'title' => 'Distribuzione Utenti',
            'description' => 'Medici e pazienti per area geografica',
        ],
        'recent_activities' => [
            'title' => 'Attività Recenti',
            'description' => 'Ultime azioni nell\'app mobile',
            'view_all' => 'Vedi Tutte',
        ],
        'verification_queue' => [
            'title' => 'Coda Verifiche',
            'description' => 'Medici in attesa di approvazione',
            'view_all' => 'Gestisci Verifiche',
        ],
    ],
    'messages' => [
        'welcome' => 'Benvenuto nella dashboard SaluteMo',
        'welcome_back' => 'Bentornato, :name!',
        'loading' => 'Caricamento dati in corso...',
        'error_loading' => 'Errore nel caricamento dei dati',
        'no_data' => 'Nessun dato disponibile',
        'last_updated' => 'Ultimo aggiornamento: :timestamp',
        'select_date_range' => 'Seleziona intervallo date',
    ],
    'actions' => [
        'refresh' => [
            'label' => 'Aggiorna',
            'icon' => 'heroicon-o-arrow-path',
            'tooltip' => 'Aggiorna i dati della dashboard',
        ],
        'export' => [
            'label' => 'Esporta',
            'icon' => 'heroicon-o-arrow-down-tray',
            'tooltip' => 'Esporta i dati correnti',
        ],
    ],
];
