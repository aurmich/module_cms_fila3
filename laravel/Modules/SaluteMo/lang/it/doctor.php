<?php

return array (
  'navigation' => 
  array (
    'label' => 'Medici',
    'group' => 'Gestione Utenti',
    'icon' => 'heroicon-o-user-plus',
    'sort' => 10,
  ),
  'model' => 
  array (
    'label' => 'Medico',
    'plural' => 'Medici',
  ),
  'pages' => 
  array (
    'index' => 
    array (
      'title' => 'Elenco Medici',
      'subtitle' => 'Gestisci i medici registrati nell\'app mobile',
    ),
    'create' => 
    array (
      'title' => 'Nuovo Medico',
      'subtitle' => 'Registra un nuovo medico',
    ),
    'edit' => 
    array (
      'title' => 'Modifica Medico',
      'subtitle' => 'Modifica le informazioni del medico',
    ),
    'view' => 
    array (
      'title' => 'Dettagli Medico',
      'subtitle' => 'Visualizza le informazioni complete del medico',
    ),
  ),
  'fields' => 
  array (
    'full_name' => 
    array (
      'label' => 'Nome e Cognome',
      'placeholder' => 'Inserisci nome e cognome completi',
      'helper_text' => 'Nome e cognome come registrati nell\'Ordine dei Medici',
    ),
    'email' => 
    array (
      'label' => 'Email',
      'placeholder' => 'email@esempio.com',
      'helper_text' => 'Indirizzo email per le comunicazioni',
    ),
    'phone' => 
    array (
      'label' => 'Telefono',
      'placeholder' => '+39 123 456 7890',
      'helper_text' => 'Numero di telefono principale',
    ),
    'mobile_phone' => 
    array (
      'label' => 'Cellulare',
      'placeholder' => '+39 123 456 7890',
      'helper_text' => 'Numero di cellulare per le notifiche push',
    ),
    'license_number' => 
    array (
      'label' => 'Numero Iscrizione Ordine',
      'placeholder' => 'Inserisci il numero di iscrizione',
      'helper_text' => 'Numero di iscrizione all\'Ordine dei Medici',
    ),
    'specialization' => 
    array (
      'label' => 'Specializzazione',
      'placeholder' => 'Seleziona la specializzazione',
      'helper_text' => 'Specializzazione medica principale',
    ),
    'clinic_address' => 
    array (
      'label' => 'Indirizzo Studio',
      'placeholder' => 'Via Roma, 123',
      'helper_text' => 'Indirizzo dello studio medico',
    ),
    'is_active' => 
    array (
      'label' => 'Attivo',
      'helper_text' => 'Il medico può ricevere prenotazioni',
    ),
    'verified_at' => 
    array (
      'label' => 'Data Verifica',
      'helper_text' => 'Data di verifica della documentazione',
    ),
    'device_token' => 
    array (
      'label' => 'Token Dispositivo',
      'helper_text' => 'Token per le notifiche push',
    ),
    'last_login' => 
    array (
      'label' => 'Ultimo Accesso',
      'helper_text' => 'Data e ora dell\'ultimo accesso all\'app',
    ),
    'reset_filters' => 
    array (
      'label' => 'Azzera Filtri',
    ),
    'apply_filters' => 
    array (
      'label' => 'Applica Filtri',
    ),
    'open_filters' => 
    array (
      'label' => 'Apri Filtri',
    ),
    'toggle_columns' => 
    array (
      'label' => 'Mostra/Nascondi Colonne',
    ),
    'reorder_records' => 
    array (
      'label' => 'Riordina Record',
    ),
    'applyFilters' => 
    array (
      'label' => 'applyFilters',
    ),
    'toggleColumns' => 
    array (
      'label' => 'toggleColumns',
    ),
    'reorderRecords' => 
    array (
      'label' => 'reorderRecords',
    ),
  ),
  'actions' => 
  array (
    'verify' => 
    array (
      'label' => 'Verifica',
      'icon' => 'heroicon-o-check-circle',
      'tooltip' => 'Verifica la documentazione del medico',
    ),
    'deactivate' => 
    array (
      'label' => 'Disattiva',
      'icon' => 'heroicon-o-x-circle',
      'tooltip' => 'Disattiva temporaneamente il medico',
    ),
    'send_notification' => 
    array (
      'label' => 'Invia Notifica',
      'icon' => 'heroicon-o-bell',
      'tooltip' => 'Invia una notifica push al medico',
    ),
    'view_appointments' => 
    array (
      'label' => 'Vedi Appuntamenti',
      'icon' => 'heroicon-o-calendar-days',
      'tooltip' => 'Visualizza gli appuntamenti del medico',
    ),
  ),
  'filters' => 
  array (
    'active' => 
    array (
      'label' => 'Solo Attivi',
    ),
    'verified' => 
    array (
      'label' => 'Solo Verificati',
    ),
    'specialization' => 
    array (
      'label' => 'Per Specializzazione',
    ),
  ),
  'bulk_actions' => 
  array (
    'verify_selected' => 
    array (
      'label' => 'Verifica Selezionati',
      'icon' => 'heroicon-o-check-circle',
    ),
    'send_notification_selected' => 
    array (
      'label' => 'Notifica Selezionati',
      'icon' => 'heroicon-o-bell',
    ),
  ),
  'messages' => 
  array (
    'verified_successfully' => 'Medico verificato con successo',
    'deactivated_successfully' => 'Medico disattivato con successo',
    'notification_sent' => 'Notifica inviata con successo',
    'verification_required' => 'È necessaria la verifica della documentazione',
  ),
  'search_placeholder' => 'Cerca per nome, email, telefono o numero iscrizione...',
);
