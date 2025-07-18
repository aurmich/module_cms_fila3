<?php

return [
    'model' => [
        'label' => 'Doctor',
        'plural' => 'Doctors',
        'description' => 'Management of doctors registered on the platform',
    ],
    'navigation' => [
        'label' => 'Doctors',
        'group' => 'User Management',
        'icon' => 'heroicon-o-user-circle',
        'sort' => '10',
    ],
    'pages' => [
        'index' => [
            'title' => 'Doctors List',
            'subtitle' => 'Manage doctors registered in the mobile app',
            'description' => 'View and manage all doctors registered on the platform',
        ],
        'create' => [
            'title' => 'New Doctor',
            'subtitle' => 'Register a new doctor',
            'description' => 'Enter data to register a new professional',
        ],
        'edit' => [
            'title' => 'Edit Doctor',
            'subtitle' => 'Edit doctor information',
            'description' => 'Update professional data',
        ],
        'view' => [
            'title' => 'Doctor Details',
            'subtitle' => 'View complete doctor information',
            'description' => 'Complete medical profile details',
        ],
    ],
    'fields' => [
        'full_name' => [
            'label' => 'Full Name',
            'placeholder' => 'Enter complete first and last name',
            'help' => 'Name as registered with the Medical Board',
        ],
        'first_name' => [
            'label' => 'First Name',
            'placeholder' => 'Enter first name',
            'help' => 'Doctor\'s first name',
        ],
        'last_name' => [
            'label' => 'Last Name',
            'placeholder' => 'Enter last name',
            'help' => 'Doctor\'s last name',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Enter email',
            'help' => 'Primary contact email',
            'description' => 'email',
        ],
        'notes' => [
            'label' => 'Notes',
            'placeholder' => 'Enter additional notes',
            'help' => 'Internal notes about the doctor',
        ],
        'phone' => [
            'label' => 'Phone',
            'placeholder' => '+39 123 456 7890',
            'help' => 'Primary phone number',
        ],
        'mobile_phone' => [
            'label' => 'Mobile Phone',
            'placeholder' => '+39 333 123 4567',
            'help' => 'Mobile number for urgent communications',
        ],
        'license_number' => [
            'label' => 'License Number',
            'placeholder' => 'Enter medical license number',
            'help' => 'Medical board registration number',
        ],
        'specializations' => [
            'label' => 'Specializations',
            'placeholder' => 'Select specializations',
            'help' => 'Doctor\'s specializations',
        ],
        'clinic_address' => [
            'label' => 'Clinic Address',
            'placeholder' => 'Enter clinic address',
            'help' => 'Complete address of the medical office',
        ],
        'bio' => [
            'label' => 'Biography',
            'placeholder' => 'Enter a brief biography',
            'help' => 'Brief professional presentation of the doctor',
        ],
        'is_active' => [
            'label' => 'Active',
            'help' => 'Indicates if the account is active',
        ],
        'verified_at' => [
            'label' => 'Verification Date',
            'placeholder' => 'Verification date',
            'help' => 'Date when documentation was verified',
        ],
        'is_verified' => [
            'label' => 'Verified',
            'help' => 'Indicates if credentials have been verified',
        ],
        'device_token' => [
            'label' => 'Device Token',
            'placeholder' => 'Automatically generated token',
            'help' => 'Token for sending push notifications',
        ],
        'last_login' => [
            'label' => 'Last Login',
            'placeholder' => 'Last login date',
            'help' => 'Date and time of the last login',
        ],
        'status' => [
            'label' => 'Status',
            'placeholder' => 'Select status',
            'help' => 'Current status of the doctor in the system',
        ],
        'schedule' => [
            'label' => 'Schedule',
            'placeholder' => 'Select available hours',
            'help' => 'Availability hours for appointments',
        ],
        'toggleColumns' => [
            'label' => 'Toggle Columns',
            'placeholder' => 'Toggle columns',
            'help' => 'Show or hide table columns',
        ],
        'reorderRecords' => [
            'label' => 'Reorder Records',
            'tooltip' => 'Reorder table records',
        ],
        'resetFilters' => [
            'label' => 'Reset Filters',
            'tooltip' => 'Remove all applied filters',
        ],
        'applyFilters' => [
            'label' => 'Apply Filters',
            'tooltip' => 'Apply selected filters',
        ],
        'openFilters' => [
            'label' => 'Open Filters',
            'tooltip' => 'Open filter panel',
        ],
        'closeFilters' => [
            'label' => 'Close Filters',
            'tooltip' => 'Close filter panel',
        ],
        'attach' => [
            'label' => 'Attach',
            'tooltip' => 'Attach a record',
        ],
        'detach' => [
            'label' => 'Detach',
            'tooltip' => 'Detach a record',
        ],
        'import' => [
            'label' => 'Import',
            'tooltip' => 'Import data',
        ],
        'export' => [
            'label' => 'Export',
            'tooltip' => 'Export data',
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
