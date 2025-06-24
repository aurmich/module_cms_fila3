<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Pazienti',
        'group' => 'Gestione Utenti',
        'icon' => 'heroicon-o-users',
        'sort' => 20,
    ],
    'model' => [
        'label' => 'Paziente',
        'plural' => 'Pazienti',
    ],
    'pages' => [
        'index' => [
            'title' => 'Elenco Pazienti',
            'subtitle' => 'Gestisci i pazienti registrati nell\'app mobile',
        ],
        'create' => [
            'title' => 'Nuovo Paziente',
            'subtitle' => 'Registra un nuovo paziente',
        ],
        'edit' => [
            'title' => 'Modifica Paziente',
            'subtitle' => 'Modifica le informazioni del paziente',
        ],
        'view' => [
            'title' => 'Dettagli Paziente',
            'subtitle' => 'Visualizza le informazioni complete del paziente',
        ],
    ],
    'fields' => [
        'full_name' => [
            'label' => 'Nome e Cognome',
            'placeholder' => 'Inserisci nome e cognome completi',
            'helper_text' => 'Nome e cognome del paziente',
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
        'fiscal_code' => [
            'label' => 'Codice Fiscale',
            'placeholder' => 'RSSMRA80A01H501Z',
            'helper_text' => 'Codice fiscale del paziente',
        ],
        'birth_date' => [
            'label' => 'Data di Nascita',
            'placeholder' => 'Seleziona la data',
            'helper_text' => 'Data di nascita del paziente',
        ],
        'gender' => [
            'label' => 'Sesso',
            'placeholder' => 'Seleziona il sesso',
            'helper_text' => 'Sesso del paziente',
            'options' => [
                'male' => 'Maschio',
                'female' => 'Femmina',
                'other' => 'Altro',
            ],
        ],
        'address' => [
            'label' => 'Indirizzo',
            'placeholder' => 'Via Roma, 123',
            'helper_text' => 'Indirizzo di residenza',
        ],
        'city' => [
            'label' => 'Città',
            'placeholder' => 'Milano',
            'helper_text' => 'Città di residenza',
        ],
        'postal_code' => [
            'label' => 'CAP',
            'placeholder' => '20100',
            'helper_text' => 'Codice di avviamento postale',
        ],
        'emergency_contact_name' => [
            'label' => 'Contatto Emergenza - Nome',
            'placeholder' => 'Nome del contatto di emergenza',
            'helper_text' => 'Nome della persona da contattare in caso di emergenza',
        ],
        'emergency_contact_phone' => [
            'label' => 'Contatto Emergenza - Telefono',
            'placeholder' => '+39 123 456 7890',
            'helper_text' => 'Telefono del contatto di emergenza',
        ],
        'allergies' => [
            'label' => 'Allergie',
            'placeholder' => 'Elenco delle allergie note',
            'helper_text' => 'Allergie note del paziente',
        ],
        'medications' => [
            'label' => 'Farmaci',
            'placeholder' => 'Farmaci attualmente assunti',
            'helper_text' => 'Farmaci che il paziente sta assumendo',
        ],
        'medical_history' => [
            'label' => 'Storia Clinica',
            'placeholder' => 'Note sulla storia clinica',
            'helper_text' => 'Informazioni rilevanti sulla storia clinica',
        ],
        'is_active' => [
            'label' => 'Attivo',
            'helper_text' => 'Il paziente può prenotare visite',
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
        'view_medical_history' => [
            'label' => 'Storia Clinica',
            'icon' => 'heroicon-o-document-text',
            'tooltip' => 'Visualizza la storia clinica del paziente',
        ],
        'view_appointments' => [
            'label' => 'Appuntamenti',
            'icon' => 'heroicon-o-calendar-days',
            'tooltip' => 'Visualizza gli appuntamenti del paziente',
        ],
        'send_notification' => [
            'label' => 'Invia Notifica',
            'icon' => 'heroicon-o-bell',
            'tooltip' => 'Invia una notifica push al paziente',
        ],
        'deactivate' => [
            'label' => 'Disattiva',
            'icon' => 'heroicon-o-x-circle',
            'tooltip' => 'Disattiva temporaneamente il paziente',
        ],
        'add_medical_note' => [
            'label' => 'Aggiungi Nota',
            'icon' => 'heroicon-o-plus-circle',
            'tooltip' => 'Aggiungi una nota medica',
        ],
    ],
    'filters' => [
        'active' => [
            'label' => 'Solo Attivi',
        ],
        'gender' => [
            'label' => 'Per Sesso',
        ],
        'age_range' => [
            'label' => 'Fascia d\'Età',
        ],
        'city' => [
            'label' => 'Per Città',
        ],
    ],
    'bulk_actions' => [
        'send_notification_selected' => [
            'label' => 'Notifica Selezionati',
            'icon' => 'heroicon-o-bell',
        ],
        'export_selected' => [
            'label' => 'Esporta Selezionati',
            'icon' => 'heroicon-o-arrow-down-tray',
        ],
    ],
    'messages' => [
        'deactivated_successfully' => 'Paziente disattivato con successo',
        'notification_sent' => 'Notifica inviata con successo',
        'medical_note_added' => 'Nota medica aggiunta con successo',
        'export_completed' => 'Esportazione completata',
    ],
    'notifications' => [
        'created' => 'Paziente creato con successo',
        'updated' => 'Paziente aggiornato con successo',
        'deleted' => 'Paziente eliminato con successo',
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
    'search_placeholder' => 'Cerca per nome, email, telefono o codice fiscale...',
];
