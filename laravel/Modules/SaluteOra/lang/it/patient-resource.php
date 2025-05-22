<?php

declare(strict_types=1);

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
        ],
        'last_name' => [
            'label' => 'Cognome',
            'placeholder' => 'Inserisci il cognome',
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
        ],
        'email' => [
            'label' => 'Email',
            'placeholder' => 'Inserisci l\'indirizzo email',
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
            'label' => 'Codice Fiscale',
            'placeholder' => 'Inserisci il tuo codice fiscale',
        ],
        'birth_date' => [
            'label' => 'Data di Nascita',
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
    ],
    'buttons' => [
        'submit' => [
            'label' => 'ACCETTA E CONTINUA',
        ],
    ],
]; 