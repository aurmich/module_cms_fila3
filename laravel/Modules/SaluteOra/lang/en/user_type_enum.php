<?php

declare(strict_types=1);

return [
    'admin' => [
        'label' => 'Administrator',
        'color' => 'danger',
        'icon' => 'heroicon-o-shield-check',
        'image' => '/img/admin.jpg',
    ],
    'doctor' => [
        'label' => 'Doctor',
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
        'doctor' => 'Healthcare professional',
        'admin' => 'System administrator',
    ],
    'plural' => [
        'patient' => 'Patients',
        'doctor' => 'Doctors',
        'admin' => 'Administrators',
    ],
];
