<?php

declare(strict_types=1);

return [
    'label' => 'Rimborso Completato',
    'description' => 'Il rimborso è stato elaborato e completato',
    'tooltip' => 'Il rimborso è stato processato con successo',
    'color' => 'success',
    'bg_color' => '#10b981',
    'icon' => 'heroicon-o-check-circle',
    'modal_heading' => 'Rimborso Completato',
    'modal_description' => 'Il rimborso è stato elaborato con successo. L\'importo è stato accreditato secondo le modalità specificate.',
    
    'actions' => [
        'view_receipt' => [
            'label' => 'Visualizza Ricevuta',
            'tooltip' => 'Visualizza la ricevuta del rimborso',
        ],
        'download_receipt' => [
            'label' => 'Scarica Ricevuta',
            'tooltip' => 'Scarica la ricevuta in formato PDF',
        ],
        'send_confirmation' => [
            'label' => 'Invia Conferma',
            'confirmation' => 'Sei sicuro di voler inviare la conferma del rimborso?',
            'success' => 'Conferma inviata con successo',
            'error' => 'Errore durante l\'invio della conferma',
        ],
        'archive' => [
            'label' => 'Archivia',
            'confirmation' => 'Sei sicuro di voler archiviare questo rimborso?',
            'success' => 'Rimborso archiviato con successo',
            'error' => 'Errore durante l\'archiviazione',
        ],
    ],
    
    'modal' => [
        'heading' => 'Rimborso Completato',
        'description' => 'Il rimborso è stato elaborato con successo. L\'importo è stato accreditato secondo le modalità specificate.',
        'confirm' => 'Conferma',
        'cancel' => 'Annulla',
    ],
    
    'messages' => [
        'processing_completed' => 'Elaborazione completata con successo',
        'amount_credited' => 'Importo accreditato correttamente',
        'confirmation_sent' => 'Conferma inviata al beneficiario',
        'receipt_available' => 'Ricevuta disponibile per il download',
    ],
    
    'fields' => [
        'message' => [
            'label' => 'Messaggio di Completamento',
            'placeholder' => 'Inserisci un messaggio di conferma',
            'helper_text' => '',
            'description' => 'Messaggio informativo sul completamento del rimborso',
        ],
        'completion_date' => [
            'label' => 'Data di Completamento',
            'placeholder' => 'Data del completamento',
            'helper_text' => '',
            'description' => 'Data in cui il rimborso è stato completato',
        ],
        'refund_amount' => [
            'label' => 'Importo Rimborsato',
            'placeholder' => 'Importo del rimborso',
            'helper_text' => '',
            'description' => 'Importo totale del rimborso elaborato',
        ],
        'payment_method' => [
            'label' => 'Metodo di Pagamento',
            'placeholder' => 'Metodo utilizzato per il rimborso',
            'helper_text' => '',
            'description' => 'Modalità utilizzata per l\'accredito del rimborso',
        ],
        'transaction_id' => [
            'label' => 'ID Transazione',
            'placeholder' => 'Identificativo della transazione',
            'helper_text' => '',
            'description' => 'Codice identificativo univoco della transazione di rimborso',
        ],
    ],
];
