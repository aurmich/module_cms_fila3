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
        ],
        'province' => [
            'label' => 'Province',
        ],
        'city' => [
            'label' => 'City',
        ],
        'cap' => [
            'label' => 'Postal Code',
        ],
        'date' => [
            'label' => 'Date',
        ],
        'time' => [
            'label' => 'Time',
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