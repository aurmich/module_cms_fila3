<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Folio Paths
    |--------------------------------------------------------------------------
    |
    | This array contains the paths that Folio will use to find your pages.
    | You can add as many paths as you need.
    |
    */

    'paths' => [
        resource_path('views/pages'),
        base_path('Themes/One/resources/views/pages'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Folio Middleware
    |--------------------------------------------------------------------------
    |
    | This array contains the middleware that will be applied to all Folio pages.
    | You can add as many middleware as you need.
    |
    */

    'middleware' => [
        'web',
    ],

    /*
    |--------------------------------------------------------------------------
    | Folio View Data
    |--------------------------------------------------------------------------
    |
    | This array contains the data that will be passed to all Folio views.
    | You can add as many items as you need.
    |
    */

    'view_data' => [
        'title' => 'SaluteOra',
    ],
];
