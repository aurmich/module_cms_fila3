<?php

declare(strict_types=1);

return [
    'navigation' => [
        'name' => 'Eventi Archiviati',
        'plural' => 'Eventi Archiviati',
        'group' => [
            'name' => 'Monitoraggio',
            'description' => 'Gestione degli eventi di sistema archiviati',
        ],
        'label' => 'Eventi Archiviati',
        'sort' => 62,
        'icon' => 'activity-stored-event-animated',
    ],
    'fields' => [
        'event_class' => [
            'label' => 'Classe Evento',
            'placeholder' => 'Inserisci la classe dell\'evento',
            'help' => 'Nome completo della classe che rappresenta l\'evento',
        ],
        'event_properties' => [
            'label' => 'Proprietà Evento',
            'placeholder' => 'Proprietà dell\'evento',
            'help' => 'Dati e proprietà specifiche dell\'evento',
        ],
        'aggregate_uuid' => [
            'label' => 'UUID Aggregato',
            'placeholder' => 'UUID dell\'aggregato',
            'help' => 'Identificativo unico dell\'aggregato di appartenenza',
        ],
        'aggregate_version' => [
            'label' => 'Versione Aggregato',
            'placeholder' => 'Inserisci la versione',
            'help' => 'Numero di versione dell\'aggregato',
        ],
        'event_version' => [
            'label' => 'Versione Evento',
            'placeholder' => 'Versione dell\'evento',
            'help' => 'Numero di versione del formato evento',
        ],
        'meta_data' => [
            'label' => 'Metadata',
            'placeholder' => 'Metadata aggiuntivi',
            'help' => 'Informazioni metadata aggiuntive sull\'evento',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'placeholder' => 'Seleziona data e ora',
            'help' => 'Timestamp di quando l\'evento è stato creato',
        ],
        'created_by' => [
            'label' => 'Creato Da',
            'placeholder' => 'Utente creatore',
            'help' => 'Utente che ha generato l\'evento',
        ],
        'updated_by' => [
            'label' => 'Aggiornato Da',
            'placeholder' => 'Utente aggiornatore',
            'help' => 'Utente che ha aggiornato l\'evento',
        ],
        'toggleColumns' => [
            'label' => 'Mostra/Nascondi Colonne',
            'placeholder' => '',
            'help' => 'Configura la visibilità delle colonne nella tabella',
        ],
    ],
    'actions' => [
        'view' => [
            'label' => 'Visualizza',
            'success' => 'Evento caricato con successo',
            'error' => 'Errore nel caricamento dell\'evento',
        ],
        'replay' => [
            'label' => 'Replay Evento',
            'success' => 'Replay dell\'evento completato con successo',
            'error' => 'Errore durante il replay dell\'evento',
            'confirmation' => 'Sei sicuro di voler eseguire il replay di questo evento?',
        ],
        'export' => [
            'label' => 'Esporta Eventi',
            'success' => 'Eventi esportati con successo',
            'error' => 'Errore durante l\'esportazione',
            'confirmation' => 'Vuoi esportare gli eventi selezionati?',
        ],
    ],
    'filters' => [
        'event_class' => [
            'label' => 'Classe Evento',
            'placeholder' => 'Filtra per classe',
            'help' => 'Filtra gli eventi per tipo di classe',
        ],
        'aggregate_uuid' => [
            'label' => 'UUID Aggregato',
            'placeholder' => 'Filtra per aggregato',
            'help' => 'Filtra gli eventi per UUID aggregato',
        ],
        'date_range' => [
            'label' => 'Intervallo Date',
            'placeholder' => 'Seleziona intervallo',
            'help' => 'Filtra gli eventi per periodo di tempo',
        ],
    ],
    'messages' => [
        'no_events' => 'Nessun evento trovato',
        'event_replayed' => 'Evento riprodotto con successo',
        'events_exported' => 'Eventi esportati con successo',
    ],
];
