<?php

declare(strict_types=1);

return [
    'name' => 'Appointments',
    
    'navigation' => [
        'label' => 'Appointment Calendar',
        'group' => 'Schedule',
        'icon' => 'heroicon-o-calendar-days',
        'color' => 'sky',
        'sort' => 1,
        'tooltip' => 'View and manage all appointments and visits',
    ],

    'model' => [
        'label' => 'Appointment',
        'plural' => 'Appointments',
        'description' => 'Management of medical appointments and visits',
    ],

    'pages' => [
        'index' => [
            'title' => 'Appointments',
            'subtitle' => 'Manage all appointments',
            'description' => 'View and manage the medical appointment calendar',
        ],
        'create' => [
            'title' => 'New Appointment',
            'subtitle' => 'Create a new appointment',
            'description' => 'Book a new appointment for a patient',
        ],
        'edit' => [
            'title' => 'Edit Appointment',
            'subtitle' => 'Update appointment details',
            'description' => 'Modify information for the selected appointment',
        ],
        'availability' => [
            'title' => 'Availability Management',
            'heading' => 'Availability Calendar',
            'subheading' => 'Manage your availability and approve appointments',
            'description' => 'Create availability slots to allow patients to book appointments and manage existing appointments.',
        ],
    ],

    'fields' => [
        'title' => [
            'label' => 'Title',
            'placeholder' => 'Enter a title for the appointment',
            'helper_text' => '',
        ],
        'patient_id' => [
            'label' => 'Patient',
            'placeholder' => 'Select the patient',
            'helper_text' => '',
        ],
        'doctor_id' => [
            'label' => 'Doctor',
            'placeholder' => 'Select the doctor',
            'helper_text' => '',
        ],
        'dentist_id' => [
            'label' => 'Dentist',
            'placeholder' => 'Select the dentist',
            'helper_text' => '',
        ],
        'studio_id' => [
            'label' => 'Studio',
            'placeholder' => 'Select the studio',
            'helper_text' => '',
        ],
        'start_time' => [
            'label' => 'Start Time',
            'placeholder' => 'Select the start time',
            'helper_text' => '',
        ],
        'end_time' => [
            'label' => 'End Time',
            'placeholder' => 'Select the end time',
            'helper_text' => '',
        ],
        'treatment_id' => [
            'label' => 'Treatment',
            'placeholder' => 'Select a treatment',
            'helper_text' => '',
        ],
        'status' => [
            'label' => 'Status',
            'placeholder' => 'Select the status',
            'helper_text' => '',
            'options' => [
                'scheduled' => 'Scheduled',
                'confirmed' => 'Confirmed',
                'completed' => 'Completed',
                'cancelled' => 'Cancelled',
                'no_show' => 'No Show',
            ],
        ],
        'type' => [
            'label' => 'Appointment Type',
            'placeholder' => 'Select the type',
            'helper_text' => '',
            'options' => [
                'consultation' => 'Consultation',
                'follow_up' => 'Follow-up',
                'treatment' => 'Treatment',
                'surgery' => 'Surgery',
                'emergency' => 'Emergency',
            ],
        ],
        'notes' => [
            'label' => 'Notes',
            'placeholder' => 'Enter any notes',
            'helper_text' => '',
        ],
        'reason' => [
            'label' => 'Reason',
            'placeholder' => 'Enter the reason for the appointment',
            'helper_text' => '',
        ],
        'emergency' => [
            'label' => 'Emergency',
            'placeholder' => 'Indicate if this is an emergency',
            'helper_text' => '',
        ],
        'eligibility_confirmed' => [
            'label' => 'Eligibility Confirmed',
            'placeholder' => 'Confirm eligibility',
            'helper_text' => '',
        ],
        'created_at' => [
            'label' => 'Creation Date',
            'placeholder' => 'Appointment creation date',
            'helper_text' => '',
        ],
    ],

    'actions' => [
        'create' => [
            'label' => 'New Appointment',
            'tooltip' => 'Create a new appointment',
            'modal_heading' => 'New Appointment',
            'modal_description' => 'Fill in the details to create a new appointment',
            'success' => 'Appointment created successfully',
            'error' => 'Error during appointment creation',
        ],
        'edit' => [
            'label' => 'Edit',
            'tooltip' => 'Edit appointment details',
            'modal_heading' => 'Edit Appointment',
            'modal_description' => 'Update appointment details',
            'success' => 'Appointment updated successfully',
            'error' => 'Error during appointment update',
        ],
        'delete' => [
            'label' => 'Delete',
            'tooltip' => 'Remove this appointment',
            'confirmation' => 'Are you sure you want to delete this appointment? This action cannot be undone.',
            'success' => 'Appointment deleted successfully',
            'error' => 'Error during appointment deletion',
        ],
        'view' => [
            'label' => 'View',
            'tooltip' => 'View appointment details',
            'modal_heading' => 'Appointment Details',
        ],
        'confirm' => [
            'label' => 'Confirm',
            'tooltip' => 'Confirm this appointment',
            'success' => 'Appointment confirmed successfully',
            'error' => 'Error during appointment confirmation',
        ],
        'cancel' => [
            'label' => 'Cancel',
            'tooltip' => 'Cancel this appointment',
            'confirmation' => 'Are you sure you want to cancel this appointment?',
            'success' => 'Appointment cancelled successfully',
            'error' => 'Error during appointment cancellation',
        ],
        'reschedule' => [
            'label' => 'Reschedule',
            'tooltip' => 'Change appointment date and time',
            'modal_heading' => 'Reschedule Appointment',
            'modal_description' => 'Select a new date and time',
            'success' => 'Appointment rescheduled successfully',
            'error' => 'Error during appointment rescheduling',
        ],
        'mark_completed' => [
            'label' => 'Complete',
            'tooltip' => 'Mark as completed',
            'confirmation' => 'Are you sure you want to mark this appointment as completed?',
            'success' => 'Appointment completed successfully',
            'error' => 'Error during appointment completion',
        ],
        'mark_no_show' => [
            'label' => 'No Show',
            'tooltip' => 'Mark as no show',
            'confirmation' => 'Are you sure you want to mark this patient as no show?',
            'success' => 'Patient marked as no show',
            'error' => 'Error during status update',
        ],
        'legend' => [
            'label' => 'Legend',
            'modal_heading' => 'Calendar Legend',
            'modal_description' => 'Explanation of colors and symbols used',
        ],
    ],

    'filters' => [
        'today' => [
            'label' => 'Today',
            'description' => 'Today\'s appointments',
        ],
        'upcoming' => [
            'label' => 'Upcoming',
            'description' => 'Future appointments',
        ],
        'past' => [
            'label' => 'Past',
            'description' => 'Past appointments',
        ],
        'by_status' => [
            'label' => 'By Status',
            'placeholder' => 'Filter by status',
            'helper_text' => '',
        ],
        'by_doctor' => [
            'label' => 'By Doctor',
            'placeholder' => 'Select a doctor',
            'helper_text' => '',
        ],
        'by_date_range' => [
            'label' => 'By Date Range',
            'placeholder' => 'Select the range',
            'helper_text' => '',
        ],
    ],

    'calendar' => [
        'title' => 'Appointment Calendar',
        'today' => 'Today',
        'month' => 'Month',
        'week' => 'Week',
        'day' => 'Day',
        'list' => 'List',
        'next' => 'Next',
        'previous' => 'Previous',
        'day_view' => 'Day View',
        'week_view' => 'Week View',
        'month_view' => 'Month View',
    ],

    'availability' => [
        'title' => 'Availability',
        'add' => 'Add Availability',
        'edit' => 'Edit Availability',
        'delete' => 'Delete Availability',
        'create_success' => 'Availability created successfully',
        'update_success' => 'Availability updated successfully',
        'delete_success' => 'Availability deleted successfully',
    ],

    'legend' => [
        'description' => 'Legend of colors and icons used in the calendar.',
        'types' => 'Event Types',
        'icons' => 'Icon Meanings',
        'availability' => 'Availability',
        'pending' => 'Pending appointment',
        'confirmed' => 'Confirmed appointment',
        'completed' => 'Completed appointment',
        'cancelled' => 'Cancelled appointment',
        'availability_icon' => 'Availability slot',
        'pending_icon' => 'Appointment pending confirmation',
        'confirmed_icon' => 'Confirmed appointment',
        'completed_icon' => 'Completed appointment',
        'cancelled_icon' => 'Cancelled appointment',
        'instructions' => 'Instructions',
        'instruction_add' => 'Click on an empty slot or the \'+\' button to add new availability.',
        'instruction_edit' => 'Click on an existing event to edit it or change its status.',
        'instruction_delete' => 'In the edit options, click \'Delete\' to remove an availability or unconfirmed appointment.',
        'instruction_approve' => 'To approve an appointment, change status from \'Pending\' to \'Confirmed\'.',
    ],

    'notifications' => [
        'reminder' => [
            'title' => 'Appointment Reminder',
            'body' => 'You have an appointment with :doctor in :time hours',
        ],
        'confirmation' => [
            'title' => 'Appointment Confirmed',
            'body' => 'Your appointment with :doctor for :date has been confirmed',
        ],
        'cancellation' => [
            'title' => 'Appointment Cancelled',
            'body' => 'Your appointment with :doctor for :date has been cancelled',
        ],
    ],

    'messages' => [
        'created' => 'Appointment created successfully',
        'updated' => 'Appointment updated successfully',
        'deleted' => 'Appointment deleted successfully',
        'confirmed' => 'Appointment confirmed successfully',
        'cancelled' => 'Appointment cancelled successfully',
        'completed' => 'Appointment completed successfully',
        'rescheduled' => 'Appointment rescheduled successfully',
        'conflict' => 'Another appointment already exists at this time',
        'unavailable_slot' => 'This time slot is not available for the selected doctor',
        'past_date' => 'Cannot schedule appointments in the past',
        'unavailable' => 'The doctor is not available at this time',
        'availability_created' => 'Availability created successfully',
        'availability_updated' => 'Availability updated successfully',
        'availability_deleted' => 'Availability deleted successfully',
        'appointment_updated' => 'Appointment updated successfully',
    ],

    'validation' => [
        'required' => 'The :attribute field is required',
        'date' => 'The :attribute field must be a valid date',
        'after' => 'The :attribute field must be after :date',
        'before' => 'The :attribute field must be before :date',
        'time_conflict' => 'An appointment already exists at this time',
        'past_appointment' => 'Cannot create appointments in the past',
        'doctor_unavailable' => 'The doctor is not available at the selected time',
    ],

    'empty_state' => [
        'heading' => 'No appointments found',
        'description' => 'There are no appointments for the selected criteria',
        'action' => 'Create the first appointment',
    ],
    'states' => [
        'confirmed' => [
            'label' => 'Conferma',
            'color' => 'success',
            'icon' => 'heroicon-o-check-circle',
            'modal_heading' => 'Accetta appuntamento',
            'modal_description' => 'Sei sicuro di voler accettare questo appuntamento?',
        ],
        'rejected' => [
            'label' => 'Rifiuta',
            'color' => 'danger',
            'icon' => 'heroicon-o-x-mark',
            'modal_heading' => 'Rifiuta appuntamento',
            'modal_description' => 'Sei sicuro di voler rifiutare questo appuntamento?',
        ],
    ],
];
