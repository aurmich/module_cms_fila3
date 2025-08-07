<?php

declare(strict_types=1);

return [
    'actions' => [
        'save' => [
            'label' => 'Save Documents',
            'tooltip' => 'Save all uploaded documents',
            'success' => 'Documents saved successfully',
            'error' => 'Error saving documents',
        ],
        'cancel' => [
            'label' => 'Cancel',
            'tooltip' => 'Cancel document changes',
            'confirmation' => 'Are you sure you want to cancel? Changes will be lost.',
        ],
    ],
    'fields' => [
        'pregnancy_certificate' => [
            'label' => 'Pregnancy Medical Certificate',
            'placeholder' => 'Upload Medical Certificate',
            'help' => 'Medical certificate attesting pregnancy status for access to special services',
            'description' => 'Medical certificate for special pregnancy services',
            'helper_text' => '',
            'validation' => [
                'file' => 'Upload a valid medical certificate',
                'mimes' => 'Supported formats: JPG, JPEG, PNG, PDF',
                'max' => 'Maximum allowed size: 5MB per file',
            ],
        ],
        'isee_certificate' => [
            'label' => 'Complete ISEE Certificate',
            'placeholder' => 'Upload ISEE Certificate',
            'help' => 'ISEE certificate for access to economic benefits and reduced rate services',
            'description' => 'ISEE certificate for economic benefits',
            'helper_text' => '',
            'validation' => [
                'file' => 'Upload a valid ISEE certificate',
                'mimes' => 'Supported formats: JPG, JPEG, PNG, PDF',
                'max' => 'Maximum allowed size: 5MB per file',
            ],
        ],
        'health_card' => [
            'label' => 'Health Card',
            'placeholder' => 'Upload Health Card',
            'help' => 'Health card, STP or ENI for identification and access to services',
            'description' => 'Health card for identification and services',
            'helper_text' => '',
            'validation' => [
                'required' => 'Health card is required for patient identification',
                'file' => 'Upload a valid file',
                'mimes' => 'Supported formats: JPG, JPEG, PNG, PDF',
                'max' => 'Maximum allowed size: 5MB per file',
            ],
        ],
    ],
    'navigation' => [
        'label' => 'Patient Documents',
        'icon' => 'heroicon-o-document-text',
        'group' => 'Patient Management',
        'description' => 'Manage patient attached documents',
    ],
    'messages' => [
        'upload_success' => 'Document uploaded successfully',
        'upload_error' => 'Error uploading document',
        'delete_success' => 'Document deleted successfully',
        'delete_error' => 'Error deleting document',
        'validation_error' => 'Document validation error',
        'file_too_large' => 'File is too large. Maximum size: 5MB',
        'invalid_format' => 'Unsupported file format. Allowed formats: JPG, JPEG, PNG, PDF',
    ],
    'notifications' => [
        'documents_updated' => [
            'title' => 'Documents Updated',
            'body' => 'Patient documents have been updated successfully',
        ],
        'document_required' => [
            'title' => 'Required Document',
            'body' => 'Some documents are required to complete registration',
        ],
    ],
];
