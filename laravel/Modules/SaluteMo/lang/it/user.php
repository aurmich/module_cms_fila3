<?php

return array (
  'navigation' => 
  array (
    'label' => 'Utenti',
    'group' => 'Gestione Utenti',
    'icon' => 'heroicon-o-user',
    'sort' => 40,
  ),
  'model' => 
  array (
    'label' => 'Utente',
    'plural' => 'Utenti',
    'description' => 'Gestione degli utenti della piattaforma',
  ),
  'pages' => 
  array (
    'index' => 
    array (
      'title' => 'Elenco Utenti',
      'subtitle' => 'Gestisci gli utenti registrati',
      'description' => 'Visualizza e gestisci tutti gli utenti della piattaforma',
    ),
    'create' => 
    array (
      'title' => 'Nuovo Utente',
      'subtitle' => 'Registra un nuovo utente',
      'description' => 'Inserisci i dati per registrare un nuovo utente',
    ),
    'edit' => 
    array (
      'title' => 'Modifica Utente',
      'subtitle' => 'Modifica le informazioni dell\'utente',
      'description' => 'Aggiorna i dati dell\'utente',
    ),
    'view' => 
    array (
      'title' => 'Dettagli Utente',
      'subtitle' => 'Visualizza le informazioni complete dell\'utente',
      'description' => 'Dettagli completi del profilo utente',
    ),
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'placeholder' => 'ID generato automaticamente',
      'help' => 'Identificativo univoco dell\'utente',
    ),
    'name' => 
    array (
      'label' => 'Nome',
      'placeholder' => 'Mario Rossi',
      'help' => 'Nome completo dell\'utente',
    ),
    'first_name' => 
    array (
      'label' => 'Nome',
      'placeholder' => 'Mario',
      'help' => 'Nome di battesimo dell\'utente',
    ),
    'last_name' => 
    array (
      'label' => 'Cognome',
      'placeholder' => 'Rossi',
      'help' => 'Cognome dell\'utente',
    ),
    'email' => 
    array (
      'label' => 'Email',
      'placeholder' => 'utente@email.com',
      'help' => 'Indirizzo email per l\'accesso',
    ),
    'role' => 
    array (
      'label' => 'Ruolo',
      'placeholder' => 'Seleziona il ruolo',
      'help' => 'Ruolo assegnato all\'utente',
    ),
    'type' => 
    array (
      'label' => 'Tipo',
      'placeholder' => 'Seleziona il tipo',
      'help' => 'Tipologia di utente nel sistema',
    ),
    'active' => 
    array (
      'label' => 'Attivo',
      'placeholder' => 'Stato di attivazione',
      'help' => 'L\'utente è attivo e può accedere',
    ),
    'created_at' => 
    array (
      'label' => 'Data Creazione',
      'placeholder' => 'Data di registrazione',
      'help' => 'Data di registrazione dell\'utente',
    ),
    'updated_at' => 
    array (
      'label' => 'Ultima Modifica',
      'placeholder' => 'Data ultima modifica',
      'help' => 'Data ultima modifica profilo',
    ),
    'toggleColumns' => 
    array (
      'label' => 'toggleColumns',
    ),
    'reorderRecords' => 
    array (
      'label' => 'reorderRecords',
    ),
    'resetFilters' => 
    array (
      'label' => 'resetFilters',
    ),
    'applyFilters' => 
    array (
      'label' => 'applyFilters',
    ),
    'openFilters' => 
    array (
      'label' => 'openFilters',
    ),
    'state' => 
    array (
      'label' => 'state',
    ),
    'create' => 
    array (
      'label' => 'create',
    ),
    'layout' => 
    array (
      'label' => 'layout',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Utente',
      'tooltip' => 'Registra un nuovo utente',
      'modal_heading' => 'Nuovo Utente',
      'modal_description' => 'Inserisci i dati per registrare un nuovo utente',
      'success' => 'Utente creato con successo',
      'error' => 'Errore durante la creazione dell\'utente',
    ),
    'edit' => 
    array (
      'label' => 'Modifica',
      'tooltip' => 'Modifica i dati dell\'utente',
      'modal_heading' => 'Modifica Utente',
      'modal_description' => 'Aggiorna le informazioni dell\'utente',
      'success' => 'Utente aggiornato con successo',
      'error' => 'Errore durante l\'aggiornamento dell\'utente',
    ),
    'delete' => 
    array (
      'label' => 'Elimina',
      'tooltip' => 'Elimina l\'utente',
      'confirmation' => 'Sei sicuro di voler eliminare questo utente? Questa azione non può essere annullata.',
      'success' => 'Utente eliminato con successo',
      'error' => 'Errore durante l\'eliminazione dell\'utente',
    ),
    'activate' => 
    array (
      'label' => 'Attiva',
      'tooltip' => 'Rendi l\'utente attivo',
      'confirmation' => 'Sei sicuro di voler attivare questo utente?',
      'success' => 'Utente attivato con successo',
      'error' => 'Errore durante l\'attivazione dell\'utente',
    ),
    'deactivate' => 
    array (
      'label' => 'Disattiva',
      'tooltip' => 'Disattiva temporaneamente l\'utente',
      'confirmation' => 'Sei sicuro di voler disattivare questo utente?',
      'success' => 'Utente disattivato con successo',
      'error' => 'Errore durante la disattivazione dell\'utente',
    ),
    'reset_password' => 
    array (
      'label' => 'Reset Password',
      'tooltip' => 'Invia una nuova password all\'utente',
      'modal_heading' => 'Reset Password',
      'modal_description' => 'Verrà generata una nuova password temporanea e inviata via email',
      'confirmation' => 'Sei sicuro di voler reimpostare la password di questo utente?',
      'success' => 'Password reimpostata con successo',
      'error' => 'Errore durante il reset della password',
    ),
    'apply_filters' => 
    array (
      'label' => 'Applica Filtri',
      'tooltip' => 'Applica i filtri selezionati',
    ),
    'reset_filters' => 
    array (
      'label' => 'Azzera Filtri',
      'tooltip' => 'Rimuovi tutti i filtri applicati',
    ),
    'open_filters' => 
    array (
      'label' => 'Apri Filtri',
      'tooltip' => 'Mostra pannello filtri',
    ),
    'toggle_columns' => 
    array (
      'label' => 'Mostra/Nascondi Colonne',
      'tooltip' => 'Personalizza le colonne visualizzate',
    ),
    'reorder_records' => 
    array (
      'label' => 'Riordina Record',
      'tooltip' => 'Riordina i record della tabella',
    ),
    'export_xls' => 
    array (
      'label' => 'export_xls',
    ),
  ),
  'filters' => 
  array (
    'active' => 
    array (
      'label' => 'Solo Attivi',
      'placeholder' => 'Filtra per utenti attivi',
      'help' => 'Mostra solo gli utenti attualmente attivi',
    ),
    'role' => 
    array (
      'label' => 'Per Ruolo',
      'placeholder' => 'Seleziona ruolo',
      'help' => 'Filtra per ruolo specifico',
    ),
    'type' => 
    array (
      'label' => 'Per Tipo',
      'placeholder' => 'Seleziona tipo',
      'help' => 'Filtra per tipologia di utente',
    ),
    'created_at' => 
    array (
      'label' => 'Data Registrazione',
      'placeholder' => 'Seleziona periodo',
      'help' => 'Filtra per periodo di registrazione',
    ),
  ),
  'bulk_actions' => 
  array (
    'activate_selected' => 
    array (
      'label' => 'Attiva Selezionati',
      'tooltip' => 'Attiva tutti gli utenti selezionati',
      'confirmation' => 'Sei sicuro di voler attivare tutti gli utenti selezionati?',
      'success' => 'Utenti attivati con successo',
      'error' => 'Errore durante l\'attivazione degli utenti',
    ),
    'deactivate_selected' => 
    array (
      'label' => 'Disattiva Selezionati',
      'tooltip' => 'Disattiva tutti gli utenti selezionati',
      'confirmation' => 'Sei sicuro di voler disattivare tutti gli utenti selezionati?',
      'success' => 'Utenti disattivati con successo',
      'error' => 'Errore durante la disattivazione degli utenti',
    ),
    'reset_password_selected' => 
    array (
      'label' => 'Reset Password Selezionati',
      'tooltip' => 'Reimposta password per tutti gli utenti selezionati',
      'modal_heading' => 'Reset Password Multiplo',
      'modal_description' => 'Verranno generate nuove password temporanee per tutti gli utenti selezionati',
      'confirmation' => 'Sei sicuro di voler reimpostare le password di tutti gli utenti selezionati?',
      'success' => 'Password reimpostate con successo',
      'error' => 'Errore durante il reset delle password',
    ),
    'delete_selected' => 
    array (
      'label' => 'Elimina Selezionati',
      'tooltip' => 'Elimina tutti gli utenti selezionati',
      'confirmation' => 'Sei sicuro di voler eliminare tutti gli utenti selezionati? Questa azione non può essere annullata.',
      'success' => 'Utenti eliminati con successo',
      'error' => 'Errore durante l\'eliminazione degli utenti',
    ),
  ),
  'messages' => 
  array (
    'activated_successfully' => 'Utente attivato con successo',
    'deactivated_successfully' => 'Utente disattivato con successo',
    'password_reset_successfully' => 'Password reimpostata con successo',
    'email_sent' => 'Email di notifica inviata',
    'empty_state' => 'Nessun utente trovato',
    'loading' => 'Caricamento utenti in corso...',
  ),
  'notifications' => 
  array (
    'created' => 'Utente creato con successo',
    'updated' => 'Utente aggiornato con successo',
    'deleted' => 'Utente eliminato con successo',
    'error' => 'Si è verificato un errore durante l\'operazione',
    'permission_denied' => 'Non hai i permessi per eseguire questa operazione',
  ),
  'validation' => 
  array (
    'required' => 'Il campo :attribute è obbligatorio',
    'email' => 'Il campo :attribute deve essere un indirizzo email valido',
    'unique' => 'Il valore del campo :attribute è già stato utilizzato',
    'min' => 
    array (
      'string' => 'Il campo :attribute deve contenere almeno :min caratteri',
    ),
    'max' => 
    array (
      'string' => 'Il campo :attribute non può superare :max caratteri',
    ),
    'confirmed' => 'La conferma del campo :attribute non corrisponde',
    'password_format' => 'La password deve contenere almeno 8 caratteri',
  ),
  'search' => 
  array (
    'placeholder' => 'Cerca per nome, email o ruolo...',
    'label' => 'Cerca',
    'help' => 'Inserisci il termine di ricerca',
  ),
  'empty_state' => 
  array (
    'heading' => 'Nessun utente trovato',
    'description' => 'Non sono stati trovati utenti corrispondenti ai criteri di ricerca',
    'action' => 'Aggiungi il primo utente',
  ),
  'sections' => 
  array (
    'personal_info' => 
    array (
      'label' => 'Informazioni Personali',
      'description' => 'Dati anagrafici dell\'utente',
    ),
    'account_settings' => 
    array (
      'label' => 'Impostazioni Account',
      'description' => 'Configurazioni di accesso e sicurezza',
    ),
    'permissions' => 
    array (
      'label' => 'Permessi',
      'description' => 'Ruoli e autorizzazioni assegnate',
    ),
  ),
  'roles' => 
  array (
    'admin' => 'Amministratore',
    'user' => 'Utente',
    'moderator' => 'Moderatore',
    'guest' => 'Ospite',
  ),
  'statuses' => 
  array (
    'active' => 'Attivo',
    'inactive' => 'Inattivo',
    'pending' => 'In attesa',
    'suspended' => 'Sospeso',
  ),
);
