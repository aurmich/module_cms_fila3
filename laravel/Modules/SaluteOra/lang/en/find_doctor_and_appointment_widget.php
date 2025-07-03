<?php

declare(strict_types=1);

return [
    'widget' => [
        'title' => 'Find Doctor and Book Appointment',
        'description' => 'Search for a doctor in your area and book an appointment online',
    ],
    
    'steps' => [
        'search_step' => [
            'label' => 'Search Doctor',
            'description' => 'Select specialization and location to find the right doctor',
            'icon' => 'heroicon-o-magnifying-glass',
        ],
        'studio_step' => [
            'label' => 'Choose Studio',
            'description' => 'Select the medical studio most convenient for you',
            'icon' => 'heroicon-o-building-office',
        ],
        'date_step' => [
            'label' => 'Select Date',
            'description' => 'Choose the most suitable date for your appointment',
            'icon' => 'heroicon-o-calendar-days',
        ],
        'time_step' => [
            'label' => 'Time',
            'description' => 'Select your preferred time for the visit',
            'icon' => 'heroicon-o-clock',
        ],
        'confirm_step' => [
            'label' => 'Confirm',
            'description' => 'Verify details and confirm your booking',
            'icon' => 'heroicon-o-check-circle',
        ],
    ],
    
    'fields' => [
        'specialization' => [
            'label' => 'Specialization',
            'placeholder' => 'Select a medical specialization',
            'helper_text' => '',
        ],
        'location' => [
            'label' => 'Location',
            'placeholder' => 'Enter your city or area',
            'helper_text' => '',
        ],
        'region' => [
            'label' => 'Region',
            'placeholder' => 'Select the region',
            'helper_text' => '',
        ],
        'province' => [
            'label' => 'Province',
            'placeholder' => 'Select the province',
            'helper_text' => '',
        ],
        'city' => [
            'label' => 'City',
            'placeholder' => 'Select the city',
            'helper_text' => '',
        ],
        'cap' => [
            'label' => 'ZIP Code',
            'placeholder' => 'Enter the postal code',
            'helper_text' => '',
        ],
        'appointment_type' => [
            'label' => 'Appointment Type',
            'placeholder' => 'Select the type of visit',
            'helper_text' => '',
        ],
        'selected_studio' => [
            'label' => 'Selected Studio',
            'placeholder' => 'No studio selected',
            'helper_text' => '',
        ],
        'selected_studio_name' => [
            'label' => 'Studio Name',
            'placeholder' => 'Medical studio name',
            'helper_text' => '',
        ],
        'doctor_id' => [
            'label' => 'Doctor',
            'placeholder' => 'Select a doctor',
            'helper_text' => '',
        ],
        'studio_id' => [
            'label' => 'Studio',
            'placeholder' => 'Select a studio',
            'helper_text' => '',
        ],
        'studio_name' => [
            'label' => 'Studio Name',
            'placeholder' => 'Medical studio name',
            'helper_text' => '',
        ],
        'appointment_date' => [
            'label' => 'Appointment Date',
            'placeholder' => 'Select a date',
            'helper_text' => '',
        ],
        'appointment_time' => [
            'label' => 'Appointment Time',
            'placeholder' => 'Select a time',
            'helper_text' => '',
        ],
        'appointment_time_display' => [
            'label' => 'Selected Time',
            'placeholder' => 'No time selected',
            'helper_text' => '',
        ],
        'date' => [
            'label' => 'Date',
            'placeholder' => 'Select a date',
            'helper_text' => '',
        ],
        'time' => [
            'label' => 'Time',
            'placeholder' => 'Select a time',
            'helper_text' => '',
        ],
        'notes' => [
            'label' => 'Additional Notes',
            'placeholder' => 'Enter any notes or special requests',
            'helper_text' => '',
        ],
        'search' => [
            'label' => 'Search',
            'placeholder' => 'Search for doctors in your area',
            'helper_text' => '',
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
        'studio_required' => 'Studio is required',
        'invalid_date' => 'The selected date is not valid',
        'past_date' => 'You cannot select a past date',
        'appointment_not_available' => 'The selected time is no longer available',
    ],
]; 