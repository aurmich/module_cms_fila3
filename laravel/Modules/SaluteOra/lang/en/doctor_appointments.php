<?php

declare(strict_types=1);

return [
    'title' => 'Doctor Appointments',
    'description' => 'Appointment management for doctors',
    
    'actions' => [
        'delete' => [
            'label' => 'Delete',
            'tooltip' => 'Delete this appointment',
            'confirmation' => 'Are you sure you want to delete this appointment?',
        ],
        'accept' => [
            'label' => 'Accept',
            'tooltip' => 'Accept this appointment',
            'confirmation' => 'Are you sure you want to accept this appointment?',
        ],
        'confirm' => [
            'label' => 'Confirm',
            'tooltip' => 'Confirm this appointment',
            'confirmation' => 'Are you sure you want to confirm this appointment?',
        ],
        'confirmed' => [
            'label' => 'Confirmed',
            'tooltip' => 'Appointment confirmed',
        ],
        'confirmAction' => [
            'label' => 'Confirm Action',
            'tooltip' => 'Execute confirmation action',
        ],
        'rejectAction' => [
            'label' => 'Reject',
            'tooltip' => 'Reject this appointment',
            'confirmation' => 'Are you sure you want to reject this appointment?',
        ],
        'info' => [
            'label' => 'Information',
            'tooltip' => 'View detailed information',
        ],
    ],
    
    'messages' => [
        'appointment_accepted' => 'Appointment accepted successfully',
        'appointment_confirmed' => 'Appointment confirmed successfully',
        'appointment_rejected' => 'Appointment rejected successfully',
        'appointment_deleted' => 'Appointment deleted successfully',
        'error_occurred' => 'An error occurred',
    ],
    
    'status' => [
        'pending' => 'Pending',
        'confirmed' => 'Confirmed',
        'rejected' => 'Rejected',
        'completed' => 'Completed',
        'cancelled' => 'Cancelled',
    ],
];
