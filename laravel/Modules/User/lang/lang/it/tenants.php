<?php

declare(strict_types=1);

return [
    'fields' => [
        'message' => [
            'label' => 'Messaggio',
            'placeholder' => 'Inserisci un messaggio',
            'tooltip' => 'Messaggio informativo',
            'description' => 'Messaggio di comunicazione per i tenants',
            'helper_text' => '',
        ],
        'name' => [
            'label' => 'Nome Tenant',
            'placeholder' => 'Inserisci nome del tenant',
            'tooltip' => 'Nome identificativo del tenant',
            'description' => 'Nome completo o ragione sociale del tenant',
            'helper_text' => '',
        ],
        'slug' => [
            'label' => 'Slug',
            'placeholder' => 'inserisci-slug-univoco',
            'tooltip' => 'Identificatore URL-friendly',
            'description' => 'Identificatore univoco utilizzato negli URL',
            'helper_text' => '',
        ],
        'status' => [
            'label' => 'Stato',
            'placeholder' => 'Seleziona stato',
            'tooltip' => 'Stato del tenant',
            'description' => 'Stato corrente del tenant (attivo, inattivo, sospeso)',
            'helper_text' => '',
        ],
    ],
    'actions' => [
        'create' => 'Crea Tenant',
        'edit' => 'Modifica Tenant',
        'delete' => 'Elimina Tenant',
        'activate' => 'Attiva Tenant',
        'deactivate' => 'Disattiva Tenant',
    ],
    'messages' => [
        'created' => 'Tenant creato con successo',
        'updated' => 'Tenant aggiornato con successo',
        'deleted' => 'Tenant eliminato con successo',
        'activated' => 'Tenant attivato con successo',
        'deactivated' => 'Tenant disattivato con successo',
    ],
];
