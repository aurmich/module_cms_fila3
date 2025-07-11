<?php

return [
    'fields' => [
        'name' => [
            'label' => 'name',
            'placeholder' => 'name',
            'helper_text' => 'name',
            'description' => 'name',
            'helper' => 'Un nome identificativo per questo indirizzo, es. \"Casa\" o \"Ufficio\"',
        ],
        'country' => [
            'label' => 'country',
            'placeholder' => 'country',
            'helper_text' => 'country',
            'description' => 'country',
        ],
        'administrative_area_level_1' => [
            'label' => 'administrative_area_level_1',
            'placeholder' => 'administrative_area_level_1',
            'helper_text' => 'administrative_area_level_1',
            'description' => 'administrative_area_level_1',
        ],
        'administrative_area_level_2' => [
            'label' => 'administrative_area_level_2',
            'placeholder' => 'administrative_area_level_2',
            'helper_text' => 'administrative_area_level_2',
            'description' => 'administrative_area_level_2',
        ],
        'locality' => [
            'label' => 'locality',
            'placeholder' => 'locality',
            'helper_text' => 'locality',
            'description' => 'locality',
        ],
        'postal_code' => [
            'label' => 'postal_code',
            'placeholder' => 'postal_code',
            'helper_text' => 'postal_code',
            'description' => 'postal_code',
        ],
        'route' => [
            'label' => 'route',
            'placeholder' => 'route',
            'helper_text' => 'route',
            'description' => 'route',
            'helper' => 'Nome della via o strada',
        ],
        'street_number' => [
            'label' => 'street_number',
            'placeholder' => 'street_number',
            'helper_text' => 'street_number',
            'description' => 'street_number',
        ],
        'is_primary' => [
            'label' => 'is_primary',
            'placeholder' => 'is_primary',
            'helper_text' => 'is_primary',
            'description' => 'is_primary',
            'helper' => 'Imposta questo indirizzo come indirizzo principale',
        ],
        'model_type' => [
            'label' => 'Tipo modello',
            'placeholder' => 'Seleziona il tipo di modello',
        ],
        'model_id' => [
            'label' => 'ID modello',
            'placeholder' => 'Inserisci ID del modello',
        ],
        'description' => [
            'label' => 'Descrizione',
            'placeholder' => 'Inserisci una descrizione',
            'helper' => 'Note aggiuntive sull\'indirizzo',
        ],
        'administrative_area_level_3' => [
            'label' => 'Comune',
            'placeholder' => 'Inserisci il comune',
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
