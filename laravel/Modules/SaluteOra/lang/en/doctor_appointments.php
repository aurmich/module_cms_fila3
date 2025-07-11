<?php

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
    'states' => [
        'pending' => [
            'label' => 'In attesa',
            'color' => 'warning',
            'bg_color' => '#FEF3C7',
            'icon' => 'heroicon-o-clock',
        ],
        'confirmed' => [
            'label' => 'Confermato',
            'color' => 'success',
            'bg_color' => '#D1FAE5',
            'icon' => 'heroicon-o-check-circle',
        ],
        'rejected' => [
            'label' => 'Rifiutato',
            'color' => 'danger',
            'bg_color' => '#FEE2E2',
            'icon' => 'heroicon-o-x-circle',
        ],
        'completed' => [
            'label' => 'Completato',
            'color' => 'success',
            'bg_color' => '#ECFDF5',
            'icon' => 'heroicon-o-check-badge',
        ],
        'cancelled' => [
            'label' => 'Annullato',
            'color' => 'gray',
            'bg_color' => '#F3F4F6',
            'icon' => 'heroicon-o-no-symbol',
        ],
    ],
    'fields' => [
        'message' => [
            'description' => 'Messaggio',
            'helper_text' => '',
            'placeholder' => '',
            'label' => 'Messaggio',
        ],
    ],
];
