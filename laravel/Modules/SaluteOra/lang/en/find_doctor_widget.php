<?php

return [
    'title' => 'Find a dentist',
    'messages' => [
        'loading_available_slots' => 'Loading available slots...',
        'appointment_booked_successfully' => 'Appointment booked successfully',
        'error_booking_appointment' => 'Error booking appointment',
    ],
    'fields' => [
        'region' => [
            'label' => 'Region',
            'placeholder' => 'Seleziona una regione',
        ],
        'province' => [
            'label' => 'Province',
            'placeholder' => 'Seleziona una provincia',
        ],
        'city' => [
            'label' => 'City',
            'placeholder' => 'Seleziona una città',
        ],
        'cap' => [
            'label' => 'Postal Code',
            'placeholder' => 'Seleziona un CAP',
        ],
        'date' => [
            'label' => 'Date',
            'placeholder' => 'Seleziona una data',
        ],
        'time' => [
            'label' => 'Time',
            'placeholder' => 'Seleziona un orario',
        ],
    ],
    'steps' => [
        'search' => [
            'label' => 'Search',
            'description' => 'Find a dentist in your area',
        ],
        'date_time' => [
            'label' => 'Date and Time',
            'description' => 'Choose appointment date and time',
        ],
        'confirmation' => [
            'label' => 'Confirmation',
            'description' => 'Summary and booking confirmation',
        ],
    ],
];
