<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Studi Medici',
        'group' => 'Gestione Strutture',
        'icon' => 'heroicon-o-building-office',
        'sort' => 30,
    ],

    'model' => [
        'label' => 'Studio Medico',
        'plural' => 'Studi Medici',
        'description' => 'Gestione degli studi medici e delle relative informazioni',
    ],

    'pages' => [
        'index' => [
            'title' => 'Elenco Studi Medici',
            'subtitle' => 'Gestisci gli studi registrati nella piattaforma',
            'description' => 'Visualizza e gestisci tutti gli studi medici presenti nel sistema',
        ],
        'create' => [
            'title' => 'Nuovo Studio Medico',
            'subtitle' => 'Registra un nuovo studio medico',
            'description' => 'Inserisci i dati per registrare un nuovo studio medico nella piattaforma',
        ],
        'edit' => [
            'title' => 'Modifica Studio Medico',
            'subtitle' => 'Modifica le informazioni dello studio',
            'description' => 'Aggiorna i dati e le informazioni del studio medico',
        ],
        'view' => [
            'title' => 'Dettagli Studio Medico',
            'subtitle' => 'Visualizza le informazioni complete dello studio',
            'description' => 'Dettagli completi del profilo e delle attività dello studio',
        ],
    ],

    'fields' => [
        'id' => [
            'label' => 'ID',
            'placeholder' => '',
            'helper_text' => 'Identificativo univoco dello studio medico',
        ],
        'active' => [
            'label' => 'Attivo',
            'placeholder' => '',
            'helper_text' => 'Indica se lo studio è attualmente operativo e visibile',
        ],
        'name' => [
            'label' => 'Nome Studio',
            'placeholder' => 'Studio Medico Dr. Rossi',
            'helper_text' => 'Nome completo e identificativo dello studio medico',
        ],
        'address' => [
            'label' => 'Indirizzo',
            'placeholder' => 'Via Roma, 123 - 41121 Modena (MO)',
            'helper_text' => 'Indirizzo completo dello studio con CAP e provincia',
        ],
        'phone' => [
            'label' => 'Telefono',
            'placeholder' => '+39 059 1234567',
            'helper_text' => 'Numero di telefono principale per contatti',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'info@studiorossi.it',
            'helper_text' => 'Indirizzo email per comunicazioni ufficiali',
        ],
        'website' => [
            'label' => 'Sito Web',
            'placeholder' => 'https://www.studiorossi.it',
            'helper_text' => 'URL del sito web ufficiale dello studio',
        ],
        'registration_number' => [
            'label' => 'Numero di Registrazione',
            'placeholder' => 'RM-123456',
            'helper_text' => 'Numero di registrazione presso l\'Ordine dei Medici',
        ],
        'vat_number' => [
            'label' => 'Partita IVA',
            'placeholder' => 'IT01234567890',
            'helper_text' => 'Partita IVA dello studio medico',
        ],
        'opening_hours' => [
            'label' => 'Orari di Apertura',
            'placeholder' => 'Lun-Ven: 9:00-18:00, Sab: 9:00-12:00',
            'helper_text' => 'Orari di apertura al pubblico',
        ],
        'specializations' => [
            'label' => 'Specializzazioni',
            'placeholder' => 'Cardiologia, Medicina Interna',
            'helper_text' => 'Specializzazioni mediche dello studio',
        ],
        'emergency_phone' => [
            'label' => 'Telefono Emergenze',
            'placeholder' => '+39 059 1234568',
            'helper_text' => 'Numero per emergenze mediche',
        ],
        'created_at' => [
            'label' => 'Data Registrazione',
            'placeholder' => '',
            'helper_text' => 'Data di registrazione dello studio nella piattaforma',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
            'placeholder' => '',
            'helper_text' => 'Data dell\'ultima modifica delle informazioni',
        ],
        'open_filters' => [
            'label' => 'Apri Filtri',
            'placeholder' => '',
            'helper_text' => 'Apri il pannello dei filtri di ricerca',
        ],
        'apply_filters' => [
            'label' => 'Applica Filtri',
            'placeholder' => '',
            'helper_text' => 'Applica i filtri selezionati alla ricerca',
        ],
        'reset_filters' => [
            'label' => 'Azzera Filtri',
            'placeholder' => '',
            'helper_text' => 'Rimuovi tutti i filtri applicati',
        ],
        'reorder_records' => [
            'label' => 'Riordina Record',
            'placeholder' => '',
            'helper_text' => 'Riordina i record nella tabella',
        ],
        'toggle_columns' => [
            'label' => 'Mostra/Nascondi Colonne',
            'placeholder' => '',
            'helper_text' => 'Configura la visibilità delle colonne nella tabella',
        ],
    ],

    'actions' => [
        'view_appointments' => [
            'label' => 'Vedi Appuntamenti',
            'icon' => 'heroicon-o-calendar-days',
            'tooltip' => 'Visualizza gli appuntamenti di questo studio',
        ],
        'manage_doctors' => [
            'label' => 'Gestisci Medici',
            'icon' => 'heroicon-o-user-group',
            'tooltip' => 'Gestisci i medici associati a questo studio',
        ],
        'view_patients' => [
            'label' => 'Vedi Pazienti',
            'icon' => 'heroicon-o-users',
            'tooltip' => 'Visualizza i pazienti registrati in questo studio',
        ],
        'manage_schedule' => [
            'label' => 'Gestisci Orari',
            'icon' => 'heroicon-o-clock',
            'tooltip' => 'Gestisci gli orari di apertura dello studio',
        ],
        'view_reports' => [
            'label' => 'Vedi Report',
            'icon' => 'heroicon-o-document-chart-bar',
            'tooltip' => 'Visualizza i report e le statistiche dello studio',
        ],
        'activate' => [
            'label' => 'Attiva',
            'icon' => 'heroicon-o-check-circle',
            'tooltip' => 'Rendi lo studio attivo e visibile',
        ],
        'deactivate' => [
            'label' => 'Disattiva',
            'icon' => 'heroicon-o-x-circle',
            'tooltip' => 'Disattiva temporaneamente lo studio',
        ],
        'export_data' => [
            'label' => 'Esporta Dati',
            'icon' => 'heroicon-o-arrow-down-tray',
            'tooltip' => 'Esporta i dati dello studio',
        ],
    ],

    'filters' => [
        'active' => [
            'label' => 'Solo Attivi',
            'placeholder' => 'Mostra solo studi attivi',
        ],
        'city' => [
            'label' => 'Per Città',
            'placeholder' => 'Filtra per città',
        ],
        'specialization' => [
            'label' => 'Per Specializzazione',
            'placeholder' => 'Filtra per specializzazione medica',
        ],
        'registration_date' => [
            'label' => 'Data Registrazione',
            'placeholder' => 'Filtra per data di registrazione',
        ],
        'has_doctors' => [
            'label' => 'Con Medici',
            'placeholder' => 'Mostra solo studi con medici associati',
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
        'export_selected' => [
            'label' => 'Esporta Selezionati',
            'icon' => 'heroicon-o-arrow-down-tray',
        ],
        'delete_selected' => [
            'label' => 'Elimina Selezionati',
            'icon' => 'heroicon-o-trash',
        ],
    ],

    'messages' => [
        'created' => 'Studio medico creato con successo',
        'updated' => 'Studio medico aggiornato con successo',
        'deleted' => 'Studio medico rimosso con successo',
        'activated_successfully' => 'Studio medico attivato con successo',
        'deactivated_successfully' => 'Studio medico disattivato con successo',
        'doctors_managed' => 'Medici gestiti con successo',
        'schedule_updated' => 'Orari aggiornati con successo',
        'data_exported' => 'Dati esportati con successo',
        'error' => 'Si è verificato un errore durante l\'operazione',
        'validation_error' => 'Errore di validazione dei dati',
        'not_found' => 'Studio medico non trovato',
    ],

    'validation' => [
        'name_required' => 'Il nome dello studio è obbligatorio',
        'name_min' => 'Il nome deve contenere almeno 3 caratteri',
        'name_max' => 'Il nome non può superare i 255 caratteri',
        'email_email' => 'Inserisci un indirizzo email valido',
        'email_unique' => 'Questo indirizzo email è già registrato',
        'phone_required' => 'Il numero di telefono è obbligatorio',
        'phone_format' => 'Il numero di telefono deve essere in formato valido',
        'address_required' => 'L\'indirizzo è obbligatorio',
        'registration_number_unique' => 'Questo numero di registrazione è già in uso',
        'vat_number_format' => 'La partita IVA deve essere in formato valido',
    ],

    'notifications' => [
        'studio_created' => [
            'title' => 'Nuovo Studio Registrato',
            'message' => 'Lo studio :name è stato registrato con successo',
        ],
        'studio_updated' => [
            'title' => 'Studio Aggiornato',
            'message' => 'Le informazioni dello studio :name sono state aggiornate',
        ],
        'studio_activated' => [
            'title' => 'Studio Attivato',
            'message' => 'Lo studio :name è ora attivo e visibile',
        ],
        'studio_deactivated' => [
            'title' => 'Studio Disattivato',
            'message' => 'Lo studio :name è stato disattivato temporaneamente',
        ],
    ],

    'search_placeholder' => 'Cerca per nome, indirizzo, telefono, email o specializzazione...',
];
