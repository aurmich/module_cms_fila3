<?php

declare(strict_types=1);

return [
    'title' => 'Find Doctor and Book Appointment',
    'description' => 'Search for available doctors and book your appointment online',
    'steps' => [
        'search' => [
            'title' => 'Search',
            'description' => 'Find doctors in your area',
        ],
        'select' => [
            'title' => 'Select',
            'description' => 'Choose your preferred doctor and time',
        ],
        'confirm' => [
            'title' => 'Confirm',
            'description' => 'Review and confirm your booking',
        ],
    ],
    'fields' => [
        'specialization' => [
            'label' => 'Specialization',
            'placeholder' => 'Select medical specialization',
            'helper_text' => '',
            'help' => 'Choose the medical specialization you need',
            'description' => 'Medical field of expertise',
        ],
        'location' => [
            'label' => 'Location',
            'placeholder' => 'Enter your city or address',
            'helper_text' => '',
            'help' => 'Specify your location to find nearby doctors',
            'description' => 'Your current location for the search',
        ],
        'date' => [
            'label' => 'Date',
            'placeholder' => 'Select a date',
            'helper_text' => '',
            'help' => 'Choose the date for your appointment',
            'description' => 'Day when the visit will take place',
        ],
        'time' => [
            'label' => 'Time',
            'placeholder' => 'Select a time',
            'helper_text' => '',
            'help' => 'Choose your preferred time',
            'description' => 'Start time of the visit',
        ],
        'notes' => [
            'label' => 'Additional Notes',
            'placeholder' => 'Enter any notes or special requests',
            'helper_text' => '',
            'help' => 'Add useful information for the doctor (symptoms, allergies, medications)',
            'description' => 'Notes that will help the doctor prepare better for the visit',
        ],
        'search' => [
            'label' => 'Search',
            'placeholder' => 'Search for doctors in your area',
            'helper_text' => '',
            'help' => 'Use filters to find the most suitable doctor',
            'description' => 'Doctor search system for specialists',
        ],
    ],
    'actions' => [
        'submit' => [
            'label' => 'Confirm Booking',
            'modal' => [
                'heading' => 'Confirm Appointment',
                'description' => 'You are about to confirm your appointment booking. Please verify that all details are correct.',
                'confirm' => 'Confirm',
                'cancel' => 'Cancel',
            ],
            'messages' => [
                'success' => 'Appointment booked successfully! You will receive a confirmation email.',
                'error' => 'An error occurred during booking. Please try again later.',
                'validation_error' => 'Some fields are not filled correctly. Please check the entered data.',
            ],
            'tooltip' => 'Complete your appointment booking',
        ],
        'search' => [
            'label' => 'Search Doctors',
            'tooltip' => 'Start searching for available doctors',
            'messages' => [
                'success' => 'Search completed',
                'error' => 'Error during search',
                'no_results' => 'No doctors found with the selected criteria',
            ],
        ],
        'back' => [
            'label' => 'Back',
            'tooltip' => 'Go back to the previous step',
        ],
        'next' => [
            'label' => 'Next',
            'tooltip' => 'Proceed to the next step',
        ],
        'reset' => [
            'label' => 'Start Over',
            'modal' => [
                'heading' => 'Start Search Over?',
                'description' => 'All entered data will be lost. Are you sure you want to start over?',
                'confirm' => 'Yes, start over',
                'cancel' => 'No, continue',
            ],
            'tooltip' => 'Clear all data and restart the search',
        ],
    ],
    'messages' => [
        'welcome' => 'Welcome to the online booking system',
        'loading' => 'Loading...',
        'no_doctors_found' => 'No doctors found with the selected search criteria',
        'no_appointments_available' => 'No appointments available for this date',
        'select_specialization' => 'Please select a specialization first',
        'select_location' => 'Please specify the location for the search',
        'appointment_confirmed' => 'Your appointment has been confirmed',
        'appointment_pending' => 'Your booking is pending confirmation',
    ],
    'empty_states' => [
        'no_doctors' => 'No doctors available',
        'no_appointments' => 'No appointments available',
        'no_results' => 'No results found',
        'search_required' => 'Fill in the search fields to begin',
    ],
    'validation' => [
        'specialization_required' => 'Specialization is required',
        'location_required' => 'Location is required',
        'date_required' => 'Date is required',
        'time_required' => 'Time is required',
        'doctor_required' => 'Doctor is required',
        'studio_required' => 'Practice is required',
        'invalid_date' => 'The selected date is not valid',
        'past_date' => 'You cannot select a past date',
        'appointment_not_available' => 'The selected time is no longer available',
    ],
];
