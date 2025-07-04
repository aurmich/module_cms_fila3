<?php

return array (
  'navigation' => 
  array (
    'label' => 'Medical Studios',
    'group' => 'Health Management',
    'icon' => 'heroicon-o-building-office',
    'sort' => 20,
  ),
  'model' => 
  array (
    'label' => 'Medical Studio',
    'plural_label' => 'Medical Studios',
    'description' => 'Complete management of medical studios and healthcare facilities',
  ),
  'pages' => 
  array (
    'index' => 
    array (
      'title' => 'Dental Studios List',
      'subtitle' => 'Registered studios management',
      'description' => 'View, edit and manage all registered dental studios in the system',
    ),
    'create' => 
    array (
      'title' => 'Register New Studio',
      'subtitle' => 'Studio data entry',
      'description' => 'Fill the form to register a new dental studio',
    ),
    'edit' => 
    array (
      'title' => 'Edit Dental Studio',
      'subtitle' => 'Update information',
      'description' => 'Edit the selected studio information',
    ),
    'view' => 
    array (
      'title' => 'Dental Studio Details',
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
    ),
    'name' => 
    array (
      'label' => 'Studio Name',
      'placeholder' => 'Enter medical studio name',
      'help' => 'Official name of the medical studio or clinic',
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
    ),
    'email' => 
    array (
      'label' => 'Email Address',
      'placeholder' => 'studio@example.com',
      'help' => 'Primary email contact for the medical studio',
    ),
    'phone' => 
    array (
      'label' => 'Phone Number',
      'placeholder' => '+39 02 1234567',
      'help' => 'Main phone number for appointments and inquiries',
    ),
    'website' => 
    array (
      'label' => 'Website',
      'placeholder' => 'https://www.studio.com',
      'help' => 'Official website URL (optional)',
    ),
    'address' => 
    array (
      'label' => 'Street Address',
      'placeholder' => 'Via Roma 123',
      'help' => 'Complete street address with building number',
    ),
    'city' => 
    array (
      'label' => 'City',
      'placeholder' => 'Milan',
      'help' => 'City where the studio is located',
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
      'label' => 'Studio Active',
      'placeholder' => 'Studio operational status',
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
      'label' => 'Certifications',
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
      'placeholder' => 'Studio registration timestamp',
      'help' => 'Date when the studio was added to the system',
    ),
    'updated_at' => 
    array (
      'label' => 'Last Update',
      'placeholder' => 'Last modification timestamp',
      'help' => 'Date of last modification to studio information',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Add New Studio',
      'success' => 'Medical studio created successfully',
      'error' => 'Error creating studio: :error',
      'confirmation' => 'Create new medical studio with the provided information?',
    ),
    'edit' => 
    array (
      'label' => 'Edit Studio',
      'success' => 'Studio information updated successfully',
      'error' => 'Error updating studio: :error',
    ),
    'delete' => 
    array (
      'label' => 'Delete Studio',
      'success' => 'Studio deleted successfully',
      'error' => 'Error deleting studio: :error',
      'confirmation' => 'Are you sure you want to permanently delete this studio? All associated data will be lost.',
    ),
    'view' => 
    array (
      'label' => 'View Studio Details',
    ),
    'duplicate' => 
    array (
      'label' => 'Duplicate Studio',
      'success' => 'Studio duplicated successfully',
      'error' => 'Error duplicating studio: :error',
    ),
    'activate' => 
    array (
      'label' => 'Activate Studio',
      'success' => 'Studio activated successfully',
      'error' => 'Error activating studio: :error',
    ),
    'deactivate' => 
    array (
      'label' => 'Deactivate Studio',
      'success' => 'Studio deactivated successfully',
      'error' => 'Error deactivating studio: :error',
      'confirmation' => 'Deactivate this studio? It will no longer accept new appointments.',
    ),
    'export' => 
    array (
      'label' => 'Export Studio Data',
      'success' => 'Studio data exported successfully',
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
  ),
  'filters' => 
  array (
    'is_active' => 
    array (
      'label' => 'Filter by Status',
      'options' => 
      array (
        1 => 'Active Studios',
        0 => 'Inactive Studios',
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
  ),
  'messages' => 
  array (
    'welcome' => 'Welcome to studio management',
    'studio_created' => 'Medical studio successfully registered',
    'studio_updated' => 'Studio information updated',
    'studio_activated' => 'Studio is now active and accepting patients',
    'studio_deactivated' => 'Studio has been deactivated',
    'no_doctors_assigned' => 'No doctors currently assigned to this studio',
    'schedule_configured' => 'Operating schedule has been configured',
    'schedule_missing' => 'Please configure the studio operating hours',
    'capacity_reached' => 'Studio has reached maximum daily capacity',
    'booking_closed' => 'Booking is currently closed for this studio',
    'emergency_contact' => 'For emergencies, please contact our emergency line',
    'insurance_verified' => 'Insurance coverage verified',
    'payment_processed' => 'Payment has been processed successfully',
  ),
  'validation' => 
  array (
    'name_required' => 'Studio name is required',
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
    'schedule_updated' => 'Studio schedule has been updated',
    'capacity_warning' => 'Studio is approaching daily capacity limit',
    'equipment_maintenance' => 'Equipment maintenance reminder',
    'license_expiring' => 'Medical license expiring soon',
    'insurance_update' => 'Insurance policy requires update',
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
  ),
);
