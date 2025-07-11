<?php

return [
    'singular' => 'Indirizzo',
    'plural' => 'Indirizzi',
    'navigation' => [
        'sort' => '96',
        'icon' => 'address.navigation',
        'group' => 'address.navigation',
    ],
    'actions' => [
        'create' => 'Crea indirizzo',
        'edit' => 'Modifica indirizzo',
        'view' => 'Visualizza indirizzo',
        'delete' => 'Elimina indirizzo',
        'set_primary' => 'Imposta come principale',
        'verify' => 'Verifica indirizzo',
        'geocode' => 'Geocodifica',
    ],
    'fields' => [
        'model_type' => [
            'label' => 'Tipo modello',
            'placeholder' => 'Seleziona il tipo di modello',
        ],
        'model_id' => [
            'label' => 'ID modello',
            'placeholder' => 'Inserisci ID del modello',
        ],
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci un nome per l\'indirizzo',
            'helper' => 'Un nome identificativo per questo indirizzo, es. \"Casa\" o \"Ufficio\"',
            'helper_text' => '',
            'description' => 'name',
        ],
        'description' => [
            'label' => 'Descrizione',
            'placeholder' => 'Inserisci una descrizione',
            'helper' => 'Note aggiuntive sull\'indirizzo',
        ],
        'route' => [
            'label' => 'Via',
            'placeholder' => 'Inserisci la via',
            'helper' => 'Nome della via o strada',
            'description' => 'route',
            'helper_text' => '',
        ],
        'street_number' => [
            'label' => 'Numero civico',
            'placeholder' => 'Inserisci il numero civico',
            'description' => 'street_number',
            'helper_text' => '',
        ],
        'locality' => [
            'label' => 'Città',
            'placeholder' => 'Inserisci la città',
            'description' => 'locality',
            'helper_text' => '',
        ],
        'administrative_area_level_3' => [
            'label' => 'Comune',
            'placeholder' => 'Inserisci il comune',
        ],
        'administrative_area_level_2' => [
            'label' => 'Provincia',
            'placeholder' => 'Inserisci la provincia',
            'description' => 'administrative_area_level_2',
            'helper_text' => '',
        ],
        'administrative_area_level_1' => [
            'label' => 'Regione',
            'placeholder' => 'Inserisci la regione',
            'description' => 'administrative_area_level_1',
            'helper_text' => '',
        ],
        'country' => [
            'label' => 'Paese',
            'placeholder' => 'Inserisci il paese',
            'description' => 'country',
            'helper_text' => '',
        ],
        'postal_code' => [
            'label' => 'CAP',
            'placeholder' => 'Inserisci il CAP',
            'description' => 'postal_code',
            'helper_text' => '',
        ],
        'formatted_address' => [
            'label' => 'Indirizzo formattato',
            'placeholder' => 'Indirizzo formattato completo',
            'description' => 'formatted_address',
            'helper_text' => '',
        ],
        'place_id' => [
            'label' => 'ID luogo',
            'placeholder' => 'ID riferimento Google Maps',
        ],
        'latitude' => [
            'label' => 'Latitudine',
            'placeholder' => 'Inserisci la latitudine',
        ],
        'longitude' => [
            'label' => 'Longitudine',
            'placeholder' => 'Inserisci la longitudine',
            'description' => 'longitude',
            'helper_text' => '',
        ],
        'type' => [
            'label' => 'Tipo',
            'placeholder' => 'Seleziona il tipo di indirizzo',
            'options' => [
                'billing' => 'Fatturazione',
                'shipping' => 'Spedizione',
                'home' => 'Casa',
                'work' => 'Lavoro',
                'other' => 'Altro',
            ],
        ],
        'is_primary' => [
            'label' => 'Principale',
            'helper' => 'Imposta questo indirizzo come indirizzo principale',
            'description' => 'is_primary',
            'helper_text' => '',
            'placeholder' => 'is_primary',
        ],
        'extra_data' => [
            'label' => 'Dati aggiuntivi',
            'placeholder' => 'Inserisci dati aggiuntivi',
        ],
        'full_address' => [
            'label' => 'Indirizzo completo',
        ],
        'street_address' => [
            'label' => 'Indirizzo stradale',
        ],
        'map' => [
            'description' => 'map',
            'helper_text' => '',
        ],
        'aaa' => [
            'description' => 'aaa',
            'helper_text' => 'aaa',
            'placeholder' => 'aaa',
        ],
    ],
    'columns' => [
        'name' => 'Nome',
        'full_address' => 'Indirizzo completo',
        'type' => 'Tipo',
        'is_primary' => 'Principale',
        'locality' => 'Città',
        'postal_code' => 'CAP',
        'model' => 'Associato a',
    ],
    'messages' => [
        'primary_set' => 'Indirizzo impostato come principale con successo',
        'address_verified' => 'Indirizzo verificato correttamente',
        'geocoding_success' => 'Geocodifica completata con successo',
        'geocoding_failed' => 'Impossibile geocodificare l\'indirizzo',
    ],
    'sections' => [
        'location' => [
            'label' => 'Informazioni di localizzazione',
            'description' => 'Dati relativi alla posizione geografica',
        ],
        'address' => [
            'label' => 'Dati indirizzo',
            'description' => 'Dettagli dell\'indirizzo',
        ],
        'metadata' => [
            'label' => 'Metadati',
            'description' => 'Informazioni aggiuntive sull\'indirizzo',
        ],
        'map' => [
            'label' => 'Mappa',
            'description' => 'Visualizzazione su mappa',
        ],
    ],
];
