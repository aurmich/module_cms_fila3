<?php

return array (
  'resource' => 
  array (
    'name' => 'Invio SMS',
    'plural' => 'Invio SMS',
  ),
  'navigation' => 
  array (
    'name' => 'Invio SMS',
    'plural' => 'Invio SMS',
    'group' => 
    array (
      'name' => 'Notifiche',
      'description' => 'Gestione dell\'invio di notifiche SMS',
    ),
    'label' => 'Invio SMS',
    'icon' => 'heroicon-o-chat-bubble-left-right',
    'sort' => 15,
  ),
  'fields' => 
  array (
    'driver' => 
    array (
      'description' => 'Driver SMS',
      'helper_text' => 'Seleziona il provider per l\'invio SMS',
      'placeholder' => 'Seleziona un driver',
      'label' => 'Driver',
    ),
    'message' => 
    array (
      'description' => 'Contenuto del messaggio',
      'helper_text' => 'Testo del messaggio da inviare',
      'placeholder' => 'Scrivi il messaggio',
      'label' => 'Messaggio',
    ),
    'phone' => 
    array (
      'description' => 'Numero di telefono',
      'helper_text' => 'Numero del destinatario',
      'placeholder' => 'Inserisci il numero',
      'label' => 'Numero telefono',
    ),
    'gateway' => 
    array (
      'description' => 'Gateway SMS',
      'helper_text' => 'Gateway utilizzato per l\'invio',
      'placeholder' => 'Gateway SMS',
      'label' => 'Gateway',
    ),
    'to' => 
    array (
      'description' => 'to',
      'helper_text' => 'to',
      'placeholder' => 'to',
      'label' => 'to',
    ),
    'template_slug' => 
    array (
      'description' => 'template_slug',
      'helper_text' => 'template_slug',
      'placeholder' => 'template_slug',
      'label' => 'template_slug',
    ),
  ),
  'actions' => 
  array (
    'send' => 
    array (
      'label' => 'Invia SMS',
      'tooltip' => 'Invia un messaggio SMS al destinatario',
      'success_message' => 'SMS inviato con successo',
      'error_message' => 'Errore nell\'invio dell\'SMS',
    ),
    'test' => 
    array (
      'label' => 'Test connessione',
      'tooltip' => 'Verifica la connessione con il provider',
      'success_message' => 'Connessione verificata con successo',
      'error_message' => 'Errore nella verifica della connessione',
    ),
  ),
  'messages' => 
  array (
    'success' => 'SMS inviato con successo',
    'error' => 'Si è verificato un errore durante l\'invio dell\'SMS',
    'confirmation' => 'Sei sicuro di voler inviare questo SMS?',
  ),
);
