<?php

declare(strict_types=1);

return [
    'doctor_availabilities' => [
        'title' => 'Disponibilità Dottori',
        'description' => 'Visualizza e gestisce le disponibilità dei dottori',
        'schedule' => [
            'no_schedule' => [
                'label' => 'Nessun orario configurato',
                'description' => 'Non sono stati configurati orari per questo dottore',
                'help' => 'Clicca su "Modifica" per configurare gli orari di disponibilità',
            ],
            'click_edit_to_configure' => [
                'label' => 'Clicca Modifica per configurare',
                'description' => 'Usa il pulsante Modifica per impostare gli orari',
                'help' => 'Potrai definire gli orari di apertura, le pause e i giorni di lavoro',
            ],
        ],
        'actions' => [
            'edit_schedule' => [
                'label' => 'Modifica Orari',
                'tooltip' => 'Configura gli orari di disponibilità',
                'modal_heading' => 'Configura Orari di Disponibilità',
                'modal_description' => 'Imposta gli orari di lavoro, le pause e i giorni disponibili',
                'success' => 'Orari aggiornati con successo',
                'error' => 'Errore durante l\'aggiornamento degli orari',
            ],
            'view_schedule' => [
                'label' => 'Visualizza Orari',
                'tooltip' => 'Mostra gli orari configurati',
            ],
        ],
        'empty_state' => [
            'heading' => 'Nessuna disponibilità configurata',
            'description' => 'Inizia configurando gli orari di disponibilità per i dottori',
        ],
    ],
]; 