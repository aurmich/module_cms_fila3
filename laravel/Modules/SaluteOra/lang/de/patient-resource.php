<?php

return [
    'steps' => [
        'personal_data_step' => [
            'label' => 'Dati Personali',
            'description' => 'Inserisci i tuoi dati personali',
        ],
        'documents_step' => [
            'label' => 'Documenti',
            'description' => 'Carica i documenti richiesti',
        ],
        'pre_visit_step' => [
            'label' => 'Pre-Visita',
            'description' => 'Informazioni preliminari',
        ],
        'privacy_step' => [
            'label' => 'Privacy',
            'description' => 'Accettazione privacy e consensi',
        ],
    ],
    'fields' => [
        'first_name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci il nome',
            'help' => 'Inserisci il nome completo',
        ],
        'last_name' => [
            'label' => 'Cognome',
            'placeholder' => 'Inserisci il cognome',
            'help' => 'Inserisci il cognome completo',
        ],
        'address' => [
            'label' => 'Indirizzo',
            'placeholder' => 'Inserisci l\'indirizzo',
        ],
        'city' => [
            'label' => 'Città',
            'placeholder' => 'Inserisci la città',
        ],
        'phone' => [
            'label' => 'Telefono',
            'placeholder' => 'Inserisci il numero di telefono',
            'help' => 'Numero di telefono per contatti',
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Inserisci l\'email',
            'help' => 'Indirizzo email valido',
        ],
        'health_card' => [
            'label' => 'Tessera Sanitaria',
            'tooltip' => 'Carica una scansione della tua tessera sanitaria',
        ],
        'identity_document' => [
            'label' => 'Documento d\'Identità',
            'tooltip' => 'Carica una scansione del tuo documento d\'identità',
        ],
        'isee_certificate' => [
            'label' => 'Certificato ISEE',
            'tooltip' => 'Carica il tuo certificato ISEE se disponibile',
        ],
        'pregnancy_certificate' => [
            'label' => 'Certificato di Gravidanza',
            'tooltip' => 'Carica il certificato di gravidanza se applicabile',
        ],
        'fiscal_code' => [
            'label' => 'Codice fiscale',
            'placeholder' => 'Inserisci il codice fiscale',
            'help' => 'Codice fiscale come da tessera sanitaria',
        ],
        'birth_date' => [
            'label' => 'Data di nascita',
            'placeholder' => 'Seleziona la data di nascita',
            'help' => 'Inserisci la data di nascita nel formato gg/mm/aaaa',
        ],
        'last_dental_visit' => [
            'label' => 'Ultima Visita Dentistica',
            'tooltip' => 'Quando hai fatto l\'ultima visita dal dentista?',
        ],
        'dental_problems' => [
            'label' => 'Problemi Dentali',
            'placeholder' => 'Descrivi eventuali problemi dentali',
        ],
        'privacy_acceptance' => [
            'label' => 'Accettazione Privacy',
            'tooltip' => 'Devi accettare l\'informativa sulla privacy per continuare',
        ],
        'newsletter' => [
            'label' => 'Newsletter',
            'tooltip' => 'Vuoi ricevere aggiornamenti via email?',
        ],
        'gender' => [
            'label' => 'Sesso',
            'placeholder' => 'Seleziona il sesso',
            'help' => 'Seleziona il sesso anagrafico',
        ],
    ],
    'buttons' => [
        'submit' => [
            'label' => 'ACCETTA E CONTINUA',
        ],
    ],
];
