<?php

<<<<<<< HEAD
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
=======
return array (
  'name' => 'Pazienti',
  'navigation' => 
  array (
    'label' => 'Anagrafica Pazienti',
    'group' => 'Pazienti',
    'icon' => 'heroicon-o-users',
    'color' => 'blue',
    'sort' => 3,
    'tooltip' => 'Gestisci l\'anagrafica e le informazioni dei pazienti',
  ),
  'fields' => 
  array (
    'first_name' => 
    array (
      'label' => 'Nome',
      'placeholder' => 'Inserisci il nome',
      'help' => 'Inserisci il nome completo',
      'helper_text' => 'Nome del paziente',
      'description' => 'Il nome anagrafico del paziente',
      'tooltip' => 'Deve corrispondere al nome sul documento d\'identità',
    ),
    'last_name' => 
    array (
      'label' => 'Cognome',
      'description' => 'last_name',
      'helper_text' => 'last_name',
      'placeholder' => 'last_name',
    ),
    'fiscal_code' => 
    array (
      'label' => 'Codice fiscale',
      'placeholder' => 'Inserisci il codice fiscale',
      'help' => 'Codice fiscale come da tessera sanitaria',
      'description' => 'fiscal_code',
      'helper_text' => 'fiscal_code',
    ),
    'birth_date' => 
    array (
      'label' => 'Data di nascita',
      'placeholder' => 'Seleziona la data di nascita',
      'help' => 'Inserisci la data di nascita nel formato gg/mm/aaaa',
      'description' => 'Data di nascita come indicata sul documento d\'identità',
    ),
    'gender' => 
    array (
      'label' => 'Sesso',
      'placeholder' => 'Seleziona il sesso',
      'help' => 'Seleziona il sesso anagrafico',
    ),
    'is_pregnant' => 
    array (
      'label' => 'Gravidanza',
      'helper_text' => 'Indica se il paziente è in gravidanza',
      'description' => 'Seleziona se il paziente è attualmente in gravidanza',
    ),
    'email' => 
    array (
      'label' => 'Email',
      'placeholder' => 'Inserisci l\'email',
      'help' => 'Indirizzo email valido',
      'description' => 'email',
      'helper_text' => 'email',
    ),
    'phone' => 
    array (
      'label' => 'Telefono',
      'placeholder' => 'Inserisci il numero di telefono',
      'help' => 'Numero di telefono per contatti',
      'description' => 'phone',
      'helper_text' => 'phone',
    ),
    'address' => 
    array (
      'label' => 'Indirizzo',
      'placeholder' => 'Inserisci l\'indirizzo completo',
      'helper_text' => 'Via/Piazza, numero civico',
      'description' => 'Indirizzo di residenza del paziente',
      'tooltip' => 'Inserisci l\'indirizzo completo con numero civico',
    ),
    'city' => 
    array (
      'label' => 'Città',
      'placeholder' => 'Inserisci la città',
      'helper_text' => 'Città di residenza',
      'description' => 'Città di residenza del paziente',
      'tooltip' => 'Inserisci la città di residenza attuale',
    ),
    'postal_code' => 
    array (
      'label' => 'CAP',
      'placeholder' => 'Inserisci il CAP',
      'helper_text' => 'Codice di avviamento postale',
      'description' => 'Inserisci il CAP della città di residenza',
    ),
    'province' => 
    array (
      'label' => 'Provincia',
      'placeholder' => 'Inserisci la provincia',
      'helper_text' => 'Provincia di residenza',
      'description' => 'Inserisci la provincia di residenza',
    ),
    'country' => 
    array (
      'label' => 'Paese',
      'placeholder' => 'Inserisci il paese',
      'helper_text' => 'Paese di residenza',
      'description' => 'Inserisci il paese di residenza',
      'default' => 'Italia',
    ),
    'isee_code' => 
    array (
      'label' => 'Codice ISEE',
      'placeholder' => 'Inserisci il codice ISEE',
      'helper_text' => 'Codice identificativo ISEE',
      'description' => 'Inserisci il codice identificativo del certificato ISEE',
    ),
    'isee_value' => 
    array (
      'label' => 'Valore ISEE',
      'placeholder' => 'Inserisci il valore ISEE',
      'helper_text' => 'Valore economico ISEE',
      'description' => 'Inserisci il valore economico del certificato ISEE',
    ),
    'isee_expiry_date' => 
    array (
      'label' => 'Scadenza ISEE',
      'placeholder' => 'Seleziona la data di scadenza',
      'helper_text' => 'Data di scadenza ISEE',
      'description' => 'Inserisci la data di scadenza del certificato ISEE',
    ),
    'health_card' => 
    array (
      'label' => 'Tessera Sanitaria',
      'placeholder' => 'Carica la tessera sanitaria',
      'helper_text' => 'Carica una scansione/foto della tessera sanitaria',
      'description' => 'Tessera sanitaria del paziente',
      'tooltip' => 'Assicurati che il documento sia leggibile',
    ),
    'identity_document' => 
    array (
      'label' => 'Documento d\'Identità',
      'placeholder' => 'Carica il documento d\'identità',
      'helper_text' => 'Carica una scansione/foto del documento d\'identità',
      'description' => 'Documento d\'identità valido del paziente',
      'tooltip' => 'Carta d\'identità, patente o passaporto in corso di validità',
    ),
    'isee_certificate' => 
    array (
      'label' => 'Certificato ISEE',
      'placeholder' => 'Carica il certificato ISEE',
      'helper_text' => 'Carica una copia del certificato ISEE',
      'description' => 'Certificato ISEE valido',
      'tooltip' => 'Necessario per accedere alle agevolazioni',
    ),
    'pregnancy_certificate' => 
    array (
      'label' => 'Certificato di Gravidanza',
      'placeholder' => 'Carica il certificato di gravidanza',
      'helper_text' => 'Se applicabile, carica il certificato di gravidanza',
      'description' => 'Certificato medico attestante lo stato di gravidanza',
      'tooltip' => 'Opzionale - Solo per pazienti in gravidanza',
    ),
    'last_dental_visit' => 
    array (
      'label' => 'Ultima Visita Dentistica',
      'placeholder' => 'Seleziona la data',
      'helper_text' => 'Data dell\'ultima visita dentistica',
      'description' => 'Quando hai fatto l\'ultima visita dal dentista?',
      'tooltip' => 'Indicare una data approssimativa se non si ricorda con precisione',
    ),
    'dental_problems' => 
    array (
      'label' => 'Problemi Dentali',
      'placeholder' => 'Descrivi eventuali problemi dentali',
      'helper_text' => 'Descrivi brevemente i problemi dentali attuali',
      'description' => 'Problemi dentali attuali o recenti',
      'tooltip' => 'Includi dolori, sensibilità o altri disturbi',
    ),
    'notes' => 
    array (
      'label' => 'Note',
      'placeholder' => 'Inserisci eventuali note',
      'helper_text' => 'Note aggiuntive',
      'description' => 'Inserisci eventuali note o informazioni aggiuntive',
    ),
    'privacy_acceptance' => 
    array (
      'label' => 'Accettazione Privacy',
      'placeholder' => 'Accetta l\'informativa sulla privacy',
      'helper_text' => 'Devi accettare l\'informativa sulla privacy',
      'description' => 'Accetto il trattamento dei dati personali secondo l\'informativa sulla privacy',
      'tooltip' => 'Leggi l\'informativa completa prima di accettare',
    ),
    'newsletter' => 
    array (
      'label' => 'Newsletter',
      'helper_text' => 'Ricevi aggiornamenti sulle nostre attività',
      'placeholder' => 'Seleziona se vuoi iscriverti alla newsletter',
      'description' => 'Iscriviti alla nostra newsletter per ricevere aggiornamenti e novità',
      'tooltip' => 'Puoi annullare l\'iscrizione in qualsiasi momento',
    ),
    'toggleColumns' => 
    array (
      'label' => 'toggleColumns',
    ),
    'reorderRecords' => 
    array (
      'label' => 'reorderRecords',
    ),
    'resetFilters' => 
    array (
      'label' => 'resetFilters',
    ),
    'applyFilters' => 
    array (
      'label' => 'applyFilters',
    ),
    'openFilters' => 
    array (
      'label' => 'openFilters',
    ),
    'updated_at' => 
    array (
      'label' => 'updated_at',
    ),
    'created_at' => 
    array (
      'label' => 'created_at',
    ),
    'id' => 
    array (
      'label' => 'id',
    ),
    'name' => 
    array (
      'label' => 'name',
    ),
    'type' => 
    array (
      'label' => 'type',
    ),
    'all_tenants' => 
    array (
      'label' => 'all_tenants',
    ),
    'country_code' => 
    array (
      'description' => 'country_code',
      'helper_text' => 'country_code',
      'placeholder' => 'country_code',
      'label' => 'country_code',
    ),
    'nationality' => 
    array (
      'description' => '',
      'helper_text' => '',
      'placeholder' => 'Nazionalità',
      'label' => 'Nazionalità',
    ),
  ),
  'steps' => 
  array (
    'personal_data_step' => 
    array (
      'label' => 'Dati Personali',
      'description' => 'Inserisci i tuoi dati personali',
      'icon' => 'heroicon-o-user',
      'color' => 'primary',
    ),
    'contacts' => 
    array (
      'label' => 'Contatti',
      'description' => 'Inserisci i dati di contatto del paziente',
      'icon' => 'heroicon-o-phone',
    ),
    'documents_step' => 
    array (
      'label' => 'Documenti',
      'description' => 'Carica i documenti richiesti',
      'icon' => 'heroicon-o-document',
      'color' => 'success',
    ),
    'pre_visit_step' => 
    array (
      'label' => 'Pre-Visita',
      'description' => 'Informazioni preliminari per la visita',
      'icon' => 'heroicon-o-clipboard-document-list',
      'color' => 'warning',
    ),
    'health' => 
    array (
      'label' => 'Stato di Salute',
      'description' => 'Inserisci le informazioni sullo stato di salute',
      'icon' => 'heroicon-o-heart',
    ),
    'privacy_step' => 
    array (
      'label' => 'Privacy',
      'description' => 'Consensi e autorizzazioni',
      'icon' => 'heroicon-o-shield-check',
      'color' => 'info',
    ),
  ),
  'messages' => 
  array (
    'success' => 
    array (
      'created' => 'Paziente creato con successo',
      'updated' => 'Dati del paziente aggiornati con successo',
      'deleted' => 'Paziente eliminato con successo',
    ),
    'errors' => 
    array (
      'create' => 'Errore durante la creazione del paziente',
      'update' => 'Errore durante l\'aggiornamento dei dati',
      'delete' => 'Errore durante l\'eliminazione del paziente',
    ),
    'confirmations' => 
    array (
      'delete' => 'Sei sicuro di voler eliminare questo paziente?',
    ),
  ),
  'actions' => 
  array (
    'create' => 
    array (
      'label' => 'Nuovo Paziente',
      'tooltip' => 'Crea una nuova scheda paziente',
    ),
    'edit' => 
    array (
      'label' => 'Modifica',
      'tooltip' => 'Modifica i dati del paziente',
    ),
    'delete' => 
    array (
      'label' => 'Elimina',
      'tooltip' => 'Elimina la scheda paziente',
    ),
    'view' => 
    array (
      'label' => 'Visualizza',
      'tooltip' => 'Visualizza i dettagli del paziente',
    ),
  ),
  'model' => 
  array (
    'label' => 'patient.model',
  ),
);
>>>>>>> 6c7bdc12 (✨ (NationalityEnum.php): introduce NationalityEnum to define nationality options for the application)
