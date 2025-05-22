<?php

return [
    'resources' => [
        'doctor' => [
            'label' => [
                'singular' => 'Dottore',
                'plural' => 'Dottori',
            ],
            'fields' => [
                'name' => [
                    'label' => 'Nome',
                    'placeholder' => 'Inserisci il nome',
                ],
                'email' => [
                    'label' => 'Email',
                    'placeholder' => 'Inserisci l\'email',
                ],
                'phone' => [
                    'label' => 'Telefono',
                    'placeholder' => 'Inserisci il numero di telefono',
                ],
                'specialties' => [
                    'label' => 'Specializzazioni',
                    'placeholder' => 'Seleziona le specializzazioni',
                ],
            ],
            'navigation' => [
                'label' => 'Dottori',
                'icon' => 'heroicon-o-user-group',
                'group' => 'Gestione Personale',
            ],
        ],
    ],
]; 