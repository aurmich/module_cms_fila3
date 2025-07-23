<?php

declare(strict_types=1);

return [
    'fields' => [
        'message' => [
            'label' => 'Messaggio Rimborso',
            'placeholder' => 'Dettagli richiesta rimborso',
            'help' => 'Messaggio per documentare la richiesta di rimborso',
            'description' => 'Comunicazione relativa al rimborso in attesa',
            'helper_text' => '',
        ],
        'invoice' => [
            'label' => 'Fattura',
            'placeholder' => 'Carica Fattura',
            'help' => 'Carica il documento fiscale per la richiesta di rimborso',
            'description' => 'File della fattura da allegare per il rimborso',
            'helper_text' => '',
        ],
    ],
];
