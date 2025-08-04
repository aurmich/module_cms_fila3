<?php

declare(strict_types=1);

return [
    'admin' => [
        'label' => 'Amministratore',
        'color' => 'danger',
        'icon' => 'heroicon-o-shield-check',
        'image' => '/img/admin.jpg',
    ],
    'doctor' => [
        'label' => 'Odontoiatra',
        'color' => 'primary',
        'icon' => 'heroicon-o-user-circle',
        'image' => '/img/dentist.png',
    ],
    'patient' => [
        'label' => 'Paziente',
        'color' => 'success',
        'icon' => 'heroicon-o-user',
        'image' => '/img/donna-personaggio.png',
    ],
    'descriptions' => [
        'patient' => 'Destinatario di servizi sanitari',
        'doctor' => 'Professionista sanitario',
        'admin' => 'Amministratore di sistema',
    ],
    'plural' => [
        'patient' => 'Pazienti',
        'doctor' => 'Dottori',
        'admin' => 'Amministratori',
    ],
];
