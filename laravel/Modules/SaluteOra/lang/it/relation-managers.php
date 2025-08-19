<?php

declare(strict_types=1);

return [
    'doctors' => [
        'title' => 'Dottori',
        'fields' => [
            'first_name' => 'Nome',
            'last_name' => 'Cognome',
            'email' => 'Email',
            'phone' => 'Telefono',
            'specialization' => 'Specializzazione',
            'registration_number' => 'N° Iscrizione',
            'status' => 'Stato',
            'created_at' => 'Creato il',
        ],
        'actions' => [
            'create' => 'Aggiungi dentista',
            'edit' => 'Modifica dentista',
            'delete' => 'Rimuovi dentista',
            'view' => 'Visualizza dentista',
        ],
    ],
    'studios' => [
        'title' => 'Studi',
        'fields' => [
            'name' => 'Nome',
            'email' => 'Email',
            'phone' => 'Telefono',
            'address' => 'Indirizzo',
            'website' => 'Sito web',
            'registration_number' => 'Partita IVA',
            'vat_number' => 'N° Registrazione',
            'active' => 'Attivo',
            'created_at' => 'Creato il',
        ],
        'actions' => [
            'create' => 'Aggiungi studio',
            'edit' => 'Modifica studio',
            'delete' => 'Rimuovi studio',
            'view' => 'Visualizza studio',
        ],
    ],
];