<?php

return [
    'fields' => [
        'name' => [
            'label' => 'Nome Report',
            'placeholder' => 'Inserisci il nome del report',
            'helper_text' => 'Il nome identificativo del report',
        ],
        'type' => [
            'label' => 'Tipo Report',
            'placeholder' => 'Seleziona il tipo di report',
            'helper_text' => 'Il tipo di report da generare',
            'options' => [
                'pdf' => 'PDF',
                'excel' => 'Excel',
                'csv' => 'CSV',
            ],
        ],
        'start_date' => [
            'label' => 'Data Inizio',
            'placeholder' => 'Seleziona la data di inizio',
            'helper_text' => 'La data di inizio del periodo del report',
        ],
        'end_date' => [
            'label' => 'Data Fine',
            'placeholder' => 'Seleziona la data di fine',
            'helper_text' => 'La data di fine del periodo del report',
        ],
        'status' => [
            'label' => 'Stato',
            'placeholder' => 'Seleziona lo stato',
            'helper_text' => 'Lo stato corrente del report',
            'options' => [
                'pending' => 'In attesa',
                'processing' => 'In elaborazione',
                'completed' => 'Completato',
                'error' => 'Errore',
            ],
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'placeholder' => 'Data di creazione',
            'helper_text' => 'Quando è stato creato il report',
        ],
        'created_by' => [
            'label' => 'Creato da',
            'placeholder' => 'Utente che ha creato il report',
            'helper_text' => 'L\'utente che ha creato il report',
        ],
        'parameters' => [
            'label' => 'Parametri',
            'key_label' => 'Parametro',
            'value_label' => 'Valore',
            'helper_text' => 'I parametri utilizzati per generare il report',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Report',
            'icon' => 'heroicon-o-plus',
            'color' => 'primary',
        ],
        'edit' => [
            'label' => 'Modifica Report',
            'icon' => 'heroicon-o-pencil',
            'color' => 'warning',
        ],
        'delete' => [
            'label' => 'Elimina Report',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
        ],
        'download' => [
            'label' => 'Scarica Report',
            'icon' => 'heroicon-o-download',
            'color' => 'success',
        ],
        'regenerate' => [
            'label' => 'Rigenera Report',
            'icon' => 'heroicon-o-arrow-path',
            'color' => 'info',
        ],
    ],
]; 