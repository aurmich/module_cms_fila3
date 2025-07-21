<?php

declare(strict_types=1);

return [
    'status' => [
        'pending' => [
            'label' => 'Der Bericht wartet auf die Generierung.',
            'tooltip' => 'Der Bericht wurde noch nicht generiert',
            'helper_text' => '',
        ],
        'processing' => [
            'label' => 'Der Bericht wird verarbeitet.',
            'tooltip' => 'Der Bericht wird generiert',
            'helper_text' => '',
        ],
        'error' => [
            'label' => 'Beim Generieren des Berichts ist ein Fehler aufgetreten.',
            'tooltip' => 'Fehler bei der Berichtserstellung',
            'helper_text' => '',
        ],
        'empty' => [
            'label' => 'Für diesen Bericht sind keine Daten verfügbar.',
            'tooltip' => 'Keine Daten verfügbar',
            'helper_text' => '',
        ],
    ],
    'group' => [
        'label' => 'Gruppe',
        'tooltip' => 'Datenkategorie des Berichts',
        'helper_text' => '',
    ],
    'json_parse_error' => [
        'label' => 'Fehler beim Parsen der JSON-Daten',
        'tooltip' => 'Fehler beim Lesen der JSON-Daten',
        'helper_text' => '',
    ],
]; 