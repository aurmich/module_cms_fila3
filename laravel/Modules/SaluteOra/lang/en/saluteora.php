<?php

return [
    'fields' => [
        'region' => 'Region',
        'city' => 'City',
        'cap' => 'ZIP Code',
        'appointment_type' => 'Type of visit',
        'appointment_date' => 'Date',
        'appointment_time' => 'Time',
        'notes' => 'Notes',
    ],
    'messages' => [
        'confirm_booking' => 'Confirm booking',
        'booking_summary' => 'Booking summary',
        'booking_summary_title' => 'Search summary',
        'search_completed' => 'Search completed',
        'searching_doctors' => 'We are searching for dentists in the selected area...',
        'search_error' => 'Search error',
        'loading_available_slots' => 'Loading available time slots...',
    ],
    'placeholders' => [
        'optional_notes' => 'Enter any notes (optional)',
    ],
    'enums' => [
        'user_type' => [
            'admin' => 'Administrator',
            'dentist' => 'Doctor',
            'patient' => 'Patient',
        ],
        'appointment_type' => [
            'consultation' => 'Consultation',
            'cleaning' => 'Cleaning',
            'treatment' => 'Treatment',
            'emergency' => 'Emergency',
            'followup' => 'Follow-up',
            'surgery' => 'Surgery',
            'orthodontics' => 'Orthodontics',
            'prevention' => 'Prevention',
        ],
        'appointment_type_descriptions' => [
            'consultation' => 'First visit or specialist consultation',
            'cleaning' => 'Oral hygiene and dental cleaning',
            'treatment' => 'Therapeutic treatment',
            'emergency' => 'Emergency visit',
            'followup' => 'Post-treatment check-up',
            'surgery' => 'Surgical procedure',
            'orthodontics' => 'Orthodontic treatment',
            'prevention' => 'Prevention visit',
        ],
    ],
];
