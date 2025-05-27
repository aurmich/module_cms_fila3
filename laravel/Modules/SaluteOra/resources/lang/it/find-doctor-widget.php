<?php

return [
    'title' => 'Trova Dentista e Prenota',
    
    'steps' => [
        'search' => 'Ricerca Dentista',
        'date_time' => 'Data e Ora',
        'confirmation' => 'Conferma',
    ],
    
    'fields' => [
        'dentist_search' => 'Ricerca Dentista',
        'appointment_details' => 'Dettagli Appuntamento',
        'search' => 'Cerca',
        'region' => 'Regione',
        'province' => 'Provincia',
        'city' => 'Città',
        'cap' => 'CAP',
        'specialization' => 'Specializzazione',
        'appointment_type' => 'Tipo di visita',
        'date' => 'Data',
        'time' => 'Orario',
    ],
    
    'placeholders' => [
        'search' => 'Cerca per nome o città',
        'region' => 'Seleziona una regione',
        'province' => 'Seleziona una provincia',
        'city' => 'Seleziona una città',
        'cap' => 'Seleziona un CAP',
        'specialization' => 'Tutte le specializzazioni',
        'appointment_type' => 'Seleziona il tipo di visita',
        'date' => 'Seleziona una data',
        'time' => 'Seleziona un orario',
    ],
    
    'actions' => [
        'submit' => 'Prenota Appuntamento',
        'next' => 'Avanti',
        'previous' => 'Indietro',
    ],
    
    'messages' => [
        'loading_available_slots' => 'Caricamento orari disponibili...',
        'no_slots_available' => 'Nessun orario disponibile per la data selezionata',
        'appointment_booked_successfully' => 'Appuntamento prenotato con successo!',
        'error_booking_appointment' => 'Si è verificato un errore durante la prenotazione',
    ],
    
    'validation' => [
        'required' => 'Campo obbligatorio',
    ],
];
