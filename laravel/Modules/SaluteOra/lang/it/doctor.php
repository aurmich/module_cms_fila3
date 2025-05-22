<?php

declare(strict_types=1);

return [
    'navigation' => [
        'group' => 'Gestione Medici',
        'label' => 'Medici',
        'plural' => 'Medici',
        'singular' => 'Medico',
        'icon' => 'heroicon-o-user-group',
        'sort' => 2,
    ],

    'fields' => [
        'full_name' => [
            'label' => 'Nome Completo',
            'placeholder' => 'Inserisci il nome completo',
            'help' => 'Nome e cognome del medico',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Inserisci l\'indirizzo email',
            'help' => 'Indirizzo email principale per le comunicazioni',
        ],
        'phone' => [
            'label' => 'Telefono',
            'placeholder' => 'Inserisci il numero di telefono',
            'help' => 'Numero di telefono per contatti diretti',
        ],
        'address' => [
            'label' => 'Indirizzo',
            'placeholder' => 'Inserisci l\'indirizzo',
            'help' => 'Indirizzo dello studio medico',
        ],
        'city' => [
            'label' => 'Città',
            'placeholder' => 'Inserisci la città',
            'help' => 'Città dello studio medico',
        ],
        'registration_number' => [
            'label' => 'Numero di Iscrizione',
            'placeholder' => 'Inserisci il numero di iscrizione all\'albo',
            'help' => 'Numero di iscrizione all\'albo dei medici',
        ],
        'certification' => [
            'label' => 'Certificazione',
            'placeholder' => 'Carica la certificazione',
            'help' => 'Documento di certificazione professionale',
        ],
        'is_active' => [
            'label' => 'Attivo',
            'help' => 'Indica se il medico è attualmente disponibile',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
        ],
    ],

    'filters' => [
        'search_placeholder' => 'Cerca medici...',
        'is_active' => [
            'label' => 'Stato',
            'options' => [
                'active' => 'Attivo',
                'inactive' => 'Inattivo',
            ],
        ],
    ],

    'actions' => [
        'create' => [
            'label' => 'Nuovo Medico',
            'modal' => [
                'heading' => 'Crea Nuovo Medico',
                'description' => 'Inserisci i dati del nuovo medico',
            ],
        ],
        'edit' => [
            'label' => 'Modifica',
            'modal' => [
                'heading' => 'Modifica Medico',
                'description' => 'Modifica i dati del medico',
            ],
        ],
        'delete' => [
            'label' => 'Elimina',
            'modal' => [
                'heading' => 'Elimina Medico',
                'description' => 'Sei sicuro di voler eliminare questo medico? Questa azione non può essere annullata.',
            ],
        ],
    ],

    'messages' => [
        'created' => 'Medico creato con successo',
        'updated' => 'Medico aggiornato con successo',
        'deleted' => 'Medico eliminato con successo',
    ],
];
