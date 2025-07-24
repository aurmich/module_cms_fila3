<?php

declare(strict_types=1);

return [
    'patient_registration_trend' => [
        'title' => 'Trend Registrazioni Pazienti',
        'description' => 'Andamento delle registrazioni pazienti negli ultimi 30 giorni',
        'empty_state' => 'Nessun dato disponibile per il periodo selezionato',
        'loading' => 'Caricamento trend registrazioni...',
        'last_updated' => 'Aggiornato: :time',
        'total_registrations' => 'Totale registrazioni: :count',
        'period' => [
            'label' => 'Periodo',
            'options' => [
                '7_days' => 'Ultimi 7 giorni',
                '30_days' => 'Ultimi 30 giorni',
                '90_days' => 'Ultimi 90 giorni',
            ],
        ],
    ],
    'user_status_distribution' => [
        'title' => 'Distribuzione Stati Utenti',
        'description' => 'Distribuzione degli stati degli utenti nel sistema',
        'empty_state' => 'Nessun utente trovato',
        'loading' => 'Caricamento distribuzione stati...',
        'total_users' => 'Totale utenti: :count',
        'statuses' => [
            'active' => [
                'label' => 'Attivo',
                'description' => 'Utenti attivi nel sistema',
            ],
            'inactive' => [
                'label' => 'Inattivo',
                'description' => 'Utenti inattivi',
            ],
            'pending' => [
                'label' => 'In attesa',
                'description' => 'Utenti in attesa di approvazione',
            ],
            'suspended' => [
                'label' => 'Sospeso',
                'description' => 'Utenti temporaneamente sospesi',
            ],
        ],
    ],
    'doctor_registration_trend' => [
        'title' => 'Trend Registrazioni Dottori',
        'description' => 'Andamento delle registrazioni dottori negli ultimi 30 giorni',
        'empty_state' => 'Nessun dato disponibile per il periodo selezionato',
        'loading' => 'Caricamento trend registrazioni...',
        'last_updated' => 'Aggiornato: :time',
        'total_registrations' => 'Totale registrazioni: :count',
        'period' => [
            'label' => 'Periodo',
            'options' => [
                '7_days' => 'Ultimi 7 giorni',
                '30_days' => 'Ultimi 30 giorni',
                '90_days' => 'Ultimi 90 giorni',
            ],
        ],
    ],
    'doctor_status_distribution' => [
        'title' => 'Distribuzione Stati Dottori',
        'description' => 'Distribuzione degli stati dei dottori nel sistema',
        'empty_state' => 'Nessun dottore trovato',
        'loading' => 'Caricamento distribuzione stati...',
        'total_doctors' => 'Totale dottori: :count',
        'statuses' => [
            'active' => [
                'label' => 'Attivo',
                'description' => 'Dottori attivi nel sistema',
            ],
            'inactive' => [
                'label' => 'Inattivo',
                'description' => 'Dottori inattivi',
            ],
            'pending' => [
                'label' => 'In attesa',
                'description' => 'Dottori in attesa di verifica',
            ],
            'verified' => [
                'label' => 'Verificato',
                'description' => 'Dottori verificati e approvati',
            ],
        ],
    ],
    'appointment_creation_trend' => [
        'title' => 'Trend Creazione Appuntamenti',
        'description' => 'Andamento della creazione appuntamenti negli ultimi 30 giorni',
        'empty_state' => 'Nessun dato disponibile per il periodo selezionato',
        'loading' => 'Caricamento trend appuntamenti...',
        'last_updated' => 'Aggiornato: :time',
        'total_appointments' => 'Totale appuntamenti: :count',
        'period' => [
            'label' => 'Periodo',
            'options' => [
                '7_days' => 'Ultimi 7 giorni',
                '30_days' => 'Ultimi 30 giorni',
                '90_days' => 'Ultimi 90 giorni',
            ],
        ],
    ],
    'appointment_status_distribution' => [
        'title' => 'Distribuzione Stati Appuntamenti',
        'description' => 'Distribuzione degli stati degli appuntamenti nel sistema',
        'empty_state' => 'Nessun appuntamento trovato',
        'loading' => 'Caricamento distribuzione stati...',
        'total_appointments' => 'Totale appuntamenti: :count',
        'statuses' => [
            'scheduled' => [
                'label' => 'Programmato',
                'description' => 'Appuntamenti programmati',
            ],
            'confirmed' => [
                'label' => 'Confermato',
                'description' => 'Appuntamenti confermati',
            ],
            'completed' => [
                'label' => 'Completato',
                'description' => 'Appuntamenti completati',
            ],
            'cancelled' => [
                'label' => 'Annullato',
                'description' => 'Appuntamenti annullati',
            ],
            'no_show' => [
                'label' => 'Non Presentato',
                'description' => 'Appuntamenti con assenza',
            ],
        ],
    ],
    'dashboard' => [
        'title' => 'Dashboard Amministrativa',
        'description' => 'Panoramica completa del sistema SaluteMo',
        'welcome_message' => 'Benvenuto nella dashboard amministrativa',
        'last_updated' => 'Ultimo aggiornamento: :time',
        'refresh' => 'Aggiorna dati',
        'loading' => 'Caricamento dashboard...',
    ],
    // Nuovi widget per i grafici
    'patient_registrations_chart' => [
        'title' => 'Registrazioni Pazienti',
        'label' => 'Pazienti Registrati',
        'description' => 'Trend delle registrazioni pazienti negli ultimi 30 giorni',
    ],
    'user_states_chart' => [
        'title' => 'Stati Utenti',
        'label' => 'Numero Utenti',
        'description' => 'Distribuzione degli stati degli utenti nel sistema',
    ],
    'doctor_registrations_chart' => [
        'title' => 'Registrazioni Medici',
        'label' => 'Medici Registrati',
        'description' => 'Trend delle registrazioni medici negli ultimi 30 giorni',
    ],
    'doctor_states_chart' => [
        'title' => 'Stati Medici',
        'label' => 'Numero Medici',
        'description' => 'Distribuzione degli stati dei medici nel sistema',
    ],
    'appointment_creation_chart' => [
        'title' => 'Creazione Appuntamenti',
        'label' => 'Appuntamenti Creati',
        'description' => 'Trend della creazione appuntamenti negli ultimi 30 giorni',
    ],
    'appointment_states_chart' => [
        'title' => 'Stati Appuntamenti',
        'label' => 'Numero Appuntamenti',
        'description' => 'Distribuzione degli stati degli appuntamenti nel sistema',
    ],
];
