<?php

declare(strict_types=1);

return [
    'fields' => [
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Enter your email',
            'help' => 'Your email address for authentication',
        ],
        'password' => [
            'label' => 'Password',
            'placeholder' => 'Enter your password',
            'help' => 'Your account password',
        ],
    ],
    'actions' => [
        'login' => [
            'label' => 'Sign in',
            'success' => 'Login successful',
            'error' => 'Invalid credentials',
        ],
        'logout' => [
            'label' => 'Logout',
            'success' => 'Logout successful',
            'error' => 'Logout failed',
        ],
    ],
    'messages' => [
        'failed' => 'These credentials do not match our records.',
        'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
        'unauthorized' => 'You are not authorized to access this resource.',
    ],
];
