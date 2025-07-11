<?php

return [
    'title' => 'Find a Dentist and Book an Appointment',
    'steps' => [
        'search' => 'Find a Dentist',
        'date_time' => 'Date and Time',
        'confirmation' => 'Confirmation',
    ],
    'fields' => [
        'dentist_search' => 'Dentist Search',
        'appointment_details' => 'Appointment Details',
        'search' => 'Search',
        'region' => 'Region',
        'province' => 'Province',
        'city' => 'City',
        'cap' => 'ZIP Code',
        'specialization' => 'Specialization',
        'appointment_type' => 'Appointment Type',
        'date' => 'Date',
        'time' => 'Time',
    ],
    'placeholders' => [
        'search' => 'Search by name or city',
        'region' => 'Select a region',
        'province' => 'Select a province',
        'city' => 'Select a city',
        'cap' => 'Enter ZIP code',
        'specialization' => 'All specializations',
        'appointment_type' => 'Select appointment type',
        'date' => 'Select a date',
        'time' => 'Select a time',
    ],
    'actions' => [
        'submit' => 'Book Appointment',
        'next' => 'Next',
        'previous' => 'Previous',
    ],
    'messages' => [
        'loading_available_slots' => 'Loading available time slots...',
        'no_slots_available' => 'No available time slots for the selected date',
        'appointment_booked_successfully' => 'Appointment booked successfully!',
        'error_booking_appointment' => 'An error occurred while booking the appointment',
    ],
    'validation' => [
        'required' => 'This field is required',
    ],
];
