<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Edit Patient',
        'icon' => 'heroicon-o-user',
        'tooltip' => 'Edit selected patient information',
        'description' => 'Update patient demographic, health and document data',
    ],
    'actions' => [
        'save' => [
            'label' => 'Save Changes',
            'success' => 'Patient data saved successfully',
            'error' => 'Error saving patient data',
            'confirmation' => 'Do you confirm you want to save the patient data changes?',
        ],
        'cancel' => [
            'label' => 'Cancel',
            'confirmation' => 'Unsaved changes will be lost. Continue?',
        ],
        'delete' => [
            'label' => 'Delete Patient',
            'success' => 'Patient deleted successfully',
            'error' => 'Error deleting patient',
            'confirmation' => 'Are you sure you want to delete this patient? This action is irreversible.',
        ],
        'view' => [
            'label' => 'View Details',
            'tooltip' => 'View all patient details',
        ],
        'edit_attachments' => [
            'label' => 'Edit Documents',
            'tooltip' => 'Manage patient documents',
        ],
        'edit_previsit' => [
            'label' => 'Edit Pre-Visit',
            'tooltip' => 'Update pre-visit information',
        ],
        'edit_privacy' => [
            'label' => 'Edit Privacy',
            'tooltip' => 'Manage privacy settings and consents',
        ],
    ],
    'fields' => [
        'first_name' => [
            'label' => 'First Name',
            'placeholder' => 'Enter patient first name',
            'help' => 'First name must match identity document',
            'validation' => [
                'required' => 'First name is required',
                'min' => 'First name must contain at least 2 characters',
                'max' => 'First name cannot exceed 50 characters',
                'alpha' => 'First name can only contain letters',
            ],
        ],
        'last_name' => [
            'label' => 'Last Name',
            'placeholder' => 'Enter patient last name',
            'help' => 'Last name must match identity document',
            'validation' => [
                'required' => 'Last name is required',
                'min' => 'Last name must contain at least 2 characters',
                'max' => 'Last name cannot exceed 50 characters',
                'alpha' => 'Last name can only contain letters',
            ],
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Enter email address',
            'help' => 'Email will be used for communications and system access',
            'validation' => [
                'required' => 'Email is required',
                'email' => 'Email must be valid',
                'unique' => 'This email is already in use',
            ],
        ],
        'phone' => [
            'label' => 'Phone',
            'placeholder' => 'Enter phone number',
            'help' => 'Phone will be used for urgent communications',
            'validation' => [
                'required' => 'Phone is required',
                'regex' => 'Phone format is not valid',
            ],
        ],
        'fiscal_code' => [
            'label' => 'Fiscal Code',
            'placeholder' => 'Enter fiscal code',
            'help' => 'Fiscal code is required for healthcare services',
            'validation' => [
                'required' => 'Fiscal code is required',
                'regex' => 'Fiscal code format is not valid',
                'unique' => 'This fiscal code is already registered',
            ],
        ],
        'birth_date' => [
            'label' => 'Date of Birth',
            'placeholder' => 'Select date of birth',
            'help' => 'Date of birth is necessary for age calculation',
            'validation' => [
                'required' => 'Date of birth is required',
                'date' => 'Date of birth must be valid',
                'before' => 'Date of birth must be in the past',
            ],
        ],
        'address' => [
            'label' => 'Address',
            'placeholder' => 'Enter residential address',
            'help' => 'Address is necessary for postal communications',
            'validation' => [
                'required' => 'Address is required',
                'max' => 'Address cannot exceed 255 characters',
            ],
        ],
        'city' => [
            'label' => 'City',
            'placeholder' => 'Enter city of residence',
            'help' => 'City is necessary for communications',
            'validation' => [
                'required' => 'City is required',
                'max' => 'City cannot exceed 100 characters',
            ],
        ],
        'postal_code' => [
            'label' => 'Postal Code',
            'placeholder' => 'Enter postal code',
            'help' => 'Postal code is necessary for postal communications',
            'validation' => [
                'required' => 'Postal code is required',
                'regex' => 'Postal code format is not valid',
            ],
        ],
        'province' => [
            'label' => 'Province',
            'placeholder' => 'Select province',
            'help' => 'Province is necessary for communications',
            'validation' => [
                'required' => 'Province is required',
            ],
        ],
        'nationality' => [
            'label' => 'Nationality',
            'placeholder' => 'Select nationality',
            'help' => 'Nationality is necessary for healthcare services',
            'validation' => [
                'required' => 'Nationality is required',
            ],
        ],
        'years_in_italy' => [
            'label' => 'Years in Italy',
            'placeholder' => 'Select years spent in Italy',
            'help' => 'Information necessary for healthcare services',
            'validation' => [
                'required' => 'Years in Italy are required',
            ],
        ],
        'last_dental_visit_period' => [
            'label' => 'Last Dental Visit',
            'placeholder' => 'Select period of last visit',
            'help' => 'Information useful for treatment planning',
            'validation' => [
                'required' => 'Last visit period is required',
            ],
        ],
        'dental_problems' => [
            'label' => 'Dental Problems',
            'placeholder' => 'Describe current dental problems',
            'help' => 'Describe symptoms and problems you are experiencing',
            'validation' => [
                'max' => 'Description cannot exceed 65535 characters',
            ],
        ],
        'medical_conditions' => [
            'label' => 'Medical Conditions',
            'placeholder' => 'Describe any medical conditions',
            'help' => 'Important information for treatment safety',
            'validation' => [
                'max' => 'Description cannot exceed 65535 characters',
            ],
        ],
        'allergies' => [
            'label' => 'Allergies',
            'placeholder' => 'Describe any allergies',
            'help' => 'Crucial information for treatment safety',
            'validation' => [
                'max' => 'Description cannot exceed 65535 characters',
            ],
        ],
        'medications' => [
            'label' => 'Medications Taken',
            'placeholder' => 'List currently taken medications',
            'help' => 'Information necessary to avoid interactions',
            'validation' => [
                'max' => 'Description cannot exceed 65535 characters',
            ],
        ],
    ],
    'messages' => [
        'patient_updated' => 'Patient data has been updated successfully',
        'patient_created' => 'Patient has been registered successfully',
        'patient_deleted' => 'Patient has been deleted successfully',
        'data_required' => 'All required fields must be filled',
        'fiscal_code_exists' => 'A patient with this fiscal code is already registered',
        'email_exists' => 'A patient with this email is already registered',
        'invalid_birth_date' => 'Date of birth cannot be in the future',
        'invalid_fiscal_code' => 'Fiscal code format is not valid',
    ],
    'sections' => [
        'personal_data' => [
            'label' => 'Personal Data',
            'description' => 'Patient demographic information',
            'icon' => 'heroicon-o-identification',
        ],
        'contact_info' => [
            'label' => 'Contact Information',
            'description' => 'Data for patient communications',
            'icon' => 'heroicon-o-phone',
        ],
        'medical_info' => [
            'label' => 'Medical Information',
            'description' => 'Health data and clinical history',
            'icon' => 'heroicon-o-heart',
        ],
        'documents' => [
            'label' => 'Documents',
            'description' => 'Patient official documents',
            'icon' => 'heroicon-o-document-text',
        ],
    ],
    'validation' => [
        'fiscal_code_required' => 'Fiscal code is required',
        'fiscal_code_format' => 'Fiscal code format is not valid',
        'fiscal_code_unique' => 'A patient with this fiscal code is already registered',
        'email_required' => 'Email is required',
        'email_format' => 'Email format is not valid',
        'email_unique' => 'A patient with this email is already registered',
        'birth_date_required' => 'Date of birth is required',
        'birth_date_past' => 'Date of birth must be in the past',
        'phone_required' => 'Phone is required',
        'phone_format' => 'Phone format is not valid',
        'address_required' => 'Address is required',
        'city_required' => 'City is required',
        'postal_code_required' => 'Postal code is required',
        'postal_code_format' => 'Postal code format is not valid',
        'province_required' => 'Province is required',
        'nationality_required' => 'Nationality is required',
        'years_in_italy_required' => 'Years in Italy are required',
        'last_dental_visit_required' => 'Last visit period is required',
    ],
];
