<?php

declare(strict_types=1);

return [
    'resource' => [
        'name' => 'Invio Email',
        'plural' => 'Invio Email',
    ],
    'navigation' => [
        'name' => 'Invio Email',
        'plural' => 'Invio Email',
        'group' => [
            'name' => 'Sistema',
            'description' => 'Funzionalità per l\'invio di email attraverso il sistema di notifiche',
        ],
        'label' => 'Invio Email',
        'icon' => 'notify-email-animated',
        'sort' => 49,
    ],
    'fields' => [
        'object' => [
            'description' => 'Oggetto della email',
            'placeholder' => 'Inserisci l\'oggetto',
            'label' => 'Oggetto',
        ],
        'template_id' => [
            'description' => 'ID del template',
            'placeholder' => 'Seleziona il template email',
            'label' => 'Template ID',
        ],
        'to' => [
            'description' => 'Destinatario',
            'placeholder' => 'Inserisci l\'indirizzo email',
            'label' => 'Destinatario',
        ],
        'content' => [
            'description' => 'Contenuto email',
            'placeholder' => 'Inserisci il contenuto',
            'label' => 'Contenuto',
        ],
        'parameters' => [
            'description' => 'Parametri del template',
            'placeholder' => 'Inserisci i parametri',
            'label' => 'Parametri',
        ],
    ],
    'actions' => [
        'send' => [
            'label' => 'Invia',
            'tooltip' => 'Invia l\'email al destinatario',
            'success_message' => 'Email inviata con successo',
            'error_message' => 'Errore nell\'invio dell\'email',
        ],
        'preview' => [
            'label' => 'Anteprima',
            'tooltip' => 'Visualizza l\'anteprima dell\'email',
            'success_message' => 'Anteprima generata',
            'error_message' => 'Errore nella generazione dell\'anteprima',
        ],
    ],
    'messages' => [
        'success' => 'Email inviata con successo',
        'error' => 'Si è verificato un errore durante l\'invio dell\'email',
        'confirmation' => 'Sei sicuro di voler inviare questa email?',
    ],
];
