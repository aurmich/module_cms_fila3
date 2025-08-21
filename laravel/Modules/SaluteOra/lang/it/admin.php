<?php

return array (
  'model' => 
  array (
    'label' => 'Amministratore',
    'plural' => 'Amministratori',
    'description' => 'Gestione del personale amministrativo e di segreteria',
    'icon' => 'heroicon-o-user-group',
  ),
  'navigation' => 
  array (
    'label' => 'BackOffice',
    'group' => 'Gestione Utenti',
    'icon' => 'saluteora-admin',
    'color' => 'purple',
    'sort' => 95,
    'tooltip' => 'Gestisci il personale amministrativo e di segreteria',
  ),
  'pages' => 
  array (
    'index' => 
    array (
      'title' => 'Elenco Amministratori',
      'subtitle' => 'Gestisci il team amministrativo',
      'description' => 'Visualizza e gestisci tutti gli amministratori registrati',
    ),
    'create' => 
    array (
      'title' => 'Nuovo Amministratore',
      'subtitle' => 'Registra un nuovo amministratore',
      'description' => 'Aggiungi un nuovo amministratore al team',
    ),
    'edit' => 
    array (
      'title' => 'Modifica Amministratore',
      'subtitle' => 'Aggiorna i dati dell\'amministratore',
      'description' => 'Modifica le informazioni dell\'amministratore selezionato',
    ),
    'view' => 
    array (
      'title' => 'Dettagli Amministratore',
      'subtitle' => 'Visualizzazione profilo completo',
      'description' => 'Consulta tutti i dati dell\'amministratore selezionato',
    ),
  ),
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
      'placeholder' => 'Identificativo dell\'amministratore',
      'tooltip' => 'Identificativo univoco dell\'amministratore',
      'helper_text' => '',
      'description' => 'Identificativo univoco dell\'amministratore',
    ),
    'first_name' => 
    array (
      'label' => 'Nome',
      'placeholder' => 'Inserisci il nome',
      'tooltip' => 'Nome dell\'amministratore',
      'helper_text' => '',
      'description' => 'Nome anagrafico dell\'amministratore',
    ),
    'last_name' => 
    array (
      'label' => 'Cognome',
      'placeholder' => 'Inserisci il cognome',
      'tooltip' => 'Cognome dell\'amministratore',
      'helper_text' => '',
      'description' => 'Cognome anagrafico dell\'amministratore',
    ),
    'email' => 
    array (
      'label' => 'Email',
      'placeholder' => 'admin@example.com',
      'tooltip' => 'Indirizzo email professionale',
      'helper_text' => '',
      'description' => 'Indirizzo email per comunicazioni professionali',
    ),
    'phone' => 
    array (
      'label' => 'Telefono',
      'placeholder' => '+39 123 456 7890',
      'tooltip' => 'Numero di telefono professionale',
      'helper_text' => '',
      'description' => 'Numero di telefono per contatti professionali',
    ),
    'role' => 
    array (
      'label' => 'Ruolo',
      'placeholder' => 'Seleziona il ruolo',
      'tooltip' => 'Ruolo amministrativo',
      'helper_text' => '',
      'description' => 'Ruolo e responsabilità amministrative',
    ),
    'department' => 
    array (
      'label' => 'Dipartimento',
      'placeholder' => 'Seleziona il dipartimento',
      'tooltip' => 'Dipartimento di appartenenza',
      'helper_text' => '',
      'description' => 'Dipartimento o area di competenza',
    ),
    'applyFilters' => 
    array (
      'label' => 'Applica Filtri',
      'placeholder' => 'Applica filtri selezionati',
      'tooltip' => 'Applica i filtri di ricerca',
      'helper_text' => '',
      'description' => 'Applicazione filtri di ricerca',
    ),
    'toggleColumns' => 
    array (
      'label' => 'Mostra/Nascondi Colonne',
      'placeholder' => 'Gestisci colonne',
      'tooltip' => 'Gestisci visibilità colonne',
      'helper_text' => '',
      'description' => 'Controllo colonne tabella',
    ),
    'reorderRecords' => 
    array (
      'label' => 'Riordina Record',
      'placeholder' => 'Riordina elementi',
      'tooltip' => 'Modifica l\'ordine dei record',
      'helper_text' => '',
      'description' => 'Riordinamento elementi tabella',
    ),
    'resetFilters' => 
    array (
      'label' => 'Reimposta Filtri',
      'placeholder' => 'Cancella tutti i filtri',
      'tooltip' => 'Rimuovi tutti i filtri applicati',
      'helper_text' => '',
      'description' => 'Reset filtri di ricerca',
    ),
    'openFilters' => 
    array (
      'label' => 'openFilters',
    ),
    'value' => 
    array (
      'description' => 'value',
      'helper_text' => '',
      'label' => 'value',
      'placeholder' => 'value',
    ),
    'name' => 
    array (
      'label' => 'name',
    ),
    'type' => 
    array (
      'label' => 'type',
      'description' => 'type',
      'helper_text' => '',
      'placeholder' => 'type',
    ),
    'state' => 
    array (
      'label' => 'state',
      'description' => 'state',
      'helper_text' => '',
      'placeholder' => 'state',
    ),
    'create' => 
    array (
      'label' => 'create',
    ),
    'layout' => 
    array (
      'label' => 'layout',
    ),
    'changePassword' => 
    array (
      'label' => 'changePassword',
    ),
    'view' => 
    array (
      'label' => 'view',
    ),
    'edit' => 
    array (
      'label' => 'edit',
    ),
    'delete' => 
    array (
      'label' => 'delete',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Registra Nuovo Amministratore',
      'modal_heading' => 'Registrazione Amministratore',
      'modal_description' => 'Compila tutti i campi per registrare un nuovo amministratore',
      'success' => 'Amministratore registrato con successo',
      'error' => 'Errore durante la registrazione dell\'amministratore',
    ),
    'edit' => 
    array (
      'label' => 'Modifica Dati',
      'modal_heading' => 'Modifica Informazioni Amministratore',
      'modal_description' => 'Aggiorna le informazioni dell\'amministratore selezionato',
      'success' => 'Dati amministratore aggiornati con successo',
      'error' => 'Errore durante l\'aggiornamento dei dati',
    ),
    'view' => 
    array (
      'label' => 'Visualizza Dettagli',
      'modal_heading' => 'Profilo Completo Amministratore',
      'modal_description' => 'Visualizza tutti i dati dell\'amministratore selezionato',
    ),
    'delete' => 
    array (
      'label' => 'Elimina Amministratore',
      'modal_heading' => 'Conferma Eliminazione',
      'modal_description' => 'Sei sicuro di voler eliminare definitivamente questo amministratore?',
      'success' => 'Amministratore eliminato dal sistema',
      'error' => 'Errore durante l\'eliminazione',
      'confirmation' => 'Questa operazione non può essere annullata',
    ),
    'export_xls' => 
    array (
      'label' => 'export_xls',
    ),
  ),
  'widgets' => 
  array (
    'user_type_registrations_chart' => 
    array (
      'heading' => 'Registrazioni Amministratori nel Tempo',
      'description' => 'Grafico che mostra l\'andamento delle registrazioni amministratori',
      'label' => 'Nuove registrazioni',
      'tooltip' => 'Numero di amministratori registrati per periodo',
    ),
    'states_chart' => 
    array (
      'heading' => 'Distribuzione Stati Amministratori',
      'description' => 'Grafico che mostra la distribuzione degli stati degli amministratori',
      'label' => 'Stati amministratori',
      'tooltip' => 'Distribuzione degli amministratori per stato',
    ),
  ),
  'states' => 
  array (
    'active' => 
    array (
      'label' => 'Attivo',
      'description' => 'Amministratore attivo nel sistema',
      'tooltip' => 'L\'amministratore è attivo e può accedere al sistema',
      'color' => 'success',
      'icon' => 'heroicon-o-check-circle',
    ),
    'pending' => 
    array (
      'label' => 'In Attesa',
      'description' => 'Amministratore in attesa di approvazione',
      'tooltip' => 'L\'amministratore è in attesa di essere approvato',
      'color' => 'warning',
      'icon' => 'heroicon-o-clock',
    ),
    'inactive' => 
    array (
      'label' => 'Non Attivo',
      'description' => 'Amministratore non attivo nel sistema',
      'tooltip' => 'L\'amministratore è stato disattivato',
      'color' => 'danger',
      'icon' => 'heroicon-o-x-circle',
    ),
    'rejected' => 
    array (
      'label' => 'Rifiutato',
      'description' => 'Registrazione amministratore rifiutata',
      'tooltip' => 'La registrazione dell\'amministratore è stata rifiutata',
      'color' => 'danger',
      'icon' => 'heroicon-o-x-mark',
    ),
    'suspended' => 
    array (
      'label' => 'Sospeso',
      'description' => 'Amministratore sospeso temporaneamente',
      'tooltip' => 'L\'amministratore è stato sospeso temporaneamente',
      'color' => 'warning',
      'icon' => 'heroicon-o-pause',
    ),
    'integration_requested' => 
    array (
      'label' => 'Integrazione Richiesta',
      'description' => 'Richiesta integrazione documentale',
      'tooltip' => 'L\'amministratore deve integrare la documentazione',
      'color' => 'info',
      'icon' => 'heroicon-o-document-plus',
    ),
    'integration_completed' => 
    array (
      'label' => 'Integrazione Completata',
      'description' => 'Integrazione documentale completata',
      'tooltip' => 'L\'amministratore ha completato l\'integrazione della documentazione',
      'color' => 'success',
      'icon' => 'heroicon-o-document-check',
    ),
  ),
  'messages' => 
  array (
    'welcome' => 'Benvenuto nella gestione amministratori',
    'registration_success' => 'Registrazione completata con successo',
    'validation_errors' => 'Controlla i campi evidenziati e riprova',
    'empty_state' => 'Nessun amministratore registrato nel sistema',
    'search_no_results' => 'Nessun amministratore trovato con i criteri di ricerca specificati',
  ),
);
