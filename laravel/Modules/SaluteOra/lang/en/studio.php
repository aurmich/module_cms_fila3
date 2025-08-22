<?php

return array (
  'navigation' => 
  array (
    'label' => 'Medical Practices',
    'group' => 'Health Management',
    'icon' => 'heroicon-o-building-office',
    'sort' => '20',
    'color' => 'primary',
    'tooltip' => 'Gestisci gli studi odontoiatrici registrati nel sistema',
  ),
  'model' => 
  array (
    'label' => 'Medical Practice',
    'plural_label' => 'Medical Practices',
    'description' => 'Complete management of medical studios and healthcare facilities',
    'plural' => 'Studi',
  ),
  'pages' => 
  array (
    'index' => 
    array (
      'title' => 'Dental Practices List',
      'subtitle' => 'Registered studios management',
      'description' => 'View, edit and manage all registered dental studios in the system',
    ),
    'create' => 
    array (
      'title' => 'Register New Practice',
      'subtitle' => 'Practice data entry',
      'description' => 'Fill the form to register a new dental studio',
    ),
    'edit' => 
    array (
      'title' => 'Edit Dental Practice',
      'subtitle' => 'Update information',
      'description' => 'Edit the selected studio information',
    ),
    'view' => 
    array (
      'title' => 'Dental Practice Details',
      'subtitle' => 'Complete view',
      'description' => 'View all dental studio information',
    ),
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'placeholder' => 'Automatic identifier',
      'help' => 'Unique system identifier for the studio',
      'helper_text' => '',
      'description' => '',
    ),
    'name' => 
    array (
      'label' => 'Practice Name',
      'placeholder' => 'Enter medical studio name',
      'help' => 'Official name of the medical studio or clinic',
      'helper_text' => '',
      'description' => '',
    ),
    'slug' => 
    array (
      'label' => 'URL Slug',
      'placeholder' => 'studio-name-location',
      'help' => 'URL-friendly identifier for the studio',
    ),
    'description' => 
    array (
      'label' => 'Description',
      'placeholder' => 'Enter studio description...',
      'help' => 'Brief description of services and specializations offered',
      'description' => 'description',
      'helper_text' => '',
    ),
    'email' => 
    array (
      'label' => 'Email Address',
      'placeholder' => 'studio@example.com',
      'help' => 'Primary email contact for the medical studio',
      'helper_text' => '',
      'description' => '',
    ),
    'phone' => 
    array (
      'label' => 'Phone Number',
      'placeholder' => '+39 02 1234567',
      'help' => 'Main phone number for appointments and inquiries',
      'helper_text' => '',
      'description' => '',
    ),
    'website' => 
    array (
      'label' => 'Website',
      'placeholder' => 'https://www.studio.com',
      'help' => 'Official website URL (optional)',
      'helper_text' => '',
      'description' => '',
    ),
    'address' => 
    array (
      'label' => 'Street Address',
      'placeholder' => 'Street Address 123',
      'help' => 'Complete street address with building number',
      'helper_text' => '',
      'description' => '',
      'full_address' => 
      array (
        'label' => 'Address Completo',
        'placeholder' => 'Address formattato completo',
        'help' => 'Address completo formattato per visualizzazione e mappe',
        'helper_text' => '',
        'description' => '',
      ),
    ),
    'city' => 
    array (
      'label' => 'City',
      'placeholder' => 'Milan',
      'help' => 'City where the studio is located',
      'helper_text' => '',
    ),
    'state' => 
    array (
      'label' => 'State/Region',
      'placeholder' => 'Lombardy',
      'help' => 'Italian region or state',
    ),
    'postal_code' => 
    array (
      'label' => 'Postal Code',
      'placeholder' => '20100',
      'help' => 'Five-digit Italian postal code',
      'helper_text' => '',
    ),
    'country' => 
    array (
      'label' => 'Country',
      'placeholder' => 'Italy',
      'help' => 'Country where the studio operates',
    ),
    'tax_code' => 
    array (
      'label' => 'Tax Code',
      'placeholder' => 'Enter tax identification number',
      'help' => 'Official tax identification code',
    ),
    'vat_number' => 
    array (
      'label' => 'VAT Number',
      'placeholder' => 'IT12345678901',
      'help' => 'Value Added Tax identification number',
      'description' => '',
      'helper_text' => '',
    ),
    'license_number' => 
    array (
      'label' => 'Medical License',
      'placeholder' => 'Enter license number',
      'help' => 'Official medical practice license number',
    ),
    'specializations' => 
    array (
      'label' => 'Medical Specializations',
      'placeholder' => 'Select specializations...',
      'help' => 'Medical specialties and services provided',
    ),
    'opening_hours' => 
    array (
      'label' => 'Opening Hours',
      'placeholder' => 'Configure weekly schedule',
      'help' => 'Standard operating hours for each day of the week',
      'helper_text' => '',
      'description' => '',
    ),
    'emergency_hours' => 
    array (
      'label' => 'Emergency Hours',
      'placeholder' => 'Configure emergency availability',
      'help' => 'After-hours emergency contact information',
    ),
    'max_patients_per_day' => 
    array (
      'label' => 'Daily Patient Capacity',
      'placeholder' => '50',
      'help' => 'Maximum number of patients that can be seen per day',
    ),
    'appointment_duration' => 
    array (
      'label' => 'Default Appointment Duration',
      'placeholder' => '30 minutes',
      'help' => 'Standard duration for regular appointments',
    ),
    'booking_advance_days' => 
    array (
      'label' => 'Booking Advance Period',
      'placeholder' => '30 days',
      'help' => 'How far in advance patients can book appointments',
    ),
    'is_active' => 
    array (
      'label' => 'Practice Active',
      'placeholder' => 'Practice operational status',
      'help' => 'Whether the studio is currently accepting patients',
    ),
    'accepts_new_patients' => 
    array (
      'label' => 'Accepting New Patients',
      'placeholder' => 'New patient registration status',
      'help' => 'Whether the studio is currently accepting new patient registrations',
    ),
    'wheelchair_accessible' => 
    array (
      'label' => 'Wheelchair Accessible',
      'placeholder' => 'Accessibility features',
      'help' => 'Whether the facility is accessible to wheelchair users',
    ),
    'parking_available' => 
    array (
      'label' => 'Parking Available',
      'placeholder' => 'Parking facility status',
      'help' => 'Whether parking is available for patients',
    ),
    'public_transport' => 
    array (
      'label' => 'Public Transport Access',
      'placeholder' => 'Transportation information',
      'help' => 'Information about nearby public transportation',
    ),
    'languages_spoken' => 
    array (
      'label' => 'Languages Spoken',
      'placeholder' => 'Select languages...',
      'help' => 'Languages spoken by staff at this location',
    ),
    'insurance_accepted' => 
    array (
      'label' => 'Insurance Plans Accepted',
      'placeholder' => 'Select accepted insurance...',
      'help' => 'Health insurance plans accepted at this studio',
    ),
    'payment_methods' => 
    array (
      'label' => 'Payment Methods',
      'placeholder' => 'Select payment options...',
      'help' => 'Available payment methods for services',
    ),
    'equipment' => 
    array (
      'label' => 'Medical Equipment',
      'placeholder' => 'List available equipment...',
      'help' => 'Specialized medical equipment available',
    ),
    'certifications' => 
    array (
      'label' => 'Certificatesons',
      'placeholder' => 'Enter certification details...',
      'help' => 'Quality certifications and accreditations',
    ),
    'notes' => 
    array (
      'label' => 'Additional Notes',
      'placeholder' => 'Enter any additional information...',
      'help' => 'Any other relevant information about the studio',
    ),
    'created_at' => 
    array (
      'label' => 'Registration Date',
      'placeholder' => 'Practice registration timestamp',
      'help' => 'Date when the studio was added to the system',
      'helper_text' => '',
      'description' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Last Update',
      'placeholder' => 'Last modification timestamp',
      'help' => 'Date of last modification to studio information',
      'helper_text' => '',
      'description' => '',
    ),
    'registration_number' => 
    array (
      'label' => 'Numero di Registrazione',
      'placeholder' => 'Enter il numero di registrazione ufficiale',
      'help' => 'Numero di registrazione presso l\'ordine dei medici o enti competenti',
      'helper_text' => '',
      'description' => '',
    ),
    'services' => 
    array (
      'label' => 'Servizi Offerti',
      'placeholder' => 'Elenca i servizi e trattamenti disponibili',
      'help' => 'Elenco completo dei servizi odontoiatrici e trattamenti offerti',
      'helper_text' => '',
      'description' => '',
    ),
    'active' => 
    array (
      'label' => 'Practice Active',
      'placeholder' => 'Indica se lo studio è attualmente operativo',
      'help' => 'Status di attivazione dello studio nel sistema',
      'helper_text' => '',
      'description' => '',
    ),
    'addresses' => 
    array (
      'label' => 'Indirizzi Aggiuntivi',
      'placeholder' => 'Gestisci indirizzi secondari o sedi distaccate',
      'help' => 'Gestione di indirizzi aggiuntivi o sedi secondarie dello studio',
      'helper_text' => '',
      'description' => '',
    ),
    'is_primary' => 
    array (
      'label' => 'Practice Principale',
      'placeholder' => 'Indica se questo è lo studio principale',
      'help' => 'Select se questo è lo studio principale tra quelli gestiti',
      'helper_text' => '',
      'description' => '',
    ),
    'administrative_area_level_1' => 
    array (
      'label' => 'Region',
      'placeholder' => 'Region of belonging of the practice',
      'help' => 'Administrative region where the practice is located',
      'helper_text' => '',
      'description' => '',
    ),
    'deleted_at' => 
    array (
      'label' => 'Deleteto il',
      'placeholder' => 'Data di eliminazione logica dello studio',
      'help' => 'Data di eliminazione logica dello studio dal sistema',
      'helper_text' => '',
      'description' => '',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Add New Practice',
      'success' => 'Medical studio created successfully',
      'error' => 'Error creating studio: :error',
      'confirmation' => 'Create new medical studio with the provided information?',
      'modal_heading' => 'Registra nuovo studio',
      'modal_description' => 'Enter i dati per registrare un nuovo studio odontoiatrico',
    ),
    'edit' => 
    array (
      'label' => 'Edit Practice',
      'success' => 'Practice information updated successfully',
      'error' => 'Error updating studio: :error',
      'modal_heading' => 'Edit dati studio',
      'modal_description' => 'Aggiorna le informazioni dello studio selezionato',
    ),
    'delete' => 
    array (
      'label' => 'Delete Practice',
      'success' => 'Practice deleted successfully',
      'error' => 'Error deleting studio: :error',
      'confirmation' => 'Are you sure you want to permanently delete this studio? All associated data will be lost.',
      'modal_heading' => 'Delete studio',
      'modal_description' => 'Are you sure di voler eliminare questo studio?',
    ),
    'view' => 
    array (
      'label' => 'View Practice Details',
      'modal_heading' => 'Dettagli studio',
      'modal_description' => 'Consulta tutte le informazioni dello studio',
    ),
    'duplicate' => 
    array (
      'label' => 'Duplicate Practice',
      'success' => 'Practice duplicated successfully',
      'error' => 'Error duplicating studio: :error',
    ),
    'activate' => 
    array (
      'label' => 'Activate Practice',
      'success' => 'Practice activated successfully',
      'error' => 'Error activating studio: :error',
      'modal_heading' => 'Activate studio',
      'modal_description' => 'Activate lo studio per renderlo operativo',
    ),
    'deactivate' => 
    array (
      'label' => 'Deactivate Practice',
      'success' => 'Practice deactivated successfully',
      'error' => 'Error deactivating studio: :error',
      'confirmation' => 'Deactivate this studio? It will no longer accept new appointments.',
      'modal_heading' => 'Disattiva studio',
      'modal_description' => 'Disattiva temporaneamente lo studio',
    ),
    'export' => 
    array (
      'label' => 'Export Practice Data',
      'success' => 'Practice data exported successfully',
      'error' => 'Error exporting data: :error',
    ),
    'assign_doctors' => 
    array (
      'label' => 'Assign Doctors',
      'success' => 'Doctors assigned successfully',
      'error' => 'Error assigning doctors: :error',
    ),
    'manage_schedule' => 
    array (
      'label' => 'Manage Schedule',
      'success' => 'Schedule updated successfully',
      'error' => 'Error updating schedule: :error',
    ),
    'register_tenant' => 
    array (
      'label' => 'Aggiungi Practice',
      'modal_heading' => 'Registra studio come tenant',
      'modal_description' => 'Registra questo studio come nuovo tenant nel sistema',
      'success' => 'Practice registrato come tenant',
      'error' => 'Error durante la registrazione tenant',
    ),
    'attach' => 
    array (
      'label' => 'Collega',
      'modal_heading' => 'Collega elemento',
      'modal_description' => 'Collega questo elemento allo studio',
      'success' => 'Elemento collegato successfully',
      'error' => 'Error durante il collegamento',
    ),
    'reset_filters' => 
    array (
      'label' => 'Azzera Filtri',
      'tooltip' => 'Rimuovi tutti i filtri di ricerca applicati',
    ),
    'apply_filters' => 
    array (
      'label' => 'Applica Filtri',
      'tooltip' => 'Applica i filtri di ricerca selezionati',
    ),
    'toggle_columns' => 
    array (
      'label' => 'Mostra/Nascondi Colonne',
      'tooltip' => 'Personalizza le colonne visibili nella tabella',
    ),
    'reorder_records' => 
    array (
      'label' => 'Riordina Record',
      'tooltip' => 'Riordina i record trascinandoli',
    ),
    'open_filters' => 
    array (
      'label' => 'Apri Filtri',
      'tooltip' => 'Apri il pannello dei filtri di ricerca',
    ),
  ),
  'sections' => 
  array (
    'basic_info' => 
    array (
      'label' => 'Basic Information',
      'description' => 'Essential studio details and contact information',
    ),
    'location' => 
    array (
      'label' => 'Location Details',
      'description' => 'Physical address and accessibility information',
    ),
    'contact_info' => 
    array (
      'label' => 'Contact Information',
      'description' => 'Phone, email, and website details',
    ),
    'business_info' => 
    array (
      'label' => 'Business Information',
      'description' => 'Tax codes, licenses, and legal information',
    ),
    'operational_settings' => 
    array (
      'label' => 'Operational Settings',
      'description' => 'Hours, capacity, and booking preferences',
    ),
    'services' => 
    array (
      'label' => 'Services & Specializations',
      'description' => 'Medical services and areas of expertise',
    ),
    'facilities' => 
    array (
      'label' => 'Facilities & Equipment',
      'description' => 'Available facilities and medical equipment',
    ),
    'policies' => 
    array (
      'label' => 'Policies & Procedures',
      'description' => 'Payment methods, insurance, and operational policies',
    ),
    'system_info' => 
    array (
      'label' => 'System Information',
      'description' => 'Registration date and system status',
    ),
    'general_info' => 
    array (
      'label' => 'Informazioni Generali',
      'description' => 'Dati principali dello studio odontoiatrico',
    ),
    'location_info' => 
    array (
      'label' => 'Informazioni Ubicazione',
      'description' => 'Dati relativi alla posizione geografica',
    ),
    'address' => 
    array (
      'label' => 'address',
      'heading' => 'address',
    ),
  ),
  'filters' => 
  array (
    'is_active' => 
    array (
      'label' => 'Filter by Status',
      'options' => 
      array (
        1 => 'Active Practices',
        0 => 'Inactive Practices',
      ),
    ),
    'accepts_new_patients' => 
    array (
      'label' => 'New Patient Acceptance',
      'options' => 
      array (
        1 => 'Accepting New Patients',
        0 => 'Not Accepting New Patients',
      ),
    ),
    'city' => 
    array (
      'label' => 'Filter by City',
      'placeholder' => 'Select a city',
    ),
    'specializations' => 
    array (
      'label' => 'Filter by Specialization',
    ),
    'wheelchair_accessible' => 
    array (
      'label' => 'Accessibility',
      'options' => 
      array (
        1 => 'Wheelchair Accessible',
        0 => 'Not Wheelchair Accessible',
      ),
    ),
    'active' => 
    array (
      'label' => 'Activation Status',
      'options' => 
      array (
        'all' => 'All studios',
        'active' => 'Active studios only',
        'inactive' => 'Inactive studios only',
      ),
    ),
    'region' => 
    array (
      'label' => 'Filter by Region',
      'placeholder' => 'Select a region',
    ),
  ),
  'messages' => 
  array (
    'welcome' => 'Welcome to studio management',
    'studio_created' => 'Medical studio successfully registered',
    'studio_updated' => 'Practice information updated',
    'studio_activated' => 'Practice is now active and accepting patients',
    'studio_deactivated' => 'Practice has been deactivated',
    'no_doctors_assigned' => 'No doctors currently assigned to this studio',
    'schedule_configured' => 'Operating schedule has been configured',
    'schedule_missing' => 'Please configure the studio operating hours',
    'capacity_reached' => 'Practice has reached maximum daily capacity',
    'booking_closed' => 'Booking is currently closed for this studio',
    'emergency_contact' => 'For emergencies, please contact our emergency line',
    'insurance_verified' => 'Insurance coverage verified',
    'payment_processed' => 'Payment has been processed successfully',
    'empty_state' => 'No studios registered',
    'loading' => 'Loading studio data...',
    'saved' => 'Changes saved successfully',
    'activated' => 'Practice activated successfully.',
    'deactivated' => 'Practice deactivated successfully.',
    'tenant_created' => 'Practice registered as tenant',
    'search_no_results' => 'No studios found with the specified criteria',
  ),
  'validation' => 
  array (
    'name_required' => 'Practice name is required',
    'email_invalid' => 'Please enter a valid email address',
    'phone_invalid' => 'Please enter a valid phone number',
    'website_invalid' => 'Please enter a valid website URL',
    'postal_code_invalid' => 'Please enter a valid postal code',
    'tax_code_invalid' => 'Tax code format is invalid',
    'vat_number_invalid' => 'VAT number format is invalid',
    'license_required' => 'Medical license number is required',
    'capacity_minimum' => 'Daily capacity must be at least 1 patient',
    'duration_invalid' => 'Appointment duration must be between 15 and 180 minutes',
    'advance_days_invalid' => 'Booking advance period must be between 1 and 365 days',
  ),
  'notifications' => 
  array (
    'new_appointment' => 'New appointment scheduled at your studio',
    'appointment_cancelled' => 'An appointment has been cancelled',
    'schedule_updated' => 'Practice schedule has been updated',
    'capacity_warning' => 'Practice is approaching daily capacity limit',
    'equipment_maintenance' => 'Equipment maintenance reminder',
    'license_expiring' => 'Medical license expiring soon',
    'insurance_update' => 'Insurance policy requires update',
    'studio_activated' => 'Your studio has been activated and you can start operating',
    'studio_deactivated' => 'Your studio has been temporarily deactivated',
    'registration_completed' => 'Studio registration completed successfully',
    'data_updated' => 'Studio data has been updated',
    'error_occurred' => 'An error occurred during the operation',
  ),
  'empty_states' => 
  array (
    'no_studios' => 'No medical studios found',
    'no_doctors' => 'No doctors assigned to this studio',
    'no_appointments' => 'No appointments scheduled',
    'no_equipment' => 'No equipment registered',
    'no_specializations' => 'No specializations defined',
  ),
  'tabs' => 
  array (
    'overview' => 
    array (
      'label' => 'Overview',
      'description' => 'General studio information and status',
    ),
    'doctors' => 
    array (
      'label' => 'Medical Staff',
      'description' => 'Doctors and healthcare professionals',
    ),
    'schedule' => 
    array (
      'label' => 'Schedule',
      'description' => 'Operating hours and availability',
    ),
    'appointments' => 
    array (
      'label' => 'Appointments',
      'description' => 'Scheduled patient appointments',
    ),
    'equipment' => 
    array (
      'label' => 'Equipment',
      'description' => 'Medical equipment and facilities',
    ),
    'reports' => 
    array (
      'label' => 'Reports',
      'description' => 'Performance and activity reports',
    ),
    'general' => 'Informazioni Generali',
    'contact' => 'Contacts e Ubicazione',
    'services' => 'Servizi e Specializzazioni',
    'staff' => 'Staff e Operatori',
    'documents' => 'Documenti e Certifications',
  ),
);
