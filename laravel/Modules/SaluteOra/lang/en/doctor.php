<?php

<<<<<<< HEAD
declare(strict_types=1);

return [
    'name' => 'Doctors',
    
    'navigation' => [
        'label' => 'Doctors',
        'group' => 'Medical Team',
        'icon' => 'heroicon-o-user-group',
        'color' => 'emerald',
        'sort' => 2,
        'tooltip' => 'Manage medical staff and related professional information',
    ],

    'model' => [
        'label' => 'Doctor',
        'plural' => 'Doctors',
        'description' => 'Management of medical staff and professional information',
    ],

    'pages' => [
        'index' => [
            'title' => 'Doctors List',
            'subtitle' => 'Manage medical team',
            'description' => 'View and manage all registered doctors',
        ],
        'create' => [
            'title' => 'New Doctor',
            'subtitle' => 'Register a new doctor',
            'description' => 'Add a new doctor to the team',
        ],
        'edit' => [
            'title' => 'Edit Doctor',
            'subtitle' => 'Update doctor data',
            'description' => 'Edit information of selected doctor',
        ],
    ],

    'steps' => [
        'personal_info' => [
            'label' => 'Personal Information',
            'description' => 'Enter personal information',
            'icon' => 'heroicon-o-user',
            'color' => 'primary',
            'tooltip' => 'Personal and biographical data of the doctor',
        ],
        'moderation' => [
            'label' => 'Moderation',
            'description' => 'Information verification',
            'icon' => 'heroicon-o-shield-check',
            'color' => 'warning',
            'tooltip' => 'Profile verification and approval process',
        ],
        'contacts' => [
            'label' => 'Contacts',
            'description' => 'Contact information',
            'icon' => 'heroicon-o-phone',
            'color' => 'info',
            'tooltip' => 'Professional contact data',
        ],
        'professional' => [
            'label' => 'Professional Information',
            'description' => 'Professional data and specializations',
            'icon' => 'heroicon-o-academic-cap',
            'color' => 'success',
            'tooltip' => 'Medical qualifications and specializations',
        ],
        'availability' => [
            'label' => 'Availability',
            'description' => 'Available hours and days',
            'icon' => 'heroicon-o-calendar',
            'color' => 'danger',
            'tooltip' => 'Calendar and office hours',
        ],
        'studio' => [
            'label' => 'Practice',
            'description' => 'Medical practice information',
            'icon' => 'heroicon-o-building-office-2',
            'color' => 'blue',
            'tooltip' => 'Data of the practice where they operate',
        ],
    ],

    'fields' => [
        'id' => [
            'label' => 'ID',
            'placeholder' => 'Doctor identifier',
            'help' => 'Unique doctor identifier',
            'helper_text' => '',
        ],
        'first_name' => [
            'label' => 'First Name',
            'placeholder' => 'Enter first name',
            'help' => 'First name as registered with the Medical Board',
            'helper_text' => '',
        ],
        'last_name' => [
            'label' => 'Last Name',
            'placeholder' => 'Enter last name',
            'help' => 'Last name as registered with the Medical Board',
            'helper_text' => '',
        ],
        'full_name' => [
            'label' => 'Full Name',
            'placeholder' => 'Enter complete first and last name',
            'help' => 'Full name as registered with the Medical Board',
            'helper_text' => '',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'doctor@example.com',
            'help' => 'Professional email address',
            'helper_text' => '',
        ],
        'phone' => [
            'label' => 'Phone',
            'placeholder' => '+39 123 456 7890',
            'help' => 'Professional phone number',
            'helper_text' => '',
        ],
        'address' => [
            'label' => 'Address',
            'placeholder' => 'Via Roma, 123',
            'help' => 'Medical practice address',
            'helper_text' => '',
        ],
        'city' => [
            'label' => 'City',
            'placeholder' => 'Enter city',
            'help' => 'City where the practice is located',
            'helper_text' => '',
        ],
        'registration_number' => [
            'label' => 'Registration Number',
            'placeholder' => 'Enter registration number',
            'help' => 'Medical Board registration number',
            'helper_text' => '',
        ],
        'vat_number' => [
            'label' => 'VAT Number',
            'placeholder' => 'Enter VAT number',
            'help' => 'VAT number for billing purposes',
            'helper_text' => '',
        ],
        'specialization' => [
            'label' => 'Specialization',
            'placeholder' => 'Select specialization',
            'help' => 'Primary medical specialization',
            'helper_text' => '',
        ],
        'status' => [
            'label' => 'Status',
            'placeholder' => 'Select status',
            'help' => 'Medical profile status',
            'helper_text' => '',
            'options' => [
                'active' => 'Active',
                'inactive' => 'Inactive',
                'pending' => 'Pending',
                'suspended' => 'Suspended',
            ],
        ],
        'certification' => [
            'label' => 'Certification',
            'placeholder' => 'Upload certification',
            'help' => 'Medical Board registration document',
            'helper_text' => '',
        ],
        'certificates' => [
            'label' => 'Certificates',
            'placeholder' => 'Upload certificates',
            'help' => 'Professional certificates and specializations',
            'helper_text' => '',
        ],
        'certifications' => [
            'label' => 'Certifications',
            'placeholder' => 'Upload certifications',
            'help' => 'Documents attesting professional qualifications',
            'helper_text' => '',
        ],
        'moderation_notes' => [
            'label' => 'Moderation Notes',
            'placeholder' => 'Enter any notes',
            'help' => 'Internal notes for the moderation process',
            'helper_text' => '',
        ],
        'availability' => [
            'label' => 'Availability',
            'placeholder' => 'Set availability',
            'help' => 'Days and hours available for visits',
            'helper_text' => '',
        ],
        'day' => [
            'label' => 'Day',
            'placeholder' => 'Select day',
            'help' => 'Day of the week for availability',
            'helper_text' => '',
            'options' => [
                'monday' => 'Monday',
                'tuesday' => 'Tuesday',
                'wednesday' => 'Wednesday',
                'thursday' => 'Thursday',
                'friday' => 'Friday',
                'saturday' => 'Saturday',
                'sunday' => 'Sunday',
            ],
        ],
        'start_time' => [
            'label' => 'Start Time',
            'placeholder' => 'Select start time',
            'help' => 'Start time of availability',
            'helper_text' => '',
        ],
        'end_time' => [
            'label' => 'End Time',
            'placeholder' => 'Select end time',
            'help' => 'End time of availability',
            'helper_text' => '',
        ],
        'attach' => [
            'label' => 'Attachments',
            'placeholder' => 'Upload attachments',
            'help' => 'Documents attached to the profile',
            'helper_text' => '',
        ],
        'created_at' => [
            'label' => 'Creation Date',
            'placeholder' => 'Registration date',
            'help' => 'Doctor registration date',
            'helper_text' => '',
        ],
    ],

    'filters' => [
        'search_placeholder' => 'Search doctors...',
        'is_active' => [
            'label' => 'Status',
            'placeholder' => 'Filter by status',
            'help' => 'Filter doctors by profile status',
            'helper_text' => '',
            'options' => [
                'active' => 'Active',
                'inactive' => 'Inactive',
                'pending' => 'Pending',
                'suspended' => 'Suspended',
            ],
        ],
        'specialization' => [
            'label' => 'Specialization',
            'placeholder' => 'Filter by specialization',
            'help' => 'Filter by medical specialization',
            'helper_text' => '',
        ],
        'city' => [
            'label' => 'City',
            'placeholder' => 'Filter by city',
            'help' => 'Filter by practice city',
            'helper_text' => '',
        ],
    ],

    'actions' => [
        'create' => [
            'label' => 'New Doctor',
            'icon' => 'heroicon-o-plus',
            'color' => 'primary',
            'tooltip' => 'Add a new doctor to the system',
            'modal_heading' => 'Create New Doctor',
            'modal_description' => 'Enter new doctor data',
            'success' => 'Doctor created successfully',
            'error' => 'Error creating doctor',
        ],
        'edit' => [
            'label' => 'Edit',
            'icon' => 'heroicon-o-pencil',
            'color' => 'warning',
            'tooltip' => 'Edit selected doctor data',
            'modal_heading' => 'Edit Doctor',
            'modal_description' => 'Edit doctor data',
            'success' => 'Doctor updated successfully',
            'error' => 'Error updating doctor',
        ],
        'delete' => [
            'label' => 'Delete',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
            'tooltip' => 'Delete selected doctor',
            'modal_heading' => 'Delete Doctor',
            'modal_description' => 'Are you sure you want to delete this doctor? This action cannot be undone.',
            'confirmation' => 'Are you sure you want to delete this doctor? All their data will be permanently lost.',
            'success' => 'Doctor deleted successfully',
            'error' => 'Error deleting doctor',
        ],
        'view' => [
            'label' => 'View',
            'icon' => 'heroicon-o-eye',
            'color' => 'info',
            'tooltip' => 'View doctor details',
            'modal_heading' => 'Doctor Details',
        ],
        'approve' => [
            'label' => 'Approve',
            'icon' => 'heroicon-o-check-circle',
            'color' => 'success',
            'tooltip' => 'Approve doctor profile',
            'confirmation' => 'Are you sure you want to approve this doctor?',
            'success' => 'Doctor approved successfully',
            'error' => 'Error approving doctor',
        ],
        'suspend' => [
            'label' => 'Suspend',
            'icon' => 'heroicon-o-pause-circle',
            'color' => 'warning',
            'tooltip' => 'Temporarily suspend profile',
            'confirmation' => 'Are you sure you want to suspend this doctor?',
            'success' => 'Doctor suspended successfully',
            'error' => 'Error suspending doctor',
        ],
    ],

    'messages' => [
        'created' => 'Doctor created successfully',
        'updated' => 'Doctor updated successfully',
        'deleted' => 'Doctor deleted successfully',
        'approved' => 'Doctor approved successfully',
        'suspended' => 'Doctor suspended successfully',
        'activated' => 'Doctor activated successfully',
        'certification_uploaded' => 'Certification uploaded successfully',
        'certification_verified' => 'Certification verified successfully',
        'availability_updated' => 'Availability updated successfully',
    ],

    'sections' => [
        'personal_info' => [
            'label' => 'Personal Information',
            'description' => 'Doctor\'s biographical data',
        ],
        'contact_info' => [
            'label' => 'Contact Information',
            'description' => 'Professional contacts',
        ],
        'professional_info' => [
            'label' => 'Professional Information',
            'description' => 'Qualifications and specializations',
        ],
        'availability_settings' => [
            'label' => 'Availability Settings',
            'description' => 'Office hours and days',
        ],
        'documents' => [
            'label' => 'Documents',
            'description' => 'Certifications and attachments',
        ],
    ],

    'validation' => [
        'required' => 'The :attribute field is required',
        'email' => 'The :attribute field must be a valid email address',
        'unique' => 'The :attribute value is already in use',
        'min' => 'The :attribute field must be at least :min characters',
        'max' => 'The :attribute field cannot exceed :max characters',
        'registration_number_format' => 'The registration number must be in the correct format',
        'vat_number_format' => 'The VAT number must be in the correct format',
        'phone_format' => 'The phone number must be in the correct format',
    ],

    'empty_state' => [
        'heading' => 'No doctors found',
        'description' => 'There are no registered doctors matching the search criteria',
        'action' => 'Register the first doctor',
    ],

    'specialties' => [
        'label' => 'Specializations',
        'description' => 'Doctor\'s medical specializations',
        'empty' => 'No specializations registered',
    ],
];
=======
return array (
  'steps' => 
  array (
    'personal_info' => 
    array (
      'label' => 'Personal Information',
      'description' => 'Enter your personal information',
    ),
    'moderation' => 
    array (
      'label' => 'Moderation',
      'description' => 'Profile verification and approval',
    ),
    'contacts' => 
    array (
      'label' => 'Contacts',
      'description' => 'Enter your contact information',
    ),
    'professional' => 
    array (
      'label' => 'Professional Information',
      'description' => 'Enter your professional information',
    ),
    'availability' => 
    array (
      'label' => 'Availability',
      'description' => 'Set your availability schedule',
    ),
  ),
  'fields' => 
  array (
    'full_name' => 
    array (
      'label' => 'Full Name',
      'placeholder' => 'Enter full name',
    ),
    'certification' => 
    array (
      'label' => 'Certification',
      'tooltip' => 'Upload your professional certification',
    ),
    'moderation_status' => 
    array (
      'label' => 'Moderation Status',
    ),
    'moderation_notes' => 
    array (
      'label' => 'Moderation Notes',
      'placeholder' => 'Enter any moderation notes',
    ),
    'fiscal_code' => 
    array (
      'label' => 'Fiscal Code',
      'placeholder' => 'Enter fiscal code',
    ),
    'birth_date' => 
    array (
      'label' => 'Date of Birth',
      'placeholder' => 'Select date of birth',
    ),
    'email' => 
    array (
      'label' => 'Email',
      'placeholder' => 'Enter email address',
      'description' => 'email',
      'helper_text' => 'email',
    ),
    'phone' => 
    array (
      'label' => 'Phone',
      'placeholder' => 'Enter phone number',
    ),
    'address' => 
    array (
      'label' => 'Address',
      'placeholder' => 'Enter practice address',
    ),
    'city' => 
    array (
      'label' => 'City',
      'placeholder' => 'Enter city',
    ),
    'registration_number' => 
    array (
      'label' => 'Registration Number',
      'placeholder' => 'Enter professional registration number',
    ),
    'specialties' => 
    array (
      'label' => 'Specialties',
      'placeholder' => 'Select specialties',
    ),
    'certifications' => 
    array (
      'label' => 'Certifications',
      'tooltip' => 'Upload any additional certifications',
    ),
    'availability' => 
    array (
      'label' => 'Availability Schedule',
    ),
    'day' => 
    array (
      'label' => 'Day',
      'placeholder' => 'Select day',
      'helper_text' => 'Select the day of the week',
    ),
    'start_time' => 
    array (
      'label' => 'Start Time',
      'placeholder' => 'Select start time',
      'helper_text' => 'When the availability period begins',
    ),
    'end_time' => 
    array (
      'label' => 'End Time',
      'placeholder' => 'Select end time',
      'helper_text' => 'When the availability period ends',
    ),
    'last_name' => 
    array (
      'label' => 'Last Name',
      'placeholder' => 'Enter last name',
      'helper_text' => 'Your family name',
    ),
    'first_name' => 
    array (
      'label' => 'First Name',
      'placeholder' => 'Enter first name',
      'helper_text' => 'Your given name',
    ),
  ),
);
>>>>>>> 1c0ba5b2 (translations)
