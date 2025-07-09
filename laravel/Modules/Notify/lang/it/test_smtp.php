<?php

<<<<<<< HEAD
declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Test SMTP',
        'group' => [
            'label' => 'Invia',
        ],
    ],
    'fields' => [
        'host' => [
            'label' => 'Host',
            'placeholder' => 'Inserisci l\'host SMTP',
            'help' => 'Indirizzo del server SMTP',
        ],
        'port' => [
            'label' => 'Porta',
            'placeholder' => 'Inserisci la porta',
            'help' => 'Porta del server SMTP',
        ],
        'username' => [
            'label' => 'Username',
            'placeholder' => 'Inserisci lo username',
            'help' => 'Username per l\'autenticazione SMTP',
        ],
        'password' => [
            'label' => 'Password',
            'placeholder' => 'Inserisci la password',
            'help' => 'Password per l\'autenticazione SMTP',
        ],
        'encryption' => [
            'label' => 'Crittografia',
            'placeholder' => 'TLS/SSL',
            'help' => 'Tipo di crittografia',
        ],
        'from_email' => [
            'label' => 'Email mittente',
            'placeholder' => 'Inserisci l\'email mittente',
            'help' => 'Indirizzo email del mittente',
        ],
        'from' => [
            'label' => 'Nome mittente',
            'placeholder' => 'Inserisci il nome mittente',
            'help' => 'Nome del mittente',
        ],
        'to' => [
            'label' => 'Destinatario',
            'placeholder' => 'Inserisci l\'email destinatario',
            'help' => 'Indirizzo email del destinatario',
        ],
        'subject' => [
            'label' => 'Oggetto',
            'placeholder' => 'Inserisci l\'oggetto',
            'help' => 'Oggetto della mail di test',
        ],
        'body_html' => [
            'label' => 'Contenuto HTML',
            'placeholder' => 'Inserisci il contenuto HTML',
            'help' => 'Contenuto HTML della mail di test',
        ],
    ],
    'actions' => [
        'send' => [
            'label' => 'Invia Test',
            'success' => 'Test SMTP inviato con successo',
            'error' => 'Errore durante l\'invio del test SMTP',
        ],
    ],
    'messages' => [
        'success' => 'Test SMTP inviato con successo',
        'error' => 'Si è verificato un errore durante l\'invio del test SMTP',
    ],
];
=======
return array (
  'navigation' => 
  array (
    'name' => 'Test Smtp',
    'plural' => 'Test Smtp',
    'group' => 
    array (
      'name' => 'Invia',
    ),
    'label' => 'Test SMTP',
  ),
  'fields' => 
  array (
    'name' => 'Nome Area',
    'parent' => 'Settore di appartenenza',
    'parent.name' => 'Settore di appartenenza',
    'parent_name' => 'Settore di appartenenza',
    'assets' => 'Quantità di asset',
    'host' => 
    array (
      'label' => 'host',
    ),
    'port' => 
    array (
      'label' => 'port',
    ),
    'username' => 
    array (
      'label' => 'username',
    ),
    'password' => 
    array (
      'label' => 'password',
    ),
    'encryption' => 
    array (
      'label' => 'encryption',
    ),
    'from_email' => 
    array (
      'label' => 'from_email',
    ),
    'from' => 
    array (
      'label' => 'from',
    ),
    'to' => 
    array (
      'label' => 'to',
    ),
    'subject' => 
    array (
      'label' => 'subject',
    ),
    'body_html' => 
    array (
      'label' => 'body_html',
      'description' => 'body_html',
    ),
  ),
  'actions' => 
  array (
    'import' => 
    array (
      'name' => 'Importa da file',
      'fields' => 
      array (
        'import_file' => 'Seleziona un file XLS o CSV da caricare',
      ),
    ),
    'export' => 
    array (
      'name' => 'Esporta dati',
      'filename_prefix' => 'Aree al',
      'columns' => 
      array (
        'name' => 'Nome area',
        'parent_name' => 'Nome area livello superiore',
      ),
    ),
    'emailFormActions' => 
    array (
      'label' => 'emailFormActions',
    ),
  ),
);
>>>>>>> d1ba726 (.)
