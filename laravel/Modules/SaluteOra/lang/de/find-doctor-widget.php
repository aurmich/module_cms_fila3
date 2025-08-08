<?php

declare(strict_types=1);

return [
    'title' => 'Zahnarzt finden und buchen',
    'steps' => [
        'search' => 'Zahnarzt suchen',
        'date_time' => 'Datum und Uhrzeit',
        'confirmation' => 'Bestätigung',
    ],
    'fields' => [
        'dentist_search' => 'Zahnarzt suchen',
        'appointment_details' => 'Termin Details',
        'search' => 'Suchen',
        'region' => 'Region',
        'province' => 'Provinz',
        'city' => 'Stadt',
        'cap' => 'PLZ',
        'specialization' => 'Spezialisierung',
        'appointment_type' => 'Art der Behandlung',
        'date' => 'Datum',
        'time' => 'Uhrzeit',
    ],
    'placeholders' => [
        'search' => 'Nach Namen oder Stadt suchen',
        'region' => 'Region auswählen',
        'province' => 'Provinz auswählen',
        'city' => 'Stadt auswählen',
        'cap' => 'PLZ auswählen',
        'specialization' => 'Alle Spezialisierungen',
        'appointment_type' => 'Art der Behandlung auswählen',
        'date' => 'Datum auswählen',
        'time' => 'Uhrzeit auswählen',
    ],
    'actions' => [
        'submit' => 'Termin buchen',
        'next' => 'Weiter',
        'previous' => 'Zurück',
    ],
    'messages' => [
        'loading_available_slots' => 'Verfügbare Termine werden geladen...',
        'no_slots_available' => 'Keine Termine verfügbar für das ausgewählte Datum',
        'appointment_booked_successfully' => 'Termin erfolgreich gebucht!',
        'error_booking_appointment' => 'Fehler bei der Terminbuchung',
    ],
    'validation' => [
        'required' => 'Pflichtfeld',
    ],
];
