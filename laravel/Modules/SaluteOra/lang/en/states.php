<?php

declare(strict_types=1);

return [
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

    // Patient States - Patient States
    'patient' => [
        'active' => [
            'label' => 'Active',
            'description' => 'Patient active in the system',
            'tooltip' => 'The patient is active and can book appointments',
        ],
        'integration_requested' => [
            'label' => 'Integration Requested',
            'description' => 'Integration request in progress',
            'tooltip' => 'The patient has requested integration',
        ],
        'integration_completed' => [
            'label' => 'Integration Completed',
            'description' => 'Integration completed successfully',
            'tooltip' => 'The patient has completed the integration',
        ],
    ],

    // Doctor States - Doctor States
    'doctor' => [
        'active' => [
            'label' => 'Active',
            'description' => 'Doctor active in the system',
            'tooltip' => 'The doctor is active and can receive appointments',
        ],
        'integration_requested' => [
            'label' => 'Integration Requested',
            'description' => 'Integration request in progress',
            'tooltip' => 'The doctor has requested integration',
        ],
        'integration_completed' => [
            'label' => 'Integration Completed',
            'description' => 'Integration completed successfully',
            'tooltip' => 'The doctor has completed the integration',
        ],
    ],

    'appointment' => [
        'pending' => [
            'label' => 'Pending',
            'color' => 'warning',
            'icon' => 'heroicon-o-clock',
            'modal_heading' => 'Pending Appointment',
            'modal_description' => 'This appointment is awaiting confirmation.',
            'bg_color' => '#f59e0b',
        ],
        'confirmed' => [
            'label' => 'Confirmed',
            'color' => 'success',
            'icon' => 'heroicon-o-check-circle',
            'modal_heading' => 'Confirm Appointment',
            'modal_description' => 'Are you sure you want to confirm this appointment?',
            'bg_color' => '#10b981',
        ],
        'scheduled' => [
            'label' => 'Scheduled',
            'color' => 'info',
            'icon' => 'heroicon-o-calendar',
            'modal_heading' => 'Scheduled Appointment',
            'modal_description' => 'This appointment has been scheduled in the calendar.',
            'bg_color' => '#3b82f6',
        ],
        'in_progress' => [
            'label' => 'In Progress',
            'color' => 'warning',
            'icon' => 'heroicon-o-clock',
            'modal_heading' => 'Visit in Progress',
            'modal_description' => 'The medical visit is currently in progress.',
            'bg_color' => '#f59e0b',
        ],
        'completed' => [
            'label' => 'Completed',
            'color' => 'success',
            'icon' => 'heroicon-o-check-badge',
            'modal_heading' => 'Visit Completed',
            'modal_description' => 'The visit has been completed successfully.',
            'bg_color' => '#10b981',
        ],
        'cancelled' => [
            'label' => 'Cancelled',
            'color' => 'danger',
            'icon' => 'heroicon-o-x-circle',
            'modal_heading' => 'Cancel Appointment',
            'modal_description' => 'Are you sure you want to cancel this appointment?',
            'bg_color' => '#ef4444',
        ],
        'rejected' => [
            'label' => 'Rejected',
            'color' => 'danger',
            'icon' => 'heroicon-o-x-mark',
            'modal_heading' => 'Reject Appointment',
            'modal_description' => 'Are you sure you want to reject this appointment?',
            'bg_color' => '#ef4444',
        ],
        'no_show' => [
            'label' => 'No Show',
            'color' => 'danger',
            'icon' => 'heroicon-o-exclamation-circle',
            'modal_heading' => 'Patient Absent',
            'modal_description' => 'The patient did not show up for the appointment.',
            'bg_color' => '#ef4444',
        ],
        'rescheduled' => [
            'label' => 'Rescheduled',
            'color' => 'info',
            'bg_color' => '#3b82f6',
            'icon' => 'heroicon-o-arrow-path',
            'modal_heading' => 'Reschedule Appointment',
            'modal_description' => 'This appointment has been rescheduled for a new date.',
        ],
        'report_pending' => [
            'label' => 'Report Pending',
            'color' => 'warning',
            'bg_color' => '#f59e0b',
            'icon' => 'heroicon-o-document-text',
            'modal_heading' => 'Report Pending',
            'modal_description' => 'The appointment is completed but the medical report is still pending compilation.',
        ],
        'report_completed' => [
            'label' => 'Report Completed',
            'color' => 'success',
            'bg_color' => '#10b981',
            'icon' => 'heroicon-o-document-check',
            'modal_heading' => 'Report Completed',
            'modal_description' => 'The medical report has been completed and the appointment can be finalized.',
        ],
        'banned' => [
            'label' => 'Banned',
            'color' => 'danger',
            'bg_color' => '#dc2626',
            'icon' => 'heroicon-o-no-symbol',
            'modal_heading' => 'User Banned',
            'modal_description' => 'This user has been banned from the system for violations.',
        ],
        'refund_pending' => [
            'label' => 'Refund Pending',
            'color' => 'warning',
            'bg_color' => '#f59e0b',
            'icon' => 'heroicon-o-currency-euro',
            'modal_heading' => 'Refund Pending',
            'modal_description' => 'The refund for this appointment is pending processing.',
        ],
        'refund_accepted' => [
            'label' => 'Refund Accepted',
            'color' => 'success',
            'bg_color' => '#10b981',
            'icon' => 'heroicon-o-check-circle',
            'modal_heading' => 'Refund Accepted',
            'modal_description' => 'The refund has been accepted and will be processed.',
        ],
        'refund_completed' => [
            'label' => 'Refund Completed',
            'color' => 'success',
            'bg_color' => '#10b981',
            'icon' => 'heroicon-o-banknotes',
            'modal_heading' => 'Refund Completed',
            'modal_description' => 'The refund has been completed and paid to the patient.',
        ],
        'refund_to_integrate' => [
            'label' => 'Refund to Integrate',
            'color' => 'info',
            'bg_color' => '#3b82f6',
            'icon' => 'heroicon-o-arrow-path',
            'modal_heading' => 'Refund to Integrate',
            'modal_description' => 'The refund needs to be integrated with other services.',
        ],
        'pro_bono' => [
            'label' => 'Pro Bono',
            'color' => 'info',
            'bg_color' => '#3b82f6',
            'icon' => 'heroicon-o-heart',
            'modal_heading' => 'Pro Bono Service',
            'modal_description' => 'This appointment was provided as a free service.',
        ],
    ],
];
