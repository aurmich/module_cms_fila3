<?php

declare(strict_types=1);

return [
    'accepted_appointments' => [
        'title' => 'Accepted Appointments',
        'back_home' => 'Back to Home',
        'redirecting' => 'Redirecting...',
        'click_here' => 'click here',
        'if_not_redirected' => 'If you are not redirected automatically, :link.',
    ],
    'hero' => [
        'accepted_appointments' => [
            'title' => 'Accepted Appointments',
            'description' => 'View all appointments that have been confirmed',
            'back_button' => [
                'label' => 'Go back',
                'tooltip' => 'Return to the previous page',
            ],
        ],
        'pending_appointments' => [
            'title' => 'Pending Appointments',
            'description' => 'View all appointments awaiting confirmation',
        ],
        'completed_appointments' => [
            'title' => 'Completed Appointments',
            'description' => 'View all appointments that have been completed',
        ],
        'rejected_appointments' => [
            'title' => 'Rejected Appointments',
            'description' => 'View all appointments that have been rejected',
        ],
        'entry_appointments' => [
            'title' => 'Incoming Appointments',
            'description' => 'Visualizza tutti i nuovi appuntamenti richiesti',
        ],
    ],
    'fields' => [
        'name' => [
            'label' => 'Name',
            'tooltip' => 'Patient\'s full name',
            'helper_text' => '',
        ],
        'date' => [
            'label' => 'Date',
            'tooltip' => 'Appointment date',
            'helper_text' => '',
        ],
        'time' => [
            'label' => 'Time',
            'tooltip' => 'Appointment time',
            'helper_text' => '',
        ],
        'phone' => [
            'label' => 'Phone',
            'tooltip' => 'Patient\'s phone number',
            'helper_text' => '',
        ],
        'email' => [
            'label' => 'Email',
            'tooltip' => 'Patient\'s email address',
            'helper_text' => '',
        ],
        'notes' => [
            'label' => 'Notes',
            'tooltip' => 'Additional notes or comments',
            'helper_text' => '',
        ],
        'emergency' => [
            'label' => 'Emergency',
            'tooltip' => 'Indicates if the appointment is urgent',
            'helper_text' => 'Emergency appointments are prioritized',
        ],
        'state' => [
            'label' => 'Status',
            'tooltip' => 'Status',
            'helper_text' => '',
        ],
    ],
    'appointment_details' => 'Appointment Details',
    'modals' => [
        'confirm_appointment' => [
            'title' => [
                'label' => 'Accept Appointment',
                'tooltip' => 'Confirm the acceptance of the appointment',
                'helper_text' => '',
            ],
            'message' => [
                'label' => 'Are you sure you want to accept the appointment with',
                'tooltip' => 'Confirmation message for acceptance',
                'helper_text' => '',
            ],
            'buttons' => [
                'confirm' => [
                    'label' => 'Accept',
                    'tooltip' => 'Confirm the acceptance of the appointment',
                    'helper_text' => '',
                ],
                'cancel' => [
                    'label' => 'Cancel',
                    'tooltip' => 'Cancel the operation',
                    'helper_text' => '',
                ],
            ],
        ],
        'reject_appointment' => [
            'title' => [
                'label' => 'Reject Appointment',
                'tooltip' => 'Reject the selected appointment',
                'helper_text' => '',
            ],
            'message' => [
                'label' => 'Are you sure you want to reject the appointment with',
                'tooltip' => 'Confirmation message for rejection',
                'helper_text' => '',
            ],
            'buttons' => [
                'confirm' => [
                    'label' => 'Reject',
                    'tooltip' => 'Confirm the rejection of the appointment',
                    'helper_text' => '',
                ],
                'cancel' => [
                    'label' => 'Cancel',
                    'tooltip' => 'Cancel the operation',
                    'helper_text' => '',
                ],
            ],
        ],
    ],
    'buttons' => [
        'close' => 'Close',
        'back' => 'Go back',
        'save' => 'Save',
        'cancel' => 'Cancel',
        'submit' => 'Submit',
    ],
    'report' => [
        'ready_title' => 'Your report is ready!',
        'download_button' => 'Download report!',
        'download_tooltip' => 'Click to download the medical report',
        'not_available' => 'Report not yet available',
        'processing' => 'Report being processed',
        'error' => 'Error loading the report',
        'generated_by' => 'Generated by',
        'pdf_title' => 'Appointment Report',
        'fields' => [
            'date' => [
                'label' => 'Date',
                'tooltip' => 'Appointment date',
                'helper_text' => 'Date in dd/mm/yyyy format',
            ],
            'time' => [
                'label' => 'Time',
                'tooltip' => 'Appointment time',
                'helper_text' => 'Time in hh:mm format',
            ],
            'full_name' => [
                'label' => 'Full Name',
                'tooltip' => 'First and last name',
                'helper_text' => 'Complete name',
            ],
            'email' => [
                'label' => 'Email',
                'tooltip' => 'Email address',
                'helper_text' => 'Email for contacts',
            ],
            'phone' => [
                'label' => 'Phone',
                'tooltip' => 'Phone number',
                'helper_text' => 'Phone for urgent contacts',
            ],
            'date_of_birth' => [
                'label' => 'Date of Birth',
                'tooltip' => 'Date of birth',
                'helper_text' => 'Date in dd/mm/yyyy format',
            ],
            'specialization' => [
                'label' => 'Specialization',
                'tooltip' => 'Doctor specialization',
                'helper_text' => 'Area of expertise',
            ],
            'patient' => [
                'full_name' => [
                    'label' => 'Full Name',
                    'tooltip' => 'Patient full name',
                    'helper_text' => 'First and last name',
                ],
                'email' => [
                    'label' => 'Email',
                    'tooltip' => 'Patient email address',
                    'helper_text' => 'Email for contacts',
                ],
                'phone' => [
                    'label' => 'Phone',
                    'tooltip' => 'Patient phone number',
                    'helper_text' => 'Phone for urgent contacts',
                ],
                'date_of_birth' => [
                    'label' => 'Date of Birth',
                    'tooltip' => 'Patient date of birth',
                    'helper_text' => 'Date in dd/mm/yyyy format',
                ],
            ],
            'doctor' => [
                'full_name' => [
                    'label' => 'Full Name',
                    'tooltip' => 'Doctor full name',
                    'helper_text' => 'First and last name',
                ],
                'email' => [
                    'label' => 'Email',
                    'tooltip' => 'Doctor email address',
                    'helper_text' => 'Email for contacts',
                ],
                'phone' => [
                    'label' => 'Phone',
                    'tooltip' => 'Doctor phone number',
                    'helper_text' => 'Phone for urgent contacts',
                ],
                'specialization' => [
                    'label' => 'Specialization',
                    'tooltip' => 'Doctor specialization',
                    'helper_text' => 'Area of expertise',
                ],
            ],
            'studio' => [
                'name' => [
                    'label' => 'Studio Name',
                    'tooltip' => 'Medical studio name',
                    'helper_text' => 'Complete studio name',
                ],
                'address' => [
                    'label' => 'Address',
                    'tooltip' => 'Studio address',
                    'helper_text' => 'Complete address',
                ],
                'full_address' => [
                    'label' => 'Full Address',
                    'tooltip' => 'Complete studio address',
                    'helper_text' => 'Complete address with ZIP and city',
                ],
                'phone' => [
                    'label' => 'Phone',
                    'tooltip' => 'Studio phone number',
                    'helper_text' => 'Phone for contacts',
                ],
                'email' => [
                    'label' => 'Email',
                    'tooltip' => 'Studio email address',
                    'helper_text' => 'Email for contacts',
                ],
            ],
        ],
        'sections' => [
            'appointment_info' => [
                'label' => 'Appointment Information',
                'tooltip' => 'Details about the appointment',
                'helper_text' => 'Date, time and appointment details',
            ],
            'patient_info' => [
                'label' => 'Patient Information',
                'tooltip' => 'Patient personal data',
                'helper_text' => 'Name, contacts and personal information',
            ],
            'doctor_info' => [
                'label' => 'Doctor Information',
                'tooltip' => 'Attending physician data',
                'helper_text' => 'Name, specialization and contacts',
            ],
            'studio_info' => [
                'label' => 'Medical Studio Information',
                'tooltip' => 'Medical studio data',
                'helper_text' => 'Name, address and studio contacts',
            ],
            'notes' => [
                'label' => 'Appointment Notes',
                'tooltip' => 'Additional notes related to the appointment',
                'helper_text' => 'Supplementary information',
            ],
            'medical_report' => [
                'label' => 'Medical Report',
                'tooltip' => 'Complete patient medical report',
                'helper_text' => 'Clinical and diagnostic data',
            ],
            'medical_conditions' => [
                'label' => 'Medical Conditions',
                'tooltip' => 'Patient general health status',
                'helper_text' => 'Pathologies and clinical conditions',
            ],
            'oral_hygiene' => [
                'label' => 'Oral Hygiene',
                'tooltip' => 'Patient oral hygiene habits',
                'helper_text' => 'Brushing frequency and habits',
            ],
            'pregnancy_info' => [
                'label' => 'Pregnancy Information',
                'tooltip' => 'Data related to pregnancy status',
                'helper_text' => 'Gestation month and week',
            ],
        ],
        'labels' => [
            'date' => 'Date',
            'time' => 'Time',
            'state' => 'Status',
            'duration' => 'Duration',
            'full_name' => 'Full Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'date_of_birth' => 'Date of Birth',
            'specialization' => 'Specialization',
            'studio_name' => 'Studio Name',
            'address' => 'Address',
            'emergency_label' => 'EMERGENCY',
            'frequency' => 'Frequency',
            'details' => 'Details',
            'specify' => 'Specify',
            'additional_info' => 'Additional Info',
            'pregnancy_info' => 'Pregnancy Information',
            'month' => 'Month',
            'week' => 'Week',
        ],
    ],
    'actions' => [
        'book' => [
            'label' => 'Book an appointment',
            'tooltip' => 'Button to book an appointment',
            'helper_text' => '',
        ],
    ],
];
