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
            'help' => 'Nome e cognome come registrati nell\'Ordine dei Medici',
        ],
        'first_name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome del medico',
        ],
        'last_name' => [
            'label' => 'Cognome',
            'placeholder' => 'Inserisci il cognome',
            'help' => 'Cognome del medico',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'email@esempio.com',
            'help' => 'Indirizzo email per le comunicazioni',
        ],
        'phone' => [
            'label' => 'Telefono',
            'placeholder' => '+39 123 456 7890',
            'help' => 'Numero di telefono principale',
        ],
        'mobile_phone' => [
            'label' => 'Cellulare',
            'placeholder' => '+39 123 456 7890',
            'help' => 'Numero di cellulare per le notifiche push',
        ],
        'license_number' => [
            'label' => 'Numero Iscrizione Ordine',
            'placeholder' => 'Inserisci il numero di iscrizione',
            'help' => 'Numero di iscrizione all\'Ordine dei Medici',
        ],
        'specialization' => [
            'label' => 'Specializzazione',
            'placeholder' => 'Seleziona la specializzazione',
            'help' => 'Specializzazione medica principale',
        ],
        'clinic_address' => [
            'label' => 'Indirizzo Studio',
            'placeholder' => 'Via Roma, 123',
            'help' => 'Indirizzo dello studio medico',
        ],
        'is_active' => [
            'label' => 'Attivo',
            'help' => 'Il medico può ricevere prenotazioni',
        ],
        'verified_at' => [
            'label' => 'Data Verifica',
            'placeholder' => 'Seleziona la data di verifica',
            'help' => 'Data di verifica della documentazione',
        ],
        'device_token' => [
            'label' => 'Token Dispositivo',
            'placeholder' => 'Token generato automaticamente',
            'help' => 'Token per le notifiche push',
        ],
        'last_login' => [
            'label' => 'Ultimo Accesso',
            'placeholder' => 'Ultimo accesso registrato',
            'help' => 'Data e ora dell\'ultimo accesso all\'app',
        ],
        'status' => [
            'label' => 'Stato',
            'placeholder' => 'Seleziona lo stato',
            'help' => 'Stato attuale del medico nella piattaforma',
        ],
        'schedule' => [
            'label' => 'Orario',
            'placeholder' => 'Configura l\'orario',
            'help' => 'Orario di disponibilità del medico',
        ],
    ],

    'actions' => [
        'create' => [
            'label' => 'Crea Medico',
            'tooltip' => 'Registra un nuovo medico',
            'modal_heading' => 'Nuovo Medico',
            'modal_description' => 'Inserisci i dati per registrare un nuovo professionista',
            'success' => 'Medico creato con successo',
            'error' => 'Errore durante la creazione del medico',
        ],
        'edit' => [
            'label' => 'Modifica',
            'tooltip' => 'Modifica i dati del medico',
            'modal_heading' => 'Modifica Medico',
            'modal_description' => 'Aggiorna le informazioni del professionista',
            'success' => 'Medico aggiornato con successo',
            'error' => 'Errore durante l\'aggiornamento del medico',
        ],
        'delete' => [
            'label' => 'Elimina',
            'tooltip' => 'Elimina il medico',
            'confirmation' => 'Sei sicuro di voler eliminare questo medico? Questa azione non può essere annullata.',
            'success' => 'Medico eliminato con successo',
            'error' => 'Errore durante l\'eliminazione del medico',
        ],
        'verify' => [
            'label' => 'Verifica',
            'tooltip' => 'Verifica la documentazione del medico',
            'modal_heading' => 'Verifica Medico',
            'modal_description' => 'Conferma la verifica della documentazione del professionista',
            'success' => 'Medico verificato con successo',
            'error' => 'Errore durante la verifica del medico',
        ],
        'deactivate' => [
            'label' => 'Disattiva',
            'tooltip' => 'Disattiva temporaneamente il medico',
            'confirmation' => 'Sei sicuro di voler disattivare questo medico?',
            'success' => 'Medico disattivato con successo',
            'error' => 'Errore durante la disattivazione del medico',
        ],
        'send_notification' => [
            'label' => 'Invia Notifica',
            'tooltip' => 'Invia una notifica push al medico',
            'modal_heading' => 'Invia Notifica',
            'modal_description' => 'Scrivi il messaggio da inviare al medico',
            'success' => 'Notifica inviata con successo',
            'error' => 'Errore durante l\'invio della notifica',
        ],
        'view_appointments' => [
            'label' => 'Vedi Appuntamenti',
            'tooltip' => 'Visualizza gli appuntamenti del medico',
        ],
        'change_schedule' => [
            'label' => 'Modifica Orario',
            'tooltip' => 'Modifica l\'orario di disponibilità',
            'modal_heading' => 'Modifica Orario',
            'modal_description' => 'Configura gli orari di disponibilità del medico',
            'success' => 'Orario aggiornato con successo',
            'error' => 'Errore durante l\'aggiornamento dell\'orario',
        ],
        'attach' => [
            'label' => 'Collega',
            'tooltip' => 'Collega elemento',
        ],
        'apply_filters' => [
            'label' => 'Applica Filtri',
            'tooltip' => 'Applica i filtri selezionati',
        ],
        'reset_filters' => [
            'label' => 'Azzera Filtri',
            'tooltip' => 'Rimuovi tutti i filtri applicati',
        ],
        'open_filters' => [
            'label' => 'Apri Filtri',
            'tooltip' => 'Mostra pannello filtri',
        ],
        'toggle_columns' => [
            'label' => 'Mostra/Nascondi Colonne',
            'tooltip' => 'Personalizza le colonne visualizzate',
        ],
        'reorder_records' => [
            'label' => 'Riordina Record',
            'tooltip' => 'Riordina i record della tabella',
        ],
    ],

    'filters' => [
        'active' => [
            'label' => 'Solo Attivi',
            'placeholder' => 'Filtra per medici attivi',
            'help' => 'Mostra solo i medici attualmente attivi',
        ],
        'verified' => [
            'label' => 'Solo Verificati',
            'placeholder' => 'Filtra per medici verificati',
            'help' => 'Mostra solo i medici con documentazione verificata',
        ],
        'specialization' => [
            'label' => 'Per Specializzazione',
            'placeholder' => 'Seleziona specializzazione',
            'help' => 'Filtra per specializzazione medica',
        ],
    ],

    'bulk_actions' => [
        'verify_selected' => [
            'label' => 'Verifica Selezionati',
            'tooltip' => 'Verifica tutti i medici selezionati',
            'confirmation' => 'Sei sicuro di voler verificare tutti i medici selezionati?',
            'success' => 'Medici verificati con successo',
            'error' => 'Errore durante la verifica dei medici',
        ],
        'send_notification_selected' => [
            'label' => 'Notifica Selezionati',
            'tooltip' => 'Invia notifica a tutti i medici selezionati',
            'modal_heading' => 'Notifica Multipla',
            'modal_description' => 'Scrivi il messaggio da inviare a tutti i medici selezionati',
            'success' => 'Notifiche inviate con successo',
            'error' => 'Errore durante l\'invio delle notifiche',
        ],
    ],

    'messages' => [
        'verified_successfully' => 'Medico verificato con successo',
        'deactivated_successfully' => 'Medico disattivato con successo',
        'notification_sent' => 'Notifica inviata con successo',
        'empty_state' => 'Nessun medico trovato',
        'loading' => 'Caricamento medici in corso...',
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
        'phone_format' => 'Il numero di telefono deve essere in formato valido',
        'license_number_format' => 'Il numero di iscrizione deve essere valido',
    ],

    'search' => [
        'placeholder' => 'Cerca per nome, email, telefono o numero di iscrizione...',
        'label' => 'Cerca',
        'help' => 'Inserisci il termine di ricerca',
    ],

    'empty_state' => [
        'heading' => 'Nessun medico trovato',
        'description' => 'Non sono stati trovati medici corrispondenti ai criteri di ricerca',
        'action' => 'Aggiungi il primo medico',
    ],
];
