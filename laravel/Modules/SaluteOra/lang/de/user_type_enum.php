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
        'label' => 'Arzt',
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
        'patient' => 'Empfänger von Gesundheitsdienstleistungen',
        'doctor' => 'Medizinischer Fachmann',
        'admin' => 'Systemadministrator',
    ],
    'plural' => [
        'patient' => 'Patienten',
        'doctor' => 'Ärzte',
        'admin' => 'Administratoren',
    ],
];
