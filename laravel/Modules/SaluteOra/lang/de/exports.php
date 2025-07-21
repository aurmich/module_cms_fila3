<?php

declare(strict_types=1);

return [
    'info' => [
        'type_label' => [
            'label' => 'Berichtstyp:',
            'tooltip' => 'Typ des generierten Berichts',
            'helper_text' => '',
        ],
        'period_label' => [
            'label' => 'Zeitraum:',
            'tooltip' => 'Bezugszeitraum des Berichts',
            'helper_text' => '',
        ],
        'generated_at_label' => [
            'label' => 'Generiert am:',
            'tooltip' => 'Datum und Uhrzeit der Generierung',
            'helper_text' => '',
        ],
        'key' => [
            'label' => 'Schlüssel',
            'tooltip' => 'Tabellenspalte Schlüssel',
            'helper_text' => '',
        ],
        'value' => [
            'label' => 'Wert',
            'tooltip' => 'Tabellenspalte Wert',
            'helper_text' => '',
        ],
    ],
    'types' => [
        'paziente_demografico' => 'Demografische Analyse der Patienten',
        'visite_per_periodo' => 'Besuchsstatistiken nach Zeitraum',
        'attivita_odontoiatri' => 'Analyse der Zahnarzttätigkeit',
        'isee_analisi' => 'ISEE-Analyse der Patienten',
    ],
    'footer' => [
        'generated_by' => [
            'label' => 'Bericht generiert von: das Projekt',
            'tooltip' => 'Text zur Berichtserstellung',
            'helper_text' => '',
        ],
        'copyright' => [
            'label' => '© :year das Projekt. Alle Rechte vorbehalten.',
            'tooltip' => 'Urheberrecht',
            'helper_text' => '',
        ],
    ],
]; 