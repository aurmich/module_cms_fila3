<?php

return [
    'fields' => [
        'patient_id' => [
            'label' => 'Paziente',
            'placeholder' => 'Seleziona il paziente',
            'helper_text' => 'Il paziente associato al workflow',
        ],
        'status' => [
            'label' => 'Stato',
            'placeholder' => 'Seleziona lo stato',
            'helper_text' => 'Lo stato corrente del workflow',
            'options' => [
                'pending' => 'In attesa',
                'in_progress' => 'In corso',
                'completed' => 'Completato',
                'cancelled' => 'Annullato',
            ],
        ],
        'current_step' => [
            'label' => 'Passo Corrente',
            'placeholder' => 'Passo corrente del workflow',
            'helper_text' => 'Il passo corrente nel workflow',
        ],
        'started_at' => [
            'label' => 'Data Inizio',
            'placeholder' => 'Data di inizio',
            'helper_text' => 'Quando è iniziato il workflow',
        ],
        'completed_at' => [
            'label' => 'Data Completamento',
            'placeholder' => 'Data di completamento',
            'helper_text' => 'Quando è stato completato il workflow',
        ],
        'last_interaction_at' => [
            'label' => 'Ultima Interazione',
            'placeholder' => 'Data ultima interazione',
            'helper_text' => 'L\'ultima volta che il workflow è stato aggiornato',
        ],
        'workflow_data' => [
            'label' => 'Dati Workflow',
            'placeholder' => 'Dati del workflow',
            'helper_text' => 'I dati associati al workflow',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Workflow',
            'icon' => 'heroicon-o-plus',
            'color' => 'primary',
        ],
        'edit' => [
            'label' => 'Modifica Workflow',
            'icon' => 'heroicon-o-pencil',
            'color' => 'warning',
        ],
        'delete' => [
            'label' => 'Elimina Workflow',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
        ],
        'continue' => [
            'label' => 'Continua Workflow',
            'icon' => 'heroicon-o-arrow-right',
            'color' => 'success',
        ],
        'cancel' => [
            'label' => 'Cancella Workflow',
            'icon' => 'heroicon-o-x-mark',
            'color' => 'danger',
        ],
    ],
    'filters' => [
        'status' => [
            'label' => 'Stato',
            'placeholder' => 'Filtra per stato',
        ],
        'started_from' => [
            'label' => 'Iniziato dal',
            'placeholder' => 'Data inizio da',
        ],
        'started_until' => [
            'label' => 'Iniziato fino al',
            'placeholder' => 'Data inizio fino a',
        ],
    ],
]; 