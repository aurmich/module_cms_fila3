<?php

return [
    'name' => 'Patients',
    'navigation' => [
        'label' => 'Patient Management',
        'sort' => 37,
        'icon' => 'heroicon-o-user-group',
        'color' => 'primary'
    ],
    'fields' => [
        'first_name' => [
            'label' => 'First Name',
            'placeholder' => 'Enter first name',
            'helper_text' => 'Enter first name as shown on ID',
            'description' => 'Patient\'s legal first name',
            'tooltip' => 'Must match the name on ID document'
        ],
        'last_name' => [
            'label' => 'Last Name',
            'placeholder' => 'Enter last name',
            'helper_text' => 'Enter last name as shown on ID',
            'description' => 'Patient\'s legal last name',
            'tooltip' => 'Must match the name on ID document'
        ],
        'fiscal_code' => [
            'label' => 'Fiscal Code',
            'placeholder' => 'Enter fiscal code',
            'helper_text' => 'Patient\'s fiscal code',
            'description' => 'Enter fiscal code as shown on health card',
        ],
        'birth_date' => [
            'label' => 'Date of Birth',
            'placeholder' => 'Select date of birth',
            'helper_text' => 'Patient\'s date of birth',
            'description' => 'Enter date of birth as shown on ID document',
        ],
        'gender' => [
            'label' => 'Gender',
            'placeholder' => 'Select gender',
            'helper_text' => 'Patient\'s gender',
            'options' => [
                'M' => 'Male',
                'F' => 'Female',
                'O' => 'Other',
            ],
        ],
        'is_pregnant' => [
            'label' => 'Pregnant',
            'helper_text' => 'Indicate if patient is pregnant',
            'description' => 'Select if patient is currently pregnant',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Enter email address',
            'helper_text' => 'Valid email address',
            'description' => 'Patient\'s email',
            'tooltip' => 'Will be used for important communications'
        ],
        'phone' => [
            'label' => 'Phone',
            'placeholder' => 'Enter phone number',
            'helper_text' => 'Primary phone number',
            'description' => 'Patient\'s phone number',
            'tooltip' => 'Preferably a mobile number'
        ],
        'address' => [
            'label' => 'Address',
            'placeholder' => 'Enter complete address',
            'helper_text' => 'Street/Square, house number',
            'description' => 'Patient\'s residential address',
            'tooltip' => 'Enter the complete address with house number'
        ],
        'city' => [
            'label' => 'City',
            'placeholder' => 'Enter city',
            'helper_text' => 'City of residence',
            'description' => 'Patient\'s city of residence',
            'tooltip' => 'Enter current city of residence'
        ],
        'postal_code' => [
            'label' => 'Postal Code',
            'placeholder' => 'Enter postal code',
            'helper_text' => 'Postal code',
            'description' => 'Enter postal code of residence city',
        ],
        'province' => [
            'label' => 'Province',
            'placeholder' => 'Enter province',
            'helper_text' => 'Province of residence',
            'description' => 'Enter province of residence',
        ],
        'country' => [
            'label' => 'Country',
            'placeholder' => 'Enter country',
            'helper_text' => 'Country of residence',
            'description' => 'Enter country of residence',
            'default' => 'Italy',
        ],
        'isee_code' => [
            'label' => 'ISEE Code',
            'placeholder' => 'Enter ISEE code',
            'helper_text' => 'ISEE identification code',
            'description' => 'Enter the identification code of the ISEE certificate',
        ],
        'isee_value' => [
            'label' => 'ISEE Value',
            'placeholder' => 'Enter ISEE value',
            'helper_text' => 'ISEE economic value',
            'description' => 'Enter the economic value of the ISEE certificate',
        ],
        'isee_expiry_date' => [
            'label' => 'ISEE Expiry',
            'placeholder' => 'Select expiry date',
            'helper_text' => 'ISEE expiry date',
            'description' => 'Enter the expiry date of the ISEE certificate',
        ],
        'health_card' => [
            'label' => 'Health Card',
            'placeholder' => 'Upload health card',
            'helper_text' => 'Upload a scan/photo of the health card',
            'description' => 'Patient\'s health card',
            'tooltip' => 'Make sure the document is readable'
        ],
        'identity_document' => [
            'label' => 'ID Document',
            'placeholder' => 'Upload ID document',
            'helper_text' => 'Upload a scan/photo of the ID document',
            'description' => 'Valid ID document of the patient',
            'tooltip' => 'ID card, driver\'s license or passport in course of validity'
        ],
        'isee_certificate' => [
            'label' => 'ISEE Certificate',
            'placeholder' => 'Upload ISEE certificate',
            'helper_text' => 'Upload a copy of the ISEE certificate',
            'description' => 'Valid ISEE certificate',
            'tooltip' => 'Required for accessing benefits'
        ],
        'pregnancy_certificate' => [
            'label' => 'Pregnancy Certificate',
            'placeholder' => 'Upload pregnancy certificate',
            'helper_text' => 'If applicable, upload pregnancy certificate',
            'description' => 'Medical certificate confirming pregnancy',
            'tooltip' => 'Optional - Only for pregnant patients'
        ],
        'last_dental_visit' => [
            'label' => 'Last Dental Visit',
            'placeholder' => 'Select date',
            'helper_text' => 'Date of last dental visit',
            'description' => 'When was your last dental visit?',
            'tooltip' => 'Indicate approximate date if not remembered precisely'
        ],
        'dental_problems' => [
            'label' => 'Dental Problems',
            'placeholder' => 'Describe any dental problems',
            'helper_text' => 'Briefly describe current dental problems',
            'description' => 'Current or recent dental problems',
            'tooltip' => 'Include pain, sensitivity or other issues'
        ],
        'notes' => [
            'label' => 'Notes',
            'placeholder' => 'Enter any notes',
            'helper_text' => 'Additional notes',
            'description' => 'Enter any additional notes or information',
        ],
        'privacy_acceptance' => [
            'label' => 'Privacy Acceptance',
            'placeholder' => 'Accept the privacy policy',
            'helper_text' => 'You must accept the privacy policy',
            'description' => 'I accept the processing of personal data according to the privacy policy',
            'tooltip' => 'Read the complete policy before accepting'
        ],
        'newsletter' => [
            'label' => 'Newsletter',
            'helper_text' => 'Receive updates about our activities',
            'placeholder' => 'Select if you want to subscribe to the newsletter',
            'description' => 'Subscribe to our newsletter to receive updates and news',
            'tooltip' => 'You can unsubscribe at any time'
        ],
    ],
    'steps' => [
        'personal_data_step' => [
            'label' => 'Personal Data',
            'description' => 'Enter your personal information',
            'icon' => 'heroicon-o-user',
            'color' => 'primary'
        ],
        'contacts' => [
            'label' => 'Contacts',
            'description' => 'Enter patient\'s contact information',
            'icon' => 'heroicon-o-phone',
        ],
        'documents_step' => [
            'label' => 'Documents',
            'description' => 'Upload required documents',
            'icon' => 'heroicon-o-document',
            'color' => 'success'
        ],
        'pre_visit_step' => [
            'label' => 'Pre-Visit',
            'description' => 'Preliminary visit information',
            'icon' => 'heroicon-o-clipboard-document-list',
            'color' => 'warning'
        ],
        'health' => [
            'label' => 'Health Status',
            'description' => 'Enter health status information',
            'icon' => 'heroicon-o-heart',
        ],
        'privacy_step' => [
            'label' => 'Privacy',
            'description' => 'Consents and authorizations',
            'icon' => 'heroicon-o-shield-check',
            'color' => 'info'
        ],
    ],
    'messages' => [
        'success' => [
            'created' => 'Patient created successfully',
            'updated' => 'Patient data updated successfully',
            'deleted' => 'Patient deleted successfully'
        ],
        'errors' => [
            'create' => 'Error while creating patient',
            'update' => 'Error while updating data',
            'delete' => 'Error while deleting patient'
        ],
        'confirmations' => [
            'delete' => 'Are you sure you want to delete this patient?'
        ]
    ],
    'actions' => [
        'create' => [
            'label' => 'New Patient',
            'tooltip' => 'Create a new patient record'
        ],
        'edit' => [
            'label' => 'Edit',
            'tooltip' => 'Edit patient data'
        ],
        'delete' => [
            'label' => 'Delete',
            'tooltip' => 'Delete patient record'
        ],
        'view' => [
            'label' => 'View',
            'tooltip' => 'View patient details'
        ]
    ]
]; 