<?php

declare(strict_types=1);

return [
    'label' => 'Refund to Integrate',
    'description' => 'Refund awaiting integration in the system',
    'tooltip' => 'The refund requires integration with additional data',
    'color' => 'warning',
    'bg_color' => '#f59e0b',
    'icon' => 'heroicon-o-exclamation-triangle',
    'modal_heading' => 'Refund to Integrate',
    'modal_description' => 'This refund requires integration with additional documents or information before it can be processed.',
    
    'actions' => [
        'start_integration' => [
            'label' => 'Start Integration',
            'confirmation' => 'Are you sure you want to start the integration process?',
            'success' => 'Integration process started successfully',
            'error' => 'Error starting integration',
        ],
        'request_documents' => [
            'label' => 'Request Documents',
            'confirmation' => 'Are you sure you want to request additional documents?',
            'success' => 'Document request sent',
            'error' => 'Error requesting documents',
        ],
        'view_requirements' => [
            'label' => 'View Requirements',
            'tooltip' => 'View integration requirements',
        ],
        'contact_support' => [
            'label' => 'Contact Support',
            'tooltip' => 'Contact support for assistance',
        ],
    ],
    
    'modal' => [
        'heading' => 'Refund to Integrate',
        'description' => 'This refund requires integration with additional documents or information before it can be processed.',
        'confirm' => 'Confirm',
        'cancel' => 'Cancel',
    ],
    
    'messages' => [
        'integration_required' => 'Integration required to complete refund',
        'documents_missing' => 'Missing documents for processing',
        'verification_pending' => 'Document verification in progress',
        'estimated_time' => 'Estimated time: 5-7 business days',
    ],
    
    'fields' => [
        'message' => [
            'label' => 'Integration Message',
            'placeholder' => 'Enter details about required integration',
            'helper_text' => '',
            'description' => 'Specific details about integration requirements',
        ],
        'integration_type' => [
            'label' => 'Integration Type',
            'placeholder' => 'Select integration type',
            'helper_text' => '',
            'description' => 'Type of integration required for the refund',
        ],
        'required_documents' => [
            'label' => 'Required Documents',
            'placeholder' => 'List of necessary documents',
            'helper_text' => '',
            'description' => 'List of documents needed to complete integration',
        ],
        'deadline' => [
            'label' => 'Deadline',
            'placeholder' => 'Integration deadline',
            'helper_text' => '',
            'description' => 'Date by which integration must be completed',
        ],
        'priority_level' => [
            'label' => 'Priority Level',
            'placeholder' => 'Select priority',
            'helper_text' => '',
            'description' => 'Urgency level for integration',
        ],
    ],
]; 