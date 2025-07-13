<?php

declare(strict_types=1);

return [
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
    ],
]; 