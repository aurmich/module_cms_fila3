<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Opzioni Campi',
        'group' => 'FormBuilder',
        'icon' => 'heroicon-o-cog-6-tooth',
        'sort' => 72,
    ],
    'fields' => [
        'field_id' => [
            'label' => 'Campo',
            'placeholder' => 'Seleziona campo',
            'helper_text' => 'Campo associato all\'opzione',
        ],
        'option_key' => [
            'label' => 'Chiave Opzione',
            'placeholder' => 'Inserisci chiave opzione',
            'helper_text' => 'Chiave identificativa dell\'opzione',
        ],
        'option_value' => [
            'label' => 'Valore Opzione',
            'placeholder' => 'Inserisci valore opzione',
            'helper_text' => 'Valore dell\'opzione',
        ],
        'option_label' => [
            'label' => 'Etichetta Opzione',
            'placeholder' => 'Inserisci etichetta opzione',
            'helper_text' => 'Etichetta visualizzata per l\'opzione',
        ],
        'is_default' => [
            'label' => 'Predefinito',
            'placeholder' => '',
            'helper_text' => 'Opzione selezionata di default',
        ],
        'sort_order' => [
            'label' => 'Ordine',
            'placeholder' => 'Inserisci ordine',
            'helper_text' => 'Ordine di visualizzazione dell\'opzione',
        ],
    ],
];
