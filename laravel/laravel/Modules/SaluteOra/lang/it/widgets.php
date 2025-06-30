<?php

declare(strict_types=1);

return [
    'find_doctor_and_appointment' => [
        'title' => 'Trova dottore e prenota appuntamento',
        'description' => 'Seleziona la tua zona, scegli un dottore e prenota un appuntamento',
        
        'fields' => [
            'cap' => [
                'label' => 'CAP',
                'placeholder' => 'Inserisci il CAP',
                'helper_text' => 'Inserisci il codice postale della tua zona',
            ],
            'studio' => [
                'label' => 'Studio',
                'placeholder' => 'Nome dello studio selezionato',
                'helper_text' => 'Studio dentistico per la prenotazione',
            ],
            'doctor' => [
                'label' => 'Dottore',
                'placeholder' => 'Seleziona un dottore',
                'helper_text' => 'Scegli il dottore con cui vuoi prenotare l\'appuntamento',
            ],
            'appointment_date' => [
                'label' => 'Data Appuntamento',
                'placeholder' => 'Seleziona una data',
                'helper_text' => 'Scegli la data per il tuo appuntamento',
            ],
            'appointment_time' => [
                'label' => 'Orario',
                'placeholder' => 'Seleziona un orario',
                'helper_text' => 'Scegli l\'orario per il tuo appuntamento',
            ],
            'notes' => [
                'label' => 'Note',
                'placeholder' => 'Aggiungi eventuali note o richieste speciali',
                'helper_text' => 'Informazioni aggiuntive per il dottore (opzionale)',
            ],
        ],
    ],

    // Traduzioni per StudioFilterWidget
    'studio_filter' => [
        'title' => 'Studio Corrente',
        
        'studio' => [
            'address' => 'Indirizzo',
            'phone' => 'Telefono',
            'email' => 'Email',
            'website' => 'Sito Web',
        ],
        
        'doctor' => [
            'label' => 'Dottore',
            'registration_number' => 'Numero Iscrizione',
        ],
        
        'change_studio' => [
            'label' => 'Cambia Studio',
        ],
        
        'total_studios' => 'studi disponibili',
        
        'actions' => [
            'refresh' => 'Aggiorna',
        ],
        
        'no_studio' => [
            'title' => 'Nessuno Studio Disponibile',
            'description' => 'Non hai accesso a nessuno studio al momento. Contatta l\'amministratore.',
        ],
        
        'messages' => [
            'studio_changed' => 'Studio cambiato',
            'studio_changed_body' => 'Ora stai lavorando nello studio: :studio',
        ],
        
        'errors' => [
            'unauthorized' => 'Non hai i permessi per accedere a questo studio',
        ],
    ],
];
