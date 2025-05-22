<?php

return [
    'fields' => [
        'name' => [
            'label' => 'Nome Report',
            'placeholder' => 'Inserisci il nome del report',
            'help' => 'Il nome del report',
            'validation' => [
                'required' => 'Il nome del report è obbligatorio'
            ]
        ],
        'description' => [
            'label' => 'Descrizione',
            'placeholder' => 'Inserisci la descrizione',
            'help' => 'La descrizione del report'
        ],
        'type' => [
            'label' => 'Tipo Report',
            'placeholder' => 'Seleziona il tipo di report',
            'help' => 'Il tipo di report',
            'validation' => [
                'required' => 'Il tipo di report è obbligatorio'
            ]
        ],
        'start_date' => [
            'label' => 'Data Inizio',
            'placeholder' => 'Seleziona la data di inizio',
            'help' => 'La data di inizio del periodo',
            'validation' => [
                'required' => 'La data di inizio è obbligatoria'
            ]
        ],
        'end_date' => [
            'label' => 'Data Fine',
            'placeholder' => 'Seleziona la data di fine',
            'help' => 'La data di fine del periodo',
            'validation' => [
                'required' => 'La data di fine è obbligatoria'
            ]
        ],
        'parameters' => [
            'label' => 'Parametri Aggiuntivi',
            'help' => 'I parametri aggiuntivi del report'
        ],
        'status' => [
            'label' => 'Stato',
            'help' => 'Lo stato del report'
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'help' => 'Data di creazione del report'
        ],
        'created_by' => [
            'label' => 'Creato da',
            'help' => 'Utente che ha creato il report'
        ],
        'last_generation' => [
            'label' => 'Ultima Generazione',
            'help' => 'Data dell\'ultima generazione del report'
        ]
    ],
    'actions' => [
        'regenerate' => [
            'label' => 'Rigenera Report',
            'tooltip' => 'Rigenera il report con i parametri attuali'
        ],
        'download_pdf' => [
            'label' => 'Scarica PDF',
            'tooltip' => 'Scarica il report in formato PDF'
        ],
        'export_csv' => [
            'label' => 'Esporta CSV',
            'tooltip' => 'Esporta il report in formato CSV'
        ],
        'view_details' => [
            'label' => 'Visualizza Dettagli',
            'tooltip' => 'Visualizza i dettagli del report'
        ]
    ],
    'filters' => [
        'type' => [
            'label' => 'Tipo Report',
            'placeholder' => 'Seleziona il tipo di report'
        ],
        'status' => [
            'label' => 'Stato',
            'placeholder' => 'Seleziona lo stato'
        ],
        'created_from' => [
            'label' => 'Creato dal',
            'placeholder' => 'Seleziona la data di inizio'
        ],
        'created_to' => [
            'label' => 'Creato fino al',
            'placeholder' => 'Seleziona la data di fine'
        ]
    ]
]; 