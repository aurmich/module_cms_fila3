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
      'placeholder' => '',
      'helper_text' => '',
    ),
    'name' => 
    array (
      'label' => 'Nome',
      'placeholder' => 'Mario Rossi',
      'helper_text' => 'Nome completo dell\'utente',
    ),
    'email' => 
    array (
      'label' => 'Email',
      'placeholder' => 'utente@email.com',
      'helper_text' => 'Indirizzo email per l\'accesso',
    ),
    'role' => 
    array (
      'label' => 'Ruolo',
      'placeholder' => 'Seleziona il ruolo',
      'helper_text' => 'Ruolo assegnato all\'utente',
    ),
    'active' => 
    array (
      'label' => 'Attivo',
      'placeholder' => '',
      'helper_text' => 'L\'utente è attivo e può accedere',
    ),
    'created_at' => 
    array (
      'label' => 'Data Creazione',
      'placeholder' => '',
      'helper_text' => 'Data di registrazione dell\'utente',
    ),
    'updated_at' => 
    array (
      'label' => 'Ultima Modifica',
      'placeholder' => '',
      'helper_text' => 'Data ultima modifica profilo',
    ),
    'toggleColumns' => 
    array (
      'label' => 'toggleColumns',
    ),
  ),
  'actions' => 
  array (
    'activate' => 
    array (
      'label' => 'Attiva',
      'icon' => 'heroicon-o-check-circle',
      'tooltip' => 'Rendi l\'utente attivo',
    ),
    'deactivate' => 
    array (
      'label' => 'Disattiva',
      'icon' => 'heroicon-o-x-circle',
      'tooltip' => 'Disattiva temporaneamente l\'utente',
    ),
    'reset_password' => 
    array (
      'label' => 'Reset Password',
      'icon' => 'heroicon-o-key',
      'tooltip' => 'Invia una nuova password all\'utente',
    ),
  ),
  'filters' => 
  array (
    'active' => 
    array (
      'label' => 'Solo Attivi',
    ),
    'role' => 
    array (
      'label' => 'Per Ruolo',
    ),
  ),
  'bulk_actions' => 
  array (
    'activate_selected' => 
    array (
      'label' => 'Attiva Selezionati',
      'icon' => 'heroicon-o-check-circle',
    ),
    'deactivate_selected' => 
    array (
      'label' => 'Disattiva Selezionati',
      'icon' => 'heroicon-o-x-circle',
    ),
    'reset_password_selected' => 
    array (
      'label' => 'Reset Password Selezionati',
      'icon' => 'heroicon-o-key',
    ),
  ),
  'messages' => 
  array (
    'activated_successfully' => 'Utente attivato con successo',
    'deactivated_successfully' => 'Utente disattivato con successo',
    'password_reset_successfully' => 'Password reimpostata con successo',
  ),
  'search_placeholder' => 'Cerca per nome, email o ruolo...',
);
