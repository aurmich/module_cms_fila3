<?php

declare(strict_types=1);

return [
    'navigation' => [
        'label' => 'Privacy Dottore',
        'icon' => 'heroicon-o-shield-check',
        'group' => 'SaluteOra',
        'sort' => 15,
    ],

    'model' => [
        'singular' => 'Privacy Dottore',
        'plural' => 'Privacy Dottori',
        'description' => 'Gestione delle impostazioni di privacy e consensi per i dottori',
    ],

    'pages' => [
        'index' => [
            'title' => 'Privacy Dottori',
            'heading' => 'Gestione Privacy Dottori',
            'description' => 'Gestisci le impostazioni di privacy e i consensi per tutti i dottori',
        ],
        'create' => [
            'title' => 'Nuova Impostazione Privacy',
            'heading' => 'Crea Nuova Impostazione Privacy',
            'description' => 'Configura le impostazioni di privacy per un nuovo dottore',
        ],
        'edit' => [
            'title' => 'Modifica Privacy',
            'heading' => 'Modifica Impostazioni Privacy',
            'description' => 'Aggiorna le impostazioni di privacy del dottore selezionato',
        ],
        'view' => [
            'title' => 'Dettagli Privacy',
            'heading' => 'Dettagli Impostazioni Privacy',
            'description' => 'Visualizza tutte le impostazioni di privacy del dottore',
        ],
    ],

    'fields' => [
        'id' => [
            'label' => 'ID',
            'placeholder' => 'Identificativo univoco',
            'help' => 'Identificativo automatico della configurazione privacy',
            'tooltip' => 'ID univoco della configurazione',
            'helper_text' => '',
        ],
        'doctor_id' => [
            'label' => 'Dottore',
            'placeholder' => 'Seleziona il dottore',
            'help' => 'Dottore associato a questa configurazione privacy',
            'tooltip' => 'Dottore di riferimento',
            'helper_text' => 'Seleziona il dottore dalla lista',
        ],
        'data_processing_consent' => [
            'label' => 'Consenso Trattamento Dati',
            'placeholder' => 'Seleziona lo stato del consenso',
            'help' => 'Consenso al trattamento dei dati personali',
            'tooltip' => 'Stato del consenso GDPR',
            'helper_text' => 'Consenso obbligatorio per il trattamento dati',
        ],
        'marketing_consent' => [
            'label' => 'Consenso Marketing',
            'placeholder' => 'Seleziona lo stato del consenso marketing',
            'help' => 'Consenso alla ricezione di comunicazioni marketing',
            'tooltip' => 'Consenso comunicazioni promozionali',
            'helper_text' => 'Consenso opzionale per comunicazioni commerciali',
        ],
        'third_party_sharing' => [
            'label' => 'Condivisione Terze Parti',
            'placeholder' => 'Seleziona le opzioni di condivisione',
            'help' => 'Autorizzazione alla condivisione con terze parti',
            'tooltip' => 'Condivisione dati con partner',
            'helper_text' => 'Specifica quali terze parti possono accedere ai dati',
        ],
        'data_retention_period' => [
            'label' => 'Periodo Conservazione',
            'placeholder' => 'Seleziona il periodo di conservazione',
            'help' => 'Periodo di conservazione dei dati personali',
            'tooltip' => 'Durata conservazione dati',
            'helper_text' => 'Periodo minimo e massimo di conservazione',
        ],
        'right_to_forget' => [
            'label' => 'Diritto all\'Oblio',
            'placeholder' => 'Seleziona le opzioni di cancellazione',
            'help' => 'Configurazione del diritto alla cancellazione dei dati',
            'tooltip' => 'Gestione diritto all\'oblio',
            'helper_text' => 'Modalità di esercizio del diritto alla cancellazione',
        ],
        'data_portability' => [
            'label' => 'Portabilità Dati',
            'placeholder' => 'Seleziona le opzioni di portabilità',
            'help' => 'Configurazione per la portabilità dei dati',
            'tooltip' => 'Esportazione dati personali',
            'helper_text' => 'Formati e modalità di esportazione dati',
        ],
        'privacy_notice_version' => [
            'label' => 'Versione Informativa',
            'placeholder' => 'Inserisci la versione dell\'informativa',
            'help' => 'Versione dell\'informativa privacy accettata',
            'tooltip' => 'Versione informativa privacy',
            'helper_text' => 'Es. 1.0, 2.1, ecc.',
        ],
        'consent_date' => [
            'label' => 'Data Consenso',
            'placeholder' => 'Seleziona la data del consenso',
            'help' => 'Data in cui è stato fornito il consenso',
            'tooltip' => 'Data accettazione privacy',
            'helper_text' => 'Data di accettazione dell\'informativa',
        ],
        'last_review_date' => [
            'label' => 'Ultima Revisione',
            'placeholder' => 'Data dell\'ultima revisione',
            'help' => 'Data dell\'ultima revisione delle impostazioni privacy',
            'tooltip' => 'Data ultima verifica',
            'helper_text' => 'Quando sono state verificate l\'ultima volta',
        ],
        'is_active' => [
            'label' => 'Attivo',
            'placeholder' => 'Seleziona lo stato di attività',
            'help' => 'Indica se la configurazione privacy è attualmente attiva',
            'tooltip' => 'Stato di attività della configurazione',
            'helper_text' => 'Configurazione privacy attiva e valida',
        ],
        'notes' => [
            'label' => 'Note',
            'placeholder' => 'Inserisci note aggiuntive',
            'help' => 'Note e commenti aggiuntivi sulla configurazione privacy',
            'tooltip' => 'Note aggiuntive',
            'helper_text' => 'Commenti e osservazioni personali',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'placeholder' => 'Data di creazione del record',
            'help' => 'Data e ora di creazione della configurazione privacy',
            'tooltip' => 'Quando è stata creata la configurazione',
            'helper_text' => '',
        ],
        'updated_at' => [
            'label' => 'Data Aggiornamento',
            'placeholder' => 'Data dell\'ultimo aggiornamento',
            'help' => 'Data e ora dell\'ultimo aggiornamento',
            'tooltip' => 'Quando è stata aggiornata l\'ultima volta',
            'helper_text' => '',
        ],
        'created_by' => [
            'label' => 'Creato Da',
            'placeholder' => 'Utente che ha creato il record',
            'help' => 'Utente che ha creato la configurazione privacy',
            'tooltip' => 'Autore della creazione',
            'helper_text' => '',
        ],
        'updated_by' => [
            'label' => 'Aggiornato Da',
            'placeholder' => 'Utente che ha aggiornato il record',
            'help' => 'Utente che ha aggiornato la configurazione privacy',
            'tooltip' => 'Autore dell\'ultimo aggiornamento',
            'helper_text' => '',
        ],
    ],

    'actions' => [
        'create' => [
            'label' => 'Nuova Privacy',
            'icon' => 'heroicon-o-plus',
            'color' => 'primary',
            'tooltip' => 'Crea una nuova configurazione privacy',
            'modal' => [
                'heading' => 'Crea Nuova Configurazione Privacy',
                'description' => 'Configura le impostazioni di privacy per un nuovo dottore nel sistema',
                'confirm' => 'Crea Configurazione',
                'cancel' => 'Annulla',
            ],
            'messages' => [
                'success' => 'Configurazione privacy creata con successo',
                'error' => 'Si è verificato un errore durante la creazione della configurazione privacy',
            ],
        ],
        'edit' => [
            'label' => 'Modifica',
            'icon' => 'heroicon-o-pencil',
            'color' => 'warning',
            'tooltip' => 'Modifica le impostazioni di privacy',
            'modal' => [
                'heading' => 'Modifica Configurazione Privacy',
                'description' => 'Aggiorna le impostazioni di privacy del dottore selezionato',
                'confirm' => 'Aggiorna Configurazione',
                'cancel' => 'Annulla',
            ],
            'messages' => [
                'success' => 'Configurazione privacy aggiornata con successo',
                'error' => 'Si è verificato un errore durante l\'aggiornamento',
            ],
        ],
        'delete' => [
            'label' => 'Elimina',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
            'tooltip' => 'Elimina la configurazione privacy',
            'modal' => [
                'heading' => 'Elimina Configurazione Privacy',
                'description' => 'Sei sicuro di voler eliminare questa configurazione privacy? Questa azione è irreversibile.',
                'confirm' => 'Elimina Configurazione',
                'cancel' => 'Annulla',
            ],
            'messages' => [
                'success' => 'Configurazione privacy eliminata con successo',
                'error' => 'Si è verificato un errore durante l\'eliminazione',
            ],
        ],
        'view' => [
            'label' => 'Visualizza',
            'icon' => 'heroicon-o-eye',
            'color' => 'info',
            'tooltip' => 'Visualizza i dettagli della configurazione privacy',
        ],
        'export_xls' => [
            'label' => 'Esporta Excel',
            'icon' => 'heroicon-o-document-download',
            'color' => 'success',
            'tooltip' => 'Esporta la lista delle configurazioni privacy in formato Excel',
            'modal' => [
                'heading' => 'Esporta Configurazioni Privacy',
                'description' => 'Esporta la lista delle configurazioni privacy in formato Excel per analisi e compliance',
                'confirm' => 'Esporta',
                'cancel' => 'Annulla',
            ],
            'messages' => [
                'success' => 'Esportazione completata con successo',
                'error' => 'Si è verificato un errore durante l\'esportazione',
            ],
        ],
        'review_privacy' => [
            'label' => 'Rivedi Privacy',
            'icon' => 'heroicon-o-eye',
            'color' => 'info',
            'tooltip' => 'Rivedi e aggiorna le impostazioni di privacy',
            'modal' => [
                'heading' => 'Rivedi Configurazione Privacy',
                'description' => 'Rivedi e aggiorna le impostazioni di privacy del dottore',
                'confirm' => 'Aggiorna Revisione',
                'cancel' => 'Annulla',
            ],
            'messages' => [
                'success' => 'Revisione privacy completata con successo',
                'error' => 'Si è verificato un errore durante la revisione',
            ],
        ],
    ],

    'filters' => [
        'doctor_id' => [
            'label' => 'Dottore',
            'placeholder' => 'Filtra per dottore',
        ],
        'data_processing_consent' => [
            'label' => 'Consenso Trattamento',
            'placeholder' => 'Filtra per consenso trattamento dati',
        ],
        'marketing_consent' => [
            'label' => 'Consenso Marketing',
            'placeholder' => 'Filtra per consenso marketing',
        ],
        'is_active' => [
            'label' => 'Stato Attività',
            'placeholder' => 'Filtra per stato di attività',
        ],
        'consent_date' => [
            'label' => 'Data Consenso',
            'placeholder' => 'Filtra per data del consenso',
        ],
    ],

    'bulk_actions' => [
        'delete' => [
            'label' => 'Elimina Selezionate',
            'icon' => 'heroicon-o-trash',
            'color' => 'danger',
            'modal' => [
                'heading' => 'Elimina Configurazioni Selezionate',
                'description' => 'Sei sicuro di voler eliminare le configurazioni privacy selezionate? Questa azione è irreversibile.',
                'confirm' => 'Elimina Selezionate',
                'cancel' => 'Annulla',
            ],
            'messages' => [
                'success' => 'Configurazioni privacy eliminate con successo',
                'error' => 'Si è verificato un errore durante l\'eliminazione',
            ],
        ],
        'export_xls' => [
            'label' => 'Esporta Selezionate',
            'icon' => 'heroicon-o-document-download',
            'color' => 'success',
            'modal' => [
                'heading' => 'Esporta Configurazioni Selezionate',
                'description' => 'Esporta solo le configurazioni privacy selezionate in formato Excel',
                'confirm' => 'Esporta Selezionate',
                'cancel' => 'Annulla',
            ],
            'messages' => [
                'success' => 'Esportazione completata con successo',
                'error' => 'Si è verificato un errore durante l\'esportazione',
            ],
        ],
        'review_selected' => [
            'label' => 'Rivedi Selezionate',
            'icon' => 'heroicon-o-eye',
            'color' => 'info',
            'modal' => [
                'heading' => 'Rivedi Configurazioni Selezionate',
                'description' => 'Rivedi e aggiorna le configurazioni privacy selezionate',
                'confirm' => 'Rivedi Selezionate',
                'cancel' => 'Annulla',
            ],
            'messages' => [
                'success' => 'Revisione completata con successo',
                'error' => 'Si è verificato un errore durante la revisione',
            ],
        ],
    ],

    'messages' => [
        'welcome' => 'Benvenuto nella gestione della privacy dei dottori',
        'no_configurations' => 'Nessuna configurazione privacy trovata',
        'search_no_results' => 'Nessuna configurazione privacy corrisponde ai criteri di ricerca',
        'filter_no_results' => 'Nessuna configurazione privacy corrisponde ai filtri applicati',
        'privacy_compliance' => 'Tutte le configurazioni sono conformi al GDPR',
        'consent_required' => 'Il consenso al trattamento dati è obbligatorio',
    ],

    'notifications' => [
        'created' => 'Configurazione privacy creata con successo',
        'updated' => 'Configurazione privacy aggiornata con successo',
        'deleted' => 'Configurazione privacy eliminata con successo',
        'bulk_deleted' => 'Configurazioni privacy eliminate con successo',
        'exported' => 'Esportazione completata con successo',
        'reviewed' => 'Revisione privacy completata con successo',
        'consent_expired' => 'Consenso privacy scaduto - richiesta revisione',
        'gdpr_compliant' => 'Configurazione conforme al GDPR',
    ],

    'validation' => [
        'doctor_id_required' => 'Il dottore è obbligatorio',
        'doctor_id_exists' => 'Il dottore selezionato non esiste',
        'data_processing_consent_required' => 'Il consenso al trattamento dati è obbligatorio',
        'consent_date_required' => 'La data del consenso è obbligatoria',
        'consent_date_date' => 'La data del consenso deve essere una data valida',
        'privacy_notice_version_required' => 'La versione dell\'informativa è obbligatoria',
        'data_retention_period_required' => 'Il periodo di conservazione è obbligatorio',
        'right_to_forget_required' => 'La configurazione del diritto all\'oblio è obbligatoria',
        'data_portability_required' => 'La configurazione della portabilità è obbligatoria',
    ],

    'consent_options' => [
        'granted' => 'Concesso',
        'denied' => 'Negato',
        'pending' => 'In attesa',
        'expired' => 'Scaduto',
        'revoked' => 'Revocato',
    ],

    'retention_periods' => [
        '1_year' => '1 anno',
        '3_years' => '3 anni',
        '5_years' => '5 anni',
        '10_years' => '10 anni',
        'indefinite' => 'Indefinito',
        'custom' => 'Personalizzato',
    ],

    'third_party_options' => [
        'none' => 'Nessuna condivisione',
        'partners' => 'Solo partner autorizzati',
        'suppliers' => 'Fornitori di servizi',
        'insurance' => 'Compagnie assicurative',
        'regulatory' => 'Autorità di regolamentazione',
        'custom' => 'Personalizzato',
    ],
];
