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
