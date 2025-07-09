<?php

<<<<<<< HEAD
declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Invio Email',
        'group' => [
            'label' => 'Sistema',
            'description' => 'Funzionalità per l\'invio di email attraverso il sistema di notifiche',
        ],
        'icon' => 'notify-email-animated',
        'sort' => 49,
    ],
    'fields' => [
        'object' => [
            'label' => 'Oggetto',
            'placeholder' => 'Inserisci l\'oggetto',
            'help' => 'Oggetto della email',
        ],
        'template_id' => [
            'label' => 'Template',
            'placeholder' => 'Seleziona il template email',
            'help' => 'ID del template',
        ],
        'to' => [
            'label' => 'Destinatario',
            'placeholder' => 'Inserisci l\'indirizzo email',
            'help' => 'Destinatario',
        ],
        'content' => [
            'label' => 'Contenuto',
            'placeholder' => 'Inserisci il contenuto',
            'help' => 'Contenuto email',
        ],
        'parameters' => [
            'label' => 'Parametri',
            'placeholder' => 'Inserisci i parametri',
            'help' => 'Parametri del template',
        ],
        'body_html' => [
            'label' => 'Contenuto HTML',
            'description' => 'Contenuto HTML dell\'email',
            'placeholder' => 'Inserisci il contenuto HTML',
            'help' => 'Contenuto HTML dell\'email da inviare',
        ],
        'subject' => [
            'label' => 'Oggetto',
            'description' => 'Oggetto dell\'email',
            'placeholder' => 'Inserisci l\'oggetto dell\'email',
            'help' => 'Oggetto che apparirà nell\'intestazione dell\'email',
        ],
    ],
    'actions' => [
        'send' => [
            'label' => 'Invia',
            'success' => 'Email inviata con successo',
            'error' => 'Errore nell\'invio dell\'email',
            'confirmation' => 'Sei sicuro di voler inviare questa email?',
        ],
        'preview' => [
            'label' => 'Anteprima',
            'success' => 'Anteprima generata',
            'error' => 'Errore nella generazione dell\'anteprima',
        ],
    ],
    'messages' => [
        'success' => 'Email inviata con successo',
        'error' => 'Si è verificato un errore durante l\'invio dell\'email',
    ],
];
=======
return array (
  'resource' => 
  array (
    'name' => 'Invio Email',
    'plural' => 'Invio Email',
  ),
  'navigation' => 
  array (
    'name' => 'Invio Email',
    'plural' => 'Invio Email',
    'group' => 
    array (
      'name' => 'Sistema',
      'description' => 'Funzionalità per l\'invio di email attraverso il sistema di notifiche',
    ),
    'label' => 'Invio Email',
    'icon' => 'notify-email-animated',
    'sort' => 49,
  ),
  'fields' => 
  array (
    'object' => 
    array (
      'description' => 'Oggetto della email',
      'placeholder' => 'Inserisci l\'oggetto',
      'label' => 'Oggetto',
    ),
    'template_id' => 
    array (
      'description' => 'ID del template',
      'placeholder' => 'Seleziona il template email',
      'label' => 'Template ID',
    ),
    'to' => 
    array (
      'description' => 'Destinatario',
      'placeholder' => 'Inserisci l\'indirizzo email',
      'label' => 'Destinatario',
      'helper_text' => 'to',
    ),
    'content' => 
    array (
      'description' => 'Contenuto email',
      'placeholder' => 'Inserisci il contenuto',
      'label' => 'Contenuto',
    ),
    'parameters' => 
    array (
      'description' => 'Parametri del template',
      'placeholder' => 'Inserisci i parametri',
      'label' => 'Parametri',
    ),
    'body_html' => 
    array (
      'description' => 'Contenuto HTML',
      'helper_text' => 'Contenuto HTML dell\'email',
      'placeholder' => 'Inserisci il contenuto HTML',
      'label' => 'Contenuto HTML',
    ),
    'subject' => 
    array (
      'description' => 'Oggetto email',
      'helper_text' => 'Inserisci l\'oggetto dell\'email',
      'label' => 'Oggetto',
      'placeholder' => 'Inserisci l\'oggetto dell\'email',
    ),
  ),
  'actions' => 
  array (
    'send' => 
    array (
      'label' => 'Invia',
      'tooltip' => 'Invia l\'email al destinatario',
      'success_message' => 'Email inviata con successo',
      'error_message' => 'Errore nell\'invio dell\'email',
    ),
    'preview' => 
    array (
      'label' => 'Anteprima',
      'tooltip' => 'Visualizza l\'anteprima dell\'email',
      'success_message' => 'Anteprima generata',
      'error_message' => 'Errore nella generazione dell\'anteprima',
    ),
    'emailFormActions' => 
    array (
      'label' => 'emailFormActions',
    ),
  ),
  'messages' => 
  array (
    'success' => 'Email inviata con successo',
    'error' => 'Si è verificato un errore durante l\'invio dell\'email',
    'confirmation' => 'Sei sicuro di voler inviare questa email?',
  ),
);
>>>>>>> d1ba726 (.)
