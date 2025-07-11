<?php

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
    'states' => [
        'pending' => [
            'label' => 'In attesa',
            'color' => 'warning',
            'bg_color' => '#FEF3C7',
            'icon' => 'heroicon-o-clock',
        ],
        'confirmed' => [
            'label' => 'Confermato',
            'color' => 'success',
            'bg_color' => '#D1FAE5',
            'icon' => 'heroicon-o-check-circle',
        ],
        'rejected' => [
            'label' => 'Rifiutato',
            'color' => 'danger',
            'bg_color' => '#FEE2E2',
            'icon' => 'heroicon-o-x-circle',
        ],
        'completed' => [
            'label' => 'Completato',
            'color' => 'success',
            'bg_color' => '#ECFDF5',
            'icon' => 'heroicon-o-check-badge',
        ],
        'cancelled' => [
            'label' => 'Annullato',
            'color' => 'gray',
            'bg_color' => '#F3F4F6',
            'icon' => 'heroicon-o-no-symbol',
        ],
    ],
    'fields' => [
        'message' => [
            'description' => 'Messaggio',
            'helper_text' => '',
            'placeholder' => '',
            'label' => 'Messaggio',
        ],
    ],
];
