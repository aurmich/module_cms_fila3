<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Medical Practice',
        'icon' => 'heroicon-o-building-office-2',
        'group' => 'SaluteOra',
        'sort' => 10,
    ],

    'model' => [
        'singular' => 'Medical Practice',
        'plural' => 'Medical Practices',
        'description' => 'Management of medical practices and relationships with doctors',
    ],

    'pages' => [
        'index' => [
            'title' => 'Medical Practices',
            'heading' => 'Medical Practices List',
            'description' => 'Manage all medical practices in the system',
        ],
        'create' => [
            'title' => 'New Medical Practice',
            'heading' => 'Create New Medical Practice',
            'description' => 'Enter data to create a new medical practice',
        ],
        'edit' => [
            'title' => 'Edit Medical Practice',
            'heading' => 'Edit Medical Practice',
            'description' => 'Modify the data of the selected medical practice',
        ],
        'view' => [
            'title' => 'Medical Practice Details',
            'heading' => 'Medical Practice Details',
            'description' => 'View all details of the medical practice',
        ],
    ],

    'fields' => [
        'id' => [
            'label' => 'ID',
            'placeholder' => 'Unique identifier',
            'help' => 'Automatic identifier of the medical practice',
            'tooltip' => 'Unique practice ID',
            'helper_text' => '',
        ],
        'name' => [
            'label' => 'Practice Name',
            'placeholder' => 'Enter the medical practice name',
            'help' => 'Complete name of the medical practice',
            'tooltip' => 'Official practice name',
            'helper_text' => 'E.g. Dr. Rossi Medical Practice',
        ],
        'address' => [
            'label' => 'Address',
            'placeholder' => 'Enter the complete address',
            'help' => 'Complete address of the medical practice',
            'tooltip' => 'Physical practice address',
            'helper_text' => 'Street, number, city, postal code',
        ],
        'phone' => [
            'label' => 'Phone',
            'placeholder' => 'Enter the phone number',
            'help' => 'Main phone number of the practice',
            'tooltip' => 'Main phone contact',
            'helper_text' => 'Format: +39 123 456 7890',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Enter the email address',
            'help' => 'Email contact address of the practice',
            'tooltip' => 'Email for official communications',
            'helper_text' => 'E.g. info@medicalpractice.it',
        ],
        'website' => [
            'label' => 'Website',
            'placeholder' => 'Enter the website URL',
            'help' => 'Official website of the medical practice',
            'tooltip' => 'Institutional website URL',
            'helper_text' => 'E.g. https://www.medicalpractice.it',
        ],
        'description' => [
            'label' => 'Description',
            'placeholder' => 'Enter a practice description',
            'help' => 'Detailed description of offered services',
            'tooltip' => 'Complete practice description',
            'helper_text' => 'Specializations, services, hours',
        ],
        'is_active' => [
            'label' => 'Active',
            'placeholder' => 'Select activity status',
            'help' => 'Indicates if the practice is currently active',
            'tooltip' => 'Practice activity status',
            'helper_text' => 'Active and operational practice',
        ],
        'created_at' => [
            'label' => 'Creation Date',
            'placeholder' => 'Record creation date',
            'help' => 'Date and time of practice creation',
            'tooltip' => 'When the record was created',
            'helper_text' => '',
        ],
        'updated_at' => [
            'label' => 'Update Date',
            'placeholder' => 'Last update date',
            'help' => 'Date and time of last update',
            'tooltip' => 'When it was last updated',
            'helper_text' => '',
        ],
        'created_by' => [
            'label' => 'Created By',
            'placeholder' => 'User who created the record',
            'help' => 'User who created the medical practice',
            'tooltip' => 'Creation author',
            'helper_text' => '',
        ],
        'updated_by' => [
            'label' => 'Updated By',
            'placeholder' => 'User who updated the record',
            'help' => 'User who updated the medical practice',
            'tooltip' => 'Last update author',
            'helper_text' => '',
        ],
    ],

    'actions' => [
        'create' => [
            'label' => 'New Practice',
            'icon' => 'heroicon-o-plus',
            'color' => 'primary',
            'tooltip' => 'Create a new medical practice',
            'modal' => [
                'heading' => 'Create New Medical Practice',
                'description' => 'Enter data to create a new medical practice in the system',
                'confirm' => 'Create Practice',
                'cancel' => 'Cancel',
            ],
            'messages' => [
                'success' => 'Medical practice created successfully',
                'error' => 'An error occurred while creating the medical practice',
            ],
        ],
        'edit' => [
            'label' => 'Edit',
            'icon' => 'heroicon-o-pencil',
            'color' => 'warning',
            'tooltip' => 'Edit medical practice data',
            'modal' => [
                'heading' => 'Edit Medical Practice',
                'description' => 'Modify the data of the selected medical practice',
                'confirm' => 'Update Practice',
                'cancel' => 'Cancel',
            ],
            'messages' => [
                'success' => 'Medical practice updated successfully',
                'error' => 'An error occurred during the update',
            ],
        ],
        'delete' => [
            'label' => 'Delete',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
            'tooltip' => 'Delete the medical practice',
            'modal' => [
                'heading' => 'Delete Medical Practice',
                'description' => 'Are you sure you want to delete this medical practice? This action is irreversible.',
                'confirm' => 'Delete Practice',
                'cancel' => 'Cancel',
            ],
            'messages' => [
                'success' => 'Medical practice deleted successfully',
                'error' => 'An error occurred during deletion',
            ],
        ],
        'view' => [
            'label' => 'View',
            'icon' => 'heroicon-o-eye',
            'color' => 'info',
            'tooltip' => 'View medical practice details',
        ],
        'export_xls' => [
            'label' => 'Export Excel',
            'icon' => 'heroicon-o-document-download',
            'color' => 'success',
            'tooltip' => 'Export the list of medical practices in Excel format',
            'modal' => [
                'heading' => 'Export Medical Practices',
                'description' => 'Export the list of medical practices in Excel format for analysis and reporting',
                'confirm' => 'Export',
                'cancel' => 'Cancel',
            ],
            'messages' => [
                'success' => 'Export completed successfully',
                'error' => 'An error occurred during export',
            ],
        ],
    ],

    'filters' => [
        'name' => [
            'label' => 'Practice Name',
            'placeholder' => 'Filter by practice name',
        ],
        'is_active' => [
            'label' => 'Activity Status',
            'placeholder' => 'Filter by activity status',
        ],
        'created_at' => [
            'label' => 'Creation Date',
            'placeholder' => 'Filter by creation date',
        ],
    ],

    'bulk_actions' => [
        'delete' => [
            'label' => 'Delete Selected',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
            'modal' => [
                'heading' => 'Delete Selected Practices',
                'description' => 'Are you sure you want to delete the selected medical practices? This action is irreversible.',
                'confirm' => 'Delete Selected',
                'cancel' => 'Cancel',
            ],
            'messages' => [
                'success' => 'Medical practices deleted successfully',
                'error' => 'An error occurred during deletion',
            ],
        ],
        'export_xls' => [
            'label' => 'Export Selected',
            'icon' => 'heroicon-o-document-download',
            'color' => 'success',
            'modal' => [
                'heading' => 'Export Selected Practices',
                'description' => 'Export only the selected medical practices in Excel format',
                'confirm' => 'Export Selected',
                'cancel' => 'Cancel',
            ],
            'messages' => [
                'success' => 'Export completed successfully',
                'error' => 'An error occurred during export',
            ],
        ],
    ],

    'messages' => [
        'welcome' => 'Welcome to medical practice management',
        'no_studios' => 'No medical practice found',
        'search_no_results' => 'No medical practice matches the search criteria',
        'filter_no_results' => 'No medical practice matches the applied filters',
    ],

    'notifications' => [
        'created' => 'Medical practice created successfully',
        'updated' => 'Medical practice updated successfully',
        'deleted' => 'Medical practice deleted successfully',
        'bulk_deleted' => 'Medical practices deleted successfully',
        'exported' => 'Export completed successfully',
    ],

    'validation' => [
        'name_required' => 'Practice name is required',
        'name_max' => 'Practice name cannot exceed 255 characters',
        'address_required' => 'Address is required',
        'phone_required' => 'Phone number is required',
        'phone_format' => 'Phone number format is not valid',
        'email_required' => 'Email is required',
        'email_email' => 'Email must be in valid format',
        'email_unique' => 'This email is already used by another practice',
        'website_url' => 'Website URL must be in valid format',
    ],
];
