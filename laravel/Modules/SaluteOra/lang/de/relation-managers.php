<?php

return [
    'doctors' => [
        'title' => 'Dottori',
        'fields' => [
            'first_name' => 'Vorname',
            'last_name' => 'Nachname',
            'email' => 'E-Mail',
            'phone' => 'Telefon',
            'specialization' => 'Spezialisierung',
            'registration_number' => 'N° Iscrizione',
            'status' => 'Status',
            'created_at' => 'Creato il',
        ],
        'actions' => [
            'create' => 'Aggiungi dottore',
            'edit' => 'bearbeiten dottore',
            'delete' => 'Rimuovi dottore',
            'view' => 'anzeigen dottore',
        ],
    ],
    'studios' => [
        'title' => 'Studi',
        'fields' => [
            'name' => 'Vorname',
            'email' => 'E-Mail',
            'phone' => 'Telefon',
            'address' => 'Adresse',
            'website' => 'Sito web',
            'registration_number' => 'Umsatzsteuernummer',
            'vat_number' => 'N° Registrazione',
            'active' => 'Aktiv',
            'created_at' => 'Creato il',
        ],
        'actions' => [
            'create' => 'Aggiungi studio',
            'edit' => 'bearbeiten studio',
            'delete' => 'Rimuovi studio',
            'view' => 'anzeigen studio',
        ],
    ],
];
