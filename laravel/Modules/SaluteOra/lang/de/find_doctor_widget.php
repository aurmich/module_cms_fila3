<?php

return [
    'title' => 'Cerca un dentista',
    'messages' => [
        'loading_available_slots' => 'Caricamento slot disponibili...',
        'appointment_booked_successfully' => 'Appuntamento prenotato con successo',
        'error_booking_appointment' => 'Errore durante la prenotazione',
    ],
    'fields' => [
        'region' => [
            'label' => 'Regione',
            'placeholder' => 'Seleziona una regione',
        ],
        'province' => [
            'label' => 'Provincia',
            'placeholder' => 'Seleziona una provincia',
        ],
        'city' => [
            'label' => 'Città',
            'placeholder' => 'Seleziona una città',
        ],
        'cap' => [
            'label' => 'CAP',
            'placeholder' => 'Seleziona un CAP',
        ],
        'date' => [
            'label' => 'Data',
            'placeholder' => 'Seleziona una data',
        ],
        'time' => [
            'label' => 'Orario',
            'placeholder' => 'Seleziona un orario',
        ],
    ],
    'steps' => [
        'search' => [
            'label' => 'Ricerca',
            'description' => 'Trova un dentista nella tua zona',
        ],
        'date_time' => [
            'label' => 'Data e Ora',
            'description' => 'Scegli data e ora dell\'appuntamento',
        ],
        'confirmation' => [
            'label' => 'Conferma',
            'description' => 'Conferma la prenotazione',
        ],
    ],
];
