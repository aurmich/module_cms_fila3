<?php

return array (
  'navigation' => 
  array (
    'label' => 'Utenti Generici',
    'group' => 'Gestione Utenti',
    'icon' => 'heroicon-o-user',
    'color' => 'primary',
    'sort' => 44,
  ),
  'model' => 
  array (
    'label' => 'Utente',
    'plural' => 'Utenti',
    'description' => 'Gestione utenti del sistema sanitario',
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID Utente',
      'placeholder' => 'Identificativo numerico automatico',
      'help' => 'Codice identificativo univoco dell\'utente nel sistema',
    ),
    'name' => 
    array (
      'label' => 'Nome Completo',
      'placeholder' => 'Inserisci nome e cognome dell\'utente',
      'help' => 'Nome e cognome completi dell\'utente per identificazione',
    ),
    'first_name' => 
    array (
      'label' => 'Nome',
      'placeholder' => 'Inserisci il nome',
      'help' => 'Nome di battesimo dell\'utente',
    ),
    'last_name' => 
    array (
      'label' => 'Cognome',
      'placeholder' => 'Inserisci il cognome',
      'help' => 'Cognome di famiglia dell\'utente',
    ),
    'email' => 
    array (
      'label' => 'Indirizzo Email',
      'placeholder' => 'Inserisci email valida (es. utente@esempio.it)',
      'help' => 'Indirizzo email per accesso al sistema e comunicazioni',
      'validation' => 
      array (
        'required' => 'L\'email è obbligatoria',
        'email' => 'Inserisci un indirizzo email valido',
        'unique' => 'Questo indirizzo email è già in uso',
      ),
    ),
    'password' => 
    array (
      'label' => 'Password di Accesso',
      'placeholder' => 'Inserisci una password sicura (min. 8 caratteri)',
      'help' => 'Password per l\'accesso al sistema (minimo 8 caratteri)',
      'validation' => 
      array (
        'required' => 'La password è obbligatoria',
        'min' => 'La password deve essere di almeno 8 caratteri',
        'confirmed' => 'Le password non corrispondono',
      ),
    ),
    'password_confirmation' => 
    array (
      'label' => 'Conferma Password',
      'placeholder' => 'Ripeti la password inserita sopra',
      'help' => 'Conferma della password per verificare la correttezza',
    ),
    'phone' => 
    array (
      'label' => 'Numero di Telefono',
      'placeholder' => 'Inserisci numero telefono (es. +39 333 123 4567)',
      'help' => 'Numero di telefono per contatti diretti e urgenze',
    ),
    'address' => 
    array (
      'label' => 'Indirizzo',
      'placeholder' => 'Inserisci indirizzo completo',
      'help' => 'Indirizzo di residenza o studio dell\'utente',
    ),
    'city' => 
    array (
      'label' => 'Città',
      'placeholder' => 'Inserisci nome della città',
      'help' => 'Città di residenza o lavoro dell\'utente',
    ),
    'type' => 
    array (
      'label' => 'Tipo Utente',
      'placeholder' => 'Seleziona il tipo di utente dal menu',
      'help' => 'Classificazione dell\'utente nel sistema sanitario',
      'options' => 
      array (
        'patient' => 'Paziente',
        'doctor' => 'Dottore/Medico',
        'admin' => 'Amministratore',
      ),
    ),
    'state' => 
    array (
      'label' => 'Stato Account',
      'placeholder' => 'Seleziona lo stato dell\'account',
      'help' => 'Stato attuale dell\'account utente nel sistema',
      'options' => 
      array (
        'pending' => 'In Attesa di Approvazione',
        'approved' => 'Approvato e Attivo',
        'rejected' => 'Rifiutato',
        'integration_requested' => 'Integrazione Documenti Richiesta',
        'suspended' => 'Sospeso Temporaneamente',
      ),
    ),
    'registration_number' => 
    array (
      'label' => 'Numero di Iscrizione',
      'placeholder' => 'Inserisci numero iscrizione albo (per medici)',
      'help' => 'Numero di iscrizione all\'albo professionale (obbligatorio per medici)',
    ),
    'status' => 
    array (
      'label' => 'Status Sistema',
      'placeholder' => 'Status tecnico dell\'account',
      'help' => 'Status tecnico dell\'account nel sistema',
    ),
    'certifications' => 
    array (
      'label' => 'Certificazioni Professionali',
      'placeholder' => 'Elenca certificazioni e specializzazioni',
      'help' => 'Elenco delle certificazioni professionali e specializzazioni mediche',
    ),
    'moderation_data' => 
    array (
      'label' => 'Dati di Moderazione',
      'placeholder' => 'Informazioni amministrative interne',
      'help' => 'Dati interni per la moderazione e gestione dell\'account',
    ),
    'roles' => 
    array (
      'label' => 'Ruoli Assegnati',
      'placeholder' => 'Seleziona i ruoli dell\'utente',
      'help' => 'Ruoli e permessi assegnati all\'utente nel sistema',
    ),
    'created_at' => 
    array (
      'label' => 'Data Registrazione',
      'placeholder' => 'Data di creazione automatica',
      'help' => 'Data e ora di registrazione dell\'utente nel sistema',
    ),
    'updated_at' => 
    array (
      'label' => 'Ultimo Aggiornamento',
      'placeholder' => 'Data ultima modifica automatica',
      'help' => 'Data e ora dell\'ultima modifica ai dati dell\'utente',
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
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Crea Nuovo Utente',
      'modal_heading' => 'Registrazione Nuovo Utente',
      'modal_description' => 'Compila tutti i campi per registrare un nuovo utente nel sistema',
      'success' => 'Utente creato con successo',
      'error' => 'Errore durante la creazione dell\'utente',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Utente',
      'modal_heading' => 'Modifica Dati Utente',
      'modal_description' => 'Aggiorna le informazioni dell\'utente selezionato',
      'success' => 'Dati utente aggiornati con successo',
      'error' => 'Errore durante l\'aggiornamento dei dati',
      'icon' => 'heroicon-o-pencil',
      'color' => 'primary',
    ),
    'view' => 
    array (
      'label' => 'Visualizza Dettagli',
      'modal_heading' => 'Dettagli Completi Utente',
      'modal_description' => 'Visualizza tutte le informazioni dell\'utente',
      'icon' => 'heroicon-o-eye',
      'color' => 'gray',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Utente',
      'modal_heading' => 'Conferma Eliminazione Utente',
      'modal_description' => 'Sei sicuro di voler eliminare definitivamente questo utente?',
      'success' => 'Utente eliminato dal sistema',
      'error' => 'Errore durante l\'eliminazione dell\'utente',
      'confirmation' => 'Questa operazione eliminerà definitivamente l\'utente e tutti i dati associati',
      'icon' => 'heroicon-o-trash',
      'color' => 'danger',
    ),
    'approve' => 
    array (
      'label' => 'Approva Account',
      'modal_heading' => 'Approvazione Account Utente',
      'modal_description' => 'Conferma l\'approvazione dell\'account utente per l\'accesso al sistema',
      'success' => 'Account utente approvato con successo',
      'error' => 'Errore durante l\'approvazione dell\'account',
      'confirmation' => 'Confermi l\'approvazione di questo account utente?',
      'icon' => 'heroicon-o-check-circle',
      'color' => 'success',
    ),
    'reject' => 
    array (
      'label' => 'Rifiuta Account',
      'modal_heading' => 'Rifiuto Account Utente',
      'modal_description' => 'Indica il motivo del rifiuto dell\'account utente',
      'success' => 'Account utente rifiutato',
      'error' => 'Errore durante il rifiuto dell\'account',
      'confirmation' => 'Confermi il rifiuto di questo account utente?',
      'icon' => 'heroicon-o-x-circle',
      'color' => 'danger',
    ),
    'request_integration' => 
    array (
      'label' => 'Richiedi Integrazione Documenti',
      'modal_heading' => 'Richiesta Integrazione Documentale',
      'modal_description' => 'Richiedi all\'utente di integrare documenti mancanti o non conformi',
      'success' => 'Richiesta di integrazione inviata all\'utente',
      'error' => 'Errore durante l\'invio della richiesta di integrazione',
      'confirmation' => 'Vuoi richiedere l\'integrazione di documenti a questo utente?',
      'icon' => 'heroicon-o-document-plus',
      'color' => 'warning',
    ),
    'suspend' => 
    array (
      'label' => 'Sospendi Account',
      'modal_heading' => 'Sospensione Account Utente',
      'modal_description' => 'Sospendi temporaneamente l\'accesso dell\'utente al sistema',
      'success' => 'Account utente sospeso temporaneamente',
      'error' => 'Errore durante la sospensione dell\'account',
      'confirmation' => 'Confermi la sospensione temporanea di questo account?',
      'icon' => 'heroicon-o-pause-circle',
      'color' => 'warning',
    ),
    'reinstate' => 
    array (
      'label' => 'Ripristina Account',
      'modal_heading' => 'Ripristino Account Utente',
      'modal_description' => 'Ripristina l\'accesso dell\'utente precedentemente sospeso',
      'success' => 'Account utente ripristinato con successo',
      'error' => 'Errore durante il ripristino dell\'account',
      'confirmation' => 'Confermi il ripristino di questo account utente?',
      'icon' => 'heroicon-o-play-circle',
      'color' => 'success',
    ),
  ),
  'messages' => 
  array (
    'welcome' => 'Benvenuto nella gestione utenti del sistema',
    'loading' => 'Caricamento dati utenti in corso...',
    'empty_state' => 'Nessun utente registrato nel sistema',
    'search_no_results' => 'Nessun utente trovato con i criteri specificati',
    'validation_errors' => 'Controlla i campi evidenziati e correggi gli errori',
    'account_created' => 'Account utente creato e email di benvenuto inviata',
    'password_reset_sent' => 'Email per il reset della password inviata all\'utente',
  ),
  'filters' => 
  array (
    'all' => 'Tutti gli Utenti',
    'by_type' => 'Filtra per Tipo',
    'by_state' => 'Filtra per Stato',
    'pending_approval' => 'In Attesa di Approvazione',
    'approved' => 'Utenti Approvati',
    'suspended' => 'Utenti Sospesi',
    'recent' => 'Registrati di Recente',
  ),
  'notifications' => 
  array (
    'account_approved' => 'Il tuo account è stato approvato e puoi ora accedere al sistema',
    'account_rejected' => 'Il tuo account è stato rifiutato. Contatta l\'assistenza per maggiori informazioni',
    'integration_requested' => 'È richiesta l\'integrazione di documenti per completare la registrazione',
    'account_suspended' => 'Il tuo account è stato temporaneamente sospeso',
    'account_reinstated' => 'Il tuo account è stato ripristinato e puoi accedere nuovamente',
  ),
  'states' => [
    'pending' => [
      'label' => 'In Attesa',
      'description' => 'Account in attesa di approvazione amministrativa',
      'modal_heading' => 'Stato: In Attesa di Approvazione',
      'modal_description' => 'L\'account è in attesa di verifica e approvazione da parte dell\'amministrazione. Riceverai una notifica una volta completato il processo.',
      'icon' => 'heroicon-o-clock',
      'color' => 'warning',
    ],
    'active' => [
      'label' => 'Attivo',
      'description' => 'Account attivo e operativo nel sistema',
      'modal_heading' => 'Stato: Account Attivo',
      'modal_description' => 'L\'account è attivo e l\'utente ha pieno accesso a tutte le funzionalità del sistema sanitario.',
      'icon' => 'heroicon-o-check-circle',
      'color' => 'success',
    ],
    'inactive' => [
      'label' => 'Inattivo',
      'description' => 'Account temporaneamente disattivato',
      'modal_heading' => 'Stato: Account Inattivo',
      'modal_description' => 'L\'account è temporaneamente inattivo. Contattare l\'amministrazione per informazioni sulla riattivazione.',
      'icon' => 'heroicon-o-minus-circle',
      'color' => 'gray',
    ],
    'rejected' => [
      'label' => 'Rifiutato',
      'description' => 'Account rifiutato dall\'amministrazione',
      'modal_heading' => 'Stato: Account Rifiutato',
      'modal_description' => 'L\'account è stato rifiutato dall\'amministrazione. Per maggiori informazioni sui motivi del rifiuto, contattare il supporto.',
      'icon' => 'heroicon-o-x-circle',
      'color' => 'danger',
    ],
    'suspended' => [
      'label' => 'Sospeso',
      'description' => 'Account temporaneamente sospeso',
      'modal_heading' => 'Stato: Account Sospeso',
      'modal_description' => 'L\'account è stato temporaneamente sospeso. Durante la sospensione l\'accesso al sistema è limitato o bloccato.',
      'icon' => 'heroicon-o-pause-circle',
      'color' => 'warning',
    ],
    'integration_requested' => [
      'label' => 'Integrazione Richiesta',
      'description' => 'Richiesta integrazione documenti',
      'modal_heading' => 'Stato: Integrazione Documenti Richiesta',
      'modal_description' => 'È stata richiesta l\'integrazione di documenti aggiuntivi per completare la registrazione. Caricare i documenti richiesti per procedere.',
      'icon' => 'heroicon-o-document-plus',
      'color' => 'warning',
    ],
    'integration_completed' => [
      'label' => 'Integrazione Completata',
      'description' => 'Integrazione documenti completata',
      'modal_heading' => 'Stato: Integrazione Documenti Completata',
      'modal_description' => 'L\'integrazione dei documenti è stata completata con successo. L\'account è ora in fase di revisione finale.',
      'icon' => 'heroicon-o-document-check',
      'color' => 'info',
    ],
  ],
);
