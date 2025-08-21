<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Studio Medico',
        'icon' => 'heroicon-o-building-office-2',
        'group' => 'SaluteOra',
        'sort' => 10,
    ],

    'model' => [
        'singular' => 'Studio Medico',
        'plural' => 'Studi Medici',
        'description' => 'Gestione degli studi medici e delle relazioni con i dottori',
    ],

    'pages' => [
        'index' => [
            'title' => 'Studi Medici',
            'heading' => 'Elenco Studi Medici',
            'description' => 'Gestisci tutti gli studi medici del sistema',
        ],
        'create' => [
            'title' => 'Nuovo Studio Medico',
            'heading' => 'Crea Nuovo Studio Medico',
            'description' => 'Inserisci i dati per creare un nuovo studio medico',
        ],
        'edit' => [
            'title' => 'Modifica Studio Medico',
            'heading' => 'Modifica Studio Medico',
            'description' => 'Modifica i dati dello studio medico selezionato',
        ],
        'view' => [
            'title' => 'Dettagli Studio Medico',
            'heading' => 'Dettagli Studio Medico',
            'description' => 'Visualizza tutti i dettagli dello studio medico',
        ],
    ],

    'fields' => [
        'id' => [
            'label' => 'ID',
            'placeholder' => 'Identificativo univoco',
            'help' => 'Identificativo automatico dello studio medico',
            'tooltip' => 'ID univoco dello studio',
            'helper_text' => '',
        ],
        'name' => [
            'label' => 'Nome Studio',
            'placeholder' => 'Inserisci il nome dello studio medico',
            'help' => 'Nome completo dello studio medico',
            'tooltip' => 'Nome ufficiale dello studio',
            'helper_text' => 'Es. Studio Medico Dr. Rossi',
        ],
        'address' => [
            'label' => 'Indirizzo',
            'placeholder' => 'Inserisci l\'indirizzo completo',
            'help' => 'Indirizzo completo dello studio medico',
            'tooltip' => 'Indirizzo fisico dello studio',
            'helper_text' => 'Via, numero, città, CAP',
        ],
        'phone' => [
            'label' => 'Telefono',
            'placeholder' => 'Inserisci il numero di telefono',
            'help' => 'Numero di telefono principale dello studio',
            'tooltip' => 'Contatto telefonico principale',
            'helper_text' => 'Formato: +39 123 456 7890',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Inserisci l\'indirizzo email',
            'help' => 'Indirizzo email di contatto dello studio',
            'tooltip' => 'Email per comunicazioni ufficiali',
            'helper_text' => 'Es. info@studiomedico.it',
        ],
        'website' => [
            'label' => 'Sito Web',
            'placeholder' => 'Inserisci l\'URL del sito web',
            'help' => 'Sito web ufficiale dello studio medico',
            'tooltip' => 'URL del sito web istituzionale',
            'helper_text' => 'Es. https://www.studiomedico.it',
        ],
        'description' => [
            'label' => 'Descrizione',
            'placeholder' => 'Inserisci una descrizione dello studio',
            'help' => 'Descrizione dettagliata dei servizi offerti',
            'tooltip' => 'Descrizione completa dello studio',
            'helper_text' => 'Specializzazioni, servizi, orari',
        ],
        'is_active' => [
            'label' => 'Attivo',
            'placeholder' => 'Seleziona lo stato di attività',
            'help' => 'Indica se lo studio è attualmente attivo',
            'tooltip' => 'Stato di attività dello studio',
            'helper_text' => 'Studio attivo e operativo',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'placeholder' => 'Data di creazione del record',
            'help' => 'Data e ora di creazione dello studio medico',
            'tooltip' => 'Quando è stato creato il record',
            'helper_text' => '',
        ],
        'updated_at' => [
            'label' => 'Data Aggiornamento',
            'placeholder' => 'Data dell\'ultimo aggiornamento',
            'help' => 'Data e ora dell\'ultimo aggiornamento',
            'tooltip' => 'Quando è stato aggiornato l\'ultima volta',
            'helper_text' => '',
        ],
        'created_by' => [
            'label' => 'Creato Da',
            'placeholder' => 'Utente che ha creato il record',
            'help' => 'Utente che ha creato lo studio medico',
            'tooltip' => 'Autore della creazione',
            'helper_text' => '',
        ],
        'updated_by' => [
            'label' => 'Aggiornato Da',
            'placeholder' => 'Utente che ha aggiornato il record',
            'help' => 'Utente che ha aggiornato lo studio medico',
            'tooltip' => 'Autore dell\'ultimo aggiornamento',
            'helper_text' => '',
        ],
    ],

    'actions' => [
        'create' => [
            'label' => 'Nuovo Studio',
            'icon' => 'heroicon-o-plus',
            'color' => 'primary',
            'tooltip' => 'Crea un nuovo studio medico',
            'modal' => [
                'heading' => 'Crea Nuovo Studio Medico',
                'description' => 'Inserisci i dati per creare un nuovo studio medico nel sistema',
                'confirm' => 'Crea Studio',
                'cancel' => 'Annulla',
            ],
            'messages' => [
                'success' => 'Studio medico creato con successo',
                'error' => 'Si è verificato un errore durante la creazione dello studio medico',
            ],
        ],
        'edit' => [
            'label' => 'Modifica',
            'icon' => 'heroicon-o-pencil',
            'color' => 'warning',
            'tooltip' => 'Modifica i dati dello studio medico',
            'modal' => [
                'heading' => 'Modifica Studio Medico',
                'description' => 'Modifica i dati dello studio medico selezionato',
                'confirm' => 'Aggiorna Studio',
                'cancel' => 'Annulla',
            ],
            'messages' => [
                'success' => 'Studio medico aggiornato con successo',
                'error' => 'Si è verificato un errore durante l\'aggiornamento',
            ],
        ],
        'delete' => [
            'label' => 'Elimina',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
            'tooltip' => 'Elimina lo studio medico',
            'modal' => [
                'heading' => 'Elimina Studio Medico',
                'description' => 'Sei sicuro di voler eliminare questo studio medico? Questa azione è irreversibile.',
                'confirm' => 'Elimina Studio',
                'cancel' => 'Annulla',
            ],
            'messages' => [
                'success' => 'Studio medico eliminato con successo',
                'error' => 'Si è verificato un errore durante l\'eliminazione',
            ],
        ],
        'view' => [
            'label' => 'Visualizza',
            'icon' => 'heroicon-o-eye',
            'color' => 'info',
            'tooltip' => 'Visualizza i dettagli dello studio medico',
        ],
        'export_xls' => [
            'label' => 'Esporta Excel',
            'icon' => 'heroicon-o-document-download',
            'color' => 'success',
            'tooltip' => 'Esporta la lista degli studi medici in formato Excel',
            'modal' => [
                'heading' => 'Esporta Studi Medici',
                'description' => 'Esporta la lista degli studi medici in formato Excel per analisi e reporting',
                'confirm' => 'Esporta',
                'cancel' => 'Annulla',
            ],
            'messages' => [
                'success' => 'Esportazione completata con successo',
                'error' => 'Si è verificato un errore durante l\'esportazione',
            ],
        ],
    ],

    'filters' => [
        'name' => [
            'label' => 'Nome Studio',
            'placeholder' => 'Filtra per nome dello studio',
        ],
        'is_active' => [
            'label' => 'Stato Attività',
            'placeholder' => 'Filtra per stato di attività',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'placeholder' => 'Filtra per data di creazione',
        ],
    ],

    'bulk_actions' => [
        'delete' => [
            'label' => 'Elimina Selezionati',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
            'modal' => [
                'heading' => 'Elimina Studi Selezionati',
                'description' => 'Sei sicuro di voler eliminare gli studi medici selezionati? Questa azione è irreversibile.',
                'confirm' => 'Elimina Selezionati',
                'cancel' => 'Annulla',
            ],
            'messages' => [
                'success' => 'Studi medici eliminati con successo',
                'error' => 'Si è verificato un errore durante l\'eliminazione',
            ],
        ],
        'export_xls' => [
            'label' => 'Esporta Selezionati',
            'icon' => 'heroicon-o-document-download',
            'color' => 'success',
            'modal' => [
                'heading' => 'Esporta Studi Selezionati',
                'description' => 'Esporta solo gli studi medici selezionati in formato Excel',
                'confirm' => 'Esporta Selezionati',
                'cancel' => 'Annulla',
            ],
            'messages' => [
                'success' => 'Esportazione completata con successo',
                'error' => 'Si è verificato un errore durante l\'esportazione',
            ],
        ],
    ],

    'messages' => [
        'welcome' => 'Benvenuto nella gestione degli studi medici',
        'no_studios' => 'Nessuno studio medico trovato',
        'search_no_results' => 'Nessuno studio medico corrisponde ai criteri di ricerca',
        'filter_no_results' => 'Nessuno studio medico corrisponde ai filtri applicati',
    ],

    'notifications' => [
        'created' => 'Studio medico creato con successo',
        'updated' => 'Studio medico aggiornato con successo',
        'deleted' => 'Studio medico eliminato con successo',
        'bulk_deleted' => 'Studi medici eliminati con successo',
        'exported' => 'Esportazione completata con successo',
    ],

    'validation' => [
        'name_required' => 'Il nome dello studio è obbligatorio',
        'name_max' => 'Il nome dello studio non può superare i 255 caratteri',
        'address_required' => 'L\'indirizzo è obbligatorio',
        'phone_required' => 'Il numero di telefono è obbligatorio',
        'phone_format' => 'Il formato del numero di telefono non è valido',
        'email_required' => 'L\'email è obbligatoria',
        'email_email' => 'L\'email deve essere in formato valido',
        'email_unique' => 'Questa email è già utilizzata da un altro studio',
        'website_url' => 'L\'URL del sito web deve essere in formato valido',
    ],
];
