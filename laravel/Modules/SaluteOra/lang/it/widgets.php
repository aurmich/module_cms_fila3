<?php

declare(strict_types=1);

return [
    'find_doctor_widget' => [
        'title' => 'Trova Dentista e Prenota Appuntamento',
        'steps' => [
            'search' => 'Cerca Dentista',
            'date_time' => 'Data e Ora',
            'confirmation' => 'Conferma',
        ],
        'fields' => [
            'dentist_search' => 'Cerca un Dentista',
            'specialization' => 'Specializzazione',
            'location' => 'Località',
            'appointment_type' => 'Tipo di Appuntamento',
            'appointment_details' => 'Dettagli Appuntamento',
            'date' => 'Data',
            'time' => 'Orario',
        ],
        'messages' => [
            'loading_available_slots' => 'Caricamento orari disponibili...',
            'appointment_booked_successfully' => 'Appuntamento prenotato con successo!',
            'error_booking_appointment' => 'Si è verificato un errore durante la prenotazione',
        ],
    ],
];
