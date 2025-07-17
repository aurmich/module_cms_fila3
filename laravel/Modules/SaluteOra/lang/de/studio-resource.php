<?php

return [
    'title' => [
        'singular' => 'Praxis Arzt',
        'plural' => 'Studi Ärzte',
    ],
    'fields' => [
        'name' => [
            'label' => 'Vorname',
            'placeholder' => 'eingeben il nome dello studio',
        ],
        'address' => [
            'label' => 'Adresse',
            'placeholder' => 'eingeben l\'indirizzo',
        ],
        'city' => [
            'label' => 'Stadt',
            'placeholder' => 'eingeben la città',
        ],
        'postal_code' => [
            'label' => 'CAP',
            'placeholder' => 'eingeben il CAP',
        ],
        'phone' => [
            'label' => 'Telefon',
            'placeholder' => 'eingeben il numero di telefono',
        ],
        'email' => [
            'label' => 'E-Mail',
            'placeholder' => 'eingeben l\'indirizzo email',
        ],
        'website' => [
            'label' => 'Sito Web',
            'placeholder' => 'eingeben l\'URL del sito web',
        ],
        'registration_number' => [
            'label' => 'Numero di Registrazione',
            'placeholder' => 'eingeben il numero di registrazione',
        ],
        'vat_number' => [
            'label' => 'Umsatzsteuernummer',
            'placeholder' => 'eingeben la partita IVA',
        ],
        'description' => [
            'label' => 'Descrizione',
            'placeholder' => 'eingeben una descrizione dello studio',
        ],
        'opening_hours' => [
            'label' => 'Orari di Apertura',
            'placeholder' => 'Configura gli orari di apertura',
            'days' => [
                'monday' => 'Montag',
                'tuesday' => 'Dienstag',
                'wednesday' => 'Mittwoch',
                'thursday' => 'Donnerstag',
                'friday' => 'Freitag',
                'saturday' => 'Samstag',
                'sunday' => 'Sonntag',
            ],
            'open' => 'Apertura',
            'close' => 'Chiusura',
            'closed' => 'Chiuso',
        ],
        'services' => [
            'label' => 'Servizi',
            'placeholder' => 'auswählen i servizi offerti',
        ],
        'active' => [
            'label' => 'Aktiv',
            'true' => 'Sì',
            'false' => 'No',
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
            'placeholder' => 'Filtra per città',
        ],
    ],
    'actions' => [
        'activate' => 'aktivieren',
        'deactivate' => 'Disattiva',
        'view_doctors' => 'anzeigen Dottori',
        'view_appointments' => 'anzeigen Appuntamenti',
    ],
    'notifications' => [
        'activated' => 'Praxis attivato erfolgreich',
        'deactivated' => 'Praxis disattivato erfolgreich',
    ],
    'sections' => [
        'basic_info' => 'Informazioni di Base',
        'contact_info' => 'Informazioni di Contatto',
        'fiscal_info' => 'Informazioni Fiscali',
        'operations' => 'Operatività',
    ],
];
