<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Google Maps API Key
    |--------------------------------------------------------------------------
    |
    | Chiave API di Google Maps utilizzata per le funzionalità di mappa.
    | 
    | Ottenere una chiave all'indirizzo: https://developers.google.com/maps/documentation/javascript/get-api-key
    |
    */
    'key' => env('GOOGLE_MAPS_API_KEY', 'AIzaSyDMF9c75w9THSHnxNB3x-3dkm0SDwNx-gA'),

    /*
    |--------------------------------------------------------------------------
    | Google Maps Libraries
    |--------------------------------------------------------------------------
    |
    | Le librerie di Google Maps da caricare.
    |
    */
    'libraries' => 'places',

    /*
    |--------------------------------------------------------------------------
    | Default Map Center
    |--------------------------------------------------------------------------
    |
    | Coordinate di default per il centro della mappa quando non è specificato.
    |
    */
    'default_location' => [
        'lat' => 41.9027835,
        'lng' => 12.4963655,
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Zoom Level
    |--------------------------------------------------------------------------
    |
    | Livello di zoom predefinito per le mappe.
    |
    */
    'default_zoom' => 8,

    /*
    |--------------------------------------------------------------------------
    | Map Height
    |--------------------------------------------------------------------------
    |
    | Altezza predefinita della mappa.
    |
    */
    'height' => 400,

    /*
    |--------------------------------------------------------------------------
    | Default Map Type
    |--------------------------------------------------------------------------
    |
    | Tipo di mappa predefinito: roadmap, satellite, hybrid, terrain
    |
    */
    'type' => 'roadmap',

    /*
    |--------------------------------------------------------------------------
    | Include Google Maps JavaScript
    |--------------------------------------------------------------------------
    |
    | Permette di disabilitare il caricamento dello script JavaScript di Google Maps,
    | utile quando si ha già incluso lo script altrove.
    |
    */
    'include_js' => true,

    /*
    |--------------------------------------------------------------------------
    | Map Controls
    |--------------------------------------------------------------------------
    |
    | Configurazione predefinita dei controlli della mappa.
    |
    */
    'controls' => [
        'mapType' => true,
        'scale' => true,
        'streetView' => true,
        'rotate' => false,
        'fullscreen' => true,
        'searchBox' => false,
        'zoomControl' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Drawing Mode
    |--------------------------------------------------------------------------
    |
    | Configurazione della modalità di disegno sulla mappa.
    |
    */
    'drawing' => [
        'enabled' => false,
        'mode' => 'polygon', // marker, circle, polygon, polyline, rectangle
    ],

    /*
    |--------------------------------------------------------------------------
    | Geocoding Settings
    |--------------------------------------------------------------------------
    |
    | Configurazione per il geocoding.
    |
    */
    'geocoding' => [
        'region' => 'it',
        'language' => 'it',
    ],
];