<?php

declare(strict_types=1);

return [
    'fields' => [
        'name' => [
            'label' => 'Name',
            'placeholder' => 'Enter the name',
            'tooltip' => 'User\'s full name'
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Enter the email',
            'tooltip' => 'User\'s email address'
        ],
        'password' => [
            'label' => 'Password',
            'placeholder' => 'Enter the password',
            'tooltip' => 'User\'s password'
        ],
        'state' => [
            'label' => 'State',
            'placeholder' => 'Select the state',
            'tooltip' => 'User\'s state'
        ]
    ],
    'actions' => [
        'create' => [
            'label' => 'Create User',
            'icon' => 'heroicon-o-plus',
            'color' => 'primary'
        ],
        'edit' => [
            'label' => 'Edit',
            'icon' => 'heroicon-o-pencil',
            'color' => 'warning'
        ],
        'delete' => [
            'label' => 'Delete',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger'
        ]
    ]
]; 