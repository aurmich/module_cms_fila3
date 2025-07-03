<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Medical Studios',
        'group' => 'Health Management',
        'icon' => 'heroicon-o-building-office',
        'sort' => 20,
    ],

    'model' => [
        'label' => 'Medical Studio',
        'plural_label' => 'Medical Studios',
        'description' => 'Complete management of medical studios and healthcare facilities',
    ],

    'pages' => [
        'index' => [
            'title' => 'Dental Studios List',
            'subtitle' => 'Registered studios management',
            'description' => 'View, edit and manage all registered dental studios in the system',
        ],
        'create' => [
            'title' => 'Register New Studio',
            'subtitle' => 'Studio data entry',
            'description' => 'Fill the form to register a new dental studio',
        ],
        'edit' => [
            'title' => 'Edit Dental Studio',
            'subtitle' => 'Update information',
            'description' => 'Edit the selected studio information',
        ],
        'view' => [
            'title' => 'Dental Studio Details',
            'subtitle' => 'Complete view',
            'description' => 'View all dental studio information',
        ],
    ],

    'fields' => [
        'id' => [
            'label' => 'ID',
            'placeholder' => 'Automatic identifier',
            'help' => 'Unique system identifier for the studio',
        ],
        'name' => [
            'label' => 'Studio Name',
            'placeholder' => 'Enter medical studio name',
            'help' => 'Official name of the medical studio or clinic',
        ],
        'slug' => [
            'label' => 'URL Slug',
            'placeholder' => 'studio-name-location',
            'help' => 'URL-friendly identifier for the studio',
        ],
        'description' => [
            'label' => 'Description',
            'placeholder' => 'Enter studio description...',
            'help' => 'Brief description of services and specializations offered',
        ],
        'email' => [
            'label' => 'Email Address',
            'placeholder' => 'studio@example.com',
            'help' => 'Primary email contact for the medical studio',
        ],
        'phone' => [
            'label' => 'Phone Number',
            'placeholder' => '+39 02 1234567',
            'help' => 'Main phone number for appointments and inquiries',
        ],
        'website' => [
            'label' => 'Website',
            'placeholder' => 'https://www.studio.com',
            'help' => 'Official website URL (optional)',
        ],
        'address' => [
            'label' => 'Street Address',
            'placeholder' => 'Via Roma 123',
            'help' => 'Complete street address with building number',
        ],
        'city' => [
            'label' => 'City',
            'placeholder' => 'Milan',
            'help' => 'City where the studio is located',
        ],
        'state' => [
            'label' => 'State/Region',
            'placeholder' => 'Lombardy',
            'help' => 'Italian region or state',
        ],
        'postal_code' => [
            'label' => 'Postal Code',
            'placeholder' => '20100',
            'help' => 'Five-digit Italian postal code',
        ],
        'country' => [
            'label' => 'Country',
            'placeholder' => 'Italy',
            'help' => 'Country where the studio operates',
        ],
        'tax_code' => [
            'label' => 'Tax Code',
            'placeholder' => 'Enter tax identification number',
            'help' => 'Official tax identification code',
        ],
        'vat_number' => [
            'label' => 'VAT Number',
            'placeholder' => 'IT12345678901',
            'help' => 'Value Added Tax identification number',
        ],
        'license_number' => [
            'label' => 'Medical License',
            'placeholder' => 'Enter license number',
            'help' => 'Official medical practice license number',
        ],
        'specializations' => [
            'label' => 'Medical Specializations',
            'placeholder' => 'Select specializations...',
            'help' => 'Medical specialties and services provided',
        ],
        'opening_hours' => [
            'label' => 'Opening Hours',
            'placeholder' => 'Configure weekly schedule',
            'help' => 'Standard operating hours for each day of the week',
        ],
        'emergency_hours' => [
            'label' => 'Emergency Hours',
            'placeholder' => 'Configure emergency availability',
            'help' => 'After-hours emergency contact information',
        ],
        'max_patients_per_day' => [
            'label' => 'Daily Patient Capacity',
            'placeholder' => '50',
            'help' => 'Maximum number of patients that can be seen per day',
        ],
        'appointment_duration' => [
            'label' => 'Default Appointment Duration',
            'placeholder' => '30 minutes',
            'help' => 'Standard duration for regular appointments',
        ],
        'booking_advance_days' => [
            'label' => 'Booking Advance Period',
            'placeholder' => '30 days',
            'help' => 'How far in advance patients can book appointments',
        ],
        'is_active' => [
            'label' => 'Studio Active',
            'placeholder' => 'Studio operational status',
            'help' => 'Whether the studio is currently accepting patients',
        ],
        'accepts_new_patients' => [
            'label' => 'Accepting New Patients',
            'placeholder' => 'New patient registration status',
            'help' => 'Whether the studio is currently accepting new patient registrations',
        ],
        'wheelchair_accessible' => [
            'label' => 'Wheelchair Accessible',
            'placeholder' => 'Accessibility features',
            'help' => 'Whether the facility is accessible to wheelchair users',
        ],
        'parking_available' => [
            'label' => 'Parking Available',
            'placeholder' => 'Parking facility status',
            'help' => 'Whether parking is available for patients',
        ],
        'public_transport' => [
            'label' => 'Public Transport Access',
            'placeholder' => 'Transportation information',
            'help' => 'Information about nearby public transportation',
        ],
        'languages_spoken' => [
            'label' => 'Languages Spoken',
            'placeholder' => 'Select languages...',
            'help' => 'Languages spoken by staff at this location',
        ],
        'insurance_accepted' => [
            'label' => 'Insurance Plans Accepted',
            'placeholder' => 'Select accepted insurance...',
            'help' => 'Health insurance plans accepted at this studio',
        ],
        'payment_methods' => [
            'label' => 'Payment Methods',
            'placeholder' => 'Select payment options...',
            'help' => 'Available payment methods for services',
        ],
        'equipment' => [
            'label' => 'Medical Equipment',
            'placeholder' => 'List available equipment...',
            'help' => 'Specialized medical equipment available',
        ],
        'certifications' => [
            'label' => 'Certifications',
            'placeholder' => 'Enter certification details...',
            'help' => 'Quality certifications and accreditations',
        ],
        'notes' => [
            'label' => 'Additional Notes',
            'placeholder' => 'Enter any additional information...',
            'help' => 'Any other relevant information about the studio',
        ],
        'created_at' => [
            'label' => 'Registration Date',
            'placeholder' => 'Studio registration timestamp',
            'help' => 'Date when the studio was added to the system',
        ],
        'updated_at' => [
            'label' => 'Last Update',
            'placeholder' => 'Last modification timestamp',
            'help' => 'Date of last modification to studio information',
        ],
    ],

    'actions' => [
        'create' => [
            'label' => 'Add New Studio',
            'success' => 'Medical studio created successfully',
            'error' => 'Error creating studio: :error',
            'confirmation' => 'Create new medical studio with the provided information?',
        ],
        'edit' => [
            'label' => 'Edit Studio',
            'success' => 'Studio information updated successfully',
            'error' => 'Error updating studio: :error',
        ],
        'delete' => [
            'label' => 'Delete Studio',
            'success' => 'Studio deleted successfully',
            'error' => 'Error deleting studio: :error',
            'confirmation' => 'Are you sure you want to permanently delete this studio? All associated data will be lost.',
        ],
        'view' => [
            'label' => 'View Studio Details',
        ],
        'duplicate' => [
            'label' => 'Duplicate Studio',
            'success' => 'Studio duplicated successfully',
            'error' => 'Error duplicating studio: :error',
        ],
        'activate' => [
            'label' => 'Activate Studio',
            'success' => 'Studio activated successfully',
            'error' => 'Error activating studio: :error',
        ],
        'deactivate' => [
            'label' => 'Deactivate Studio',
            'success' => 'Studio deactivated successfully',
            'error' => 'Error deactivating studio: :error',
            'confirmation' => 'Deactivate this studio? It will no longer accept new appointments.',
        ],
        'export' => [
            'label' => 'Export Studio Data',
            'success' => 'Studio data exported successfully',
            'error' => 'Error exporting data: :error',
        ],
        'assign_doctors' => [
            'label' => 'Assign Doctors',
            'success' => 'Doctors assigned successfully',
            'error' => 'Error assigning doctors: :error',
        ],
        'manage_schedule' => [
            'label' => 'Manage Schedule',
            'success' => 'Schedule updated successfully',
            'error' => 'Error updating schedule: :error',
        ],
    ],

    'sections' => [
        'basic_info' => [
            'label' => 'Basic Information',
            'description' => 'Essential studio details and contact information',
        ],
        'location' => [
            'label' => 'Location Details',
            'description' => 'Physical address and accessibility information',
        ],
        'contact_info' => [
            'label' => 'Contact Information',
            'description' => 'Phone, email, and website details',
        ],
        'business_info' => [
            'label' => 'Business Information',
            'description' => 'Tax codes, licenses, and legal information',
        ],
        'operational_settings' => [
            'label' => 'Operational Settings',
            'description' => 'Hours, capacity, and booking preferences',
        ],
        'services' => [
            'label' => 'Services & Specializations',
            'description' => 'Medical services and areas of expertise',
        ],
        'facilities' => [
            'label' => 'Facilities & Equipment',
            'description' => 'Available facilities and medical equipment',
        ],
        'policies' => [
            'label' => 'Policies & Procedures',
            'description' => 'Payment methods, insurance, and operational policies',
        ],
        'system_info' => [
            'label' => 'System Information',
            'description' => 'Registration date and system status',
        ],
    ],

    'filters' => [
        'is_active' => [
            'label' => 'Filter by Status',
            'options' => [
                '1' => 'Active Studios',
                '0' => 'Inactive Studios',
            ],
        ],
        'accepts_new_patients' => [
            'label' => 'New Patient Acceptance',
            'options' => [
                '1' => 'Accepting New Patients',
                '0' => 'Not Accepting New Patients',
            ],
        ],
        'city' => [
            'label' => 'Filter by City',
        ],
        'specializations' => [
            'label' => 'Filter by Specialization',
        ],
        'wheelchair_accessible' => [
            'label' => 'Accessibility',
            'options' => [
                '1' => 'Wheelchair Accessible',
                '0' => 'Not Wheelchair Accessible',
            ],
        ],
    ],

    'messages' => [
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
    ],

    'validation' => [
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
    ],

    'notifications' => [
        'new_appointment' => 'New appointment scheduled at your studio',
        'appointment_cancelled' => 'An appointment has been cancelled',
        'schedule_updated' => 'Studio schedule has been updated',
        'capacity_warning' => 'Studio is approaching daily capacity limit',
        'equipment_maintenance' => 'Equipment maintenance reminder',
        'license_expiring' => 'Medical license expiring soon',
        'insurance_update' => 'Insurance policy requires update',
    ],

    'empty_states' => [
        'no_studios' => 'No medical studios found',
        'no_doctors' => 'No doctors assigned to this studio',
        'no_appointments' => 'No appointments scheduled',
        'no_equipment' => 'No equipment registered',
        'no_specializations' => 'No specializations defined',
    ],

    'tabs' => [
        'overview' => [
            'label' => 'Overview',
            'description' => 'General studio information and status',
        ],
        'doctors' => [
            'label' => 'Medical Staff',
            'description' => 'Doctors and healthcare professionals',
        ],
        'schedule' => [
            'label' => 'Schedule',
            'description' => 'Operating hours and availability',
        ],
        'appointments' => [
            'label' => 'Appointments',
            'description' => 'Scheduled patient appointments',
        ],
        'equipment' => [
            'label' => 'Equipment',
            'description' => 'Medical equipment and facilities',
        ],
        'reports' => [
            'label' => 'Reports',
            'description' => 'Performance and activity reports',
        ],
    ],
]; 