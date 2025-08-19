<?php

declare(strict_types=1);

return [
    'admin' => [
        'label' => 'Administrator',
        'color' => 'danger',
        'icon' => 'heroicon-o-shield-check',
        'image' => '/img/admin.jpg',
    ],
    'dentist' => [
        'label' => 'Dentist',
        'color' => 'primary',
        'icon' => 'heroicon-o-user-circle',
        'image' => '/img/dentist.png',
    ],
    'patient' => [
        'label' => 'Patient',
        'color' => 'success',
        'icon' => 'heroicon-o-user',
        'image' => '/img/donna-personaggio.png',
    ],
    'descriptions' => [
        'patient' => 'Healthcare service recipient',
        'dentist' => 'Healthcare professional',
        'admin' => 'System administrator',
    ],
    'plural' => [
        'patient' => 'Patients',
        'dentist' => 'Doctors',
        'admin' => 'Administrators',
    ],
];
