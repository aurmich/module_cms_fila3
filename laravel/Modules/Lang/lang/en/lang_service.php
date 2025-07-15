<?php

declare(strict_types=1);

return [
    'fields' => [
        'language' => [
            'label' => 'Language',
            'placeholder' => 'Select language',
            'help' => 'Currently selected interface language',
        ],
        'available_languages' => [
            'label' => 'Available Languages',
            'placeholder' => 'List of languages',
            'help' => 'Languages available for selection',
        ],
    ],
    'actions' => [
        'change_language' => [
            'label' => 'Change Language',
            'success' => 'Language changed successfully',
            'error' => 'Error changing language',
        ],
    ],
    'messages' => [
        'language_changed' => 'Language changed successfully',
        'error' => 'An error occurred while changing language',
    ],
    'validation' => [
        'language_required' => 'Language is required',
        'language_valid' => 'Selected language is not valid',
    ],
];
