<?php

declare(strict_types=1);

return [
    'actions' => [
        'save' => [
            'label' => 'Save Pre-Visit Information',
            'tooltip' => 'Save pre-visit information for dental appointment',
            'success' => 'Pre-visit information saved successfully',
            'error' => 'Error saving pre-visit information',
        ],
        'cancel' => [
            'label' => 'Cancel',
            'tooltip' => 'Cancel pre-visit information changes',
            'confirmation' => 'Are you sure you want to cancel? Changes will be lost.',
        ],
    ],
    'fields' => [
        'last_dental_visit_period' => [
            'label' => 'When was your last dental visit?',
            'placeholder' => 'Select the time period of your last dental visit',
            'help' => 'This information helps the dentist understand your dental care history',
            'description' => 'Last visit period for dental anamnesis',
            'helper_text' => '',
            'options' => [
                'less_than_6_months' => 'Less than 6 months ago',
                '6_months_to_1_year' => '6 months to 1 year ago',
                '1_to_2_years' => '1 to 2 years ago',
                '2_to_5_years' => '2 to 5 years ago',
                'more_than_5_years' => 'More than 5 years ago',
                'never' => 'Never had a dental visit',
                'dont_remember' => 'I don\'t remember',
            ],
        ],
        'dental_problems' => [
            'label' => 'Current Dental Problems',
            'placeholder' => 'Describe current dental pain, sensitivity or disorders',
            'help' => 'Describe any current dental problems, pain, sensitivity or disorders you are experiencing',
            'description' => 'Dental problems for medical dental evaluation',
            'helper_text' => 'Include details about pain, sensitivity, gum bleeding, tooth mobility',
            'validation' => [
                'max' => 'Description cannot exceed 500 characters',
            ],
        ],
    ],
    'navigation' => [
        'label' => 'Pre-Visit Information',
        'icon' => 'heroicon-o-clipboard-document-list',
        'group' => 'Patient Management',
        'description' => 'Pre-visit information for dental appointment',
    ],
    'messages' => [
        'save_success' => 'Pre-visit information saved successfully',
        'save_error' => 'Error saving pre-visit information',
        'validation_error' => 'Pre-visit information validation error',
        'required_field' => 'This field is required to complete registration',
    ],
    'notifications' => [
        'pre_visit_updated' => [
            'title' => 'Pre-Visit Information Updated',
            'body' => 'Patient pre-visit information has been updated successfully',
        ],
        'pre_visit_required' => [
            'title' => 'Required Pre-Visit Information',
            'body' => 'Pre-visit information is required to schedule the dental appointment',
        ],
    ],
    'help' => [
        'last_dental_visit_period' => 'Select the period that best matches your last professional dental visit',
        'dental_problems' => 'Describe in detail any current dental problems to help the dentist in evaluation',
    ],
];
