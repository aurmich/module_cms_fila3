<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Doctor Privacy',
        'icon' => 'heroicon-o-shield-check',
        'group' => 'SaluteOra',
        'sort' => 15,
    ],

    'model' => [
        'singular' => 'Doctor Privacy',
        'plural' => 'Doctor Privacy Settings',
        'description' => 'Management of privacy settings and consents for doctors',
    ],

    'pages' => [
        'index' => [
            'title' => 'Doctor Privacy',
            'heading' => 'Doctor Privacy Management',
            'description' => 'Manage privacy settings and consents for all doctors',
        ],
        'create' => [
            'title' => 'New Privacy Setting',
            'heading' => 'Create New Privacy Setting',
            'description' => 'Configure privacy settings for a new doctor',
        ],
        'edit' => [
            'title' => 'Edit Privacy',
            'heading' => 'Edit Privacy Settings',
            'description' => 'Update privacy settings for the selected doctor',
        ],
        'view' => [
            'title' => 'Privacy Details',
            'heading' => 'Privacy Settings Details',
            'description' => 'View all privacy settings for the doctor',
        ],
    ],

    'fields' => [
        'id' => [
            'label' => 'ID',
            'placeholder' => 'Unique identifier',
            'help' => 'Automatic identifier of the privacy configuration',
            'tooltip' => 'Unique configuration ID',
            'helper_text' => '',
        ],
        'doctor_id' => [
            'label' => 'Doctor',
            'placeholder' => 'Select the doctor',
            'help' => 'Doctor associated with this privacy configuration',
            'tooltip' => 'Reference doctor',
            'helper_text' => 'Select the doctor from the list',
        ],
        'data_processing_consent' => [
            'label' => 'Data Processing Consent',
            'placeholder' => 'Select consent status',
            'help' => 'Consent to personal data processing',
            'tooltip' => 'GDPR consent status',
            'helper_text' => 'Mandatory consent for data processing',
        ],
        'marketing_consent' => [
            'label' => 'Marketing Consent',
            'placeholder' => 'Select marketing consent status',
            'help' => 'Consent to receive marketing communications',
            'tooltip' => 'Promotional communications consent',
            'helper_text' => 'Optional consent for commercial communications',
        ],
        'third_party_sharing' => [
            'label' => 'Third Party Sharing',
            'placeholder' => 'Select sharing options',
            'help' => 'Authorization for sharing with third parties',
            'tooltip' => 'Data sharing with partners',
            'helper_text' => 'Specify which third parties can access data',
        ],
        'data_retention_period' => [
            'label' => 'Data Retention Period',
            'placeholder' => 'Select retention period',
            'help' => 'Personal data retention period',
            'tooltip' => 'Data retention duration',
            'helper_text' => 'Minimum and maximum retention period',
        ],
        'right_to_forget' => [
            'label' => 'Right to be Forgotten',
            'placeholder' => 'Select deletion options',
            'help' => 'Configuration of the right to data deletion',
            'tooltip' => 'Right to be forgotten management',
            'helper_text' => 'How to exercise the right to deletion',
        ],
        'data_portability' => [
            'label' => 'Data Portability',
            'placeholder' => 'Select portability options',
            'help' => 'Configuration for data portability',
            'tooltip' => 'Personal data export',
            'helper_text' => 'Data export formats and methods',
        ],
        'privacy_notice_version' => [
            'label' => 'Privacy Notice Version',
            'placeholder' => 'Enter privacy notice version',
            'help' => 'Version of the accepted privacy notice',
            'tooltip' => 'Privacy notice version',
            'helper_text' => 'E.g. 1.0, 2.1, etc.',
        ],
        'consent_date' => [
            'label' => 'Consent Date',
            'placeholder' => 'Select consent date',
            'help' => 'Date when consent was provided',
            'tooltip' => 'Privacy acceptance date',
            'helper_text' => 'Date of privacy notice acceptance',
        ],
        'last_review_date' => [
            'label' => 'Last Review',
            'placeholder' => 'Last review date',
            'help' => 'Date of last privacy settings review',
            'tooltip' => 'Last verification date',
            'helper_text' => 'When they were last verified',
        ],
        'is_active' => [
            'label' => 'Active',
            'placeholder' => 'Select activity status',
            'help' => 'Indicates if the privacy configuration is currently active',
            'tooltip' => 'Configuration activity status',
            'helper_text' => 'Active and valid privacy configuration',
        ],
        'notes' => [
            'label' => 'Notes',
            'placeholder' => 'Enter additional notes',
            'help' => 'Additional notes and comments on privacy configuration',
            'tooltip' => 'Additional notes',
            'helper_text' => 'Personal comments and observations',
        ],
        'created_at' => [
            'label' => 'Creation Date',
            'placeholder' => 'Record creation date',
            'help' => 'Date and time of privacy configuration creation',
            'tooltip' => 'When the configuration was created',
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
            'help' => 'User who created the privacy configuration',
            'tooltip' => 'Creation author',
            'helper_text' => '',
        ],
        'updated_by' => [
            'label' => 'Updated By',
            'placeholder' => 'User who updated the record',
            'help' => 'User who updated the privacy configuration',
            'tooltip' => 'Last update author',
            'helper_text' => '',
        ],
    ],

    'actions' => [
        'create' => [
            'label' => 'New Privacy',
            'icon' => 'heroicon-o-plus',
            'color' => 'primary',
            'tooltip' => 'Create a new privacy configuration',
            'modal' => [
                'heading' => 'Create New Privacy Configuration',
                'description' => 'Configure privacy settings for a new doctor in the system',
                'confirm' => 'Create Configuration',
                'cancel' => 'Cancel',
            ],
            'messages' => [
                'success' => 'Privacy configuration created successfully',
                'error' => 'An error occurred while creating the privacy configuration',
            ],
        ],
        'edit' => [
            'label' => 'Edit',
            'icon' => 'heroicon-o-pencil',
            'color' => 'warning',
            'tooltip' => 'Edit privacy settings',
            'modal' => [
                'heading' => 'Edit Privacy Configuration',
                'description' => 'Update privacy settings for the selected doctor',
                'confirm' => 'Update Configuration',
                'cancel' => 'Cancel',
            ],
            'messages' => [
                'success' => 'Privacy configuration updated successfully',
                'error' => 'An error occurred during the update',
            ],
        ],
        'delete' => [
            'label' => 'Delete',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
            'tooltip' => 'Delete the privacy configuration',
            'modal' => [
                'heading' => 'Delete Privacy Configuration',
                'description' => 'Are you sure you want to delete this privacy configuration? This action is irreversible.',
                'confirm' => 'Delete Configuration',
                'cancel' => 'Cancel',
            ],
            'messages' => [
                'success' => 'Privacy configuration deleted successfully',
                'error' => 'An error occurred during deletion',
            ],
        ],
        'view' => [
            'label' => 'View',
            'icon' => 'heroicon-o-eye',
            'color' => 'info',
            'tooltip' => 'View privacy configuration details',
        ],
        'export_xls' => [
            'label' => 'Export Excel',
            'icon' => 'heroicon-o-document-download',
            'color' => 'success',
            'tooltip' => 'Export the list of privacy configurations in Excel format',
            'modal' => [
                'heading' => 'Export Privacy Configurations',
                'description' => 'Export the list of privacy configurations in Excel format for analysis and compliance',
                'confirm' => 'Export',
                'cancel' => 'Cancel',
            ],
            'messages' => [
                'success' => 'Export completed successfully',
                'error' => 'An error occurred during export',
            ],
        ],
        'review_privacy' => [
            'label' => 'Review Privacy',
            'icon' => 'heroicon-o-eye',
            'color' => 'info',
            'tooltip' => 'Review and update privacy settings',
            'modal' => [
                'heading' => 'Review Privacy Configuration',
                'description' => 'Review and update the doctor\'s privacy settings',
                'confirm' => 'Update Review',
                'cancel' => 'Cancel',
            ],
            'messages' => [
                'success' => 'Privacy review completed successfully',
                'error' => 'An error occurred during the review',
            ],
        ],
    ],

    'filters' => [
        'doctor_id' => [
            'label' => 'Doctor',
            'placeholder' => 'Filter by doctor',
        ],
        'data_processing_consent' => [
            'label' => 'Processing Consent',
            'placeholder' => 'Filter by data processing consent',
        ],
        'marketing_consent' => [
            'label' => 'Marketing Consent',
            'placeholder' => 'Filter by marketing consent',
        ],
        'is_active' => [
            'label' => 'Activity Status',
            'placeholder' => 'Filter by activity status',
        ],
        'consent_date' => [
            'label' => 'Consent Date',
            'placeholder' => 'Filter by consent date',
        ],
    ],

    'bulk_actions' => [
        'delete' => [
            'label' => 'Delete Selected',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
            'modal' => [
                'heading' => 'Delete Selected Configurations',
                'description' => 'Are you sure you want to delete the selected privacy configurations? This action is irreversible.',
                'confirm' => 'Delete Selected',
                'cancel' => 'Cancel',
            ],
            'messages' => [
                'success' => 'Privacy configurations deleted successfully',
                'error' => 'An error occurred during deletion',
            ],
        ],
        'export_xls' => [
            'label' => 'Export Selected',
            'icon' => 'heroicon-o-document-download',
            'color' => 'success',
            'modal' => [
                'heading' => 'Export Selected Configurations',
                'description' => 'Export only the selected privacy configurations in Excel format',
                'confirm' => 'Export Selected',
                'cancel' => 'Cancel',
            ],
            'messages' => [
                'success' => 'Export completed successfully',
                'error' => 'An error occurred during export',
            ],
        ],
        'review_selected' => [
            'label' => 'Review Selected',
            'icon' => 'heroicon-o-eye',
            'color' => 'info',
            'modal' => [
                'heading' => 'Review Selected Configurations',
                'description' => 'Review and update the selected privacy configurations',
                'confirm' => 'Review Selected',
                'cancel' => 'Cancel',
            ],
            'messages' => [
                'success' => 'Review completed successfully',
                'error' => 'An error occurred during the review',
            ],
        ],
    ],

    'messages' => [
        'welcome' => 'Welcome to doctor privacy management',
        'no_configurations' => 'No privacy configuration found',
        'search_no_results' => 'No privacy configuration matches the search criteria',
        'filter_no_results' => 'No privacy configuration matches the applied filters',
        'privacy_compliance' => 'All configurations are GDPR compliant',
        'consent_required' => 'Data processing consent is required',
    ],

    'notifications' => [
        'created' => 'Privacy configuration created successfully',
        'updated' => 'Privacy configuration updated successfully',
        'deleted' => 'Privacy configuration deleted successfully',
        'bulk_deleted' => 'Privacy configurations deleted successfully',
        'exported' => 'Export completed successfully',
        'reviewed' => 'Privacy review completed successfully',
        'consent_expired' => 'Privacy consent expired - review required',
        'gdpr_compliant' => 'Configuration GDPR compliant',
    ],

    'validation' => [
        'doctor_id_required' => 'Doctor is required',
        'doctor_id_exists' => 'Selected doctor does not exist',
        'data_processing_consent_required' => 'Data processing consent is required',
        'consent_date_required' => 'Consent date is required',
        'consent_date_date' => 'Consent date must be a valid date',
        'privacy_notice_version_required' => 'Privacy notice version is required',
        'data_retention_period_required' => 'Data retention period is required',
        'right_to_forget_required' => 'Right to be forgotten configuration is required',
        'data_portability_required' => 'Data portability configuration is required',
    ],

    'consent_options' => [
        'granted' => 'Granted',
        'denied' => 'Denied',
        'pending' => 'Pending',
        'expired' => 'Expired',
        'revoked' => 'Revoked',
    ],

    'retention_periods' => [
        '1_year' => '1 year',
        '3_years' => '3 years',
        '5_years' => '5 years',
        '10_years' => '10 years',
        'indefinite' => 'Indefinite',
        'custom' => 'Custom',
    ],

    'third_party_options' => [
        'none' => 'No sharing',
        'partners' => 'Authorized partners only',
        'suppliers' => 'Service providers',
        'insurance' => 'Insurance companies',
        'regulatory' => 'Regulatory authorities',
        'custom' => 'Custom',
    ],
];
