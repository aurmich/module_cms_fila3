<?php

declare(strict_types=1);

return [
    'model' => [
        'label' => 'Modello Collezione',
        'placeholder' => 'Seleziona modello',
        'help' => 'Modello per la gestione delle collezioni',
    ],
    'navigation' => [
        'label' => 'Collezioni',
        'group' => 'FormBuilder',
        'icon' => 'heroicon-o-collection',
        'sort' => 73,
    ],
    'fields' => [
        'itemIsDefault' => [
            'description' => 'Elemento predefinito della collezione',
            'helper_text' => '',
            'placeholder' => 'Seleziona elemento predefinito',
            'label' => 'Elemento Predefinito',
        ],
        'itemKey' => [
            'description' => 'Chiave dell\'elemento della collezione',
            'helper_text' => '',
            'placeholder' => 'Inserisci chiave elemento',
            'label' => 'Chiave Elemento',
        ],
        'itemValue' => [
            'description' => 'Valore dell\'elemento della collezione',
            'helper_text' => '',
            'placeholder' => 'Inserisci valore elemento',
            'label' => 'Valore Elemento',
        ],
        'values' => [
            'description' => 'Valori della collezione',
            'helper_text' => '',
            'placeholder' => 'Inserisci valori',
            'label' => 'Valori',
        ],
        'name' => [
            'description' => 'Nome della collezione',
            'helper_text' => '',
            'label' => 'Nome',
            'placeholder' => 'Inserisci nome collezione',
        ],
    ],
];
