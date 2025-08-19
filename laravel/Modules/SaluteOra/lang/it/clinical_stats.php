<?php

return [
    'fields' => [
        'tenant_id' => [
            'label' => 'Struttura',
            'placeholder' => 'Seleziona la struttura',
            'tooltip' => 'Seleziona la struttura per cui visualizzare le statistiche',
        ],
        'doctor_id' => [
            'label' => 'Dentista',
            'placeholder' => 'Seleziona il dentista',
            'tooltip' => 'Seleziona il dentista per cui visualizzare le statistiche',
        ],
        'start_date' => [
            'label' => 'Data inizio',
            'placeholder' => 'Seleziona la data di inizio',
            'tooltip' => 'Data di inizio del periodo da analizzare',
        ],
        'end_date' => [
            'label' => 'Data fine',
            'placeholder' => 'Seleziona la data di fine',
            'tooltip' => 'Data di fine del periodo da analizzare',
        ],
    ],
    'navigation' => [
        'label' => 'Statistiche Cliniche',
        'icon' => 'heroicon-o-chart-bar',
        'group' => 'Statistiche',
    ],
    'stats' => [
        'total_appointments' => 'Totale Appuntamenti',
        'completed_appointments' => 'Appuntamenti Completati',
        'cancelled_appointments' => 'Appuntamenti Cancellati',
        'no_show_appointments' => 'Appuntamenti Non Presentati',
        'completion_rate' => 'Tasso di Completamento',
        'cancellation_rate' => 'Tasso di Cancellazione',
        'no_show_rate' => 'Tasso di Non Presentazione',
    ],
]; 