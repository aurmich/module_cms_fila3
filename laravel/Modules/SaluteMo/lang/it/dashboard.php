<?php

declare(strict_types=1);

return [
    'model' => [
        'label' => 'Dashboard',
        'plural' => 'Dashboard',
    ],
    
    'navigation' => [
        'label' => 'Dashboard',
        'group' => 'Dashboard',
        'icon' => 'heroicon-o-home',
        'sort' => 1,
    ],
    
    'pages' => [
        'index' => [
            'title' => 'Dashboard SaluteMo',
            'subtitle' => 'Panoramica del modulo mobile per medici e pazienti',
            'description' => 'Gestione completa dell\'applicazione mobile SaluteMo per la connessione tra medici e pazienti',
        ],
    ],
    
    'sections' => [
        'overview' => [
            'title' => 'Panoramica Generale',
            'description' => 'Statistiche principali dell\'app mobile',
        ],
        'users' => [
            'title' => 'Gestione Utenti',
            'description' => 'Medici e pazienti registrati',
        ],
        'appointments' => [
            'title' => 'Appuntamenti',
            'description' => 'Sistema di prenotazione visite',
        ],
        'analytics' => [
            'title' => 'Analitiche',
            'description' => 'Analisi utilizzo e performance',
        ],
        'notifications' => [
            'title' => 'Notifiche',
            'description' => 'Sistema di comunicazione push',
        ],
        'system' => [
            'title' => 'Sistema',
            'description' => 'Stato e monitoraggio infrastruttura',
        ],
    ],
    
    'quick_actions' => [
        'add_doctor' => [
            'label' => 'Aggiungi Medico',
            'icon' => 'heroicon-o-user-plus',
            'tooltip' => 'Aggiungi un nuovo medico al sistema',
            'route' => 'filament.admin.resources.doctors.create',
        ],
        'add_patient' => [
            'label' => 'Aggiungi Paziente',
            'icon' => 'heroicon-o-user-plus',
            'tooltip' => 'Aggiungi un nuovo paziente al sistema',
            'route' => 'filament.admin.resources.patients.create',
        ],
        'send_notification' => [
            'label' => 'Invia Notifica',
            'icon' => 'heroicon-o-bell',
            'tooltip' => 'Invia una notifica agli utenti',
            'action' => 'send-notification',
        ],
        'view_analytics' => [
            'label' => 'Visualizza Analitiche',
            'icon' => 'heroicon-o-chart-pie',
            'tooltip' => 'Visualizza le analitiche del sistema',
            'route' => 'filament.admin.pages.analytics',
        ],
        'system_health' => [
            'label' => 'Stato del Sistema',
            'icon' => 'heroicon-o-cog-6-tooth',
            'tooltip' => 'Visualizza lo stato del sistema',
            'route' => 'filament.admin.pages.system-health',
        ],
    ],
    
    'widgets' => [
        'stats_overview' => [
            'title' => 'Statistiche Generali',
            'description' => 'Panoramica numerica principale',
            'cards' => [
                'total_doctors' => 'Totale Medici',
                'total_patients' => 'Totale Pazienti',
                'active_appointments' => 'Appuntamenti Attivi',
                'pending_verifications' => 'Verifiche in Attesa',
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
