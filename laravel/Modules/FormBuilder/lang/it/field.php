<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Campi',
        'group' => 'FormBuilder',
        'icon' => 'heroicon-o-rectangle-stack',
        'sort' => 51,
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci nome campo',
            'helper_text' => 'Nome identificativo del campo',
        ],
        'type' => [
            'label' => 'Tipo',
            'placeholder' => 'Seleziona tipo campo',
            'helper_text' => 'Tipo di campo (testo, numero, data, ecc.)',
        ],
        'label' => [
            'label' => 'Etichetta',
            'placeholder' => 'Inserisci etichetta',
            'helper_text' => 'Etichetta visualizzata per il campo',
        ],
        'placeholder' => [
            'label' => 'Placeholder',
            'placeholder' => 'Inserisci testo placeholder',
            'helper_text' => 'Testo di esempio nel campo',
        ],
        'required' => [
            'label' => 'Obbligatorio',
            'placeholder' => '',
            'helper_text' => 'Campo obbligatorio per la validazione',
        ],
        'validation' => [
            'label' => 'Validazione',
            'placeholder' => 'Configura regole validazione',
            'helper_text' => 'Regole di validazione per il campo',
        ],
    ],
];
