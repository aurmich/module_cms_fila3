<?php

declare(strict_types=1);

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
            'placeholder' => 'Select a region',
        ],
        'province' => [
            'label' => 'Province',
            'placeholder' => 'Select a province',
        ],
        'city' => [
            'label' => 'City',
            'placeholder' => 'Select a city',
        ],
        'cap' => [
            'label' => 'Postal Code',
            'placeholder' => 'Select a postal code',
        ],
        'date' => [
            'label' => 'Date',
            'placeholder' => 'Select a date',
        ],
        'time' => [
            'label' => 'Time',
            'placeholder' => 'Select a time',
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
