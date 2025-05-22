<?php

declare(strict_types=1);

return [
    'navigation' => [
        'group' => 'Notifications',
        'label' => 'Email Templates',
        'plural' => 'Email Templates',
        'singular' => 'Email Template',
        'icon' => 'heroicon-o-envelope',
        'sort' => 1,
    ],

    'fields' => [
        'id' => [
            'label' => 'ID',
        ],
        'mailable' => [
            'label' => 'Mailable Class',
            'placeholder' => 'Enter the Mailable class name',
            'help' => 'The PHP class that handles email sending',
        ],
        'subject' => [
            'label' => 'Subject',
            'placeholder' => 'Enter the email subject',
            'help' => 'The subject that will appear in the email',
        ],
        'html_template' => [
            'label' => 'HTML Content',
            'placeholder' => 'Enter the email HTML content',
            'help' => 'The email content in HTML format',
        ],
        'text_template' => [
            'label' => 'Text Content',
            'placeholder' => 'Enter the email text content',
            'help' => 'Text version of the email for clients that don\'t support HTML',
        ],
        'version' => [
            'label' => 'Version',
            'help' => 'Template version number',
        ],
        'created_at' => [
            'label' => 'Created At',
        ],
        'updated_at' => [
            'label' => 'Last Modified',
        ],
    ],

    'filters' => [
        'search_placeholder' => 'Search templates...',
        'version' => [
            'label' => 'Version',
            'placeholder' => 'Select version',
        ],
    ],

    'actions' => [
        'create' => [
            'label' => 'New Template',
            'modal' => [
                'heading' => 'Create Email Template',
                'description' => 'Enter the details for the new email template',
                'submit' => 'Create',
            ],
        ],
        'edit' => [
            'label' => 'Edit',
            'modal' => [
                'heading' => 'Edit Email Template',
                'description' => 'Modify the email template details',
                'submit' => 'Save',
            ],
        ],
        'delete' => [
            'label' => 'Delete',
            'modal' => [
                'heading' => 'Delete Email Template',
                'description' => 'Are you sure you want to delete this template? This action cannot be undone.',
                'submit' => 'Delete',
            ],
        ],
        'restore' => [
            'label' => 'Restore',
        ],
        'force_delete' => [
            'label' => 'Force Delete',
            'modal' => [
                'heading' => 'Force Delete Email Template',
                'description' => 'Are you sure you want to permanently delete this template? This action cannot be undone.',
                'submit' => 'Force Delete',
            ],
        ],
        'new_version' => [
            'label' => 'New Version',
            'modal' => [
                'heading' => 'Create New Version',
                'description' => 'Create a new version of the email template',
                'submit' => 'Create Version',
            ],
        ],
    ],

    'messages' => [
        'created' => 'Email template created successfully.',
        'updated' => 'Email template updated successfully.',
        'deleted' => 'Email template deleted successfully.',
        'restored' => 'Email template restored successfully.',
        'force_deleted' => 'Email template permanently deleted.',
        'version_created' => 'New template version created successfully.',
    ],

    'sections' => [
        'template' => [
            'label' => 'Template',
            'description' => 'Main template information',
        ],
        'versions' => [
            'label' => 'Versions',
            'description' => 'Template version history',
        ],
        'logs' => [
            'label' => 'Logs',
            'description' => 'Template sending history',
        ],
    ],
];
