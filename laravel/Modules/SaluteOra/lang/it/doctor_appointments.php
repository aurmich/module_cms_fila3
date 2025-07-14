<?php

return array (
  'title' => 'Appuntamenti Dottore',
  'description' => 'Gestione degli appuntamenti per i dottori',
  'actions' => 
  array (
    'delete' => 
    array (
      'label' => 'Elimina',
      'tooltip' => 'Elimina questo appuntamento',
      'confirmation' => 'Sei sicuro di voler eliminare questo appuntamento?',
    ),
    'accept' => 
    array (
      'label' => 'Accetta',
      'tooltip' => 'Accetta questo appuntamento',
      'confirmation' => 'Sei sicuro di voler accettare questo appuntamento?',
    ),
    'confirm' => 
    array (
      'label' => 'Conferma',
      'tooltip' => 'Conferma questo appuntamento',
      'confirmation' => 'Sei sicuro di voler confermare questo appuntamento?',
    ),
    'confirmed' => 
    array (
      'label' => 'Confermato',
      'tooltip' => 'Appuntamento confermato',
    ),
    'confirmAction' => 
    array (
      'label' => 'Azione Conferma',
      'tooltip' => 'Esegui azione di conferma',
    ),
    'rejectAction' => 
    array (
      'label' => 'Rifiuta',
      'tooltip' => 'Rifiuta questo appuntamento',
      'confirmation' => 'Sei sicuro di voler rifiutare questo appuntamento?',
    ),
    'info' => 
    array (
      'label' => 'Informazioni',
      'tooltip' => 'Visualizza informazioni dettagliate',
    ),
    'create-report' => 
    array (
      'label' => 'create-report',
    ),
    'warning' => 
    array (
      'label' => 'warning',
    ),
    'test' => 
    array (
      'label' => 'test',
    ),
    'report' => 
    array (
      'label' => 'report',
    ),
  ),
  'messages' => 
  array (
    'appointment_accepted' => 'Appuntamento accettato con successo',
    'appointment_confirmed' => 'Appuntamento confermato con successo',
    'appointment_rejected' => 'Appuntamento rifiutato con successo',
    'appointment_deleted' => 'Appuntamento eliminato con successo',
    'error_occurred' => 'Si è verificato un errore',
  ),
  'status' => 
  array (
    'pending' => 'In attesa',
    'confirmed' => 'Confermato',
    'rejected' => 'Rifiutato',
    'completed' => 'Completato',
    'cancelled' => 'Annullato',
  ),
  'states' => 
  array (
    'pending' => 
    array (
      'label' => 'In attesa',
      'color' => 'warning',
      'bg_color' => '#FEF3C7',
      'icon' => 'heroicon-o-clock',
    ),
    'confirmed' => 
    array (
      'label' => 'Confermato',
      'color' => 'success',
      'bg_color' => '#D1FAE5',
      'icon' => 'heroicon-o-check-circle',
    ),
    'rejected' => 
    array (
      'label' => 'Rifiutato',
      'color' => 'danger',
      'bg_color' => '#FEE2E2',
      'icon' => 'heroicon-o-x-circle',
    ),
    'completed' => 
    array (
      'label' => 'Completato',
      'color' => 'success',
      'bg_color' => '#ECFDF5',
      'icon' => 'heroicon-o-check-badge',
    ),
    'cancelled' => 
    array (
      'label' => 'Annullato',
      'color' => 'gray',
      'bg_color' => '#F3F4F6',
      'icon' => 'heroicon-o-no-symbol',
    ),
  ),
  'fields' => 
  array (
    'message' => 
    array (
      'description' => 'Messaggio',
      'helper_text' => '',
      'placeholder' => '',
      'label' => 'Messaggio',
    ),
  ),
);
