<?php

declare(strict_types=1);

return [
    'find_doctor_widget' => [
        'title' => 'Find Dentist and Book Appointment',
        'steps' => [
            'search' => 'Find Dentist',
            'date_time' => 'Date & Time',
            'confirmation' => 'Confirmation',
        ],
        'fields' => [
            'dentist_search' => 'Find a Dentist',
            'specialization' => 'Specialization',
            'location' => 'Location',
            'appointment_type' => 'Appointment Type',
            'appointment_details' => 'Appointment Details',
            'date' => 'Date',
            'time' => 'Time',
        ],
        'messages' => [
            'loading_available_slots' => 'Loading available time slots...',
            'appointment_booked_successfully' => 'Appointment booked successfully!',
            'error_booking_appointment' => 'An error occurred while booking the appointment',
        ],
    ],
];
