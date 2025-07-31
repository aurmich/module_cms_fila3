<?php

declare(strict_types=1);

return [
    'label' => 'Sospeso',
    'description' => 'Elemento temporaneamente sospeso',
    'tooltip' => 'L\'elemento è stato sospeso temporaneamente',
    'color' => 'danger',
    'icon' => 'heroicon-o-pause-circle',
    
    'actions' => [
        'reactivate' => [
            'label' => 'Riattiva',
            'confirmation' => 'Sei sicuro di voler riattivare questo elemento?',
            'success' => 'Elemento riattivato con successo',
            'error' => 'Errore durante la riattivazione',
        ],
        'extend_suspension' => [
            'label' => 'Prolunga Sospensione',
            'confirmation' => 'Sei sicuro di voler prolungare la sospensione?',
            'success' => 'Sospensione prolungata con successo',
            'error' => 'Errore durante il prolungamento della sospensione',
        ],
        'view_reason' => [
            'label' => 'Visualizza Motivo',
            'tooltip' => 'Visualizza il motivo della sospensione',
        ],
        'contact_admin' => [
            'label' => 'Contatta Amministratore',
            'tooltip' => 'Contatta l\'amministratore per chiarimenti',
        ],
    ],
    
    'modal' => [
        'heading' => 'Elemento Sospeso',
        'description' => 'Questo elemento è stato temporaneamente sospeso. Contatta l\'amministratore per maggiori informazioni o per richiedere la riattivazione.',
        'confirm' => 'Conferma',
        'cancel' => 'Annulla',
    ],
    
    'messages' => [
        'suspension_active' => 'Sospensione attiva',
        'temporary_restriction' => 'Restrizione temporanea in vigore',
        'contact_required' => 'Contatto con amministratore richiesto',
        'review_pending' => 'Revisione in corso',
    ],
    
    'fields' => [
        'message' => [
            'label' => 'Messaggio di Sospensione',
            'placeholder' => 'Inserisci il motivo della sospensione',
            'helper_text' => '',
            'description' => 'Motivo dettagliato della sospensione dell\'elemento',
        ],
        'suspension_date' => [
            'label' => 'Data Sospensione',
            'placeholder' => 'Data di inizio sospensione',
            'helper_text' => '',
            'description' => 'Data in cui è stata applicata la sospensione',
        ],
        'suspension_end_date' => [
            'label' => 'Data Fine Sospensione',
            'placeholder' => 'Data prevista per la fine della sospensione',
            'helper_text' => '',
            'description' => 'Data prevista per la riattivazione automatica',
        ],
        'suspension_reason' => [
            'label' => 'Motivo Sospensione',
            'placeholder' => 'Seleziona il motivo',
            'helper_text' => '',
            'description' => 'Categoria del motivo della sospensione',
        ],
        'admin_notes' => [
            'label' => 'Note Amministratore',
            'placeholder' => 'Note interne dell\'amministratore',
            'helper_text' => '',
            'description' => 'Note riservate all\'amministratore sulla sospensione',
        ],
    ],
];
