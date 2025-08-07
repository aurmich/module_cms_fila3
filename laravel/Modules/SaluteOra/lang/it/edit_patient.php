<?php

declare(strict_types=1);

return [
    'model' => [
        'label' => 'Paziente',
        'plural_label' => 'Pazienti',
        'description' => 'Gestione completa dei dati anagrafici, sanitari e documentali del paziente',
    ],
    'page' => [
        'title' => 'Modifica Paziente',
        'heading' => 'Gestione Dati Paziente',
        'description' => 'Modifica e aggiorna tutte le informazioni del paziente selezionato',
        'subheading' => 'Dati anagrafici, sanitari e documentali',
    ],
    'navigation' => [
        'label' => 'Modifica Paziente',
        'icon' => 'heroicon-o-user',
        'tooltip' => 'Modifica le informazioni del paziente selezionato',
        'description' => 'Aggiorna i dati anagrafici, sanitari e documentali del paziente',
    ],
    'actions' => [
        'save' => [
            'label' => 'Salva Modifiche',
            'success' => 'Dati del paziente salvati con successo',
            'error' => 'Errore durante il salvataggio dei dati del paziente',
            'confirmation' => 'Confermi di voler salvare le modifiche ai dati del paziente?',
        ],
        'cancel' => [
            'label' => 'Annulla',
            'confirmation' => 'Le modifiche non salvate andranno perse. Continuare?',
        ],
        'delete' => [
            'label' => 'Elimina Paziente',
            'success' => 'Paziente eliminato con successo',
            'error' => 'Errore durante l\'eliminazione del paziente',
            'confirmation' => 'Sei sicuro di voler eliminare questo paziente? Questa azione è irreversibile.',
        ],
        'view' => [
            'label' => 'Visualizza Dettagli',
            'tooltip' => 'Visualizza tutti i dettagli del paziente',
        ],
        'edit_attachments' => [
            'label' => 'Modifica Documenti',
            'tooltip' => 'Gestisci i documenti del paziente',
        ],
        'edit_previsit' => [
            'label' => 'Modifica Pre-Visita',
            'tooltip' => 'Aggiorna le informazioni pre-visita',
        ],
        'edit_privacy' => [
            'label' => 'Modifica Privacy',
            'tooltip' => 'Gestisci le impostazioni di privacy e consensi',
        ],
    ],
    'fields' => [
        'first_name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome del paziente',
            'help' => 'Il nome deve corrispondere al documento di identità',
            'description' => 'Nome anagrafico del paziente come da documento di identità',
            'helper_text' => '',
            'validation' => [
                'required' => 'Il nome è obbligatorio',
                'min' => 'Il nome deve contenere almeno 2 caratteri',
                'max' => 'Il nome non può superare i 50 caratteri',
                'alpha' => 'Il nome può contenere solo lettere',
            ],
        ],
        'last_name' => [
            'label' => 'Cognome',
            'placeholder' => 'Inserisci il cognome del paziente',
            'help' => 'Il cognome deve corrispondere al documento di identità',
            'description' => 'Cognome anagrafico del paziente come da documento di identità',
            'helper_text' => '',
            'validation' => [
                'required' => 'Il cognome è obbligatorio',
                'min' => 'Il cognome deve contenere almeno 2 caratteri',
                'max' => 'Il cognome non può superare i 50 caratteri',
                'alpha' => 'Il cognome può contenere solo lettere',
            ],
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Inserisci l\'indirizzo email',
            'help' => 'L\'email verrà utilizzata per le comunicazioni e l\'accesso al sistema',
            'description' => 'Indirizzo email principale per comunicazioni e accesso al portale paziente',
            'helper_text' => '',
            'validation' => [
                'required' => 'L\'email è obbligatoria',
                'email' => 'L\'email deve essere valida',
                'unique' => 'Questa email è già in uso',
            ],
        ],
        'phone' => [
            'label' => 'Telefono',
            'placeholder' => 'Inserisci il numero di telefono',
            'help' => 'Il telefono verrà utilizzato per comunicazioni urgenti',
            'description' => 'Numero di telefono principale per contatti diretti e comunicazioni urgenti',
            'helper_text' => '',
            'validation' => [
                'required' => 'Il telefono è obbligatorio',
                'regex' => 'Il formato del telefono non è valido',
            ],
        ],
        'fiscal_code' => [
            'label' => 'Codice Fiscale',
            'placeholder' => 'Inserisci il codice fiscale',
            'help' => 'Il codice fiscale è obbligatorio per le prestazioni sanitarie',
            'description' => 'Codice fiscale italiano necessario per identificazione univoca e prestazioni SSN',
            'helper_text' => '',
            'validation' => [
                'required' => 'Il codice fiscale è obbligatorio',
                'regex' => 'Il formato del codice fiscale non è valido',
                'unique' => 'Questo codice fiscale è già registrato',
            ],
        ],
        'birth_date' => [
            'label' => 'Data di Nascita',
            'placeholder' => 'Seleziona la data di nascita',
            'help' => 'La data di nascita è necessaria per il calcolo dell\'età e per le prestazioni sanitarie',
            'description' => 'Data di nascita del paziente nel formato gg/mm/aaaa',
            'helper_text' => '',
            'validation' => [
                'required' => 'La data di nascita è obbligatoria',
                'date' => 'La data di nascita deve essere valida',
                'before' => 'La data di nascita deve essere nel passato',
            ],
        ],
        'address' => [
            'label' => 'Indirizzo',
            'placeholder' => 'Inserisci l\'indirizzo completo',
            'help' => 'L\'indirizzo è necessario per le comunicazioni postali e per la fatturazione',
            'description' => 'Indirizzo di residenza completo (via, numero civico)',
            'helper_text' => '',
            'validation' => [
                'required' => 'L\'indirizzo è obbligatorio',
                'max' => 'L\'indirizzo non può superare i 255 caratteri',
            ],
        ],
        'city' => [
            'label' => 'Città',
            'placeholder' => 'Inserisci la città',
            'help' => 'La città di residenza del paziente',
            'description' => 'Città di residenza anagrafica del paziente',
            'helper_text' => '',
            'validation' => [
                'required' => 'La città è obbligatoria',
                'max' => 'La città non può superare i 100 caratteri',
            ],
        ],
        'postal_code' => [
            'label' => 'CAP',
            'placeholder' => 'Inserisci il codice postale',
            'help' => 'Il CAP è necessario per le comunicazioni postali',
            'description' => 'Codice di Avviamento Postale (5 cifre)',
            'helper_text' => '',
            'validation' => [
                'required' => 'Il CAP è obbligatorio',
                'regex' => 'Il formato del CAP non è valido',
            ],
        ],
        'province' => [
            'label' => 'Provincia',
            'placeholder' => 'Seleziona la provincia',
            'help' => 'La provincia di residenza del paziente',
            'description' => 'Provincia di residenza anagrafica (sigla provinciale)',
            'helper_text' => '',
            'validation' => [
                'required' => 'La provincia è obbligatoria',
            ],
        ],
        'nationality' => [
            'label' => 'Nazionalità',
            'placeholder' => 'Seleziona la nazionalità',
            'help' => 'La nazionalità è necessaria per le prestazioni sanitarie',
            'description' => 'Nazionalità del paziente per determinare i diritti alle prestazioni sanitarie',
            'helper_text' => '',
            'validation' => [
                'required' => 'La nazionalità è obbligatoria',
            ],
        ],
        'years_in_italy' => [
            'label' => 'Anni in Italia',
            'placeholder' => 'Seleziona gli anni trascorsi in Italia',
            'help' => 'Informazione necessaria per le prestazioni sanitarie',
            'description' => 'Numero di anni di permanenza in Italia per cittadini stranieri',
            'helper_text' => '',
            'validation' => [
                'required' => 'Gli anni in Italia sono obbligatori',
            ],
        ],
        'last_dental_visit_period' => [
            'label' => 'Ultima Visita Odontoiatrica',
            'placeholder' => 'Seleziona il periodo dell\'ultima visita',
            'help' => 'Informazione utile per la pianificazione del trattamento',
            'description' => 'Periodo dell\'ultima visita odontoiatrica per valutare la continuità delle cure',
            'helper_text' => '',
            'validation' => [
                'required' => 'Il periodo dell\'ultima visita è obbligatorio',
            ],
        ],
        'dental_problems' => [
            'label' => 'Problemi Dentali',
            'placeholder' => 'Descrivi i problemi dentali attuali',
            'help' => 'Descrivi i sintomi e i problemi che stai riscontrando',
            'description' => 'Descrizione dettagliata dei problemi dentali attuali e sintomi riferiti',
            'helper_text' => '',
            'validation' => [
                'max' => 'La descrizione non può superare i 65535 caratteri',
            ],
        ],
        'medical_conditions' => [
            'label' => 'Condizioni Mediche',
            'placeholder' => 'Descrivi eventuali condizioni mediche',
            'help' => 'Informazioni importanti per la sicurezza del trattamento',
            'description' => 'Patologie pregresse e condizioni mediche rilevanti per il trattamento odontoiatrico',
            'helper_text' => '',
            'validation' => [
                'max' => 'La descrizione non può superare i 65535 caratteri',
            ],
        ],
        'allergies' => [
            'label' => 'Allergie',
            'placeholder' => 'Descrivi eventuali allergie',
            'help' => 'Informazioni cruciali per la sicurezza del trattamento',
            'description' => 'Allergie note a farmaci, materiali dentali o altre sostanze',
            'helper_text' => '',
            'validation' => [
                'max' => 'La descrizione non può superare i 65535 caratteri',
            ],
        ],
        'medications' => [
            'label' => 'Farmaci Assunti',
            'placeholder' => 'Elenca i farmaci attualmente assunti',
            'help' => 'Informazioni necessarie per evitare interazioni',
            'description' => 'Elenco completo dei farmaci attualmente in uso con dosaggi',
            'helper_text' => '',
            'validation' => [
                'max' => 'La descrizione non può superare i 65535 caratteri',
            ],
        ],
    ],
    'messages' => [
        'patient_updated' => 'I dati del paziente sono stati aggiornati con successo',
        'patient_created' => 'Il paziente è stato registrato con successo',
        'patient_deleted' => 'Il paziente è stato eliminato con successo',
        'data_required' => 'Tutti i campi obbligatori devono essere compilati',
        'fiscal_code_exists' => 'Un paziente con questo codice fiscale è già registrato',
        'email_exists' => 'Un paziente con questa email è già registrato',
        'invalid_birth_date' => 'La data di nascita non può essere nel futuro',
        'invalid_fiscal_code' => 'Il formato del codice fiscale non è valido',
    ],
    'sections' => [
        'personal_data' => [
            'label' => 'Dati Personali',
            'description' => 'Informazioni anagrafiche del paziente',
            'icon' => 'heroicon-o-identification',
        ],
        'contact_info' => [
            'label' => 'Informazioni di Contatto',
            'description' => 'Dati per le comunicazioni con il paziente',
            'icon' => 'heroicon-o-phone',
        ],
        'medical_info' => [
            'label' => 'Informazioni Mediche',
            'description' => 'Dati sanitari e storia clinica',
            'icon' => 'heroicon-o-heart',
        ],
        'documents' => [
            'label' => 'Documenti',
            'description' => 'Documenti ufficiali del paziente',
            'icon' => 'heroicon-o-document-text',
        ],
    ],
    'validation' => [
        'fiscal_code_required' => 'Il codice fiscale è obbligatorio',
        'fiscal_code_format' => 'Il formato del codice fiscale non è valido',
        'fiscal_code_unique' => 'Un paziente con questo codice fiscale è già registrato',
        'email_required' => 'L\'email è obbligatoria',
        'email_format' => 'Il formato dell\'email non è valido',
        'email_unique' => 'Un paziente con questa email è già registrato',
        'birth_date_required' => 'La data di nascita è obbligatoria',
        'birth_date_past' => 'La data di nascita deve essere nel passato',
        'phone_required' => 'Il telefono è obbligatorio',
        'phone_format' => 'Il formato del telefono non è valido',
        'address_required' => 'L\'indirizzo è obbligatorio',
        'city_required' => 'La città è obbligatoria',
        'postal_code_required' => 'Il CAP è obbligatorio',
        'postal_code_format' => 'Il formato del CAP non è valido',
        'province_required' => 'La provincia è obbligatoria',
        'nationality_required' => 'La nazionalità è obbligatoria',
        'years_in_italy_required' => 'Gli anni in Italia sono obbligatori',
        'last_dental_visit_required' => 'Il periodo dell\'ultima visita è obbligatorio',
    ],
];
