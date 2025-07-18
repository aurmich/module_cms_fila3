<?php

declare(strict_types=1);

return [
    'section_title' => 'Meine Daten',
    'actions' => [
        'delete' => [
            'label' => 'Löschen',
        ],
        'edit' => [
            'label' => 'Bearbeiten',
            'modal_heading' => 'Profil bearbeiten',
            'modal_description' => 'Aktualisieren Sie Ihre persönlichen Profilinformationen',
        ],
    ],
    'fields' => [
        'address' => [
            'label' => 'Adresse',
            'placeholder' => 'Geben Sie Ihre Adresse ein',
            'help' => 'Geben Sie Ihre Wohn- oder Meldeadresse an',
            'description' => 'Vollständige Adresse des Benutzers',
            'helper_text' => '',
        ],
        'phone' => [
            'label' => 'Telefon',
            'placeholder' => 'Geben Sie Ihre Telefonnummer ein',
            'help' => 'Telefonnummer für Kontakte',
            'description' => 'Primäre Telefonnummer',
            'helper_text' => '',
        ],
        'last_name' => [
            'label' => 'Nachname',
            'placeholder' => 'Geben Sie Ihren Nachnamen ein',
            'help' => 'Ihr Nachname gemäß offiziellen Dokumenten',
            'description' => 'Nachname des Benutzers',
            'helper_text' => '',
        ],
        'first_name' => [
            'label' => 'Vorname',
            'placeholder' => 'Geben Sie Ihren Vornamen ein',
            'help' => 'Ihr Vorname gemäß offiziellen Dokumenten',
            'description' => 'Vorname des Benutzers',
            'helper_text' => '',
        ],
    ],
]; 