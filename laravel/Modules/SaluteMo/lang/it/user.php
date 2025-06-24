<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Utenti',
        'group' => 'Gestione Utenti',
        'icon' => 'heroicon-o-user',
        'sort' => 40,
    ],
    'model' => [
        'label' => 'Utente',
        'plural' => 'Utenti',
        'description' => 'Gestione degli utenti della piattaforma',
    ],
    'pages' => [
        'index' => [
            'title' => 'Elenco Utenti',
            'subtitle' => 'Gestisci gli utenti registrati',
            'description' => 'Visualizza e gestisci tutti gli utenti della piattaforma',
        ],
        'create' => [
            'title' => 'Nuovo Utente',
            'subtitle' => 'Registra un nuovo utente',
            'description' => 'Inserisci i dati per registrare un nuovo utente',
        ],
        'edit' => [
            'title' => 'Modifica Utente',
            'subtitle' => 'Modifica le informazioni dell\'utente',
            'description' => 'Aggiorna i dati dell\'utente',
        ],
        'view' => [
            'title' => 'Dettagli Utente',
            'subtitle' => 'Visualizza le informazioni complete dell\'utente',
            'description' => 'Dettagli completi del profilo utente',
        ],
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'placeholder' => '',
            'helper_text' => '',
        ],
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Mario Rossi',
            'helper_text' => 'Nome completo dell\'utente',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'utente@email.com',
            'helper_text' => 'Indirizzo email per l\'accesso',
        ],
        'role' => [
            'label' => 'Ruolo',
            'placeholder' => 'Seleziona il ruolo',
            'helper_text' => 'Ruolo assegnato all\'utente',
        ],
        'active' => [
            'label' => 'Attivo',
            'placeholder' => '',
            'helper_text' => 'L\'utente è attivo e può accedere',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'placeholder' => '',
            'helper_text' => 'Data di registrazione dell\'utente',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
            'placeholder' => '',
            'helper_text' => 'Data ultima modifica profilo',
        ],
    ],
    'actions' => [
        'activate' => [
            'label' => 'Attiva',
            'icon' => 'heroicon-o-check-circle',
            'tooltip' => 'Rendi l\'utente attivo',
        ],
        'deactivate' => [
            'label' => 'Disattiva',
            'icon' => 'heroicon-o-x-circle',
            'tooltip' => 'Disattiva temporaneamente l\'utente',
        ],
        'reset_password' => [
            'label' => 'Reset Password',
            'icon' => 'heroicon-o-key',
            'tooltip' => 'Invia una nuova password all\'utente',
        ],
    ],
    'filters' => [
        'active' => [
            'label' => 'Solo Attivi',
        ],
        'role' => [
            'label' => 'Per Ruolo',
        ],
    ],
    'bulk_actions' => [
        'activate_selected' => [
            'label' => 'Attiva Selezionati',
            'icon' => 'heroicon-o-check-circle',
        ],
        'deactivate_selected' => [
            'label' => 'Disattiva Selezionati',
            'icon' => 'heroicon-o-x-circle',
        ],
        'reset_password_selected' => [
            'label' => 'Reset Password Selezionati',
            'icon' => 'heroicon-o-key',
        ],
    ],
    'messages' => [
        'activated_successfully' => 'Utente attivato con successo',
        'deactivated_successfully' => 'Utente disattivato con successo',
        'password_reset_successfully' => 'Password reimpostata con successo',
    ],
    'search_placeholder' => 'Cerca per nome, email o ruolo...'
];
