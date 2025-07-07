<?php

declare(strict_types=1);

return [
    'login' => [
        'title' => 'Sign in to your account',
        'subtitle' => 'Enter your credentials to access',
        'email' => 'Email address',
        'email_placeholder' => 'example@email.com',
        'password' => 'Password',
        'password_placeholder' => '••••••••',
        'remember' => 'Remember me',
        'submit' => 'Sign in',
        'forgot_password' => 'Forgot your password?',
        'no_account' => 'Don\'t have an account?',
        'register' => 'Sign up',
    ],

    'register' => [
        'title' => 'Create a new account',
        'subtitle' => 'Enter your details to register',
        'name' => 'Full name',
        'name_placeholder' => 'John Doe',
        'email' => 'Email address',
        'email_placeholder' => 'example@email.com',
        'password' => 'Password',
        'password_placeholder' => '••••••••',
        'password_confirmation' => 'Confirm password',
        'password_confirmation_placeholder' => '••••••••',
        'submit' => 'Sign up',
        'already_registered' => 'Already have an account? Sign in',
    ],

    'forgot-password' => [
        'title' => 'Reset your password',
        'subtitle' => 'Enter your email to receive the reset link',
        'email' => 'Email address',
        'email_placeholder' => 'example@email.com',
        'submit' => 'Send reset link',
        'back_to_login' => 'Back to login',
    ],

    'reset-password' => [
        'title' => 'Reset password',
        'subtitle' => 'Enter your new password',
        'email' => 'Email address',
        'email_placeholder' => 'example@email.com',
        'password' => 'New password',
        'password_placeholder' => '••••••••',
        'password_confirmation' => 'Confirm password',
        'password_confirmation_placeholder' => '••••••••',
        'submit' => 'Reset password',
    ],

    'password_reset' => [
        'email_placeholder' => 'Enter your email address',
        'send_button' => 'Send reset link',
        'back_to_login' => 'Back to login',
        'send_another' => 'Send another link',
        'email_sent' => [
            'title' => 'Email sent!',
            'message' => 'We have sent you a password reset link. Check your inbox and follow the instructions.',
        ],
        'email_failed' => [
            'title' => 'Send failed',
            'generic' => 'An error occurred while sending the email. Please try again later.',
        ],
        'password_requirements' => 'Password must be at least 8 characters long',
        'processing' => 'Processing...',
        'instructions' => [
            'title' => 'Reset instructions',
            'description' => 'Enter your email and new password to complete the reset.',
        ],
        'confirm_button' => 'Confirm new password',
        'request_new_link' => 'Request a new link',
        'security' => [
            'title' => 'Security',
            'note' => 'The reset link is valid for 60 minutes and can only be used once.',
        ],
        'success' => [
            'title' => 'Password reset successful!',
            'message' => 'Your password has been updated. You can now log in with your new password.',
            'redirect_notice' => 'Automatic redirect in progress...',
            'go_to_dashboard' => 'Go to dashboard',
            'go_to_login' => 'Go to login',
        ],
        'errors' => [
            'title' => 'Password reset error',
            'invalid_token' => 'The reset link is no longer valid or has expired.',
            'invalid_user' => 'We couldn\'t find a user with this email address.',
            'generic' => 'An error occurred while resetting the password. Please try again later.',
            'possible_causes' => 'Possible causes:',
            'causes' => [
                'expired_token' => 'The reset link has expired (valid for 60 minutes)',
                'invalid_email' => 'The email address doesn\'t match any account',
                'already_used' => 'The reset link has already been used',
            ],
            'try_again' => 'Try again',
        ],
    ],

    'passwords' => [
        'reset' => 'Your password has been reset!',
        'sent' => 'We have emailed your password reset link!',
        'throttled' => 'Please wait before retrying.',
        'token' => 'This password reset token is invalid.',
        'user' => 'We can\'t find a user with that email address.',
    ],

    'login-via' => 'Or log in via',

    'login-failed' => 'Login failed, please try again.',

    'user-not-allowed' => 'Your email is not part of a domain that is allowed.',

    'registration-not-enabled' => 'Registration of a new user is not allowed.',

    'login-in' => 'Sign in',
    'sign-up' => 'Sign up',

    // Basic fields
    'email' => 'Email',
    'password' => 'Password',
    'name' => 'Name',
    'confirm_password' => 'Confirm Password',

    // General auth messages
    'failed' => 'These credentials do not match our records.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
    'general_error' => 'An error occurred. Please try again later.',
    'unauthorized' => 'You do not have the necessary permissions for this operation.',
];
