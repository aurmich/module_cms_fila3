<?php

return [
    'fields' => [
        'name' => [
            'label' => 'Nome',
        ],
        'email' => [
            'label' => 'Email',
        ],
        'type' => [
            'label' => 'Tipo',
            'options' => [
                'patient' => 'Paziente',
                'doctor' => 'Dottore',
                'admin' => 'Admin',
            ],
        ],
        'state' => [
            'label' => 'Stato',
            'options' => [
                'pending' => 'In attesa',
                'approved' => 'Approvato',
                'rejected' => 'Rifiutato',
                'integration_requested' => 'Integrazione richiesta',
                'suspended' => 'Sospeso',
            ],
        ],
        'phone' => [
            'label' => 'Telefono',
        ],
        'address' => [
            'label' => 'Indirizzo',
        ],
        'city' => [
            'label' => 'Città',
        ],
        'registration_number' => [
            'label' => 'Numero di registrazione',
        ],
        'status' => [
            'label' => 'Stato',
        ],
        'certifications' => [
            'label' => 'Certificazioni',
        ],
        'moderation_data' => [
            'label' => 'Dati di moderazione',
        ],
        'password' => [
            'label' => 'Password',
        ],
        'password_confirmation' => [
            'label' => 'Conferma password',
        ],
    ],
    'actions' => [
        'approve' => [
            'label' => 'Approva',
            'icon' => 'heroicon-o-check',
            'color' => 'success',
        ],
        'reject' => [
            'label' => 'Rifiuta',
            'icon' => 'heroicon-o-x-mark',
            'color' => 'danger',
        ],
        'request_integration' => [
            'label' => 'Richiedi integrazione',
            'icon' => 'heroicon-o-arrow-path',
            'color' => 'warning',
        ],
    ],
]; 