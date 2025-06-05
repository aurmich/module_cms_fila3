<?php

return [
    'fields' => [
        'first_name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Il nome del paziente',
            'validation' => [
                'required' => 'Il nome è obbligatorio',
                'max' => 'Il nome non può superare i 255 caratteri'
            ]
        ],
        'last_name' => [
            'label' => 'Cognome',
            'placeholder' => 'Inserisci il cognome',
            'help' => 'Il cognome del paziente',
            'validation' => [
                'required' => 'Il cognome è obbligatorio',
                'max' => 'Il cognome non può superare i 255 caratteri'
            ]
        ],
        'fiscal_code' => [
            'label' => 'Codice Fiscale',
            'placeholder' => 'Inserisci il codice fiscale',
            'help' => 'Il codice fiscale del paziente',
            'validation' => [
                'required' => 'Il codice fiscale è obbligatorio',
                'max' => 'Il codice fiscale deve essere di 16 caratteri',
                'min' => 'Il codice fiscale deve essere di 16 caratteri'
            ]
        ],
        'birth_date' => [
            'label' => 'Data di Nascita',
            'help' => 'Seleziona la tua data di nascita'
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Inserisci l\'email',
            'help' => 'L\'email del paziente',
            'validation' => [
                'required' => 'L\'email è obbligatoria',
                'email' => 'Inserisci un\'email valida',
                'max' => 'L\'email non può superare i 255 caratteri'
            ]
        ],
        'phone' => [
            'label' => 'Telefono',
            'placeholder' => 'Inserisci il numero di telefono',
            'help' => 'Il numero di telefono del paziente',
            'validation' => [
                'required' => 'Il numero di telefono è obbligatorio',
                'max' => 'Il numero di telefono non può superare i 20 caratteri'
            ]
        ],
        'address' => [
            'label' => 'Indirizzo',
            'placeholder' => 'Inserisci il tuo indirizzo',
            'help' => 'Il tuo indirizzo completo',
        ],
        'city' => [
            'label' => 'Città',
            'placeholder' => 'Inserisci la tua città',
            'help' => 'La città dove risiedi',
        ],
        'postal_code' => [
            'label' => 'CAP',
            'placeholder' => 'Inserisci il CAP',
            'help' => 'Inserisci il codice di avviamento postale'
        ],
        'province' => [
            'label' => 'Provincia',
            'placeholder' => 'Inserisci la provincia',
            'help' => 'Inserisci la provincia di residenza'
        ],
        'country' => [
            'label' => 'Paese',
            'placeholder' => 'Inserisci il paese',
            'help' => 'Inserisci il paese di residenza'
        ],
        'is_pregnant' => [
            'label' => 'Sei in stato di gravidanza?',
            'help' => 'Seleziona se sei in stato di gravidanza'
        ],
        'isee_code' => [
            'label' => 'Codice ISEE',
            'placeholder' => 'Inserisci il codice ISEE',
            'help' => 'Inserisci il codice ISEE se disponibile'
        ],
        'isee_value' => [
            'label' => 'Valore ISEE',
            'placeholder' => 'Inserisci il valore ISEE',
            'help' => 'Inserisci il valore ISEE in euro'
        ],
        'isee_expiry_date' => [
            'label' => 'Data Scadenza ISEE',
            'help' => 'Seleziona la data di scadenza del documento ISEE'
        ],
        'health_card' => [
            'label' => 'Tessera Sanitaria',
            'help' => 'Carica una copia della tua tessera sanitaria',
        ],
        'identity_document' => [
            'label' => 'Documento d\'Identità',
            'help' => 'Carica una copia del tuo documento d\'identità',
        ],
        'isee_certificate' => [
            'label' => 'Certificato ISEE',
            'help' => 'Carica il tuo certificato ISEE (opzionale)',
        ],
        'pregnancy_certificate' => [
            'label' => 'Certificato di Gravidanza',
            'help' => 'Carica il certificato di gravidanza (se applicabile)',
        ],
        'last_dental_visit' => [
            'label' => 'Ultima Visita Dentale',
            'help' => 'Quando hai fatto l\'ultima visita dentale?',
        ],
        'dental_problems' => [
            'label' => 'Problemi Dentali',
            'help' => 'Descrivi eventuali problemi dentali',
        ],
        'privacy_acceptance' => [
            'label' => 'Accetto la Privacy Policy',
            'help' => 'Devi accettare la privacy policy per procedere',
        ],
        'newsletter' => [
            'label' => 'Iscriviti alla Newsletter',
            'help' => 'Ricevi aggiornamenti e offerte speciali',
        ],
    ],
    'steps' => [
        'personal_data' => [
            'label' => 'Dati Personali',
            'help' => 'Inserisci i tuoi dati personali',
        ],
        'documents' => [
            'label' => 'Documenti',
            'help' => 'Carica i documenti richiesti',
        ],
        'pre_visit' => [
            'label' => 'Informazioni Preventive',
            'help' => 'Fornisci informazioni sulla tua salute dentale',
        ],
        'privacy' => [
            'label' => 'Privacy e Consensi',
            'help' => 'Leggi e accetta le condizioni di privacy',
        ],
    ],
    'buttons' => [
        'submit' => [
            'label' => 'Registrati',
            'help' => 'Completa la registrazione',
        ],
    ],
    'actions' => [
        'create' => [
            'label' => 'Nuovo Paziente',
            'tooltip' => 'Crea un nuovo paziente'
        ],
        'edit' => [
            'label' => 'Modifica',
            'tooltip' => 'Modifica il paziente'
        ],
        'delete' => [
            'label' => 'Elimina',
            'tooltip' => 'Elimina il paziente'
        ]
    ]
]; 