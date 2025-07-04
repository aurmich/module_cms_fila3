<?php

return array (
  'name' => 'Doctors',
  'navigation' => 
  array (
    'label' => 'Doctors',
    'group' => 'Medical Team',
    'icon' => 'heroicon-o-user-group',
    'color' => 'emerald',
    'sort' => 2,
    'tooltip' => 'Manage medical staff and related professional information',
  ),
  'model' => 
  array (
    'label' => 'Doctor',
    'plural' => 'Doctors',
    'description' => 'Management of medical staff and professional information',
  ),
  'pages' => 
  array (
    'index' => 
    array (
      'title' => 'Doctors List',
      'subtitle' => 'Manage medical team',
      'description' => 'View and manage all registered doctors',
    ),
    'create' => 
    array (
      'title' => 'New Doctor',
      'subtitle' => 'Register a new doctor',
      'description' => 'Add a new doctor to the team',
    ),
    'edit' => 
    array (
      'title' => 'Edit Doctor',
      'subtitle' => 'Update doctor data',
      'description' => 'Edit information of selected doctor',
    ),
  ),
  'steps' => 
  array (
    'personal_info' => 
    array (
      'label' => 'Personal Information',
      'description' => 'Enter personal information',
      'icon' => 'heroicon-o-user',
      'color' => 'primary',
      'tooltip' => 'Personal and biographical data of the doctor',
    ),
    'moderation' => 
    array (
      'label' => 'Moderation',
      'description' => 'Information verification',
      'icon' => 'heroicon-o-shield-check',
      'color' => 'warning',
      'tooltip' => 'Profile verification and approval process',
    ),
    'contacts' => 
    array (
      'label' => 'Contacts',
      'description' => 'Contact information',
      'icon' => 'heroicon-o-phone',
      'color' => 'info',
      'tooltip' => 'Professional contact data',
    ),
    'professional' => 
    array (
      'label' => 'Professional Information',
      'description' => 'Professional data and specializations',
      'icon' => 'heroicon-o-academic-cap',
      'color' => 'success',
      'tooltip' => 'Medical qualifications and specializations',
    ),
    'availability' => 
    array (
      'label' => 'Availability',
      'description' => 'Available hours and days',
      'icon' => 'heroicon-o-calendar',
      'color' => 'danger',
      'tooltip' => 'Calendar and office hours',
    ),
    'studio' => 
    array (
      'label' => 'Practice',
      'description' => 'Medical practice information',
      'icon' => 'heroicon-o-building-office-2',
      'color' => 'blue',
      'tooltip' => 'Data of the practice where they operate',
    ),
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'placeholder' => 'Doctor identifier',
      'help' => 'Unique doctor identifier',
      'helper_text' => '',
    ),
    'first_name' => 
    array (
      'label' => 'First Name',
      'placeholder' => 'Enter first name',
      'help' => 'First name as registered with the Medical Board',
      'helper_text' => '',
    ),
    'last_name' => 
    array (
      'label' => 'Last Name',
      'placeholder' => 'Enter last name',
      'help' => 'Last name as registered with the Medical Board',
      'helper_text' => '',
    ),
    'full_name' => 
    array (
      'label' => 'Full Name',
      'placeholder' => 'Enter complete first and last name',
      'help' => 'Full name as registered with the Medical Board',
      'helper_text' => '',
    ),
    'email' => 
    array (
      'label' => 'Email',
      'placeholder' => 'doctor@example.com',
      'help' => 'Professional email address',
      'helper_text' => '',
      'description' => 'email',
    ),
    'phone' => 
    array (
      'label' => 'Phone',
      'placeholder' => '+39 123 456 7890',
      'help' => 'Professional phone number',
      'helper_text' => '',
    ),
    'address' => 
    array (
      'label' => 'Address',
      'placeholder' => 'Via Roma, 123',
      'help' => 'Medical practice address',
      'helper_text' => '',
    ),
    'city' => 
    array (
      'label' => 'City',
      'placeholder' => 'Enter city',
      'help' => 'City where the practice is located',
      'helper_text' => '',
    ),
    'registration_number' => 
    array (
      'label' => 'Registration Number',
      'placeholder' => 'Enter registration number',
      'help' => 'Medical Board registration number',
      'helper_text' => '',
    ),
    'vat_number' => 
    array (
      'label' => 'VAT Number',
      'placeholder' => 'Enter VAT number',
      'help' => 'VAT number for billing purposes',
      'helper_text' => '',
    ),
    'specialization' => 
    array (
      'label' => 'Specialization',
      'placeholder' => 'Select specialization',
      'help' => 'Primary medical specialization',
      'helper_text' => '',
    ),
    'status' => 
    array (
      'label' => 'Status',
      'placeholder' => 'Select status',
      'help' => 'Medical profile status',
      'helper_text' => '',
      'options' => 
      array (
        'active' => 'Active',
        'inactive' => 'Inactive',
        'pending' => 'Pending',
        'suspended' => 'Suspended',
      ),
    ),
    'certification' => 
    array (
      'label' => 'Certification',
      'placeholder' => 'Upload certification',
      'help' => 'Medical Board registration document',
      'helper_text' => '',
    ),
    'certificates' => 
    array (
      'label' => 'Certificates',
      'placeholder' => 'Upload certificates',
      'help' => 'Professional certificates and specializations',
      'helper_text' => '',
    ),
    'certifications' => 
    array (
      'label' => 'Certifications',
      'placeholder' => 'Upload certifications',
      'help' => 'Documents attesting professional qualifications',
      'helper_text' => '',
    ),
    'moderation_notes' => 
    array (
      'label' => 'Moderation Notes',
      'placeholder' => 'Enter any notes',
      'help' => 'Internal notes for the moderation process',
      'helper_text' => '',
    ),
    'availability' => 
    array (
      'label' => 'Availability',
      'placeholder' => 'Set availability',
      'help' => 'Days and hours available for visits',
      'helper_text' => '',
    ),
    'day' => 
    array (
      'label' => 'Day',
      'placeholder' => 'Select day',
      'help' => 'Day of the week for availability',
      'helper_text' => '',
      'options' => 
      array (
        'monday' => 'Monday',
        'tuesday' => 'Tuesday',
        'wednesday' => 'Wednesday',
        'thursday' => 'Thursday',
        'friday' => 'Friday',
        'saturday' => 'Saturday',
        'sunday' => 'Sunday',
      ),
    ),
    'start_time' => 
    array (
      'label' => 'Start Time',
      'placeholder' => 'Select start time',
      'help' => 'Start time of availability',
      'helper_text' => '',
    ),
    'end_time' => 
    array (
      'label' => 'End Time',
      'placeholder' => 'Select end time',
      'help' => 'End time of availability',
      'helper_text' => '',
    ),
    'attach' => 
    array (
      'label' => 'Attachments',
      'placeholder' => 'Upload attachments',
      'help' => 'Documents attached to the profile',
      'helper_text' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Creation Date',
      'placeholder' => 'Registration date',
      'help' => 'Doctor registration date',
      'helper_text' => '',
    ),
  ),
  'filters' => 
  array (
    'search_placeholder' => 'Search doctors...',
    'is_active' => 
    array (
      'label' => 'Status',
      'placeholder' => 'Filter by status',
      'help' => 'Filter doctors by profile status',
      'helper_text' => '',
      'options' => 
      array (
        'active' => 'Active',
        'inactive' => 'Inactive',
        'pending' => 'Pending',
        'suspended' => 'Suspended',
      ),
    ),
    'specialization' => 
    array (
      'label' => 'Specialization',
      'placeholder' => 'Filter by specialization',
      'help' => 'Filter by medical specialization',
      'helper_text' => '',
    ),
    'city' => 
    array (
      'label' => 'City',
      'placeholder' => 'Filter by city',
      'help' => 'Filter by practice city',
      'helper_text' => '',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'New Doctor',
      'icon' => 'heroicon-o-plus',
      'color' => 'primary',
      'tooltip' => 'Add a new doctor to the system',
      'modal_heading' => 'Create New Doctor',
      'modal_description' => 'Enter new doctor data',
      'success' => 'Doctor created successfully',
      'error' => 'Error creating doctor',
    ),
    'edit' => 
    array (
      'label' => 'Edit',
      'icon' => 'heroicon-o-pencil',
      'color' => 'warning',
      'tooltip' => 'Edit selected doctor data',
      'modal_heading' => 'Edit Doctor',
      'modal_description' => 'Edit doctor data',
      'success' => 'Doctor updated successfully',
      'error' => 'Error updating doctor',
    ),
    'delete' => 
    array (
      'label' => 'Delete',
      'icon' => 'heroicon-o-trash',
      'color' => 'danger',
      'tooltip' => 'Delete selected doctor',
      'modal_heading' => 'Delete Doctor',
      'modal_description' => 'Are you sure you want to delete this doctor? This action cannot be undone.',
      'confirmation' => 'Are you sure you want to delete this doctor? All their data will be permanently lost.',
      'success' => 'Doctor deleted successfully',
      'error' => 'Error deleting doctor',
    ),
    'view' => 
    array (
      'label' => 'View',
      'icon' => 'heroicon-o-eye',
      'color' => 'info',
      'tooltip' => 'View doctor details',
      'modal_heading' => 'Doctor Details',
    ),
    'approve' => 
    array (
      'label' => 'Approve',
      'icon' => 'heroicon-o-check-circle',
      'color' => 'success',
      'tooltip' => 'Approve doctor profile',
      'confirmation' => 'Are you sure you want to approve this doctor?',
      'success' => 'Doctor approved successfully',
      'error' => 'Error approving doctor',
    ),
    'suspend' => 
    array (
      'label' => 'Suspend',
      'icon' => 'heroicon-o-pause-circle',
      'color' => 'warning',
      'tooltip' => 'Temporarily suspend profile',
      'confirmation' => 'Are you sure you want to suspend this doctor?',
      'success' => 'Doctor suspended successfully',
      'error' => 'Error suspending doctor',
    ),
  ),
  'messages' => 
  array (
    'created' => 'Doctor created successfully',
    'updated' => 'Doctor updated successfully',
    'deleted' => 'Doctor deleted successfully',
    'approved' => 'Doctor approved successfully',
    'suspended' => 'Doctor suspended successfully',
    'activated' => 'Doctor activated successfully',
    'certification_uploaded' => 'Certification uploaded successfully',
    'certification_verified' => 'Certification verified successfully',
    'availability_updated' => 'Availability updated successfully',
  ),
  'sections' => 
  array (
    'personal_info' => 
    array (
      'label' => 'Personal Information',
      'description' => 'Doctor\'s biographical data',
    ),
    'contact_info' => 
    array (
      'label' => 'Contact Information',
      'description' => 'Professional contacts',
    ),
    'professional_info' => 
    array (
      'label' => 'Professional Information',
      'description' => 'Qualifications and specializations',
    ),
    'availability_settings' => 
    array (
      'label' => 'Availability Settings',
      'description' => 'Office hours and days',
    ),
    'documents' => 
    array (
      'label' => 'Documents',
      'description' => 'Certifications and attachments',
    ),
  ),
  'validation' => 
  array (
    'required' => 'The :attribute field is required',
    'email' => 'The :attribute field must be a valid email address',
    'unique' => 'The :attribute value is already in use',
    'min' => 'The :attribute field must be at least :min characters',
    'max' => 'The :attribute field cannot exceed :max characters',
    'registration_number_format' => 'The registration number must be in the correct format',
    'vat_number_format' => 'The VAT number must be in the correct format',
    'phone_format' => 'The phone number must be in the correct format',
  ),
  'empty_state' => 
  array (
    'heading' => 'No doctors found',
    'description' => 'There are no registered doctors matching the search criteria',
    'action' => 'Register the first doctor',
  ),
  'specialties' => 
  array (
    'label' => 'Specializations',
    'description' => 'Doctor\'s medical specializations',
    'empty' => 'No specializations registered',
  ),
);
