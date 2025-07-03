<?php

<<<<<<< HEAD
declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Patient Registry',
        'group' => 'Patient Management',
        'icon' => 'heroicon-o-users',
        'color' => 'blue',
        'sort' => 3,
        'tooltip' => 'Manage complete patient registry and clinical information',
    ],

    'model' => [
        'label' => 'Patient',
        'plural' => 'Patients',
        'description' => 'Complete management of patient records and health data',
        'icon' => 'heroicon-o-user-group',
    ],

    'pages' => [
        'index' => [
            'title' => 'Registered Patients List',
            'subtitle' => 'Complete registry management',
            'description' => 'View, edit and delete patient records registered in the system',
        ],
        'create' => [
            'title' => 'New Patient Registration',
            'subtitle' => 'Entering demographic and health data',
            'description' => 'Complete the guided form to register a new patient with all necessary data',
        ],
        'edit' => [
            'title' => 'Edit Patient Record',
            'subtitle' => 'Updating existing data',
            'description' => 'Modify demographic, health and documentation information for the selected patient',
        ],
        'view' => [
            'title' => 'Complete Patient Details',
            'subtitle' => 'Full record view',
            'description' => 'View all demographic, health and documentation data registered for this patient',
        ],
    ],

    'steps' => [
        'personal_data_step' => [
            'label' => 'Personal Data',
            'description' => 'Enter name, surname, tax code and date of birth',
            'icon' => 'heroicon-o-identification',
            'color' => 'primary',
            'help' => 'All demographic fields are mandatory and must match official documents',
        ],
        'contacts' => [
            'label' => 'Contacts and Information',
            'description' => 'Enter email, phone and residence address',
            'icon' => 'heroicon-o-phone',
            'color' => 'info',
            'help' => 'Contact data is essential for communications and appointments',
        ],
        'documents_step' => [
            'label' => 'Official Documents',
            'description' => 'Upload health card, identity document and certificates',
            'icon' => 'heroicon-o-document-text',
            'color' => 'success',
            'help' => 'Documents must be in PDF, JPG or PNG format with maximum size 5MB',
        ],
        'pre_visit_step' => [
            'label' => 'Pre-Visit Information',
            'description' => 'Medical history and current dental problems',
            'icon' => 'heroicon-o-clipboard-document-list',
            'color' => 'warning',
            'help' => 'This information helps the doctor better prepare for the visit',
        ],
        'health' => [
            'label' => 'General Health Status',
            'description' => 'Pathologies, allergies and relevant medical information',
            'icon' => 'heroicon-o-heart',
            'color' => 'danger',
            'help' => 'Provide complete information about allergies, chronic conditions and medications taken',
        ],
        'privacy_step' => [
            'label' => 'Privacy and Consent',
            'description' => 'Data processing consent and marketing communications',
            'icon' => 'heroicon-o-shield-check',
            'color' => 'info',
            'help' => 'Privacy consent is mandatory by law, newsletter is optional',
        ],
    ],

    'fields' => [
        'id' => [
            'label' => 'Patient ID',
            'placeholder' => 'Unique numeric code generated automatically',
            'helper_text' => '',
        ],
        'name' => [
            'label' => 'Full Patient Name',
            'placeholder' => 'First and last name concatenated for display',
            'helper_text' => '',
        ],
        'first_name' => [
            'label' => 'First Name',
            'placeholder' => 'Enter patient\'s first name',
            'helper_text' => '',
            'validation' => [
                'required' => 'First name is required',
                'min' => 'First name must contain at least 2 characters',
                'max' => 'First name cannot exceed 50 characters',
                'alpha' => 'First name can only contain letters',
            ],
        ],
        'last_name' => [
            'label' => 'Last Name',
            'placeholder' => 'Enter patient\'s last name',
            'helper_text' => '',
            'validation' => [
                'required' => 'Last name is required',
                'min' => 'Last name must contain at least 2 characters',
                'max' => 'Last name cannot exceed 50 characters',
                'alpha' => 'Last name can only contain letters',
            ],
        ],
        'fiscal_code' => [
            'label' => 'Tax ID Code',
            'placeholder' => 'Enter 16 characters of tax code (e.g. RSSMRA80A01H501U)',
            'helper_text' => '',
            'validation' => [
                'required' => 'Tax code is required',
                'regex' => 'Tax code must be in correct Italian format (16 characters)',
                'unique' => 'This tax code is already registered in the system',
            ],
        ],
        'birth_date' => [
            'label' => 'Date of Birth',
            'placeholder' => 'Select birth date from calendar',
            'helper_text' => '',
            'validation' => [
                'required' => 'Date of birth is required',
                'date' => 'Enter a valid date',
                'before' => 'Birth date must be before today\'s date',
                'after' => 'Birth date cannot be more than 120 years ago',
            ],
        ],
        'gender' => [
            'label' => 'Gender',
            'placeholder' => 'Select gender from dropdown menu',
            'helper_text' => '',
            'options' => [
                'M' => 'Male',
                'F' => 'Female',
                'X' => 'Not specified/Other',
            ],
            'validation' => [
                'required' => 'Gender is required',
                'in' => 'Select a valid gender from available options',
            ],
        ],
        'nationality' => [
            'label' => 'Nationality',
            'placeholder' => 'Select patient\'s nationality',
            'helper_text' => '',
        ],
        'years_in_italy' => [
            'label' => 'Years in Italy',
            'placeholder' => 'Enter number of years residing in Italy',
            'helper_text' => '',
        ],
        'email' => [
            'label' => 'Email Address',
            'placeholder' => 'Enter valid email (e.g. name@domain.com)',
            'helper_text' => '',
            'validation' => [
                'required' => 'Email address is required',
                'email' => 'Enter a valid and working email address',
                'unique' => 'This email address is already registered for another patient',
                'max' => 'Email address cannot exceed 255 characters',
            ],
        ],
        'phone' => [
            'label' => 'Phone Number',
            'placeholder' => 'Enter complete number (e.g. +39 333 123 4567)',
            'helper_text' => '',
            'validation' => [
                'required' => 'Phone number is required',
                'regex' => 'Enter a valid Italian phone number',
                'min' => 'Number must contain at least 10 digits',
            ],
        ],
        'address' => [
            'label' => 'Residence Address',
            'placeholder' => 'Street/Square Name of the Street, 123',
            'helper_text' => '',
            'validation' => [
                'required' => 'Residence address is required',
                'min' => 'Address must contain at least 10 characters',
                'max' => 'Address cannot exceed 200 characters',
            ],
        ],
        'city' => [
            'label' => 'City of Residence',
            'placeholder' => 'Enter city name',
            'helper_text' => '',
            'validation' => [
                'required' => 'City is required',
                'min' => 'City name must contain at least 2 characters',
                'max' => 'City name cannot exceed 100 characters',
            ],
        ],
        'postal_code' => [
            'label' => 'Postal Code (ZIP)',
            'placeholder' => 'Enter 5 digits of postal code (e.g. 00100)',
            'helper_text' => '',
            'validation' => [
                'required' => 'Postal code is required',
                'regex' => 'Postal code must be exactly 5 digits',
                'numeric' => 'Postal code must contain only numbers',
            ],
        ],
        'province' => [
            'label' => 'Province of Residence',
            'placeholder' => 'Select province (e.g. RM, MI, NA)',
            'helper_text' => '',
            'validation' => [
                'required' => 'Province is required',
                'size' => 'Province code must be exactly 2 characters',
                'alpha' => 'Province must contain only letters',
            ],
        ],
        'country' => [
            'label' => 'Country of Residence',
            'placeholder' => 'Select country from menu',
            'helper_text' => '',
        ],
        'country_code' => [
            'label' => 'Country Code',
            'placeholder' => 'ISO country code (e.g. IT, FR, DE)',
            'helper_text' => '',
        ],
        'isee_code' => [
            'label' => 'ISEE Identification Code',
            'placeholder' => 'Enter unique ISEE certificate code',
            'helper_text' => '',
            'validation' => [
                'alpha_num' => 'ISEE code must contain only letters and numbers',
                'max' => 'ISEE code cannot exceed 20 characters',
            ],
        ],
        'isee_value' => [
            'label' => 'ISEE Indicator Value',
            'placeholder' => 'Enter amount in euros (e.g. 15000.50)',
            'helper_text' => '',
            'validation' => [
                'numeric' => 'ISEE value must be a valid number',
                'min' => 'ISEE value must be greater than 0',
                'max' => 'ISEE value cannot exceed 999999.99 euros',
            ],
        ],
        'isee_expiry_date' => [
            'label' => 'ISEE Certificate Expiry Date',
            'placeholder' => 'Select expiry date from calendar',
            'helper_text' => '',
            'validation' => [
                'date' => 'Enter a valid expiry date',
                'after' => 'Expiry date must be in the future to access benefits',
            ],
        ],
        'health_card' => [
            'label' => 'Health Card Scan',
            'placeholder' => 'Upload image file or PDF of health card',
            'helper_text' => '',
            'validation' => [
                'required' => 'Health card is required for patient identification',
                'file' => 'Upload a valid file',
                'mimes' => 'Supported formats: JPG, JPEG, PNG, PDF',
                'max' => 'Maximum allowed size: 5MB per file',
            ],
        ],
        'identity_document' => [
            'label' => 'Valid Identity Document',
            'placeholder' => 'Upload scan of valid identity document',
            'helper_text' => '',
            'validation' => [
                'required' => 'Identity document is required for demographic verification',
                'file' => 'Upload a valid file',
                'mimes' => 'Supported formats: JPG, JPEG, PNG, PDF',
                'max' => 'Maximum allowed size: 5MB per file',
            ],
        ],
        'isee_certificate' => [
            'label' => 'Complete ISEE Certificate',
            'placeholder' => 'Upload ISEE certificate for economic benefits',
            'helper_text' => '',
            'validation' => [
                'file' => 'Upload a valid ISEE certificate',
                'mimes' => 'Supported formats: JPG, JPEG, PNG, PDF',
                'max' => 'Maximum allowed size: 5MB per file',
            ],
        ],
        'pregnancy_certificate' => [
            'label' => 'Pregnancy Medical Certificate',
            'placeholder' => 'Upload medical certificate attesting pregnancy status',
            'helper_text' => '',
            'validation' => [
                'file' => 'Upload a valid medical certificate',
                'mimes' => 'Supported formats: JPG, JPEG, PNG, PDF',
                'max' => 'Maximum allowed size: 5MB per file',
            ],
        ],
        'is_pregnant' => [
            'label' => 'Current Pregnancy Status',
            'placeholder' => 'Indicate if patient is currently pregnant',
            'helper_text' => '',
            'options' => [
                1 => 'Yes, currently pregnant',
                0 => 'No, not pregnant',
            ],
        ],
        'last_dental_visit' => [
            'label' => 'Last Dental Visit Date',
            'placeholder' => 'Select approximate date of last dental visit',
            'helper_text' => '',
            'validation' => [
                'date' => 'Enter a valid date',
                'before_or_equal' => 'Last visit date cannot be in the future',
            ],
        ],
        'last_dental_visit_period' => [
            'label' => 'When was your last dental visit?',
            'placeholder' => 'Select the time period of your last dental visit',
            'helper_text' => '',
        ],
        'dental_problems' => [
            'label' => 'Current Dental Problems',
            'placeholder' => 'Describe current dental pain, sensitivity or disorders',
            'helper_text' => '',
            'validation' => [
                'max' => 'Description cannot exceed 500 characters',
            ],
        ],
        'allergies' => [
            'label' => 'Allergies and Intolerances',
            'placeholder' => 'List drugs, foods or substances that cause allergies',
            'helper_text' => '',
            'validation' => [
                'max' => 'Allergy list cannot exceed 1000 characters',
            ],
        ],
        'chronic_diseases' => [
            'label' => 'Chronic Conditions',
            'placeholder' => 'Indicate diabetes, hypertension, heart conditions or other chronic pathologies',
            'helper_text' => '',
            'validation' => [
                'max' => 'Condition list cannot exceed 1000 characters',
            ],
        ],
        'current_medications' => [
            'label' => 'Currently Taken Medications',
            'placeholder' => 'List all medications with dosage and frequency',
            'helper_text' => '',
            'validation' => [
                'max' => 'Medication list cannot exceed 1000 characters',
            ],
        ],
        'notes' => [
            'label' => 'Additional Clinical Notes',
            'placeholder' => 'Enter other relevant medical information not specified above',
            'helper_text' => '',
            'validation' => [
                'max' => 'Additional notes cannot exceed 1500 characters',
            ],
        ],
        'children_count' => [
            'label' => 'Number of Children',
            'placeholder' => 'Enter number of children',
            'helper_text' => '',
        ],
        'privacy_acceptance' => [
            'label' => 'Personal Data Processing Consent',
            'placeholder' => 'I must accept data processing according to GDPR',
            'helper_text' => '',
            'validation' => [
                'accepted' => 'It is mandatory to accept the privacy policy to proceed',
            ],
        ],
        'newsletter' => [
            'label' => 'Newsletter Subscription',
            'placeholder' => 'I want to receive periodic communications via email',
            'helper_text' => '',
        ],
        'marketing_communications' => [
            'label' => 'Marketing Communications Consent',
            'placeholder' => 'I accept to receive personalized commercial offers',
            'helper_text' => '',
        ],
        'created_at' => [
            'label' => 'System Registration Date',
            'placeholder' => 'Record creation timestamp generated automatically',
            'helper_text' => '',
        ],
        'updated_at' => [
            'label' => 'Last Data Update',
            'placeholder' => 'Last modification timestamp generated automatically',
            'helper_text' => '',
        ],
    ],

    'actions' => [
        'create' => [
            'label' => 'Register New Patient',
            'modal_heading' => 'Patient Registration',
            'modal_description' => 'Complete all required fields to register a new patient',
            'success' => 'Patient successfully registered in the system',
            'error' => 'Error during patient registration',
        ],
        'edit' => [
            'label' => 'Edit Data',
            'modal_heading' => 'Edit Patient Information',
            'modal_description' => 'Update information for the selected patient',
            'success' => 'Patient data updated successfully',
            'error' => 'Error during data update',
        ],
        'view' => [
            'label' => 'View Details',
            'modal_heading' => 'Complete Patient Record',
            'modal_description' => 'View all data for the selected patient',
        ],
        'delete' => [
            'label' => 'Delete Patient',
            'modal_heading' => 'Confirm Deletion',
            'modal_description' => 'Are you sure you want to permanently delete this patient?',
            'success' => 'Patient deleted from system',
            'error' => 'Error during deletion',
            'confirmation' => 'This operation cannot be undone',
        ],
        'approve' => [
            'label' => 'Approve Registration',
            'modal_heading' => 'Approve Patient',
            'modal_description' => 'Confirm approval of this patient registration',
            'success' => 'Patient registration approved',
            'error' => 'Error during approval',
        ],
        'reject' => [
            'label' => 'Reject Registration',
            'modal_heading' => 'Reject Patient',
            'modal_description' => 'Indicate reason for rejecting the registration',
            'success' => 'Patient registration rejected',
            'error' => 'Error during rejection',
        ],
    ],

    'messages' => [
        'welcome' => 'Welcome to patient management',
        'registration_success' => 'Registration completed successfully',
        'validation_errors' => 'Check highlighted fields and try again',
        'document_uploaded' => 'Document uploaded successfully',
        'document_error' => 'Error during document upload',
        'empty_state' => 'No patients registered in the system',
        'search_no_results' => 'No patients found with the specified search criteria',
    ],
];
=======
return array (
  'name' => 'Patients',
  'navigation' => 
  array (
    'label' => 'Patient Management',
    'sort' => 37,
    'icon' => 'heroicon-o-user-group',
    'color' => 'primary',
  ),
  'fields' => 
  array (
    'first_name' => 
    array (
      'label' => 'First Name',
      'placeholder' => 'Enter first name',
      'helper_text' => '',
      'description' => 'Patient\'s legal first name',
      'tooltip' => 'Must match the name on ID document',
    ),
    'last_name' => 
    array (
      'label' => 'Last Name',
      'placeholder' => 'Enter last name',
      'helper_text' => '',
      'description' => 'Patient\'s legal last name',
      'tooltip' => 'Must match the name on ID document',
    ),
    'fiscal_code' => 
    array (
      'label' => 'Fiscal Code',
      'placeholder' => 'Enter fiscal code',
      'helper_text' => 'Patient\'s fiscal code',
      'description' => 'Enter fiscal code as shown on health card',
    ),
    'birth_date' => 
    array (
      'label' => 'Date of Birth',
      'placeholder' => 'Select date of birth',
      'helper_text' => 'Patient\'s date of birth',
      'description' => 'Enter date of birth as shown on ID document',
    ),
    'gender' => 
    array (
      'label' => 'Gender',
      'placeholder' => 'Select gender',
      'helper_text' => 'Patient\'s gender',
      'options' => 
      array (
        'M' => 'Male',
        'F' => 'Female',
        'O' => 'Other',
      ),
    ),
    'is_pregnant' => 
    array (
      'label' => 'Pregnant',
      'helper_text' => 'Indicate if patient is pregnant',
      'description' => 'Select if patient is currently pregnant',
    ),
    'email' => 
    array (
      'label' => 'Email',
      'placeholder' => 'Enter email address',
      'helper_text' => 'Valid email address',
      'description' => 'Patient\'s email',
      'tooltip' => 'Will be used for important communications',
    ),
    'phone' => 
    array (
      'label' => 'Phone',
      'placeholder' => 'Enter phone number',
      'helper_text' => 'Primary phone number',
      'description' => 'Patient\'s phone number',
      'tooltip' => 'Preferably a mobile number',
    ),
    'address' => 
    array (
      'label' => 'Address',
      'placeholder' => 'Enter complete address',
      'helper_text' => 'Street/Square, house number',
      'description' => 'Patient\'s residential address',
      'tooltip' => 'Enter the complete address with house number',
    ),
    'city' => 
    array (
      'label' => 'City',
      'placeholder' => 'Enter city',
      'helper_text' => 'City of residence',
      'description' => 'Patient\'s city of residence',
      'tooltip' => 'Enter current city of residence',
    ),
    'postal_code' => 
    array (
      'label' => 'Postal Code',
      'placeholder' => 'Enter postal code',
      'helper_text' => 'Postal code',
      'description' => 'Enter postal code of residence city',
    ),
    'province' => 
    array (
      'label' => 'Province',
      'placeholder' => 'Enter province',
      'helper_text' => 'Province of residence',
      'description' => 'Enter province of residence',
    ),
    'country' => 
    array (
      'label' => 'Country',
      'placeholder' => 'Enter country',
      'helper_text' => 'Country of residence',
      'description' => 'Enter country of residence',
      'default' => 'Italy',
    ),
    'isee_code' => 
    array (
      'label' => 'ISEE Code',
      'placeholder' => 'Enter ISEE code',
      'helper_text' => 'ISEE identification code',
      'description' => 'Enter the identification code of the ISEE certificate',
    ),
    'isee_value' => 
    array (
      'label' => 'ISEE Value',
      'placeholder' => 'Enter ISEE value',
      'helper_text' => 'ISEE economic value',
      'description' => 'Enter the economic value of the ISEE certificate',
    ),
    'isee_expiry_date' => 
    array (
      'label' => 'ISEE Expiry',
      'placeholder' => 'Select expiry date',
      'helper_text' => 'ISEE expiry date',
      'description' => 'Enter the expiry date of the ISEE certificate',
    ),
    'health_card' => 
    array (
      'label' => 'Health Card',
      'placeholder' => 'Upload health card',
      'helper_text' => 'Upload a scan/photo of the health card',
      'description' => 'Patient\'s health card',
      'tooltip' => 'Make sure the document is readable',
    ),
    'identity_document' => 
    array (
      'label' => 'ID Document',
      'placeholder' => 'Upload ID document',
      'helper_text' => 'Upload a scan/photo of the ID document',
      'description' => 'Valid ID document of the patient',
      'tooltip' => 'ID card, driver\'s license or passport in course of validity',
    ),
    'isee_certificate' => 
    array (
      'label' => 'ISEE Certificate',
      'placeholder' => 'Upload ISEE certificate',
      'helper_text' => 'Upload a copy of the ISEE certificate',
      'description' => 'Valid ISEE certificate',
      'tooltip' => 'Required for accessing benefits',
    ),
    'pregnancy_certificate' => 
    array (
      'label' => 'Pregnancy Certificate',
      'placeholder' => 'Upload pregnancy certificate',
      'helper_text' => 'If applicable, upload pregnancy certificate',
      'description' => 'Medical certificate confirming pregnancy',
      'tooltip' => 'Optional - Only for pregnant patients',
    ),
    'last_dental_visit' => 
    array (
      'label' => 'Last Dental Visit',
      'placeholder' => 'Select date',
      'helper_text' => 'Date of last dental visit',
      'description' => 'When was your last dental visit?',
      'tooltip' => 'Indicate approximate date if not remembered precisely',
    ),
    'dental_problems' => 
    array (
      'label' => 'Dental Problems',
      'placeholder' => 'Describe any dental problems',
      'helper_text' => 'Briefly describe current dental problems',
      'description' => 'Current or recent dental problems',
      'tooltip' => 'Include pain, sensitivity or other issues',
    ),
    'notes' => 
    array (
      'label' => 'Notes',
      'placeholder' => 'Enter any notes',
      'helper_text' => 'Additional notes',
      'description' => 'Enter any additional notes or information',
    ),
    'privacy_acceptance' => 
    array (
      'label' => 'Privacy Acceptance',
      'placeholder' => 'Accept the privacy policy',
      'helper_text' => 'You must accept the privacy policy',
      'description' => 'I accept the processing of personal data according to the privacy policy',
      'tooltip' => 'Read the complete policy before accepting',
    ),
    'newsletter' => 
    array (
      'label' => 'Newsletter',
      'helper_text' => 'Receive updates about our activities',
      'placeholder' => 'Select if you want to subscribe to the newsletter',
      'description' => 'Subscribe to our newsletter to receive updates and news',
      'tooltip' => 'You can unsubscribe at any time',
    ),
    'children_count' => 
    array (
      'description' => 'children_count',
      'helper_text' => 'children_count',
    ),
  ),
  'steps' => 
  array (
    'personal_data_step' => 
    array (
      'label' => 'Personal Data',
      'description' => 'Enter your personal information',
      'icon' => 'heroicon-o-user',
      'color' => 'primary',
    ),
    'contacts' => 
    array (
      'label' => 'Contacts',
      'description' => 'Enter patient\'s contact information',
      'icon' => 'heroicon-o-phone',
    ),
    'documents_step' => 
    array (
      'label' => 'Documents',
      'description' => 'Upload required documents',
      'icon' => 'heroicon-o-document',
      'color' => 'success',
    ),
    'pre_visit_step' => 
    array (
      'label' => 'Pre-Visit',
      'description' => 'Preliminary visit information',
      'icon' => 'heroicon-o-clipboard-document-list',
      'color' => 'warning',
    ),
    'health' => 
    array (
      'label' => 'Health Status',
      'description' => 'Enter health status information',
      'icon' => 'heroicon-o-heart',
    ),
    'privacy_step' => 
    array (
      'label' => 'Privacy',
      'description' => 'Consents and authorizations',
      'icon' => 'heroicon-o-shield-check',
      'color' => 'info',
    ),
  ),
  'messages' => 
  array (
    'success' => 
    array (
      'created' => 'Patient created successfully',
      'updated' => 'Patient data updated successfully',
      'deleted' => 'Patient deleted successfully',
    ),
    'errors' => 
    array (
      'create' => 'Error while creating patient',
      'update' => 'Error while updating data',
      'delete' => 'Error while deleting patient',
    ),
    'confirmations' => 
    array (
      'delete' => 'Are you sure you want to delete this patient?',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'New Patient',
      'tooltip' => 'Create a new patient record',
    ),
    'edit' => 
    array (
      'label' => 'Edit',
      'tooltip' => 'Edit patient data',
    ),
    'delete' => 
    array (
      'label' => 'Delete',
      'tooltip' => 'Delete patient record',
    ),
    'view' => 
    array (
      'label' => 'View',
      'tooltip' => 'View patient details',
    ),
  ),
);
>>>>>>> 1c0ba5b2 (translations)
