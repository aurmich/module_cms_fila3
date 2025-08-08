<?php

return [
    'navigation' => [
        'label' => 'Utenti',
        'group' => 'Gestione Utenti',
        'icon' => 'heroicon-o-user',
        'sort' => '40',
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
            'placeholder' => 'ID generato automaticamente',
            'help' => 'Identificativo univoco dell\'utente',
        ],
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Mario Rossi',
            'help' => 'Nome completo dell\'utente',
        ],
        'first_name' => [
            'label' => 'Nome',
            'placeholder' => 'Mario',
            'help' => 'Nome di battesimo dell\'utente',
        ],
        'last_name' => [
            'label' => 'Cognome',
            'placeholder' => 'Rossi',
            'help' => 'Cognome dell\'utente',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'utente@email.com',
            'help' => 'Indirizzo email per l\'accesso',
        ],
        'role' => [
            'label' => 'Ruolo',
            'placeholder' => 'Seleziona il ruolo',
            'help' => 'Ruolo assegnato all\'utente',
        ],
        'type' => [
            'label' => 'Tipo',
            'placeholder' => 'Seleziona il tipo',
            'help' => 'Tipologia di utente nel sistema',
        ],
        'active' => [
            'label' => 'Attivo',
            'placeholder' => 'Stato di attivazione',
            'help' => 'L\'utente è attivo e può accedere',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'placeholder' => 'Data di registrazione',
            'help' => 'Data di registrazione dell\'utente',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
            'placeholder' => 'Data ultima modifica',
            'help' => 'Data ultima modifica profilo',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Utente',
            'tooltip' => 'Registra un nuovo utente',
            'modal_heading' => 'Nuovo Utente',
            'modal_description' => 'Inserisci i dati per registrare un nuovo utente',
            'success' => 'Utente creato con successo',
            'error' => 'Errore durante la creazione dell\'utente',
        ],
        'edit' => [
            'label' => 'Modifica',
            'tooltip' => 'Modifica i dati dell\'utente',
            'modal_heading' => 'Modifica Utente',
            'modal_description' => 'Aggiorna le informazioni dell\'utente',
            'success' => 'Utente aggiornato con successo',
            'error' => 'Errore durante l\'aggiornamento dell\'utente',
        ],
        'delete' => [
            'label' => 'Elimina',
            'tooltip' => 'Elimina l\'utente',
            'confirmation' => 'Sei sicuro di voler eliminare questo utente? Questa azione non può essere annullata.',
            'success' => 'Utente eliminato con successo',
            'error' => 'Errore durante l\'eliminazione dell\'utente',
        ],
        'activate' => [
            'label' => 'Attiva',
            'tooltip' => 'Rendi l\'utente attivo',
            'confirmation' => 'Sei sicuro di voler attivare questo utente?',
            'success' => 'Utente attivato con successo',
            'error' => 'Errore durante l\'attivazione dell\'utente',
        ],
        'deactivate' => [
            'label' => 'Disattiva',
            'tooltip' => 'Disattiva temporaneamente l\'utente',
            'confirmation' => 'Sei sicuro di voler disattivare questo utente?',
            'success' => 'Utente disattivato con successo',
            'error' => 'Errore durante la disattivazione dell\'utente',
        ],
        'reset_password' => [
            'label' => 'Reset Password',
            'tooltip' => 'Invia una nuova password all\'utente',
            'modal_heading' => 'Reset Password',
            'modal_description' => 'Verrà generata una nuova password temporanea e inviata via email',
            'confirmation' => 'Sei sicuro di voler reimpostare la password di questo utente?',
            'success' => 'Password reimpostata con successo',
            'error' => 'Errore durante il reset della password',
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
            'placeholder' => 'Filtra per utenti attivi',
            'help' => 'Mostra solo gli utenti attualmente attivi',
        ],
        'role' => [
            'label' => 'Per Ruolo',
            'placeholder' => 'Seleziona ruolo',
            'help' => 'Filtra per ruolo specifico',
        ],
        'type' => [
            'label' => 'Per Tipo',
            'placeholder' => 'Seleziona tipo',
            'help' => 'Filtra per tipologia di utente',
        ],
        'created_at' => [
            'label' => 'Data Registrazione',
            'placeholder' => 'Seleziona periodo',
            'help' => 'Filtra per periodo di registrazione',
        ],
    ],
    'bulk_actions' => [
        'activate_selected' => [
            'label' => 'Attiva Selezionati',
            'tooltip' => 'Attiva tutti gli utenti selezionati',
            'confirmation' => 'Sei sicuro di voler attivare tutti gli utenti selezionati?',
            'success' => 'Utenti attivati con successo',
            'error' => 'Errore durante l\'attivazione degli utenti',
        ],
        'deactivate_selected' => [
            'label' => 'Disattiva Selezionati',
            'tooltip' => 'Disattiva tutti gli utenti selezionati',
            'confirmation' => 'Sei sicuro di voler disattivare tutti gli utenti selezionati?',
            'success' => 'Utenti disattivati con successo',
            'error' => 'Errore durante la disattivazione degli utenti',
        ],
        'reset_password_selected' => [
            'label' => 'Reset Password Selezionati',
            'tooltip' => 'Reimposta password per tutti gli utenti selezionati',
            'modal_heading' => 'Reset Password Multiplo',
            'modal_description' => 'Verranno generate nuove password temporanee per tutti gli utenti selezionati',
            'confirmation' => 'Sei sicuro di voler reimpostare le password di tutti gli utenti selezionati?',
            'success' => 'Password reimpostate con successo',
            'error' => 'Errore durante il reset delle password',
        ],
        'delete_selected' => [
            'label' => 'Elimina Selezionati',
            'tooltip' => 'Elimina tutti gli utenti selezionati',
            'confirmation' => 'Sei sicuro di voler eliminare tutti gli utenti selezionati? Questa azione non può essere annullata.',
            'success' => 'Utenti eliminati con successo',
            'error' => 'Errore durante l\'eliminazione degli utenti',
        ],
    ],
    'messages' => [
        'activated_successfully' => 'Utente attivato con successo',
        'deactivated_successfully' => 'Utente disattivato con successo',
        'password_reset_successfully' => 'Password reimpostata con successo',
        'email_sent' => 'Email di notifica inviata',
        'empty_state' => 'Nessun utente trovato',
        'loading' => 'Caricamento utenti in corso...',
    ],
    'notifications' => [
        'created' => 'Utente creato con successo',
        'updated' => 'Utente aggiornato con successo',
        'deleted' => 'Utente eliminato con successo',
        'error' => 'Si è verificato un errore durante l\'operazione',
        'permission_denied' => 'Non hai i permessi per eseguire questa operazione',
    ],
    'validation' => [
        'required' => 'The :attribute field is required',
        'email' => 'Il campo :attribute deve essere un indirizzo email valido',
        'unique' => 'Il valore del campo :attribute è già stato utilizzato',
        'min' => [
            'string' => 'Il campo :attribute deve contenere almeno :min caratteri',
        ],
        'max' => [
            'string' => 'Il campo :attribute non può superare :max caratteri',
        ],
        'confirmed' => 'La conferma del campo :attribute non corrisponde',
        'password_format' => 'La password deve contenere almeno 8 caratteri',
    ],
    'search' => [
        'placeholder' => 'Cerca per nome, email o ruolo...',
        'label' => 'Cerca',
        'help' => 'Inserisci il termine di ricerca',
    ],
    'empty_state' => [
        'heading' => 'Nessun utente trovato',
        'description' => 'Non sono stati trovati utenti corrispondenti ai criteri di ricerca',
        'action' => 'Aggiungi il primo utente',
    ],
    'sections' => [
        'personal_info' => [
            'label' => 'Informazioni Personali',
            'description' => 'Dati anagrafici dell\'utente',
        ],
        'account_settings' => [
            'label' => 'Impostazioni Account',
            'description' => 'Configurazioni di accesso e sicurezza',
        ],
        'permissions' => [
            'label' => 'Permessi',
            'description' => 'Ruoli e autorizzazioni assegnate',
        ],
    ],
    'roles' => [
        'admin' => 'Amministratore',
        'user' => 'Utente',
        'moderator' => 'Moderatore',
        'guest' => 'Ospite',
    ],
    'statuses' => [
        'active' => 'Attivo',
        'inactive' => 'Inattivo',
        'pending' => 'In attesa',
        'suspended' => 'Sospeso',
    ],
];
