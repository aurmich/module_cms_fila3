<?php

declare(strict_types=1);

return [
    'ready_title' => 'Report Ready',
    'pdf_title' => 'Appointment Report',
    'download_tooltip' => 'Download the report in PDF format',
    'download_button' => 'Download Report',
    
    'labels' => [
        'emergency_label' => 'Emergency',
        'frequency' => 'Frequency',
        'month' => 'Month',
        'week' => 'Week',
        'details' => 'Details',
        'specify' => 'Specify',
        'additional_info' => 'Additional information',
    ],
    
    'sections' => [
        'notes' => [
            'label' => 'Notes',
        ],
        'medical_report' => [
            'label' => 'Medical Report',
        ],
        'medical_conditions' => [
            'label' => 'Medical Conditions',
        ],
        'pregnancy_info' => [
            'label' => 'Pregnancy Information',
        ],
        'oral_hygiene' => [
            'label' => 'Oral Hygiene',
        ],
        'patient_info' => [
            'label' => 'Patient Information',
        ],
        'doctor_info' => [
            'label' => 'Doctor Information',
        ],
        'studio_info' => [
            'label' => 'Studio Information',
        ],
        'appointment_info' => [
            'label' => 'Appointment Information',
            'tooltip' => 'Appointment details',
            'helper_text' => 'Date, time and status',
        ],
    ],
    
    'fields' => [
        'date' => [
            'label' => 'Date',
            'tooltip' => 'Appointment date',
            'helper_text' => 'Format: dd/mm/yyyy',
        ],
        'time' => [
            'label' => 'Time',
        ],
        'has_mouth_or_teeth_pain' => [
            'label' => 'Do you have mouth or teeth pain?',
        ],
        'teeth_brushing_frequency' => [
            'label' => 'Teeth brushing frequency',
        ],
        'smokes' => [
            'label' => 'Do you smoke?',
        ],
        'has_diseases' => [
            'label' => 'Do you have any diseases?',
        ],
        'follows_diet_rules' => [
            'label' => 'Do you follow dietary rules?',
        ],
        'uses_asl_clinic_for_dental_care' => [
            'label' => 'Do you use ASL clinic for dental care?',
        ],
        'missing_teeth' => [
            'label' => 'Do you have missing teeth?',
        ],
        'decayed_teeth' => [
            'label' => 'Do you have decayed teeth?',
        ],
        'has_fixed_prosthesis_or_implants' => [
            'label' => 'Do you have fixed prosthesis or implants?',
        ],
        'has_tartar' => [
            'label' => 'Do you have tartar?',
        ],
        'has_plaque' => [
            'label' => 'Do you have plaque?',
        ],
        'needs_more_dental_care' => [
            'label' => 'Do you need additional dental care?',
        ],
        'further_notes' => [
            'label' => 'Further notes',
        ],
        'patient' => [
            'full_name' => [
                'label' => 'Full name',
                'tooltip' => 'Patient first and last name',
                'helper_text' => 'Complete name',
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
                'label' => 'Date of birth',
                'tooltip' => 'Patient date of birth',
                'helper_text' => 'Date in dd/mm/yyyy format',
            ],
        ],
        'doctor' => [
            'full_name' => [
                'label' => 'Full name',
                'tooltip' => 'Doctor first and last name',
                'helper_text' => 'Complete name',
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
                'label' => 'Studio name',
                'tooltip' => 'Medical studio name',
                'helper_text' => 'Complete studio name',
            ],
            'full_address' => [
                'label' => 'Full address',
                'tooltip' => 'Complete studio address',
                'helper_text' => 'Street, city, ZIP and province',
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
]; 