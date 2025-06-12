<?php

declare(strict_types=1);

return [
    'dashboard' => [
        'title' => 'Dashboard SaluteMo',
        'subtitle' => 'Panoramica dell\'applicazione mobile',
        'navigation' => [
            'label' => 'Dashboard',
            'group' => 'SaluteMo',
            'icon' => 'heroicon-o-chart-bar-square',
        ],
    ],
    
    'analytics' => [
        'title' => 'Analytics Mobile',
        'subtitle' => 'Statistiche di utilizzo dell\'app',
        'navigation' => [
            'label' => 'Analytics',
            'group' => 'Reportistica',
            'icon' => 'heroicon-o-chart-pie',
        ],
        'tabs' => [
            'overview' => 'Panoramica',
            'users' => 'Utenti',
            'appointments' => 'Appuntamenti',
            'performance' => 'Performance',
            'retention' => 'Ritenzione',
        ],
    ],
    
    'notifications' => [
        'title' => 'Centro Notifiche',
        'subtitle' => 'Gestione notifiche push',
        'navigation' => [
            'label' => 'Notifiche',
            'group' => 'Comunicazioni',
            'icon' => 'heroicon-o-bell',
        ],
        'tabs' => [
            'send' => 'Invia Notifica',
            'history' => 'Storico',
            'templates' => 'Modelli',
            'settings' => 'Impostazioni',
        ],
    ],
    
    'system_health' => [
        'title' => 'Stato Sistema',
        'subtitle' => 'Monitoraggio infrastruttura mobile',
        'navigation' => [
            'label' => 'Stato Sistema',
            'group' => 'Sistema',
            'icon' => 'heroicon-o-cog-6-tooth',
        ],
        'sections' => [
            'api_status' => 'Stato API',
            'database_status' => 'Stato Database',
            'push_service' => 'Servizio Push',
            'external_services' => 'Servizi Esterni',
        ],
    ],
    
    'user_management' => [
        'title' => 'Gestione Utenti',
        'subtitle' => 'Amministrazione medici e pazienti',
        'navigation' => [
            'label' => 'Gestione Utenti',
            'group' => 'Amministrazione',
            'icon' => 'heroicon-o-users',
        ],
        'tabs' => [
            'doctors' => 'Medici',
            'patients' => 'Pazienti',
            'verification' => 'Verifiche',
            'reports' => 'Report',
        ],
    ],
    
    'app_configuration' => [
        'title' => 'Configurazione App',
        'subtitle' => 'Impostazioni applicazione mobile',
        'navigation' => [
            'label' => 'Config App',
            'group' => 'Configurazione',
            'icon' => 'heroicon-o-device-phone-mobile',
        ],
        'sections' => [
            'general' => [
                'title' => 'Impostazioni Generali',
                'description' => 'Configurazioni base dell\'app',
            ],
            'features' => [
                'title' => 'Funzionalità',
                'description' => 'Attivazione/disattivazione features',
            ],
            'integrations' => [
                'title' => 'Integrazioni',
                'description' => 'Connessioni con servizi esterni',
            ],
            'security' => [
                'title' => 'Sicurezza',
                'description' => 'Impostazioni di sicurezza',
            ],
        ],
    ],
    
    'appointment_management' => [
        'title' => 'Gestione Appuntamenti',
        'subtitle' => 'Sistema di prenotazione visite',
        'navigation' => [
            'label' => 'Appuntamenti',
            'group' => 'Gestione',
            'icon' => 'heroicon-o-calendar-days',
        ],
        'tabs' => [
            'calendar' => 'Calendario',
            'list' => 'Elenco',
            'conflicts' => 'Conflitti',
            'statistics' => 'Statistiche',
        ],
    ],
    
    'feedback_management' => [
        'title' => 'Gestione Feedback',
        'subtitle' => 'Recensioni e valutazioni',
        'navigation' => [
            'label' => 'Feedback',
            'group' => 'Qualità',
            'icon' => 'heroicon-o-star',
        ],
        'tabs' => [
            'reviews' => 'Recensioni',
            'ratings' => 'Valutazioni',
            'reports' => 'Segnalazioni',
            'responses' => 'Risposte',
        ],
    ],
    
    'api_documentation' => [
        'title' => 'Documentazione API',
        'subtitle' => 'Endpoint per app mobile',
        'navigation' => [
            'label' => 'API Docs',
            'group' => 'Sviluppo',
            'icon' => 'heroicon-o-code-bracket',
        ],
        'sections' => [
            'authentication' => 'Autenticazione',
            'users' => 'Gestione Utenti',
            'appointments' => 'Appuntamenti',
            'notifications' => 'Notifiche',
            'medical_records' => 'Cartelle Cliniche',
        ],
    ],
    
    'support_tools' => [
        'title' => 'Strumenti di Supporto',
        'subtitle' => 'Assistenza e debug',
        'navigation' => [
            'label' => 'Supporto',
            'group' => 'Strumenti',
            'icon' => 'heroicon-o-wrench-screwdriver',
        ],
        'tools' => [
            'user_impersonate' => 'Impersona Utente',
            'push_test' => 'Test Notifiche',
            'api_test' => 'Test API',
            'log_viewer' => 'Visualizza Log',
            'cache_clear' => 'Svuota Cache',
        ],
    ],
]; 