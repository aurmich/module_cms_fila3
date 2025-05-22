<?php

declare(strict_types=1);

return [
    'user_types' => [
        'doctor' => [
            'required_fields' => ['registration_number', 'certifications'],
            'validation_rules' => [
                'registration_number' => 'required|string|unique:users,registration_number',
                'certifications' => 'required|json',
            ],
            'workflow' => [
                'initial_status' => 'pending',
                'steps' => ['document_verification', 'admin_review'],
            ],
        ],
        'patient' => [
            'required_fields' => ['phone'],
            'validation_rules' => [
                'phone' => 'required|string',
            ],
            'workflow' => [
                'initial_status' => 'pending',
                'steps' => ['identity_check'],
            ],
        ],
    ],
];
