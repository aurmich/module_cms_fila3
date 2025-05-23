<?php

return array (
  'fields' => 
  array (
    'id' => 
    array (
      'label' => 'ID',
    ),
    'name' => 
    array (
      'label' => 'Nome',
      'placeholder' => 'Inserisci il nome',
      'tooltip' => 'Nome completo dell\'utente',
      'description' => 'name',
      'helper_text' => 'name',
    ),
    'email' => 
    array (
      'label' => 'Email',
      'placeholder' => 'Inserisci l\'email',
      'tooltip' => 'Indirizzo email dell\'utente',
      'description' => 'email',
      'helper_text' => 'email',
    ),
    'type' => 
    array (
      'label' => 'Tipo',
      'options' => 
      array (
        'patient' => 'Paziente',
        'doctor' => 'Dottore',
        'admin' => 'Admin',
      ),
      'description' => 'type',
      'helper_text' => 'type',
      'placeholder' => 'type',
    ),
    'state' => 
    array (
      'label' => 'Stato',
      'options' => 
      array (
        'pending' => 'In attesa',
        'approved' => 'Approvato',
        'rejected' => 'Rifiutato',
        'integration_requested' => 'Integrazione richiesta',
        'suspended' => 'Sospeso',
      ),
      'description' => 'state',
      'helper_text' => 'state',
      'placeholder' => 'state',
    ),
    'phone' => 
    array (
      'label' => 'Telefono',
    ),
    'address' => 
    array (
      'label' => 'Indirizzo',
    ),
    'city' => 
    array (
      'label' => 'Città',
    ),
    'registration_number' => 
    array (
      'label' => 'Numero iscrizione',
    ),
    'status' => 
    array (
      'label' => 'Status',
    ),
    'certifications' => 
    array (
      'label' => 'Certificazioni',
    ),
    'moderation_data' => 
    array (
      'label' => 'Dati moderazione',
    ),
    'password' => 
    array (
      'label' => 'Password',
      'placeholder' => 'Inserisci la password',
      'tooltip' => 'Password dell\'utente',
    ),
    'password_confirmation' => 
    array (
      'label' => 'Conferma password',
    ),
    'created_at' => 
    array (
      'label' => 'Data creazione',
    ),
    'updated_at' => 
    array (
      'label' => 'Data aggiornamento',
    ),
    'roles' => 
    array (
      'label' => 'Ruoli',
      'placeholder' => 'Seleziona i ruoli',
      'tooltip' => 'Ruoli assegnati all\'utente',
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
    'resetFilters' => 
    array (
      'label' => 'resetFilters',
    ),
    'openFilters' => 
    array (
      'label' => 'openFilters',
    ),
    'last_name' => 
    array (
      'label' => 'last_name',
    ),
    'first_name' => 
    array (
      'label' => 'first_name',
    ),
  ),
  'actions' => 
  array (
    'approve' => 
    array (
      'label' => 'approve',
    ),
    'reject' => 
    array (
      'label' => 'reject',
    ),
    'request_integration' => 'Richiedi integrazione',
    'reinstate' => 
    array (
      'label' => 'reinstate',
    ),
    'suspend' => 
    array (
      'label' => 'suspend',
    ),
    'view' => 
    array (
      'label' => 'view',
    ),
    'edit' => 
    array (
      'label' => 'Modifica',
      'icon' => 'heroicon-o-pencil',
      'color' => 'primary',
    ),
    'delete' => 
    array (
      'label' => 'Elimina',
      'icon' => 'heroicon-o-trash',
      'color' => 'danger',
    ),
    'create' => 
    array (
      'label' => 'create',
    ),
  ),
  'navigation' => 
  array (
    'label' => 'Utenti',
    'group' => 'Gestione Utenti',
    'icon' => 'heroicon-o-user',
    'color' => 'primary',
    'sort' => 44,
  ),
  'model' => 
  array (
    'label' => 'user.model',
  ),
);
