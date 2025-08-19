<?php

return [
    'resources' => [
        'dentist' => [
            'label' => [
                'singular' => 'Doctor',
                'plural' => 'Doctors',
            ],
            'fields' => [
                'name' => [
                    'label' => 'Name',
                    'placeholder' => 'Enter name',
                    'helper_text' => '',
                ],
                'email' => [
                    'label' => 'Email',
                    'placeholder' => 'Enter email',
                    'helper_text' => '',
                ],
                'phone' => [
                    'label' => 'Phone',
                    'placeholder' => 'Enter phone number',
                    'helper_text' => '',
                ],
                'specialties' => [
                    'label' => 'Specialties',
                    'placeholder' => 'Select specialties',
                    'helper_text' => '',
                ],
            ],
            'navigation' => [
                'label' => 'Doctors',
                'icon' => 'heroicon-o-user-group',
                'group' => 'Staff Management',
            ],
        ],
    ],
];
