<?php

return array (
  'fields' => 
  array (
    'monday' => 
    array (
      'morning_from' => 
      array (
        'label' => 'Monday morning from',
        'placeholder' => '08:00',
        'help' => 'Opening time for Monday morning',
      ),
      'morning_to' => 
      array (
        'label' => 'Monday morning to',
        'placeholder' => '12:00',
        'help' => 'Closing time for Monday morning',
      ),
      'afternoon_from' => 
      array (
        'label' => 'Monday afternoon from',
        'placeholder' => '14:00',
        'help' => 'Opening time for Monday afternoon',
      ),
      'afternoon_to' => 
      array (
        'label' => 'Monday afternoon to',
        'placeholder' => '18:00',
        'help' => 'Closing time for Monday afternoon',
      ),
    ),
    'tuesday' => 
    array (
      'morning_from' => 
      array (
        'label' => 'Tuesday morning from',
        'placeholder' => '08:00',
        'help' => 'Opening time for Tuesday morning',
      ),
      'morning_to' => 
      array (
        'label' => 'Tuesday morning to',
        'placeholder' => '12:00',
        'help' => 'Closing time for Tuesday morning',
      ),
      'afternoon_from' => 
      array (
        'label' => 'Tuesday afternoon from',
        'placeholder' => '14:00',
        'help' => 'Opening time for Tuesday afternoon',
      ),
      'afternoon_to' => 
      array (
        'label' => 'Tuesday afternoon to',
        'placeholder' => '18:00',
        'help' => 'Closing time for Tuesday afternoon',
      ),
    ),
    'wednesday' => 
    array (
      'morning_from' => 
      array (
        'label' => 'Wednesday morning from',
        'placeholder' => '08:00',
        'help' => 'Opening time for Wednesday morning',
      ),
      'morning_to' => 
      array (
        'label' => 'Wednesday morning to',
        'placeholder' => '12:00',
        'help' => 'Closing time for Wednesday morning',
      ),
      'afternoon_from' => 
      array (
        'label' => 'Wednesday afternoon from',
        'placeholder' => '14:00',
        'help' => 'Opening time for Wednesday afternoon',
      ),
      'afternoon_to' => 
      array (
        'label' => 'Wednesday afternoon to',
        'placeholder' => '18:00',
        'help' => 'Closing time for Wednesday afternoon',
      ),
    ),
    'thursday' => 
    array (
      'morning_from' => 
      array (
        'label' => 'Thursday morning from',
        'placeholder' => '08:00',
        'help' => 'Opening time for Thursday morning',
      ),
      'morning_to' => 
      array (
        'label' => 'Thursday morning to',
        'placeholder' => '12:00',
        'help' => 'Closing time for Thursday morning',
      ),
      'afternoon_from' => 
      array (
        'label' => 'Thursday afternoon from',
        'placeholder' => '14:00',
        'help' => 'Opening time for Thursday afternoon',
      ),
      'afternoon_to' => 
      array (
        'label' => 'Thursday afternoon to',
        'placeholder' => '18:00',
        'help' => 'Closing time for Thursday afternoon',
      ),
    ),
    'friday' => 
    array (
      'morning_from' => 
      array (
        'label' => 'Friday morning from',
        'placeholder' => '08:00',
        'help' => 'Opening time for Friday morning',
      ),
      'morning_to' => 
      array (
        'label' => 'Friday morning to',
        'placeholder' => '12:00',
        'help' => 'Closing time for Friday morning',
      ),
      'afternoon_from' => 
      array (
        'label' => 'Friday afternoon from',
        'placeholder' => '14:00',
        'help' => 'Opening time for Friday afternoon',
      ),
      'afternoon_to' => 
      array (
        'label' => 'Friday afternoon to',
        'placeholder' => '18:00',
        'help' => 'Closing time for Friday afternoon',
        'description' => 'friday.afternoon_to',
      ),
    ),
    'saturday' => 
    array (
      'morning_from' => 
      array (
        'label' => 'Saturday morning from',
        'placeholder' => '08:00',
        'help' => 'Opening time for Saturday morning',
        'description' => 'saturday.morning_from',
        'helper_text' => 'saturday.morning_from',
      ),
      'morning_to' => 
      array (
        'label' => 'Saturday morning to',
        'placeholder' => '12:00',
        'help' => 'Closing time for Saturday morning',
        'description' => 'saturday.morning_to',
        'helper_text' => 'saturday.morning_to',
      ),
      'afternoon_from' => 
      array (
        'label' => 'Saturday afternoon from',
        'placeholder' => '14:00',
        'help' => 'Opening time for Saturday afternoon',
        'description' => 'saturday.afternoon_from',
        'helper_text' => 'saturday.afternoon_from',
      ),
      'afternoon_to' => 
      array (
        'label' => 'Saturday afternoon to',
        'placeholder' => '18:00',
        'help' => 'Closing time for Saturday afternoon',
        'description' => 'saturday.afternoon_to',
        'helper_text' => 'saturday.afternoon_to',
      ),
    ),
    'sunday' => 
    array (
      'morning_from' => 
      array (
        'label' => 'Sunday morning from',
        'placeholder' => '08:00',
        'help' => 'Opening time for Sunday morning',
      ),
      'morning_to' => 
      array (
        'label' => 'Sunday morning to',
        'placeholder' => '12:00',
        'help' => 'Closing time for Sunday morning',
      ),
      'afternoon_from' => 
      array (
        'label' => 'Sunday afternoon from',
        'placeholder' => '14:00',
        'help' => 'Opening time for Sunday afternoon',
      ),
      'afternoon_to' => 
      array (
        'label' => 'Sunday afternoon to',
        'placeholder' => '18:00',
        'help' => 'Closing time for Sunday afternoon',
      ),
    ),
    'schedule' => 
    array (
      'label' => 'Schedule',
      'placeholder' => 'Configure opening hours',
      'help' => 'Manage complete availability schedule',
    ),
    'availability' => 
    array (
      'label' => 'Availability',
      'placeholder' => 'Set your availability',
      'help' => 'Configure when you are available for appointments',
    ),
  ),
  'sections' => 
  array (
    'week_schedule' => 
    array (
      'label' => 'Weekly Schedule',
      'description' => 'Configure opening hours for each day of the week',
    ),
    'availability_settings' => 
    array (
      'label' => 'Availability Settings',
      'description' => 'Manage your availability time slots',
    ),
  ),
  'actions' => 
  array (
    'copy_schedule' => 
    array (
      'label' => 'Copy schedule',
      'success' => 'Schedule copied successfully',
      'error' => 'Error copying schedule',
    ),
    'clear_schedule' => 
    array (
      'label' => 'Clear schedule',
      'success' => 'Schedule cleared successfully',
      'confirmation' => 'Are you sure you want to clear all schedules?',
    ),
  ),
  'messages' => 
  array (
    'no_availability' => 'No availability configured',
    'schedule_saved' => 'Schedule saved successfully',
    'invalid_time_range' => 'Invalid time: end time must be after start time',
  ),
);
