<?php

return [
    'title' => [
        'singular' => 'Medical Studio',
        'plural' => 'Medical Studios',
    ],
    'fields' => [
        'name' => [
            'label' => 'Name',
            'placeholder' => 'Enter the studio name',
        ],
        'address' => [
            'label' => 'Address',
            'placeholder' => 'Enter the address',
        ],
        'city' => [
            'label' => 'City',
            'placeholder' => 'Enter the city',
        ],
        'postal_code' => [
            'label' => 'Postal Code',
            'placeholder' => 'Enter the postal code',
        ],
        'phone' => [
            'label' => 'Phone',
            'placeholder' => 'Enter the phone number',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Enter the email address',
        ],
        'website' => [
            'label' => 'Website',
            'placeholder' => 'Enter the website URL',
        ],
        'registration_number' => [
            'label' => 'Registration Number',
            'placeholder' => 'Enter the registration number',
        ],
        'vat_number' => [
            'label' => 'VAT Number',
            'placeholder' => 'Enter the VAT number',
        ],
        'description' => [
            'label' => 'Description',
            'placeholder' => 'Enter a studio description',
        ],
        'opening_hours' => [
            'label' => 'Opening Hours',
            'placeholder' => 'Configure opening hours',
            'days' => [
                'monday' => 'Monday',
                'tuesday' => 'Tuesday',
                'wednesday' => 'Wednesday',
                'thursday' => 'Thursday',
                'friday' => 'Friday',
                'saturday' => 'Saturday',
                'sunday' => 'Sunday',
            ],
            'open' => 'Open',
            'close' => 'Close',
            'closed' => 'Closed',
        ],
        'services' => [
            'label' => 'Services',
            'placeholder' => 'Select offered services',
        ],
        'active' => [
            'label' => 'Active',
            'true' => 'Yes',
            'false' => 'No',
        ],
    ],
    'filters' => [
        'active' => [
            'label' => 'Active',
            'options' => [
                'active' => 'Active',
                'inactive' => 'Inactive',
            ],
        ],
        'city' => [
            'label' => 'City',
            'placeholder' => 'Filter by city',
        ],
    ],
    'actions' => [
        'activate' => 'Activate',
        'deactivate' => 'Deactivate',
        'view_doctors' => 'View Doctors',
        'view_appointments' => 'View Appointments',
    ],
    'notifications' => [
        'activated' => 'Studio activated successfully',
        'deactivated' => 'Studio deactivated successfully',
    ],
    'sections' => [
        'basic_info' => 'Basic Information',
        'contact_info' => 'Contact Information',
        'fiscal_info' => 'Fiscal Information',
        'operations' => 'Operations',
    ],
];
