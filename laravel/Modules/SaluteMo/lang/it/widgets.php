<?php

declare(strict_types=1);

return [
    'appointment_overview' => [
        'title' => 'Panoramica Appuntamenti',
        'description' => 'Statistiche degli appuntamenti per stato',
        'no_data' => 'Nessun appuntamento trovato',
        'loading' => 'Caricamento statistiche...',
        'last_updated' => 'Aggiornato: :time',
        'total_appointments' => 'Totale: :count appuntamenti',
        'states' => [
            'pending' => 'In Attesa',
            'confirmed' => 'Confermati',
            'scheduled' => 'Programmati',
            'in_progress' => 'In Corso',
            'completed' => 'Completati',
            'cancelled' => 'Annullati',
            'rejected' => 'Rifiutati',
            'no_show' => 'Assenti',
            'rescheduled' => 'Riprogrammati',
            'report_pending' => 'Referto in Attesa',
            'report_completed' => 'Referto Completato',
            'refund_pending' => 'Rimborso in Attesa',
            'refund_accepted' => 'Rimborso Accettato',
            'refund_completed' => 'Rimborso Completato',
            'refund_to_integrate' => 'Rimborso da Integrare',
            'pro_bono' => 'Pro Bono',
            'banned' => 'Bannato',
        ],
    ],
    'doctor_appointments' => [
        'title' => 'Appuntamenti Dottore',
        'description' => 'Gestione appuntamenti per il dottore corrente',
        'no_appointments' => 'Nessun appuntamento trovato',
        'filter_by_date' => 'Filtra per data',
        'filter_by_status' => 'Filtra per stato',
    ],
    'patient_overview' => [
        'title' => 'Panoramica Pazienti',
        'description' => 'Statistiche dei pazienti',
        'total_patients' => 'Totale pazienti',
        'new_patients' => 'Nuovi pazienti',
        'active_patients' => 'Pazienti attivi',
    ],
];
