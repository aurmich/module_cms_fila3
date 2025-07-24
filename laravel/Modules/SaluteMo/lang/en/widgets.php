<?php

declare(strict_types=1);

return [
    'stats' => [
        'total_users' => 'Total Users',
        'active_sessions' => 'Active Sessions',
        'avg_time' => 'Avg. Time on Site',
        'increase' => ':percent% increase',
        'decrease' => ':percent% decrease',
    ],
    'appointment_overview' => [
        'title' => 'Appointments Overview',
        'description' => 'Compact overview of appointments by status',
        'empty_state' => 'No appointment states available',
        'last_updated' => 'Last updated',
        'total_states' => 'Total states',
        'helper_text' => '',
    ],
    'patient_registration_trend' => [
        'title' => 'Patient Registration Trend',
        'description' => 'Patient registration trend over the last 30 days',
        'empty_state' => 'No data available for the selected period',
        'loading' => 'Loading registration trend...',
        'last_updated' => 'Updated: :time',
        'total_registrations' => 'Total registrations: :count',
        'period' => [
            'label' => 'Period',
            'options' => [
                '7_days' => 'Last 7 days',
                '30_days' => 'Last 30 days',
                '90_days' => 'Last 90 days',
            ],
        ],
    ],
    'user_status_distribution' => [
        'title' => 'User Status Distribution',
        'description' => 'Distribution of user states in the system',
        'empty_state' => 'No users found',
        'loading' => 'Loading status distribution...',
        'total_users' => 'Total users: :count',
        'statuses' => [
            'active' => [
                'label' => 'Active',
                'description' => 'Active users in the system',
            ],
            'inactive' => [
                'label' => 'Inactive',
                'description' => 'Inactive users',
            ],
            'pending' => [
                'label' => 'Pending',
                'description' => 'Users awaiting approval',
            ],
            'suspended' => [
                'label' => 'Suspended',
                'description' => 'Temporarily suspended users',
            ],
        ],
    ],
    'doctor_registration_trend' => [
        'title' => 'Doctor Registration Trend',
        'description' => 'Doctor registration trend over the last 30 days',
        'empty_state' => 'No data available for the selected period',
        'loading' => 'Loading registration trend...',
        'last_updated' => 'Updated: :time',
        'total_registrations' => 'Total registrations: :count',
        'period' => [
            'label' => 'Period',
            'options' => [
                '7_days' => 'Last 7 days',
                '30_days' => 'Last 30 days',
                '90_days' => 'Last 90 days',
            ],
        ],
    ],
    'doctor_status_distribution' => [
        'title' => 'Doctor Status Distribution',
        'description' => 'Distribution of doctor states in the system',
        'empty_state' => 'No doctors found',
        'loading' => 'Loading status distribution...',
        'total_doctors' => 'Total doctors: :count',
        'statuses' => [
            'active' => [
                'label' => 'Active',
                'description' => 'Active doctors in the system',
            ],
            'inactive' => [
                'label' => 'Inactive',
                'description' => 'Inactive doctors',
            ],
            'pending' => [
                'label' => 'Pending',
                'description' => 'Doctors awaiting verification',
            ],
            'verified' => [
                'label' => 'Verified',
                'description' => 'Verified and approved doctors',
            ],
        ],
    ],
    'appointment_creation_trend' => [
        'title' => 'Appointment Creation Trend',
        'description' => 'Appointment creation trend over the last 30 days',
        'empty_state' => 'No data available for the selected period',
        'loading' => 'Loading appointment trend...',
        'last_updated' => 'Updated: :time',
        'total_appointments' => 'Total appointments: :count',
        'period' => [
            'label' => 'Period',
            'options' => [
                '7_days' => 'Last 7 days',
                '30_days' => 'Last 30 days',
                '90_days' => 'Last 90 days',
            ],
        ],
    ],
    'appointment_status_distribution' => [
        'title' => 'Appointment Status Distribution',
        'description' => 'Distribution of appointment states in the system',
        'empty_state' => 'No appointments found',
        'loading' => 'Loading status distribution...',
        'total_appointments' => 'Total appointments: :count',
        'statuses' => [
            'scheduled' => [
                'label' => 'Scheduled',
                'description' => 'Scheduled appointments',
            ],
            'confirmed' => [
                'label' => 'Confirmed',
                'description' => 'Confirmed appointments',
            ],
            'completed' => [
                'label' => 'Completed',
                'description' => 'Completed appointments',
            ],
            'cancelled' => [
                'label' => 'Cancelled',
                'description' => 'Cancelled appointments',
            ],
            'no_show' => [
                'label' => 'No Show',
                'description' => 'Appointments with no show',
            ],
        ],
    ],
    'dashboard' => [
        'title' => 'Administrative Dashboard',
        'description' => 'Complete overview of the SaluteMo system',
        'welcome_message' => 'Welcome to the administrative dashboard',
        'last_updated' => 'Last updated: :time',
        'refresh' => 'Refresh data',
        'loading' => 'Loading dashboard...',
    ],
];
