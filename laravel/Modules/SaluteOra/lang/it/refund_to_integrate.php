<?php

declare(strict_types=1);

return [
    'label' => 'Rimborso da Integrare',
    'description' => 'Rimborso in attesa di integrazione nel sistema',
    'tooltip' => 'Il rimborso richiede integrazione con dati aggiuntivi',
    'color' => 'warning',
    'icon' => 'heroicon-o-exclamation-triangle',
    
    'actions' => [
        'start_integration' => [
            'label' => 'Avvia Integrazione',
            'confirmation' => 'Sei sicuro di voler avviare il processo di integrazione?',
            'success' => 'Processo di integrazione avviato con successo',
            'error' => 'Errore durante l\'avvio dell\'integrazione',
        ],
        'request_documents' => [
            'label' => 'Richiedi Documenti',
            'confirmation' => 'Sei sicuro di voler richiedere documenti aggiuntivi?',
            'success' => 'Richiesta documenti inviata',
            'error' => 'Errore durante la richiesta documenti',
        ],
        'view_requirements' => [
            'label' => 'Visualizza Requisiti',
            'tooltip' => 'Visualizza i requisiti per l\'integrazione',
        ],
        'contact_support' => [
            'label' => 'Contatta Supporto',
            'tooltip' => 'Contatta il supporto per assistenza',
        ],
    ],
    
    'modal' => [
        'heading' => 'Rimborso da Integrare',
        'description' => 'Questo rimborso richiede integrazione con documenti o informazioni aggiuntive prima di poter essere elaborato.',
        'confirm' => 'Conferma',
        'cancel' => 'Annulla',
    ],
    
    'messages' => [
        'integration_required' => 'Integrazione richiesta per completare il rimborso',
        'documents_missing' => 'Documenti mancanti per l\'elaborazione',
        'verification_pending' => 'Verifica documenti in corso',
        'estimated_time' => 'Tempo stimato: 5-7 giorni lavorativi',
    ],
    
    'fields' => [
        'message' => [
            'label' => 'Messaggio di Integrazione',
            'placeholder' => 'Inserisci dettagli sull\'integrazione richiesta',
            'helper_text' => '',
            'description' => 'Dettagli specifici sui requisiti di integrazione',
        ],
        'integration_type' => [
            'label' => 'Tipo di Integrazione',
            'placeholder' => 'Seleziona il tipo di integrazione',
            'helper_text' => '',
            'description' => 'Tipologia di integrazione richiesta per il rimborso',
        ],
        'required_documents' => [
            'label' => 'Documenti Richiesti',
            'placeholder' => 'Elenco dei documenti necessari',
            'helper_text' => '',
            'description' => 'Lista dei documenti necessari per completare l\'integrazione',
        ],
        'deadline' => [
            'label' => 'Scadenza',
            'placeholder' => 'Data limite per l\'integrazione',
            'helper_text' => '',
            'description' => 'Data entro cui completare l\'integrazione',
        ],
        'priority_level' => [
            'label' => 'Livello di Priorità',
            'placeholder' => 'Seleziona la priorità',
            'helper_text' => '',
            'description' => 'Livello di urgenza per l\'integrazione',
        ],
    ],
];
