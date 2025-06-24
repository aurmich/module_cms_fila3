<?php

declare(strict_types=1);

return [
    'model' => [
        'label' => 'Medico',
        'plural' => 'Medici',
        'description' => 'Gestione dei medici registrati nella piattaforma',
    ],

    'navigation' => [
        'label' => 'Medici',
        'group' => 'Gestione Utenti',
        'icon' => 'heroicon-o-user-circle',
        'sort' => 10,
    ],

    'pages' => [
        'index' => [
            'title' => 'Elenco Medici',
            'subtitle' => 'Gestisci i medici registrati nell\'app mobile',
            'description' => 'Visualizza e gestisci tutti i medici iscritti alla piattaforma',
        ],
        'create' => [
            'title' => 'Nuovo Medico',
            'subtitle' => 'Registra un nuovo medico',
            'description' => 'Inserisci i dati per registrare un nuovo professionista',
        ],
        'edit' => [
            'title' => 'Modifica Medico',
            'subtitle' => 'Modifica le informazioni del medico',
            'description' => 'Aggiorna i dati del professionista',
        ],
        'view' => [
            'title' => 'Dettagli Medico',
            'subtitle' => 'Visualizza le informazioni complete del medico',
            'description' => 'Dettagli completi del profilo medico',
        ],
    ],

    'fields' => [
        'full_name' => [
            'label' => 'Nome e Cognome',
            'placeholder' => 'Inserisci nome e cognome completi',
            'helper_text' => 'Nome e cognome come registrati nell\'Ordine dei Medici',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'email@esempio.com',
            'helper_text' => 'Indirizzo email per le comunicazioni',
        ],
        'phone' => [
            'label' => 'Telefono',
            'placeholder' => '+39 123 456 7890',
            'helper_text' => 'Numero di telefono principale',
        ],
        'mobile_phone' => [
            'label' => 'Cellulare',
            'placeholder' => '+39 123 456 7890',
            'helper_text' => 'Numero di cellulare per le notifiche push',
        ],
        'license_number' => [
            'label' => 'Numero Iscrizione Ordine',
            'placeholder' => 'Inserisci il numero di iscrizione',
            'helper_text' => 'Numero di iscrizione all\'Ordine dei Medici',
        ],
        'specialization' => [
            'label' => 'Specializzazione',
            'placeholder' => 'Seleziona la specializzazione',
            'helper_text' => 'Specializzazione medica principale',
        ],
        'clinic_address' => [
            'label' => 'Indirizzo Studio',
            'placeholder' => 'Via Roma, 123',
            'helper_text' => 'Indirizzo dello studio medico',
        ],
        'is_active' => [
            'label' => 'Attivo',
            'helper_text' => 'Il medico può ricevere prenotazioni',
        ],
        'verified_at' => [
            'label' => 'Data Verifica',
            'helper_text' => 'Data di verifica della documentazione',
        ],
        'device_token' => [
            'label' => 'Token Dispositivo',
            'helper_text' => 'Token per le notifiche push',
        ],
        'last_login' => [
            'label' => 'Ultimo Accesso',
            'helper_text' => 'Data e ora dell\'ultimo accesso all\'app',
        ],
        'reset_filters' => [
            'label' => 'Azzera Filtri',
        ],
        'apply_filters' => [
            'label' => 'Applica Filtri',
        ],
        'open_filters' => [
            'label' => 'Apri Filtri',
        ],
        'toggle_columns' => [
            'label' => 'Mostra/Nascondi Colonne',
        ],
        'reorder_records' => [
            'label' => 'Riordina Record',
        ],
    ],

    'actions' => [
        'verify' => [
            'label' => 'Verifica',
            'icon' => 'heroicon-o-check-circle',
            'tooltip' => 'Verifica la documentazione del medico',
        ],
        'deactivate' => [
            'label' => 'Disattiva',
            'icon' => 'heroicon-o-x-circle',
            'tooltip' => 'Disattiva temporaneamente il medico',
        ],
        'send_notification' => [
            'label' => 'Invia Notifica',
            'icon' => 'heroicon-o-bell',
            'tooltip' => 'Invia una notifica push al medico',
        ],
        'view_appointments' => [
            'label' => 'Vedi Appuntamenti',
            'icon' => 'heroicon-o-calendar-days',
            'tooltip' => 'Visualizza gli appuntamenti del medico',
        ],
    ],

    'filters' => [
        'active' => [
            'label' => 'Solo Attivi',
        ],
        'verified' => [
            'label' => 'Solo Verificati',
        ],
        'specialization' => [
            'label' => 'Per Specializzazione',
        ],
    ],

    'bulk_actions' => [
        'verify_selected' => [
            'label' => 'Verifica Selezionati',
            'icon' => 'heroicon-o-check-circle',
        ],
        'send_notification_selected' => [
            'label' => 'Notifica Selezionati',
            'icon' => 'heroicon-o-bell',
        ],
    ],

    'messages' => [
        'verified_successfully' => 'Medico verificato con successo',
        'deactivated_successfully' => 'Medico disattivato con successo',
        'notification_sent' => 'Notifica inviata con successo',
    ],

    'notifications' => [
        'created' => 'Medico creato con successo',
        'updated' => 'Medico aggiornato con successo',
        'deleted' => 'Medico eliminato con successo',
        'error' => 'Si è verificato un errore durante l\'operazione',
    ],

    'validation' => [
        'required' => 'Il campo :attribute è obbligatorio',
        'email' => 'Il campo :attribute deve essere un indirizzo email valido',
        'unique' => 'Il valore del campo :attribute è già stato utilizzato',
        'min' => [
            'string' => 'Il campo :attribute deve contenere almeno :min caratteri',
        ],
        'max' => [
            'string' => 'Il campo :attribute non può superare :max caratteri',
        ],
    ],

    'search_placeholder' => 'Cerca per nome, email, telefono o numero di iscrizione...',
];
