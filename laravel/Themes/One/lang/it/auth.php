<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Autenticazione
    |--------------------------------------------------------------------------
    */
    'login' => [
        'title' => 'Accedi al tuo account',
        'or' => 'oppure',
        'create_account' => 'crea un nuovo account',
        'forgot_password' => 'Hai dimenticato la password?',
        'back_to_login' => 'torna al login',
        'email' => 'Indirizzo email',
        'password' => 'Password',
        'remember_me' => 'Ricordami',
        'login_button' => 'Accedi',
    ],

    'register' => [
        'title' => 'Crea il tuo account',
        'welcome_message' => 'Benvenuto in <span class="font-bold">SaluteOra</span>',
        'description' => 'Crea il tuo account per accedere a tutti i servizi',
        'already_have_account' => 'Hai già un account?',
        'login_link' => 'accedi qui',
        'register_button' => 'Registrati',
    ],

    'password' => [
        'reset' => [
            'title' => 'Reimposta password',
            'subtitle' => 'Inserisci il tuo indirizzo email per ricevere il link di reimpostazione password',
            'description' => 'Inserisci il tuo indirizzo email per ricevere il link di reimpostazione password',
            'email_label' => 'Indirizzo email',
            'email_placeholder' => 'Inserisci la tua email',
            'send_button' => 'Invia link reimpostazione password',
            'back_to_login' => 'torna al login',
            'or' => 'oppure',
            'email_sent' => 'Link di reimpostazione password inviato!',
            'email_sent_title' => 'Email inviata con successo',
            'email_sent_message' => 'Controlla la tua casella di posta e segui le istruzioni per reimpostare la password.',
            'check_email_status' => 'Controlla email',
            'breadcrumb' => [
                'request' => 'Richiesta reset',
                'confirm' => 'Conferma password',
            ],
            'info' => [
                'security' => [
                    'title' => 'Sicurezza garantita',
                    'description' => 'Il link di reset è criptato e valido solo per 60 minuti. Nessuno può accedere al tuo account senza questo link.',
                ],
                'password' => [
                    'title' => 'Nuova password',
                    'description' => 'Scegli una password sicura con almeno 8 caratteri, includendo lettere, numeri e simboli.',
                ],
                'expiry' => [
                    'title' => 'Scadenza link',
                    'description' => 'Il link di reset scade automaticamente dopo 60 minuti per motivi di sicurezza.',
                ],
            ],
            'confirm' => [
                'title' => 'Imposta nuova password',
                'subtitle' => 'Inserisci la tua email e la nuova password per completare il reset',
            ],
            'help' => [
                'having_trouble' => 'Problemi con il reset?',
            ],
        ],
    ],

    'password-reset' => [
        'submit' => [
            'label' => 'Invia link di reset password',
        ],
    ],

    'confirm' => [
        'title' => 'Conferma password',
        'description' => 'Inserisci la tua password per confermare l\'identità',
    ],

    'new' => [
        'title' => 'Nuova password',
        'password_label' => 'Nuova password',
        'confirm_password_label' => 'Conferma nuova password',
        'update_button' => 'Aggiorna password',
    ],

    'verify' => [
        'title' => 'Verifica il tuo account',
        'description' => 'Ti abbiamo inviato un\'email di verifica. Controlla la tua casella di posta.',
        'resend_button' => 'Invia nuovamente',
        'change_email' => 'Cambia indirizzo email',
    ],

    'logout' => [
        'title' => 'Disconnessione',
        'message' => 'Sei stato disconnesso con successo',
        'redirect_message' => 'Reindirizzamento in corso...',
    ],

    'thank_you' => [
        'title' => 'Grazie per la registrazione',
        'message' => 'Il tuo account è stato creato con successo',
        'continue_button' => 'Continua',
    ],

    'actions' => [
        'processing' => 'Elaborazione in corso...',
        'sending' => 'Invio in corso...',
        'refresh' => 'Ricarica pagina',
    ],

    'errors' => [
        'loading_failed' => 'Errore di caricamento',
        'please_refresh' => 'Si è verificato un errore. Ricarica la pagina e riprova.',
    ],
]; 