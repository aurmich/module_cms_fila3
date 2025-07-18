<?php

declare(strict_types=1);

return [
    'section_title' => 'I miei dati',
    'actions' => [
        'delete' => [
            'label' => 'Elimina',
            'helper_text' => '',
        ],
        'edit' => [
            'label' => 'Modifica',
            'modal_heading' => 'Modifica Profilo',
            'modal_description' => 'Aggiorna le informazioni del tuo profilo personale',
            'helper_text' => '',
        ],
    ],
    'fields' => [
        'address' => [
            'label' => 'Indirizzo',
            'placeholder' => 'Inserisci il tuo indirizzo',
            'help' => 'Indica l\'indirizzo di residenza o domicilio',
            'description' => 'Indirizzo completo dell\'utente',
            'helper_text' => '',
        ],
        'phone' => [
            'label' => 'Telefono',
            'placeholder' => 'Inserisci il numero di telefono',
            'help' => 'Numero di telefono per i contatti',
            'description' => 'Numero di telefono principale',
            'helper_text' => '',
        ],
        'last_name' => [
            'label' => 'Cognome',
            'placeholder' => 'Inserisci il cognome',
            'help' => 'Il tuo cognome anagrafico',
            'description' => 'Cognome dell\'utente',
            'helper_text' => '',
        ],
        'first_name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Il tuo nome anagrafico',
            'description' => 'Nome dell\'utente',
            'helper_text' => '',
        ],
    ],
];
