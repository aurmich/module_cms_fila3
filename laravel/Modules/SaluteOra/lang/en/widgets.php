<?php

return [
    'doctor_availabilities' => [
        'schedule' => [
            'no_schedule' => 'No schedule available',
            'click_edit_to_configure' => 'Click edit to configure your availability',
        ],
    ],
    'studio_overview' => [
        'title' => 'Studios Overview',
        'stats' => [
            'total' => 'Total Studios',
            'active' => 'Active Studios',
            'inactive' => 'Inactive Studios',
            'cities' => 'Cities Covered',
            'doctors' => 'Associated Doctors',
            'appointments' => 'Monthly Appointments',
        ],
        'chart' => [
            'title' => 'Distribution by City',
            'empty' => 'No data available',
        ],
    ],
    'find_doctor_and_appointment' => [
        'title' => 'Find doctor and book appointment',
        'description' => 'Select your area, choose a doctor and book an appointment',
        'steps' => [
            'studio' => [
                'title' => 'Select Studio',
                'description' => 'Choose the medical studio in your area',
            ],
            'date' => [
                'title' => 'Date and Time',
                'description' => 'Select the date and time for your appointment',
            ],
            'confirmation' => [
                'title' => 'Confirmation',
                'description' => 'Check the details and confirm the booking',
            ],
        ],
        'studio_step' => [
            'title' => 'Select Studio',
            'description' => 'Choose the medical studio in your area',
        ],
        'date_step' => [
            'title' => 'Date and Time',
            'description' => 'Select the date and time for your appointment',
        ],
        'confirm_step' => [
            'title' => 'Confirm Appointment',
            'description' => 'Check your appointment details before confirming',
        ],
        'fields' => [
            'cap' => [
                'label' => 'ZIP Code',
                'placeholder' => 'Enter ZIP code',
                'helper_text' => 'Enter the postal code of your area',
            ],
            'studio' => [
                'label' => 'Studio',
                'placeholder' => 'Selected studio name',
                'helper_text' => 'Dental studio for the booking',
            ],
            'doctor' => [
                'label' => 'Doctor',
                'placeholder' => 'Select a doctor',
                'helper_text' => 'Choose the doctor you want to book the appointment with',
            ],
            'appointment_date' => [
                'label' => 'Appointment Date',
                'placeholder' => 'Select a date',
                'helper_text' => 'Choose the date for your appointment',
            ],
            'appointment_time' => [
                'label' => 'Time',
                'placeholder' => 'Select a time',
                'helper_text' => 'Choose the time for your appointment',
            ],
            'notes' => [
                'label' => 'Notes',
                'placeholder' => 'Add any notes or special requests',
                'helper_text' => 'Additional information for the doctor (optional)',
            ],
        ],
        'actions' => [
            'next' => [
                'label' => 'Next',
            ],
            'previous' => [
                'label' => 'Previous',
            ],
            'submit' => [
                'label' => 'Confirm Booking',
            ],
        ],
        'messages' => [
            'success' => 'Appointment booked successfully!',
            'error' => 'An error occurred while booking.',
            'no_doctors' => 'No doctors available for this studio.',
            'no_times' => 'No time slots available for the selected date.',
        ],
    ],
    'studio_filter' => [
        'title' => 'Studio Filter',
        'description' => 'Select the studio to filter the displayed data',
        'current_studio' => [
            'label' => 'Current Studio',
            'no_studio' => 'No studio selected',
            'primary_badge' => 'Primary',
        ],
        'doctor_info' => [
            'label' => 'Doctor Information',
            'full_name' => 'Dr. :first_name :last_name',
            'studios_count' => '{0} No studio|{1} 1 studio|[2,*] :count studios',
        ],
        'studio_selector' => [
            'label' => 'Change Studio',
            'placeholder' => 'Select a studio...',
            'help_text' => 'Changing studio will automatically update all filters',
        ],
        'studio_details' => [
            'name' => 'Studio',
            'description' => 'Description',
            'status' => 'Status',
            'address' => 'Address',
            'phone' => 'Phone',
            'email' => 'Email',
            'website' => 'Website',
            'opening_hours' => 'Opening Hours',
            'doctors' => 'Associated Doctors',
            'created_at' => 'Created on',
            'general_info' => 'General Information',
            'contact_info' => 'Contact',
            'no_address' => 'Address not specified',
            'closed' => 'Closed',
            'view_on_map' => 'View on Map',
            'not_found' => [
                'title' => 'Studio Not Found',
                'description' => 'Studio information is not available.',
            ],
        ],
        'status' => [
            'active' => 'Active',
            'inactive' => 'Inactive',
        ],
        'actions' => [
            'switch_studio' => [
                'label' => 'Quick Actions',
            ],
            'view_details' => [
                'label' => 'View Details',
                'tooltip' => 'Show detailed studio information',
            ],
            'manage_schedule' => [
                'label' => 'Manage Schedule',
                'tooltip' => 'Edit studio opening hours',
            ],
        ],
        'empty_states' => [
            'no_current_studio' => [
                'title' => 'No Studio Selected',
                'description' => 'Select a studio to view details and filter data.',
            ],
        ],
        'messages' => [
            'studio_changed' => 'Studio changed successfully',
            'studio_change_error' => 'Error changing studio',
        ],
    ],
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
    'doctor_appointments' => [
        'title' => 'Pending Appointments',
        'empty' => [
            'title' => 'No pending appointments',
            'description' => 'You have no appointments to confirm at this time.',
        ],
        'actions' => [
            'view_details' => [
                'label' => 'View Details',
                'tooltip' => 'Show appointment details',
            ],
            'confirm' => [
                'label' => 'Confirm',
                'tooltip' => 'Confirm the appointment',
                'modal' => [
                    'title' => 'Confirm Appointment',
                    'description' => 'Are you sure you want to confirm this appointment?',
                    'confirm_button' => 'Confirm',
                    'cancel_button' => 'Cancel',
                ],
            ],
            'reject' => [
                'label' => 'Reject',
                'tooltip' => 'Reject the appointment',
                'modal' => [
                    'title' => 'Reject Appointment',
                    'description' => 'Are you sure you want to reject this appointment?',
                    'confirm_button' => 'Reject',
                    'cancel_button' => 'Cancel',
                ],
            ],
        ],
        'messages' => [
            'appointment_confirmed' => 'Appointment confirmed successfully',
            'appointment_rejected' => 'Appointment rejected successfully',
        ],
        'errors' => [
            'cannot_confirm' => 'Cannot confirm this appointment',
            'cannot_reject' => 'Cannot reject this appointment',
            'confirm_failed' => 'Error confirming the appointment',
            'reject_failed' => 'Error rejecting the appointment',
            'appointment_not_found' => 'Appointment not found',
        ],
        'status' => [
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'rejected' => 'Rejected',
        ],
    ],
];
