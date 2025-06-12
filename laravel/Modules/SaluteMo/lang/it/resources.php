<?php

declare(strict_types=1);

return [
    'general' => [
        'create' => 'Crea',
        'edit' => 'Modifica',
        'delete' => 'Elimina',
        'view' => 'Visualizza',
        'save' => 'Salva',
        'cancel' => 'Annulla',
        'back' => 'Indietro',
        'next' => 'Avanti',
        'previous' => 'Precedente',
        'confirm' => 'Conferma',
        'search' => 'Cerca',
        'filter' => 'Filtra',
        'export' => 'Esporta',
        'import' => 'Importa',
        'refresh' => 'Aggiorna',
        'actions' => 'Azioni',
        'details' => 'Dettagli',
        'settings' => 'Impostazioni',
    ],
    
    'tables' => [
        'empty_state' => [
            'title' => 'Nessun elemento trovato',
            'description' => 'Non ci sono elementi da visualizzare.',
        ],
        'loading' => 'Caricamento in corso...',
        'pagination' => [
            'previous' => 'Precedente',
            'next' => 'Successivo',
            'showing' => 'Mostrando da :from a :to di :total risultati',
        ],
        'actions' => [
            'bulk_delete' => 'Elimina selezionati',
            'bulk_export' => 'Esporta selezionati',
            'select_all' => 'Seleziona tutti',
            'deselect_all' => 'Deseleziona tutti',
        ],
    ],
    
    'forms' => [
        'validation' => [
            'required' => 'Questo campo è obbligatorio',
            'email' => 'Inserisci un indirizzo email valido',
            'min' => 'Il valore deve essere almeno :min caratteri',
            'max' => 'Il valore non può superare :max caratteri',
            'unique' => 'Questo valore è già stato utilizzato',
            'confirmed' => 'La conferma non corrisponde',
        ],
        'placeholders' => [
            'search' => 'Inizia a digitare per cercare...',
            'select' => 'Seleziona un\'opzione',
            'select_multiple' => 'Seleziona una o più opzioni',
            'no_options' => 'Nessuna opzione disponibile',
        ],
    ],
    
    'notifications' => [
        'success' => [
            'created' => ':item creato con successo',
            'updated' => ':item aggiornato con successo',
            'deleted' => ':item eliminato con successo',
            'exported' => 'Esportazione completata con successo',
            'imported' => 'Importazione completata con successo',
        ],
        'error' => [
            'create_failed' => 'Errore durante la creazione di :item',
            'update_failed' => 'Errore durante l\'aggiornamento di :item',
            'delete_failed' => 'Errore durante l\'eliminazione di :item',
            'export_failed' => 'Errore durante l\'esportazione',
            'import_failed' => 'Errore durante l\'importazione',
            'validation_failed' => 'Controlla i dati inseriti',
        ],
    ],
    
    'status' => [
        'active' => 'Attivo',
        'inactive' => 'Inattivo',
        'pending' => 'In attesa',
        'approved' => 'Approvato',
        'rejected' => 'Rifiutato',
        'verified' => 'Verificato',
        'unverified' => 'Non verificato',
        'online' => 'Online',
        'offline' => 'Offline',
        'published' => 'Pubblicato',
        'draft' => 'Bozza',
    ],
    
    'dates' => [
        'today' => 'Oggi',
        'yesterday' => 'Ieri',
        'tomorrow' => 'Domani',
        'this_week' => 'Questa settimana',
        'last_week' => 'Settimana scorsa',
        'this_month' => 'Questo mese',
        'last_month' => 'Mese scorso',
        'this_year' => 'Quest\'anno',
        'last_year' => 'Anno scorso',
        'custom_range' => 'Intervallo personalizzato',
    ],
    
    'mobile_app' => [
        'title' => 'App Mobile SaluteMo',
        'description' => 'Gestione dell\'applicazione mobile per medici e pazienti',
        'features' => [
            'appointment_booking' => 'Prenotazione appuntamenti',
            'doctor_search' => 'Ricerca medici',
            'patient_management' => 'Gestione pazienti',
            'push_notifications' => 'Notifiche push',
            'real_time_chat' => 'Chat in tempo reale',
            'medical_records' => 'Cartelle cliniche',
            'prescription_management' => 'Gestione prescrizioni',
        ],
    ],
]; 