<?php

declare(strict_types=1);

return [
    'hero' => [
        'accepted_appointments' => [
            'title' => 'Accepted Appointments',
            'description' => 'View all appointments that have been confirmed',
            'back_button' => [
                'label' => 'Go back',
                'tooltip' => 'Return to previous page',
            ],
        ],
        'pending_appointments' => [
            'title' => 'Pending Appointments',
            'description' => 'View all appointments waiting for confirmation',
        ],
        'completed_appointments' => [
            'title' => 'Completed Appointments',
            'description' => 'View all appointments that have been completed',
        ],
        'rejected_appointments' => [
            'title' => 'Rejected Appointments',
            'description' => 'View all appointments that have been rejected',
        ],
        'entry_appointments' => [
            'title' => 'Incoming Appointments',
            'description' => 'View all new appointment requests',
        ],
    ],
    'fields' => [
        'state' => [
            'label' => 'State',
            'placeholder' => 'Select state',
            'help' => 'Current appointment state',
        ],
        'date' => [
            'label' => 'Date',
            'placeholder' => 'Select date',
            'help' => 'Appointment date',
        ],
        'time' => [
            'label' => 'Time',
            'placeholder' => 'Select time',
            'help' => 'Appointment time',
        ],
        'notes' => [
            'label' => 'Notes',
            'placeholder' => 'Enter additional notes',
            'help' => 'Optional notes for the appointment',
        ],
        'patient' => [
            'label' => 'Patient',
            'placeholder' => 'Select patient',
            'help' => 'Patient for whom the appointment is scheduled',
        ],
        'doctor' => [
            'label' => 'Doctor',
            'placeholder' => 'Select doctor',
            'help' => 'Doctor who will perform the visit',
        ],
        'studio' => [
            'label' => 'Studio',
            'placeholder' => 'Select studio',
            'help' => 'Studio where the appointment will take place',
        ],
        'service' => [
            'label' => 'Service',
            'placeholder' => 'Select service',
            'help' => 'Type of service requested',
        ],
        'duration' => [
            'label' => 'Duration',
            'placeholder' => 'Duration in minutes',
            'help' => 'Estimated appointment duration',
        ],
        'emergency' => [
            'label' => 'Emergency',
            'placeholder' => 'Select if it is an emergency',
            'help' => 'Indicates if the appointment is urgent',
        ],
    ],
    'states' => [
        'pending' => 'Pending',
        'confirmed' => 'Confirmed',
        'scheduled' => 'Scheduled',
        'in_progress' => 'In Progress',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
        'rejected' => 'Rejected',
        'no_show' => 'No Show',
        'rescheduled' => 'Rescheduled',
    ],
    'fields' => [
        'state' => [
            'label' => 'Status',
            'placeholder' => 'Select status',
            'help' => 'Current appointment status',
            'helper_text' => '',
        ],
        'title' => [
            'label' => 'Title',
            'placeholder' => 'Enter appointment title',
            'help' => 'Brief description of the appointment',
            'helper_text' => '',
        ],
        'patient_id' => [
            'label' => 'Patient',
            'placeholder' => 'Select patient',
            'help' => 'Patient for whom the appointment is scheduled',
            'helper_text' => '',
        ],
        'doctor_id' => [
            'label' => 'Doctor',
            'placeholder' => 'Select doctor',
            'help' => 'Doctor who will conduct the appointment',
            'helper_text' => '',
        ],
        'studio_id' => [
            'label' => 'Studio',
            'placeholder' => 'Select studio',
            'help' => 'Studio where the appointment will take place',
            'helper_text' => '',
        ],
        'start_time' => [
            'label' => 'Start Time',
            'placeholder' => 'Select start time',
            'help' => 'When the appointment starts',
            'helper_text' => '',
        ],
        'end_time' => [
            'label' => 'End Time',
            'placeholder' => 'Select end time',
            'help' => 'When the appointment ends',
            'helper_text' => '',
        ],
        'status' => [
            'label' => 'Status',
            'placeholder' => 'Select status',
            'help' => 'Current appointment status',
            'helper_text' => '',
        ],
        'type' => [
            'label' => 'Appointment Type',
            'placeholder' => 'Select type',
            'help' => 'Type of medical appointment',
            'helper_text' => '',
        ],
        'notes' => [
            'label' => 'Notes',
            'placeholder' => 'Enter any notes',
            'help' => 'Additional information about the appointment',
            'helper_text' => '',
        ],
        'reason' => [
            'label' => 'Reason',
            'placeholder' => 'Enter appointment reason',
            'help' => 'Main reason for the visit',
            'helper_text' => '',
        ],
        'emergency' => [
            'label' => 'Emergency',
            'placeholder' => 'Indicate if it\'s an emergency',
            'help' => 'Mark as emergency appointment',
            'helper_text' => '',
        ],
    ],
    'accepted_appointments' => [
        'title' => 'Accepted Appointments',
        'back_home' => 'Back to Home',
        'redirecting' => 'Redirecting...',
        'click_here' => 'click here',
        'if_not_redirected' => 'If you are not redirected automatically, :link.',
    ],
];
