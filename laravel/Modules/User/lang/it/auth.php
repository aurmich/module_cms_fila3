<?php

declare(strict_types=1);

return [
    // Messaggi generali di autenticazione
    'failed' => 'Credenziali non valide.',
    'password' => 'La password inserita non è corretta.',
    'throttle' => 'Troppi tentativi di accesso. Riprova fra :seconds secondi.',
    'general_error' => 'Si è verificato un errore. Riprova più tardi.',
    'unauthorized' => 'Non hai i permessi necessari per questa operazione.',

    // Login
    'login-via' => 'Accedi con',

    'login-failed' => 'Login fallito, riprova.',

    'user-not-allowed' => 'La tua email non è autorizzata.',

    'registration-not-enabled' => 'Non è possibile registrare un nuovo utente.',
    'Sign in to your account' => 'Accedi al tuo account',
    'create a new account' => 'Crea un nuovo account',
    'Or' => 'O',
    'Email address' => 'Indirizzo e-mail',
    'Password' => 'Password',
    'Remember me' => 'Ricordami',
    'Remember' => 'Ricordami',
    'Forgot your password?' => 'Password dimenticata?',
    'Sign in' => 'Accedi',
    'login-in' => 'Accedi',
    'sign-up' => 'Registrati',
    'password_expired' => [
        'title' => 'Password Scaduta, Reimposta Password',
        'heading' => 'Crea una Nuova Password',
        'sub_heading' => 'La tua password è scaduta, per favore crea una nuova password',
        'fields' => [
            'current_password' => [
                'label' => 'Current Password',
                'validation_attribute' => 'current_password',
            ],
            'password' => [
                'label' => 'Password',
                'validation_attribute' => 'password',
            ],
            'password_confirmation' => [
                'label' => 'Confirm Password',
            ],
        ],
        'form' => [
            'current_password' => [
<<<<<<< HEAD
<<<<<<< HEAD
                'label' => 'Current Password',
                'validation_attribute' => 'current_password',
            ],
            'password' => [
                'label' => 'Password',
                'validation_attribute' => 'password',
            ],
            'password_confirmation' => [
                'label' => 'Confirm Password',
            ],
        ],
        'actions' => [
            'reset_password' => ['label' => 'Reset Password'],
            'cancel' => ['label' => 'Cancel'],
        ],
        'reset_password' => 'Reset Password',
        'password_reset' => 'Password Reset',
        'notifications' => [
            'wrong_password' => [
                'title' => 'Wrong Password',
                'body' => 'The current password you entered is incorrect.',
            ],
            'column_not_found' => [
                'title' => 'Column Not Found',
                'body' => 'Either the column ":column_name" or the password column ":password_column_name" was not found in the :table_name table.',
            ],
            'password_reset' => [
                'success' => 'Password Reset Successful',
            ],
            'same_password' => [
                'title' => 'Same Password',
                'body' => 'The new password must be different from the current password.',
            ],
        ],
        'exceptions' => [
            'column_not_found' => 'Either the column ":column_name" or the password column ":password_column_name" was not found in the ":table_name" table. Please publish migrations and run them, if the error still persists, publish the config file and update the table_name, column_name, and password_column_name values.',
        ],
    ],
    'failed' => 'Le credenziali non corrispondono a quelle registrate.',
    'general_error' => 'Non hai diritti sufficienti per questa operazione.',
    'socialite' => [
        'unacceptable' => ':provider non è supportato.',
    ],
    'throttle' => 'Troppi tentativi di login. Si prega di riprovare tra :seconds secondi.',
    'unknown' => 'Si è verificato un errore sconosciuto',
    'Reset password' => 'Reimposta la password',
    'Send password reset link' => 'Invia link per reimpostare la password',
    'Confirm Password' => 'Conferma Password',
    'Confirm' => 'Conferma',
=======
=======
>>>>>>> a3f7230 (.)
                'label' => 'Password Attuale',
                'placeholder' => 'Inserisci la password attuale',
                'help' => 'Inserisci la tua password attuale per confermare la tua identità',
            ],
            'password' => [
                'label' => 'Nuova Password',
                'placeholder' => 'Inserisci la nuova password',
                'help' => 'La password deve contenere almeno 8 caratteri',
            ],
            'password_confirmation' => [
                'label' => 'Conferma Nuova Password',
                'placeholder' => 'Conferma la nuova password',
                'help' => 'Reinserisci la nuova password per confermarla',
            ],
        ],
        'actions' => [
            'update' => [
                'label' => 'Aggiorna Password',
                'success' => 'Password aggiornata con successo',
                'error' => 'Errore durante l\'aggiornamento della password',
            ],
        ],
    ],

    'email' => 'Email',
    'name' => 'Nome',
    'confirm_password' => 'Conferma Password',

    // Messaggi di stato
    'logout_success' => 'Logout effettuato con successo.',
    'logout_error' => 'Si è verificato un errore durante il logout.',

    // Messaggi per il reset password
    'reset_password_notification_subject' => 'Reset Password Notification',
    'reset_password_notification_line_1' => 'You are receiving this email because we received a password reset request for your account.',
    'reset_password_notification_action' => 'Reset Password',
    'reset_password_notification_line_2' => 'This password reset link will expire in :count minutes.',
    'reset_password_notification_line_3' => 'If you did not request a password reset, no further action is required.',

