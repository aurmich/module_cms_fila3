<?php

return [
    'fields' => [
        'id' => [ 'label' => 'ID' ],
        'name' => [ 'label' => 'Nome' ],
        'email' => [ 'label' => 'Email' ],
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
        'phone' => [ 'label' => 'Telefono' ],
        'address' => [ 'label' => 'Indirizzo' ],
        'city' => [ 'label' => 'Città' ],
        'registration_number' => [ 'label' => 'Numero iscrizione' ],
        'status' => [ 'label' => 'Status' ],
        'certifications' => [ 'label' => 'Certificazioni' ],
        'moderation_data' => [ 'label' => 'Dati moderazione' ],
        'password' => [ 'label' => 'Password' ],
        'password_confirmation' => [ 'label' => 'Conferma password' ],
        'created_at' => [ 'label' => 'Creato il' ],
        'updated_at' => [ 'label' => 'Aggiornato il' ],
    ],
    'actions' => [
        'approve' => 'Approva',
        'reject' => 'Rifiuta',
        'request_integration' => 'Richiedi integrazione',
    ],
];
