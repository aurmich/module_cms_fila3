<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Appointment Workflow',
        'group' => 'Schedule',
        'icon' => 'heroicon-o-document-chart-bar',
        'sort' => 60,
        'tooltip' => 'Management of booking and appointment workflows',
    ],
    'model' => [
        'label' => 'Appointment Workflow',
        'plural_label' => 'Appointment Workflows',
    ],
    'actions' => [
        'create' => [
            'label' => 'Create New',
            'tooltip' => 'Create a new appointment workflow',
            'icon' => 'heroicon-o-plus',
        ],
        'edit' => [
            'label' => 'Edit',
            'tooltip' => 'Edit this appointment workflow',
            'icon' => 'heroicon-o-pencil',
        ],
        'delete' => [
            'label' => 'Delete',
            'tooltip' => 'Delete this appointment workflow',
            'icon' => 'heroicon-o-trash',
        ],
        'view' => [
            'label' => 'View',
            'tooltip' => 'View workflow details',
            'icon' => 'heroicon-o-eye',
        ],
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => 'Unique workflow identifier',
        ],
        'patient' => [
            'label' => 'Patient',
            'tooltip' => 'Patient associated with the workflow',
            'placeholder' => 'Select patient',
            'helper_text' => 'The patient who requested the appointment',
            'last_name' => [
                'label' => 'Last Name',
                'placeholder' => 'Enter last name',
                'help' => 'Enter the complete last name',
            ],
            'first_name' => [
                'label' => 'First Name',
                'placeholder' => 'Enter first name',
                'help' => 'Enter the complete first name',
            ],
        ],
        'current_step' => [
            'label' => 'Current Step',
            'tooltip' => 'Current step in the appointment workflow',
            'placeholder' => 'Select step',
            'helper_text' => 'Indicates where the appointment is in the process',
        ],
        'status' => [
            'label' => 'Status',
            'tooltip' => 'Current workflow status',
            'placeholder' => 'Select status',
            'helper_text' => 'Indicates if the workflow is active, completed, or cancelled',
            'options' => [
                'pending' => 'Pending',
                'active' => 'Active',
                'completed' => 'Completed',
                'cancelled' => 'Cancelled',
            ],
        ],
        'appointment' => [
            'label' => 'Appointment',
            'tooltip' => 'Appointment linked to the workflow',
            'placeholder' => 'Select appointment',
            'helper_text' => 'The appointment associated with this workflow',
            'title' => [
                'label' => 'Appointment Title',
                'tooltip' => 'Title of the linked appointment',
                'placeholder' => 'Enter title',
                'helper_text' => 'Brief description of the appointment',
            ],
        ],
        'started_at' => [
            'label' => 'Start Date',
            'tooltip' => 'Workflow start date',
            'placeholder' => 'Select start date',
            'helper_text' => 'When the booking workflow was started',
        ],
        'completed_at' => [
            'label' => 'Completion Date',
            'tooltip' => 'Workflow completion date',
            'placeholder' => 'Select completion date',
            'helper_text' => 'When the booking workflow was completed',
        ],
        'session_id' => [
            'label' => 'Session ID',
            'tooltip' => 'User session identifier',
            'placeholder' => 'Session ID',
            'helper_text' => 'Technical identifier of the browsing session',
        ],
        'created_at' => [
            'label' => 'Creation Date',
            'tooltip' => 'Record creation date',
            'placeholder' => 'Creation date',
            'helper_text' => 'Date and time of creation in the system',
        ],
        'openFilters' => [
            'label' => 'Open Filters',
        ],
        'applyFilters' => [
            'label' => 'Apply Filters',
        ],
        'resetFilters' => [
            'label' => 'Reset Filters',
        ],
        'reorderRecords' => [
            'label' => 'Reorder Records',
        ],
        'toggleColumns' => [
            'label' => 'Toggle Columns',
        ],
    ],
    'filters' => [
        'title' => 'Filters',
        'open' => 'Open Filters',
        'apply' => 'Apply Filters',
        'reset' => 'Reset Filters',
        'close' => 'Close Filters',
    ],
    'table' => [
        'reorder' => 'Reorder Records',
        'toggle_columns' => 'Show/Hide Columns',
        'empty' => 'No appointment workflows found',
        'loading' => 'Loading appointment workflows...',
    ],
    'messages' => [
        'success' => [
            'created' => 'Appointment workflow created successfully',
            'updated' => 'Appointment workflow updated successfully',
            'deleted' => 'Appointment workflow deleted successfully',
        ],
        'error' => [
            'create' => 'Error creating appointment workflow',
            'update' => 'Error updating appointment workflow',
            'delete' => 'Error deleting appointment workflow',
        ],
        'confirm' => [
            'delete' => 'Are you sure you want to delete this appointment workflow?',
        ],
    ],
];
