<?php

return [
    'navigation' => [
        'label' => 'Availability Management',
        'group' => 'Schedule',
        'icon' => 'heroicon-o-calendar',
        'sort' => '40',
        'tooltip' => 'Manage medical practice availability',
    ],
    'model' => [
        'label' => 'Doctor Availability',
        'plural_label' => 'Doctors Availability',
    ],
    'actions' => [
        'create' => [
            'label' => 'Add Availability',
            'tooltip' => 'Add new availability',
            'icon' => 'heroicon-o-plus',
        ],
        'edit' => [
            'label' => 'Edit',
            'tooltip' => 'Edit this availability',
            'icon' => 'heroicon-o-pencil',
        ],
        'delete' => [
            'label' => 'Delete',
            'tooltip' => 'Delete this availability',
            'icon' => 'heroicon-o-trash',
        ],
        'view' => [
            'label' => 'View',
            'tooltip' => 'View availability details',
            'icon' => 'heroicon-o-eye',
        ],
        'toggle_status' => [
            'label' => 'Toggle Status',
            'tooltip' => 'Activate or deactivate this availability',
            'icon' => 'heroicon-o-arrow-path',
        ],
    ],
    'fields' => [
        'doctor_id' => [
            'label' => 'Doctor',
            'tooltip' => 'The doctor this availability belongs to',
            'placeholder' => 'Select dentist',
            'helper_text' => 'Select the doctor to assign this availability to',
        ],
        'studio_id' => [
            'label' => 'Practice',
            'tooltip' => 'Associated medical practice',
            'placeholder' => 'Select practice',
            'helper_text' => 'The medical practice where the doctor will be available',
        ],
        'day_of_week' => [
            'label' => 'Day of Week',
            'tooltip' => 'Day of the week for this availability',
            'placeholder' => 'Select day',
            'helper_text' => 'The day of the week the doctor is available',
            'options' => [
                '1' => 'Monday',
                '2' => 'Tuesday',
                '3' => 'Wednesday',
                '4' => 'Thursday',
                '5' => 'Friday',
                '6' => 'Saturday',
                '7' => 'Sunday',
            ],
        ],
        'start_time' => [
            'label' => 'Start Time',
            'tooltip' => 'Start time of availability',
            'placeholder' => 'Select start time',
            'helper_text' => 'Time when the doctor becomes available',
        ],
        'end_time' => [
            'label' => 'End Time',
            'tooltip' => 'End time of availability',
            'placeholder' => 'Select end time',
            'helper_text' => 'Time when the doctor becomes unavailable',
        ],
        'date_range' => [
            'label' => 'Validity Period',
            'tooltip' => 'Period when this availability is valid',
            'placeholder' => 'Select period',
            'helper_text' => 'Date range when this availability applies',
            'start_date' => [
                'label' => 'Start Date',
                'placeholder' => 'Select start date',
            ],
            'end_date' => [
                'label' => 'End Date',
                'placeholder' => 'Select end date',
            ],
        ],
        'is_active' => [
            'label' => 'Active',
            'tooltip' => 'Indicates if this availability is active',
            'helper_text' => 'If active, this availability will be visible to patients',
        ],
        'created_at' => [
            'label' => 'Creation Date',
            'tooltip' => 'Date this record was created',
        ],
        'updated_at' => [
            'label' => 'Last Update',
            'tooltip' => 'Date this record was last updated',
        ],
    ],
    'filters' => [
        'title' => 'Filters',
        'studio' => 'Filter by Practice',
        'dentist' => 'Filter by Doctor',
        'day' => 'Filter by Day',
        'active' => 'Active Only',
        'inactive' => 'Inactive Only',
    ],
    'table' => [
        'empty' => 'No availability found',
        'loading' => 'Loading availability...',
    ],
    'messages' => [
        'success' => [
            'created' => 'Availability created successfully',
            'updated' => 'Availability updated successfully',
            'deleted' => 'Availability deleted successfully',
            'activated' => 'Availability activated successfully',
            'deactivated' => 'Availability deactivated successfully',
        ],
        'error' => [
            'create' => 'Error creating availability',
            'update' => 'Error updating availability',
            'delete' => 'Error deleting availability',
            'toggle' => 'Error toggling availability status',
        ],
        'confirm' => [
            'delete' => 'Are you sure you want to delete this availability?',
        ],
    ],
    'calendar' => [
        'title' => 'Availability Calendar',
        'loading' => 'Loading calendar...',
        'empty' => 'No availability configured',
        'today' => 'Today',
        'month' => 'Month',
        'week' => 'Week',
        'day' => 'Day',
        'list' => 'List',
    ],
];
