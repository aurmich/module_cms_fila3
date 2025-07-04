<?php

declare(strict_types=1);

return [
    'title' => 'Appuntamenti Dottore',
    'description' => 'Gestione degli appuntamenti per i dottori',
    
    'actions' => [
        'delete' => [
            'label' => 'Elimina',
            'tooltip' => 'Elimina questo appuntamento',
            'confirmation' => 'Sei sicuro di voler eliminare questo appuntamento?',
        ],
        'accept' => [
            'label' => 'Accetta',
            'tooltip' => 'Accetta questo appuntamento',
            'confirmation' => 'Sei sicuro di voler accettare questo appuntamento?',
        ],
        'confirm' => [
            'label' => 'Conferma',
            'tooltip' => 'Conferma questo appuntamento',
            'confirmation' => 'Sei sicuro di voler confermare questo appuntamento?',
        ],
        'confirmed' => [
            'label' => 'Confermato',
            'tooltip' => 'Appuntamento confermato',
        ],
        'confirmAction' => [
            'label' => 'Azione Conferma',
            'tooltip' => 'Esegui azione di conferma',
        ],
        'rejectAction' => [
            'label' => 'Rifiuta',
            'tooltip' => 'Rifiuta questo appuntamento',
            'confirmation' => 'Sei sicuro di voler rifiutare questo appuntamento?',
        ],
        'info' => [
            'label' => 'Informazioni',
            'tooltip' => 'Visualizza informazioni dettagliate',
        ],
    ],
    
    'messages' => [
        'appointment_accepted' => 'Appuntamento accettato con successo',
        'appointment_confirmed' => 'Appuntamento confermato con successo',
        'appointment_rejected' => 'Appuntamento rifiutato con successo',
        'appointment_deleted' => 'Appuntamento eliminato con successo',
        'error_occurred' => 'Si è verificato un errore',
    ],
    
    'status' => [
        'pending' => 'In attesa',
        'confirmed' => 'Confermato',
        'rejected' => 'Rifiutato',
        'completed' => 'Completato',
        'cancelled' => 'Annullato',
    ],
];
