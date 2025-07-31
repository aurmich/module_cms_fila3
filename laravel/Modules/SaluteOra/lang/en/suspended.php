<?php

declare(strict_types=1);

return [
    'label' => 'Suspended',
    'description' => 'Element temporarily suspended',
    'tooltip' => 'The element has been temporarily suspended',
    'color' => 'danger',
    'bg_color' => '#dc2626',
    'icon' => 'heroicon-o-pause-circle',
    'modal_heading' => 'Suspended Element',
    'modal_description' => 'This element has been temporarily suspended. Contact the administrator for more information or to request reactivation.',
    
    'actions' => [
        'reactivate' => [
            'label' => 'Reactivate',
            'confirmation' => 'Are you sure you want to reactivate this element?',
            'success' => 'Element reactivated successfully',
            'error' => 'Error during reactivation',
        ],
        'extend_suspension' => [
            'label' => 'Extend Suspension',
            'confirmation' => 'Are you sure you want to extend the suspension?',
            'success' => 'Suspension extended successfully',
            'error' => 'Error extending suspension',
        ],
        'view_reason' => [
            'label' => 'View Reason',
            'tooltip' => 'View suspension reason',
        ],
        'contact_admin' => [
            'label' => 'Contact Administrator',
            'tooltip' => 'Contact administrator for clarifications',
        ],
    ],
    
    'modal' => [
        'heading' => 'Suspended Element',
        'description' => 'This element has been temporarily suspended. Contact the administrator for more information or to request reactivation.',
        'confirm' => 'Confirm',
        'cancel' => 'Cancel',
    ],
    
    'messages' => [
        'suspension_active' => 'Suspension active',
        'temporary_restriction' => 'Temporary restriction in effect',
        'contact_required' => 'Administrator contact required',
        'review_pending' => 'Review in progress',
    ],
    
    'fields' => [
        'message' => [
            'label' => 'Suspension Message',
            'placeholder' => 'Enter suspension reason',
            'helper_text' => '',
            'description' => 'Detailed reason for element suspension',
        ],
        'suspension_date' => [
            'label' => 'Suspension Date',
            'placeholder' => 'Suspension start date',
            'helper_text' => '',
            'description' => 'Date when suspension was applied',
        ],
        'suspension_end_date' => [
            'label' => 'Suspension End Date',
            'placeholder' => 'Expected suspension end date',
            'helper_text' => '',
            'description' => 'Expected date for automatic reactivation',
        ],
        'suspension_reason' => [
            'label' => 'Suspension Reason',
            'placeholder' => 'Select reason',
            'helper_text' => '',
            'description' => 'Category of suspension reason',
        ],
        'admin_notes' => [
            'label' => 'Administrator Notes',
            'placeholder' => 'Internal administrator notes',
            'helper_text' => '',
            'description' => 'Notes reserved for administrator about suspension',
        ],
    ],
    'modal_description' => 'Are you sure you want to suspend this element? The element will not be available until reactivation.',
];