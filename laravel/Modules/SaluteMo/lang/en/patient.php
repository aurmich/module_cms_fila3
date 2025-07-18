<?php

return [
    'navigation' => [
        'label' => 'Patients',
        'group' => 'User Management',
        'icon' => 'heroicon-o-users',
        'sort' => '20',
    ],
    'model' => [
        'label' => 'Patient',
        'plural' => 'Patients',
    ],
    'pages' => [
        'index' => [
            'title' => 'Patient List',
            'subtitle' => 'Manage patients registered in the mobile app',
        ],
        'create' => [
            'title' => 'New Patient',
            'subtitle' => 'Register a new patient',
        ],
        'edit' => [
            'title' => 'Edit Patient',
            'subtitle' => 'Edit patient information',
        ],
        'view' => [
            'title' => 'Patient Details',
            'subtitle' => 'View complete patient information',
        ],
    ],
    'fields' => [
        'full_name' => [
            'label' => 'Full Name',
            'placeholder' => 'Enter full name',
            'helper_text' => 'Patient\'s full name',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'email@example.com',
            'helper_text' => 'Email address for communications',
        ],
        'phone' => [
            'label' => 'Phone',
            'placeholder' => '+39 123 456 7890',
            'helper_text' => 'Primary phone number',
        ],
        'fiscal_code' => [
            'label' => 'Fiscal Code',
            'placeholder' => 'RSSMRA80A01H501Z',
            'helper_text' => 'Patient\'s fiscal code (Italian tax ID)',
        ],
        'verified_at' => [
            'label' => 'Verification Date',
            'placeholder' => 'Verification date',
            'help' => 'Date when the account was verified',
        ],
        'birth_date' => [
            'label' => 'Date of Birth',
            'placeholder' => 'Select date',
            'helper_text' => 'Patient\'s date of birth',
        ],
        'blood_type' => [
            'label' => 'Gruppo Sanguigno',
            'placeholder' => 'Seleziona gruppo sanguigno',
            'helper_text' => 'Gruppo sanguigno del paziente',
            'options' => [
                'A_POSITIVE' => 'A+',
                'A_NEGATIVE' => 'A-',
                'B_POSITIVE' => 'B+',
                'B_NEGATIVE' => 'B-',
                'AB_POSITIVE' => 'AB+',
                'AB_NEGATIVE' => 'AB-',
                'O_POSITIVE' => 'O+',
                'O_NEGATIVE' => 'O-',
                'UNKNOWN' => 'Sconosciuto',
            ],
        ],
        'gender' => [
            'label' => 'Gender',
            'placeholder' => 'Select gender',
            'helper_text' => 'Patient\'s gender',
            'options' => [
                'male' => 'Male',
                'female' => 'Female',
                'other' => 'Other',
            ],
        ],
        'address' => [
            'label' => 'Address',
            'placeholder' => 'Via Roma, 123',
            'helper_text' => 'Residential address',
        ],
        'city' => [
            'label' => 'City',
            'placeholder' => 'Milan',
            'helper_text' => 'City of residence',
        ],
        'postal_code' => [
            'label' => 'Postal Code',
            'placeholder' => '20100',
            'helper_text' => 'ZIP/Postal code',
        ],
        'emergency_contact_name' => [
            'label' => 'Emergency Contact - Name',
            'placeholder' => 'Emergency contact name',
            'helper_text' => 'Name of person to contact in case of emergency',
        ],
        'emergency_contact_phone' => [
            'label' => 'Emergency Contact - Phone',
            'placeholder' => '+39 123 456 7890',
            'helper_text' => 'Emergency contact phone number',
        ],
        'allergies' => [
            'label' => 'Allergies',
            'placeholder' => 'List of known allergies',
            'helper_text' => 'Patient\'s known allergies',
        ],
        'medications' => [
            'label' => 'Medications',
            'placeholder' => 'Currently prescribed medications',
            'helper_text' => 'Medications the patient is currently taking',
        ],
        'medical_history' => [
            'label' => 'Medical History',
            'placeholder' => 'Medical history information',
            'helper_text' => 'Patient\'s medical history',
        ],
        'medical_conditions' => [
            'label' => 'Medical Conditions',
            'placeholder' => 'List of medical conditions',
            'helper_text' => 'Patient\'s medical conditions',
        ],
        'is_active' => [
            'label' => 'Active',
            'helper_text' => 'The patient can book appointments',
        ],
        'is_verified' => [
            'label' => 'Verified',
            'help' => 'Indicates if the account is verified',
        ],
        'device_token' => [
            'label' => 'Device Token',
            'helper_text' => 'Token for push notifications',
        ],
        'last_login' => [
            'label' => 'Last Login',
            'helper_text' => 'Date and time of the last app login',
        ],
        'reset_filters' => [
            'label' => 'Reset Filters',
        ],
        'apply_filters' => [
            'label' => 'Apply Filters',
        ],
        'open_filters' => [
            'label' => 'Filters',
        ],
        'toggle_columns' => [
            'label' => 'Show/Hide Columns',
        ],
        'reorder_records' => [
            'label' => 'Reorder Records',
        ],
        'toggleColumns' => [
            'label' => 'Toggle Columns',
        ],
        'reorderRecords' => [
            'label' => 'Reorder Records',
        ],
        'resetFilters' => [
            'label' => 'Reset Filters',
        ],
        'openFilters' => [
            'label' => 'Open Filters',
        ],
        'applyFilters' => [
            'label' => 'Apply Filters',
        ],
    ],
    'actions' => [
        'view_medical_history' => [
            'label' => 'Storia Clinica',
            'icon' => 'heroicon-o-document-text',
            'tooltip' => 'Visualizza la storia clinica del paziente',
        ],
        'view_appointments' => [
            'label' => 'Appuntamenti',
            'icon' => 'heroicon-o-calendar-days',
            'tooltip' => 'Visualizza gli appuntamenti del paziente',
        ],
        'send_notification' => [
            'label' => 'Invia Notifica',
            'icon' => 'heroicon-o-bell',
            'tooltip' => 'Invia una notifica push al paziente',
        ],
        'deactivate' => [
            'label' => 'Disattiva',
            'icon' => 'heroicon-o-x-circle',
            'tooltip' => 'Disattiva temporaneamente il paziente',
        ],
        'add_medical_note' => [
            'label' => 'Aggiungi Nota',
            'icon' => 'heroicon-o-plus-circle',
            'tooltip' => 'Aggiungi una nota medica',
        ],
    ],
    'filters' => [
        'active' => [
            'label' => 'Solo Attivi',
        ],
        'gender' => [
            'label' => 'Per Sesso',
        ],
        'age_range' => [
            'label' => 'Fascia d\'Età',
        ],
        'city' => [
            'label' => 'Per Città',
        ],
    ],
    'bulk_actions' => [
        'send_notification_selected' => [
            'label' => 'Notifica Selezionati',
            'icon' => 'heroicon-o-bell',
        ],
        'export_selected' => [
            'label' => 'Esporta Selezionati',
            'icon' => 'heroicon-o-arrow-down-tray',
        ],
    ],
    'messages' => [
        'deactivated_successfully' => 'Paziente disattivato con successo',
        'notification_sent' => 'Notifica inviata con successo',
        'medical_note_added' => 'Nota medica aggiunta con successo',
        'export_completed' => 'Esportazione completata',
    ],
    'notifications' => [
        'created' => 'Paziente creato con successo',
        'updated' => 'Paziente aggiornato con successo',
        'deleted' => 'Paziente eliminato con successo',
        'error' => 'Si è verificato un errore durante l\'operazione',
    ],
    'validation' => [
        'required' => 'Il campo :attribute è obbligatorio',
        'email' => 'Il campo :attribute deve essere un indirizzo email valido',
        'unique' => 'Il valore del campo :attribute è già stato utilizzato',
        'min' => [
            'string' => 'Il campo :attribute deve contenere almeno :min caratteri',
        ],
        'max' => [
            'string' => 'Il campo :attribute non può superare :max caratteri',
        ],
    ],
    'search_placeholder' => 'Cerca per nome, email, telefono o codice fiscale...',
];
