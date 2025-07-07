<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    */
    'login' => [
        'title' => 'Sign in to your account',
        'or' => 'or',
        'create_account' => 'create a new account',
        'forgot_password' => 'Forgot your password?',
        'back_to_login' => 'return to login',
        'email' => 'Email address',
        'password' => 'Password',
        'remember_me' => 'Remember me',
        'login_button' => 'Sign in',
    ],

    'register' => [
        'title' => 'Create your account',
        'welcome_message' => 'Welcome to <span class="font-bold">SaluteOra</span>',
        'description' => 'Create your account to access all services',
        'already_have_account' => 'Already have an account?',
        'login_link' => 'sign in here',
        'register_button' => 'Register',
    ],

    'password' => [
        'reset' => [
            'title' => 'Reset password',
            'subtitle' => 'Enter your email address to receive the password reset link',
            'description' => 'Enter your email address to receive the password reset link',
            'email_label' => 'Email address',
            'email_placeholder' => 'Enter your email',
            'send_button' => 'Send password reset link',
            'back_to_login' => 'return to login',
            'or' => 'or',
            'email_sent' => 'Password reset link sent!',
            'email_sent_title' => 'Email sent successfully',
            'email_sent_message' => 'Check your inbox and follow the instructions to reset your password.',
            'check_email_status' => 'Check email',
            'breadcrumb' => [
                'request' => 'Reset request',
                'confirm' => 'Confirm password',
            ],
            'info' => [
                'security' => [
                    'title' => 'Security guaranteed',
                    'description' => 'The reset link is encrypted and valid for only 60 minutes. No one can access your account without this link.',
                ],
                'password' => [
                    'title' => 'New password',
                    'description' => 'Choose a secure password with at least 8 characters, including letters, numbers, and symbols.',
                ],
                'expiry' => [
                    'title' => 'Link expiry',
                    'description' => 'The reset link automatically expires after 60 minutes for security reasons.',
                ],
            ],
            'confirm' => [
                'title' => 'Set new password',
                'subtitle' => 'Enter your email and new password to complete the reset',
            ],
            'help' => [
                'having_trouble' => 'Having trouble with reset?',
            ],
        ],
    ],

    'password-reset' => [
        'submit' => [
            'label' => 'Send password reset link',
        ],
    ],

    'confirm' => [
        'title' => 'Confirm password',
        'description' => 'Enter your password to confirm your identity',
    ],

    'new' => [
        'title' => 'New password',
        'password_label' => 'New password',
        'confirm_password_label' => 'Confirm new password',
        'update_button' => 'Update password',
    ],

    'verify' => [
        'title' => 'Verify your account',
        'description' => 'We\'ve sent you a verification email. Please check your inbox.',
        'resend_button' => 'Resend',
        'change_email' => 'Change email address',
    ],

    'logout' => [
        'title' => 'Logout',
        'message' => 'You have been successfully logged out',
        'redirect_message' => 'Redirecting...',
    ],

    'thank_you' => [
        'title' => 'Thank you for registering',
        'message' => 'Your account has been created successfully',
        'continue_button' => 'Continue',
    ],

    'actions' => [
        'processing' => 'Processing...',
        'sending' => 'Sending...',
        'refresh' => 'Refresh page',
    ],

    'errors' => [
        'loading_failed' => 'Loading failed',
        'please_refresh' => 'An error occurred. Please refresh the page and try again.',
    ],
]; 