<?php

declare(strict_types=1);

return [
    'label' => 'Active',
    'description' => 'User active in the system',
    'tooltip' => 'The user is active and can use the system',
    'color' => 'success',
    'bg_color' => '#10b981',
    'icon' => 'heroicon-o-check-circle',
    'modal_heading' => 'Active User Management',
    'modal_description' => 'This user is currently active in the system and can access all functionalities.',
    
    'actions' => [
        'deactivate' => [
            'label' => 'Deactivate',
            'confirmation' => 'Are you sure you want to deactivate this user?',
            'success' => 'User deactivated successfully',
            'error' => 'Error during user deactivation',
        ],
        'suspend' => [
            'label' => 'Suspend',
            'confirmation' => 'Are you sure you want to suspend this user?',
            'success' => 'User suspended successfully',
            'error' => 'Error during user suspension',
        ],
        'view_details' => [
            'label' => 'View Details',
            'tooltip' => 'View complete user details',
        ],
    ],
    
    'modal' => [
        'heading' => 'Active User Management',
        'description' => 'This user is currently active in the system and can access all functionalities.',
        'confirm' => 'Confirm',
        'cancel' => 'Cancel',
    ],
    
    'messages' => [
        'status_confirmed' => 'Active status confirmed',
        'access_granted' => 'System access granted',
        'permissions_active' => 'All permissions are active',
        'last_activity' => 'Last activity recorded',
    ],
    
    'fields' => [
        'message' => [
            'label' => 'Status Message',
            'placeholder' => 'Enter a message for the active user',
            'helper_text' => '',
            'description' => 'Informational message for the user regarding their active status',
        ],
        'activation_date' => [
            'label' => 'Activation Date',
            'placeholder' => 'Select activation date',
            'helper_text' => '',
            'description' => 'Date when the user was activated in the system',
        ],
        'last_login' => [
            'label' => 'Last Login',
            'placeholder' => 'Last login date',
            'helper_text' => '',
            'description' => 'Date and time of the user\'s last login',
        ],
    ],
];