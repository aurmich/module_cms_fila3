<?php

declare(strict_types=1);

return [
    'section_title' => 'My Data',
    'actions' => [
        'delete' => [
            'label' => 'Delete',
        ],
        'edit' => [
            'label' => 'Edit',
            'modal_heading' => 'Edit Profile',
            'modal_description' => 'Update your personal profile information',
        ],
    ],
    'fields' => [
        'address' => [
            'label' => 'Address',
            'placeholder' => 'Enter your address',
            'help' => 'Provide your residence or domicile address',
            'description' => 'Full user address',
            'helper_text' => '',
        ],
        'phone' => [
            'label' => 'Phone',
            'placeholder' => 'Enter your phone number',
            'help' => 'Phone number for contact',
            'description' => 'Primary phone number',
            'helper_text' => '',
        ],
        'last_name' => [
            'label' => 'Last Name',
            'placeholder' => 'Enter your last name',
            'help' => 'Your surname as per official documents',
            'description' => 'User\'s last name',
            'helper_text' => '',
        ],
        'first_name' => [
            'label' => 'First Name',
            'placeholder' => 'Enter your first name',
            'help' => 'Your given name as per official documents',
            'description' => 'User\'s first name',
            'helper_text' => '',
        ],
    ],
]; 