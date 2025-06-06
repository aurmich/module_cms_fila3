<?php

return array (
  'navigation' => 
  array (
    'name' => 'Trattamenti',
    'plural' => 'Trattamenti',
    'group' => 
    array (
      'name' => 'GDPR',
      'description' => 'Registro dei trattamenti dati',
    ),
    'label' => 'Registro Trattamenti',
    'sort' => 76,
    'icon' => 'gdpr-treatment',
  ),
  'fields' => 
  array (
    'name' => 'Nome Trattamento',
    'purpose' => 'Finalità',
    'legal_basis' => 'Base Giuridica',
    'data_categories' => 'Categorie di Dati',
    'retention_period' => 'Periodo di Conservazione',
    'security_measures' => 'Misure di Sicurezza',
    'data_transfers' => 'Trasferimenti Dati',
    'toggleColumns' => 
    array (
      'label' => 'toggleColumns',
    ),
    'reorderRecords' => 
    array (
      'label' => 'reorderRecords',
    ),
  ),
  'legal_bases' => 
  array (
    'consent' => 'Consenso',
    'contract' => 'Contratto',
    'legal_obligation' => 'Obbligo Legale',
    'vital_interests' => 'Interessi Vitali',
    'public_interest' => 'Interesse Pubblico',
    'legitimate_interests' => 'Interessi Legittimi',
  ),
);
