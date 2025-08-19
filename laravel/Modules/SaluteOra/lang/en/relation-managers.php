<?php

return [
    'doctors' => [
        'title' => 'Doctors',
        'fields' => [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'specialization' => 'Specialization',
            'registration_number' => 'Registration Number',
            'status' => 'Status',
            'created_at' => 'Created at',
        ],
        'actions' => [
            'create' => 'Add dentist',
            'edit' => 'Edit dentist',
            'delete' => 'Remove dentist',
            'view' => 'View dentist',
        ],
    ],
    'studios' => [
        'title' => 'Studios',
        'fields' => [
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'address' => 'Address',
            'website' => 'Website',
            'registration_number' => 'VAT Number',
            'vat_number' => 'Registration Number',
            'active' => 'Active',
            'created_at' => 'Created at',
        ],
        'actions' => [
            'create' => 'Add studio',
            'edit' => 'Edit studio',
            'delete' => 'Remove studio',
            'view' => 'View studio',
        ],
    ],
];
