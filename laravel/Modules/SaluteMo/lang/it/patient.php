<?php

return array (
  'navigation' => 
  array (
    'label' => 'Pazienti',
    'group' => 'Gestione Utenti',
    'icon' => 'heroicon-o-users',
    'sort' => 20,
  ),
  'model' => 
  array (
    'label' => 'Paziente',
    'plural' => 'Pazienti',
  ),
  'pages' => 
  array (
    'index' => 
    array (
      'title' => 'Elenco Pazienti',
      'subtitle' => 'Gestisci i pazienti registrati nell\'app mobile',
    ),
    'create' => 
    array (
      'title' => 'Nuovo Paziente',
      'subtitle' => 'Registra un nuovo paziente',
    ),
    'edit' => 
    array (
      'title' => 'Modifica Paziente',
      'subtitle' => 'Modifica le informazioni del paziente',
    ),
    'view' => 
    array (
      'title' => 'Dettagli Paziente',
      'subtitle' => 'Visualizza le informazioni complete del paziente',
    ),
  ),
  'fields' => 
  array (
    'full_name' => 
    array (
      'label' => 'Nome e Cognome',
      'placeholder' => 'Inserisci nome e cognome completi',
      'helper_text' => 'Nome e cognome del paziente',
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
    'fiscal_code' => 
    array (
      'label' => 'Codice Fiscale',
      'placeholder' => 'RSSMRA80A01H501Z',
      'helper_text' => 'Codice fiscale del paziente',
    ),
    'birth_date' => 
    array (
      'label' => 'Data di Nascita',
      'placeholder' => 'Seleziona la data',
      'helper_text' => 'Data di nascita del paziente',
    ),
    'gender' => 
    array (
      'label' => 'Sesso',
      'placeholder' => 'Seleziona il sesso',
      'helper_text' => 'Sesso del paziente',
      'options' => 
      array (
        'male' => 'Maschio',
        'female' => 'Femmina',
        'other' => 'Altro',
      ),
    ),
    'address' => 
    array (
      'label' => 'Indirizzo',
      'placeholder' => 'Via Roma, 123',
      'helper_text' => 'Indirizzo di residenza',
    ),
    'city' => 
    array (
      'label' => 'Città',
      'placeholder' => 'Milano',
      'helper_text' => 'Città di residenza',
    ),
    'postal_code' => 
    array (
      'label' => 'CAP',
      'placeholder' => '20100',
      'helper_text' => 'Codice di avviamento postale',
    ),
    'emergency_contact_name' => 
    array (
      'label' => 'Contatto Emergenza - Nome',
      'placeholder' => 'Nome del contatto di emergenza',
      'helper_text' => 'Nome della persona da contattare in caso di emergenza',
    ),
    'emergency_contact_phone' => 
    array (
      'label' => 'Contatto Emergenza - Telefono',
      'placeholder' => '+39 123 456 7890',
      'helper_text' => 'Telefono del contatto di emergenza',
    ),
    'allergies' => 
    array (
      'label' => 'Allergie',
      'placeholder' => 'Elenco delle allergie note',
      'helper_text' => 'Allergie note del paziente',
    ),
    'medications' => 
    array (
      'label' => 'Farmaci',
      'placeholder' => 'Farmaci attualmente assunti',
      'helper_text' => 'Farmaci che il paziente sta assumendo',
    ),
    'medical_history' => 
    array (
      'label' => 'Storia Clinica',
      'placeholder' => 'Note sulla storia clinica',
      'helper_text' => 'Informazioni rilevanti sulla storia clinica',
    ),
    'is_active' => 
    array (
      'label' => 'Attivo',
      'helper_text' => 'Il paziente può prenotare visite',
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
  ),
  'actions' => 
  array (
    'view_medical_history' => 
    array (
      'label' => 'Storia Clinica',
      'icon' => 'heroicon-o-document-text',
      'tooltip' => 'Visualizza la storia clinica del paziente',
    ),
    'view_appointments' => 
    array (
      'label' => 'Appuntamenti',
      'icon' => 'heroicon-o-calendar-days',
      'tooltip' => 'Visualizza gli appuntamenti del paziente',
    ),
    'send_notification' => 
    array (
      'label' => 'Invia Notifica',
      'icon' => 'heroicon-o-bell',
      'tooltip' => 'Invia una notifica push al paziente',
    ),
    'deactivate' => 
    array (
      'label' => 'Disattiva',
      'icon' => 'heroicon-o-x-circle',
      'tooltip' => 'Disattiva temporaneamente il paziente',
    ),
    'add_medical_note' => 
    array (
      'label' => 'Aggiungi Nota',
      'icon' => 'heroicon-o-plus-circle',
      'tooltip' => 'Aggiungi una nota medica',
    ),
  ),
  'filters' => 
  array (
    'active' => 
    array (
      'label' => 'Solo Attivi',
    ),
    'gender' => 
    array (
      'label' => 'Per Sesso',
    ),
    'age_range' => 
    array (
      'label' => 'Fascia d\'Età',
    ),
    'city' => 
    array (
      'label' => 'Per Città',
    ),
  ),
  'bulk_actions' => 
  array (
    'send_notification_selected' => 
    array (
      'label' => 'Notifica Selezionati',
      'icon' => 'heroicon-o-bell',
    ),
    'export_selected' => 
    array (
      'label' => 'Esporta Selezionati',
      'icon' => 'heroicon-o-arrow-down-tray',
    ),
  ),
  'messages' => 
  array (
    'deactivated_successfully' => 'Paziente disattivato con successo',
    'notification_sent' => 'Notifica inviata con successo',
    'medical_note_added' => 'Nota medica aggiunta con successo',
    'export_completed' => 'Esportazione completata',
  ),
  'search_placeholder' => 'Cerca per nome, email, telefono o codice fiscale...',
);
