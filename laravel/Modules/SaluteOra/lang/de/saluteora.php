<?php

return [
    'fields' => [
        'region' => 'Regione',
        'city' => 'Stadt',
        'cap' => 'CAP',
        'appointment_type' => 'Tipo di visita',
        'appointment_date' => 'Data',
        'appointment_time' => 'Orario',
        'notes' => 'Note',
    ],
    'messages' => [
        'confirm_booking' => 'Conferma prenotazione',
        'booking_summary' => 'Riepilogo prenotazione',
        'booking_summary_title' => 'Riepilogo ricerca',
        'search_completed' => 'Ricerca effettuata',
        'searching_doctors' => 'Stiamo cercando dentisti nella zona selezionata...',
        'search_error' => 'Fehler nella ricerca',
        'loading_available_slots' => 'hochladenmento orari disponibili...',
    ],
    'placeholders' => [
        'optional_notes' => 'eingeben eventuali note (opzionale)',
    ],
    'enums' => [
        'user_type' => [
            'admin' => 'Amministratore',
            'doctor' => 'Arzt',
            'patient' => 'Paziente',
        ],
        'appointment_type' => [
            'consultation' => 'Visita',
            'cleaning' => 'Pulizia',
            'treatment' => 'Trattamento',
            'emergency' => 'Emergenza',
            'followup' => 'Controllo',
            'surgery' => 'Chirurgia',
            'orthodontics' => 'Ortodonzia',
            'prevention' => 'Prevenzione',
        ],
        'appointment_type_descriptions' => [
            'consultation' => 'Prima visita o consulto specialistico',
            'cleaning' => 'Igiene orale e pulizia dentale',
            'treatment' => 'Trattamento terapeutico',
            'emergency' => 'Visita di emergenza',
            'followup' => 'Controllo post-trattamento',
            'surgery' => 'Intervento chirurgico',
            'orthodontics' => 'Trattamento ortodontico',
            'prevention' => 'Visita di prevenzione',
        ],
    ],
];
