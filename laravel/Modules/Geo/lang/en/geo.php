<?php

declare(strict_types=1);

return [
    'navigation' => [
        'icons' => [
            'location-map' => [
                'default' => 'heroicon-o-map-pin',
                'hover' => 'heroicon-o-map-pin animate-bounce',
                'title' => 'Location icon',
            ],
            'lat-lng' => [
                'default' => 'heroicon-o-map-pin',
                'hover' => 'heroicon-o-map-pin animate-pulse',
                'title' => 'Coordinates icon',
            ],
            'webbingbrasil-map' => [
                'default' => 'heroicon-o-map',
                'hover' => 'heroicon-o-map animate-spin',
                'title' => 'Webbingbrasil map icon',
            ],
            'osm-map' => [
                'default' => 'heroicon-o-globe-alt',
                'hover' => 'heroicon-o-globe-alt animate-spin',
                'title' => 'Global map icon',
            ],
            'dotswan-map' => [
                'default' => 'heroicon-o-map',
                'hover' => 'heroicon-o-map animate-spin',
                'title' => 'Dotswan map icon',
            ],
            'setting-page' => [
                'default' => 'heroicon-o-cog-6-tooth',
                'hover' => 'heroicon-o-cog-6-tooth animate-spin',
                'title' => 'Settings icon',
            ],
        ],
        'groups' => [
            'geo' => [
                'name' => 'Geo',
                'description' => 'Maps and location management',
            ],
        ],
        'pages' => [
            'location-map' => [
                'label' => 'Location Map',
                'description' => 'View and manage locations on the map',
                'sort' => 1,
            ],
            'lat-lng' => [
                'label' => 'Coordinates',
                'description' => 'Geographic coordinates management',
                'sort' => 2,
            ],
            'webbingbrasil-map' => [
                'label' => 'Webbingbrasil Map',
                'description' => 'Map view with Webbingbrasil',
                'sort' => 3,
            ],
            'osm-map' => [
                'label' => 'OSM Map',
                'description' => 'OpenStreetMap view',
                'sort' => 4,
            ],
            'dotswan-map' => [
                'label' => 'Dotswan Map',
                'description' => 'Map view with Dotswan',
                'sort' => 5,
            ],
            'setting-page' => [
                'label' => 'Settings',
                'description' => 'Geo module configuration',
                'sort' => 6,
            ],
        ],
    ],
    'status' => [
        'waiting' => 'Waiting...',
        'loading' => 'Loading...',
        'error' => 'Error',
        'success' => 'Completed',
    ],
    'actions' => [
        'save' => 'Save',
        'cancel' => 'Cancel',
        'delete' => 'Delete',
        'edit' => 'Edit',
        'view' => 'View',
    ],
    'messages' => [
        'saved' => 'Successfully saved',
        'deleted' => 'Successfully deleted',
        'error' => 'An error occurred',
    ],
];
