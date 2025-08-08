<?php

declare(strict_types=1);

return [
    'title' => 'Zahnarzt finden',
    'messages' => [
        'loading_available_slots' => 'Verfügbare Termine werden geladen...',
        'appointment_booked_successfully' => 'Termin erfolgreich gebucht',
        'error_booking_appointment' => 'Fehler bei der Terminbuchung',
    ],
    'fields' => [
        'region' => [
            'label' => 'Region',
            'placeholder' => 'Region auswählen',
        ],
        'province' => [
            'label' => 'Provinz',
            'placeholder' => 'Provinz auswählen',
        ],
        'city' => [
            'label' => 'Stadt',
            'placeholder' => 'Stadt auswählen',
        ],
        'cap' => [
            'label' => 'PLZ',
            'placeholder' => 'PLZ auswählen',
        ],
        'date' => [
            'label' => 'Datum',
            'placeholder' => 'Datum auswählen',
        ],
        'time' => [
            'label' => 'Uhrzeit',
            'placeholder' => 'Uhrzeit auswählen',
        ],
    ],
    'steps' => [
        'search' => [
            'label' => 'Suche',
            'description' => 'Finden Sie einen Zahnarzt in Ihrer Nähe',
        ],
        'date_time' => [
            'label' => 'Datum und Uhrzeit',
            'description' => 'Wählen Sie Datum und Uhrzeit des Termins',
        ],
        'confirmation' => [
            'label' => 'Bestätigung',
            'description' => 'Bestätigen Sie die Buchung',
        ],
    ],
];
