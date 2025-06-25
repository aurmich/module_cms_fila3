<?php

declare(strict_types=1);

return [
    'studio_overview' => [
        'title' => 'Panoramica Studi',
        'stats' => [
            'total' => 'Studi Totali',
            'active' => 'Studi Attivi',
            'inactive' => 'Studi Inattivi',
            'cities' => 'Città Coperte',
            'doctors' => 'Dottori Associati',
            'appointments' => 'Appuntamenti Mensili',
        ],
        'chart' => [
            'title' => 'Distribuzione per Città',
            'empty' => 'Nessun dato disponibile',
        ],
    ],
    'doctor_availabilities' => [
        'title' => 'I Miei Orari di Disponibilità',
        'description' => 'Visualizza e gestisci gli orari di tutti i tuoi studi',
        'stats' => [
            'total_studios' => 'Studi totali',
            'configured_studios' => 'Orari configurati',
            'unconfigured_studios' => 'Da configurare',
        ],
        'studio' => [
            'primary_badge' => 'Principale',
            'configured_badge' => 'Configurato',
            'unconfigured_badge' => 'Da configurare',
            'edit_schedule' => 'Modifica orari',
            'configure_now' => 'Configura ora',
        ],
        'schedule' => [
            'title' => 'Orari di Disponibilità',
            'description' => 'Visualizza e modifica gli orari di apertura per questo studio',
            'not_configured' => 'Orari non configurati',
            'configure_description' => 'Configura gli orari di disponibilità per questo studio',
            'no_schedule' => 'Nessun orario configurato',
            'click_edit_to_configure' => 'Clicca sul pulsante modifica per configurare gli orari',
            'closed' => 'Chiuso',
        ],
        'empty_states' => [
            'no_studios' => 'Nessuno studio associato',
            'no_studios_description' => 'Contatta l\'amministratore per associarti a uno studio',
            'no_schedule' => 'Orari non ancora configurati per questo studio',
            'no_schedule_description' => 'Configura gli orari di disponibilità',
        ],
        'actions' => [
            'edit_schedule' => [
                'label' => 'Modifica orari',
                'tooltip' => 'Apri la pagina di configurazione orari per questo studio',
            ],
            'configure_schedule' => [
                'label' => 'Configura ora',
                'tooltip' => 'Configura gli orari di disponibilità per questo studio',
            ],
        ],
    ],
];