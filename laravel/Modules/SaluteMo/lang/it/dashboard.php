<?php

declare(strict_types=1);

return [
    'title' => 'Dashboard SaluteMo',
    'subtitle' => 'Panoramica del modulo mobile per medici e pazienti',
    'description' => 'Gestione completa dell\'applicazione mobile SaluteMo per la connessione tra medici e pazienti',
    
    'navigation' => [
        'label' => 'Dashboard SaluteMo',
        'group' => 'Dashboard',
        'icon' => 'heroicon-o-chart-bar-square',
        'sort' => 1,
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
            'title' => 'Analytics',
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
            'route' => 'filament.admin.resources.doctors.create',
        ],
        'add_patient' => [
            'label' => 'Aggiungi Paziente',
            'icon' => 'heroicon-o-user-plus',
            'route' => 'filament.admin.resources.patients.create',
        ],
        'send_notification' => [
            'label' => 'Invia Notifica',
            'icon' => 'heroicon-o-bell',
            'action' => 'send-notification',
        ],
        'view_analytics' => [
            'label' => 'Visualizza Analytics',
            'icon' => 'heroicon-o-chart-pie',
            'route' => 'filament.admin.pages.analytics',
        ],
        'system_health' => [
            'label' => 'Controllo Sistema',
            'icon' => 'heroicon-o-cog-6-tooth',
            'route' => 'filament.admin.pages.system-health',
        ],
    ],
    
    'widgets' => [
        'stats_overview' => [
            'title' => 'Statistiche Generali',
            'description' => 'Panoramica numerica principale',
        ],
        'appointments_chart' => [
            'title' => 'Grafico Appuntamenti',
            'description' => 'Trend degli appuntamenti nel tempo',
        ],
        'user_distribution' => [
            'title' => 'Distribuzione Utenti',
            'description' => 'Medici e pazienti per area geografica',
        ],
        'recent_activities' => [
            'title' => 'Attività Recenti',
            'description' => 'Ultime azioni nell\'app mobile',
        ],
        'verification_queue' => [
            'title' => 'Coda Verifiche',
            'description' => 'Medici in attesa di approvazione',
        ],
    ],
    
    'messages' => [
        'welcome' => 'Benvenuto nella dashboard SaluteMo',
        'loading' => 'Caricamento dati in corso...',
        'error_loading' => 'Errore nel caricamento dei dati',
        'no_data' => 'Nessun dato disponibile',
        'last_updated' => 'Ultimo aggiornamento: :timestamp',
    ],
];
