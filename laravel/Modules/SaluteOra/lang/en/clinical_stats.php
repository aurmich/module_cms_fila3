<?php

return [
    'fields' => [
        'tenant_id' => [
            'label' => 'Facility',
            'placeholder' => 'Select facility',
            'tooltip' => 'Select the facility to view statistics for',
        ],
        'doctor_id' => [
            'label' => 'Doctor',
            'placeholder' => 'Select doctor',
            'tooltip' => 'Select the doctor to view statistics for',
        ],
        'start_date' => [
            'label' => 'Start date',
            'placeholder' => 'Select start date',
            'tooltip' => 'Start date of the period to analyze',
        ],
        'end_date' => [
            'label' => 'End date',
            'placeholder' => 'Select end date',
            'tooltip' => 'End date of the period to analyze',
        ],
    ],
    'navigation' => [
        'label' => 'Clinical Statistics',
        'icon' => 'heroicon-o-chart-bar',
        'group' => 'Statistics',
    ],
    'stats' => [
        'total_appointments' => 'Total Appointments',
        'completed_appointments' => 'Completed Appointments',
        'cancelled_appointments' => 'Cancelled Appointments',
        'no_show_appointments' => 'No Show Appointments',
        'completion_rate' => 'Completion Rate',
        'cancellation_rate' => 'Cancellation Rate',
        'no_show_rate' => 'No Show Rate',
    ],
];
