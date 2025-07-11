<?php

return [
    'navigation' => [
        'label' => 'Doctors',
        'icon' => 'heroicon-o-user-group',
        'group' => 'Management',
    ],
    'model' => [
        'label' => 'Doctor',
        'plural' => 'Doctors',
    ],
    'pages' => [
        'index' => [
            'title' => 'Doctors',
        ],
        'create' => [
            'title' => 'New Doctor',
        ],
        'edit' => [
            'title' => 'Edit Doctor',
        ],
    ],
    'steps' => [
        'personal_info' => [
            'label' => 'Personal Information',
            'description' => 'Enter your personal information',
        ],
        'moderation' => [
            'label' => 'Moderation',
            'description' => 'Profile verification and approval',
        ],
        'contacts' => [
            'label' => 'Contacts',
            'description' => 'Enter your contact information',
        ],
        'professional' => [
            'label' => 'Professional Information',
            'description' => 'Enter your professional information',
        ],
        'availability' => [
            'label' => 'Availability',
            'description' => 'Set your availability schedule',
        ],
    ],
    'fields' => [
        'full_name' => [
            'label' => 'Full Name',
            'placeholder' => 'Enter full name',
            'helper_text' => '',
        ],
        'certification' => [
            'label' => 'Professional Certification',
            'tooltip' => 'Upload your professional certification',
            'helper_text' => '',
        ],
        'moderation_status' => [
            'label' => 'Moderation Status',
            'helper_text' => '',
        ],
        'moderation_notes' => [
            'label' => 'Moderation Notes',
            'placeholder' => 'Enter any moderation notes',
            'helper_text' => '',
        ],
        'fiscal_code' => [
            'label' => 'Fiscal Code',
            'placeholder' => 'Enter fiscal code',
            'helper_text' => '',
        ],
        'birth_date' => [
            'label' => 'Date of Birth',
            'placeholder' => 'Select date of birth',
            'helper_text' => '',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Enter email address',
            'helper_text' => '',
        ],
        'phone' => [
            'label' => 'Phone',
            'placeholder' => 'Enter phone number',
            'helper_text' => '',
        ],
        'address' => [
            'label' => 'Address',
            'placeholder' => 'Enter practice address',
            'helper_text' => '',
        ],
        'city' => [
            'label' => 'City',
            'placeholder' => 'Enter city',
            'helper_text' => '',
        ],
        'registration_number' => [
            'label' => 'Registration Number',
            'placeholder' => 'Enter professional registration number',
            'helper_text' => '',
        ],
        'specialties' => [
            'label' => 'Specialties',
            'placeholder' => 'Select specialties',
            'helper_text' => '',
        ],
        'certifications' => [
            'label' => 'Certifications',
            'tooltip' => 'Upload any additional certifications',
            'helper_text' => '',
        ],
        'availability' => [
            'label' => 'Availability Schedule',
            'helper_text' => '',
        ],
        'day' => [
            'label' => 'Day',
            'helper_text' => '',
            'options' => [
                'monday' => 'Monday',
                'tuesday' => 'Tuesday',
                'wednesday' => 'Wednesday',
                'thursday' => 'Thursday',
                'friday' => 'Friday',
                'saturday' => 'Saturday',
                'sunday' => 'Sunday',
            ],
        ],
        'start_time' => [
            'label' => 'Start Time',
            'helper_text' => '',
        ],
        'end_time' => [
            'label' => 'End Time',
            'helper_text' => '',
        ],
        'available_for_emergencies' => [
            'label' => 'Available for Emergencies',
            'help' => 'Indicate if you are available for emergency visits outside of the specified hours',
            'helper_text' => '',
        ],
    ],
    'actions' => [
        'approve' => [
            'label' => 'Approve',
            'tooltip' => 'Approve doctor registration',
        ],
        'reject' => [
            'label' => 'Reject',
            'tooltip' => 'Reject doctor registration',
        ],
    ],
    'moderation' => [
        'pending' => 'Pending moderation',
        'approved' => 'Approved',
        'rejected' => 'Rejected',
        'approve' => 'Approve',
        'reject' => 'Reject',
    ],
    'search_placeholder' => 'Search by name, email, phone, fiscal code...',
];