<<<<<<< HEAD
>>>>>>> aurmich/dev
=======
>>>>>>> a3f7230 (.)
    'Resend Verification Email' => 'Rinvia Email di Verifica',
    'Verify Your Email Address' => 'Verifica la tua email',
    'A fresh verification link has been sent to your email address.' => 'Un nuovo link di verifica è stato inviato al tuo indirizzo email.',

    'login' => [
        'title' => 'Accedi al tuo account',
        'subtitle' => 'Inserisci le tue credenziali per accedere',
        'email' => 'Indirizzo email',
        'email_placeholder' => 'esempio@email.com',
        'password' => 'Password',
        'password_placeholder' => '••••••••',
        'remember' => 'Ricordami',
        'email_structured' => [
            'label' => 'Email',
            'placeholder' => 'Inserisci la tua email'
        ],
        'password_structured' => [
            'label' => 'Password',
            'placeholder' => 'Inserisci la tua password'
        ],
        'remember_structured' => [
            'label' => 'Ricordami'
        ],
        'submit' => 'Accedi',
        'forgot_password' => 'Password dimenticata?',
        'no_account' => 'Non hai un account?',
        'register' => 'Registrati',
        'success' => 'Accesso effettuato con successo.',
        'failed' => 'Credenziali non valide.',
        'logout_success' => 'Logout effettuato con successo.',
        'logout_error' => 'Si è verificato un errore durante il logout.',
        'login-via' => 'Accedi con',
        'login-failed' => 'Login fallito, riprova.',
        'user-not-allowed' => 'La tua email non è autorizzata.',
        'login-in' => 'Accedi',
        'Sign in' => 'Accedi',
        'Sign in to your account' => 'Accedi al tuo account',
        'Welcome back' => 'Bentornato',
        'Email address' => 'Indirizzo email',
        'Email' => 'Email',
        'Password' => 'Password',
        'Remember me' => 'Ricordami',
        'Remember' => 'Ricordami',
        'Forgot your password?' => 'Password dimenticata?',
    ],

    // Registrazione
    'register' => [
        'title' => 'Crea un nuovo account',
        'subtitle' => 'Inserisci i tuoi dati per registrarti',
        'name' => 'Nome completo',
        'name_placeholder' => 'Mario Rossi',
        'email' => 'Indirizzo email',
        'email_placeholder' => 'esempio@email.com',
        'password' => 'Password',
        'password_placeholder' => '••••••••',
        'password_confirmation' => 'Conferma password',
        'password_confirmation_placeholder' => '••••••••',
        'submit' => 'Registrati',
<<<<<<< HEAD
<<<<<<< HEAD
        'already_registered' => 'Hai già un account? Accedi',
        'success' => 'Registrazione completata con successo.',
        'failed' => 'Impossibile completare la registrazione.',
        // Structured version
        'name_structured' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il tuo nome'
=======
=======
>>>>>>> a3f7230 (.)
        'success' => 'Registrazione completata con successo.',
        'failed' => 'Impossibile completare la registrazione.',
        'already_have_account' => 'Hai già un account?',
        'login' => 'Accedi',
        // Structured version
        'name_structured' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il tuo nome completo'
<<<<<<< HEAD
>>>>>>> aurmich/dev
=======
>>>>>>> a3f7230 (.)
        ],
        'email_structured' => [
            'label' => 'Email',
            'placeholder' => 'Inserisci la tua email'
        ],
        'password_structured' => [
            'label' => 'Password',
<<<<<<< HEAD
<<<<<<< HEAD
            'placeholder' => 'Inserisci la tua password'
        ],
        'password_confirmation_structured' => [
            'label' => 'Conferma Password',
            'placeholder' => 'Conferma la tua password'
        ],
    ],

    // Recupero Password
    'forgot-password' => [
        'title' => 'Recupera password',
        'subtitle' => 'Inserisci il tuo indirizzo email per ricevere il link di reset',
        'email' => 'Indirizzo email',
        'email_placeholder' => 'esempio@email.com',
        'submit' => 'Invia link',
        'back_to_login' => 'Torna al login',
        'success' => 'Ti abbiamo inviato le istruzioni via email.',
        'failed' => 'Impossibile inviare le istruzioni di reset.',
=======
=======
>>>>>>> a3f7230 (.)
            'placeholder' => 'Inserisci la password'
        ],
        'password_confirmation_structured' => [
            'label' => 'Conferma Password',
            'placeholder' => 'Conferma la password'
        ],
    ],

    // Password dimenticata
    'forgot_password' => [
        'title' => 'Password dimenticata?',
        'subtitle' => 'Inserisci la tua email per ricevere le istruzioni',
        'email' => 'Indirizzo email',
        'email_placeholder' => 'esempio@email.com',
        'submit' => 'Invia istruzioni',
        'success' => 'Le istruzioni sono state inviate alla tua email.',
        'failed' => 'Impossibile inviare le istruzioni di reset.',
        'back_to_login' => 'Torna al login',
<<<<<<< HEAD
>>>>>>> aurmich/dev
=======
>>>>>>> a3f7230 (.)
        // Structured version
        'email_structured' => [
            'label' => 'Email',
            'placeholder' => 'Inserisci la tua email'
        ],
    ],

