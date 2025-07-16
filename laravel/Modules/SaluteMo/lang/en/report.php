<?php

return array (
  'model' => 
  array (
    'label' => 'Dental Report',
    'plural' => 'Dental Reports',
    'description' => 'Complete management of dental reports',
    'icon' => 'heroicon-o-document-text',
  ),
  'navigation' => 
  array (
    'label' => 'Dental Reports',
    'group' => 'Report Management',
    'icon' => 'heroicon-o-document-text',
    'color' => 'green',
    'sort' => 2,
    'tooltip' => 'Manage all dental reports in the system',
    'helper_text' => '',
  ),
  'pages' => 
  array (
    'index' => 
    array (
      'title' => 'Dental Reports List',
      'subtitle' => 'Complete management of dental reports',
      'description' => 'View and manage all dental reports in the system',
    ),
    'create' => 
    array (
      'title' => 'New Dental Report',
      'subtitle' => 'Create a new dental report',
      'description' => 'Enter details to create a new dental report',
    ),
    'edit' => 
    array (
      'title' => 'Edit Dental Report',
      'subtitle' => 'Edit dental report details',
      'description' => 'Update information for the selected dental report',
    ),
    'view' => 
    array (
      'title' => 'Dental Report Details',
      'subtitle' => 'View complete details of the dental report',
      'description' => 'Detailed information about the selected dental report',
    ),
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'placeholder' => 'Report ID',
      'help' => 'Unique identifier of the report',
      'tooltip' => 'Numeric ID of the report',
      'helper_text' => '',
    ),
    'patient_id' => 
    array (
      'label' => 'Patient ID',
      'placeholder' => 'Patient ID',
      'help' => 'Patient identifier',
      'tooltip' => 'ID of the patient associated with the report',
      'helper_text' => '',
    ),
    'appointment_id' => 
    array (
      'label' => 'Appointment ID',
      'placeholder' => 'Appointment ID',
      'help' => 'Appointment identifier',
      'tooltip' => 'ID of the appointment associated with the report',
      'helper_text' => '',
    ),
    'has_mouth_or_teeth_pain' => 
    array (
      'label' => 'Mouth or Teeth Pain',
      'placeholder' => 'Has suffered from mouth or teeth pain in the last 12 months',
      'help' => 'Indicates if the patient has suffered from mouth or teeth pain in the last 12 months',
      'tooltip' => 'Mouth or teeth pain in the last 12 months',
      'helper_text' => '',
    ),
    'mouth_teeth_pain_frequency' => 
    array (
      'label' => 'Pain Frequency',
      'placeholder' => 'How often does pain occur',
      'help' => 'Frequency of mouth or teeth pain',
      'tooltip' => 'How often pain manifests',
      'helper_text' => '',
    ),
    'pregnancy_month' => 
    array (
      'label' => 'Pregnancy Month',
      'placeholder' => 'Enter pregnancy month',
      'help' => 'Patient\'s pregnancy month',
      'tooltip' => 'Pregnancy month',
      'helper_text' => '',
    ),
    'pregnancy_week' => 
    array (
      'label' => 'Pregnancy Week',
      'placeholder' => 'Enter pregnancy week',
      'help' => 'Patient\'s pregnancy week',
      'tooltip' => 'Pregnancy week',
      'helper_text' => '',
    ),
    'teeth_brushing_frequency' => 
    array (
      'label' => 'Teeth Brushing Frequency',
      'placeholder' => 'Number of times teeth are brushed',
      'help' => 'Number of times the patient brushes their teeth',
      'tooltip' => 'Frequency of teeth brushing',
      'helper_text' => '',
    ),
    'smokes' => 
    array (
      'label' => 'Smokes',
      'placeholder' => 'Does the patient smoke?',
      'help' => 'Indicates if the patient smokes',
      'tooltip' => 'Smoking habit',
      'helper_text' => '',
    ),
    'visits_dentist_yearly' => 
    array (
      'label' => 'Annual Dentist Visits',
      'placeholder' => 'Does he/she visit the dentist at least once a year?',
      'help' => 'Indicates if the patient visits the dentist at least once a year',
      'tooltip' => 'Annual dentist visits',
      'helper_text' => '',
    ),
    'has_diseases' => 
    array (
      'label' => 'Has Diseases',
      'placeholder' => 'Is he/she affected by any disease?',
      'help' => 'Indicates if the patient is affected by any disease',
      'tooltip' => 'Presence of diseases',
      'helper_text' => '',
    ),
    'specify_diseases' => 
    array (
      'label' => 'Specify Diseases',
      'placeholder' => 'If yes, specify the diseases',
      'help' => 'Specify diseases if present',
      'tooltip' => 'Disease details',
      'helper_text' => '',
    ),
    'follows_diet_rules' => 
    array (
      'label' => 'Follows Diet Rules',
      'placeholder' => 'Does he/she follow diet rules?',
      'help' => 'Indicates if the patient follows diet rules',
      'tooltip' => 'Dietary rules',
      'helper_text' => '',
    ),
    'uses_asl_clinic_for_dental_care' => 
    array (
      'label' => 'Uses ASL Clinic',
      'placeholder' => 'Does he/she use ASL clinic?',
      'help' => 'Indicates if the patient uses ASL clinic for dental care',
      'tooltip' => 'ASL clinic usage',
      'helper_text' => '',
    ),
    'missing_teeth' => 
    array (
      'label' => 'Missing Teeth',
      'placeholder' => 'Does he/she have missing teeth?',
      'help' => 'Indicates if the patient has missing teeth',
      'tooltip' => 'Presence of missing teeth',
      'helper_text' => '',
    ),
    'specify_missing_teeth' => 
    array (
      'label' => 'Specify Missing Teeth',
      'placeholder' => 'If yes, specify missing teeth',
      'help' => 'Specify missing teeth if present',
      'tooltip' => 'Missing teeth details',
      'helper_text' => '',
    ),
    'more_info_missing_teeth' => 
    array (
      'label' => 'Additional Missing Teeth Info',
      'placeholder' => 'Additional specifications on missing teeth',
      'help' => 'Additional information on missing teeth',
      'tooltip' => 'Additional missing teeth details',
      'helper_text' => '',
    ),
    'decayed_teeth' => 
    array (
      'label' => 'Decayed Teeth',
      'placeholder' => 'Does he/she have decayed teeth?',
      'help' => 'Indicates if the patient has decayed teeth',
      'tooltip' => 'Presence of decayed teeth',
      'helper_text' => '',
    ),
    'specify_decayed_teeth' => 
    array (
      'label' => 'Specify Decayed Teeth',
      'placeholder' => 'If yes, specify decayed teeth',
      'help' => 'Specify decayed teeth if present',
      'tooltip' => 'Decayed teeth details',
      'helper_text' => '',
    ),
    'more_info_decayed_teeth' => 
    array (
      'label' => 'Additional Decayed Teeth Info',
      'placeholder' => 'Additional specifications on decayed teeth',
      'help' => 'Additional information on decayed teeth',
      'tooltip' => 'Additional decayed teeth details',
      'helper_text' => '',
    ),
    'has_fixed_prosthesis_or_implants' => 
    array (
      'label' => 'Fixed Prosthesis or Implants',
      'placeholder' => 'Does he/she have fixed prosthesis or implants?',
      'help' => 'Indicates if the patient has fixed prosthesis or implants',
      'tooltip' => 'Presence of fixed prosthesis or implants',
      'helper_text' => '',
    ),
    'specify_prosthesis_or_implants' => 
    array (
      'label' => 'Specify Prosthesis or Implants',
      'placeholder' => 'If yes, specify prosthesis or implants',
      'help' => 'Specify prosthesis or implants if present',
      'tooltip' => 'Prosthesis or implants details',
      'helper_text' => '',
    ),
    'more_info_prosthesis' => 
    array (
      'label' => 'Additional Prosthesis Info',
      'placeholder' => 'Additional specifications on prosthesis or implants',
      'help' => 'Additional information on prosthesis or implants',
      'tooltip' => 'Additional prosthesis details',
      'helper_text' => '',
    ),
    'has_tartar' => 
    array (
      'label' => 'Has Tartar',
      'placeholder' => 'Does he/she have tartar?',
      'help' => 'Indicates if the patient has tartar',
      'tooltip' => 'Presence of tartar',
      'helper_text' => '',
    ),
    'specify_tartar' => 
    array (
      'label' => 'Specify Tartar',
      'placeholder' => 'If yes, specify tartar',
      'help' => 'Specify tartar if present',
      'tooltip' => 'Tartar details',
      'helper_text' => '',
    ),
    'more_info_tartar' => 
    array (
      'label' => 'Additional Tartar Info',
      'placeholder' => 'Additional specifications on tartar',
      'help' => 'Additional information on tartar',
      'tooltip' => 'Additional tartar details',
      'helper_text' => '',
    ),
    'has_plaque' => 
    array (
      'label' => 'Has Plaque',
      'placeholder' => 'Does he/she have plaque?',
      'help' => 'Indicates if the patient has plaque',
      'tooltip' => 'Presence of plaque',
      'helper_text' => '',
    ),
    'specify_plaque' => 
    array (
      'label' => 'Specify Plaque',
      'placeholder' => 'If yes, specify plaque',
      'help' => 'Specify plaque if present',
      'tooltip' => 'Plaque details',
      'helper_text' => '',
    ),
    'more_info_plaque' => 
    array (
      'label' => 'Additional Plaque Info',
      'placeholder' => 'Additional specifications on plaque',
      'help' => 'Additional information on plaque',
      'tooltip' => 'Additional plaque details',
      'helper_text' => '',
    ),
    'needs_more_dental_care' => 
    array (
      'label' => 'Needs More Dental Care',
      'placeholder' => 'Does the patient need additional dental care?',
      'help' => 'Indicates if the patient needs additional dental care',
      'tooltip' => 'Need for additional dental care',
      'helper_text' => '',
    ),
    'further_notes' => 
    array (
      'label' => 'Additional Notes',
      'placeholder' => 'Enter additional specifications',
      'help' => 'Additional notes or specifications on the report',
      'tooltip' => 'Additional notes',
      'helper_text' => '',
    ),
    'invoice' => 
    array (
      'label' => 'Invoice',
      'placeholder' => 'Invoice file',
      'help' => 'Associated invoice file',
      'tooltip' => 'Invoice file',
      'helper_text' => '',
    ),
    'created_at' => 
    array (
      'label' => 'Creation Date',
      'help' => 'Date and time of report creation',
      'tooltip' => 'When the report was created',
      'helper_text' => '',
    ),
    'updated_at' => 
    array (
      'label' => 'Modification Date',
      'help' => 'Date and time of last report modification',
      'tooltip' => 'When the report was last modified',
      'helper_text' => '',
    ),
    'toggleColumns' => 
    array (
      'label' => 'Show/Hide Columns',
    ),
    'reorderRecords' => 
    array (
      'label' => 'Reorder Records',
    ),
    'resetFilters' => 
    array (
      'label' => 'Reset Filters',
    ),
    'applyFilters' => 
    array (
      'label' => 'Apply Filters',
    ),
    'openFilters' => 
    array (
      'label' => 'Open Filters',
    ),
    'delete' => 
    array (
      'label' => 'Delete',
    ),
    'edit' => 
    array (
      'label' => 'Edit',
    ),
    'view' => 
    array (
      'label' => 'View',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'New Dental Report',
      'success' => 'Dental report created successfully',
      'error' => 'Error creating dental report',
    ),
    'edit' => 
    array (
      'label' => 'Edit Dental Report',
      'success' => 'Dental report modified successfully',
      'error' => 'Error modifying dental report',
    ),
    'delete' => 
    array (
      'label' => 'Delete Dental Report',
      'success' => 'Dental report deleted successfully',
      'error' => 'Error deleting dental report',
      'confirmation' => 'Are you sure you want to delete this dental report?',
    ),
    'view' => 
    array (
      'label' => 'View Dental Report',
    ),
    'export' => 
    array (
      'label' => 'Export Dental Report',
      'success' => 'Dental report exported successfully',
      'error' => 'Error exporting dental report',
    ),
    'print' => 
    array (
      'label' => 'Print Dental Report',
      'success' => 'Dental report sent to print',
      'error' => 'Error printing dental report',
    ),
  ),
  'filters' => 
  array (
    'patient_id' => 
    array (
      'label' => 'Filter by Patient',
      'placeholder' => 'Select patient',
    ),
    'appointment_id' => 
    array (
      'label' => 'Filter by Appointment',
      'placeholder' => 'Select appointment',
    ),
    'date_range' => 
    array (
      'label' => 'Date Range',
      'placeholder' => 'Select date range',
    ),
  ),
  'messages' => 
  array (
    'no_reports' => 'No dental reports found',
    'loading' => 'Loading dental reports...',
    'error_loading' => 'Error loading dental reports',
  ),
); 