<?php

declare(strict_types=1);

return [
    // User States - Stati Utente
    'user' => [
        'pending' => [
            'label' => 'Pending',
            'description' => 'User awaiting approval',
            'tooltip' => 'The user is waiting to be approved',
        ],
        'active' => [
            'label' => 'Active',
            'description' => 'Active user in the system',
            'tooltip' => 'The user is active and can use the system',
        ],
        'inactive' => [
            'label' => 'Inactive',
            'description' => 'Inactive user in the system',
            'tooltip' => 'The user has been deactivated',
        ],
        'rejected' => [
            'label' => 'Rejected',
            'description' => 'Rejected user',
            'tooltip' => 'The user has been rejected',
        ],
        'suspended' => [
            'label' => 'Suspended',
            'description' => 'Suspended user',
            'tooltip' => 'The user has been suspended',
        ],
        'integration_requested' => [
            'label' => 'Integration Requested',
            'description' => 'Integration request in progress',
            'tooltip' => 'The user has requested integration',
        ],
    ],

    // Appointment States - Stati degli Appuntamenti
    'appointment' => [
        'pending' => [
            'label' => 'Pending',
            'color' => 'warning',
            'icon' => 'heroicon-o-clock',
            'modal_heading' => 'Pending Appointment',
            'modal_description' => 'This appointment is awaiting confirmation.',
        ],
        'confirmed' => [
            'label' => 'Confirmed',
            'color' => 'success',
            'icon' => 'heroicon-o-check-circle',
            'modal_heading' => 'Confirm Appointment',
            'modal_description' => 'Are you sure you want to confirm this appointment?',
        ],
        'scheduled' => [
            'label' => 'Scheduled',
            'color' => 'info',
            'icon' => 'heroicon-o-calendar',
            'modal_heading' => 'Scheduled Appointment',
            'modal_description' => 'This appointment has been scheduled in the calendar.',
        ],
        'in_progress' => [
            'label' => 'In Progress',
            'color' => 'warning',
            'icon' => 'heroicon-o-clock',
            'modal_heading' => 'Visit in Progress',
            'modal_description' => 'The medical visit is currently in progress.',
        ],
        'completed' => [
            'label' => 'Completed',
            'color' => 'success',
            'icon' => 'heroicon-o-check-badge',
            'modal_heading' => 'Visit Completed',
            'modal_description' => 'The visit has been completed successfully.',
        ],
        'cancelled' => [
            'label' => 'Cancelled',
            'color' => 'danger',
            'icon' => 'heroicon-o-x-circle',
            'modal_heading' => 'Cancel Appointment',
            'modal_description' => 'Are you sure you want to cancel this appointment?',
        ],
        'rejected' => [
            'label' => 'Rejected',
            'color' => 'danger', 
            'icon' => 'heroicon-o-x-mark',
            'modal_heading' => 'Reject Appointment',
            'modal_description' => 'Are you sure you want to reject this appointment?',
        ],
        'no_show' => [
            'label' => 'No Show',
            'color' => 'danger',
            'icon' => 'heroicon-o-exclamation-circle',
            'modal_heading' => 'Patient Absent',
            'modal_description' => 'The patient did not show up for the appointment.',
        ],
        'rescheduled' => [
            'label' => 'Rescheduled',
            'color' => 'info',
            'icon' => 'heroicon-o-arrow-path',
            'modal_heading' => 'Reschedule Appointment',
            'modal_description' => 'This appointment has been rescheduled for a new date.',
        ],
    ],
]; 