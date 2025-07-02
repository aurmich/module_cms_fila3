<?php

declare(strict_types=1);

return [
    'model' => [
        'label' => 'Paziente',
        'plural' => 'Pazienti',
        'description' => 'Gestione anagrafica e informazioni dei pazienti',
    ],

    'navigation' => [
        'label' => 'Anagrafica Pazienti',
        'group' => 'Pazienti',
        'icon' => 'heroicon-o-users',
        'color' => 'blue',
        'sort' => 3,
        'tooltip' => 'Gestisci l\'anagrafica e le informazioni dei pazienti',
    ],

    'pages' => [
        'index' => [
            'title' => 'Elenco Pazienti',
            'subtitle' => 'Gestisci l\'anagrafica dei pazienti',
            'description' => 'Visualizza e gestisci tutte le schede pazienti registrate',
        ],
        'create' => [
            'title' => 'Nuovo Paziente',
            'subtitle' => 'Registra un nuovo paziente',
            'description' => 'Compila tutti i dati richiesti per registrare un nuovo paziente',
        ],
        'edit' => [
            'title' => 'Modifica Paziente',
            'subtitle' => 'Aggiorna i dati del paziente',
            'description' => 'Modifica le informazioni anagrafiche e sanitarie del paziente',
        ],
        'view' => [
            'title' => 'Dettagli Paziente',
            'subtitle' => 'Visualizza tutti i dati del paziente',
            'description' => 'Consulta tutte le informazioni registrate per questo paziente',
        ],
    ],

    'steps' => [
        'personal_data_step' => [
            'label' => 'Dati Personali',
            'description' => 'Inserisci i dati anagrafici del paziente',
            'icon' => 'heroicon-o-user',
            'color' => 'primary',
            'help' => 'Compila tutti i campi anagrafici obbligatori',
        ],
        'contacts' => [
            'label' => 'Contatti',
            'description' => 'Inserisci i dati di contatto del paziente',
            'icon' => 'heroicon-o-phone',
            'color' => 'info',
            'help' => 'Fornisci i recapiti per contattare il paziente',
        ],
        'documents_step' => [
            'label' => 'Documenti',
            'description' => 'Carica i documenti richiesti',
            'icon' => 'heroicon-o-document',
            'color' => 'success',
            'help' => 'Carica tessera sanitaria, documento identità e certificati',
        ],
        'pre_visit_step' => [
            'label' => 'Pre-Visita',
            'description' => 'Informazioni preliminari per la visita',
            'icon' => 'heroicon-o-clipboard-document-list',
            'color' => 'warning',
            'help' => 'Compila le informazioni mediche preliminari',
        ],
        'health' => [
            'label' => 'Stato di Salute',
            'description' => 'Inserisci le informazioni sullo stato di salute',
            'icon' => 'heroicon-o-heart',
            'color' => 'danger',
            'help' => 'Informazioni mediche e problemi di salute attuali',
        ],
        'privacy_step' => [
            'label' => 'Privacy e Consensi',
            'description' => 'Consensi e autorizzazioni',
            'icon' => 'heroicon-o-shield-check',
            'color' => 'info',
            'help' => 'Leggi e accetta i consensi per il trattamento dei dati',
        ],
    ],

    'fields' => [
        'first_name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Nome come indicato sul documento d\'identità',
            'helper_text' => '',
            'validation' => [
                'required' => 'Il nome è obbligatorio',
                'min' => 'Il nome deve essere di almeno 2 caratteri',
                'max' => 'Il nome non può superare i 50 caratteri',
            ],
        ],
        'last_name' => [
            'label' => 'Cognome',
            'placeholder' => 'Inserisci il cognome',
            'help' => 'Cognome come indicato sul documento d\'identità',
            'helper_text' => '',
            'validation' => [
                'required' => 'Il cognome è obbligatorio',
                'min' => 'Il cognome deve essere di almeno 2 caratteri',
                'max' => 'Il cognome non può superare i 50 caratteri',
            ],
        ],
        'fiscal_code' => [
            'label' => 'Codice Fiscale',
            'placeholder' => 'Inserisci il codice fiscale (16 caratteri)',
            'help' => 'Codice fiscale come riportato sulla tessera sanitaria',
            'helper_text' => '',
            'validation' => [
                'required' => 'Il codice fiscale è obbligatorio',
                'regex' => 'Il codice fiscale deve essere nel formato corretto',
                'unique' => 'Questo codice fiscale è già registrato',
            ],
        ],
        'birth_date' => [
            'label' => 'Data di Nascita',
            'placeholder' => 'Seleziona la data di nascita',
            'help' => 'Data di nascita nel formato gg/mm/aaaa',
            'helper_text' => '',
            'validation' => [
                'required' => 'La data di nascita è obbligatoria',
                'date' => 'Inserisci una data valida',
                'before' => 'La data di nascita deve essere antecedente ad oggi',
            ],
        ],
        'gender' => [
            'label' => 'Genere',
            'placeholder' => 'Seleziona il genere',
            'help' => 'Genere anagrafico come indicato sui documenti',
            'helper_text' => '',
            'options' => [
                'M' => 'Maschio',
                'F' => 'Femmina',
                'X' => 'Non specificato',
            ],
            'validation' => [
                'required' => 'Il genere è obbligatorio',
                'in' => 'Seleziona un genere valido',
            ],
        ],
        'is_pregnant' => [
            'label' => 'Stato di Gravidanza',
            'placeholder' => 'Indica se la paziente è in gravidanza',
            'help' => 'Seleziona se la paziente è attualmente in gravidanza',
            'helper_text' => '',
            'options' => [
                '1' => 'Sì, in gravidanza',
                '0' => 'No',
            ],
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Inserisci l\'indirizzo email',
            'help' => 'Indirizzo email valido per comunicazioni importanti',
            'helper_text' => '',
            'validation' => [
                'required' => 'L\'email è obbligatoria',
                'email' => 'Inserisci un indirizzo email valido',
                'unique' => 'Questo indirizzo email è già registrato',
            ],
        ],
        'phone' => [
            'label' => 'Numero di Telefono',
            'placeholder' => 'Inserisci il numero di telefono (+39 123456789)',
            'help' => 'Numero di telefono per contatti urgenti',
            'helper_text' => '',
            'validation' => [
                'required' => 'Il numero di telefono è obbligatorio',
                'regex' => 'Inserisci un numero di telefono valido',
            ],
        ],
        'address' => [
            'label' => 'Indirizzo',
            'placeholder' => 'Via/Piazza, numero civico',
            'help' => 'Indirizzo di residenza completo con numero civico',
            'helper_text' => '',
            'validation' => [
                'required' => 'L\'indirizzo è obbligatorio',
                'min' => 'L\'indirizzo deve essere di almeno 10 caratteri',
            ],
        ],
        'city' => [
            'label' => 'Città',
            'placeholder' => 'Inserisci la città di residenza',
            'help' => 'Città di residenza attuale',
            'helper_text' => '',
            'validation' => [
                'required' => 'La città è obbligatoria',
                'min' => 'La città deve essere di almeno 2 caratteri',
            ],
        ],
        'postal_code' => [
            'label' => 'CAP',
            'placeholder' => 'Inserisci il CAP (5 cifre)',
            'help' => 'Codice di avviamento postale della città di residenza',
            'helper_text' => '',
            'validation' => [
                'required' => 'Il CAP è obbligatorio',
                'regex' => 'Il CAP deve essere di 5 cifre',
            ],
        ],
        'province' => [
            'label' => 'Provincia',
            'placeholder' => 'Seleziona la provincia',
            'help' => 'Provincia di residenza (sigla a 2 lettere)',
            'helper_text' => '',
            'validation' => [
                'required' => 'La provincia è obbligatoria',
                'size' => 'La provincia deve essere di 2 caratteri',
            ],
        ],
        'country' => [
            'label' => 'Paese',
            'placeholder' => 'Seleziona il paese',
            'help' => 'Paese di residenza',
            'helper_text' => '',
            'default' => 'Italia',
            'validation' => [
                'required' => 'Il paese è obbligatorio',
            ],
        ],
        'isee_code' => [
            'label' => 'Codice ISEE',
            'placeholder' => 'Inserisci il codice identificativo ISEE',
            'help' => 'Codice univoco del certificato ISEE per agevolazioni',
            'helper_text' => '',
            'validation' => [
                'alpha_num' => 'Il codice ISEE deve contenere solo lettere e numeri',
            ],
        ],
        'isee_value' => [
            'label' => 'Valore ISEE',
            'placeholder' => 'Inserisci il valore ISEE in euro',
            'help' => 'Valore economico indicato nel certificato ISEE',
            'helper_text' => '',
            'validation' => [
                'numeric' => 'Il valore ISEE deve essere un numero',
                'min' => 'Il valore ISEE deve essere maggiore di 0',
            ],
        ],
        'isee_expiry_date' => [
            'label' => 'Data Scadenza ISEE',
            'placeholder' => 'Seleziona la data di scadenza',
            'help' => 'Data di scadenza del certificato ISEE',
            'helper_text' => '',
            'validation' => [
                'date' => 'Inserisci una data valida',
                'after' => 'La data di scadenza deve essere futura',
            ],
        ],
        'health_card' => [
            'label' => 'Tessera Sanitaria',
            'placeholder' => 'Carica la scansione della tessera sanitaria',
            'help' => 'File immagine o PDF della tessera sanitaria (fronte/retro)',
            'helper_text' => '',
            'validation' => [
                'required' => 'La tessera sanitaria è obbligatoria',
                'file' => 'Carica un file valido',
                'mimes' => 'Formato supportato: JPG, PNG, PDF',
                'max' => 'Dimensione massima: 5MB',
            ],
        ],
        'identity_document' => [
            'label' => 'Documento d\'Identità',
            'placeholder' => 'Carica la scansione del documento d\'identità',
            'help' => 'Carta d\'identità, patente o passaporto in corso di validità',
            'helper_text' => '',
            'validation' => [
                'required' => 'Il documento d\'identità è obbligatorio',
                'file' => 'Carica un file valido',
                'mimes' => 'Formato supportato: JPG, PNG, PDF',
                'max' => 'Dimensione massima: 5MB',
            ],
        ],
        'isee_certificate' => [
            'label' => 'Certificato ISEE',
            'placeholder' => 'Carica il certificato ISEE',
            'help' => 'Certificato ISEE in corso di validità per agevolazioni economiche',
            'helper_text' => '',
            'validation' => [
                'file' => 'Carica un file valido',
                'mimes' => 'Formato supportato: JPG, PNG, PDF',
                'max' => 'Dimensione massima: 5MB',
            ],
        ],
        'pregnancy_certificate' => [
            'label' => 'Certificato di Gravidanza',
            'placeholder' => 'Carica il certificato medico di gravidanza',
            'help' => 'Necessario solo per pazienti in gravidanza (opzionale)',
            'helper_text' => '',
            'validation' => [
                'file' => 'Carica un file valido',
                'mimes' => 'Formato supportato: JPG, PNG, PDF',
                'max' => 'Dimensione massima: 5MB',
            ],
        ],
        'last_dental_visit' => [
            'label' => 'Ultima Visita Dentistica',
            'placeholder' => 'Seleziona la data dell\'ultima visita',
            'help' => 'Data approssimativa dell\'ultima visita odontoiatrica',
            'helper_text' => '',
            'validation' => [
                'date' => 'Inserisci una data valida',
                'before_or_equal' => 'La data non può essere futura',
            ],
        ],
        'dental_problems' => [
            'label' => 'Problemi Dentali',
            'placeholder' => 'Descrivi i problemi dentali attuali',
            'help' => 'Descrizione dettagliata di dolori, sensibilità o altri disturbi',
            'helper_text' => '',
            'validation' => [
                'max' => 'La descrizione non può superare i 500 caratteri',
            ],
        ],
        'notes' => [
            'label' => 'Note Aggiuntive',
            'placeholder' => 'Inserisci eventuali note o informazioni utili',
            'helper_text' => '',
            'help' => 'Informazioni aggiuntive rilevanti per il trattamento',
            'validation' => [
                'max' => 'Le note non possono superare i 1000 caratteri',
            ],
        ],
        'privacy_acceptance' => [
            'label' => 'Accettazione Privacy',
            'placeholder' => 'Accetto il trattamento dei dati personali',
            'help' => 'Consenso obbligatorio per il trattamento dei dati secondo GDPR',
            'helper_text' => '',
            'validation' => [
                'accepted' => 'Devi accettare l\'informativa sulla privacy',
            ],
        ],
        'newsletter' => [
            'label' => 'Iscrizione Newsletter',
            'placeholder' => 'Accetto di ricevere comunicazioni via email',
            'help' => 'Consenso facoltativo per ricevere aggiornamenti e novità',
            'helper_text' => '',
        ],
        'created_at' => [
            'label' => 'Data Creazione',
            'placeholder' => 'Data di registrazione del paziente',
            'help' => 'Data e ora di inserimento nel sistema',
            'helper_text' => '',
        ],
        'updated_at' => [
            'label' => 'Ultima Modifica',
            'placeholder' => 'Data dell\'ultimo aggiornamento',
            'helper_text' => '',
            'help' => 'Data e ora dell\'ultima modifica ai dati',
        ],
        'id' => [
            'label' => 'ID Paziente',
            'placeholder' => 'Identificativo univoco',
            'help' => 'Numero identificativo univoco del paziente',
            'helper_text' => '',
        ],
        'name' => [
            'label' => 'Nome Completo',
            'placeholder' => 'Nome e cognome del paziente',
            'help' => 'Nome e cognome per visualizzazione rapida',
            'helper_text' => '',
        ],
        'type' => [
            'label' => 'Tipo Utente',
            'placeholder' => 'Tipo di account utente',
            'help' => 'Classificazione del tipo di utente nel sistema',
            'helper_text' => '',
        ],
    ],

    'actions' => [
        'create' => [
            'label' => 'Nuovo Paziente',
            'tooltip' => 'Registra un nuovo paziente nel sistema',
            'modal_heading' => 'Registrazione Nuovo Paziente',
            'modal_description' => 'Compila tutti i dati richiesti per registrare un nuovo paziente',
            'success' => 'Paziente registrato con successo',
            'error' => 'Errore durante la registrazione del paziente',
        ],
        'edit' => [
            'label' => 'Modifica',
            'tooltip' => 'Modifica i dati del paziente',
            'modal_heading' => 'Modifica Dati Paziente',
            'modal_description' => 'Aggiorna le informazioni del paziente selezionato',
            'success' => 'Dati del paziente aggiornati con successo',
            'error' => 'Errore durante l\'aggiornamento dei dati',
        ],
        'delete' => [
            'label' => 'Elimina',
            'tooltip' => 'Elimina definitivamente la scheda paziente',
            'modal_heading' => 'Conferma Eliminazione',
            'modal_description' => 'Attenzione: questa azione eliminerà definitivamente tutti i dati del paziente e non può essere annullata',
            'confirmation' => 'Sei sicuro di voler eliminare definitivamente questo paziente?',
            'success' => 'Paziente eliminato con successo',
            'error' => 'Errore durante l\'eliminazione del paziente',
        ],
        'view' => [
            'label' => 'Visualizza',
            'tooltip' => 'Visualizza tutti i dettagli del paziente',
            'modal_heading' => 'Dettagli Paziente',
            'modal_description' => 'Visualizzazione completa di tutti i dati del paziente',
        ],
        'export' => [
            'label' => 'Esporta',
            'tooltip' => 'Esporta i dati dei pazienti',
            'success' => 'Esportazione completata con successo',
            'error' => 'Errore durante l\'esportazione',
        ],
        'bulk_delete' => [
            'label' => 'Elimina Selezionati',
            'tooltip' => 'Elimina tutti i pazienti selezionati',
            'confirmation' => 'Sei sicuro di voler eliminare tutti i pazienti selezionati?',
            'success' => 'Pazienti eliminati con successo',
            'error' => 'Errore durante l\'eliminazione dei pazienti',
        ],
    ],

    'messages' => [
        'welcome' => 'Benvenuto nella gestione pazienti',
        'no_patients' => 'Nessun paziente registrato',
        'search_placeholder' => 'Cerca per nome, cognome o codice fiscale...',
        'validation_errors' => 'Controlla i campi evidenziati e correggi gli errori',
        'upload_progress' => 'Caricamento in corso...',
        'file_uploaded' => 'File caricato con successo',
        'success' => [
            'created' => 'Paziente registrato con successo',
            'updated' => 'Dati del paziente aggiornati con successo',
            'deleted' => 'Paziente eliminato con successo',
            'imported' => 'Importazione completata: :count pazienti aggiunti',
            'exported' => 'Esportazione completata con successo',
        ],
        'errors' => [
            'create' => 'Errore durante la registrazione del paziente',
            'update' => 'Errore durante l\'aggiornamento dei dati',
            'delete' => 'Errore durante l\'eliminazione del paziente',
            'import' => 'Errore durante l\'importazione: :error',
            'export' => 'Errore durante l\'esportazione dei dati',
            'file_upload' => 'Errore durante il caricamento del file',
            'file_size' => 'Il file è troppo grande (massimo 5MB)',
            'file_type' => 'Tipo di file non supportato',
        ],
        'confirmations' => [
            'delete' => 'Sei sicuro di voler eliminare questo paziente? Tutti i suoi dati verranno persi definitivamente.',
            'bulk_delete' => 'Sei sicuro di voler eliminare :count pazienti selezionati?',
            'leave_form' => 'Ci sono modifiche non salvate. Sei sicuro di voler uscire?',
        ],
        'empty_states' => [
            'no_patients' => 'Nessun paziente trovato',
            'no_search_results' => 'Nessun risultato per la ricerca',
            'no_filtered_results' => 'Nessun paziente corrisponde ai filtri applicati',
        ],
    ],
];
