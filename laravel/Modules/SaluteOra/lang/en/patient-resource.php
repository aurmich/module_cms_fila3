<?php

return [
    'steps' => [
        'personal_data_step' => [
            'label' => 'Personal Information',
            'description' => 'Enter your personal details',
        ],
        'documents_step' => [
            'label' => 'Documents',
            'description' => 'Upload required documents',
        ],
        'pre_visit_step' => [
            'label' => 'Pre-Visit',
            'description' => 'Preliminary information',
        ],
        'privacy_step' => [
            'label' => 'Privacy',
            'description' => 'Privacy policy and consents',
        ],
    ],
    'fields' => [
        'first_name' => [
            'label' => 'First Name',
            'placeholder' => 'Enter first name',
            'help' => 'Enter your full first name',
            'helper_text' => '',
        ],
        'last_name' => [
            'label' => 'Last Name',
            'placeholder' => 'Enter last name',
            'help' => 'Enter your full last name',
            'helper_text' => '',
        ],
        'address' => [
            'label' => 'Address',
            'placeholder' => 'Enter your address',
            'helper_text' => '',
        ],
        'city' => [
            'label' => 'City',
            'placeholder' => 'Enter your city',
            'helper_text' => '',
        ],
        'phone' => [
            'label' => 'Phone',
            'placeholder' => 'Enter phone number',
            'help' => 'Phone number for contact',
            'helper_text' => '',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Enter email address',
            'help' => 'Valid email address',
            'helper_text' => '',
        ],
        'health_card' => [
            'label' => 'Health Card',
            'tooltip' => 'Upload a scan of your health card',
            'helper_text' => '',
        ],
        'identity_document' => [
            'label' => 'ID Document',
            'tooltip' => 'Upload a scan of your ID document',
            'helper_text' => '',
        ],
        'isee_certificate' => [
            'label' => 'ISEE Certificate',
            'tooltip' => 'Upload your ISEE certificate if available',
            'helper_text' => '',
        ],
        'pregnancy_certificate' => [
            'label' => 'Pregnancy Certificate',
            'tooltip' => 'Upload pregnancy certificate if applicable',
            'helper_text' => '',
        ],
        'fiscal_code' => [
            'label' => 'Tax Code',
            'placeholder' => 'Enter tax code',
            'help' => 'Tax code as on health card',
            'helper_text' => '',
        ],
        'birth_date' => [
            'label' => 'Date of Birth',
            'placeholder' => 'Select date of birth',
            'help' => 'Enter your date of birth in dd/mm/yyyy format',
            'helper_text' => '',
        ],
        'last_dental_visit' => [
            'label' => 'Last Dental Visit',
            'tooltip' => 'When was your last dental visit?',
            'helper_text' => '',
        ],
        'dental_problems' => [
            'label' => 'Dental Problems',
            'placeholder' => 'Describe any dental problems',
            'helper_text' => '',
        ],
        'privacy_acceptance' => [
            'label' => 'Privacy Acceptance',
            'tooltip' => 'You must accept the privacy policy to continue',
            'helper_text' => '',
        ],
        'newsletter' => [
            'label' => 'Newsletter',
            'tooltip' => 'Would you like to receive email updates?',
            'helper_text' => '',
        ],
        'gender' => [
            'label' => 'Gender',
            'placeholder' => 'Select gender',
            'help' => 'Select your gender',
            'helper_text' => '',
        ],
    ],
    'buttons' => [
        'submit' => [
            'label' => 'ACCEPT AND CONTINUE',
        ],
    ],
];
