<?php

return array (
  'singular' => 'Indirizzo',
  'plural' => 'Indirizzi',
  'navigation' => 
  array (
    'sort' => 96,
    'icon' => 'address.navigation',
    'group' => 'address.navigation',
  ),
  'actions' => 
  array (
    'create' => 'Crea indirizzo',
    'edit' => 'Modifica indirizzo',
    'view' => 'Visualizza indirizzo',
    'delete' => 'Elimina indirizzo',
    'set_primary' => 'Imposta come principale',
    'verify' => 'Verifica indirizzo',
    'geocode' => 'Geocodifica',
  ),
  'fields' => 
  array (
    'model_type' => 
    array (
      'label' => 'Tipo modello',
      'placeholder' => 'Seleziona il tipo di modello',
    ),
    'model_id' => 
    array (
      'label' => 'ID modello',
      'placeholder' => 'Inserisci ID del modello',
    ),
    'name' => 
    array (
      'label' => 'Nome',
      'placeholder' => 'Inserisci un nome per l\'indirizzo',
      'helper' => 'Un nome identificativo per questo indirizzo, es. "Casa" o "Ufficio"',
      'helper_text' => '',
      'description' => 'name',
    ),
    'description' => 
    array (
      'label' => 'Descrizione',
      'placeholder' => 'Inserisci una descrizione',
      'helper' => 'Note aggiuntive sull\'indirizzo',
    ),
    'route' => 
    array (
      'label' => 'Via',
      'placeholder' => 'Inserisci la via',
      'helper' => 'Nome della via o strada',
      'description' => 'route',
      'helper_text' => '',
    ),
    'street_number' => 
    array (
      'label' => 'Numero civico',
      'placeholder' => 'Inserisci il numero civico',
      'description' => 'street_number',
      'helper_text' => '',
    ),
    'locality' => 
    array (
      'label' => 'Città',
      'placeholder' => 'Inserisci la città',
      'description' => 'locality',
      'helper_text' => '',
    ),
    'administrative_area_level_3' => 
    array (
      'label' => 'Comune',
      'placeholder' => 'Inserisci il comune',
    ),
    'administrative_area_level_2' => 
    array (
      'label' => 'Provincia',
      'placeholder' => 'Inserisci la provincia',
      'description' => 'administrative_area_level_2',
      'helper_text' => '',
    ),
    'administrative_area_level_1' => 
    array (
      'label' => 'Regione',
      'placeholder' => 'Inserisci la regione',
      'description' => 'administrative_area_level_1',
      'helper_text' => '',
    ),
    'country' => 
    array (
      'label' => 'Paese',
      'placeholder' => 'Inserisci il paese',
      'description' => 'country',
      'helper_text' => '',
    ),
    'postal_code' => 
    array (
      'label' => 'CAP',
      'placeholder' => 'Inserisci il CAP',
      'description' => 'postal_code',
      'helper_text' => '',
    ),
    'formatted_address' => 
    array (
      'label' => 'Indirizzo formattato',
      'placeholder' => 'Indirizzo formattato completo',
      'description' => 'formatted_address',
      'helper_text' => '',
    ),
    'place_id' => 
    array (
      'label' => 'ID luogo',
      'placeholder' => 'ID riferimento Google Maps',
    ),
    'latitude' => 
    array (
      'label' => 'Latitudine',
      'placeholder' => 'Inserisci la latitudine',
    ),
    'longitude' => 
    array (
      'label' => 'Longitudine',
      'placeholder' => 'Inserisci la longitudine',
      'description' => 'longitude',
      'helper_text' => '',
    ),
    'type' => 
    array (
      'label' => 'Tipo',
      'placeholder' => 'Seleziona il tipo di indirizzo',
      'options' => 
      array (
        'billing' => 'Fatturazione',
        'shipping' => 'Spedizione',
        'home' => 'Casa',
        'work' => 'Lavoro',
        'other' => 'Altro',
      ),
    ),
    'is_primary' => 
    array (
      'label' => 'Principale',
      'helper' => 'Imposta questo indirizzo come indirizzo principale',
      'description' => 'is_primary',
      'helper_text' => '',
      'placeholder' => 'is_primary',
    ),
    'extra_data' => 
    array (
      'label' => 'Dati aggiuntivi',
      'placeholder' => 'Inserisci dati aggiuntivi',
    ),
    'full_address' => 
    array (
      'label' => 'Indirizzo completo',
    ),
    'street_address' => 
    array (
      'label' => 'Indirizzo stradale',
    ),
    'map' => 
    array (
      'description' => 'map',
      'helper_text' => '',
    ),
    'aaa' => 
    array (
      'description' => 'aaa',
      'helper_text' => 'aaa',
      'placeholder' => 'aaa',
    ),
  ),
  'columns' => 
  array (
    'name' => 'Nome',
    'full_address' => 'Indirizzo completo',
    'type' => 'Tipo',
    'is_primary' => 'Principale',
    'locality' => 'Città',
    'postal_code' => 'CAP',
    'model' => 'Associato a',
  ),
  'messages' => 
  array (
    'primary_set' => 'Indirizzo impostato come principale con successo',
    'address_verified' => 'Indirizzo verificato correttamente',
    'geocoding_success' => 'Geocodifica completata con successo',
    'geocoding_failed' => 'Impossibile geocodificare l\'indirizzo',
  ),
  'sections' => 
  array (
    'location' => 
    array (
      'label' => 'Informazioni di localizzazione',
      'description' => 'Dati relativi alla posizione geografica',
    ),
    'address' => 
    array (
      'label' => 'Dati indirizzo',
      'description' => 'Dettagli dell\'indirizzo',
    ),
    'metadata' => 
    array (
      'label' => 'Metadati',
      'description' => 'Informazioni aggiuntive sull\'indirizzo',
    ),
    'map' => 
    array (
      'label' => 'Mappa',
      'description' => 'Visualizzazione su mappa',
    ),
  ),
);
