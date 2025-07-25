<?php

declare(strict_types=1);

return [
    'title' => [
        'singular' => 'Studio Medico',
        'plural' => 'Studi Medici',
    ],
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome dello studio',
        ],
        'address' => [
            'label' => 'Indirizzo',
            'placeholder' => 'Inserisci l\'indirizzo',
        ],
        'city' => [
            'label' => 'Città',
            'placeholder' => 'Inserisci la città',
        ],
        'postal_code' => [
            'label' => 'CAP',
            'placeholder' => 'Inserisci il CAP',
        ],
        'phone' => [
            'label' => 'Telefono',
            'placeholder' => 'Inserisci il numero di telefono',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Inserisci l\'indirizzo email',
        ],
        'website' => [
            'label' => 'Sito Web',
            'placeholder' => 'Inserisci l\'URL del sito web',
        ],
        'registration_number' => [
            'label' => 'Numero di Registrazione',
            'placeholder' => 'Inserisci il numero di registrazione',
        ],
        'vat_number' => [
            'label' => 'Partita IVA',
            'placeholder' => 'Inserisci la partita IVA',
        ],
        'description' => [
            'label' => 'Descrizione',
            'placeholder' => 'Inserisci una descrizione dello studio',
        ],
        'opening_hours' => [
            'label' => 'Orari di Apertura',
            'placeholder' => 'Configura gli orari di apertura',
            'days' => [
                'monday' => 'Lunedì',
                'tuesday' => 'Martedì',
                'wednesday' => 'Mercoledì',
                'thursday' => 'Giovedì',
                'friday' => 'Venerdì',
                'saturday' => 'Sabato',
                'sunday' => 'Domenica',
            ],
            'open' => 'Apertura',
            'close' => 'Chiusura',
            'closed' => 'Chiuso',
        ],
        'services' => [
            'label' => 'Servizi',
            'placeholder' => 'Seleziona i servizi offerti',
        ],
        'active' => [
            'label' => 'Attivo',
            'true' => 'Sì',
            'false' => 'No',
        ],
    ],
    'filters' => [
        'active' => [
            'label' => 'Attivo',
            'options' => [
                'active' => 'Attivo',
                'inactive' => 'Inattivo',
            ],
        ],
        'city' => [
            'label' => 'Città',
            'placeholder' => 'Filtra per città',
        ],
    ],
    'actions' => [
        'activate' => 'Attiva',
        'deactivate' => 'Disattiva',
        'view_doctors' => 'Visualizza Dottori',
        'view_appointments' => 'Visualizza Appuntamenti',
    ],
    'notifications' => [
        'activated' => 'Studio attivato con successo',
        'deactivated' => 'Studio disattivato con successo',
    ],
    'sections' => [
        'basic_info' => 'Informazioni di Base',
        'contact_info' => 'Informazioni di Contatto',
        'fiscal_info' => 'Informazioni Fiscali',
        'operations' => 'Operatività',
    ],
];
