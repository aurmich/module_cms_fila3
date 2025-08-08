<?php

return [
    'navigation' => [
        'label' => 'Medical Offices',
        'group' => 'Facility Management',
        'icon' => 'heroicon-o-building-office',
        'sort' => '30',
    ],
    'model' => [
        'label' => 'Medical Office',
        'plural' => 'Medical Offices',
        'description' => 'Management of medical offices and related information',
    ],
    'pages' => [
        'index' => [
            'title' => 'Medical Offices List',
            'subtitle' => 'Manage the offices registered in the platform',
            'description' => 'View and manage all medical offices in the system',
        ],
        'create' => [
            'title' => 'New Medical Office',
            'subtitle' => 'Register a new medical office',
            'description' => 'Enter data to register a new medical office in the platform',
        ],
        'edit' => [
            'title' => 'Edit Medical Office',
            'subtitle' => 'Edit office information',
            'description' => 'Update data and information of the medical office',
        ],
        'view' => [
            'title' => 'Medical Office Details',
            'subtitle' => 'View office details',
            'description' => 'Show all information related to the medical office',
        ],
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'placeholder' => '',
            'helper_text' => 'Unique identifier of the medical office',
        ],
        'active' => [
            'label' => 'Active',
            'placeholder' => '',
            'helper_text' => 'Indicates if the medical office is currently operational and visible',
        ],
        'name' => [
            'label' => 'Office Name',
            'placeholder' => 'Dr. Smith Medical Office',
            'helper_text' => 'Complete name and identifier of the medical office',
            'description' => 'name',
        ],
        'address' => [
            'label' => 'Address',
            'placeholder' => '123 Main St - 10001 New York (NY)',
            'helper_text' => 'Complete address of the medical office with ZIP code and state/province',
        ],
        'phone' => [
            'label' => 'Phone',
            'placeholder' => '+1 212 1234567',
            'helper_text' => 'Main contact phone number',
            'description' => 'phone',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'info@drsmithoffice.com',
            'helper_text' => 'Email address for official communications',
            'description' => 'email',
        ],
        'website' => [
            'label' => 'Website',
            'placeholder' => 'https://www.drsmithoffice.com',
            'helper_text' => 'URL of the official medical office website',
            'description' => 'website',
        ],
        'registration_number' => [
            'label' => 'Registration Number',
            'placeholder' => 'NY-123456',
            'helper_text' => "Registration number with the Medical Association",
            'description' => 'registration_number',
        ],
        'vat_number' => [
            'label' => 'VAT Number',
            'placeholder' => 'IT01234567890',
            'helper_text' => 'VAT number of the medical office',
            'description' => 'vat_number',
        ],
        'opening_hours' => [
            'label' => 'Opening Hours',
            'placeholder' => 'Mon-Fri: 9:00-18:00, Sat: 9:00-12:00',
            'helper_text' => 'Public opening hours',
        ],
        'specializations' => [
            'label' => 'Specializations',
            'placeholder' => 'Cardiology, Internal Medicine',
            'helper_text' => 'Medical specializations of the office',
        ],
        'emergency_phone' => [
            'label' => 'Emergency Phone',
            'placeholder' => '+1 212 1234568',
            'helper_text' => 'Number for medical emergencies',
        ],
        'created_at' => [
            'label' => 'Registration Date',
            'placeholder' => '',
            'helper_text' => 'Date when the medical office was registered in the platform',
        ],
        'updated_at' => [
            'label' => 'Last Modified',
            'placeholder' => '',
            'helper_text' => 'Date of the last information update',
        ],
        'open_filters' => [
            'label' => 'Open Filters',
            'placeholder' => '',
            'helper_text' => 'Open the search filters panel',
        ],
        'apply_filters' => [
            'label' => 'Apply Filters',
            'placeholder' => '',
            'helper_text' => 'Apply selected filters to the search',
        ],
        'reset_filters' => [
            'label' => 'Reset Filters',
            'placeholder' => '',
            'helper_text' => 'Clear all applied filters',
        ],
        'reorder_records' => [
            'label' => 'Reorder Records',
            'placeholder' => '',
            'helper_text' => 'Reorder the records in the table',
        ],
        'toggle_columns' => [
            'label' => 'Show/Hide Columns',
            'placeholder' => '',
            'helper_text' => 'Configure the visibility of columns in the table',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
        'description' => [
            'description' => 'description',
            'helper_text' => 'description',
            'placeholder' => 'description',
            'label' => 'description',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'delete' => [
            'label' => 'delete',
        ],
        'edit' => [
            'label' => 'edit',
        ],
        'create' => [
            'label' => 'create',
        ],
        'full_address' => [
            'label' => 'full_address',
        ],
        'schedule' => [
            'label' => 'schedule',
        ],
        'change-schedule' => [
            'label' => 'change-schedule',
        ],
    ],
    'actions' => [
        'view_appointments' => [
            'label' => 'View Appointments',
            'icon' => 'heroicon-o-calendar-days',
            'tooltip' => 'View appointments for this medical office',
        ],
        'manage_doctors' => [
            'label' => 'Manage Doctors',
            'icon' => 'heroicon-o-user-group',
            'tooltip' => 'Manage doctors associated with this medical office',
        ],
        'view_patients' => [
            'label' => 'View Patients',
            'icon' => 'heroicon-o-users',
            'tooltip' => 'View patients registered in this medical office',
        ],
        'manage_schedule' => [
            'label' => 'Gestisci Orari',
            'icon' => 'heroicon-o-clock',
            'tooltip' => 'Gestisci gli orari di apertura dello studio',
        ],
        'view_reports' => [
            'label' => 'Vedi Report',
            'icon' => 'heroicon-o-document-chart-bar',
            'tooltip' => 'Visualizza i report e le statistiche dello studio',
        ],
        'activate' => [
            'label' => 'Attiva',
            'icon' => 'heroicon-o-check-circle',
            'tooltip' => 'Rendi lo studio attivo e visibile',
        ],
        'deactivate' => [
            'label' => 'Disattiva',
            'icon' => 'heroicon-o-x-circle',
            'tooltip' => 'Disattiva temporaneamente lo studio',
        ],
        'export_data' => [
            'label' => 'Esporta Dati',
            'icon' => 'heroicon-o-arrow-down-tray',
            'tooltip' => 'Esporta i dati dello studio',
        ],
    ],
    'filters' => [
        'active' => [
            'label' => 'Solo Attivi',
            'placeholder' => 'Mostra solo studi attivi',
        ],
        'city' => [
            'label' => 'Per Città',
            'placeholder' => 'Filtra per città',
        ],
        'specialization' => [
            'label' => 'Per Specializzazione',
            'placeholder' => 'Filtra per specializzazione medica',
        ],
        'registration_date' => [
            'label' => 'Data Registrazione',
            'placeholder' => 'Filtra per data di registrazione',
        ],
        'has_doctors' => [
            'label' => 'Con Medici',
            'placeholder' => 'Mostra solo studi con medici associati',
        ],
    ],
    'bulk_actions' => [
        'activate_selected' => [
            'label' => 'Attiva Selezionati',
            'icon' => 'heroicon-o-check-circle',
        ],
        'deactivate_selected' => [
            'label' => 'Disattiva Selezionati',
            'icon' => 'heroicon-o-x-circle',
        ],
        'export_selected' => [
            'label' => 'Esporta Selezionati',
            'icon' => 'heroicon-o-arrow-down-tray',
        ],
        'delete_selected' => [
            'label' => 'Elimina Selezionati',
            'icon' => 'heroicon-o-trash',
        ],
    ],
    'messages' => [
        'created' => 'Studio medico creato con successo',
        'updated' => 'Studio medico aggiornato con successo',
        'deleted' => 'Studio medico rimosso con successo',
        'activated_successfully' => 'Studio medico attivato con successo',
        'deactivated_successfully' => 'Studio medico disattivato con successo',
        'doctors_managed' => 'Medici gestiti con successo',
        'schedule_updated' => 'Orari aggiornati con successo',
        'data_exported' => 'Dati esportati con successo',
        'error' => 'Si è verificato un errore durante l\'operazione',
        'validation_error' => 'Errore di validazione dei dati',
        'not_found' => 'Studio medico non trovato',
    ],
    'validation' => [
        'name_required' => 'The practice name is required',
        'name_min' => 'The name must contain at least 3 characters',
        'name_max' => 'The name cannot exceed 255 characters',
        'email_email' => 'Please enter a valid email address',
        'email_unique' => 'This email address is already registered',
        'phone_required' => 'The phone number is required',
        'phone_format' => 'The phone number must be in a valid format',
        'address_required' => 'The address is required',
        'registration_number_unique' => 'Questo numero di registrazione è già in uso',
        'vat_number_format' => 'La partita IVA deve essere in formato valido',
    ],
    'notifications' => [
        'studio_created' => [
            'title' => 'Nuovo Studio Registrato',
            'message' => 'Lo studio :name è stato registrato con successo',
        ],
        'studio_updated' => [
            'title' => 'Studio Aggiornato',
            'message' => 'Le informazioni dello studio :name sono state aggiornate',
        ],
        'studio_activated' => [
            'title' => 'Studio Attivato',
            'message' => 'Lo studio :name è ora attivo e visibile',
        ],
        'studio_deactivated' => [
            'title' => 'Studio Disattivato',
            'message' => 'Lo studio :name è stato disattivato temporaneamente',
        ],
    ],
    'search_placeholder' => 'Cerca per nome, indirizzo, telefono, email o specializzazione...',
];
