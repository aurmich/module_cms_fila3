<?php

declare(strict_types=1);

return [
    'label' => 'Patient',
    'plural_label' => 'Patienten',
    'navigation_group' => 'SaluteOra',
    'navigation_icon' => 'heroicon-o-user-group',
    'navigation_sort' => 2,
    'description' => 'Verwaltung der Patienten und ihrer Daten',
    'steps' => [
        'personal_data_step' => [
            'label' => 'Persönliche Daten',
            'description' => 'Geben Sie Ihre persönlichen Daten ein',
        ],
        'documents_step' => [
            'label' => 'Dokumente',
            'description' => 'Laden Sie die erforderlichen Dokumente hoch',
        ],
        'pre_visit_step' => [
            'label' => 'Vor dem Besuch',
            'description' => 'Vorläufige Informationen',
        ],
        'privacy_step' => [
            'label' => 'Datenschutz',
            'description' => 'Akzeptierung der Datenschutzerklärung und Einwilligungen',
        ],
    ],
    'fields' => [
        'first_name' => [
            'label' => 'Vorname',
            'placeholder' => 'Vorname eingeben',
            'help' => 'Geben Sie Ihren vollständigen Vornamen ein',
        ],
        'last_name' => [
            'label' => 'Nachname',
            'placeholder' => 'Nachname eingeben',
            'help' => 'Geben Sie Ihren vollständigen Nachnamen ein',
        ],
        'address' => [
            'label' => 'Adresse',
            'placeholder' => 'Adresse eingeben',
        ],
        'city' => [
            'label' => 'Stadt',
            'placeholder' => 'Stadt eingeben',
            'tooltip' => 'Stadt des Patienten',
            'helper_text' => 'Geben Sie die Stadt ein, in der der Patient wohnt',
            'description' => 'Stadt des Patienten für die Dokumentation',
            'icon' => 'heroicon-o-map-pin',
            'color' => 'primary',
        ],
        'phone' => [
            'label' => 'Telefon',
            'placeholder' => 'Telefonnummer eingeben',
            'help' => 'Telefonnummer für Kontakte',
        ],
        'email' => [
            'label' => 'E-Mail',
            'placeholder' => 'E-Mail-Adresse eingeben',
            'help' => 'Gültige E-Mail-Adresse',
        ],
        'health_card' => [
            'label' => 'Gesundheitskarte',
            'tooltip' => 'Laden Sie einen Scan Ihrer Gesundheitskarte hoch',
        ],
        'identity_document' => [
            'label' => 'Personalausweis',
            'tooltip' => 'Laden Sie einen Scan Ihres Personalausweises hoch',
        ],
        'isee_certificate' => [
            'label' => 'ISEE-Zertifikat',
            'tooltip' => 'Laden Sie Ihr ISEE-Zertifikat hoch, falls verfügbar',
        ],
        'pregnancy_certificate' => [
            'label' => 'Schwangerschaftsbescheinigung',
            'tooltip' => 'Laden Sie die Schwangerschaftsbescheinigung hoch, falls zutreffend',
        ],
        'fiscal_code' => [
            'label' => 'Steuernummer',
            'placeholder' => 'Steuernummer eingeben',
            'help' => 'Steuernummer wie auf der Gesundheitskarte',
        ],
        'birth_date' => [
            'label' => 'Geburtsdatum',
            'placeholder' => 'Geburtsdatum auswählen',
            'help' => 'Geben Sie das Geburtsdatum im Format TT/MM/JJJJ ein',
        ],
        'last_dental_visit' => [
            'label' => 'Letzter Zahnarztbesuch',
            'tooltip' => 'Wann haben Sie das letzte Mal den Zahnarzt besucht?',
        ],
        'dental_problems' => [
            'label' => 'Zahnprobleme',
            'placeholder' => 'Beschreiben Sie eventuelle Zahnprobleme',
        ],
        'privacy_acceptance' => [
            'label' => 'Datenschutz-Akzeptierung',
            'tooltip' => 'Sie müssen die Datenschutzerklärung akzeptieren, um fortzufahren',
        ],
        'newsletter' => [
            'label' => 'Newsletter',
            'tooltip' => 'Möchten Sie Updates per E-Mail erhalten?',
        ],
        'gender' => [
            'label' => 'Geschlecht',
            'placeholder' => 'Geschlecht auswählen',
            'help' => 'Wählen Sie das demografische Geschlecht',
        ],
    ],
    'buttons' => [
        'submit' => [
            'label' => 'AKZEPTIEREN UND FORTFAHREN',
        ],
    ],
];
