<?php

return array (
  'navigation' => 
  array (
    'name' => 'Consensi',
    'plural' => 'Consensi',
    'group' => 
    array (
      'name' => 'GDPR',
      'description' => 'Gestione dei consensi privacy',
    ),
    'label' => 'Gestione Consensi',
    'sort' => 62,
    'icon' => 'gdpr-consent',
  ),
  'fields' => 
  array (
    'user' => 'Utente',
    'type' => 'Tipo Consenso',
    'status' => 'Stato',
    'date' => 'Data',
    'ip_address' => 'Indirizzo IP',
    'notes' => 'Note',
    'toggleColumns' => 
    array (
      'label' => 'toggleColumns',
    ),
    'reorderRecords' => 
    array (
      'label' => 'reorderRecords',
    ),
  ),
  'statuses' => 
  array (
    'granted' => 'Concesso',
    'denied' => 'Negato',
    'withdrawn' => 'Revocato',
    'expired' => 'Scaduto',
  ),
  'actions' => 
  array (
    'grant' => 'Concedi',
    'deny' => 'Nega',
    'withdraw' => 'Revoca',
    'renew' => 'Rinnova',
  ),
);
