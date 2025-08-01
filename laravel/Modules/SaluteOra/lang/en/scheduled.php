<?php

declare(strict_types=1);

return [
    'label' => 'Scheduled',
    'description' => 'Element scheduled for a specific date',
    'tooltip' => 'The element has been scheduled and is awaiting execution',
    'color' => 'info',
    'bg_color' => '#3b82f6',
    'icon' => 'heroicon-o-calendar',
    
    'actions' => [
        'reschedule' => [
            'label' => 'Reschedule',
            'confirmation' => 'Are you sure you want to reschedule this element?',
            'success' => 'Element rescheduled successfully',
            'error' => 'Error during rescheduling',
        ],
        'execute_now' => [
            'label' => 'Execute Now',
            'confirmation' => 'Are you sure you want to execute this element immediately?',
            'success' => 'Element executed successfully',
            'error' => 'Error during execution',
        ],
        'cancel_schedule' => [
            'label' => 'Cancel Schedule',
            'confirmation' => 'Are you sure you want to cancel the schedule?',
            'success' => 'Schedule cancelled',
            'error' => 'Error during cancellation',
        ],
        'view_schedule' => [
            'label' => 'View Schedule',
            'tooltip' => 'View schedule details',
        ],
    ],
    
    'modal' => [
        'heading' => 'Scheduled Element',
        'description' => 'This element is scheduled to be executed on a specific date. You can modify the schedule or execute it immediately.',
        'confirm' => 'Confirm',
        'cancel' => 'Cancel',
    ],
    
    'messages' => [
        'scheduled_for' => 'Scheduled for',
        'execution_pending' => 'Execution pending',
        'reminder_sent' => 'Reminder sent',
        'time_remaining' => 'Time remaining',
    ],
    
    'fields' => [
        'message' => [
            'label' => 'Schedule Message',
            'placeholder' => 'Enter a message for the schedule',
            'helper_text' => '',
            'description' => 'Informational message about the element schedule',
        ],
        'scheduled_date' => [
            'label' => 'Scheduled Date',
            'placeholder' => 'Select execution date',
            'helper_text' => '',
            'description' => 'Date and time when the element is scheduled to be executed',
        ],
        'reminder_date' => [
            'label' => 'Reminder Date',
            'placeholder' => 'Select when to send reminder',
            'helper_text' => '',
            'description' => 'Date to send a reminder before execution',
        ],
        'priority' => [
            'label' => 'Priority',
            'placeholder' => 'Select priority',
            'helper_text' => '',
            'description' => 'Priority level of the scheduled element',
        ],
        'notes' => [
            'label' => 'Notes',
            'placeholder' => 'Enter additional notes',
            'helper_text' => '',
            'description' => 'Additional notes about the schedule',
        ],
    ],
];