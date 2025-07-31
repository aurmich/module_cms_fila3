<?php

declare(strict_types=1);

return [
    'label' => 'Integrazione Richiesta',
    'description' => 'Richiesta di integrazione dati in corso',
    'tooltip' => 'L\'utente ha richiesto l\'integrazione dei dati',
    'color' => 'warning',
    'bg_color' => '#f59e0b',
    'icon' => 'heroicon-o-clock',
    'modal_heading' => 'Richiesta di Integrazione Dati',
    'modal_description' => 'L\'utente ha richiesto l\'integrazione dei propri dati. Rivedi la richiesta e procedi con l\'approvazione o il rifiuto.',
    
    'actions' => [
        'approve' => [
            'label' => 'Approva Integrazione',
            'confirmation' => 'Sei sicuro di voler approvare la richiesta di integrazione?',
            'success' => 'Richiesta di integrazione approvata con successo',
            'error' => 'Errore durante l\'approvazione della richiesta',
        ],
        'reject' => [
            'label' => 'Rifiuta Integrazione',
            'confirmation' => 'Sei sicuro di voler rifiutare la richiesta di integrazione?',
            'success' => 'Richiesta di integrazione rifiutata',
            'error' => 'Errore durante il rifiuto della richiesta',
        ],
        'view_request' => [
            'label' => 'Visualizza Richiesta',
            'tooltip' => 'Visualizza i dettagli della richiesta di integrazione',
        ],
        'contact_user' => [
            'label' => 'Contatta Utente',
            'tooltip' => 'Contatta l\'utente per chiarimenti',
        ],
    ],
    
    'modal' => [
        'heading' => 'Richiesta di Integrazione Dati',
        'description' => 'L\'utente ha richiesto l\'integrazione dei propri dati. Rivedi la richiesta e procedi con l\'approvazione o il rifiuto.',
        'confirm' => 'Conferma',
        'cancel' => 'Annulla',
    ],
    
    
    'fields' => [
        'message' => [
            'label' => 'Messaggio',
            'placeholder' => 'Inserisci un messaggio per la richiesta di integrazione',
            'helper_text' => '',
            'description' => 'Messaggio relativo alla richiesta di integrazione documenti',
        ],
        'required_documents' => [
            'label' => 'Documenti Richiesti',
            'placeholder' => 'Elenca i documenti necessari',
            'helper_text' => '',
            'description' => 'Data in cui è stata effettuata la richiesta di integrazione',
        ],
        'integration_type' => [
            'label' => 'Tipo di Integrazione',
            'placeholder' => 'Seleziona il tipo di integrazione',
            'helper_text' => '',
            'description' => 'Tipologia di integrazione dati richiesta',
        ],
        'priority' => [
            'label' => 'Priorità',
            'placeholder' => 'Seleziona la priorità',
            'helper_text' => '',
            'description' => 'Livello di priorità della richiesta',
        ],
    ],
];