<<<<<<< HEAD
<<<<<<< HEAD
    // Reset Password
    'reset-password' => [
=======
    // Reset password
    'reset_password' => [
>>>>>>> aurmich/dev
=======
    // Reset password
    'reset_password' => [
>>>>>>> a3f7230 (.)
        'title' => 'Reimposta password',
        'subtitle' => 'Inserisci la nuova password',
        'email' => 'Indirizzo email',
        'email_placeholder' => 'esempio@email.com',
        'password' => 'Nuova password',
        'password_placeholder' => '••••••••',
        'password_confirmation' => 'Conferma password',
        'password_confirmation_placeholder' => '••••••••',
        'submit' => 'Reimposta password',
        'success' => 'Password reimpostata con successo.',
        'failed' => 'Impossibile reimpostare la password.',
        // Structured version
        'email_structured' => [
            'label' => 'Email',
            'placeholder' => 'Inserisci la tua email'
        ],
        'password_structured' => [
            'label' => 'Nuova Password',
            'placeholder' => 'Inserisci la nuova password'
        ],
        'password_confirmation_structured' => [
            'label' => 'Conferma Password',
            'placeholder' => 'Conferma la nuova password'
        ],
    ],

    // Verifica Email
    'verification' => [
        'title' => 'Verifica il tuo indirizzo email',
        'subtitle' => 'Ti abbiamo inviato un link di verifica',
        'notice' => 'Prima di procedere, controlla la tua email per il link di verifica.',
        'another' => 'Se non hai ricevuto l\'email',
        'resend' => 'Clicca qui per richiederne un\'altra',
        'success' => 'Un nuovo link di verifica è stato inviato al tuo indirizzo email.',
    ],

    // Social Login
    'social' => [
        'title' => 'Accedi con',
        'google' => 'Google',
        'facebook' => 'Facebook',
        'github' => 'GitHub',
        'error' => 'Si è verificato un errore con il login social.',
    ],

    // Messaggi di Errore
    'errors' => [
        'invalid_credentials' => 'Credenziali non valide.',
        'invalid_token' => 'Token non valido o scaduto.',
        'account_blocked' => 'Account bloccato. Contatta l\'assistenza.',
        'too_many_attempts' => 'Troppi tentativi. Riprova più tardi.',
        'session_expired' => 'Sessione scaduta. Effettua nuovamente il login.',
    ],
    
    // Reset Password
    'passwords' => [
        'reset' => 'La tua password è stata reimpostata!',
        'sent' => 'Ti abbiamo inviato il link per reimpostare la password!',
        'throttled' => 'Per favore attendi prima di riprovare.',
        'token' => 'Il token di reset password non è valido.',
        'user' => 'Non riusciamo a trovare un utente con questo indirizzo email.',
    ],
];
