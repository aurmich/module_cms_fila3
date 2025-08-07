<?php

declare(strict_types=1);

return [
    'model' => [
        'label' => 'Documenti Paziente',
        'plural_label' => 'Documenti Pazienti',
        'description' => 'Gestione e caricamento documenti allegati del paziente',
    ],
    'page' => [
        'title' => 'Modifica Documenti Paziente',
        'heading' => 'Gestione Documenti Allegati',
        'description' => 'Carica e gestisci i documenti necessari per il paziente',
        'subheading' => 'Documenti richiesti per completare la registrazione',
    ],
    'actions' => [
        'save' => [
            'label' => 'Salva Documenti',
            'tooltip' => 'Salva tutti i documenti caricati',
            'success' => 'Documenti salvati con successo',
            'error' => 'Errore durante il salvataggio dei documenti',
        ],
        'cancel' => [
            'label' => 'Annulla',
            'tooltip' => 'Annulla le modifiche ai documenti',
            'confirmation' => 'Sei sicuro di voler annullare? Le modifiche andranno perse.',
        ],
    ],
    'fields' => [
        'pregnancy_certificate' => [
            'label' => 'Certificato Medico di Gravidanza',
            'placeholder' => 'Carica Certificato Medico',
            'help' => 'Certificato medico attestante lo stato di gravidanza per accesso a prestazioni speciali e agevolazioni sanitarie',
            'description' => 'Certificato medico rilasciato da ginecologo o medico di base che attesta lo stato di gravidanza per accesso a prestazioni speciali',
            'helper_text' => '',
            'validation' => [
                'file' => 'Carica un certificato medico valido',
                'mimes' => 'Formati supportati: JPG, JPEG, PNG, PDF',
                'max' => 'Dimensione massima consentita: 5MB per file',
            ],
        ],
        'isee_certificate' => [
            'label' => 'Certificato ISEE Completo',
            'placeholder' => 'Carica Certificato ISEE',
            'help' => 'Certificato ISEE (Indicatore Situazione Economica Equivalente) per accesso ad agevolazioni economiche e prestazioni sanitarie a tariffa ridotta',
            'description' => 'Certificato ISEE completo rilasciato da CAF o INPS per determinare la situazione economica e accedere ad agevolazioni',
            'helper_text' => '',
            'validation' => [
                'file' => 'Carica un certificato ISEE valido',
                'mimes' => 'Formati supportati: JPG, JPEG, PNG, PDF',
                'max' => 'Dimensione massima consentita: 5MB per file',
            ],
        ],
        'health_card' => [
            'label' => 'Tessera Sanitaria',
            'placeholder' => 'Carica Tessera Sanitaria',
            'help' => 'Tessera sanitaria nazionale, STP (Straniero Temporaneamente Presente) o ENI (Europeo Non Iscritto) per identificazione paziente e accesso alle prestazioni sanitarie',
            'description' => 'Documento di identificazione sanitaria necessario per accedere alle prestazioni del Servizio Sanitario Nazionale',
            'helper_text' => '',
            'validation' => [
                'required' => 'La tessera sanitaria è obbligatoria per identificazione paziente',
                'file' => 'Carica un file valido',
                'mimes' => 'Formati supportati: JPG, JPEG, PNG, PDF',
                'max' => 'Dimensione massima consentita: 5MB per file',
            ],
        ],
    ],
    'navigation' => [
        'label' => 'Documenti Paziente',
        'icon' => 'heroicon-o-document-text',
        'group' => 'Gestione Pazienti',
        'description' => 'Gestione documenti allegati del paziente',
    ],
    'messages' => [
        'upload_success' => 'Documento caricato con successo',
        'upload_error' => 'Errore durante il caricamento del documento. Riprova o contatta il supporto',
        'delete_success' => 'Documento eliminato con successo',
        'delete_error' => 'Errore durante l\'eliminazione del documento. Riprova o contatta il supporto',
        'validation_error' => 'Errore di validazione del documento. Verifica formato e dimensioni',
        'file_too_large' => 'Il file è troppo grande. Dimensione massima consentita: 5MB per file',
        'invalid_format' => 'Formato file non supportato. Formati consentiti: JPG, JPEG, PNG, PDF',
        'processing' => 'Elaborazione documento in corso...',
        'upload_complete' => 'Caricamento completato. Documento salvato correttamente',
        'multiple_files_error' => 'Errore nel caricamento di uno o più file. Controlla i formati e le dimensioni',
    ],
    'notifications' => [
        'documents_updated' => [
            'title' => 'Documenti Aggiornati',
            'body' => 'I documenti del paziente sono stati aggiornati con successo',
        ],
        'document_required' => [
            'title' => 'Documento Obbligatorio',
            'body' => 'Alcuni documenti sono obbligatori per completare la registrazione',
        ],
    ],
];
