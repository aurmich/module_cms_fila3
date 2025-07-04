<?php

return array (
  'navigation' => 
  array (
    'label' => 'Patient Registry',
    'group' => 'Patient Management',
    'icon' => 'heroicon-o-users',
    'color' => 'blue',
    'sort' => 3,
    'tooltip' => 'Manage complete patient registry and clinical information',
  ),
  'model' => 
  array (
    'label' => 'Patient',
    'plural' => 'Patients',
    'description' => 'Complete management of patient records and health data',
    'icon' => 'heroicon-o-user-group',
  ),
  'pages' => 
  array (
    'index' => 
    array (
      'title' => 'Registered Patients List',
      'subtitle' => 'Complete registry management',
      'description' => 'View, edit and delete patient records registered in the system',
    ),
    'create' => 
    array (
      'title' => 'New Patient Registration',
      'subtitle' => 'Entering demographic and health data',
      'description' => 'Complete the guided form to register a new patient with all necessary data',
    ),
    'edit' => 
    array (
      'title' => 'Edit Patient Record',
      'subtitle' => 'Updating existing data',
      'description' => 'Modify demographic, health and documentation information for the selected patient',
    ),
    'view' => 
    array (
      'title' => 'Complete Patient Details',
      'subtitle' => 'Full record view',
      'description' => 'View all demographic, health and documentation data registered for this patient',
    ),
  ),
  'steps' => 
  array (
    'personal_data_step' => 
    array (
      'label' => 'Personal Data',
      'description' => 'Enter name, surname, tax code and date of birth',
      'icon' => 'heroicon-o-identification',
      'color' => 'primary',
      'help' => 'All demographic fields are mandatory and must match official documents',
    ),
    'contacts' => 
    array (
      'label' => 'Contacts and Information',
      'description' => 'Enter email, phone and residence address',
      'icon' => 'heroicon-o-phone',
      'color' => 'info',
      'help' => 'Contact data is essential for communications and appointments',
    ),
    'documents_step' => 
    array (
      'label' => 'Official Documents',
      'description' => 'Upload health card, identity document and certificates',
      'icon' => 'heroicon-o-document-text',
      'color' => 'success',
      'help' => 'Documents must be in PDF, JPG or PNG format with maximum size 5MB',
    ),
    'pre_visit_step' => 
    array (
      'label' => 'Pre-Visit Information',
      'description' => 'Medical history and current dental problems',
      'icon' => 'heroicon-o-clipboard-document-list',
      'color' => 'warning',
      'help' => 'This information helps the doctor better prepare for the visit',
    ),
    'health' => 
    array (
      'label' => 'General Health Status',
      'description' => 'Pathologies, allergies and relevant medical information',
      'icon' => 'heroicon-o-heart',
      'color' => 'danger',
      'help' => 'Provide complete information about allergies, chronic conditions and medications taken',
    ),
    'privacy_step' => 
    array (
      'label' => 'Privacy and Consent',
      'description' => 'Data processing consent and marketing communications',
      'icon' => 'heroicon-o-shield-check',
      'color' => 'info',
      'help' => 'Privacy consent is mandatory by law, newsletter is optional',
    ),
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'Patient ID',
      'placeholder' => 'Unique numeric code generated automatically',
      'helper_text' => '',
    ),
    'name' => 
    array (
      'label' => 'Full Patient Name',
      'placeholder' => 'First and last name concatenated for display',
      'helper_text' => '',
    ),
    'first_name' => 
    array (
      'label' => 'First Name',
      'placeholder' => 'Enter patient\'s first name',
      'helper_text' => '',
      'validation' => 
      array (
        'required' => 'First name is required',
        'min' => 'First name must contain at least 2 characters',
        'max' => 'First name cannot exceed 50 characters',
        'alpha' => 'First name can only contain letters',
      ),
    ),
    'last_name' => 
    array (
      'label' => 'Last Name',
      'placeholder' => 'Enter patient\'s last name',
      'helper_text' => '',
      'validation' => 
      array (
        'required' => 'Last name is required',
        'min' => 'Last name must contain at least 2 characters',
        'max' => 'Last name cannot exceed 50 characters',
        'alpha' => 'Last name can only contain letters',
      ),
    ),
    'fiscal_code' => 
    array (
      'label' => 'Tax ID Code',
      'placeholder' => 'Enter 16 characters of tax code (e.g. RSSMRA80A01H501U)',
      'helper_text' => '',
      'validation' => 
      array (
        'required' => 'Tax code is required',
        'regex' => 'Tax code must be in correct Italian format (16 characters)',
        'unique' => 'This tax code is already registered in the system',
      ),
    ),
    'birth_date' => 
    array (
      'label' => 'Date of Birth',
      'placeholder' => 'Select birth date from calendar',
      'helper_text' => '',
      'validation' => 
      array (
        'required' => 'Date of birth is required',
        'date' => 'Enter a valid date',
        'before' => 'Birth date must be before today\'s date',
        'after' => 'Birth date cannot be more than 120 years ago',
      ),
    ),
    'gender' => 
    array (
      'label' => 'Gender',
      'placeholder' => 'Select gender from dropdown menu',
      'helper_text' => '',
      'options' => 
      array (
        'M' => 'Male',
        'F' => 'Female',
        'X' => 'Not specified/Other',
      ),
      'validation' => 
      array (
        'required' => 'Gender is required',
        'in' => 'Select a valid gender from available options',
      ),
    ),
    'nationality' => 
    array (
      'label' => 'Nationality',
      'placeholder' => 'Select patient\'s nationality',
      'helper_text' => '',
    ),
    'years_in_italy' => 
    array (
      'label' => 'Years in Italy',
      'placeholder' => 'Enter number of years residing in Italy',
      'helper_text' => '',
    ),
    'email' => 
    array (
      'label' => 'Email Address',
      'placeholder' => 'Enter valid email (e.g. name@domain.com)',
      'helper_text' => '',
      'validation' => 
      array (
        'required' => 'Email address is required',
        'email' => 'Enter a valid and working email address',
        'unique' => 'This email address is already registered for another patient',
        'max' => 'Email address cannot exceed 255 characters',
      ),
    ),
    'phone' => 
    array (
      'label' => 'Phone Number',
      'placeholder' => 'Enter complete number (e.g. +39 333 123 4567)',
      'helper_text' => '',
      'validation' => 
      array (
        'required' => 'Phone number is required',
        'regex' => 'Enter a valid Italian phone number',
        'min' => 'Number must contain at least 10 digits',
      ),
    ),
    'address' => 
    array (
      'label' => 'Residence Address',
      'placeholder' => 'Street/Square Name of the Street, 123',
      'helper_text' => '',
      'validation' => 
      array (
        'required' => 'Residence address is required',
        'min' => 'Address must contain at least 10 characters',
        'max' => 'Address cannot exceed 200 characters',
      ),
    ),
    'city' => 
    array (
      'label' => 'City of Residence',
      'placeholder' => 'Enter city name',
      'helper_text' => '',
      'validation' => 
      array (
        'required' => 'City is required',
        'min' => 'City name must contain at least 2 characters',
        'max' => 'City name cannot exceed 100 characters',
      ),
    ),
    'postal_code' => 
    array (
      'label' => 'Postal Code (ZIP)',
      'placeholder' => 'Enter 5 digits of postal code (e.g. 00100)',
      'helper_text' => '',
      'validation' => 
      array (
        'required' => 'Postal code is required',
        'regex' => 'Postal code must be exactly 5 digits',
        'numeric' => 'Postal code must contain only numbers',
      ),
    ),
    'province' => 
    array (
      'label' => 'Province of Residence',
      'placeholder' => 'Select province (e.g. RM, MI, NA)',
      'helper_text' => '',
      'validation' => 
      array (
        'required' => 'Province is required',
        'size' => 'Province code must be exactly 2 characters',
        'alpha' => 'Province must contain only letters',
      ),
    ),
    'country' => 
    array (
      'label' => 'Country of Residence',
      'placeholder' => 'Select country from menu',
      'helper_text' => '',
    ),
    'country_code' => 
    array (
      'label' => 'Country Code',
      'placeholder' => 'ISO country code (e.g. IT, FR, DE)',
      'helper_text' => '',
    ),
    'isee_code' => 
    array (
      'label' => 'ISEE Identification Code',
      'placeholder' => 'Enter unique ISEE certificate code',
      'helper_text' => '',
      'validation' => 
      array (
        'alpha_num' => 'ISEE code must contain only letters and numbers',
        'max' => 'ISEE code cannot exceed 20 characters',
      ),
    ),
    'isee_value' => 
    array (
      'label' => 'ISEE Indicator Value',
      'placeholder' => 'Enter amount in euros (e.g. 15000.50)',
      'helper_text' => '',
      'validation' => 
      array (
        'numeric' => 'ISEE value must be a valid number',
        'min' => 'ISEE value must be greater than 0',
        'max' => 'ISEE value cannot exceed 999999.99 euros',
      ),
    ),
    'isee_expiry_date' => 
    array (
      'label' => 'ISEE Certificate Expiry Date',
      'placeholder' => 'Select expiry date from calendar',
      'helper_text' => '',
      'validation' => 
      array (
        'date' => 'Enter a valid expiry date',
        'after' => 'Expiry date must be in the future to access benefits',
      ),
    ),
    'health_card' => 
    array (
      'label' => 'Health Card Scan',
      'placeholder' => 'Upload image file or PDF of health card',
      'helper_text' => '',
      'validation' => 
      array (
        'required' => 'Health card is required for patient identification',
        'file' => 'Upload a valid file',
        'mimes' => 'Supported formats: JPG, JPEG, PNG, PDF',
        'max' => 'Maximum allowed size: 5MB per file',
      ),
    ),
    'identity_document' => 
    array (
      'label' => 'Valid Identity Document',
      'placeholder' => 'Upload scan of valid identity document',
      'helper_text' => '',
      'validation' => 
      array (
        'required' => 'Identity document is required for demographic verification',
        'file' => 'Upload a valid file',
        'mimes' => 'Supported formats: JPG, JPEG, PNG, PDF',
        'max' => 'Maximum allowed size: 5MB per file',
      ),
    ),
    'isee_certificate' => 
    array (
      'label' => 'Complete ISEE Certificate',
      'placeholder' => 'Upload ISEE certificate for economic benefits',
      'helper_text' => '',
      'validation' => 
      array (
        'file' => 'Upload a valid ISEE certificate',
        'mimes' => 'Supported formats: JPG, JPEG, PNG, PDF',
        'max' => 'Maximum allowed size: 5MB per file',
      ),
    ),
    'pregnancy_certificate' => 
    array (
      'label' => 'Pregnancy Medical Certificate',
      'placeholder' => 'Upload medical certificate attesting pregnancy status',
      'helper_text' => '',
      'validation' => 
      array (
        'file' => 'Upload a valid medical certificate',
        'mimes' => 'Supported formats: JPG, JPEG, PNG, PDF',
        'max' => 'Maximum allowed size: 5MB per file',
      ),
    ),
    'is_pregnant' => 
    array (
      'label' => 'Current Pregnancy Status',
      'placeholder' => 'Indicate if patient is currently pregnant',
      'helper_text' => '',
      'options' => 
      array (
        1 => 'Yes, currently pregnant',
        0 => 'No, not pregnant',
      ),
    ),
    'last_dental_visit' => 
    array (
      'label' => 'Last Dental Visit Date',
      'placeholder' => 'Select approximate date of last dental visit',
      'helper_text' => '',
      'validation' => 
      array (
        'date' => 'Enter a valid date',
        'before_or_equal' => 'Last visit date cannot be in the future',
      ),
    ),
    'last_dental_visit_period' => 
    array (
      'label' => 'When was your last dental visit?',
      'placeholder' => 'Select the time period of your last dental visit',
      'helper_text' => '',
    ),
    'dental_problems' => 
    array (
      'label' => 'Current Dental Problems',
      'placeholder' => 'Describe current dental pain, sensitivity or disorders',
      'helper_text' => '',
      'validation' => 
      array (
        'max' => 'Description cannot exceed 500 characters',
      ),
    ),
    'allergies' => 
    array (
      'label' => 'Allergies and Intolerances',
      'placeholder' => 'List drugs, foods or substances that cause allergies',
      'helper_text' => '',
      'validation' => 
      array (
        'max' => 'Allergy list cannot exceed 1000 characters',
      ),
    ),
    'chronic_diseases' => 
    array (
      'label' => 'Chronic Conditions',
      'placeholder' => 'Indicate diabetes, hypertension, heart conditions or other chronic pathologies',
      'helper_text' => '',
      'validation' => 
      array (
        'max' => 'Condition list cannot exceed 1000 characters',
      ),
    ),
    'current_medications' => 
    array (
      'label' => 'Currently Taken Medications',
      'placeholder' => 'List all medications with dosage and frequency',
      'helper_text' => '',
      'validation' => 
      array (
        'max' => 'Medication list cannot exceed 1000 characters',
      ),
    ),
    'notes' => 
    array (
      'label' => 'Additional Clinical Notes',
      'placeholder' => 'Enter other relevant medical information not specified above',
      'helper_text' => '',
      'validation' => 
      array (
        'max' => 'Additional notes cannot exceed 1500 characters',
      ),
    ),
    'children_count' => 
    array (
      'label' => 'Number of Children',
      'placeholder' => 'Enter number of children',
      'helper_text' => '',
    ),
    'privacy_acceptance' => 
    array (
      'label' => 'Personal Data Processing Consent',
      'placeholder' => 'I must accept data processing according to GDPR',
      'helper_text' => '',
      'validation' => 
      array (
        'accepted' => 'It is mandatory to accept the privacy policy to proceed',
      ),
      'description' => 'privacy_acceptance',
    ),
    'newsletter' => 
    array (
      'label' => 'Newsletter Subscription',
      'placeholder' => 'I want to receive periodic communications via email',
      'helper_text' => '',
    ),
    'marketing_communications' => 
    array (
      'label' => 'Marketing Communications Consent',
      'placeholder' => 'I accept to receive personalized commercial offers',
      'helper_text' => '',
    ),
    'created_at' => 
    array (
      'label' => 'System Registration Date',
      'placeholder' => 'Record creation timestamp generated automatically',
      'helper_text' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Last Data Update',
      'placeholder' => 'Last modification timestamp generated automatically',
      'helper_text' => '',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Register New Patient',
      'modal_heading' => 'Patient Registration',
      'modal_description' => 'Complete all required fields to register a new patient',
      'success' => 'Patient successfully registered in the system',
      'error' => 'Error during patient registration',
    ),
    'edit' => 
    array (
      'label' => 'Edit Data',
      'modal_heading' => 'Edit Patient Information',
      'modal_description' => 'Update information for the selected patient',
      'success' => 'Patient data updated successfully',
      'error' => 'Error during data update',
    ),
    'view' => 
    array (
      'label' => 'View Details',
      'modal_heading' => 'Complete Patient Record',
      'modal_description' => 'View all data for the selected patient',
    ),
    'delete' => 
    array (
      'label' => 'Delete Patient',
      'modal_heading' => 'Confirm Deletion',
      'modal_description' => 'Are you sure you want to permanently delete this patient?',
      'success' => 'Patient deleted from system',
      'error' => 'Error during deletion',
      'confirmation' => 'This operation cannot be undone',
    ),
    'approve' => 
    array (
      'label' => 'Approve Registration',
      'modal_heading' => 'Approve Patient',
      'modal_description' => 'Confirm approval of this patient registration',
      'success' => 'Patient registration approved',
      'error' => 'Error during approval',
    ),
    'reject' => 
    array (
      'label' => 'Reject Registration',
      'modal_heading' => 'Reject Patient',
      'modal_description' => 'Indicate reason for rejecting the registration',
      'success' => 'Patient registration rejected',
      'error' => 'Error during rejection',
    ),
  ),
  'messages' => 
  array (
    'welcome' => 'Welcome to patient management',
    'registration_success' => 'Registration completed successfully',
    'validation_errors' => 'Check highlighted fields and try again',
    'document_uploaded' => 'Document uploaded successfully',
    'document_error' => 'Error during document upload',
    'empty_state' => 'No patients registered in the system',
    'search_no_results' => 'No patients found with the specified search criteria',
  ),
);
