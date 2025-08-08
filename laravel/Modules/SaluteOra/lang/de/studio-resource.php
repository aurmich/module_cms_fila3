<?php

declare(strict_types=1);

return [
    'label' => 'Praxis',
    'plural_label' => 'Praxen',
    'navigation_group' => 'SaluteOra',
    'navigation_icon' => 'heroicon-o-building-office',
    'navigation_sort' => 1,
    'description' => 'Verwaltung der medizinischen Praxen',
    'fields' => [
        'name' => [
            'label' => 'Name',
            'placeholder' => 'Name der Praxis eingeben',
        ],
        'address' => [
            'label' => 'Adresse',
            'placeholder' => 'Adresse eingeben',
        ],
        'city' => [
            'label' => 'Stadt',
            'placeholder' => 'Stadt eingeben',
            'tooltip' => 'Stadt der Praxis',
            'helper_text' => 'Geben Sie die Stadt ein, in der sich die Praxis befindet',
            'description' => 'Stadt der Praxis für die Terminbuchung',
            'icon' => 'heroicon-o-map-pin',
            'color' => 'primary',
        ],
        'postal_code' => [
            'label' => 'PLZ',
            'placeholder' => 'PLZ eingeben',
        ],
        'phone' => [
            'label' => 'Telefon',
            'placeholder' => 'Telefonnummer eingeben',
        ],
        'email' => [
            'label' => 'E-Mail',
            'placeholder' => 'E-Mail-Adresse eingeben',
        ],
        'website' => [
            'label' => 'Website',
            'placeholder' => 'Website-URL eingeben',
        ],
        'registration_number' => [
            'label' => 'Registrierungsnummer',
            'placeholder' => 'Registrierungsnummer eingeben',
        ],
        'vat_number' => [
            'label' => 'Umsatzsteuernummer',
            'placeholder' => 'Umsatzsteuernummer eingeben',
        ],
        'description' => [
            'label' => 'Beschreibung',
            'placeholder' => 'Beschreibung der Praxis eingeben',
        ],
        'opening_hours' => [
            'label' => 'Öffnungszeiten',
            'placeholder' => 'Öffnungszeiten konfigurieren',
            'days' => [
                'monday' => 'Montag',
                'tuesday' => 'Dienstag',
                'wednesday' => 'Mittwoch',
                'thursday' => 'Donnerstag',
                'friday' => 'Freitag',
                'saturday' => 'Samstag',
                'sunday' => 'Sonntag',
            ],
            'open' => 'Öffnung',
            'close' => 'Schließung',
            'closed' => 'Geschlossen',
        ],
        'services' => [
            'label' => 'Dienstleistungen',
            'placeholder' => 'Angebotene Dienstleistungen auswählen',
        ],
        'active' => [
            'label' => 'Aktiv',
            'true' => 'Ja',
            'false' => 'Nein',
        ],
    ],
    'filters' => [
        'active' => [
            'label' => 'Aktiv',
            'options' => [
                'active' => 'Aktiv',
                'inactive' => 'Inaktiv',
            ],
        ],
        'city' => [
            'label' => 'Stadt',
            'placeholder' => 'Nach Stadt filtern',
        ],
    ],
    'actions' => [
        'activate' => 'Aktivieren',
        'deactivate' => 'Deaktivieren',
        'view_doctors' => 'Ärzte anzeigen',
        'view_appointments' => 'Termine anzeigen',
    ],
    'notifications' => [
        'activated' => 'Praxis erfolgreich aktiviert',
        'deactivated' => 'Praxis erfolgreich deaktiviert',
    ],
    'sections' => [
        'basic_info' => 'Grundinformationen',
        'contact_info' => 'Kontaktinformationen',
        'fiscal_info' => 'Steuerinformationen',
        'operations' => 'Betrieb',
    ],
];
