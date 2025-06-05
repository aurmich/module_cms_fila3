<?php

return [
    'fields' => [
        'id' => [ 'label' => 'ID' ],
        'name' => [ 'label' => 'Name' ],
        'email' => [ 'label' => 'Email' ],
        'type' => [
            'label' => 'Type',
            'options' => [
                'patient' => 'Patient',
                'doctor' => 'Doctor',
                'admin' => 'Admin',
            ],
        ],
        'state' => [
            'label' => 'State',
            'options' => [
                'pending' => 'Pending',
                'approved' => 'Approved',
                'rejected' => 'Rejected',
                'integration_requested' => 'Integration requested',
                'suspended' => 'Suspended',
            ],
        ],
        'phone' => [ 'label' => 'Phone' ],
        'address' => [ 'label' => 'Address' ],
        'city' => [ 'label' => 'City' ],
        'registration_number' => [ 'label' => 'Registration number' ],
        'status' => [ 'label' => 'Status' ],
        'certifications' => [ 'label' => 'Certifications' ],
        'moderation_data' => [ 'label' => 'Moderation data' ],
        'password' => [ 'label' => 'Password' ],
        'password_confirmation' => [ 'label' => 'Password confirmation' ],
        'created_at' => [ 'label' => 'Created at' ],
        'updated_at' => [ 'label' => 'Updated at' ],
    ],
    'actions' => [
        'approve' => 'Approve',
        'reject' => 'Reject',
        'request_integration' => 'Request integration',
    ],
];
