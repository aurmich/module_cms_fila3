<?php

return array (
  'navigation' => 
  array (
    'name' => 'Attività',
    'plural' => 'Attività',
    'group' => 
    array (
      'name' => 'Monitoraggio',
      'description' => 'Monitoraggio delle attività di sistema',
    ),
    'label' => 'Attività',
    'sort' => 60,
    'icon' => 'activity-activity-animated',
  ),
  'fields' => 
  array (
    'user' => 
    array (
      'label' => 'Utente',
      'name' => 'Nome',
      'email' => 'Email',
      'role' => 'Ruolo',
    ),
    'action' => 
    array (
      'label' => 'Azione',
      'created' => 'Creato',
      'updated' => 'Modificato',
      'deleted' => 'Eliminato',
      'viewed' => 'Visualizzato',
      'downloaded' => 'Scaricato',
      'uploaded' => 'Caricato',
      'logged_in' => 'Accesso',
      'logged_out' => 'Uscita',
    ),
    'subject' => 
    array (
      'label' => 'Oggetto',
      'type' => 'Tipo',
      'id' => 'ID',
      'name' => 'Nome',
    ),
    'description' => 'Descrizione',
    'ip_address' => 'Indirizzo IP',
    'user_agent' => 'User Agent',
    'created_at' => 'Data',
    'properties' => 
    array (
      'label' => 'Proprietà',
      'old' => 'Vecchio Valore',
      'new' => 'Nuovo Valore',
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
  'filters' => 
  array (
    'user' => 'Utente',
    'action' => 'Azione',
    'subject_type' => 'Tipo Oggetto',
    'date_range' => 'Intervallo Date',
    'ip_address' => 'Indirizzo IP',
  ),
  'actions' => 
  array (
    'view_details' => 'Visualizza Dettagli',
    'export' => 'Esporta',
    'clear_old' => 'Pulisci Vecchie',
  ),
  'messages' => 
  array (
    'no_activities' => 'Nessuna attività trovata',
    'cleared' => 'Attività vecchie eliminate con successo',
    'exported' => 'Attività esportate con successo',
  ),
  'export' => 
  array (
    'formats' => 
    array (
      'csv' => 'CSV',
      'excel' => 'Excel',
      'pdf' => 'PDF',
    ),
    'columns' => 
    array (
      'date' => 'Data',
      'user' => 'Utente',
      'action' => 'Azione',
      'subject' => 'Oggetto',
      'ip' => 'IP',
    ),
  ),
);
