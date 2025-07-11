<?php

return [
    'navigation' => [
        'label' => 'Flusso Appuntamenti',
        'group' => 'Agenda',
        'icon' => 'heroicon-o-document-chart-bar',
        'sort' => '60',
        'tooltip' => 'Gestione dei flussi di prenotazione e appuntamenti',
    ],
    'model' => [
        'label' => 'Flusso Appuntamento',
        'plural_label' => 'Flussi Appuntamenti',
    ],
    'actions' => [
        'create' => [
            'label' => 'Crea Nuovo',
            'tooltip' => 'Crea un nuovo flusso di appuntamento',
            'icon' => 'heroicon-o-plus',
        ],
        'edit' => [
            'label' => 'Modifica',
            'tooltip' => 'Modifica questo flusso di appuntamento',
            'icon' => 'heroicon-o-pencil',
        ],
        'delete' => [
            'label' => 'Elimina',
            'tooltip' => 'Elimina questo flusso di appuntamento',
            'icon' => 'heroicon-o-trash',
        ],
        'view' => [
            'label' => 'Visualizza',
            'tooltip' => 'Visualizza i dettagli del flusso',
            'icon' => 'heroicon-o-eye',
        ],
    ],
    'fields' => [
        'id' => [
            'label' => 'ID',
            'tooltip' => 'Identificativo univoco del flusso',
        ],
        'patient' => [
            'label' => 'Paziente',
            'tooltip' => 'Paziente associato al flusso',
            'placeholder' => 'Seleziona paziente',
            'helper_text' => 'Il paziente che ha richiesto l\'appuntamento',
            'last_name' => [
                'label' => 'Cognome',
                'placeholder' => 'Inserisci il cognome',
                'help' => 'Inserisci il cognome completo',
            ],
            'first_name' => [
                'label' => 'Nome',
                'placeholder' => 'Inserisci il nome',
                'help' => 'Inserisci il nome completo',
            ],
        ],
        'current_step' => [
            'label' => 'Fase Attuale',
            'tooltip' => 'Fase attuale del flusso di appuntamento',
            'placeholder' => 'Seleziona fase',
            'helper_text' => 'Indica a che punto del processo si trova l\'appuntamento',
        ],
        'status' => [
            'label' => 'Stato',
            'tooltip' => 'Stato corrente del flusso',
            'placeholder' => 'Seleziona stato',
            'helper_text' => 'Indica se il flusso è attivo, completato o annullato',
            'options' => [
                'pending' => 'In attesa',
                'active' => 'Attivo',
                'completed' => 'Completato',
                'cancelled' => 'Annullato',
            ],
        ],
        'appointment' => [
            'label' => 'Appuntamento',
            'tooltip' => 'Appuntamento collegato al flusso',
            'placeholder' => 'Seleziona appuntamento',
            'helper_text' => 'L\'appuntamento associato a questo flusso',
            'title' => [
                'label' => 'Titolo Appuntamento',
                'tooltip' => 'Titolo dell\'appuntamento collegato',
                'placeholder' => 'Inserisci titolo',
                'helper_text' => 'Breve descrizione dell\'appuntamento',
            ],
        ],
        'started_at' => [
            'label' => 'Data Inizio',
            'tooltip' => 'Data di inizio del flusso',
            'placeholder' => 'Seleziona data inizio',
            'helper_text' => 'Quando è stato avviato il flusso di prenotazione',
        ],
        'completed_at' => [
            'label' => 'Data Completamento',
            'tooltip' => 'Data di completamento del flusso',
            'placeholder' => 'Seleziona data completamento',
            'helper_text' => 'Quando è stato completato il flusso di prenotazione',
        ],
        'session_id' => [
            'label' => 'ID Sessione',
            'tooltip' => 'Identificativo della sessione utente',
            'placeholder' => 'ID Sessione',
            'helper_text' => 'Identificativo tecnico della sessione di navigazione',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'tooltip' => 'Data di creazione del record',
            'placeholder' => 'Data creazione',
            'helper_text' => 'Data e ora di creazione nel sistema',
        ],
        'openFilters' => [
            'label' => 'openFilters',
        ],
        'applyFilters' => [
            'label' => 'applyFilters',
        ],
        'resetFilters' => [
            'label' => 'resetFilters',
        ],
        'reorderRecords' => [
            'label' => 'reorderRecords',
        ],
        'toggleColumns' => [
            'label' => 'toggleColumns',
        ],
    ],
    'filters' => [
        'title' => 'Filtri',
        'open' => 'Apri Filtri',
        'apply' => 'Applica Filtri',
        'reset' => 'Reimposta Filtri',
        'close' => 'Chiudi Filtri',
    ],
    'table' => [
        'reorder' => 'Riordina Record',
        'toggle_columns' => 'Mostra/Nascondi Colonne',
        'empty' => 'Nessun flusso di appuntamento trovato',
        'loading' => 'Caricamento flussi di appuntamento...',
    ],
    'messages' => [
        'success' => [
            'created' => 'Flusso di appuntamento creato con successo',
            'updated' => 'Flusso di appuntamento aggiornato con successo',
            'deleted' => 'Flusso di appuntamento eliminato con successo',
        ],
        'error' => [
            'create' => 'Errore durante la creazione del flusso di appuntamento',
            'update' => 'Errore durante l\'aggiornamento del flusso di appuntamento',
            'delete' => 'Errore durante l\'eliminazione del flusso di appuntamento',
        ],
        'confirm' => [
            'delete' => 'Sei sicuro di voler eliminare questo flusso di appuntamento?',
        ],
    ],
];
