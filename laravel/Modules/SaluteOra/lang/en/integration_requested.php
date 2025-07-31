<?php

declare(strict_types=1);

return [
    'label' => 'Integration Requested',
    'description' => 'Data integration request in progress',
    'tooltip' => 'The user has requested data integration',
    'color' => 'warning',
    'bg_color' => '#f59e0b',
    'icon' => 'heroicon-o-clock',
    'modal_heading' => 'Data Integration Request',
    'modal_description' => 'The user has requested data integration. Review the request and proceed with approval or rejection.',
    
    'actions' => [
        'approve' => [
            'label' => 'Approve Integration',
            'confirmation' => 'Are you sure you want to approve the integration request?',
            'success' => 'Integration request approved successfully',
            'error' => 'Error during request approval',
        ],
        'reject' => [
            'label' => 'Reject Integration',
            'confirmation' => 'Are you sure you want to reject the integration request?',
            'success' => 'Integration request rejected',
            'error' => 'Error during request rejection',
        ],
        'view_request' => [
            'label' => 'View Request',
            'tooltip' => 'View integration request details',
        ],
        'contact_user' => [
            'label' => 'Contact User',
            'tooltip' => 'Contact user for clarifications',
        ],
    ],
    
    'modal' => [
        'heading' => 'Data Integration Request',
        'description' => 'The user has requested data integration. Review the request and proceed with approval or rejection.',
        'confirm' => 'Confirm',
        'cancel' => 'Cancel',
    ],
    
    'messages' => [
        'request_pending' => 'Request pending approval',
        'review_required' => 'Team review required',
        'documentation_needed' => 'Additional documentation needed',
        'processing_time' => 'Processing time: 3-5 business days',
    ],
    
    'fields' => [
        'message' => [
            'label' => 'Request Message',
            'placeholder' => 'Enter integration request details',
            'helper_text' => '',
            'description' => 'Specific details of the data integration request',
        ],
        'request_date' => [
            'label' => 'Request Date',
            'placeholder' => 'Request date',
            'helper_text' => '',
            'description' => 'Date when the integration request was made',
        ],
        'integration_type' => [
            'label' => 'Integration Type',
            'placeholder' => 'Select integration type',
            'helper_text' => '',
            'description' => 'Type of data integration requested',
        ],
        'priority' => [
            'label' => 'Priority',
            'placeholder' => 'Select priority',
            'helper_text' => '',
            'description' => 'Request priority level',
        ],
    ],
];